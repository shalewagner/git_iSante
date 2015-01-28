<?php

require_once('autoload.php');

$subjectId=$_REQUEST["subjectid"];

$malariaDtos=AggregatedDataLogic::GetAggregatedDataAsDtos($subjectId, 0, 0, 0, 0,0);

Http::AddHeaders();
echo json_encode($malariaDtos);

exit;
