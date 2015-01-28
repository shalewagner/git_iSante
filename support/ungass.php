<?php  
/* Annual report generated on demand */
chdir("..");
require_once "backend.php";
error_reporting (E_ALL | E_STRICT);

$runDate = $_GET['runDate']; 
$runDate2 = $_GET['runDate2'];
$runDate3 = $_GET['runDate3'];

echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$qry = "drop table if exists ungassNumerator";
dbQuery($qry);
$qry = "drop table if exists ungassDenominator";
dbQuery($qry); 

// Number of patients who started ARV (i.e dispensation form filled) between 01-01-2010 and 12-31-2010
$qry = "create table ungassDenominator select patientid from pepfarTable p, clinicLookup s where left(patientid,5) = s.sitecode group by patientid having min(visitdate) between  '" . $runDate . "' and '" . $runDate2 . "'";
echo $qry . "<br>";
dbQuery($qry);
dbQuery("alter table ungassDenominator add primary key (patientid)");

// Number of patients who started ARV (i.e dispensation form filled) between 01-01-2010 and 12-31-2010 - Number of these preceding patients who stopped (dead, lost to follow-up, patient choice) from 01-01-2010 through 12-31-2011
$qry = "create table ungassNumerator select distinct patientid from patientStatusTemp join ungassDenominator using (patientid) where patientStatus in (1,8) and endDate between '" . $runDate . "' and '" . $runDate3 . "'";
echo $qry . "<br>";
dbQuery($qry); 
dbQuery("alter table ungassNumerator add primary key (patientid)");

$qry = "select sitecode, count(distinct n.patientid) as numerator from ungassNumerator n, clinicLookup c where left(n.patientid,5) = c.sitecode group by 1 order by 1";
echo $qry . "<br>";
$result = dbQuery($qry);
$numerator = array();
while ($row = psRowFetch($result)) { 
	$numerator[$row[0]] = $row[1];
}

$qry = "select sitecode, clinic, count(distinct d.patientid) as denominator from ungassDenominator d, clinicLookup c where left(d.patientid,5) = c.sitecode group by 1,2 order by 1";
echo $qry . "<br>";
$result = dbQuery($qry);
echo "<table border=\"1\"><tr><th>Code</th><th>Clinique</th><th>Num&eacute;rateur</th><th>D&eacute;nominateur</th><th>Pourcentage</th></tr>";
while ($row = psRowFetch($result)) {
	$site = $row[0];
	$clinic = $row[1];
	$den = $row[2];
	if (! array_key_exists($site, $numerator)) $numerator[$site] = 0;
	echo "<tr><td>" . $site . "</td><td>" . $clinic . "</td><td>" . ($den - $numerator[$site]) . "</td><td>"  . $den . "</td><td>" . sprintf("%d", ($den - $numerator[$site])/$den*100) . "</td></tr>";
}
echo "</table>";
?>
