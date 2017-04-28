<?php
require_once ("backend.php");

require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";

function generatearvDrug()
{
	
$lang = trim($_GET["lang"]);
$site = trim($_GET["site"]);
$endDate = trim($_GET["endDate"]);
$startDate = trim($_GET["startDate"]);
$rank = trim($_GET["rank"]);	
$siteName = getSiteName ($site, $lang);
$drugPeriod = '';
 switch ($rank)
 {
	 case '30' :$drugPeriod.=' And DATEDIFF( ymdToDate(`nxtVisitYy` ,  `nxtVisitMm` ,  `nxtVisitDd`), e.visitDate )<=30'; break;
	 case '60' :$drugPeriod.=' And DATEDIFF( ymdToDate(`nxtVisitYy` ,  `nxtVisitMm` ,  `nxtVisitDd`), e.visitDate ) BETWEEN 30 AND 60';break;
	 case '90' :$drugPeriod.=' And DATEDIFF( ymdToDate(`nxtVisitYy` ,  `nxtVisitMm` ,  `nxtVisitDd`), e.visitDate ) BETWEEN 60 AND 90';break;
	 case '120':$drugPeriod.=' And DATEDIFF( ymdToDate(`nxtVisitYy` ,  `nxtVisitMm` ,  `nxtVisitDd`), e.visitDate ) BETWEEN 90 AND 120';break;
	 case '130':$drugPeriod.=' And DATEDIFF( ymdToDate(`nxtVisitYy` ,  `nxtVisitMm` ,  `nxtVisitDd`), e.visitDate )>120';break;
	 default: $drugPeriod.='';
 }
$startDate = '2000-01-01';
$endDate = '2016-12-31';
 
$queryArray = array(
"arvDrug" => "SELECT max(ymdToDate(e.visitDateYy,e.visitDateMm,e.visitDateDd)) as visitDAte,e . patientID ,p.lname,p.fname 
FROM encounter e, prescriptions d, patient p,drugLookup l
WHERE e.encounterType IN (5,18) 
and d.seqNum = e.seqNum
and e.patientID=d.patientID
and e.patientID=p.patientID
and ymdToDate(d.visitDateYy,d.visitDateMm,d.visitDateDd)=ymdToDate(e.visitDateYy,e.visitDateMm,e.visitDateDd)
and d.drugID = l.drugID" . $drugPeriod . "
and l.drugGroup in ('NRTIs', 'NNRTIs', 'Pls','II') " . $drugPeriod . "
and ymdToDate(e.visitDateYy,e.visitDateMm,e.visitDateDd) between  '" . $startDate . "' AND '" . $endDate . "' group by 2"); 
  
  $arvDrug = outputQueryRows($queryArray["arvDrug"]); 
 
  $summary ='<table width="100%" >
  <tr>
    <td width="70%">
	<p>&nbsp;</p>
	<div><strong> Liste des patients ayant démarré les ARVs durant la période </strong></div>
	<div>&nbsp;</div>
	<div>'.$arvDrug.'</div>
	<p>'.$queryArray["arvDrug"].'</p>	
	</td>
  </tr>
</table>';

  return $summary;

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
<center>
<div>&nbsp;</div>
<div>&nbsp;</div>
<?php echo generatearvDrug(); ?>
</body>
</html>
