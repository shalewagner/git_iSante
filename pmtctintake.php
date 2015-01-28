<?
require_once 'include/standardHeaderExt.php';
if ($version < 2) {
require_once 'labels/followup.php';
require_once 'labels/intake.php';
require_once 'labels/pediatric.php';
require_once 'labels/pmtctintake.php';
$mf = getData("sex", "textarea");
$registVisitDt =  getRegistVisitDt($pid,$site);
echo "<title>" . ${$typeArray[$type] . 'FormTitle'}[$lang][1] . "</title>
 </head>
 <body>
<form name=\"mainForm\" target=\"mainWindow\" action=\"patienttabs.php\" method=\"post\">
 <input id=\"registVisitDt\" name=\"registVisitDt\" type=\"hidden\" value=\"".$registVisitDt."\"/>
 <input id=\"sex1\" name=\"sex1\" type=\"hidden\" value=\"".$mf."\">
 <input id=\"errorSave\" name =\"errorSave\" type=\"hidden\" value=\"\"/>
 <script language=\"javascript\" type=\"text/javascript\" src=\"include/arv.js\"></script>
 <script language=\"javascript\" type=\"text/javascript\" src=\"include/arvs.js\"></script>
";
$tabIndex = 0;
include ('include/patientIdClinicVisitDate.php');
include ($typeArray[$type] . "/" . $version . ".php");
$tabIndex = 22000;
echo"<div id=\"saveButtons\">";
include ('include/saveButtons.php');
echo "
</div>
</form>
</body>
</html>";
} else {
	include 'include/verticalTabHeader.php';
}
?>