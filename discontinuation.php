<?php
require_once 'include/standardHeaderExt.php';
require_once 'labels/discontinuation.php';

if(isPediatric($pid)){
	$type = '21';
} else {
	$type = '12';
}

echo "<title>" . ${$typeArray[$type] . 'FormTitle'}[$lang][1] . "</title>
 </head>
 <body>
  <form name=\"mainForm\" target =\"mainWindow\" action=\"patienttabs.php\" method=\"post\">
   <input id=\"errorSave\" name =\"errorSave\" type=\"hidden\" value=\"\"/>
";
$tabIndex = 0;
include ('include/patientIdClinicVisitDate.php');
echo "
<div id=\"tab-panes\"><hr/>
";
if($type == "21"){
	include ('peddiscontinuation.php');
} else {
	include ("discontinuation/".$version.".php");
}

$tabIndex = 5000;
echo "
  </div>
  <div id=\"saveButtons\">
";
include ("include/saveButtons.php");
echo "
</div>
</form>
</body>
</html>
";
function allClinicsDropdown ($widgetName, $site, $tabIndex, $curCode, $disabled) {
    $qry = "SELECT distinct clinic, sitecode from clinicLookup where inCphr = 1 and sitecode <> '" . $site . "' order by 1";
	$result = dbQuery ($qry);
	echo "<select name=\"" . $widgetName . "\" " . $tabIndex . " " . $disabled . ">";
	while ($row = psRowFetch ($result))
		if ($row['sitecode'] == $curCode)
			echo "<option value=\"" . $row['sitecode'] . "\" selected>" . $row['clinic'] . "</option>";
		else
			echo "<option value=\"" . $row['sitecode'] . "\" >" . $row['clinic'] . "</option>";
	echo "</select>";
}
?>
