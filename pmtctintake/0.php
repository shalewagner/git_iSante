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

//include('pmtct/vaccines.php');
$tab = $tab + 1000;
echo "
 <div id=\"pane8_1\">
  <table width=\"100%\">";
include ("immunizations.php");
echo "</table>
 </div>";

if (DEBUG_FLAG) fb($tab, "5");
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
 <div id=\"pane4_1\">

  <table class=\"header\">
";
$arv_rows = arvRows (4001);
include ("arvs.php");
echo "
 <a name=\"medications_section\"> </a>

  </table>
 </div>";

$tab = $tab + 1000;

//include('pmtct/tbStatus');

echo "
 <div id=\"pane8\">
  <table width=\"100%\">";
include ("tbStatus.php");


echo
 "</table>
 </div>";

$tab = $tab + 1000;
include('allergies.php');

//include('pmtct/treatmentSection.php');

$tab = $tab + 1000;
include('meds.php');

$tab = $tab + 1000;
include('pmtct/symptomSection.php');


//include('pmtct/conditions.php');


$tab = $tab + 1000;

echo "
  <div id=\"pane9\">
   <table class=\"header\">";
include ("clinicalExam/pmtct.php");
echo "
  </table>
 </div>";


$tab = $tab + 1000;
//include('pmtct/conditionSection.php');
 echo "
 <div id=\"pane2\">
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
