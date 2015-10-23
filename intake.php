<?php
require_once 'include/standardHeaderExt.php';
require_once 'labels/followup.php';
require_once 'labels/intake.php';
require_once 'labels/pediatric.php';
require_once 'labels/pmtctfollowup.php';
require_once 'labels/pmtctfollowup.php';

$mf = getData("sex", "textarea");

$registVisitDt =  getRegistVisitDt($pid,$site);
echo '
 <script type="text/javascript">
 </script>
 <title>' . ${$typeArray[$type] . 'FormTitle'}[$lang][1] . '</title>
 </head>
 <body>
 <form name="mainForm" target="mainWindow" action="patienttabs.php?pid=$pid&lang=$lang&site=$site" method="post">
 <input id="registVisitDt" name="registVisitDt" type="hidden" value="' . $registVisitDt .'" />
 <input id="sex1" name="sex1" type="hidden" value="' . $mf. '">
 <input id="errorSave" name="errorSave" type="hidden" />
 <script type="text/javascript" src="include/arv.js"></script>
 '; 

//$tabsOn = false;
//if ($tabsOn) include("include/tabs/intakeTabs.php");
$tabIndex = 0;

include ('include/patientIdClinicVisitDate.php');

if($type == '1'){
	include ($typeArray[$type] . "/" . $version . ".php");
	$tabIndex = 22005;
} else if($type == '16'){
	include("pedintake.php");
	$tabIndex = 8000;
}
echo"<div id=\"saveButtons\">";
include ('include/saveButtons.php');
echo"
	</div>
   </form>
 </body>
</html>";
?>
