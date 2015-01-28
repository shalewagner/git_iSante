<?php
$type="28";
$encType = "28";
$_GET['type'] = "28";
require_once 'include/standardHeaderExt.php';
require_once 'labels/register.php';
require_once 'labels/pedPsychFollowUp.php';


echo "
<title>" . ${$typeArray[$type]. 'FormTitle'}[$lang][1] . "</title>
<script language=\"Javascript\" type=\"text/javascript\" src=\"include/util.js\"></script>
<script language=\"Javascript\" type=\"text/javascript\" src=\"pedpsychfollowup/1.js\"></script>

</head>
<body>
 ";

echo "
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
include "". $typeArray[$type] . "/" . $version . ".php";
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

