
module SqlTokenizer (sqlComplete, sqlManyComplete) where

import Text.ParserCombinators.Parsec
import qualified Text.ParserCombinators.Parsec.Token as P

import SimpleSql


--From parsecs built in language lexer generator.
lexer :: P.TokenParser ()
lexer = P.makeTokenParser P.LanguageDef {P.commentStart="/*",
                                         P.commentEnd="*/",
                                         P.commentLine="--",
                                         P.nestedComments=False,
                                         P.identStart=letter <|> oneOf "*@",
                                         P.identLetter=alphaNum <|> char '_',
                                         P.opStart=oneOf  ":!#$%&*+.,/<=>?@\\^|-~",
                                         P.opLetter=oneOf ":!#$%&*+.,/<=>?@\\^|~",
                                         P.reservedNames=[],
                                         P.reservedOpNames=[],
                                         P.caseSensitive=False}

whiteSpace = P.whiteSpace lexer
lexeme = P.lexeme lexer
naturalOrFloat = P.naturalOrFloat lexer
parens = P.parens lexer
identifier = P.identifier lexer
operator = P.operator lexer


--Parse an SQL statement completely.
sqlComplete :: Parser [SqlExpr]
sqlComplete = do 
  whiteSpace
  s <- sql
  try ((do sqlSeperator; eof) <|> eof)
  return s

--Parse many SQL statement completely.
sqlManyComplete :: Parser [[SqlExpr]]
sqlManyComplete = do 
  whiteSpace
  s <- sepBy sql sqlSeperator
  eof
  return s

--Parses the seperator between statements in a compound statement
sqlSeperator :: Parser ()
sqlSeperator = do
  char ';'
  whiteSpace
  return ()

--Parse as many SQL expressions as possible.
sql :: Parser [SqlExpr]
sql = do 
  s <- many sqlExpr
  whiteSpace
  return s


--Parse a single SQL expression. Can be kind of expression defined in SimpleSql.
sqlExpr :: Parser SqlExpr
sqlExpr =
    --look for $foo{bar} replacement parameters used in jasper queries
    try $ lexeme (do char '$'
                     varName <- many $ letter <|> oneOf "!"
                     char '{'
                     varKey <- many $ letter
                     char '}'
                     return (SqlWord $ Unquoted ("$" ++ varName ++ "{" ++ varKey ++ "}")))
    <|>
    --look for functions foo(bar ...)
    try (do w <- letter
            ws <- many $ alphaNum <|> char '_'
            s <- parens sql
            return (SqlFunction (w:ws) s))
    <|>
    do w <- identifier
       return (SqlWord $ Unquoted w)
    <|>
    do o <- operator
       return (SqlOperator o)
    <|>
    do n <- naturalOrFloat
       return (case n of
                 Left n -> SqlInteger n
                 Right n -> SqlFloat n)
    <|>
    makeQuotedStringParser '\''
    <|>
    makeQuotedStringParser '"'
    <|>
    makeQuotedStringParser '`'
    <|>
    do s <- parens sql
       return (SqlParen s)


--Make a parser for parsing quoted strings with any kind of quote character.
makeQuotedStringParser :: Char -> Parser SqlExpr
makeQuotedStringParser c 
    = let charParse = do try $ string [c, c]
                         return [c, c]
                      <|>
                      do oneChar <- noneOf [c]
                         return [oneChar]
      in lexeme $ do char c
                     contents <- many charParse
                     char c
                     return $ SqlWord $ QuotedBy c (concat contents)

{-                
makeQuotedStringParser :: Char -> Parser SqlExpr
makeQuotedStringParser c 
    = let charParse = do try $ string ['\\', c]
                         return c
                      <|>
                      do try $ string ['\\', '\\']
                         return '\\'
                      <|>
                      noneOf [c]
      in lexeme $ do char c
                     contents <- many charParse
                     char c
                     return $ SqlWord $ QuotedBy c contents
-}
