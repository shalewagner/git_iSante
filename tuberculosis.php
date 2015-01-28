<? 
require_once 'include/standardHeaderExt.php';
//$eid = getMostRecentIntakeID ($pid); 
//getExistingData ($eid, $tables);
require_once 'include/verticalTabHeader.php';
function getMostRecentIntakeID ($pid) { 
	$queryStmt = "SELECT encounter_id FROM encounter WHERE patientID = " . $pid . " AND encStatus < 255 AND encounterType = 32 order by encounter_id desc limit 1";
	$result = database()->query($queryStmt)->fetchAll();
	$eid = $result[0]['encounter_id'];
	return ($eid);
}
?>
