
import Data.Maybe
import System.Exit
import System.IO

import SqlTransform

main :: IO ()
main = do
  queryString <- hGetContents stdin
  case splitSql queryString of
    Left err -> do hPutStrLn stderr ("ERROR: " ++ err)
                   exitFailure
    Right queryStrings -> do let translated = map translateSql queryStrings
                                 errors = filter 
                                          (\(t,_) -> if t == "ERROR" then True else False) 
                                          translated
                             if errors /= []
                              then do hPutStrLn stderr ("ERROR: " ++ snd (head errors))
                                      exitFailure
                              else putStrLn $ concatMap (\(_,s) -> s ++ "; ") translated
