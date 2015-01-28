<?php
require_once 'include/standardHeaderExt.php';
require_once 'labels/selection.php';

$type=11;
echo"  <title>" . ${$typeArray[$type] . 'FormTitle'}[$lang][1] . "</title>
 </head>
 <body>
<form name=\"mainForm\" target=\"mainWindow\" action=\"patienttabs.php\" method=\"post\">
 <input id=\"errorSave\" name =\"errorSave\" type=\"hidden\" value=\"\"/>


<!-- ******************************************************************** -->
<!-- ************************* Selection Committee ********************** -->
<!-- ********************* (tab indices 2001 - 3000) ******************** -->
<!-- ******************************************************************** -->
";
include ("include/patientIdClinicVisitDate.php");
$tabsOn = false;
if ($tabsOn) {
  echo $tabHeaders;
}
echo "
<div id=\"tab-panes\">
";
include ("selection/".$version.".php");



echo "</div><div id=\"saveButtons\">";
include ("include/saveButtons.php");

echo "
</div></form>
 </body>
</html>
";

?>
