<? 
function updateTbSnapshot($lastModified) {
	/* Put obs table records into the snapshot */ 
	/* First insert the date events -- these are tricky because each separate obs record needs to be correlated */
	$sql = "select d.visitdate, e.patientID, c.short_name, o.value_numeric 
	from obs o, encounter e, concept c, (
		select o.location_id, o.encounter_id, e.patientID, short_name, date(value_datetime) as visitdate
		from obs o, encounter e, concept c 
		where c.short_name in ('tbEvalDt0', 'tbEvalDt2', 'tbEvalDt3', 'tbEvalDt5', 'tbEvalDtFin', 'tbStopDate') and
		c.concept_id = o.concept_id and 
		o.encounter_id = e.encounter_id and 
		concat(o.location_id,o.person_id) = e.patientid) d 
	where c.short_name in ( 'tbEvalResult0', 'tbEvalResult2', 'tbEvalResult3', 'tbEvalResult5', 'tbEvalResultFin', 'tbStopReason') and
	c.concept_id = o.concept_id and 
	o.encounter_id = e.encounter_id and 
	concat(o.location_id,o.person_id) = e.patientid and
	o.location_id = d.location_id and
	o.encounter_id = d.encounter_id and
	e.patientID = d.patientID and
	(right(c.short_name,length(c.short_name)-12) = right(d.short_name,length(d.short_name)-8) or (c.short_name = 'tbStopReason' and d.short_name = 'tbStopDate'))";
	if (DEBUG_FLAG) echo "<br>Obs Query1: " . $sql . "<br>";
	$arr = databaseSelect()->query($sql,array($lastModified))->fetchAll(PDO::FETCH_ASSOC);
	$j = 0;
	$k = 0;
	foreach ($arr as $i => $row) {
		if ($row['patientID'] == "" || $row['visitdate'] == "") continue;
		$qry = 'insert into dw_tb_snapshot (patientid, visitdate, ' . $row['short_name'] . ') values (?,?,?) on duplicate key update ' . $row['short_name'] . ' = ?';
		$rc = database()->query($qry, array($row['patientID'],$row['visitdate'], $row['value_numeric'], $row['value_numeric']))->rowCount();
		$j++;
		if ($rc > 0) $k++;
	} 
	if (DEBUG_FLAG) {
		echo "<br>Obs date elements: " . $k . " updated of " . $j . " found<br>";
		echo "<br>" . date('h:i:s') . "<br>";
	}
	
	/* Next insert the rest of the events */
	$sql = "select e.visitdate, patientID, short_name, datatype_id, case 
	when datatype_id = 1 then value_numeric
	when datatype_id = 10 then value_boolean
	when datatype_id = 8 then date(value_datetime) end as columnVal 
	from obs o, dw_encounter_snapshot e, concept c 
	where (c.short_name in ('dyspnea','touxGreat2', 'hemoptysie', 'perteDePoid', 'feverLess2', 'feverGreat2',
	'dxTB', 'dxTBA','dxMDRtb','dxMDRtbA', 'tbRegistrationDt',
	'tbClassPulmonaire', 'tbClassExtra', 'tbDxCrachat', 'tbDxXray', 'tbDxClinique',
	'tbStartTreatment', 'tbTestVIH', 'tbArvYN', 'propCotrimoxazole',
	'tbDxNew', 'tbRegistrationDt', 'tbDxXray', 'tbMaladeNew', 'tbMaladeRechute', 'tbMeningite', 'tbGenitale', 'tbPleurale', 
	'tbMiliaire', 'tbGanglionnaire', 'tbIntestinale', 'tbClassOther', 'tbPrestataire') or c.short_name like 'tbRegimen%') and
	c.concept_id = o.concept_id and 
	o.encounter_id = e.encounter_id and 
	concat(o.location_id,o.person_id) = e.patientid and
	e.lastModified >= ' . $lastModified . '";
	if (DEBUG_FLAG) echo "<br>Obs Query2: " . $sql . "<br>";
	$arr = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	$j = 0;
	$k = 0;
	foreach ($arr as $i => $row) {
		if ($row['patientID'] == "" || $row['visitdate'] == "") continue;
		$params = array($row['patientID']);
		if ($row['short_name'] == 'tbStartTreatment' || $row['short_name'] == 'tbRegistrationDt') $params[] = $row['columnVal']; 
		else $params[] = $row['visitdate'];
		switch ($row['short_name'])  {
		case 'tbArvYN':
		case 'tbTestVIH':
		case 'tbDxNew':
			$qry = 'insert into dw_tb_snapshot (patientid, visitdate, ' . $row['short_name'] . ') values (?,?,?) on duplicate key update ' . $row['short_name'] . ' = ?'; 
			$params[] = $row['columnVal'];
			$params[] = $row['columnVal'];
			break;
		default:
			if (substr($row['short_name'],0,9) === 'tbRegimen') $row['short_name'] = 'tbRegimen';
			$qry = 'insert into dw_tb_snapshot (patientid, visitdate, ' . $row['short_name'] . ') values (?,?,1) on duplicate key update ' . $row['short_name'] . ' = 1';
			break;
		}
		$rc = database()->query($qry, $params)->rowCount();
		$j++;
		if ($rc > 0) $k++;
	} 
        if (DEBUG_FLAG) {
		echo "<br>Obs non-date elements: " . $k . " updated of " . $j . " found<br>";
		echo "<br>" . date('h:i:s') . "<br>";
	}


	/* Put lab tests into the snapshot 
	 * notice that xray = 1 is normal, xray = 2 is abnormal; crachat = 1 is positive, crachat = 2 is negative
	 */
	$sql = "select e.visitdate, p.patientID, case 
	     when labid = 137 then 'xray'
	     else 'crachat' end as tbTest,
	     case 
		when labid = 137 then result
		else case when result in ('2', 'neg', 'Negatif') then 2
		else 1 end
	     end as result
	from a_labs p, dw_encounter_snapshot e 
	where e.encounter_id = p.encounter_id and e.dbSite = p.dbSite and 
	(p.result is not null and ltrim(rtrim(p.result)) <> '' and p.result != 0) and
	(testnamefr like '%crachat%' or (labid = 137 and result in (1,2))) and e.lastModified >= ?";
	if (DEBUG_FLAG) echo "<br>Lab Test Query: " . $sql . "<br>";
	$arr = databaseSelect()->query($sql,array($lastModified))->fetchAll(PDO::FETCH_ASSOC); 
	$j = 0;
	$k = 0;
	foreach ($arr as $i => $row) {
		if ($row['patientID'] == "" || $row['visitdate'] == "") continue;
		$qry = 'insert into dw_tb_snapshot (patientid, visitdate, ' . $row['tbTest'] . ') values (?,?,?) on duplicate key update ' . $row['tbTest'] . ' = ?';
		$rc = database()->query($qry, array($row['patientID'],$row['visitdate'],$row['result'],$row['result']))->rowCount();  
		$j++;
		if ($rc > 0) $k++;
	} 
	if (DEBUG_FLAG) {
		echo "<br>Lab test elements: " . $k . " updated of " . $j . " found<br>"; 
		echo "<br>After labs: " . date('h:i:s') . "<br>";
	} 
	
	/* Put prescription records into the snapshot
	 * TODO: open vs. dispensed??? vs. blank (non-encountertype) 
	*/ 
	$sql = "select e.visitdate, p.patientID,
	case when drugid = 13 then 'ethambutol'
	when drugid = 18 then 'isoniazid'
	when drugid = 24 then 'pyrazinamide'
	when drugid = 25 then 'rifampicine'
	when drugid = 30 then 'streptomycine' end as tbDrug 
	from a_prescriptions p, dw_encounter_snapshot e 
	where e.encounter_id = p.encounter_id and 
	e.dbSite = p.dbSite and 
	drugid in (13,18,24,25,30) and
	e.lastModified >= ?"; 
	if (DEBUG_FLAG) echo "<br>Prescriptions Query: " . $sql . "<br>";
	$arr = databaseSelect()->query($sql,array($lastModified))->fetchAll(PDO::FETCH_ASSOC);
	$j = 0;
	$k = 0;
	foreach ($arr as $i => $row) {
		if ($row['patientID'] == "" || $row['visitdate'] == "") continue;
		$qry = 'insert into dw_tb_snapshot (patientid, visitdate, ' . $row['tbDrug'] . ') values (?,?,1) on duplicate key update ' . $row['tbDrug'] . ' = 1';
		$rc = database()->query($qry, array($row['patientID'],$row['visitdate']))->rowCount();  
	       	$j++;
		if ($rc > 0) $k++;
	}
	if (DEBUG_FLAG) {
		echo "<br>Perscription elements: " . $k . " updated of " . $j . " found<br>"; 
		echo "<br>" . date('h:i:s') . "<br>"; 
	}       
}

function tbSlices($key, $orgType, $time_period) {
/***  $indicatorQueries array
 Arg zero is code for type of computation:
     0 - simple, assumes qualification from snapshot table
     1 - percent or ratio, implies both a numerator (value) and a denominator in the record. Non-1 records have zero in the denominator
 Args 1 and 2 are either simple qualifications for calculations or pointers to previous calculations
 The pointers are in the form of subarrays referencing 1 or 2 previously calculated indicators. 
 A pointer array containing 2 indicators always includes an operator (union, join, not) in its third slot, indicating that it is a combination of the two indicator calculations
***/ 

$indicatorQueries = array(
	// cough/dyspnea
	-1 => array(0, " where dyspnea + touxGreat2 > 0", NULL), 
	-2 => array(0, " ,dw_tb_snapshot t where s.dyspnea + s.touxGreat2 > 0 and s.patientid = t.patientid and (t.tbDxCrachat + t.crachat + t.tbEvalresult0 > 0 and s.visitdate <= t.visitdate)", NULL),
	1 => array(1, array(-2), array(-1)), 
               
	// positive test 
	-4 => array(0, " ,dw_tb_snapshot t where s.dyspnea + s.touxGreat2 > 0 and s.patientid = t.patientid and ((t.tbDxCrachat = 1 or t.crachat = 1 or t.tbEvalresult0 = 1) and s.visitdate <= t.visitdate)", NULL),
	2 => array(1, array(-4), array(-2)),
	
         // crachat adult
	-5 => array(0, ", patient p where s.patientid = p.patientid and ((tbClassExtra+tbClassOther+tbMeningite+tbGenitale+tbPleurale+tbMiliaire+tbGanglionnaire+tbIntestinale = 0) and 
	tbDxNew = 1 and (tbDxXray = 1 or tbDxCrachat = 1 or tbClassPulmonaire = 1 or s.patientid in (select patientid from dw_tb_snapshot where crachat > 0 or tbEvalresult0 > 0))) and 
	(dobyy+0 between 1920 and year(now()) and year(s.visitdate)-dobyy > 14)", NULL), 
	-6 => array(0, ", patient p where s.patientid = p.patientid and (tbDxNew = 1 and (tbDxCrachat = 1 or s.patientid in (select patientid from dw_tb_snapshot where crachat = 1 or 
	tbEvalresult0 = 1))) and (dobyy+0 between 1920 and year(now()) and year(s.visitdate)-dobyy > 14)", NULL), 
	3 => array(1, array(-6), array(-5)),

	// crachat child
	-7 => array(0, ", patient p where s.patientid = p.patientid and ((tbClassExtra+tbClassOther+tbMeningite+tbGenitale+tbPleurale+tbMiliaire+tbGanglionnaire+tbIntestinale = 0) and 
	tbDxNew = 1 and (tbDxXray = 1 or tbDxCrachat = 1 or tbClassPulmonaire = 1 or s.patientid in (select patientid from dw_tb_snapshot where crachat > 0 or tbEvalresult0 > 0))) and (dobyy+0 between 1920 and year(now()) and year(s.visitdate)-dobyy < 15)", NULL), 
	-8 => array(0, ", patient p where s.patientid = p.patientid and (tbDxNew = 1 and (tbDxCrachat = 1 or s.patientid in (select patientid from dw_tb_snapshot where crachat = 1 or tbEvalresult0 = 1))) and 
	(dobyy+0 between 1900 and year(now()) and year(s.visitdate)-dobyy < 15)", NULL),
	4 => array(1, array(-8), array(-7)),

        // xray/clinical
	-10 => array(0,", patient p where s.patientid = p.patientid and ((tbClassExtra+tbClassOther+tbMeningite+tbGenitale+tbPleurale+tbMiliaire+tbGanglionnaire+tbIntestinale+tbClassExtra = 0) and 
	tbDxNew = 1 and (tbDxXray + tbClassPulmonaire > 0 ) and s.patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 2)) and (dobyy+0 between 1920 and year(now()) and year(s.visitdate)-dobyy < 15)", NULL),
	5 => array(1, array(-10), array(-5)), 

	// xray/clinical child
	-12 => array(0,", patient p where s.patientid = p.patientid and ((tbClassExtra+tbClassOther+tbMeningite+tbGenitale+tbPleurale+tbMiliaire+tbGanglionnaire+tbIntestinale = 0) and 
	tbDxNew = 1 and (tbDxXray + tbClassPulmonaire > 0 ) and s.patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 2)) and (dobyy+0 between 1900 and year(now()) and year(s.visitdate)-dobyy < 15)", NULL),
	6 => array(1, array(-12), array(-7)),
	 
	// extra pulmonaire
	-13 => array(0,", patient p where s.patientid = p.patientid and tbDxNew = 1 and 
	(tbClassExtra+ tbClassOther+ tbMeningite+tbGenitale+ tbPleurale+tbMiliaire+ tbGanglionnaire+tbIntestinale+ tbClassExtra+ tbClassPulmonaire+tbDxCrachat+tbDxXray > 0 or 
	s.patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 1)) and (dobyy+0 between 1900 and year(now()) and year(s.visitdate)-dobyy > 14)", NULL), 
	-14 => array(0,", patient p where s.patientid = p.patientid and tbDxNew = 1 and (tbClassExtra = 1 or 
	(tbClassExtra+tbClassOther+tbMeningite+tbGenitale+tbPleurale+tbMiliaire+tbGanglionnaire+tbIntestinale+tbClassExtra > 0)) and (tbClassPulmonaire+tbDxCrachat+tbDxXray = 0 and 
	s.patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 <> 1)) and (dobyy+0 between 1900 and year(now()) and year(s.visitdate)-dobyy > 14)", NULL), 
	7 => array(1, array(-14), array(-13)),

	// extra pulmonaire child
	-15 => array(0,", patient p where s.patientid = p.patientid and tbDxNew = 1 and 
	(tbClassExtra + tbClassOther + tbMeningite + tbGenitale + tbPleurale + tbMiliaire + tbGanglionnaire + tbIntestinale + tbClassExtra + tbClassPulmonaire+tbDxCrachat+tbDxXray > 0 or 
	s.patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 1)) and (dobyy+0 between 1900 and year(now()) and year(s.visitdate)-dobyy < 15)", NULL), 
	-16 => array(0,", patient p where s.patientid = p.patientid and tbDxNew = 1 and 
	(tbClassExtra+ tbClassOther+ tbMeningite+ tbGenitale+ tbPleurale+ tbMiliaire+ tbGanglionnaire+ tbIntestinale+ tbClassExtra > 0) and (tbClassPulmonaire+tbDxCrachat+tbDxXray = 0 and 
	s.patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 <> 1)) and (dobyy+0 between 1900 and year(now()) and year(s.visitdate)-dobyy < 15)", NULL),
	8 => array(1, array(-16), array(-15)),
	
	// evaluated in month 2
	-17 => array(0," where tbStartTreatment + tbRegimen > 0 and (tbDxCrachat = 1 or patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 > 0)) ", NULL), 
	//s is baseline, t is slot0, u is slot2 -- visitdate for slot0 must be earlier than slot2
	-18 => array(0," , dw_tb_snapshot t, dw_tb_snapshot u where s.tbStartTreatment + s.tbRegimen > 0 and s.patientid = t.patientid and t.tbEvalResult0 > 0 and u.tbEvalResult2 > 0 and 
	s.patientid = u.patientid and t.visitdate < u.visitdate", NULL),
	9 => array(1, array(-18), array(-17)),
	
	// evaluated in month 3 
	-19 => array(0," , dw_tb_snapshot t, dw_tb_snapshot u where s.tbStartTreatment + s.tbRegimen > 0 and s.patientid = t.patientid and t.tbEvalResult0 > 0 and u.tbEvalResult3 > 0 and 
	s.patientid = u.patientid and t.visitdate < u.visitdate", NULL),
	10 => array(1, array(-19), array(-17)),
	
	// converted in month 2
	-9 => array(0," where tbStartTreatment + tbRegimen > 0 and (tbDxCrachat = 1 or patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 1))", NULL), 
	-20 => array(0," , dw_tb_snapshot t, dw_tb_snapshot u where s.tbStartTreatment + s.tbRegimen > 0 and s.patientid = t.patientid and t.tbEvalResult0 = 1 and u.tbEvalResult2 = 2 and 
	s.patientid = u.patientid and t.visitdate < u.visitdate", NULL),
	11 => array(1, array(-20), array(-9)),
	
	// converted in month 3 
	-21 => array(0," , dw_tb_snapshot t, dw_tb_snapshot u where s.tbStartTreatment + s.tbRegimen > 0 and s.patientid = t.patientid and t.tbEvalResult0 = 1 and u.tbEvalResult3 = 2 and 
	s.patientid = u.patientid and t.visitdate < u.visitdate", NULL),
	12 => array(1, array(-21), array(-9)),   
       
	// cure rate 
	-22 => array(0," where tbStartTreatment + tbRegimen > 0 and tbStopReason = 1 and patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 1)", NULL),
	13 => array(1, array(-22), array(-9)),
	
	// treatment terminated (TPM+)
	-23 => array(0," where tbStartTreatment + tbRegimen > 0 and tbStopReason = 2 and patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 1)", NULL),
	14 => array(1, array(-23), array(-9)),
	
	// treatment terminated (TPM-)
	-50 => array(0," where tbStartTreatment + tbRegimen > 0 and patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 2)", NULL), 		
	-24 => array(0," where tbStartTreatment + tbRegimen > 0 and tbStopReason = 2 and patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 2)", NULL),
	15 => array(1, array(-24), array(-50)),
	
	// success rate
	-25 => array(0," where tbStartTreatment + tbRegimen > 0 and tbStopReason in (1,2) and patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 1)", NULL),
	16 => array(1, array(-25), array(-9)),
	
	// failure rate
	-26 => array(0," where (tbStartTreatment + tbRegimen > 0 and patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 1)) and (tbStopReason = 4 or 
	patientid in (select patientid from dw_tb_snapshot where tbEvalResult5 = 1 or tbEvalResultFin = 1))", NULL),
	17 => array(1, array(-26), array(-9)), 
	
	// treatment abandoned
	-27 => array(0," where tbStartTreatment + tbRegimen > 0 and patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 1) and tbStopReason = 8", NULL),
	18 => array(1, array(-27), array(-9)), 
	
	// death
	-28 => array(0," where tbStartTreatment + tbRegimen > 0 and patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 1) and tbStopReason = 32", NULL),
	19 => array(1, array(-28), array(-9)), 
	
	// transferred
	-29 => array(0," where tbStartTreatment + tbRegimen > 0 and patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 1) and tbStopReason = 16", NULL),
	20 => array(1, array(-29), array(-9)),
	
	// tested for HIV 
	-30 => array(0," where tbTestVIH > 0 and (tbDxNew + tbDxXray + tbDxCrachat + tbClassPulmonaire > 0 or patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 1))", NULL),
	-31 => array(0," where tbTestVIH > 1 and (tbDxNew + tbDxXray + tbDxCrachat + tbClassPulmonaire > 0 or patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 1))", NULL),
	21 => array(1, array(-31), array(-30)), 
	
	// HIV TB patients
	-32 => array(0," where tbTestVIH = 4 and (tbDxNew + tbDxXray + tbDxCrachat + tbClassPulmonaire > 0 or patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 1))", NULL),
	22 => array(1, array(-32), array(-31)), 
	
	// cotrimoxazole
	-33 => array(0," where tbTestVIH = 4 and propCotrimoxazole = 1 and (tbDxNew + tbDxXray + tbDxCrachat + tbClassPulmonaire > 0 or patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 1))", NULL),
	23 => array(1, array(-33), array(-32)),
	
	// on ARVs
	-34 => array(0," where tbTestVIH = 4 and tbArvYN = 1 and (tbDxNew + tbDxXray + tbDxCrachat + tbClassPulmonaire > 0 or patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 1))", NULL),
	24 => array(1, array(-34), array(-32)),
	
	// new cases of all types over total population seen
	-35 => array(0,", encValidAll e where s.patientid = e.patientid", NULL),
	-36 => array(0," where tbDxNew = 1", NULL),
	25 => array(1, array(-36), array(-35)),
               
	// new cases of TPM+ (pulmonare)
	-37 => array(0," where tbDxNew = 1 and (tbDxCrachat = 1 or s.patientid in (select patientid from dw_tb_snapshot where crachat = 1 or tbEvalresult0 = 1))", NULL),  
	26 => array(1, array(-37), array(-35)), 
	
	// cases of meningitis tb among children < 60 months over total population seen
	-38 => array(0,", patient p, encValidAll e where s.patientid = e.patientid and s.patientid = p.patientid and (dobyy+0 between 1900 and year(now()) and datediff(s.visitdate, ymdtodate(dobyy,dobmm,dobdd))/30 < 60)", NULL), 
	-39 => array(0, ", patient p where s.patientid = p.patientid and s.tbMeningite = 1 and (dobyy+0 between 1900 and year(now()) and datediff(s.visitdate, ymdtodate(dobyy,dobmm,dobdd))/30 < 60)", NULL),
	27 => array(1, array(-39), array(-38)),
	
	// deaths among those treated (same as 19)
	28 => array(1, array(-28), array(-9)),
	
// B. Status
	// 1. # of new cases  Nouveau Diagnostiques : Patients ayant recu leur diagnostique au cours de la periode.
	29 => array(0, " where tbDxNew = 1", NULL),
	// 2. # started treatment Nouveaux traitement : Patients ayant initie leur traitement au cours de la periode.
	30 => array(0, " where tbStartTreatment + tbRegimen > 0", NULL),
	/* 3. # treatment terminated Traitement complete : a patient who completed treatment but did not meet the criteria for cure or failure.
	 * Applies to pulmonary smear-positive,smear negative and extra pulmonary cases.
	 */
	31 => array(0, " where tbStopReason = 2 ", NULL),
	// 4. # cured Gueri : a patient who was initially smear-positive and who was smear-negative in the last month of treatment and on at least one previous occasion.
	32 => array(0, " where tbStopReason = 1 ", NULL),

// C. Rapports qualite de soins
	// 1. Rappels de redez-vous mensuel Report of upcoming visits all tb patients in the next 4 weeks 
	33 => array(0," , encValidAll e where tbDxNew + tbDxXray + tbDxCrachat + tbClassPulmonaire > 0 and s.patientid = e.patientid and s.visitdate = e.visitdate and 
	isdate(ymdtodate(e.nxtVisitYy, e.nxtVisitMm,e.nxtVisitDd)) = 1 and datediff(ymdtodate(e.nxtVisitYy, e.nxtVisitMm,e.nxtVisitDd),e.visitdate) <= 28",NULL), 
	/* 2. Rappel d'analyses de laboratoire   tb patients who never had a sputum test
	 Nouveau diagnostic or suivi checked and mois 0 empty 
	 */
	34 => array(0, " where tbDxNew + tbDxXray + tbDxCrachat + tbClassPulmonaire > 0 and patientid not in (select patientid from dw_tb_snapshot where tbEvalResult0 > 0 or crachat > 0)", NULL), 
	/* 3. Rappel d'analyses de laboratoire  (had 0 but not 2)
	 */
	-136 => array(0, " where s.tbEvalResult0 > 0", NULL),
	-135 => array(0, " , dw_tb_snapshot t where s.patientid = t.patientid and s.tbEvalResult0 > 0 and t.tbEvalResult2 > 0 and s.visitdate < t.visitdate", NULL),
	35 => array(1, array(-135), array(-136)),
	/* 4. Rappel d'analyses de laboratoire  (had 2 but not 3)
	 */ 
	-138 => array(0, " where s.tbEvalResult2 > 0", NULL),
	-137 => array(0, " , dw_tb_snapshot t where s.patientid = t.patientid and s.tbEvalResult2 > 0 and t.tbEvalResult3 > 0 and s.visitdate < t.visitdate", NULL),
	36 => array(1, array(-137), array(-138)), 
	/* 5. Rappel d'analyses de laboratoire  (had 3 but not 5)
	 */
	-140 => array(0, " where s.tbEvalResult3 > 0", NULL),
	-139 => array(0, " , dw_tb_snapshot t where s.patientid = t.patientid and s.tbEvalResult3 > 0 and t.tbEvalResult5 > 0 and s.visitdate < t.visitdate", NULL),
	37 => array(1, array(-139), array(-140)),
	/* 6. Rappel d'analyses de laboratoire  (had 5 but not Fin)
	 */ 
	-142 => array(0, " where s.tbEvalResult5 > 0", NULL),
	-141 => array(0, " , dw_tb_snapshot t where s.patientid = t.patientid and s.tbEvalResult5 > 0 and t.tbEvalResultFin > 0 and s.visitdate < t.visitdate", NULL),
	38 => array(1, array(-141), array(-142)), 
	/* 7. no xray  */
	39 => array(0, " where tbDxNew > 0 and patientid not in (select patientid from dw_tb_snapshot where xray > 0)", NULL),  
	/* 8. cough/dyspnea and sputum ordered 
	 *  Liste de (SR) > 2 semaines ayant initie examens de crachat diagnostiques
	 */
	40 => array(0, array(-1), NULL), 
	/* 9. cough/dyspnea and 3rd sputum not completed 
	 *  Liste de (SR) > 2 semaines n'ayant pas complete 3 examens de crachat diagnostiques
	 */
	41 => array(0, " , encounter e where e.patientid = s.patientid and tbDxNew > 0 and (dyspnea = 1 or touxGreat2 = 1) and e.encountertype > 23 and s.patientid not in 
	(select patientid from dw_tb_snapshot where tbEvalResult3 > 0)", NULL),
	/* 10. cough/dyspnea and positive sputum never ordered 
	 *  Liste de (SR) > 2 semaines n'ayant pas beneficie d'examens de crachat diagnostiques
	 */
	-143 => array(0, "  where dyspnea + touxGreat2 > 0 and s.patientid not in (select patientid from dw_tb_snapshot where tbEvalResult0 + crachat + tbDxCrachat > 0)", NULL),
	42 => array(1, array(-143), array(-1)), 
	/* 11. Pulmonary Tb patients with positive sputum 
	 *  Liste de patients TPM+
	 */
	43 => array(0, " where tbDxNew > 0 and tbDxCrachat = 1 and s.patientid in (select patientid from dw_tb_snapshot where tbEvalResult0 = 1)", NULL),
	/* 12. Pulmonary Tb patients without Crachat Dx and with other Dx 
	 *  Liste de patients TPM+
	 */ 
	-145 => array(0, " where tbClassExtra+tbClassOther+tbMeningite+tbGenitale+tbPleurale+tbMiliaire+tbGanglionnaire+tbIntestinale = 0 and tbDxXray + tbDxCrachat + tbClassPulmonaire > 0", NULL), 
	-144 => array(0, " where tbClassExtra+tbClassOther+tbMeningite+tbGenitale+tbPleurale+tbMiliaire+tbGanglionnaire+tbIntestinale = 0 and tbDxXray + tbDxCrachat + tbClassPulmonaire > 0 and 
	s.patientid in (select patientid from dw_tb_snapshot where crachat = 1 or tbEvalresult0 = 1)", NULL),
	44 => array(1, array(-144), array(-145)),

// D. HealthQual (indicators)
	/* 1. Pourcentage de patients Diagnostique TB ayant inite leur traitement leur dans un mois suivant le diagnostique
	 *    Population of TB patients who started treatment in a 30 days period after being diagnosed.
	 */
	-40 => array(0, "where s.tbDxNew > 0 and s.tbRegistrationDt+s.tbClassPulmonaire+s.tbClassExtra+s.tbDxCrachat+s.tbDxXray+s.tbDxClinique > 0", NULL),
	-41 => array(0, ",dw_tb_snapshot t where s.tbDxNew > 0 and s.tbRegistrationDt+s.tbClassPulmonaire+s.tbClassExtra+s.tbDxCrachat+s.tbDxXray+s.tbDxClinique > 0 and 
	s.patientid = t.patientid and t.tbStartTreatment + t.tbRegimen > 1 and datediff(t.visitdate,s.visitdate) between 0 and 30", NULL),
	45 => array(1,array(-41),array(-40)), 
	/* 2. Pourcentage de patients TB TPM+ places sous traitement ayant eu leur crachat de controle.
	 *    Population of pulmonary TB patients with a positive sputum who are receiving treatment and had a followup sputum done.
	 */
	-42 => array(0, " , dw_tb_snapshot t where (s.tbDxCrachat = 1 or (s.patientid = t.patientid and t.tbEvalResult0 > 0 and s.visitdate <  t.visitdate)) and s.tbStartTreatment + s.tbRegimen > 0", NULL),
	-43 => array(0, ",dw_tb_snapshot t, dw_tb_snapshot u where (s.tbDxCrachat = 1 or (s.patientid = t.patientid and t.tbEvalResult0 > 0 and s.visitdate <  t.visitdate)) and 
	s.tbStartTreatment + s.tbRegimen > 0 and s.patientid = u.patientid and u.tbEvalResult2 + u.tbEvalResult3 + u.tbEvalResult5 + u.tbEvalResultFin > 0 and s.visitdate < u.visitdate", NULL),
	46 => array(1,array(-43),array(-42)), 
	/* 3. Pourcentage de symptomatique respiratoire (SR) > 2 semaine ayant beneficie d'un examen de crachat diagnostique.
	 *    Population of patients with respiratory problems who had a sputum ordered.
	 */
	-44 => array(0, ",dw_tb_snapshot t where s.patientid = t.patientid and s.dyspnea + s.touxGreat2 > 0 and t.crachat + t.tbEvalResult0 > 0 and s.visitdate < t.visitdate", NULL),
	47 => array(1,array(-44),array(-1)),
// E. Statistiques de services
	/*
	 * 1. Nombre de symptomatiques respiratoires identifies
	 *    Count of patients with respiratory problems.
	 */
	48 => array(0,array(-1),NULL),
	/* 2. Nombre de symptomatiques respiratoires (SR) ayant beneficie d/examens de crachat diagnostique.
	 *    Count of patients with respiratory problems who had a sputum done.
	 */
	49 => array(0,array(-44),NULL),
	/* 3. Nombre de symptomatiques respiratoires (SR) avec resultats de crachats diagnostique positif.
	 *    Count of patients with respiratory problems who had a positive sputum.
	 */
	50 => array(0,array(-4),NULL),
	/* 4. Nombre de SR avec resultat de crachat diagnostique negative.
	 *    Count of patients with respiratory problems who had a negative sputum. 
	 */
	51 => array(0,",dw_tb_snapshot t where s.dyspnea + s.touxGreat2 > 0 and s.patientid = t.patientid and (t.crachat = 2 or (t.tbEvalResult0 = 2 and s.visitdate < t.visitdate))",NULL),
	/* 5. Taux de detection = Nombre TB+ / Nombre teste pur TB.
	 *    Patients with positive TB Dx / Patients who had a sputum done.
	 */
	-48 => array(0," where s.tbDxCrachat + s.crachat + s.tbEvalResult0 > 0", NULL),
	-49 => array(0," where s.crachat = 1 or s.tbEvalResult0 = 1", NULL),
	52 => array(1,array(-49),array(-48)),
	/* 6. Nombre de patient diagnostique TB--Pulmonaire.
	 *    Patients with a pulmonary TB Dx
	 */
	53 => array(0," where tbDxNew = 1 and (tbDxXray + tbDxCrachat + tbClassPulmonaire > 0 or s.patientid in (select patientid from dw_tb_snapshot where crachat > 0 or tbEvalresult0 > 0)) and 
	tbClassExtra+tbClassOther+tbMeningite+tbGenitale+tbPleurale+tbMiliaire+tbGanglionnaire+tbIntestinale = 0",NULL),
	/* 7. Nombre de patient diagnostique TB--non-pulmonaire.
	 *    Patients with a non-pulmonary TB Dx 
	 */
	54 => array(0," , dw_tb_snapshot t where s.tbClassExtra+s.tbClassOther+s.tbMeningite+s.tbGenitale+s.tbPleurale+s.tbMiliaire+s.tbGanglionnaire+s.tbIntestinale > 0 and s.tbClassPulmonaire+s.tbDxCrachat+s.tbDxXray = 0 and 
	s.patientid = t.patientid and t.tbEvalResult0 <> 1 and s.visitdate <= t.visitdate",NULL),
	/* 8. Nombre de diagnostique etabli par clinique, crachats, xray.
	 *    Patients diagnosed by clinical impression , sputum or xray.
	 */
	55 => array(0," where tbDxNew > 0 and tbDxCrachat + tbDxXray + tbDxClinique > 0",NULL),
	/* 9. Nombre de patients diagnostique TB pulmonaire avec crachats positif.
	 *    Pulmonary TB patients with a positive sputum.
	 */
	56 => array(0," where tbDxNew > 0 and (tbDxCrachat = 1 or tbEvalResult0 = 1 or crachat = 1)",NULL),
	/* 10. Nombre de patients diagnostique TB pulmonaire avec crachats negatif.
	 *     Pulmonary TB patients with a negative sputum.
	 */
	57 => array(0," ,dw_tb_snapshot t where s.tbDxXray + s.tbClassPulmonaire > 0 and 
	s.tbClassExtra + s.tbClassOther + s.tbMeningite + s.tbGenitale + s.tbPleurale + s.tbMiliaire + s.tbGanglionnaire + s.tbIntestinale = 0 and 
	s.patientid = t.patientid and (t.tbEvalResult0 = 2 or t.crachat = 2) and s.visitdate <= t.visitdate",NULL),

	/* 11. Nombre de patients diagnostique TB pulmonaire sans crachat.
	 *     Pulmonary TB patients with no sputum test.
	 */
	58 => array(0," where tbDxNew = 1 and tbDxCrachat = 0 and tbDxXray + tbClassPulmonaire > 0 and patientid not in (select patientid from dw_tb_snapshot where crachat + tbEvalresult0 > 0) and 
	tbClassExtra+tbClassOther+tbMeningite+tbGenitale+tbPleurale+tbMiliaire+tbGanglionnaire+tbIntestinale = 0",NULL),

	/* 12. Nombre de patient TB place sous traitement--Nouveau.
	 *
	 */
	59 => array(0," where tbDxNew = 1 and tbRegimen + tbStartTreatment > 0",NULL),

	/* 13. relapsed patients.
	 *
	 */
	60 => array(0," where tbRegimen + tbStartTreatment > 0 and tbMaladeRechute = 1 ",NULL), 

	/* 14. not receiving treatment.
	 *
	 */
	61 => array(0, array(-26),NULL),

	/* 15. failed treatment.
	 *
	 */
	62 => array(0," where tbRegimen + tbStartTreatment > 0 and tbMaladeRechute = 1 ",NULL),

	/* 16. Nombre de patient TB place sous traitement--Rechute.
	 *
	 */
	63 => array(0," ,dw_tb_snapshot t where s.tbRegistrationDt = 1 and s.patientid = t.patientid and t.crachat = 0 and t.tbEvalResult0 = 0 and datediff(t.visitdate,s.visitdate) > 180 ",NULL),
);

	if (DEBUG_FLAG) echo "<br>Generate Patient Lists start: " . date('h:i:s') . "<br>";
	// store the patientid lists; don't need any reference to org, since pid contains site info
	foreach ($indicatorQueries as $indicator => $query) {
		foreach ($time_period as $period) {
			if ($period == "Week") $period_value = $period . "(s.visitdate,2) ";
			else $period_value = $period . "(s.visitdate) ";
			if (!is_array($query[1])) {
				if ($query[0] == 0) {
					$sql = "insert into dw_tb_patients 
					select distinct " . $indicator . ",?, year(s.visitdate), " . $period_value . ", s.patientid from dw_tb_snapshot s " . $query[1]; 
				} else {  // $query[0] == -1 (for general population)
					$sql = "insert into dw_tb_patients 
					select distinct " . $indicator . ",?, year(s.visitdate), " . $period_value . ", s.patientid from encValidAll s" . $query[1]; 
				}
				$insArray = array($period);
				//if ($indicator == -44) $insArray[] = 'Recherche de BARR%';
				$rc = database()->query($sql,$insArray)->rowCount();
				if (DEBUG_FLAG) echo "<br>Generate Pid List for: " . $indicator . " :" . $sql . " Rows inserted: " . $rc . "<br>"; 
			} else { 
				// anytime $query[1] isn't simple, previous calculations can be used
				generatePidLists("tb", $indicator, $query[1], $period);
			}  
		} 
	}	 
	if (DEBUG_FLAG) echo "<br>Generate Patient Lists end/Indicator slices start: " . date('h:i:s') . "<br>";
	// store the indicators     
	foreach ($indicatorQueries as $indicator => $query) {
		if ($indicator < 1) continue;  // don't need slices for these
		$org_unit = 'Sitecode';
                $org_value = 't.location_id'; 
		switch ($query[0]) {
		case 0: // simple calculation
			$sql = "insert into dw_tb_slices select ?, " . $org_value . ", " . $indicator . ", time_period, year, period, t.sex, count(distinct p.patientid), 0 
			from dw_tb_patients p, patient t where indicator = " . $indicator . " and p.patientid = t.patientid and t.sex in (1,2) group by 1,2,3,4,5,6,7"; 
			$rc = database()->query($sql, array($org_unit))->rowCount();
			if (DEBUG_FLAG) {
				echo "<br>Generate simple slices for: " . $indicator . " :" . $sql . " Rows inserted: " . $rc . "<br>"; 
				print_r ($argArray);
			} 
			break;
		case 1: // percent
			//generatePercents('tb', $indicator, $org_unit, $org_value, $query);
			break;
		} 
	}  
	generatePercents('tb');
	if (DEBUG_FLAG) echo "<br>Indicator slices end: " . date('h:i:s') . "<br>";       	
}
?>