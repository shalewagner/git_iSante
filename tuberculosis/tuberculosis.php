var newOrPrevious = {
	layout: 'hbox',
	defaults: { margins: '0 3'},
	flex: 0.3,
	items: [{
		xtype: 'spacer', width: '3em'
	},{
		boxLabel: '<?=_('Nouveau diagnostic')?>',
		<?= genExtWidget ('tbDxNew', 'radio', 1); ?>
	},{
		boxLabel: '<?=_('Suivi')?>',
		<?= genExtWidget ('tbDxNew', 'radio', 2); ?> 
	}]
};
	
var tbRegisterPanel = {
	layout: 'hbox',
	defaults: { margins: '0 3'},
	flex: 0.3,
	items: [{
		xtype: 'label',
		//width: 100,
		text: '<?=_('No. d’enregistrement TB :')?>'
	},{
		width: '4em',
		<?= genExtWidget('currentTreatNo', 'textfield', 0); ?> 
	},{
		xtype: 'label',
		//width: 100,
		text: '<?=_('Date d’enregistrement :')?>'
	},{
		format: 'd/m/y',
		width: 100,
		<?= genExtWidget('tbRegistrationDt', 'datefield', 0); ?>
	},{
		xtype: 'label',
		//width: 100,
		text: '<?=_('Etablissement :')?>'
	},{
		width: '20em',
		<?= genExtWidget('currentTreatFac', 'textfield', 0); ?> 
	}]
};

var typeMalade = {
	layout: 'hbox',
	defaults: { margins: '0 3'},
	flex: 0.3,
	items: [{
		xtype: 'label',
		text: '<?=_('Type de Malade')?>'
	},{
		boxLabel: '<?=_('Nouveau')?>',
		<?= genExtWidget ('tbMaladeNew', 'checkbox', 0); ?>
	},{
		boxLabel: '<?=_('Traitement après interruption')?>',
		<?= genExtWidget ('tbMaladeInterrupted', 'checkbox', 0); ?> 
	},{
		boxLabel: '<?=_('Echec')?>',
		<?= genExtWidget ('tbMaladeEchec', 'checkbox', 0); ?> 
	},{
		boxLabel: '<?=_('Rechute')?>',
		<?= genExtWidget ('tbMaladeRechute', 'checkbox', 0); ?> 
	},{
		boxLabel: '<?=_('Transféré')?>',
		<?= genExtWidget ('tbMaladeTransfer', 'checkbox', 0); ?> 
	},{
		boxLabel: '<?=_('MDR TB')?>',
		<?= genExtWidget ('tbMaladeMdr', 'checkbox', 0); ?> 
	}]
};
var classification = {
	layout: 'hbox',
	autoHeight: true,
	defaults: { margins: '0 3'},
	flex: 0.3,
	items: [{
		xtype: 'label',
		text: '<?=_('Classification de la maladie')?>'
	},{
		boxLabel: '<?=_('Pulmonaire')?>',
		<?= genExtWidget ('tbClassPulmonaire', 'checkbox', 0); ?>
	},{
		boxLabel: '<?=_('Extra-pulmonaire')?>',
		<?= genExtWidget ('tbClassExtra', 'checkbox', 0); ?> 
	},{
		xtype: 'label',
		style: { fontStyle: 'italic'},
		text: '<?=_('marquer ci-dessous :')?>'
	}]
};
var marquer = {
	layout: 'hbox',
	autoHeight: true,
	defaults: { margins: '0 3'},
	flex: 0.3,
	items: [{
		xtype: 'spacer', width: '3em'
	},{
		boxLabel: '<?=_('Méningite')?>',
		<?= genExtWidget ('tbMeningite', 'checkbox', 0); ?>
	},{
		boxLabel: '<?=_('Génitale')?>',
		<?= genExtWidget ('tbGenitale', 'checkbox', 0); ?> 
	},{
		boxLabel: '<?=_('Pleurale')?>',
		<?= genExtWidget ('tbPleurale', 'checkbox', 0); ?> 
	},{
		boxLabel: '<?=_('Miliaire')?>',
		<?= genExtWidget ('tbMiliaire', 'checkbox', 0); ?> 
	},{
		boxLabel: '<?=_('Ganglionnaire')?>',
		<?= genExtWidget ('tbGanglionnaire', 'checkbox', 0); ?> 
	},{
		boxLabel: '<?=_('Intestinale')?>',
		<?= genExtWidget ('tbIntestinale', 'checkbox', 0); ?> 
	},{
		boxLabel: '<?=_('Autre')?>',
		<?= genExtWidget ('tbClassOther', 'checkbox', 0); ?> 
	},{
		width: '24em',
		<?= genExtWidget('tbClassOther_specify', 'textfield', 0); ?> 
	}]
}; 
var diagnosis = {
	layout: 'hbox',
	defaults: { margins: '0 3'},
	flex: 0.3,
	items: [{
		xtype: 'label',
		text: '<?=_('Diagnostic base sur :')?>'
	},{
		boxLabel: '<?=_('Crachat');?>',
		<?= genExtWidget ('tbDxCrachat', 'checkbox', 0); ?>
	},{
		boxLabel: '<?=_('X-Ray');?>',
		<?= genExtWidget ('tbDxXray', 'checkbox', 0); ?> 
	},{
		boxLabel: '<?=_('Impression Clinique');?>',
		<?= genExtWidget ('tbDxClinique', 'checkbox', 0); ?> 
	}]
};  
var startDate = {
	layout: 'hbox',
	defaults: { margins: '0 3'},
	flex: 0.3,
	items: [{
		xtype: 'label',
		text: '<?= _('Date début traitement') ?>'
	},{
		format: 'd/m/y',
		width: 100,
		<?= genExtWidget ('tbStartTreatment', 'datefield', 0); ?>
	}]
};
var regimen = {
	layout: 'hbox',
	defaults: { margins: '0 3'},
	flex: 0.3,
	items: [{
		xtype: 'label',
		text: '<?=_('Régime et posologie prescrits')?>'
	},{
		boxLabel: '<?=_('E')?>',
		<?= genExtWidget ('tbRegimenE', 'checkbox', 0); ?> 
	},{
		boxLabel: '<?=_('4RH')?>',
		<?= genExtWidget ('tbRegimen4rh', 'checkbox', 0); ?> 
	},{
		boxLabel: '<?=_('5RHE')?>',
		<?= genExtWidget ('tbRegimen5rhe', 'checkbox', 0); ?> 
	},{
		boxLabel: '<?=_('1RHEZ')?>',
		<?= genExtWidget ('tbRegimenRhez', 'checkbox', 0); ?> 
	},{
		boxLabel: '<?=_('2RHEZ')?>',
		<?= genExtWidget ('tbRegimen2rhez', 'checkbox', 0); ?> 
	},{ 
		boxLabel: '<?=_('S')?>',
		<?= genExtWidget ('tbRegimenS', 'checkbox', 0); ?>
	},{
		boxLabel: '<?=_('2S')?>',
		<?= genExtWidget ('tbRegimen2s', 'checkbox', 0); ?> 
	},{
		boxLabel: '<?=_('2SRHEZ')?>',
		<?= genExtWidget ('tbRegimen2srhez', 'checkbox', 0); ?> 
	},{  
		boxLabel: '<?=_('Z')?>',
		<?= genExtWidget ('tbRegimenZ', 'checkbox', 0); ?> 
	}] 
};
var regimenCodes = {
	layout: 'hbox',
	defaults: { 
		margins: '0 3', 
		style: { fontStyle: 'italic'}
	},
	flex: 0.3,
	items: [{
		xtype: 'spacer', width: '6em'
	},{
		xtype: 'label',
		text: '<?=_('S: Streptomycine')?>'
	},{
		xtype: 'label',
		text: '<?=_('R: Rifampicine')?>'
	},{
		xtype: 'label',
		text: '<?=_('H: Isoniazide')?>'
	},{
		xtype: 'label',
		text: '<?=_('E: Ethambutol')?>'
	},{
		xtype: 'label',
		text: '<?=_('Z: Pyrizinamide')?>'
	}]
};
var casContact = {
	layout: 'hbox',
	defaults: { margins: '0 3'},
	flex: 0.3,
	items: [{
		xtype: 'label',
		text: '<?=_('Cas Contact (TPM+)')?>'
	},{
		boxLabel: '<?=_('Oui');?>',
		<?= genExtWidget ('tbCasContactYN', 'radio', 1); ?>
	},{
		boxLabel: '<?=_('Non');?>',
		<?= genExtWidget ('tbCasContactYN', 'radio', 2); ?> 
	},{
		xtype: 'label',
		text: '<?=_('Nombre de contacts :')?>'
	},{
		width: '4em',
		<?= genExtWidget('tbCasContactNumber', 'numberfield', 0); ?> 
	},{	
		xtype: 'label',
		text: '<?=_('No de référence du cas index : ')?>'
	},{
		width: '4em',
		<?= genExtWidget('tbCasContactReference', 'numberfield', 0); ?> 
	}]
};  
var accompagnateur = {
	layout: 'hbox',
	defaults: { margins: '0 3'},
	flex: 0.3,
	items:	[{
		xtype: 'label',
		text: '<?=_('Accompagnateur')?>'
	},{
		boxLabel: '<?=_('Oui');?>',
		<?= genExtWidget ('tbAccompagnateurYN', 'radio', 1); ?>
	},{
		boxLabel: '<?=_('Non');?>',
		<?= genExtWidget ('tbAccompagnateurYN', 'radio', 2); ?> 
	},{
		xtype: 'label',
		text: '<?=_('Nom et Prénom :')?>'
	},{
		width: '32em',
		<?= genExtWidget('tbAccompagnateurName', 'textfield', 0); ?> 
	}] 
}; 

var testVIH = {
	layout: 'hbox',
	defaults: { margins: '0 3'},
	flex: 0.3,
	items: [{
		xtype: 'label',
		text: '<?=_('Statut VIH')?>'
	},{
		boxLabel: '<?=_('Non testé');?>',
		<?= genExtWidget ('tbTestVIH', 'radio', 1); ?>
	},{
		boxLabel: '<?=_('Négatif');?>',
		<?= genExtWidget ('tbTestVIH', 'radio', 2); ?> 
	},{
		boxLabel: '<?=_('Positif');?>',
		<?= genExtWidget ('tbTestVIH', 'radio', 4); ?>
	},{
		xtype: 'label',
		text: '<?= _('Date') ?>'
	},{
		format: 'd/m/y',
		width: 100,
		<?= genExtWidget ('tbTestvihDate', 'datefield', 0); ?>
	}]
};
var cd4Result = {
	layout: 'hbox',
	defaults: { margins: '0 3'},
	flex: 0.3,
	items:	[{
		xtype: 'spacer', width: '3em'
	},{	
		xtype: 'label',
		text: '<? echo ($isObgynEncounter) ? _('Si positif, enrôlée en soins : '): _('Si positif, enrôlé(e) en soins : '); ?>'
	},{
		boxLabel: '<?=_('Oui');?>',
		<?= genExtWidget ('tbIoYN', 'radio', 1); ?>
	},{
		boxLabel: '<?=_('Non');?>',
		<?= genExtWidget ('tbIoYN', 'radio', 2); ?> 
	},{	
		xtype: 'label',
		text: '<?=_('CD4 : ')?>'
	},{
		width: '4em',
		<?= genExtWidget('tbCd4Result', 'numberfield', 0); ?> 
	},{
		xtype: 'label',
		text: '<?= _('Date') ?>'
	},{
		format: 'd/m/y',
		width: 100,
		<?= genExtWidget ('tbCd4ResultDate', 'datefield', 0); ?>
	},{
		boxLabel: '<?=_('Inconnue')?>',
		<?= genExtWidget ('tbCd4ResultDateUnknown', 'checkbox', 0); ?>
	}]
};    
var arv = {
	layout: 'hbox',
	defaults: { margins: '0 3'},
	flex: 0.3,
	items:	[{
		xtype: 'spacer', width: '3em'
	},{
		xtype: 'label',
		text: '<?=_('ARV')?>'
	},{
		boxLabel: '<?=_('Oui');?>',
		<?= genExtWidget ('tbArvYN', 'radio', 1); ?>
	},{
		boxLabel: '<?=_('Non');?>',
		<?= genExtWidget ('tbArvYN', 'radio', 2); ?> 
	},{
		xtype: 'label',
		text: '<?=_('Si oui, médicaments : ')?>'
	},{
		width: '32em',
		<?= genExtWidget('tbArvMeds', 'textfield', 0); ?> 
	}] 
};
var arvDate = {
	layout: 'hbox',
	defaults: { margins: '0 3'},
	flex: 0.3,
	items: [{
		xtype: 'spacer', width: '3em'
	},{
		xtype: 'label',
		text: '<?= _('Date de début') ?> : '
	},{
		format: 'd/m/y',
		width: 100,
		<?= genExtWidget ('tbArvDate', 'datefield', 0); ?>
	}]
};
var prophylaxie = {
	layout: 'hbox',
	defaults: { margins: '0 3'},
	flex: 0.3,
	items: [{
		xtype: 'label',
		text: '<?=_('Prophylaxie : ')?>'
	},{
		boxLabel: '<?=_('Cotrimoxazole')?>',
		<?= genExtWidget ('propCotrimoxazole', 'checkbox', 0); ?>
	},{
		boxLabel: '<?=_('Azythromycine')?>',
		<?= genExtWidget ('propAzythromycine', 'checkbox', 0); ?> 
	},{
		boxLabel: '<?=_('Fluconazole')?>',
		<?= genExtWidget ('propFluconazole', 'checkbox', 0); ?> 
	},{
		boxLabel: '<?=_('INH primaire')?>',
		<?= genExtWidget ('propINHprim', 'checkbox', 0); ?> 
	},{
		boxLabel: '<?=_('INH secondaire')?>',
		<?= genExtWidget ('propINHsec', 'checkbox', 0); ?> 
	}]
};

var supplements = {
	layout: 'hbox',
	defaults: { margins: '0 3'},
	flex: 0.3,
	items:	[{
		xtype: 'label',
		text: '<?=_('Supplémentation Alimentaire')?>'
	},{
		boxLabel: '<?=_('Oui');?>',
		<?= genExtWidget ('tbSupplimentsYN', 'radio', 1); ?>
	},{
		boxLabel: '<?=_('Non');?>',
		<?= genExtWidget ('tbSupplimentsYN', 'radio', 2); ?> 
	},{
		width: '32em',
		<?= genExtWidget('tbSuppliments', 'textfield', 0); ?> 
	}] 
}; 
var vitB6 = {
	layout: 'hbox',
	defaults: { margins: '0 3'},
	flex: 0.3,
	items:	[{
		xtype: 'label',
		text: '<?=_('Supplémentation en vitamine B')?>'
	},{
		boxLabel: '<?=_('Oui');?>',
		<?= genExtWidget ('tbSupVitBYN', 'radio', 1); ?>
	},{
		boxLabel: '<?=_('Non');?>',
		<?= genExtWidget ('tbSupVitBYN', 'radio', 2); ?> 
	}] 
};
var tuberculosis = new Ext.Panel ({  
    id: 'tuberculosis', 
	title: 'TUBERCULOSE',
<?   
     if ($_REQUEST['type'] < 24) echo "
	cls: 'extToOldForm',
        renderTo: 'tbPanel',";
?>
	autoHeight: true,
	autoWidth: true,
	items: [ 
		newOrPrevious,
	<? if ($_REQUEST['type'] != 32) echo "tbRegisterPanel,"; ?>
		typeMalade,
		classification,
		marquer,
		diagnosis,
		startDate,
		regimen,
		regimenCodes,
		casContact,
		accompagnateur,
		<? 
		if (!($isObgynEncounter && $isIntakeEncounter)) echo " 
		testVIH,
		cd4Result,
		arv,
		arvDate,
		prophylaxie,";
		?>
		supplements,
		vitB6
	]   
});

var stopDate = {
	layout: 'hbox',
	defaults: { margins: '0 3'},
	flex: 0.3,
	items: [{
		xtype: 'label',
		text: '<?= _('Date d’arret du traitement') ?> : '
	},{
		format: 'd/m/y',
		width: 100,
		<?= genExtWidget ('tbStopDate', 'datefield', 0); ?>
	}]
};
var stopReason = {
	layout: 'hbox',
	defaults: { margins: '0 3'},
	flex: 0.3,
	items: [{
		boxLabel: 'Guéri',
		 <?= genExtWidget ('tbStopReason', 'radio', 1); ?>
	},{
		boxLabel: 'Traitement Terminé',
		 <?= genExtWidget ('tbStopReason', 'radio', 2); ?>  
	},{
		boxLabel: 'Echec',
		 <?= genExtWidget ('tbStopReason', 'radio', 4); ?>  
	},{
		boxLabel: 'Abandon',
		 <?= genExtWidget ('tbStopReason', 'radio', 8); ?>  
	},{
		boxLabel: 'Transféré',
		 <?= genExtWidget ('tbStopReason', 'radio', 16); ?>  
	},{
		boxLabel: 'Décédé',
		 <?= genExtWidget ('tbStopReason', 'radio', 32); ?>  
	}]
}; 
var prestataire = { 
	layout: 'hbox',
	defaults: { margins: '0 3'},
	flex: 0.3,
	items: [{
		xtype: 'label',
		text: '<?=_('Nom de prestataire :')?>'
	},{
		width: '64em',
		<?= genExtWidget('tbPrestataire', 'textfield', 0); ?> 
	}]
};

var endTreatment = new Ext.Panel ({  
	id: 'endTreatment',
	title: 'RESULTAT DU TRAITEMENT<? if ($_REQUEST['type'] != 32) echo " (TB)"; ?>',
	<?   
	     if ($_REQUEST['type'] < 24) echo "
		cls: 'extToOldForm',
	        renderTo: 'endPanel',";
	?>
	autoHeight: true,
	autoWidth: true,
	items: [
		stopDate
		,stopReason
<? if ($_REQUEST['type'] == 32) echo ",prestataire"; ?>
	]       
});