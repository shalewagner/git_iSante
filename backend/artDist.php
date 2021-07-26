<? 
function updateArtDistSnapshot($lastModified) {
 $rc = database()->query('INSERT INTO dw_artDist_snapshot (patientID,visitDate,visitArt) 
	SELECT DISTINCT e.patientid,
		CASE WHEN ymdtodate(p.dispdateyy,p.dispdatemm,p.dispdatedd) IS NOT NULL and p.dispdateyy != ? and p.dispdatemm != ? THEN ymdtodate(dispdateyy,dispdatemm,dispdatedd)
		ELSE ymdToDate(e.visitdateyy,e.visitdatemm,e.visitdatedd) END visitDate,1
		FROM prescriptions p, encounter e WHERE e.encountertype in (5,18) AND encStatus < 255 AND 
		p.patientid = e.patientid AND p.sitecode = e.sitecode AND p.visitdateyy = e.visitdateyy AND p.visitdatemm = e.visitdatemm AND p.visitdatedd = e.visitdatedd AND p.seqNum = e.seqNum AND 
		drugid IN ( 1, 3, 4, 5, 6, 7, 8, 10, 11, 12, 15, 16, 17, 20, 21, 22, 23, 26, 27, 28, 29, 31, 32, 33, 34, 87, 88,89,90,91) AND 
		(dispensed = 1 OR dispAltNumPills IS NOT NULL OR ISDATE(ymdtodate(dispdateyy,dispdatemm,dispdatedd)) = 1 OR dispAltNumDays IS NOT NULL OR 
		dispAltDosage IS NOT NULL) on duplicate key update visitArt=values(visitArt) ', array('un','un'))->rowCount();
	echo "\n ArvDate" . date('h:i:s') . "\n";
	
	
		$rc = database()->query('INSERT INTO dw_artDist_snapshot (patientID,visitDate,nextVisitArt) 
	SELECT DISTINCT e.patientid,
	ifnull(nextVisitDateOther,CASE WHEN ymdToDate(e.nxtVisityy,e.nxtVisitmm,e.nxtVisitdd) IS NOT NULL and e.nxtVisityy != ? and e.nxtvisitmm != ? THEN ymdToDate(e.nxtVisityy,e.nxtVisitmm,e.nxtVisitdd) ELSE NULL END),1
		FROM prescriptions p, encounter e WHERE e.encountertype in (5,18) AND encStatus < 255 AND 
		p.patientid = e.patientid AND p.sitecode = e.sitecode AND p.visitdateyy = e.visitdateyy AND p.visitdatemm = e.visitdatemm AND p.visitdatedd = e.visitdatedd AND p.seqNum = e.seqNum AND 
		drugid IN ( 1, 3, 4, 5, 6, 7, 8, 10, 11, 12, 15, 16, 17, 20, 21, 22, 23, 26, 27, 28, 29, 31, 32, 33, 34, 87, 88,89,90,91) AND 
		(dispensed = 1 OR dispAltNumPills IS NOT NULL OR ISDATE(ymdtodate(dispdateyy,dispdatemm,dispdatedd)) = 1 OR dispAltNumDays IS NOT NULL OR 
		dispAltDosage IS NOT NULL) on duplicate key update nextVisitArt=values(nextVisitArt)', array('un','un'))->rowCount();
	echo "\n ArvDate" . date('h:i:s') . "\n";
	
 
}


function artDistSlices($key, $orgType, $time_period) {
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
" 1"=> array(0, "where ifnull(nextVisitArt,0)=1 ", NULL), 
" 2"=> array(0, "where ifnull(visitArt,0)=1 ", NULL), 
" 3"=> array(1, "where ifnull(nextVisitArt,0)=1 ",array(1)),
" 4"=> array(1, "where ifnull(nextVisitArt,0)=1 ", array(1)),
" 5"=> array(1, "where ifnull(visitArt,0)=1 ", array(3))
);


	if (1 == 1) echo "\nGenerate Patient Lists start: " . date('h:i:s') . "\n";
	// store the patientid lists; don't need any reference to org, since pid contains site info
	foreach ($indicatorQueries as $indicator => $query) { 
	        echo "***" . date('h:i:s') . "***\n";
		foreach ($time_period as $period) {
			if ($period == "Week") $period_value = $period . "(s.visitdate,2) ";
			else $period_value = $period . "(s.visitdate) ";
			if (!is_array($query[1])) {
				if($indicator==3)
				$sql = "insert into dw_artDist_patients select distinct " . $indicator . ",?, year(s.visitdate), " . $period_value . ", s.patientid from dw_artDist_snapshot s " . $query[1]." and s.patientID not in (select t.patientID from dw_artDist_snapshot t where year(s.visitdate)=year(t.visitdate) and ".$period."(s.visitDate)=".$period."(t.visitDate) and ifnull(t.visitArt,0)=1)";	
				
				if($indicator==4)
				$sql = "insert into dw_artDist_patients select distinct " . $indicator . ",?, year(s.visitdate), " . $period_value . ", s.patientid from dw_artDist_snapshot s " . $query[1]." and s.patientID in (select t.patientID from dw_artDist_snapshot t where year(s.visitdate)=year(t.visitdate) and ".$period."(s.visitDate)=".$period."(t.visitDate) and ifnull(t.visitArt,0)=1)";	
			
			    if($indicator==5)
			    $sql = "insert into dw_artDist_patients select distinct " . $indicator . ",?, year(s.visitdate), " . $period_value . ", s.patientid from dw_artDist_snapshot s " . $query[1]." and s.patientID not in (select t.patientID from dw_artDist_snapshot t where year(s.visitdate)=year(t.visitdate) and ".$period."(s.visitDate)=".$period."(t.visitDate) and ifnull(t.visitArt,0)=1) and s.patientID in (select t.patientID from dw_artDist_snapshot t where year(s.visitdate)>=year(t.visitdate) and ".$period."(s.visitDate)>".$period."(t.visitDate) and ifnull(t.visitArt,0)=1)";	
				
				if($indicator<3)
				$sql = "insert into dw_artDist_patients select distinct " . $indicator . ",?, year(s.visitdate), " . $period_value . ", s.patientid from dw_artDist_snapshot s " . $query[1]; 
				$rc = database()->query($sql,array($period))->rowCount();
				
				if (1 == 1) echo "\nGenerate Pid List for: " . $indicator . " :" . $sql . " Rows inserted: " . $rc . "\n"; 
			} else { 
				// anytime $query[1] isn't simple, previous calculations can be used
				generatePidLists("artDist", $indicator, $query[1], $period);
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
				$sql = "insert into dw_artDist_slices select ?, " . $org_value . ", " . $indicator . ", time_period, year, period, t.sex, count(distinct p.patientid), 0 from dw_artDist_patients p, patient t";
				if ($org_unit != "Haiti") 
					$sql .= ", clinicLookup c where c.sitecode = left(p.patientid,5) and ";
				else 
					$sql .= " where ";
				$sql .= " indicator = ? and p.patientid = t.patientid group by 1,2,3,4,5,6,7";
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
				generateAmongSlices("artDist", $indicator, $org_unit, $org_value, $query);
				break;
			}
		} 
	} 
	generatePercents('artDist'); 
	if (1 == 1) echo "\nIndicator slices end: " . date('h:i:s') . "\n";       	
}

?>
