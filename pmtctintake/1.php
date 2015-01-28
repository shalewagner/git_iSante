<?php


if ($tabsOn) {
  echo $tabHeaders;
}
$max_treatments = 5;
echo "
<div id=\"tab-panes\">";



$tab = 0;
include('pmtct/sourceOfReference.php');

$tab = $tab + 1000;
include('pmtct/habit.php');

$tab = $tab + 1000;
include('pmtct/backgroundObstetrical.php');

$tab = $tab + 1000;
include('pmtct/familyPlanning.php');

$tab = $tab + 1000;
echo "
 <div id=\"pane_Immunizations\">
  <table width=\"100%\">";
include ("immunizations.php");
echo "</table>
 </div>";

$tab = $tab + 1000;
include('pmtct/sexLast3Mos.php');

$tab = $tab + 1000;

include('pmtct/vitalSigns.php');

$tab = $tab + 1000;
include('pmtct/vihStatut.php');

$tab = $tab + 1000;
include('pmtct/reference.php');

$tab = $tab + 1000;
include('pmtct/riskSection.php');

$tab = $tab + 1000;
echo "<br/>";



echo "
 <div id=\"pane_arvs\">

  <table class=\"header\">
";
$arv_rows = arvRows (8301);
include ("arvs.php");
echo "
 <a name=\"medications_section\"> </a>

  </table>
 </div>";

$tab = $tab + 1000;

include ("tbStatus.php");


$tab = $tab + 1000;
include('allergies.php');


$tab = $tab + 1000;
include('meds.php');

$tab = $tab + 1000;
include('pmtct/symptomSection.php');



$tab = $tab + 1000;

echo "
  <div id=\"pane_physicalExam\">
   <table class=\"header\">";
include ("clinicalExam/pmtct.php");
echo "
  </table>
 </div>";


$tab = $tab + 1000;
 echo "
 <div id=\"pane_conditions\">
  <table class=\"header\">";
include ("conditions/pmtct.php");
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
include('pmtct/otherInterventions.php');

$tab = $tab + 1000;
include('pmtct/birthPlanSection.php');

$tab = $tab + 1000;
include('pmtct/birthPlan.php');

echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"pmtctintake/".$version.".js\"></script>";




?>
