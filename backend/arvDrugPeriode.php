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
"arvDrug" => "SELECT count(distinct e . patientID) as patientCount , 
concat('<a href=\"arvDrugPeriodeList.php?rank=30&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">',count(distinct case when DATEDIFF( ymdToDate(`nxtVisitYy` ,  `nxtVisitMm` ,  `nxtVisitDd`), e.visitDate )<=30  then e.patientID else null end),'</a>') as '0-30',
concat('<a href=\"arvDrugPeriodeList.php?rank=60&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">',count(distinct case when DATEDIFF( ymdToDate(`nxtVisitYy` ,  `nxtVisitMm` ,  `nxtVisitDd`), e.visitDate )>30 and  
	      DATEDIFF( ymdToDate(`nxtVisitYy` ,  `nxtVisitMm` ,  `nxtVisitDd`), e.visitDate )<=60 then e.patientID else null end) ,'</a>') as  '31-60',
concat('<a href=\"arvDrugPeriodeList.php?rank=90&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">',count(distinct case when DATEDIFF( ymdToDate(`nxtVisitYy` ,  `nxtVisitMm` ,  `nxtVisitDd`), e.visitDate )>60 and  
	      DATEDIFF( ymdToDate(`nxtVisitYy` ,  `nxtVisitMm` ,  `nxtVisitDd`), e.visitDate )<=90 then e.patientID else null end) ,'</a>') as  '61-90',	
concat('<a href=\"arvDrugPeriodeList.php?rank=120&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">',count(distinct case when DATEDIFF( ymdToDate(`nxtVisitYy` ,  `nxtVisitMm` ,  `nxtVisitDd`), e.visitDate )>90 and  
	      DATEDIFF( ymdToDate(`nxtVisitYy` ,  `nxtVisitMm` ,  `nxtVisitDd`), e.visitDate )<=120 then e.patientID else null end) ,'</a>') as '91-120',
concat('<a href=\"arvDrugPeriodeList.php?rank=130&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">',count(distinct case when DATEDIFF( ymdToDate(`nxtVisitYy` ,  `nxtVisitMm` ,  `nxtVisitDd`), e.visitDate )>120  then e.patientID else null end) ,'</a>') as  '121 +'	 
FROM  `encounter` e, prescriptions d, drugLookup l
WHERE e.encounterType IN (5,18) 
and d.seqNum=e.seqNum
and e.patientID=d.patientID
and ymdToDate(d.visitDateYy,d.visitDateMm,d.visitDateDd)=ymdToDate(e.visitDateYy,e.visitDateMm,e.visitDateDd)
and d.drugID = l.drugID 
and l.drugGroup in ('NRTIs', 'NNRTIs', 'Pls','II')
and ymdToDate(e.visitDateYy,e.visitDateMm,e.visitDateDd) between  '".$startdate."' AND '".$enddate."'"); 
  
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
	<div><strong> Liste des patients ayant démarré les ARVs durant la période </strong></div>
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