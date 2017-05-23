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


$patStatus="select * from lastSplashText";
 $result =databaseSelect()->query($patStatus);
 $info='';
while ($statusRow = $result->fetch()) {
	$info=$statusRow['splashText'];
}
 
  $summary ='
  <div style="width: 100%; height: 400px; overflow: scroll;">
  <table width="1900" border="1">
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
