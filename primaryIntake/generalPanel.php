var agePanelItem = {
    layout: { type: 'hbox' },
    defaults: {
	margins: '0 3'
    },
    flex: .25,
    items: [{
        xtype: 'label',
        text: '<?= _('Age:')?>'
    },{
	width: '5em',
        <?= genExtWidget('formAge', 'textfield', 0); ?>
    }]
};

var hemoglobinElectrophoresisPanelItem = {
    layout: {
	type: 'hbox'
    },
    defaults: {margins: '0 18 0 0'},
    flex: 2.5,
    items: [{
	    margins: '0 3',
	    xtype: 'label',
	    text: '<?= _('Électrophorèse de l’hémoglobine') ?> :'
	},{
	    boxLabel: 'AS',
	    <?= genExtWidget('electrophoreseTestResult', 'radio', 1); ?>
	},{
	    boxLabel: 'SS',
	    <?= genExtWidget('electrophoreseTestResult', 'radio', 2); ?>
	},{
	    boxLabel: 'AC',
	    <?= genExtWidget('electrophoreseTestResult', 'radio', 4); ?>
	},{
	    boxLabel: 'SC',
	    <?= genExtWidget('electrophoreseTestResult', 'radio', 8); ?>
	},{
	    boxLabel: 'AA',
	    <?= genExtWidget('electrophoreseTestResult', 'radio', 16); ?>
	},{
	    border: false,
	    items: [{
		    xtype: 'label',
		    text: '<?= _('Autre, précisez') ?> : '
		},{ 
		    width: '15em',
		    <?= genExtWidget('electrophoreseTestResult_specify', 'textfield', 0); ?>
		}]
	}]
};   
buildValidation(72, makeTestIfThen(makeTestAnyNotBlank('electrophoreseTestResult_specify0'),
				   makeTestNot(makeTestAnyIsChecked('electrophoreseTestResult1',
								    'electrophoreseTestResult2',
								    'electrophoreseTestResult4',
								    'electrophoreseTestResult8',
								    'electrophoreseTestResult16'))));

var birthWeightPanelItem = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 1,
    items: [{
	    xtype: 'label',
	    text: '<?= _('Poids de naissance') ?> :'
	},{
	    width: '4em',
            decimalSeparator: '.',
            <?= genExtWidget('birthWeight', 'numberfield', 0); ?>
        },{
            boxLabel: 'lb',
            <?= genExtWidget('birthWeightUnits', 'radio', 1); ?>
        },{
            boxLabel: 'kg',
            <?= genExtWidget('birthWeightUnits', 'radio', 2); ?>
	}]    
};
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('birthWeight0'),
                                      makeTestAnyIsChecked('birthWeightUnits1', 'birthWeightUnits2')));
buildValidation(25, makeTestInNumericRange('birthWeight0', 0, 500));

var schooledPanelItem = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 1.5,
    items: [{
	    xtype: 'label',
	    text: '<?= _('Scolarisé') ?> :'
	},{
	    boxLabel: '<?= _('Oui') ?>',
	    <?= genExtWidget('schooled', 'radio', 1); ?>
	},{ 
	    boxLabel: '<?= _('Non') ?>',
	    <?= genExtWidget('schooled', 'radio', 2); ?>
	},{
	    margins: '0 3 0 10',
	    xtype: 'label',
            text: '<?= _('Si oui, précisez classe') ?> : '
	},{
	    width: '20em',
	    <?= genExtWidget('schoolingClass', 'textfield', 0); ?>
	}]    
};
buildValidation(72, makeTestAllOrNone(makeTestAnyIsChecked('schooled1'),
				      makeTestAnyNotBlank('schoolingClass0')));

var referenceYesNoPanelItem = {
    layout: { type: 'hbox' },
    defaults: {
	margins: '0 3'
    },
    flex: 1,
    items: [{
        xtype: 'label',
        text: '<?= _('Référé(e) :')?>'
    },{
        boxLabel: '<?= _('Oui') ?>',
        <?= genExtWidget('referenceYesNo', 'radio', 1); ?>
    },{
        boxLabel: '<?= _('Non') ?>',
        <?= genExtWidget('referenceYesNo', 'radio', 2); ?>
    }]
}

var referencePanelItem = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 1,
    items: [{
	    xtype: 'label',
	    text: '<?= _('Source de référence') ?> :'
	},{
	    boxLabel: '<?= _('Hôpital') ?>',
	    <?= genExtWidget('referHosp', 'checkbox', 0); ?>
	},{
	    boxLabel: '<?= _('Clinique Externe') ?>',
	    <?= genExtWidget('referOutpatStd', 'checkbox', 0); ?>
	},{
	    boxLabel: '<?= _('Centres CDV intégrés') ?>',
	    <?= genExtWidget('referVctCenter', 'checkbox', 0); ?>
	},{
	    boxLabel: '<?= _('Programme communautaire') ?>',
	    <?= genExtWidget('referCommunityBasedProg', 'checkbox', 0); ?>
	}]    
};

var consultationTypePanelItem = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 1,
    items: [{
	    xtype: 'label',
	    text: '<?= _('Patiente vue pour Consultation') ?> :'
	},{
	    boxLabel: '<?= _('Gynécologique') ?>',
	    <?= genExtWidget('consult_rsn', 'checkbox', 0); ?>
	},{
	    boxLabel: '<?= _('Prénatale') ?>',
	    <?= genExtWidget('consult_obs', 'checkbox', 0); ?>
	},{
	    boxLabel: '<?= _('Postnatale') ?>',
	    <?= genExtWidget('consult_postnatale', 'checkbox', 0); ?>
	},{
	    boxLabel: '<?= _('Planification familiale') ?>',
	    <?= genExtWidget('consult_planification', 'checkbox', 0); ?>
	}]    
};

var etudePanelItem = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 1,
    items: [{
	    xtype: 'label',
	    text: '<?= _('Niveau d’étude') ?> :'
	},{
	    boxLabel: '<?= _('Primaire') ?>',
	    <?= genExtWidget('etudePrimaire', 'checkbox', 0); ?>
	},{
	    boxLabel: '<?= _('Secondaire') ?>',
	    <?= genExtWidget('etudeSecondaire', 'checkbox', 0); ?>
	},{
	    boxLabel: '<?= _('Universitaire') ?>',
	    <?= genExtWidget('etudeUniversitaire', 'checkbox', 0); ?>
	},{
	    boxLabel: '<?= _('Alphabétisée') ?>',
	    <?= genExtWidget('etudeAlph', 'checkbox', 0); ?>
	},{
	    boxLabel: '<?= _('Non Alphabétisée') ?>',
	    <?= genExtWidget('etudeNonAlph', 'checkbox', 0); ?>
	}]    
};

var isPregnantPanel = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: .50,
    items: [{
	    xtype: 'label',
	    text: '<?= _(' : Enceinte') ?> :'
	},{ 
	    boxLabel: '<?= _('Oui') ?>',
	    <?= genExtWidget('pregnant', 'radio', 1); ?>
	},{ 
	    boxLabel: '<?= _('Non') ?>',
	    <?= genExtWidget('pregnant', 'radio', 2); ?>
	},{ 
	    boxLabel: '<?= _('Inconnu') ?>',
	    <?= genExtWidget('pregnant', 'radio', 4); ?>
	}]    
};


var sexPanelItem = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: .50,
    items: [{
	    xtype: 'label',
	    text: '<?= _('Sexe') ?> :'
	},{ 
	    boxLabel: '<?= _('Masculin') ?>',
	    <?= genExtWidget('sex', 'radio', 2); ?>
	},{ 
	    boxLabel: '<?= _('Féminin') ?>',
	    <?= genExtWidget('sex', 'radio', 1); ?>
	}
	<? if ($_REQUEST['type'] == '32') echo ", isPregnantPanel"; ?>
    ]    
};

var cervicalScreeningPanelItem = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 1,
    items: [{
	    boxLabel: '<?= _('Dépistage CA du Col') ?>',
	    <?= genExtWidget('depistageCol', 'checkbox', 1); ?>
	},{
	    xtype: 'label',
	    margins: '0 3 0 8',
	    text: '<?= _('Date') ?>'
	},{
	    format: 'm/Y',
	    <?= genExtWidget('DateDepistageCol', 'datefield', 0); ?>
	},{
	    xtype: 'label',
	    text: '<?= _('(mm/aa)') ?>'
	}]    
};
buildValidation(72, makeTestAllOrNone(makeTestAnyIsChecked('depistageCol1'),
				      makeTestAnyNotBlank('DateDepistageCol0')));

var prostateScreeningPanelItem = {
    layout: {
	type: 'hbox'
    },
    border:false,
    defaults: {
	margins: '0 2'
    },
    flex: 1,
    items: [{
    	    boxLabel: '<?= _('Dépistage CA de la Prostate (Homme > 40ans)') ?>',
    	    <?= genExtWidget('depistageProstate', 'checkbox', 1); ?>
    	},{
	    xtype: 'label',
	    margins: '0 3 0 8',
	    text: '<?= _('Date') ?>'
	},{
	    format: 'm/Y',
	    <?= genExtWidget('dateDepistageProstate', 'datefield', 0); ?>
	},{
	    xtype: 'label',
	    text: '<?= _('(mm/aa)') ?>'
        }]  
};
buildValidation(72, makeTestAllOrNone(makeTestAnyIsChecked('depistageProstate1'),
				      makeTestAnyNotBlank('dateDepistageProstate0')));

var screeningResultsPanelItem = {
    layout: {
	type: 'hbox'
    },
    border:false,
    defaults: {
	margins: '0 2'
    },
    flex: 1,
    items: [{
            xtype: 'label',
            text: '<?= _('Résultats:')?>'
	},{
            width: '80em',
            <?=genExtWidget('prostateResult', 'textfield', 0);?>
	}]  
};
buildValidation(72, makeTestAllOrNone(makeTestAnyIsChecked('depistageCol1'),
				      makeTestAnyNotBlank('prostateResult0')));
buildValidation(72, makeTestAllOrNone(makeTestAnyIsChecked('depistageProstate1'),
				      makeTestAnyNotBlank('prostateResult0')));


var bloodPanelItem = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 2,
    items: [{
	    xtype: 'label',
	    text: '<?= _('Groupe sanguin') ?> :'
	},{ 
	    flex: 1,
	    boxLabel: 'A+',
	    <?= genExtWidget('blood_group', 'radio', 1); ?>
	},{ 
	    flex: 1,
	    boxLabel: 'A-',
	    <?= genExtWidget('blood_group', 'radio', 2); ?>
	},{ 
	    flex: 1,
	    boxLabel: 'B+',
	    <?= genExtWidget('blood_group', 'radio', 4); ?>
	},{ 
	    flex: 1,
	    boxLabel: 'B-',
	    <?= genExtWidget('blood_group', 'radio', 8); ?>
	},{ 
	    flex: 1,
	    boxLabel: 'O+',
	    <?= genExtWidget('blood_group', 'radio', 16); ?>
	},{ 
	    flex: 1,
	    boxLabel: 'O-',
	    <?= genExtWidget('blood_group', 'radio', 32); ?>
	},{ 
	    flex: 1,
	    boxLabel: 'AB+',
	    <?= genExtWidget('blood_group', 'radio', 64); ?>
	},{ 
	    flex: 1,
	    boxLabel: 'AB-',
	    <?= genExtWidget('blood_group', 'radio', 128); ?>
	},{ 
	    flex: 1,
	    boxLabel: '<?= _('Inconnu') ?>',
	    <?= genExtWidget('blood_group', 'radio', 256); ?>
	}]
};

<?php if ($isObgynEncounter && $isFollowupEncounter) { ?>
    //These elements are used on the obgyn history panel in the intake form. This if is needed to avoid duplicate call to genExtWidget on that form.
var extraObgYnItems1 = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 1,
    items: [{
	    xtype: 'label',
	    text: '<?=_('DDR')?>'
	},{
	    format: 'd/m/Y',
	    width: 100,
	    <?= genExtWidget('pregnantDDRDt', 'datefield', 0); ?>
	},{
	    margins: '0 3 0 30',
	    xtype: 'label',
	    text: 'G'
	},{
	    width: 25,
	    <?= genExtWidget('gravida', 'numberfield',0); ?>
	},{
	    xtype: 'label',
	    text: 'P'
	},{
	    width: 25,
	    <?= genExtWidget('para', 'numberfield',0); ?>
	},{
	    xtype: 'label',
	    text: 'A'
	},{
	    width: 50,
	    <?= genExtWidget('aborta', 'numberfield',0); ?>
	},{
	    xtype: 'label',
	    text: 'EV'
	},{
	    width: 25,
	    <?= genExtWidget('liveChilds', 'numberfield',0); ?>
	},{
	    margins: '0 3 0 30',
	    xtype: 'label',
	    text: '<?=_('DPA')?>'
	},{
	    format: 'd/m/Y',
	    width: 100,
	    <?= genExtWidget('DPADt', 'datefield', 0); ?>
	}]
};

var extraObgYnItems2 = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 1,
    items: [{
	    xtype: 'label',
	    text: '<?=_('Palpation mensuelle des Seins')?>:'
	},{
	    boxLabel: '<?=_('Oui')?>',
	    <?= genExtWidget('palpationMensuelle', 'radio', 1); ?>
	},{ 
	    boxLabel: '<?=_('Non')?>',
	    <?= genExtWidget('palpationMensuelle', 'radio', 2); ?>
	}]
};
<?php } ?>

if (isAdultEncounter) {
    if (isIntakeEncounter) {
	var generalPanelLayout = [
		  [agePanelItem, sexPanelItem],
		  [bloodPanelItem],
		  [hemoglobinElectrophoresisPanelItem],
		  [cervicalScreeningPanelItem, prostateScreeningPanelItem], 
		  [screeningResultsPanelItem]
		 ]; 
    } else {
	var generalPanelLayout = [ 
		  [agePanelItem, sexPanelItem]
	];
    }
}

if (isPediatricEncounter) {
    if (isIntakeEncounter) {
	var generalPanelLayout = [
		[agePanelItem, sexPanelItem, referenceYesNoPanelItem],
		[bloodPanelItem],
		[schooledPanelItem, birthWeightPanelItem],
		[hemoglobinElectrophoresisPanelItem]
	];
    } else {
      var generalPanelLayout = [ 
		[agePanelItem, sexPanelItem], 
		[schooledPanelItem]
	];
    }
}

if (isObgynEncounter) {
    if (isIntakeEncounter) {
    var generalPanelLayout = [
			      [agePanelItem, bloodPanelItem],
			      [consultationTypePanelItem],
			      [referencePanelItem],
				  [etudePanelItem]
			     ];
    } else {
    var generalPanelLayout = [
			      [agePanelItem, consultationTypePanelItem],
			      [extraObgYnItems1, extraObgYnItems2],
				  [etudePanelItem]
			     ];
    }
}

var generalPanel = new Ext.FormPanel({
	title: '<?= _('INFORMATIONS GÉNÉRALES') ?>',
	id: 'generalPanel', 
	autoHeight: true,
	autoScroll: true,
	padding: 5,
	items: generalPanelLayout.map(function(row) {
		return {
		    xtype: 'fieldset',
		    border: false,
		    layout: {
			type: 'hbox',
			pack: 'start',
			align: 'middle'
		    },
		    height: 35,
		    defaults: {
			border: false,
			autoHeight: true
		    },
		    items: row
		}
	})
});
