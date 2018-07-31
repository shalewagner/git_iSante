<?php
require_once ("backend.php");

require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";




function generateFrequentationReport ($startdate, $enddate,$site, $lang) {
  $dateTime = $lang == "fr" ? date ("d/m/y H:i:s") : date ("m/d/y H:i:s");
  $siteName = getSiteName ($site, $lang);
  $period=date("d-M-Y", strtotime($startdate)).' To '.date("d-M-Y", strtotime($enddate));
  $year = date("y", strtotime($startdate));
  $month = date("m", strtotime($startdate));   
  $commune = getCommune($site);
  $department=getDepartment($site);
 

  $queryArray = array(
"visit" => "SELECT lastModifier as User ,a.visitDate,
COUNT( DISTINCT CASE WHEN  N.patientID is not null and p.hivPositive=1 THEN a.patientid ELSE NULL END ) AS 'Nouveau Patient VIH', 
COUNT( DISTINCT CASE WHEN  N.patientID is not null and (p.hivPositive<>1 or p.hivPositive is null) THEN a.patientid ELSE NULL END ) AS 'Nouveau Patient Non VIH',  
COUNT( DISTINCT CASE WHEN N.patientID is not null THEN a.patientid ELSE NULL END ) AS 'Nouveau Patient',   
COUNT( DISTINCT CASE WHEN p.hivPositive=1   THEN a.patientid ELSE NULL END ) AS 'Patient VIH', 
COUNT( DISTINCT CASE WHEN p.hivPositive<>1 or p.hivPositive is null  THEN a.patientid ELSE NULL END ) AS 'Patient Non VIH', 
COUNT( DISTINCT  a.patientid ) AS 'Total Patient'

FROM patient p,encValidAll a left join
(
SELECT patientID,visitDate
FROM encValidAll a
WHERE encounterType IN (10,15) 
And visitDate between  '".$startdate."' AND '".$enddate."'  AND sitecode='".$site."'
) N on (a.patientID=N.patientID)

where  a.visitDate between  '".$startdate."' AND '".$enddate."'  AND sitecode='".$site."'
and p.patientID=a.patientID
GROUP BY 1,2 
order by 1,2",
"visitTotal"=> "SELECT lastModifier as User ,
COUNT( DISTINCT CASE WHEN  N.patientID is not null and p.hivPositive=1 THEN a.patientid ELSE NULL END ) AS 'Nouveau Patient VIH', 
COUNT( DISTINCT CASE WHEN  N.patientID is not null and (p.hivPositive<>1 or p.hivPositive is null) THEN a.patientid ELSE NULL END ) AS 'Nouveau Patient Non VIH',  
COUNT( DISTINCT CASE WHEN N.patientID is not null THEN a.patientid ELSE NULL END ) AS 'Nouveau Patient',   
COUNT( DISTINCT CASE WHEN p.hivPositive=1   THEN a.patientid ELSE NULL END ) AS 'Patient VIH', 
COUNT( DISTINCT CASE WHEN p.hivPositive<>1 or p.hivPositive is null  THEN a.patientid ELSE NULL END ) AS 'Patient Non VIH', 
COUNT( DISTINCT  a.patientid ) AS 'Total Patient'

FROM patient p,encValidAll a left join
(
SELECT patientID,visitDate
FROM encValidAll a
WHERE encounterType IN (10,15) 
And visitDate between  '".$startdate."' AND '".$enddate."'  AND sitecode='".$site."'
) N on (a.patientID=N.patientID)

where  a.visitDate between  '".$startdate."' AND '".$enddate."'  AND sitecode='".$site."'
and p.patientID=a.patientID
GROUP BY 1
order by 1"	 
	   ); 
  
  $visit = outputQueryRows($queryArray["visit"]); 
  $visitTotal = outputQueryRows($queryArray["visitTotal"]); 
  
 

 




  
  $summary = <<<EOF
  
 <script type="text/javascript">
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
  <td style="width: 30%;text-align: right; padding:15px;">
  <div><span style="font-family: Lucida Console; font-size: 12.0px;"><strong>Periode :</strong>   $period </span></div>
  </td>  
</tr>
</table>

<table width="90%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top" >
  <td style="width: 70%"> 
   <div><span style="font-family: Lucida Console; font-size: 12.0px; border:solid 1px black; padding:5px;"><strong>Institution :</strong> $siteName</span> 
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
<table width="90%" border="1">
  <tr>
    <td width="70%">
	<p>&nbsp;</p>
	<div><strong> Total de visite  durant la periode </strong></div>
	<div>&nbsp;</div>
	<div>$visitTotal</div>
	<p>&nbsp;</p>
	<div><strong> Total de visite Par date durant la periode </strong></div>
	<div>$visit</div>
	<div>&nbsp;</div>
	
	</td>
  </tr>
</table>


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





function generateFrequentationReport1 ($startdate, $enddate,$site, $lang) {
  $dateTime = $lang == "fr" ? date ("d/m/y H:i:s") : date ("m/d/y H:i:s");
  $siteName = getSiteName ($site, $lang);
  $period=date("d-M-Y", strtotime($startdate)).' To '.date("d-M-Y", strtotime($enddate));
  $year = date("y", strtotime($startdate));
  $month = date("m", strtotime($startdate));   
  $commune = getCommune($site);
  $department=getDepartment($site);
 

  $queryArray = array(
"visit" => "SELECT a.visitDate,
COUNT( DISTINCT CASE WHEN  N.patientID is not null and p.hivPositive=1 THEN a.patientid ELSE NULL END ) AS 'Nouveau Patient VIH', 
COUNT( DISTINCT CASE WHEN  N.patientID is not null and (p.hivPositive<>1 or p.hivPositive is null) THEN a.patientid ELSE NULL END ) AS 'Nouveau Patient Non VIH',  
COUNT( DISTINCT CASE WHEN N.patientID is not null THEN a.patientid ELSE NULL END ) AS 'Nouveau Patient',   
COUNT( DISTINCT CASE WHEN p.hivPositive=1   THEN a.patientid ELSE NULL END ) AS 'Patient VIH', 
COUNT( DISTINCT CASE WHEN p.hivPositive<>1 or p.hivPositive is null  THEN a.patientid ELSE NULL END ) AS 'Patient Non VIH', 
COUNT( DISTINCT  a.patientid ) AS 'Total Patient'

FROM patient p,encValidAll a left join
(
SELECT patientID,visitDate
FROM encValidAll a
WHERE encounterType IN (10,15) 
And visitDate between  '".$startdate."' AND '".$enddate."'  AND sitecode='".$site."'
) N on (a.patientID=N.patientID)

where  a.visitDate between  '".$startdate."' AND '".$enddate."'  AND sitecode='".$site."'
and p.patientID=a.patientID
GROUP BY 1 
order by 1",
"visitTotal"=> "SELECT 
COUNT( DISTINCT CASE WHEN  N.patientID is not null and p.hivPositive=1 THEN a.patientid ELSE NULL END ) AS 'Nouveau Patient VIH', 
COUNT( DISTINCT CASE WHEN  N.patientID is not null and (p.hivPositive<>1 or p.hivPositive is null) THEN a.patientid ELSE NULL END ) AS 'Nouveau Patient Non VIH',  
COUNT( DISTINCT CASE WHEN N.patientID is not null THEN a.patientid ELSE NULL END ) AS 'Nouveau Patient',   
COUNT( DISTINCT CASE WHEN p.hivPositive=1   THEN a.patientid ELSE NULL END ) AS 'Patient VIH', 
COUNT( DISTINCT CASE WHEN p.hivPositive<>1 or p.hivPositive is null  THEN a.patientid ELSE NULL END ) AS 'Patient Non VIH', 
COUNT( DISTINCT  a.patientid ) AS 'Total Patient'

FROM patient p,encValidAll a left join
(
SELECT patientID,visitDate
FROM encValidAll a
WHERE encounterType IN (10,15) 
And visitDate between  '".$startdate."' AND '".$enddate."'  AND sitecode='".$site."'
) N on (a.patientID=N.patientID)

where  a.visitDate between  '".$startdate."' AND '".$enddate."'  AND sitecode='".$site."'
and p.patientID=a.patientID
"	 
	   ); 
  
  $visit = outputQueryRows($queryArray["visit"]); 
  $visitTotal = outputQueryRows($queryArray["visitTotal"]);
  
  

  
  
  $summary = <<<EOF
  
 <script type="text/javascript">
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
  <td style="width: 30%;text-align: right; padding:15px;">
  <div><span style="font-family: Lucida Console; font-size: 12.0px;"><strong>Periode :</strong>   $period </span></div>
  </td>  
</tr>
</table>

<table width="90%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top" >
  <td style="width: 70%"> 
   <div><span style="font-family: Lucida Console; font-size: 12.0px; border:solid 1px black; padding:5px;"><strong>Institution :</strong> $siteName</span> 
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
<table width="90%" border="1">
  <tr>
    <td width="70%">
	<p>&nbsp;</p>
	<div><strong> Total de visite Par User durant la periode </strong></div>
	<p>&nbsp;</p>
	<div>$visitTotal</div>
	<div>&nbsp;</div>
	<p>&nbsp;</p>
	<div><strong> Total de visite Par date durant la periode </strong></div>
	<div>$visit</div>
	<div>&nbsp;</div>
	
	</td>
  </tr>
</table>


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

?>
