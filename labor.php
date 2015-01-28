<?php
require_once 'include/standardHeaderExt.php';

$isPed = ($_GET['type'] == '10') ? 0 : 1;
$pedChecked = ($isPed) ? "checked" : "";
$adultChecked = ($isPed) ? "" : "checked";
echo "
<title>" . ${$typeArray[$type]. 'FormTitle'}[$lang][1] . "</title>
</head>
<body>
 ";

$tabsOn = false;
echo "
<form name=\"mainForm\" id=\"mainForm\" target=\"_parent\" action=\"patienttabs.php\" method=\"post\">
 <input id=\"errorSave\" name =\"errorSave\" type=\"hidden\" value=\"\"/>
";
if ($pid == "")
	 include 'bannerbody.php';
else echo "
<input  type=\"hidden\" name=\"site\" value=\"$site\" />
<input  type=\"hidden\" name=\"lang\" value=\"$lang\" />
<input  type=\"hidden\" name=\"lastPid\" value=\"$lastPid\" />
";
$tabIndex = 0;
include ("include/patientIdClinicVisitDate.php");
include ($typeArray[$type] . "/" . $version . ".php");

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
