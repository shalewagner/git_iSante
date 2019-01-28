<?

/* last date modified :  nov 4 */
function updateObgynSnapshot($lastModified) {

database()->query('INSERT INTO dw_obgyn_snapshot (patientID, visitDate, mammographDt, papTestResult, leucorhee, metrorragieSymptom, sexAgression, consult_obs, grossesseHautRisque, tetanosDtD1, hypertensionArteryA, hemorragieVaginale,hemorragieVaginalet1, membraneRupture, vacuum, laborMethod, laborMystery, laborDifficultBirth, vitalWeight1, ppVitalBp1, ironSup, utilisationPartogramme, beneficieGATPA, laborEvolution, plusDe30Ans, plusDe40Ans, femmesVuesPrenatal, suiviPrenatal, accouchement,membraneRuptureDeno)
SELECT patientID, maxDate AS visiteDate,
COUNT(CASE WHEN concept_id = 8039 THEN patientID ELSE NULL END) AS mammographDt,
COUNT(CASE WHEN concept_id = 7073 THEN patientID ELSE NULL END) AS papTestResult,
COUNT(CASE WHEN concept_id = 7886 THEN patientID ELSE NULL END) AS leucorhee,
COUNT(CASE WHEN concept_id = 70631 THEN patientID ELSE NULL END) AS metrorragieSymptom,
COUNT(CASE WHEN concept_id = 70176 THEN patientID ELSE NULL END) AS sexAgression,
COUNT(CASE WHEN concept_id = 70018 THEN patientID ELSE NULL END) AS consult_obs,
COUNT(CASE WHEN concept_id = 70086 THEN patientID ELSE NULL END) AS grossesseHautRisque,
COUNT(CASE WHEN concept_id = 71079 THEN patientID ELSE NULL END) AS tetanosDtD1,
COUNT(CASE WHEN concept_id = 7007 THEN patientID ELSE NULL END) AS hypertensionArteryA,
COUNT(CASE WHEN concept_id = 70190 THEN patientID ELSE NULL END) AS hemorragieVaginale,
COUNT(CASE WHEN concept_id = 70635 THEN patientID ELSE NULL END) AS hemorragieVaginalet1,
COUNT(CASE WHEN concept_id = 7809 THEN patientID ELSE NULL END) AS membraneRupture,
COUNT(CASE WHEN concept_id = 7200 THEN patientID ELSE NULL END) AS vacuum,
COUNT(CASE WHEN concept_id = 7820 THEN patientID ELSE NULL END) AS laborMethod,
COUNT(CASE WHEN concept_id = 71137 THEN patientID ELSE NULL END) AS laborMystery,
COUNT(CASE WHEN concept_id = 71279 THEN patientID ELSE NULL END) AS laborDifficultBirth,
COUNT(CASE WHEN concept_id = 7280 THEN patientID ELSE NULL END) AS vitalWeight1,
COUNT(CASE WHEN concept_id = 7248 THEN patientID ELSE NULL END) AS ppVitalBp1,
COUNT(CASE WHEN concept_id = 70792 THEN patientID ELSE NULL END) AS ironSup,
0 AS utilisationPartogramme,
0 AS beneficieGATPA,  
COUNT(CASE WHEN concept_id = 70521 THEN patientID ELSE NULL END) AS laborEvolution,
COUNT(CASE WHEN concept_id = 284746 THEN patientID ELSE NULL END) AS plusDe30Ans,
COUNT(CASE WHEN concept_id = 984746 THEN patientID ELSE NULL END) AS plusDe40Ans,
COUNT(CASE WHEN concept_id = 683632 THEN patientID ELSE NULL END) AS femmesVuesPrenatal, 
COUNT(CASE WHEN concept_id = 70729 THEN patientID ELSE NULL END) AS suiviPrenatal,
COUNT(CASE WHEN concept_id = 70478 THEN patientID ELSE NULL END) AS accouchement ,
COUNT(CASE WHEN concept_id = 7802 THEN patientID ELSE NULL END) AS membraneRuptureDeno
FROM
(
 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e, obs o
 WHERE  o.location_id = e.siteCode
 AND o.encounter_id = e.encounter_id
 AND o.concept_id IN (8039)           
 AND e.encounterType IN (24, 25)            
 GROUP BY 1
 
 UNION  
 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e, obs o
 WHERE  o.location_id = e.siteCode
 AND o.encounter_id = e.encounter_id
 AND o.concept_id IN (7073,70401)           
 AND e.encounterType IN (24, 25)            
 GROUP BY 1
 
 UNION 
 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e, obs o
 WHERE  o.location_id = e.siteCode
 AND o.encounter_id = e.encounter_id
 AND o.concept_id IN (7886,70194 )           
 AND e.encounterType IN (24, 25)  
 GROUP BY 1
 
 UNION 
 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e, obs o
 WHERE  o.location_id = e.siteCode
 AND o.encounter_id = e.encounter_id
 AND o.concept_id IN (70631, 70636,70083, 70152)           
 AND e.encounterType IN (24, 25)  
 GROUP BY 1
 
 UNION 
 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e, obs o
 WHERE  o.location_id = e.siteCode
 AND o.encounter_id = e.encounter_id
 AND o.concept_id IN (70176,71131, 71132, 71133, 71134)           
 AND e.encounterType IN (24, 25)  
 GROUP BY 1
 
  
 UNION 
 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e, obs o
 WHERE  o.location_id = e.siteCode
 AND o.encounter_id = e.encounter_id
 AND o.concept_id IN (70018)           
 AND e.encounterType IN (24, 25)  
 GROUP BY 1
 
  UNION 
 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id  
 FROM encValidAll e, obs o
 WHERE  o.location_id = e.siteCode
 AND o.encounter_id = e.encounter_id
 AND o.concept_id IN (71079, 71080, 71081, 71082)           
 AND e.encounterType IN (24, 25)  
 GROUP BY 1
 
 UNION 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e, obs o,a_vitals v,
(SELECT e.patientID, e.visitDate, value_text AS gestation
FROM  `obs` o, encValidAll e
WHERE e.encounter_id = o.encounter_id
AND o.location_id = e.sitecode
AND concept_id =70750 ) g
 WHERE  o.location_id = e.siteCode
 AND o.encounter_id = e.encounter_id
 AND g.patientID=e.patientID
 AND g.visitDate=e.visitDate 
 AND v.patientID=e.patientID
 AND v.visitDate=e.visitDate 
 AND v.vitalBp1>140 AND v.vitalBp2>90
 AND gestation >= 20
 AND e.encounterType IN (24,25)  
and o.concept_id IN (7007,70168,70593,71138) 
 GROUP BY 1
 
  UNION 
 
SELECT patientID,maxDate, ? AS concept_id  
from (
 SELECT e.patientID, DATE(e.visitDate) AS maxDate
 FROM encValidAll e, obs o,
(SELECT e.patientID, e.visitDate, value_text AS gestation
FROM  `obs` o, encValidAll e
WHERE e.encounter_id = o.encounter_id
AND o.location_id = e.sitecode
AND concept_id =70750 ) g
 WHERE  o.location_id = e.siteCode
 AND o.encounter_id = e.encounter_id
 AND g.patientID=e.patientID
 AND g.visitDate=e.visitDate 
 AND ( 
       (gestation between 14 and 26  AND o.concept_id IN (70635))    
      or ((gestation between 27 and 42  AND o.concept_id IN (70635)) or (concept_id in ( 70069,70132 ) ))
	  ) 
 AND e.encounterType IN (24,25)  
union   
 SELECT e.patientID, DATE(e.visitDate) AS maxDate 
 FROM encValidAll e, obs o
 WHERE  o.location_id = e.siteCode
 AND o.encounter_id = e.encounter_id
 AND concept_id in (7828)  
 AND e.encounterType IN (26)  
)P1
 
  UNION 
 
 SELECT e.patientID, DATE( e.visitDate ) AS maxDate, ? AS concept_id 
FROM  `obs` o,  `obs` o1, encValidAll e
WHERE e.encounter_id = o.encounter_id
AND o.location_id = e.sitecode
AND e.encounter_id = o1.encounter_id
AND o1.location_id = e.sitecode
AND o.concept_id =7802
AND o1.concept_id =7809
AND TIME_TO_SEC( TIMEDIFF( o1.value_datetime, o.value_datetime ) ) /3600 >8
GROUP BY 1 
 
 UNION 
 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e, obs o
 WHERE  o.location_id = e.siteCode
 AND o.encounter_id = e.encounter_id
 AND o.concept_id IN (7200, 70524)           
 AND e.encounterType IN (26)  
 GROUP BY 1
 
 
  UNION 
 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e, obs o
 WHERE  o.location_id = e.siteCode
 AND o.encounter_id = e.encounter_id
 AND o.concept_id IN (7820)           
 AND e.encounterType IN (26)  
 GROUP BY 1
 
 UNION 
 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e, obs o
 WHERE  o.location_id = e.siteCode
 AND o.encounter_id = e.encounter_id
 AND o.concept_id IN (71137)           
 AND e.encounterType IN (26)  
 GROUP BY 1
 
 UNION 
 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e, obs o
 WHERE  o.location_id = e.siteCode
 AND o.encounter_id = e.encounter_id
 AND o.concept_id IN (71279,  71297, 7828, 71281)           
 AND e.encounterType IN (26)  
 GROUP BY 1
 
 UNION 
 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e, a_vitals v
 WHERE  e.patientID = v.patientID
 AND e.visitDate=v.visitDate
 AND vitalWeight>0           
 AND e.encounterType IN (24, 25)  
 GROUP BY 1
 
 
 UNION 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e, a_vitals v
 WHERE  e.patientID = v.patientID
 AND e.visitDate=v.visitDate
 AND vitalBp1>0
 and vitalBp2>0           
 AND e.encounterType IN (24, 25)  
 GROUP BY 1
 
  UNION 

  SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e, a_prescriptions pr
 WHERE  e.patientID = pr.patientID
 AND e.visitDate=pr.visitDate
 AND drugName=?           
 AND e.encounterType IN (24, 25)  
 GROUP BY 1

 
  UNION 
 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e, obs o
 WHERE  o.location_id = e.siteCode
 AND o.encounter_id = e.encounter_id
 AND o.concept_id IN (70521)           
 AND e.encounterType IN (26)  
 GROUP BY 1
 
 UNION
 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e, patient p
 WHERE  e.patientID = p.patientID
 AND YEAR(NOW())-dobYy >= 40         
 AND e.encounterType IN (24, 25)            
 GROUP BY 1
 
 UNION
 
 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id
 FROM encValidAll e,  patient p
 WHERE e.patientID = p.patientID
 AND YEAR(NOW())-dobYy >= 30        
 AND e.encounterType IN (24, 25)            
 GROUP BY 1
 
 UNION
 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e,  patient p
 WHERE e.patientID = p.patientID  
 AND e.encounterType IN (24, 25)            
 GROUP BY 1 
 
 UNION
 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e, obs o
 WHERE  o.location_id = e.siteCode
 AND o.encounter_id = e.encounter_id
 AND o.concept_id IN (70729)           
 AND e.encounterType IN (24, 25)  
 GROUP BY 1
 
  UNION
 
 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e,  obs o, patient p
 WHERE  o.location_id = e.siteCode
 AND e.patientID = p.patientID
 AND o.encounter_id = e.encounter_id       
 AND ((e.encounterType IN (24, 25)  
 AND o.concept_id IN(70472, 70475, 70478) ) OR e.encounterType = 26)          
 GROUP BY 1
 
 UNION 
 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id 
 FROM encValidAll e, obs o
 WHERE  o.location_id = e.siteCode
 AND o.encounter_id = e.encounter_id
 AND o.concept_id in (70086,70114,7009270084,70118,70069,70132,70190,71135,70087,71140,71281,70082,70150,70078,70144,70083,70152)          
 AND e.encounterType IN (24, 25)  
 GROUP BY 1

 UNION 
 SELECT e.patientID, DATE(e.visitDate) AS maxDate, ? AS concept_id
 FROM encValidAll e, obs o,
(SELECT e.patientID, e.visitDate, value_text AS gestation
FROM  `obs` o, encValidAll e
WHERE e.encounter_id = o.encounter_id
AND o.location_id = e.sitecode
AND concept_id =70750 ) g
 WHERE  o.location_id = e.siteCode
 AND o.encounter_id = e.encounter_id
 AND g.patientID=e.patientID
 AND g.visitDate=e.visitDate 
 AND  gestation < 14  AND o.concept_id IN (70635)   
 AND e.encounterType IN (24,25)
 group by 1
 
 UNION 
 
SELECT e.patientID, DATE( e.visitDate ) AS maxDate, ? AS concept_id 
FROM  `obs` o,  `obs` o1, encValidAll e
WHERE e.encounter_id = o.encounter_id
AND o.location_id = e.sitecode
AND e.encounter_id = o1.encounter_id
AND o1.location_id = e.sitecode
AND o.concept_id =7802
AND o1.concept_id =7809
GROUP BY 1 
)t

GROUP BY patientID, maxDate', array('8039','7073','7886','70631','70176','70018','71079','7007','70190','7809','7200','7820','71137','71279','7280','7248','70792','iron','70521','984746','284746','683632','70729','70478','70086','70635','7802'));

}

function obgynSlices($key, $orgType, $time_period) {
	$indicatorQueries = array( 
		-1 => array(0, "where plusDe40Ans >0 ", NULL),
		-2 => array(0, "where plusDe30Ans >0 ", NULL), 
  		-3 => array(0, "where suiviPrenatal >0  ", NULL), 
		-4 => array(0, "where femmesVuesPrenatal> 0 ", NULL),
		-5 => array(0, "where accouchement > 0", NULL),
		-6 => array(0, "where membraneRuptureDeno > 0", NULL),
		 
		1 => array(1, "where mammographDt = 1", array(-1)),
		2 => array(1, "where papTestResult = 1", array(-2)), 
  		3 => array(1, "where leucorhee =1 ", array(-4)), 
		4 => array(0, "where metrorragieSymptom = 1", NULL),
		5 => array(0, "where sexAgression = 1", NULL), 
		 6 => array(0, "where consult_obs = 1", NULL),
		 7 => array(0, "where grossesseHautRisque = 1",NULL), 
		 8 => array(0, "where tetanosDtD1 = 0", NULL),
		 9 => array(0, "where hypertensionArteryA = 1", NULL),
		 10 => array(0, "where hemorragieVaginale = 1", NULL),
		 11 => array(1, "where membraneRupture = 1", array(-6)),
		 12 => array(0, "where vacuum + laborMethod + laborMystery  > 0", NULL),
		 13 => array(0, "where  laborDifficultBirth = 1", NULL),
		 14 => array(1, "where vitalWeight1 = 1", array(-4)),
		 15 => array(1, "where ppVitalBp1 = 1", array(-4)),
		 16 => array(1, "where ironSup = 1", array(-4)),
		 17 => array(0, "where hemorragieVaginalet1 = 1", NULL),
		 18 => array(0, "where laborEvolution = 1", NULL)
	);
	
	if (DEBUG_FLAG) echo "<br>Generate Patient Lists start: " . date('h:i:s') . "<br>";
	// store the patientid lists; don't need any reference to org, since pid contains site info
	foreach ($indicatorQueries as $indicator => $query) {
		foreach ($time_period as $period) {
			if ($period == "Week") $period_value = $period . "(s.visitdate,2) ";
			else $period_value = $period . "(s.visitdate) ";
			if (!is_array($query[1])) {
				 $sql = "insert into dw_obgyn_patients select distinct " . $indicator . ",?, year(s.visitdate), " . $period_value . ", s.patientid from dw_obgyn_snapshot  s " . $query[1]; 
				$rc = database()->query($sql,array($period))->rowCount();
				if (DEBUG_FLAG) echo "<br>Generate Pid List for: " . $indicator . " :" . $sql . " Rows inserted: " . $rc . "<br>"; 
			} else { 
				// anytime $query[1] isn't simple, previous calculations can be used
				generatePidLists("obgyn", $indicator, $query[1], $period);
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
			$sql = "insert into dw_obgyn_slices select ?, " . $org_value . ", " . $indicator . ", time_period, year, period, case when t.sex in (1,2) then t.sex else 4 end, count(distinct p.patientid), 0 
			from dw_obgyn_patients p, patient t 
			where indicator = " . $indicator . " and p.patientid = t.patientid group by 3,4,1,2,5,6,7";
			$rc = database()->query($sql, array($org_unit))->rowCount();
			if (DEBUG_FLAG) {
				echo "<br>Generate simple slices for: " . $indicator . " :" . $sql . " Rows inserted: " . $rc . "<br>"; 
				print_r ($argArray);
			} 
			break;
		case 1: // percent
			//generatePercents('obgyn', $indicator, $org_unit, $org_value, $query);
			break;
		case 2: // this among that
			generateAmongSlices("obgyn", $indicator, $org_unit, $org_value, $query);
			break;
		}
	} 
	generatePercents('obgyn'); 
	if (DEBUG_FLAG) echo "<br>Indicator slices end: " . date('h:i:s') . "<br>";       	
}
?>
