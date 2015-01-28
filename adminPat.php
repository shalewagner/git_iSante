<?php

require_once 'include/standardHeaderExt.php';
require_once 'labels/findLabels.php';
require_once 'labels/menu.php';

// Check authorization
if (getAccessLevel (getSessionUser ()) < 2) {
  header ("Location: error.php?type=auth&lang=$lang");
  exit;
}
$patientDOB = getData ("dobDd", "textarea") . "/" . getData ("dobMm", "textarea") . "/" . getData ("dobYy", "textarea");
$patientStatus = getPatientStatus ($pid);
$patientRegimen = getRegimen($pid) ;
$fname = getData ("fname", "textarea");
$lname = getData ("lname", "textarea");
$clinID = getData ("clinicPatientID", "textarea");
$fnamemom =  getData ("fnameMother", "textarea");
$natID =  getData ("nationalID", "textarea");
$symptoms = getSymptoms($pid, $lang, array($coverLabels[$lang][6],$coverLabels[$lang][10]));
$symptoms = str_replace("'","\'",$symptoms);
$mf = getData("sex", "textarea");
if($mf!=""){
	$mf=$sex[$lang][$mf];
}

echo "
  <title>" . _('Vérification de suppression de patient') . "</title>
  <script type=\"text/javascript\">
    function redirectY(){
    	var answer = confirm ('". _('Étes-vous sûr vous voulez-vous supprimer ce patient et toutes leurs formes ?') ."');
	if (answer) {
	    	document.mainForm.method='post';
	    	document.mainForm.action='find.php';
	    	document.mainForm.submit(); 
	} else {
		history.back();
	}

    }
    function redirectN(){
    	document.mainForm.method='get';
    	document.mainForm.target='mainWindow';
    	document.mainForm.action ='patienttabs.php?pid=". $pid."&amp;lang=".$lang."&amp;site=".$site."';
    	document.mainForm.submit();
    }
";
include_once ("include/patientHeaderButtonFunctions.js");
echo "

  </script>

 </head>
 <body>
 <form name=\"mainForm\" action=\"find.php\" method=\"post\">
";

include("bannerbody.php");
// If patient ID given, display delete confirmation
if (!empty ($pid) && preg_match ('/^\d+$/', $pid)) {
	include "patient/patientHeader.php";
	echo "
	<table class=\"header\">
	     <tr>
	      <td class=\"m_header\">" . _('Vérification de suppression de patient') . "</td>
	     </tr>
	  </table>
	  <table class=\"header\">
	   <tr id=\"deleteHead\">  <h4 class=\"statusMsg\">" . _('Étes-vous sûr vous voulez-vous supprimer ce patient et toutes leurs formes ?') . "</h4>
	</tr><tr>
	    <td align=\"right\">
	     <input type=\"hidden\" name=\"lang\" value=\"$lang\"/>
	     <input type=\"hidden\" name=\"pid\" value=\"$pid\"/>
	     <input type=\"hidden\" name=\"lastPid\" value=\"$lastPid\"/>
		 <input type=\"hidden\" name=\"deletePatient\" value=\"exists\" />
	     <input type=\"button\" name=\"confirmYes\" onclick=\"redirectY();\"value=\"" . _('Oui') . "\"/>
	    </td>
	    <td class=\"left_pad\" align=\"left\">
	     <input type=\"button\" name=\"confirmNo\" onclick=\"redirectN();\" value=\"" . _('Non') . "\">
	     </form>
	    </td>
	   </tr>
	  </table>";   
} else {
  echo "
     <h4 align=\"center\">" . _('Information sur le patient non trouvée') . "</h4>";
}

echo "
 </body>
</html>
";

?>
