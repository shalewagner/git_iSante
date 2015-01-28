<?php
include "../backend.php";
$finalArray = outputEvents ("report", "2012-01-01");
//print_r ($finalArray);
echo "sitecode|user|rundate|reportNumber<br>";
foreach ($finalArray as $curRow) {
	foreach ($curRow as $key => $val) {
		switch ($key) {
		case "username":
			$user = $val;
			break;
		case "eventParameters":
			$params = json_decode($val, true);
			$repNum = $params['reportNumber'];
			break;
		case "eventDate":
			$eDate = $val;
			break;
		case "siteCode":
			$site = $val;
			break;
		}
	}
	if (!empty($params['reportNumber']))  {
		echo "<br>";
		echo $site . "|" . $user . "|" . $eDate . "|" . $repNum;
	}
}
?>