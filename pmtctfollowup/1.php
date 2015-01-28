<?php
if ($tabsOn) {
  echo $tabHeaders;
}

echo "
<div id=\"tab-panes\">";


$tab = 0;

include('pmtct/obstDiagnostics.php');

$tab = $tab + 1000;
include('pmtct/familyPlanning.php');

$tab = $tab + 1000;
include('pmtct/vihStatut.php');

$tab = $tab + 1000;
include('pmtct/reference.php');

$tab = $tab + 1000;
include('pmtct/riskSection.php');

$tab = $tab + 1000;
include('pmtctintake/meds.php');

$tab = $tab + 1000;

//arvs section

echo "
 <div id=\"pane_arvs\">

  <table class=\"header\">
";
$arv_rows = arvRows (4001);
include ('pmtctintake/arvs.php');
echo "
 <a name=\"medications_section\"> </a>

  </table>
 </div>";

$tab = $tab + 1000;

include('pmtctintake/allergies.php');

$tab = $tab + 1000;
echo "<div id=\"pane_immunizations\">
	<table>";
include('pmtctintake/immunizations.php');
echo "</table></div>";

$tab = $tab + 1000;
include ('pmtctintake/tbStatus.php');

//make a header here for examen clinique

$tab = $tab + 1000;
include('pmtct/vitalSigns.php');

$tab = $tab + 1000;
include('pmtct/symptomSection.php');



$tab = $tab + 1000;
echo "
  <div id=\"pane_physicalExam\">
   <table class=\"header\">";
$tabIndex = 9000;
include ('clinicalExam/pmtct.php');
echo "
  </table>
 </div>";

$tab = $tab + 1000;
include('pmtct/gestesChirur.php');

$tab = $tab + 1000;
include('pmtct/gestesObste.php');

$tab = $tab + 1000;
include('pmtct/otherGestes.php');

$tab = $tab + 1000;
include('pmtct/evalAndPlanning.php');

$tab = $tab + 1000;
include('pmtct/birthPlanSection.php');

$tab = $tab + 1000;
include('pmtct/birthPlan.php');


echo "
</div>";
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"pmtctfollowup/".$version.".js\"></script>";
?>




