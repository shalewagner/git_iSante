
module SqlTransform (translateSql, splitSql) where

import Data.Either
import Data.List
import Data.Char
import qualified Text.ParserCombinators.Parsec as P

import SimpleSql
import SqlTokenizer


--Splits up a compound sql statement
splitSql :: String -> Either String [String]
splitSql sql = 
    let parseResults = P.parse sqlManyComplete "" sql
    in case parseResults of
         Left err -> Left ("splitSql parse error at " ++ show err)
         Right sqlData -> Right (map sqlTokensToString $ filter (\s -> s /= []) sqlData)


--Translate an mssql string in to mysql.
--Returns either ("ERROR", error message string)
--or ("SQL", sql string)
translateSql :: String -> (String, String)
translateSql sql =
    let parseResult = P.parse sqlComplete "" sql
    in case parseResult of
         Left err -> ("ERROR", "Parse error at " ++ show err)
         Right sqlData -> ("SQL", sqlTokensToString (fixAll sqlData))


--All the fixes in one composite function.
--fixAll = sqlMapAll fixFunctions . sqlListMapParen fixTop 
--         . sqlListMapParen fixUnion . sqlListMap fixHashOperator
--         . fixCreateTemp
fixAll = sqlListMap fixConcatOperator
         . sqlListMap fixUserFunctions
         . sqlMapAll fixFunctions 
         . sqlListMapParen fixTop 
         . sqlListMap fixHashOperator
         . fixCreateTemp 
         . fixUpdateFrom
         . fixDeclare
         . fixSetIdentityInsert
         . sqlListMap fixAssignment
         . sqlListMap fixWith


--Used to make test for unquoted identifiers.
--Needs a special function because these are case insensitive.
makeKeywordTest :: String -> (SqlExpr -> Bool)
makeKeywordTest s = let func (SqlWord (Unquoted ns)) = map toLower ns == map toLower s
                        func _ = False
                    in func

--Used to make test for function names.
--Needs a special function because these are case insensitive.
makeFunctionTest :: String -> (SqlExpr -> Bool)
makeFunctionTest s = let func (SqlFunction ns _) = map toLower ns == map toLower s
                         func _ = False
                     in func


--Apply a SqlExpr -> SqlExpr to a single expression. If the expression has 
--sub expressions then apply it to all of them in depth first order.
sqlDepthMap :: (SqlExpr -> SqlExpr) -> SqlExpr -> SqlExpr
sqlDepthMap f (SqlFunction fname sql) = f $ SqlFunction fname (sqlMapAll f sql)
sqlDepthMap f (SqlParen sql) = f $ SqlParen (sqlMapAll f sql)
sqlDepthMap f sqlExpr = f sqlExpr

--Apply a SqlExpr -> SqlExpr to a list of expressions.
--Also applies to any sub expressions in depth first order.
sqlMapAll :: (SqlExpr -> SqlExpr) -> ([SqlExpr] -> [SqlExpr])
sqlMapAll f = map (sqlDepthMap f)

--Apply a [SqlExpr] -> [SqlExpr] to nested parenthetical and function expressions in depth first order.
sqlListMap :: ([SqlExpr] -> [SqlExpr]) -> [SqlExpr] -> [SqlExpr]
sqlListMap f sql =
    let subListRun (SqlParen s) = SqlParen (sqlListMap f s)
        subListRun (SqlFunction fname s) = SqlFunction fname (sqlListMap f s)
        subListRun s = s
    in f $ map subListRun sql

--Apply a [SqlExpr] -> [SqlExpr] to nested parenthetical expressions in depth first order.
--Does not apply to functions or parenthetical expressions in functions.
sqlListMapParen :: ([SqlExpr] -> [SqlExpr]) -> [SqlExpr] -> [SqlExpr]
sqlListMapParen f sql =
    let subListRun (SqlParen s) = SqlParen (sqlListMapParen f s)
        subListRun s = s
    in f $ map subListRun sql


--Change "... top x ..." into "... limit x".
fixTop :: [SqlExpr] -> [SqlExpr]
fixTop sql = 
    let (beforeTop, topAndAfter) = break (makeKeywordTest "top") sql
    in case topAndAfter of 
         _:(SqlInteger i):after -> beforeTop ++ after ++ [SqlWord (Unquoted "limit"), SqlInteger i]
         otherwise -> sql


--Change "... union ..." into "(...) union (...)".
fixUnion :: [SqlExpr] -> [SqlExpr]
fixUnion sql =
    let breakUpSql [] = []
        breakUpSql s = let (beforeUnion, unionAndAfter) = break (makeKeywordTest "union") s
                       in case unionAndAfter of 
                            _:after -> beforeUnion : (breakUpSql after)
                            otherwise -> [beforeUnion]
        fixUnionContents s@[SqlParen _] = s
        fixUnionContents s = [SqlParen s]
        brokenUpSql = map fixUnionContents $ breakUpSql sql
    in case brokenUpSql of 
         [] -> []
         [s] -> sql
         otherwise -> foldl1 (\s1 s2 -> s1 ++ [SqlWord (Unquoted "union")] ++ s2) brokenUpSql
         

--Modifies certain SQL function calls. 
--Uses helper functions for complicated transformations.
fixFunctions :: SqlExpr -> SqlExpr
fixFunctions sqlf@(SqlFunction fname sql) =
    case map toLower fname of
      "convert" -> fixConvertFunction sql
      "datediff" -> fixDateDiffFunction sql
      "dateadd" -> fixDateAddFunction sql
      "getdate" -> SqlFunction "now" sql
      "len" -> SqlFunction "length" sql
      "scope_identity" -> SqlFunction "last_insert_id" sql
      "isnull" -> SqlFunction "ifnull" sql
      "charindex" -> SqlFunction "locate" sql
      "str" -> fixStrFunction sql
      otherwise -> sqlf
fixFunctions sql = sql


--Change convert(datetime and convert(smalldatetime function calls.
--Currently ignores other types of convert().
fixConvertFunction :: [SqlExpr] -> SqlExpr
fixConvertFunction sql =
    let (dataType:_, _:argument) = break (== SqlOperator ",") sql
        isDateDataType = (makeKeywordTest "datetime") dataType
                         || (makeKeywordTest "smalldatetime") dataType
        isFloatType = (makeKeywordTest "float") dataType
                      || (makeKeywordTest "real") dataType
                      || (makeKeywordTest "numeric") dataType
        isIntType = (makeKeywordTest "int") dataType
                    || (makeKeywordTest "smallint") dataType
                    || (makeKeywordTest "tinyint") dataType
                    || (makeKeywordTest "bigint") dataType
        isCharType = (makeKeywordTest "varchar") dataType
                     || (makeFunctionTest "varchar") dataType
                     || (makeKeywordTest "char") dataType
                     || (makeFunctionTest "char") dataType
        plusToComma (SqlOperator "+") = (SqlOperator ",")
        plusToComma s = s
        processedArgument = map plusToComma argument
    in if isDateDataType
       then SqlFunction "str_to_date" 
                [SqlFunction "concat" processedArgument,
                 SqlOperator ",",
                 SqlWord (QuotedBy '\'' "%m/%d/%y")]
       else if isFloatType
            then SqlParen argument
            else if isIntType
                 then SqlFunction "round" argument
                 else if isCharType
                      then SqlParen argument
                      else SqlFunction "convert" sql


--Change datediff(datepart, start, end).
--When datepart is something other then 'day' then the result is divided by the number of days
--in that interval.
--Doesn't handle dateparts smaller then a day. 'round' my also not be the correct way to get and int.
fixDateDiffFunction :: [SqlExpr] -> SqlExpr
fixDateDiffFunction sql =
    let ((SqlWord (Unquoted datePart)):_:arguments) = sql
        (startDate, _:endDate) = break (== SqlOperator ",") arguments
        dayVersion = SqlFunction "datediff" (endDate ++ [SqlOperator ","] ++ startDate)
        dividedVersion d = SqlFunction "round" [dayVersion, SqlOperator "/", SqlFloat d]
    in case datePart of
         "day" -> dayVersion
         "dd" -> dayVersion
         "d" -> dayVersion
         "year" -> dividedVersion 365.242199
         "yyyy" -> dividedVersion 365.242199
         "yy" -> dividedVersion 365.242199
         "month" -> dividedVersion 30.4368499
         "mm" -> dividedVersion 30.4368499
         "m" -> dividedVersion 30.4368499
         "quarter" -> dividedVersion 91.3105497
         "qq" -> dividedVersion 91.3105497
         "q" -> dividedVersion 91.3105497
         "week" -> dividedVersion 7
         "wk" -> dividedVersion 7
         "ww" -> dividedVersion 7
         otherwise -> SqlFunction "datediff" sql


--Chage dateadd(datepart, number, date)
--Doesn't handle dateparts smaller then a day.
fixDateAddFunction :: [SqlExpr] -> SqlExpr
fixDateAddFunction sql =
    let ((SqlWord (Unquoted datePart)):_:arguments) = sql
        (number, _:date) = break (== SqlOperator ",") arguments
        newDatePart "dd" = "day"
        newDatePart "d" = "day"
        newDatePart "yyyy" = "year"
        newDatePart "yy" = "year"
        newDatePart "mm" = "month"
        newDatePart "m" = "month"
        newDatePart "qq" = "quarter"
        newDatePart "q" = "quarter"
        newDatePart a = a
    in SqlFunction "date_add" (date 
                               ++ [SqlOperator ",",
                                   SqlWord (Unquoted "INTERVAL")]
                               ++ number
                               ++ [SqlWord (Unquoted $ newDatePart datePart)])


--change str(number, length, decimal) to round(number, decimal)
fixStrFunction :: [SqlExpr] -> SqlExpr
fixStrFunction sql = 
    let (number, lengthAndRest) = break (== SqlOperator ",") sql
    in if (lengthAndRest == []) 
       then SqlFunction "str" sql
       else let (length, decimalAndRest) = break (== SqlOperator ",") (tail lengthAndRest)
            in if (decimalAndRest == []) 
               then SqlFunction "str" sql
               else SqlFunction "round" (number ++ [SqlOperator ","] ++ tail decimalAndRest)


--remove hash operator which is used to indicated temp tables
fixHashOperator :: [SqlExpr] -> [SqlExpr]
fixHashOperator sql = filter (/= SqlOperator "#") sql

--change create table syntax for temp tables
fixCreateTemp :: [SqlExpr] -> [SqlExpr]
fixCreateTemp sql@(create:table:(SqlOperator "#"):rest) = 
    if makeKeywordTest "create" create
       && makeKeywordTest "table" table
    then create:(SqlWord (Unquoted "temporary")):table:rest
    else sql
fixCreateTemp sql = sql


--change update statements with a from clause
--update a set b from c where d
--to
--update c set b where d
fixUpdateFrom :: [SqlExpr] -> [SqlExpr]
fixUpdateFrom sql@([]) = sql
fixUpdateFrom sql@(_:[]) = sql
fixUpdateFrom sql@(update:rest) 
    | makeKeywordTest "update" update =
        let (table, setAndAfter) = break (makeKeywordTest "set") rest
        in if setAndAfter == []
           then sql
           else let (set:afterSet) = setAndAfter
                    (setData, fromAndAfter) = break (makeKeywordTest "from") afterSet
                in if fromAndAfter == []
                   then sql
                   else let (from:afterFrom) = fromAndAfter
                            (fromData, whereAndWhere) = break (makeKeywordTest "where") afterFrom
                        in [update] ++ fromData ++ [set] ++ setData ++ whereAndWhere
    | otherwise = sql


--take expressions like "... + ... + ..." and change them into concat(..., ..., ...)
fixConcatOperator :: [SqlExpr] -> [SqlExpr]
fixConcatOperator sql =
    let isSqlNumeric (SqlInteger _) = True
        isSqlNumeric (SqlFloat _) = True
        isSqlNumeric _ = False
    in if elem (SqlOperator "+") sql 
           && (not $ any isSqlNumeric sql)
       then [SqlFunction "concat" $ map (\e -> if e == (SqlOperator "+")
                                               then (SqlOperator ",")
                                               else e) sql]
       else sql


--change "declare ..." into "select 1"
fixDeclare :: [SqlExpr] -> [SqlExpr]
fixDeclare [] = []
fixDeclare sql@(start:_)
    | makeKeywordTest "declare" start = [SqlWord $ Unquoted "select", SqlInteger 1]
    | otherwise = sql


--change "set identity_insert ..." into "select 1"
fixSetIdentityInsert :: [SqlExpr] -> [SqlExpr]
fixSetIdentityInsert [] = []
fixSetIdentityInsert (a:[]) = a:[]
fixSetIdentityInsert sql@(first:second:_)
    | makeKeywordTest "set" first 
      && makeKeywordTest "identity_insert" second = [SqlWord $ Unquoted "select", SqlInteger 1]
    | otherwise = sql


--change "select @foo = bar, ... from ..." into "select @foo := bar, ... from ..."
fixAssignment :: [SqlExpr] -> [SqlExpr]
fixAssignment [] = []
fixAssignment sql =
    let (beforeSelect, selectAndAfter) = break (makeKeywordTest "select") sql
        modifyVars [] = []
        modifyVars (x:[]) = x:[]
        modifyVars (x@(SqlWord (Unquoted i)):xs)
            | makeKeywordTest "from" x = x:xs
            | head i == '@' && head xs == SqlOperator "=" = x:SqlOperator ":=":(modifyVars $ tail xs)
            | otherwise = x:(modifyVars xs)
        modifyVars (x:xs) = x:(modifyVars xs)
    in beforeSelect ++ (modifyVars selectAndAfter)


--User function must be written like dbo.foobar(). Change them to just foobar().
fixUserFunctions :: [SqlExpr] -> [SqlExpr]
fixUserFunctions [] = []
fixUserFunctions sql@(_:[]) = sql
fixUserFunctions sql@(_:_:[]) = sql
fixUserFunctions sql = 
    let (dbo:dot:function:rest) = sql
        userFunctionNames = ["ymdtodate"]
        shouldFix = dbo == SqlWord (Unquoted "dbo")
                    && dot == SqlOperator "."
                    && any (\t -> makeFunctionTest t function) userFunctionNames
    in if shouldFix
       then function:(fixUserFunctions rest)
       else (head sql):(fixUserFunctions $ tail sql)


--remove 'with (...)' style mssql table hints
fixWith :: [SqlExpr] -> [SqlExpr]
fixWith [] = []
fixWith sql =
    let (beforeWith, withAndAfter) = break (makeKeywordTest "with") sql
    in if withAndAfter == []
       then sql
       else case withAndAfter of
              _:(SqlParen _):_ -> beforeWith ++ (drop 2 withAndAfter)
              otherwise -> sql
