SET fileToUpload=%1
SET iSanteServer=%2
SET login=%3
SET password=%4

ECHO --- >>hybrid_datamerger.log
ECHO Started sending file %TIME% >>hybrid_datamerger.log

:: delete to make sure an old error file isn't already there
del curlErrorFile.htm

:: http://curl.haxx.se/latest.cgi?curl=win64-ssl-sspi
curl.exe --insecure --user %login%:%password%  --data-urlencode upload@%fileToUpload%  --data-urlencode  "filename=%fileToUpload%" %iSanteServer%/uploadfpmerge.php > curlErrorFile.htm
set /p curlReturnValue= < curlErrorFile.htm

IF "%curlReturnValue%" == "%fileToUpload%" ( 
	ECHO sent %curlReturnValue% >> hybrid_datamerger.log 
	move %fileToUpload% iSanteMergers_done
	del curlErrorFile.htm
) ELSE ( 
	ECHO ERROR trying to send %fileToUpload%  >> hybrid_datamerger.log 
	ECHO returned value is %curlReturnValue% >> hybrid_datamerger.log 
)
ECHO Ended sending file %TIME% >>hybrid_datamerger.log
)