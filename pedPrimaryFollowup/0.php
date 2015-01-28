// pediatric primary care followup form
<?php
include 'tuberculosis/tuberculosis.php';
include 'primaryIntake/generalPanel.php';
include 'primaryIntake/consultationPanel.php';
include 'pedPrimaryIntake/psychomotor.php';
include 'primaryIntake/physicalExamPanel.php'; 
include 'primaryIntake/vitalsPanel.php';
include 'primaryIntake/diagnosis.php'; 
include 'pedPrimaryFollowup/powerUpsPanel2.php';
include 'primaryIntake/procedures.php'; 
include 'primaryIntake/otherplans.php';
include 'pedPrimaryIntake/diet.php';
include 'tuberculosis/tbEval.php';
?>
renderVerticalTabForm([
	generalPanel,
	dietPanel,
	powerUpVaccSupp,
	vitalsPanel,
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
	"<?= _('MSPP Fiche de Consultation Pédiatrique (Décembre 2012)') ?>"
);
