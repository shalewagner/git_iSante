
import Data.Maybe
import Network.CGI

import SqlTransform


main :: IO ()
main = runCGI (handleErrors cgiMain)

cgiMain :: CGI CGIResult
cgiMain = do
  setHeader "Content-type" "text/plain"
  command <- getInput "command"
  case command of 
    Nothing -> output "ERROR\nNo command given."
    Just commandString -> case commandString of
                            "translateSql" -> translateSqlRest
                            "splitSql" -> splitSqlRest
                            otherwise -> output "ERROR\nUnknown command given."

translateSqlRest :: CGI CGIResult
translateSqlRest = do
  query <- getInput "query"
  case query of
    Nothing -> output "ERROR\nNo query given."
    Just queryString -> 
        let (returnType, message) = translateSql queryString
        in output $ returnType ++ "\n" ++ message

splitSqlRest :: CGI CGIResult
splitSqlRest = do
  query <- getInput "query"
  case query of
    Nothing -> output "ERROR\nNo query given."
    Just queryString -> 
        let result = splitSql queryString
        in case result of
             Left err -> output $ "ERROR\n" ++ err
             Right s -> output $ "SQL\n" ++ case s of
                                              [] -> ""
                                              otherwise -> foldl1 (\s1 s2 -> s1 ++ "\n" ++ s2) s
