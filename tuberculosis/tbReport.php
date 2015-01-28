<?
error_reporting(E_ALL); 
$_REQUEST['noid'] = 'true';
require_once 'backend.php';

/* Fetch the array of tb evaluation variables: 
 *   eval slot (series 1,2,3 aka mois 0,2,3,5,fin)
 *   eval date
 *   eval result
 *   eval weight
 * Sort by patient, slot, encounterDate desc, encountertype (just to differentiate if same day encounters)
 * Interested in the most recent information for each slot
 */
$sql = "
select patientID,  
case when substr(short_name,length(short_name)) = 'n' then '6' else substr(short_name,length(short_name)) end as slot,
visitDate, encounterType, 
group_concat(short_name) as short_name, 
group_concat(ifnull(value_numeric,0)) as vn, 
group_concat(substr(ifnull(value_datetime,'0000-00-00'),1,10)) as dt 
from obs o, concept c, encValidAll e 
where o.concept_id = c.concept_id and c.short_name like 'tbEval%' and 
e.encounter_id = o.encounter_id and e.sitecode = o.location_id
group by 1,2,3,4 order by 1,2,3 desc,4
";

$arr = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
$patientArray = array();
echo '<table border="1">'; 
$havit = array();    
$sql = "create table tbEvalReport (patientID varchar(11), slot int, vdate datetime, resultPositive int, resultNegative int, weight int)";  
$sql = "truncate table tbEvalReport"; 
$result = database()->query($sql);
foreach ($arr as $row) {
	$pid = $row['patientID'];
	$slot = $row['slot'];
	if (in_array($pid . '-' . $slot, $havit)) continue;
	$havit[] = $pid . '-' . $slot; 
	$visitDate = $row['visitDate'];
	$encType = $row['encounterType']; 
	$nameArray = explode(',', $row['short_name']); 
	$vnArray = explode(',', $row['vn']);
	$dtArray = explode(',', $row['dt']);
	echo "<tr><td>pid: " . $pid . "</td><td>slot: " . $slot . "</td><td>date: " . $visitDate . "</td><td>encType: " . $encType ."</td></tr>"; 
	$date = '0000-00-00';
	$weight = 0;
	$resultP = 0;
	$resultN = 0;
	for ($i = 0; $i < count($nameArray); $i++) {
		if ($slot == 6) $tempName = substr($nameArray[$i],0,strlen($nameArray[$i])-3);
		else $tempName = substr($nameArray[$i],0,strlen($nameArray[$i])-1); 
		switch ($tempName) {
		case 'tbEvalDt':
			$date = $dtArray[$i];
		break;
		case 'tbEvalresult': 
			if ($vnArray[$i] == 1) $resultP = 1; 
			if ($vnArray[$i] == 2) $resultN = 1;
		break;
		case 'tbEvalweight':
			$weight = $vnArray[$i];
		break;
		default:
		//echo "nothing worked";
		} 
	} 
	echo "<tr><td>Slot: " . $slot . "</td><td>Date: " . $date . "</td><td>Result: " . $resultP . "</td><td>Weight: " . $weight . "</td></tr>"; 
	$ins1 = "insert into tbEvalReport (patientID, slot, vdate, resultPositive, resultNegative, weight) values (?,?,?,?,?,?)"; 
	$result = database()->query($ins1, array($pid, $slot, $date, $resultP, $resultN, $weight)); 
}   
echo "</table>";
$sql = "select substr(patientid,1,5) as sitecode, slot, year(vdate) as year, count(resultPositive) as positive, count(resultNegative) as negative, avg(weight) as wt from tbEvalReport
	group by 1,2,3 order by 1,2,3"; 
	$arr = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
	print_r($arr)
?> 
