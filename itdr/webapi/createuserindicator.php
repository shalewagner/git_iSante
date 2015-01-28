<?php

require_once('autoload.php');

if (!isset($_POST["requestJson"])){
    echo "no data";
    exit;
}

if (count($_POST)==0)
{
    $indicator = new Indicator();
    $indicator->subjectId=1;
    $indicator->userIndicatorTypeId=1;
    $indicator->ageLevel=0;
    $indicator->genderLevel=2;
    $indicator->userIndicatorName="second";
    $indicator->userIdentifier="User 1";
    $indicator->indicatorType=1;
    $indicator->equation="~chloroquine~";
}
else {
    $data=$_POST["requestJson"];
    $request=json_decode($data);
    $indicator = $request->indicator;
}

$indicator->equation=Http::removeHttpFormatting($indicator->equation);
$createdIndicator = IndicatorLogic::CreateIndicator($indicator);

Http::AddHeaders();
echo json_encode(array('Indicator'=>$createdIndicator));

exit;

