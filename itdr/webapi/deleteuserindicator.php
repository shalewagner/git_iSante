<?php

require_once('autoload.php');

if (!isset($_POST["requestJson"])){
    $subjectId = 1;
    $userIdentifier="User 1";
    $userIndicatorId=2;
}
else{
    $data=$_POST["requestJson"];
    $request=json_decode($data);
    $subjectId=$request->subjectId;
    $userIdentifier=$request->userIdentifier;
    $userIndicatorId=$request->userIndicatorId;
}

$userIndicatorDtos = IndicatorLogic::DeleteIndicator($subjectId, $userIdentifier,$userIndicatorId);

Http::AddHeaders();
echo json_encode(true);

exit;

