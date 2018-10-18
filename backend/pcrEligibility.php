<?php
require_once ("backend.php");

require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";

function generatepatientEligibility ($startdate, $enddate,$site, $lang) {
  $dateTime = $lang == "fr" ? date ("d/m/y H:i:s") : date ("m/d/y H:i:s");
  $siteName = getSiteName ($site, $lang);
  $period=date("d-M-Y", strtotime($startdate)).' To '.date("d-M-Y", strtotime($enddate));
 
  $queryArray = array(
"eligibility" => "
select patientID,lname,fname,clinicPatientID,sex,statusDescFr as Statut,min(Naissance) as 'Date de naissance' from (
select distinct p.patientID,lname,fname,p.patientStatus,clinicPatientID,p.sex,ymdToDate(v.visitDateYy,v.visitDateMm,v.visitDateDd),date(concat(p.dobYy,'-', case when p.dobMm is not null or p.dobMm<>'' then dobMm else '06' end ,'-', case when p.dobDd is not null or p.dobDd<>'' then dobDd else '15' end)) as Naissance from vitals v,patient p 
where v.pedCurrHiv=1 
and p.patientID=v.patientID 
and p.patientID not in (select l.patientID from labs l where labID=181)
and datediff(now(),(ymdtodate(dobYy,case when dobMm='XX' or dobMm='' or dobMm is null then '01' else dobMm end,
		case when dobDd='XX' or dobDd='' or dobDd is null then '01' else dobDd end))) between 28 and 365
and ymdToDate(v.visitdateyy,v.visitdatemm,v.visitdatedd)<=now()
union all 
select distinct p.patientID,lname,fname,p.patientStatus,clinicPatientID,p.sex,ymdToDate(v.visitDateYy,v.visitDateMm,v.visitDateDd),date(concat(p.dobYy,'-', case when p.dobMm is not null or p.dobMm<>'' then dobMm else '06' end ,'-', case when p.dobDd is not null or p.dobDd<>'' then dobDd else '15' end)) as Naissance from labs v,patient p  
 where labID in (100,101) and (v.result=1 or upper(v.result) like 'POS%' )
 and p.patientID=v.patientID 
 and p.patientID not in (select l.patientID from labs l where labID=181)
 and datediff(now(),(ymdtodate(dobYy,case when dobMm='XX' or dobMm='' or dobMm is null then '01' else dobMm end,
		case when dobDd='XX' or dobDd='' or dobDd is null then '01' else dobDd end)))  between 366 and 548
 and ymdToDate(v.visitDateYy,v.visitDateMm,v.visitDateDd)<=now()) A,patientStatusLookup p2 where A.patientStatus=p2.statusValue group by 1,2,3,4,5,6;"); 
  
  $patientEligibility = outputQueryRows($queryArray["eligibility"]); 
 
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
	<div><strong>Patient ELigible pour un PCR </strong></div>
	<div>&nbsp;</div>
	<div>$patientEligibility</div>
	<p>&nbsp;</p>	
	</td>
  </tr>
</table>


</form>
<!-- ********************************************************************* -->
<!-- ****************** Ped. imm. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->

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
