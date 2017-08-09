<?php
require_once ("backend.php");

require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";

function generateViral($startdate, $enddate,$site, $lang) {
  $dateTime = $lang == "fr" ? date ("d/m/y H:i:s") : date ("m/d/y H:i:s");
  $siteName = getSiteName ($site, $lang);
  $period=date("d-M-Y", strtotime($startdate)).' To '.date("d-M-Y", strtotime($enddate));
 
 $lien1="<a href=\"viralLoadList.php?viral=0&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">";
 $a='</a>';
 $col1='Patient avec un resultat de charge viral < 1000 copies/ml';
 $lien2="<a href=\"viralLoadList.php?viral=1&site=".$site."&endDate=".$enddate."&startDate=".$startdate."&lang=".$lang."\">";
 $col2='Patient avec un resultat de charge viral >= 1000 copies/ml';
 $col3='Patient Unique';
 
 $param=array($lien1,$a,$col1,$lien2,$a,$col2,$col3,$startdate,$enddate,$site);
 
  $queryArray = array(
"viralLoad" => "select 
concat(?,count(distinct case when digits(result)+0<1000 then l.patientID else null end),?) as ? ,
concat(?,count(distinct case when digits(result)+0>=1000 then l.patientID else null end),?)as ?,
count(distinct l.patientID) as ?
FROM labs l,(select patientID,max(ymdToDate(visitdateyy,visitDateMm,visitDateDd)) as visitDate from labs where labID in (103,1257) group by 1) la
WHERE l.labID IN (103, 1257) and l.result IS NOT NULL and digits(l.result)>0
and la.visitDate=date(ymdToDate(l.visitdateyy,l.visitDateMm,l.visitDateDd))
and la.patientID=l.patientID
and date(ymdToDate(l.visitdateyy,l.visitDateMm,l.visitDateDd)) between ? AND ? and  LEFT(l.patientid,5)=?"); 
  
  $viralLoad = outputQueryRows($queryArray["viralLoad"],$param); 
 
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
<table width="90%" cellpadding="0" cellspacing="0" border="0">
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
	<div ><strong> Charge virale en fonction du nombre de copies </strong></div>
	<div>&nbsp;</div>
	<div>$viralLoad</div>
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



function outputQueryRows($qry,$param) {
        $output = '';
        // execute the query 
        $arr = database()->query($qry,$param)->fetchAll(PDO::FETCH_ASSOC); 
        if (count($arr) == 0) return '<p><center><font color="red"><bold>Aucuns résultats trouvés</bold></font></center><p>';
        // set up the table
        $output = '<table class="" width="90%" border="1" cellpadding="0" cellspacing="0">';
        // loop on the results 
        $i = 0;
        foreach($arr as $row) {
               if ($i == 0) { 
                       // output the column header 
                       $output .= '<tr>';
                       foreach($row as $key => $value) $output .= '<th style="float:center;">' . $key . '</th>';
                       $output .= '</tr>'; 
                       $i++;
               } 
               $output .= '<tr>';
               foreach($row as $key => $value) $output .= '<td style="font-family: Lucida Console; font-size: 12.0px; padding:3px; float:center;">' . $value . '</td>';
               $output .= '</tr>';
        }
        // close the table 
        $output .= '</table>';
        return $output;
}

?>
