<?php
require_once ("backend.php");
require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";  


$startDate=$_REQUEST['startDate'];
$endDate=$_REQUEST['endDate'];
$NbrLigne=2;
//$valeur=0;
$query="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1 then  patientID else null end) as '<1 an',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then   patientID else null end) as '50 ans et plus'
from arv_pnls_report
where DateEnrolement between '".$startDate."' and '".$endDate."' and indicator_id=1 group by sex";

/*$query="select * from arv_pnls_report";*/


$result = databaseSelect()->query($query);


// creation d'un seul array avec toutes les donnees


//$NbreData = $result->rowCount();
$NbreData = 2;
$NbreData2 = 1;
$NbreData3 =2;
$NbreData4 =1;
$NbreData5 =2;
$NbreData6=2;
$NbreData7=2;
$NbreData8=2;
$NbreData9=2;
$NbreData10=2;
$NbreData11=2;
$NbreData12=2;

$NbreData13=2;
$NbreData14=2;
$NbreData15=2;
$NbreData16=2;
$NbreData17=2;
$NbreData18=2;

$NbreData19=2;
$NbreData20=2;
$NbreData21=2;
$NbreData22=2;
$NbreData23=2;
$NbreData24=2;
$NbreData25=2;
$NbreData26=6;



//$NbreData40=2;
$NbreData41=2;
$NbreData42=2;
$NbreData43=2;
$NbreData44=2;
$NbreData45=2;
$NbreData46=2;
$NbreData47=2;
$NbreData48=2;
$NbreData49=2;
$NbreData50=2;
$NbreData51=2;
$NbreData52=2;
$NbreData53=2;
$NbreData54=1;
$NbreData55=2;
$NbreData56=1;
$NbreData57=1;
$NbreData58=1;
$NbreData59=2;
$NbreData60=1;
$NbreData61=1;
$NbreData62=1;

//echo $NbreData;
// creation d'un seul array avec toutes les donnees
$k=0;
while ($val = $result->fetch()) {
   $tableau[$k] = $val;
   $k++;
}
$result->closeCursor();

$query2="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1 then  patientID else null end) as '<1 an',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then   patientID else null end) as '50 ans et plus',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu' from arv_pnls_report
where DebutAllaitement between '".$startDate."' and '".$endDate."' and indicator_id=2 group by sex";
$result2 = databaseSelect()->query($query2);

$k=0;
while ($val = $result2->fetch()) {
   $tableau2[$k] = $val;
   $k++;
}
$result2->closeCursor();

$query3="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1 then  patientID else null end) as '<1 an',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then   patientID else null end) as '50 ans et plus',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu' from arv_pnls_report
where DateTransfert between '".$startDate."' and '".$endDate."' and indicator_id=3 group by sex";
$result3 = databaseSelect()->query($query3);

$k=0;
while ($val = $result3->fetch()) {
   $tableau3[$k] = $val;
   $k++;
}
$result3->closeCursor();

$query4="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1 then  patientID else null end) as '<1 an',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then   patientID else null end) as '50 ans et plus',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu' from arv_pnls_report
where DebutAllaitement between '".$startDate."' and '".$endDate."' and indicator_id=4 group by sex";
$result4 = databaseSelect()->query($query4);

$k=0;
while ($val = $result4->fetch()) {
   $tableau4[$k] = $val;
   $k++;
}
$result4->closeCursor();

$query5="select case when indicator_id=5 then 'Nouveaux enroles pour le mois' when indicator_id=7 then 'Personnes VIH+ enrolées sous ARV dans un autre site et referees au cours du mois' end as groupe,indicator_id, count(case when risk ='HARSAH' then patientID end) 'HARSAH', count(case when risk ='Professionnels de sexe' then patientID end) 'Professionnels de sexe', count(case when risk ='Personnes transgenres' then patientID end) 'Personnes transgenres', count(case when risk ='Prisonniers' then patientID end) 'Prisonniers', count(case when risk ='Utilisateurs de drogues injectables' then patientID end) 'Utilisateurs de drogues injectables' from arv_pnls_report
where (DateEnrolement between '".$startDate."' and '".$endDate."' or DateTransfert between '".$startDate."' and '".$endDate."') and indicator_id in(5,7) group by indicator_id";
$result5 = databaseSelect()->query($query5);

$k=0;
while ($val = $result5->fetch()) {
   $tableau5[$k] = $val;
   $k++;
}
$result5->closeCursor();

$query6="select reasonNoEnrolment, case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1 then  patientID else null end) as '<1 an',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then   patientID else null end) as '50 ans et plus',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu' from arv_pnls_report
where (endDate between '".$startDate."' and '".$endDate."' or endDate is NULL) and reasonNoEnrolment is not NULL and indicator_id=6 group by sex";
$result6 = databaseSelect()->query($query6);

$k=0;
while ($val = $result6->fetch()) {
   $tableau6[$k] = $val;
   $k++;
}$result6->closeCursor();

$query7="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1 then  patientID else null end) as '<1 an',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then   patientID else null end) as '50 ans et plus',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu' from arv_pnls_report
where (DebutAllaitement between '".$startDate."' and '".$endDate."' and endDate between '".$startDate."' and '".$endDate."') and indicator_id=8 group by sex";
$result7 = databaseSelect()->query($query7);

$k=0;
while ($val = $result7->fetch()) {
   $tableau7[$k] = $val;
   $k++;
}$result7->closeCursor();

$query8="select 'Patients VIH+ sous ARV nouvellement mis sous CTX' as groupe, case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1 then  patientID else null end) as '<1 an',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then   patientID else null end) as '50 ans et plus',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu' from arv_pnls_report
where (dateprophylaxieCTX between '".$startDate."' and '".$endDate."') and indicator_id=9 group by sex";
$result8 = databaseSelect()->query($query8);

$k=0;
while ($val = $result8->fetch()) {
   $tableau8[$k] = $val;
   $k++;
}$result8->closeCursor();

$query9="select 'Patients actifs sous ARV sous CTX' as groupe, case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1 then  patientID else null end) as '<1 an',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then   patientID else null end) as '50 ans et plus',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu' from arv_pnls_report
where (dateprophylaxieCTX between '".$startDate."' and '".$endDate."' and endDate between '".$startDate."' and '".$endDate."') and indicator_id=10 group by sex";
$result9 = databaseSelect()->query($query9);

$k=0;
while ($val = $result9->fetch()) {
   $tableau9[$k] = $val;
   $k++;
}$result9->closeCursor();

$query10="select 'Nouveaux enroles sous ARV' as groupe, case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 15 then  patientID else null end) as '<15 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >=15 then   patientID else null end) as '>=15 ans',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
from arv_pnls_report
where (dateprophylaxieINH between '".$startDate."' and '".$endDate."' and DateEnrolement between '".$startDate."' and '".$endDate."') and indicator_id=11 group by sex";
$result10 = databaseSelect()->query($query10);

$k=0;
while ($val = $result10->fetch()) {
   $tableau10[$k] = $val;
   $k++;
}$result10->closeCursor();

$query11="select 'Patients deja sous ARV' as groupe, case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 15 then  patientID else null end) as '<15 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >=15 then   patientID else null end) as '>=15 ans',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
from arv_pnls_report
where (dateprophylaxieINH between '".$startDate."' and '".$endDate."' and DateEnrolement < '".$startDate."') and indicator_id=11 group by sex";
$result11 = databaseSelect()->query($query11);

$k=0;
while ($val = $result11->fetch()) {
   $tableau11[$k] = $val;
   $k++;
}$result11->closeCursor();

$query12="select 'Nouveaux enroles sous ARV' as groupe, case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 15 then  patientID else null end) as '<15 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >=15 then   patientID else null end) as '>=15 ans',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
from arv_pnls_report
where (dateprophylaxieINH between '".$startDate."' - INTERVAL 6 MONTH and '".$endDate."' - INTERVAL 6 MONTH and DateEnrolement between '".$startDate."' - INTERVAL 6 MONTH and '".$endDate."' - INTERVAL 6 MONTH) and indicator_id=11 group by sex";
$result12 = databaseSelect()->query($query12);


$k=0;
while ($val = $result12->fetch()) {
   $tableau12[$k] = $val;
   $k++;
}$result12->closeCursor();

$query13="select 'Patients deja sous ARV' as groupe, case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 15 then  patientID else null end) as '<15 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >=15 then   patientID else null end) as '>=15 ans',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
from arv_pnls_report
where (dateprophylaxieINH between '".$startDate."' - INTERVAL 6 MONTH and '".$endDate."' - INTERVAL 6 MONTH and DateEnrolement < '".$startDate."' - INTERVAL 6 MONTH) and indicator_id=11 group by sex";
$result13 = databaseSelect()->query($query13);

$k=0;
while ($val = $result13->fetch()) {
   $tableau13[$k] = $val;
   $k++;
}$result13->closeCursor();



$k=0;
while ($val = $result13->fetch()) {
   $tableau13[$k] = $val;
   $k++;
}$result13->closeCursor();

$query14="select 'Nouveaux enroles sous ARV' as groupe, case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 15 then patientID else null end) '<15 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >=15 then patientID else null end) '>=15 ans',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu' from arv_pnls_report
where (DateEnrolement between '".$startDate."' - INTERVAL 6 MONTH and '".$endDate."' - INTERVAL 6 MONTH and datearretprophylaxieINH between '".$startDate."' and '".$endDate."') and indicator_id=12 group by sex";
$result14 = databaseSelect()->query($query14);

$k=0;
while ($val = $result14->fetch()) {
   $tableau14[$k] = $val;
   $k++;
}$result14->closeCursor();

$query15="select 'Patients deja sous ARV' as groupe, case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 15 then patientID else null end) '<15 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >=15 then patientID else null end) '>=15 ans',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu' from arv_pnls_report
where (DateEnrolement < '".$startDate."' - INTERVAL 6 MONTH and datearretprophylaxieINH between '".$startDate."' and '".$endDate."') and indicator_id=12 group by sex";
$result15 = databaseSelect()->query($query15);

$k=0;
while ($val = $result15->fetch()) {
   $tableau15[$k] = $val;
   $k++;
}$result15->closeCursor();


$query16="select 'Nouveaux enroles sous ARV' as groupe, case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 15 then patientID else null end) '<15 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >=15 then patientID else null end) '>=15 ans',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu' from arv_pnls_report
where (DateEnrolement between '".$startDate."' and '".$endDate."' and dateVisite between '".$endDate."' - INTERVAL 6 MONTH and '".$endDate."' and endDate between '".$startDate."' and '".$endDate."') and indicator_id=13 and presenceBCG=1 group by sex";
$result16 = databaseSelect()->query($query16);

$k=0;
while ($val = $result16->fetch()) {
   $tableau16[$k] = $val;
   $k++;
}$result16->closeCursor();

$query17="select 'Patients deja sous ARV' as groupe, case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 15 then patientID else null end) '<15 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >=15 then patientID else null end) '>=15 ans',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu' from arv_pnls_report
where (DateEnrolement < '".$startDate."' and dateVisite between '".$endDate."' - INTERVAL 6 MONTH and '".$endDate."' and endDate between '".$startDate."' and '".$endDate."') and indicator_id=13 and presenceBCG=1 group by sex";
$result17 = databaseSelect()->query($query17);

$k=0;
while ($val = $result17->fetch()) {
   $tableau17[$k] = $val;
   $k++;
}$result17->closeCursor();

$query18="select 'Nouveaux enroles sous ARV' as groupe, case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 15 then patientID else null end) '<15 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >=15 then patientID else null end) '>=15 ans', 
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu' from arv_pnls_report
where (DateEnrolement between '".$startDate."' and '".$endDate."' and dateVisite between '".$endDate."' - INTERVAL 6 MONTH and '".$endDate."' and endDate between '".$startDate."' and '".$endDate."') and indicator_id=13 and recentNegPPD=1 group by sex";
$result18 = databaseSelect()->query($query18);

$k=0;
while ($val = $result18->fetch()) {
   $tableau18[$k] = $val;
   $k++;
}$result18->closeCursor();

$query19="select 'Patients deja sous ARV' as groupe, case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 15 then patientID else null end) '<15 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >=15 then patientID else null end) '>=15 ans', 
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu' from arv_pnls_report
where (DateEnrolement < '".$startDate."' and dateVisite between '".$endDate."' - INTERVAL 6 MONTH and '".$endDate."' and endDate between '".$startDate."' and '".$endDate."') and indicator_id=13 and recentNegPPD=1 group by sex";
$result19 = databaseSelect()->query($query19);

$k=0;
while ($val = $result19->fetch()) {
   $tableau19[$k] = $val;
   $k++;
}$result19->closeCursor();

$query20="select 'Nouveaux enroles sous ARV' as groupe, case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 15 then patientID else null end) '<15 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >=15 then patientID else null end) '>=15 ans', 
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu' from arv_pnls_report
where (DateEnrolement between '".$startDate."' and '".$endDate."' and datetraitemntAntiTb between '".$startDate."' and '".$endDate."') and indicator_id=14 group by sex";
$result20 = databaseSelect()->query($query20);

$k=0;
while ($val = $result20->fetch()) {
   $tableau20[$k] = $val;
   $k++;
}$result20->closeCursor();

$query21="select 'Patients deja sous ARV' as groupe, case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 15 then patientID else null end) '<15 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >=15 then patientID else null end) '>=15 ans', 
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu' from arv_pnls_report
where (DateEnrolement < '".$startDate."' and datetraitemntAntiTb between '".$startDate."' and '".$endDate."') and indicator_id=14 group by sex";
$result21 = databaseSelect()->query($query21);

$k=0;
while ($val = $result21->fetch()) {
   $tableau21[$k] = $val;
   $k++;
}$result21->closeCursor();

$query22="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1 then  patientID else null end) as '<1 an',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then   patientID else null end) as '50 ans et plus',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
from arv_pnls_report
where datetraitemntAntiTb between '".$startDate."' and '".$endDate."' and indicator_id=15 group by sex";
$result22 = databaseSelect()->query($query22);

$k=0;
while ($val = $result22->fetch()) {
   $tableau22[$k] = $val;
   $k++;
}
$result22->closeCursor();

$query23="select 'Nouveaux enroles sous ARV' as groupe,case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1 then  patientID else null end) as '<1 an',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then   patientID else null end) as '50 ans et plus',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
from arv_pnls_report
where datetraitemntAntiTb between '".$startDate."' and '".$endDate."' and DateEnrolement between '".$startDate."' and '".$endDate."' and indicator_id=16 group by sex";
$result23 = databaseSelect()->query($query23);

$k=0;
while ($val = $result23->fetch()) {
   $tableau23[$k] = $val;
   $k++;
}
$result23->closeCursor();

$query24="select 'Patients deja sous ARV' as groupe,case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1 then  patientID else null end) as '<1 an',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then   patientID else null end) as '50 ans et plus',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
from arv_pnls_report
where datetraitemntAntiTb between '".$startDate."' and '".$endDate."' and DateEnrolement < '".$startDate."' and indicator_id=16 group by sex";
$result24 = databaseSelect()->query($query24);

$k=0;
while ($val = $result24->fetch()) {
   $tableau24[$k] = $val;
   $k++;
}
$result24->closeCursor();

$query25="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1 then  patientID else null end) as '<1 an',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then   patientID else null end) as '50 ans et plus',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
from arv_pnls_report
where endDate between '".$startDate."' and '".$endDate."' and indicator_id=17 group by sex";
$result25 = databaseSelect()->query($query25);

$k=0;
while ($val = $result25->fetch()) {
   $tableau25[$k] = $val;
   $k++;
}
$result25->closeCursor();

$query26="select count(distinct case when risk ='HARSAH' then patientID end) 'HARSAH', count(distinct case when risk ='Professionnels de sexe' then patientID end) 'Professionnels de sexe', count(distinct case when risk ='Personnes transgenres' then patientID end) 'Personnes transgenres', count(distinct case when risk ='Prisonniers' then patientID end) 'Prisonniers', count(distinct case when risk ='Utilisateurs de drogues injectables' then patientID end) 'Utilisateurs de drogues injectables' from arv_pnls_report
where endDate between '".$startDate."' and '".$endDate."' and indicator_id=18";
$result26 = databaseSelect()->query($query26);

$k=0;
while ($val = $result26->fetch()) {
   $tableau26[$k] = $val;
   $k++;
}
$result26->closeCursor();

$query27="select dispensationIntervalle, case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 15 then  patientID else null end) as '<15 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >=15 then   patientID else null end) as '>=15 ans',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
from arv_pnls_report
where (dispd between '".$startDate."' and '".$endDate."') and indicator_id=19 group by dispensationIntervalle,sex";

$result27 = databaseSelect()->query($query27);

$k=0;
while ($val = $result27->fetch()) {
   $tableau27[$k] = $val;
   $k++;
}$result27->closeCursor();


/*Nombre de patients décédés CONFIRMES parmi les perdus de vue recherchés au cours du mois du rapport16.1. Nombre de patients décédés CONFIRMES parmi les perdus de vue recherchés au cours du mois du rapport*/

$query41="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when (TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1)
AND ((TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'2018-02-28') >= 0)) then  patientID else null end) as '<1 an',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then patientID else null end) as '50 ans et plus',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
from arv_pnls_report
where (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=41 group by sex";
$result41 = databaseSelect()->query($query41);

$k=0;
while ($val = $result41->fetch()) {
   $tableau41[$k] = $val;
   $k++;
}$result41->closeCursor();

/*16.2. Nombre de patients perdus de vue après un traitement de moins de 3 mois sous ARV*/
$query42="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when (TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1)
AND ((TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'2018-02-28') >= 0)) then  patientID else null end) as '<1 an',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then patientID else null end) as '50 ans et plus',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
from arv_pnls_report
where (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=42 group by sex";
$result42 = databaseSelect()->query($query42);

$k=0;
while ($val = $result42->fetch()) {
   $tableau42[$k] = $val;
   $k++;
}$result42->closeCursor();

/*Nombre de patients perdus de vue après un traitement de plus de 3 mois sous ARV */
$query43="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when (TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1)
AND ((TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'2018-02-28') >= 0)) then  patientID else null end) as '<1 an',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then patientID else null end) as '50 ans et plus',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
from arv_pnls_report
where (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=43 group by sex";
$result43 = databaseSelect()->query($query43);

$k=0;
while ($val = $result43->fetch()) {
   $tableau43[$k] = $val;
   $k++;
}$result43->closeCursor();

/*16.4. Nombre de patients perdus de vue transférés CONFIRMES*/

$query44="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when (TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1)
AND ((TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'2018-02-28') >= 0)) then  patientID else null end) as '<1 an',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then patientID else null end) as '50 ans et plus',
count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
from arv_pnls_report
where (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=44 group by sex";
$result44 = databaseSelect()->query($query44);

$k=0;
while ($val = $result44->fetch()) {
   $tableau44[$k] = $val;
   $k++;
}$result44->closeCursor();

/*16.5. Nombre de patients perdus de vue contactés et confirmés avoir arreté le traitement ARV*/
	$query45="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
	count(distinct case when (TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1)
	AND ((TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'2018-02-28') >= 0)) then  patientID else null end) as '<1 an',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then patientID else null end) as '50 ans et plus',
	count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
	from arv_pnls_report
	where (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=45 group by sex";
	$result45 = databaseSelect()->query($query45);

	$k=0;
	while ($val = $result45->fetch()) {
	   $tableau45[$k] = $val;
	   $k++;
	}$result45->closeCursor();
	
	/*16.1.1 Nombre de décès CONFIRMES lies a la Tuberculose parmi les 
perdus de vue recherches au cours du mois du rapport*/
	$query46="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
	count(distinct case when (TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1)
	AND ((TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'2018-02-28') >= 0)) then  patientID else null end) as '<1 an',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then patientID else null end) as '50 ans et plus',
	count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
	from arv_pnls_report
	where (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=46 group by sex";
	$result46 = databaseSelect()->query($query46);

	$k=0;
	while ($val = $result46->fetch()) {
	   $tableau46[$k] = $val;
	   $k++;
	}$result46->closeCursor();
	
	/*16.1.2 Nombre de décès CONFIRMES lies a d'autres maladies infectieuses et parasitaires  
	parmi les perdus de vue recherches au cours du mois du rapport*/
	$query47="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
	count(distinct case when (TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1)
	AND ((TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'2018-02-28') >= 0)) then  patientID else null end) as '<1 an',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then patientID else null end) as '50 ans et plus',
	count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
	from arv_pnls_report
	where (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=47 group by sex";
	$result47 = databaseSelect()->query($query47);

	$k=0;
	while ($val = $result47->fetch()) {
	   $tableau47[$k] = $val;
	   $k++;
	}$result47->closeCursor();
	
/*16.1.3 Nombre de décès CONFIRMES dus a des causes de cancer connu 
ou présumé parmi les perdus de vue recherches au cours du mois*/	
	$query48="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
	count(distinct case when (TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1)
	AND ((TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'2018-02-28') >= 0)) then  patientID else null end) as '<1 an',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then patientID else null end) as '50 ans et plus',
	count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
	from arv_pnls_report
	where (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=48 group by sex";
	$result48 = databaseSelect()->query($query48);

	$k=0;
	while ($val = $result48->fetch()) {
	   $tableau48[$k] = $val;
	   $k++;
	}$result48->closeCursor();
	/*16.1.4 Nombre de décès CONFIRMES dus a d'autres maladies liees au VIH  
parmi les perdus de vue recherches*/
	$query49="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
	count(distinct case when (TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1)
	AND ((TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'2018-02-28') >= 0)) then  patientID else null end) as '<1 an',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then patientID else null end) as '50 ans et plus',
	count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
	from arv_pnls_report
	where (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=49 group by sex";
	$result49 = databaseSelect()->query($query49);

	$k=0;
	while ($val = $result49->fetch()) {
	   $tableau49[$k] = $val;
	   $k++;
	}$result49->closeCursor();
	
	/*16.1.5 Nombre de décès  parmi les perdus de vue lies a des causes naturelles 
( cancers et infections, qui n'étaient pas directement liées à l'infection à VIH).*/
	$query50="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
	count(distinct case when (TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1)
	AND ((TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'2018-02-28') >= 0)) then  patientID else null end) as '<1 an',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then patientID else null end) as '50 ans et plus',
	count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
	from arv_pnls_report
	where (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=50 group by sex";
	$result50 = databaseSelect()->query($query50);

	$k=0;
	while ($val = $result50->fetch()) {
	   $tableau50[$k] = $val;
	   $k++;
	}$result50->closeCursor();

/*16.1.6 Nombre de décès  parmi les perdus de vue lies a des causes non naturelles 
( traumatisme, accident, suicide, guerre, etc.)*/

$query51="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
	count(distinct case when (TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1)
	AND ((TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'2018-02-28') >= 0)) then  patientID else null end) as '<1 an',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then patientID else null end) as '50 ans et plus',
	count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
	from arv_pnls_report
	where (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=51 group by sex";
	$result51 = databaseSelect()->query($query51);

	$k=0;
	while ($val = $result51->fetch()) {
	   $tableau51[$k] = $val;
	   $k++;
	}$result51->closeCursor();

/*16.1.7 Nombre de décès  parmi les perdus de vue lies a des causes inconnues*/
	$query52="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
	count(distinct case when (TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1)
	AND ((TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'2018-02-28') >= 0)) then  patientID else null end) as '<1 an',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then patientID else null end) as '50 ans et plus',
	count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
	from arv_pnls_report
	where (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=52 group by sex";
	$result52 = databaseSelect()->query($query52);

	$k=0;
	while ($val = $result52->fetch()) {
	   $tableau52[$k] = $val;
	   $k++;
	}$result52->closeCursor();
	
	/*17. Nombre de patients perdus de vue ayant repris le traitement ARV au cours du mois (TX-RTT)*/
	$query53="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
	count(distinct case when (TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1)
	AND ((TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'2018-02-28') >= 0)) then  patientID else null end) as '<1 an',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then patientID else null end) as '50 ans et plus',
	count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
	from arv_pnls_report
	where (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=53 group by sex";
	$result53 = databaseSelect()->query($query53);

	$k=0;
	while ($val = $result53->fetch()) {
	   $tableau53[$k] = $val;
	   $k++;
	}$result53->closeCursor();
	
	/*17.1 Nombre de populations clés perdus de vue ayant repris le traitement ARV au cours du mois*/
	
	$query54="select 
	count(distinct (case when indicator_id = 54 AND risk ='163593' then patientID end)) 'HARSAH', 
	count(distinct (case when indicator_id = 54 AND risk ='163594' then patientID end)) 'Professionnels de sexe', 
	count(distinct (case when indicator_id = 54 AND risk ='163596' then patientID end)) 'Personnes transgenres', 
	count(distinct (case when indicator_id = 54 AND risk ='163595' then patientID end)) 'Prisonniers', 
	count(distinct (case when indicator_id = 54 AND risk ='163597' then patientID end)) 'Utilisateurs de drogues injectables' 
	from arv_pnls_report
	where (dateVisite between '".$startDate."' and '".$endDate."') 
	and indicator_id = 54 AND risk IN ('163593','163594','163595','163596','163597')";
	$result54 = databaseSelect()->query($query54);

	$k=0;
	while ($val = $result54->fetch()) {
	   $tableau54[$k] = $val;
	   $k++;
	}
	$result54->closeCursor();
	/*18.1 Nombre de patients actifs sous ARV ayant au moins un resultat 
	de charge virale au cours des 12 derniers mois: (TX_PVLS D routine)*/
	$query55="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
	count(distinct case when (TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1)
	AND ((TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'2018-02-28') >= 0)) then  patientID else null end) as '<1 an',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then patientID else null end) as '50 ans et plus',
	count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
	from arv_pnls_report
	where (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=55 group by sex";
	$result55 = databaseSelect()->query($query55);

	$k=0;
	while ($val = $result55->fetch()) {
	   $tableau55[$k] = $val;
	   $k++;
	}$result55->closeCursor();
	
	/*18.1.1 Nombre de femmes enceintes actives sous ARV ayant au moins un 
	resultat de charge virale au cours des 12 derniers mois*/
	$query56="select 
	count(distinct patientID) AS nbEnceinte from arv_pnls_report
	where (dateVisite between '".$startDate."' and '".$endDate."') 
	AND ((DebutGrossesse between '".$startDate."' and '".$endDate."') 
	OR (endDate between '".$startDate."' and '".$endDate."'))
	and indicator_id = 56";
	$result56 = databaseSelect()->query($query56);

	$k=0;
	while ($val = $result56->fetch()) {
	   $tableau56[$k] = $val;
	   $k++;
	}
	$result56->closeCursor();
	
	/*18.1.2 Nombre de femmes allaitantes actives sous ARV 
ayant au moins un resultat de charge virale au cours des 12 derniers mois*/
	$query57="select 
	count(distinct patientID) AS nbAllaitante from arv_pnls_report
	where (dateVisite between '".$startDate."' and '".$endDate."') 
	AND ((DebutAllaitement between '".$startDate."' and '".$endDate."') 
	OR (endDate between '".$startDate."' and '".$endDate."'))
	and indicator_id = 57";
	$result57 = databaseSelect()->query($query57);

	$k=0;
	while ($val = $result57->fetch()) {
	   $tableau57[$k] = $val;
	   $k++;
	}
	$result57->closeCursor();
	
/*18.1.3 Nombre de populations clés actives sous ARV 
ayant au moins un resultat de charge virale au cours des 12 derniers mois*/	
	$query58="select 
	count(distinct (case when indicator_id = 58 AND risk ='163593' then patientID end)) 'HARSAH', 
	count(distinct (case when indicator_id = 58 AND risk ='163594' then patientID end)) 'Professionnels de sexe', 
	count(distinct (case when indicator_id = 58 AND risk ='163596' then patientID end)) 'Personnes transgenres', 
	count(distinct (case when indicator_id = 58 AND risk ='163595' then patientID end)) 'Prisonniers', 
	count(distinct (case when indicator_id = 58 AND risk ='163597' then patientID end)) 'Utilisateurs de drogues injectables' 
	from arv_pnls_report
	where (dateVisite between '".$startDate."' and '".$endDate."') 
	and indicator_id = 58 AND risk IN ('163593','163594','163595','163596','163597')";
	$result58 = databaseSelect()->query($query58);

	$k=0;
	while ($val = $result58->fetch()) {
	   $tableau58[$k] = $val;
	   $k++;
	}
	$result58->closeCursor();
	/*18.2 Nombre de patients actifs sous ARV dont le dernier résultat de Charge virale au cours 
des 12 derniers mois  est inférieur à 1000 copies/ml (TX_PVLS N routine)*/
	$query59="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
	count(distinct case when (TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 1)
	AND ((TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'2018-02-28') >= 0)) then  patientID else null end) as '<1 an',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 1 and 4 then   patientID else null end) as '1-4 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 5 and 9 then   patientID else null end) as '5-9 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 10 and 14 then   patientID else null end) as '10-14 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 15 and 19 then   patientID else null end) as '15-19 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 20 and 24 then   patientID else null end) as '20-24 ans',
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 25 and 29 then   patientID else null end) as '25-29 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 30 and 34 then   patientID else null end) as '30-34 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 35 and 39 then   patientID else null end) as '35-39 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 40 and 44 then   patientID else null end) as '40-44 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') between 45 and 49 then   patientID else null end) as '45-49 ans', 
	count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then patientID else null end) as '50 ans et plus',
	count(distinct case when (dobYy IS NULL OR dobYy = '') then patientID else null end) as 'âge inconnu'
	from arv_pnls_report
	where (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=59 group by sex";
	$result59 = databaseSelect()->query($query59);

	$k=0;
	while ($val = $result59->fetch()) {
	   $tableau59[$k] = $val;
	   $k++;
	}$result59->closeCursor();
	
	/*18.2.1 Nombre de femmes enceintes actives sous ARV dont 
le dernier résultat de Charge virale au cours des 12 derniers mois  est inférieur à 1000 copies/ml
 */
 $query60="select 
	count(distinct patientID) AS nbEnceinte from arv_pnls_report
	where (dateVisite between '".$startDate."' and '".$endDate."')
	AND ((DebutGrossesse between '".$startDate."' and '".$endDate."') 
	OR (endDate between '".$startDate."' and '".$endDate."'))
	and indicator_id = 60";
	$result60 = databaseSelect()->query($query60);

	$k=0;
	while ($val = $result60->fetch()) {
	   $tableau60[$k] = $val;
	   $k++;
	}
	$result56->closeCursor();
 /*18.2.2 Nombre de femmes allaitantes actives sous ARV dont le dernier résultat de 
Charge virale au cours des 12 derniers mois  est inférieur à 1000 copies/ml */
	$query61="select 
	count(distinct patientID) AS nbAllaitante from arv_pnls_report
	where (dateVisite between '".$startDate."' and '".$endDate."')
	AND ((DebutAllaitement between '".$startDate."' and '".$endDate."') 
	OR (endDate between '".$startDate."' and '".$endDate."'))
	and indicator_id = 61";
	$result61 = databaseSelect()->query($query61);

	$k=0;
	while ($val = $result61->fetch()) {
	   $tableau61[$k] = $val;
	   $k++;
	}
	$result61->closeCursor();
/*18.2.3 Nombre de populations clés actives sous ARV dont le dernier résultat de 
	Charge virale au cours des 12 derniers mois  est inférieur à 1000 copies/ml*/
	$query62="select 
	count(distinct (case when indicator_id = 62 AND risk ='163593' then patientID end)) 'HARSAH', 
	count(distinct (case when indicator_id = 62 AND risk ='163594' then patientID end)) 'Professionnels de sexe', 
	count(distinct (case when indicator_id = 62 AND risk ='163596' then patientID end)) 'Personnes transgenres', 
	count(distinct (case when indicator_id = 62 AND risk ='163595' then patientID end)) 'Prisonniers', 
	count(distinct (case when indicator_id = 62 AND risk ='163597' then patientID end)) 'Utilisateurs de drogues injectables' 
	from arv_pnls_report
	where (dateVisite between '".$startDate."' and '".$endDate."') 
	and indicator_id = 62 AND risk IN ('163593','163594','163595','163596','163597')";
	$result62 = databaseSelect()->query($query62);

	$k=0;
	while ($val = $result62->fetch()) {
	   $tableau62[$k] = $val;
	   $k++;
	}
	$result62->closeCursor();

?> 

<style type="text/css">

  input[type="submit"] { padding:3px; border:1px solid #F5C5C5; border-radius:2px; width:142px;
}

#keywords {
  margin: 0 auto;
  font-size: 1.2em;
}
table { 
  border-collapse: collapse; border-spacing: 0; width:100%; 
}
#keywords thead {
  cursor: pointer;
  background: #c9dff0;
}
label {
	padding-right:50px;
}

#keywords thead tr th { 
  font-weight: bold;
  padding: 5px 5px;
  padding-left: 42px;
}
#keywords thead tr th span { 
  padding-right: 20px;
  background-repeat: no-repeat;
  background-position: 100% 100%;
}

#keywords thead tr th.headerSortUp, #keywords thead tr th.headerSortDown {
  background: #acc8dd;
}

#keywords tbody tr { 
  color: #555;
}
#keywords tbody tr td {
  text-align: center;
  padding-right: 20px;
}
#keywords tbody tr td.lalign {
  text-align: left;
}

table.gridtable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}
table.gridtable th {
	border-width: 1px;
	padding: 5px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 5px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}

table.gridtable caption {
	border-width: 1px;
	padding: 5px;
	border-style: solid;
	border-color: #666666;
	background-color: #b8b8b8;
	font-weight: bold;
}

</style>
<script language="javascript">
        function printdiv(printpage) {
            var headstr = "<html><head><title></title></head><body>";
            var footstr = "</body>";
            var newstr = document.all.item(printpage).innerHTML;
            var oldstr = document.body.innerHTML;
            document.body.innerHTML = headstr + newstr + footstr;
            window.print();
            document.body.innerHTML = oldstr;
            return false;
        }
    </script>
	
<script type="text/javascript">
var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
</script>

</head>

<body text="#000000" link="#000000" alink="#000000" vlink="#000000" align="left"> 

<? include ("bannerbody.php"); ?>
	
<div style="border-left: 1px solid #99BBE8;">

<table id="keywords">
   <thead>
       <tr><th> Rapport mensuel des soins cliniques VIH-ARV </th></tr>
    </thead>

    <form id="form" name="form" method="post" action="" >
     <tr><td>     
		<div style="display:inline-block; padding-bottom:5px; float:left;">
		<label id="vitalTempTitle" style="width:50px">Date de debut</label>
		   <input id="startDate" name="startDate"  type="date"  value="<?php echo $startDate; ?>"> 
		 </div>
	</td></tr>  
    <tr><td>	 
		 <div style="display:inline-block; padding-bottom:5px; float:left;">
		<label id="vitalTempTitle" style="width:50px">Date de fin</label>
		   <input id="endDate" name="endDate"  type="date"  value="<?php echo $endDate; ?>"> 
		 </div>
	  </div>
	</td></tr>  
    <tr><td>	  
	<div class="" style="padding:15px; float:left;">
       <button type="submit" class="" >Submit</button>
       <button class="">Cancel</button>
    </div>
	</td></tr> 
	
   </form>
   
       <thead>
        <tr><th>Periode : <?php echo $startDate; ?> - <?php echo $endDate; ?> </th></tr>
    </thead>
   
 </table>

</div>	
  
  <?php ?>
  
  <div style="float:left; padding:15px; margin-right:35px; width:90%;">
 <input name="b_print" type="button"  onClick="printdiv('print_section');" value=" Imprimer ">
 <button onclick="tableToExcel('excelTable', 'Rapport mensuel des soins cliniques VIH-ARV')">Exporter dans EXCEL</button>
 </div>
  
  
<div id="print_section" style="width:90%; padding:15px; vertical-align:top;border-left: 1px solid #99BBE8;">
		 
		   <?php 
		   
if ($NbreData != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Nombre de personnes VIH+ nouvellement enrolees sous ARV au cours du mois</caption>
<thead><tr>
            <th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total_0=0;
			$total_1=0;
			$total_2=0;
			$total_3=0;
			$total_4=0;
			$total_5=0;
			$total_6=0;
			$total_7=0;
			$total_8=0;
			$total_9=0;
			$total_10=0;
			$total_11=0;
			$total_12=0;
   
   for ($i=0; $i<count($tableau); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau[$k]['sex'];
		   echo '</td><td>';
		   echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=1&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau[$k]['sex_id']."& interval=<1 an\">".$tableau[$k]['<1 an']."</a>";
		 $total_0=$total_0+$tableau[$k]['<1 an'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=1&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau[$k]['sex_id']."& interval=1-4 ans\">".$tableau[$k]['1-4 ans']."</a>";
		  $total_1=$total_1+$tableau[$k]['1-4 ans'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=1&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau[$k]['sex_id']."& interval=5-9 ans\">".$tableau[$k]['5-9 ans']."</a>";
		  $total_2=$total_2+$tableau[$k]['5-9 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=1&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau[$k]['sex_id']."& interval=10-14 ans\">".$tableau[$k]['10-14 ans']."</a>";
		  $total_3=$total_3+$tableau[$k]['10-14 ans'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=1&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau[$k]['sex_id']."& interval=15-19 ans\">".$tableau[$k]['15-19 ans']."</a>";
		  $total_4=$total_4+$tableau[$k]['15-19 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=1&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau[$k]['sex_id']."& interval=20-24 ans\">".$tableau[$k]['20-24 ans']."</a>";
		  $total_5=$total_5+$tableau[$k]['20-24 ans'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=1&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau[$k]['sex_id']."& interval=25-29 ans\">".$tableau[$k]['25-29 ans']."</a>";
		  $total_6=$total_6+$tableau[$k]['25-29 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=1&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau[$k]['sex_id']."& interval=30-34 ans\">".$tableau[$k]['30-34 ans']."</a>";
		  $total_7=$total_7+$tableau[$k]['30-34 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=1&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau[$k]['sex_id']."& interval=35-39 ans\">".$tableau[$k]['35-39 ans']."</a>";
		  $total_8=$total_8+$tableau[$k]['35-39 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=1&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau[$k]['sex_id']."& interval=40-44 ans\">".$tableau[$k]['40-44 ans']."</a>";
		  $total_9=$total_9+$tableau[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=1&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau[$k]['sex_id']."& interval=45-49 ans\">".$tableau[$k]['45-49 ans']."</a>";
		  $total_10=$total_10+$tableau[$k]['45-49 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=1&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau[$k]['sex_id']."& interval=50 ans et plus\">".$tableau[$k]['50 ans et plus']."</a>";
		  $total_11=$total_11+$tableau[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=1&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau[$k]['sex_id']."& interval=inconnu\">".$tableau[$k]['âge inconnu']."</a>";
		  $total_12=$total_12+$tableau[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
            <td>Total</td>
			<td>'.$total_0.'</td>
			<td>'.$total_1.'</td>
			<td>'.$total_2.'</td>
			<td>'.$total_3.'</td>
			<td>'.$total_4.'</td>
			<td>'.$total_5.'</td>
			<td>'.$total_6.'</td>
			<td>'.$total_7.'</td>
			<td>'.$total_8.'</td>
			<td>'.$total_9.'</td>
			<td>'.$total_10.'</td>
			<td>'.$total_11.'</td>
			<td>'.$total_12.'</td>
			</tr>';
echo '</table>';
}

echo '<div>&nbsp;</div>';

if ($NbreData2 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table   class="gridtable" border="1">
<caption>Nouvelles femmes allaitantes enrolees sous ARV</caption>
<thead><tr>
            <th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total2_0=0;
			$total2_1=0;
			$total2_2=0;
			$total2_3=0;
			$total2_4=0;
			$total2_5=0;
			$total2_6=0;
			$total2_7=0;
			$total2_8=0;
			$total2_9=0;
			$total2_10=0;
			$total2_11=0;
			$total2_12=0;// $NbrLigne
   
   for ($i=0; $i<count($tableau2); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData2) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau2[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=2&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau2[$k]['sex_id']."& interval=<1 an\">".$tableau2[$k]['<1 an']."</a>";
		 $total2_0=$total2_0+$tableau2[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=2&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau2[$k]['sex_id']."& interval=1-4 ans\">".$tableau2[$k]['1-4 ans']."</a>";
		  $total2_1=$total2_1+$tableau2[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=2&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau2[$k]['sex_id']."& interval=5-9 ans\">".$tableau2[$k]['5-9 ans']."</a>";
		  $total2_2=$total2_2+$tableau2[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=2&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau2[$k]['sex_id']."& interval=10-14 ans\">".$tableau2[$k]['10-14 ans']."</a>";
		  $total2_3=$total2_3+$tableau2[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=2&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau2[$k]['sex_id']."& interval=15-19 ans\">".$tableau2[$k]['15-19 ans']."</a>";
		  $total2_4=$total2_4+$tableau2[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=2&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau2[$k]['sex_id']."& interval=20-24 ans\">".$tableau2[$k]['20-24 ans']."</a>";
		  $total2_5=$total2_5+$tableau2[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=2&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau2[$k]['sex_id']."& interval=25-29 ans\">".$tableau2[$k]['25-29 ans']."</a>";
		  $total2_6=$total2_6+$tableau2[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=2&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau2[$k]['sex_id']."& interval=30-34 ans\">".$tableau2[$k]['30-34 ans']."</a>";
		  $total2_7=$total2_7+$tableau2[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=2&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau2[$k]['sex_id']."& interval=35-39 ans\">".$tableau2[$k]['35-39 ans']."</a>";
		  $total2_8=$total2_8+$tableau2[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=2&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau2[$k]['sex_id']."& interval=40-44 ans\">".$tableau2[$k]['40-44 ans']."</a>";
		  $total2_9=$total2_9+$tableau2[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=2&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau2[$k]['sex_id']."& interval=45-49 ans\">".$tableau2[$k]['45-49 ans']."</a>";
		  $total2_10=$total2_10+$tableau2[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=2&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau2[$k]['sex_id']."& interval=50 ans et plus\">".$tableau2[$k]['50 ans et plus']."</a>";
		  $total2_11=$total2_11+$tableau2[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=2&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau2[$k]['sex_id']."& interval=inconnu\">".$tableau2[$k]['âge inconnu']."</a>";
		  $total2_12=$total2_12+$tableau2[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
            <td>Total</td>
			<td>'.$total2_0.'</td>
			<td>'.$total2_1.'</td>
			<td>'.$total2_2.'</td>
			<td>'.$total2_3.'</td>
			<td>'.$total2_4.'</td>
			<td>'.$total2_5.'</td>
			<td>'.$total2_6.'</td>
			<td>'.$total2_7.'</td>
			<td>'.$total2_8.'</td>
			<td>'.$total2_9.'</td>
			<td>'.$total2_10.'</td>
			<td>'.$total2_11.'</td>
			<td>'.$total2_12.'</td>
			</tr>';
echo '</table>';
} 

echo '<div>&nbsp;</div>';

if ($NbreData3 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table  class="gridtable" border="1">
<caption>Nombre de personnes VIH+ prealablement enrolees sous ARV dans un autre site et referees au cours du mois</caption>
<thead><tr>
            <th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total3_0=0;
			$total3_1=0;
			$total3_2=0;
			$total3_3=0;
			$total3_4=0;
			$total3_5=0;
			$total3_6=0;
			$total3_7=0;
			$total3_8=0;
			$total3_9=0;
			$total3_10=0;
			$total3_11=0;
			$total3_12=0;
   
   for ($i=0; $i<count($tableau3); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData3) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau3[$k]['sex'];
		   echo '</td><td>'; 
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=3&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau3[$k]['sex_id']."& interval=<1 an\">".$tableau3[$k]['<1 an']."</a>";
		 $total3_0=$total3_0+$tableau3[$k]['<1 an'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=3&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau3[$k]['sex_id']."& interval=1-4 ans\">".$tableau3[$k]['1-4 ans']."</a>";
		  $total3_1=$total3_1+$tableau3[$k]['1-4 ans'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=3&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau3[$k]['sex_id']."& interval=5-9 ans\">".$tableau3[$k]['5-9 ans']."</a>";
		  $total3_2=$total3_2+$tableau3[$k]['5-9 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=3&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau3[$k]['sex_id']."& interval=10-14 ans\">".$tableau3[$k]['10-14 ans']."</a>";
		  $total3_3=$total3_3+$tableau3[$k]['10-14 ans'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=3&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau3[$k]['sex_id']."& interval=15-19 ans\">".$tableau3[$k]['15-19 ans']."</a>";
		  $total3_4=$total3_4+$tableau3[$k]['15-19 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=3&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau3[$k]['sex_id']."& interval=20-24 ans\">".$tableau3[$k]['20-24 ans']."</a>";
		  $total3_5=$total3_5+$tableau3[$k]['20-24 ans'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=3&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau3[$k]['sex_id']."& interval=25-29 ans\">".$tableau3[$k]['25-29 ans']."</a>";
		  $total3_6=$total3_6+$tableau3[$k]['25-29 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=3&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau3[$k]['sex_id']."& interval=30-34 ans\">".$tableau3[$k]['30-34 ans']."</a>";
		  $total3_7=$total3_7+$tableau3[$k]['30-34 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=3&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau3[$k]['sex_id']."& interval=35-39 ans\">".$tableau3[$k]['35-39 ans']."</a>";
		  $total3_8=$total3_8+$tableau3[$k]['35-39 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=3&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau3[$k]['sex_id']."& interval=40-44 ans\">".$tableau3[$k]['40-44 ans']."</a>";
		  $total3_9=$total3_9+$tableau3[$k]['40-44 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=3&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau3[$k]['sex_id']."& interval=45-49 ans\">".$tableau3[$k]['45-49 ans']."</a>";
		  $total3_10=$total3_10+$tableau3[$k]['45-49 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=3&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau3[$k]['sex_id']."& interval=50 ans et plus\">".$tableau3[$k]['50 ans et plus']."</a>";
		  $total3_11=$total3_11+$tableau3[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=3&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau3[$k]['sex_id']."& interval=inconnu\">".$tableau3[$k]['âge inconnu']."</a>";
		  $total3_12=$total3_12+$tableau3[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
            <td>Total</td>
			<td>'.$total3_0.'</td>
			<td>'.$total3_1.'</td>
			<td>'.$total3_2.'</td>
			<td>'.$total3_3.'</td>
			<td>'.$total3_4.'</td>
			<td>'.$total3_5.'</td>
			<td>'.$total3_6.'</td>
			<td>'.$total3_7.'</td>
			<td>'.$total3_8.'</td>
			<td>'.$total3_9.'</td>
			<td>'.$total3_10.'</td>
			<td>'.$total3_11.'</td>
			<td>'.$total3_12.'</td>
			</tr>';
echo '</table>';
} 

echo '<div>&nbsp;</div>';

if ($NbreData4 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Nouvelles femmes allaitantes prealablement enrolees sous ARV et referees au cours du mois</caption>
<thead><tr>
            <th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total4_0=0;
			$total4_1=0;
			$total4_2=0;
			$total4_3=0;
			$total4_4=0;
			$total4_5=0;
			$total4_6=0;
			$total4_7=0;
			$total4_8=0;
			$total4_9=0;
			$total4_10=0;
			$total4_11=0;
			$total4_12=0;
   
   for ($i=0; $i<count($tableau4); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData4) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau4[$k]['sex'];
		   echo '</td><td>';
         echo $tableau4[$k]['<1 an']; 
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=4&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau4[$k]['sex_id']."& interval=<1 an\">".$tableau4[$k]['<1 an']."</a>";
		 $total4_0=$total4_0+$tableau4[$k]['<1 an'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=4&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau4[$k]['sex_id']."& interval=1-4 ans\">".$tableau4[$k]['1-4 ans']."</a>";
		  $total4_1=$total4_1+$tableau4[$k]['1-4 ans'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=4&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau4[$k]['sex_id']."& interval=5-9 ans\">".$tableau4[$k]['5-9 ans']."</a>";
		  $total4_2=$total4_2+$tableau4[$k]['5-9 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=4&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau4[$k]['sex_id']."& interval=10-14 ans\">".$tableau4[$k]['10-14 ans']."</a>";
		  $total4_3=$total4_3+$tableau4[$k]['10-14 ans'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=4&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau4[$k]['sex_id']."& interval=15-19 ans\">".$tableau4[$k]['15-19 ans']."</a>";
		  $total4_4=$total4_4+$tableau4[$k]['15-19 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=4&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau4[$k]['sex_id']."& interval=20-24 ans\">".$tableau4[$k]['20-24 ans']."</a>";
		  $total4_5=$total4_5+$tableau4[$k]['20-24 ans'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=4&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau4[$k]['sex_id']."& interval=25-29 ans\">".$tableau4[$k]['25-29 ans']."</a>";
		  $total4_6=$total4_6+$tableau4[$k]['25-29 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=4&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau4[$k]['sex_id']."& interval=30-34 ans\">".$tableau4[$k]['30-34 ans']."</a>";
		  $total4_7=$total4_7+$tableau4[$k]['30-34 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=4&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau4[$k]['sex_id']."& interval=35-39 ans\">".$tableau4[$k]['35-39 ans']."</a>";
		  $total4_8=$total4_8+$tableau4[$k]['35-39 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=4&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau4[$k]['sex_id']."& interval=40-44 ans\">".$tableau4[$k]['40-44 ans']."</a>";
		  $total4_9=$total4_9+$tableau4[$k]['40-44 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=4&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau4[$k]['sex_id']."& interval=45-49 ans\">".$tableau4[$k]['45-49 ans']."</a>";
		  $total4_10=$total4_10+$tableau4[$k]['45-49 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=4&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau4[$k]['sex_id']."& interval=50 ans et plus\">".$tableau4[$k]['50 ans et plus']."</a>";
		  $total4_11=$total4_11+$tableau4[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=4&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau4[$k]['sex_id']."& interval=inconnu\">".$tableau4[$k]['âge inconnu']."</a>";
		  $total4_12=$total4_12+$tableau4[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
            <td>Total</td>
			<td>'.$total4_0.'</td>
			<td>'.$total4_1.'</td>
			<td>'.$total4_2.'</td>
			<td>'.$total4_3.'</td>
			<td>'.$total4_4.'</td>
			<td>'.$total4_5.'</td>
			<td>'.$total4_6.'</td>
			<td>'.$total4_7.'</td>
			<td>'.$total4_8.'</td>
			<td>'.$total4_9.'</td>
			<td>'.$total4_10.'</td>
			<td>'.$total4_11.'</td>
			<td>'.$total4_12.'</td>
			</tr>';
echo '</table>';
} 

echo '<div>&nbsp;</div>';

if ($NbreData5 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Enrolement et reference des personnes des populations cles</caption>
<thead><tr>
            <th></th>
			<th>HARSAH</th>
			<th>Professionnels de sexe</th>
			<th>Personnes transgenres</th>
			<th>Prisonniers</th>
			<th>Utilisateurs de drogues injectables</th>
			</tr></thead>';
			
			$total5_0=0;
			$total5_1=0;
			$total5_2=0;
			$total5_3=0;
			$total5_4=0;
   
   for ($i=0; $i<count($tableau5); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData5) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau5[$k]['groupe'];
		   echo '</td><td>';
		   if($tableau5[$k]['indicator_id']=='5') echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=5&cle=HARSAH&startDate=".$startDate."&endDate=".$endDate."&sex=& interval=\">".$tableau5[$k]['HARSAH']."</a>";
		   if($tableau5[$k]['indicator_id']=='6') echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=6&cle=HARSAH&startDate=".$startDate."&endDate=".$endDate."&sex=& interval=\">".$tableau5[$k]['HARSAH']."</a>"; 
		 
		 $total5_0=$total5_0+$tableau5[$k]['HARSAH'];
         echo '</td><td>';
		 if($tableau5[$k]['indicator_id']=='5') echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=5&cle=Professionnels de sexe&startDate=".$startDate."&endDate=".$endDate."&sex=& interval=\">".$tableau5[$k]['Professionnels de sexe']."</a>";
		 if($tableau5[$k]['indicator_id']=='6') echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=6&cle=Professionnels de sexe&startDate=".$startDate."&endDate=".$endDate."&sex=& interval=\">".$tableau5[$k]['Professionnels de sexe']."</a>";

		  $total5_1=$total5_1+$tableau5[$k]['Professionnels de sexe'];
		 echo '</td><td>';
		 if($tableau5[$k]['indicator_id']=='5') echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=5&cle=Personnes transgenres&startDate=".$startDate."&endDate=".$endDate."&sex=& interval=\">".$tableau5[$k]['Personnes transgenres']."</a>";
		 if($tableau5[$k]['indicator_id']=='6') echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=6&cle=Personnes transgenres&startDate=".$startDate."&endDate=".$endDate."&sex=& interval=\">".$tableau5[$k]['Personnes transgenres']."</a>";

		  $total5_2=$total5_2+$tableau5[$k]['Personnes transgenres'];
		  echo '</td><td>';
		if($tableau5[$k]['indicator_id']=='5') echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=5&cle=Prisonniers&startDate=".$startDate."&endDate=".$endDate."&sex=& interval=\">".$tableau5[$k]['Prisonniers']."</a>";
		if($tableau5[$k]['indicator_id']=='6') echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=6&cle=Prisonniers&startDate=".$startDate."&endDate=".$endDate."&sex=& interval=\">".$tableau5[$k]['Prisonniers']."</a>"; 
		 
		  $total5_3=$total5_3+$tableau5[$k]['Prisonniers'];
		   echo '</td><td>';
		 if($tableau5[$k]['indicator_id']=='5') echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=5&cle=Utilisateurs de drogues injectables&startDate=".$startDate."&endDate=".$endDate."&sex=& interval=\">".$tableau5[$k]['Utilisateurs de drogues injectables']."</a>";
		if($tableau5[$k]['indicator_id']=='6') echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=6&cle=Utilisateurs de drogues injectables&startDate=".$startDate."&endDate=".$endDate."&sex=& interval=\">".$tableau5[$k]['Utilisateurs de drogues injectables']."</a>"; 

		  $total5_4=$total5_4+$tableau5[$k]['Utilisateurs de drogues injectables'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
            <td>Total</td>
			<td>'.$total5_0.'</td>
			<td>'.$total5_1.'</td>
			<td>'.$total5_2.'</td>
			<td>'.$total5_3.'</td>
			<td>'.$total5_4.'</td>
			</tr>';
echo '</table>';
} 

echo '<div>&nbsp;</div>';

if ($NbreData6 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Patients VIH+ non encore enroles sous ARV</caption>
<thead><tr>
            <th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total6_0=0;
			$total6_1=0;
			$total6_2=0;
			$total6_3=0;
			$total6_4=0;
			$total6_5=0;
			$total6_6=0;
			$total6_7=0;
			$total6_8=0;
			$total6_9=0;
			$total6_10=0;
			$total6_11=0;
			$total6_12=0;
   
   for ($i=0; $i<count($tableau6); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData6) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau6[$k]['reasonNoEnrolment'];
		   echo '</td><td>';
		  echo $tableau6[$k]['sex'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=6&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau6[$k]['sex_id']."& interval=<1 an\">".$tableau6[$k]['<1 an']."</a>";
		 $total6_0=$total6_0+$tableau6[$k]['<1 an'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=6&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau6[$k]['sex_id']."& interval=1-4 ans\">".$tableau6[$k]['1-4 ans']."</a>";
		  $total6_1=$total6_1+$tableau6[$k]['1-4 ans'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=6&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau6[$k]['sex_id']."& interval=5-9 ans\">".$tableau6[$k]['5-9 ans']."</a>";
		  $total6_2=$total6_2+$tableau6[$k]['5-9 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=6&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau6[$k]['sex_id']."& interval=10-14 ans\">".$tableau6[$k]['10-14 ans']."</a>";
		  $total6_3=$total6_3+$tableau6[$k]['10-14 ans'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=6&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau6[$k]['sex_id']."& interval=15-19 ans\">".$tableau6[$k]['15-19 ans']."</a>";
		  $total6_4=$total6_4+$tableau6[$k]['15-19 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=6&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau6[$k]['sex_id']."& interval=20-24 ans\">".$tableau6[$k]['20-24 ans']."</a>";
		  $total6_5=$total6_5+$tableau6[$k]['20-24 ans'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=6&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau6[$k]['sex_id']."& interval=25-29 ans\">".$tableau6[$k]['25-29 ans']."</a>";
		  $total6_6=$total6_6+$tableau6[$k]['25-29 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=6&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau6[$k]['sex_id']."& interval=30-34 ans\">".$tableau6[$k]['30-34 ans']."</a>";
		  $total6_7=$total6_7+$tableau6[$k]['30-34 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=6&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau6[$k]['sex_id']."& interval=35-39 ans\">".$tableau6[$k]['35-39 ans']."</a>";
		  $total6_8=$total6_8+$tableau6[$k]['35-39 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=6&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau6[$k]['sex_id']."& interval=40-44 ans\">".$tableau6[$k]['40-44 ans']."</a>";
		  $total6_9=$total6_9+$tableau6[$k]['40-44 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=6&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau6[$k]['sex_id']."& interval=45-49 ans\">".$tableau6[$k]['45-49 ans']."</a>";
		  $total6_10=$total6_10+$tableau6[$k]['45-49 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=6&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau6[$k]['sex_id']."& interval=50 ans et plus\">".$tableau6[$k]['50 ans et plus']."</a>";
		  $total6_11=$total6_11+$tableau6[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=6&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau6[$k]['sex_id']."& interval=inconnu\">".$tableau6[$k]['âge inconnu']."</a>";
		  $total6_12=$total6_12+$tableau6[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total6_0.'</td>
			<td>'.$total6_1.'</td>
			<td>'.$total6_2.'</td>
			<td>'.$total6_3.'</td>
			<td>'.$total6_4.'</td>
			<td>'.$total6_5.'</td>
			<td>'.$total6_6.'</td>
			<td>'.$total6_7.'</td>
			<td>'.$total6_8.'</td>
			<td>'.$total6_9.'</td>
			<td>'.$total6_10.'</td>
			<td>'.$total6_11.'</td>
			<td>'.$total6_12.'</td>
			</tr>';
echo '</table>';
} 

echo '<div>&nbsp;</div>';

if ($NbreData7 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Femmes allaitantes VIH+ non encore enrolees sous ARV</caption>
<thead><tr>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total7_0=0;
			$total7_1=0;
			$total7_2=0;
			$total7_3=0;
			$total7_4=0;
			$total7_5=0;
			$total7_6=0;
			$total7_7=0;
			$total7_8=0;
			$total7_9=0;
			$total7_10=0;
			$total7_11=0;
			$total7_12=0;
   
   for ($i=0; $i<count($tableau7); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData7) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau7[$k]['sex'];
		   echo '</td><td>'; 
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=8&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau7[$k]['sex_id']."& interval=<1 an\">".$tableau7[$k]['<1 an']."</a>";
		 $total7_0=$total7_0+$tableau7[$k]['<1 an'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=8&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau7[$k]['sex_id']."& interval=1-4 ans\">".$tableau7[$k]['1-4 ans']."</a>";
		  $total7_1=$total7_1+$tableau7[$k]['1-4 ans'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=8&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau7[$k]['sex_id']."& interval=5-9 ans\">".$tableau7[$k]['5-9 ans']."</a>";
		  $total7_2=$total7_2+$tableau7[$k]['5-9 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=8&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau7[$k]['sex_id']."& interval=10-14 ans\">".$tableau7[$k]['10-14 ans']."</a>";
		  $total7_3=$total7_3+$tableau7[$k]['10-14 ans'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=8&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau7[$k]['sex_id']."& interval=15-19 ans\">".$tableau7[$k]['15-19 ans']."</a>";
		  $total7_4=$total7_4+$tableau7[$k]['15-19 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=8&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau7[$k]['sex_id']."& interval=20-24 ans\">".$tableau7[$k]['20-24 ans']."</a>";
		  $total7_5=$total7_5+$tableau7[$k]['20-24 ans'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=8&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau7[$k]['sex_id']."& interval=25-29 ans\">".$tableau7[$k]['25-29 ans']."</a>";
		  $total7_6=$total7_6+$tableau7[$k]['25-29 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=8&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau7[$k]['sex_id']."& interval=30-34 ans\">".$tableau7[$k]['30-34 ans']."</a>";
		  $total7_7=$total7_7+$tableau7[$k]['30-34 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=8&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau7[$k]['sex_id']."& interval=35-39 ans\">".$tableau7[$k]['35-39 ans']."</a>";
		  $total7_8=$total7_8+$tableau7[$k]['35-39 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=8&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau7[$k]['sex_id']."& interval=40-44 ans\">".$tableau7[$k]['40-44 ans']."</a>";
		  $total7_9=$total7_9+$tableau7[$k]['40-44 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=8&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau7[$k]['sex_id']."& interval=45-49 ans\">".$tableau7[$k]['45-49 ans']."</a>";
		  $total7_10=$total7_10+$tableau7[$k]['45-49 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=8&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau7[$k]['sex_id']."& interval=50 ans et plus\">".$tableau7[$k]['50 ans et plus']."</a>";
		  $total7_11=$total7_11+$tableau7[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=8&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau7[$k]['sex_id']."& interval=inconnu\">".$tableau7[$k]['âge inconnu']."</a>";
		  $total7_12=$total7_12+$tableau7[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td>'.$total7_0.'</td>
			<td>'.$total7_1.'</td>
			<td>'.$total7_2.'</td>
			<td>'.$total7_3.'</td>
			<td>'.$total7_4.'</td>
			<td>'.$total7_5.'</td>
			<td>'.$total7_6.'</td>
			<td>'.$total7_7.'</td>
			<td>'.$total7_8.'</td>
			<td>'.$total7_9.'</td>
			<td>'.$total7_10.'</td>
			<td>'.$total7_11.'</td>
			<td>'.$total7_12.'</td>
			</tr>';
echo '</table>';
}

echo '<div>&nbsp;</div>';

if ($NbreData7 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table  class="gridtable" border="1">
<caption>Nombre de patients VIH+ sous ARV places sous prophylaxie CTX au cours du mois</caption>
<thead><tr>
			<th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total8_0=0;
			$total8_1=0;
			$total8_2=0;
			$total8_3=0;
			$total8_4=0;
			$total8_5=0;
			$total8_6=0;
			$total8_7=0;
			$total8_8=0;
			$total8_9=0;
			$total8_10=0;
			$total8_11=0;
			$total8_12=0;
   
   for ($i=0; $i<count($tableau8); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData7) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau8[$k]['groupe'];
		   echo '</td><td>';
		  echo $tableau8[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=9&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau8[$k]['sex_id']."& interval=<1 an\">".$tableau8[$k]['<1 an']."</a>";
		 $total8_0=$total8_0+$tableau8[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=9&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau8[$k]['sex_id']."& interval=1-4 ans\">".$tableau8[$k]['1-4 ans']."</a>";
		  $total8_1=$total8_1+$tableau8[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=9&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau8[$k]['sex_id']."& interval=5-9 ans\">".$tableau8[$k]['5-9 ans']."</a>";
		  $total8_2=$total8_2+$tableau8[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=9&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau8[$k]['sex_id']."& interval=10-14 ans\">".$tableau8[$k]['10-14 ans']."</a>";
		  $total8_3=$total8_3+$tableau8[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=9&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau8[$k]['sex_id']."& interval=15-19 ans\">".$tableau8[$k]['15-19 ans']."</a>";
		  $total8_4=$total8_4+$tableau8[$k]['15-19 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=9&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau8[$k]['sex_id']."& interval=20-24 ans\">".$tableau8[$k]['20-24 ans']."</a>";
		  $total8_5=$total8_5+$tableau8[$k]['20-24 ans'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=9&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau8[$k]['sex_id']."& interval=25-29 ans\">".$tableau8[$k]['25-29 ans']."</a>";
		  $total8_6=$total8_6+$tableau8[$k]['25-29 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=9&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau8[$k]['sex_id']."& interval=30-34 ans\">".$tableau8[$k]['30-34 ans']."</a>";
		  $total8_7=$total8_7+$tableau8[$k]['30-34 ans'];
		  echo '</td><td>';
		echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=9&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau8[$k]['sex_id']."& interval=35-39 ans\">".$tableau8[$k]['35-39 ans']."</a>";
		  $total8_8=$total8_8+$tableau8[$k]['35-39 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=9&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau8[$k]['sex_id']."& interval=40-44 ans\">".$tableau8[$k]['40-44 ans']."</a>";
		  $total8_9=$total8_9+$tableau8[$k]['40-44 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=9&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau8[$k]['sex_id']."& interval=45-49 ans\">".$tableau8[$k]['45-49 ans']."</a>";
		  $total8_10=$total8_10+$tableau8[$k]['45-49 ans'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=9&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau8[$k]['sex_id']."& interval=50 ans et plus\">".$tableau8[$k]['50 ans et plus']."</a>";
		  $total8_11=$total8_11+$tableau8[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=9&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau8[$k]['sex_id']."& interval=inconnu\">".$tableau8[$k]['âge inconnu']."</a>";
		  $total8_12=$total8_12+$tableau8[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total8_0.'</td>
			<td>'.$total8_1.'</td>
			<td>'.$total8_2.'</td>
			<td>'.$total8_3.'</td>
			<td>'.$total8_4.'</td>
			<td>'.$total8_5.'</td>
			<td>'.$total8_6.'</td>
			<td>'.$total8_7.'</td>
			<td>'.$total8_8.'</td>
			<td>'.$total8_9.'</td>
			<td>'.$total8_10.'</td>
			<td>'.$total8_11.'</td>
			<td>'.$total8_12.'</td>
			</tr>';
echo '</table>';
}

echo '<div>&nbsp;</div>';


if ($NbreData8 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Patients actifs sous ARV sous CTX </caption>
<thead><tr>
			<th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total9_0=0;
			$total9_1=0;
			$total9_2=0;
			$total9_3=0;
			$total9_4=0;
			$total9_5=0;
			$total9_6=0;
			$total9_7=0;
			$total9_8=0;
			$total9_9=0;
			$total9_10=0;
			$total9_11=0;
			$total9_12=0;
   
   for ($i=0; $i<count($tableau9); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData8) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau9[$k]['groupe'];
		   echo '</td><td>';
		  echo $tableau9[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=10&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau9[$k]['sex_id']."& interval=<1 an\">".$tableau9[$k]['<1 an']."</a>";
		 $total9_0=$total9_0+$tableau9[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=10&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau9[$k]['sex_id']."& interval=1-4 ans\">".$tableau9[$k]['1-4 ans']."</a>";
		  $total9_1=$total9_1+$tableau9[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=10&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau9[$k]['sex_id']."& interval=5-9 ans\">".$tableau9[$k]['5-9 ans']."</a>";
		  $total9_2=$total9_2+$tableau9[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=10&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau9[$k]['sex_id']."& interval=10-14 ans\">".$tableau9[$k]['10-14 ans']."</a>";
		  $total9_3=$total9_3+$tableau9[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=10&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau9[$k]['sex_id']."& interval=15-19 ans\">".$tableau9[$k]['15-19 ans']."</a>";
		  $total9_4=$total9_4+$tableau9[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=10&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau9[$k]['sex_id']."& interval=20-24 ans\">".$tableau9[$k]['20-24 ans']."</a>";
		  $total9_5=$total9_5+$tableau9[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=10&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau9[$k]['sex_id']."& interval=25-29 ans\">".$tableau9[$k]['25-29 ans']."</a>";
		  $total9_6=$total9_6+$tableau9[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=10&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau9[$k]['sex_id']."& interval=30-34 ans\">".$tableau9[$k]['30-34 ans']."</a>";
		  $total9_7=$total9_7+$tableau9[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=10&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau9[$k]['sex_id']."& interval=35-39 ans\">".$tableau9[$k]['35-39 ans']."</a>";
		  $total9_8=$total9_8+$tableau9[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=10&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau9[$k]['sex_id']."& interval=40-44 ans\">".$tableau9[$k]['40-44 ans']."</a>";
		  $total9_9=$total9_9+$tableau9[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=10&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau9[$k]['sex_id']."& interval=45-49 ans\">".$tableau9[$k]['45-49 ans']."</a>";
		  $total9_10=$total9_10+$tableau9[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=10&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau9[$k]['sex_id']."& interval=50 ans et plus\">".$tableau9[$k]['50 ans et plus']."</a>";
		  $total9_11=$total9_11+$tableau9[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=10&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau9[$k]['sex_id']."& interval=inconnu\">".$tableau9[$k]['âge inconnu']."</a>";
		  $total9_12=$total9_12+$tableau9[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total9_0.'</td>
			<td>'.$total9_1.'</td>
			<td>'.$total9_2.'</td>
			<td>'.$total9_3.'</td>
			<td>'.$total9_4.'</td>
			<td>'.$total9_5.'</td>
			<td>'.$total9_6.'</td>
			<td>'.$total9_7.'</td>
			<td>'.$total9_8.'</td>
			<td>'.$total9_9.'</td>
			<td>'.$total9_10.'</td>
			<td>'.$total9_11.'</td>
			<td>'.$total9_12.'</td>
			</tr>';
echo '</table>';
}

echo '<div>&nbsp;</div>';


if ($NbreData9 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Patients sous ARV ayant initie un traitement preventif de la TB au cours du mois </caption>
<thead><tr>
			<th></th>
			<th>Sex</th>
			<th>< 15 ans</th>
			<th>>=15 ans</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total10_0=0;
			$total10_1=0;
			$total10_2=0;
			
   
   for ($i=0; $i<count($tableau10); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData9) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau10[$k]['groupe'];
		   echo '</td><td>';
		  echo $tableau10[$k]['sex'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=11&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau10[$k]['sex_id']."& interval=<15 ans\">".$tableau10[$k]['<15 ans']."</a>";
		 $total10_0=$total10_0+$tableau10[$k]['<15 ans'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=11&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau10[$k]['sex_id']."& interval=>=15 ans\">".$tableau10[$k]['>=15 ans']."</a>";
		  $total10_1=$total10_1+$tableau10[$k]['>=15 ans'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=11&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau10[$k]['sex_id']."& interval=inconnu\">".$tableau10[$k]['âge inconnu']."</a>";
		  $total10_2=$total10_2+$tableau10[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total10_0.'</td>
			<td>'.$total10_1.'</td>
			<td>'.$total10_2.'</td>
			</tr>';
echo '</table>';
}

echo '<div>&nbsp;</div>';


if ($NbreData10 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Patients deja sous ARV ayant initie un traitement preventif de la TB au cours du mois </caption>
<thead><tr>
			<th></th>
			<th>Sex</th>
			<th>< 15 ans</th>
			<th>>=15 ans</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total11_0=0;
			$total11_1=0;
			$total11_2=0;
			
   
   for ($i=0; $i<count($tableau11); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData10) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau11[$k]['groupe'];
		   echo '</td><td>';
		  echo $tableau11[$k]['sex'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=111&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau11[$k]['sex_id']."& interval=<15 ans\">".$tableau11[$k]['<15 ans']."</a>";
		 $total11_0=$total11_0+$tableau11[$k]['<15 ans'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=111&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau11[$k]['sex_id']."& interval=>=15 ans\">".$tableau11[$k]['>=15 ans']."</a>";
		  $total11_1=$total11_1+$tableau11[$k]['>=15 ans'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=111&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau11[$k]['sex_id']."& interval=inconnu\">".$tableau11[$k]['âge inconnu']."</a>";
		  $total11_2=$total11_2+$tableau11[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total11_0.'</td>
			<td>'.$total11_1.'</td>
			<td>'.$total11_2.'</td>
			</tr>';
echo '</table>';
}


echo '<div>&nbsp;</div>';


if ($NbreData11 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Patients sous ARV ayant initie un traitement preventif de la TB il y a 6 mois</caption>
<thead><tr>
			<th></th>
			<th>Sex</th>
			<th>< 15 ans</th>
			<th>>=15 ans</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total12_0=0;
			$total12_1=0;
			$total12_2=0;
			
   
   for ($i=0; $i<count($tableau12); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData11) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau12[$k]['groupe'];
		   echo '</td><td>';
		  echo $tableau12[$k]['sex'];
		   echo '</td><td>';
         echo "<a target=\"_blank\" rel=\"noopener noreferrer\"  href=\" arv_pnls_list.php?indicateur=112&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau12[$k]['sex_id']."& interval=<15 ans\">".$tableau12[$k]['<15 ans']."</a>";		 
		 $total12_0=$total12_0+$tableau12[$k]['<15 ans'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\"  href=\" arv_pnls_list.php?indicateur=112&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau12[$k]['sex_id']."& interval=>=15 ans\">".$tableau12[$k]['>=15 ans']."</a>";
		  $total12_1=$total12_1+$tableau12[$k]['>=15 ans'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=112&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau12[$k]['sex_id']."& interval=inconnu\">".$tableau12[$k]['âge inconnu']."</a>";
		  $total12_2=$total12_2+$tableau12[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total12_0.'</td>
			<td>'.$total12_1.'</td>
			<td>'.$total12_2.'</td>
			</tr>';
echo '</table>';
}


echo '<div>&nbsp;</div>';


if ($NbreData12 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Patients deja sous ARV ayant initie un traitement preventif de la TB il y a 6 mois </caption>
<thead><tr>
			<th></th>
			<th>Sex</th>
			<th>< 15 ans</th>
			<th>>=15 ans</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total13_0=0;
			$total13_1=0;
			$total13_2=0;
			
   
   for ($i=0; $i<count($tableau13); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData12) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau13[$k]['groupe'];
		   echo '</td><td>';
		  echo $tableau13[$k]['sex'];
		   echo '</td><td>'; 
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=113&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau13[$k]['sex_id']."& interval=<15 ans\">".$tableau13[$k]['<15 ans']."</a>";
		 $total13_0=$total13_0+$tableau13[$k]['<15 ans'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=113&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau13[$k]['sex_id']."& interval=>=15 ans\">".$tableau13[$k]['>=15 ans']."</a>";
		  $total13_1=$total13_1+$tableau13[$k]['>=15 ans'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=113&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau13[$k]['sex_id']."& interval=inconnu\">".$tableau13[$k]['âge inconnu']."</a>";
		  $total13_2=$total13_2+$tableau13[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total13_0.'</td>
			<td>'.$total13_1.'</td>
			<td>'.$total13_2.'</td>
			</tr>';
echo '</table>';
}
 else {
echo 'pas de données à afficher';
}

echo '<div>&nbsp;</div>';


if ($NbreData13 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Patients sous ARV ayant complete un traitement preventif de la TB au cours du mois </caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 15 ans</th>
			<th>>=15 ans</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total14_0=0;
			$total14_1=0;
			$total14_2=0;
			
   
   for ($i=0; $i<count($tableau14); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData13) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau14[$k]['groupe'];
		   echo '</td><td>';
		  echo $tableau14[$k]['sex'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=12&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau14[$k]['sex_id']."&interval=<15 ans\">".$tableau14[$k]['<15 ans']."</a>";
		 $total14_0=$total14_0+$tableau14[$k]['<15 ans'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=12&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau14[$k]['sex_id']."&interval=>=15 ans\">".$tableau14[$k]['>=15 ans']."</a>";
		  $total14_1=$total14_1+$tableau14[$k]['>=15 ans'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=12&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau14[$k]['sex_id']."& interval=inconnu\">".$tableau14[$k]['âge inconnu']."</a>";
		  $total14_2=$total14_2+$tableau14[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total14_0.'</td>
			<td>'.$total14_1.'</td>
			<td>'.$total14_2.'</td>
			</tr>';
echo '</table>';
}


echo '<div>&nbsp;</div>';


if ($NbreData14 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Patients deja sous ARV ayant complete un traitement preventif de la TB au cours du mois </caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 15 ans</th>
			<th>>=15 ans</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total15_0=0;
			$total15_1=0;
			$total15_2=0;
			
   
   for ($i=0; $i<count($tableau15); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData14) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau15[$k]['groupe'];
		   echo '</td><td>';
		  echo $tableau15[$k]['sex'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=122&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau15[$k]['sex_id']."&interval=<15 ans\">".$tableau15[$k]['<15 ans']."</a>";
		 $total15_0=$total15_0+$tableau15[$k]['<15 ans'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=122&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau15[$k]['sex_id']."&interval=>=15 ans\">".$tableau15[$k]['>=15 ans']."</a>";
		  $total15_1=$total15_1+$tableau15[$k]['>=15 ans'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=122&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau15[$k]['sex_id']."& interval=inconnu\">".$tableau15[$k]['âge inconnu']."</a>";
		  $total15_2=$total15_2+$tableau15[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total15_0.'</td>
			<td>'.$total15_1.'</td>
			<td>'.$total15_2.'</td>
			</tr>';
echo '</table>';
}


echo '<div>&nbsp;</div>';


if ($NbreData15 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Nouveaux patients actifs sous ARV ayant ete screenes positifs au moins une fois pour la tuberculose au cours des 6 derniers mois </caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 15 ans</th>
			<th>>=15 ans</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total16_0=0;
			$total16_1=0;
			$total16_2=0;
			
   
   for ($i=0; $i<count($tableau16); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData15) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau16[$k]['groupe'];
		   echo '</td><td>';
		  echo $tableau16[$k]['sex'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=13&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau16[$k]['sex_id']."& interval=<15 ans\">".$tableau16[$k]['<15 ans']."</a>";
		 $total16_0=$total16_0+$tableau16[$k]['<15 ans'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=13&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau16[$k]['sex_id']."& interval=>=15 ans\">".$tableau16[$k]['>=15 ans']."</a>";
		  $total16_1=$total16_1+$tableau16[$k]['>=15 ans'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=13&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau16[$k]['sex_id']."& interval=inconnu\">".$tableau16[$k]['âge inconnu']."</a>";
		  $total16_2=$total16_2+$tableau16[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total16_0.'</td>
			<td>'.$total16_1.'</td>
			<td>'.$total16_2.'</td>
			</tr>';
echo '</table>';
}


echo '<div>&nbsp;</div>';


if ($NbreData16 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Patients actifs deja sous ARV ayant ete screenes positifs au moins une fois pour la tuberculose au cours des 6 derniers mois </caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 15 ans</th>
			<th>>=15 ans</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total17_0=0;
			$total17_1=0;
			$total17_2=0;
			
   
   for ($i=0; $i<count($tableau17); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData16) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau17[$k]['groupe'];
		   echo '</td><td>';
		  echo $tableau17[$k]['sex'];
		   echo '</td><td>';
         echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=133&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau17[$k]['sex_id']."& interval=<15 ans\">".$tableau17[$k]['<15 ans']."</a>";		 
		 $total17_0=$total17_0+$tableau17[$k]['<15 ans'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=133&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau17[$k]['sex_id']."& interval=>=15 ans\">".$tableau17[$k]['>=15 ans']."</a>";
		  $total17_1=$total17_1+$tableau17[$k]['>=15 ans'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=133&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau17[$k]['sex_id']."& interval=inconnu\">".$tableau17[$k]['âge inconnu']."</a>";
		  $total17_2=$total17_2+$tableau17[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total17_0.'</td>
			<td>'.$total17_1.'</td>
			<td>'.$total17_2.'</td>
			</tr>';
echo '</table>';
}


echo '<div>&nbsp;</div>';


if ($NbreData17 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Nouveaux patients actifs sous ARV ayant ete screenes negatifs pour la tuberculose au moins une fois  au cours des 6 derniers mois </caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 15 ans</th>
			<th>>=15 ans</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total18_0=0;
			$total18_1=0;
			$total18_2=0;
			
   
   for ($i=0; $i<count($tableau18); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData17) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau18[$k]['groupe'];
		   echo '</td><td>';
		  echo $tableau18[$k]['sex'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=134&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau18[$k]['sex_id']."& interval=<15 ans\">".$tableau18[$k]['<15 ans']."</a>";
		 $total18_0=$total18_0+$tableau18[$k]['<15 ans'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=134&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau18[$k]['sex_id']."& interval=>=15 ans\">".$tableau18[$k]['>=15 ans']."</a>";
		  $total18_1=$total18_1+$tableau18[$k]['>=15 ans'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=134&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau18[$k]['sex_id']."& interval=inconnu\">".$tableau18[$k]['âge inconnu']."</a>";
		  $total18_2=$total18_2+$tableau18[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total18_0.'</td>
			<td>'.$total18_1.'</td>
			<td>'.$total18_2.'</td>
			</tr>';
echo '</table>';
}


echo '<div>&nbsp;</div>';


if ($NbreData18 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Patients actifs deja sous ARV ayant ete screenes negatifs pour la tuberculose au moins une fois au cours des 6 derniers mois </caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 15 ans</th>
			<th>>=15 ans</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total19_0=0;
			$total19_1=0;
			$total19_2=0;
			
   
   for ($i=0; $i<count($tableau19); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData18) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau19[$k]['groupe'];
		   echo '</td><td>';
		  echo $tableau19[$k]['sex'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=135&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau19[$k]['sex_id']."& interval=<15 ans\">".$tableau19[$k]['<15 ans']."</a>";
		 $total19_0=$total19_0+$tableau19[$k]['<15 ans'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=135&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau19[$k]['sex_id']."& interval=>=15 ans\">".$tableau19[$k]['>=15 ans']."</a>";
		  $total19_1=$total19_1+$tableau19[$k]['>=15 ans'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=135&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau19[$k]['sex_id']."& interval=inconnu\">".$tableau19[$k]['âge inconnu']."</a>";
		  $total19_2=$total19_2+$tableau19[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total19_0.'</td>
			<td>'.$total19_1.'</td>
			<td>'.$total19_2.'</td>
			</tr>';
echo '</table>';
}
 else {
echo 'pas de données à afficher';
}



echo '<div>&nbsp;</div>';

if ($NbreData19 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Patients sous ARV nouvellement places sous traitement anti-TB </caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 15 ans</th>
			<th>>=15 ans</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total20_0=0;
			$total20_1=0;
			$total20_2=0;
			
   
   for ($i=0; $i<count($tableau20); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData19) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau20[$k]['groupe'];
		   echo '</td><td>';
		  echo $tableau20[$k]['sex'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=14&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau20[$k]['sex_id']."& interval=<15 ans\">".$tableau20[$k]['<15 ans']."</a>";
		 $total20_0=$total20_0+$tableau20[$k]['<15 ans'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=14&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau20[$k]['sex_id']."& interval=>=15 ans\">".$tableau20[$k]['>=15 ans']."</a>";
		  $total20_1=$total20_1+$tableau20[$k]['>=15 ans'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=14&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau20[$k]['sex_id']."& interval=inconnu\">".$tableau20[$k]['âge inconnu']."</a>";
		  $total20_2=$total20_2+$tableau20[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total20_0.'</td>
			<td>'.$total20_1.'</td>
			<td>'.$total20_2.'</td>
			</tr>';
echo '</table>';
}

echo '<div>&nbsp;</div>';

if ($NbreData20 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Patients sous ARV nouvellement places sous traitement anti-TB </caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 15 ans</th>
			<th>>=15 ans</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total21_0=0;
			$total21_1=0;
			$total21_2=0;
			
   
   for ($i=0; $i<count($tableau21); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData20) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau21[$k]['groupe'];
		   echo '</td><td>';
		  echo $tableau21[$k]['sex'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=144&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau21[$k]['sex_id']."& interval=<15 ans\">".$tableau21[$k]['<15 ans']."</a>";
		 $total21_0=$total21_0+$tableau21[$k]['<15 ans'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=144&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau21[$k]['sex_id']."& interval=>=15 ans\">".$tableau21[$k]['>=15 ans']."</a>";
		  $total21_1=$total21_1+$tableau21[$k]['>=15 ans'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=144&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau21[$k]['sex_id']."& interval=inconnu\">".$tableau21[$k]['âge inconnu']."</a>";
		  $total21_2=$total21_2+$tableau21[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total21_0.'</td>
			<td>'.$total21_1.'</td>
			<td>'.$total21_2.'</td>
			</tr>';
echo '</table>';
}

echo '<div>&nbsp;</div>';

if ($NbreData21 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Nombre de patients TB/VIH sous traitement anti-TB :TB_ART (D) </caption>
<thead><tr>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total22_0=0;
			$total22_1=0;
			$total22_2=0;
			$total22_3=0;
			$total22_4=0;
			$total22_5=0;
			$total22_6=0;
			$total22_7=0;
			$total22_8=0;
			$total22_9=0;
			$total22_10=0;
			$total22_11=0;
			$total22_12=0;
   
   for ($i=0; $i<count($tableau22); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData21) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau22[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=15&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau22[$k]['sex_id']."& interval=<1 an\">".$tableau22[$k]['<1 an']."</a>";
		 $total22_0=$total22_0+$tableau22[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=15&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau22[$k]['sex_id']."& interval=1-4 ans\">".$tableau22[$k]['1-4 ans']."</a>";
		  $total22_1=$total22_1+$tableau22[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=15&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau22[$k]['sex_id']."& interval=5-9 ans\">".$tableau22[$k]['5-9 ans']."</a>";
		  $total22_2=$total22_2+$tableau22[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=15&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau22[$k]['sex_id']."& interval=10-14 ans\">".$tableau22[$k]['10-14 ans']."</a>";
		  $total22_3=$total22_3+$tableau22[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=15&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau22[$k]['sex_id']."& interval=15-19 ans\">".$tableau22[$k]['15-19 ans']."</a>";
		  $total22_4=$total22_4+$tableau22[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=15&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau22[$k]['sex_id']."& interval=20-24 ans\">".$tableau22[$k]['20-24 ans']."</a>";
		  $total22_5=$total22_5+$tableau22[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=15&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau22[$k]['sex_id']."& interval=25-29 ans\">".$tableau22[$k]['25-29 ans']."</a>";
		  $total22_6=$total22_6+$tableau22[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=15&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau22[$k]['sex_id']."& interval=30-34 ans\">".$tableau22[$k]['30-34 ans']."</a>";
		  $total22_7=$total22_7+$tableau22[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=15&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau22[$k]['sex_id']."& interval=35-39 ans\">".$tableau22[$k]['35-39 ans']."</a>";
		  $total22_8=$total22_8+$tableau22[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=15&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau22[$k]['sex_id']."& interval=40-44 ans\">".$tableau22[$k]['40-44 ans']."</a>";
		  $total22_9=$total22_9+$tableau22[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=15&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau22[$k]['sex_id']."& interval=45-49 ans\">".$tableau22[$k]['45-49 ans']."</a>";
		  $total22_10=$total22_10+$tableau22[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=15&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau22[$k]['sex_id']."& interval=50 ans et plus\">".$tableau22[$k]['50 ans et plus']."</a>";
		  $total22_11=$total22_11+$tableau22[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=15&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau22[$k]['sex_id']."& interval=inconnu\">".$tableau22[$k]['âge inconnu']."</a>";
		  $total22_12=$total22_12+$tableau22[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td>'.$total22_0.'</td>
			<td>'.$total22_1.'</td>
			<td>'.$total22_2.'</td>
			<td>'.$total22_3.'</td>
			<td>'.$total22_4.'</td>
			<td>'.$total22_5.'</td>
			<td>'.$total22_6.'</td>
			<td>'.$total22_7.'</td>
			<td>'.$total22_8.'</td>
			<td>'.$total22_9.'</td>
			<td>'.$total22_10.'</td>
			<td>'.$total22_11.'</td>
			<td>'.$total22_12.'</td>
			</tr>';
echo '</table>';
}

echo '<div>&nbsp;</div>';

if ($NbreData22 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Nombre de patients TB/VIH sous traitement ARV : TB_ART (N) </caption>
<thead><tr>
			<th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total23_0=0;
			$total23_1=0;
			$total23_2=0;
			$total23_3=0;
			$total23_4=0;
			$total23_5=0;
			$total23_6=0;
			$total23_7=0;
			$total23_8=0;
			$total23_9=0;
			$total23_10=0;
			$total23_11=0;
			$total23_12=0;
   
   for ($i=0; $i<count($tableau23); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData22) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau23[$k]['groupe'];
		   echo '</td><td>';
		  echo $tableau23[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=16&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau23[$k]['sex_id']."& interval=<1 an\">".$tableau23[$k]['<1 an']."</a>";
		 $total23_0=$total23_0+$tableau23[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=16&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau23[$k]['sex_id']."& interval=1-4 ans\">".$tableau23[$k]['1-4 ans']."</a>";
		  $total23_1=$total23_1+$tableau23[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=16&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau23[$k]['sex_id']."& interval=5-9 ans\">".$tableau23[$k]['5-9 ans']."</a>";
		  $total23_2=$total23_2+$tableau23[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=16&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau23[$k]['sex_id']."& interval=10-14 ans\">".$tableau23[$k]['10-14 ans']."</a>";
		  $total23_3=$total23_3+$tableau23[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=16&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau23[$k]['sex_id']."& interval=15-19 ans\">".$tableau23[$k]['15-19 ans']."</a>";
		  $total23_4=$total23_4+$tableau23[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=16&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau23[$k]['sex_id']."& interval=20-24 ans\">".$tableau23[$k]['20-24 ans']."</a>";
		  $total23_5=$total23_5+$tableau23[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=16&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau23[$k]['sex_id']."& interval=25-29 ans\">".$tableau23[$k]['25-29 ans']."</a>";
		  $total23_6=$total23_6+$tableau23[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=16&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau23[$k]['sex_id']."& interval=30-34 ans\">".$tableau23[$k]['30-34 ans']."</a>";
		  $total23_7=$total23_7+$tableau23[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=16&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau23[$k]['sex_id']."& interval=35-39 ans\">".$tableau23[$k]['35-39 ans']."</a>";
		  $total23_8=$total23_8+$tableau23[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=16&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau23[$k]['sex_id']."& interval=40-44 ans\">".$tableau23[$k]['40-44 ans']."</a>";
		  $total23_9=$total23_9+$tableau23[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=16&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau23[$k]['sex_id']."& interval=45-49 ans\">".$tableau23[$k]['45-49 ans']."</a>";
		  $total23_10=$total23_10+$tableau23[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=16&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau23[$k]['sex_id']."& interval=50 ans et plus\">".$tableau23[$k]['50 ans et plus']."</a>";
		  $total23_11=$total23_11+$tableau23[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=16&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau23[$k]['sex_id']."& interval=inconnu\">".$tableau23[$k]['âge inconnu']."</a>";
		  $total23_12=$total23_12+$tableau23[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total23_0.'</td>
			<td>'.$total23_1.'</td>
			<td>'.$total23_2.'</td>
			<td>'.$total23_3.'</td>
			<td>'.$total23_4.'</td>
			<td>'.$total23_5.'</td>
			<td>'.$total23_6.'</td>
			<td>'.$total23_7.'</td>
			<td>'.$total23_8.'</td>
			<td>'.$total23_9.'</td>
			<td>'.$total23_10.'</td>
			<td>'.$total23_11.'</td>
			<td>'.$total23_12.'</td>
			</tr>';
echo '</table>';
}

echo '<div>&nbsp;</div>';

if ($NbreData23 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Nombre de patients TB/VIH sous traitement ARV : TB_ART (N) </caption>
<thead><tr>
			<th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total24_0=0;
			$total24_1=0;
			$total24_2=0;
			$total24_3=0;
			$total24_4=0;
			$total24_5=0;
			$total24_6=0;
			$total24_7=0;
			$total24_8=0;
			$total24_9=0;
			$total24_10=0;
			$total24_11=0;
			$total24_12=0;
   
   for ($i=0; $i<count($tableau24); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData23) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau24[$k]['groupe'];
		   echo '</td><td>';
		  echo $tableau24[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=166&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau24[$k]['sex_id']."& interval=<1 an\">".$tableau24[$k]['<1 an']."</a>";
		 $total24_0=$total24_0+$tableau24[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=166&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau24[$k]['sex_id']."& interval=1-4 ans\">".$tableau24[$k]['1-4 ans']."</a>";
		  $total24_1=$total24_1+$tableau24[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=166&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau24[$k]['sex_id']."& interval=5-9 ans\">".$tableau24[$k]['5-9 ans']."</a>";
		  $total24_2=$total24_2+$tableau24[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=166&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau24[$k]['sex_id']."& interval=10-14 ans\">".$tableau24[$k]['10-14 ans']."</a>";
		  $total24_3=$total24_3+$tableau24[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=166&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau24[$k]['sex_id']."& interval=15-19 ans\">".$tableau24[$k]['15-19 ans']."</a>";
		  $total24_4=$total24_4+$tableau24[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=166&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau24[$k]['sex_id']."& interval=20-24 ans\">".$tableau24[$k]['20-24 ans']."</a>";
		  $total24_5=$total24_5+$tableau24[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=166&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau24[$k]['sex_id']."& interval=25-29 ans\">".$tableau24[$k]['25-29 ans']."</a>";
		  $total24_6=$total24_6+$tableau24[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=166&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau24[$k]['sex_id']."& interval=30-34 ans\">".$tableau24[$k]['30-34 ans']."</a>";
		  $total24_7=$total24_7+$tableau24[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=166&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau24[$k]['sex_id']."& interval=35-39 ans\">".$tableau24[$k]['35-39 ans']."</a>";
		  $total24_8=$total24_8+$tableau24[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=166&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau24[$k]['sex_id']."& interval=40-44 ans\">".$tableau24[$k]['40-44 ans']."</a>";
		  $total24_9=$total24_9+$tableau24[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=166&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau24[$k]['sex_id']."& interval=45-49 ans\">".$tableau24[$k]['45-49 ans']."</a>";
		  $total24_10=$total24_10+$tableau24[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=166&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau24[$k]['sex_id']."& interval=50 ans et plus\">".$tableau24[$k]['50 ans et plus']."</a>";
		  $total24_11=$total24_11+$tableau24[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=166&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau24[$k]['sex_id']."& interval=inconnu\">".$tableau24[$k]['âge inconnu']."</a>";
		  $total24_12=$total24_12+$tableau24[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total24_0.'</td>
			<td>'.$total24_1.'</td>
			<td>'.$total24_2.'</td>
			<td>'.$total24_3.'</td>
			<td>'.$total24_4.'</td>
			<td>'.$total24_5.'</td>
			<td>'.$total24_6.'</td>
			<td>'.$total24_7.'</td>
			<td>'.$total24_8.'</td>
			<td>'.$total24_9.'</td>
			<td>'.$total24_10.'</td>
			<td>'.$total24_11.'</td>
			<td>'.$total24_12.'</td>
			</tr>';
echo '</table>';
}

echo '<div>&nbsp;</div>';

if ($NbreData24 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Patients VIH+ actifs sous ARV : TX_CURR</caption>
<thead><tr>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total25_0=0;
			$total25_1=0;
			$total25_2=0;
			$total25_3=0;
			$total25_4=0;
			$total25_5=0;
			$total25_6=0;
			$total25_7=0;
			$total25_8=0;
			$total25_9=0;
			$total25_10=0;
			$total25_11=0;
			$total25_12=0;
   
   for ($i=0; $i<count($tableau25); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData24) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau25[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=17&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau25[$k]['sex_id']."& interval=<1 an\">".$tableau25[$k]['<1 an']."</a>";
		 $total25_0=$total25_0+$tableau25[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=17&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau25[$k]['sex_id']."& interval=1-4 ans\">".$tableau25[$k]['1-4 ans']."</a>";
		  $total25_1=$total25_1+$tableau25[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=17&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau25[$k]['sex_id']."& interval=5-9 ans\">".$tableau25[$k]['5-9 ans']."</a>";
		  $total25_2=$total25_2+$tableau25[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=17&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau25[$k]['sex_id']."& interval=10-14 ans\">".$tableau25[$k]['10-14 ans']."</a>";
		  $total25_3=$total25_3+$tableau25[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=17&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau25[$k]['sex_id']."& interval=15-19 ans\">".$tableau25[$k]['15-19 ans']."</a>";
		  $total25_4=$total25_4+$tableau25[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=17&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau25[$k]['sex_id']."& interval=20-24 ans\">".$tableau25[$k]['20-24 ans']."</a>";
		  $total25_5=$total25_5+$tableau25[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=17&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau25[$k]['sex_id']."& interval=25-29 ans\">".$tableau25[$k]['25-29 ans']."</a>";
		  $total25_6=$total25_6+$tableau25[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=17&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau25[$k]['sex_id']."& interval=30-34 ans\">".$tableau25[$k]['30-34 ans']."</a>";
		  $total25_7=$total25_7+$tableau25[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=17&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau25[$k]['sex_id']."& interval=35-39 ans\">".$tableau25[$k]['35-39 ans']."</a>";
		  $total25_8=$total25_8+$tableau25[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=17&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau25[$k]['sex_id']."& interval=40-44 ans\">".$tableau25[$k]['40-44 ans']."</a>";
		  $total25_9=$total25_9+$tableau25[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=17&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau25[$k]['sex_id']."& interval=45-49 ans\">".$tableau25[$k]['45-49 ans']."</a>";
		  $total25_10=$total25_10+$tableau25[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=17&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau25[$k]['sex_id']."& interval=50 ans et plus\">".$tableau25[$k]['50 ans et plus']."</a>";
		  $total25_11=$total25_11+$tableau25[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=17&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau25[$k]['sex_id']."& interval=inconnu\">".$tableau25[$k]['âge inconnu']."</a>";
		  $total25_12=$total25_12+$tableau25[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td>'.$total25_0.'</td>
			<td>'.$total25_1.'</td>
			<td>'.$total25_2.'</td>
			<td>'.$total25_3.'</td>
			<td>'.$total25_4.'</td>
			<td>'.$total25_5.'</td>
			<td>'.$total25_6.'</td>
			<td>'.$total25_7.'</td>
			<td>'.$total25_8.'</td>
			<td>'.$total25_9.'</td>
			<td>'.$total25_10.'</td>
			<td>'.$total25_11.'</td>
			<td>'.$total25_12.'</td>
			</tr>';
echo '</table>';
}

echo '<div>&nbsp;</div>';

if ($NbreData25 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption>Personnes des populations cles actives sous ARV</caption>
<thead><tr>
            <th></th>
			<th>HARSAH</th>
			<th>Professionnels de sexe</th>
			<th>Personnes transgenres</th>
			<th>Prisonniers</th>
			<th>Utilisateurs de drogues injectables</th>
			</tr></thead>';
			
			$total26_0=0;
			$total26_1=0;
			$total26_2=0;
			$total26_3=0;
			$total26_4=0;
   
   for ($i=0; $i<count($tableau26); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData25) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  echo '</td><td>';
		  $k = ($i+($j*$NbrLigne));
		   echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=18&cle=HARSAH&startDate=".$startDate."&endDate=".$endDate."&sex=& interval=\">".$tableau26[$k]['HARSAH']."</a>";
		  $total26_0=$total26_0+$tableau26[$k]['HARSAH'];
		   echo '</td><td>';
		   echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=18&cle=Professionnels de sexe&startDate=".$startDate."&endDate=".$endDate."&sex=& interval=\">".$tableau26[$k]['Professionnels de sexe']."</a>";
		  $total26_1=$total26_1+$tableau26[$k]['Professionnels de sexe'];
		   echo '</td><td>';
		   echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=18&cle=Personnes transgenres&startDate=".$startDate."&endDate=".$endDate."&sex=& interval=\">".$tableau26[$k]['Personnes transgenres']."</a>";
          $total26_2=$total26_2+$tableau26[$k]['Personnes transgenres'];
		   echo '</td><td>';
		   echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=18&cle=Prisonniers&startDate=".$startDate."&endDate=".$endDate."&sex=& interval=\">".$tableau26[$k]['Prisonniers']."</a>"; 
		  $total26_3=$total26_3+$tableau26[$k]['Prisonniers'];
		   echo '</td><td>';
		   echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=18&cle=Utilisateurs de drogues injectables&startDate=".$startDate."&endDate=".$endDate."&sex=& interval=\">".$tableau26[$k]['Utilisateurs de drogues injectables']."</a>"; 
          $total26_4=$total26_4+$tableau26[$k]['Utilisateurs de drogues injectables'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
            <td>Total</td>
			<td>'.$total26_0.'</td>
			<td>'.$total26_1.'</td>
			<td>'.$total26_2.'</td>
			<td>'.$total26_3.'</td>
			<td>'.$total26_4.'</td>
			</tr>';
echo '</table>';
}

echo '<div>&nbsp;</div>';

if ($NbreData26 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption> Nombre de patients recevant des médicaments ARV sur plusieurs mois</caption>
<thead><tr>
			<th></th>
			<th>Sex</th>
			<th>< 15 ans</th>
			<th>>=15 ans</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total27_0=0;
			$total27_1=0;
			$total27_2=0;
			
			
   
   for ($i=0; $i<count($tableau27); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<count($tableau27)) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  echo $tableau27[$k]['dispensationIntervalle'];
		   echo '</td><td>';
		  echo $tableau27[$k]['sex'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=19&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau27[$k]['sex_id']."&interval=<15 ans&dispdInterval=".$tableau27[$k]['dispensationIntervalle']."\">".$tableau27[$k]['<15 ans']."</a>";
		 $total27_0=$total27_0+$tableau27[$k]['<15 ans'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=19&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau27[$k]['sex_id']."&interval=>=15 ans&dispdInterval=".$tableau27[$k]['dispensationIntervalle']."\">".$tableau27[$k]['>=15 ans']."</a>";
		  $total27_1=$total27_1+$tableau27[$k]['>=15 ans'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=19&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau27[$k]['sex_id']."&interval=inconnu&dispdInterval=".$tableau27[$k]['dispensationIntervalle']."\">".$tableau27[$k]['âge inconnu']."</a>";
		  $total27_2=$total27_2+$tableau27[$k]['âge inconnu'];
		 echo '</td>';echo '</tr>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total27_0.'</td>
			<td>'.$total27_1.'</td>
			<td>'.$total27_2.'</td>
			</tr>';
echo '</table>';
}

echo '<div>&nbsp;</div>';





/*16.1. Nombre de patients décédés CONFIRMES parmi les perdus de vue recherchés au cours du mois du rapport*/

if ($NbreData41 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de patients décédés CONFIRMES parmi les perdus de vue recherchés au cours du mois du rapport</b></caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total41_0=0;
			$total41_1=0;
			$total41_2=0;
			$total41_3=0;
			$total41_4=0;
			$total41_5=0;
			$total41_6=0;
			$total41_7=0;
			$total41_8=0;
			$total41_9=0;
			$total41_10=0;
			$total41_11=0;
			$total41_12=0;
   
   for ($i=0; $i<count($tableau41); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<count($tableau41)) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  /*echo $tableau41[$k]['groupe'];*/
		   echo '</td><td>';
		  echo $tableau41[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=41&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau41[$k]['sex_id']."& interval=<1 an\">".$tableau41[$k]['<1 an']."</a>";
		 $total41_0=$total41_0+$tableau41[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=41&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau41[$k]['sex_id']."& interval=1-4 ans\">".$tableau41[$k]['1-4 ans']."</a>";
		  $total41_1=$total41_1+$tableau41[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=41&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau41[$k]['sex_id']."& interval=5-9 ans\">".$tableau41[$k]['5-9 ans']."</a>";
		  $total41_2=$total41_2+$tableau41[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=41&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau41[$k]['sex_id']."& interval=10-14 ans\">".$tableau41[$k]['10-14 ans']."</a>";
		  $total41_3=$total41_3+$tableau41[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=41&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau41[$k]['sex_id']."& interval=15-19 ans\">".$tableau41[$k]['15-19 ans']."</a>";
		  $total41_4=$total41_4+$tableau41[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=41&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau41[$k]['sex_id']."& interval=20-24 ans\">".$tableau41[$k]['20-24 ans']."</a>";
		  $total41_5=$total41_5+$tableau41[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=41&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau41[$k]['sex_id']."& interval=25-29 ans\">".$tableau41[$k]['25-29 ans']."</a>";
		  $total41_6=$total41_6+$tableau41[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=41&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau41[$k]['sex_id']."& interval=30-34 ans\">".$tableau41[$k]['30-34 ans']."</a>";
		  $total41_7=$total41_7+$tableau41[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=41&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau41[$k]['sex_id']."& interval=35-39 ans\">".$tableau41[$k]['35-39 ans']."</a>";
		  $total41_8=$total41_8+$tableau41[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=41&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau41[$k]['sex_id']."& interval=40-44 ans\">".$tableau41[$k]['40-44 ans']."</a>";
		  $total41_9=$total41_9+$tableau41[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=41&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau41[$k]['sex_id']."& interval=45-49 ans\">".$tableau41[$k]['45-49 ans']."</a>";
		  $total41_10=$total41_10+$tableau41[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=41&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau41[$k]['sex_id']."& interval=50 ans et plus\">".$tableau41[$k]['50 ans et plus']."</a>";
		  $total41_11=$total41_11+$tableau41[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=41&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau41[$k]['sex_id']."& interval=inconnu\">".$tableau41[$k]['âge inconnu']."</a>";
		  $total41_12=$total41_12+$tableau41[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total41_0.'</td>
			<td>'.$total41_1.'</td>
			<td>'.$total41_2.'</td>
			<td>'.$total41_3.'</td>
			<td>'.$total41_4.'</td>
			<td>'.$total41_5.'</td>
			<td>'.$total41_6.'</td>
			<td>'.$total41_7.'</td>
			<td>'.$total41_8.'</td>
			<td>'.$total41_9.'</td>
			<td>'.$total41_10.'</td>
			<td>'.$total41_11.'</td>
			<td>'.$total41_12.'</td>
			</tr>';
echo '</table>';
}
echo '<div>&nbsp;</div>';

/*Nombre de patients perdus de vue après un traitement de moins de 3 mois sous ARV*/

if ($NbreData42 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de patients perdus de vue après un traitement de moins de 3 mois sous ARV</b></caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total42_0=0;
			$total42_1=0;
			$total42_2=0;
			$total42_3=0;
			$total42_4=0;
			$total42_5=0;
			$total42_6=0;
			$total42_7=0;
			$total42_8=0;
			$total42_9=0;
			$total42_10=0;
			$total42_11=0;
			$total42_12=0;
   
   for ($i=0; $i<count($tableau42); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData42) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  /*echo $tableau42[$k]['groupe'];*/
		   echo '</td><td>';
		  echo $tableau42[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=42&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau42[$k]['sex_id']."& interval=<1 an\">".$tableau42[$k]['<1 an']."</a>";
		 $total42_0=$total42_0+$tableau42[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=42&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau42[$k]['sex_id']."& interval=1-4 ans\">".$tableau42[$k]['1-4 ans']."</a>";
		  $total42_1=$total42_1+$tableau42[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=42&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau42[$k]['sex_id']."& interval=5-9 ans\">".$tableau42[$k]['5-9 ans']."</a>";
		  $total42_2=$total42_2+$tableau42[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=42&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau42[$k]['sex_id']."& interval=10-14 ans\">".$tableau42[$k]['10-14 ans']."</a>";
		  $total42_3=$total42_3+$tableau42[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=42&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau42[$k]['sex_id']."& interval=15-19 ans\">".$tableau42[$k]['15-19 ans']."</a>";
		  $total42_4=$total42_4+$tableau42[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=42&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau42[$k]['sex_id']."& interval=20-24 ans\">".$tableau42[$k]['20-24 ans']."</a>";
		  $total42_5=$total42_5+$tableau42[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=42&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau42[$k]['sex_id']."& interval=25-29 ans\">".$tableau42[$k]['25-29 ans']."</a>";
		  $total42_6=$total42_6+$tableau42[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=42&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau42[$k]['sex_id']."& interval=30-34 ans\">".$tableau42[$k]['30-34 ans']."</a>";
		  $total42_7=$total42_7+$tableau42[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=42&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau42[$k]['sex_id']."& interval=35-39 ans\">".$tableau42[$k]['35-39 ans']."</a>";
		  $total42_8=$total42_8+$tableau42[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=42&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau42[$k]['sex_id']."& interval=40-44 ans\">".$tableau42[$k]['40-44 ans']."</a>";
		  $total42_9=$total42_9+$tableau42[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=42&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau42[$k]['sex_id']."& interval=45-49 ans\">".$tableau42[$k]['45-49 ans']."</a>";
		  $total42_10=$total42_10+$tableau42[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=42&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau42[$k]['sex_id']."& interval=50 ans et plus\">".$tableau42[$k]['50 ans et plus']."</a>";
		  $total42_11=$total42_11+$tableau42[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=42&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau42[$k]['sex_id']."& interval=inconnu\">".$tableau42[$k]['âge inconnu']."</a>";
		  $total42_12=$total42_12+$tableau42[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total42_0.'</td>
			<td>'.$total42_1.'</td>
			<td>'.$total42_2.'</td>
			<td>'.$total42_3.'</td>
			<td>'.$total42_4.'</td>
			<td>'.$total42_5.'</td>
			<td>'.$total42_6.'</td>
			<td>'.$total42_7.'</td>
			<td>'.$total42_8.'</td>
			<td>'.$total42_9.'</td>
			<td>'.$total42_10.'</td>
			<td>'.$total42_11.'</td>
			<td>'.$total42_12.'</td>
			</tr>';
echo '</table>';
}
echo '<div>&nbsp;</div>';

/*Nombre de patients perdus de vue après un traitement de plus de 3 mois sous ARV */

if ($NbreData43 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de patients perdus de vue après un traitement de plus de 3 mois sous ARV</b></caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total43_0=0;
			$total43_1=0;
			$total43_2=0;
			$total43_3=0;
			$total43_4=0;
			$total43_5=0;
			$total43_6=0;
			$total43_7=0;
			$total43_8=0;
			$total43_9=0;
			$total43_10=0;
			$total43_11=0;
			$total43_12=0;
   
   for ($i=0; $i<count($tableau43); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData43) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  /*echo $tableau43[$k]['groupe'];*/
		   echo '</td><td>';
		  echo $tableau43[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=43&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau43[$k]['sex_id']."& interval=<1 an\">".$tableau43[$k]['<1 an']."</a>";
		 $total43_0=$total43_0+$tableau43[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=43&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau43[$k]['sex_id']."& interval=1-4 ans\">".$tableau43[$k]['1-4 ans']."</a>";
		  $total43_1=$total43_1+$tableau43[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=43&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau43[$k]['sex_id']."& interval=5-9 ans\">".$tableau43[$k]['5-9 ans']."</a>";
		  $total43_2=$total43_2+$tableau43[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=43&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau43[$k]['sex_id']."& interval=10-14 ans\">".$tableau43[$k]['10-14 ans']."</a>";
		  $total43_3=$total43_3+$tableau43[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=43&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau43[$k]['sex_id']."& interval=15-19 ans\">".$tableau43[$k]['15-19 ans']."</a>";
		  $total43_4=$total43_4+$tableau43[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=43&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau43[$k]['sex_id']."& interval=20-24 ans\">".$tableau43[$k]['20-24 ans']."</a>";
		  $total43_5=$total43_5+$tableau43[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=43&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau43[$k]['sex_id']."& interval=25-29 ans\">".$tableau43[$k]['25-29 ans']."</a>";
		  $total43_6=$total43_6+$tableau43[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=43&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau43[$k]['sex_id']."& interval=30-34 ans\">".$tableau43[$k]['30-34 ans']."</a>";
		  $total43_7=$total43_7+$tableau43[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=43&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau43[$k]['sex_id']."& interval=35-39 ans\">".$tableau43[$k]['35-39 ans']."</a>";
		  $total43_8=$total43_8+$tableau43[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=43&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau43[$k]['sex_id']."& interval=40-44 ans\">".$tableau43[$k]['40-44 ans']."</a>";
		  $total43_9=$total43_9+$tableau43[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=43&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau43[$k]['sex_id']."& interval=45-49 ans\">".$tableau43[$k]['45-49 ans']."</a>";
		  $total43_10=$total43_10+$tableau43[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=43&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau43[$k]['sex_id']."& interval=50 ans et plus\">".$tableau43[$k]['50 ans et plus']."</a>";
		  $total43_11=$total43_11+$tableau43[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=43&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau43[$k]['sex_id']."& interval=inconnu\">".$tableau43[$k]['âge inconnu']."</a>";
		  $total43_12=$total43_12+$tableau43[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total43_0.'</td>
			<td>'.$total43_1.'</td>
			<td>'.$total43_2.'</td>
			<td>'.$total43_3.'</td>
			<td>'.$total43_4.'</td>
			<td>'.$total43_5.'</td>
			<td>'.$total43_6.'</td>
			<td>'.$total43_7.'</td>
			<td>'.$total43_8.'</td>
			<td>'.$total43_9.'</td>
			<td>'.$total43_10.'</td>
			<td>'.$total43_11.'</td>
			<td>'.$total43_12.'</td>
			</tr>';
echo '</table>';
}
echo '<div>&nbsp;</div>';

/*16.4. Nombre de patients perdus de vue transférés CONFIRMES */

if ($NbreData44 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de patients perdus de vue transférés CONFIRMES</b></caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total44_0=0;
			$total44_1=0;
			$total44_2=0;
			$total44_3=0;
			$total44_4=0;
			$total44_5=0;
			$total44_6=0;
			$total44_7=0;
			$total44_8=0;
			$total44_9=0;
			$total44_10=0;
			$total44_11=0;
			$total44_12=0;
   
   for ($i=0; $i<count($tableau44); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData44) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  /*echo $tableau44[$k]['groupe'];*/
		   echo '</td><td>';
		  echo $tableau44[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=44&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau44[$k]['sex_id']."& interval=<1 an\">".$tableau44[$k]['<1 an']."</a>";
		 $total44_0=$total44_0+$tableau44[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=44&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau44[$k]['sex_id']."& interval=1-4 ans\">".$tableau44[$k]['1-4 ans']."</a>";
		  $total44_1=$total44_1+$tableau44[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=44&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau44[$k]['sex_id']."& interval=5-9 ans\">".$tableau44[$k]['5-9 ans']."</a>";
		  $total44_2=$total44_2+$tableau44[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=44&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau44[$k]['sex_id']."& interval=10-14 ans\">".$tableau44[$k]['10-14 ans']."</a>";
		  $total44_3=$total44_3+$tableau44[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=44&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau44[$k]['sex_id']."& interval=15-19 ans\">".$tableau44[$k]['15-19 ans']."</a>";
		  $total44_4=$total44_4+$tableau44[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=44&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau44[$k]['sex_id']."& interval=20-24 ans\">".$tableau44[$k]['20-24 ans']."</a>";
		  $total44_5=$total44_5+$tableau44[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=44&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau44[$k]['sex_id']."& interval=25-29 ans\">".$tableau44[$k]['25-29 ans']."</a>";
		  $total44_6=$total44_6+$tableau44[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=44&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau44[$k]['sex_id']."& interval=30-34 ans\">".$tableau44[$k]['30-34 ans']."</a>";
		  $total44_7=$total44_7+$tableau44[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=44&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau44[$k]['sex_id']."& interval=35-39 ans\">".$tableau44[$k]['35-39 ans']."</a>";
		  $total44_8=$total44_8+$tableau44[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=44&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau44[$k]['sex_id']."& interval=40-44 ans\">".$tableau44[$k]['40-44 ans']."</a>";
		  $total44_9=$total44_9+$tableau44[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=44&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau44[$k]['sex_id']."& interval=45-49 ans\">".$tableau44[$k]['45-49 ans']."</a>";
		  $total44_10=$total44_10+$tableau44[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=44&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau44[$k]['sex_id']."& interval=50 ans et plus\">".$tableau44[$k]['50 ans et plus']."</a>";
		  $total44_11=$total44_11+$tableau44[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=44&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau44[$k]['sex_id']."& interval=inconnu\">".$tableau44[$k]['âge inconnu']."</a>";
		  $total44_12=$total44_12+$tableau44[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total44_0.'</td>
			<td>'.$total44_1.'</td>
			<td>'.$total44_2.'</td>
			<td>'.$total44_3.'</td>
			<td>'.$total44_4.'</td>
			<td>'.$total44_5.'</td>
			<td>'.$total44_6.'</td>
			<td>'.$total44_7.'</td>
			<td>'.$total44_8.'</td>
			<td>'.$total44_9.'</td>
			<td>'.$total44_10.'</td>
			<td>'.$total44_11.'</td>
			<td>'.$total44_12.'</td>
			</tr>';
echo '</table>';
}
echo '<div>&nbsp;</div>';
/*16.5. Nombre de patients perdus de vue contactés et confirmés avoir arreté le traitement ARV*/
if ($NbreData45 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de patients perdus de vue contactés et confirmés avoir arreté le traitement ARV</b></caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total45_0=0;
			$total45_1=0;
			$total45_2=0;
			$total45_3=0;
			$total45_4=0;
			$total45_5=0;
			$total45_6=0;
			$total45_7=0;
			$total45_8=0;
			$total45_9=0;
			$total45_10=0;
			$total45_11=0;
			$total45_12=0;
   
   for ($i=0; $i<count($tableau45); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData45) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  /*echo $tableau45[$k]['groupe'];*/
		   echo '</td><td>';
		  echo $tableau45[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=45&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau45[$k]['sex_id']."& interval=<1 an\">".$tableau45[$k]['<1 an']."</a>";
		 $total45_0=$total45_0+$tableau45[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=45&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau45[$k]['sex_id']."& interval=1-4 ans\">".$tableau45[$k]['1-4 ans']."</a>";
		  $total45_1=$total45_1+$tableau45[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=45&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau45[$k]['sex_id']."& interval=5-9 ans\">".$tableau45[$k]['5-9 ans']."</a>";
		  $total45_2=$total45_2+$tableau45[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=45&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau45[$k]['sex_id']."& interval=10-14 ans\">".$tableau45[$k]['10-14 ans']."</a>";
		  $total45_3=$total45_3+$tableau45[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=45&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau45[$k]['sex_id']."& interval=15-19 ans\">".$tableau45[$k]['15-19 ans']."</a>";
		  $total45_4=$total45_4+$tableau45[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=45&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau45[$k]['sex_id']."& interval=20-24 ans\">".$tableau45[$k]['20-24 ans']."</a>";
		  $total45_5=$total45_5+$tableau45[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=45&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau45[$k]['sex_id']."& interval=25-29 ans\">".$tableau45[$k]['25-29 ans']."</a>";
		  $total45_6=$total45_6+$tableau45[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=45&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau45[$k]['sex_id']."& interval=30-34 ans\">".$tableau45[$k]['30-34 ans']."</a>";
		  $total45_7=$total45_7+$tableau45[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=45&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau45[$k]['sex_id']."& interval=35-39 ans\">".$tableau45[$k]['35-39 ans']."</a>";
		  $total45_8=$total45_8+$tableau45[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=45&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau45[$k]['sex_id']."& interval=40-44 ans\">".$tableau45[$k]['40-44 ans']."</a>";
		  $total45_9=$total45_9+$tableau45[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=45&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau45[$k]['sex_id']."& interval=45-49 ans\">".$tableau45[$k]['45-49 ans']."</a>";
		  $total45_10=$total45_10+$tableau45[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=45&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau45[$k]['sex_id']."& interval=50 ans et plus\">".$tableau45[$k]['50 ans et plus']."</a>";
		  $total45_11=$total45_11+$tableau45[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=45&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau45[$k]['sex_id']."& interval=inconnu\">".$tableau45[$k]['âge inconnu']."</a>";
		  $total45_12=$total45_12+$tableau45[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total45_0.'</td>
			<td>'.$total45_1.'</td>
			<td>'.$total45_2.'</td>
			<td>'.$total45_3.'</td>
			<td>'.$total45_4.'</td>
			<td>'.$total45_5.'</td>
			<td>'.$total45_6.'</td>
			<td>'.$total45_7.'</td>
			<td>'.$total45_8.'</td>
			<td>'.$total45_9.'</td>
			<td>'.$total45_10.'</td>
			<td>'.$total45_11.'</td>
			<td>'.$total45_12.'</td>
			</tr>';
echo '</table>';
}
echo '<div>&nbsp;</div>';
/*16.1.1 Nombre de décès CONFIRMES lies a la Tuberculose parmi les 
perdus de vue recherches au cours du mois du rapport*/

if ($NbreData46 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de décès CONFIRMES lies a la Tuberculose parmi les 
perdus de vue recherches au cours du mois du rapport</b></caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total46_0=0;
			$total46_1=0;
			$total46_2=0;
			$total46_3=0;
			$total46_4=0;
			$total46_5=0;
			$total46_6=0;
			$total46_7=0;
			$total46_8=0;
			$total46_9=0;
			$total46_10=0;
			$total46_11=0;
			$total46_12=0;
   
   for ($i=0; $i<count($tableau46); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData46) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  /*echo $tableau46[$k]['groupe'];*/
		   echo '</td><td>';
		  echo $tableau46[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=46&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau46[$k]['sex_id']."& interval=<1 an\">".$tableau46[$k]['<1 an']."</a>";
		 $total46_0=$total46_0+$tableau46[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=46&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau46[$k]['sex_id']."& interval=1-4 ans\">".$tableau46[$k]['1-4 ans']."</a>";
		  $total46_1=$total46_1+$tableau46[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=46&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau46[$k]['sex_id']."& interval=5-9 ans\">".$tableau46[$k]['5-9 ans']."</a>";
		  $total46_2=$total46_2+$tableau46[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=46&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau46[$k]['sex_id']."& interval=10-14 ans\">".$tableau46[$k]['10-14 ans']."</a>";
		  $total46_3=$total46_3+$tableau46[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=46&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau46[$k]['sex_id']."& interval=15-19 ans\">".$tableau46[$k]['15-19 ans']."</a>";
		  $total46_4=$total46_4+$tableau46[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=46&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau46[$k]['sex_id']."& interval=20-24 ans\">".$tableau46[$k]['20-24 ans']."</a>";
		  $total46_5=$total46_5+$tableau46[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=46&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau46[$k]['sex_id']."& interval=25-29 ans\">".$tableau46[$k]['25-29 ans']."</a>";
		  $total46_6=$total46_6+$tableau46[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=46&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau46[$k]['sex_id']."& interval=30-34 ans\">".$tableau46[$k]['30-34 ans']."</a>";
		  $total46_7=$total46_7+$tableau46[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=46&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau46[$k]['sex_id']."& interval=35-39 ans\">".$tableau46[$k]['35-39 ans']."</a>";
		  $total46_8=$total46_8+$tableau46[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=46&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau46[$k]['sex_id']."& interval=40-44 ans\">".$tableau46[$k]['40-44 ans']."</a>";
		  $total46_9=$total46_9+$tableau46[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=46&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau46[$k]['sex_id']."& interval=45-49 ans\">".$tableau46[$k]['45-49 ans']."</a>";
		  $total46_10=$total46_10+$tableau46[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=46&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau46[$k]['sex_id']."& interval=50 ans et plus\">".$tableau46[$k]['50 ans et plus']."</a>";
		  $total46_11=$total46_11+$tableau46[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=46&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau46[$k]['sex_id']."& interval=inconnu\">".$tableau46[$k]['âge inconnu']."</a>";
		  $total46_12=$total46_12+$tableau46[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total46_0.'</td>
			<td>'.$total46_1.'</td>
			<td>'.$total46_2.'</td>
			<td>'.$total46_3.'</td>
			<td>'.$total46_4.'</td>
			<td>'.$total46_5.'</td>
			<td>'.$total46_6.'</td>
			<td>'.$total46_7.'</td>
			<td>'.$total46_8.'</td>
			<td>'.$total46_9.'</td>
			<td>'.$total46_10.'</td>
			<td>'.$total46_11.'</td>
			<td>'.$total46_12.'</td>
		</tr>';
echo '</table>';
}
echo '<div>&nbsp;</div>';

/*16.1.2 Nombre de décès CONFIRMES lies a d'autres maladies infectieuses et parasitaires  
parmi les perdus de vue recherches au cours du mois du rapport*/
if ($NbreData47 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de décès CONFIRMES liés a d\'autres maladies infectieuses et parasitaires 
parmi les perdus de vue recherches au cours du mois du rapport</b></caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total47_0=0;
			$total47_1=0;
			$total47_2=0;
			$total47_3=0;
			$total47_4=0;
			$total47_5=0;
			$total47_6=0;
			$total47_7=0;
			$total47_8=0;
			$total47_9=0;
			$total47_10=0;
			$total47_11=0;
			$total47_12=0;
   
   for ($i=0; $i<count($tableau47); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData47) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  /*echo $tableau47[$k]['groupe'];*/
		   echo '</td><td>';
		  echo $tableau47[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=47&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau47[$k]['sex_id']."& interval=<1 an\">".$tableau47[$k]['<1 an']."</a>";
		 $total47_0=$total47_0+$tableau47[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=47&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau47[$k]['sex_id']."& interval=1-4 ans\">".$tableau47[$k]['1-4 ans']."</a>";
		  $total47_1=$total47_1+$tableau47[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=47&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau47[$k]['sex_id']."& interval=5-9 ans\">".$tableau47[$k]['5-9 ans']."</a>";
		  $total47_2=$total47_2+$tableau47[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=47&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau47[$k]['sex_id']."& interval=10-14 ans\">".$tableau47[$k]['10-14 ans']."</a>";
		  $total47_3=$total47_3+$tableau47[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=47&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau47[$k]['sex_id']."& interval=15-19 ans\">".$tableau47[$k]['15-19 ans']."</a>";
		  $total47_4=$total47_4+$tableau47[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=47&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau47[$k]['sex_id']."& interval=20-24 ans\">".$tableau47[$k]['20-24 ans']."</a>";
		  $total47_5=$total47_5+$tableau47[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=47&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau47[$k]['sex_id']."& interval=25-29 ans\">".$tableau47[$k]['25-29 ans']."</a>";
		  $total47_6=$total47_6+$tableau47[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=47&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau47[$k]['sex_id']."& interval=30-34 ans\">".$tableau47[$k]['30-34 ans']."</a>";
		  $total47_7=$total47_7+$tableau47[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=47&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau47[$k]['sex_id']."& interval=35-39 ans\">".$tableau47[$k]['35-39 ans']."</a>";
		  $total47_8=$total47_8+$tableau47[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=47&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau47[$k]['sex_id']."& interval=40-44 ans\">".$tableau47[$k]['40-44 ans']."</a>";
		  $total47_9=$total47_9+$tableau47[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=47&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau47[$k]['sex_id']."& interval=45-49 ans\">".$tableau47[$k]['45-49 ans']."</a>";
		  $total47_10=$total47_10+$tableau47[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=47&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau47[$k]['sex_id']."& interval=50 ans et plus\">".$tableau47[$k]['50 ans et plus']."</a>";
		  $total47_11=$total47_11+$tableau47[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=47&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau47[$k]['sex_id']."& interval=inconnu\">".$tableau47[$k]['âge inconnu']."</a>";
		  $total47_12=$total47_12+$tableau47[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total47_0.'</td>
			<td>'.$total47_1.'</td>
			<td>'.$total47_2.'</td>
			<td>'.$total47_3.'</td>
			<td>'.$total47_4.'</td>
			<td>'.$total47_5.'</td>
			<td>'.$total47_6.'</td>
			<td>'.$total47_7.'</td>
			<td>'.$total47_8.'</td>
			<td>'.$total47_9.'</td>
			<td>'.$total47_10.'</td>
			<td>'.$total47_11.'</td>
			<td>'.$total47_12.'</td>
		</tr>';
echo '</table>';
}
echo '<div>&nbsp;</div>';

/*16.1.3 Nombre de décès CONFIRMES dus a des causes de cancer connu 
ou présumé parmi les perdus de vue recherches au cours du mois*/

if ($NbreData48 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de décès CONFIRMES dus a des causes de cancer connu 
ou présumé parmi les perdus de vue recherches au cours du mois</b></caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total48_0=0;
			$total48_1=0;
			$total48_2=0;
			$total48_3=0;
			$total48_4=0;
			$total48_5=0;
			$total48_6=0;
			$total48_7=0;
			$total48_8=0;
			$total48_9=0;
			$total48_10=0;
			$total48_11=0;
			$total48_12=0;
   
   for ($i=0; $i<count($tableau48); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData48) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  /*echo $tableau48[$k]['groupe'];*/
		   echo '</td><td>';
		  echo $tableau48[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=48&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau48[$k]['sex_id']."& interval=<1 an\">".$tableau48[$k]['<1 an']."</a>";
		 $total48_0=$total48_0+$tableau48[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=48&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau48[$k]['sex_id']."& interval=1-4 ans\">".$tableau48[$k]['1-4 ans']."</a>";
		  $total48_1=$total48_1+$tableau48[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=48&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau48[$k]['sex_id']."& interval=5-9 ans\">".$tableau48[$k]['5-9 ans']."</a>";
		  $total48_2=$total48_2+$tableau48[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=48&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau48[$k]['sex_id']."& interval=10-14 ans\">".$tableau48[$k]['10-14 ans']."</a>";
		  $total48_3=$total48_3+$tableau48[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=48&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau48[$k]['sex_id']."& interval=15-19 ans\">".$tableau48[$k]['15-19 ans']."</a>";
		  $total48_4=$total48_4+$tableau48[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=48&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau48[$k]['sex_id']."& interval=20-24 ans\">".$tableau48[$k]['20-24 ans']."</a>";
		  $total48_5=$total48_5+$tableau48[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=48&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau48[$k]['sex_id']."& interval=25-29 ans\">".$tableau48[$k]['25-29 ans']."</a>";
		  $total48_6=$total48_6+$tableau48[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=48&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau48[$k]['sex_id']."& interval=30-34 ans\">".$tableau48[$k]['30-34 ans']."</a>";
		  $total48_7=$total48_7+$tableau48[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=48&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau48[$k]['sex_id']."& interval=35-39 ans\">".$tableau48[$k]['35-39 ans']."</a>";
		  $total48_8=$total48_8+$tableau48[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=48&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau48[$k]['sex_id']."& interval=40-44 ans\">".$tableau48[$k]['40-44 ans']."</a>";
		  $total48_9=$total48_9+$tableau48[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=48&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau48[$k]['sex_id']."& interval=45-49 ans\">".$tableau48[$k]['45-49 ans']."</a>";
		  $total48_10=$total48_10+$tableau48[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=48&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau48[$k]['sex_id']."& interval=50 ans et plus\">".$tableau48[$k]['50 ans et plus']."</a>";
		  $total48_11=$total48_11+$tableau48[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=48&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau48[$k]['sex_id']."& interval=inconnu\">".$tableau48[$k]['âge inconnu']."</a>";
		  $total48_12=$total48_12+$tableau48[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total48_0.'</td>
			<td>'.$total48_1.'</td>
			<td>'.$total48_2.'</td>
			<td>'.$total48_3.'</td>
			<td>'.$total48_4.'</td>
			<td>'.$total48_5.'</td>
			<td>'.$total48_6.'</td>
			<td>'.$total48_7.'</td>
			<td>'.$total48_8.'</td>
			<td>'.$total48_9.'</td>
			<td>'.$total48_10.'</td>
			<td>'.$total48_11.'</td>
			<td>'.$total48_12.'</td>
		</tr>';
echo '</table>';
}
echo '<div>&nbsp;</div>';

/*16.1.4 Nombre de décès CONFIRMES dus a d'autres maladies liees au VIH  
parmi les perdus de vue recherches*/
if ($NbreData49 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de décès CONFIRMES dus a d\'autres maladies liees au VIH  
parmi les perdus de vue recherches</b></caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total49_0=0;
			$total49_1=0;
			$total49_2=0;
			$total49_3=0;
			$total49_4=0;
			$total49_5=0;
			$total49_6=0;
			$total49_7=0;
			$total49_8=0;
			$total49_9=0;
			$total49_10=0;
			$total49_11=0;
			$total49_12=0;
   
   for ($i=0; $i<count($tableau49); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData49) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  /*echo $tableau49[$k]['groupe'];*/
		   echo '</td><td>';
		  echo $tableau49[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=49&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau49[$k]['sex_id']."& interval=<1 an\">".$tableau49[$k]['<1 an']."</a>";
		 $total49_0=$total49_0+$tableau49[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=49&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau49[$k]['sex_id']."& interval=1-4 ans\">".$tableau49[$k]['1-4 ans']."</a>";
		  $total49_1=$total49_1+$tableau49[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=49&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau49[$k]['sex_id']."& interval=5-9 ans\">".$tableau49[$k]['5-9 ans']."</a>";
		  $total49_2=$total49_2+$tableau49[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=49&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau49[$k]['sex_id']."& interval=10-14 ans\">".$tableau49[$k]['10-14 ans']."</a>";
		  $total49_3=$total49_3+$tableau49[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=49&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau49[$k]['sex_id']."& interval=15-19 ans\">".$tableau49[$k]['15-19 ans']."</a>";
		  $total49_4=$total49_4+$tableau49[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=49&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau49[$k]['sex_id']."& interval=20-24 ans\">".$tableau49[$k]['20-24 ans']."</a>";
		  $total49_5=$total49_5+$tableau49[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=49&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau49[$k]['sex_id']."& interval=25-29 ans\">".$tableau49[$k]['25-29 ans']."</a>";
		  $total49_6=$total49_6+$tableau49[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=49&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau49[$k]['sex_id']."& interval=30-34 ans\">".$tableau49[$k]['30-34 ans']."</a>";
		  $total49_7=$total49_7+$tableau49[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=49&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau49[$k]['sex_id']."& interval=35-39 ans\">".$tableau49[$k]['35-39 ans']."</a>";
		  $total49_8=$total49_8+$tableau49[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=49&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau49[$k]['sex_id']."& interval=40-44 ans\">".$tableau49[$k]['40-44 ans']."</a>";
		  $total49_9=$total49_9+$tableau49[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=49&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau49[$k]['sex_id']."& interval=45-49 ans\">".$tableau49[$k]['45-49 ans']."</a>";
		  $total49_10=$total49_10+$tableau49[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=49&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau49[$k]['sex_id']."& interval=50 ans et plus\">".$tableau49[$k]['50 ans et plus']."</a>";
		  $total49_11=$total49_11+$tableau49[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=49&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau49[$k]['sex_id']."& interval=inconnu\">".$tableau49[$k]['âge inconnu']."</a>";
		  $total49_12=$total49_12+$tableau49[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total49_0.'</td>
			<td>'.$total49_1.'</td>
			<td>'.$total49_2.'</td>
			<td>'.$total49_3.'</td>
			<td>'.$total49_4.'</td>
			<td>'.$total49_5.'</td>
			<td>'.$total49_6.'</td>
			<td>'.$total49_7.'</td>
			<td>'.$total49_8.'</td>
			<td>'.$total49_9.'</td>
			<td>'.$total49_10.'</td>
			<td>'.$total49_11.'</td>
			<td>'.$total49_12.'</td>
		</tr>';
echo '</table>';
}
echo '<div>&nbsp;</div>';

/*16.1.5 Nombre de décès  parmi les perdus de vue lies a des causes naturelles 
( cancers et infections, qui n'étaient pas directement liées à l'infection à VIH).*/
	if ($NbreData50 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de décès  parmi les perdus de vue lies a des causes naturelles 
(cancers et infections, qui n\'étaient pas directement liées à l\'infection à VIH)</b></caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total50_0=0;
			$total50_1=0;
			$total50_2=0;
			$total50_3=0;
			$total50_4=0;
			$total50_5=0;
			$total50_6=0;
			$total50_7=0;
			$total50_8=0;
			$total50_9=0;
			$total50_10=0;
			$total50_11=0;
			$total50_12=0;
   
   for ($i=0; $i<count($tableau50); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData50) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  /*echo $tableau50[$k]['groupe'];*/
		   echo '</td><td>';
		  echo $tableau50[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=50&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau50[$k]['sex_id']."& interval=<1 an\">".$tableau50[$k]['<1 an']."</a>";
		 $total50_0=$total50_0+$tableau50[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=50&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau50[$k]['sex_id']."& interval=1-4 ans\">".$tableau50[$k]['1-4 ans']."</a>";
		  $total50_1=$total50_1+$tableau50[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=50&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau50[$k]['sex_id']."& interval=5-9 ans\">".$tableau50[$k]['5-9 ans']."</a>";
		  $total50_2=$total50_2+$tableau50[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=50&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau50[$k]['sex_id']."& interval=10-14 ans\">".$tableau50[$k]['10-14 ans']."</a>";
		  $total50_3=$total50_3+$tableau50[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=50&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau50[$k]['sex_id']."& interval=15-19 ans\">".$tableau50[$k]['15-19 ans']."</a>";
		  $total50_4=$total50_4+$tableau50[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=50&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau50[$k]['sex_id']."& interval=20-24 ans\">".$tableau50[$k]['20-24 ans']."</a>";
		  $total50_5=$total50_5+$tableau50[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=50&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau50[$k]['sex_id']."& interval=25-29 ans\">".$tableau50[$k]['25-29 ans']."</a>";
		  $total50_6=$total50_6+$tableau50[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=50&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau50[$k]['sex_id']."& interval=30-34 ans\">".$tableau50[$k]['30-34 ans']."</a>";
		  $total50_7=$total50_7+$tableau50[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=50&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau50[$k]['sex_id']."& interval=35-39 ans\">".$tableau50[$k]['35-39 ans']."</a>";
		  $total50_8=$total50_8+$tableau50[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=50&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau50[$k]['sex_id']."& interval=40-44 ans\">".$tableau50[$k]['40-44 ans']."</a>";
		  $total50_9=$total50_9+$tableau50[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=50&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau50[$k]['sex_id']."& interval=45-49 ans\">".$tableau50[$k]['45-49 ans']."</a>";
		  $total50_10=$total50_10+$tableau50[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=50&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau50[$k]['sex_id']."& interval=50 ans et plus\">".$tableau50[$k]['50 ans et plus']."</a>";
		  $total50_11=$total50_11+$tableau50[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=50&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau50[$k]['sex_id']."& interval=inconnu\">".$tableau50[$k]['âge inconnu']."</a>";
		  $total50_12=$total50_12+$tableau50[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total50_0.'</td>
			<td>'.$total50_1.'</td>
			<td>'.$total50_2.'</td>
			<td>'.$total50_3.'</td>
			<td>'.$total50_4.'</td>
			<td>'.$total50_5.'</td>
			<td>'.$total50_6.'</td>
			<td>'.$total50_7.'</td>
			<td>'.$total50_8.'</td>
			<td>'.$total50_9.'</td>
			<td>'.$total50_10.'</td>
			<td>'.$total50_11.'</td>
			<td>'.$total50_12.'</td>
		</tr>';
echo '</table>';
}
echo '<div>&nbsp;</div>';
/*16.1.6 Nombre de décès  parmi les perdus de vue lies a des causes non naturelles 
( traumatisme, accident, suicide, guerre, etc.)*/
	if ($NbreData51 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b> Nombre de décès  parmi les perdus de vue lies a des causes non naturelles 
( traumatisme, accident, suicide, guerre, etc.)</b></caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total51_0=0;
			$total51_1=0;
			$total51_2=0;
			$total51_3=0;
			$total51_4=0;
			$total51_5=0;
			$total51_6=0;
			$total51_7=0;
			$total51_8=0;
			$total51_9=0;
			$total51_10=0;
			$total51_11=0;
			$total51_12=0;
   
   for ($i=0; $i<count($tableau51); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData51) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  /*echo $tableau51[$k]['groupe'];*/
		   echo '</td><td>';
		  echo $tableau51[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=51&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau51[$k]['sex_id']."& interval=<1 an\">".$tableau51[$k]['<1 an']."</a>";
		 $total51_0=$total51_0+$tableau51[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=51&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau51[$k]['sex_id']."& interval=1-4 ans\">".$tableau51[$k]['1-4 ans']."</a>";
		  $total51_1=$total51_1+$tableau51[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=51&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau51[$k]['sex_id']."& interval=5-9 ans\">".$tableau51[$k]['5-9 ans']."</a>";
		  $total51_2=$total51_2+$tableau51[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=51&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau51[$k]['sex_id']."& interval=10-14 ans\">".$tableau51[$k]['10-14 ans']."</a>";
		  $total51_3=$total51_3+$tableau51[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=51&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau51[$k]['sex_id']."& interval=15-19 ans\">".$tableau51[$k]['15-19 ans']."</a>";
		  $total51_4=$total51_4+$tableau51[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=51&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau51[$k]['sex_id']."& interval=20-24 ans\">".$tableau51[$k]['20-24 ans']."</a>";
		  $total51_5=$total51_5+$tableau51[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=51&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau51[$k]['sex_id']."& interval=25-29 ans\">".$tableau51[$k]['25-29 ans']."</a>";
		  $total51_6=$total51_6+$tableau51[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=51&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau51[$k]['sex_id']."& interval=30-34 ans\">".$tableau51[$k]['30-34 ans']."</a>";
		  $total51_7=$total51_7+$tableau51[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=51&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau51[$k]['sex_id']."& interval=35-39 ans\">".$tableau51[$k]['35-39 ans']."</a>";
		  $total51_8=$total51_8+$tableau51[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=51&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau51[$k]['sex_id']."& interval=40-44 ans\">".$tableau51[$k]['40-44 ans']."</a>";
		  $total51_9=$total51_9+$tableau51[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=51&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau51[$k]['sex_id']."& interval=45-49 ans\">".$tableau51[$k]['45-49 ans']."</a>";
		  $total51_10=$total51_10+$tableau51[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=51&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau51[$k]['sex_id']."& interval=50 ans et plus\">".$tableau51[$k]['50 ans et plus']."</a>";
		  $total51_11=$total51_11+$tableau51[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=51&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau51[$k]['sex_id']."& interval=inconnu\">".$tableau51[$k]['âge inconnu']."</a>";
		  $total51_12=$total51_12+$tableau51[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total51_0.'</td>
			<td>'.$total51_1.'</td>
			<td>'.$total51_2.'</td>
			<td>'.$total51_3.'</td>
			<td>'.$total51_4.'</td>
			<td>'.$total51_5.'</td>
			<td>'.$total51_6.'</td>
			<td>'.$total51_7.'</td>
			<td>'.$total51_8.'</td>
			<td>'.$total51_9.'</td>
			<td>'.$total51_10.'</td>
			<td>'.$total51_11.'</td>
			<td>'.$total51_12.'</td>
		</tr>';
echo '</table>';
}
echo '<div>&nbsp;</div>';

/*16.1.7 Nombre de décès  parmi les perdus de vue lies a des causes inconnues*/

	if ($NbreData52 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de décès  parmi les perdus de vue lies a des causes inconnues</b></caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total52_0=0;
			$total52_1=0;
			$total52_2=0;
			$total52_3=0;
			$total52_4=0;
			$total52_5=0;
			$total52_6=0;
			$total52_7=0;
			$total52_8=0;
			$total52_9=0;
			$total52_10=0;
			$total52_11=0;
			$total52_12=0;
   
   for ($i=0; $i<count($tableau52); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData52) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  /*echo $tableau52[$k]['groupe'];*/
		   echo '</td><td>';
		  echo $tableau52[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=52&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau52[$k]['sex_id']."& interval=<1 an\">".$tableau52[$k]['<1 an']."</a>";
		 $total52_0=$total52_0+$tableau52[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=52&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau52[$k]['sex_id']."& interval=1-4 ans\">".$tableau52[$k]['1-4 ans']."</a>";
		  $total52_1=$total52_1+$tableau52[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=52&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau52[$k]['sex_id']."& interval=5-9 ans\">".$tableau52[$k]['5-9 ans']."</a>";
		  $total52_2=$total52_2+$tableau52[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=52&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau52[$k]['sex_id']."& interval=10-14 ans\">".$tableau52[$k]['10-14 ans']."</a>";
		  $total52_3=$total52_3+$tableau52[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=52&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau52[$k]['sex_id']."& interval=15-19 ans\">".$tableau52[$k]['15-19 ans']."</a>";
		  $total52_4=$total52_4+$tableau52[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=52&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau52[$k]['sex_id']."& interval=20-24 ans\">".$tableau52[$k]['20-24 ans']."</a>";
		  $total52_5=$total52_5+$tableau52[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=52&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau52[$k]['sex_id']."& interval=25-29 ans\">".$tableau52[$k]['25-29 ans']."</a>";
		  $total52_6=$total52_6+$tableau52[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=52&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau52[$k]['sex_id']."& interval=30-34 ans\">".$tableau52[$k]['30-34 ans']."</a>";
		  $total52_7=$total52_7+$tableau52[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=52&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau52[$k]['sex_id']."& interval=35-39 ans\">".$tableau52[$k]['35-39 ans']."</a>";
		  $total52_8=$total52_8+$tableau52[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=52&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau52[$k]['sex_id']."& interval=40-44 ans\">".$tableau52[$k]['40-44 ans']."</a>";
		  $total52_9=$total52_9+$tableau52[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=52&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau52[$k]['sex_id']."& interval=45-49 ans\">".$tableau52[$k]['45-49 ans']."</a>";
		  $total52_10=$total52_10+$tableau52[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=52&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau52[$k]['sex_id']."& interval=50 ans et plus\">".$tableau52[$k]['50 ans et plus']."</a>";
		  $total52_11=$total52_11+$tableau52[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=52&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau52[$k]['sex_id']."& interval=inconnu\">".$tableau52[$k]['âge inconnu']."</a>";
		  $total52_12=$total52_12+$tableau52[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total52_0.'</td>
			<td>'.$total52_1.'</td>
			<td>'.$total52_2.'</td>
			<td>'.$total52_3.'</td>
			<td>'.$total52_4.'</td>
			<td>'.$total52_5.'</td>
			<td>'.$total52_6.'</td>
			<td>'.$total52_7.'</td>
			<td>'.$total52_8.'</td>
			<td>'.$total52_9.'</td>
			<td>'.$total52_10.'</td>
			<td>'.$total52_11.'</td>
			<td>'.$total52_12.'</td>
		</tr>';
echo '</table>';
}
echo '<div>&nbsp;</div>';

/*17.1 Nombre de patients perdus de vue ayant repris le traitement ARV au cours du mois (TX-RTT)*/
	if ($NbreData53 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de patients perdus de vue ayant repris le traitement ARV au cours du mois (TX-RTT)</b></caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total53_0=0;
			$total53_1=0;
			$total53_2=0;
			$total53_3=0;
			$total53_4=0;
			$total53_5=0;
			$total53_6=0;
			$total53_7=0;
			$total53_8=0;
			$total53_9=0;
			$total53_10=0;
			$total53_11=0;
			$total53_12=0;
   
   for ($i=0; $i<count($tableau53); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData53) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  /*echo $tableau53[$k]['groupe'];*/
		   echo '</td><td>';
		  echo $tableau53[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=53&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau53[$k]['sex_id']."& interval=<1 an\">".$tableau53[$k]['<1 an']."</a>";
		 $total53_0=$total53_0+$tableau53[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=53&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau53[$k]['sex_id']."& interval=1-4 ans\">".$tableau53[$k]['1-4 ans']."</a>";
		  $total53_1=$total53_1+$tableau53[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=53&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau53[$k]['sex_id']."& interval=5-9 ans\">".$tableau53[$k]['5-9 ans']."</a>";
		  $total53_2=$total53_2+$tableau53[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=53&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau53[$k]['sex_id']."& interval=10-14 ans\">".$tableau53[$k]['10-14 ans']."</a>";
		  $total53_3=$total53_3+$tableau53[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=53&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau53[$k]['sex_id']."& interval=15-19 ans\">".$tableau53[$k]['15-19 ans']."</a>";
		  $total53_4=$total53_4+$tableau53[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=53&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau53[$k]['sex_id']."& interval=20-24 ans\">".$tableau53[$k]['20-24 ans']."</a>";
		  $total53_5=$total53_5+$tableau53[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=53&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau53[$k]['sex_id']."& interval=25-29 ans\">".$tableau53[$k]['25-29 ans']."</a>";
		  $total53_6=$total53_6+$tableau53[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=53&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau53[$k]['sex_id']."& interval=30-34 ans\">".$tableau53[$k]['30-34 ans']."</a>";
		  $total53_7=$total53_7+$tableau53[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=53&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau53[$k]['sex_id']."& interval=35-39 ans\">".$tableau53[$k]['35-39 ans']."</a>";
		  $total53_8=$total53_8+$tableau53[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=53&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau53[$k]['sex_id']."& interval=40-44 ans\">".$tableau53[$k]['40-44 ans']."</a>";
		  $total53_9=$total53_9+$tableau53[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=53&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau53[$k]['sex_id']."& interval=45-49 ans\">".$tableau53[$k]['45-49 ans']."</a>";
		  $total53_10=$total53_10+$tableau53[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=53&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau53[$k]['sex_id']."& interval=50 ans et plus\">".$tableau53[$k]['50 ans et plus']."</a>";
		  $total53_11=$total53_11+$tableau53[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=53&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau53[$k]['sex_id']."& interval=inconnu\">".$tableau53[$k]['âge inconnu']."</a>";
		  $total53_12=$total53_12+$tableau53[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total53_0.'</td>
			<td>'.$total53_1.'</td>
			<td>'.$total53_2.'</td>
			<td>'.$total53_3.'</td>
			<td>'.$total53_4.'</td>
			<td>'.$total53_5.'</td>
			<td>'.$total53_6.'</td>
			<td>'.$total53_7.'</td>
			<td>'.$total53_8.'</td>
			<td>'.$total53_9.'</td>
			<td>'.$total53_10.'</td>
			<td>'.$total53_11.'</td>
			<td>'.$total53_12.'</td>
		</tr>';
echo '</table>';
}
echo '<div>&nbsp;</div>';
/*17.1 Nombre de populations clés perdus de vue ayant repris le traitement ARV au cours du mois*/
if ($NbreData54 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de populations clés perdus de vue ayant repris le traitement ARV au cours du mois</b></caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>HARSAH</th>
			<th>Professionnels de sexe</th>
			<th>Personnes transgenres</th>
			<th>Prisonniers</th>
			<th>Utilisateurs de drogues injectables</th>
			</tr></thead>';
			
			$total54_0=0;
			$total54_1=0;
			$total54_2=0;
			$total54_3=0;
			$total54_4=0;
   
   for ($i=0; $i<count($tableau54); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData54) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		/*  echo $tableau54[$k]['groupe'];
		*/
		   echo '</td><td>';
		   echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=54&cle=163593&startDate=".$startDate."&endDate=".$endDate."\">".$tableau54[$k]['HARSAH']."</a>";
		
		 $total54_0=$total54_0+$tableau54[$k]['HARSAH'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=54&cle=163594&startDate=".$startDate."&endDate=".$endDate."\">".$tableau54[$k]['Professionnels de sexe']."</a>";
		 
		  $total54_1=$total54_1+$tableau54[$k]['Professionnels de sexe'];
		 echo '</td><td>';
		echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=54&cle=163596&startDate=".$startDate."&endDate=".$endDate."\">".$tableau54[$k]['Personnes transgenres']."</a>";
		 
		  $total54_2=$total54_2+$tableau54[$k]['Personnes transgenres'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=54&cle=163595&startDate=".$startDate."&endDate=".$endDate."\">".$tableau54[$k]['Prisonniers']."</a>";
		
		  $total54_3=$total54_3+$tableau54[$k]['Prisonniers'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=54&cle=163597&startDate=".$startDate."&endDate=".$endDate."\">".$tableau54[$k]['Utilisateurs de drogues injectables']."</a>";
		  $total54_4=$total54_4+$tableau54[$k]['Utilisateurs de drogues injectables'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td>'.$total54_0.'</td>
			<td>'.$total54_1.'</td>
			<td>'.$total54_2.'</td>
			<td>'.$total54_3.'</td>
			<td>'.$total54_4.'</td>
			</tr>';
echo '</table>';
} 
echo '<div>&nbsp;</div>';

/* 18.1 Nombre de patients actifs sous ARV ayant au moins un resultat 
de charge virale au cours des 12 derniers mois: (TX_PVLS D routine) */

if ($NbreData55 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de patients actifs sous ARV ayant au moins un resultat 
de charge virale au cours des 12 derniers mois: (TX_PVLS D routine)</b></caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total55_0=0;
			$total55_1=0;
			$total55_2=0;
			$total55_3=0;
			$total55_4=0;
			$total55_5=0;
			$total55_6=0;
			$total55_7=0;
			$total55_8=0;
			$total55_9=0;
			$total55_10=0;
			$total55_11=0;
			$total55_12=0;
   
   for ($i=0; $i<count($tableau55); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData55) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		  /*echo $tableau55[$k]['groupe'];*/
		   echo '</td><td>';
		  echo $tableau55[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=55&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau55[$k]['sex_id']."& interval=<1 an\">".$tableau55[$k]['<1 an']."</a>";
		 $total55_0=$total55_0+$tableau55[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=55&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau55[$k]['sex_id']."& interval=1-4 ans\">".$tableau55[$k]['1-4 ans']."</a>";
		  $total55_1=$total55_1+$tableau55[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=55&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau55[$k]['sex_id']."& interval=5-9 ans\">".$tableau55[$k]['5-9 ans']."</a>";
		  $total55_2=$total55_2+$tableau55[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=55&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau55[$k]['sex_id']."& interval=10-14 ans\">".$tableau55[$k]['10-14 ans']."</a>";
		  $total55_3=$total55_3+$tableau55[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=55&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau55[$k]['sex_id']."& interval=15-19 ans\">".$tableau55[$k]['15-19 ans']."</a>";
		  $total55_4=$total55_4+$tableau55[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=55&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau55[$k]['sex_id']."& interval=20-24 ans\">".$tableau55[$k]['20-24 ans']."</a>";
		  $total55_5=$total55_5+$tableau55[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=55&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau55[$k]['sex_id']."& interval=25-29 ans\">".$tableau55[$k]['25-29 ans']."</a>";
		  $total55_6=$total55_6+$tableau55[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=55&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau55[$k]['sex_id']."& interval=30-34 ans\">".$tableau55[$k]['30-34 ans']."</a>";
		  $total55_7=$total55_7+$tableau55[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=55&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau55[$k]['sex_id']."& interval=35-39 ans\">".$tableau55[$k]['35-39 ans']."</a>";
		  $total55_8=$total55_8+$tableau55[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=55&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau55[$k]['sex_id']."& interval=40-44 ans\">".$tableau55[$k]['40-44 ans']."</a>";
		  $total55_9=$total55_9+$tableau55[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=55&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau55[$k]['sex_id']."& interval=45-49 ans\">".$tableau55[$k]['45-49 ans']."</a>";
		  $total55_10=$total55_10+$tableau55[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=55&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau55[$k]['sex_id']."& interval=50 ans et plus\">".$tableau55[$k]['50 ans et plus']."</a>";
		  $total55_11=$total55_11+$tableau55[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=55&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau55[$k]['sex_id']."& interval=inconnu\">".$tableau55[$k]['âge inconnu']."</a>";
		  $total55_12=$total55_12+$tableau55[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total55_0.'</td>
			<td>'.$total55_1.'</td>
			<td>'.$total55_2.'</td>
			<td>'.$total55_3.'</td>
			<td>'.$total55_4.'</td>
			<td>'.$total55_5.'</td>
			<td>'.$total55_6.'</td>
			<td>'.$total55_7.'</td>
			<td>'.$total55_8.'</td>
			<td>'.$total55_9.'</td>
			<td>'.$total55_10.'</td>
			<td>'.$total55_11.'</td>
			<td>'.$total55_12.'</td>
		</tr>';
echo '</table>';
}
echo '<div>&nbsp;</div>';

/*18.1.1 Nombre de femmes enceintes actives sous ARV 
ayant au moins un resultat de charge virale au cours des 12 derniers mois*/
if ($NbreData56 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de femmes enceintes actives sous ARV 
ayant au moins un resultat de charge virale au cours des 12 derniers mois</b></caption>';
	$total56_0=0;
   
   for ($i=0; $i<count($tableau56); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData56) {
      
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		echo '<td>';
		   echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=56&cle=nbEnceinte&startDate=".$startDate."&endDate=".$endDate."\">".$tableau56[$k]['nbEnceinte']."</a>";
			$total56_0=$total56_0+$tableau56[$k]['nbEnceinte'];
        echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
echo '</table>';
} 
echo '<div>&nbsp;</div>';

/*18.1.2 Nombre de femmes allaitantes actives sous ARV 
ayant au moins un resultat de charge virale au cours des 12 derniers mois*/
if ($NbreData57 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de femmes allaitantes actives sous ARV 
ayant au moins un resultat de charge virale au cours des 12 derniers mois</b></caption>';
	$total57_0=0;
   
   for ($i=0; $i<count($tableau57); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData57) {
      
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		echo '<td>';
		   echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=57&cle=nbAllaitante&startDate=".$startDate."&endDate=".$endDate."\">".$tableau57[$k]['nbAllaitante']."</a>";
			$total57_0=$total57_0+$tableau57[$k]['nbAllaitante'];
        echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
echo '</table>';
} 
echo '<div>&nbsp;</div>';

/*18.1.3 Nombre de populations clés actives sous ARV 
ayant au moins un resultat de charge virale au cours des 12 derniers mois*/	
if ($NbreData58 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de populations clés actives sous ARV 
ayant au moins un resultat de charge virale au cours des 12 derniers mois</b></caption>
<thead class=\"theadx\"><tr>
			<th>HARSAH</th>
			<th>Professionnels de sexe</th>
			<th>Personnes transgenres</th>
			<th>Prisonniers</th>
			<th>Utilisateurs de drogues injectables</th>
			</tr></thead>';
			
			$total58_0=0;
			$total58_1=0;
			$total58_2=0;
			$total58_3=0;
			$total58_4=0;
   
   for ($i=0; $i<count($tableau58); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData58) {
       //  echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		
		   echo '<td>';
		   echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=58&cle=163593&startDate=".$startDate."&endDate=".$endDate."\">".$tableau58[$k]['HARSAH']."</a>";
		
		 $total58_0=$total58_0+$tableau58[$k]['HARSAH'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=58&cle=163594&startDate=".$startDate."&endDate=".$endDate."\">".$tableau58[$k]['Professionnels de sexe']."</a>";
		 
		  $total58_1=$total58_1+$tableau58[$k]['Professionnels de sexe'];
		 echo '</td><td>';
		echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=58&cle=163596&startDate=".$startDate."&endDate=".$endDate."\">".$tableau58[$k]['Personnes transgenres']."</a>";
		 
		  $total58_2=$total58_2+$tableau58[$k]['Personnes transgenres'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=58&cle=163595&startDate=".$startDate."&endDate=".$endDate."\">".$tableau58[$k]['Prisonniers']."</a>";
		
		  $total58_3=$total58_3+$tableau58[$k]['Prisonniers'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=58&cle=163597&startDate=".$startDate."&endDate=".$endDate."\">".$tableau58[$k]['Utilisateurs de drogues injectables']."</a>";
		  $total58_4=$total58_4+$tableau58[$k]['Utilisateurs de drogues injectables'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
echo '</table>';
} 
echo '<div>&nbsp;</div>';

/*18.2 Nombre de patients actifs sous ARV dont le dernier résultat de Charge virale au cours 
des 12 derniers mois  est inférieur à 1000 copies/ml (TX_PVLS N routine)*/
if ($NbreData59 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de patients actifs sous ARV dont le dernier résultat de Charge virale au cours 
des 12 derniers mois  est inférieur à 1000 copies/ml (TX_PVLS N routine)</b></caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 1 an</th>
			<th>1-4 ans</th>
			<th>5-9 ans</th>
			<th>10-14 ans</th>
			<th>15-19 ans</th>
			<th>20-24 ans</th>
			<th>25-29 ans</th>
			<th>30-34 ans</th>
			<th>35-39 ans</th>
			<th>40-44 ans</th>
			<th>45-49 ans</th>
			<th>50 ans et plus</th>
			<th>âge inconnu</th>
			</tr></thead>';
			
			$total59_0=0;
			$total59_1=0;
			$total59_2=0;
			$total59_3=0;
			$total59_4=0;
			$total59_5=0;
			$total59_6=0;
			$total59_7=0;
			$total59_8=0;
			$total59_9=0;
			$total59_10=0;
			$total59_11=0;
			$total59_12=0;
   
   for ($i=0; $i<count($tableau59); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData59) {
         echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		   echo '</td><td>';
		  echo $tableau59[$k]['sex'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=59&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau59[$k]['sex_id']."& interval=<1 an\">".$tableau59[$k]['<1 an']."</a>";
		 $total59_0=$total59_0+$tableau59[$k]['<1 an'];
         echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=59&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau59[$k]['sex_id']."& interval=1-4 ans\">".$tableau59[$k]['1-4 ans']."</a>";
		  $total59_1=$total59_1+$tableau59[$k]['1-4 ans'];
		 echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=59&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau59[$k]['sex_id']."& interval=5-9 ans\">".$tableau59[$k]['5-9 ans']."</a>";
		  $total59_2=$total59_2+$tableau59[$k]['5-9 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=59&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau59[$k]['sex_id']."& interval=10-14 ans\">".$tableau59[$k]['10-14 ans']."</a>";
		  $total59_3=$total59_3+$tableau59[$k]['10-14 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=59&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau59[$k]['sex_id']."& interval=15-19 ans\">".$tableau59[$k]['15-19 ans']."</a>";
		  $total59_4=$total59_4+$tableau59[$k]['15-19 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=59&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau59[$k]['sex_id']."& interval=20-24 ans\">".$tableau59[$k]['20-24 ans']."</a>";
		  $total59_5=$total59_5+$tableau59[$k]['20-24 ans'];
		   echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=59&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau59[$k]['sex_id']."& interval=25-29 ans\">".$tableau59[$k]['25-29 ans']."</a>";
		  $total59_6=$total59_6+$tableau59[$k]['25-29 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=59&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau59[$k]['sex_id']."& interval=30-34 ans\">".$tableau59[$k]['30-34 ans']."</a>";
		  $total59_7=$total59_7+$tableau59[$k]['30-34 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=59&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau59[$k]['sex_id']."& interval=35-39 ans\">".$tableau59[$k]['35-39 ans']."</a>";
		  $total59_8=$total59_8+$tableau59[$k]['35-39 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=59&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau59[$k]['sex_id']."& interval=40-44 ans\">".$tableau59[$k]['40-44 ans']."</a>";
		  $total59_9=$total59_9+$tableau59[$k]['40-44 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=59&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau59[$k]['sex_id']."& interval=45-49 ans\">".$tableau59[$k]['45-49 ans']."</a>";
		  $total59_10=$total59_10+$tableau59[$k]['45-49 ans'];
		  echo '</td><td>';
		  echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=59&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau59[$k]['sex_id']."& interval=50 ans et plus\">".$tableau59[$k]['50 ans et plus']."</a>";
		  $total59_11=$total59_11+$tableau59[$k]['50 ans et plus'];
		 echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=59&startDate=".$startDate."&endDate=".$endDate."&sex=".$tableau59[$k]['sex_id']."& interval=inconnu\">".$tableau59[$k]['âge inconnu']."</a>";
		  $total59_12=$total59_12+$tableau59[$k]['âge inconnu'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
   echo '<tr>
			<td>Total</td>
			<td></td>
			<td>'.$total59_0.'</td>
			<td>'.$total59_1.'</td>
			<td>'.$total59_2.'</td>
			<td>'.$total59_3.'</td>
			<td>'.$total59_4.'</td>
			<td>'.$total59_5.'</td>
			<td>'.$total59_6.'</td>
			<td>'.$total59_7.'</td>
			<td>'.$total59_8.'</td>
			<td>'.$total59_9.'</td>
			<td>'.$total59_10.'</td>
			<td>'.$total59_11.'</td>
			<td>'.$total59_12.'</td>
		</tr>';
echo '</table>';
}

echo '<div>&nbsp;</div>';

/*18.2.1 Nombre de femmes enceintes actives sous ARV dont le dernier 
résultat de Charge virale au cours des 12 derniers mois  est inférieur à 1000 copies/ml */
	if ($NbreData60 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de femmes enceintes actives sous ARV dont le dernier 
résultat de Charge virale au cours des 12 derniers mois  est inférieur à 1000 copies/ml</b></caption>';
	$total60_0=0;
   
   for ($i=0; $i<count($tableau60); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData60) {
      
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		echo '<td>';
		   echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=60&cle=nbEnceinte&startDate=".$startDate."&endDate=".$endDate."\">".$tableau60[$k]['nbEnceinte']."</a>";
			$total60_0=$total60_0+$tableau60[$k]['nbEnceinte'];
        echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
echo '</table>';
}

echo '<div>&nbsp;</div>';

/*18.2.2 Nombre de femmes allaitantes actives sous ARV dont le dernier résultat de 
Charge virale au cours des 12 derniers mois  est inférieur à 1000 copies/ml */
	if ($NbreData61 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de femmes allaitantes actives sous ARV dont le dernier résultat de 
Charge virale au cours des 12 derniers mois  est inférieur à 1000 copies/ml</b></caption>';
	$total61_0=0;
   
   for ($i=0; $i<count($tableau61); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData61) {
      
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		echo '<td>';
		   echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=61&cle=nbAllaitante&startDate=".$startDate."&endDate=".$endDate."\">".$tableau61[$k]['nbAllaitante']."</a>";
			$total61_0=$total61_0+$tableau61[$k]['nbAllaitante'];
        echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
echo '</table>';
} 

echo '<div>&nbsp;</div>';

/*18.2.3 Nombre de populations clés actives sous ARV dont le dernier résultat de 
	Charge virale au cours des 12 derniers mois  est inférieur à 1000 copies/ml*/
if ($NbreData62 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table class="gridtable" border="1">
<caption><b>Nombre de populations clés actives sous ARV dont le dernier résultat de 
	Charge virale au cours des 12 derniers mois  est inférieur à 1000 copies/ml</b></caption>
<thead class=\"theadx\"><tr>
			<th>HARSAH</th>
			<th>Professionnels de sexe</th>
			<th>Personnes transgenres</th>
			<th>Prisonniers</th>
			<th>Utilisateurs de drogues injectables</th>
			</tr></thead>';
			
			$total62_0=0;
			$total62_1=0;
			$total62_2=0;
			$total62_3=0;
			$total62_4=0;
   
   for ($i=0; $i<count($tableau62); $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData62) {
       //  echo '<td>';
          // --------------------------------------
          // AFFICHAGE de l'element
		  
		  $k = ($i+($j*$NbrLigne));
		
		   echo '<td>';
		   echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=62&cle=163593&startDate=".$startDate."&endDate=".$endDate."\">".$tableau62[$k]['HARSAH']."</a>";
		
		 $total62_0=$total62_0+$tableau62[$k]['HARSAH'];
         echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=62&cle=163594&startDate=".$startDate."&endDate=".$endDate."\">".$tableau62[$k]['Professionnels de sexe']."</a>";
		 
		  $total62_1=$total62_1+$tableau62[$k]['Professionnels de sexe'];
		 echo '</td><td>';
		echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=62&cle=163596&startDate=".$startDate."&endDate=".$endDate."\">".$tableau62[$k]['Personnes transgenres']."</a>";
		 
		  $total62_2=$total62_2+$tableau62[$k]['Personnes transgenres'];
		  echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=62&cle=163595&startDate=".$startDate."&endDate=".$endDate."\">".$tableau62[$k]['Prisonniers']."</a>";
		
		  $total62_3=$total62_3+$tableau62[$k]['Prisonniers'];
		   echo '</td><td>';
		 echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\" arv_pnls_list.php?indicateur=62&cle=163597&startDate=".$startDate."&endDate=".$endDate."\">".$tableau62[$k]['Utilisateurs de drogues injectables']."</a>";
		  $total62_4=$total62_4+$tableau62[$k]['Utilisateurs de drogues injectables'];
		 echo '</td>';
         $j++;
         if ($NbrCol<$j) { $NbrCol=$j; }
      }
      echo '</tr>';
   }
echo '</table>';
}


 else {
echo 'pas de données à afficher';
}


echo '<div>&nbsp;</div>';




/*echo $table;*/ ?>











		 
	  </div> 
  
  

  
  
  
  </body>
</html>