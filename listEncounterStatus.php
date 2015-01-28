<? 
require_once 'include/standardHeaderExt.php'; 
require_once 'labels/bannerLabels.php';
$encListLoc = array (
'headerLabel' => array('en' => 'Lab order queue', 'fr' => 'File d’attente d’ordre laboratoire'), 
'encType' => array('en' => 'Form', 'fr' => 'Fiche'),
'creator' => array('en' => 'Healthcare provider', 'fr' => 'Prestataire des soins'),
'orderno' => array('en' => 'Order number', 'fr' => 'No d’ordre'),
'accNum' => array('en' => 'Accession', 'fr' => 'Accession'),
'orderDate' => array('en' => 'Order/error date', 'fr' => 'Date d’ordre/erreur'),
'orderStatus' => array('en' => 'Form status/error', 'fr' => 'Statut/erreur de la fiche')  
); 
?>
  <title><?=$encListLoc['headerLabel'][$lang]?></title>
 </head>
 <body>
<form name="mainForm" action="">
<? include ("bannerbody.php");  ?>
  <div class="contentArea"> 
    <table class="header">
	<tr>
	<td class="m_header"><?=$encListLoc['headerLabel'][$lang]?></td>
	</tr>
    </table>
    <table border="1">
	<tr><th><?=$encListLoc['encType'][$lang]?></th><th><?=$encListLoc['creator'][$lang]?></th><th><?=$encListLoc['orderno'][$lang]?></th><th><?=$encListLoc['accNum'][$lang]?></th><th><?=$encListLoc['orderDate'][$lang]?></th><th><?=$encListLoc['orderStatus'][$lang]?></th></tr>
<?      
	$errArray = getQueueErrors();
	foreach (getEncounterStatus($lang) as $row) {
		$errCounter = 0; 
		echo "<tr><td>" . $row['name'] . "</td><td>" . $row['formAuthor'] . "</td><td><a href=\"patienttabs.php?lang=" . $lang . "&amp;pid=" . $row['pid'] . "&amp;fid=" . $row['eid'] . "&amp;site=" . $row['site'] . "\">" . $row['orderno'] . "</a></td><td>" . $row['accessionNumber'] . "</td><td>" . $row['testdate'] . "</td><td>". $row['theText'] . "</td></tr>"; 
		foreach ($errArray as $row2) {  
			$row2Array = explode('|',$row2); 
			if ($row2Array[0] == $row['orderno']) {
				 $msgArray = explode("Code:", $row2Array[2]); 
				 for ($i = 1; $i < count($msgArray); $i++) {
					if ($j < 15) echo  "<tr><td>Error</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>" . $row2Array[1] . "</td><td>" . $msgArray[$i] . "</td></tr>";
					$j++; 
				 }
			}
		}
	}
?>
    </table>
  </div> 
</form>
</body>
</html>
<?
/* list each order, regardless of status, in create date order
 */
function getEncounterStatus ($lang) {
    $sql = "SELECT t." . $lang . "Name as name, createdatetime as testdate, l.statusText" . $lang . " as theText, e.encounter_id as orderno, e.sitecode as site, e.encounter_id as eid, e.patientid as pid, accessionNumber, formAuthor 
FROM encounter e, encounterQueue q, queueStatusLookup l, encTypeLookup t 
where e.encounter_id = q.encounter_id and q.sitecode = e.sitecode and q.encounterStatus = l.encounterStatus and e.encounterType = t.encountertype ORDER BY 2 DESC limit 50";   
 
    $result = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
    $errArray =  getQueueErrors ();
    return($result);
}
/* fetch an array of eventLog rows corresponding to encounterQueue errors
 */ 
function getQueueErrors () {
	$finalArray = outputEvents ("labOrderErr", "2013-05-01"); 
	$errArray = array();
	foreach ($finalArray as $curRow) {
		foreach ($curRow as $key => $val) {
			switch ($key) {
			case "username":
				$user = $val;
				break;
			case "eventParameters":
				$params = json_decode($val, true);
				$orderid = $params['orderId'];
				$msg = $params['msg'];
				$source = $params['source'];
				$sitecode = $params['site'];
				break;
			case "eventDate":
				$eDate = $val;
				break;
			case "siteCode":
				$site = $val;
				break;
			}
		}
		$errArray[] = $orderid . "|" . $eDate . "|" . $msg . "|" . $source . "|" . $sitecode;
	} 
	return($errArray);
}
?>
