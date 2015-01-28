<?php
require_once 'include/standardHeaderExt.php';
require_once 'labels/pediatric.php';

/*
if(isPediatric($pid)){
	$type = '18';
} else {
	$type = '5';
}
*/
echo "
  <title>" . ${$typeArray[$type] . 'FormTitle'}[$lang][1] . "</title>";
  $tabsOn = false;
if ($tabsOn) {
  include("include/tabs/prescriptionTabs.php");
}
echo "
 </head>
 <body>

<form name=\"mainForm\" target = \"mainWindow\" action=\"patienttabs.php\" method=\"post\">
  <input id=\"errorSave\" name =\"errorSave\" type=\"hidden\" value=\"\"/>
 <script language=\"JavaScript\" type=\"text/javascript\" src=\"include/arv.js\"></script>


";

$tabIndex = 0;
include ("include/patientIdClinicVisitDate.php");
if($type == '5'){
	include ($typeArray[$type] . "/" . $version . ".php");
	$tabIndex = 10000;
} else {
	include ("pedprescription.php");
	$tabIndex = 8000;
}
echo"<div id=\"saveButtons\">";
include ("include/saveButtons.php");

echo "
</div>
</form>
 </body>
</html>
";


?>
