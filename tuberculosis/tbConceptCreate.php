<?
$_REQUEST['noid'] = 'true';
//require_once 'backend.php';
error_reporting(E_ALL);
$nameArray = array (
	'asymptomaticTb',
	'suspectedTb',
	'currentProp',
	'currentTreat',
	'currentTreatNo',
	'currentTreatFac',
	'completeTreat',
	'completeTreatMm',
	'completeTreatYy',
	'completeTreatDd',
	'presenceBCG',
	'suspicionTBwSymptoms',
	'noTBsymptoms',
	'recentNegPPD',
	'statusPPDunknown',
	'propINH',
	'debutINHMm',
	'debutINHYy',
	'arretINHMm',
	'arretINHYy',
	'pedTbEvalRecentExp',
	'pedCompleteTreatStartMm',
	'pedCompleteTreatStartYy',
	'pedTbEvalPpdRecent',
	'pedTbEvalPpdRecentMm',
	'pedTbEvalPpdRecentYy',
	'pedTbEvalPpdRecentRes',
	'completeTreatFac'
);
// note: completeTreatFac is already concept 8073, so is not added in the loop below  
for ($i = 0; $i < 27; $i++) { 
	$cid = $i + 6000;
	$sql = 'insert into concept (concept_id , short_name , description , class_id , datatype_id , date_created) values (' . $cid . ' , ? , ? , 4 , 3 , now())';
	$statement = $dbh->prepare($sql);
	$retVal = $statement->execute(array($nameArray[$i],$nameArray[$i]));
	if (! $retVal) exit; 
	$sql = 'insert into concept_name (concept_id , name , short_name , description , locale , date_created) values (' . $cid . ' , ? , ? , ? , ? , now())'; 
	$statement = $dbh->prepare($sql);
	$retVal = $statement->execute(array($nameArray[$i],$nameArray[$i],$nameArray[$i],'en'));  
	if (! $retVal) exit;
	$statement = $dbh->prepare($sql);
	$retVal = $statement->execute(array($nameArray[$i],$nameArray[$i],$nameArray[$i],'fr')); 
	if (! $retVal) exit;
	echo $i . "...\n";
}   
$sql = 'update concept set datatype_id = 10 where short_name in (?,?,?,?,?,?,?,?,?,?,?,?,?)';
$statement = $dbh->prepare($sql);
$retVal = $statement->execute(array('asymptomaticTb','suspectedTb', 'currentProp',
        'currentTreat','completeTreat', 'presenceBCG', 'suspicionTBwSymptoms', 'noTBsymptoms', 'recentNegPPD',
        'statusPPDunknown', 'propINH', 'pedTbEvalRecentExp', 'pedTbEvalPpdRecent'));
if (! $retVal) echo 'failed to update datatype_id = 10';
else echo 'database_id update OK'; 
?>
