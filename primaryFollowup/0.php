// adult primary care followup form
<?php
include 'tuberculosis/tuberculosis.php';
include 'primaryIntake/generalPanel.php';
include 'primaryIntake/vitalsPanel.php';
include 'primaryIntake/consultationPanel.php';
include 'primaryIntake/physicalExamPanel.php'; 
include 'primaryIntake/diagnosis.php'; 
include 'primaryIntake/procedures.php'; 
include 'primaryIntake/otherplans.php';
include 'tuberculosis/tbEval.php';
include 'primaryFollowup/powerUpsPanel2.php';
?>

renderVerticalTabForm([
		generalPanel,
		vitalsPanel,
		powerUpVaccSupp,
		consultationPanel,
		physicalExamPanel,
		diagnosisPanel,
		tuberculosis, 
		tbEvalExtTable ('tbEval'),
		endTreatment,
		proceduresPanel,
		otherplansPanel
	],
	"<?= _('MSPP Fiche de Consultation Adulte (Décembre 2012)') ?>" 
);
