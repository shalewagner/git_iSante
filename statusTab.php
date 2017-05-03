<?php
require_once ("backend.php");
require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'labels/splash.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";

function generateStatus($lang)
{
//$lang = trim($_GET["lang"]);
$site = trim($_GET["site"]);
$endDate = trim($_GET["endDate"]);
$startDate = trim($_GET["startDate"]);	
$siteName = getSiteName ($site, $lang);

/* Site info*/
$info='
<tr style="text-align:left; background-color:#C7D0D3;border-collapse: collapse; border: 1px solid #C0D8DA">
<th>Etablissement</th><th>sitecode</th><th>Server local</th><th>Version</th><th>Date de saisi la plus r&#233;cente</th>
<th>R&#233;cent (A/E)</th><th>Actif (A/E)</th><th>Perdu de vue (A/E)</th><th>Transf&#233;r&#233; (A/E)</th><th>D&#233;c&#233;d&#233; (A/E)</th><th>Total (A/E)</th>
<th>R&#233;gulier (A/E)</th><th>Rendez-vous Rat&#233; (A/E)</th><th>Perdu de vue (A/E)</th><th>Arr&#234;t&#233; (A/E)</th><th>Transf&#233;r&#233; (A/E)</th><th>D&#233;c&#233;d&#233; (A/E)</th><th>Total (A/E)</th>
<th>Total G&#233;n&#233;ral</th></tr>';

/* patient Status PRE ART AND ART */
		$patStatuspreArt="select 
		            clinic,rtrim(c.sitecode) as sitecode, 
                    case when c.dbSite !=0 then 'Oui' else '' end as 'local', 
				    left(dbVersion,4) as dbVersion, 
				    case when max(lastmodified) is null then '2000-01-01' else max(DATE_FORMAT(lastmodified,'%Y-%m-%d')) end as 'maxDate',
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
					count(distinct case when t.hivPositive=1 and t.patientStatus in (4,5,7,10,11) and (year(now())-t.dobYy)>14 then t.patientID else null end) as preArtTotalAdl,
					count(distinct case when t.patientStatus=1 and (year(now())-t.dobYy)<=14 then t.patientID else null end) as artDeathChild,
					count(distinct case when t.patientStatus=1 and (year(now())-t.dobYy)>14 then t.patientID else null end) as artDeathAdl,
                    count(distinct case when t.patientStatus=2 and (year(now())-t.dobYy)<=14 then t.patientID else null end) as artTransfertChild,
					count(distinct case when t.patientStatus=2 and (year(now())-t.dobYy)>14 then t.patientID else null end) as artTransfertAdl,
                    count(distinct case when t.patientStatus=3 and (year(now())-t.dobYy)<=14 then t.patientID else null end) as artStoppedChild,
                    count(distinct case when t.patientStatus=3 and (year(now())-t.dobYy)>14 then t.patientID else null end) as artStoppedAdl,
					count(distinct case when t.patientStatus=6 and (year(now())-t.dobYy)<=14 then t.patientID else null end) as artRegularChild,
                    count(distinct case when t.patientStatus=6 and (year(now())-t.dobYy)>14 then t.patientID else null end) as artRegularAdl,
					count(distinct case when t.patientStatus=8 and (year(now())-t.dobYy)<=14 then t.patientID else null end) as artMissingChild,
                    count(distinct case when t.patientStatus=8 and (year(now())-t.dobYy)>14 then t.patientID else null end) as artMissingAdl,
					count(distinct case when t.patientStatus=9 and (year(now())-t.dobYy)<=14 then t.patientID else null end) as artLostChild,
					count(distinct case when t.patientStatus=9 and (year(now())-t.dobYy)>14 then t.patientID else null end) as artLostAdl,
					count(distinct case when t.hivPositive=1 and (year(now())-t.dobYy)<=14 then t.patientID else null end) as artTotalChild,
					count(distinct case when t.hivPositive=1 and t.patientStatus in (1,2,3,6,8,9) and (year(now())-t.dobYy)>14 then t.patientID else null end) as artTotalAdl,
					count(distinct case when t.patientStatus in (4,5,7,10,11,1,2,3,6,8,9) then t.patientID else null end) as TotalGeneral
            from patient t,clinicLookup c,encounter e 
                where c.sitecode=LEFT(t.patientid,5) and t.hivPositive=1 and e.patientID=t.patientid group by clinic, c.sitecode, case when c.dbSite != 0 then 'Oui' else '' end, dbVersion order by 5 desc";
 $result2 =databaseSelect()->query($patStatuspreArt);

$j=0;
$i=0;
while ($statusRow2 = $result2->fetch()) {
	$red='';
	$diff = round(abs(time()-strtotime($statusRow2['maxDate']))/(3600*24),0);
	if($diff>15) $red='color:#F00;';	
	$style='style="text-align:right; background-color:#FFF;border-collapse: collapse; border: 1px hidden #666;'.$red.'"';

	if($i=1) {$style='style="text-align:right; background-color:#E8E8E8;border-collapse: collapse; border: 1px hidden #666;'.$red.'"'; $i=0;}
	else $i=1;
	
    $info=$info.'<tr '.$style.'><td style="text-align: left;">'.$statusRow2['clinic'].'</td><td>'. $statusRow2['sitecode'].'</td><td>'. $statusRow2['local'].'</td><td>'.$statusRow2['dbVersion'].'</td><td>'.$statusRow2['maxDate'].'</td>';
	$j+=1;
	//
       $info=$info.'<td>'.$statusRow2['preArtRecentAdl'].'/'.$statusRow2['preArtRecentChild'].'</td>
	                <td>'.$statusRow2['preArtActifAdl'].'/'.$statusRow2['preArtActifChild'].'</td>
	                <td>'.$statusRow2['preArtLostAdl'].'/'.$statusRow2['preArtLostChild'].'</td>
					<td>'.$statusRow2['preArtTransfertAdl'].'/'.$statusRow2['preArtTransfertChild'].'</td>
					<td>'.$statusRow2['preArtDeathAdl'].'/'.$statusRow2['preArtDeathChild'].'</td>					
					<td>'.$statusRow2['preArtTotalAdl'].'/'.$statusRow2['preArtTotalChild'].'</td>
					<td>'.$statusRow2['artRegularAdl'].'/'.$statusRow2['artRegularChild'].'</td>
	                <td>'.$statusRow2['artMissingAdl'].'/'.$statusRow2['artMissingChild'].'</td>
	                <td>'.$statusRow2['artLostAdl'].'/'.$statusRow2['artLostChild'].'</td>
					<td>'.$statusRow2['artStoppedAdl'].'/'.$statusRow2['artStoppedChild'].'</td>
					<td>'.$statusRow2['artTransfertAdl'].'/'.$statusRow2['artTransfertChild'].'</td>
	                <td>'.$statusRow2['artDeathAdl'].'/'.$statusRow2['artDeathChild'].'</td>
					<td>'.$statusRow2['artTotalAdl'].'/'.$statusRow2['artTotalChild'].'</td>
					<td>'. $statusRow2['TotalGeneral'].'</td>';
}
if($j==0){ $info=$info.'<td>0/0</td><td>0/0</td><td>0/0</td><td>0/0</td><td>0/0</td><td>0/0</td>
                        <td>0/0</td><td>0/0</td><td>0/0</td><td>0/0</td><td>0/0</td><td>0/0</td><td>0/0</td><td>0</td>';}
$info=$info.'</tr>';
 
  $summary ='
  <div style="width: 100%; height: 400px; overflow: scroll;">
  <table width="1900" border="0">
  <tr style="text-align:left; background-color:#CEECF5;border-collapse: collapse; border: 2px solid #C0D8DA">
    <th colspan="5" style="width:40%;text-align:center; background-color:#CEECF5;border-collapse: collapse; border: 2px solid #C0D8DA">&nbsp;</th>
	<th colspan="6" style="width:28%;text-align:center; background-color:#CEECF5;border-collapse: collapse; border: 2px solid #C0D8DA">PRE-ARV</th>
    <th colspan="7" style="width:28%;text-align:center; background-color:#CEECF5;border-collapse: collapse; border: 2px solid #C0D8DA">Sous TAR</th>    
    <th style="width:4%;text-align:center; background-color:#CEECF5;border-collapse: collapse; border: 2px solid #C0D8DA">Totaux g&#233;n&#233;raux</th>
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
<div><span style="color:red;">Rouge</span>--Sites dont le transfert des donn&#233;es n\'a pas &#233;t&#233; fait depuis au moins deux semaines.</div>
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
<?php echo generateStatus($lang); ?>
</body>
</html>
