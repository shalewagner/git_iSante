
module SimpleSql where

--Main data type describing a single SQL expression.
data SqlExpr = SqlWord Quotable
             | SqlOperator String
             | SqlInteger Integer
             | SqlFloat Double
             | SqlFunction String [SqlExpr]
             | SqlParen [SqlExpr]
               deriving (Show, Eq)

--For various quoted strings and for unquoted identifiers.
data Quotable = Unquoted String
              | QuotedBy Char String
                deriving (Show, Eq)


--Stringify a list of SQL expressions.
sqlTokensToString :: [SqlExpr] -> String
sqlTokensToString sqlTokens 
    = let tokenToString (SqlWord (Unquoted s)) = s
          tokenToString (SqlWord (QuotedBy c s)) = [c] ++ s ++ [c]
          tokenToString (SqlOperator s) = s
          tokenToString (SqlInteger i) = show i
          tokenToString (SqlFloat d) = show d
          tokenToString (SqlFunction s sql) = s ++ "(" ++ sqlTokensToString sql ++ ")"
          tokenToString (SqlParen sql) = "(" ++ sqlTokensToString sql ++ ")"
          stringifiedTokens = map tokenToString sqlTokens
      in case stringifiedTokens of
           [] -> ""
           otherwise -> foldl1 (\s1 s2 -> s1 ++ " " ++ s2) stringifiedTokens
