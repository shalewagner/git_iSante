
var heightPanel = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 1,
    items: [{
	    xtype: 'label',
	    text: '<?=_('Taille')?>'
	},{
	    width: '2em',
	    allowNegative: false,
	    <?= genExtWidget('vitalHeight', 'numberfield', 0); ?>
	},{ 
	    xtype: 'label',
	    text: '<?=_('mètres')?>'
	},{
	    width: '3em',
	    allowNegative: false,
	    <?= genExtWidget('vitalHeightCm', 'numberfield', 0); ?>
	},{
	    xtype: 'label',
	    text: '<?=_('cm')?>'
	}]
};
buildValidation(88, makeTestInNumericRange('vitalHeight0', 0, 2));
buildValidation(89, makeTestInNumericRange('vitalHeightCm0', 0, 99));
buildValidation(72, makeTestIfThen(makeTestAnyNotBlank('vitalHeight0'),
				   makeTestAnyNotBlank('vitalHeightCm0')));

var weightPanel = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 0.8,
    items: [{
	    xtype: 'label',
	    text: '<?=_('Pds')?>'
	},{ 
	    width: '4em',
	    allowNegative: false,
	    decimalSeparator: '.',
	    <?= genExtWidget('vitalWeight', 'numberfield', 0); ?>
	},{ 
	    boxLabel: '<?=_('kg')?>',
	    <?= genExtWidget('vitalWeightUnits', 'radio', 1); ?> 
	},{
	    boxLabel: '<?=_('lb')?>',
	    <?= genExtWidget('vitalWeightUnits', 'radio', 2); ?> 
	}]
};
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('vitalWeight0'),
				      makeTestAnyIsChecked('vitalWeightUnits1', 'vitalWeightUnits2')));
buildValidation(25, makeTestInNumericRange('vitalWeight0', 0, 500));

var imcPanel = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 0.8,
    items: [{
	    xtype: 'label',
	    text: '<?=_('IMC')?>'
	},{ 
	    width: '5em',
	    allowNegative: false,
	    decimalSeparator: '.',
	    <?= genExtWidget('vitalIMC', 'numberfield', 0); ?>
	},{
	    xtype: 'label',
	    text: '<?=_('Pds kg/T² m')?>'
	}]
};

var pcPanelItem = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 1,
    items: [{
	    xtype: 'label',
	    text: '<?=_('PC')?>'
	},{ 
	    width: '5em',
	    decimalSeparator: '.',
	    <?= genExtWidget('vitalPc', 'numberfield', 0); ?>
	},{
	    xtype: 'label',
	    text: '<?=_('cm (âge < 3 ans)')?>'
	}]
};

var pbPanelItem = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 0.75,
    items: [{
	    xtype: 'label',
	    text: '<?=_('PB')?>'
	},{ 
	    width: '5em',
	    decimalSeparator: '.',
	    <?= genExtWidget('vitalPb', 'numberfield', 0); ?>
	},{
	    xtype: 'label',
	    text: '<?=_('cm')?>'
	}]
};

var pbPcPanelItem = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 1.2,
    items: [{
	    xtype: 'label',
	    text: '<?=_('PB/PC')?>'
	},{ 
	    width: '5em',
	    decimalSeparator: '.',
	    <?= genExtWidget('vitalPbPc', 'numberfield', 0); ?>
	},{
	    xtype: 'label',
	    text: '<?=_('(âge 1 mois- 5 ans)')?>'
	}]
};

var tempPanel = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 0.8,
    items: [{
	    xtype: 'label',
	    text: '<?=_('Temp')?>'
	},{ 
	    width: '5em',
	    allowDecimals: true,
	    decimalSeparator: '.',
	    <?= genExtWidget('vitalTemp', 'numberfield', 0); ?>
	},{
	    boxLabel: '<?=_('°C')?>',
	    <?= genExtWidget('vitalTempUnits', 'radio', 1); ?>
	},{ 
	    boxLabel: '<?=_('°F')?>',
	    <?= genExtWidget('vitalTempUnits', 'radio', 2); ?>
	}]
};
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('vitalTemp0'),
				      makeTestAnyIsChecked('vitalTempUnits1', 'vitalTempUnits2')));
buildValidation(83, makeTestIfThen(makeTestAnyIsChecked('vitalTempUnits1'),
				   makeTestInNumericRange('vitalTemp0', 32, 43)));
buildValidation(29, makeTestIfThen(makeTestAnyIsChecked('vitalTempUnits2'),
				   makeTestInNumericRange('vitalTemp0', 89.6, 109.4)));

var bpPanel = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 2,
    items: [{
	    xtype: 'label',
	    text: '<?=_('TA')?>'
	},{ 
	    width: '3em',
	    allowNegative: false,
	    decimalSeparator: '.',
	    <?= genExtWidget('vitalBp1','numberfield', 0); ?>
	},{   
	    xtype: 'label',
	    text: '/'
	},{ 
	    width: '3em',
	    allowNegative: false,
	    decimalSeparator: '.',
	    <?= genExtWidget('vitalBp2','numberfield', 0); ?>
	},{ 
	    boxLabel: '<?=_('cm')?>',
	    <?= genExtWidget('vitalBPUnits','radio',1); ?> 
	},{
	    boxLabel: '<?=_('mm de Hg')?>',
	    <?= genExtWidget('vitalBPUnits','radio',2); ?>
	}]
};
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('vitalBp10'),
				      makeTestAnyIsChecked('vitalBPUnits1', 'vitalBPUnits2')));
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('vitalBp20'),
				      makeTestAnyIsChecked('vitalBPUnits1', 'vitalBPUnits2')));
buildValidation(22, makeTestInNumericRange('vitalBp10', 0, 300));
buildValidation(23, makeTestInNumericRange('vitalBp20', 0, 200));

var poulsPanel = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 0.5,
    items: [{
	    xtype: 'label',
	    text: '<?=_('Pouls')?>'
	},{ 
	    width: '5em',
	    allowNegative: false,
	    decimalSeparator: '.',
	    <?= genExtWidget('vitalHr', 'numberfield', 0); ?>
	}]
};

var frPanel = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 0.3,
    items: [{
	    xtype: 'label',
	    text: '<?=_('FR')?>'
	},{
	    width: '4em',
	    allowNegative: false,
	    decimalSeparator: '.',
	    <?= genExtWidget('vitalRr', 'numberfield', 0); ?>
	}]
}; 

var nurseNamePanel = {
    layout: {
	type: 'hbox'
    },
    defaults: {
	margins: '0 3'
    },
    flex: 0.3,
    items: [{
	    xtype: 'label',
	    text: '<?=_('Nom et Prénom du Prestataire')?> :'
	},{
	    width: '16em',
	    <?= genExtWidget('formAuthor', 'textfield', 0); ?>
	}]
};

var vitalsPanelLayout = [
	[weightPanel, heightPanel, bpPanel],
	<? if ($isPediatricEncounter) echo "[pcPanelItem, pbPanelItem, pbPcPanelItem],"; ?>
	[tempPanel, poulsPanel, frPanel, imcPanel <? if ($isObgynEncounter) echo ", pbPanelItem"; ?>],
	[nurseNamePanel]
];  

var vitalsPanel = new Ext.FormPanel({
	title: '<?=_('SIGNES VITAUX/ANTHROPOMETRIE')?>',
	id: 'vitalsPanel', 
	autoHeight: true,
	autoScroll: true,
	padding: 5,
	items: vitalsPanelLayout.map(function(row) {
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


