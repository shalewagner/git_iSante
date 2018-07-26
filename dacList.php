<?php
require_once ("backend.php");

require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";




function generatedacList()
{
	
$lang = trim($_GET["lang"]);
$site = trim($_GET["site"]);
$endDate = trim($_GET["endDate"]);
$startDate = trim($_GET["startDate"]);
$disp = trim($_GET["disp"]);	
$siteName = getSiteName ($site, $lang);
$dispClause=' And 1=1';
$message='Liste de patients ayant reçu des ARVs ';
 switch ($disp)
 {
	 case '0' :{$dispClause.=' And ifnull(o.value_boolean,0)=0'; $message.=' en communauté :'; break;}
	 case '1' :{$dispClause.=' And ifnull(o.value_boolean,0)=1'; $message.=' dans l`Institution :';break;}
	 default: $dispClause.='';
 }
 
$queryArray = array(
"arvDrug" => "select  distinct p.clinicPatientID as ST,p.lname as 'Prenom',p.fname as 'Nom',p.sex,DATEDIFF(disp,dbo.ymdToDate(p.dobYy, case when p.dobMm is not null or p.dobMm<>'' then dobMm else '06' end , case when p.dobDd is not null or p.dobDd<>'' then dobDd else '15' end )/365 as Age,telephone
from patient p,
(select max(visitDate) as visitDate,patientID from v_prescriptions  e 
where drugid IN ( 1, 3, 4, 5, 6, 7, 8, 10, 11, 12, 15, 16, 17, 20, 21, 22, 23, 26, 27, 28, 29, 31, 32, 33, 34, 87, 88)
and e.dispensed=1
and e.visitDate between '".$startDate."' AND '".$endDate."' and  LEFT(e.patientid,5)=".$site." 
group by patientID
)p1,v_prescriptions e  left outer join obs o  on (e.encounter_id=o.encounter_id and o.concept_id='71642' and o.value_boolean=1)
where drugid IN ( 1, 3, 4, 5, 6, 7, 8, 10, 11, 12, 15, 16, 17, 20, 21, 22, 23, 26, 27, 28, 29, 31, 32, 33, 34, 87, 88)
and e.dispensed=1 and p1.visitDate=e.visitDate and e.patientID=p1.patientID and p.patientID=e.patientID".$dispClause."
and e.visitDate between '".$startDate."' AND '".$endDate."' and  LEFT(p.patientid,5)=".$site); 
  
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
<?php echo generatedacList(); ?>
</body>
</html>
