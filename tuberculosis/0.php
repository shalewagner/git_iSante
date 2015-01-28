// tuberculosis stand-alone form
<?
if (isPediatric($pid)) 
	echo "isPediatricEncounter = true;";
else 
	echo "isAdultEncounter = true;"; 
include 'primaryIntake/generalPanel.php'; 
include 'primaryIntake/personalHistoryPanel.php'; 
include 'tuberculosis/tuberculosis.php';
include 'tuberculosis/tbEval.php';
include 'primaryIntake/vitalsPanel.php';  
?>     

renderVerticalTabForm([
	generalPanel,
	personalHistoryPanel,
	tuberculosis, 
	vitalsPanel,
	tbEvalExtTable ('tbEval'),
	endTreatment
   ],
   "<?= _('MSPP FICHE DE SOINS DE TUBERCULOSE (VERSION Août 2012)') ?>" 
);