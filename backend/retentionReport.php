<?php
require_once ("backend.php");

require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";

function generateRetention($startdate, $enddate,$site, $lang) {
  $dateTime = $lang == "fr" ? date ("d/m/y H:i:s") : date ("m/d/y H:i:s");
  $siteName = getSiteName ($site, $lang);
  $period=date("d-M-Y", strtotime($startdate)).' To '.date("d-M-Y", strtotime($enddate));
  $tableName="retentionArvTmp".date ("mdyHis");
  database()->exec("DROP TABLE IF EXISTS ".$tableName);
  database()->exec("create table ".$tableName." (siteCode varchar(20),patientID varchar(25),monthDate date,visitNumber45 int);");

/* Generate viralLoadTemp */
database()->exec("insert into ".$tableName." (siteCode,patientID,monthDate)  select siteCode,patientID,date_add(date_add(LAST_DAY(start),interval 1 DAY),interval -1 MONTH) as startDate 
from ( select siteCode,patientID,min(visitDate) as start from pepfarTable group by 1,2 ) A where start between date_add(".$startdate.",interval -12 month) and date_add(".$enddate.",interval -12 month);");


database()->exec("update ".$tableName."  A,encounter e set A.visitNumber45=1  
where e.patientID=A.patientID and 
      A.siteCode=e.siteCode and 
	  ymdToDate(e.visitDateYy,e.visitDateMm,e.visitDateDd) between date_add(A.monthDate,interval -45 day) and date_add(A.monthDate,interval 75 day)
	  and ymdToDate(e.visitDateYy,e.visitDateMm,e.visitDateDd) between date_add(date_add(LAST_DAY(".$startdate."),interval 1 DAY),interval -1 MONTH) and date_add(date_add(LAST_DAY(".$enddate."),interval 1 DAY),interval -1 MONTH);");

   
  
  
 
  $queryArray = array(
"retentionArv" => "select monthDate,l.clinic,count(distinct patientID) as Deno,count(distinct case when visitNumber45=1 then patientID else null end) as Num
from ".$tableName."  a,clinicLookup l 
where l.siteCode=a.siteCode group by 1,2;"); 
  
  $retentionArv = outputQueryRows($queryArray["retentionArv"]); 
 database()->exec("DROP TABLE IF EXISTS ".$tableName);
 
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
<center>
<div>&nbsp;</div>
<div>&nbsp;</div>


<form >
<table width="100%" >
  <tr>
    <td width="70%">
	<p>&nbsp;</p>
	<div><strong>La liste des patients </strong></div>
	<div>&nbsp;</div>
	<div>$retentionArv</div>
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
