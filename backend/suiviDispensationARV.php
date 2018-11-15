<?php
require_once ("backend.php");
require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";

function generatearvPatient ($site, $lang) {
  $dateTime = $lang == "fr" ? date ("d/m/y H:i:s") : date ("m/d/y H:i:s");
  $siteName = getSiteName ($site, $lang);
 
  $queryArray = array(
"arvpatient"=> "select concat('<a href=\"patienttabs.php?pid=',patientID,'&lang=fr&site=".$site."\">',STCode,'</a>') as STCode,lname,fname,DateNaiss as 'Date de Naissance',age,Sexe,dateInitiationARV as 'Date Initiation ARV',derniereVisite as 'Derniere Visite',derniereRDVARV as 'Dernier RDV Arv',prochainRendezVousARV as 'Prochain Randez-vous ARV',nombreDeJours as 'Nombre de Jours' from suiviDispArv;"); 
  
  $arvpatient = outputQueryRows($queryArray["arvpatient"]); 
 
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
<form >
<table width="100%" >
  <tr>
    <td width="70%">
	<p>&nbsp;</p>
	<div><strong> Suivi dispensation ARV </strong></div>
	<div>&nbsp;</div>
	<div>$arvpatient</div>
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
		database()->exec('drop table if exists suiviDispArv;');
		
		database()->exec('create table if not exists suiviDispArv ( patientID varchar(20),STCode varchar(20),lname varchar(20),fname varchar(20), DateNaiss varchar(30), age varchar(20), Sexe varchar(20), dateInitiationARV varchar(30),derniereVisite varchar(30),derniereRDVARV varchar(30),prochainRendezVousARV varchar(30), nombreDeJours int(11));');
		
		database()->query("insert into suiviDispArv (patientID, STCode,DateNaiss,age,Sexe,lname,fname,dateInitiationARV)
select p.patientID,p.clinicPatientID as ST,date(concat(p.dobYy,?, case when p.dobMm is not null or p.dobMm<>? then dobMm else ? end ,?, case when p.dobDd is not null or p.dobDd<>? then dobDd else ? end)),round(DATEDIFF(now(),date(concat(p.dobYy,?, case when p.dobMm is not null or p.dobMm<>? then dobMm else ? end ,?, case when p.dobDd is not null or p.dobDd<>? then dobDd else ? end)))/365,0) as Age,case when p.sex=2 then ? when p.sex=1 then ? else ? end as sex,p.lname,p.fname,startDate as dateInitiationARV
from (select siteCode,patientID,min(visitDate) as startDate from pepfarTable where ifnull(forPepPmtct,0)=0 group by 1,2) c , patient p
where c.patientID=p.patientID ;",array('-','','06','-','','15','-','','06','-','','15','M','F','I'));

database()->exec('update suiviDispArv r,(select patientID,max(ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd)) maxDt from encounter e  where encountertype in (1,2,5,10,14,15,16,17,18,20,24,25,26,27,28,29,31) AND e.encStatus < 255 group by 1) S
set r.derniereVisite=S.maxDt where r.patientID=S.patientID;');

database()->exec('update suiviDispArv r,
(select patientID,max(dispd) as dispd,max(nxt_dispd) as nxt_dispd from patientDispenses group by 1) s
set r.derniereRDVARV=s.dispd,r.prochainRendezVousARV=s.nxt_dispd where r.patientID=s.patientID;');

database()->query("update suiviDispArv r,(select p.patientID,numDaysDesc,CASE WHEN ymdtodate(p.dispdateyy,p.dispdatemm,p.dispdatedd) IS NOT NULL and p.dispdateyy != ? and p.dispdatemm != ?  THEN ymdtodate(dispdateyy,dispdatemm,dispdatedd) ELSE ymdToDate(e.visitdateyy,e.visitdatemm,e.visitdatedd) END as dispd from prescriptions p, encounter e WHERE e.encountertype in (5,18) AND encStatus < 255 AND p.patientid = e.patientid AND p.sitecode = e.sitecode AND p.visitdateyy = e.visitdateyy AND p.visitdatemm = e.visitdatemm AND p.visitdatedd = e.visitdatedd AND p.seqNum = e.seqNum AND drugid IN ( 1, 3, 4, 5, 6, 7, 8, 10, 11, 12, 15, 16, 17, 20, 21, 22, 23, 26, 27, 28, 29, 31, 32, 33, 34, 87, 88,89,90,91) AND (dispensed = 1 OR dispAltNumPills IS NOT NULL OR ISDATE(ymdtodate(dispdateyy,dispdatemm,dispdatedd)) = 1 OR dispAltNumDays IS NOT NULL OR dispAltDosage IS NOT NULL) AND (forPepPmtct = 2 OR forPepPmtct IS NULL)) s
set r.nombreDeJours=s.numDaysDesc  where r.patientID=s.patientID and r.derniereRDVARV=s.dispd;",array('un','un'));
		
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
