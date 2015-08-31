<? 

function updateMerSnapshot($lastModified) {
        $qry = 'insert into dw_mer_snapshot(patientID,visitDate,TBRegistered,vitalPb,tbOnArv,tbTraetment)
                SELECT DISTINCT patientID, visitDate, case when o.concept_id IN (71174,71177) then  1 else 0 end AS TBRegistered,
				case when o.concept_id IN (70823) then  o.value_numeric else null end AS vitalPb,
				case when o.concept_id IN (71209) then  1 else null end AS tbOnArv,
				case when concept_id in (71218,71196,71199,71197,71432,71433,71220,71198,71434) then 1 else 0 end as tbTraetment
                FROM encValidAll e, obs o
                WHERE e.encounter_id = o.encounter_id AND o.concept_id IN (71174,71177,71211,71193,71206,71211,71218,71196,71199,71197,71432,71433,71220,71198,71434,70823,71209) 
				      on duplicate key update TBRegistered=1,
					  tbTraetment=case when concept_id in (71218,71196,71199,71197,71432,71433,71220,71198,71434) then 1 else 0 end,
					  vitalPb=case when o.concept_id IN (70823) then  o.value_numeric else null end,
					  tbOnArv=case when o.concept_id IN (71209) then  1 else null end';
		$rc = database()->query($qry)->rowCount();
		echo "\n TBRegistered" . date('h:i:s') . "\n";
		
		
		 $qry = 'insert into dw_mer_snapshot(patientID,visitDate,tbTraetementStart,tbTestVih,tbArvDate)
select distinct patientID,o.value_datetime as vistitDate,
case when o.concept_id IN (71193) then  1 else 0 end AS tbTraetementStart,
case when o.concept_id IN (71206) then  1 else 0 end AS tbTestVih,
case when o.concept_id IN (71211) then  1 else 0 end AS tbArvDate
FROM encValidAll e, obs o
 WHERE e.encounter_id = o.encounter_id AND o.concept_id IN (71193,71206,71211)
 on duplicate key update tbTraetementStart=case when o.concept_id IN (71193) then  1 else 0 end,
					  tbTestVih=case when o.concept_id IN (71206) then  1 else 0 end,
					  tbArvDate=case when o.concept_id IN (71211) then  1 else 0 end';
		$rc = database()->query($qry)->rowCount();
		echo "\n tbArvDate" . date('h:i:s') . "\n";
				
	
        $qry = 'insert into dw_mer_snapshot(patientID,visitDate,pregnancy)
                select distinct patientID,visitDate,1 as pregnancy from a_vitals where pregnant =1
                union all
                select distinct patientID,visitDate,1 as pregnancy from encValidAll e,obs o 
                where o.encounter_id=e.encounter_id and o.concept_id in 
                 (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)  on duplicate key update pregnancy =1';
		$rc = database()->query($qry,array('71262','7959','7098','7051','7053','7052','70118','70132','70150','70144','70130','70148','71140','70128','71398','70084','70069','70082','70078',
'70086','70066','70103','70624','70068','70087','70733','7958','71068','70732','7960','71070','7967','70730','70591','70731','70750','7957','70126',
'7955','71067','70729','7806','70067','70826','7805','70827','7804','70465','70018'))->rowCount();
		echo "\n pregnancy" . date('h:i:s') . "\n";


        $qry = 'insert into dw_mer_snapshot(patientID,visitDate,HIVStatus)
select * from (		
select distinct patientID,visitDate,case when o.value_numeric=2 then 1 when o.value_numeric=4 then 2 else 0 end as HIVStatus1
from encValidAll e,obs o where o.encounter_id=e.encounter_id and o.concept_id=? 
union all  
select distinct patientID,visitDate,case when upper(result) like ? then 1 when upper(result) like ? then 2 else 0 end as HIVStatus1 from a_labs where labID in (?,?) and result is not null and result <>?
) p
on duplicate key update HIVStatus=HIVStatus1';
		$rc = database()->query($qry,array('71205','POSI%','NEGA%','1567','1568',''))->rowCount();
		echo "\n HIVStatus" . date('h:i:s') . "\n";
		
        $qry = 'insert into dw_mer_snapshot(patientID,visitDate,HIVStatus)
select * from (		
select distinct patientID,visitDate,1 as HIVStatus1 from encValid e
) p
on duplicate key update HIVStatus=HIVStatus1';
		$rc = database()->query($qry,array('71205','POSI%','NEGA%','1567','1568',''))->rowCount();
		echo "\n HIVStatus" . date('h:i:s') . "\n";		
		
		
	
        $qry = 'insert into dw_mer_snapshot(patientID,visitDate,ARVPatient)
select distinct p.patientID,p.visitDate,1 AS ARVPatient from pepfarTable p
on duplicate key update ARVPatient=1';
		$rc = database()->query($qry)->rowCount();
		echo "\n HIVStatus" . date('h:i:s') . "\n";		


        $qry = 'insert into dw_mer_snapshot(patientID,visitDate,newHIV)
select distinct e.patientID,e.visitDate as firstHIVForm ,1 as newHIV
from encValid e where  e.encounterType in (1,16)
on duplicate key update newHIV=1';
		$rc = database()->query($qry)->rowCount();
		echo "\n firstHIVForm" . date('h:i:s') . "\n";
		
		
		
		        $qry = 'insert into dw_mer_snapshot(patientID,visitDate,HIVForm)
select distinct e.patientID,e.visitDate as firstHIVForm ,1 as HIVForm
from encValid e where  e.encounterType in (1,2,16,17)
on duplicate key update HIVForm=1';
		$rc = database()->query($qry)->rowCount();
		echo "\n firstHIVForm" . date('h:i:s') . "\n";
		
		
        $qry = 'insert into dw_mer_snapshot(patientID,visitDate,ipt)
select distinct patientID,visitDate ,1 as ipt
from a_drugs d where drugID=18
on duplicate key update ipt=1';
		$rc = database()->query($qry)->rowCount();
		echo "\n ipt" . date('h:i:s') . "\n";
		
		
        $qry = 'insert into dw_mer_snapshot(patientID,visitDate,accouchement)
SELECT distinct e.patientID,e.visitDate, 1 AS accouchement  FROM `encValidAll` e  WHERE encounterType=26
on duplicate key update accouchement=1';
		$rc = database()->query($qry)->rowCount();
		echo "\n accouchement" . date('h:i:s') . "\n";		


        $qry = 'insert into dw_mer_snapshot(patientID,visitDate,virologicTest,viralLoad)
select distinct p.patientID,visitDate,case when labID=181 then result else null end as virologicTest,
case when labID=103 then result else null end as viralLoad 
from a_labs p where   labID in (181,103)
on duplicate key update virologicTest=case when labID=181 then result else null end,
viralLoad=case when labID=103 then result else null end ';
		$rc = database()->query($qry)->rowCount();
		echo "\n virologicTest" . date('h:i:s') . "\n";
		
		 $qry = 'insert into dw_mer_snapshot(patientID,visitDate,pedVirologicTest)
select patientID,visitDate,1 as pedVirologic from a_labs where labID in (181,182) and result=2
on duplicate key update pedVirologicTest=1';
		$rc = database()->query($qry)->rowCount();
		echo "\n pedVirologicTest " . date('h:i:s') . "\n";
		
	$qry = 'insert into dw_mer_snapshot(patientID,visitDate,breastfeeding)
SELECT patientID,visitDate,case when pedFeedBreast=1 or pedFeedMixed=1 then 1
	                           when pedFeedBreast=4 or pedFeedMixed=4 then 2
							   when pedFeedBreast=8 and pedFeedMixed=8 then 3
							   else 0 end as breastfeeding
	 FROM `a_vitals` WHERE pedFeedBreast in (1,4,8) or pedFeedMixed in (1,4,8)
on duplicate key update breastfeeding=case when pedFeedBreast=1 or pedFeedMixed=1 then 1
	                           when pedFeedBreast=4 or pedFeedMixed=4 then 2
							   when pedFeedBreast=8 and pedFeedMixed=8 then 3
							   else 0 end';
		$rc = database()->query($qry)->rowCount();
		echo "\n breastfeeding " . date('h:i:s') . "\n";
	
	
					
	   $qry = ' insert into dw_mer_snapshot(patientID,visitDate,stagingCd4Viralload)
select patientID,visitDate,1 as stagingCd4Viralload 
from (
select distinct patientid, visitDate as visitDate from v_medicalEligARVs 
where currentHivStage is not null 
union all
SELECT distinct patientID, visitDate FROM cd4Table
union all 
SELECT distinct patientID, visitDate  FROM v_vitals 
WHERE firstViralLoad IS NOT NULL ) p
on duplicate key update stagingCd4Viralload=1';
		$rc = database()->query($qry)->rowCount();
		echo "\n stagingCd4Viralload" . date('h:i:s') . "\n";
	
	
		   $qry = 'insert into dw_mer_snapshot(patientID,visitDate,outcomeTb)
SELECT DISTINCT e.patientID, e.visitDate,  
case when o.value_numeric=1 then 1
     when o.value_numeric=2 then 2
     when o.value_numeric=4 then 3
     when o.value_numeric=8 then 4
     when o.value_numeric=16 then 5
     when o.value_numeric=32 then 6
end as outcomeTb FROM encValidAll e, obs o
WHERE e.encounter_id = o.encounter_id
AND o.concept_id IN ( 71216)
on duplicate key update outcomeTb=case when o.value_numeric=1 then 1
     when o.value_numeric=2 then 2
     when o.value_numeric=4 then 3
     when o.value_numeric=8 then 4
     when o.value_numeric=16 then 5
     when o.value_numeric=32 then 6
end';
		$rc = database()->query($qry)->rowCount();
		echo "\n outcomeTb" . date('h:i:s') . "\n";


	   $qry = 'insert into dw_mer_snapshot(patientID,visitDate,tbSymptom)
select distinct patientID,visitDate, 1 as tbSymptom from a_tbStatus 
where  presenceBCG=1 or recentNegPPD=1 or suspicionTBwSymptoms=1 or noTBsymptoms=1 or statusPPDunknown=1 or propINH=1
on duplicate key update tbSymptom=1';
		$rc = database()->query($qry)->rowCount();
		echo "\n tbSymptom" . date('h:i:s') . "\n";	
		
	
	  $qry = 'insert into dw_mer_snapshot(patientID,visitDate,TX_UNDETECT_N)
select distinct p1.patientID,p1.visitDate, 1 as TX_UNDETECT_N from 
encValid p1,a_labs p2
where p2.patientID=p1.patientID 
and p1.visitDate>= DATE_ADD(p2.visitDate, INTERVAL 12 MONTH) 
and labID in (103) and result is not null and result<>? and result<=1000
on duplicate key update TX_UNDETECT_N=1';
		$rc = database()->query($qry,array(''))->rowCount();
		echo "\n ipt" . date('h:i:s') . "\n";	
		
		
	 $qry = 'insert into dw_mer_snapshot(patientID,visitDate,TX_UNDETECT_D)
select distinct p1.patientID,p1.visitDate, 1  as TX_UNDETECT_D from 
encValid p1,v_labs p2
where p2.patientID=p1.patientID 
and p1.visitDate>= DATE_ADD(p2.visitDate, INTERVAL 12 MONTH) 
and labID in (103) and result is not null and result<>?
on duplicate key update TX_UNDETECT_D=1';
		$rc = database()->query($qry,array(''))->rowCount();
		echo "\n ipt" . date('h:i:s') . "\n";	


	 $qry = 'insert into dw_mer_snapshot(patientID,visitDate,AntiRetroViral)
	 select * from (
SELECT distinct patientID,visitDate,count(drugID) as AntiRetroViral1 FROM `a_drugs` WHERE drugID in (1,8,10,12,20,29,31,33,34,11,23,5,17,21) group by 1,2
) P
on duplicate key update AntiRetroViral=AntiRetroViral1';
		$rc = database()->query($qry)->rowCount();
		echo "\n ipt" . date('h:i:s') . "\n";			
		
	 $qry = 'insert into dw_mer_snapshot(patientID,visitDate,statutVihActuel)
SELECT distinct patientID,visitDate,1 as statutVihActuel FROM `a_vitals` WHERE pedCurrHiv=1
on duplicate key update statutVihActuel=1';
		$rc = database()->query($qry)->rowCount();
		echo "\n ipt" . date('h:i:s') . "\n";			
		
		
			 $qry = 'insert into dw_mer_snapshot(patientID,visitDate,linkToArv)
SELECT distinct patientID,visitDate,
case when pedArvEver=1 and arvEver is null then 1 when arvEver=1 and pedArvEver is null then 2 else 0  end  as linkToArv 
FROM `a_arvEnrollment` WHERE pedArvEver IS NOT NULL or arvEver is not null
on duplicate key update linkToArv=case when pedArvEver=1 and arvEver is null then 1 when arvEver=1 and pedArvEver is null then 2 else 0  end';
		$rc = database()->query($qry)->rowCount();
		echo "\n linkToArv" . date('h:i:s') . "\n";


			 $qry = 'insert into dw_mer_snapshot(patientID,visitDate,cotrimoxazole)
SELECT distinct patientID,visitDate,1 as cotrimoxazole FROM `a_prescriptions` WHERE drugID=9 and forPepPmtct=1
on duplicate key update cotrimoxazole=1';
		$rc = database()->query($qry)->rowCount();
		echo "\n cotrimoxazole" . date('h:i:s') . "\n";


 $qry = 'insert into dw_mer_snapshot(patientID,visitDate,tbPrescription)
select distinct patientID,visitDate,1 as tbPrescription from a_prescriptions where drugID in (13,18,24,25,30) and dispensed=1
on duplicate key update tbPrescription=1';
		$rc = database()->query($qry)->rowCount();
		echo "\n tbPrescription" . date('h:i:s') . "\n";


 $qry = 'insert into dw_mer_snapshot(patientID,visitDate,isDeath,noFollowup,transfer)
SELECT distinct patientID,visitDate,case when reasonDiscDeath=1 then 1 else 0 end  as isDeath,
case when reasonDiscNoFollowup=1 then 1 else 0 end  as noFollowup,
case when reasonDiscTransfer=1 then 1 else 0 end  as transfer
FROM `a_discEnrollment` WHERE reasonDiscDeath=1 or reasonDiscNoFollowup=1 or reasonDiscTransfer=1
on duplicate key update isDeath=case when reasonDiscDeath=1 then 1 else 0 end,
noFollowup=case when reasonDiscNoFollowup=1 then 1 else 0 end,
transfer=case when reasonDiscTransfer=1 then 1 else 0 end';
		$rc = database()->query($qry)->rowCount();
		echo "\n isDeath" . date('h:i:s') . "\n";

 $qry = 'insert into dw_mer_snapshot(patientID,visitDate,AnthroPrometrique)
SELECT distinct v.patientID,v.visitDate,
case when DATEDIFF(v.visitdate,ymdtodate(dobyy,dobmm,?))/365 between 0 and 5 then 
                  case when pedVitCurBracCirc is not null and pedVitCurBracCirc<>? then 1 else 0 end               
    else 1 end  as AnthroPrometrique
FROM  `v_vitals` v, patient p
WHERE  v.patientID=p.patientid 
AND `vitalWeight` IS NOT NULL 
AND  (`vitalHeight` IS NOT NULL or vitalHeightCm is not null)
AND vitalWeight <>  ?
AND (vitalHeight <>  ? or vitalHeightCm<> ?)
on duplicate key update AnthroPrometrique=case when DATEDIFF(v.visitdate,ymdtodate(dobyy,dobmm,?))/365 between 0 and 5 then 
                  case when pedVitCurBracCirc is not null and pedVitCurBracCirc<>? then 1 else 0 end               
    else 1 end';
		$rc = database()->query($qry,array('01','','','','','01',''))->rowCount();
		echo "\n isDeath" . date('h:i:s') . "\n";		
		
	
	 $qry = 'insert into dw_mer_snapshot(patientID,visitDate,newEnrollArt)
SELECT distinct patientID,visitDate,1 as newEnrollArt FROM `a_drugs` WHERE drugID in (1,8,10,12,20,29,31,33,34,11,23,5,17,21) and startMm is not null
union all
SELECT distinct patientID,visitDate,1 as newEnrollArt FROM `a_prescriptions` WHERE drugID in (1,8,10,12,20,29,31,33,34,11,23,5,17,21) and dispensed=1

on duplicate key update newEnrollArt=1';
		$rc = database()->query($qry)->rowCount();
		echo "\n isDeath" . date('h:i:s') . "\n";	
	
	
		
	 
	/* get rid of any snapshot records where patient either isn't suspected or confirmed and has not had any treatments or tests 
	$sql = "drop table if exists nonMalaria; create table nonMalaria select distinct patientid from dw_malaria_snapshot where malariaDx = 0 and malariaDxA = 0 and malariaDxG = 0 and malariaDxSuspected = 0 and malariaDxSuspectedA = 0 and malariaDxSuspectedG = 0 and rapidResultPositive = 0 and rapidResultNegative = 0 and smearResultPositive = 0 and smearResultNegative = 0 and malariaTest = 0 and malariaTestRapid = 0 and chloroquine = 0 and quinine = 0 and primaquine = 0; create index pnon on nonMalaria (patientid); delete from dw_malaria_snapshot where patientid in (select patientid from nonMalaria)";
	$rc = database()->query($sql)->rowCount();
	if (1 == 1) {
		echo "\nEliminate stray patients query: " . $sql . " Rows removed: " . $rc . "\n";
		echo "\n" . date('h:i:s') . "\n"; 
	}  */        
}


function merSlices($key, $orgType, $time_period) {
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
"-1"=> array(0, "where pregnancy=1 or accouchement=1", NULL), 
" 1"=> array(1, "where pregnancy=1 and HIVStatus in (1,2)", array(-1)), 
" 2"=> array(1, "where pregnancy=1 and HIVStatus in (1,2) and patientID in (select patientID from a_vitals  where month(s.visitDate)= firstTestMm and year(s.visitDate)=firstTestYy)", array(-1)),
" 3"=> array(1, "where pregnancy=1 and HIVStatus in (1,2) and patientID in (select patientID from a_vitals  where (year(s.visitDate)>firstTestYy or (month(s.visitDate)> firstTestMm and year(s.visitDate)=firstTestYy)))", array(-1)),
" 4"=> array(1, "where pregnancy=1 and HIVStatus in (1,2) and patientID not in (select patientID from a_vitals  where (year(s.visitDate)>firstTestYy or (month(s.visitDate)>= firstTestMm and year(s.visitDate)=firstTestYy)))", array(-1)),

"-2"=> array(0, "where pregnancy=1 and HIVStatus=1",NULL), 
" 5"=> array(1, "where pregnancy=1 and HIVStatus=1 and AntiRetroViral>=1", array(-2)),
" 6"=> array(1, "where pregnancy=1 and HIVStatus=1 and PatientID in(select p.patientID from dw_pregnancy_ranges p,dw_mer_snapshot p1 where p.patientID=p1.patientID and p1.AntiRetroViral>=1 and p1.visitDate between DATE_ADD(startdate,INTERVAL -1 month) and stopdate)", array(-2)), 
" 7"=> array(1, "where pregnancy=1 and HIVStatus=1 and patientID in(select p.patientID from dw_pregnancy_ranges p,dw_mer_snapshot p1 where p.patientID=p1.patientID and p1.AntiRetroViral>=1 and p1.visitDate not between DATE_ADD(startdate,INTERVAL -1 month) and stopdate)", array(-2)), 
" 8"=> array(1, "where pregnancy=1 and HIVStatus=1 and AntiRetroViral>=2", array(-2)), 


" 9"=> array(1, ",patient p where statutVihActuel=1 and virologicTest is not null and s.patientID=p.patientID and DATEDIFF(visitdate,ymdtodate(dobyy,dobmm,dobDd)) between 0 and 365", array(-2)), 
" 10"=> array(1, ",patient p where statutVihActuel=1 and virologicTest is not null and s.patientID=p.patientID and DATEDIFF(visitdate,ymdtodate(dobyy,dobmm,dobDd)) between 0 and 61", array(-2)), 
"11"=> array(1, ",patient p where statutVihActuel=1 and virologicTest is not null and s.patientID=p.patientID and DATEDIFF(visitdate,ymdtodate(dobyy,dobmm,dobDd)) between 62 and 365", array(-2)), 
"12"=> array(1, ",patient p where statutVihActuel=1 and (virologicTest=2 or pedVirologicTest=1) and s.patientID=p.patientID and DATEDIFF(visitdate,ymdtodate(dobyy,dobmm,dobDd)) between 0 and 61", array(-2)), 
"13"=> array(1, ",patient p where statutVihActuel=1 and (virologicTest=2 or pedVirologicTest=1) and s.patientID=p.patientID and DATEDIFF(visitdate,ymdtodate(dobyy,dobmm,dobDd)) between 62 and 365", array(-2)), 

/* HIV-infected linked to ART/ not linked to ART/ unknown linked to ART*/
"-3"=> array(0, ",patient p where HIVStatus=1=1 and s.patientID=p.patientID and DATEDIFF(visitdate,ymdtodate(dobyy,dobmm,dobDd))<=547", NULL), 
"14"=> array(1, ",patient p where HIVStatus=1=1 and linkToArv=1 and s.patientID=p.patientID and DATEDIFF(visitdate,ymdtodate(dobyy,dobmm,dobDd))<=547", array(-3)), 
"15"=> array(1, ",patient p where HIVStatus=1=1 and linkToArv=2 and s.patientID=p.patientID and DATEDIFF(visitdate,ymdtodate(dobyy,dobmm,dobDd))<=547", array(-3)), 
"16"=> array(1, ",patient p where HIVStatus=1=1 and linkToArv=0 and s.patientID=p.patientID and DATEDIFF(visitdate,ymdtodate(dobyy,dobmm,dobDd))<=547", array(-3)), 
// labID=182 for antigenemie UP24; 181 for pcr 
/* HIV-uninfected not breastfeeding */ 
"17"=> array(1, ",patient p where HIVStatus=1=1 and pedVirologicTest=1 and breastfeeding=2 and s.patientID=p.patientID and DATEDIFF(visitdate,ymdtodate(dobyy,dobmm,dobDd))<=547", array(-3)), 
"18"=> array(1, ",patient p where HIVStatus=1=1 and pedVirologicTest=1 and breastfeeding=1 and s.patientID=p.patientID and DATEDIFF(visitdate,ymdtodate(dobyy,dobmm,dobDd))<=547", array(-3)),
"19"=> array(1, ",patient p where HIVStatus=1=1 and pedVirologicTest=1 and breastfeeding=3 and s.patientID=p.patientID and DATEDIFF(visitdate,ymdtodate(dobyy,dobmm,dobDd))<=547", array(-3)),

/* HIV-uninfected not breastfeeding */ 
"20"=> array(1, ",patient p where HIVStatus=1=1 and pedVirologicTest=0 and statutVihActuel=1 and s.patientID=p.patientID and DATEDIFF(visitdate,ymdtodate(dobyy,dobmm,dobDd))<=547", array(-3)), 
"21"=> array(1, ",patient p where HIVStatus=1=1 and noFollowup=1 and statutVihActuel=1 and s.patientID=p.patientID and DATEDIFF(visitdate,ymdtodate(dobyy,dobmm,dobDd))<=547", array(-3)),
"22"=> array(1, ",patient p where HIVStatus=1=1 and isDeath=1 and statutVihActuel=1 and s.patientID=p.patientID and DATEDIFF(visitdate,ymdtodate(dobyy,dobmm,dobDd))<=547", array(-3)),


"23"=> array(1, ",patient p where HIVStatus=1 and cotrimoxazole=1 and s.patientID=p.patientID and DATEDIFF(visitdate,ymdtodate(dobyy,dobmm,dobDd))<=547", array(-2)), 
"24"=> array(0, " where HIVStatus=1 and stagingCd4Viralload=1 and newHIV=1", NULL), 
/* generate age group for indicator 24 */
"25"=>array(0, ", patient p  where HIVStatus=1 and stagingCd4Viralload=1 and newHIV=1 and p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) < 1 ", NULL),
"26"=>array(0, ", patient p  where HIVStatus=1 and stagingCd4Viralload=1 and newHIV=1 and p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 1 and 4.99 ", NULL),
"27"=>array(0, ", patient p  where HIVStatus=1 and stagingCd4Viralload=1 and newHIV=1 and p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 5 and 9.99 ", NULL),
"28"=>array(0, ", patient p  where HIVStatus=1 and stagingCd4Viralload=1 and newHIV=1 and p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 10 and 14.99 ", NULL),
"29"=>array(0, ", patient p  where HIVStatus=1 and stagingCd4Viralload=1 and newHIV=1 and p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 15 and 24.99 ", NULL),
"30"=>array(0, ", patient p  where HIVStatus=1 and stagingCd4Viralload=1 and newHIV=1 and p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 25 and 49", NULL),
"31"=>array(0, ", patient p  where HIVStatus=1 and stagingCd4Viralload=1 and newHIV=1 and p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) > 49 ", NULL), 
"32"=>array(0, ", patient p  where HIVStatus=1 and stagingCd4Viralload=1 and newHIV=1 and p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 < 15 ", NULL), 
"33"=>array(0, ", patient p  where HIVStatus=1 and stagingCd4Viralload=1 and newHIV=1 and p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 >=15 ", NULL), 


"34"=> array(0, " where HIVStatus=1 and stagingCd4Viralload=1", NULL),
"35"=>array(0, ", patient p  where HIVStatus=1 and stagingCd4Viralload=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) < 1 ", NULL),
"36"=>array(0, ", patient p  where HIVStatus=1 and stagingCd4Viralload=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 1 and 4.99 ", NULL),
"37"=>array(0, ", patient p  where HIVStatus=1 and stagingCd4Viralload=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 5 and 9.99 ", NULL),
"38"=>array(0, ", patient p  where HIVStatus=1 and stagingCd4Viralload=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 10 and 14.99 ", NULL),
"39"=>array(0, ", patient p  where HIVStatus=1 and stagingCd4Viralload=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 15 and 24.99 ", NULL),
"40"=>array(0, ", patient p  where HIVStatus=1 and stagingCd4Viralload=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 25 and 49 ", NULL),
"41"=>array(0, ", patient p  where HIVStatus=1 and stagingCd4Viralload=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) > 49 ", NULL), 
"42"=>array(0, ", patient p  where HIVStatus=1 and stagingCd4Viralload=1 and  p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 < 15 ", NULL), 
"43"=>array(0, ", patient p  where HIVStatus=1 and stagingCd4Viralload=1 and  p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 >=15 ", NULL), 

"-4"=> array(0, " where TBRegistered=1", NULL),
"44"=> array(1, " where HIVStatus=1=1 and TBRegistered=1", array(-4)),
"45"=>array(1, ", patient p  where HIVStatus in (1,2) and TBRegistered=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) < 1 ", array(-4)),
"46"=>array(1, ", patient p  where HIVStatus in (1,2) and TBRegistered=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 1 and 4.99 ", array(-4)),
"47"=>array(1, ", patient p  where HIVStatus in (1,2) and TBRegistered=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 5 and 9.99 ", array(-4)),
"48"=>array(1, ", patient p  where HIVStatus in (1,2) and TBRegistered=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 10 and 14.99 ", array(-4)),
"49"=>array(1, ", patient p  where HIVStatus in (1,2) and TBRegistered=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 15 and 19 ", array(-4)),
"50"=>array(1, ", patient p  where HIVStatus in (1,2) and TBRegistered=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) >19 ", array(-4)), 
"51"=> array(1, " where HIVStatus=1 and TBRegistered=1", array(-4)),
"52"=> array(1, " where HIVStatus=2 and TBRegistered=1", array(-4)),



"-5"=> array(0, " where HIVStatus=1=1 and TBRegistered=1", NULL),
"53"=> array(1, " where HIVStatus=1=1 and TBRegistered=1 and ARVPatient=1", array(-5)),
"54"=>array(1, ", patient p  where HIVStatus=1=1 and TBRegistered=1 and ARVPatient=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) < 1 ", array(-5)),
"55"=>array(1, ", patient p  where HIVStatus=1=1 and TBRegistered=1 and ARVPatient=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 1 and 4.99 ", array(-5)),
"56"=>array(1, ", patient p  where HIVStatus=1=1 and TBRegistered=1 and ARVPatient=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 5 and 9.99 ", array(-5)),
"57"=>array(1, ", patient p  where HIVStatus=1=1 and TBRegistered=1 and ARVPatient=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 10 and 14.99 ", array(-5)),
"58"=>array(1, ", patient p  where HIVStatus=1=1 and TBRegistered=1 and ARVPatient=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 15 and 19 ", array(-5)),
"59"=>array(1, ", patient p  where HIVStatus=1=1 and TBRegistered=1 and ARVPatient=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) >19 ", array(-5)), 
"60"=> array(1, " where HIVStatus=1=1 and TBRegistered=1 and ARVPatient=1 and patientID in (select patientID from dw_mer_snapshot p where month(p.visitDate)=month(s.visitDate) and tbTestVih=1)", array(-5)),
"61"=> array(1, " where HIVStatus=1=1 and TBRegistered=1 and ARVPatient=1 and patientID in (select patientID from dw_mer_snapshot p where DATE_ADD(s.visitDate,INTERVAL -1 month)>=month(p.visitDate) and tbTestVih=1)", array(-5)),
"62"=> array(1, " where HIVStatus=1=1 and TBRegistered=1 and tbArvDate=1 and patientID in (select patientID from dw_mer_snapshot p where s.visitDate<DATE_ADD(p.visitDate,INTERVAL 8 week) and tbTraetementStart=1)", array(-5)),
"63"=> array(1, " where HIVStatus=1=1 and TBRegistered=1 and tbArvDate=1 and patientID in (select patientID from dw_mer_snapshot p where s.visitDate>=DATE_ADD(p.visitDate,INTERVAL 8 week) and tbTraetementStart=1)", array(-5)),

"-6"=> array(0, " where HIVStatus=1 and newHIV=1 and stagingCd4Viralload=1", NULL),
"64"=> array(1, " where newHIV=1 and stagingCd4Viralload=1 and ipt=1", array(-6)),
"65"=>array(1, ", patient p  where newHIV=1 and stagingCd4Viralload=1 and ipt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) < 1 ", array(-6)),
"66"=>array(1, ", patient p  where newHIV=1 and stagingCd4Viralload=1 and ipt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 1 and 4.99 ", array(-6)),
"67"=>array(1, ", patient p  where newHIV=1 and stagingCd4Viralload=1 and ipt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 5 and 9.99 ", array(-6)),
"68"=>array(1, ", patient p  where newHIV=1 and stagingCd4Viralload=1 and ipt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 10 and 14.99 ", array(-6)),
"69"=>array(1, ", patient p  where newHIV=1 and stagingCd4Viralload=1 and ipt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 15 and 19 ", array(-6)),
"70"=>array(1, ", patient p  where newHIV=1 and stagingCd4Viralload=1 and ipt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) >19 ", array(-6)), 
"71"=>array(1, ", patient p  where newHIV=1 and stagingCd4Viralload=1 and ipt=1 and  p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 < 15 ", array(-6)), 
"72"=>array(1, ", patient p  where newHIV=1 and stagingCd4Viralload=1 and ipt=1 and  p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 >=15 ", array(-6)), 


"73"=> array(1, " where HIVStatus=1=1 and TBRegistered=1 and (tbTraetment=1 or tbPrescription=1)", array(-5)), 
"74"=>array(1, ", patient p  where newHIV=1 and stagingCd4Viralload=1 and ipt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) < 1 ", array(-5)),
"75"=>array(1, ", patient p  where newHIV=1 and stagingCd4Viralload=1 and ipt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 1 and 4.99 ", array(-5)),
"76"=>array(1, ", patient p  where newHIV=1 and stagingCd4Viralload=1 and ipt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 5 and 9.99 ", array(-5)),
"77"=>array(1, ", patient p  where newHIV=1 and stagingCd4Viralload=1 and ipt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 10 and 14.99 ", array(-5)),
"78"=>array(1, ", patient p  where newHIV=1 and stagingCd4Viralload=1 and ipt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 15 and 19 ", array(-5)),
"79"=>array(1, ", patient p  where newHIV=1 and stagingCd4Viralload=1 and ipt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) >19 ", array(-5)),
"80"=> array(1, " where HIVStatus=1=1 and TBRegistered=1 and (tbTraetment=1 or tbPrescription=1) and outcomeTb=1", array(-5)),
"81"=> array(1, " where HIVStatus=1=1 and TBRegistered=1 and (tbTraetment=1 or tbPrescription=1) and outcomeTb=2", array(-5)),
"82"=> array(1, " where HIVStatus=1=1 and TBRegistered=1 and (tbTraetment=1 or tbPrescription=1) and outcomeTb=3", array(-5)),
"83"=> array(1, " where HIVStatus=1=1 and TBRegistered=1 and (tbTraetment=1 or tbPrescription=1) and isDeath=1", array(-5)),
"84"=> array(1, " where HIVStatus=1=1 and TBRegistered=1 and (tbTraetment=1 or tbPrescription=1) and noFollowup=1", array(-5)),
 
"-7"=> array(0, " where HIVStatus=1=1 and stagingCd4Viralload=1", NULL), 
"85"=> array(1, " where HIVStatus=1=1 and stagingCd4Viralload=1 and tbSymptom=1", array(-7)),
"86"=>array(1, ", patient p  where HIVStatus=1=1 and stagingCd4Viralload=1 and tbSymptom=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) < 1 ", array(-7)),
"87"=>array(1, ", patient p  where HIVStatus=1=1 and stagingCd4Viralload=1 and tbSymptom=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 1 and 4.99 ", array(-7)),
"88"=>array(1, ", patient p  where HIVStatus=1=1 and stagingCd4Viralload=1 and tbSymptom=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 5 and 9.99 ", array(-7)),
"89"=>array(1, ", patient p  where HIVStatus=1=1 and stagingCd4Viralload=1 and tbSymptom=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 10 and 14.99 ", array(-7)),
"90"=>array(1, ", patient p  where HIVStatus=1=1 and stagingCd4Viralload=1 and tbSymptom=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 15 and 24.99 ", array(-7)),
"91"=>array(1, ", patient p  where HIVStatus=1=1 and stagingCd4Viralload=1 and tbSymptom=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 25 and 49 ", array(-7)),
"92"=>array(1, ", patient p  where HIVStatus=1=1 and stagingCd4Viralload=1 and tbSymptom=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) > 49 ", array(-7)), 
"93"=>array(1, ", patient p  where HIVStatus=1=1 and stagingCd4Viralload=1 and tbSymptom=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) < 15 ", array(-7)), 
"94"=>array(1, ", patient p  where HIVStatus=1=1 and stagingCd4Viralload=1 and tbSymptom=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) >=15 ", array(-7)),  

"95"=> array(1, " where HIVStatus=1=1 and stagingCd4Viralload=1 and (AnthroPrometrique=1 or vitalPb>0)", array(-7)),
"96"=>array(1, ", patient p  where HIVStatus=1=1 and stagingCd4Viralload=1 and (AnthroPrometrique=1 or vitalPb>0) and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) < 1 ", array(-7)),
"97"=>array(1, ", patient p  where HIVStatus=1=1 and stagingCd4Viralload=1 and (AnthroPrometrique=1 or vitalPb>0) and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 1 and 4.99 ", array(-7)),
"98"=>array(1, ", patient p  where HIVStatus=1=1 and stagingCd4Viralload=1 and (AnthroPrometrique=1 or vitalPb>0) and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 5 and 9.99 ", array(-7)),
"99"=>array(1, ", patient p  where HIVStatus=1=1 and stagingCd4Viralload=1 and (AnthroPrometrique=1 or vitalPb>0) and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 10 and 14.99 ", array(-7)),
"100"=>array(1, ", patient p  where HIVStatus=1=1 and stagingCd4Viralload=1 and (AnthroPrometrique=1 or vitalPb>0) and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 15 and 17 ", array(-7)),
"101"=>array(1, ", patient p  where HIVStatus=1=1 and stagingCd4Viralload=1 and (AnthroPrometrique=1 or vitalPb>0) and  p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 > 17 ", array(-7)), 
"102"=>array(1, ", patient p  where HIVStatus=1=1 and stagingCd4Viralload=1 and (AnthroPrometrique=1 or vitalPb>0) and  p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 < 18 ", array(-7)),  



"103"=> array(0, " where HIVStatus=1=1 and newEnrollArt=1", NULL),
"104"=>array(0, ", patient p  where HIVStatus=1=1 and newEnrollArt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) < 1 ", NULL),
"105"=>array(0, ", patient p  where HIVStatus=1=1 and newEnrollArt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 1 and 4.99 ", NULL),
"106"=>array(0, ", patient p  where HIVStatus=1=1 and newEnrollArt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 5 and 9.99 ", NULL),
"107"=>array(0, ", patient p  where HIVStatus=1=1 and newEnrollArt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 10 and 14.99 ", NULL),
"108"=>array(0, ", patient p  where HIVStatus=1=1 and newEnrollArt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 15 and 24.99 ", NULL),
"109"=>array(0, ", patient p  where HIVStatus=1=1 and newEnrollArt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 25 and 49 ", NULL),
"110"=>array(0, ", patient p  where HIVStatus=1=1 and newEnrollArt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) > 49 ", NULL),


"111"=> array(0, " where HIVStatus=1=1 and AntiRetroViral>=1 and newEnrollArt=1", NULL),
"112"=>array(0, ", patient p  where HIVStatus=1=1 and AntiRetroViral>=1 and newEnrollArt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) < 1 ", NULL),
"113"=>array(0, ", patient p  where HIVStatus=1=1 and AntiRetroViral>=1 and newEnrollArt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 1 and 4.99 ", NULL),
"114"=>array(0, ", patient p  where HIVStatus=1=1 and AntiRetroViral>=1 and newEnrollArt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 5 and 9.99 ", NULL),
"115"=>array(0, ", patient p  where HIVStatus=1=1 and AntiRetroViral>=1 and newEnrollArt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 10 and 14.99 ", NULL),
"116"=>array(0, ", patient p  where HIVStatus=1=1 and AntiRetroViral>=1 and newEnrollArt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 15 and 24.99 ", NULL),
"117"=>array(0, ", patient p  where HIVStatus=1=1 and AntiRetroViral>=1 and newEnrollArt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 25 and 49 ", NULL),
"118"=>array(0, ", patient p  where HIVStatus=1=1 and AntiRetroViral>=1 and newEnrollArt=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) > 49 ", NULL),

"-8"=> array(0, " where HIVStatus=1=1 and patientID in (select patientID from pepfarTable p where p.visitDate<=DATE_ADD(s.visitDate, interval -12 month))", NULL),
"119"=> array(1, " where HIVStatus=1=1 and arvPatient=1 and isdeath=0 and s.patientID in (select patientID from pepfarTable p where p.visitDate<=DATE_ADD(s.visitDate, interval -12 month))", array(-8)),
"120"=>array(1, ", patient p  where HIVStatus=1=1 and arvPatient=1 and isdeath=0 and s.patientID in (select patientID from pepfarTable p where p.visitDate<=DATE_ADD(s.visitDate, interval -12 month)) and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) < 1 ", array(-8)),
"121"=>array(1, ", patient p  where HIVStatus=1=1 and arvPatient=1 and isdeath=0 and s.patientID in (select patientID from pepfarTable p where p.visitDate<=DATE_ADD(s.visitDate, interval -12 month)) and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 1 and 4 ", array(-8)),
"122"=>array(1, ", patient p  where HIVStatus=1=1 and arvPatient=1 and isdeath=0 and s.patientID in (select patientID from pepfarTable p where p.visitDate<=DATE_ADD(s.visitDate, interval -12 month)) and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 5 and 9 ", array(-8)),
"123"=>array(1, ", patient p  where HIVStatus=1=1 and arvPatient=1 and isdeath=0 and s.patientID in (select patientID from pepfarTable p where p.visitDate<=DATE_ADD(s.visitDate, interval -12 month)) and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 10 and 14 ", array(-8)),
"124"=>array(1, ", patient p  where HIVStatus=1=1 and arvPatient=1 and isdeath=0 and s.patientID in (select patientID from pepfarTable p where p.visitDate<=DATE_ADD(s.visitDate, interval -12 month)) and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 15 and 19 ", array(-8)),
"125"=>array(1, ", patient p  where HIVStatus=1=1 and arvPatient=1 and isdeath=0 and s.patientID in (select patientID from pepfarTable p where p.visitDate<=DATE_ADD(s.visitDate, interval -12 month)) and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) >19 ", array(-8)),

"-9"=> array(0, " where HIVStatus=1=1 and arvPatient=1  and s.patientID in (select patientID from encValidAll p where p.visitDate>=DATE_ADD(s.visitDate, interval -6 month))", NULL),
"126"=> array(1, " where HIVStatus=1=1 and arvPatient=1  and s.patientID in (select patientID from dw_mer_snapshot p where viralLoad>0 and p.visitDate>=DATE_ADD(s.visitDate, interval -12 month))", array(-9)),
"127"=>array(1, ", patient p  where HIVStatus=1=1 and arvPatient=1  and s.patientID in (select patientID from dw_mer_snapshot p where viralLoad>0 and p.visitDate>=DATE_ADD(s.visitDate, interval -12 month)) and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) < 1 ", array(-9)),
"128"=>array(1, ", patient p  where HIVStatus=1=1 and arvPatient=1  and s.patientID in (select patientID from dw_mer_snapshot p where viralLoad>0 and p.visitDate>=DATE_ADD(s.visitDate, interval -12 month)) and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 1 and 4.99 ", array(-9)),
"129"=>array(1, ", patient p  where HIVStatus=1=1 and arvPatient=1  and s.patientID in (select patientID from dw_mer_snapshot p where viralLoad>0 and p.visitDate>=DATE_ADD(s.visitDate, interval -12 month)) and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 5 and 9.99 ", array(-9)),
"130"=>array(1, ", patient p  where HIVStatus=1=1 and arvPatient=1  and s.patientID in (select patientID from dw_mer_snapshot p where viralLoad>0 and p.visitDate>=DATE_ADD(s.visitDate, interval -12 month)) and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 10 and 14.99 ", array(-9)),
"131"=>array(1, ", patient p  where HIVStatus=1=1 and arvPatient=1  and s.patientID in (select patientID from dw_mer_snapshot p where viralLoad>0 and p.visitDate>=DATE_ADD(s.visitDate, interval -12 month)) and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 15 and 19 ", array(-9)),
"132"=>array(1, ", patient p  where HIVStatus=1=1 and arvPatient=1  and s.patientID in (select patientID from dw_mer_snapshot p where viralLoad>0 and p.visitDate>=DATE_ADD(s.visitDate, interval -12 month)) and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) >19 ", array(-9)),

"-10"=> array(0, " where TX_UNDETECT_D=1", NULL),
"133"=> array(1, " where TX_UNDETECT_N=1", array(-10)),
"134"=>array(1, ", patient p  where TX_UNDETECT_N=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) < 1 ", array(-10)),
"135"=>array(1, ", patient p  where TX_UNDETECT_N=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 1 and 4.99 ", array(-10)),
"136"=>array(1, ", patient p  where TX_UNDETECT_N=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 5 and 9.99 ", array(-10)),
"137"=>array(1, ", patient p  where TX_UNDETECT_N=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 10 and 14.99 ", array(-10)),
"138"=>array(1, ", patient p  where TX_UNDETECT_N=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) between 15 and 19 ", array(-10)),
"139"=>array(1, ", patient p  where TX_UNDETECT_N=1 and  p.patientid = s.patientid and round(datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365,2) >19 ", array(-10))
);

/* 
$indicatorQueries = $indicatorQueries + genAgeGpQueries1(33 , ', patient p where p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 < 1 ');
$indicatorQueries = $indicatorQueries + genAgeGpQueries1(49 , ', patient p where p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 between 1 and 4 ');
$indicatorQueries = $indicatorQueries + genAgeGpQueries1(65 , ', patient p where p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 between 5 and 9 ');	
$indicatorQueries = $indicatorQueries + genAgeGpQueries1(81 , ', patient p where p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 between 10 and 14 ');
$indicatorQueries = $indicatorQueries + genAgeGpQueries1(97 , ', patient p where p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 between 15 and 24 ');
$indicatorQueries = $indicatorQueries + genAgeGpQueries1(113, ', patient p where p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 between 25 and 49 ');  
$indicatorQueries = $indicatorQueries + genAgeGpQueries1(129, ', patient p where p.patientid = s.patientid and datediff(s.visitdate, ymdtodate(p.dobyy,6,15))/365 > 49 '); 
*/	
	if (1 == 1) echo "\nGenerate Patient Lists start: " . date('h:i:s') . "\n";
	// store the patientid lists; don't need any reference to org, since pid contains site info
	foreach ($indicatorQueries as $indicator => $query) { 
	        echo "***" . date('h:i:s') . "***\n";
		foreach ($time_period as $period) {
			if ($period == "Week") $period_value = $period . "(s.visitdate,2) ";
			else $period_value = $period . "(s.visitdate) ";
			if (!is_array($query[1])) {
				$sql = "insert into dw_mer_patients select distinct " . $indicator . ",?, year(s.visitdate), " . $period_value . ", s.patientid from dw_mer_snapshot s " . $query[1]; 
				$rc = database()->query($sql,array($period))->rowCount();
				if (1 == 1) echo "\nGenerate Pid List for: " . $indicator . " :" . $sql . " Rows inserted: " . $rc . "\n"; 
			} else { 
				// anytime $query[1] isn't simple, previous calculations can be used
				generatePidLists("mer", $indicator, $query[1], $period);
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
				$sql = "insert into dw_mer_slices select ?, " . $org_value . ", " . $indicator . ", time_period, year, period, t.sex, count(distinct p.patientid), 0 from dw_mer_patients p, patient t";
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
				generateAmongSlices("mer", $indicator, $org_unit, $org_value, $query);
				break;
			}
		} 
	} 
	generatePercents('mer'); 
	if (1 == 1) echo "\nIndicator slices end: " . date('h:i:s') . "\n";       	
}
/*
function genAgeGpQueries1 ($i, $qualifier) {
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
*/
?>
