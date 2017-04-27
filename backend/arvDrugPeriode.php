<?php
require_once ("backend.php");

require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";

function generatearvPatient ($startdate, $enddate,$site, $lang) {
  $dateTime = $lang == "fr" ? date ("d/m/y H:i:s") : date ("m/d/y H:i:s");
  $siteName = getSiteName ($site, $lang);
  $period=date("d-M-Y", strtotime($startdate)).' To '.date("d-M-Y", strtotime($enddate));
 
  $queryArray = array(
"arvDrug" => "select 
concat('<a href=\"arvDrugPeriodeList.php?rank=35&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">',count(distinct case when DATEDIFF(nxt_dispd, p1.dispd) BETWEEN 0 and 35 then p1.patientID else null end),'</a>') as  '0-35 jours',
concat('<a href=\"arvDrugPeriodeList.php?rank=90&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">',count(distinct case when DATEDIFF(nxt_dispd, p1.dispd) BETWEEN 36 AND 89 then p1.patientID else null end),'</a>') as '36-89 jours',
concat('<a href=\"arvDrugPeriodeList.php?rank=120&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">',count(distinct case when DATEDIFF(nxt_dispd, p1.dispd) BETWEEN 90 AND 120 then p1.patientID else null end),'</a>') as '90-120 jours',
concat('<a href=\"arvDrugPeriodeList.php?rank=180&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">',count(distinct case when DATEDIFF(nxt_dispd, p1.dispd) BETWEEN 121 AND 180 then p1.patientID else null end),'</a>') as '121-180 jours',
concat('<a href=\"arvDrugPeriodeList.php?rank=200&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">',count(distinct case when DATEDIFF(nxt_dispd, p1.dispd) > 180 then p1.patientID else null end),'</a>') as '>180 jours', 
count(distinct p1.patientid) as 'Patient Unique '
from patientDispenses p1,clinicLookup l, 
(SELECT patientID,max(dispd) as dispd FROM  patientDispenses  p  where dispd between '".$startdate."' AND '".$enddate."'  group by 1) p2
where p1.patientID=p2.patientID and p1.dispd=p2.dispd 
and p1.dispd<p1.nxt_dispd and l.siteCode=LEFT(p1.patientid,5) and  LEFT(p1.patientid,5)=".$site); 
  
  $arvDrug = outputQueryRows($queryArray["arvDrug"]); 
 
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
	<div><strong> Nombre de patients ayant reçu des ARV par période </strong></div>
	<div>&nbsp;</div>
	<div>$arvDrug</div>
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
