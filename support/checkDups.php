<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
  <title>check for duplicate records/keys</title>
  <link href="default.css" type="text/css" rel="StyleSheet">
 </head>
<?php
include ("../backend.php");
set_time_limit (500);
if ( isset($_GET['updateFlag']) ) $updateFlag = true;
else $updateFlag = false;
if ( isset($_GET['dupRecFlag']) ) $dupRecFlag = true;
else $dupRecFlag = false;

$tabArray = array();
$qry = "select table_name from v_currentTables order by 1 desc";
$result = dbQuery ($qry);
while ($row = psRowFetch ($result))
	array_push($tabArray, $row[0]);

// check out patient table as well
array_push($tabArray, "patient");

echo "<table border=\"1\" width=\"100%\">
	<tr><th>Table</th><th>Duplicate Count</th><th>Statement</th><th>Duplicate Query</th></tr>";

foreach ($tabArray as $table) {
	// get rid of any sitecode=00000 records
	if ($table == "patient")
		$qry = "delete from " . $table . " where left(patientid,5) = '00000'";
	else
		$qry = "delete from " . $table . " where sitecode = '00000'";
	dbQuery($qry);

	if ($dupRecFlag) {
		// this query has all columns except <tablename>_id, long text columns, and dbSite in it, to check for duplicate records
		$qry2 = "select column_name, ordinal_position
				from information_schema.columns
				where table_name = '" . $table . "' and
				column_name != '" . $table . "_id' and
				column_name != 'dbSite' and
				data_type not in ('text', 'ntext', 'image')
				order by 2";
	} else {
		// this query has all possible key columns in it, to check for duplicate keys
		$qry2 = "select column_name, ordinal_position
				from information_schema.columns
				where table_name = '" . $table . "' and column_name in
				(
					'sitecode', 'patientid', 'visitdatedd', 'visitdatemm', 'visitdateyy', 'seqNum',
					'allergySlot', 'referral', 'conditionID', 'disclosureSlot',
					'drugID', 'drugName', 'drug', 'drugSlot', 'rxSlot',
					'encounterType', 'householdSlot', 'immunizationID', 'immunizationSlot',
					'labID', 'labSlot', 'pedlabsID', 'pedlabsSlot', 'reasonID', 'riskID'
				)
				order by 2";
	}
	$result1 = dbQuery ($qry2);
	$colList = "";
	while ($row = psRowFetch ($result1)) {
		if ($colList != "") $colList .= ", ";
		$colList .= $row[0];
	}
	$currQuery = "select " . $colList . ", count(*), min(" . $table . "_id) as 'cnt', max(" . $table . "_id) as 'xcnt' from " . $table . " group by " . $colList . " having count(*) > 1";
	//echo $currQuery . "<br>";
	$result2 = dbQuery ($currQuery);
	$rowcnt = 0;
	$statementArray = array();
	while ($row = psRowFetch($result2)) {
		$rowcnt++;
		if ($updateFlag) {
			$qry = "delete from " . $table . " where " . $table . "_id = " . $row['cnt'];
			// . " and dbSite = " . $row['dbSite'];
			dbQuery($qry);
		} else
			$qry = "select * from " . $table . " where " . $table . "_id in (" . $row['cnt'] . "," . $row['xcnt'] . ")";
			//" and dbSite = " . $row['dbSite'];
		array_push($statementArray, $qry);
	}
	echo "<tr><td>" . $table . "</td><td>" . $rowcnt . "</td><td>";
	foreach ($statementArray as $qry) {
		echo $qry . "<br>";
	}
	echo "</td><td>" . $currQuery . "</td></tr>";
}
echo "
	</table>";
?>
 </form>
 </body>
</html>
