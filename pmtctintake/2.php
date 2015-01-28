// ob-gyn intake form
<?
include 'tuberculosis/tuberculosis.php';
include 'primaryIntake/generalPanel.php';
include 'primaryIntake/relatives.php'; 
include 'primaryIntake/personalHistoryPanel.php';
include 'pmtctintake/obgynHistoryPanel.php'; 
include 'pmtctintake/vaccins.php';
include 'primaryIntake/vitalsPanel.php';
include 'primaryIntake/consultationPanel.php';
include 'primaryIntake/physicalExamPanel.php';
include 'primaryIntake/procedures.php'; 
include 'primaryIntake/diagnosis.php'; 
include 'primaryIntake/otherplans.php';
include 'tuberculosis/tbEval.php';
?>

renderVerticalTabForm([
	generalPanel,
	relativesPanel,
	personalHistoryPanel,
	obgynHistoryPanel,
	obVaccinPanel(),
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
"<?= _('MSPP Fiche de Première Consultation OB-GYN (Décembre 2012)') ?>"
);
