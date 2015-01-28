<? 
function updateDataqualitySnapshot($lastModified) {

database()->query('INSERT INTO   ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT e.patientID, e.visitDate, ? 
 FROM encValidAll e, patient p
 WHERE  e.patientID = p.patientID        
 AND e.encounterType IN (15)            
 GROUP BY 1,YEAR(e.visitDate)  , MONTH(e.visitDate)  , WEEK(e.visitDate) ',array ('C1D'));
echo "\nC1D: " . date('h:i:s') . "\n";  
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) 
 SELECT e.patientID, e.visitDate, ?
 FROM encValidAll e,  patient p
 WHERE e.patientID = p.patientID      
 AND e.encounterType IN (15)
 AND (TRIM(p.dobDd) = ? OR TRIM(p.dobMm)= ? OR TRIM(p.dobYy= ?) OR LOWER(TRIM(p.dobDd)) = ? OR LOWER(TRIM(p.dobMm))= ? OR LOWER(TRIM(p.dobYy)= ?))
 GROUP BY 1 ,YEAR(e.visitDate)  , MONTH(e.visitDate)  , WEEK(e.visitDate) ',array ('C1N','','','','xx','xx','xx'));
echo "\nC1N: " . date('h:i:s') . "\n";

database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)   
 SELECT e.patientID, e.visitDate, ?  
 FROM encValidAll e,  patient p
 WHERE  e.patientID = p.patientID       
 AND e.encounterType IN (10)            
 GROUP BY 1,YEAR(e.visitDate)  , MONTH(e.visitDate)  , WEEK(e.visitDate) ',array ('C2D'));
echo "\nC2D: " . date('h:i:s') . "\n";
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) 
 SELECT e.patientID, e.visitDate, ?  
 FROM encValidAll e,  patient p
 WHERE  e.patientID = p.patientID 
   AND e.patientID = p.patientID      
 AND e.encounterType IN (10)
 AND (TRIM(p.dobDd) =? OR TRIM(p.dobMm)=? OR TRIM(p.dobYy=?) OR LOWER(TRIM(p.dobDd)) =? OR LOWER(TRIM(p.dobMm))=? OR LOWER(TRIM(p.dobYy)=?))       
 GROUP BY 1 ,YEAR(e.visitDate)  , MONTH(e.visitDate)  , WEEK(e.visitDate) ',array ('C2N','','','','xx','xx','xx'));
echo "\nC2N: " . date('h:i:s') . "\n";
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)   
 SELECT e.patientID, e.visitDate, ?  
 FROM encValidAll e,  patient p
 WHERE e.patientID = p.patientID 
   AND e.encounterType IN (15, 10)            
 GROUP BY 1, YEAR(e.visitDate)  , MONTH(e.visitDate)  , WEEK(e.visitDate) ',array ('C3D'));
echo "\nC3D: " . date('h:i:s') . "\n";

database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT e.patientID, e.visitDate, ?  
 FROM encValidAll e, patient p
 WHERE  e.patientID = p.patientID      
 AND e.encounterType IN (15, 10)
 AND (TRIM(p.dobDd) =? OR TRIM(p.dobMm)=? OR TRIM(p.dobYy=?) OR LOWER(TRIM(p.dobDd)) =? OR LOWER(TRIM(p.dobMm))=? OR LOWER(TRIM(p.dobYy)=?))
 GROUP BY 1,YEAR(e.visitDate)  , MONTH(e.visitDate)  , WEEK(e.visitDate) ',array ('C3N','','','','xx','xx','xx'));
echo "\nC3N: " . date('h:i:s') . "\n";

database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)  
 SELECT patientID, visitDate, ?  
 FROM encValidAll
 where encounterType IN (16, 17, 29, 31)
 GROUP BY 1, YEAR(visitDate)  , MONTH(visitDate)  , WEEK(visitDate) ',array ('C4D')); 
echo "\nC4D: " . date('h:i:s') . "\n";	
	
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) 
 SELECT patientID, visitDate, ?  
 FROM a_vitals
 WHERE (TRIM(vitalHeight)=? OR TRIM(vitalHeight)=? OR vitalHeight IS NULL) AND (TRIM(vitalHeightCm)=? OR TRIM(vitalHeightCm)=? OR vitalHeightCm IS NULL)
  AND encounterType IN (16, 17, 29, 31)
 GROUP BY 1 ,YEAR(visitDate)  , MONTH(visitDate)  , WEEK(visitDate) ',array ('C4N','','0','','0')); 
echo "\nC4N: " . date('h:i:s') . "\n";

database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT patientID, visitDate, ?  
 FROM encValidAll
 where encounterType IN (1, 2, 27, 28)
 GROUP BY 1, YEAR(visitDate) , MONTH(visitDate)  , WEEK(visitDate) ',array ('C5D')); 
echo "\nC5D: " . date('h:i:s') . "\n";

database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT patientID, visitDate,   ?  
 FROM a_vitals
 WHERE (TRIM(vitalHeight)=? OR TRIM(vitalHeight)=? OR vitalHeight IS NULL) AND (TRIM(vitalHeightCm)=? OR TRIM(vitalHeightCm)=? OR vitalHeightCm IS NULL)
 and encounterType IN (1, 2, 27, 28)
 GROUP BY 1,YEAR(visitDate)  , MONTH(visitDate)  , WEEK(visitDate) ', array ('C5N','','0','','0')); 
echo "\nC5N: " . date('h:i:s') . "\n"; 
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)  
 SELECT patientID, visitDate,   ?   
 FROM encValidAll
 where encounterType IN (1, 2, 16, 17, 27, 28, 29, 31)
 GROUP BY 1, YEAR(visitDate)  , MONTH(visitDate)  , WEEK(visitDate) ', array ('C6D'));
echo "\nC6D: " . date('h:i:s') . "\n"; 
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT patientID, visitDate,   ?  
 FROM a_vitals
 WHERE (TRIM(vitalHeight)=? OR TRIM(vitalHeight)=? OR vitalHeight IS NULL) AND (TRIM(vitalHeightCm)=? OR TRIM(vitalHeightCm)=? OR vitalHeightCm IS NULL)
 AND encounterType IN (1, 2, 16, 17, 27, 28, 29, 31)
 GROUP BY 1 ,YEAR(visitDate)  , MONTH(visitDate)  , WEEK(visitDate)', array ('C6N','','0','','0'));
echo "\nC6N: " . date('h:i:s') . "\n"; 
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) 
 SELECT patientID, visitDate,   ?  
 FROM encValidAll
 where encounterType IN (16, 17, 29, 31)
 GROUP BY 1, YEAR(visitDate)  , MONTH(visitDate)  , WEEK(visitDate) ', array ('C7D'));
echo "\nC7D: " . date('h:i:s') . "\n"; 
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) 
 SELECT patientID, visitDate, ?
 FROM a_vitals
 WHERE (TRIM(vitalWeight)=? OR TRIM(vitalWeight)=? OR vitalWeight IS NULL)
 and  encounterType IN (16, 17, 29, 31)
 GROUP BY 1 ,YEAR(visitDate)  , MONTH(visitDate)  , WEEK(visitDate) ', array ('C7N','','0'));
echo "\nC7N: " . date('h:i:s') . "\n"; 
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) 
 SELECT patientID, visitDate, ?
 FROM encValidAll  
 where encounterType IN (1, 2, 27, 28)
 GROUP BY 1, YEAR(visitDate)  , MONTH(visitDate)  , WEEK(visitDate) ', array ('C8D'));
echo "\nC8D: " . date('h:i:s') . "\n"; 
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) 
 SELECT patientID, visitDate  ,   ?  
 FROM a_vitals
 WHERE (TRIM(vitalWeight)=? OR TRIM(vitalWeight)=? OR vitalWeight IS NULL)
 and encounterType IN (1, 2, 27, 28)
 GROUP BY 1 ,YEAR(visitDate)  , MONTH(visitDate)  , WEEK(visitDate) ', array ('C8N','','0'));
echo "\nC8N: " . date('h:i:s') . "\n"; 
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)  
 SELECT patientID, visitDate, ?   
 FROM encValidAll
where encounterType IN (1, 2, 16, 17, 27, 28, 29, 31)
 GROUP BY 1, YEAR(visitDate)  , MONTH(visitDate)  , WEEK(visitDate) ', array ('C9D'));
echo "\nC9D: " . date('h:i:s') . "\n"; 
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) 
 SELECT patientID, visitDate, ?  
 FROM a_vitals  
 WHERE (TRIM(vitalWeight)=? OR TRIM(vitalWeight)=? OR vitalWeight IS NULL)
 and encounterType IN (1, 2, 16, 17, 27, 28, 29, 31)
 GROUP BY 1 ,YEAR(visitDate)  , MONTH(visitDate)  , WEEK(visitDate) ', array ('C9N','','0'));
echo "\nC9N: " . date('h:i:s') . "\n";  
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) 
 SELECT v.patientID, v.visitDate, ? 
 FROM patient p 
 JOIN a_vitals v ON p.patientID = v.patientID 
 WHERE (YEAR(v.visitDate) - p.dobYy) BETWEEN 15 AND 49  
 AND p.sex = 1 
 and v.encounterType IN (1,2, 27, 28)
 GROUP BY 1,YEAR( v.visitDate ) , MONTH( v.visitDate ) , WEEK( v.visitDate )', array ('C10D'));
echo "\nC10D: " . date('h:i:s') . "\n"; 
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) 
 SELECT v.patientID, v.visitDate, ?  
 FROM a_vitals v
 JOIN patient p ON v.patientID = p.patientID
 WHERE (YEAR(visitDate) - p.dobYy) BETWEEN 15 AND 49  
 AND p.sex = 1 
 and v.encounterType IN (1,2, 27, 28)
 AND v.pregnant NOT IN (1, 2, 4)       
 GROUP BY 1,YEAR(v.visitDate)  , MONTH(v.visitDate)  , WEEK(v.visitDate) ', array ('C10N')); 
echo "\nC10N: " . date('h:i:s') . "\n"; 

database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)   
 SELECT patientID, visitDate, ? 
 FROM a_medicalEligARVs 
 WHERE encounterType IN (16, 17) 
 GROUP BY 1 ,YEAR(visitDate) , MONTH(visitDate) , WEEK(visitDate)', array ('C11D'));
echo "\nC11D: " . date('h:i:s') . "\n"; 
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)    
 SELECT patientID, visitDate, ?
 FROM a_medicalEligARVs 
 WHERE encounterType IN (16, 17) 
 and (medElig IS NULL OR medElig =0)
 AND ((cd4LT200!=0 OR cd4LT200 IS NOT NULL) 
      OR (tlcLT1200!=0 OR tlcLT1200 IS NOT NULL) 
      OR (WHOIV!=0 OR WHOIV IS NOT NULL)
      OR (WHOIII!=0 OR WHOIII IS NOT NULL)
      OR (PMTCT!=0 OR PMTCT IS NOT NULL)
      OR (medEligHAART!=0 OR medEligHAART IS NOT NULL)
      OR (formerARVtherapy!=0 OR formerARVtherapy IS NOT NULL)
      OR (PEP!=0 OR PEP IS not NULL))
 GROUP BY 1 ,YEAR(visitDate) , MONTH(visitDate) , WEEK(visitDate)', array ('C11N'));
echo "\nC11N: " . date('h:i:s') . "\n";  
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT patientID, visitDate  ,   ?  
 FROM a_medicalEligARVs
 WHERE  encounterType IN (1, 2)
 GROUP BY 1 ,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)', array ('C12D'));
echo "\nC12D: " . date('h:i:s') . "\n";
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT patientID, visitDate, ?  
 FROM a_medicalEligARVs
 WHERE (medElig IS not NULL OR medElig !=0)
 AND encounterType IN (1, 2)
 and (medElig IS NULL OR medElig =0)
 AND ((cd4LT200!=0 OR cd4LT200 IS NOT NULL) 
      OR (tlcLT1200!=0 OR tlcLT1200 IS NOT NULL) 
      OR (WHOIV!=0 OR WHOIV IS NOT NULL)
      OR (WHOIII!=0 OR WHOIII IS NOT NULL)
      OR (PMTCT!=0 OR PMTCT IS NOT NULL)
      OR (medEligHAART!=0 OR medEligHAART IS NOT NULL)
      OR (formerARVtherapy!=0 OR formerARVtherapy IS NOT NULL)
      OR (PEP!=0 OR PEP IS not NULL))
 GROUP BY 1 ,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)', array ('C12N'));
echo "\nC12N: " . date('h:i:s') . "\n";  
 
 database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) 
 SELECT patientID, visitDate, ?  
 FROM a_medicalEligARVs
 WHERE encounterType IN (1, 2, 16, 17) 
 GROUP BY 1 ,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)', array ('C13D'));
echo "\nC13D: " . date('h:i:s') . "\n";
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) 
 SELECT patientID, visitDate, ?  
 FROM a_medicalEligARVs
 WHERE encounterType IN (1, 2, 16, 17) and (medElig IS not NULL OR medElig !=0)
 AND ((cd4LT200=0 OR cd4LT200 IS NULL) 
      AND (tlcLT1200=0 OR tlcLT1200 IS NULL) 
      AND (WHOIV=0 OR WHOIV IS NULL)
      AND (WHOIII=0 OR WHOIII IS NULL)
      AND (PMTCT=0 OR PMTCT IS NULL)
      AND (medEligHAART=0 OR medEligHAART IS NULL)
      AND (formerARVtherapy=0 OR formerARVtherapy IS NULL)
      AND (PEP=0 OR PEP IS NULL))
 GROUP BY 1 ,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)', array ('C13N'));
echo "\nC13N: " . date('h:i:s') . "\n"; 
   
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT t.patientID, t.visitDate, ?  
 FROM v_tbStatus t
 JOIN pedHistory p ON (t.patientID = p.patientID AND t.visitDateDd = p.visitDateDd AND t.visitDateMm = p.visitDateMm AND t.visitDateYy = p.visitDateYy and t.seqNum = p.seqNum and t.sitecode = p.sitecode)
 WHERE t.encounterType IN (16, 17) 
 and ((p.pedMotherHistRecentTb = 0 OR p.pedMotherHistRecentTb IS NULL) 
AND (p.pedMotherHistActiveTb =0 OR p.pedMotherHistActiveTb IS NULL)
AND (p.pedMotherHistTreatTb = 0 OR p.pedMotherHistTreatTb IS NULL))
AND (((t.asymptomaticTb = 0 OR t.asymptomaticTb IS NULL) 
AND (t.currentTreat = 0 OR t.currentTreat IS NULL)
AND (t.completeTreat =0 OR t.completeTreat IS NULL) 
AND (t.propINH =0 OR t.propINH IS NULL))
OR ((t.pedTbEvalRecentExp =0 OR t.pedTbEvalRecentExp IS NULL) 
OR (t.suspicionTBwSymptoms=0 OR t.suspicionTBwSymptoms IS NULL)
OR (t.presenceBCG = 0 OR t.presenceBCG IS NULL)
OR (t.noTBsymptoms = 0 OR t.noTBsymptoms IS NULL)))   
GROUP BY 1 ,YEAR(t.visitDate), MONTH(t.visitDate), WEEK(t.visitDate)', array ('C14N'));
echo "\nC14N: " . date('h:i:s') . "\n";
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT patientID, visitDate, ?  
 FROM encValid
 where encounterType IN (16, 17)
 GROUP BY 1 ,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)', array ('C14D'));
echo "\nC14D: " . date('h:i:s') . "\n";
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT patientID, visitDate, ?  
 FROM v_tbStatus
 WHERE encounterType IN (1, 2)
 and (((asymptomaticTb = 0 OR asymptomaticTb IS NULL) 
AND (completeTreat =0 OR completeTreat IS NULL)
AND (currentTreat = 0 OR currentTreat IS NULL))
OR ((presenceBCG = 0 OR presenceBCG IS NULL) 
AND (recentNegPPD = 0 OR recentNegPPD IS NULL) 
AND (statusPPDunknown = 0 OR statusPPDunknown IS NULL) 
AND (propINH = 0 OR propINH IS NULL)
AND (suspicionTBwSymptoms = 0 OR suspicionTBwSymptoms IS NULL)
AND (noTBsymptoms = 0 OR noTBsymptoms IS NULL)))   
GROUP BY 1,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)',array ('C15N')); 
echo "\nC15N: " . date('h:i:s') . "\n";

database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT patientID, visitDate, ?  
 FROM encValid 
 where encounterType IN (1, 2)
 GROUP BY 1 ,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)', array ('C15D'));
echo "\nC15D: " . date('h:i:s') . "\n"; 

database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
SELECT patientID, visitDate, ?   
FROM a_discEnrollment
WHERE encounterType IN (21)
AND partStop = 1 
AND (ymdToDate( disEnrollYy, disEnrollMm, disEnrollDd) IS NULL
OR((reasonDiscNoFollowup = 0 OR reasonDiscNoFollowup IS NULL)
AND(reasonDiscTransfer = 0 OR reasonDiscTransfer IS NULL)
AND(reasonDiscDeath = 0 OR reasonDiscDeath IS NULL)
AND(reasonDiscOther = 0 OR reasonDiscOther IS NULL)
AND(reasonUnknownClosing = 0 OR reasonUnknownClosing IS NULL)))
  GROUP BY 1 ,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)', array ('C17N'));
echo "\nC17N: " . date('h:i:s') . "\n";  
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
  SELECT patientID, visitDate, ?   
  FROM a_discEnrollment
  WHERE encounterType = 21 and partStop = 1  
  GROUP BY 1 ,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)', array ('C17D'));
echo "\nC17D: " . date('h:i:s') . "\n";  
  
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
  SELECT patientID, visitDate, ?   
FROM a_discEnrollment       
WHERE encounterType = 12 and partStop = 1 
AND (ymdToDate( disEnrollYy, disEnrollMm, disEnrollDd) IS NULL
OR((reasonDiscNoFollowup = 0 OR reasonDiscNoFollowup IS NULL)
AND(reasonDiscTransfer = 0 OR reasonDiscTransfer IS NULL)
AND(reasonDiscDeath = 0 OR reasonDiscDeath IS NULL)
AND(reasonDiscOther = 0 OR reasonDiscOther IS NULL)
AND(reasonUnknownClosing = 0 OR reasonUnknownClosing IS NULL)))      
GROUP BY 1 ,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)', array ('C18N'));
echo "\nC18N: " . date('h:i:s') . "\n";  
  
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
  SELECT patientID, visitDate, ?   
FROM a_discEnrollment       
WHERE encounterType = 12 and partStop = 1
  GROUP BY 1 ,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)', array ('C18D'));
echo "\nC18D: " . date('h:i:s') . "\n";  
  
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
SELECT patientID, visitDate, ?   
FROM a_discEnrollment 
WHERE encounterType IN (12, 21) and partStop = 1 
AND (ymdToDate( disEnrollYy, disEnrollMm, disEnrollDd) IS NULL
OR((reasonDiscNoFollowup = 0 OR reasonDiscNoFollowup IS NULL)
AND(reasonDiscTransfer = 0 OR reasonDiscTransfer IS NULL)
AND(reasonDiscDeath = 0 OR reasonDiscDeath IS NULL)
AND(reasonDiscOther = 0 OR reasonDiscOther IS NULL)
AND(reasonUnknownClosing = 0 OR reasonUnknownClosing IS NULL)))   
GROUP BY 1 ,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)', array ('C19N'));
echo "\nC19N: " . date('h:i:s') . "\n";  
  
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) 
  SELECT patientID, visitDate, ?   
 FROM a_discEnrollment
 WHERE encounterType IN (12, 21) and partStop = 1 
  GROUP BY 1,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)',array ('C19D'));
echo "\nC19D: " . date('h:i:s') . "\n";  
  
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT patientID, visitDate, ?   
 FROM encValidAll
 WHERE encounterType IN (10,15)            
 GROUP BY 1,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)', array ('A1D'));
echo "\nA1D: " . date('h:i:s') . "\n"; 
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT e.patientID, e.visitDate, ?
 FROM encValidAll e, patient p
 WHERE e.patientID = p.patientID
 AND e.encounterType IN (10,15)
 AND (CAST(TRIM(p.dobDd) AS UNSIGNED) >31 OR CAST(TRIM(p.dobMm)AS UNSIGNED) >12 OR CAST(TRIM(p.dobYy)AS UNSIGNED)<1904  OR CAST(TRIM(p.dobYy)AS UNSIGNED)> YEAR(e.visitDate)
 OR ymdToDate(p.dobYy,p.dobMm,p.dobDd) > e.visitDate)
 GROUP BY 1,YEAR(e.visitDate), MONTH(e.visitDate), WEEK(e.visitDate)', array ('A1N'));
echo "\nA1N: " . date('h:i:s') . "\n"; 
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
  SELECT e.patientID, e.visitDate, ?
 FROM encValidAll e, patient p
 WHERE e.patientID = p.patientID
 AND e.encounterType IN (10,15)
 AND ((DATEDIFF(e.visitDate, ymdToDate(p.dobYy,p.dobMm,p.dobDd) )) - p.ageYears*365) > 1068       
 GROUP BY 1,YEAR(e.visitDate), MONTH(e.visitDate), WEEK(e.visitDate)', array ('A2N'));
echo "\nA2N: " . date('h:i:s') . "\n"; 
 
 database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)  
SELECT e.patientID, e.visitDate,   ?   
FROM encValidAll e, patient p
 WHERE e.patientID = p.patientID      
 AND e.encounterType IN (10,15)
 AND (SUBSTRING(p.`nationalID`,3,2) != TRIM(p.`dobMm`) OR SUBSTRING(p.`nationalID`,5,2) != SUBSTRING(TRIM(p.`dobYy`),3,2))
 GROUP BY 1,YEAR(e.visitDate), MONTH(e.visitDate), WEEK(e.visitDate)', array ('A3N'));
echo "\nA3N: " . date('h:i:s') . "\n"; 
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
   SELECT e.patientID, e.visitDate, ?  
 FROM encValidAll e,  patient p
 WHERE  e.patientID = p.patientID
 AND ((( YEAR(e.visitDate) -YEAR(ymdToDate(p.dobYy, p.dobMm, p.dobDd)) < 15) and e.encounterType =10 ) 
 OR  (( YEAR(e.visitDate)-YEAR(ymdToDate(p.dobYy, p.dobMm, p.dobDd)) > 15) and e.encounterType=15))
 GROUP BY 1,YEAR(e.visitDate), MONTH(e.visitDate), WEEK(e.visitDate)', array ('A4N'));
echo "\nA4N: " . date('h:i:s') . "\n"; 
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
  SELECT e.patientID, e.visitDate, ?
 FROM encValidAll e,  patient p
 WHERE  e.patientID = p.patientID
 AND e.encounterType IN (10,15)
 AND (YEAR(e.visitDate)-YEAR(ymdToDate(p.dobYy,p.dobMm,p.dobDd)) <15 ) 
 AND  p.maritalStatus IN (1,2,4,8)
 GROUP BY 1,YEAR(e.visitDate)  , MONTH(e.visitDate)  , WEEK(e.visitDate)', array ('A5N'));
echo "\nA5N: " . date('h:i:s') . "\n"; 
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT e.patientID, e.visitDate, ?   
 FROM encValidAll e, patient p
 WHERE   e.patientID = p.PatientID
 AND p.`sex` = 2               
 GROUP BY 1,YEAR(e.visitDate)  , MONTH(e.visitDate)  , WEEK(e.visitDate)',array ('A7D'));
echo "\nA7D: " . date('h:i:s') . "\n"; 
 
  database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
  SELECT v.patientID, v.visitDate, ?
 FROM patient p, a_vitals v
 WHERE v.patientID = p.PatientID
 AND p.sex =2     
 AND  ( (v.gravida is not null  and   v.gravida <>?)
   or (v.para is not null and v.para <>?)
   or (v.aborta is not null and v.aborta <>?)
   or (v.children is not null and v.children <>?)
   or (v.papTest is not null  and papTest <>?)
   or (papTestYy is not null and papTestYy <>?)
   or (pregnant is not null and pregnant <>?)
   or (pregnantPrenatal is not null and pregnantPrenatal <>?)
   or (pregnantLmpYy is not null and pregnantLmpYy <>?)
   or (pregnantPrenatalFirstYy is not null and pregnantPrenatalFirstYy <>?)
   or (pregnantPrenatalLastYy is not null and pregnantPrenatalLastYy <>?)
   or (pedReproHealthMenses is not null and pedReproHealthMenses <>?)
   or (pedPapTestRes is not null and pedPapTestRes <>?)
 )
 AND v.encounterType IN (1, 2, 24, 25, 26, 27, 28) 
 GROUP BY 1,YEAR(v.visitDate), MONTH(v.visitDate), WEEK(v.visitDate)',array ('A7N','','','','','0','','0','0','','','','0','0'));
echo "\nA7N: " . date('h:i:s') . "\n"; 

database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT e.patientID, e.visitDate, ?   
 FROM encValidAll e
 WHERE e.encounterType IN (1, 2, 16, 17, 27, 28, 29, 31)
 GROUP BY 1,YEAR(e.visitDate), MONTH(e.visitDate), WEEK(e.visitDate)',array ('A8D')); 
echo "\nA8D: " . date('h:i:s') . "\n"; 

database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
SELECT e.patientID, e.visitDate, ?  
FROM encValidAll e, obs o, patient p
WHERE o.location_id = e.siteCode
AND o.encounter_id = e.encounter_id
AND e.patientID = p.patientID  
AND e.encounterType IN (1, 2, 16, 17, 27, 28, 29, 31)
AND ( (o.concept_id IN (70189,70378) AND p.sex = 1) OR
(o.concept_id IN (70194, 70590,70010,70190,70192,70196,70377,70154, 70155,70079) AND p.sex = 2) )
GROUP BY 1,YEAR(e.visitDate)  , MONTH(e.visitDate)  , WEEK(e.visitDate)',array ('A8N'));
echo "\nA8N: " . date('h:i:s') . "\n"; 
  
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
SELECT e.patientID, e.visitDate, ?  
FROM encValidAll e
WHERE e.encounterType IN (6,13,19)
GROUP BY 1,YEAR(e.visitDate)  , MONTH(e.visitDate)  , WEEK(e.visitDate)',array ('A9D'));
echo "\nA9D: " . date('h:i:s') . "\n";

database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) 
SELECT e.patientID, e.visitDate, ?  
FROM encValidAll e, obs o, patient p
WHERE o.encounter_id = e.encounter_id
AND e.patientID = p.patientID
AND e.encounterType IN (6,13,19)
AND ( (o.concept_id IN (70074) AND p.sex = 1) OR (o.concept_id IN (70399,70400,7073,70073) AND p.sex = 2) )
GROUP BY 1,YEAR(e.visitDate)  , MONTH(e.visitDate)  , WEEK(e.visitDate) ',array ('A9N'));
echo "\nA9N: " . date('h:i:s') . "\n"; 
  
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) 
 SELECT patientID, visitDate, ?   
 FROM  a_prescriptions
 WHERE encounterType IN (5,18)  GROUP BY 1,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)',array ('A11D')); 
echo "\nA11D: " . date('h:i:s') . "\n"; 

database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)  
 SELECT patientID,visitDate, ?   
 FROM a_prescriptions
 WHERE encounterType IN (5,18) AND
 (visitDate >= ymdtodate(dispDateYy,dispDateMm,dispDateDd) OR DATEDIFF(ymdtodate(dispDateYy,dispDateMm,dispDateDd),visitDate) > 30)
 AND drugID IN (1,8,10,12,20,29,31,33,34,11,23,5,6,16,17,21)
 GROUP BY 1,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)',array ('A11N')); 
echo "\nA11N: " . date('h:i:s') . "\n"; 

database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) 
SELECT patientID,visitDate,concept_id FROM ( 
 SELECT patientID, visitDate, ? AS concept_id ,
  COUNT(distinct numDaysDesc) as numDaysDesc, count(distinct ymdToDate(dispDateYy,dispDateMm,dispDateDd)) as dispDate, count(distinct dispAltNumDaysSpecify) as dispAltNumDaysSpecify
  FROM a_prescriptions
  WHERE encounterType IN (5,18) AND drugID IN (1,8,10,12,20,29,31,33,34)
  GROUP BY patientID, visitDate having numDaysDesc > 1 or dispDate > 1 or dispAltNumDaysSpecify > 1
) p',array ('A12N')); 
echo "\nA12N: " . date('h:i:s') . "\n";

database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT patientID, visitDate, ?   
 FROM encValidAll 
 GROUP BY 1,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)',array ('A14D'));
echo "\nA14D: " . date('h:i:s') . "\n"; 
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT patientID, visitDate, ?   
 FROM encValidAll
 WHERE visitDate < ? OR visitDate > createDate
 GROUP BY 1,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)',array ('A14N','2004-01-01'));
echo "\nA14N: " . date('h:i:s') . "\n";

database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
SELECT e.patientID, e.visitDate, ?   
FROM encValidAll e,(SELECT patientID, visitDate FROM encValidAll e WHERE encounterType IN (10,15)) A
WHERE e.patientID=A.patientID AND e.visitDate < A.visitDate
AND e.encounterType NOT IN (10,15)
 GROUP BY 1,YEAR(e.visitDate)  , MONTH(e.visitDate)  , WEEK(e.visitDate)',array ('A15N'));
echo "\nA15N: " . date('h:i:s') . "\n"; 

 database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) SELECT patientID, visitDate, ? AS concept_id FROM ( 
SELECT e.patientID,e.visitDate, ?   
FROM encValidAll e,(SELECT patientID, visitDate FROM encValidAll e WHERE encounterType IN (1)) A
WHERE e.patientID=A.patientID
AND e.visitDate<A.visitDate
AND e.encounterType  IN (2,3,4,5,6,7,8,9,11,12,13,14)
 GROUP BY 1,YEAR(e.visitDate)  , MONTH(e.visitDate)  , WEEK(e.visitDate) 
UNION
SELECT e.patientID,e.visitDate, ?   
FROM encValidAll e,(SELECT patientID, visitDate FROM encValidAll e WHERE encounterType IN (16)) A
WHERE e.patientID=A.patientID
AND e.visitDate<A.visitDate
AND e.encounterType  IN (17,18,19,20,21)
 GROUP BY 1,YEAR(e.visitDate)  , MONTH(e.visitDate)  , WEEK(e.visitDate) 
UNION
SELECT e.patientID,e.visitDate, ?   
FROM encValidAll e,(SELECT patientID, visitDate FROM encValidAll e WHERE encounterType IN (24)) A
WHERE e.patientID=A.patientID
AND e.visitDate<A.visitDate
AND e.encounterType  IN (25,26)
 GROUP BY 1,YEAR(e.visitDate)  , MONTH(e.visitDate)  , WEEK(e.visitDate) 
UNION
SELECT e.patientID,e.visitDate, ?   
FROM encValidAll e,(SELECT patientID, visitDate FROM encValidAll e WHERE encounterType IN (27)) A
WHERE e.patientID=A.patientID
AND e.visitDate<A.visitDate
AND e.encounterType  IN (28)
 GROUP BY 1,YEAR(e.visitDate)  , MONTH(e.visitDate)  , WEEK(e.visitDate) 
UNION
SELECT e.patientID,e.visitDate, ?   
FROM encValidAll e,(SELECT patientID, visitDate FROM encValidAll e WHERE encounterType IN (29)) A
WHERE e.patientID=A.patientID
AND e.visitDate<A.visitDate
AND e.encounterType  IN (31)
 GROUP BY 1,YEAR(e.visitDate)  , MONTH(e.visitDate)  , WEEK(e.visitDate)) q',array ('A16N','A16N','A16N','A16N','A16N','A16N'));
echo "\nMulti: " . date('h:i:s') . "\n";
 
database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)  
  SELECT patientID, visitDate, ?   
 FROM a_prescriptions
 WHERE encounterType IN (5,18)
 AND
 (visitDate > ymdToDate(dispDateYy, dispDateMm, dispDateDd)
 OR
 DATEDIFF(ymdToDate(dispDateYy,dispDateMm,dispDateDd),visitDate) >= 30)
 GROUP BY 1,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)',array ('A17N')); 
echo "\nA17N: " . date('h:i:s') . "\n"; 
  
 database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) 
SELECT patientID, visitDate, ?
FROM encValidAll
WHERE encounterType IN (6,13,19)
GROUP BY 1,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)',array ('A18D'));
echo "\nA18D: " . date('h:i:s') . "\n"; 
 
 database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT patientID, visitDate, ?  
 FROM a_labs 
 WHERE encounterType IN (6,13,19)
 AND
  (
  visitDate > ymdToDate(resultDateYy,resultDateMm,resultDateDd)
  OR
DATEDIFF(ymdToDate(resultDateYy,resultDateMm,resultDateDd),visitDate) > 30
  )
 GROUP BY 1,YEAR(visitDate) , MONTH(visitDate) , WEEK(visitDate)',array ('A18N')); 
echo "\nA18N: " . date('h:i:s') . "\n"; 
 
 database()->query('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT patientID, visitDate, ?   
 FROM a_labs
 WHERE encounterType IN (6,13,19)
 AND labID = 176
 AND (result IS NOT NULL OR result2 IS NOT NULL)
 GROUP BY 1,YEAR(visitDate) , MONTH(visitDate) , WEEK(visitDate)',array ('A20D'));
echo "\nA20D: " . date('h:i:s') . "\n"; 

DATABASE()->QUERY('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) SELECT patientID, visitDate, ? AS concept_id FROM (
 SELECT patientID, visitDate, ?   
 FROM a_prescriptions
 WHERE (visitDate > ymdToDate(dispDateYy,dispDateMm,dispDateDd) OR DATEDIFF(ymdToDate(dispDateYy,dispDateMm,dispDateDd),visitDate) > 30)
 AND drugID IN (1,8,10,12,20,29,31,33,34,11,23,5,6,16,17,21)
 GROUP BY 1,YEAR(visitDate) , MONTH(visitDate) , WEEK(visitDate) 
 UNION 
  SELECT patientID, visitDate, ?
 FROM a_prescriptions
 WHERE drugID IN (1,8,10,12,20,29,31,33,34)
 GROUP BY patientID,visitDate
 HAVING COUNT(*) < 2) q',array ('A19N','A11N','A12N')); 
echo "\nA12N: " . date('h:i:s') . "\n"; 
 
DATABASE()->QUERY('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
 SELECT patientID, visitDate, ?
 FROM a_prescriptions
 GROUP BY 1,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)',array ('A19D')); 
echo "\nA19D: " . date('h:i:s') . "\n";

DATABASE()->QUERY('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id) 
  SELECT patientID, visitDate, ?  
 FROM a_labs
 WHERE encounterType IN (6,13,19) AND labID = 176
 AND (
 (result <= 0 OR result > 2000) OR (result2 < 0 OR result2 >68)
 )
 GROUP BY 1,YEAR(visitDate)  , MONTH(visitDate)  , WEEK(visitDate) ',array ('A20N'));
echo "\nA20N: " . date('h:i:s') . "\n";
 
DATABASE()->QUERY('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . ' (patientID, maxDate, concept_id)
  SELECT patientID, visitDate, ?   
 FROM encValidAll
 WHERE DATEDIFF(createDate, visitDate) >= 3
 GROUP BY 1,YEAR(visitDate), MONTH(visitDate), WEEK(visitDate)',array ('t1N'));
echo "\nt1N: " . date('h:i:s') . "\n";
  
  DATABASE()->QUERY('INSERT INTO dw_dataquality_snapshot
SELECT patientID, maxDate AS visiteDate,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A1D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A1N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A2N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A3N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A4N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A5N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A6N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A7N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A7D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A8N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A8D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A9N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A9D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A10N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A10D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A11D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A11N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A12N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A13N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A14D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A14N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A15N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A16N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A17N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A18N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A18D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A19N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A19D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A20D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS A20N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C1D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C1N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C2D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C2N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C3D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C3N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C4D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C4N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C5D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C5N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C6D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C6N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C7D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C7N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C8D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C8N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C9D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C9N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C10D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C10N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C11N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C11D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C12N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C12D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C13N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C13D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C14N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C14D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C15N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C15D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C16N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C16D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C17N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C17D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C18N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C18D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C19N,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS C19D,
COUNT(CASE WHEN concept_id = ? THEN patientID ELSE NULL END) AS t1N
FROM ' . $GLOBALS['tempTableNames'][1] . '
GROUP BY patientID, maxDate', array('A1D','A1N', 'A2N','A3N','A4N','A5N','A6N','A7N','A7D','A8N','A8D','A9N','A9D','A10N','A10D','A11D','A11N','A12N','A13N','A14D','A14N','A15N' ,'A16N','A17N','A18N','A18D','A19N','A19D','A20D','A20N','C1D','C1N','C2D','C2N','C3D','C3N','C4D','C4N','C5D','C5N','C6D',
'C6N','C7D','C7N','C8D','C8N','C9D','C9N','C10D','C10N','C11N','C11D','C12N','C12D','C13N','C13D','C14N','C14D','C15N','C15D','C16N','C16D','C17N','C17D','C18N','C18D','C19N','C19D','t1N'));
echo "\nFinal into snapshot: " . date('h:i:s') . "\n";
}

function dataqualitySlices($key, $orgType, $time_period) {

$indicatorQueries = array (
   // Denominators
    -1 => array(0, "where C1D > 0", NULL), 
    -2 => array(0, "where C2D > 0", NULL), 
    -3 => array(0, "where C3D > 0", NULL),
    -4 => array(0, "where C4D > 0", NULL),   
    -5 => array(0, "where C5D > 0", NULL),
    -6 => array(0, "where C5D + C4D > 0", NULL),   
    -7 => array(0, "where C7D > 0", NULL),
/*	-8 => array(0, "where C8D > 0", NULL),
	-9 => array(0, "where C9D > 0", NULL),*/
	-10 => array(0, "where C10D > 0", NULL),
	-11 => array(0, "where C11D > 0", NULL),
	-12 => array(0, "where C12D > 0", NULL),
	-13 => array(0, "where C11D + C12D > 0", NULL),
	-14=> array(0, "where C14D > 0", NULL),
	-15 => array(0, "where C15D > 0", NULL),
	/*-16 => array(0, "where C16D > 0", NULL),*/
	-17 => array(0, "where C17D > 0", NULL),
	-18 => array(0, "where C18D > 0", NULL),
	-19 => array(0, "where C17D + C18D > 0", NULL),
	-20 => array(0, "where A1D > 0", NULL),
	-21 => array(0, "where A7D > 0", NULL),
	-22 => array(0, "where A8D > 0", NULL),
	-23 => array(0, "where A9D > 0", NULL),
	-24 => array(0, "where A11D > 0", NULL),
	-25 => array(0, "where A14D > 0", NULL),
	-26 => array(0, "where A18D > 0", NULL),
	-27 => array(0, "where A19D > 0", NULL),
	-28 => array(0, "where A20D > 0", NULL),
	-29 => array(0, "where A7D + A9D = 2", NULL),
	-30 => array(0, "where C4D + C5D > 1", NULL),
	-31 => array(0, "where A7D + A8D + A9D > 0", NULL),
	-32 => array(0, "where C14D + C15D > 0", NULL),
	-33 => array(0, "where C7D + C5D > 0", NULL),
    // C 
    1 => array(1, " where C1N = 1", array(-1)), 
    2 => array(1, " where C2N = 1", array(-2)),
    3 => array(1, " where C3N = 1", array(-3)),
    4 => array(1, " where C4N = 1", array(-4)),
    5 => array(1, " where C5N = 1", array(-5)),       
    6 => array(1, " where C4N + C5N >0", array(-6)), 
    7 => array(1, " where C7N = 1", array(-7)),
    8 => array(1, " where C8N = 1", array(-5) ),
    9 => array(1, " where C8N + C7N > 0", array(-33)),
   10 => array(1, " where C10N = 1", array(-10)),
    11 => array(1, " where C11N = 1", array(-11)), 
    12 => array(1, " where C12N = 1", array(-12)),
    13 => array(1, " where C12N + C11N >0 ", array(-13)),
    14 => array(1, " where C14N = 1", array(-14)),
   15 => array(1, " where C15N = 1", array(-15)),
   16  => array(1, " where C14N + C15N> 0", array(-32)),
   17 => array(1, " where C17N = 1", array(-17)),
   18  => array(1, " where C18N = 1", array(-18)),
   19 => array(1, " where C18N + C19N > 0", array(-19)),
   // A
   20 => array(1, " where A1N = 1",    array(-20)), 
    21 => array(1, " where A2N = 1",   array(-20)),
    22 => array(1, " where A3N = 1",   array(-20)),
    23 => array(1, " where A4N = 1",   array(-20)),
    24 => array(1, " where A5N = 1",   array(-20)),       
    25 => array(1, " where A1N + A2N + A3N + A4N + A5N > 1",   array(-20)), 
    26 => array(1, " where A7N = 1",   array(-21)),
    27 => array(1, " where A8N = 1",   array(-22)),
    28 => array(1, " where A9N = 1",   array(-23)),
    29 => array(1, " where A7N + A8N + A9N > 0",   array(-31)),
    30 => array(1, " where A11N = 1",  array(-24)), 
    31 => array(1, " where A12N = 1",  array(-24)),
    32 => array(1, " where A11N + A12N > 0",  array(-24)),
    33 => array(1, " where A14N = 1",  array(-25)),
   34 => array(1, " where A15N = 1",   array(-25)),
   35  => array(1, " where A16N = 1",  array(-25)),
   36 => array(1, " where A17N = 1",   array(-24)),
   37  => array(1, " where A18N = 1",  array(-26)),
   38 => array(1, " where A19N = 1",   array(-27)),
   39 => array(1, " where A20N = 1",   array(-28)),
   // t 
   40 => array(1, "where t1N = 1",     array(-25)), 

);
	
	if (DEBUG_FLAG) echo "<br>Generate Patient Lists start: " . date('h:i:s') . "<br>";
	// store the patientid lists; don't need any reference to org, since pid contains site info

	foreach ($indicatorQueries as $indicator => $query) {
		foreach ($time_period as $period) {
			if ($period == "Week") $period_value = $period . "(s.visitdate,2) ";
			else $period_value = $period . "(s.visitdate) ";
			if (!is_array($query[1])) {
				$sql = "insert into dw_dataquality_patients select distinct " . $indicator . ",?, year(s.visitdate), " . $period_value . ", s.patientid from dw_dataquality_snapshot s " . $query[1]; 
				$rc = database()->query($sql,array($period))->rowCount();
				if (DEBUG_FLAG) echo "<br>Generate Pid List for: " . $indicator . " :" . $sql . " Rows inserted: " . $rc . "<br>"; 
			} else { 
				// anytime $query[1] isn't simple, previous calculations can be used
				generatePidLists("dataquality", $indicator, $query[1], $period);
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
			$sql = "insert into dw_dataquality_slices select ?, " . $org_value . ", " . $indicator . ", time_period, year, period, t.sex, count(distinct p.patientid), 0 
			from dw_dataquality_patients p, patient t 
			where indicator = " . $indicator . " and p.patientid = t.patientid and t.sex in (1,2) group by 3,4,1,2,5,6,7"; 
			$rc = database()->query($sql, array($org_unit))->rowCount();
			if (DEBUG_FLAG) {
				echo "<br>Generate simple slices for: " . $indicator . " :" . $sql . " Rows inserted: " . $rc . "<br>"; 
				print_r ($argArray);
			} 
			break;
		case 1: // percent
			//generatePercents('dataquality', $indicator, $org_unit, $org_value, $query);
			break;
		case 2: // this among that
			generateAmongSlices("dataquality", $indicator, $org_unit, $org_value, $query);
			break;
		} 
	}  
        generatePercents('dataquality');
	if (DEBUG_FLAG) echo "<br>Indicator slices end: " . date('h:i:s') . "<br>";
}  


?>
