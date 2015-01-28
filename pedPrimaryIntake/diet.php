var itemsDiet = {
	xtype: 'fieldset', border:false, 
	items: [{
		xtype: 'fieldset',border:false,height: 30,
		layout: 'hbox', 
		items: [{
			xtype: 'label',
			text: '<?=("Allaitement maternel exclusif :")?>'
			},{
				xtype: 'spacer', height: 25, width: 25 
		},{
			boxLabel: '<?=_("Oui")?>',
			<?= genExtWidget("foodExclusive", "radio", 1); ?>
		},{
			xtype: 'spacer', height: 25, width: 25 
		},{
			boxLabel: '<?=_("Non")?>',
			<?= genExtWidget("foodExclusive", "radio", 2); ?>
		},{
			xtype: 'spacer', height: 25, width: 25 
		},{ 
			xtype: 'label',
			text: '<?=_("Si oui, durée en mois :")?>' 
		},{ 
			height: 25, width: 150,
			<?= genExtWidget("maternalSpec", "numberfield", 0); ?> 
		}]
	},{
		xtype: 'fieldset',border:false,height: 30,
		layout: 'hbox',
		items: [{
			xtype: 'label',
			text: '<?=("Préparation pour nourrissons (LM) :")?>'
		},{
			xtype: 'spacer', height: 25, width: 25 
		},{
			boxLabel: '<?=_("Oui")?>',
			<?= genExtWidget("prepPour", "radio", 1); ?>
		},{
			xtype: 'spacer', height: 25, width: 25 
		},{
			boxLabel: '<?=_("Non")?>',
			<?= genExtWidget("prepPour", "radio", 2); ?>
		},{
			xtype: 'spacer', height: 25, width: 25 
		},{
			xtype: 'label',
			text: '<?=_("Si oui, précisez le lait :")?>'
		},{ 
			height: 25, width: 400,
			<?= genExtWidget("milk_specify", "textarea", 0); ?>  
		}]
	},{
		xtype: 'fieldset',border:false,height: 30,
		layout: 'hbox',
		items: [{
			xtype: 'label',
			text: '<?=("Alimentation mixte :")?>'
		},{
			xtype: 'spacer', height: 25, width: 25 
		},{
			boxLabel: '<?=_("Oui")?>',
			<?= genExtWidget("foodMix", "radio", 1); ?>
		},{
			xtype: 'spacer', height: 25, width: 25 
		},{
			boxLabel: '<?=_("Non")?>',
			<?= genExtWidget("foodMix", "radio", 2); ?>
		},{
			xtype: 'spacer', height: 25, width: 25 
		},{
			xtype: 'label',
			text: '<?=("Diversification alimentaire :")?>'
		},{
			xtype: 'spacer', height: 25, width: 25 
		},{
			boxLabel: '<?=_("Oui")?>',
			<?= genExtWidget("foodDiverse", "radio", 1); ?>
		},{
			xtype: 'spacer', height: 25, width: 25 
		},{
			boxLabel: '<?=_("Non")?>',
			<?= genExtWidget("foodDiverse", "radio", 2); ?>
		},{
			xtype: 'spacer', height: 25, width: 25 
		},{
			xtype: 'label', 
			text: '<?=_('Si oui, âge en mois')?> :'
		},{ 
			height: 25, width: 150,
			<?= genExtWidget("ageMonths", "numberfield", 0); ?> 
		}]
	}]
};
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('maternalSpec0'),
				      makeTestAnyIsChecked('foodExclusive1')));
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('milk_specify0'),
				      makeTestAnyIsChecked('prepPour1')));
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('ageMonths0'),
				      makeTestAnyIsChecked('foodDiverse1')));

var dietPanel = new Ext.FormPanel({
    title: '<?=$isIntakeEncounter ? _("HISTOIRE ALIMENTAIRE") : _("ALIMENTAIRE ACTUELLE") ?>',
    id: 'diet',
    autoHeight: true,
    autoScroll: true,
    padding: 5,
    defaults: {
	layout: 'form'
    },
    items: [itemsDiet]
});

