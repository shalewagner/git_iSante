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
$drugPeriod=' And 1=1';
$message='Liste de patients ayant reçu des ARV pour la période allant de ';
 switch ($rank)
 {
	 case '35' :{$drugPeriod.=' And DATEDIFF(nxt_dispd, p1.dispd) BETWEEN 0 and 35'; $message.=' 0 a 35 jours'; break;}
	 case '90' :{$drugPeriod.=' And DATEDIFF(nxt_dispd, p1.dispd) BETWEEN 36 AND 89'; $message.=' 36 a 89 jours';break;}
	 case '120' :{$drugPeriod.=' And DATEDIFF(nxt_dispd, p1.dispd) BETWEEN 90 AND 120'; $message.=' 90 a 120 jours';break;}
	 case '180':{$drugPeriod.=' And DATEDIFF(nxt_dispd, p1.dispd) BETWEEN 121 AND 180'; $message.=' 121 a 180 jours';break;}
	 case '200':{$drugPeriod.=' And DATEDIFF(nxt_dispd, p1.dispd) > 180'; $message=' Liste de patients ayant reçu des ARV pour plus de 180 jours'; break;}
	 default: $drugPeriod.='';
 }
 
$queryArray = array(
"arvDrug" => "SELECT p1.dispd as 'Date de dispensation',p.clinicPatientID as ST,p.lname as 'Prenom',p.fname as 'Nom',telephone as Telephone
from patientDispenses p1,clinicLookup l,patient p, 
(SELECT patientID,max(dispd) as dispd FROM  patientDispenses  p  where dispd between '".$startDate."' AND '".$endDate."'  group by 1) p2
where p1.patientID=p2.patientID and p1.dispd=p2.dispd and p.patientID=p1.patientID
and p1.dispd<p1.nxt_dispd and l.siteCode=LEFT(p1.patientid,5)". $drugPeriod."   and p.location_id=".$site."
group by 2,3,4 order by 1 desc"); 

  $arvDrug = outputQueryRows($queryArray["arvDrug"]); 
 
  $summary ='<table width="100%" >
  <tr>
    <td width="70%">
	<p>&nbsp;</p>
	<div><strong> '.$message.'  </strong></div>
	<div>&nbsp;</div>
	<div>'.$arvDrug.'</div>	
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
