<?php
require_once ("backend.php");

require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";




function generateviralList()
{
	
$lang = trim($_GET["lang"]);
$site = trim($_GET["site"]);
$endDate = trim($_GET["endDate"]);
$startDate = trim($_GET["startDate"]);
$viral = trim($_GET["viral"]);	
$siteName = getSiteName ($site, $lang);
$viralClause=' And 1=1';
$message='Liste de patients avec un resultat de charge viral';
 switch ($viral)
 {
	 case '0' :{$viralClause.=' And ifnull(result,0)+0<=1000'; $message.=' <= 1000 copies/ml '; break;}
	 case '1' :{$viralClause.=' And ifnull(result,0)+0>1000'; $message.=' > 1000 copies/ml  :';break;}
	 default: $viralClause.='';
 }
 
$queryArray = array(
"viralLoad" => "select  distinct clinicPatientID as ST,p.lname as 'Prenom',p.fname as 'Nom',telephone
from patient p, (SELECT distinct patientid, date(ymdToDate(visitdateyy,visitDateMm,visitDateDd)) as visitDate, result
FROM labs WHERE labID IN (103, 1257) and result IS NOT NULL) e
where e.patientid=p.patientID ".$viralClause."
and e.visitDate between '".$startDate."' AND '".$endDate."' and  LEFT(p.patientid,5)=".$site); 
  
  $viralLoad = outputQueryRows($queryArray["viralLoad"]); 
 
  $summary ='<table width="100%" >
  <tr>
    <td width="70%">
	<p>&nbsp;</p>
	<div><strong> '.$message.'  </strong></div>
	<div>&nbsp;</div>
	<div>'.$viralLoad.'</div>
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
<?php echo generateviralList(); ?>
</body>
</html>
