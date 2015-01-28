:: --- ENGLISH ---
:: Merges Local Fingerprint Database with distant Fingerprint Database defined in hybrid_datamerger.ini
:: --- FRENCH ---
:: Fusionne la base de donnee locale d'empreintes digitales avec la base distance definie dans le fichier hybrid_datamerger.ini
:::::::::::::::::::::::::::::::::::::
::            OPTIONS              ::
:::::::::::::::::::::::::::::::::::::
:: --- ENGLISH ---
:: Set these options to fit your account on the iSante server
:: Execute this cmd file (double click)
:: If curlErrorFile.htm exists and is empty, your iSanteServer parameter might be wrong
:: If curlErrorFile.htm exists and contains Authorization Required, your authentication information aren't correct
:: If no curlErrorFile.htm exists. Please see log hybrid_datamerger.log.
:: --- FRENCH ---
:: Parametrez la connexion avec le serveur iSante ici
:: Executez ce fichier cmd (double clic)
:: Si le fichier curlErrorFile.htm existe et est vide, votre parametre iSanteServer est surement faux
:: Si le fichier curlErrorFile.htm existe et contient Authorization Required, vos informations de connexion sont surement fausses
:: Si aucun fichier curlErrorFile.htm n'existe, la connexion a fonctionne. Referez vous au log hybrid_datamerger.log.
SET iSanteServer=https://haiti-dev.ci
SET login=myLogin
SET password=myPassword
:::::::::::::::::::::::::::::::::::::

:: Logs start time
ECHO.
ECHO.
ECHO === %date% === >> hybrid_datamerger.log


ECHO Started hybrid_datamerger.exe %TIME% >>hybrid_datamerger.log
:: Starts hybrid_datamerger.exe for Fingerprints (FP1)
:: retrieves the DuplicateTemplateFound.log file to current folder
hybrid_datamerger.exe FP1

SET receivedFilename=DuplicateTemplateFound.log
SET archivedFilename=DuplicateTemplateFound-%date:~10,4%%date:~4,2%%date:~7,2%.log

ren %receivedFilename% %archivedFilename%
move %archivedFilename% iSanteMergers_todo

:: Logs end time
ECHO Ended hybrid_datamerger.exe %TIME% >>hybrid_datamerger.log

FOR %%f IN (iSanteMergers_todo\*) DO cmd /C curlSendFile.cmd %%f %iSanteServer% %login% %password%
:: End of execution
EXIT