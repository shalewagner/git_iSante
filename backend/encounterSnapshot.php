<?
function updateEncounterSnapshot($truncate) {
 
	if ($truncate) dbQuery ("TRUNCATE TABLE dw_encounter_snapshot"); 
	
	/* refresh the dw_encounter_snapshot */
	$sql = "select max(lastModified) as 'lm', count(*) as 'cnt' from dw_encounter_snapshot";
	$arr = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	if ($arr[0]['cnt'] == 0) $lastModified = '2003-01-01';
	else $lastModified = $arr[0]['lm'];  
      
        // avoid issue of encounters with lastModified dates in the future
        $now = date ("Y-m-d H:i:s");

	$sql = "insert into dw_encounter_snapshot select e.sitecode, e.patientid, date(left(e.visitDate,10)) as visitdate, e.encounter_id, e.dbSite, case when e.lastModified > ? then ? else e.lastModified end as lastModified
	from encValidAll e where e.lastModified >= ? and e.visitDate between ? and ?
	on duplicate key update dw_encounter_snapshot.visitdate = date(left(e.visitDate,10)), dw_encounter_snapshot.lastModified = case when e.lastModified > ? then ? else e.lastModified end";  

	if (DEBUG_FLAG) echo "<br />Last Modified Value: " . $lastModified . "<br />" . $sql . "<br />";   
	$rc = database()->query($sql, array($now, $now, $lastModified, '2003-01-01', $now, $now, $now))->rowCount(); 
	if (DEBUG_FLAG) echo "<br />Refresh Time" . date('h:i:s') . "<br />";
	 
	return array('rowCount' => $rc, 'lastModified' => $lastModified);
}
?>
