// adult primary care intake form
<?php
include 'tuberculosis/tuberculosis.php';
include 'primaryIntake/generalPanel.php'; 
include 'primaryIntake/relatives.php';
include 'primaryIntake/personalHistoryPanel.php'; 
include 'primaryIntake/vitalsPanel.php';
include 'primaryIntake/consultationPanel.php';
include 'primaryIntake/physicalExamPanel.php'; 
include 'primaryIntake/diagnosis.php'; 
include 'primaryIntake/procedures.php'; 
include 'primaryIntake/otherplans.php';
include 'tuberculosis/tbEval.php'; 
?>

renderVerticalTabForm([
	generalPanel,
	relativesPanel,
	personalHistoryPanel,
	vitalsPanel,
	consultationPanel,
	physicalExamPanel,
	diagnosisPanel,
	tuberculosis, 
	tbEvalExtTable ('tbEval'),
	endTreatment,
	proceduresPanel,
	otherplansPanel 
	],
	"<?= _('MSPP Fiche de Première Consultation Adulte (Décembre 2012)') ?>"  
);
