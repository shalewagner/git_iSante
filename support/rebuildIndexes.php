<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
  <title>Rebuild Database Indexes</title>
  <link href="default.css" type="text/css" rel="StyleSheet">
 </head>
<?php
include ("../backend.php");
set_time_limit (500);
//error_reporting (0);
$tabArray = array();
$qry = "select table_name from v_currentTables order by 1";
$result = dbQuery ($qry);
while ($row = psRowFetch ($result))
	array_push($tabArray, $row[0]);

echo "<table border=\"1\">";

// first get rid of some leftover indexes:
$currQuery = "if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[encounter.IX_encounter') and objectproperty(id,N'IsIndex') = 1) drop index encounter.IX_encounter";
	$w = 0;
	$w = doWQuery ($currQuery);
	echo "<tr><td>" . $currQuery . "</td><td>" . $w . "</td></tr>";
$currQuery = "if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[adherenceCounseling.adherenceCounselingCONSTRAINT]') and objectproperty(id,N'IsConstraint') = 1) alter table adherenceCounseling drop constraint adherenceCounselingCONSTRAINT";
	$w = 0;
	$w = doWQuery ($currQuery);
	echo "<tr><td>" . $currQuery . "</td><td>" . $w . "</td></tr>";

// build a unique index on patient, if it doesn't have one
	$currQuery = "if not exists (select * from sysobjects where name = 'patientGUID') alter table patient add constraint patientGUID unique (patientID)";
	$w = 0;
	$w = doWQuery ($currQuery);
	echo "<tr><td>" . $currQuery . "</td><td>" . $w . "</td></tr>";

foreach ($tabArray as $table) {
	$qry2 = "select column_name, ordinal_position
	from information_schema.columns
	where table_name = '" . $table . "' and column_name in (
		'sitecode', 'patientid', 'visitdatedd', 'visitdatemm', 'visitdateyy', 'seqNum',
		'allergySlot', 'referral', 'conditionID', 'disclosureSlot',
		'drugID', 'drugName', 'drug', 'drugSlot', 'rxSlot',
		'encounterType', 'householdSlot', 'immunizationID', 'immunizationSlot',
		'labID', 'labSlot', 'pedlabsID', 'pedlabsSlot', 'reasonID', 'riskID')
	order by 2";
	$result1 = dbQuery ($qry2);
	$colList = "";
	while ($row = psRowFetch ($result1)) {
		if ($colList != "") $colList .= ", ";
		$colList .= $row[0];
	}
	echo "<tr><th colspan=\"2\">" . $table . "</th></tr>";
	$currQuery = "alter table " . $table . " drop constraint " . $table . "GUID";
	$w = 0;
	$w = doWQuery ($currQuery);
	echo "<tr><td>" . $currQuery . "</td><td>" . $w . "</td></tr>";
	$currQuery = "drop index " . $table . "." . $table . "INDEX";
	$w = 0;
	$w = doWQuery ($currQuery);
	echo "<tr><td>" . $currQuery . "</td><td>" . $w . "</td></tr>";
	$currQuery = "create unique clustered index " . $table . "INDEX on " . $table . "(" . $colList . "," . $table . "_ID)";
	$w = 0;
	$w = doWQuery ($currQuery);
	echo "<tr><td>" . $currQuery . "</td><td>" . $w . "</td></tr>";
	$currQuery = "alter table " . $table . " add constraint " . $table . "GUID unique (" . $table . "_id, dbSite)";
	$w = 0;
	$w = doWQuery ($currQuery);
	echo "<tr><td>" . $currQuery . "</td><td>" . $w . "</td></tr>";

}
echo "
	</table>";
function doWQuery ($qry = "") {
	$id = dbQuery ($qry);
	if ($id == "") {
		if (DEBUG_FLAG) print "<br>Failed: " . $qry . "<br>";
		return (0);
	}
	else
		return (1);
}
?>
 </form>
 </body>
</html>
