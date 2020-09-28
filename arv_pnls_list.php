<?php
require_once ("backend.php");
require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";  



$output = '';
$indicateur=$_REQUEST['indicateur'];
$startDate=$_REQUEST['startDate'];
$endDate=$_REQUEST['endDate'];
$sex=$_REQUEST['sex'];
$interval=$_REQUEST['interval'];


switch ($indicateur){
	case 111: $where=" and indicator_id=11"; break;
	case 112: $where=" and indicator_id=11"; break;
	case 113: $where=" and indicator_id=11"; break;
	case 122: $where=" and indicator_id=12"; break;
	case 133: $where=" and indicator_id=13"; break;
	case 134: $where=" and indicator_id=13"; break;
	case 135: $where=" and indicator_id=13"; break;
	case 144: $where=" and indicator_id=14"; break;
	case 166: $where=" and indicator_id=16"; break;
	case 35: $where=""; break;
	case 36: $where=""; break;
	case 37: $where=""; break;
	case 38: $where=""; break;
	case 39: $where=""; break;
	case 78: $where=""; break;
	
	default : $where=" and indicator_id=".$indicateur."";
	break;
}


if(isset($_REQUEST['sex'])) $where.=" and p.sex=".$sex."";
if (isset($_REQUEST['cle'])) $where.=" and risk='".$_REQUEST['cle']."' ";
if (isset($_REQUEST['cancer_col'])) $where.=" and cancer_col_status='".$_REQUEST['cancer_col']."' ";
if (isset($_REQUEST['intervention'])) $where.=" and intervention='".$_REQUEST['intervention']."' ";
if (isset($_REQUEST['dispdInterval'])) $where.=" and dispensationIntervalle='".$_REQUEST['dispdInterval']."' ";
if (isset($_REQUEST['methode_pf'])) $where.=" and methode_pf='".$_REQUEST['methode_pf']."' ";



$sex_value='';
if($sex==2) $sex_value="Homme" ;
if($sex==1) $sex_value="Femme" ;

$tableHeader='<table class="gridtable" border="1">
<caption>Rapport mensuel des soins cliniques VIH-ARV</caption>
<thead><tr><th>Periode</th><th>'.$startDate.' - '.$endDate.'</th></tr>
       <tr><th>Sex</th><th>'.$sex_value.'</th></tr>
	   <tr><th>Age</th><th>'.$interval.'</th></tr>';

if (isset($_REQUEST['cle'])) $tableHeader.="<tr><th>Risk</th><th>".$_REQUEST['cle']."</th></tr>";

$tableHeader.="</thead></table>";


if($interval<>'') 
switch ($interval){
	case '<1 an': 
	      $where.=" and TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy, case when p.dobMm is not null or p.dobMm<>'' then p.dobMm else '06' end , case when p.dobDd is not null or p.dobDd<>'' then p.dobDd else '15' end),'".$endDate."') < 1 ";
		   break;
	case '1-4 ans':
	      $where.=" and TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy, case when p.dobMm is not null or p.dobMm<>'' then p.dobMm else '06' end , case when p.dobDd is not null or p.dobDd<>'' then p.dobDd else '15' end),'".$endDate."') between 1 and 4 ";
	       break;
	case '5-9 ans':
	       $where.=" and TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy, case when p.dobMm is not null or p.dobMm<>'' then p.dobMm else '06' end , case when p.dobDd is not null or p.dobDd<>'' then p.dobDd else '15' end),'".$endDate."') between 5 and 9 ";
	       break;
	case '10-14 ans':
           $where.=" and TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy, case when p.dobMm is not null or p.dobMm<>'' then p.dobMm else '06' end , case when p.dobDd is not null or p.dobDd<>'' then p.dobDd else '15' end),'".$endDate."') between 10 and 14 ";	
	       break;
	case '15-19 ans':
           $where.=" and TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy, case when p.dobMm is not null or p.dobMm<>'' then p.dobMm else '06' end , case when p.dobDd is not null or p.dobDd<>'' then p.dobDd else '15' end),'".$endDate."') between 15 and 19 ";	
	        break;
	case '20-24 ans':
           $where.=" and TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy, case when p.dobMm is not null or p.dobMm<>'' then p.dobMm else '06' end , case when p.dobDd is not null or p.dobDd<>'' then p.dobDd else '15' end),'".$endDate."') between 20 and 24 ";	
	       break;
	case '25-29 ans':
           $where.=" and TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy, case when p.dobMm is not null or p.dobMm<>'' then p.dobMm else '06' end , case when p.dobDd is not null or p.dobDd<>'' then p.dobDd else '15' end),'".$endDate."') between 25 and 29 ";	
	       break;
	case '30-34 ans':
           $where.=" and TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy, case when p.dobMm is not null or p.dobMm<>'' then p.dobMm else '06' end , case when p.dobDd is not null or p.dobDd<>'' then p.dobDd else '15' end),'".$endDate."') between 30 and 34 ";	
	       break;
	case '35-39 ans':
           $where.=" and TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy, case when p.dobMm is not null or p.dobMm<>'' then p.dobMm else '06' end , case when p.dobDd is not null or p.dobDd<>'' then p.dobDd else '15' end),'".$endDate."') between 35 and 39 ";	
	       break;
	case '40-44 ans':
           $where.=" and TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy, case when p.dobMm is not null or p.dobMm<>'' then p.dobMm else '06' end , case when p.dobDd is not null or p.dobDd<>'' then p.dobDd else '15' end),'".$endDate."') between 40 and 44 ";	
            break;
	case '45-49 ans':
           $where.=" and TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy, case when p.dobMm is not null or p.dobMm<>'' then p.dobMm else '06' end , case when p.dobDd is not null or p.dobDd<>'' then p.dobDd else '15' end),'".$endDate."') between 45 and 49 ";	
          break;   
   case '50 ans et plus':
           $where.=" and TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy, case when p.dobMm is not null or p.dobMm<>'' then p.dobMm else '06' end , case when p.dobDd is not null or p.dobDd<>'' then p.dobDd else '15' end),'".$endDate."') >= 50 ";
     break;	
   case '<15 ans': 
	      $where.=" and TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy, case when p.dobMm is not null or p.dobMm<>'' then p.dobMm else '06' end , case when p.dobDd is not null or p.dobDd<>'' then p.dobDd else '15' end),'".$endDate."') < 15 ";
	 break;	 
   case '>=15 ans': 
	      $where.=" and TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy, case when p.dobMm is not null or p.dobMm<>'' then p.dobMm else '06' end , case when p.dobDd is not null or p.dobDd<>'' then p.dobDd else '15' end),'".$endDate."') >= 15 ";
	 break;	 
	 
   case 'inconnu': 
	      $where.=" and (p.dobYy IS NULL OR p.dobYy = '') ";
	 break;		 
}  	  	  	  	  	   
	

$query='';

switch ($indicateur) {
	case '1':{
            $query="select distinct a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and DateEnrolement between '".$startDate."' and '".$endDate."'".$where;

	   }		  
	  break;
	case '2':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and DebutAllaitement between '".$startDate."' and '".$endDate."'".$where;

	   }		  
	  break;  
	case '3':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and DateTransfert between '".$startDate."' and '".$endDate."'".$where;

	   }		  
	  break; 
	case '4':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and DebutAllaitement between '".$startDate."' and '".$endDate."'".$where;

	   }		  
	  break;	

	case '5':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and (DateEnrolement between '".$startDate."' and '".$endDate."' or DateTransfert between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;



	case '6':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and (endDate between '".$startDate."' and '".$endDate."' or endDate is null) and reasonNoEnrolment is not NULL ".$where;

	   }		  
	  break;
	  
	case '7':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,round(DATEDIFF('".$endDate."',ymdToDate(p.dobYy,p.dobMm,p.dobDd))/365,0) as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and (DateEnrolement between '".$startDate."' and '".$endDate."' or DateTransfert between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;	  

	case '8':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and (DebutAllaitement between '".$startDate."' and '".$endDate."' and endDate between '".$startDate."' and '".$endDate."')".$where;

	   }		  
	  break;

	case '9':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and dateprophylaxieCTX between '".$startDate."' and '".$endDate."'".$where;

	   }		  
	  break;	


	case '10':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and dateprophylaxieCTX between '".$startDate."' and '".$endDate."'".$where;

	   }		  
	  break;
	  

	case '11':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and (dateprophylaxieINH between '".$startDate."' and '".$endDate."' and DateEnrolement between '".$startDate."' and '".$endDate."') ".$where;

echo $query;
	   }		  
	  break;	
  
	  
	case '111':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and (dateprophylaxieINH between '".$startDate."' and '".$endDate."' and DateEnrolement < '".$startDate."') ".$where;

	   }		  
	  break;	

	case '112':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone 
			from arv_pnls_report a,patient p
where a.patientID=p.patientID and (dateprophylaxieINH between '".$startDate."' - INTERVAL 6 MONTH and '".$endDate."' - INTERVAL 6 MONTH and DateEnrolement between '".$startDate."' - INTERVAL 6 MONTH and '".$endDate."' - INTERVAL 6 MONTH) ".$where;
	 }		  
	  break;
	  
	case '113':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and (dateprophylaxieINH between '".$startDate."' - INTERVAL 6 MONTH and '".$endDate."' - INTERVAL 6 MONTH and DateEnrolement < '".$startDate."' - INTERVAL 6 MONTH)  ".$where;
	 
	 }		  
	  break; 

	case '12':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (DateEnrolement between '".$startDate."' - INTERVAL 6 MONTH and '".$endDate."' - INTERVAL 6 MONTH and datearretprophylaxieINH between '".$startDate."' and '".$endDate."')  ".$where;	
	}		  
	  break; 	

	case '122':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (DateEnrolement < '".$startDate."' - INTERVAL 6 MONTH and datearretprophylaxieINH between '".$startDate."' and '".$endDate."')  ".$where;	
	}		  
	  break; 	

	case '13':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (DateEnrolement between '".$startDate."' and '".$endDate."' and dateVisite between '".$endDate."' - INTERVAL 6 MONTH and '".$endDate." and '".$endDate."' and endDate between '".$startDate."' and '".$endDate."'') and presenceBCG=1  ".$where;	
	}		  
	  break; 
	  
	case '133':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (DateEnrolement < '".$startDate."' and dateVisite between '".$endDate."' - INTERVAL 6 MONTH and '".$endDate."' and '".$endDate."' and endDate between '".$startDate."' and '".$endDate."') and presenceBCG=1 ".$where;

	   }		  
	  break; 	

	case '134':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (DateEnrolement between '".$startDate."' and '".$endDate."' and dateVisite between '".$endDate."' - INTERVAL 6 MONTH and '".$endDate."' and '".$endDate."' and endDate between '".$startDate."' and '".$endDate."') and recentNegPPD=1 ".$where;

	   }		  
	  break;
	  
	case '135':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (DateEnrolement < '".$startDate."' and dateVisite between '".$endDate."' - INTERVAL 6 MONTH and '".$endDate."' and '".$endDate."' and endDate between '".$startDate."' and '".$endDate."') and recentNegPPD=1 ".$where;

	   }		  
	  break;	


	case '14':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (DateEnrolement between '".$startDate."' and '".$endDate."' and datetraitemntAntiTb between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;
	  

	case '144':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (DateEnrolement < '".$startDate."' and datetraitemntAntiTb between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;
	  
	  
	case '15':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and datetraitemntAntiTb between '".$startDate."' and '".$endDate."'  ".$where;

	   }		  
	  break;	  


	case '16':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and datetraitemntAntiTb between '".$startDate."' and '".$endDate."' and DateEnrolement between '".$startDate."' and '".$endDate."'  ".$where;

	   }		  
	  break;


	case '166':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and datetraitemntAntiTb between '".$startDate."' and '".$endDate."' and DateEnrolement < '".$startDate."'  ".$where;

	   }		  
	  break;	

	case '17':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and endDate between '".$startDate."' and '".$endDate."'  ".$where;

	   }		  
	  break;	


	case '18':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and endDate between '".$startDate."' and '".$endDate."'  ".$where;

	   }		  
	  break;
	  
	  
	case '19':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone,dispensationIntervalle from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dispd between '".$startDate."' and '".$endDate."')  ".$where;
	   }		  
	  break;	  
	  
	case '35':{
            
$query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone
from patient p, patientStatusYear ps, 
(select pst.patientID, MAX(pst.endDate) as endDate FROM patientStatusYear pst
WHERE DATE(pst.endDate) BETWEEN '".$startDate."' and '".$endDate."' GROUP BY 1) B
WHERE p.patientID = ps.patientID AND ps.patientStatus = 1
AND ps.patientID = B.patientID
AND DATE(ps.endDate) = DATE(B.endDate)
AND (DATE(ps.endDate) between '".$startDate."' and '".$endDate."') ". $where;
			
	   }		  
	  break;
	  
	case '36':{
            
$query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone
from patient p, patientStatusYear ps, 
(select pst.patientID, MAX(pst.endDate) as endDate FROM patientStatusYear pst
WHERE DATE(pst.endDate) BETWEEN '".$startDate."' and '".$endDate."' GROUP BY 1) B
WHERE p.patientID = ps.patientID AND ps.patientStatus = 3
AND ps.patientID = B.patientID
AND DATE(ps.endDate) = DATE(B.endDate)
AND (DATE(ps.endDate) between '".$startDate."' and '".$endDate."')  ". $where;
			
	   }		  
	  break;	  

	case '37':{
            
$query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone
from patient p, patientStatusYear ps, 
(select pst.patientID, MAX(pst.endDate) as endDate FROM patientStatusYear pst
WHERE DATE(pst.endDate) BETWEEN '".$startDate."' and '".$endDate."' GROUP BY 1) B
WHERE p.patientID = ps.patientID AND ps.patientStatus = 9
AND ps.patientID = B.patientID
AND DATE(ps.endDate) = DATE(B.endDate)
AND (DATE(ps.endDate) between '".$startDate."' and '".$endDate."') ". $where;
			
	   }		  
	  break;	  
	  
	case '38':{
            
$query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone
from patient p, patientStatusYear ps, encounter e, obs o,
(select pst.patientID, MAX(pst.endDate) as endDate FROM patientStatusYear pst
WHERE DATE(pst.endDate) BETWEEN '".$startDate."' and '".$endDate."' GROUP BY 1) B
WHERE p.patientID = ps.patientID AND ps.patientStatus = 9
AND p.patientID = e.patientID
AND e.encounter_id = o.encounter_id
AND ps.patientID = B.patientID
AND DATE(ps.endDate) = DATE(B.endDate)
AND (o.concept_id = 163623 AND o.value_boolean = 1)
AND (DATE(ps.endDate) between '".$startDate."' and '".$endDate."') ". $where;
			
	   }		  
	  break;	  
	  

	case '39':{
            
$query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone
from patient p, patientStatusYear ps, 
(select pst.patientID, MAX(pst.endDate) as endDate FROM patientStatusYear pst
WHERE DATE(pst.endDate) BETWEEN '".$startDate."' and '".$endDate."' GROUP BY 1) B
WHERE p.patientID = ps.patientID AND ps.patientStatus = 2
AND ps.patientID = B.patientID
AND DATE(ps.endDate) = DATE(B.endDate)
AND (DATE(ps.endDate) between '".$startDate."' and '".$endDate."')  ". $where;
			
	   }		  
	  break;

	case '41':{
            $query="select distinct  a.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;
	  
	case '42':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;	

	case '43':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;	  
	  
	case '44':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;

	case '45':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;	  

	case '45':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;

	case '46':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;	  

	case '47':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;	

	case '48':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;

	case '49':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;

	case '50':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;	

	case '51':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;

	case '52':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;	

	case '53':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;	


	case '54':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;	

	case '55':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;


	case '56':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') AND ((DebutGrossesse between '".$startDate."' and '".$endDate."') 	OR (endDate between '".$startDate."' and '".$endDate."')) ".$where;
	   }		  
	  break;	

	case '57':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') AND ((DebutAllaitement between '".$startDate."' and '".$endDate."')	OR (endDate between '".$startDate."' and '".$endDate."')) ".$where;
	   }		  
	  break;	 

	case '58':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') ".$where;
	   }		  
	  break;

	case '59':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') ".$where;
	   }		  
	  break;	

	case '60':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') AND ((DebutGrossesse between '".$startDate."' and '".$endDate."') OR (endDate between '".$startDate."' and '".$endDate."')) ".$where;
	   }		  
	  break;


	case '61':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."')	AND ((DebutAllaitement between '".$startDate."' and '".$endDate."') OR (endDate between '".$startDate."' and '".$endDate."')) ".$where;
	   }		  
	  break;

	case '62':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') ".$where;
	   }		  
	  break;	  
	  
	  
	case '75':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=75 ".$where;
	   }		  
	  break;		  

	case '76':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=76  ".$where;
	   }		  
	  break;

	case '77':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=77 ".$where;
	   }		  
	  break;	
	  
	case '78':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone 
      from patient p, arv_pnls_report apr, patientStatusYear ps, 
	(select pst.patientID, MAX(pst.endDate) AS endDate FROM patientStatusYear pst 
	WHERE pst.endDate <= '".$endDate."' GROUP BY 1) B
	where apr.patientID = ps.patientID
	AND ps.patientID = B.patientID
	AND p.patientID = B.patientID
	AND ps.endDate = B.endDate
	AND ps.patientStatus IN (6,8,9)
	AND ps.endDate <= '".$endDate."'
	AND (apr.dateVisite between '".$startDate."' and '".$endDate."') and apr.indicator_id=75 ".$where;
	   }		  
	  break;	


	case '79':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=79 ".$where;
	   }		  
	  break;

	case '80':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=80 ".$where;
	   }		  
	  break;
	  
	case '81':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=81 ".$where;
	   }		  
	  break;	  

	case '82':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=82 ".$where;
	   }		  
	  break;	

	case '83':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=83 ".$where;
	   }		  
	  break;	 

	case '84':{
            $query="select distinct  p.patientID,p.location_id as siteCode,case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy,p.dobMm,p.dobDd),'".$endDate."') as Age,p.telephone from arv_pnls_report a,patient p
           where a.patientID=p.patientID and (dateVisite between '".$startDate."' and '".$endDate."') and indicator_id=84 ".$where;
	   }		  
	  break;	  
	  
}

	$result = databaseSelect()->query($query)->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) == 0) return '<p><center><font color="red"><bold>Aucuns résultats trouvés</bold></font></center><p>';
        // set up the table
        $output = '<center><table id="excelTable" class="gridtable" width="90%" border="1" cellpadding="0" cellspacing="0">';
        // loop on the results 
        $i = 0;
        foreach($result as $row) {
               if ($i == 0) { 
                       // output the column header 
                       $output .= '<tr><th>Code ST</th><th>Prenom</th><th>Nom</th><th>Sexe</th><th>Age</th><th>Telephone</th></tr>';
					   }				   
                       $output .= '<tr><td><a target="_blank" rel="noopener noreferrer" href="patienttabs.php?pid='.$row['patientID'].'&lang=fr&site='.$row['siteCode'].'">'. $row['ST']. '</a></td><td>'. $row['Prenom']. '</td><td>'. $row['Nom']. '</td><td>'. $row['sex']. '</td><td>'. $row['Age']. '</td><td>'. $row['telephone']. '</td></tr>';
                       $i++;
               } 
        $output .= '</table></center>';
		
		
		
		

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

</head>

<body text="#000000" link="#000000" alink="#000000" vlink="#000000" align="left"> 

<? include ("bannerbody.php"); ?>

    
  <?php ?>
<div style="width:65%; vertical-align:top;border-left: 1px solid #99BBE8;">
      <div class="tablex" style="padding:10px;width:50%"><?php echo $tableHeader; ?></div>	
      <div class="tablex" style="padding:10px"><?php echo $output ; ?></div>		 
</div> 
  
  </body>
</html>