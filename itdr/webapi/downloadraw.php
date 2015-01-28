<?php
ini_set('memory_limit', '1024M');
set_time_limit(0);

require_once('autoload.php');

if (count($_POST)==0){
    $subjectId = 1;
}
else{
    $subjectId=$_POST["subjectIdRaw"];
}

$fileName='/var/backups/itech/unloads/malaria.csv';

if (!file_exists($fileName)){
    $fileText=DownloadLogic::GetCsvFormattedRawDataBySubjectId($subjectId,0,100000);
    file_put_contents($fileName, $fileText, LOCK_EX);
}

header('Location:'.$fileName);

exit;

