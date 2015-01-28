<?php

require_once('autoload.php');

if (count($_GET)==0){
    $subjectId = 1;
}
else{
    $subjectId=$_REQUEST["subjectid"];
}

$fieldDtos = FieldLogic::GetFieldsAsDtos($subjectId, 0);

Http::AddHeaders();
echo json_encode(array('fields'=>$fieldDtos));

exit;

