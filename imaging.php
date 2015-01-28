<?php
require_once 'include/standardHeaderExt.php'; 

require_once 'labels/followup.php';
require_once 'labels/intake.php';
require_once 'labels/menu.php';
require_once 'labels/pediatric.php'; 


$mf = getData("sex", "textarea");
$label1 = $encType['fr'][32]; 

echo '<title>' . $label1 . '</title>';
echo '<script language="javascript" type="text/javascript" src="laboratory/labs.js"></script>';
echo '
 </head>
 <body>
<form name="mainForm" target="mainWindow" action="patienttabs.php" method="post">
 <input id="errorSave" name="errorSave" type="hidden" value=""/>
 <input id="sex1" name="sex1" type="hidden" value="' . $mf . '"/>
';
$tabIndex = 0;

include ('include/patientIdClinicVisitDate.php');
echo '
<div id="tab-panes">
<div id="pane1"><hr/>
';

$tabIndex = 4000;
include ("imaging/0.php");
echo '</div></div>';

$tabIndex = 5000;
$formName = "imaging";
echo '<div id="saveButtons">';
include ("include/saveButtons.php");
?>
     </div>
   </form>
 </body>
</html>
?>
