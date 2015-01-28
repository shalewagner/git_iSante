<?php
include ("backend.php");

$iii = 0;
$jjj = 0;
/* code to load conceptKeywords for diagnoses (4), drugs (3), tests (1) 
$stmt = dbQuery("use concept");
$stmt = dbQuery("truncate table conceptKeywords") or die ("truncate");
	echo "in here";
$qry = "insert into conceptKeywords (concept_id, keyword) values (?,?)";
$ps = dbPrepare($qry) or die ("prepare");
$qry = "select concept_id, replace(replace(name,'(',''),')','') as name, replace(replace(description,'(',''),')','') as description from concept_name where locale = 'en' and concept_id in (select concept_id from concept where class_id = 3)";

$result = dbQuery($qry) or die (mysql_error());
while ($row = psRowFetch($result)) {
	$tmpArray = preg_split("/[\s,]+/", $row['name']);
	for ($i = 0; $i < count($tmpArray); $i++) {
		$stmt = dbQuery($ps, $row['concept_id'], $tmpArray[$i]) or die(mysql_error()) ;
		$jjj++;
	}
	$iii++; 
	$tmpArray = preg_split("/[\s,]+/", $row['description']);
	for ($i = 0; $i < count($tmpArray); $i++) {
		$stmt = dbQuery($ps, $row['concept_id'], $tmpArray[$i]) or die (mysql_error()) ;
		$jjj++;
	}
	$iii++;
}
$stmt = dbQuery("delete from conceptKeywords where keyword in ('acute','by','the','a','an','is','that','from','usually','for','on','than','be','which','to','of','or','HIV','in','due','with','','not','other','-','and')");
$stmt = dbQuery("delete from conceptKeywords where length(keyword) = 1");
*/
/* code to load conditions (diagnoses)/drugs/labs from conditionLookup/drugLookup/labLookup */

$stmt = dbQuery("use has") or die ("cant use has");
$stmt = dbQuery("truncate table conditionKeywords") or die ("cant truncate");
$qry = "insert into conditionKeywords (concept_id, keyword) values (?,?)";
$ps = $globalDbHandle->prepare($qry) or die ("failed here");
$qry = "select drugid as id, replace(replace(drugLabel,'(',''),')','') as name, replace(replace(drugGroup,'(',''),')','') as name2 from drugLookup";
$result = dbQuery($qry) or die (mysql_error());

while ($row = psRowFetch($result)) {
	$tmpArray = preg_split("/[\s,]+/", $row['name']);
	for ($i = 0; $i < count($tmpArray); $i++) {
		$t2 = explode("+", $tmpArray[$i]);
		if (count($t2) == 2) {
			$stmt = dbQuery($ps, $row['id'], $t2[1]) or die (mysql_error()) ;
			$jjj;
		}
		$stmt = dbQuery($ps, $row['id'], $t2[0]) or die (mysql_error()) ;
		$jjj++;
	}
	/*$tmpArray = preg_split("/[\s,]+/", $row['name2']);
	for ($i = 0; $i < count($tmpArray); $i++) {
		$t2 = explode("+", $tmpArray[$i]);
		if (count($t2) == 2) {
			$stmt = dbQuery($ps, $row['id'], $t2[1]) or die (mysql_error()) ;
			$jjj;
		}
		$stmt = dbQuery($ps, $row['id'], $t2[0]) or die (mysql_error()) ;
		$jjj++;
	}*/
	$iii++;
}

$stmt = dbQuery("delete from conditionKeywords where keyword in (
'acute','by','the','a','an','is','that','from','usually','for','on','than','be','which','to','of','or','HIV','in','due','with','','not','other','-','and')");
$stmt = dbQuery("delete from conditionKeywords where length(keyword) = 1");


/* code to test performance of prepared inserts
$result = mysql_query("delete from patient where patientid < 10000");
$before = date("i:s");
//$qry = "insert into patient (patientid, fname, lname) values (?,?,?)";
//$ps = $globalDbHandle->prepare($qry) or die (mssql_error());
for ($i = 0; $i < 10000; $i++) {
	$pid = $i;
	$fname = "fname" . $i;
	$lname = "lname" . $i;
	$ps = "insert into patient (patientid, fname, lname) values (" . $pid . ",'" . $fname . "','" . $lname . "')";
	//$stmt = dbQuery ($ps, $pid, $fname, $lname) or die (mssql_error());
	$stmt = mysql_query($ps) or die (mysql_error());
}

echo date("i:s") . "-" . $before;
*/
echo $iii . " concepts " . $jjj . " keywords";
?>