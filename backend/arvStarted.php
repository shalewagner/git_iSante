<?php
require_once ("backend.php");

require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";

function generatearvStarted ($startdate, $enddate,$site, $lang) {
  $dateTime = $lang == "fr" ? date ("d/m/y H:i:s") : date ("m/d/y H:i:s");
  $siteName = getSiteName ($site, $lang);
  $period=date("d-M-Y", strtotime($startdate)).' To '.date("d-M-Y", strtotime($enddate));
 
  $queryArray = array(
"arvStarted" => "select startDate as 'Date de visite',p.clinicPatientID as ST,lname as 'Prenom',fname as 'Nom',telephone,statusDescFr as Statut,case when p.sex=2 then 'M' when p.sex=1 then 'F' else 'I' end as sex,round(DATEDIFF(c.startDate,date(concat(p.dobYy,'-', case when p.dobMm is not null or p.dobMm<>'' then dobMm else '06' end ,'-', case when p.dobDd is not null or p.dobDd<>'' then dobDd else '15' end)))/365,0) as Age,date(concat(p.dobYy,'-', case when p.dobMm is not null or p.dobMm<>'' then dobMm else '06' end ,'-', case when p.dobDd is not null or p.dobDd<>'' then dobDd else '15' end)) as 'Date de Naissance'
from 
(select siteCode,patientID,min(visitDate) as startDate from pepfarTable where ifnull(forPepPmtct,0)=0 group by 1,2) c , patient p,patientStatusLookup p2
where c.patientID=p.patientID and p.patientStatus=p2.statusValue and  p.patientStatus in (6,8,9,1,2,3)  and  startDate between  '".$startdate."' AND '".$enddate."' And c.siteCode=".$site." order by 1",
"arvStartedTotal" =>"select count(distinct p.patientID) as Total
from 
(select siteCode,patientID,min(visitDate) as startDate from pepfarTable where ifnull(forPepPmtct,0)=0 group by 1,2) c , patient p
where c.patientID=p.patientID and p.patientStatus>0 and  startDate between  '".$startdate."' AND '".$enddate."' And c.siteCode=".$site); 
  
  $arvStarted = outputQueryRows($queryArray["arvStarted"]);
  $arvStartedTotal = outputQueryRows($queryArray["arvStartedTotal"]); 	
 
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

<div>&nbsp;</div>
<div>&nbsp;</div>


<form >
<table width="100%" >
  <tr>
    <td width="70%">
	<p>&nbsp;</p>
	<div><strong>Liste des patients ayant démarré un régime ARV</strong></div>
	<div width="50px">$arvStartedTotal</div>
	<div>&nbsp;</div>
	<div>$arvStarted</div>
	<p>&nbsp;</p>	
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
