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
$whereClause=' And 1=1';
$message='';
 switch ($rank)
 {
	 case '1' :{$whereClause.=" And screenResult=2 "; $message.="Patient Dépisté avec résultat positive ou anormal"; break;}
	 case '2' :{$whereClause.=" And screenResult=1 "; $message.="Patient Dépisté avec résultat negative ou normal";break;}
	 case '3' :{$whereClause.=" And screenResult in (1,2)"; $message.="Patient Dépisté avec résultat";break;}
	 case '4' :{$whereClause.=" And (screenResult=4 or screenResult is null)"; $message.="Patient Dépisté sans résultat";break;}
	 case '5' :{$whereClause.=""; $message="Patient Dépisté"; break;}
	 case '6' :{$whereClause.=" And screenResult=2 AND treatment is not null and treatment<>''"; $message="atient  ELigible traité pour le cancer du col"; break;}
	 case '7' :{$whereClause.=" And screenResult=2 AND treatment is null or treatment=''"; $message=" Patient  ELigible non traité pour le cancer du col"; break;}
	 case '8' :{$whereClause.="And screenResult=2"; $message="Patient Eligible"; break;}
	 default: $whereClause.="";
 }
 
$queryArray = array(
"cancerCol" => "select StCode, DateNaiss, age, Sexe , ScreenedDate ,visitDate,treatmentDate,treatment
from cancerCol where ScreenedDate is not null and visitDate between '".$startDate."' AND '".$endDate."'  and LEFT(patientid,5)=".$site." ".$whereClause
);


  $cancerCol = outputQueryRows($queryArray["cancerCol"]); 
 
  $summary ='<table width="100%" >
  <tr>
    <td width="70%">
	<p>&nbsp;</p>
	<div><strong> '.$message.'  </strong></div>
	<div>&nbsp;</div>
	<div>'.$cancerCol.'</div>	
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
