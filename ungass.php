<?php
require_once "backend.php";
error_reporting (E_ALL | E_STRICT);
$runDate = $_GET['runDate'];
$numPickups = $_GET['numPickups'];
$qry = "select dateadd(yy, -1, '" . $runDate . "'), dateadd(mm,-3,'" . $runDate . "')";
$result = dbQuery($qry);
$row = psRowFetch($result);
echo "<h3>Pourcentage d’adultes et d’enfants s&eacute;ropositifs dont on sait qu’ils
sont toujours sous traitement 12 mois apr&egrave;s le d&eacute;but de la th&eacute;rapie antir&eacute;trovirale.</h3><p />";
echo "12 mois:&nbsp;&nbsp;" . substr($row[0],0,10) . " : " . $runDate . "<p />";
echo "Derni&egrave;re collecte > " . substr($row[1],0,10) . "; au moins " . $numPickups . " collectes<p />";
echo "Database: " . DB_NAME . "<p />";
$qry = "create table ungassNumerator (patientid varchar(11))";
//echo $qry . "<br>";
dbQuery($qry);
$qry = "create table ungassDenominator (patientid varchar(11))";
//echo $qry . "<br>";
dbQuery($qry);
$qry = "insert into ungassDenominator (patientid) select p.patientid from pepfarTable p where p.visitdate between dateadd(mm,-13,'" . $runDate . "') and dateadd(mm,-11,'" . $runDate . "') group by p.patientid";
//echo $qry . "<br>";
dbQuery($qry);
$qry = "insert into ungassNumerator (patientid) select p.patientid from pepfarTable p
where p.visitdate between dateadd(yy,-1,'" . $runDate . "') and '" . $runDate . "' and 
p.patientid not in (select patientid from discTable where discdate between dateadd(yy,-1,'" . $runDate . "') and '" . $runDate . "')
group by p.patientid having max(p.visitdate) >= dateadd(mm,-3, '" . $runDate . "') and count(distinct p.visitdate) >= " . $numPickups;
//echo $qry . "<br>";
dbQuery($qry);
$qry = "select sitecode, clinic, count(distinct a.patientid) as numerator from ungassNumerator a, clinicLookup c, ungassDenominator b where left(a.patientid,5) = c.sitecode and a.patientid = b.patientid group by sitecode, clinic";
//echo $qry . "<br>";
$result = dbQuery($qry);
$numerator = array();
while ($row = psRowFetch($result)) {
	$site = $row[0];
	$num = $row[2];
	$numerator[$site] = $num;
}
//print_r($numerator);
$qry = "select sitecode, clinic, count(*) as denominator from ungassDenominator a, clinicLookup c where c.sitecode = left(patientid,5) group by sitecode, clinic";
//echo $qry . "<br>";
$result = dbQuery($qry);
$denominator = array();
echo "<table border=\"1\">
	<tr><th>Clinique</th><th>Num&eacute;rateur</th><th>D&eacute;nominateur</th><th>Pourcentage</th></tr>";
while ($row = psRowFetch($result)) {
	$clinic = $row[1];
	$site = $row[0];
	$den = $row[2];
	$denominator[$site] = $den;
	if (isset($numerator[$site]))
		echo "<tr><td>" . $clinic . "</td><td>" . $numerator[$site] . "</td><td>"  . $denominator[$site] . "</td><td>" . sprintf("%d", ($numerator[$site]/$denominator[$site])*100) . "</td></tr>";
	else
		echo "<tr><td>" . $clinic . "</td><td>0</td><td>"  . $denominator[$site] . "</td><td>na</td></tr>";
}
		echo "<tr><td>Total</td><td>" . array_sum($numerator) . "</td><td>"  . array_sum($denominator). "</td><td>" . sprintf("%d", (array_sum($numerator)/array_sum($denominator))*100) . "</td></tr>";
echo "</table>";
dbQuery ("drop table ungassNumerator");
dbQuery ("drop table ungassDenominator");
?>
