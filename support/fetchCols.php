<?php
   
include ("backend.php");
$query = "select visitdateDd + '/' + visitdateMm + '/' + visitdateYy as vDate, conditions_id, whoStage, conditionNameFr, case when conditionactive = 1 then convert(tinyint,1) else convert(tinyint,0) end as active, case when conditionactive = 2 then convert(tinyint,1) else convert(tinyint,0) end as resolved, '01/01/01' as onsetDate from v_conditions where patientid = '11208296'";
$colArray = fetchQueryColumns($query);
foreach ($colArray as $key => $value) {
	echo $key . " " . $value[0] . "." . $value[1] . "<br>";
}

function fetchQueryColumns($qry) {
	$colArray = array();
	$result = dbQuery($qry);
	while ($row = mssql_fetch_field($result)) 
		$colArray[$row->name] = array ($row->type, $row->max_length);
	return ($colArray);
}

?>