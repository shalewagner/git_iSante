
module CLibrary where

import Foreign.C.Types
import Foreign.C.String
import Foreign.Marshal.Alloc
import Foreign.Marshal.Array
import Foreign.Ptr
import Foreign.Storable

import SqlTransform


--return an array with exactly two strings in it
--first is "ERROR" or "SQL"
--second is either the error message or the new sql string

foreign export ccall "translateSql" translateSqlCWrapper :: CString -> IO (Ptr CString)

translateSqlCWrapper :: CString -> IO (Ptr CString)
translateSqlCWrapper cs = do
  sql <- peekCString cs
  let (returnType, message) = translateSql sql
  returnTypeCString <- newCString returnType
  messageCString <- newCString message
  newArray [returnTypeCString, messageCString]


--return an array with at least two values
--first is an int (cast) with the number of strings or 0 on error
--second is either an error message or the first sql statement
--third or greater are sql statements

foreign export ccall "splitSql" splitSqlCWrapper :: CString -> IO (Ptr CString)

splitSqlCWrapper :: CString -> IO (Ptr CString)
splitSqlCWrapper cs = do
  sql <- peekCString cs
  let result = splitSql sql
      (count, strings) = case result of 
                           Left err -> (0, [err])
                           Right s -> if s == [] --make sure we always return at least one string
                                      then (1, [""])
                                      else (length s, s)
  messageCStrings <- mapM newCString strings
  countPointer <- malloc :: IO (Ptr CInt)
  poke countPointer $ fromInteger $ toInteger count
  newArray $ (castPtr countPointer):messageCStrings
