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
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then   patientID else null end) as '50 ans et plus'
from arv_pnls_report
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
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then   patientID else null end) as '50 ans et plus'
from arv_pnls_report
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
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then   patientID else null end) as '50 ans et plus'
from arv_pnls_report
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
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then   patientID else null end) as '50 ans et plus'
from arv_pnls_report
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
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then   patientID else null end) as '50 ans et plus'
from arv_pnls_report
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
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then   patientID else null end) as '50 ans et plus'
from arv_pnls_report
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
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >= 50 then   patientID else null end) as '50 ans et plus'
from arv_pnls_report
where (dateprophylaxieCTX between '".$startDate."' and '".$endDate."' and endDate between '".$startDate."' and '".$endDate."') and indicator_id=10 group by sex";
$result9 = databaseSelect()->query($query9);

$k=0;
while ($val = $result9->fetch()) {
   $tableau9[$k] = $val;
   $k++;
}$result9->closeCursor();

$query10="select 'Nouveaux enroles sous ARV' as groupe, case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,sex as sex_id,
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') < 15 then  patientID else null end) as '<15 ans',
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >=15 then   patientID else null end) as '>=15 ans'
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
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >=15 then   patientID else null end) as '>=15 ans'
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
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >=15 then   patientID else null end) as '>=15 ans'
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
count(distinct case when TIMESTAMPDIFF(YEAR,ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end),'".$endDate."') >=15 then   patientID else null end) as '>=15 ans'
from arv_pnls_report
where (dateprophylaxieINH between '".$startDate."' - INTERVAL 6 MONTH and '".$endDate."' - INTERVAL 6 MONTH and DateEnrolement < '".$startDate."' - INTERVAL 6 MONTH) and indicator_id=11 group by sex";
$result13 = databaseSelect()->query($query13);

$k=0;
while ($val = $result13->fetch()) {
   $tableau13[$k] = $val;
   $k++;
}$result13->closeCursor();

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
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}
</style>

<script type="text/javascript">
			function showHideDiv(ele) {
				if(ele == "vitals") 
				{ 
			      document.getElementById("vital").style.backgroundColor ="#8899AA";
				  document.getElementById("veineuses").style.display = 'none';
				  document.getElementById("interventions").style.display = 'none';
				}
                else document.getElementById("vital").style.backgroundColor ="#AABBCC";
					  
				if(ele == "veineuses") 
				{
					document.getElementById("veineuse").style.backgroundColor ="#8899AA";
					document.getElementById("vitals").style.display = 'none';
					document.getElementById("interventions").style.display = 'none';
				}
				else document.getElementById("veineuse").style.backgroundColor ="#AABBCC";
				
				if(ele == "interventions") 
				{
					document.getElementById("intervention").style.backgroundColor ="#8899AA";
					document.getElementById("vitals").style.display = 'none';
					document.getElementById("veineuses").style.display = 'none';
				}
				else document.getElementById("intervention").style.backgroundColor ="#AABBCC";
				
				
				
				var srcElement = document.getElementById(ele);
				if (srcElement != null) {
					if (srcElement.style.display == "block") {
						srcElement.style.display = 'none';						
					}
					else {
						srcElement.style.display = 'block';
					}
					return false;
				}
			}
		</script>
</head>

<body text="#000000" link="#000000" alink="#000000" vlink="#000000" align="left"> 

<? include ("bannerbody.php"); ?>

  <fieldset style="width:65%;display: inline-block;">
    <legend>Choose your favorite Action</legend>
	
<div style="display: inline-block; width:65%; vertical-align:top;border-left: 1px solid #99BBE8;">
    <form id="form" name="form" method="post" action="" >
      
		<div style="display:inline-block; padding-left:10px">
		<label id="vitalTempTitle" style="width:50px">Date de debut</label>
		   <input id="startDate" name="startDate"  type="date"> 
		 </div>
		 <div style="display:inline-block; padding-left:10px">
		<label id="vitalTempTitle" style="width:50px">Date de fin</label>
		   <input id="endDate" name="endDate"  type="date"> 
		 </div>
	  </div>
	  
	<div class="" style="padding:15px">
       <button type="submit" class="" >Submit</button>
       <button class="">Cancel</button>
    </div>
   </form>
 
	</div>	
  </fieldset>
  
  <?php ?>
<div style="display: inline-block; width:65%; vertical-align:top;border-left: 1px solid #99BBE8;">
      <div class="tablex" style="padding:5px">
	  

	
	  
     </div>
		 
		   <?php 
		   
		   if ($NbreData != 0) {
$i = 0;
$NbrCol = 0;
echo '<table border="1">
<caption>Nombre de personnes VIH+ nouvellement enrolees sous ARV au cours du mois</caption>
<thead class=\"theadx\"><tr>
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
   
   for ($i=0; $i<$NbrLigne; $i++) {
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
			</tr>';
echo '</table>';
}
if ($NbreData2 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table border="1">
<caption>Nouvelles femmes allaitantes enrolees sous ARV</caption>
<thead class=\"theadx\"><tr>
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
   
   for ($i=0; $i<$NbrLigne; $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData3) {
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
			</tr>';
echo '</table>';
} 
if ($NbreData3 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table border="1">
<caption>Nombre de personnes VIH+ prealablement enrolees sous ARV dans un autre site et referees au cours du mois</caption>
<thead class=\"theadx\"><tr>
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
   
   for ($i=0; $i<$NbrLigne; $i++) {
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
			</tr>';
echo '</table>';
} 

if ($NbreData4 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table border="1">
<caption>Nouvelles femmes allaitantes prealablement enrolees sous ARV et referees au cours du mois</caption>
<thead class=\"theadx\"><tr>
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
   
   for ($i=0; $i<$NbrLigne; $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData3) {
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
			</tr>';
echo '</table>';
} 

if ($NbreData5 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table border="1">
<caption>Enrolement et reference des personnes des populations cles</caption>
<thead class=\"theadx\"><tr>
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
   
   for ($i=0; $i<$NbrLigne; $i++) {
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

if ($NbreData6 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table border="1">
<caption>Patients VIH+ non encore enroles sous ARV</caption>
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
   
   for ($i=0; $i<$NbrLigne; $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData3) {
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
			</tr>';
echo '</table>';
} 
if ($NbreData7 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table border="1">
<caption>Femmes allaitantes VIH+ non encore enrolees sous ARV</caption>
<thead class=\"theadx\"><tr>
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
   
   for ($i=0; $i<$NbrLigne; $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData3) {
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
			</tr>';
echo '</table>';
}
if ($NbreData7 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table border="1">
<caption>Nombre de patients VIH+ sous ARV places sous prophylaxie CTX au cours du mois</caption>
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
   
   for ($i=0; $i<$NbrLigne; $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData3) {
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
			</tr>';
echo '</table>';
}
if ($NbreData8 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table border="1">
<caption>Patients actifs sous ARV sous CTX </caption>
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
   
   for ($i=0; $i<$NbrLigne; $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData3) {
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
			</tr>';
echo '</table>';
}
if ($NbreData9 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table border="1">
<caption>Patients sous ARV ayant initie un traitement preventif de la TB au cours du mois </caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 15 ans</th>
			<th>>=15 ans</th>
			</tr></thead>';
			
			$total10_0=0;
			$total10_1=0;
			
   
   for ($i=0; $i<$NbrLigne; $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData3) {
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
			</tr>';
echo '</table>';
}
if ($NbreData10 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table border="1">
<caption>Patients deja sous ARV ayant initie un traitement preventif de la TB au cours du mois </caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 15 ans</th>
			<th>>=15 ans</th>
			</tr></thead>';
			
			$total11_0=0;
			$total11_1=0;
			
   
   for ($i=0; $i<$NbrLigne; $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData3) {
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
			</tr>';
echo '</table>';
}
if ($NbreData11 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table border="1">
<caption>Patients sous ARV ayant initie un traitement preventif de la TB il y a 6 mois</caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 15 ans</th>
			<th>>=15 ans</th>
			</tr></thead>';
			
			$total12_0=0;
			$total12_1=0;
			
   
   for ($i=0; $i<$NbrLigne; $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData3) {
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
			</tr>';
echo '</table>';
}
if ($NbreData12 != 0) {
$i = 0;
$NbrCol = 0;
echo '<table border="1">
<caption>Patients deja sous ARV ayant initie un traitement preventif de la TB il y a 6 mois </caption>
<thead class=\"theadx\"><tr>
			<th></th>
			<th>Sex</th>
			<th>< 15 ans</th>
			<th>>=15 ans</th>
			</tr></thead>';
			
			$total13_0=0;
			$total13_1=0;
			
   
   for ($i=0; $i<$NbrLigne; $i++) {
      echo '<tr>';
      $j = 0;
	  
      while (($i+($j*$NbrLigne))%$NbrLigne==$i && ($i+($j*$NbrLigne))<$NbreData3) {
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
			</tr>';
echo '</table>';
}
 else {
echo 'pas de données à afficher';
}/*echo $table;*/ ?>
		 
	  </div> 
  
  

  
  
  
  </body>
</html>