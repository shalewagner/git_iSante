<? 
function updateHivstatusSnapshot($lastModified) {
	$statusMap = array(
	 3 => 'new_palliatifs'    ,
	 7 => 'actif_palliatifs'  ,
	 5 => 'risque_palliatifs' ,
	10 => 'inactif_palliatifs',
	 9 => 'disc_palliatifs'   ,
	 2 => 'new_tar'           ,
	 6 => 'actif_tar'         ,
	 4 => 'risque_tar'        ,
	 8 => 'inactif_tar'       ,
	 1 => 'disc_tar'
	); 

	/* load the snapshot table */
	$qry = "select enddate as 'enddate', patientid as 'patientid', patientStatus as 'patientStatus' from patientStatusTemp
	where year(enddate) between year(date_sub(now(),interval 5 year)) and year(now()) and ( ( (
	year(enddate) = year(date_sub(now(), interval 1 day)) and month(enddate) = month(date_sub(now(), interval 1 day)) and day(enddate) = day(date_sub(now(), interval 1 day))
	) or (
	year(enddate) < year(now()) and month(enddate) = 12 and day(enddate) = 31
	) ) or (
	year(enddate) between  year(date_sub(now(), interval 5 month)) and  year(now()) and month(enddate) between month(date_sub(now(), interval 5 month)) and month(now()) and enddate = last_day(enddate)
	) or (
	year(enddate) between  year(date_sub(now(), interval 5 week)) and  year(now()) and month(enddate) between month(date_sub(now(), interval 5 week)) and month(now()) and week(enddate) between  week(date_sub(now(), interval 5 week)) and week(now()) and dayofweek(enddate) = 6
	));";
	$result = dbQuery ($qry);
	while ($row = psRowFetch($result)) {        
		if ($row['patientid'] == "" || $row['enddate'] == "") continue;
		$qry = 'insert into dw_hivstatus_snapshot (patientid, visitdate, ' . $statusMap[$row['patientStatus']] . ') values (?,?,1) on duplicate key update ' . $statusMap[$row['patientStatus']] . ' = 1'; 
		$rc = database()->query($qry, array($row['patientid'],$row['enddate']))->rowCount();
		$j++;
	} 
        if (DEBUG_FLAG) {
		echo "<br>Status rows: " . $j . " updated<br>";
		echo "<br>" . date('h:i:s') . "<br>";
	}
}

function hivstatusSlices($key, $orgType, $time_period) { 
/*
insert into dw_hivstatusReportLookup (indicator , indicatorType , nameen , namefr , definitionen , definitionfr , subGroupEn , subGroupFr , indicatorDenominator) values
( 1,1,'Adult new in clinic',             'Adult new in clinic',             'Adult new in clinic',             'Adult new in clinic',             'Adult',    'Adult',    -2),
( 2,1,'Adult active in clinic',          'Adult active in clinic',          'Adult active in clinic',          'Adult active in clinic',          'Adult',    'Adult',    -2),
( 3,1,'Adult at risk in clinic',         'Adult at risk in clinic',         'Adult at risk in clinic',         'Adult at risk in clinic',         'Adult',    'Adult',    -2),
( 4,1,'Adult inactive in clinic',        'Adult inactive in clinic',        'Adult inactive in clinic',        'Adult inactive in clinic',        'Adult',    'Adult',    -2),
( 5,1,'Adult discontinued in clinic',    'Adult discontinued in clinic',    'Adult discontinued in clinic',    'Adult discontinued in clinic',    'Adult',    'Adult',    -2),
                                                                                                                                                                          
( 6,1,'Adult new on ART',                'Adult new on ART',                'Adult new on ART',                'Adult new on ART',                'Adult',    'Adult',    -3),
( 7,1,'Adult active on ART',             'Adult active on ART',             'Adult active on ART',             'Adult active on ART',             'Adult',    'Adult',    -3),
( 8,1,'Adult at risk on ART',            'Adult at risk on ART',            'Adult at risk on ART',            'Adult at risk on ART',            'Adult',    'Adult',    -3),
( 9,1,'Adult inactive on ART',           'Adult inactive on ART',           'Adult inactive on ART',           'Adult inactive on ART',           'Adult',    'Adult',    -3),
(10,1,'Adult discontinued on ART',       'Adult discontinued on ART',       'Adult discontinued on ART',       'Adult discontinued on ART',       'Adult',    'Adult',    -3),
      
(11,1,'Pediatric new in clinic',         'Pediatric new in clinic',         'Pediatric new in clinic',         'Pediatric new in clinic',         'Pediatric','Pediatric',-4),
(12,1,'Pediatric active in clinic',      'Pediatric active in clinic',      'Pediatric active in clinic',      'Pediatric active in clinic',      'Pediatric','Pediatric',-4),
(13,1,'Pediatric at risk in clinic',     'Pediatric at risk in clinic',     'Pediatric at risk in clinic',     'Pediatric at risk in clinic',     'Pediatric','Pediatric',-4),
(14,1,'Pediatric inactive in clinic',    'Pediatric inactive in clinic',    'Pediatric inactive in clinic',    'Pediatric inactive in clinic',    'Pediatric','Pediatric',-4),
(15,1,'Pediatric discontinued in clinic','Pediatric discontinued in clinic','Pediatric discontinued in clinic','Pediatric discontinued in clinic','Pediatric','Pediatric',-4),
                                                                                                                                                                          
(16,1,'Pediatric new on ART',            'Pediatric new on ART',            'Pediatric new on ART',            'Pediatric new on ART',            'Pediatric','Pediatric',-5),
(17,1,'Pediatric active on ART',         'Pediatric active on ART',         'Pediatric active on ART',         'Pediatric active on ART',         'Pediatric','Pediatric',-5),
(18,1,'Pediatric at risk on ART',        'Pediatric at risk on ART',        'Pediatric at risk on ART',        'Pediatric at risk on ART',        'Pediatric','Pediatric',-5),
(19,1,'Pediatric inactive on ART',       'Pediatric inactive on ART',       'Pediatric inactive on ART',       'Pediatric inactive on ART',       'Pediatric','Pediatric',-5),
(20,1,'Pediatric discontinued on ART',   'Pediatric discontinued on ART',   'Pediatric discontinued on ART',   'Pediatric discontinued on ART',   'Pediatric','Pediatric',-5),
                                                                                                               
(21,1,'Total new in clinic',             'Total new in clinic',             'Total new in clinic',             'Total new in clinic',             'Total',    'Total',    -6),
(22,1,'Total active in clinic',          'Total active in clinic',          'Total active in clinic',          'Total active in clinic',          'Total',    'Total',    -6),
(23,1,'Total at risk in clinic',         'Total at risk in clinic',         'Total at risk in clinic',         'Total at risk in clinic',         'Total',    'Total',    -6),
(24,1,'Total inactive in clinic',        'Total inactive in clinic',        'Total inactive in clinic',        'Total inactive in clinic',        'Total',    'Total',    -6),
(25,1,'Total discontinued in clinic',    'Total discontinued in clinic',    'Total discontinued in clinic',    'Total discontinued in clinic',    'Total',    'Total',    -6),
(26,1,'Total in clinic',                 'Total in clinic',                 'Total in clinic',                 'Total in clinic',                 'Total',    'Total',    -1),                                                                                                            
                                                                                                                                                                          
(27,1,'Total new on ART',                'Total new on ART',                'Total new on ART',                'Total new on ART',                'Total',    'Total',    -7),
(28,1,'Total active on ART',             'Total active on ART',             'Total active on ART',             'Total active on ART',             'Total',    'Total',    -7),
(29,1,'Total at risk on ART',            'Total at risk on ART',            'Total at risk on ART',            'Total at risk on ART',            'Total',    'Total',    -7),
(30,1,'Total inactive on ART',           'Total inactive on ART',           'Total inactive on ART',           'Total inactive on ART',           'Total',    'Total',    -7),
(31,1,'Total discontinued on ART',       'Total discontinued on ART',       'Total discontinued on ART',       'Total discontinued on ART',       'Total',    'Total',    -7),
(32,1,'Total on ART',                    'Total on ART',                    'Total on ART',                    'Total on ART',                    'Total',    'Total',    -1);
*/	
$pallQual = "new_palliatifs+actif_palliatifs+risque_palliatifs+inactif_palliatifs+disc_palliatifs";
$tarQual =  "new_tar+actif_tar+risque_tar+inactif_tar+disc_tar";
$totalQual = $pallQual . "+" . $tarQual;
$pedQual = "datediff(s.visitdate,ymdtodate(p.dobyy,01,01))/365 < 15";
$adultQual = "(not datediff(s.visitdate,ymdtodate(p.dobyy,01,01))/365 < 15 or isnumeric(p.dobyy) <> 1)"; 

$indicatorQueries = array (
   // Denominators
    -1 => array(0, "where " . $totalQual . " > 0", NULL), 
    -2 => array(0, ", patient p where s.patientid = p.patientid and " . $adultQual . " and " . $pallQual . " > 0", NULL), 
    -3 => array(0, ", patient p where s.patientid = p.patientid and " . $adultQual . " and " . $tarQual . " > 0", NULL),
    -4 => array(0, ", patient p where s.patientid = p.patientid and " . $pedQual . " and " . $pallQual . " > 0", NULL),   
    -5 => array(0, ", patient p where s.patientid = p.patientid and " . $pedQual . " and " . $tarQual . " > 0", NULL),
    -6 => array(0, ", patient p where s.patientid = p.patientid and " . $pallQual . " > 0", NULL),   
    -7 => array(0, ", patient p where s.patientid = p.patientid and " . $tarQual . " > 0", NULL),
    // Adult 
    1 => array(1, ", patient p where s.patientid = p.patientid and " . $adultQual . " and new_palliatifs = 1",     array(-2)), 
    2 => array(1, ", patient p where s.patientid = p.patientid and " . $adultQual . " and actif_palliatifs = 1",   array(-2)),
    3 => array(1, ", patient p where s.patientid = p.patientid and " . $adultQual . " and risque_palliatifs = 1",  array(-2)),
    4 => array(1, ", patient p where s.patientid = p.patientid and " . $adultQual . " and inactif_palliatifs = 1", array(-2)),
    5 => array(1, ", patient p where s.patientid = p.patientid and " . $adultQual . " and disc_palliatifs = 1",    array(-2)),       
    6 => array(1, ", patient p where s.patientid = p.patientid and " . $adultQual . " and new_tar = 1",            array(-3)), 
    7 => array(1, ", patient p where s.patientid = p.patientid and " . $adultQual . " and actif_tar = 1",          array(-3)),
    8 => array(1, ", patient p where s.patientid = p.patientid and " . $adultQual . " and risque_tar = 1",         array(-3)),
    9 => array(1, ", patient p where s.patientid = p.patientid and " . $adultQual . " and inactif_tar = 1",        array(-3)),
   10 => array(1, ", patient p where s.patientid = p.patientid and " . $adultQual . " and disc_tar = 1",           array(-3)),
   // Pediatric
   11 => array(1, ", patient p where s.patientid = p.patientid and " . $pedQual . " and new_palliatifs = 1",     array(-4)), 
   12 => array(1, ", patient p where s.patientid = p.patientid and " . $pedQual . " and actif_palliatifs = 1",   array(-4)),
   13 => array(1, ", patient p where s.patientid = p.patientid and " . $pedQual . " and risque_palliatifs = 1",  array(-4)),
   14 => array(1, ", patient p where s.patientid = p.patientid and " . $pedQual . " and inactif_palliatifs = 1", array(-4)),
   15 => array(1, ", patient p where s.patientid = p.patientid and " . $pedQual . " and disc_palliatifs = 1",    array(-4)),       
   16 => array(1, ", patient p where s.patientid = p.patientid and " . $pedQual . " and new_tar = 1",            array(-5)), 
   17 => array(1, ", patient p where s.patientid = p.patientid and " . $pedQual . " and actif_tar = 1",          array(-5)),
   18 => array(1, ", patient p where s.patientid = p.patientid and " . $pedQual . " and risque_tar = 1",         array(-5)),
   19 => array(1, ", patient p where s.patientid = p.patientid and " . $pedQual . " and inactif_tar = 1",        array(-5)),
   20 => array(1, ", patient p where s.patientid = p.patientid and " . $pedQual . " and disc_tar = 1",           array(-5)),
   // Total 
   21 => array(1, ", patient p where s.patientid = p.patientid and new_palliatifs = 1",     array(-6)), 
   22 => array(1, ", patient p where s.patientid = p.patientid and actif_palliatifs = 1",   array(-6)),
   23 => array(1, ", patient p where s.patientid = p.patientid and risque_palliatifs = 1",  array(-6)),
   24 => array(1, ", patient p where s.patientid = p.patientid and inactif_palliatifs = 1", array(-6)),
   25 => array(1, ", patient p where s.patientid = p.patientid and disc_palliatifs = 1",    array(-6)),
   26 => array(1, array(-6),    array(-1)),       

   27 => array(1, ", patient p where s.patientid = p.patientid and new_tar = 1",     array(-7)), 
   28 => array(1, ", patient p where s.patientid = p.patientid and actif_tar = 1",   array(-7)),
   29 => array(1, ", patient p where s.patientid = p.patientid and risque_tar = 1",  array(-7)),
   30 => array(1, ", patient p where s.patientid = p.patientid and inactif_tar = 1", array(-7)),
   31 => array(1, ", patient p where s.patientid = p.patientid and disc_tar = 1",    array(-7)),
   32 => array(1, array(-7),    array(-1))
);
	
	if (DEBUG_FLAG) echo "<br>Generate Patient Lists start: " . date('h:i:s') . "<br>";
	// store the patientid lists; don't need any reference to org, since pid contains site info
	foreach ($indicatorQueries as $indicator => $query) {
		foreach ($time_period as $period) {
			if ($period == "Week") $period_value = $period . "(s.visitdate,2) ";
			else $period_value = $period . "(s.visitdate) ";
			if (!is_array($query[1])) { 
				$sql = "insert into dw_hivstatus_patients 
				select distinct " . $indicator . ",?, year(s.visitdate), " . $period_value . ", s.patientid from dw_hivstatus_snapshot s " . $query[1]; 
				$rc = database()->query($sql,array($period))->rowCount();
				if (DEBUG_FLAG) echo "<br>Generate Pid List for: " . $indicator . " :" . $sql . " Rows inserted: " . $rc . "<br>"; 
			} else { 
				// anytime $query[1] isn't simple, previous calculations can be used
				generatePidLists("hivstatus", $indicator, $query[1], $period);
			}
		} 
	}	 
	if (DEBUG_FLAG) echo "<br>Generate Patient Lists end/Indicator slices start: " . date('h:i:s') . "<br>";
	// store the indicators     
	foreach ($indicatorQueries as $indicator => $query) {
		if ($indicator < 1) continue;  // don't need slices for these
		foreach ($orgType as $org_unit => $org_value) { 
			switch ($query[0]) {
			case 0: // simple calculation
				$sql = "insert into dw_hivstatus_slices select ?, " . $org_value . ", " . $indicator . ", time_period, year, period, t.sex, count(distinct p.patientid), 0 from dw_hivstatus_patients p, patient t";
				if ($org_unit != "Haiti") 
					$sql .= ", clinicLookup c where c.sitecode = left(p.patientid,5) and ";
				else 
					$sql .= " where ";
				$sql .= " indicator = ? and p.patientid = t.patientid and t.sex in (1,2) group by 1,2,3,4,5,6,7";
				if ($org_unit == 'Commune') $argArray = array($org_unit, "-", $indicator);
				else $argArray = array($org_unit, $indicator); 
				$rc = database()->query($sql, $argArray)->rowCount();
				if (DEBUG_FLAG) {
					echo "<br>Generate simple slices for: " . $indicator . " :" . $sql . " Rows inserted: " . $rc . "<br>"; 
					print_r ($argArray);
				} 
				break;
			case 1: // percent
				generatePercents('hivstatus', $indicator, $org_unit, $org_value, $query);
				break;
			case 2: // this among that
				generateAmongSlices("hivstatus", $indicator, $org_unit, $org_value, $query);
				break;
			}
		} 
	}  
	if (DEBUG_FLAG) echo "<br>Indicator slices end: " . date('h:i:s') . "<br>";
}  

function updateBplusSnapshot($lastModified) { 
	/* insert pregnancy start and end dates */
	$sql = "select patientid as patientID, startDate as startDate, stopDate as stopDate from dw_pregnancy_ranges";
	if (DEBUG_FLAG) echo "<br>Pregnancy start/stop Query1: " . $sql . "<br>";
	$arr = databaseSelect()->query($sql,array($lastModified))->fetchAll(PDO::FETCH_ASSOC);
	$j = 0;
	foreach ($arr as $i => $row) {
		if ($row['patientID'] == "") continue; 
		$start = $row['startDate'];
                if ($start == "") continue;
		else {
			$qry = 'insert into dw_bplus_snapshot (patientid, visitdate, startPregnant) values (?,?,1) on duplicate key update startPregnant = 1';
			$rc = database()->query($qry, array($row['patientID'], $start))->rowCount();
			$j++;
		}
		$stop = $row['stopDate'];
		if ($stop == "") continue; 
		else {
			$qry = 'insert into dw_bplus_snapshot (patientid, visitdate, stopPregnant) values (?,?,1) on duplicate key update stopPregnant = 1';
			$rc = database()->query($qry, array($row['patientID'], $stop))->rowCount();
			$j++;
		}
	} 
	if (DEBUG_FLAG) {
		echo "<br>Pregnancy start/stop date values " . $j . " found<br>";
		echo "<br>" . date('h:i:s') . "<br>";
	}	
	/* insert first arv dates */ 
	$sql = "select patientid as patientID, date(min(visitdate)) as visitdate from pepfarTable group by 1";
	if (DEBUG_FLAG) echo "<br>Pregnancy start/stop Query1: " . $sql . "<br>";
	$arr = databaseSelect()->query($sql,array($lastModified))->fetchAll(PDO::FETCH_ASSOC);
	$j = 0;
	$k = 0;
	foreach ($arr as $i => $row) {
		if ($row['patientID'] == "") continue; 
		$firstARV = $row['visitdate'];
		$qry = 'insert into dw_bplus_snapshot (patientid, visitdate, firstARV) values (?,?,1) on duplicate key update firstARV = 1';
		$rc = database()->query($qry, array($row['patientID'], $firstARV))->rowCount();
		$j++;
	} 
	if (DEBUG_FLAG) {
		echo "<br>First ARV date values " . $j . " found<br>";
		echo "<br>" . date('h:i:s') . "<br>";
	}
	/* insert latest visit */ 
	$sql = "select e.patientid as patientID, date(max(e.visitdate)) as visitdate from dw_bplus_snapshot n, encValid e 
		where n.patientid = e.patientid and e.encountertype not in (12,21,27,28,29,31) group by 1";
	if (DEBUG_FLAG) echo "<br>Latest visitdate: " . $sql . "<br>";
	$arr = databaseSelect()->query($sql,array($lastModified))->fetchAll(PDO::FETCH_ASSOC);
	$j = 0;
	$k = 0;
	foreach ($arr as $i => $row) {
		if ($row['patientID'] == "") continue; 
		$latestVisit = $row['visitdate'];
		$qry = 'insert into dw_bplus_snapshot (patientid, visitdate, latestVisit) values (?,?,1) on duplicate key update latestVisit = 1';
		$rc = database()->query($qry, array($row['patientID'], $latestVisit))->rowCount();
		$j++;

	} 
	if (DEBUG_FLAG) {
		echo "<br>Latest visit date values " . $j . " found<br>";
		echo "<br>" . date('h:i:s') . "<br>";
	}
}
?>