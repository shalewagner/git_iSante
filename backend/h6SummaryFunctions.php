<?php
require_once ("backend.php");

require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";





function generateh6Summary ($startdate, $enddate,$site, $lang) {
  $dateTime = $lang == "fr" ? date ("d/m/y H:i:s") : date ("m/d/y H:i:s");
  $siteName = getSiteName ($site, $lang);
  $period=date("d-M-Y", strtotime($startdate)).' To '.date("d-M-Y", strtotime($enddate));
  $year = date("y", strtotime($startdate));
  $month = date("m", strtotime($startdate));   
  $commune = getCommune($site);
  $department=getDepartment($site);
  
$eid = '';
$sql = "select encounter_id as eid from encounter 
        where encountertype = 34 and visitdateyy = '".$year."' and 
                                     visitdatemm = '".$month."' and 
                                     visitdatedd = '01' and
                                     patientid = '" . $site . "0'";
$result = databaseSelect()->query($sql)->fetchAll();
$eid = $result[0]['eid']; 
if($eid<>null) getExistingData ($eid, array());  
  

  $queryArray = array(
       "consultation" => "SELECT CASE WHEN DATEDIFF( visitdate, ymdtodate(dobyy, dobmm,  '01') ) /365 <1 THEN  '1. Enfants(< 1 ans)' WHEN DATEDIFF( visitdate, ymdtodate(dobyy, dobmm,  '01') ) /365 BETWEEN 2  AND 4 THEN  '2.Enfants(1-4 ans)' WHEN DATEDIFF( visitdate, ymdtodate(dobyy, dobmm,  '01') ) /365 BETWEEN 5 AND 14 THEN  '3.Enfants(5-14 ans)' WHEN o.concept_id = 71368  then '5.Client PF' ELSE  '6.Adultes/Autres' END categories, COUNT( DISTINCT e.patientid ) AS  'Total des consultations' FROM patient p, encValidAll e left join obs o on e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = 71368 WHERE visitdate BETWEEN  '".$startdate."' AND '".$enddate."' AND e.patientID = p.patientID and sitecode='".$site."' and encountertype in (1,2,3,4,16,17,24,25,26,27,28,29,31) GROUP BY 1 union select '4.Femmes enceintes', COUNT(DISTINCT patientid) from dw_pregnancy_ranges where  year('".$startdate."') between year(startdate) and year(stopdate) and month('".$startdate."') between month(startdate) and month(stopdate)   order by 1",
	
       "laboratoire" => "SELECT case 	when testnamefr like '%malaria%' then 'Malaria'	when testnamefr like '%Cracha%' then 'Tuberculose' 	when testnamefr like '%vih%' then 'VIH' when testnamefr LIKE  '%rpr%' then 'RPR' else 'Autres' end as 'Type déxamen', COUNT( * ) as Total, SUM( CASE WHEN result LIKE  'pos%' and testnamefr not like '%Cracha%' THEN 1  when result =1 and testnamefr like '%Cracha%' then 1 ELSE 0 END ) as Positif FROM a_labs WHERE ( testnamefr LIKE  '%malaria%' OR testnamefr LIKE  '%rpr%' OR testnamefr LIKE  '%vih%' OR testnamefr LIKE  '%scope%' OR testnamefr LIKE  '%Cracha%') AND sitecode='".$site."' AND visitdate BETWEEN  '".$startdate."' AND '".$enddate."' GROUP BY 1 ORDER BY 1",
	   
	   "prenatalevisit1"=>"select sum(case when trimester='1ere visite: 0-3 mois' then patientCount else 0 end) as '1ere visite: 0-3 mois',  sum(case when trimester='1ere visite: 4-6 mois' then patientCount else 0 end) as '1ere visite: 4-6 mois', sum(case when trimester='1ere visite: 7-9 mois' then patientCount else 0 end) as '1ere visite: 7-9 mois' from   ( select case when round(datediff(e.visitdate,startdate)) <= 90 then '1ere visite: 0-3 mois'  when round(datediff(e.visitdate,startdate)) between 91 and 180 then '1ere visite: 4-6 mois' when round(datediff(e.visitdate,startdate)) between 181 and 270 then '1ere visite: 7-9 mois' when round(datediff(e.visitdate,startdate)) > 271 then 'post' end as trimester, count(distinct a.patientid) patientCount from dw_pregnancy_ranges a, encValidAll e where e.patientID=a.patientID and e.visitdate between a.startdate and a.stopdate and e.visitdate between '".$startdate."' AND '".$enddate."'  and e.sitecode='".$site."' and round(datediff(e.visitdate,startdate)) < 271 group by trimester order by trimester ) A",

      "grossesseRisque"=>"SELECT  'Grossesse a risque', COUNT( DISTINCT e.patientID ) 'Total Patients' FROM encValidAll e, obs o, concept c WHERE encounterType IN ( 24, 25 ) AND e.encounter_id = o.encounter_id AND e.sitecode =  '".$site."' AND c.concept_id = o.concept_id AND ( c.short_name LIKE  'diabetespregnancy%' OR c.short_name LIKE  'htapregnancy%' OR c.short_name LIKE  'hemorragie%' OR c.short_name LIKE  '%eclampsia%' OR c.short_name LIKE  'vaginalBleedingA%' OR c.short_name LIKE  'membraneRupture%' OR c.short_name LIKE  'menacePrema%' ) AND visitdate BETWEEN  '".$startdate."' AND '".$enddate."' GROUP BY 1 ORDER BY 1",
	  
	  "anemie"=> "SELECT  'Cas d''Anemie' AS  'Cas d''Anemie', COUNT( DISTINCT patientID ) as 'Total Patients' FROM obs o, obs m, concept c, concept n, encValidAll e WHERE e.encounter_id = o.encounter_id AND o.location_id = m.location_id AND o.encounter_id = m.encounter_id AND c.concept_id = o.concept_id AND e.sitecode='".$site."'  AND m.concept_id IN ( 70234, 70235, 70236 ) AND m.concept_id = n.concept_id AND c.short_name =  'consult_obs' AND e.encounterType IN ( 24, 25 )  AND visitdate BETWEEN  '".$startdate."' AND '".$enddate."' GROUP BY 1 ",
	  
	  "ConsultationPostnatale"=>"SELECT  '' AS  '1-7 jours',  '' AS  '8-42 jours', COUNT( DISTINCT e.patientID ) AS  'Total' FROM obs o, concept c, encValidAll e WHERE e.encounter_id = o.encounter_id AND c.concept_id = o.concept_id AND c.short_name =  'consult_postnatale' AND e.sitecode =  '".$site."' AND e.encounterType IN ( 24, 25 ) AND visitdate BETWEEN  '2014-05-01' AND  '2014-05-31'",
	  
	  "accouchement"=>"select theAge as 'Age des meres' ,sum( case when method='Normal' then patientCount else 0 end) as 'Normal' ,sum( case when method='Cesarienne' then patientCount else 0 end) as 'Cesarienne' ,sum( case when method='Autres' then patientCount else 0 end) as 'Autres' from ( SELECT CASE WHEN DATEDIFF( visitdate, ymdtodate(dobyy, dobmm, '01') ) /365 <15 THEN '1. < 15 ans'      WHEN DATEDIFF( visitdate, ymdtodate(dobyy, dobmm, '01') ) /365 BETWEEN 15 AND 19 THEN '2. 15 - 19 ans'      WHEN DATEDIFF( visitdate, ymdtodate(dobyy, dobmm, '01') ) /365 BETWEEN 20 AND 34 THEN '3. 20 - 34 ans'       WHEN DATEDIFF( visitdate, ymdtodate(dobyy, dobmm, '01') ) /365 >34 THEN '4. 35 ans et plus'       ELSE '5. Age inconnu'     END theAge, case when o.value_numeric in (1,2) then 'Cesarienne'      when o.value_numeric=4 then 'Autres'      else 'Normal'  end as method, COUNT( DISTINCT p.patientID ) AS patientCount FROM patient p, encValidAll e left join obs o on e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = 7820 WHERE e.encountertype =26 AND e.patientid = p.patientid AND e.sitecode='".$site."' AND visitdate BETWEEN  '".$startdate."' AND '".$enddate."' GROUP BY 1 , 2 ) A group by 1 ORDER BY 1",
	  
	  "naissancevivante"=>"select poids_range  ,sum( case when method='Normal' then patientCount else 0 end) as 'Normal' ,sum( case when method='Cesarienne' then patientCount else 0 end) as 'Cesarienne' ,sum( case when method='Autres' then patientCount else 0 end) as 'Autres' from (SELECT  CASE WHEN w.poids < 2.5 then '1. < 2.5 Kg'  WHEN w.poids between 2.5 and 4.5 then '2. > 2.5 Kg' ELSE '3. Non pesés' END as poids_range ,r.method, count(distinct e.patientID) as patientCount FROM encValidAll e, (SELECT p.location_id, p.encounter_id, c.short_name as birthweight, case when u.value_numeric = 1 then p.value_text+0 else (p.value_text+0)*.453592 end as poids from obs p, obs u, concept c, concept d where c.short_name in ('birthHistoryWeight1','birthHistoryWeight2','birthHistoryWeight3','birthHistoryWeight4') and d.short_name in ('birthHistoryWeightUnit1','birthHistoryWeightUnit2','birthHistoryWeightUnit3','birthHistoryWeightUnit4') and right(c.short_name,1) = right(d.short_name,1) and c.concept_id = p.concept_id and p.encounter_id = u.encounter_id and p.location_id = u.location_id and d.concept_id = u.concept_id) w left join (SELECT s.location_id, s.encounter_id, case when t.concept_Id =7820 and s.value_numeric in (1,2) then 'Cesarienne'      when t.concept_Id =7820 and s.value_numeric=4  then 'Autres'      else 'Normal'  END AS method, t.short_name as mortality FROM obs s, obs m, concept t WHERE t.short_name in ('birthHistoryMortality1','birthHistoryMortality2','birthHistoryMortality3','birthHistoryMortality4') and s.concept_id = t.concept_id and s.value_numeric=1 and s.location_id = m.location_id and s.encounter_id = m.encounter_id ) r on r.location_id = w.location_id and r.encounter_id = w.encounter_id and right(birthweight,1) = right(mortality,1) where e.sitecode = w.location_id and e.encounter_id = w.encounter_id and e.encounterType=26 and e.sitecode='".$site."' and e.visitdate between  '".$startdate."' AND '".$enddate."' group by 1,2 ) A group by 1 order by 1",
	  
	  "deces"=>"select mortality as Mortalite ,sum( case when method='Normal' then patientCount else 0 end) as 'Normal' ,sum( case when method='Cesarienne' then patientCount else 0 end) as 'Cesarienne' ,sum( case when method='Autres' then patientCount else 0 end) as 'Autres' from (SELECT r.method, case when r.mortality like 'birth%' then 'Mort-Nes'     when r.mortality='laborEvolution' then 'Deces Maternels'      else 'Autes' end as mortality, COUNT( DISTINCT e.patientID ) AS patientCount FROM encValidAll e, (SELECT s.location_id, s.encounter_id,  case when m.concept_Id =7820 and m.value_numeric in (1,2) then 'Cesarienne'      when m.concept_Id =7820 and m.value_numeric=4  then 'Autres'      else 'Normal'  END AS method, t.short_name AS mortality FROM obs s, obs m, concept t WHERE t.short_name IN ('birthHistoryMortality1',  'birthHistoryMortality2',  'birthHistoryMortality3',  'birthHistoryMortality4','laborEvolution' ) AND s.concept_id = t.concept_id AND s.value_numeric <>1 AND s.location_id = m.location_id AND s.encounter_id = m.encounter_id )r WHERE e.sitecode = r.location_id AND e.encounter_id = r.encounter_id AND e.encounterType =26 AND e.sitecode='".$site."' AND e.visitdate BETWEEN   '".$startdate."' AND '".$enddate."' GROUP BY 1 , 2 ) A group by 1 ORDER BY 1",
	  
	  "enfant1"=>"SELECT CASE WHEN DATEDIFF( visitdate, ymdtodate(dobyy, dobmm,  '01') ) /365 <1 THEN  'Population < 1 ans' WHEN DATEDIFF( visitdate, ymdtodate(dobyy, dobmm,  '01') ) /365 BETWEEN 1 AND 4 THEN  'Population 1 - 4 ans' END as 'Groupe d''ages',count(distinct e.patientid) as 'Total d''enfant' FROM  patient p,encValidAll e WHERE  e.sitecode='73103' AND e.patientid = p.patientid and e.sitecode='".$site."' and DATEDIFF( visitdate, ymdtodate(dobyy, dobmm,  '01') ) /365 <=4 and visitdate BETWEEN  '".$startdate."' AND '".$enddate."' AND encountertype in (16,17,27,29,31) group by 1",

      "vaccination"=>"select Vaccin ,sum(case when theAge='< 1 ans' then patientCount else 0 end) as 'Enfants < 1 ans' ,sum(case when theAge='1 - 4 ans' then patientCount else 0 end) as 'Enfants 1 - 4 ans'  from (SELECT  CASE WHEN DATEDIFF( visitdate, ymdtodate(dobyy, dobmm,  '01') ) /365 <1 THEN  '< 1 ans' WHEN DATEDIFF( visitdate, ymdtodate(dobyy, dobmm,  '01') ) /365 BETWEEN 1 AND 4 THEN  '1 - 4 ans' ELSE  '5 ans et plus' END theAge, CASE WHEN short_name LIKE  'bcgDt%' THEN  'bcg' WHEN short_name LIKE  'polioDt%' THEN  'polio' WHEN short_name LIKE  'dtperDt%' THEN  'dtper' WHEN short_name LIKE  'rougeoleDt%' THEN  'rougeole' ELSE  'AUTRES' END AS Vaccin, COUNT( DISTINCT e.patientID ) as patientCount FROM obs o, concept c, encValidAll e,patient p WHERE o.concept_id = c.concept_id AND e.encounter_id = o.encounter_id and e.patientID=p.patientID and e.sitecode='".$site."' and visitdate BETWEEN  '".$startdate."' AND '".$enddate."' AND value_datetime IS NOT NULL AND ( c.short_name LIKE  'bcgDt%' OR c.short_name LIKE  'polioDt%' OR c.short_name LIKE  'dtperDt%' OR c.short_name LIKE  'rougeoleDt%' ) GROUP BY 1,2 )B group by 1 order by 1",
	  
	  "vitaminA"=>"select Vaccin,sum(case when theAge='< 1 ans' then patientCount else 0 end) as ' < 1 ans' ,sum(case when theAge='1 - 4 ans' then patientCount else 0 end) as ' 1-4 ans' ,sum(case when theAge='5 - 7 ans' then patientCount else 0 end) as ' 5-7 ans' from (SELECT CASE WHEN DATEDIFF( visitdate, ymdtodate(dobyy, dobmm,  '01') ) /365 <1 THEN  '< 1 ans' WHEN DATEDIFF( visitdate, ymdtodate(dobyy, dobmm,  '01') ) /365 BETWEEN 1 AND 4 THEN  '1 - 4 ans' WHEN DATEDIFF( visitdate, ymdtodate(dobyy, dobmm,  '01') ) /365 BETWEEN 5 AND 7 THEN  '5 - 7 ans' ELSE  '8 ans et plus' END theAge,CASE WHEN short_name='supplementVITA1' THEN  'Dose 1' ELSE  'Dose 2 & Plus' END AS Vaccin, COUNT( DISTINCT e.patientID ) as patientCount FROM obs o, concept c, encValidAll e,patient p WHERE o.concept_id = c.concept_id AND e.encounter_id = o.encounter_id and e.patientID=p.patientID and e.sitecode='".$site."' and visitdate BETWEEN  '".$startdate."' AND '".$enddate."' AND value_datetime IS NOT NULL AND c.short_name LIKE  'supplementVITA%' GROUP BY 1,2 ) A group by 1 order by 1",
	  
	  "episodemaladie"=>"select 
case when conditionNameFr like 'an%mi%' or 
          conditionNameFr like 'scd%' or 
		  conditionNameFr like 'sicklecell %' or 
		  conditionNameFr like 'anémi%' then 'Anémie'     
	when conditionNameFr like 'asthma%' then 'Asthme'	 
	when conditionNameFr like 'Conjonctivite%' then 'Conjonctivite'	 
	when conditionNameFr like 'Diab%te%' or conditionNameFr like 'Diabéte%' then 'Diabéte'	 
	when conditionNameFr like 'Diarrh%e%' or conditionNameFr like 'Diarrhée%'  then 'Diarrhée'	 
	when conditionNameFr like 'malaria%' then 'Malaria'	
	when conditionNameFr like 'abscess' then 'absces'
	when conditionNameFr like 'Candidose%buccale%' then 'Candidose buccale' 
	when conditionNameFr like 'Charbon' then 'Charbon'	 
	when conditionNameFr like 'Cardiopathy' then 'Cardiopathie'
	when conditionNameFr like 'Amygdalite%' then 'Amygdalite'	
	when conditionNameFr like 'Cardiopathy%' then 'Cardiopathy'	 
	when conditionNameFr like 'Hypertension arterielle%' then 'Hypertension arterielle'	 
	when conditionNameFr like 'impetigo%' then 'impetigo'	 
	when conditionNameFr like 'Infection des Tissus%' then 'Infection des Tissus'	 
	when conditionNameFr like 'Infection voies respiratoires%' then 'Infection voies respiratoires'	 
	when conditionNameFr like 'Pneumonie%' then 'Pneumonie'	 
	when conditionNameFr like 'Teigne%' 	then 'Teigne'	
	when conditionNameFr like 'Autre%' or conditionNameFr like 'physicalOtherText' 	then 'Autres spécifies' 
	when conditionNameFr like 'Epilepsie%' then 'Epilepsie' 	 
	when conditionNameFr like 'Grossesse%' then 'Grossesse'  	 
	when conditionNameFr like 'Parasitose%' then 'Parasitose' 	
	when conditionNameFr like 'DengueN'  then 'Dengue'
	when conditionNameFr like 'Fracture osseuseN' then 'Fracture osseuse'
	when conditionNameFr like 'GaleN' then 'Gale'
	when conditionNameFr like 'gastroenteritiswithdehydrationmild' then 'Deshydratation legere avec gastro enterite'
	when conditionNameFr like 'fungalskin' then 'Infection fongique de la peau'
	when conditionNameFr like 'genUriInfectionDx' then 'Infection genito-Urinaire'
	when conditionNameFr like 'Méningites à Cryptococcose (extra pulmonaire)' then 'Méningites à Cryptococcus (extra pulmonaire)'
	when conditionNameFr like 'Fever indeterminee%' then 'Fievre indeterminee'
	when conditionNameFr like 'MeningitesN' then 'Meningites'
	when conditionNameFr like 'OtiteN' then 'Otite'
	when conditionNameFr like 'PlaieN' then 'Plaie'
	when conditionNameFr like 'Oesphagites dûe à candidose' then 'Oesphagites dûe à candida'
	when conditionNameFr like 'RougeoleN' then 'Rougeole'
	when conditionNameFr like 'VaricelleN' then 'Varicelle'
	when conditionNameFr like 'travailLatent' then 'Phase de latence du travail'
	when conditionNameFr like 'Syndrome icterique febrileN' then 'Syndrome icterique febrile'
	when conditionNameFr like 'nephroticsyndrome' then 'Syndrome nephrotique'
	when conditionNameFr like 'feverTyphoidSuspected' then 'Fievre Typhoide Suspecte'
	when conditionNameFr like 'malnutrition%' then 'Malnutrition'
	when conditionNameFr like 'Fibrome ut%rin' then 'Fibrome utérin'
	when conditionNameFr like '%tuberculos%' or 
	     conditionNameFr like 'dxtb%' or 
		 conditionNameFr like'dxMDRtb%' then 'Tuberculose' 	  
	when conditionNameFr like 'HIV%' then 'VIH' 	 
	when conditionNameFr like 'Tetanos%' then 'Tetanos' 	 
	when conditionNameFr like 'Syphilis%' then 'Syphilis' 	 
else conditionNameFr 	 end as 'Maladies / Symptomes'	 ,sum( case when AgeGroup='Femme < 1 an' then patientCount else 0 end) as 'Femme < 1 an'	 ,sum( case when AgeGroup='Homme < 1 an' then patientCount else 0 end) as 'Homme < 1 an'	 ,sum( case when AgeGroup='Femme 1-4 ans' then patientCount else 0 end) as 'Femme 1-4 ans'	 ,sum( case when AgeGroup='Homme 1-4 ans' then patientCount else 0 end) as 'Homme 1-4 ans'	 ,sum( case when AgeGroup='Femme 5-9 ans' then patientCount else 0 end) as 'Femme 5-9 ans'	 ,sum( case when AgeGroup='Homme 5-9 ans' then patientCount else 0 end) as 'Homme 5-9 ans'	 ,sum( case when AgeGroup='Femme 10-14 ans' then patientCount else 0 end) as 'Femme 10-14 ans'	 ,sum( case when AgeGroup='Homme 10-14 ans' then patientCount else 0 end) as 'Homme 10-14 ans'	 ,sum( case when AgeGroup='Femme 15-24 ans' then patientCount else 0 end) as 'Femme 15-24 ans'	 ,sum( case when AgeGroup='Homme 15-24 ans' then patientCount else 0 end) as 'Homme 15-24 ans'	 ,sum( case when AgeGroup='Femme 25-49 ans' then patientCount else 0 end) as 'Femme 25-49 ans'	 ,sum( case when AgeGroup='Homme 25-49 ans' then patientCount else 0 end) as 'Homme 25-49 ans'	 ,sum( case when AgeGroup='Femme 50 and +' then patientCount else 0 end) as 'Femme 50 and +'	 ,sum( case when AgeGroup='Homme 50 and +' then patientCount else 0 end) as 'Homme 50 and +'     ,sum( case when AgeGroup like '%Femme%' then patientCount else 0 end) as 'Total Femme'	 	 ,sum( case when AgeGroup like '%Homme%' then patientCount else 0 end) as 'Total Homme' 	 ,sum( patientCount) as 'Total'  from ((select case when c.theAge < 1 and c.gender='Femme' then   'Femme < 1 an' when c.theAge < 1 and c.gender='Homme' then   'Homme < 1 an' when c.theAge between 1 and 4 and  c.gender='Femme' then 'Femme 1-4 ans' when c.theAge between 1 and 4 and  c.gender='Homme' then 'Homme 1-4 ans' when c.theAge between 5 and 9 and  c.gender='Femme' then 'Femme 5-9 ans' when c.theAge between 5 and 9 and  c.gender='Homme' then 'Homme 5-9 ans' when c.theAge between 10 and 14 and  c.gender='Femme' then 'Femme 10-14 ans' when c.theAge between 10 and 14 and  c.gender='Homme' then 'Homme 10-14 ans' when c.theAge between 15 and 24 and  c.gender='Femme' then 'Femme 15-24 ans' when c.theAge between 15 and 24 and  c.gender='Homme' then 'Homme 15-24 ans' when c.theAge between 25 and 49 and  c.gender='Femme' then 'Femme 25-49 ans' when c.theAge between 25 and 49 and  c.gender='Homme' then 'Homme 25-49 ans' when c.theAge >= 50 and  c.gender='Femme' then 'Femme 50 and +' when c.theAge >= 50 and  c.gender='Homme' then 'Homme 50 and +' else 'Unk' end as 'AgeGroup', l.conditionNameFr, count(pid) patientCount from conditionLookup l, (select a.conditionid, case when p.sex = 1 then 'Femme' else 'Homme' end as 'gender', round(datediff(a.visitdate,ymdtodate(p.dobyy,'01','01'))/365.242199) as 'theAge', a.patientid as 'pid' from a_conditions a, patient p where a.visitdate between '".$startdate."' AND '".$enddate."' and a.sitecode='".$site."'  and a.patientid = p.patientid) c where l.conditionsid = c.conditionid group by 1,2) union (select case when c.theAge < 1 and c.gender='Femme' then   'Femme < 1 an'  when c.theAge < 1 and c.gender='Homme' then   'Homme < 1 an'  when c.theAge between 1 and 4 and  c.gender='Femme' then 'Femme 1-4 ans'  when c.theAge between 1 and 4 and  c.gender='Homme' then 'Homme 1-4 ans' when c.theAge between 5 and 9 and  c.gender='Femme' then 'Femme 5-9 ans' when c.theAge between 5 and 9 and  c.gender='Homme' then 'Homme 5-9 ans' when c.theAge between 10 and 14 and  c.gender='Femme' then 'Femme 10-14 ans' when c.theAge between 10 and 14 and  c.gender='Homme' then 'Homme 10-14 ans' when c.theAge between 15 and 24 and  c.gender='Femme' then 'Femme 15-24 ans' when c.theAge between 15 and 24 and  c.gender='Homme' then 'Homme 15-24 ans' when c.theAge between 25 and 49 and  c.gender='Femme' then 'Femme 25-49 ans'  when c.theAge between 25 and 49 and  c.gender='Homme' then 'Homme 25-49 ans' when c.theAge >= 50 and  c.gender='Femme' then 'Femme 50 and +' when c.theAge >= 50 and  c.gender='Homme' then 'Homme 50 and +' else 'Unk' end as 'AgeGroup', case when l.name <> '' then l.name else l.short_name end as 'condition',  count(pid) from concept_name l,(select a.concept_id, case when p.sex = 1 then 'Femme' else 'Homme' end as 'gender', round(datediff(e.visitdate,ymdtodate(p.dobyy,'01','01'))/365.242199) as 'theAge', e.patientid as 'pid' from obs a, patient p, encValidAll e, concept t where a.location_id = e.sitecode and e.visitdate between '".$startdate."' AND '".$enddate."' and e.sitecode='".$site."' and e.patientid = p.patientid and e.encounter_id = a.encounter_id and t.class_id = 4 and t.concept_id = a.concept_id) c where l.concept_id = c.concept_id group by 1,2) ) B where right(conditionNameFr,1)<>'A' group by 1 order by 1",
	  
	  "frequentation"=>" select 'Institutionnelles' as '',sum(case when category='Nouvelles' then PatientCount else 0 end) Nouvelles,sum(case when category='Subsequentes' then PatientCount else 0 end) Subsequentes from (select case when encountertype in (1,3, 16,24,27,29) then 'Nouvelles' else 'Subsequentes' end as 'category', count(distinct patientid) as 'PatientCount' from encValidAll where visitdate between '".$startdate."' and '".$enddate."' and sitecode='".$site."' and encountertype in (1,2,3,4,16,17,24,25,27,28,29,31) group by 1)c union select 'Non-Institutionnelles' as '', '' as Nouvelles,'' as Subsequentes",

      "planFamilial"=>"select method as Methode,sum(patientCount) Utilisateurs, sum(case when AgeGroup='< 25 ans' then patientCount else 0 end) as 'Acceptant < 25 ans',sum(case when AgeGroup='>= 25 ans' then patientCount else 0 end) as 'Acceptant >= 25 ans' from (SELECT CASE WHEN DATEDIFF( visitdate, ymdtodate(dobyy, dobmm,  '01') ) /365 <25 then '< 25 ans' else '>= 25 ans' end AgeGroup,case when short_Name='famPlanMethodCollier' or o.value_text like '%collier%' then  'Collier' when short_Name='famPlanMethodCollierDt'  then  'Collier' when short_Name='famPlanMethodCounseling'  then  'Counseling' when short_Name='famPlanMethodImplant'  then  'Implant' when short_Name='famPlanMethodImplants'  then  'Implant' when short_Name='famPlanMethodInjectable'  then  'Injectable' when short_Name='famPlanMethodLigature'  then  'Ligature' when short_Name='famPlanMethodNorplan' or o.value_text like '%norplan%' then  'Norplan' when short_Name='famPlanMethodPillCombined'  then  'PillCombined' when short_Name='famPlanMethodPillOnly'  then  'PillOnly' when short_Name='famPlanMethodSterile'  then  'Sterilet' when short_Name='famPlanMethodTablet'  then  'Tablet' when o.value_text like '%depo%' then 'depo provera'  when o.value_text like '%feme%' then 'Lo femonal' when o.value_text like '%pilplan%' then 'pilplan'  else 'Autres'  end method, count(distinct e.patientID) patientCount FROM obs o, concept c, encValidAll e,patient p WHERE o.concept_id = c.concept_id AND e.encounter_id = o.encounter_id AND p.patientID =e.patientID AND c.short_Name in ('famPlanMethod','famPlanMethodCollier','famPlanMethodCollierDt','famPlanMethodCounseling','famPlanMethodImplant','famPlanMethodImplants','famPlanMethodInjectable','famPlanMethodLigature','famPlanMethodNorplan','famPlanMethodPillCombined','famPlanMethodPillOnly','famPlanMethodSterile','famPlanMethodTablet') AND e.visitdate BETWEEN  '".$startdate."' and '".$enddate."' and e.sitecode='".$site."'group by 1,2 ) A where method<>'Autres' group by 1"
	   ); 
  
  $consultation = outputQueryRows($queryArray["consultation"]); 
  $laboratoire =  outputQueryRows($queryArray["laboratoire"]); 
  $prenatalevisit1=outputQueryRows($queryArray["prenatalevisit1"]); 
  $grossesseRisque=outputQueryRows($queryArray["grossesseRisque"]); 
  $anemie=outputQueryRows($queryArray["anemie"]);
  $ConsultationPostnatale=outputQueryRows($queryArray["ConsultationPostnatale"]);
  $accouchement=outputQueryRows($queryArray["accouchement"]);
  $naissancevivante=outputQueryRows($queryArray["naissancevivante"]);
  $deces=outputQueryRows($queryArray["deces"]);
  $enfant1=outputQueryRows($queryArray["enfant1"]);
  $vaccination=outputQueryRows($queryArray["vaccination"]); 
  $vitaminA=outputQueryRows($queryArray["vitaminA"]);
  $episodemaladie=outputQueryRows($queryArray["episodemaladie"]);
  $frequentation=outputQueryRows($queryArray["frequentation"]);
  $planFamilial=outputQueryRows($queryArray["planFamilial"]);

  $enfant=outputEnfant($startdate,$enddate,$site);
  $visit=outputVisit($startdate,$enddate,$site);
  

  $etatFinancier1= '<table width="100%" border="1" cellspacing="0" style="font-family: Lucida Console; font-size: 12.0px; padding:0px;">
      <tr><td width="171">Sorties</td><td width="124">Gourdes</td></tr>
      <tr><td>Contractuels</td><td><input type="text" name="ef_contractuel" id="ef_contractuel" '.getData("ef_contractuel", "text").'></td></tr>
      <tr><td>Achat services </td><td><input type="text" name="ef_achatService" id="ef_achatService" '.getData("ef_achatService", "text").'></td></tr>
      <tr><td>Medicaments</td><td><input type="text" name="ef_medicament" id="ef_medicament" '.getData("ef_medicament", "text").'></td></tr>
      <tr><td>Materiels fongibles </td><td><input type="text" name="ef_materielFongible" id="ef_materielFongible" '.getData("ef_materielFongible", "text").'></"></td></tr>
      <tr><td>Equipements</td><td><input type="text" name="ef_equipement" id="ef_equipement" '.getData("ef_equipement", "text").'></td></tr>
      <tr><td>Divers</td><td><input type="text" name="ef_divers"  id="ef_divers" '.getData("ef_divers", "text").'></td></tr>
      <tr><td>Total</td><td><input type="text" name="ef_total" id="ef_total" '.getData("ef_total", "text").'></td></tr>
      <tr><td>Balance</td><td><input type="text" name="ef_balance" id="ef_balance" '.getData("ef_balance", "text").'></td></tr>
    </table>';
  
  

  $etatFinancier2= '<table width="100%" border="1" cellspacing="0" style="font-family: Lucida Console; font-size: 12.0px; padding:0px;">
      <tr><td width="163">Entrees</td><td width="155">Gourdes</td></tr>
      <tr><td>1. Balance anterieur </td><td><input type="text" name="ef_balanceAnterieur" id="ef_balanceAnterieur"' . getData("ef_balanceAnterieur", "text") .         '></td></tr>
      <tr><td>2. Allocations </td><td><input type="text" name="ef_allocation" id="ef_allocation"' . getData("ef_allocation", "text") . '></td></tr>
      <tr><td>3. Dons </td><td><input type="text" name="ef_don" id="ef_don"' . getData("ef_don", "text") . '></td></tr>
      <tr><td>4. Recettes </td><td><input type="text" name="ef_recette" id="ef_recette"  '.getData("ef_recette", "text").'></td></tr>
      <tr><td>  Consultations </td><td><input type="text" name="ef_consultation" id="ef_consultation" '.getData("ef_consultation", "text").'></td></tr>
      <tr><td>Pharmacie</td><td><input type="text" name="ef_pharmarcie" id="ef_pharmarcie" '.getData("ef_pharmarcie", "text").'></></td></tr>
      <tr><td>Odontologie</td><td><input type="text" name="ef_odontologie" id="ef_odontologie" '.getData("ef_odontologie", "text").'></></></td></tr>
      <tr><td>Laboratoire</td><td><input type="text" name="ef_laboratoire" id="ef_laboratoire" '.getData("ef_laboratoire", "text").'></td></tr>
      <tr><td>Radiologie</td><td><input type="text" name="ef_radiologie" id="ef_radiologie" '.getData("ef_radiologie", "text").'></td></tr>
      <tr><td>Hospitalisation</td><td><input type="text" name="ef_hospitalisation" id="ef_hospitalisation" '.getData("ef_hospitalisation", "text").'></td></tr>
      <tr><td>Autres</td><td><input type="text" name="ef_autres" id="ef_autres" '.getData("ef_autres", "text").'></td></tr>
      <tr><td>Total</td><td><input type="text" name="ef_total_2" id="ef_total_2" '.getData("ef_total_2", "text").'></td></tr>
    </table>';
	
	

	$comunication='<center><table width="90%" border="1" cellspacing="0" style="font-family: Lucida Console; font-size: 12.0px; padding:0px;">
  <tr>
    <td>&nbsp;</td>
    <td>Discution de groupe </td>
    <td>Causeries</td>
    <td>Assistances conseil</td>
    <td>Forum</td>
    <td>Reunions communautaires </td>
    <td>Autres</td>
  </tr>
  <tr>
    <td>Prise en charge enfant </td>
    <td><input type="text" name="priseEnChargeEnfant_discutionGroupe" id="priseEnChargeEnfant_discutionGroupe" '.getData("priseEnChargeEnfant_discutionGroupe", "text").'></></td>
    <td><input type="text" name="priseEnChargeEnfant_causerie" id="priseEnChargeEnfant_causerie" '.getData("priseEnChargeEnfant_causerie", "text").'></></></td>
    <td><input type="text" name="priseEnChargeEnfant_assistance" id="priseEnChargeEnfant_assistance" '.getData("priseEnChargeEnfant_assistance", "text").'></td>
    <td><input type="text" name="priseEnChargeEnfant_forum" id="priseEnChargeEnfant_forum" '.getData("priseEnChargeEnfant_forum", "text").'></></td>
    <td><input type="text" name="priseEnChargeEnfant_reunion" id="priseEnChargeEnfant_reunion" '.getData("priseEnChargeEnfant_reunion", "text").'></td>
    <td><input type="text" name="priseEnChargeEnfant_autres" id="priseEnChargeEnfant_autres" '.getData("priseEnChargeEnfant_autres", "text").'></></td>
  </tr>
  <tr>
    <td>Sante reproductive </td>
    <td><input type="text" name="santeReproductive_discutionGroupe" id="santeReproductive_discutionGroupe" '.getData("santeReproductive_discutionGroupe", "text").'></td>
    <td><input type="text" name="santeReproductive_causerie" id="santeReproductive_causerie" '.getData("santeReproductive_causerie", "text").'></td>
    <td><input type="text" name="santeReproductive_assistance" id="santeReproductive_assistance" '.getData("santeReproductive_assistance", "text").'></td>
    <td><input type="text" name="santeReproductive_forum" id="santeReproductive_forum" '.getData("santeReproductive_forum", "text").'></></td>
    <td><input type="text" name="santeReproductive_reunion" id="santeReproductive_reunion" '.getData("santeReproductive_reunion", "text").'></td>
    <td><input type="text" name="santeReproductive_autres" id="santeReproductive_autres" '.getData("santeReproductive_autres", "text").'></td>
  </tr>
  <tr>
    <td>Hygienne  environnement </td>
    <td><input type="text" name="hygieneEnv_discutionGroupe" id="hygieneEnv_discutionGroupe" '.getData("hygieneEnv_discutionGroupe", "text").'></td>
    <td><input type="text" name="hygieneEnv_causerie" id="hygieneEnv_causerie" '.getData("hygieneEnv_causerie", "text").'></></td>
    <td><input type="text" name="hygieneEnv_assistance" id="hygieneEnv_assistance" '.getData("hygieneEnv_assistance", "text").'></td>
    <td><input type="text" name="hygieneEnv_forum" id="hygieneEnv_forum" '.getData("hygieneEnv_forum", "text").'></td>
    <td><input type="text" name="hygieneEnv_reunion" id="hygieneEnv_reunion" '.getData("hygieneEnv_reunion", "text").'></td>
    <td><input type="text" name="hygieneEnv_autres" id="hygieneEnv_autres" '.getData("hygieneEnv_autres", "text").'></td>
  </tr>
  <tr>
    <td>Hygienne personnelle </td>
    <td><input type="text" name="hygienePers_discutionGroupe" id="hygienePers_discutionGroupe" '.getData("hygienePers_discutionGroupe", "text").'></td>
    <td><input type="text" name="hygienePers_causerie" id="hygienePers_causerie" '.getData("hygienePers_causerie", "text").'></td>
    <td><input type="text" name="hygienePers_assistance" id="hygienePers_assistance" '.getData("hygienePers_assistance", "text").'></td>
    <td><input type="text" name="hygienePers_forum" id="hygienePers_forum" '.getData("hygienePers_forum", "text").'></td>
    <td><input type="text" name="hygienePers_reunion" id="hygienePers_reunion" '.getData("hygienePers_reunion", "text").'></td>
    <td><input type="text" name="hygienePers_autres" id="hygienePers_autres" '.getData("hygienePers_autres", "text").'></td>
  </tr>
  <tr><td>ST/VIH/SIDA</td>
    <td><input type="text" name="stVihSida_discutionGroupe" id="stVihSida_discutionGroupe" '.getData("stVihSida_discutionGroupe", "text").'></td>
    <td><input type="text" name="stVihSida_causerie" id="stVihSida_causerie" '.getData("stVihSida_causerie", "text").'></td>
    <td><input type="text" name="stVihSida_assistance" id="stVihSida_assistance" '.getData("stVihSida_assistance", "text").'></td>
    <td><input type="text" name="stVihSida_forum" id="stVihSida_forum" '.getData("stVihSida_forum", "text").'></td>
    <td><input type="text" name="stVihSida_reunion" id="stVihSida_reunion" '.getData("stVihSida_reunion", "text").'></td>
    <td><input type="text" name="stVihSida_autres" id="stVihSida_autres" '.getData("stVihSida_autres", "text").'></td>
  </tr>
  <tr><td>Autres maladies transmissibles</td>
    <td><input type="text" name="autresMaladie_discutionGroupe" id="autresMaladie_discutionGroupe" '.getData("autresMaladie_discutionGroupe", "text").'></td>
    <td><input type="text" name="autresMaladie_causerie" id="autresMaladie_causerie" '.getData("autresMaladie_causerie", "text").'></></td>
    <td><input type="text" name="autresMaladie_assistance" id="autresMaladie_assistance" '.getData("autresMaladie_assistance", "text").'></td>
    <td><input type="text" name="autresMaladie_forum" id="autresMaladie_forum" '.getData("autresMaladie_forum", "text").'></td>
    <td><input type="text" name="autresMaladie_reunion" id="autresMaladie_reunion" '.getData("autresMaladie_reunion", "text").'></></td>
    <td><input type="text" name="autresMaladie_autres" id="autresMaladie_autres" '.getData("autresMaladie_autres", "text").'></td>
  </tr>
  <tr><td>Autres themes </td>
    <td><input type="text" name="autresThemes_discutionGroupe" id="autresThemes_discutionGroupe" '.getData("autresThemes_discutionGroupe", "text").'></td>
    <td><input type="text" name="autresThemes_causerie" id="autresThemes_causerie" '.getData("autresThemes_causerie", "text").'></td>
    <td><input type="text" name="autresThemes_assistance" id="autresThemes_assistance"  '.getData("autresThemes_assistance", "text").'></td>
    <td><input type="text" name="autresThemes_forum" id="autresThemes_forum" '.getData("autresThemes_forum", "text").'></td>
    <td><input type="text" name="autresThemes_reunion" id="autresThemes_reunion" '.getData("autresThemes_reunion", "text").'></td>
    <td><input type="text" name="autresThemes_autres" id="autresThemes_autres" '.getData("autresThemes_autres", "text").'></td>
  </tr>
</table></center>';
	
  

	  $soinDentaire='<center><table width="90%" border="1" cellspacing="0" style="font-family: Lucida Console; font-size: 12.0px; padding:0px;"><tr><td width="154">&nbsp;</td><td width="101">Nombre</td></tr>
  <tr><td>Patients vus </td><td><input type="text" name="soinDentaire_patientVus" id="soinDentaire_patientVus" '.getData("soinDentaire_patientVus", "text").'></></td></tr>
  <tr><td>Extractions</td><td><input type="text" name="soinDentaire_extraction" id="soinDentaire_extraction" '.getData("soinDentaire_extraction", "text").'></td></tr>
  <tr><td>Prophylaxies</td><td><input type="text" name="soinDentaire_prophylaxie" id="soinDentaire_prophylaxie" '.getData("soinDentaire_prophylaxie", "text").'></></td></tr>
  <tr><td>Amalgames</td><td><input type="text" name="soinDentaire_amalgame" id="soinDentaire_amalgame" '.getData("soinDentaire_amalgame", "text").'></td></tr>
</table></center>';
	
  

  $urgence='<center><table width="90%" border="1" cellspacing="0" style="font-family: Lucida Console; font-size: 12.0px; padding:0px;">
  <tr><td>Causes</td><td>Nombre</td></tr>
  <tr><td>Accident de la route </td><td><input type="text" name="urgence_accidentRoute" id="urgence_accidentRoute" '.getData("urgence_accidentRoute", "text").'></td></tr>
  <tr><td>Accident du travail </td><td><input type="text" name="urgence_accidentTravail" id="urgence_accidentTravail" '.getData("urgence_accidentTravail", "text").'></td></tr>
  <tr><td>Autres</td><td><input type="text" name="urgence_autre" id="urgence_autre" '.getData("urgence_autre", "text").'></td></tr>
  <tr><td colspan="2">Type de prise en charge </td></tr>
  <tr><td>Medicale</td><td><input type="text" name="urgence_medicale" id="urgence_medicale" '.getData("urgence_medicale", "text").'></td></tr>
  <tr><td>Chirurgicale</td><td><input type="text" name="urgence_chirurgicale" id="urgence_chirurgicale" '.getData("urgence_chirurgicale", "text").'></td></tr>
  <tr><td>Obstetrico/Gynecologie</td><td><input type="text" name="urgence_gynecologie" id="urgence_gynecologie" '.getData("urgence_gynecologie", "text").'></td></tr>
  <tr><td>Urgence Relative </td><td><input type="text" name="urgence_relative" id="urgence_relative" '.getData("urgence_relative", "text").'></td></tr>
  <tr><td colspan="2">Devenir</td></tr>
  <tr><td>Soignes</td><td><input type="text" name="urgence_soigne" id="urgence_soigne" '.getData("urgence_soigne", "text").'></td></tr>
  <tr><td>Referes</td><td><input type="text" name="urgence_refere" id="urgence_refere" '.getData("urgence_refere", "text").'></td></tr>
  <tr><td>Decedes</td><td><input type="text" name="urgence_decede" id="urgence_decede" '.getData("urgence_decede", "text").'></td></tr>
  <tr><td>partis sans autorisation </td><td><input type="text" name="urgence_partir" id="urgence_partir" '.getData("urgence_partir", "text").'></td></tr>
</table></center>';

 

 list($oui1,$non1)=isChecked(substr(getData("disponible_amoxicilline", "text"),7,3));
 list($oui2,$non2)=isChecked(substr(getData("disponible_cotrimoxazole", "text"),7,3));
 list($oui3,$non3)=isChecked(substr(getData("disponible_fer", "text"),7,3));
 list($oui4,$non4)=isChecked(substr(getData("disponible_paracetamol", "text"),7,3));
 list($oui5,$non5)=isChecked(substr(getData("disponible_sro", "text"),7,3));
 list($oui6,$non6)=isChecked(substr(getData("disponible_chlorique", "text"),7,3));


  $disponible='<center><table width="90%" border="1" cellspacing="0" style="font-family: Lucida Console; font-size: 12.0px; padding:0px;">
  <tr><td width="104" rowspan="2">&nbsp;</td><td colspan="2">Disponibles tout le mois </td></tr>
  <tr><td width="104" rowspan="">Oui</td><td>Non </td></tr>
  <tr><td>Amoxicilline</td><td><input type="radio" name="disponible_amoxicilline" id="disponible_amoxicilline" value="Oui" '.$oui1.'></td><td><input type="radio" name="disponible_amoxicilline" id="disponible_amoxicilline" value="Non" '.$non1.'></td></tr>
  <tr><td>Cotrimoxazole</td><td><input type="radio" name="disponible_cotrimoxazole" id="disponible_cotrimoxazole" value="Oui" '.$oui2.'></td><td><input type="radio" name="disponible_cotrimoxazole" id="disponible_cotrimoxazole" value="Non" '.$non2.'></td></tr>
  <tr><td>Fer/Acide Folique </td><td><input type="radio" name="disponible_fer" id="disponible_fer" value="Oui" '.$oui3.'></td><td><input type="radio" name="disponible_fer" id="disponible_fer" value="Non" '.$non3.'></td></tr>
  <tr><td>Paracetamol</td><td><input type="radio" name="disponible_paracetamol" id="disponible_paracetamol" value="Oui" '.$oui4.'></td><td><input type="radio" name="disponible_paracetamol" id="disponible_paracetamol" value="Non" '.$non4.'></td></tr>
  <tr><td>SRO</td><td><input type="radio" name="disponible_sro" id="disponible_sro" value="Oui" '.$oui5.'></td><td><input type="radio" name="disponible_sro" id="disponible_sro" value="Non" '.$non5.'></td></tr>
  <tr>
    <td>Chloroquine</td><td><input type="radio" name="disponible_chlorique" id="disponible_chlorique" value="Oui" '.$oui6.'></td><td><input type="radio" name="disponible_chlorique" id="disponible_chlorique" value="Non" '.$non6.'></td></tr>
</table></center>';
 
 
  $vaccinationfemme='<center><table width="90%" border="1" cellspacing="0" cellpadding="0" style="font-family: Lucida Console; font-size: 12.0px; padding:0px;">
          <tr><td><strong>Vaccination Antitetanique</strong></td><td>TT2</td><td>TTR</td></tr>
		  <tr><td>Femmes enceintes</td>
			<td><input type="text" name="vaccination_femmeEnceinteTT2" id="vaccination_femmeEnceinteTT2" '.getData("vaccination_femmeEnceinteTT2", "text").'></td>
			<td><input type="text" name="vaccination_femmeEnceinteTTR" id="vaccination_femmeEnceinteTTR" '.getData("vaccination_femmeEnceinteTTR", "text").'></td></tr>
		  <tr><td>Autres Femmes 15-49 ans</td>
			<td><input type="text" name="vaccination_femme15_49ansTT2" id="vaccination_femme15_49ansTT2" '.getData("vaccination_femme15_49ansTT2", "text").'></></td>
			<td><input type="text" name="vaccination_femme15_49ansTTR" id="vaccination_femme15_49ansTTR" '.getData("vaccination_femme15_49ansTTR", "text").'><td></tr>
		  <tr>
            <td>Autres</td><td><input type="text" name="vaccination_autreTT2" id="vaccination_autreTT2" '.getData("vaccination_autreTT2", "text").'></td>
			<td><input type="text" name="vaccination_autreTTR" id="vaccination_autreTTR" '.getData("vaccination_autreTTR", "text").'></td></tr>
         </table></center>';
 
 
  $contraception='<center><table width="90%" border="1" cellspacing="0" cellpadding="0" style="font-family: Lucida Console; font-size: 12.0px; padding:0px;">
  <tr><td width="35%">Hommes</td>
    <td width="37%"><input type="text" name="contraception_homme_utilisateurs" id="contraception_homme_utilisateurs" '.getData("contraception_homme_utilisateurs", "text").'></td>
    <td width="16%"><input type="text" name="contraception_homme_moins25" id="contraception_homme_moins25" '.getData("contraception_homme_moins25", "text").'></></td>
    <td width="12%"><input type="text" name="contraception_homme_25plus" id="contraception_homme_25plus" '.getData("contraception_homme_25plus", "text").'></td></tr>
  <tr><td>Condom</td>
    <td><input type="text" name="contraception_condom_utilisateurs" id="contraception_condom_utilisateurs" '.getData("contraception_condom_utilisateurs", "text").'></></td>
    <td><input type="text" name="contraception_condom_moins25" id="contraception_condom_moins25" '.getData("contraception_condom_moins25", "text").'></></></td>
    <td><input type="text" name="contraception_condom_25plus" id="contraception_condom_25plus" '.getData("contraception_condom_25plus", "text").'></td></tr>
  <tr><td>CCv </td>
    <td><input type="text" name="contraception_ccv_utilisateurs" id="contraception_ccv_utilisateurs" '.getData("contraception_ccv_utilisateurs", "text").'></></td>
    <td><input type="text" name="contraception_ccv_moins25" id="contraception_ccv_moins25" '.getData("contraception_ccv_moins25", "text").'></td>
    <td><input type="text" name="contraception_ccv_25plus" id="contraception_ccv_25plus" '.getData("contraception_ccv_25plus", "text").'></td></tr>
</table></center>';
  
  

  $contraceptif='<center><table width="90%" border="1" cellspacing="0" cellpadding="0" style="font-family: Lucida Console; font-size: 12.0px; padding:0px;">
  <tr><td width="35%">&nbsp;</td><td width="37%">Unite</td><td width="16%">Quantite</td></tr>
  <tr><td>LoFemenal</td>
    <td><input type="text" name="contraceptif_lofemenal_unite" id="contraceptif_lofemenal_unite" '.getData("contraceptif_lofemenal_unite", "text").'></td>
    <td><input type="text" name="contraceptif_lofemenal_value" id="contraceptif_lofemenal_value" '.getData("contraceptif_lofemenal_value", "text").'></td></tr>
  <tr><td>Ovrette </td>
    <td><input type="text" name="contraceptif_ovrette_unite" id="contraceptif_ovrette_unite" '.getData("contraceptif_ovrette_unite", "text").'></td>
    <td><input type="text" name="contraceptif_ovrette_value" id="contraceptif_ovrette_value" '.getData("contraceptif_ovrette_value", "text").'></td></tr>
   <tr><td>Depo-Provera </td>
    <td><input type="text" name="contraceptif_depoProvena_unite" id="contraceptif_depoProvena_unite" '.getData("contraceptif_depoProvena_unite", "text").'></td>
    <td><input type="text" name="contraceptif_depoProvena_value" id="contraceptif_depoProvena_value" '.getData("contraceptif_depoProvena_value", "text").'></td></tr>
   <tr><td>Noristerat </td>
    <td><input type="text" name="contraceptif_noristerat_unite" id="contraceptif_noristerat_unite" '.getData("contraceptif_noristerat_unite", "text").'></td>
    <td><input type="text" name="contraceptif_noristerat_value" id="contraceptif_noristerat_value" '.getData("contraceptif_noristerat_value", "text").'></td></tr>
   <tr><td>Norplan </td>
    <td><input type="text" name="contraceptif_norplan_unite" id="contraceptif_norplan_unite" '.getData("contraceptif_norplan_unite", "text").'></td>
    <td><input type="text" name="contraceptif_norplan_value" id="contraceptif_norplan_value" '.getData("contraceptif_norplan_value", "text").'></td></tr>
   <tr><td>Sterilet </td>
    <td><input type="text" name="contraceptif_norplan_unite" id="contraceptif_norplan_unite" '.getData("contraceptif_norplan_unite", "text").'></td>
    <td><input type="text" name="contraceptif_norplan_value" id="contraceptif_norplan_value" '.getData("contraceptif_norplan_value", "text").'></></td></tr>
   <tr><td>MAMA </td>
    <td><input type="text" name="contraceptif_mama_unite" id="contraceptif_mama_unite" '.getData("contraceptif_mama_unite", "text").'></td>
    <td><input type="text" name="contraceptif_mama_value" id="contraceptif_mama_value" '.getData("contraceptif_mama_value", "text").'></td></tr>
   <tr><td>Collier </td>
    <td><input type="text" name="contraceptif_collier_unite" id="contraceptif_collier_unite" '.getData("contraceptif_collier_unite", "text").'></td>
    <td><input type="text" name="contraceptif_collier_value" id="contraceptif_collier_value" '.getData("contraceptif_collier_value", "text").'></td></tr>
   <tr><td>Tablettes varginales </td>
    <td><input type="text" name="contraceptif_tablette_unite" id="contraceptif_tablette_unite" '.getData("contraceptif_tablette_unite", "text").'></td>
    <td><input type="text" name="contraceptif_tablette_value" id="contraceptif_tablette_value" '.getData("contraceptif_tablette_value", "text").'></td></tr>
   <tr><td>Condom </td>
    <td><input type="text" name="contraceptif_condom_unite" id="contraceptif_condom_unite" '.getData("contraceptif_condom_unite", "text").'></td>
    <td><input type="text" name="contraceptif_condom_value" id="contraceptif_condom_value" '.getData("contraceptif_condom_value", "text").'></td></tr>
</table>
</center>';


  $operationCcv='<center><table width="90%" border="1" cellspacing="0" cellpadding="0" style="font-family: Lucida Console; font-size: 12.0px; padding:0px;">
  <tr><td width="35%">Ligature des trompes</td>
    <td width="37%"><input type="text" name="operationCcv_ligature" id="operationCcv_ligature" '.getData("operationCcv_ligature", "text").'></td></tr>
  <tr><td>Vasectomie</td>
    <td><input type="text" name="operationCcv_vasectomie" id="operationCcv_vasectomie" '.getData("operationCcv_vasectomie", "text").'></td></tr> 
</table></center>';


  $distributionVitamin='<center><table width="90%" border="1" cellspacing="0" cellpadding="0" style="font-family: Lucida Console; font-size: 12.0px; padding:0px;">
          <tr><td>Femmes recevant Vitamine A</td>
			<td><input type="text" name="distribution_vitamineA_femme" id="distribution_vitamineA_femme" '.getData("distribution_vitamineA_femme", "text").'></td></tr>
		  <tr><td>Femmes recevant du fer</td>
			<td><input type="text" name="distribution_fer_femme" id="distribution_fer_femme" '.getData("distribution_fer_femme", "text").'></td></tr>
		  <tr><td>Femmes recevant de la chloroquine </td>
			<td><input type="text" name="distribution_chlorique_femme" id="distribution_chlorique_femme" '.getData("distribution_chlorique_femme", "text").'></td></tr>
         </table></center>';
 
 
  $visitDomiciliaire='<center><table width="90%" border="1" cellspacing="0" cellpadding="0" style="font-family: Lucida Console; font-size: 12.0px; padding:0px;">
          <tr><td><strong>Visites domiciliaires</strong></td>
			<td><input type="text" name="visitDomiciliaire" id="visitDomiciliaire" '.getData("visitDomiciliaire", "text").'></td></tr>
         </table></center>';
  
  $commentaireFeild=getData("commentaire", "text");
  $commentaireFeild=substr($commentaireFeild,7,strlen($commentaireFeild)-8);
  
  $commentaire='<center><table width="90%" border="1" cellspacing="0" style="font-family: Lucida Console; font-size: 12.0px;">
  <tr>
    <td colspan=2><strong>Commentaires / Remarques</strong></td>
  </tr>
  <tr><td rowspan="4"><textarea name="commentaire" id="commentaire" cols="60" rows="12">'.$commentaireFeild.'</textarea></td></tr>
  </table></center>';
  
  
  $Capacite='<center>
	<table width="90%" border="1" cellspacing="0">
  <tr>
    <td colspan="6"><strong>Capacite installee / Utilisation </strong></td>
    </tr>
  <tr><td>&nbsp;</td><td>Ped.</td><td>Med.Chir.</td><td>Matern.</td><td>Gyneco</td><td>Autres</td></tr>
  <tr>
    <td>Lits disponibles</td>
    <td><input type="text" name="listDisponible_ped" id="listDisponible_ped" '.getData("listDisponible_ped", "text").'></td>
    <td><input type="text" name="listDisponible_medChir" id="listDisponible_medChir" '.getData("listDisponible_medChir", "text").'></td>
    <td><input type="text" name="listDisponible_matern" id="listDisponible_matern" '.getData("listDisponible_matern", "text").'></td>
    <td><input type="text" name="listDisponible_gyneco" id="listDisponible_gyneco" '.getData("listDisponible_gyneco", "text").'></td>
    <td><input type="text" name="listDisponible_autre" id="listDisponible_autre" '.getData("listDisponible_autre", "text").'></td>
    </tr>
  <tr>
    <td>Jours-lits</td>
    <td><input type="text" name="joursLits_ped" id="joursLits_ped" '.getData("joursLits_ped", "text").'></td>
    <td><input type="text" name="joursLits_medChir" id="joursLits_medChir" '.getData("joursLits_medChir", "text").'></></td>
    <td><input type="text" name="joursLits_matern" id="joursLits_matern" '.getData("joursLits_matern", "text").'></></></td>
    <td><input type="text" name="joursLits_gyneco" id="joursLits_gyneco" '.getData("joursLits_gyneco", "text").'></td>
    <td><input type="text" name="joursLits_autre" id="joursLits_autre" '.getData("joursLits_autre", "text").'></td>
    </tr>
  <tr>
    <td>Jour-Patients</td>
    <td><input type="text" name="joursPatient_ped" id="joursPatient_ped" '.getData("joursPatient_ped", "text").'></td>
    <td><input type="text" name="joursPatient_medChir" id="joursPatient_medChir" '.getData("joursPatient_medChir", "text").'></td>
    <td><input type="text" name="joursPatient_matern" id="joursPatient_matern" '.getData("joursPatient_matern", "text").'></td>
    <td><input type="text" name="joursPatient_gyneco" id="joursPatient_gyneco" '.getData("joursPatient_gyneco", "text").'></td>
    <td><input type="text" name="joursPatient_autre" id="joursPatient_autre" '.getData("joursPatient_autre", "text").'></td>
    </tr>
  <tr>
    <td>Hospitalises</td>
    <td><input type="text" name="hospitatite_ped" id="hospitatite_ped" '.getData("hospitatite_ped", "text").'></td>
    <td><input type="text" name="hospitatite_medChir" id="hospitatite_medChir" '.getData("hospitatite_medChir", "text").'></td>
    <td><input type="text" name="hospitatite_matern" id="hospitatite_matern" '.getData("hospitatite_matern", "text").'></td>
    <td><input type="text" name="hospitatite_gyneco" id="hospitatite_gyneco" '.getData("hospitatite_gyneco", "text").'></td>
    <td><input type="text" name="hospitatite_autre" id="hospitatite_autre" '.getData("hospitatite_autre", "text").'></td>
    </tr>
  <tr>
    <td>Exeates </td>
    <td><input type="text" name="exeateVivant_ped" id="exeateVivant_ped" '.getData("exeateVivant_ped", "text").'></td>
    <td><input type="text" name="exeateVivant_medChir" id="exeateVivant_medChir" '.getData("exeateVivant_medChir", "text").'></td>
    <td><input type="text" name="exeateVivant_matern" id="exeateVivant_matern" '.getData("exeateVivant_matern", "text").'></td>
    <td><input type="text" name="exeateVivant_gyneco" id="exeateVivant_gyneco" '.getData("exeateVivant_gyneco", "text").'></td>
    <td><input type="text" name="exeateVivant_autre" id="exeateVivant_autre" '.getData("exeateVivant_autre", "text").'></td>
    </tr>
  <tr>
    <td>Deces avant 48 hres </td>
    <td><input type="text" name="decesAvant48h_ped" id="decesAvant48h_ped" '.getData("decesAvant48h_ped", "text").'></td>
    <td><input type="text" name="decesAvant48h_medChir" id="decesAvant48h_medChir" '.getData("decesAvant48h_medChir", "text").'></td>
    <td><input type="text" name="decesAvant48h_matern" id="decesAvant48h_matern" '.getData("decesAvant48h_matern", "text").'></td>
    <td><input type="text" name="decesAvant48h_gyneco" id="decesAvant48h_gyneco" '.getData("decesAvant48h_gyneco", "text").'></td>
    <td><input type="text" name="decesAvant48h_autre" id="decesAvant48h_autre" '.getData("decesAvant48h_autre", "text").'></td>
    </tr>
  <tr>
    <td>Deces apres 48 hres </td>
    <td><input type="text" name="decesApres48h_ped" id="decesApres48h_ped" '.getData("decesApres48h_ped", "text").'></td>
    <td><input type="text" name="decesApres48h_medChir" id="decesApres48h_medChir" '.getData("decesApres48h_medChir", "text").'></td>
    <td><input type="text" name="decesApres48h_matern" id="decesApres48h_matern" '.getData("decesApres48h_matern", "text").'></td>
    <td><input type="text" name="decesApres48h_gyneco" id="decesApres48h_gyneco" '.getData("decesApres48h_gyneco", "text").'></td>
    <td><input type="text" name="decesApres48h_autre" id="decesApres48h_autre" '.getData("decesApres48h_autre", "text").'></td>
    </tr>
  <tr>
    <td>Jours d\'Hospitalisation </td>
    <td><input type="text" name="jourHospitalisation_ped" id="jourHospitalisation_ped" '.getData("jourHospitalisation_ped", "text").'></td>
    <td><input type="text" name="jourHospitalisation_medChir" id="jourHospitalisation_medChir" '.getData("jourHospitalisation_medChir", "text").'></td>
    <td><input type="text" name="jourHospitalisation_matern" id="jourHospitalisation_matern" '.getData("jourHospitalisation_matern", "text").'></td>
    <td><input type="text" name="jourHospitalisation_gyneco" id="jourHospitalisation_gyneco" '.getData("jourHospitalisation_gyneco", "text").'></td>
    <td><input type="text" name="jourHospitalisation_autre" id="jourHospitalisation_autre" '.getData("jourHospitalisation_autre", "text").'></td>
    </tr>
</table>
	</center>';
  
  
  
  $summary = <<<EOF
  
 <script type="text/javascript">
function ajaxFunction(){
 alert("Saving Hsis report ..... "+"$month "+ " $year "+"$eid" );

var site = document.getElementById('site').value;
var startdate = document.getElementById('startdate').value;
var enddate = document.getElementById('enddate').value;

  var hsysjson1='{"';
  var form=document.forms[0];
  var cnt=0;
  for (i=0 ; i<= form.length-1 ; i++){
  
  if(form[i].type=="text"||form[i].type=="textarea"){
  if(form[i].name=="ef_contractuel") cnt=1; 
  if(form[i].name=="commentaire") {cnt=0; hsysjson1 += form[i].name + '":"' + form[i].value + '"}';}
  if (cnt>=1) {hsysjson1 += form[i].name  + '":"' + form[i].value + '","';}
  }
  if(form[i].type=="radio"&&form[i].checked){hsysjson1 += form[i].name  + '":"' + form[i].value + '","';}
    }

	 
Ext.Ajax.request({   
	url: 'genericsave.php',
	params: {
                type: '34', 
                site: site,
                visitDateDd: '01',
                visitDateYy: '$year',
                visitDateMm: '$month',
                pid: site + '0',
                eid: '$eid', 
                jsonData: hsysjson1 
        },
	failure:function(response,options){
		Ext.MessageBox.alert('Warning','Oops...');
	},                                  
	success:function(response,options){		
		    console.dir (response.responseText);
		var responseData = Ext.util.JSON.decode (response.responseText); 
		Ext.MessageBox.alert('Success', 'report data saved');
	} 
}); 

}
</script>
  
<html>
<head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <style type="text/css">
    a {text-decoration: none}
	input { padding:3px; border:1px solid #F5C5C5; border-radius:2px; width:142px; }
  </style>  
</head>


<body text="#000000" link="#000000" alink="#000000" vlink="#000000" align="center">
<center><table width="90%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top" >
  <td style="width: 70%; padding:15px;"  align="center">
   <div><span style="font-family: Lucida Console; font-size: 15.0px;">
   <strong>MINISTERE DE LA SANTE PUBLIQUE ET DE LA POPULATION</strong></span></div>
   <div><span style="font-family: Lucida Console; font-size: 12.0px;"><strong>RAPPORT MENSUELS DES SERVICES DE SANTE</strong></span></div>
  </td>
  <td style="width: 30%;text-align: right; padding:15px;">
  <div><span style="font-family: Lucida Console; font-size: 12.0px;"><strong>Periode :</strong>   $period </span></div>
  <div><span style="font-family: Lucida Console; font-size: 12.0px;"><strong>Population desservie :</strong> ...................</span></div>
  </td>  
</tr>
</table>

<table width="90%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top" >
  <td style="width: 70%"> 
   <div><span style="font-family: Lucida Console; font-size: 12.0px; border:solid 1px black; padding:5px;"><strong>Institution :</strong> $siteName</span> 
        <span style="font-family: Lucida Console; font-size: 12.0px; border:solid 1px black; padding:5px;"><strong>Niveau :</strong>....... </span>
	  </div>
  </td>		
  <td style="width: 30%;text-align: right;">
		<div>
        <span style="font-family: Lucida Console; font-size: 12.0px; border:solid 1px black; padding:5px;"><strong>Commune :</strong> $commune</span>
        <span style="font-family: Lucida Console; font-size: 12.0px; border:solid 1px black; padding:5px;"><strong>Departement :</strong>$department </span></div>
  </td> 
</tr>
</table>
<div>&nbsp;</div>
<div>&nbsp;</div>


<form action="../isante/backend/hsis_insertMissingValue.php" method="Get">
<input type="hidden" name="site" id="site" value="$site">
<input type="hidden" name="startdate" id="startdate" value="$startdate">
<input type="hidden" name="enddate" id="enddate" value="$enddate">
<table width="90%" border="1">
  <tr>
    <td width="70%">
	<p>&nbsp;</p>
	<div><strong>1) Frequentation de línstitution </strong></div>
	<div>$frequentation</div>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<div><strong>Consultations Generales</strong></div>
	<div>$consultation</div>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<div><strong>2) Etat Financier</strong> </div>
	
	<div>
	<center><table width="90%" border="0" >
  <tr>
    <td width="47%" valign="bottom">$etatFinancier1</td>
    <td width="53%" valign="bottom">$etatFinancier2</td>
  </tr>
</table></center>
</div>
<div>&nbsp;</div>
<div>&nbsp;</div>

<div><strong>3) Communication et education pour la sante </strong></div>
<div>$comunication</div>
	</td>
    <td width="30%" valign="top">
	<div>&nbsp;</div>
	<div><strong>4) Soins Bucco-dentaires</strong></div>
	<div>$soinDentaire</div>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<div><strong>5) Examens de laboratoire</strong></div>
	<div> $laboratoire</div>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<div><strong>6) Urgences</strong></div>
	<div>$urgence</div>
	<div>&nbsp;</div>
	<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
	<div><strong>7) Disponibles</strong></div>
	<div>$disponible</div>
	
	</td>
  </tr>
</table>


<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="100%" border="1">
  <tr>
    <td width="80%">
	<div><strong>8) Prise en charge de la femme</strong></div>
	<div> Nombre de grossesse attendues:-------------</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70%">
	<div><strong>8.1) consultations pre/postnatales </strong></div>	
	<div> &nbsp;</div>
	<div> <strong>Consultations prenatales</strong></div>
	
	<div> 
	     <center><table width="95%" border="0" cellspacing="0">
          <tr>
            <td width="50%">$prenatalevisit1</td>
            <td width="50%">$visit</td>
          </tr>
         </table></center>
	</div>
	
	<div> &nbsp;</div>	
	<div> $grossesseRisque</div>	
	<div> &nbsp;</div>	
	<div>$anemie</div>	
	<div>&nbsp; </div>
    <div>$vaccinationfemme</div>	
		<div> <strong>Consultations Postnatales</strong></div>
	    <div>$ConsultationPostnatale</div>	 
	    <div>&nbsp;</div>
	    <div>$visitDomiciliaire</div>	
	    <div> &nbsp;</div>
        <div> <strong>Distribution de Vitamine A, Fer, Chloroquine</strong></div> 
        <div>$distributionVitamin</div>
        <div> &nbsp;</div>
	    <div><strong>8.2) Accouchement </strong></div>
		<div> $accouchement</div>	 
		 <div> &nbsp;</div>
		 <div><strong>Naisssance Vivante </strong></div>
		<div> $naissancevivante</div>
	     <div> &nbsp;</div>
	    <div><strong>Deces </strong></div>
		<div> $deces</div>		 
	</td>
    <td width="30%" valign="top">
	<div><strong>8.3) consultations PF: -------- </strong></div>	
	<div> <strong>Utilisation et Acceptation Contraception</strong></div>
	<div> $planFamilial </div>
    <div>&nbsp;</div>	
    <div> &nbsp;</div>
	<div>$contraception</div>	
	<div>&nbsp;</div>
	<div> <strong>Contraceptifs distribues</strong></div>
	<div>$contraceptif</div>
	<div>&nbsp;</div>	
	<div> <strong>Operations de CCV</strong></div>
	<div> $operationCcv</div>	
	</td>
  </tr>
</table>

	</td>
    <td width="30%" valign="top">
	<div><strong>9) Prise en charge de l'enfant</strong></div>
	<div> $enfant1</div>	
	<div>&nbsp;</div>
	<div>$enfant</div>
	<div>&nbsp;</div>
	<div><strong>Vaccination</strong></div>
	<div> $vaccination</div>	
	<div>&nbsp;</div>
	<div><strong>Vitamine A</strong></div>
	<div> $vitaminA</div>	
	</td>
  </tr>
</table>

<p>&nbsp;</p>
<p>&nbsp;</p>

<table width="90%" border="1" cellspacing="0">
  <tr>
    <td>
	<div> <strong>10) Nouveaux episodes Maladies</strong></div>
	<div>$episodemaladie</div>
	
	<div>&nbsp;</div>
	<div>&nbsp;</div>
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td width="50%">$Capacite</td>
	<td width="50%">$commentaire</td>
  </tr>	
	
	</td>
  </tr>
</table></center>
<div align="left">
<input type='button' name="buttonSave" id="buttonSave" onclick="ajaxFunction()"  value="Enregistrer"> 
<input type="button" name="buttonClear" value="Annuller"> 
</div>
</form>
<!-- ********************************************************************* -->
<!-- ****************** Ped. imm. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$relatives

</body>
</html>
EOF;

  return ($summary);
}

function outputQueryRows($qry) {
        $output = '';
        // execute the query 
        $arr = databaseSelect()->query($qry)->fetchAll(PDO::FETCH_ASSOC); 
        if (count($arr) == 0) return '<p><center><font color="red"><bold>Aucuns résultats trouvés</bold></font></center><p>';
        // set up the table
        $output = '<center><table class="" width="90%" border="1" cellpadding="0" cellspacing="0">';
        // loop on the results 
        $i = 0;
        foreach($arr as $row) {
               if ($i == 0) { 
                       // output the column header 
                       $output .= '<tr>';
                       foreach($row as $key => $value) $output .= '<th>' . $key . '</th>';
                       $output .= '</tr>'; 
                       $i++;
               } 
               $output .= '<tr>';
               foreach($row as $key => $value) $output .= '<td style="font-family: Lucida Console; font-size: 12.0px; padding:3px;">' . $value . '</td>';
               $output .= '</tr>';
        }
        // close the table 
        $output .= '</table></center>';
        return $output;
}


function outputVisit($startdate,$enddate,$site) {
        $output = '';
        // execute the query 		
		$qry="drop table if exists xxx; create table xxx select a.patientid, visitdate from encValidAll e,dw_pregnancy_ranges a where e.encountertype=25 AND e.sitecode='".$site."' and e.visitdate BETWEEN a.startdate AND a.stopdate AND e.patientID = a.patientID order by 1,2; set @patientid = ''; set @num  = 1; 
 SELECT SUM( CASE WHEN visit =  '2rd visit' THEN patientCount ELSE 0 END ) AS  '2eme visite', SUM( CASE WHEN visit =  '3tr visit' THEN patientCount ELSE 0 END ) AS  '3eme visite', SUM( CASE WHEN visit =  '4ft visit and more' THEN patientCount ELSE 0 END ) AS  '4eme visite and more' FROM (SELECT CASE WHEN row_number =1 THEN  '2rd visit' WHEN row_number =2 THEN  '3tr visit' WHEN row_number >2 THEN  '4ft visit and more' END AS visit, COUNT( DISTINCT patientid ) AS patientCount FROM (SELECT patientid, visitdate, @num := IF( @patientid = patientid, @num +1, 1 ) AS row_number, @patientid := patientid AS dummy FROM xxx, (SELECT @num :=0, @patientid :=0) AS t )A WHERE visitdate BETWEEN  '".$startdate."' and '".$enddate."' GROUP BY 1 )B";
    
	$result = dbQuery($qry);   
    $retArray = array();
	// set up the table 
	$output = '<center><table width="90%" cellpadding="0" cellspacing="0" border="1">
	<tr valign="top" >
	<th style="width: 20%; font-family: Lucida Console; font-size: 12.0px; padding:3px;">2eme Visite</th>
    <th style="width: 20%; font-family: Lucida Console; font-size: 12.0px; padding:3px;">3eme Visite</th>
	<th style="width: 20%; font-family: Lucida Console; font-size: 12.0px; padding:3px;">4eme visite et plus</th>
  </tr>';
	
	while ($row = psRowFetch($result)) {
	$output=$output. '<tr valign="top" >
    <td style="width: 20%; font-family: Lucida Console; font-size: 12.0px; padding:3px;">'.$row[0].'</td> 
	<td style="width: 20%; font-family: Lucida Console; font-size: 12.0px; padding:3px;">'.$row[1].'</td>
    <td style="width: 20%; font-family: Lucida Console; font-size: 12.0px; padding:3px;">'.$row[2].'</td>
  </tr>';
	}
	$output=$output. '</table></center>';		
        return $output;
}


function isChecked($field) { 
$oui=""; $non="";
if($field=="Oui") {$oui="checked";$non="";} else {$oui=""; $non="checked";}
return array($oui,$non);
}


function outputEnfant($startdate,$enddate,$site) {
        $output = '';
        // execute the query 		
		$qry=" drop table if exists careOfChild; create table careOfChild 
SELECT 
e.siteCode,
CASE WHEN DATEDIFF( visitdate, ymdtodate(dobyy, dobmm,  '01') ) /365 <1 THEN  '< 1 ans'
WHEN DATEDIFF( visitdate, ymdtodate(dobyy, dobmm,  '01') ) /365 BETWEEN 1 AND 4 THEN  '1 - 4 ans'
END theAge,
case when r.poids is not null then 'Pese' else 'Non Pese' end poids,
count(distinct e.patientid) patientCount
FROM  patient p,encValidAll e left join
(
SELECT p.location_id, e.patientID,
CASE WHEN u.value_numeric =2 THEN p.value_text +0 ELSE (p.value_text +0) * 0.453592 END AS poids
FROM obs p, obs u, concept c, concept d,encValidAll e
WHERE c.short_name =  'birthWeight'
AND d.short_name =  'birthWeightUnits'
AND c.concept_id = p.concept_id
AND p.encounter_id = u.encounter_id
AND p.location_id = u.location_id
AND d.concept_id = u.concept_id
and e.encounter_id=p.encounter_id
and e.visitdate between '".$startdate."' and '".$enddate."'
union 
SELECT siteCode, patientID, CASE WHEN vitalWeightUnits =1 THEN vitalWeight +0 ELSE (vitalWeight +0) * 0.453592 END AS poids
FROM  `a_vitals` 
WHERE encountertype
IN ( 16, 17, 27, 29, 31 ) 
AND visitdate BETWEEN  '".$startdate."' and '".$enddate."') r on (r.location_id = e.sitecode and r.patientID = e.patientID)
WHERE  e.sitecode='73103'
AND e.patientid = p.patientid
and e.sitecode='73103'
and DATEDIFF( visitdate, ymdtodate(dobyy, dobmm,  '01') ) /365 <=4
and visitdate BETWEEN  '".$startdate."' and '".$enddate."'
AND encountertype in (16,17,27,29,31)
group by 1,2,3;

select 
poids, sum(case when theAge='< 1 ans' then patientCount else 0 end) as '< 1 ans',
sum(case when theAge='1 - 4 ans' then patientCount else 0 end) as '1 - 4 ans'
from careOfChild
group by 1
union 
select 'Total vus',sum(case when theAge='< 1 ans' then patientCount else 0 end) as '< 1 ans',
sum(case when theAge='1 - 4 ans' then patientCount else 0 end) as '1 - 4 ans'
from careOfChild;";
    
	$result = dbQuery($qry);   
    $retArray = array();
	// set up the table 
	$output = '<center><table width="90%" cellpadding="0" cellspacing="0" border="1">
	<tr valign="top" >
	<th style="width: 20%; font-family: Lucida Console; font-size: 12.0px; padding:5px;">Poids</th>
    <th style="width: 20%; font-family: Lucida Console; font-size: 12.0px; padding:5px;"> < 1 ans</th>
	<th style="width: 20%; font-family: Lucida Console; font-size: 12.0px; padding:5px;">1 - 4 ans</th>
  </tr>';
	
	while ($row = psRowFetch($result)) {
	$output=$output. '<tr valign="top" >
    <td style="width: 20%; font-family: Lucida Console; font-size: 12.0px; padding:5px;">'.$row[0].'</td> 
	<td style="width: 20%; font-family: Lucida Console; font-size: 12.0px; padding:5px;">'.$row[1].'</td>
    <td style="width: 20%; font-family: Lucida Console; font-size: 12.0px; padding:5px;">'.$row[2].'</td>
  </tr>';
	}
	$output=$output. '</table></center>';		
    return $output;
}


?>
