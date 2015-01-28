<?php
ini_set('memory_limit', "1024M");

require_once('autoload.php');


if (count($_GET)==0){
    $subjectId = 1;
    $timeLevel=0;
    $geographyLevel=0;
    $ageLevel=0;
    $genderLevel=0;
    $start=0;
    $limit=10;
}
else{
    $subjectId=$_GET["subjectId"];
    $geographyLevel=$_GET["geographyLevel"];
    $timeLevel=$_GET["timeLevel"];
    $ageLevel=$_GET["ageLevel"];
    $genderLevel=$_GET["genderLevel"];
    $start=$_GET["start"];
    $limit=$_GET["limit"];
}

$rows = AggregatedDataLogic::GetDataAsFieldList($subjectId, $timeLevel, $geographyLevel,$ageLevel,$genderLevel, $start, $limit, 0);

Http::AddHeaders();
echo json_encode(array('rows'=>$rows));

exit;
