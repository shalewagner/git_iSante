<?php
include ("backend.php");
//error_reporting (0);
set_time_limit (500);
$tabArray = array();
$qry = "select table_name from v_currentTables order by 1";
$result = dbQuery ($qry);
while ($row = psRowFetch ($result))
	array_push($tabArray, $row[0]);

echo "<table border=\"1\">";

// build a unique index on patient, if it doesn't have one
$currQuery = "drop index patientGUID on patient";
$w = 0;
dbQuery ($currQuery);
echo "<tr><th colspan=\"2\">patient</th></tr>";
echo "<tr><td>" . $currQuery . "</td><td>" . $w . "</td></tr>";
$currQuery = "create index patientGUID on patient (patientID)";
dbQuery ($currQuery);
echo "<tr><td>" . $currQuery . "</td><td>" . $w . "</td></tr>";

foreach ($tabArray as $table) {
	$qry2 = "select column_name, ordinal_position
	from information_schema.columns
	where table_schema = '" . DB_NAME . "' and table_name = '" . $table . "' and column_name in (
		'sitecode', 'patientid', 'visitDateDd', 'visitDateMm', 'visitDateYy', 'seqNum',
		'allergySlot', 'referral', 'conditionID', 'disclosureSlot',
		'drugID', 'drugName', 'drug', 'drugSlot', 'rxSlot',
		'encounterType', 'householdSlot', 'immunizationID', 'immunizationSlot',
		'labID', 'labSlot', 'pedlabsID', 'pedlabsSlot', 'reasonID', 'riskID')
	order by 2";
	$result1 = dbQuery ($qry2);
	$colList = "patientId, siteCode";
	while ($row = psRowFetch ($result1)) {
		$curCol = strtolower($row[0]);
		if ($curCol != "sitecode" && $curCol != "patientid")
			$colList .= ", " . $row[0];
	}
	echo "<tr><th colspan=\"2\">" . $table . "</th></tr>";
	if (indexExists($table . "GUID")) {
		$currQuery = "drop index " . $table . "GUID on " . $table;
		$w = 0;
		dbQuery ($currQuery);
		echo "<tr><td>" . $currQuery . "</td><td>" . $w . "</td></tr>";
	}
	if (indexExists($table . "INDEX")) {
		$currQuery = "drop index " . $table . "INDEX on " . $table;
		$w = 0;
		dbQuery ($currQuery);
		echo "<tr><td>" . $currQuery . "</td><td>" . $w . "</td></tr>";
	}
	$currQuery = "create unique index " . $table . "INDEX on " . $table . "(" . $colList . "," . $table . "_ID)";
	$w = 0;
	dbQuery ($currQuery);
	echo "<tr><td>" . $currQuery . "</td><td>" . $w . "</td></tr>";
	$currQuery = "create unique index " . $table . "GUID on " . $table .  " (dbSite, " . $table . "_id)";
	$w = 0;
	dbQuery ($currQuery);
	echo "<tr><td>" . $currQuery . "</td><td>" . $w . "</td></tr>";

}
echo "
	</table>";
function indexExists ($indexName) {
	$flag = false;
	$qry = "select 1 from information_schema.key_column_usage where constraint_name = '" . $indexName . "' and constraint_schema = '" . DB_NAME . "'";
	$result = dbQuery($qry);
	while ($row = psRowFetch($result))
		$flag = true;
	return ($flag);
}
?>
 </form>
 </body>
</html>
