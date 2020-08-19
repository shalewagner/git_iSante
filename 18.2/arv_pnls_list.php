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

$where=" and indicateur=".$indicateur."";
if($sex<>'') $where.=" and sex=".$sex."";
if($interval<>'') 
switch ($interval){
	case '<1 an': 
	      $where.=" and TIMESTAMPDIFF(YEAR,'".$endDate."',ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end)) < 1 ";
	case '1-4 ans':
	      $where.=" and TIMESTAMPDIFF(YEAR,'".$endDate."',ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end)) between 1 and 4 ";
	case '5-9 ans':
	       $where.=" and TIMESTAMPDIFF(YEAR,'".$endDate."',ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end)) between 5 and 9 ";
	case '10-14 ans':
           $where.=" and TIMESTAMPDIFF(YEAR,'".$endDate."',ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end)) between 10 and 14 ";	
	case '15-19 ans':
           $where.=" and TIMESTAMPDIFF(YEAR,'".$endDate."',ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end)) between 15 and 19 ";	
	case '20-24 ans':
           $where.=" and TIMESTAMPDIFF(YEAR,'".$endDate."',ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end)) between 20 and 24 ";	
	case '25-29 ans':
           $where.=" and TIMESTAMPDIFF(YEAR,'".$endDate."',ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end)) between 25 and 29 ";	
	case '30-34 ans':
           $where.=" and TIMESTAMPDIFF(YEAR,'".$endDate."',ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end)) between 30 and 34 ";	
	case '35-39 ans':
           $where.=" and TIMESTAMPDIFF(YEAR,'".$endDate."',ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end)) between 35 and 39 ";	
	case '40-44 ans':
           $where.=" and TIMESTAMPDIFF(YEAR,'".$endDate."',ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end)) between 40 and 44 ";	
    case '45-49 ans':
           $where.=" and TIMESTAMPDIFF(YEAR,'".$endDate."',ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end)) between 45 and 49 ";	
    case '50 ans et plus':
           $where.=" and TIMESTAMPDIFF(YEAR,'".$endDate."',ymdToDate(dobYy, case when dobMm is not null or dobMm<>'' then dobMm else '06' end , case when dobDd is not null or dobDd<>'' then dobDd else '15' end)) >= 50 ";	
}  	  	  	  	  	   
	

$query='';

switch ($indicateur) {
	case '1':{
            $query="select case when sex=2 then 'HOMME' when sex=1 then 'FEMME' end as sex,clinicPatientID as ST,lname as Prenom,fname as Nom,round(DATEDIFF('".$endDate."',ymdToDate(p1.dobYy,p1.dobMm,p1.dobDd))/365,0) as Age,telephone from arv_pnls_report a,patient p
where a.patientID=p.patientID and DateEnrolement between '".$startDate."' and '".$endDate."'".$where
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