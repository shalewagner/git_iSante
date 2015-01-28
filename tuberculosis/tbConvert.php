<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
/*** This program:
 *** reads the tbStatus table and loads its contents into the obs table
 *** It requires:
 *** concept objects for each of the concept columns in the tbStatus table 
 *** (these are generated originally by tbConceptCreate.php, but will be included in the lookup tables as part of the normal lookup refresh)
 *** It outputs:
 *** count of obs records created per tbStatus record read plus grand total of obs records added                  
 */
 
/*
 * This is the format of the tbStatus table, for reference purposes 
CREATE TABLE IF NOT EXISTS tbStatus (
  tbStatus_id int(10) unsigned NOT NULL auto_increment,
  siteCode mediumint(8) unsigned NOT NULL,
  patientID varchar(11) NOT NULL,
  visitDateDd char(2) NOT NULL,
  visitDateMm char(2) NOT NULL,
  visitDateYy char(2) NOT NULL,
  seqNum tinyint(3) unsigned NOT NULL default '0',
  asymptomaticTb tinyint(3) unsigned default '0',
  suspectedTb tinyint(3) unsigned default '0',
  currentProp tinyint(3) unsigned default '0',
  currentTreat tinyint(3) unsigned default '0',
  currentTreatNo varchar(64) default NULL,
  currentTreatFac varchar(255) default NULL,
  completeTreat tinyint(3) unsigned default '0',
  completeTreatFac varchar(255) default NULL,
  completeTreatMm char(2) default NULL,
  completeTreatYy char(2) default NULL,
  completeTreatDd char(2) default NULL,
  dbSite tinyint(3) unsigned NOT NULL default '0',
  presenceBCG tinyint(3) unsigned default NULL,
  suspicionTBwSymptoms tinyint(3) unsigned default NULL,
  noTBsymptoms tinyint(3) unsigned default NULL,
  recentNegPPD tinyint(3) unsigned default NULL,
  statusPPDunknown tinyint(3) unsigned default NULL,
  propINH tinyint(3) unsigned default NULL,
  debutINHMm char(2) default NULL,
  debutINHYy char(2) default NULL,
  arretINHMm char(2) default NULL,
  arretINHYy char(2) default NULL,
  pedTbEvalRecentExp tinyint(3) unsigned default NULL,
  pedCompleteTreatStartMm char(2) default NULL,
  pedCompleteTreatStartYy char(2) default NULL,
  pedTbEvalPpdRecent tinyint(3) unsigned default NULL,
  pedTbEvalPpdRecentMm char(2) default NULL,
  pedTbEvalPpdRecentYy char(2) default NULL,
  pedTbEvalPpdRecentRes char(2) default NULL,
  PRIMARY KEY  (tbStatus_id,dbSite),
  UNIQUE KEY tbStatusINDEX (patientID,visitDateYy,visitDateMm,visitDateDd,seqNum,siteCode)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=238160 ;
*/  

$_REQUEST['noid'] = 'true';
require_once 'backend.php';

error_reporting(E_ALL);  

// load concept map
$sql = 'select short_name, concept_id, datatype_id from concept where concept_id < 7000 or concept_id = 8073'; 
$conceptArray = database()->query($sql)->fetchAll();
$conceptMap = array();
foreach ($conceptArray as $row) {
	$conceptMap[$row['short_name']] = array($row['concept_id'],$row['datatype_id']);
}  

/* This query would load row by row if memory size is too big to do entire table
   $sql = 'select e.encounter_id from tbStatus tb, encounter e
	where tb.siteCode = e.siteCode and tb.patientID = e.patientID and tb.visitDateDd = e.visitDateDd and 
	tb.visitDateMm = e.visitDateMm and tb.visitDateYy = e.visitDateYy and tb.seqNum = e.seqNum order by 1';	
   $idArray = database()->query($sql)->fetchAll();  
*/

$sql = 'select straight_join encounter_id, tb.* from tbStatus tb join encounter using (siteCode, patientID, visitDateDd, visitDateMm, visitDateYy, seqNum)';   
$tbArray = database()->query($sql)->fetchAll();

// Loop on tbStatus table
$total = 0;
foreach ($tbArray as $tbRow) {
	$counter = obsInsert($tbRow,$conceptMap);
//	echo "# of columns inserted for " . $tbRow['encounter_id'] . ": " . $counter . "<br>";
	$total += $counter;
}      
echo "Grand total of records inserted for " . count($tbArray) . " tbStatus records: " . $total;

function obsInsert($row,$conceptMap) { 
/*	$sql = 'delete from obs where encounter_id = ? and location_id = ? and (concept_id < 7000 or concept_id = 8073)'; 
	$rowCnt = database()->query($sql, array($row['encounter_id'],$row['siteCode']))->rowCount(); */
	
	// insert a obs record for each concept in the map that is not null 
	$counter = 0;  
	foreach ($conceptMap as $key => $value) { 
		if ($value['1'] == 3) {
			if ($row[$key] == '') continue; 
			$type = 'value_text';
		} else {
			if ($row[$key] != 1) continue;
			$type = 'value_boolean';
		} 
		$sql = 'insert into obs (person_id, concept_id, encounter_id, location_id, ' . $type . ') values (?,?,?,?,?)';
		$vals = array(substr($row['patientID'],5),$value[0], $row['encounter_id'], $row['siteCode'], $row[$key]);
		$rowCnt = database()->query($sql, $vals)->rowCount();
		$counter += $rowCnt;  
	}
	return $counter; 
}
?>
