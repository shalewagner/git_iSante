<?php
require_once 'include/standardHeaderExt.php';
require_once 'labels/register.php';

$isPed = ($_GET['type'] == '10') ? 0 : 1;  
$pedChecked = ($isPed) ? "checked" : "";
$adultChecked = ($isPed) ? "" : "checked";
echo "
<script type=\"text/javascript\">
function callOtherReg (newType, asTab) {
	var newVersion = '0';
	if (newType == 10) newVersion = '1';
	var x = 'register.php?pid=$lastPid&eid=$eid&type=' + newType + '&version=' + newVersion; 
	if (asTab == 1) x = x + '&tabcall=1';
	document.forms[0].action = x;
	document.forms[0].target = '_self';
	document.forms[0].tabcall.value = '" . $_REQUEST['tabcall'] . "';
	document.forms[0].type.value = newType;
	document.forms[0].method='get';
	document.forms[0].submit();
} 
function whoCalledMe () {
	alert('" . $_SERVER['HTTP_REFERER'] . "');
}
</script>
<title>" . ${$typeArray[$type]. 'FormTitle'}[$lang][1] . "</title>
</head>
<body>
 ";

$tabsOn = false;
if ($tabsOn) include("include/tabs/registerTabs.php");
echo "
<form name=\"mainForm\"  target=\"_parent\" action=\"patienttabs.php\" method=\"post\">
 <input id=\"errorSave\" name =\"errorSave\" type=\"hidden\" value=\"\"/>
";
if ($pid == "")
	 include 'bannerbody.php';
else echo "
<input type=\"hidden\" name=\"site\" value=\"$site\" />
<input type=\"hidden\" name=\"lang\" value=\"$lang\" />
<input type=\"hidden\" name=\"lastPid\" value=\"$lastPid\" />
<input type=\"hidden\" name=\"tabcall\" value=\"" . $_REQUEST['tabcall'] . "\" />
";
$tabIndex = 0;
include ("include/patientIdClinicVisitDate.php");
if ($isPed) {
	include("pedregister.php");
} else {
	include ($typeArray[$type] . "/" . $version . ".php");
}

$tabIndex = 4000;
echo"<div id=\"saveButtons\">";
include ("include/saveButtons.php");
echo "
  </div>
   </form>
 </body>
</html>
";
function getExtra($temp = "", $lang = "") {
	if (empty($temp))
		$extra = "";
	else {
		if ($lang == "fr")
			$extra = " (non valide)";
		else
			$extra = " (Not Valid)";
	}
	return $extra;
}

?>
