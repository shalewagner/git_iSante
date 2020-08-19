<?php
require_once ("backend.php");

require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";

function generatenextVisit($startdate, $enddate,$site, $lang) {
  $dateTime = $lang == "fr" ? date ("d/m/y H:i:s") : date ("m/d/y H:i:s");
  $siteName = getSiteName ($site, $lang);
  $period=date("d-M-Y", strtotime($startdate)).' To '.date("d-M-Y", strtotime($enddate));
 
  $queryArray = array(
"nextVisit" => "select clinicPatientID as ST,lname as Prenom,fname as Nom,telephone,sex,Age,birthDate as 'Date de naissance',dispenseDate as 'Date de dispensation Prevue' from (
SELECT p.patientID,clinicPatientID,lname,fname,telephone,ymdToDate(dobYy,dobMm,dobDd) as birthDate,case when p.sex=2 then 'M' when p.sex=1 then 'F' else 'I' end as sex,round(DATEDIFF(max(p1.dispd),date(concat(p.dobYy,'-', case when p.dobMm is not null or p.dobMm<>'' then dobMm else '06' end ,'-', case when p.dobDd is not null or p.dobDd<>'' then dobDd else '15' end)))/365,0) as Age,max(nxt_dispd) as dispenseDate
from patient p, patientDispenses p1
where p1.patientID=p.patientID and p.patientStatus in (6,7,8)  and p.location_id=".$site."
group by 1,2,3,4,5,6,7
) A where DATEDIFF(dispenseDate, CURDATE()) between -90 and 0   order by 5"); 
  
  $nextVisit = outputQueryRows($queryArray["nextVisit"]); 
 
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
<center><div>&nbsp;</div><div>&nbsp;</div>
<form >
<table width="100%" >
  <tr>
    <td width="70%">
	<p>&nbsp;</p>
	<div><strong>La liste des patients dont la date de renflouement des ARV est arrivée à terme</strong></div>
	<div>&nbsp;</div>
	<div>$nextVisit</div>
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
