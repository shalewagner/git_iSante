<?php

require_once('autoload.php');

if (count($_POST)==0)
{
    $request = new QueryRequest();
    $request->timeLevel=1;
    $request->geographyLevel=0;
    $request->indicatorIds=array(1,2);
}
else {
    $data=$_POST["requestJson"];
    $request=json_decode($data);
}

$rows=QueryLogic::Query(1,$request);

Http::AddHeaders();
echo json_encode(array('rows'=>$rows));

exit;
