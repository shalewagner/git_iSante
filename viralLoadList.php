<?php
require_once ("/usr/share/isante/htdocs/backend.php");

require_once '/usr/share/isante/htdocs/backend/config.php';
require_once '/usr/share/isante/htdocs/backend/database.php';
require_once '/usr/share/isante/htdocs/backend/materializedViews.php';
require_once "/usr/share/isante/htdocs/include/standardHeaderExt.php";




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
	 case '0' :{$viralClause.=' And digits(result)+0<1000'; $message.=' < 1000 copies/ml '; break;}
	 case '1' :{$viralClause.=' And digits(result)+0>=1000'; $message.=' >= 1000 copies/ml  :';break;}
	 default: $viralClause.='';
 }
 
$queryArray = array(
"viralLoad" => "select  distinct clinicPatientID as ST,p.lname as Prenom,p.fname as Nom,case when p.sex=2 then 'M' when p.sex=1 then 'F' else 'I' end as Sexe,round(DATEDIFF(la.visitDate,ymdToDate(p.dobYy,p.dobMm,p.dobDd))/365,0) as Age,telephone
FROM patient p,labs l,(select patientID,max(ymdToDate(visitdateyy,visitDateMm,visitDateDd)) as visitDate from labs where labID in (103,1257) group by 1) la
WHERE l.labID IN (103, 1257) and digits(l.result)>0
and la.visitDate=date(ymdToDate(l.visitdateyy,l.visitDateMm,l.visitDateDd))
and la.patientID=l.patientID
and p.patientID=l.patientID ".$viralClause."
and date(ymdToDate(l.visitdateyy,l.visitDateMm,l.visitDateDd)) between ? AND ? and  LEFT(l.patientid,5)=?"); 
 
$param=array($startDate,$endDate,$site);
  
  $viralLoad = outputQueryRows($queryArray["viralLoad"],$param); 
  $summary ='<table width="100%" >
  <tr>
    <td width="70%">
	<p>&nbsp;</p>
	<div><strong> '.$message.' </strong></div>
	<div>&nbsp;</div>
	<div>'.$viralLoad.'</div>
	</td>
  </tr>
</table>';

  return $summary;

}

function outputQueryRows($qry,$param) {
        $output = '';
        // execute the query 
        $arr = database()->query($qry,$param)->fetchAll(PDO::FETCH_ASSOC); 
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
