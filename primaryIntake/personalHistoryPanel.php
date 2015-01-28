<?php  

function dxIndentItemH($item) {
  return "{xtype: 'fieldset', border: false, layout: 'column', collapsible: false, autoHeight:true, items: [{xtype: 'spacer', html: '&nbsp;&nbsp;'},{" . substr($item, 1) . "]}";
}

function personalHistoryMakeEmpty() {
  return "{border: false, html: '&nbsp;', ctCls: 'personalHistoryPanel'}";
}

function personalHistoryMakeCheckOnly($concept, $label) {
  global $tabIndex;
  $checkWidget = genExtWidget($concept, 'checkbox', 1);
  $output = "{ 
  boxLabel: '$label',
  tabIndex: $tabIndex,
  ctCls: 'personalHistoryPanel',
  $checkWidget
}";
  $tabIndex = $tabIndex + 1;
  return $output;
}

function personalHistoryMakeLabelAndText($concept, $label) {
  global $tabIndex;
  $textWidget = genExtWidget($concept . '_specify', 'textfield', 0);
  $output = "{
  xtype: 'label',text: '$label'},{ 
  boxLabel: '$label',
  tabIndex: $tabIndex,
  ctCls: 'personalHistoryPanel',
  $textWidget
}";
  $tabIndex = $tabIndex + 1;
  return $output;
} 

function personalHistoryMakeTextOnly($concept) {
  global $tabIndex;
  $textWidget = genExtWidget($concept . '_specify', 'textfield', 0);
  $output = "
{tabIndex: $tabIndex,
 ctCls: 'personalHistoryPanel',
 $textWidget
}
";
  $tabIndex = $tabIndex + 1;
  return $output;
}

function personalHistoryMakeCheckAndText($concept, $label) {
  //write javascript to validate the text is filled out when the check box is selected
  $checkWidgetId = $concept . '1';
  $textWidgetId = $concept . '_specify' . '0';
  print "
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('$textWidgetId'),
                                      makeTestAnyIsChecked('$checkWidgetId')));
";

  return personalHistoryMakeCheckOnly($concept, $label)
    . ',' . personalHistoryMakeTextOnly($concept);
}

$tableColumns = 3;

$personalHistoryPanelData = array();

if ($isAdultEncounter) {
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_cva', _('Accident cérébro-vasculaire'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('sym_allergy', _('Allergies, précisez:'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_asthma', _('Asthme'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('sym_cancer', _('Cancer, précisez:'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_cardiopathy', _('Cardiopathie'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('chirurgie', _('Chirurgie/Trauma, précisez:'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_diabetes', _('Diabète'));
  $personalHistoryPanelData[] = personalHistoryMakeEmpty();
//  $personalHistoryPanelData[] = personalHistoryMakeEmpty(); 
#second column starts around here

  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_epilepse', _('Epilepsie'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_pregnancy', _('Grossesse'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('hemoglobinopathie', _('Hémoglobinopathie, précisez:'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_hta', _('HTA'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('hypercholesterolemia', _('Hypercholestérolémie'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('sym_ist', _('IST, précisez:'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_malariaLT', _('Malaria < 1 mois'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_malariaGT', _('Malaria ≥ 1 mois')); 
  $personalHistoryPanelData[] = personalHistoryMakeEmpty();
  
/*  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_malariaLT', _('Malaria < 1 mois'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_malaria', _('Malaria 1 mois à un an'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_malariaGT', _('Malaria > un ans'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_malariaUnk', _('Malaria inconnu'));
*/

#third column starts around here

  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('malnutrition', _('Malnutrition/Perte de poids'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_tuberculosis', _('Tuberculose'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_mdrtb', _('MDR TB'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('psychiatricDisorders', _('Troubles psychiatriques, précisez:'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_alcohol', _('Alcool'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('drugs', _('Drogue, précisez:'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_tabacco', _('Tabac'));
  $personalHistoryPanelData[] = '{xtype: \'label\', border: false, text: \'' . _('Autres') . ':\'}';
  $personalHistoryPanelData[] = personalHistoryMakeTextOnly('personalHistoryOther1');
}

if ($isPediatricEncounter) {
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('sym_allergy', _('Allergies, précisez:'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_asthma', _('Asthme'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_cardiopathy', _('Cardiopathie'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('chirurgie', _('Chirurgie/Trauma, précisez:'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_diabetes', _('Diabète'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('diphterie', _('Diphtérie'));
  $personalHistoryPanelData[] = personalHistoryMakeEmpty();
  $personalHistoryPanelData[] = personalHistoryMakeEmpty();
  $personalHistoryPanelData[] = personalHistoryMakeEmpty();
  
#second column starts here

  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_epilepse', _('Epilepsie'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('hemoglobinopathie', _('Hémoglobinopathie, précisez:'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_hta', _('HTA'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('sym_ist', _('IST, précisez:'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_malariaLT', _('Malaria < 1 mois'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_malariaGT', _('Malaria ≥ 1 mois'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('malf_cong', _('Malf. Congénitales, précisez:'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('malnutrition', _('Malnutrition/Perte de poids'));

#third column starts around here

  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('premat', _('Prématurité'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('phRaa', _('RAA'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('phRougeole', _('Rougeole'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_tuberculosis', _('Tuberculose'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_mdrtb', _('MDR TB'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('phVaricelle', _('Varicelle'));
  //$personalHistoryPanelData[] = personalHistoryMakeCheckAndText('drugs', _('Alcool/Drogue, précisez:'));
  $personalHistoryPanelData[] = '{xtype: \'label\', border: false, text: \'' . _('Autres précisez') . ':\'}';
  $personalHistoryPanelData[] = personalHistoryMakeTextOnly('personalHistoryOther1');
  $personalHistoryPanelData[] = personalHistoryMakeTextOnly('personalHistoryOther2');
  $personalHistoryPanelData[] = personalHistoryMakeEmpty();
}

if ($isObgynEncounter) {
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_cva', _('Accident cérébro-vasculaire'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('sym_allergy', _('Allergies, précisez:'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_asthma', _('Asthme'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('sym_cancer', _('Cancer, précisez:'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_cardiopathy', _('Cardiopathie'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('chirurgie', _('Chirurgie/Trauma, précisez:'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_diabetes', _('Diabète'));  
  $personalHistoryPanelData[] = personalHistoryMakeEmpty();

#second column starts around here

  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_epilepse', _('Epilepsie'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('hemoglobinopathie', _('Hémoglobinopathie, précisez:'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_hta', _('HTA'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_hyperchoesterolemie', _('Hyperchoestérolémie'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('sym_ist', _('IST, précisez:'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_malariaLT', _('Malaria < 1 mois'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_malariaGT', _('Malaria ≥ 1 mois'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('personalHistoryOther1', 'Autres, précisez : ');
  
#third column starts around here

  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('malnutrition', _('Malnutrition/Perte de poids'));  
  //$personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_nephropathie', _('Néphropathie'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_tuberculosis', _('Tuberculose'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_mdrtb', _('MDR TB'));  
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('psychiatricDisorders', _('Troubles psychiatriques, précisez:'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_alcohol', _('Alcool'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('drugs', _('Drogue, précisez:'));
  $personalHistoryPanelData[] = personalHistoryMakeCheckOnly('sym_tabacco', _('Tabac'));
  //$personalHistoryPanelData[] = '{xtype: \'label\', border: false, text: \'' . _('Autres') . ':\'}';
  $personalHistoryPanelData[] = personalHistoryMakeCheckAndText('personalHistoryOther2', 'Autres, précisez : ');
  //$personalHistoryPanelData[] = personalHistoryMakeEmpty();
}

?>

var personalHistorySeeingDr = {
    layout: 'hbox',
    defaults: { margins: '0 3'},
    items: [{
            xtype: 'label',
            text: '<?=_('Présentement suivi par un médecin ?')?>'
        },{
            boxLabel: '<?=_('Oui')?>',
	    tabIndex: 2100,
            <?= genExtWidget('tbSeeingDr', 'radio', 1); ?>
        },{
            boxLabel: '<?=_('Non')?>',
            <?= genExtWidget('tbSeeingDr', 'radio', 2); ?>
        },{
            xtype: 'label',
            text: '<?=_('Si oui, nom détablissement :')?>'
        },{
            width: '20em',
	    tabIndex: 2100,
            <?= genExtWidget('tbSeeingDr_specify', 'textfield', 0); ?>
        }]
};

var medsActual = {
	fieldLabel: '<?= _('Médicaments actuels') ?>',
	tabIndex: 2110,
	<?= genExtWidget('sym_actualMeds', 'textfield', 0); ?>,
	width: '80ex'
};

var remark = {
	fieldLabel: '<?= _('Remarque') ?>',
	tabIndex: 2111,
	<?= genExtWidget('symRemarks', 'textfield', 0); ?>,
	width: '80ex'
};

var personalHistoryPreviousHospitalization = {
    layout: {
        type: 'hbox'
    },
    defaults: {
        margins: '0 3'
    },
    items: [{
            xtype: 'label',
            text: '<?=_('Hospitalisation Antérieure :')?>'
        },{
            boxLabel: '<?=_('Oui')?>',
            <?= genExtWidget('hosp', 'radio', 1); ?>
        },{
            boxLabel: '<?=_('Non')?>',
            <?= genExtWidget('hosp', 'radio', 2); ?>
        },{
            boxLabel: '<?=_('Inconnu')?>',
            <?= genExtWidget('hosp', 'radio', 4); ?>
        },{
            xtype: 'label',
            text: '<?=_('Si oui, cause :')?>'
        },{
            width: '20em',
            <?= genExtWidget('hospSpe', 'textfield', 0); ?>
        }]
};
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('hospSpe0'),
                                      makeTestAnyIsChecked('hosp1')));

var personalHistoryPanel = new Ext.FormPanel({
	title: '<?= _('ANTECEDENTS PERSONNELS/HABITUDES') ?>',
	id: 'personalHistoryPanel',
	autoHeight: true,
	autoScroll: true,
	padding: 5,
	defaults: {
	    border: false,
            autoHeight: true
	},
	items: [{
		layout: {
		    type: 'hbox'
		},
		defaults: {
		    margins: '0 25'
		},
		items: [{
			boxLabel: '<?=_('Aucune')?>',
			<?= genExtWidget('aucunePersonalHistory', 'radio', 1) ?>
		},{
			boxLabel: '<?=_('Inconnu')?>',
			<?= genExtWidget('aucunePersonalHistory', 'radio', 2) ?>
		}]
	},{
		xtype: 'fieldset',
		border: false,
		layout: {type: 'table', columns: <?=$tableColumns?>},
		items: transposeExtTableItems([<?= implode(",\n", $personalHistoryPanelData) ?>],<?= $tableColumns ?>,{xtype: 'label', text: ''})
	},{
		xtype: 'spacer', width: '80em', height: '3em'
	}
	<? if ($type == 32) echo ", personalHistorySeeingDr"; ?>
	<?
  if ($isObgynEncounter && $isIntakeEncounter) echo "
	,testVIH
	,cd4Result
	,arv
	,arvDate
	,prophylaxie"; 
	?>
	,medsActual
	<? if (! $isPediatricEncounter) echo ",remark"; ?>
	<?= $isPediatricEncounter ? ',personalHistoryPreviousHospitalization' : '' ?>
	]
});
