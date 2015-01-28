<?php
ini_set('memory_limit', '1024M');
set_time_limit(0);

require_once('autoload.php');

if (count($_GET)==0){
    $subjectId = 1;
    $timeLevel=1;
    $geographyLevel=0;
    $ageLevel=0;
    $genderLevel=0;
}
else{
    $subjectId=$_GET["subjectIdSel"];
    $geographyLevel=$_GET["geographyLevelSel"];
    $timeLevel=$_GET["timeLevelSel"];
    $ageLevel=$_GET["ageLevelSel"];
    $genderLevel=$_GET["genderLevelSel"];
}

$selectionString='malaria'.$timeLevel.$geographyLevel.$ageLevel.$genderLevel;
$fileName="Export\\".$selectionString.'.csv';

if (!file_exists($fileName)){
    $fileText=DownloadLogic::GetCsvFormattedAggregatedDataBySubjectId($subjectId,$timeLevel,$geographyLevel,$ageLevel,$genderLevel);
    file_put_contents($fileName, $fileText, LOCK_EX);
}

header("Location: ".$fileName);
exit;

