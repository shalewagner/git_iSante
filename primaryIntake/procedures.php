var itemLabs;
var itemFamilyPlanning;        // obgyn stuff
var itemEvaluationAndPlanning; // obgyn stuff
var itemNutritionalSupport; // pediatric stuff
var itemVaccination;
var itemPrescribedMedications;
var itemReference;

<?php

function labsMakeEmpty() {
    return "{border: false, html: '&nbsp;'}";
}

function labsMakeCheckOnly($concept, $label) {
    global $tabIndex;
    $checkWidget = genExtWidget($concept, 'checkbox', 1);
    $output = "{
 xtype: 'fieldset', layout:'column',
 border: false,
 ctCls: 'proceduresPanel',
 items: [{ 
   boxLabel: '$label',
   tabIndex: $tabIndex,
   $checkWidget
 }]
}";
    $tabIndex += 1;
    return $output;
}

function labsMakeTextOnly($concept) {
    global $tabIndex;
    $textWidget = genExtWidget($concept . '_specify', 'textfield', 0);
    $output = "{
  tabIndex: $tabIndex,
  ctCls: 'proceduresPanel',
  $textWidget
} ";
    $tabIndex += 1;
    return $output;
}

function labsMakeCheckAndText($concept, $label) {
    //write javascript to validate the text is filled out when the check box is selected
    $checkWidgetId = $concept . '1';
    $textWidgetId = $concept . '_specify' . '0';
    print "
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('$textWidgetId'),
                                      makeTestAnyIsChecked('$checkWidgetId')));
";

    return labsMakeCheckOnly($concept, $label)
      . ',' . labsMakeTextOnly($concept);
} 

function labsMakeRadioSet($concept, $label, $radioLabels) {
	global $tabIndex;
	$output = "{
		xtype: 'fieldset',
		layout: 'column',
		collapsible: false,
		autoHeight: true,
		border: false,
		items: [{
			xtype: 'label', text: '" . $label . "'
		},";
		for ($i = 0; $i < count($radioLabels); $i++) {
			if ($i > 0) $output .= ',';
			$radioWidget = genExtWidget($concept, 'radio', $i + 1);
			$output .= "{
			      tabIndex: $tabIndex,
			      boxLabel: '$radioLabels[$i]',
			      $radioWidget
			}"; 
			$tabIndex += 1;
		}
                $output .= "
		]		
	}";
	return $output;
}

$labsAllCheckOnlyItems = array(
    'hemocultureTest' => _('Hémogramme'),
    'widalTest' => _('Widal'),
    'fastingGlucoseTest' => _('Glycémie'),
    'urineTest' => _('Urines'),
    'stoolTest' => _('Selles'),
    'pregnancyTest' => _('Test de grossesse'),
    'crpTest' => _('C Réactive Protéine'),
    'spitTest' => _('Crachats en série'),
    'bloodtypeTest' => _('Groupe sanguin'),
    'frottisvaginalTest' => _('Frottis vaginal / gouttes pendantes'), 
    'papTestTest' => _('PAP test'),
    'psaTest' => _('PSA'),
    'rprTest' => _('Sérologie syphilis'),
    'hivTest' => _('VIH'),
    'ppdMantouxTest' => _('PPD'),
    'fshlhTest' => _('FSH / LH'),
    'cd4TestOrder' => _('CD4'),
    'sicklingTest' => _('Sickling test'),
    'hemoglobinelectrophoresisTest' => _('Electrophorèse de l’hémoglobine'),
    'seroHeliTest' => _('Sérologie à Hélicobacter Pylori'),
    'prolactineTest' => _('Prolactine'),
    'serologiehivTest' => _('Sérologie VIH'),
    'ivaTest' => _('VIA'),
    'asatalatTest' => _('ASAT / ALAT'),
    'ureaTest' => _('Urée / créatinine'),
    'estrogenprogestoroneTest' => _('Œstrogène / Progestérone'),
    'sedimentationrateTest' => _('Vitesse de sédimentation (ESR)'),
    'asoTest' => _('ASO'),
    //'malariaEither' => _('Malaria') . ' : ',
    'malariaTestRapid' => _('Malaria : TDR'),
    'malariaTest' => _('Malaria : microscopie')
);

$labsAllCheckAndTextItems = array(
    'radiographTest' => _('Radiographie, précisez:'),
    'ultrasoundTest' => _('Echographie, précisez:')
); 

$labsAllRadioSetItems = array(
	'malariaResultRapid' => array(
		'label' => _('Résultat :'),
		'radios' => array (_('nég'),_('pos'),_('inconnu'))
		)
);  

$labsPrimary = array(
'bloodtypeTest', 'hemocultureTest', 'fastingGlucoseTest', 'asatalatTest', 'ureaTest', 'crpTest', 'hemoglobinelectrophoresisTest', 'labEmpty', 'labEmpty', 'labEmpty',
'cd4TestOrder', 'sicklingTest', 'seroHeliTest', 'malariaTestRapid', 'malariaTest', 'malariaResultRapid', 'psaTest', 'rprTest', 'serologiehivTest', 'labEmpty',
'widalTest', 'spitTest', 'urineTest', 'stoolTest', 'pregnancyTest',  'frottisvaginalTest', 'ivaTest', 'labEmpty', 'labEmpty', 'labEmpty',
'papTestTest', 'ppdMantouxTest', 'radiographTest', 'ultrasoundTest'
);

$labsOBGYN = array(
'bloodtypeTest', 'hemocultureTest',  'fastingGlucoseTest', 'asatalatTest', 'ureaTest', 'prolactineTest', 'fshlhTest', 'estrogenprogestoroneTest', 'labEmpty',
'crpTest', 'cd4TestOrder', 'hemoglobinelectrophoresisTest', 'sicklingTest', 'malariaTestRapid', 'malariaTest', 'malariaResultRapid', 'rprTest', 'labEmpty',
'serologiehivTest', 'urineTest', 'stoolTest', 'pregnancyTest', 'frottisvaginalTest', 'ivaTest', 'papTestTest', 'labEmpty', 'labEmpty',
'ppdMantouxTest', 'radiographTest', 'ultrasoundTest'
);

$labsPediatric = array(
'bloodtypeTest', 'hemocultureTest', 'fastingGlucoseTest', 'ureaTest', 'crpTest', 'cd4TestOrder', 'hemoglobinelectrophoresisTest', 'labEmpty', 'labEmpty',
'sicklingTest', 'seroHeliTest' , 'malariaTestRapid', 'malariaTest', 'malariaResultRapid', 'rprTest', 'serologiehivTest', 'widalTest', 'spitTest',
'urineTest', 'stoolTest', 'pregnancyTest',  'frottisvaginalTest', 'ppdMantouxTest', 'labEmpty', 'labEmpty', 'labEmpty', 'labEmpty', 
'radiographTest', 'ultrasoundTest'
);  

$tableColumns = 4;
if ($isAdultEncounter) {
    $labsThisItems = $labsPrimary;
}
if ($isObgynEncounter) {
    $labsThisItems = $labsOBGYN; 
}
if ($isPediatricEncounter) {
    $labsThisItems = $labsPediatric; 
}

$labsItemsEXT = array();
foreach ($labsThisItems as $concept) {
    if ($concept == "labEmpty") $newItem = labsMakeEmpty();
    if (array_key_exists($concept, $labsAllCheckOnlyItems)) {
        $newItem = labsMakeCheckOnly($concept, $labsAllCheckOnlyItems[$concept]);
    } 
    if (array_key_exists($concept, $labsAllCheckAndTextItems)) {
        $newItem = labsMakeCheckAndText($concept, $labsAllCheckAndTextItems[$concept]);
    } 
    if (array_key_exists($concept, $labsAllRadioSetItems)) {
        $newItem = labsMakeRadioSet($concept,
					   $labsAllRadioSetItems[$concept]['label'],
					   $labsAllRadioSetItems[$concept]['radios']);  
    }

    /*if (array_key_exists($concept, $labsIndentedItems)) {
      $newItem = '{ padding: \'0 0 0 16\',' . substr($newItem, 1);
    } */

    $labsItemsEXT[] = $newItem;
}
#Add other options
$labsItemsEXT[] = '{xtype: \'label\', border: false, text: \'' . _('Autres') . ':\'}';
$labsItemsEXT[] = labsMakeTextOnly('labOther1');
$labsItemsEXT[] = labsMakeTextOnly('labOther2');
$labsItemsEXT[] = labsMakeEmpty();
?>

itemLabs = {
		xtype: 'panel',
		title: '',
		autoHeight: true,
		border: false,
		items: [{ 
			 xtype: 'fieldset',
			 title: '<?=_("Tests Laboratoire")?>',
			 autoHeight: true,
			 padding: 5,
			 layout: {type:'table', columns: <?=$tableColumns?>},
			 items: transposeExtTableItems([<?=implode(",\n", $labsItemsEXT)?>], <?=$tableColumns?>, {xtype: 'label', text:''})
		}] 
	};


itemFamilyPlanning = {       // obgyn stuff
		xtype: 'fieldset',
		layout: 'form',
		title: '<?=_('Planification familiale')?>',
		padding: 5,
		items: [{
      boxLabel: '<?=_('Counseling effectué')?>',
      <?= genExtWidget('famPlanMethodCounseling', 'checkbox', 1); ?> 
    }, {
			xtype: 'fieldset',
			layout: 'hbox', 
			border: false,
			defaults: {margins: '0 16 0 0'},
			items: [{
				xtype: 'label',
				text: '<?=_('Date début :')?>'
			},{	
				width:90,
				<?= genExtWidget("beginBCDt", "datefield", 0); ?> 
			},{
				xtype: 'label',
				text: '<?=_('Date d’arrêt')?> :'
			},{ 
				width:90,
				<?= genExtWidget("endBCDt", "datefield", 0); ?> 
			},{ 
				boxLabel: '<?=_('Utilisation Courante')?>',
				//this used to be a radio with 1=Oui and 0=Non
				<?= genExtWidget("currentBCUse", "checkbox", 1); ?> 
			}] 
	},{
	    xtype: 'label',
	    html: '<hr>'
	},{
			xtype: 'fieldset',
			border: false,
			layout: {type: 'table', columns: 6},
			cls: 'birthControlTable',
			items: [{
		    xtype: 'label',
		    text: 'Méthode PF administrée'
		},{
		    boxLabel: '<?=_('Condom')?>',
		    <?= genExtWidget('famPlanMethodCondom', 'checkbox', 1); ?> 
		},{ 
		    boxLabel: '<?=_('Ligature des trompes')?>',
		    <?= genExtWidget('famPlanMethodLigature', 'checkbox', 1); ?> 
		},{
		    boxLabel: '<?=_('Pilule: Combiné')?>',
		    <?= genExtWidget('famPlanMethodPillCombined', 'checkbox', 1); ?> 
		},{
		    boxLabel: '<?=_('Pilule: Progestatif seule')?>',
		    <?= genExtWidget('famPlanMethodPillOnly', 'checkbox', 1); ?> 
		},{
		    boxLabel: '<?=_('Implant')?>',
		    <?= genExtWidget('famPlanMethodImplants', 'checkbox', 1); ?> 
		},{
		    boxLabel: '<?=_('Stérilet')?>',
		    <?= genExtWidget('famPlanMethodSterile', 'checkbox', 1); ?> 
		},{
		    boxLabel: '<?=_('Injectable')?>',
		    <?= genExtWidget('famPlanMethodInjectable', 'checkbox', 1); ?> 
		},{
		    boxLabel: '<?=_('Collier, jour fixe :')?>',
		    <?= genExtWidget('famPlanMethodCollier', 'checkbox', 1); ?> 
		},{
        	    width:90,
        	    <?= genExtWidget("famPlanMethodCollierDt", "datefield", 0); ?> 
    		},{
		    layout: 'column',
		    border: false,
		    items: [{
			    xtype: 'label',
			    text: '<?=_('Autre')?>:'
		    },{
			    width: '15em',
			    <?= genExtWidget('famPlanOther_specify', 'textfield', 0); ?> 
		    }]
		}]  
	}]
    };

itemVaccination = {
    xtype: 'fieldset',
    title: '<?=_('Vaccination')?>',
    layout: 'hbox',
    defaults: {margins: '5 16 5 5'},
    items: [{
	<?php if (!$isObgynEncounter) { ?>
	    boxLabel: '<?=_('RR')?>', 
	    <?= genExtWidget('rr', 'checkbox',0); ?>
	},{
	<?php } ?>
	    boxLabel: '<?=_('DT/Tétanos toxoïde')?>',
	    <?= genExtWidget('toxTetanus1DtToday', 'checkbox', 0); ?>
	},{
	    boxLabel: '<?=_('Hépatite B')?>',
	    <?= genExtWidget('hepatitisBTest', 'checkbox', 0); ?>
	},{
	    xtype: 'label',
	    text: '<?=_('Autre')?> :',
	    margins: '5 0 5 5'
	},{   
	    width: '20em',
	    <?= genExtWidget('immunOtherText1', 'textfield', 0); ?>
	}]
};

itemPrescribedMedications = {
		xtype: 'fieldset',
		autoHeight: true,
		autoScroll: true,
	        autoWidth: true,
                padding: 5,
		title: '<?=_('Medicaments prescrits / Posologie')?>',
		items: [{		
			width: '80%', 
			fieldLabel: '1',
			<?= genExtWidget("medicinePres1","textfield", 0); ?>
		},{		
			width: '80%',
			fieldLabel: '2',
			<?= genExtWidget("medicinePres2","textfield",0); ?>
		},{		
			width: '80%', 
			fieldLabel: '3',
			<?= genExtWidget("medicinePres3","textfield",0); ?>
		},{		
			width: '80%', 
			fieldLabel: '4',
			<?= genExtWidget("medicinePres4","textfield",0); ?>
		},{		
			width: '80%', 
			fieldLabel: '5',
			<?= genExtWidget("medicinePres5","textfield",0); ?>
	    }] 
    }; 

itemNutritionalSupport = {
        xtype: 'fieldset',
        title: '<?=_('Support Nutritionnel')?>',
        items: [
            { xtype: 'fieldset', layout: 'hbox',
	      defaults: {margins: '0 8'},
	      border: false,
              items: [
    {boxLabel: '<?=_('Oui')?>', <?=genExtWidget('nutritionalSupport', 'radio', 1); ?>},
    {boxLabel: '<?=_('Non')?>', <?=genExtWidget('nutritionalSupport', 'radio', 2); ?>},
    {xtype: 'label', text: '<?=_('Si oui, précisez:')?>'}
		      ]
            },{
                layout: {type: 'hbox'},
                defaults: {margins: '0 8'},
                border: false,
                height: 35,
                items: [
                    {
			flex: 1,
                        boxLabel: '<?=_('Lait enrichi')?>',
                        <?=genExtWidget('nutritionalSupportEnrichedMilk','checkbox', 0);?>
		    },{
			flex: 2,
                        boxLabel: '<?=_('Préparation pour nourrissons (LM)')?>',
                        <?=genExtWidget('nutritionalSupportLM','checkbox', 0);?>
		    },{
			flex: 1,
                        boxLabel: '<?=_('Medica mamba')?>',
                        <?=genExtWidget('nutritionalSupportMedicaMamba','checkbox', 0);?>
		    },{
			flex: 1,
                        boxLabel: '<?=_('Ration sèche')?>',
                        <?=genExtWidget('nutritionalSupportDryRations','checkbox', 0);?>
		    },{
			flex: 2,
			layout: {type: 'hbox'},
			defaults: {margins: '0 8'},
			border: false,
                        height: 35,
			items: [{
				xtype: 'label',
				text: '<?=_('Autre, précisez')?> :'
			      },{
				width: '25ex',
				<?=genExtWidget('nutritionalSupportOther_specify', 'textfield', 0); ?>
			      }]
		    }
                ]
            }
        ]
    };
buildValidation(72, makeTestAllOrNone(makeTestAnyIsChecked('nutritionalSupport1'),
				      makeTestOr(makeTestAnyIsChecked('nutritionalSupportEnrichedMilk0',
								      'nutritionalSupportLM0',
								      'nutritionalSupportMedicaMamba0',
								      'nutritionalSupportDryRations0'),
						 makeTestAnyNotBlank('nutritionalSupportOther_specify0'))));


var itemEvaluationAndPlanning = {
    xtype: 'fieldset',
    padding: 5,
    defaults: { },
    title: '<?=_('Suivi et planification')?>',
    items: [{
	    layout: {type: 'hbox'},
	    border: false,
      defaults: {margins: '0 12 0 0'},
	    items: [{
		    xtype: 'label',
		    text: '<?=_('Semaine de Gestation:')?>'
		},{
		    width: '3em',
		    allowNegative: false,
		    margins: '0 24 0 0',
		    <?= genExtWidget('evalplanWeekOfPregnancy','numberfield',0); ?>
		}]
        },{
            xtype: 'fieldset',
            border: false,
            layout: {type: 'table', columns: 9},
            cls: 'formTableStd',
            items: [{
		    xtype: 'label',
		    text: '<?=_('Facteur de risque:')?>'
		},{
		    boxLabel: '<?=_('Aucune')?>',
		    <?= genExtWidget('evalplanRiskFactorAucune', 'checkbox', 1); ?> 
		},{
		    boxLabel: '<?=_('Ancienne césarisée')?>',
		    <?= genExtWidget('evalplanRiskFactorAncienne', 'checkbox', 1); ?> 
		},{
		    boxLabel: '<?=_('Anémie')?>',
		    <?= genExtWidget('evalplanRiskFactorAnemie', 'checkbox', 1); ?> 
		},{
		    boxLabel: '<?=_('Diabète')?>',
		    <?= genExtWidget('evalplanRiskFactorDiabete', 'checkbox', 1); ?> 
		},{
		    boxLabel: '<?=_('Œdème')?>',
		    <?= genExtWidget('evalplanRiskFactorOedeme', 'checkbox', 1); ?> 
		},{
		    boxLabel: '<?=_('Grande parité')?>',
		    <?= genExtWidget('evalplanRiskFactorParite', 'checkbox', 1); ?> 
		},{
		    boxLabel: '<?=_('<18ans')?>',
		    <?= genExtWidget('evalplanRiskFactor18', 'checkbox', 1); ?> 
    },{
        boxLabel: '<?=_('>35ans')?>',
		    <?= genExtWidget('evalplanRiskFactor35', 'checkbox', 1); ?> 
    },{
		    xtype: 'label',
		    text: ''
		},{
		    boxLabel: '<?=_('Grossesse multiple')?>',
		    <?= genExtWidget('evalplanRiskFactorMultiple', 'checkbox', 1); ?> 
		},{
		    boxLabel: '<?=_('Hémorragie antépartum')?>',
		    <?= genExtWidget('evalplanRiskFactorAntepartum', 'checkbox', 1); ?> 
		},{
		    boxLabel: '<?=_('Hypertension')?>',
		    <?= genExtWidget('evalplanRiskFactorHypertension' , 'checkbox', 1); ?> 
		},{
		    boxLabel: '<?=_('Poids stationnaire')?>',
		    <?= genExtWidget('evalplanRiskFactorPoids', 'checkbox', 1); ?> 
		},{
		    boxLabel: '<?=_('VIH')?>',
		    <?= genExtWidget('evalplanRiskFactorVIH', 'checkbox', 1); ?> 
		},{
		    boxLabel: '<?=_('Taille<150cm')?>',
		    <?= genExtWidget('evalplanRiskFactorTaille', 'checkbox', 1); ?> 
		}]
	},{
	    xtype: 'label',
	    html: '<hr>'
  },{
	    layout: {type: 'hbox'},
	    border: false,
	    defaults: {margins: '8 12 8 0'},
	    items: [{
		    xtype: 'label',
		    style: {'font-weight': 'bold'},
		    text: '<?=_('VIH counseling/test')?>:'
      },{
		    boxLabel: '<?=_('Counseling prétest &nbsp;&nbsp; Date :')?>',
		    <?= genExtWidget('evalplanHIVCounselingPretest', 'checkbox', 1); ?> 
      },{
		    width: 90,
		    <?= genExtWidget('evalplanHIVCounselingPretestDate', 'datefield', 0); ?>
      },{
		    boxLabel: '<?=_('Counseling post test &nbsp;&nbsp; Date :')?>',
		    <?= genExtWidget('evalplanHIVCounselingPosttest', 'checkbox', 1); ?> 
      },{
		    width: 90,
		    <?= genExtWidget('evalplanHIVCounselingPosttestDate', 'datefield', 0); ?>
      }]
  },{
	    layout: 'hbox',
	    border: false,
	    defaults: {margins: '8 12 8 0'},
	    items: [{
		    xtype: 'label',
		    text: '<?=_('Référence partenaire :')?>'
      },{
		    boxLabel: '<?=_('Oui')?>',
		    <?= genExtWidget('evalplanHIVCounselingPartner', 'radio', 1); ?>
      },{
		    boxLabel: '<?=_('No')?>',
		    <?= genExtWidget('evalplanHIVCounselingPartner', 'radio', 2); ?>
      },{
		    xtype: 'label',
		    text: '<?=_('Référence partenaire :')?>'
      },{
		    boxLabel: '<?=_('Positif')?>',
		    <?= genExtWidget('evalplanHIVCounselingPartnerResult', 'radio', 1); ?>
      },{
		    boxLabel: '<?=_('Négatif')?>',
		    <?= genExtWidget('evalplanHIVCounselingPartnerResult', 'radio', 2); ?>
      },{
		    boxLabel: '<?=_('Indéterminé')?>',
		    <?= genExtWidget('evalplanHIVCounselingPartnerResult', 'radio', 3); ?>
      }]
  },{
	    layout: 'hbox',
	    border: false,
	    defaults: {margins: '8 12 8 0'},
	    items: [{
		    xtype: 'label',
		    text: '<?=_('Motif de dépistage')?>'
      },{
		    width: '80%',
				<?=genExtWidget('evalplanHIVCounselingReason', 'textfield', 0); ?>
      }]
	},{
	    xtype: 'label',
	    html: '<hr>'
	},{
	    layout: {type: 'hbox'},
	    border: false,
	    defaults: {margins: '8 12 8 0'},
	    items: [{
		    xtype: 'label',
		    style: {'font-weight': 'bold'},
		    text: '<?=_('VIH Positif')?>:'
		},{
		    xtype: 'label',
		    text: '<?=_('Stade OMS')?>'
		},{
		    boxLabel: '<?=_('Stade I')?>',
        margins: '5 12 8 0',
		    <?= genExtWidget('evalplanHIVStage1', 'checkbox', 1); ?> 
		},{
		    boxLabel: '<?=_('Stade II')?>',
		    margins: '5 12 8 0',
        <?= genExtWidget('evalplanHIVStage2', 'checkbox', 2); ?> 
		},{
		    boxLabel: '<?=_('Stade III')?>',
		    margins: '5 12 8 0',
        <?= genExtWidget('evalplanHIVStage3', 'checkbox', 3); ?> 
		},{
		    boxLabel: '<?=_('Stade IV')?>',
		    margins: '5 12 8 0',
        <?= genExtWidget('evalplanHIVStage4', 'checkbox', 4); ?> 
		},{
		    boxLabel: '<?=_('Stade inconnu')?>',
		    margins: '5 12 8 0',
        <?= genExtWidget('evalplanHIVStageUnknown', 'checkbox', 4); ?> 
		},{
		    xtype: 'label',
		    margins: '8 0 8 12',
		    text: '<?=_('Numération ou taux de CD4:')?>'
		},{
		    width: '10em',
		    allowNegative: false,
		    decimalSeparator: '.',
		    <?= genExtWidget('evalplanCD4Count','numberfield',0); ?>
		}]
	},{
	    layout: 'hbox',
	    border: false,
	    defaults: {margins: '8 12 8 0'},
	    items: [{
		    xtype: 'label',
		    text: '<?=_('Patiente sous ARV:')?>'
		},{
		    boxLabel: '<?=_('Oui, Date de début :')?>',
		    <?= genExtWidget('evalplanARV', 'radio', 1); ?>
		},{
		    width: 90,
		    <?= genExtWidget('evalplanARVYesDate', 'datefield', 0); ?>
		},{
                    style: {'margin-left': '10px'},
		    boxLabel: '<?=_('Non, si non date prèvue pour l’initiation de la prophylaxie :')?>',
		    <?= genExtWidget('evalplanARV', 'radio', 2); ?>
		},{
		    width: 90,
		    <?= genExtWidget('evalplanARVDate', 'datefield', 0); ?>
		}]
        },{
	     layout: 'hbox',
	     defaults: { margins: '0 3'},
	     border: false,
	     flex: 0.3,
	     items: [{
			xtype: 'label',
			text: '<?=_('Prophylaxie : ')?>'
		},{
			boxLabel: '<?=_('Cotrimoxazole')?>',
			<?= genExtWidget ('planCotrimoxazole', 'checkbox', 0); ?>
		},{
			boxLabel: '<?=_('Azythromycine')?>',
			<?= genExtWidget ('planAzythromycine', 'checkbox', 0); ?> 
		},{
			boxLabel: '<?=_('Fluconazole')?>',
			<?= genExtWidget ('planFluconazole', 'checkbox', 0); ?> 
		},{
			boxLabel: '<?=_('INH primaire')?>',
			<?= genExtWidget ('planINHprim', 'checkbox', 0); ?> 
		},{
			boxLabel: '<?=_('INH secondaire')?>',
			<?= genExtWidget ('planINHsec', 'checkbox', 0); ?> 
		}] 
	}]
    };
	

itemIntervention = {       // Itervention in OBGYN Stuff
		xtype: 'fieldset',
		layout: 'hbox',
        defaults: {margins: '5 16 5 5'},
		title: '<?=_('Intervention')?>',
		padding: 5,
		items: [{
				xtype: 'label',
				layout: 'hbox',
				width:150,
				text: '<?=_('Date de Procedure :')?>'
			},{
				width:90,
				<?= genExtWidget("procedureDate", "datefield", 0); ?> 
			},		
		{
      boxLabel: '<?=_('Cryotherapie ')?>',
      <?= genExtWidget('cryotherapie', 'checkbox', 0); ?> 
    },
	{
      boxLabel: '<?=_('LEEP ')?>',
      <?= genExtWidget('leep', 'checkbox', 0); ?> 
    },
	{
      boxLabel: '<?=_('Thermocoagulation ')?>',
      <?= genExtWidget('thermocoagulation', 'checkbox', 0); ?> 
    },
	{
      boxLabel: '<?=_('Conisation ')?>',
      <?= genExtWidget('conisation', 'checkbox', 0); ?> 
    },
	{
      boxLabel: '<?=_('Hystérectomie ')?>',
      <?= genExtWidget('hysterectomie', 'checkbox', 0); ?> 
    }]
    };	
	
	
	
	
	
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('evalplanHIVCounselingPretestDate0'),
				      makeTestAnyIsChecked('evalplanHIVCounselingPretest1')));
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('evalplanHIVCounselingPosttestDate0'),
				      makeTestAnyIsChecked('evalplanHIVCounselingPosttest1')));
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('evalplanRiskFactor_specify0'),
				      makeTestAnyIsChecked('evalplanRiskFactor1')));
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('evalplanARVDate0'),
				      makeTestAnyIsChecked('evalplanARV2')));
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('evalplanARVYesDate0'),
				      makeTestAnyIsChecked('evalplanARV1')));


<?php
$referencePanelObjects = array(
            'hospitalisation' => _('Hospitalisation'), 
            'progNutrition' => _('Programme de nutrition'), 
            'referenceForm' => _('Fiches de référence remplie'),
            'psychologue' => _('Psychologue'),
            'planFamily' => _('Planification familiale'),
            'referenceStructureCommunautaire' => _('Structure Communautaire'),
            'referenceVaccination' => _('Vaccination'),
            'referenceSTA' => _('Salle de Travail et d’Accouchement (STA)'),
            'referOtherService' => array('xtype: \'label\','
					 . 'text: \'' . _('Autre services, précisez') . ' :\'',
					 '},{',
					 'width: \'25ex\','
					 . genExtWidget('referOtherService_specify','textfield',0)),
            'referClinic' => array('xtype: \'label\','
				   . 'text: \'' . _('Autre établissement / clinique') . ' :\'',
                                   '},{',
                                   'width: \'50ex\','
                                   . genExtWidget('referClinic_specify','textfield',0)),
        );

echo "var itemReferenceRawList = [];\r\n";
foreach ($referencePanelObjects as $ref => $object) {
   echo "itemReferenceRawList['$ref'] = {";
   if (is_string($object)) {
      echo "boxLabel: '$object', flex: 1, ";
      echo genExtWidget($ref,'checkbox',0);
   } else {
      echo "
		flex: 2,
                layout: {type: 'hbox'},
                border: false,
                height: 35,
		items: [{";
      foreach ($object as $objectString) {
          echo $objectString . "\n";
      }
      echo '}]';
   }
   echo "};\n";
}
?>

var itemReferenceItemsAdult = [
    ['psychologue', 'progNutrition', 'planFamily', 'referenceForm', 'hospitalisation'],
    ['referClinic']
    ];

var itemReferenceItemsOBGYN = [
    ['psychologue', 'progNutrition', 'planFamily', 'referClinic'],
    ['referenceSTA', 'hospitalisation', 'referenceStructureCommunautaire', 'referenceForm']
    ];

var itemReferenceItemsPediatric = [
    ['progNutrition', 'hospitalisation', 'referenceVaccination', 'referOtherService'],
    ['referClinic', 'referenceForm']
    ];

var itemReferenceItemsIndex;
if (isAdultEncounter) itemReferenceItemsIndex = itemReferenceItemsAdult;
if (isObgynEncounter) itemReferenceItemsIndex = itemReferenceItemsOBGYN;
if (isPediatricEncounter) itemReferenceItemsIndex = itemReferenceItemsPediatric;

itemReference = {
        xtype: 'fieldset',
        title: '<?=_('Référence')?>',
        items: itemReferenceItemsIndex.map(function(line) {
		return {
		    layout: {type: 'hbox'},
		    defaults: {margins: '0 8'},
		    border: false,
		    height: 35,
		    items: line.map(function(item) {return itemReferenceRawList[item]})
		};
	})
};




var proceduresPanelItems = new Array();
<? if (getConfig('labOrderUrl') === Null) echo "
proceduresPanelItems.push(itemLabs);";
?>

if (isObgynEncounter) proceduresPanelItems.push(itemFamilyPlanning);
if (!isPediatricEncounter) proceduresPanelItems.push(itemVaccination);
proceduresPanelItems.push(itemPrescribedMedications);
proceduresPanelItems.push(itemIntervention);
if (isObgynEncounter) proceduresPanelItems.push(itemEvaluationAndPlanning);
if (isPediatricEncounter) proceduresPanelItems.push(itemNutritionalSupport);
proceduresPanelItems.push(itemReference);



var proceduresPanelVariables = {
        title: '<?=_('CONDUITE A TENIR')?>',
        id: 'procedures',
        autoHeight: true,
	autoScroll: true,
        padding: 5,
	defaults: {
		style: {
			marginBottom: '1em'
		},
		layout: 'form'
	}     
};
proceduresPanelVariables.items = proceduresPanelItems;
var proceduresPanel = new Ext.FormPanel(proceduresPanelVariables);
