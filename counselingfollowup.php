<?php
# These should be read from the get, no?
#$type="4";
#$encType = "4";
#$_GET['type'] = "4";
require_once 'include/standardHeaderExt.php';
require_once 'labels/register.php';
# This file doesn't exist. Is it supposed to?
#require_once 'labels/psychfollowup.php';


echo "
<title>" . ${$typeArray[$type]. 'FormTitle'}[$lang][1] . "</title>

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
//include ("psychForm/0.php");
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
<script language=\"JavaScript\" type=\"text/javascript\" src=\"counselingfollowup/" . $version . ".js\"></script>
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

