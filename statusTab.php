<?php
require_once ("backend.php");
require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'labels/splash.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";

function generateStatus()
{
$lang = trim($_GET["lang"]);
$site = trim($_GET["site"]);
$endDate = trim($_GET["endDate"]);
$startDate = trim($_GET["startDate"]);	
$siteName = getSiteName ($site, $lang);

/* Site info*/
 
 $siteInfo="select clinic,rtrim(c.sitecode) as sitecode, 
                   case when c.dbSite !=0 then '" . $splashLabels[$lang]['sLocal'] . "' else '' end as 'local', 
				   dbVersion, 
				   case when max(lastmodified) is null then '2000-01-01' else max(DATE_FORMAT(lastmodified,'%Y-%m-%d')) end as 'maxDate'
				   from clinicLookup c, encounter e 
				   where e.encStatus< 255 and e.sitecode = c.sitecode and c.incphr = 1 
				   group by clinic, c.sitecode, case when c.dbSite != 0 then '" . $splashLabels[$lang]['sLocal'] . "' else '' end, dbVersion order by 5 desc";  
$result =databaseSelect()->query($siteInfo);

$info='
<tr style="text-align:left; background-color:#C7D0D3;border-collapse: collapse; border: 1px solid #C0D8DA">
<th>Etablissement</th><th>sitecode</th><th>Server local</th><th>Version</th><th>Date recente</th>
<th>Regulier</th><th>Rendez-vous Rate</th><th>perdu de vu</th><th>Arrete</th><th>Transferer</th><th>Decede</th><th>Total ART</th>
<th>Recent</th><th>Actif</th><th>perdu de vu</th><th>Transferer</th><th>Decede</th><th>Total PRE-ART</th>
<th>Autres patients VIH</th><th>Total General</th></tr>';
$i=0;
while ($statusRow = $result->fetch()) {
	$red='';
	$diff = round(abs(time()-strtotime($statusRow['maxDate']))/(3600*24),0);
	if($diff>15) $red='color:#F00;';	
	$style='style="text-align:right; background-color:#FFF;border-collapse: collapse; border: 1px hidden #666;'.$red.'"';

	if($i=1) {$style='style="text-align:right; background-color:#E8E8E8;border-collapse: collapse; border: 1px hidden #666;'.$red.'"'; $i=0;}
	else $i=1;
	
    $info=$info.'<tr '.$style.'><td>'.$statusRow['clinic'].'</td><td>'. $statusRow['sitecode'].'</td><td>'. $statusRow['local'].'</td><td>'.$statusRow['dbVersion'].'</td><td>'.$statusRow['maxDate'].'</td>';

/* patient Status ART */
		$patStatusart="select 
		            count(distinct case when p.patientStatus=1 and (year(now())-p.dobYy)<=14 then p.patientID else null end) as artDeathChild,
					count(distinct case when p.patientStatus=1 and (year(now())-p.dobYy)>14 then p.patientID else null end) as artDeathAdl,
                    count(distinct case when p.patientStatus=2 and (year(now())-p.dobYy)<=14 then p.patientID else null end) as artTransfertChild,
					count(distinct case when p.patientStatus=2 and (year(now())-p.dobYy)>14 then p.patientID else null end) as artTransfertAdl,
                    count(distinct case when p.patientStatus=3 and (year(now())-p.dobYy)<=14 then p.patientID else null end) as artStoppedChild,
                    count(distinct case when p.patientStatus=3 and (year(now())-p.dobYy)>14 then p.patientID else null end) as artStoppedAdl,
					count(distinct case when p.patientStatus=6 and (year(now())-p.dobYy)<=14 then p.patientID else null end) as artRegularChild,
                    count(distinct case when p.patientStatus=6 and (year(now())-p.dobYy)>14 then p.patientID else null end) as artRegularAdl,
					count(distinct case when p.patientStatus=8 and (year(now())-p.dobYy)<=14 then p.patientID else null end) as artMissingChild,
                    count(distinct case when p.patientStatus=8 and (year(now())-p.dobYy)>14 then p.patientID else null end) as artMissingAdl,
					count(distinct case when p.patientStatus=9 and (year(now())-p.dobYy)<=14 then p.patientID else null end) as artLostChild,
					count(distinct case when p.patientStatus=9 and (year(now())-p.dobYy)>14 then p.patientID else null end) as artLostAdl,
					count(distinct case when p.hivPositive=1 and (year(now())-p.dobYy)<=14 then p.patientID else null end) as artTotalChild,
					count(distinct case when p.hivPositive=1 and (year(now())-p.dobYy)>14 then p.patientID else null end) as artTotalAdl
            from patient p,clinicLookup c,encounter e 
            where c.sitecode=LEFT(p.patientid,5) and  p.patientStatus in (1,2,3,6,8,9) and e.patientID=p.patientid and c.sitecode=". $statusRow['sitecode'];
 $result1 =database()->query($patStatusart);

while ($statusRow1 = $result1->fetch()) {
       $info=$info.'<td>'.$statusRow1['artRegularChild'].'/'.$statusRow1['artRegularAdl'].'</td>
	                <td>'.$statusRow1['artMissingChild'].'/'.$statusRow1['artMissingAdl'].'</td>
	                <td>'. $statusRow1['artLostChild'].'/'.$statusRow1['artLostAdl'].'</td>
					<td>'.$statusRow1['artStoppedChild'].'/'.$statusRow1['artStoppedAdl'].'</td>
					<td>'.$statusRow1['artTransfertChild'].'/'.$statusRow1['artTransfertAdl'].'</td>
	                <td>'.$statusRow1['artDeathChild'].'/'.$statusRow1['artDeathAdl'].'</td>
					<td>'.$statusRow1['artTotalChild'].'/'.$statusRow1['artTotalAdl'].'</td>';
}

/* patient Status PRE ART */
		$patStatuspreArt="select 
                    count(distinct case when t.patientStatus=4 and (year(now())-t.dobYy)<=14 then t.patientID else null end) as preArtDeathChild,
                    count(distinct case when t.patientStatus=5 and (year(now())-t.dobYy)<=14 then t.patientID else null end) as preArtTransfertChild,
                    count(distinct case when t.patientStatus=7 and (year(now())-t.dobYy)<=14 then t.patientID else null end) as preArtRecentChild,
                    count(distinct case when t.patientStatus=10 and (year(now())-t.dobYy)<=14 then t.patientID else null end) as preArtLostChild,
                    count(distinct case when t.patientStatus=11 and (year(now())-t.dobYy)<=14 then t.patientID else null end) as preArtActifChild,
					count(distinct case when t.patientStatus=4 and (year(now())-t.dobYy)>14 then t.patientID else null end) as preArtDeathAdl,
                    count(distinct case when t.patientStatus=5 and (year(now())-t.dobYy)>14 then t.patientID else null end) as preArtTransfertAdl,
                    count(distinct case when t.patientStatus=7 and (year(now())-t.dobYy)>14 then t.patientID else null end) as preArtRecentAdl,
                    count(distinct case when t.patientStatus=10 and (year(now())-t.dobYy)>14 then t.patientID else null end) as preArtLostAdl,
                    count(distinct case when t.patientStatus=11 and (year(now())-t.dobYy)>14 then t.patientID else null end) as preArtActifAdl,
					count(distinct case when t.hivPositive=1 and (year(now())-t.dobYy)<=14 then t.patientID else null end) as preArtTotalChild,
					count(distinct case when t.hivPositive=1 and (year(now())-t.dobYy)>14 then t.patientID else null end) as preArtTotalAdl
            from patient t,clinicLookup c,encounter e 
                where c.sitecode=LEFT(t.patientid,5) and t.patientStatus in (4,5,7,10,11) and e.patientID=t.patientid and c.sitecode=". $statusRow['sitecode'];
 $result2 =database()->query($patStatuspreArt);


while ($statusRow2 = $result2->fetch()) {
       $info=$info.'<td>'.$statusRow2['preArtRecentChild'].'/'.$statusRow2['preArtRecentAdl'].'</td>
	                <td>'.$statusRow2['preArtActifChild'].'/'.$statusRow2['preArtActifAdl'].'</td>
	                <td>'.$statusRow2['preArtLostChild'].'/'.$statusRow2['preArtLostAdl'].'</td>
					<td>'.$statusRow2['preArtTransfertChild'].'/'.$statusRow2['preArtTransfertAdl'].'</td>
					<td>'.$statusRow2['preArtDeathChild'].'/'.$statusRow2['preArtDeathAdl'].'</td>					
					<td>'.$statusRow2['preArtTotalChild'].'/'.$statusRow2['preArtTotalAdl'].'</td>';
}


/* patient status total */
		$patStatustotal="select 
                    count(distinct case when t.patientStatus in (4,5,7,10,11,1,2,3,6,8,9) then t.patientID else null end) as TotalGeneral,
                    count(distinct case when t.hivPositive=1 and t.patientStatus not in (4,5,7,10,11,1,2,3,6,8,9) then t.patientID else null end) as autreTotal
            from patient t,clinicLookup c,encounter e 
                where c.sitecode=LEFT(t.patientid,5) and e.patientID=t.patientid  and c.sitecode=". $statusRow['sitecode'];
 $result3 =database()->query($patStatustotal);

while ($statusRow3 = $result3->fetch()) {
       $info=$info.'<td>'.$statusRow3['autreTotal'].'</td><td>'. $statusRow3['TotalGeneral'].'</td>';
}
  
}
$info=$info.'</tr>';
 
  $summary ='
  <div style="width: 100%; height: 400px; overflow: scroll;">
  <table width="1800" border="0">
  <tr style="text-align:left; background-color:#CEECF5;border-collapse: collapse; border: 2px solid #C0D8DA">
    <th colspan="5" style="text-align:left; background-color:#CEECF5;border-collapse: collapse; border: 2px solid #C0D8DA">&nbsp;</th>
    <th colspan="7" style="text-align:left; background-color:#CEECF5;border-collapse: collapse; border: 2px solid #C0D8DA">Sous TAR</th>
    <th colspan="6" style="text-align:left; background-color:#CEECF5;border-collapse: collapse; border: 2px solid #C0D8DA">Soins palliatifs</th>
    <th colspan="2" style="text-align:left; background-color:#CEECF5;border-collapse: collapse; border: 2px solid #C0D8DA">Totaux generaux</th>
  </tr>
  <tr>
    <td  colspan="20">'.$info .'</td>
  </tr>
</table>
</div>
<div align="left">
<table width="100%" border="0">
<tr style="text-align:left; background-color:#C7D0D3;border-collapse: collapse; border: 2px solid #C0D8DA">
<td> Legendre</td></tr>
<tr><td>
<div><span style="color:blue;">Bleu</span>--Sites utilisant iSante pendant moins de 90 jours.</div>
<div><span style="color:red;">Rouge</span>--Sites dont le transfert des donnees n\'a pas ete fait depuis au moins deux semaines.</div>
</td></tr>
</table>
</div>

';

  return $summary;
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
<?php echo generateStatus(); ?>
</body>
</html>
