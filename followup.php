<?php
require_once 'include/standardHeaderExt.php';
require_once 'labels/followup.php';
require_once 'labels/intake.php';
require_once 'labels/pediatric.php';

$mf = getData("sex", "textarea");
/*
if(isPediatric($pid)){
	$type = '17';
	$version = '0';
} else {
	$type = '2';
}
*/

$registVisitDt =  getRegistVisitDt($pid,$site);

echo "
  <title>" . ${$typeArray[$type] . 'FormTitle'}[$lang][1] . "</title>";
echo "
 </head>
 <body>
 <script language=\"JavaScript\" type=\"text/javascript\" src=\"include/arv.js\"></script>
 <script language=\"JavaScript\" type=\"text/javascript\" src=\"followup/commons.js\"></script>
 <form name=\"mainForm\" target=\"mainWindow\" action=\"patienttabs.php\" method=\"post\">
 <input id=\"registVisitDt\" name=\"registVisitDt\" type=\"hidden\" value=\"".$registVisitDt."\"/>
 <input id=\"sex1\" name=\"sex1\" type=\"hidden\" value=\"".$mf."\"/>
 <input id=\"errorSave\" name =\"errorSave\" type=\"hidden\" value=\"\"/>
";
$tabsOn = false;
if($tabsOn) include('include/tabs/followUpTabs.php');
$tabIndex = 0;
include ('include/patientIdClinicVisitDate.php');

if($type == '2'){
	include ($typeArray[$type] . "/" . $version. ".php");
	$tabIndex = 13000;
} else {
	include('pedfollowup.php');
	$tabIndex = 8000;
}

echo"
<div id=\"saveButtons\">";
include ('include/saveButtons.php');
echo "
</div>
</form>
</body>
</html>";
?>
