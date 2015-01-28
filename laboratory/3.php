<?
$labLoc = array (
'southLabel' => array('en' => 'MSPP LABORATORY ANALYSIS FORM (VERSION OCTOBER 2014)', 'fr' => 'MSPP FICHE D’ANALYSES DE LABORATOIRE (VERSION OCTOBRE 2014)'),
'title' => array('en' => 'Lab order form', 'fr' => 'Fiche de lab'),
'gridLabel' => array('en' => 'Tests ordered', 'fr' => 'Tests demandés'),
'visitType' => array('en' => 'VISIT TYPE', 'fr' => 'TYPE DE VISITE'), 
'lname' => array('en' => 'Last name', 'fr' => 'Nom'), 
'fname' => array('en' => 'First name', 'fr' => 'Prénom'), 
'dob' => array('en' => 'Date of birth', 'fr' => 'Date de naissance'), 
'sex' => array('en' => 'Gender', 'fr' => 'Sexe'), 
'identifiers' => array('IDENTIFIERS' => 'Gender', 'fr' => 'IDENTIFICATEURS'),
'fnameMother' => array('en' => 'Mother’s first name', 'fr' => 'Prénom de la mère'),
'labVisitType1' => array('en' => 'External clinic', 'fr' => 'Clinique externe'),
'labVisitType2' => array('en' => 'Initial visit', 'fr' => 'Visite initiale'),
'labVisitType3' => array('en' => 'Followup visit', 'fr' => 'Visite de suivi'),
'labVisitType4' => array('en' => 'Consultation', 'fr' => 'Consultation'),
'labOrderNumber' => array('en' => 'Order #', 'fr' => 'No. d’ordre'),
'toOE1' => array('en' => 'Methodology external', 'fr' => 'Méthodologie externe'),
'toOE2' => array('en' => 'Methodology iSanté', 'fr' => 'Méthodologie iSanté'),
'doctorSignature1' => array('en' => 'Doctors signature, First', 'fr' => 'Signature du médecin, Prénom'),
'doctorSignature2' => array('en' => 'Last', 'fr' => 'Nom'),
'printButton' => array('en' => 'Print lab order', 'fr' => 'Imprimer l’ordre'), 
'sendLabButton' => array('en' => 'Send order', 'fr' => 'Envoyer l’ordre'),
'orderUnsaved' => array('en' => 'This order has unsaved changes', 'fr' => 'Cet ordre a des modifications non enregistrées'), 
'orderNoItems' => array('en' => 'This order has no items included', 'fr' => 'Cet ordre n’a pas d’articles inclus'), 
'itemInOrder' => array('en' => 'This item is already in the order', 'fr' => 'Cet article est déjà dans l’ordre'),
'orderSent' => array('en' => 'This order was sent to the lab', 'fr' => 'L’ordre a été envoyé au laboratoire'), 
'chooseMethod' => array('en' => 'You must choose either: \n  Methodology external\n ou \n   Methodology iSanté', 'fr' => 'Il faut choisir soit: \n  Méthodologie externe \n ou \n  Méthodologie iSanté'), 
'saveSuccessful' => array('en' => 'Save successful', 'fr' => 'Sauvegarde réussie'),
'saveResultsButton' => array('en' => 'Save Results', 'fr' => 'Sauvegarder les résultats'), 
'saveResults' => array('en' => 'Results were saved', 'fr' => 'Les résultats ont été enregistrés'),
'cmGroup' => array('en' => 'Group', 'fr' => 'Groupe'), 
'cmName' => array('en' => 'Test Name', 'fr' => 'Nom du test'), 
'cmSampleType' => array('en' => 'Sample Type', 'fr' => 'Type d’échantillon'), 
'cmResultDate' => array('en' => 'Result date', 'fr' => 'Date du résultat'),
'cmResult' => array('en' => 'Result', 'fr' => 'Résultat'), 
'cmAccNum' => array('en' => 'Accession Number', 'fr' => 'Numéro d’accession'), 
'cmSourceLab' => array('en' => 'Source Lab', 'fr' => 'Lab référant'), 
'cmRemarks' => array('en' => 'Remarks', 'fr' => 'Remarques'), 
'cmDelete' => array('en' => 'Delete?', 'fr' => 'Supprimer?'), 
'tChoose' => array('en' => 'Choose panel/test', 'fr' => 'Choisir panel/test'), 
'tChooseSample' => array('en' => 'Select preferred sample type', 'fr' => 'Sélectionner le type d’échantillon préféré'),
'tMustSelect' => array('en' => 'You must make a selection', 'fr' => 'Il faut sélectionner'), 
'select' => array('en' => 'Select', 'fr' => 'Sélectionner'),
'cancel' => array('en' => 'Cancel', 'fr' => 'Annuler'),
'tNoPanels' => array('en' => 'Panels are not allowed with Methodologie iSanté', 'fr' => 'Les panels ne sont pas autorisés dans la Méthodologie iSanté'),
'searchLabel' => array('en' => 'Enter search string', 'fr' => 'Entrez la chaîne de recherche'), 
'searchButton' => array('en' => 'Find', 'fr' => 'Rechercher'),
'searchNothing' => array('en' => 'Nothing found', 'fr' => 'Rien trouvé'),
'noPanelsDirectly' => array('en' => 'Panel results cannot be entered in iSanté. Please select the panel’s tests directly.', 'fr' => 'Les résultats du panel ne peuvent pas être entrés dans iSanté. Svp sélectionner directement les tests du panneau.') 
);
 
$patientStatus = getPatientStatus ($pid);
$usingOE = 0;
if (getConfig('labOrderUrl') != NULL) $usingOE = 1;
$newForm = 0;
$iFlag = 0;
$oFlag = 0;
$alreadySent = 0;
if ($eid == "" && $pid != "") {
	// generate this encounter 
	$newForm = 1;
	$curUser = getSessionUser();
	$version = 3;
	$eid = addEncounter ($pid, date ("d"), date ("m"), date ("y"), $site, date ("Y-m-d H:i:s"), $type, "added automatically when starting laboratory form", $curUser, $curUser, "", "", "", "", $version, getSessionUser(), date ("Y-m-d H:i:s"));
	getExistingData ($eid, $tables); 
} else {
	$sql = "select labID as labid, sampletype as sampletype from a_labs where encounter_id = " . $eid . " and sitecode = " . $site . " and patientid = " . $pid;
	$rc = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $is = array('isante', 'iSanté', 'isanté','iSante');         
        foreach($rc as $key => $value) {
                $id = $value['labid'];
                $st = $value['sampletype'];
                if ($id < 1000 || in_array($st,$is)) $iFlag = 1;
                if ($id > 1000 && !in_array($st,$is)) $oFlag = 1; 
	} 
	$sql = "select count(*) as cnt from encounterQueue where encounter_id = " . $eid . " and sitecode = " . $site . " and encounterStatus in (1,2,6)";
	$rc = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
	if ($rc[0]['cnt'] == 1) $alreadySent = 1;   
}
if ($eid == "")  {
	header ("Location: error.php?type=eid&lang=$lang");
	exit; 
}   
$vDate = getData ("visitDateDd", "textarea") . "/" . getData ("visitDateMm", "textarea") . "/" . getData ("visitDateYy", "textarea");    
?> 

<style type="text/css">
.x-custgrid3-row td {
line-height: 12px !important;
font-size: 10px !important;
}  
.x-custgrid-group-title hd {
line-height: 12px !important;
font-size: 10px !important;
}
</style>
<script type="text/javascript"> 
<?
        echo " 
        var southLabel = '" . $labLoc['southLabel'][$lang] ."';
        var iFlag = " . $iFlag . ";
        var oFlag = " . $oFlag . ";
        var sent =  " . $alreadySent . ";
        var usingOE = " . $usingOE . ";
        ";
	include 'include/formValidationExt.js';   
	include 'laboratory/labHeader.php';
	include 'laboratory/tests.php';
	include 'laboratory/labGrids.php';
	include 'include/visitDatePanel.php'; 
?>

	Ext.onReady(function() {
		var win2;

		var grids = new Ext.Panel({ 
			region: 'center',
			id: 'grids', 
			layout: 'form',
			autoScroll: true,
			items: [
				a_labsGrid
				,enclosingPanel
			]
		});
		var vp = new Ext.Viewport({
			layout: 'border',
			id: 'vp',
			autoScroll: true,
			items: [ 
				visitDatePanel,
				grids,
				footerPanel 
			] 
		});  
		<? 
		// initial conditions (new order)
		echo " 
			Ext.getCmp('sendLabButton').setVisible(false); 
			Ext.getCmp('saveResultsButton').setVisible(false);
			resultColsNotShowing = true;
			for (var i = 5; i < 9; i++) a_labsGrid.getColumnModel().setHidden(i, resultColsNotShowing);
		"; 
		?> 
		a_labsDs.load({params: {task: 'getOrdered'}}); 
		adjustDisplayedWidgets(usingOE, iFlag,oFlag,sent); 
	});
</script> 
<title><?=$labLoc['title'][$lang]?></title> 
</head>
<body>
<div id="win2"></div>
</body>
</html>
