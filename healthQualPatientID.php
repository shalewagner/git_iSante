<?php
require_once 'backend/healthQualFunctions.php';

$lang = trim($_GET["lang"]);
$site = trim($_GET["site"]);
$endDate = trim($_GET["endDate"]);
$startDate = trim($_GET["startDate"]);
$index = ereg_replace('[^AB0-9]', '', trim($_GET["index"]));
$type = trim($_GET["type"]);
$group = trim($_GET["group"]);
$repNum = "512";

if ($index == "06") {
  $index .= $group == "adults" ? "A" : "B";
}

if ($endDate == null) {
  $endDate = date ('Y-m-d');
}

$intervalLength = round((strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24 * 30.4368499));

setupHealthQual ($repNum, $site, $startDate, $endDate);
if (substr ($index, 0, 2) == "06" && $group == "total") {
  // Indicator "06" has two possible denoms, choose wisely
  $tmpDen = call_user_func($indicatorProperties["06A"]["denFunct"], $repNum, $site, $intervalLength, $startDate, $endDate);
  $tmpDen = array_merge ($tmpDen, call_user_func($indicatorProperties["06B"]["denFunct"], $repNum, $site, $intervalLength, $startDate, $endDate));
} else {
  $tmpDen = call_user_func($indicatorProperties[$index]["denFunct"], $repNum, $site, $intervalLength, $startDate, $endDate);
}
$pidsByAge = generateAgeGenderGroups ($tmpDen, $site, $startDate);

if ($type == 'num') {
  $tmpNum = array_intersect($tmpDen, call_user_func($indicatorProperties[$index]["numFunct"], $repNum, $site, $intervalLength, $startDate, $endDate));
  if ($group == "adults") $patients = getPatientDetail (array_intersect ($tmpNum, array_merge ($pidsByAge["adultsF"], $pidsByAge["adultsM"])), $lang);
  else if ($group == "kids") $patients = getPatientDetail (array_intersect ($tmpNum, array_merge ($pidsByAge["kidsF"], $pidsByAge["kidsM"])), $lang);
  else $patients = getPatientDetail($tmpNum, $lang);
} else {
  if ($group == "adults") $patients = getPatientDetail (array_merge ($pidsByAge["adultsF"], $pidsByAge["adultsM"]), $lang);
  else if ($group == "kids") $patients = getPatientDetail (array_merge ($pidsByAge["kidsF"], $pidsByAge["kidsM"]), $lang);
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
