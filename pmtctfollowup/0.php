<?php
if ($tabsOn) {
  echo $tabHeaders;
}

echo "
<div id=\"tab-panes\">";




include('pmtct/obstDiagnostics.php');

include('pmtct/conditionSection.php');


//arvs section

echo "
 <div id=\"arvs\">

  <table class=\"header\">
";
$arv_rows = arvRows (4001);
include ("pmtctintake/arvs.php");
echo "
 <a name=\"medications_section\"> </a>

  </table>
 </div>";


include('pmtctfollowup/allergies.php');

include('pmtctfollowup/meds.php');

include('pmtct/symptomSection.php');

//make a header here for examen clinique

include('pmtct/vitalSigns.php');



echo "
  <div id=\"pane9\">
   <table class=\"header\">";
$tabIndex = 9000;
include ("clinicalExam/pmtct.php");
echo "
  </table>
 </div>";

include('pmtct/evalAndPlanning.php');

include('pmtct/otherInterventions.php');

include('pmtct/birthPlanSection.php');

include('pmtct/birthPlan.php');


echo "
</div>";
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"pmtctfollowup/".$version.".js\"></script>";
?>




