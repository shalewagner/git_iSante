<?php

function consultationMakeEmpty() {
  return "{border: false, html: '&nbsp;', ctCls: 'consultationPanel'}";
}

function consultationMakeCategory($category) {
  $output = "{
  xtype: 'label',
  style: {'font-weight': 'bold'},
  text: '$category',
  ctCls: 'consultationPanel'
}
";
  return $output;
}

function consultationMakeCheckOnly($concept, $label) {
  global $tabIndex;
  $checkWidget = genExtWidget($concept, 'checkbox', 1);
  $output = "{
  xtype: 'fieldset', layout:'column',
  border: false,
  ctCls: 'consultationPanel',
  items:
   [{
      boxLabel: '$label',
      tabIndex: $tabIndex,
      $checkWidget
    }]
}";
  $tabIndex = $tabIndex + 1;
  return $output;
}

function consultationMakeSexAgressionItems() {
  global $tabIndex;
  $sexAgressionLt72hWidget = genExtWidget('sexAgressionLt72h', 'checkbox', 1);
  $sexAgressionLe120hWidget = genExtWidget('sexAgressionLe120h', 'checkbox', 1);
  $sexAgressionLe2wWidget = genExtWidget('sexAgressionLe2w', 'checkbox', 1);
  $sexAgressionGt2wWidget = genExtWidget('sexAgressionGt2w', 'checkbox', 1);

  $output = "{
  xtype: 'fieldset', layout:'column',
  border: false,
  ctCls: 'consultationPanel',
  items:
   [
    {boxLabel: '" . _('<72h') . "', tabIndex: $tabIndex, $sexAgressionLt72hWidget},
    {xtype: 'spacer', height: '1em', width: '1ex'},
    {boxLabel: '" . _('72-120h') . "', tabIndex: $tabIndex + 1, $sexAgressionLe120hWidget},
    {xtype: 'spacer', height: '1em', width: '1ex'},
    {boxLabel: '" . _('120h-2sem') . "', tabIndex: $tabIndex + 2, $sexAgressionLe2wWidget},
    {xtype: 'spacer', height: '1em', width: '1ex'},
    {boxLabel: '" . _('>2sem') . "', tabIndex: $tabIndex + 3, $sexAgressionGt2wWidget}
   ]
}";

  $tabIndex = $tabIndex + 4;
  return $output;
}

function consultationMakeTextOnly($concept) {
  global $tabIndex;
  $textWidget = genExtWidget($concept, 'textfield', 0);
  $output = "{
 xtype: 'fieldset', layout:'column',
 border: false,
 ctCls: 'consultationPanel',
 items:
  [{
     style: {'margin': '3px 0 0 5px'},
     tabIndex: $tabIndex,
     $textWidget
   }]
}";
  $tabIndex = $tabIndex + 1;
  return $output;
}

function consultationMakeCheckAndText($concept, $label) {
  global $tabIndex;
  $checkWidget = genExtWidget($concept, 'checkbox', 1);
  $textWidget = genExtWidget($concept . '_specify', 'textfield', 0);
  $nextTabIndex = $tabIndex + 1;
  $output = "{ rowspan: 2,
  border: false,
  ctCls: 'consultationPanel',
  items: [{
 boxLabel: '$label',
 tabIndex: $tabIndex,
 $checkWidget
 },{
 style: {'margin': '3px 0 0 5px'},
 tabIndex: $nextTabIndex,
 $textWidget
 }]
}
";
  //write javascript to validate the text is filled out when the check box is selected
  $checkWidgetId = $concept . '1';
  $textWidgetId = $concept . '_specify' . '0';
print "
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('$textWidgetId'),
                                      makeTestAnyIsChecked('$checkWidgetId')));
";
  $tabIndex = $tabIndex + 2;
  return $output;
}

function consultationIndentItem($item) {
  return '{ padding: \'0 0 0 12\',' . substr($item, 1);
}


if ($isAdultEncounter) {
$tableColumns = 4;
$consultationPanelData = 
    array(
	  consultationMakeCategory(_('Général')),
	  consultationMakeCheckOnly('adenopathie', _('Adénopathie')),
	  //consultationMakeCheckOnly('asthenia', _('Asthénie')),
	  //consultationMakeCheckOnly('courbatures', _('Courbatures')), 
	  consultationMakeCheckAndText('cedeme', _('Œdème, précisez:')),       
	  consultationMakeCheckAndText('douler', _('Douleur, précisez:')),
	  consultationMakeCheckOnly('feverLess2', _('Fièvre < 2 semaines')),
	  consultationMakeCheckOnly('feverGreat2', _('Fièvre ≥ 2 semaines')),
	  //consultationMakeCheckOnly('frissons', _('Frissons')), 
	  consultationMakeCheckOnly('perteDePoid', _('Perte de poids')), 
	  consultationMakeCheckOnly('sueursProfuse', _('Sueur profuses')),
	  consultationMakeCategory(_('Trauma')),
	  consultationMakeCheckOnly('agressionAuto', _('Agression Auto-infligée')),
	  '{xtype: \'label\', text: \'' . _('Agression Sexuelle') . ':' . '\'}',
	  consultationIndentItem(consultationMakeSexAgressionItems()),
	  consultationMakeCheckOnly('accidentVoiePublique', _('Accident Voie Publique')),
	  consultationMakeCheckAndText('brulure', _('Brûlures, précisez:')),
	  consultationMakeCheckOnly('fractureOsseuse', _('Fracture osseuse')),
	  '{xtype: \'label\', text: \'' . _('Plaie, précisez') . ':' . '\'}',
	  consultationIndentItem(consultationMakeCheckOnly('armeFeu', _('Arme à feu'))), 
	  consultationIndentItem(consultationMakeCheckOnly('armeBlanche', _('Arme blanche'))),
	  consultationIndentItem('{border: false, items: [{xtype: \'label\', text: \'' . _('Autres:') . '\'}]}'),
          consultationIndentItem(consultationMakeTextOnly('plaie_specify')),
	  consultationMakeCheckOnly('consultationHeadTrauma', _('Trauma crânien')),
		
	  consultationMakeCategory(_('Oreilles, Nez, Gorge')),
	  consultationMakeCheckOnly('rhinorhee', _('Ecoulement nasal')), 
	  //consultationMakeCheckOnly('eyeDischarge', _('Ecoulement purulent yeux')), 
	  consultationMakeCheckOnly('epitaxis', _('Epistaxis')),
	  consultationMakeCheckOnly('ceilRouge', _('Œil rouge')),
	  consultationMakeCheckOnly('otalgia', _('Otalgie')),
	  consultationMakeCheckOnly('otorrhea', _('Otorrhée')),		
	  consultationMakeCategory(_('Génito-urinaire')),
	  consultationMakeCheckOnly('brulureMictionnelles', _('Brûlures mictionnelles')),
	  consultationMakeCheckOnly('douleurHypogastrique', _('Douleur hypogastrique')),
	  consultationMakeCheckOnly('dysuria', _('Dysurie')),
	  consultationMakeCheckOnly('encoulementUrethral', _('Ecoulement uréthral')),
	  consultationMakeCheckOnly('hematuria', _('Hématurie')),
	  consultationMakeCheckOnly('hemorragieVaginale', _('Hémorragie vaginale')),
	  consultationMakeCheckOnly('pertesVaginales', _('Pertes vaginales')),
	  consultationMakeCheckOnly('pollakiurie', _('Pollakiurie')), 
	  consultationMakeCheckOnly('polyuria', _('Polyurie')),
	  consultationMakeCheckOnly('pruritVulvaire', _('Prurit Vulvaire')),
	  consultationMakeCheckOnly('ulceration', _('Ulcération(s)')),	
	  consultationMakeCheckOnly('retardDesRegles', _('Retard des Règles')),
	  consultationMakeCategory(_('Psychiatrique')),
	  consultationMakeCheckAndText('mentalTrouble', _('Troubles mentaux, précisez:')),
	  consultationMakeEmpty(),
	  consultationMakeEmpty(),
	
	  consultationMakeCategory(_('Neurologique')),
	  consultationMakeCheckOnly('aphasie', _('Aphasie')),
	  consultationMakeCheckOnly('boiterie', _('Boiterie/Steppage')),
	  consultationMakeCheckOnly('cephalee', _('Céphalée/Maux de tète')), 
	  //consultationMakeCheckOnly('coma', _('Coma')),
	  consultationMakeCheckOnly('convulsion', _('Convulsions')),
	  consultationMakeCheckOnly('hemiplegie', _('Hémiplégie')),
	  //consultationMakeCheckOnly('myalgie', _('Myalgie')),
	  consultationMakeCheckOnly('paralysie', _('Paralysie flasque')),
	  consultationMakeCheckOnly('paraplegie', _('Paraplégie')),
	  consultationMakeCheckOnly('syncopeSymptom', _('Syncope')),
	  consultationMakeCheckOnly('vertiges', _('Vertiges')),
	  consultationMakeCategory(_('Cardiovasculaire/pulmonaire')),
	  consultationMakeCheckOnly('doulersPrecordiales', _('Douleurs précordiales')), 
	  consultationMakeCheckOnly('doulersThoraciques', _('Douleurs thoraciques')), 
	  consultationMakeCheckOnly('dyspnea', _('Dyspnée')),
	  consultationMakeCheckOnly('hemoptysia', _('Hémoptysie')), 
	  //consultationMakeCheckOnly('orthopnee', _('Orthopnée')),
	  consultationMakeCheckOnly('palpitation', _('Palpitations')),
	  consultationMakeCheckOnly('touxLess2', _('Toux < 2 semaines')),
	  consultationMakeCheckOnly('touxGreat2', _('Toux ≥ 2 semaines')),
	  consultationMakeCategory(_('Dermatologique')),
	  consultationMakeCheckAndText('eruptionCutanees', _('Eruptions cutanées, précisez:')),
	  consultationMakeCheckOnly('prurit', _('Prurit')),
	  consultationMakeEmpty(),
	  consultationMakeEmpty(),
		     
	  consultationMakeCategory(_('Gastro-intestinale')),
	  consultationMakeCheckOnly('constipationSymptom', _('Constipation')),
	  consultationMakeCheckOnly('diarrheeLess2', _('Diarrhée < 2 semaines')),
	  consultationMakeCheckOnly('diarrheeGreat2', _('Diarrhée ≥ 2 semaines')),
	  consultationMakeCheckOnly('abdominalPain', _('Douleur abdominale')),
  	  consultationMakeCheckOnly('dysphagia', _('Dysphagie')),
	  consultationMakeCheckOnly('hematemesia', _('Hématémèse')),
	  consultationMakeCheckOnly('ictere', _('Ictère/jaunisse')),
	  consultationMakeCheckOnly('inappetence', _('Inappétence / anorexie')),
	  //consultationMakeCheckOnly('anorexiaGT2', _('Anorexie > 2 semaines')),
	  consultationMakeCheckOnly('melaena', _('Méléna')),
	  consultationMakeCheckOnly('nausea', _('Nausée')),
	  consultationMakeCheckOnly('pyrosisSymptom', _('Pyrosis')),
	  consultationMakeCheckOnly('vomisement', _('Vomissements')),
	  consultationMakeCategory(_('Autres')),
	  consultationMakeTextOnly('symptomOther1'),
	  consultationMakeTextOnly('symptomOther2'),
	  consultationMakeTextOnly('symptomOther3'),
	  consultationMakeTextOnly('symptomOther4'),
	  consultationMakeTextOnly('symptomOther5'),
	  consultationMakeTextOnly('symptomOther6'),
	  consultationMakeTextOnly('symptomOther7')
          );
} elseif ($isObgynEncounter) {
$tableColumns = 3;
$consultationPanelData = 
    array(
	  consultationMakeCheckAndText('amenorrhee', _('Aménorrhée, précisez')), 
	  consultationMakeCheckOnly('asthenia', _('Asthénie')),          
	  consultationMakeCheckOnly('cephalee', _('Céphalée')),
	  consultationMakeCheckOnly('foetalMovementChangeSymptom', _('Changement dans la fréquence et/ou <br/> intensité des mouvements foetaux')),
	  consultationMakeCheckOnly('convulsion', _('Convulsions')),
	  consultationMakeCheckOnly('courbatures', _('Courbatures')), 
	  consultationMakeCheckOnly('diarrheaSymptom', _('Diarrhée')),
	  consultationMakeCheckOnly('abdominalPain', _('Douleurs Abdominales')),
	  consultationMakeCheckOnly('epigasPainSymptom', _('Douleurs Épigastriques en barre')),
	  consultationMakeCheckOnly('hypogasDouleurs', _('Douleurs Hypogastriques')),
	  consultationMakeCheckOnly('doulersPrecordiales', _('Douleurs précordiales')), 
	  consultationMakeCheckOnly('doulersThoraciques', _('Douleurs thoraciques')),
	  consultationMakeCheckOnly('dyspnea', _('Dyspnée')),
	  consultationMakeCheckOnly('dysuria', _('Dysurie')),
	  consultationMakeCheckOnly('rhinorhee', _('Ecoulement nasal')),
	  
     //     consultationMakeCheckOnly('shiverFeverSymptom', _('Fièvre')),
	  consultationMakeCheckOnly('feverLess2', _('Fièvre < 2 semaines')),
	  consultationMakeCheckOnly('feverGreat2', _('Fièvre ≥ 2 semaines')),		  
	  consultationMakeCheckOnly('frissons', _('Frissons')), 
	  consultationMakeCheckOnly('hemoptysia', _('Hémoptysie')), 
	 // consultationMakeCheckOnly('orthopnee', _('Orthopnée')),
	  consultationMakeCheckOnly('hypomenorrheeSymptom', _('Hypoménorrhée')),
	  consultationMakeCheckOnly('hypermenorrheeSymptom', _('Hyperménorrhée')),
	  consultationMakeCheckOnly('inappetence', _('Inappétence')),
	  consultationMakeCheckOnly('leucorheeSymptom', _('Leucorrhée')),
	  consultationMakeCheckOnly('hypogasPain', _('Masse Hypogastrique')),
	  consultationMakeCheckOnly('menorrhagiaSymptom', _('Ménorragie')),
	  consultationMakeCheckOnly('metrorragieSymptom', _('Métrorragie')), 
	  consultationMakeCheckOnly('cedeme', _('Œdème')),
	  consultationMakeCheckOnly('menorrheeOligoSymptom', _('Oligo ménorrhée')), 
	  consultationMakeCheckOnly('vaginaLiquidSymptom', _('Passage de liquide par le vagin')),
	  consultationMakeCheckOnly('perteDePoid', _('Perte de poids')),
	  consultationMakeEmpty(),  
	         
	  consultationMakeCheckOnly('familyplan', _('Planification Familiale')),  
	  consultationMakeCheckOnly('pollakiurie', _('Pollakiurie')),
	  consultationMakeCheckOnly('polymenorrheeSymptom', _('Poly ménorrhée')),
	  consultationMakeCheckOnly('pruritVulvaire', _('Prurit Vulvaire')),
	  consultationMakeCheckOnly('ptme', _('PTME')),
	  consultationMakeCheckOnly('vaginalBleedingSymptom', _('Saignement Vaginal')),
	  consultationMakeCheckOnly('sueursProfuse', _('Sueurs profuses face/doigts')),
	  consultationMakeCheckOnly('touxLess2', _('Toux < 2 semaines')),
	  consultationMakeCheckOnly('touxGreat2', _('Toux ≥ 2 semaines')),
	  consultationMakeCheckOnly('visualTrouble', _('Troubles Visuels')),
	  consultationMakeCheckOnly('vomiting', _('Vomissement')),
	  '{xtype: \'label\', text: \'' . _('Autres, précisez :') . '\'}',
	  consultationMakeTextOnly('symptomOther1'),
	  consultationMakeTextOnly('symptomOther2')
	  );
} elseif ($isPediatricEncounter) {
$tableColumns = 4;
$consultationPanelData = 
    array(
	  consultationMakeCategory(_('Général')),
	  consultationMakeCheckOnly('asthenia', _('Asthénie/léthargie')),
	  consultationMakeCheckOnly('courbatures', _('Courbatures')), 
	  consultationMakeCheckAndText('douleur', _('Douleurs, précisez :')),
	  consultationMakeCheckOnly('pedSympNutritionalEdema', _('Œdèmes bilateraux (nutritionnel)')), 
	  consultationMakeCheckAndText('cedeme', _('Œdème, précisez :')), 
	  consultationMakeCheckOnly('feverLess2', _('Fièvre < 2 semaines')),
	  consultationMakeCheckOnly('feverGreat2', _('Fièvre ≥ 2 semaines')),
	  consultationMakeCheckOnly('frissons', _('Frissons')),
	  consultationMakeCheckOnly('inssufficientWeightGain', _('Insuffisance gain de poids')),
	  consultationMakeCheckOnly('malaise', _('Malaise')),
	  consultationMakeCheckOnly('myalgie', _('Myalgie')), 
	  consultationMakeCheckOnly('perteDePoid', _('Perte de poids')),
	  consultationMakeCheckOnly('sueursProfuse', _('Sueur profuses')), 
	  consultationMakeCheckOnly('continualUnexplainedCrying', _('Pleurs incessants inexpliqués')),
	  consultationMakeCheckOnly('refusesBreastFeedingOrDrink', _('Refus de téter / boire')),	  
	  consultationMakeCategory(_('Cardiovasculaire/Pulmonaire')), 
	  consultationMakeCheckOnly('doulersThoraciques', _('Douleurs thoraciques')),
	  consultationMakeCheckOnly('dyspnea', _('Dyspnée')),
	  consultationMakeCheckOnly('hemoptysia', _('Hémoptysie')),
	  //consultationMakeCheckOnly('orthopnee', _('Orthopnée')),
	  consultationMakeCheckOnly('palpitation', _('Palpitation')),
	  consultationMakeCheckOnly('touxLess2', _('Toux < 2 semaines')),
	  consultationMakeCheckOnly('touxGreat2', _('Toux ≥ 2 semaines')),
		
	  consultationMakeCategory(_('Oreilles, Nez, Gorge')),
	  consultationMakeCheckOnly('rhinorhee', _('Ecoulement nasal')),
	  consultationMakeCheckOnly('pusEyeSecretion', _('Ecoulement de pus dans les yeux')),
	  //consultationMakeCheckOnly('epitaxis', _('Epistaxis')),
	  consultationMakeCheckOnly('ceilRouge', _('Œil rouge')),
	  consultationMakeCheckOnly('otalgia', _('Otalgie')),
	  consultationMakeCheckOnly('otorrhea', _('Otorrhée')),
	  
  	  consultationMakeCategory(_('Trauma')),
	  consultationMakeCheckOnly('domesticAssault', _('Agression à domicile')),
	  '{xtype: \'label\', text: \'' . _('Agression Sexuelle') . ':' . '\'}',
	  consultationIndentItem(consultationMakeSexAgressionItems()),
	  consultationMakeCheckOnly('accidentVoiePublique', _('Accident Voie Publique')),
	  consultationMakeCheckAndText('brulure', _('Brûlure, précisez:')),
	  consultationMakeCheckOnly('fractureOsseuse', _('Fracture osseuse')),
	  consultationMakeCheckAndText('plaie', _('Plaie, précisez:')),
  	  consultationMakeCheckOnly('traumaCranien', _('Trauma crânien')),
	     
	  consultationMakeCategory(_('Dermatologique')),
	  consultationMakeCheckOnly('eruptionCutanees', _('Eruptions cutanées')),
	  consultationMakeCheckOnly('ecchymosisPetechiae', _('Pétéchie/Ecchymose')),
	  consultationMakeCheckOnly('prurit', _('Prurit')),
	  consultationMakeCheckOnly('purpura', _('Purpura')),
	  consultationMakeCheckOnly('urticaria', _('Urticaire')),
	  consultationMakeEmpty(),
	
	// 2nd column starts here
	  consultationMakeCategory(_('Neurologique')),
	  consultationMakeCheckOnly('arthralgia', _('Arthralgie')),
	  consultationMakeCheckOnly('cephalee', _('Céphalée/Maux de tète')),
	  consultationMakeCheckOnly('convulsion', _('Convulsions')),
	  consultationMakeCheckOnly('irritabilityAgitation', _('Irritablilité/agitation')),
	  consultationMakeCheckOnly('pedSympLethargy', _('Léthargie/inconscient')),
	  consultationMakeCheckOnly('paralysie', _('Paralysie flasque')),
	  consultationMakeCheckOnly('syncopeSymptom', _('Syncope')),
	  //consultationMakeCheckOnly('vertiges', _('Vertiges')),

	  consultationMakeCategory(_('Génito-urinaire')),
	  consultationMakeCheckOnly('brulureMictionnelles', _('Brûlures mictionnelles')),
	  consultationMakeCheckOnly('dysuria', _('Dysurie')),
	  consultationMakeCheckOnly('enuresis', _('Enurésie')),
	  consultationMakeCheckOnly('hematuria', _('Hématurie')),
	  consultationMakeCheckOnly('leucorheeSymptom', _('Leucorrhée')),
	  consultationMakeCheckOnly('polyuria', _('Polyurie')),
	  consultationMakeCheckOnly('pruritVulvaire', _('Pruirit vulvaire')),

	  consultationMakeCategory(_('Gastro-intestinale')),
	  consultationMakeCheckOnly('constipationSymptom', _('Constipation')),
	  consultationMakeCheckOnly('diarrheeLess2', _('Diarrhée < 2 semaines')),
	  consultationMakeCheckOnly('diarrheeGreat2', _('Diarrhée ≥ 2 semaines')),
	  consultationMakeCheckOnly('abdominalPain', _('Douleurs abdominales')),
	  consultationMakeCheckOnly('dysphagia', _('Dysphagie')),
	  consultationMakeCheckOnly('ictere', _('Ictère/jaunisse')), 
	  consultationMakeEmpty(),
	
	// 3rd column starts here
	  consultationMakeCategory(_('Gastro-intestinale, cont.')),
	  consultationMakeCheckOnly('inappetence', _('Inappétence / anorexie')), 
	  //consultationMakeCheckOnly('anorexiaGT2', _('Anorexie > 2 semaines')),  
	  consultationMakeCheckOnly('hematemesia', _('Hématémèse')),
	  consultationMakeCheckOnly('melaena', _('Méléna')),
	  consultationMakeCheckOnly('nausea', _('Nausée')),
	  consultationMakeCheckOnly('prurisAni', _('Pruit anal')),
	  consultationMakeCheckOnly('pyrosisSymptom', _('Pyrosis')),
	  consultationMakeCheckOnly('regurgitation', _('Régurgitation')),
	  consultationMakeCheckOnly('vomisement', _('Vomissement')), 
	  consultationMakeCategory(_('Psychiatrique')),
	  consultationMakeCheckAndText('mentalTrouble', _('Troubles mentaux, précisez :')),
  	  consultationMakeCategory(_('Autres')),
          consultationMakeTextOnly('symptomOther1'),
          consultationMakeTextOnly('symptomOther2'),
	  consultationMakeEmpty(),
	  consultationMakeEmpty(),
	  consultationMakeEmpty(),
	  consultationMakeEmpty(),
	  consultationMakeEmpty(),
	  consultationMakeEmpty()
	  );
}
?> 

var consultationPanel = new Ext.FormPanel({
	title: '<?= _('MOTIFS DE CONSULTATION') ?>',
	id: 'consultationPanel',
	autoHeight: true,
	autoScroll: true,
	padding: 5,
	defaults: {
	    border: false,
            autoHeight: true
	},
	items: [
        <?php if ($isFollowupEncounter) { ?>
	{
	    layout: 'hbox',
            defaults: {margins: '0 5'},
	    style: {'font-weight': 'bold'},
	    items: [
		    <?=consultationMakeCheckOnly('dxFollowup', _('Suivi Diagnostic Actuel'))?>,
		    <?=consultationMakeCheckOnly('newSymptom', _('Nouveau Problème'))?>,
		    <?=consultationMakeCheckOnly('labResult', _('Résultat de Laboratoire'))?>
		    ]
	},
	<?php if ($isPediatricEncounter) { ?>
	{ xtype: 'label', html: '<hr>' },
        <?php } ?>
        <?php } ?>
        <?php if ($isObgynEncounter) { ?>
	{
	    layout: 'hbox',
            defaults: {margins: '5 5'},
	    items: [
		    {xtype: 'label', style: {'font-weight': 'bold', 'margin-top': '3px'},
			text: '<?= _('Agression Sexuelle') . ' :' ?>'},
		    <?=consultationMakeSexAgressionItems()?>
		    ]
        },
        <?php } ?>
	{
		padding: 5,
		layout: {
		type: 'table',
		columns: <?= $tableColumns ?>
		},
		items: transposeExtTableItems([<?= implode(",\n", $consultationPanelData) ?>],
		<?= $tableColumns ?>,
		{xtype: 'label', text: ''})
		<?php if (! $isObgynEncounter) { ?>
		},{
		fieldLabel: '<?= _('Remarques') ?>',
                style: {'margin-left': '5px'},
		tabIndex: 2100,
		<?= genExtWidget("symptomSpecify", "textarea", 0); ?>,
		width: '80ex'
		<?php } ?>
	}]   
});
