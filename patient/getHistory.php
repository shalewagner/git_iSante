<?  
chdir('..');
include ("backend.php");
require_once 'labels/grid.php';
$task = $_REQUEST['task'];
$pid = $_REQUEST['pid'];
$lang = $_REQUEST['lang'];
switch($task){
case 'lab':
	$sql = "(select ymdToDate(visitdateYy, visitdateMm, visitdateDd) as vDate, v.labid, CONCAT(UPPER(SUBSTRING(v.labgroup, 1, 1)), LOWER(SUBSTRING(v.labgroup FROM 2))) AS labGroup, v.testName" . ucfirst($lang) . ", case when resultType = 1 and result != '' then case when result = '1' then resultLabelFr1 when result = '2' then resultLabel" . ucfirst($lang) . "2 when result = '4' then resultLabel" . ucfirst($lang) . "3 when result = '8' then resultLabel" . ucfirst($lang) . "4 when result = '16' then resultLabel" . ucfirst($lang) . "5 end when resultType = 2 and result != '' then (result + ' ' + resultLabel" . ucfirst($lang) . "1) when resultType = 3 and result != '' then (result + ' ' + resultLabel" . ucfirst($lang) . "1) when resultType = 4 and result != '' then case when result = '1' then resultLabel" . ucfirst($lang) . "1  when result = '2' then resultLabel" . ucfirst($lang) . "3 when result = '4' then resultLabel" . ucfirst($lang) . "4 end when resultType = 5 and result IS NOT NULL then case when result2 = '1' then (result + ' ' + resultLabel" . ucfirst($lang) . "1) when result2 = '2' then (result + ' ' + resultLabel" . ucfirst($lang) . "2) end when resultType = 6 and result != '' then case when result = '1' then resultLabel" . ucfirst($lang) . "1 when result = '2' then resultLabel" . ucfirst($lang) . "5 end else '' end as result, case when resultType = 2 and result2 IS NOT NULL then (result2 + ' ' + resultLabel" . ucfirst($lang) . "1) when resultType = 3 and result2 IS NOT NULL then (result2 + ' ' + resultLabel" . ucfirst($lang) . "2) when resultType = 4 and result2 IS NOT NULL then case when result2 != '1' and result2 != '2' and result2 != '4' then (result2 + ' ' + resultLabel" . ucfirst($lang) . "2) end when resultType = 6 and result2 IS NOT NULL then case when result2 = '2' then resultLabel" . ucfirst($lang) . "3  when result2 = '3' then (result2 + ' ' + resultLabel" . ucfirst($lang) . "4) end else '' end as result2,case when resultType = 3 and result3 IS NOT NULL then (result3 + ' ' + resultLabel" . ucfirst($lang) . "3) else '' end as result3, resultType, resultAbnormal, resultRemarks,  case when isdate(ymdToDate(resultDateYy,resultDateMm, resultDateDd)) = 1 then ymdToDate(resultDateYy,resultDateMm, resultDateDd) else '2005-01-01' end as resultDate, concat(v.minValue,v.maxValue) as valueRange, v.units, v.panelName as labPanel, v.sectionOrder, v.sendingSiteName, v.testOrder from a_labs v where ((result is not null and result <> '') or isdate(ymdToDate(resultDateYy,resultDateMm, resultDateDd)) = 1) and patientid = '" . $pid . "')
	union
	(select 
	ymdToDate(visitdateYy, visitdateMm, visitdateDd),
	'labid',
	'Autre',
	case when labName = '' then 'Unknown Test' else labName end,
	result,
	result2,
	'result3',
	'resultType',
	resultAbnormal,
	'result remarks',
	case when isdate(ymdToDate(resultDateYy,resultDateMm, resultDateDd)) = 1 then ymdToDate(resultDateYy,resultDateMm, resultDateDd) else '2005-01-01' end,
	'valueRange',
	units,
	'labPanel',
	1,
	sendingSiteName,
	testOrder
	from otherLabs where ((result is not null and result <> '') or isdate(ymdToDate(resultDateYy,resultDateMm, resultDateDd)) = 1) and patientid = '" . $pid . "')
	order by 4, 1 desc"; 
	break;
case 'dx':
	// first query is from the conditions table; second query is from obs
	$sql = "(select visitDate as vDate, conditions_id, whoStage, conditionName" . ucfirst($lang) . ", case when conditionactive = 1 then 1 else 0 end as active, case when conditionactive = 2 then 1 else 0 end as resolved, ymdtodate(conditionYy, conditionMm, '01') as onsetDate from a_conditions where patientid = '" . $pid . "') union (select e.visitDate, n.concept_id, 'NA', case when locate(':', n.description) > 0 then substr(n.description,locate(':', n.description)) else n.description end, 1, 0, visitDate from obs o, concept c, concept_name n, encValidAll e where e.encounter_id = o.encounter_id and o.concept_id = n.concept_id and o.concept_id = c.concept_id and c.class_id = 4 and n.locale = '" . $lang . "' and concat(o.location_id,o.person_id) = e.patientid and e.patientid = '" . $pid . "') order by 1 desc"; 
	break;
case 'rx':
	// first query below is for prescriptions; second query is for stops; third for other meds
	$sql = "(select date(ymdToDate(visitdateyy,visitdatemm,visitdatedd)) as vDate, v.drugID, l.drugGroup, l.drugName, 1 as isContinued, '' as startDate, '' as stopDate, 0 as toxicity,0 as intolerance,0 as failureVir,0 as failureImm,0 as failureClin,0 as stockOut,0 as pregnancy,0 as patientHospitalized,0 as lackMoney,0 as alternativeTreatments,0 missedVisit,0 as patientPreference from prescriptions v, drugLookup l where v.drugid = l.drugid and v.patientid = '" . $pid . "') union 
	(select date(stopDate) as vDate, v.drugID, drugGroup, l.drugName, 0, startDate, case when stopDate is not null then stopDate else '' end as stopDate, toxicity, intolerance, failureVir, failureImm, failureClin, stockOut, pregnancy, patientHospitalized, lackMoney, alternativeTreatments, missedVisit, patientPreference from drugSummary v, drugLookup l where v.drugid = l.drugid and patientid = '" . $pid . "' and stopdate is not null) union 
	(select date(ymdToDate(visitdateYy, visitdateMm, visitdateDd)) as vDate, 0, '" . $newprescription_subhead6[$lang][1] . "', v.drug, 1 as isContinued, ymdToDate(visitdateYy, visitdateMm, '01') as startDate, '' as stopDate, 0 as toxicity,0 as intolerance,0 as failureVir,0 as failureImm,0 as failureClin,0 as stockOut,0 as pregnancy,0 as patientHospitalized,0 as lackMoney,0 as alternativeTreatments,0 missedVisit,0 as patientPreference from otherPrescriptions v where v.patientid = '" . $pid . "') order by 1 desc";
}
$arr = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
$data = json_encode($arr);  
echo '({"total":"' . count($arr) . '","results":' . $data . '})';
	
function doLab($arr, $lang) {
	$lastDate = '';
	$lastSection = 0;
	$lastPanel = 0; 
	$notFirst = false;
	echo "[";
	foreach($arr as $f) {
		$frd = $f['resultDate'];
		$s = $f['labGroup'];
		$p = $f['labPanel'];
		if ($lastDate <> $frd) { 
			if ($notFirst) echo "]}]}]},";  
			openDate($frd);
			openSection($s);
			openPanel($p);
		} else if ($lastSection <> $s) { 
			echo "]}]},";
			openSection($s);
			openPanel($p);
		} else if ($lastPanel <> $p) {
			echo "]},";
			openPanel($p);
		} else echo ",";
		makeTest($f, $lang);
		$lastDate = $frd;
		$lastSection = $s;
		$lastPanel = $p;
		$notFirst = true; 
	}    
	echo "]}]}]}]";
}
function openDate($frd) {
	echo "{ 
		task: '$frd',
		iconCls: 'task-folder',
		leaf: false,
		expanded: true,
		children: [
	";
} 
function openSection($s) {
	echo "{
		task: '$s',
		leaf: false,
		expanded: true, 
		children: [
	";
}
function openPanel($p) {
	echo "{
		task: '$p',
		leaf: false,
		expanded: true, 
		children: [
	";
}
function makeTest($f, $lang) {
	$test = str_replace("'","’", $f['testName' . ucfirst($lang)]);
	echo "{
		task: '" . $test . "',
		result: '" . $f['result'] . "',
		units: '" . $f['units'] . "', 
		leaf: true, 
		iconCls: 'task',
		valueRange: '" . $f['valueRange'] . "',
		resultRemarks: '" . $f['resultRemarks'] . "',
		sendingSiteName: '" . $f['sendingSiteName'] . "',
		accessionNumber: '" . $f['accessionNumber'] . "',
		vDate: '" . $f['resultRemarks'] . "'
		
	}";
}     
?>
