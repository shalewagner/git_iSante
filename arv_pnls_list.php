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


if($indicateur>100) 
{ 
    $where=" and indicator_id=11";
}
else 
	$where=" and indicator_id=".$indicateur."";




if($sex<>'') $where.=" and p.sex=".$sex."";
if (isset($_REQUEST['cle'])) $where.=" and risk='".$_REQUEST['cle']."' ";

if($interval<>'') 
switch ($interval){
	case '<1 an': 
	      $where.=" and TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy, case when p.dobMm is not null or p.dobMm<>'' then p.dobMm else '06' end , case when p.dobDd is not null or p.dobDd<>'' then p.dobDd else '15' end),'".$endDate."') < 1 ";
		   break;
	case '1-4 ans':
	      $where.=" and TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy, case when p.dobMm is not null or p.dobMm<>'' then p.dobMm else '06' end , case when p.dobDd is not null or p.dobDd<>'' then p.dobDd else '15' end),'".$endDate."') between 1 and 4 ";
	       break;
	case '5-9 ans':
	       $where.=" and TIMESTAMPDIFF(YEAR,ymdToDate(p.dobYy, case when p.dobMm is not null or p.dobMm<>'' then p.dobMm else '06' end , case when p.dobDd is not null or p.dobDd<>'' then p. else '15' end),'".$endDate."') between 5 and 9 ";
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
}  	  	  	  	  	   
	

$query='';

switch ($indicateur) {
	case '1':{
            $query="select distinct case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,round(DATEDIFF('".$endDate."',ymdToDate(p.dobYy,p.dobMm,p.dobDd))/365,0) as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and DateEnrolement between '".$startDate."' and '".$endDate."'".$where;

	   }		  
	  break;
	case '2':{
            $query="select distinct  case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,round(DATEDIFF('".$endDate."',ymdToDate(p.dobYy,p.dobMm,p.dobDd))/365,0) as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and DebutAllaitement between '".$startDate."' and '".$endDate."'".$where;

	   }		  
	  break;  
	case '3':{
            $query="select distinct  case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,round(DATEDIFF('".$endDate."',ymdToDate(p.dobYy,p.dobMm,p.dobDd))/365,0) as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and DateTransfert between '".$startDate."' and '".$endDate."'".$where;

	   }		  
	  break; 
	case '4':{
            $query="select distinct  case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,round(DATEDIFF('".$endDate."',ymdToDate(p.dobYy,p.dobMm,p.dobDd))/365,0) as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and DebutAllaitement between '".$startDate."' and '".$endDate."'".$where;

	   }		  
	  break;	

	case '5':{
            $query="select distinct  case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,round(DATEDIFF('".$endDate."',ymdToDate(p.dobYy,p.dobMm,p.dobDd))/365,0) as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and (DateEnrolement between '".$startDate."' and '".$endDate."' or DateTransfert between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;



	case '6':{
            $query="select distinct  case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,round(DATEDIFF('".$endDate."',ymdToDate(p.dobYy,p.dobMm,p.dobDd))/365,0) as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and (endDate between '".$startDate."' and '".$endDate."' or endDate is null) and reasonNoEnrolment is not NULL ".$where;

	   }		  
	  break;
	  
	case '7':{
            $query="select distinct  case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,round(DATEDIFF('".$endDate."',ymdToDate(p.dobYy,p.dobMm,p.dobDd))/365,0) as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and (DateEnrolement between '".$startDate."' and '".$endDate."' or DateTransfert between '".$startDate."' and '".$endDate."') ".$where;

	   }		  
	  break;	  

	case '8':{
            $query="select distinct  case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,round(DATEDIFF('".$endDate."',ymdToDate(p.dobYy,p.dobMm,p.dobDd))/365,0) as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and (DebutAllaitement between '".$startDate."' and '".$endDate."' and endDate between '".$startDate."' and '".$endDate."')".$where;

	   }		  
	  break;

	case '9':{
            $query="select distinct  case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,round(DATEDIFF('".$endDate."',ymdToDate(p.dobYy,p.dobMm,p.dobDd))/365,0) as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and dateprophylaxieCTX between '".$startDate."' and '".$endDate."'".$where;

	   }		  
	  break;	


	case '10':{
            $query="select distinct  case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,round(DATEDIFF('".$endDate."',ymdToDate(p.dobYy,p.dobMm,p.dobDd))/365,0) as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and dateprophylaxieCTX between '".$startDate."' and '".$endDate."'".$where;

	   }		  
	  break;
	  

	case '11':{
            $query="select distinct  case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,round(DATEDIFF('".$endDate."',ymdToDate(p.dobYy,p.dobMm,p.dobDd))/365,0) as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and (dateprophylaxieINH between '".$startDate."' and '".$endDate."' and DateEnrolement between '".$startDate."' and '".$endDate."') ".$where;
	   }		  
	  break;	  
	  
	case '111':{
            $query="select distinct  case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,round(DATEDIFF('".$endDate."',ymdToDate(p.dobYy,p.dobMm,p.dobDd))/365,0) as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and (dateprophylaxieINH between '".$startDate."' and '".$endDate."' and DateEnrolement < '".$startDate."') ".$where;
	   }		  
	  break;	

	case '112':{
            $query="select distinct  case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,round(DATEDIFF('".$endDate."',ymdToDate(p.dobYy,p.dobMm,p.dobDd))/365,0) as Age,p.telephone 
			from arv_pnls_report a,patient p
where a.patientID=p.patientID and (dateprophylaxieINH between '".$startDate."' - INTERVAL 6 MONTH and '".$endDate."' - INTERVAL 6 MONTH and DateEnrolement between '".$startDate."' - INTERVAL 6 MONTH and '".$endDate."' - INTERVAL 6 MONTH) ".$where;

	 }		  
	  break;
	  
	case '113':{
            $query="select distinct  case when p.sex=2 then 'HOMME' when p.sex=1 then 'FEMME' end as sex,p.clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,round(DATEDIFF('".$endDate."',ymdToDate(p.dobYy,p.dobMm,p.dobDd))/365,0) as Age,p.telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and (dateprophylaxieINH between '".$startDate."' - INTERVAL 6 MONTH and '".$endDate."' - INTERVAL 6 MONTH and DateEnrolement < '".$startDate."' - INTERVAL 6 MONTH)  ".$where;
	   }		  
	  break; 
	 
	  
}

$result = databaseSelect()->query($query)->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) == 0) return '<p><center><font color="red"><bold>Aucuns résultats trouvés</bold></font></center><p>';
        // set up the table
        $output = '<center><table class="" width="90%" border="1" cellpadding="0" cellspacing="0">';
        // loop on the results 
        $i = 0;
        foreach($result as $row) {
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

?> 

</head>

</head>

<body text="#000000" link="#000000" alink="#000000" vlink="#000000" align="left"> 

<? include ("bannerbody.php"); ?>

    
  <?php ?>
<div style="display: inline-block; width:65%; vertical-align:top;border-left: 1px solid #99BBE8;">
      <div class="tablex" style="padding:5px">
     </div>		 
		   <?php echo $output ; ?>		 
	  </div> 
  
  </body>
</html>