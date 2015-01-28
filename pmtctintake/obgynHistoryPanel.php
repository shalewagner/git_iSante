<?php function renderGrossesseLine($lineNumber) { ?>
    border: false,
    layout: 'hbox',
    border: false, 
    defaults: {margins: '0 0 0 5'}, 
    items: [{
        xtype: 'label',
        style: 'font-weight: bold;',
        text: '<?=_('Grossesse')?> <?=$lineNumber?> '
          },{
        margins: '0 6 0 12',
        xtype: 'label',
        text: '<?=_(' Date ')?>'
          },{ 
        format: 'd/m/Y',
        width: 90,
        <?= genExtWidget("grossesseDt$lineNumber", "datefield", 0); ?> 
         },{
        xtype: 'label',
        style: 'font-style: italic;',
        margins: '0 4 0 5',
        text: '<?=_('Suivi')?> : '
         },{  
        boxLabel: '<?=_('Oui')?>',
        <?=genExtWidget("grossesseSuivi$lineNumber", 'radio', 1); ?>
         },{
        boxLabel: '<?=_('Non')?>',
        <?=genExtWidget("grossesseSuivi$lineNumber", 'radio', 2); ?>
          },{
        xtype: 'label',
        style: 'font-style: italic;',
        margins: '0 4 0 12',
        text: '<?=_('Accouchement')?> :'
          },{
        boxLabel: '<?=_('Domicile')?>',
        <?=genExtWidget("accouchment$lineNumber", 'radio', 1); ?>
          },{
        boxLabel: '<?=_('Institution')?>',
        <?=genExtWidget("accouchment$lineNumber", 'radio', 2); ?>
         },{ 
        xtype: 'label',
        style: 'font-style: italic;',
        margins: '0 4 0 5',
        text: '<?=_('Naissance vivante')?> :' 
	  },{
        boxLabel: '<?=_('Oui')?>',
        <?=genExtWidget("naissanceVivante$lineNumber", 'radio', 1); ?>
          },{
        boxLabel: '<?=_('Non')?>',
        <?=genExtWidget("naissanceVivante$lineNumber", 'radio', 2); ?>
      }] 
<?php } ?>


var obgynHistoryPanel = new Ext.FormPanel({
	title: '<?=_('ANTECEDENTS OBSTETRICO-GYNECOLOGIQUES')?>',
	id: 'obgynHistoryPanel',
	border: false,
	autoHeight: true,
	autoScroll: true,
	padding: 5,
	defaults: {
            style: {
                marginBottom: '0.5ex',
                marginTop: '0.5ex'
            }
	},
	items: [{
		layout: 'hbox',
		border: false,
		defaults: {margins: '0 5'},
		items: [{     
			xtype: 'label',
			style: 'font-weight: bold',
			text: '<?=_('Age des Ménarches')?>'
		    },{  
			width: '4em',
			allowNegative: false,
			decimalSeparator: '.',
			<?= genExtWidget('mensAge', 'numberfield', 0); ?> 
		    },{
			xtype: 'spacer', width: '3em'
		    },{
			xtype: 'label',
			style: 'font-weight: bold',
			text: '<?=_('Age des premières relations sexuelles')?>'
		    },{  
			width: '4em',
			allowNegative: false,
			decimalSeparator: '.',
			<?= genExtWidget('beginSex', 'numberfield', 0); ?> 
		    },{
			xtype: 'spacer', width: '3em'
		    },{
			xtype: 'label',
			style: 'font-weight: bold',
			text: '<?=_('Nombre cumulé de partenaires sexuels')?>'
		    },{
			width: '3em',
			<?= genExtWidget('numberCumPartnerSex', 'numberfield', 0); ?>
		    }]
	    },{
		layout: 'hbox',
		border: false,
		defaults: {margins: '0 5'},
		items: [{
			xtype: 'label',
			style: 'font-weight: bold',
			text: '<?=_('Durée des Règles')?>'
		    },{ 
			width: 25,
			<?= genExtWidget("mensDuration", "numberfield",0); ?> 
		    },{
			xtype: 'label',
			text: '<?=_('jours')?>'
		    },{
			xtype: 'spacer', width: '6em'
		    },{
			xtype: 'label',
			text: '<?=_('Durée des Cycle')?>'
		    },{
			width: 25,
			<?= genExtWidget("mensCycle", "numberfield",0); ?> 
		    },{
			xtype: 'label',
			text: '<?=_('jours')?>'
		    },{
			xtype: 'spacer', width: '6em'
		    },{
			xtype: 'label',
			text: '<?=_('DDR')?>'
		    },{ 
			format: 'd/m/Y',
			width: 100,
			<?= genExtWidget("pregnantDDRDt", "datefield", 0); ?> 
		    },{
			xtype: 'label',
			text: '<?=_('DPA')?>'
		    },{ 
			format: 'd/m/Y',
			width: 100,
			<?= genExtWidget("DPADt", "datefield",0); ?> 
		    }]
	    },{
		layout: 'hbox',
		border: false,
		defaults: {margins: '0 5'},
		items: [{
			xtype: 'label',
			style: 'font-weight: bold', 
			text: '<?=_('Dysménorrhée')?> :'
		    },{  
			boxLabel: '<?=_('Oui')?>',
			<?= genExtWidget("dysmenhoree", "radio", 1); ?> 
		    },{  
			boxLabel: '<?=_('Non')?>',
			<?= genExtWidget("dysmenhoree", "radio", 2); ?> 
		    },{  
			xtype: 'spacer', width: '1em'
		    },{
			xtype: 'label',
			text: '<?=_('Si oui')?>,'
		    },{  
			boxLabel: '<?=_('Primaire')?>',
			<?= genExtWidget("yesDysmenhoree", "radio", 1); ?> 
		    },{  
			xtype: 'label',
			text: '<?=_('ou')?>'
		    },{  
			boxLabel: '<?=_('Secondaire')?>',
			<?= genExtWidget("yesDysmenhoree", "radio", 2); ?> 
		    },{  
			xtype: 'spacer', width: '1em'
		    },{
      xtype: 'label',
			style: 'font-weight: bold', 
			text: '<?=_('Infertilité')?> :'
        },{  
			boxLabel: '<?=_('Oui')?>',
			<?= genExtWidget("infertilite", "radio", 1); ?> 
		    },{  
			boxLabel: '<?=_('Non')?>',
			<?= genExtWidget("infertilite", "radio", 2); ?> 
		    }]
	    },{
		layout: 'hbox',
		border: false,
		defaults: {margins: '0 5'},
		items: [{
			xtype: 'label',
			text: 'G'
		    },{ 
			width: 25,
			<?= genExtWidget("gravida", "numberfield",0); ?> 
		    },{
			xtype: 'label',
			text: 'P'
		    },{
			width: 25,
			<?= genExtWidget("para", "numberfield",0); ?> 
		    },{
			xtype: 'label',
			text: 'A'
		    },{ 
			width: 50,
			<?= genExtWidget("aborta", "numberfield",0); ?> 
		    },{
			xtype: 'label',
			text: 'EV'
		    },{ 
			width: 25,
			<?= genExtWidget("liveChilds", "numberfield",0); ?> 
		    },{
			boxLabel: '<?=_('Grossesse multiple')?>',
			<?= genExtWidget("grossesseGemellaire", "radio",1); ?>
		    },{
			boxLabel: '<?=_('Pré éclampsie sévère')?>',
			<?= genExtWidget("grossesseGemellaire", "radio",2); ?>
		    },{
			boxLabel: '<?=_('Hémorragie de la grossesse/post-partum')?>',
			<?= genExtWidget("grossesseGemellaire", "radio",4); ?>
		    }]
	    },{
		<?php renderGrossesseLine(1); ?>
	    },{
		<?php renderGrossesseLine(2); ?>
	    },{
		<?php renderGrossesseLine(3); ?>
	    },{
    // Added back in 13.1. Not handled per pregnancy
		layout: 'hbox',
		border: false,
		defaults: {margins: '0 5'},
		items: [{
			xtype: 'label',
			style: 'font-weight: bold',
			text: '<?=_('ATCD de Césarienne')?> :' 
		    },{
			boxLabel: '<?=_('Oui')?>',
			<?=genExtWidget("atcd", "radio", 1); ?>
		    },{
			boxLabel: '<?=_('Non')?>',
			<?=genExtWidget("atcd", "radio", 2); ?>
		    }]
	    },{
		layout: 'hbox',
		border: false,
		defaults: {margins: '0 5'},
		items: [{
			xtype: 'label',
			text: '<?=_('Si oui, Indication1')?>' 
		    },{
			width: '20ex',
			<?=genExtWidget('indication1', 'textfield', 0); ?>
		    },{ 
			xtype: 'label',
			text: '<?=_('Date1')?>' 
		    },{
			format: 'd/m/Y',
			width: 100,
			<?= genExtWidget('date1', 'datefield',0); ?> 
		    },{
			xtype: 'spacer', height: 25, width: 14
		    },{
			xtype: 'label',
			text: '<?=_('Indication2')?>' 
		    },{
			width: '20ex',
			<?=genExtWidget('indication2', 'textfield', 0); ?>
		    },{ 
			xtype: 'label',
			text: '<?=_('Date2')?>' 
		    },{
			format: 'd/m/Y',
			width: 100,
			<?=genExtWidget('date2', 'datefield', 0); ?>
		    }]
	    },{
	 //       */
    layout: 'hbox',
		border: false,
		defaults: {margins: '0 5'},
		items: [{
			xtype: 'label',
			style: 'font-weight: bold',
			text: '<?=_('Date du dernier dépistage du cancer du Col')?> :'
		    },{ 
			format: 'd/m/Y',
			width: 100,
			<?= genExtWidget("cancerColon", "datefield",0); ?> 
		    }]
	    },{
		layout: 'hbox',
		border: false,
		defaults: {margins: '0 5'},
		items: [{
			xtype: 'label',
			text: '<?=_('Méthode utilisée')?> :'
		    },{
			<?= genExtWidget("methodUti", "textfield",0); ?>
		    },{
			xtype: 'label',
			text: '<?=_('Résultat')?> :'
		    },{
			boxLabel: '<?=_('Normal')?>',
			<?= genExtWidget("cancerColonStatus", "radio",1); ?>
		    },{
			boxLabel: '<?=_('Anormale')?>',
			<?= genExtWidget("cancerColonStatus", "radio",2); ?>
		    },{
			boxLabel: '<?=_('Jamais réalisé')?>',
			<?= genExtWidget("cancerColonStatus", "radio",4); ?>
		    }]
	    },{
		layout: 'hbox',
		border: false,
		defaults: {margins: '0 5'},
		items: [{     
			xtype: 'label', style: 'font-weight: bold',
			text: '<?=_('Palpation mensuelle des Seins')?> :'
		    },{
			boxLabel: '<?=_('Oui')?>',
			<?= genExtWidget("palpationMensuelle", "radio", 1); ?> 
		    },{ 
			boxLabel: '<?=_('Non')?>',
			<?= genExtWidget("palpationMensuelle", "radio", 2); ?>   
		    }]
	    },{
		layout: 'hbox',
		border: false,
		defaults: {margins: '0 5'},
		items: [{     
			xtype: 'label', style: 'font-weight: bold',
			text: '<?=_('Mammographie (âge > 35ans)')?> :'
		    },{
			boxLabel: '<?=_('Oui')?>',
			<?= genExtWidget("mammograph", "radio", 1); ?> 
		    },{ 
			boxLabel: '<?=_('Non')?>',
			<?= genExtWidget("mammograph", "radio", 2); ?>   
		    },{     
			xtype: 'label',
			text: '<?=_('Si oui')?>,'
		    },{ 
			boxLabel: '<?=_('Normale')?>',
			<?= genExtWidget("mammographNormal", "radio", 1); ?> 
		    },{ 
			boxLabel: '<?=_('Anormale')?>',
			<?= genExtWidget("mammographNormal", "radio", 2); ?> 
		    }]
	    },{ 
		layout: 'hbox',
		border: false,
		defaults: {margins: '0 5'},
		items: [{     
			xtype: 'label', style: 'font-weight: bold',
			text: '<?=_('Planification familiale')?> :'
		    },{
			boxLabel: '<?=_('Oui')?>',
			<?= genExtWidget("famPlan", "radio", 1); ?> 
		    },{ 
			boxLabel: '<?=_('Non')?>',
			<?= genExtWidget("famPlan", "radio", 2); ?>   
		    },{     
			xtype: 'label',
			text: '<?=_('Si oui, méthode')?> :'
		    },{
			width: 300,
			<?= genExtWidget("famPlanMethod", "textfield", 1); ?> 
		    }]
	    },{
		layout: 'hbox',
		border: false,
		defaults: {margins: '0 5'},
		items: [{     
			xtype: 'label', style: 'font-weight: bold',
			text: '<?=_('Ménopause')?> :'
		    },{
			boxLabel: '<?=_('Oui')?>',
			<?= genExtWidget("menopause", "radio", 1); ?> 
		    },{ 
			boxLabel: '<?=_('Non')?>',
			<?= genExtWidget("menopause", "radio", 2); ?>   
		    },{     
			xtype: 'label',
			text: '<?=_('Si oui, âge')?> :'
		    },{
			width: '3em',
			<?= genExtWidget("menopauseAge", "numberfield", 1); ?> 
		    }]
	    }]
    });

buildValidation(72, makeTestAllOrNone(makeTestAnyIsChecked('dysmenhoree1'),
				      makeTestAnyIsChecked('yesDysmenhoree1', 'yesDysmenhoree2')));
/* removed--now handled below the preg array
buildValidation(72, makeTestAllOrNone(makeTestAnyIsChecked('grossesseCesarienne11'),
				      makeTestAnyNotBlank('grossesseIndication10')));
buildValidation(72, makeTestAllOrNone(makeTestAnyIsChecked('grossesseCesarienne21'),
				      makeTestAnyNotBlank('grossesseIndication20')));
buildValidation(72, makeTestAllOrNone(makeTestAnyIsChecked('grossesseCesarienne31'),
				      makeTestAnyNotBlank('grossesseIndication30')));
*/
// Not Removed. Now handled per pregnancy
buildValidation(72, makeTestAllOrNone(makeTestAnyIsChecked('atcd1'),
				      makeTestAnyNotBlank('indication10', 'date10')));
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('indication10'),
				      makeTestAnyNotBlank('date10')));
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('indication20'),
				      makeTestAnyNotBlank('date20')));
//

buildValidation(72, makeTestAllOrNone(makeTestAnyIsChecked('mammograph1'),
				      makeTestAnyIsChecked('mammographNormal1', 'mammographNormal2')));

buildValidation(72, makeTestAllOrNone(makeTestAnyIsChecked('famPlan1'),
				      makeTestAnyNotBlank('famPlanMethod1')));

buildValidation(72, makeTestAllOrNone(makeTestAnyIsChecked('menopause1'),
				      makeTestAnyNotBlank('menopauseAge1')));

