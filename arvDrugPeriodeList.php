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
 switch ($rank)
 {
	 case '30' :$drugPeriod.=' And DATEDIFF(nxt_dispd, dispd)<=30'; break;
	 case '60' :$drugPeriod.=' And DATEDIFF(nxt_dispd, dispd)>30'. ' And DATEDIFF(nxt_dispd, dispd)<=60';break;
	 case '90' :$drugPeriod.=' And DATEDIFF(nxt_dispd, dispd)>60'. ' And DATEDIFF(nxt_dispd, dispd)<=90';break;
	 case '120':$drugPeriod.=' And DATEDIFF(nxt_dispd, dispd)>90'. ' And DATEDIFF(nxt_dispd, dispd)<=120';break;
	 case '130':$drugPeriod.=' And DATEDIFF(nxt_dispd, dispd)>120';break;
	 default: $drugPeriod.='';
 }
 
$queryArray = array(
"arvDrug" => "SELECT p1.dispd as 'Date de dispensation',p. patientID ,p.lname as 'Prenom',p.fname as 'Nom'
FROM   patientDispenses p1,patient p 
WHERE  p1.patientID=p.patientID". $drugPeriod."
and p1.dispd between  '".$startDate."' AND '".$endDate."' group by 2,3,4"); 
  
  $arvDrug = outputQueryRows($queryArray["arvDrug"]); 
 
  $summary ='<table width="100%" >
  <tr>
    <td width="70%">
	<p>&nbsp;</p>
	<div><strong> Liste de patients ayant reçu des ARV pour une période  </strong></div>
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
