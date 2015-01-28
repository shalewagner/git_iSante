<?php

require_once('autoload.php');

if (count($_GET)<2){
    $subjectId = 1;
    $userIdentifier="User 1";
    $includeShared=true;
}
else{
    $subjectId=$_REQUEST["subjectid"];
    $userIdentifier=$_REQUEST["useridentifier"];
    $includeShared=$_REQUEST["includeshared"];
}

$userIndicatorDtos = IndicatorLogic::GetIndicatorsAsDtos($subjectId, $userIdentifier);
foreach ($userIndicatorDtos as $ind){
    $ind->equation=Http::formatEquationForHttp($ind->equation);
}

Http::AddHeaders();
echo json_encode(array('userIndicators'=>$userIndicatorDtos));

exit;

