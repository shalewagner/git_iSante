<?php
require_once 'backend/hivQualFunctions.php';
require_once 'backend.php';

$lang = trim($_GET["lang"]);
$site = trim($_GET["site"]);
$endDate = trim($_GET["endDate"]);
$startDate = trim($_GET["startDate"]);
$index = ereg_replace('[^AB0-9]', '', trim($_GET["index"]));
$type = trim($_GET["type"]);
$group = trim($_GET["group"]);
if ($group == "adults" || $group == "kids" || $group == "total") {
  $repNum = "504";
} else if ($group == "all") {
  $repNum = "530";
}

if ($endDate == null) {
  $endDate = date ('Y-m-d');
}

$intervalLength = round((strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24 * 30.4368499));

$numFunct = 'getInd' . $index . 'Num';
$denFunct = 'getInd' . $index . 'Den';
setupHivQual ($repNum, $site, $startDate, $endDate);
$tmpDen = call_user_func($denFunct, $repNum, $site, $intervalLength, $startDate, $endDate);
$pidsByAge = generateAgeGroups ($tmpDen, $site, $startDate);

if ($type == 'num') {
  $tmpNum = array_intersect($tmpDen, call_user_func($numFunct, $repNum, $site, $intervalLength, $startDate, $endDate));
  if ($group == "adults") $patients = getPatientDetail (array_intersect ($tmpNum, $pidsByAge["adults"]), $lang);
  else if ($group == "kids") $patients = getPatientDetail (array_intersect ($tmpNum, $pidsByAge["kids"]), $lang);
  else $patients = getPatientDetail($tmpNum, $lang);
} else {
  if ($group == "adults") $patients = getPatientDetail ($pidsByAge["adults"], $lang);
  else if ($group == "kids") $patients = getPatientDetail ($pidsByAge["kids"], $lang);
  else $patients = getPatientDetail($tmpDen, $lang);
}
cleanupHivQual ();

function fillEmpty($str) {
  return empty($str) ? 'N/A' : $str;
}

function listPatient($patients,$lang) {
    $noResult = array ("en" => "<br>There is no result!<br>", "fr" => "<br>Il n'y a aucun  r&eacute;sultat!<br>");
    $header = array ( "en" => array ("Clinic Patient ID",  "First Name" , "Last Name"), "fr" => array ( "No. de patient attribu&#xe9; par le site", "Pr&#xe9;nom", "Nom"));  
  
    $result = "";
	if(count($patients)>0)
	{
		$result .= "<table border=\"1\"><tr>";
		for($i=0;$i<3;$i++)
		{
			$result .= "<td width=\"33%\" align=\"center\"><b>". $header[$lang][$i] . "</b></td>";
		}
		$result .= "</tr>";
		foreach($patients as $patient)
		{
			$result .= "<tr>";
			for($j=0;$j<3;$j++)
			{
				$result .= "<td align=\"left\">" . fillEmpty($patient[$j]) . "</td>";
			}
			$result .= "</tr>";
		}
		$result .= "</table>";
	}
	else
	{
		$result = "<b>" . $noResult[$lang] . "</b>"; 
	}

	return $result;
  }
  
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?= CHARSET ?>" />
<link rel="StyleSheet" type="text/css" href="default.css" />
<link rel="StyleSheet" type="text/css" href="tabs.css" />
<body>
<?= listPatient($patients, $lang) ?>
</body>
</html>
