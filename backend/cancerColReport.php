<?php
require_once ("backend.php");

require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";

function generateCancerColPatient($startdate, $enddate,$site, $lang) {
  $dateTime = $lang == "fr" ? date ("d/m/y H:i:s") : date ("m/d/y H:i:s");
  $siteName = getSiteName ($site, $lang);
  $period=date("d-M-Y", strtotime($startdate)).' To '.date("d-M-Y", strtotime($enddate));   
	   
 
  $queryArray = array(
"cancerColScreened" => "select 
concat('<a href=\"cancerColList.php?rank=1&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">',count(distinct case when screenResult=2 then patientID else null end),'</a>') as  'Patient Dépisté avec résultat positive ou anormal',
concat('<a href=\"cancerColList.php?rank=2&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">', count(distinct case when screenResult=1 then patientID else null end),'</a>') as 'Patient Dépisté avec résultat negative ou normal',
concat('<a href=\"cancerColList.php?rank=3&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">',count(distinct case when screenResult in (1,2) then patientID else null end),'</a>') as 'Patient Dépisté avec résultat',
concat('<a href=\"cancerColList.php?rank=4&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">',count(distinct case when screenResult=4 or screenResult is null then patientID else null end),'</a>') as 'Patient Dépisté sans résultat',
concat('<a href=\"cancerColList.php?rank=5&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">',count(distinct patientID),'</a>') as 'Patient Dépisté'
from cancerCol where ScreenedDate is not null and visitDate between '".$startdate."' AND '".$enddate."'  and LEFT(patientid,5)=".$site,
"cancerColTreatment" => "select 
concat('<a href=\"cancerColList.php?rank=6&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">',count(distinct case when treatment is not null and treatment<>'' then patientID else null end),'</a>') as  'Patient  ELigible traité pour le cancer du col',
concat('<a href=\"cancerColList.php?rank=7&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">', count(distinct case when treatment is null or treatment='' then patientID else null end),'</a>') as 'Patient  ELigible non traité pour le cancer du col',
concat('<a href=\"cancerColList.php?rank=8&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">',count(distinct patientID),'</a>') as 'Patient Eligible'
from cancerCol where ScreenedDate is not null and screenResult=2 and visitDate between '".$startdate."' AND '".$enddate."'  and LEFT(patientid,5)=".$site
); 
  
  $cancerColScreened = outputQueryRows($queryArray["cancerColScreened"]); 
  $cancerColTreatment = outputQueryRows($queryArray["cancerColTreatment"]); 
 
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
	<div style="padding-left:50px"><strong>Patient Dépisté  pour le cancer du col(CXCA_SCRN) </strong></div>
	<div>&nbsp;</div>
	<div>$cancerColScreened</div>
	<p>&nbsp;</p>	
	<div style="padding-left:50px"><strong>Patient traité  pour le cancer du col(CXCA_TX) </strong></div>
	<div>&nbsp;</div>
	<div>$cancerColTreatment</div>
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
