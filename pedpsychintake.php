<?php
require_once 'include/standardHeaderExt.php';

$type="27";

require_once 'labels/register.php';
require_once 'labels/pedpsych.php';

echo "
<title>" . ${$typeArray[$type]. 'FormTitle'}[$lang][1] . "</title>
<script src=\"" . $typeArray[$type] . "/0.js\" type=\"text/javascript\"></script>
</head>
<body>
<form name=\"mainForm\"  target=\"_parent\" action=\"patienttabs.php\" method=\"post\">
 <input id=\"errorSave\" name =\"errorSave\" type=\"hidden\" value=\"\"/>
";
if ($pid == "")
	 include 'bannerbody.php';
else echo "
<input  type=\"hidden\" name=\"site\" value=\"$site\" />
<input  type=\"hidden\" name=\"lang\" value=\"$lang\" />
<input  type=\"hidden\" name=\"lastPid\" value=\"$lastPid\" />
";

if($eid)
 echo" <input  type=\"hidden\" name=\"eid\" value=\"$eid\" />";

$tabIndex = 0;
include ("include/patientIdClinicVisitDate.php");

echo "<div>";
include ($typeArray[$type] . "/" . $version . ".php");
echo "</div>";

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

