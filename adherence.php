<?php
require_once 'include/standardHeaderExt.php';
require_once 'labels/adherence.php';

/*
if(isPediatric($pid)){
	$type = '20';
} else {
	$type = '14';
}
*/
echo "
  <title>" . ${$typeArray[$type] . 'FormTitle'}[$lang][1] . "</title>";
  echo "
   </head>
   <body>
  <form name=\"mainForm\" target=\"mainWindow\" action=\"patienttabs.php\"  method=\"post\">
   <input id=\"errorSave\" name =\"errorSave\" type=\"hidden\" value=\"\"/>

";
$tabIndex = 0;
include ("include/patientIdClinicVisitDate.php");
if($type == "20"){
	include("pedadherence.php");
} else {
	include ("adherence/0.php");
}
$tabIndex = 5000;
echo"<div id=\"saveButtons\">";
include ("include/saveButtons.php");

echo "
</div>
		</form>
 	</body>
</html>
";

?>
