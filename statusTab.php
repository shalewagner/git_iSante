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
$info='<tr style="text-align:left; background-color:#C7D0D3;border-collapse: collapse; border: 1px solid #C0D8DA">
<th>Etablissement</th><th>sitecode</th><th>Server local</th><th>Version</th><th>Date de Debut</th><th>Date de saisi la plus r&#233;cente</th>
<th>R&#233;cent (A/E)</th><th>Actif (A/E)</th><th>Perdu de vue (A/E)</th><th>Transf&#233;r&#233; (A/E)</th><th>D&#233;c&#233;d&#233; (A/E)</th><th>Total (A/E)</th>
<th>R&#233;gulier (A/E)</th><th>Rendez-vous Rat&#233; (A/E)</th><th>Perdu de vue (A/E)</th><th>Arr&#234;t&#233; (A/E)</th><th>Transf&#233;r&#233; (A/E)</th><th>D&#233;c&#233;d&#233; (A/E)</th><th>Total (A/E)</th>
<th>Total G&#233;n&#233;ral</th></tr>';
$arrayStatus=array();
/* patient Status PRE ART AND ART */
		$patStatus="select 
		            clinic,rtrim(c.sitecode) as sitecode, 
                    case when c.dbSite !=0 then 'Oui' else 'No' end as 'local', 
				    left(dbVersion,4) as dbVersion, 
				    case when date(lastmodified) is null then '2000-01-01' else DATE_FORMAT(lastmodified,'%Y-%m-%d') end as 'maxDate',
					case when date(mindate) is null then '2000-01-01' else DATE_FORMAT(mindate,'%Y-%m-%d') end as 'minDate'
                   from  clinicLookup c, (select sitecode,min(lastModified) as mindate,max(lastModified) as lastModified from encounter group by 1) e 
                where e.sitecode=c.sitecode order by 5 desc";
 $result1 =databaseSelect()->query($patStatus);
 $y=0;
while ($statusRow1 = $result1->fetch()) {
	$arrayStatus[$statusRow1['sitecode']]=array("clinic" => $statusRow1['clinic'],
	                       "sitecode" => $statusRow1['sitecode'],
						   "local" => $statusRow1['local'],
						   "dbVersion" => $statusRow1['dbVersion'],
						   "minDate" => $statusRow1['minDate'],
						   "maxDate" => $statusRow1['maxDate'],
						   "preArtDeathChild" =>'0',
						   "preArtTransfertChild" =>'0',
						   "preArtRecentChild" =>'0',
						   "preArtLostChild" =>'0',
						   "preArtActifChild" =>'0',
						   "preArtTotalChild" =>'0',
						   "preArtDeathAdl" =>'0',
						   "preArtTransfertAdl" =>'0',
						   "preArtRecentAdl" =>'0',
						   "preArtLostAdl" =>'0',
						   "preArtActifAdl" =>'0',
						   "preArtTotalAdl" =>'0',						   
						   "artDeathChild" =>'0',
						   "artTransfertChild" =>'0',
						   "artStoppedChild" =>'0',
						   "artRegularChild" =>'0',
						   "artMissingChild" =>'0',
						   "artLostChild" =>'0',
						   "artTotalChild" =>'0',
						   "artDeathAdl" =>'0',
						   "artTransfertAdl" =>'0',
						   "artStoppedAdl" =>'0',
						   "artRegularAdl" =>'0',
						   "artMissingAdl" =>'0',						   
						   "artLostAdl" =>'0',
						   "artTotalAdl" =>'0',
						   "TotalGeneral" =>'0'
						   );
	$y++;
}

		$patStatus="select 
		            rtrim(c.sitecode) as sitecode, 
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
					count(distinct case when (year(now())-t.dobYy)<=14 then t.patientID else null end) as preArtTotalChild,
					count(distinct case when (year(now())-t.dobYy)>14 then t.patientID else null end) as preArtTotalAdl
                   from patient t,clinicLookup c 
                where c.sitecode=LEFT(t.patientid,5) and t.patientStatus in (4,5,7,10,11)
				group by 1";
 $result2 =databaseSelect()->query($patStatus);
while ($statusRow2 = $result2->fetch()) {	
	$arrayStatus[$statusRow2['sitecode']]['preArtDeathChild']=$statusRow2['preArtDeathChild'];
	$arrayStatus[$statusRow2['sitecode']]['preArtTransfertChild']=$statusRow2['preArtTransfertChild'];
	$arrayStatus[$statusRow2['sitecode']]['preArtRecentChild']=$statusRow2['preArtRecentChild'];
	$arrayStatus[$statusRow2['sitecode']]['preArtLostChild']=$statusRow2['preArtLostChild'];
	$arrayStatus[$statusRow2['sitecode']]['preArtActifChild']=$statusRow2['preArtActifChild'];
	$arrayStatus[$statusRow2['sitecode']]['preArtTotalChild']=$statusRow2['preArtTotalChild'];
	$arrayStatus[$statusRow2['sitecode']]['preArtDeathAdl']=$statusRow2['preArtDeathAdl'];
	$arrayStatus[$statusRow2['sitecode']]['preArtTransfertAdl']=$statusRow2['preArtTransfertAdl'];
	$arrayStatus[$statusRow2['sitecode']]['preArtRecentAdl']=$statusRow2['preArtRecentAdl'];
	$arrayStatus[$statusRow2['sitecode']]['preArtLostAdl']=$statusRow2['preArtLostAdl'];
	$arrayStatus[$statusRow2['sitecode']]['preArtActifAdl']=$statusRow2['preArtActifAdl'];
	$arrayStatus[$statusRow2['sitecode']]['preArtTotalAdl']=$statusRow2['preArtTotalAdl'];
}
  


		$patStatus="select 
		            rtrim(c.sitecode) as sitecode, 
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
					count(distinct case when (year(now())-t.dobYy)<=14 then t.patientID else null end) as artTotalChild,
					count(distinct case when (year(now())-t.dobYy)>14 then t.patientID else null end) as artTotalAdl
					from patient t,clinicLookup c 
                where c.sitecode=LEFT(t.patientid,5) and t.patientStatus in (1,2,3,6,8,9)
				group by 1";
 $result2 =databaseSelect()->query($patStatus);
while ($statusRow2 = $result2->fetch()) {
	$arrayStatus[$statusRow2['sitecode']]['artDeathChild']=$statusRow2['artDeathChild'];
	$arrayStatus[$statusRow2['sitecode']]['artTransfertChild']=$statusRow2['artTransfertChild'];
	$arrayStatus[$statusRow2['sitecode']]['artStoppedChild']=$statusRow2['artStoppedChild'];
	$arrayStatus[$statusRow2['sitecode']]['artRegularChild']=$statusRow2['artRegularChild'];
	$arrayStatus[$statusRow2['sitecode']]['artMissingChild']=$statusRow2['artMissingChild'];
	$arrayStatus[$statusRow2['sitecode']]['artLostChild']=$statusRow2['artLostChild'];
	$arrayStatus[$statusRow2['sitecode']]['artTotalChild']=$statusRow2['artTotalChild'];
	$arrayStatus[$statusRow2['sitecode']]['artDeathAdl']=$statusRow2['artDeathAdl'];
	$arrayStatus[$statusRow2['sitecode']]['artTransfertAdl']=$statusRow2['artTransfertAdl'];
	$arrayStatus[$statusRow2['sitecode']]['artStoppedAdl']=$statusRow2['artStoppedAdl'];
	$arrayStatus[$statusRow2['sitecode']]['artRegularAdl']=$statusRow2['artRegularAdl'];
	$arrayStatus[$statusRow2['sitecode']]['artMissingAdl']=$statusRow2['artMissingAdl'];
	$arrayStatus[$statusRow2['sitecode']]['artLostAdl']=$statusRow2['artLostAdl'];
	$arrayStatus[$statusRow2['sitecode']]['artTotalAdl']=$statusRow2['artTotalAdl'];	  
  }
 
 		$patStatus="select 
		            rtrim(c.sitecode) as sitecode,
					count(distinct t.patientID) as TotalGeneral
					from patient t,clinicLookup c 
                where c.sitecode=LEFT(t.patientid,5) and t.patientStatus in (1,2,3,6,8,9,4,5,7,10,11)
				group by 1";
 $result3 =databaseSelect()->query($patStatus);
while ($statusRow3 = $result3->fetch()) {
	$arrayStatus[$statusRow3['sitecode']]['TotalGeneral']=$statusRow3['TotalGeneral'];
} 
 
 
$i=0; 
foreach($arrayStatus as $key => $status) 
{
  $red='';	
  $diff = round(abs(time()-strtotime($status['maxDate']))/(3600*24),0);
  if($diff>15) $red='color:#F00;';	
	$style='style="text-align:right; background-color:#FFF;border-collapse: collapse; border: 1px hidden #666;'.$red.'"';
  if($i=1) {$style='style="text-align:right; background-color:#E8E8E8;border-collapse: collapse; border: 1px hidden #666;'.$red.'"'; $i=0;}
	else $i=1;	
	$clinic='';
	if(strlen($status['clinic'])>50) $clinic=substr($status['clinic'],0,50).' ...';
	else $clinic=$status['clinic'];
	
	
  $info=$info.'<tr '.$style.'><td style="text-align: left;"><font size="1">'.$clinic.'</font></td><td>'. $status['sitecode'].'</td>
                              <td><font size="1">'.$status['local'].'</font></td><td>'.$status['dbVersion'].'</td><td><font size="1">'.$status['minDate'].'</font></td>
							  <td><font size="1">'.$status['maxDate'].'</font></td><td><font size="1">'.$status['preArtRecentAdl'].'/'.$status['preArtRecentChild'].'</font></td>
	                          <td><font size="1">'.$status['preArtActifAdl'].'/'.$status['preArtActifChild'].'</font></td>
	                          <td><font size="1">'.$status['preArtLostAdl'].'/'.$status['preArtLostChild'].'</font></td>
					          <td><font size="1">'.$status['preArtTransfertAdl'].'/'.$status['preArtTransfertChild'].'</font></td>
					          <td><font size="1">'.$status['preArtDeathAdl'].'/'.$status['preArtDeathChild'].'</font></td>					
					          <td><font size="1">'.$status['preArtTotalAdl'].'/'.$status['preArtTotalChild'].'</font></td>
					          <td><font size="1">'.$status['artRegularAdl'].'/'.$status['artRegularChild'].'</font></td>
	                          <td><font size="1">'.$status['artMissingAdl'].'/'.$status['artMissingChild'].'</font></td>
	                          <td><font size="1">'.$status['artLostAdl'].'/'.$status['artLostChild'].'</font></td>
					          <td><font size="1">'.$status['artStoppedAdl'].'/'.$status['artStoppedChild'].'</font></td>
					          <td><font size="1">'.$status['artTransfertAdl'].'/'.$status['artTransfertChild'].'</font></font></td>
	                          <td><font size="1">'.$status['artDeathAdl'].'/'.$status['artDeathChild'].'</td>
					          <td><font size="1">'.$status['artTotalAdl'].'/'.$status['artTotalChild'].'</font></td>
					          <td><font size="1">'.$status['TotalGeneral'].'</font></td>';
}
$info=$info.'</tr>';
 
  $summary ='
  <div style="width: 100%; height: 400px; overflow: scroll;">
  <table width="1900" border="0">
  <tr style="text-align:left; background-color:#CEECF5;border-collapse: collapse; border: 2px solid #C0D8DA">
    <th colspan="6" style="width:40%;text-align:center; background-color:#CEECF5;border-collapse: collapse; border: 2px solid #C0D8DA">&nbsp;</th>
	<th colspan="6" style="width:28%;text-align:center; background-color:#CEECF5;border-collapse: collapse; border: 2px solid #C0D8DA">PRE-ARV</th>
    <th colspan="7" style="width:28%;text-align:center; background-color:#CEECF5;border-collapse: collapse; border: 2px solid #C0D8DA">Sous TAR</th>    
    <th style="width:4%;text-align:center; background-color:#CEECF5;border-collapse: collapse; border: 2px solid #C0D8DA">Totaux g&#233;n&#233;raux</th>
  </tr>
  '.$info .'
</table>
</div>
<div align="left" style="width: 100%;">
<table width="100%" border="0">
<tr style="text-align:left; background-color:#C7D0D3;border-collapse: collapse; border: 2px solid #C0D8DA">
<td style="width: 100%;"> Legendre</td></tr>
<tr><td>
<div><span style="color:blue;">Bleu</span>--Sites utilisant iSante pendant moins de 90 jours.</div>
<div><span style="color:red;">Rouge</span>--Sites dont le transfert des donn&#233;es n\'a pas &#233;t&#233; fait depuis au moins deux semaines.</div>
<div><span >(A/E)</span>-- Adulte/Enfant</div>
</td></tr>
</table>
</div>

<table width="100%" border="0">
<tr style="text-align:left; background-color:#C7D0D3;border-collapse: collapse; border: 2px solid #C0D8DA">
<td> Definition </td></tr>
<tr><td>
<div>
<div><span style="text-decoration:underline;"><strong>Pr&#233;-ARV</strong></span></div>

<div>
<span style="font:bold;">R&#233;cents	Pr&#233;-ARV:</span>Tout patient VIH+ non encore mis sous ARV ayant eu sa premi&#232;re visite (clinique "1re visite VIH") au cours des 12 derniers mois tout en excluant tout patient ayant un rapport d\'arr&#234;t avec motifs d&#233;c&#233;d&#233; ou transf&#233;r&#233;.
</div>
<div>
<span style="font:bold;">Perdus de vue en Pr&#233;-ARV :</span> Tout patient VIH+ non encore mis sous ARV n\'ayant eu aucune visite (clinique  "1re visite VIH et suivi VIH	uniquement", pharmacie,labo) au cours des 12 derniers mois et n\'&#233;tant ni d&#233;c&#233;d&#233; ni transf&#233;r&#233;.
</div>
<div>
<span style="font:bold;">D&#233;c&#233;d&#233;s en Pr&#233;-ARV :</span> Tout patient VIH+ non	encore mis sous ARV ayant un rapport d\'arr&#234;t rempli pour cause de d&#233;c&#232;s.
</div>

<div>
<span style="font:bold;">Transf&#233;r&#233;s en Pr&#233;-ARV :</span> Tout patient VIH+ non encore mis sous ARV ayant un rapport d\'arr&#234;t rempli pour cause de transfert.
</div>
<div>
<span style="font:bold;">Actifs en Pr&#233;-ARV :</span> Tout patient VIH+ non encore mis sous ARV et ayant eu une visite (clinique	de suivi VIH uniquement, ou de pharmacie ou de labo) au	cours des 12 derniers mois et n\'&#233;tant ni d&#233;c&#233;d&#233; ni transf&#233;r&#233;. NB: pour capturer les patients Pr&#233;-ARV non r&#233;cents qui ont un contact avec l\'institution.
</div>

<div><span style="font:bold;text-decoration:underline;"><strong>Traitement ARV</strong></span></div>

<div>
<span style="font:bold;">R&#233;guliers (actifs	sous ARV) :</span> Tout patient mis sous ARV et n\'ayant aucun rapport d\'arr&#234;t rempli pour motifs de d&#233;c&#232;s, de transfert, ni d\'arr&#234;t de traitement. La date de prochain rendez-vous clinique ou de prochaine	collecte de m&#233;dicaments est situ&#233;e dans le futur de la p&#233;riode d\'analyse.(Fiches &#224; ne pas consid&#233;rer, labo et counseling)
</div>

<div>
<span style="font:bold;">Rendez-vous rat&#233;s :</span> Tout patient mis sous ARV et n\'ayant aucun rapport d\'arr&#234;t rempli pour motifs de d&#233;c&#232;s, de transfert, ni d\'arr&#234;t de traitement. La date de la p&#233;riode d\'analyse est sup&#233;rieure &#224; la date de rendez-vous clinique ou de collecte de m&#233;dicaments la plus r&#233;cente sans exc&#233;der 90 jours.
</div>
<div>
<span style="font:bold;">Perdus de vue (LTFU, anciennement	inactif) :</span> Tout patient mis sous ARV et n\'ayant aucun rapport d\'arr&#234;t rempli pour motifs de d&#233;c&#232;s, de transfert, ni d\'arr&#234;t de traitement. La date de la p&#233;riode d\'analyse est sup&#233;rieure &#224; la date de rendez-vous clinique ou de collecte de m&#233;dicaments la plus r&#233;cente de plus de 90 jours.
</div>
<div>
<span style="font:bold;">D&#233;c&#233;d&#233;s :</span>Tout patient mis sous ARV et ayant un rapport d\'arr&#234;t rempli pour motif de d&#233;c&#232;s.
</div>
<div>
<span style="font:bold;">Arr&#234;t&#233;s :</span>Tout patient mis sous	ARV	et ayant un rapport d\'arr&#234;t rempli pour motif d\'arr&#234;t de traitement.
</div>
<div>
<span style="font:bold;">Transf&#233;r&#233;s :</span>Tout patient mis sous ARV et ayant un rapport d\'arr&#234;t rempli pour motif de transfert.
</div>

</td></tr>
</table>
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
	thead, tbody {display: inline-block; }
    tbody {width:100%; overflow:scroll; overflow:auto;}
  </style>  
</head>


<body text="#000000" link="#000000" alink="#000000" vlink="#000000" align="center">
<center>
<?php echo generateStatus($lang); ?>
</body>
</html>
