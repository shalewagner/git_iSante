// pediatric primary care intake form
<?php 
include 'tuberculosis/tuberculosis.php'; 
include 'primaryIntake/generalPanel.php';
include 'primaryIntake/relatives.php';
include 'primaryIntake/personalHistoryPanel.php';
include 'primaryIntake/vitalsPanel.php';
include 'primaryIntake/consultationPanel.php';
include 'primaryIntake/physicalExamPanel.php'; 
include 'primaryIntake/diagnosis.php'; 
include 'pedPrimaryIntake/powerUpsPanel.php';
include 'primaryIntake/procedures.php'; 
include 'pedPrimaryIntake/psychomotor.php';
include 'pedPrimaryIntake/diet.php';
include 'primaryIntake/otherplans.php'; 
include 'tuberculosis/tbEval.php';
?>
renderVerticalTabForm(
	[
		generalPanel,
		relativesPanel,
		personalHistoryPanel,
		dietPanel,
		powerUpExtTable('vaccine'),
		powerUpExtTable('supplement'),
		vitalsPanel, // size oddities?
		consultationPanel,
		physicalExamPanel,
		psychomotorPanel,
		diagnosisPanel,
		tuberculosis, 
		tbEvalExtTable ('tbEval'),
		endTreatment,
		proceduresPanel,
		otherplansPanel
	],
	"<?= _('MSPP Fiche de Première Consultation Pédiatrique (Décembre 2012)') ?>"
); 
