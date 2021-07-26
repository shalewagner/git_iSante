<? 
function updateHepdoSnapshot($lastModified) {
        $qry = 'insert into dw_hepdo_snapshot(patientID,visitDate,
		rageSuspected,coquelucheSuspected,choleraSuspected,
		covidSuspected,pesteSuspected,rougeoleSuspected,
		dingueSuspected,charbonSuspected,lepreSuspected,
		typhoideSuspected)
   SELECT DISTINCT patientID, visitDate, 
   case when o.concept_id IN (163811) then o.value_boolean else 0 end AS rageSuspected,
   case when o.concept_id IN (163812) then  o.value_boolean else 0 end AS coquelucheSuspected,
   case when o.concept_id IN (163813) then  o.value_boolean else null end AS choleraSuspected,
   case when concept_id in (163800) then o.value_boolean else 0 end as covidSuspected,
   case when concept_id in (163806) then o.value_boolean else 0 end as pesteSuspected,
   case when concept_id in (163814) then o.value_boolean else 0 end as rougeoleSuspected,
   case when concept_id in (163815) then o.value_boolean else 0 end as dingueSuspected,
   case when concept_id in (163816) then o.value_boolean else 0 end as charbonSuspected,
   case when concept_id in (163817) then o.value_boolean else 0 end as lepreSuspected,
   case when concept_id in (71340) then o.value_boolean else 0 end as typhoideSuspected 
   FROM encValidAll e, obs o
        WHERE e.encounter_id = o.encounter_id AND o.concept_id IN (71340,163817,163816,163815,163814,163806,163800,163813,163812,163811) 
   on duplicate key update 
      rageSuspected=case when o.concept_id IN (163811) then o.value_boolean else 0 end,
      coquelucheSuspected=case when o.concept_id IN (163812) then  o.value_boolean else 0 end,
      choleraSuspected=case when o.concept_id IN (163813) then  o.value_boolean else null end,
   covidSuspected=case when concept_id in (163800) then o.value_boolean else 0 end,
   pesteSuspected=case when concept_id in (163806) then o.value_boolean else 0 end,
   rougeoleSuspected=case when concept_id in (163814) then o.value_boolean else 0 end,
   dingueSuspected=case when concept_id in (163815) then o.value_boolean else 0 end,
   charbonSuspected=case when concept_id in (163816) then o.value_boolean else 0 end,
   lepreSuspected=case when concept_id in (163817) then o.value_boolean else 0 end,
   typhoideSuspected=case when concept_id in (71340) then o.value_boolean else 0 end';
		$rc = database()->query($qry)->rowCount();
		echo "\n Registered 1" . date('h:i:s') . "\n";
		
		
		 $qry = 'insert into dw_hepdo_snapshot(patientID,visitDate,		 decesMaternel,diphterieProbable,esavi,microcephalie,
		 paludisme,pfa,rage,sgb,sfha,src,tetanosNeonatal)
select distinct patientID,visitDate,
case when o.concept_id IN (163802) then  o.value_boolean else 0 end AS decesMaternel,
case when o.concept_id IN (70296) then  o.value_boolean else 0 end AS diphterieProbable,
case when o.concept_id IN (163803) then  o.value_boolean else 0 end AS esavi,
case when o.concept_id IN (163804) then  o.value_boolean else 0 end AS microcephalie,
case when o.concept_id IN (7182,70850,70851,71149,71151) then  o.value_boolean else 0 end AS paludisme,
case when o.concept_id IN (163805) then  o.value_boolean else 0 end AS pfa,
case when o.concept_id IN (70336,70337) then  o.value_boolean else 0 end AS rage,
case when o.concept_id IN (163807) then  o.value_boolean else 0 end AS sgb,
case when o.concept_id IN (70882) then  o.value_boolean else 0 end AS sfha,
case when o.concept_id IN (70317,70318) then  o.value_boolean else 0 end AS src,
case when o.concept_id IN (163808) then  o.value_boolean else 0 end AS tetanosNeonatal
FROM encValidAll e, obs o
 WHERE e.encounter_id = o.encounter_id AND o.concept_id IN (163808,70317,70318,70882,163807,70336,70337,163805,7182,70850,70851,71149,71151,163804,163803,70296,163802)
 on duplicate key update 
 decesMaternel=case when o.concept_id IN (163802) then  o.value_boolean else 0 end,
 diphterieProbable=case when o.concept_id IN (70296) then  o.value_boolean else 0 end,
 esavi=case when o.concept_id IN (163803) then  o.value_boolean else 0 end,
 microcephalie=case when o.concept_id IN (163804) then  o.value_boolean else 0 end,
 paludisme=case when o.concept_id IN (7182,70850,70851,71149,71151) then  o.value_boolean else 0 end,
 pfa=case when o.concept_id IN (163805) then  o.value_boolean else 0 end,
 rage=case when o.concept_id IN (70336,70337) then  o.value_boolean else 0 end,
 sgb=case when o.concept_id IN (163807) then  o.value_boolean else 0 end,
 sfha=case when o.concept_id IN (70882) then  o.value_boolean else 0 end,
 src=case when o.concept_id IN (70317,70318) then  o.value_boolean else 0 end,
 tetanosNeonatal=case when o.concept_id IN (163808) then  o.value_boolean else 0 end';
		$rc = database()->query($qry)->rowCount();
		echo "\n tbArvDate" . date('h:i:s') . "\n";

 
		
$qry = 'insert into dw_hepdo_snapshot(patientID,visitDate,		 tiac,diabete,diarheAiguAqueuse,diarheAiguSanglante,
filarioseProbable,infectionRespAigu,sif,tetanos)
select distinct patientID,visitDate,
case when o.concept_id IN (163809) then  o.value_boolean else 0 end AS tiac,
case when o.concept_id IN (70085,70249,70250,70252,70253) then  o.value_boolean else 0 end AS diabete,
case when o.concept_id IN (70258,70259) then  o.value_boolean else 0 end AS diarheAiguAqueuse,
case when o.concept_id IN (70261,70262) then  o.value_boolean else 0 end AS diarheAiguSanglante,
case when o.concept_id IN (70461,70845) then  o.value_boolean else 0 end AS filarioseProbable,
case when o.concept_id IN (70308,70309) then  o.value_boolean else 0 end AS infectionRespAigu,
case when o.concept_id IN (70342,70343) then  o.value_boolean else 0 end AS sif,
case when o.concept_id IN (70855,70856) then  o.value_boolean else 0 end AS tetanos
FROM encValidAll e, obs o
 WHERE e.encounter_id = o.encounter_id AND o.concept_id IN (163809,70085,70249,70250,70252,70253,70461,70845,70258,70259,70261,70262,70308,70309,70342,70343,70855,70856)
 on duplicate key update 
 tiac=case when o.concept_id IN (163809) then  o.value_boolean else 0 end,
 diabete=case when o.concept_id IN (70085,70249,70250,70252,70253) then  o.value_boolean else 0 end,
 diarheAiguAqueuse=case when o.concept_id IN (70258,70259) then  o.value_boolean else 0 end,
 diarheAiguSanglante=case when o.concept_id IN (70261,70262) then  o.value_boolean else 0 end,
 filarioseProbable=case when o.concept_id IN (70461,70845) then  o.value_boolean else 0 end,
 infectionRespAigu=case when o.concept_id IN (70308,70309) then  o.value_boolean else 0 end,
 sif=case when o.concept_id IN (70342,70343) then  o.value_boolean else 0 end,
 tetanos=case when o.concept_id IN (70855,70856) then  o.value_boolean else 0 end';
		$rc = database()->query($qry)->rowCount();
		echo "\n tbArvDate" . date('h:i:s') . "\n";


$qry = 'insert into dw_hepdo_snapshot(patientID,visitDate,		 accidents,cancer,epilepsie,hta,ist,malnutrition,syphilis,violence)
select distinct patientID,visitDate,
case when o.concept_id IN (163818) then  o.value_boolean else 0 end AS accidents,
case when o.concept_id IN (70861,70862,70485,70378,70377,70162,70112,70110,70108,70061,70060,70059,70864,70865) then  o.value_boolean else 0 end AS cancer,
case when o.concept_id IN (70243,70244) then  o.value_boolean else 0 end AS epilepsie,
case when o.concept_id IN (70267,70268) then  o.value_boolean else 0 end AS hta,
case when o.concept_id IN (70097,70136) then  o.value_boolean else 0 end AS ist,
case when o.concept_id IN (70270,70271,70878,70879,70915,70916,70917,70957,70959,70961,71424,71425) then  o.value_boolean else 0 end AS malnutrition,
case when o.concept_id IN (71021,71022,163810) then  o.value_boolean else 0 end AS syphilis,
case when o.concept_id IN (70360,70361) then  o.value_boolean else 0 end AS violence
FROM encValidAll e, obs o
 WHERE e.encounter_id = o.encounter_id AND o.concept_id IN (163818,70243,70244,70861,70862,70485,70378,70377,70162,70112,70110,70108,70061,70060,70059,70864,70865,70267,70268,70097,70136,70270,70271,70878,70879,70915,70916,70917,70957,70959,70961,71424,71425,71021,71022,163810,70360,70361)
 on duplicate key update 
 accidents=case when o.concept_id IN (163818) then  o.value_boolean else 0 end,
 cancer=case when o.concept_id IN (70861,70862,70485,70378,70377,70162,70112,70110,70108,70061,70060,70059,70864,70865) then  o.value_boolean else 0 end,
 epilepsie=case when o.concept_id IN (70243,70244) then  o.value_boolean else 0 end,
 hta=case when o.concept_id IN (70267,70268) then  o.value_boolean else 0 end,
 ist=case when o.concept_id IN (70097,70136) then  o.value_boolean else 0 end,
 malnutrition=case when o.concept_id IN (70270,70271,70878,70879,70915,70916,70917,70957,70959,70961,71424,71425) then  o.value_boolean else 0 end,
 syphilis=case when o.concept_id IN (71021,71022,163810) then  o.value_boolean else 0 end,
 violence=case when o.concept_id IN (70360,70361) then  o.value_boolean else 0 end';
		$rc = database()->query($qry)->rowCount();
		echo "\n tbArvDate" . date('h:i:s') . "\n";



  		
 
}


function hepdoSlices($key, $orgType, $time_period) {
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
" 1"=> array(0, "where rageSuspected=1", NULL), 
" 2"=> array(0, "where coquelucheSuspected=1", NULL), 
" 3"=> array(0, "where choleraSuspected=1", NULL),
" 4"=> array(0, "where decesMaternel=1", NULL),
" 5"=> array(0, "where diphterieProbable=1", NULL),
" 6"=> array(0, "where esavi=1", NULL),
" 7"=> array(0, "where esavi=1", NULL),/* to replace by meningite suspected */
" 8"=> array(0, "where microcephalie=1", NULL),
" 9"=> array(0, "where paludisme=1", NULL),
" 10"=> array(0, "where pfa=1", NULL),
" 11"=> array(0, "where pesteSuspected=1", NULL),
" 12"=> array(0, "where rage=1", NULL),
" 13"=> array(0, "where rougeoleSuspected=1", NULL),
" 14"=> array(0, "where sgb=1", NULL),
" 15"=> array(0, "where sfha=1", NULL),
" 16"=> array(0, "where src=1", NULL),
" 17"=> array(0, "where tetanosNeonatal=1", NULL),
" 18"=> array(0, "where tiac=1", NULL),
" 19"=> array(0, "where charbonSuspected=1", NULL),
" 20"=> array(0, "where dingueSuspected=1", NULL),
" 21"=> array(0, "where diabete=1", NULL),
" 22"=> array(0, "where diarheAiguAqueuse=1", NULL),
" 23"=> array(0, "where diarheAiguSanglante=1", NULL),
" 24"=> array(0, "where typhoideSuspected=1", NULL),
" 25"=> array(0, "where filarioseProbable=1", NULL),
" 26"=> array(0, "where infectionRespAigu=1", NULL),
" 27"=> array(0, "where sif=1", NULL),
" 28"=> array(0, "where tetanos=1", NULL),
" 29"=> array(0, "where accidents=1", NULL),
" 30"=> array(0, "where cancer=1", NULL),
" 31"=> array(0, "where epilepsie=1", NULL),
" 32"=> array(0, "where hta=1", NULL),
" 33"=> array(0, "where ist=1", NULL),
" 34"=> array(0, "where lepreSuspected=1", NULL),
" 35"=> array(0, "where malnutrition=1", NULL),
" 36"=> array(0, "where syphilis=1", NULL),
" 37"=> array(0, "where violence=1", NULL)
);


	if (1 == 1) echo "\nGenerate Patient Lists start: " . date('h:i:s') . "\n";
	// store the patientid lists; don't need any reference to org, since pid contains site info
	foreach ($indicatorQueries as $indicator => $query) { 
	        echo "***" . date('h:i:s') . "***\n";
		foreach ($time_period as $period) {
			if ($period == "Week") $period_value = $period . "(s.visitdate,2) ";
			else $period_value = $period . "(s.visitdate) ";
			if (!is_array($query[1])) {
				$sql = "insert into dw_hepdo_patients select distinct " . $indicator . ",?, year(s.visitdate), " . $period_value . ", s.patientid from dw_hepdo_snapshot s " . $query[1]; 
				$rc = database()->query($sql,array($period))->rowCount();
				if (1 == 1) echo "\nGenerate Pid List for: " . $indicator . " :" . $sql . " Rows inserted: " . $rc . "\n"; 
			} else { 
				// anytime $query[1] isn't simple, previous calculations can be used
				generatePidLists("hepdo", $indicator, $query[1], $period);
			}
		} 
	}	 
	if (1 == 1) echo "\nGenerate Patient Lists end/Indicator slices start: " . date('h:i:s') . "\n";
	// store the indicators     
	foreach ($indicatorQueries as $indicator => $query) {
	        echo "***" . date('h:i:s') . "***\n"; 
		if ($indicator < 1) continue;  // don't need slices for these 
		foreach ($orgType as $org_unit => $org_value) { 
			switch ($query[0]) {
			case 0: // simple calculation
				$sql = "insert into dw_hepdo_slices select ?, " . $org_value . ", " . $indicator . ", time_period, year, period, t.sex, count(distinct p.patientid), 0 from dw_hepdo_patients p, patient t";
				if ($org_unit != "Haiti") 
					$sql .= ", clinicLookup c where c.sitecode = left(p.patientid,5) and ";
				else 
					$sql .= " where ";
				$sql .= " indicator = ? and p.patientid = t.patientid and t.sex in (1,2) group by 1,2,3,4,5,6,7";
				if ($org_unit == 'Commune') $argArray = array($org_unit, "-", $indicator);
				else $argArray = array($org_unit, $indicator); 
				$rc = database()->query($sql, $argArray)->rowCount();
				if (1 == 1) {
					echo "\nGenerate simple slices for: " . $indicator . " :" . $sql . " Rows inserted: " . $rc . "\n"; 
					print_r ($argArray);
				} 
				break;
			case 1: // percent
				//generatePercents('malaria', $indicator, $org_unit, $org_value, $query);
				break;
			case 2: // this among that
				generateAmongSlices("hepdo", $indicator, $org_unit, $org_value, $query);
				break;
			}
		} 
	} 
	generatePercents('hepdo'); 
	if (1 == 1) echo "\nIndicator slices end: " . date('h:i:s') . "\n";       	
}

?>
