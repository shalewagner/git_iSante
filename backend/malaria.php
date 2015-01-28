<? 
function updateMalariaSnapshot($lastModified) {
	/* Put obs table records into the snapshot 
	 * Latest results (02/11/2014) for rapid result malaria testing in the primary care forms:
	select value_numeric, count(*) from obs o, concept c where o.concept_id = c.concept_id and short_name = 'malariaResultRapid' group by 1;
	+---------------+----------+
	| value_numeric | count(*) |
	+---------------+----------+
	|             1 |       21 |  positive
	|             2 |        1 |  negative
	+---------------+----------+
	*/
	$sql = "select e.visitdate, patientID, short_name, o.value_numeric 
	from obs o, dw_encounter_snapshot e, concept c 
	where c.short_name in (
	'malariaDxA', 'malariaDx', 'malariaDxG', 'malariaDxSuspectedA', 'malariaDxSuspected', 'malariaDxSuspectedG', 
	'sym_malariaLT', 'sym_malariaGT', 'feverLess2', 'feverGreat2', 'convulsion', 'lethargy', 'hematuria', 'ictere', 
	'anemia', 'anemiaA', 'anemiaG', 'malariaTest', 'malariaTestRapid', 'malariaResultRapid', 'hospitalisation' ) and
	c.concept_id = o.concept_id and 
	o.encounter_id = e.encounter_id and 
	concat(o.location_id,o.person_id) = e.patientid and
	o.value_boolean is true and
	e.lastModified >= ?";
	if (1 == 1) echo "\nObs Query: " . $sql . "\n";
	$arr = databaseSelect()->query($sql,array($lastModified))->fetchAll(PDO::FETCH_ASSOC);
	$j = 0;
	$k = 0;
	foreach ($arr as $i => $row) {
		if ($row['patientID'] == "" || $row['visitdate'] == "") continue;
		if ($row['short_name'] == 'malariaResultRapid') {
			if ($row['value_numeric'] == 1) $row['short_name'] = 'rapidResultNegative';
			else if ($row['value_numeric'] == 2) $row['short_name'] = 'rapidResultPositive';
			else continue;  
		}
		$qry = 'insert into dw_malaria_snapshot (patientid, visitdate, ' . $row['short_name'] . ') values (?,?,1) on duplicate key update ' . $row['short_name'] . ' = 1';
		$rc = database()->query($qry, array($row['patientID'],$row['visitdate']))->rowCount();
		$j++;
		if ($rc > 0) $k++;
	} 
        if (1 == 1) {
		echo "\nObs elements: " . $k . " updated of " . $j . " found\n";
		echo "\n" . date('h:i:s') . "\n";
	}
	/* Put prescription records into the snapshot
	 * TODO: open vs. dispensed??? vs. blank (non-encountertype) 
	*/ 
	$sql = "select e.visitdate, p.patientID, 
	case when drugid = 60 then 'chloroquine' 
	when drugid = 62 then 'quinine' 
	when drugid = 85 then 'primaquine' end as malariaDrug 
	from a_prescriptions p, dw_encounter_snapshot e 
	where e.encounter_id = p.encounter_id and 
	e.dbSite = p.dbSite and 
	drugid in (60,62,85) and
	e.lastModified >= ?"; 
	if (1 == 1) echo "\nPrescriptions Query: " . $sql . "\n";
	$arr = databaseSelect()->query($sql,array($lastModified))->fetchAll(PDO::FETCH_ASSOC);
	$j = 0;
	$k = 0;
	foreach ($arr as $i => $row) {
		if ($row['patientID'] == "" || $row['visitdate'] == "") continue;
		$qry = 'insert into dw_malaria_snapshot (patientid, visitdate, ' . $row['malariaDrug'] . ') values (?,?,1) on duplicate key update ' . $row['malariaDrug'] . ' = 1';
		$rc = database()->query($qry, array($row['patientID'],$row['visitdate']))->rowCount();  
	       	$j++;
		if ($rc > 0) $k++;
	}
	if (1 == 1) {
		echo "\nPrescription elements: " . $k . " updated of " . $j . " found\n"; 
		echo "\n" . date('h:i:s') . "\n"; 
	}  
	/* Put condition records into the snapshot (HIV form malaria diagnoses)
	 * TODO: adult vs. pediatric conditionids 
	 */
	$j = 0;
	$k = 0; 
	$sql = "select case when isdate(ymdtodate(conditionyy,conditionmm,'01')) = 1 then ymdtodate(conditionyy,conditionmm,'01') else ymdtodate(c.visitdateyy,c.visitdatemm,c.visitdatedd) end as visitdate, c.patientID, 
	case when (conditionActive IN (1,4,5) AND encounterType IN (16,17)) OR (conditionActive IN (1,4,5) AND encounterType IN (1,2)) OR (conditionActive = 1 AND encounterType IN (24,25)) and conditionid in (45,335,717) then 'malariaDx' 
	when (conditionActive in (2,6) AND encounterType IN (16,17)) OR (conditionActive not IN (1,4,5) AND encounterType IN (1,2)) OR (conditionActive <> 1 AND encounterType IN (24,25)) and conditionid in (45,335,717) then 'malariaDxG' 
	when (conditionActive IN (1,4,5) AND encounterType IN (16,17)) OR (conditionActive IN (1,4,5) AND encounterType IN (1,2)) OR (conditionActive = 1 AND encounterType IN (24,25)) and conditionid = 716 then 'malariaDxSuspected'
	when (conditionActive in (2,6) AND encounterType IN (16,17)) OR (conditionActive not IN (1,4,5) AND encounterType IN (1,2)) OR (conditionActive <> 1 AND encounterType IN (24,25)) and conditionid = 716 then 'malariaDxSuspectedG' 
	else '' end as 'dxColumn'
	from a_conditions c, dw_encounter_snapshot e 
	where e.encounter_id = c.encounter_id and 
	e.dbSite = c.dbSite and 
	c.conditionID in (45,335,716,717) and
	e.lastModified >= ?"; 
	if (1 == 1) echo "\nHIV Conditions Query: " . $sql . "\n"; 
	$arr = databaseSelect()->query($sql,array($lastModified))->fetchAll(PDO::FETCH_ASSOC); 
	$j = 0;
	$k = 0;
	foreach ($arr as $i => $row) {
		if ($row['patientID'] == "" || $row['visitdate'] == "" || $row['dxColumn'] == "") continue;
		$qry = 'insert into dw_malaria_snapshot (patientid, visitdate, ' . $row['dxColumn'] . ') values (?,?,1) on duplicate key update ' . $row['dxColumn'] . ' = 1';
		$rc = database()->query($qry, array($row['patientID'],$row['visitdate']))->rowCount();  
		$j++;
		if ($rc > 0) $k++;
	}
	if (1 == 1) {
		echo "\nHIV Form Condition elements: " . $k . " updated of " . $j . " found\n"; 
		echo "\n" . date('h:i:s') . "\n"; 
	} 
	/* Put lab orders/results into the snapshot
	 */
	$sql = "select distinct p.visitdate as visitdate, p.patientID
		from a_labs p, dw_encounter_snapshot e 
		where e.encounter_id = p.encounter_id and e.dbSite = p.dbSite 
		and labid in ( 132, 173, 1208, 1209, 1210, 1211, 1559, 1560, 1610, 1613) and e.lastModified >= ?";
	if (1 == 1) echo "\nLab orders Query: " . $sql . "\n";		
	$arr = databaseSelect()->query($sql,array($lastModified))->fetchAll(PDO::FETCH_ASSOC); 
	$j = 0;
	foreach ($arr as $i => $row) {
		if ($row['patientID'] == "" || $row['visitdate'] == "") continue;
		$qry = 'insert into dw_malaria_snapshot (patientid, visitdate, testsOrdered) values (?,?,1) on duplicate key update testsOrdered = 1';
		$rc = database()->query($qry, array($row['patientID'],$row['visitdate']))->rowCount();  
		$j++;
	} 
	if (1 == 1) {
		echo "\nLab orders: " . $j . " found\n"; 
		echo "\nAfter lab orders: " . date('h:i:s') . "\n";
	} 
	
	/* Put lab tests with results into the snapshot
	 * Latest counts (04/09/2014) of the various test results for malaria 
	 * +---------------------+----------+
	| testtype            | count(*) |
	+---------------------+----------+
	| rapidResultNegative |    12900 | 
	| rapidResultPositive |      226 | 
	| smearResultNegative |      177 | 
	| smearResultPositive |      277 | 
	+---------------------+----------+ 
	 */
	$sql = "select e.visitdate, p.patientID, p.labID as labid, p.testNameFr as testNameFr, p.result, p.result2, p.result3, 
	case when labid = 173 then
	        case when result = 1 then 'smearResultPositive' when result = 2 then 'smearResultNegative' else 'notMalariaTest' end
	when labid = 132 then
	        case when result = 1 then 'rapidResultPositive' when result = 2 then 'rapidResultNegative' else 'notMalariaTest' end 
	when labid in (1208,1209,1210,1211,1559) then
	        case when result not like '%neg%' or result like '%+%' then 'smearResultPositive' else 'smearResultNegative' end
	when labid in (1560,1610,1613) then
	        case when result not like '%neg%' or result like '%+%' then 'rapidResultPositive' else 'rapidResultNegative' end
	else
	       'notMalariaTest'
	end as 'testType'
	from a_labs p, dw_encounter_snapshot e 
	where e.encounter_id = p.encounter_id and e.dbSite = p.dbSite and p.result is not null and ltrim(rtrim(p.result)) <> '' and p.result not in ('0','8') and 
	p.labid in (132,173,1208,1209,1210,1211,1559,1560,1610,1613) and e.lastModified >= ?";
	if (1 == 1) echo "\nLab Test Query: " . $sql . "\n";		
	$arr = databaseSelect()->query($sql,array($lastModified))->fetchAll(PDO::FETCH_ASSOC); 
	$i = 0;
	$j = 0;
	$k = 0;
	$l = 0;  
	foreach ($arr as $i => $row) {
		if ($row['patientID'] == "" || $row['visitdate'] == "" || $row['testNameFr'] == "") continue;
		if ($row['testType'] != "notMalariaTest") {
			$qry = 'insert into dw_malaria_snapshot (patientid, visitdate, ' . $row['testType'] . ') values (?,?,1) on duplicate key update ' . $row['testType'] . ' = 1';
			$rc = database()->query($qry, array($row['patientID'],$row['visitdate']))->rowCount(); 
			switch ($row['testType']) {
				case 'rapidResultNegative': 
					$i++;
					break;
				case 'rapidResultPositive':
					$j++;
					break;
				case 'smearResultNegative':
					$k++;
					break;
				case 'smearResultPositive':
					// figure out which organisms might be checked 
					if ($row['labid'] == '173' && $row['result2'] > 0) 
						$l = isanteOrganisms($l, $row['patientID'],$row['visitdate'],$row['result2']);
					if (in_array($row['labid'], array(1208,1209,1210,1211,1559))) 
						$l = openElisOrganisms($l, $row['patientID'],$row['visitdate'],$row['labid']);
					$l++;
					break; 
			} 
		}
	} 
	if (1 == 1) {
		echo "\nRapid negative: " . $i . "\n"; 
		echo "\nRapid positive: " . $j . "\n";
		echo "\nSmear negative: " . $k . "\n";
		echo "\nSmear positive: " . $l . "\n";
		echo "\nTotal results : " . $i+$j+$k+$l . "\n";
								
		echo "\nAfter labs: " . date('h:i:s') . "\n";
	}
	
	/* Put vitals temp records into the snapshot 
         */ 
        $sql = "select ymdtodate(visitdateyy,visitdatemm,visitdatedd) as visitdate, patientID, 
        1 as highTemp from vitals where (replace(replace(vitalTemp,',','.'),'..','.')+0 > 37.5 and vitalTempUnits = 1) or 
        (replace(replace(vitalTemp,',','.'),'..','.')+0 > 99.5 and vitalTempUnits = 2)"; 
        if (1 == 1) echo "\nVital Temp Query: " . $sql . "\n";
        $arr = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $j = 0;
        $k = 0;
        foreach ($arr as $i => $row) {
        	if ($row['patientID'] == "" || $row['visitdate'] == "") continue;
        	$qry = 'insert into dw_malaria_snapshot (patientid, visitdate, highTemp) values (?,?,1) on duplicate key update highTemp = 1';
        	$rc = database()->query($qry, array($row['patientID'],$row['visitdate']))->rowCount();  
               	$j++;
        	if ($rc > 0) $k++;
        }
        if (1 == 1) {
        	echo "\nhigh temp elements: " . $k . " updated of " . $j . " found\n"; 
        	echo "\n" . date('h:i:s') . "\n"; 
        }
	
	// pregnancy 
	$retVal = database()->query("update dw_malaria_snapshot a, dw_pregnancy_ranges p set isPregnant = 1 
	where a.patientid = p.patientid and a.visitdate between p.startdate and p.stopdate")->rowCount(); 
	if (1 == 1) {
		echo "\nFound " . $retVal . " rows where patients were pregnant";
	}
	 
	/* get rid of any snapshot records where patient either isn't suspected or confirmed and has not had any treatments or tests 
	$sql = "drop table if exists nonMalaria; create table nonMalaria select distinct patientid from dw_malaria_snapshot where malariaDx = 0 and malariaDxA = 0 and malariaDxG = 0 and malariaDxSuspected = 0 and malariaDxSuspectedA = 0 and malariaDxSuspectedG = 0 and rapidResultPositive = 0 and rapidResultNegative = 0 and smearResultPositive = 0 and smearResultNegative = 0 and malariaTest = 0 and malariaTestRapid = 0 and chloroquine = 0 and quinine = 0 and primaquine = 0; create index pnon on nonMalaria (patientid); delete from dw_malaria_snapshot where patientid in (select patientid from nonMalaria)";
	$rc = database()->query($sql)->rowCount();
	if (1 == 1) {
		echo "\nEliminate stray patients query: " . $sql . " Rows removed: " . $rc . "\n";
		echo "\n" . date('h:i:s') . "\n"; 
	}  */        
}

function isanteOrganisms ($l, $pat, $vd, $val) {
        $binArray = array(1 => 'FT',2 => 'FG',4 => 'Vx', 8 => 'Ov', 16 => 'Mai');
	$binstring = strrev (decbin ($val)); 
        foreach ($binArray as $bin => $org) {
		$retVal = (!empty ($binstring{log ($bin, 2)}) && $binstring{log ($bin, 2)} == 1) ? 1 : 0;
		if ($retVal) { 
			//if (1 == 1) echo "Val: " . $val . " Bin: " . $bin . " Org: " . $org . "\n";
			$qry = 'insert into dw_malaria_snapshot (patientid, visitdate, ' . $org . ') values (?,?,1) on duplicate key update ' . $org . ' = 1';
			$rc = database()->query($qry, array($pat,$vd))->rowCount();
			$l++;
		} 
	} 
	return $l;
}

function openElisOrganisms($l, $pat, $vd, $labid) {
	$binArray = array(1559 => 'FT', 1208 => 'FG', 1209 => 'Vx', 1210 => 'Ov', 1211 => 'Mai'); 
	//if (1 == 1) echo "Pat: " . $pat . " Labid: " . $labid . " Org: " . $binArray[$labid] . "\n";
	$qry = 'insert into dw_malaria_snapshot (patientid, visitdate, ' . $binArray[$labid] . ') values (?,?,1) on duplicate key update ' . $binArray[$labid] . ' = 1';
	$rc = database()->query($qry, array($pat,$vd))->rowCount();
	return $l + $rc;
} 

function malariaSlices($key, $orgType, $time_period) {
/***  $indicatorQueries array
 Arg zero is code for type of computation:
     0 - simple, implies no item two
     1 - percent or ratio, implies both a numerator (value) and a denominator in the record. Non-1 records have zero in the denominator
     2 - "among" calculation, implies two or more separate queries combined together
 Args 1 and 2 are either simple qualifications for calculations or pointers to previous calculations
 The pointers are in the form of subarrays referencing 1 or 2 previously calculated indicators. 
 A pointer array containing 2 indicators always includes an operator (union, join, not) in its third slot, indicating that it is a combination of the two indicator calculations
***/ 

$indicatorQueries = array( 
"-1"=> array(0, "where 1=1", NULL), 
" 1"=> array(1, "where feverLess2+highTemp > 0", array(-1)),
" 2"=> array(1, "where patientid in (select patientid from dw_malaria_snapshot where malariaDx+malariaDxA+rapidResultPositive+smearResultPositive = 0) and chloroquine+primaquine+quinine > 0 and feverLess2+highTemp > 0", array(1)), 
"-5"=> array(0, "where chloroquine+primaquine = 2 and malariaDx+malariaDxA+rapidResultPositive+smearResultPositive > 0", NULL),
" 5"=> array(0, "where malariaDx+malariaDxA+rapidResultPositive+smearResultPositive > 0", NULL), 
" 3"=> array(1, array(-5), array(5)),
" 4"=> array(1, "where feverLess2+highTemp > 0 and testsOrdered = 1", array(1)),
" 6"=> array(0, "where smearResultPositive+smearResultNegative > 0", NULL),
" 7"=> array(0, "where smearResultPositive = 1", NULL),
" 8"=> array(0, "where smearResultPositive = 1 and FT+FG > 0 and Vx+Ov+Mai = 0", NULL), 
" 9"=> array(0, "where smearResultPositive = 1 and FT+FG > 0 and Vx+Ov+Mai > 0", NULL), 
"10"=> array(0, "where smearResultPositive = 1 and FT+FG = 0 and Vx+Ov+Mai > 0", NULL), 
"11"=> array(0, "where rapidResultPositive+rapidResultNegative > 0", NULL), 
"12"=> array(0, "where rapidResultPositive = 1", NULL),
"-13"=> array(0, "where testsOrdered = 1", NULL),
"13"=> array(1, "where rapidResultPositive+smearResultPositive+rapidResultNegative+smearResultNegative > 0", array(-13)),
"14"=> array(0, "where feverLess2+highTemp > 0 and rapidResultPositive+smearResultPositive > 0", NULL),
"15"=> array(0, "where malariaDx+malariaDxA+rapidResultPositive+smearResultPositive > 0 and chloroquine+primaquine = 2", NULL),
"16"=> array(0, "where malariaDx+malariaDxA+rapidResultPositive+smearResultPositive > 0 and hospitalisation = 1", NULL),

"-17" => array(0, ", dw_pregnancy_ranges p where s.patientid = p.patientid and s.visitdate between p.startdate and p.stopdate", NULL), 
"17"=> array(1, "where isPregnant = 1 and feverLess2+highTemp > 0", array(-17)),
"18"=> array(1, "where isPregnant = 1 and patientid in (select patientid from dw_malaria_snapshot where malariaDx+malariaDxA+rapidResultPositive+smearResultPositive = 0) and chloroquine+primaquine+quinine > 0 and feverLess2+highTemp > 0", array(17)), 
"-21" => array(0, "where isPregnant = 1 and chloroquine+primaquine = 2 and malariaDx+malariaDxA+rapidResultPositive+smearResultPositive > 0", NULL),
"21"=> array(0, "where isPregnant = 1 and malariaDx+malariaDxA+rapidResultPositive+smearResultPositive > 0", NULL),
"19"=> array(1, array(-21), array(21)),
"20"=> array(1, "where isPregnant = 1 and feverLess2+highTemp > 0 and testsOrdered = 1", array(17)),
"22"=> array(0, "where isPregnant = 1 and smearResultPositive+smearResultNegative > 0", NULL),
"23"=> array(0, "where isPregnant = 1 and smearResultPositive = 1", NULL),
"24"=> array(0, "where isPregnant = 1 and smearResultPositive = 1 and FT+FG > 0 and Vx+Ov+Mai = 0", NULL), 
"25"=> array(0, "where isPregnant = 1 and smearResultPositive = 1 and FT+FG > 0 and Vx+Ov+Mai > 0", NULL), 
"26"=> array(0, "where isPregnant = 1 and smearResultPositive = 1 and FT+FG = 0 and Vx+Ov+Mai > 0", NULL), 
"27"=> array(0, "where isPregnant = 1 and rapidResultPositive+rapidResultNegative > 0", NULL), 
"28"=> array(0, "where isPregnant = 1 and rapidResultPositive = 1", NULL),
"-29"=> array(0, "where isPregnant = 1 and testsOrdered = 1", NULL),
"29"=> array(1, "where isPregnant = 1 and rapidResultPositive+smearResultPositive+rapidResultNegative+smearResultNegative > 0", array(-29)),
"30"=> array(0, "where isPregnant = 1 and feverLess2+highTemp > 0 and rapidResultPositive+smearResultPositive > 0", NULL),
"31"=> array(0, "where isPregnant = 1 and malariaDx+malariaDxA+rapidResultPositive+smearResultPositive > 0 and chloroquine+primaquine = 2", NULL),
"32"=> array(0, "where isPregnant = 1 and malariaDx+malariaDxA+rapidResultPositive+smearResultPositive > 0 and hospitalisation = 1", NULL)
);

$indicatorQueries = $indicatorQueries + genAgeGpQueries(33 , ', patient p where p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 < 1 ');
$indicatorQueries = $indicatorQueries + genAgeGpQueries(49 , ', patient p where p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 between 1 and 4 ');
$indicatorQueries = $indicatorQueries + genAgeGpQueries(65 , ', patient p where p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 between 5 and 9 ');	
$indicatorQueries = $indicatorQueries + genAgeGpQueries(81 , ', patient p where p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 between 10 and 14 ');
$indicatorQueries = $indicatorQueries + genAgeGpQueries(97 , ', patient p where p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 between 15 and 24 ');
$indicatorQueries = $indicatorQueries + genAgeGpQueries(113, ', patient p where p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 between 25 and 49 ');  
$indicatorQueries = $indicatorQueries + genAgeGpQueries(129, ', patient p where p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 > 49 '); 
	
	if (1 == 1) echo "\nGenerate Patient Lists start: " . date('h:i:s') . "\n";
	// store the patientid lists; don't need any reference to org, since pid contains site info
	foreach ($indicatorQueries as $indicator => $query) { 
		foreach ($time_period as $period) {
			if ($period == "Week") $period_value = $period . "(s.visitdate,2) ";
			else $period_value = $period . "(s.visitdate) ";
			if (!is_array($query[1])) {
				$sql = "insert into dw_malaria_patients select distinct " . $indicator . ",?, year(s.visitdate), " . $period_value . ", s.patientid from dw_malaria_snapshot s " . $query[1]; 
				$rc = database()->query($sql,array($period))->rowCount();
				if (1 == 1) echo "\nGenerate Pid List for: " . $indicator . " :" . $sql . " Rows inserted: " . $rc . "\n"; 
			} else { 
				// anytime $query[1] isn't simple, previous calculations can be used
				generatePidLists("malaria", $indicator, $query[1], $period);
			}
		} 
	}	 
	if (1 == 1) echo "\nGenerate Patient Lists end/Indicator slices start: " . date('h:i:s') . "\n";
	// store the indicators     
	foreach ($indicatorQueries as $indicator => $query) { 
		if ($indicator < 1) continue;  // don't need slices for these 
		$org_unit = 'Sitecode';
		$org_value = 't.location_id';
		switch ($query[0]) {
		case 0: // simple calculation
			$sql = "insert into dw_malaria_slices select ?, " . $org_value . ", " . $indicator . ", time_period, year, period, case when t.sex in (1,2) then t.sex else 4 end, count(distinct p.patientid), 0 
			from dw_malaria_patients p, patient t where indicator = " . $indicator . " and p.patientid = t.patientid group by 3,4,1,2,5,6,7"; 
			$rc = database()->query($sql, array($org_unit))->rowCount();
			if (1 == 1) {
				echo "\nGenerate simple slices for: " . $indicator . " :" . $sql . " Rows inserted: " . $rc . "\n"; 
				print_r ($argArray);
			} 
			break;
		case 1: // percent
			//generatePercents('malaria', $indicator, $org_unit, $org_value, $query);
			break;
		case 2: // this among that
			generateAmongSlices("malaria", $indicator, $org_unit, $org_value, $query);
			break;
		}    
	} 
	generatePercents('malaria'); 
	if (1 == 1) echo "\nIndicator slices end: " . date('h:i:s') . "\n";       	
}
function genAgeGpQueries ($i, $qualifier) {
        $iArray = array();
        $iArray[strval(-$i    )] = array(0, $qualifier, NULL); 
        $iArray[strval( $i    )] = array(1, $qualifier . " and feverLess2+highTemp > 0", array(strval(-$i)));
        $iArray[strval( $i+1  )] = array(1, $qualifier . " and s.patientid in (select patientid from dw_malaria_snapshot where malariaDx+malariaDxA+rapidResultPositive+smearResultPositive = 0) and chloroquine+primaquine+quinine > 0 and feverLess2+highTemp > 0", array(strval($i))); 
        $iArray[strval(-($i+4))] = array(0, $qualifier . " and chloroquine+primaquine = 2 and malariaDx+malariaDxA+rapidResultPositive+smearResultPositive > 0", NULL);
        $iArray[strval( $i+4  )] = array(0, $qualifier . " and malariaDx+malariaDxA+rapidResultPositive+smearResultPositive > 0", NULL);
        $iArray[strval( $i+2  )] = array(1, array(-($i+4)), array(strval($i+4)));
        $iArray[strval( $i+3  )] = array(1, $qualifier . " and feverLess2+highTemp > 0 and testsOrdered = 1", array(strval($i)));
        $iArray[strval( $i+5  )] = array(0, $qualifier . " and smearResultPositive+smearResultNegative > 0", NULL);
        $iArray[strval( $i+6  )] = array(0, $qualifier . " and smearResultPositive = 1", NULL);
        $iArray[strval( $i+7  )] = array(0, $qualifier . " and smearResultPositive = 1 and FT+FG > 0 and Vx+Ov+Mai = 0", NULL); 
        $iArray[strval( $i+8  )] = array(0, $qualifier . " and smearResultPositive = 1 and FT+FG > 0 and Vx+Ov+Mai > 0", NULL); 
        $iArray[strval( $i+9  )] = array(0, $qualifier . " and smearResultPositive = 1 and FT+FG = 0 and Vx+Ov+Mai > 0", NULL); 
        $iArray[strval( $i+10 )] = array(0, $qualifier . " and rapidResultPositive+rapidResultNegative > 0", NULL); 
        $iArray[strval( $i+11 )] = array(0, $qualifier . " and rapidResultPositive = 1", NULL);
        $iArray[strval(-($i+12))] = array(0, $qualifier . " and testsOrdered = 1", NULL);
        $iArray[strval( $i+12 )] = array(1, $qualifier . " and rapidResultPositive+smearResultPositive+rapidResultNegative+smearResultNegative > 0", array(strval(-($i+12))));
        $iArray[strval( $i+13 )] = array(0, $qualifier . " and feverLess2+highTemp > 0 and rapidResultPositive+smearResultPositive > 0", NULL);
        $iArray[strval( $i+14 )] = array(0, $qualifier . " and malariaDx+malariaDxA+rapidResultPositive+smearResultPositive > 0 and chloroquine+primaquine = 2", NULL);
        $iArray[strval( $i+15 )] = array(0, $qualifier . " and malariaDx+malariaDxA+rapidResultPositive+smearResultPositive > 0 and hospitalisation = 1", NULL);
        return $iArray;  
}
?>
