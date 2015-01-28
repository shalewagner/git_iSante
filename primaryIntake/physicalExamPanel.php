<?
function physicalExamMakeRow($conceptName, $label) {
  $output = "{xtype: 'label', text: '$label', width: '150ex'}";
  $output .= ',{' . genExtWidget($conceptName, 'radio', 1) . ', ctCls: "physicalExamRadio"}';
  $output .= ',{' . genExtWidget($conceptName, 'radio', 2) . ', ctCls: "physicalExamRadio"}';
  $output .= ',{' . genExtWidget($conceptName, 'radio', 3) . ', ctCls: "physicalExamRadio"}';
  return $output;
} 

function physicalExamLabelRow($label) {
  $output = "{xtype: 'label', text: '$label', 	width: '150ex'}";
  $output .= ",{xtype: 'label', text: ''}";
  $output .= ",{xtype: 'label', text: ''}";
  $output .= ",{xtype: 'label', text: ''}";
  return $output;
}
function physicalExamTextField($conceptName) {
  $textWidget = genExtWidget($conceptName, 'textfield', 0);
  $output = "{
	width: '75ex',
        $textWidget 
  }";
  return $output;
}
function physicalExamCheckText($concept, $conceptText) {
  //write javascript to validate the text is filled out when the check box is selected
  $checkWidgetId = $concept;
  $textWidgetId = $conceptText;
print "
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('$conceptText'),
                                      makeTestAnyIsChecked('${concept}1','${concept}2','${concept}3')));
";
}
?>
    
var examListItems = [
<? if ($isObgynEncounter) { ?>
       <?= physicalExamMakeRow('physicalGeneral', _('Général')) ?>,
       <?= physicalExamMakeRow('physicalHead', _('Tête')) ?>,
       <?= physicalExamMakeRow('physicalNeck', _('Cou + Thyroïde')) ?>,
       <?= physicalExamMakeRow('physicalLungs', _('Poumons')) ?>,
       <?= physicalExamMakeRow('physicalHeart', _('Coeur')) ?>,
       <?= physicalExamMakeRow('physicalCentres', _('Seins')) ?>,
       <?= physicalExamMakeRow('physicalAbdomen', _('Abdomen')) ?>,
       <?= physicalExamMakeRow('physicalUterine', _('Utérus')) ?>,
       <?= physicalExamMakeRow('physicalExternalGenitals', _('Organes génitaux Externes')) ?>,
       <?= physicalExamMakeRow('physicalVagina', _('Vagin')) ?>,
       <?= physicalExamMakeRow('physicalCollar', _('Col')) ?>,
       <?= physicalExamMakeRow('physicalAppendices', _('Annexes')) ?>,
/*       <?= physicalExamMakeRow('physicalBassin', _('Bassin')) ?>,      */
       <?= physicalExamMakeRow('physicalRectum', _('Toucher Rectal')) ?>,
       <?= physicalExamMakeRow('physicalMembers', _('Membres')) ?>,
       <?= physicalExamMakeRow('physicalTendonReflexes', _('Reflexes Ostéo-Tendineux')) ?>,
       <?= physicalExamMakeRow('physicalSkin', _('Peau')) ?>
<? } else { ?>
       <?= physicalExamMakeRow('physicalHead', _('Tête')) ?>,
       <?= physicalExamMakeRow('physicalEyes', _('Yeux')) ?>,
       <?= physicalExamMakeRow('physicalNose', _('Nez')) ?>,
       <?= physicalExamMakeRow('physicalMouth', _('Bouche')) ?>,
       <?= physicalExamMakeRow('physicalEar', _('Oreille')) ?>,
       <?= physicalExamMakeRow('physicalCollar', _('Cou')) ?>,
       <?= physicalExamMakeRow('physicalHeart', _('Coeur')) ?>, 
       <?= physicalExamMakeRow('physicalLungs', _('Poumons')) ?>,
       <?= physicalExamMakeRow('physicalAbdomen', _('Abdomen')) ?>,
       <?= physicalExamMakeRow('physicalGenitals', _('Organes génitaux')) ?>,
       <? if ($isAdultEncounter) { ?> 
		<?= physicalExamMakeRow('physicalRectum', _('Toucher Rectal')) ?>,
       <? } ?>
       <?= physicalExamMakeRow('physicalMembers', _('Membres')) ?>,
       <?= physicalExamMakeRow('physicalSkin', _('Peau')) ?>,
       <? if ($isPediatricEncounter) { ?>
		<?= physicalExamMakeRow('physicalAnus', _('Anus')) ?>,
       <? } ?>
       <?= physicalExamMakeRow('physicalNeurological', _('Examen Neurologique')) ?>
<? } ?>
	   ]; 

examListItems.unshift({xtype: 'label', text: ''},
		      {xtype: 'label', text: '<?= _('Normal') ?>', ctCls: 'physicalExamRadio'},
                      {xtype: 'label', text: '<?= _('Anormal') ?>', ctCls: 'physicalExamRadio'},
		      {xtype: 'label', text: '<?= _('Non Effectué') ?>', ctCls: 'physicalExamRadio'});

<? if ($isPediatricEncounter) { ?>
    examListItems.push({
	    border: false,
	    items: [
		    {xtype: 'label', text: '<?= _('Tanner') ?> S:'},
		    {width: '2em', <?= genExtWidget('tannerS', 'textfield', 1) ?>},
		    {xtype: 'label', text: 'P:'},
		    {width: '2em', <?= genExtWidget('tannerP', 'textfield', 1) ?>}
	    ]},
	{<?= genExtWidget('physicalTanner', 'radio', 1) ?>, ctCls: 'physicalExamRadio'},
	{<?= genExtWidget('physicalTanner', 'radio', 2) ?>, ctCls: 'physicalExamRadio'},
	{<?= genExtWidget('physicalTanner', 'radio', 3) ?>, ctCls: 'physicalExamRadio'});
    buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('tannerS1'),
					  makeTestAnyNotBlank('tannerP1'),
					  makeTestAnyIsChecked('physicalTanner1',
							       'physicalTanner2',
							       'physicalTanner3')));
<? } ?>

examListItems.push({xtype: 'label', text: '<?= _('Lymphadenopathy') ?>'},
		      {xtype: 'label', text: '<?= _('Absent') ?>', ctCls: 'physicalExamRadio'},
                      {xtype: 'label', text: '<?= _('Présent') ?>', ctCls: 'physicalExamRadio'},
		      {xtype: 'label', text: '<?= _('Non Effectué') ?>', ctCls: 'physicalExamRadio'});
examListItems.push(<?= physicalExamMakeRow('physicalCervical', _('-Cervicale')) ?>);
examListItems.push(<?= physicalExamMakeRow('physicalSupraclavicular', _('-Supraclaviculaire')) ?>);
examListItems.push(<?= physicalExamMakeRow('physicalAxillary', _('-Axillaire')) ?>);
examListItems.push(<?= physicalExamMakeRow('physicalInguinal', _('-Inguinale')) ?>);

<? if ($isObgynEncounter) { ?>
    examListItems.push({
	    border: false,
	    items: [
		{xtype: 'label', text: '<?= _('Autres') ?> :'},
		{width: '10em', <?= genExtWidget('physicalOtherText', 'textfield', 1) ?>}
	    ]},
	{<?= genExtWidget('physicalOthers', 'radio', 1) ?>, ctCls: 'physicalExamRadio'},
	{<?= genExtWidget('physicalOthers', 'radio', 2) ?>, ctCls: 'physicalExamRadio'},
	{<?= genExtWidget('physicalOthers', 'radio', 3) ?>, ctCls: 'physicalExamRadio'});
<? } ?>

if (isObgynEncounter) {
    var examDescriptionTextAreaHeight = '23em';
    var physicalExamFooterObgynRows = 
	[
	 [{
		 layout: {type: 'hbox'},
		 defaults: {margins: '0 3'},
		 flex: 1,
		 items: [{
			 xtype: 'label',
			 text: '<?=_('Rythme cardiaque fœtal')?>'
		     },{
			 width: '4em',
			 decimalSeparator: '.',
			 //NOTE: This concept name matches what is used on labor and delivery form
			 <?= genExtWidget('laborFetalHeartRate', 'numberfield', 0); ?>
		     },{
			 xtype: 'label',
			 text: '/<?=_('min')?>'
		     }]
	     },{
		 layout: {type: 'hbox'},
		 defaults: {margins: '0 3'},
		 flex: 1,
		 items: [{
			 xtype: 'label',
			 text: '<?=_('Hauteur utérine')?>'
		     },{
			 width: '4em',
			 decimalSeparator: '.',
			 //NOTE: This concept name matches what is used on labor and delivery form
			 <?= genExtWidget('laborUterine', 'numberfield', 0); ?>
		     },{
			 xtype: 'label',
			 text: '<?=_('cm')?>'
		     }]
	     },{
		 layout: {type: 'hbox'},
		 defaults: {margins: '0 3'},
		 flex: 1,
		 items: [{
			 xtype: 'label',
			 text: '<?=_('Œdème')?>'
		     },{
			 boxLabel: '<?=_('Oui')?>',
			 <?= genExtWidget('examObOedeme','radio',1); ?>
		     },{
			 boxLabel: '<?=_('Non')?>',
			 <?= genExtWidget('examObOedeme','radio',2); ?>
		     }]
	     }],
	 [{
		 layout: {type: 'hbox'},
		 defaults: {margins: '0 3'},
		 flex: 2,
		 items: [{
			 xtype: 'label',
			 text: '<?=_('Présentation')?> :'
		     },{
			 boxLabel: '<?=_('Céphalique')?> (C)',
			 //NOTE: This concept name matches what is used on labor and delivery form
			 <?= genExtWidget('laborPresentation', 'radio', 1); ?>
		     },{
			 boxLabel: '<?=_('Siège')?> (S)',
			 //NOTE: This concept name matches what is used on labor and delivery form
			 <?= genExtWidget('laborPresentation', 'radio', 2); ?>
		     },{
			 boxLabel: '<?=_('Transversale')?> (T)',
			 //NOTE: This concept name matches what is used on labor and delivery form
			 <?= genExtWidget('laborPresentation', 'radio', 4); ?>
		     }]
	     },{
		 layout: {type: 'hbox'},
		 defaults: {margins: '0 3'},
		 flex: 1,
		 items: [{
			 xtype: 'label',
			 text: '<?=_('Position')?>'
		     },{
			 boxLabel: 'D',
			 <?= genExtWidget('examObPosition','radio',1); ?>
		     },{
			 boxLabel: 'G',
			 <?= genExtWidget('examObPosition','radio',2); ?>
		     }]
	     },{
		 layout: {type: 'hbox'},
		 defaults: {margins: '0 3'},
		 flex: 1,
		 items: [{
			 xtype: 'label',
			 text: '<?=_('Contraction utérine')?>'
		     },{
			 boxLabel: '<?=_('Oui')?>',
			 <?= genExtWidget('examObContraction','radio',1); ?>
		     },{
			 boxLabel: '<?=_('Non')?>',
			 <?= genExtWidget('examObContraction','radio',2); ?>
		     }]
	     }]
	 ];
    var physicalExamFooter = physicalExamFooterObgynRows.map(function(row) {
	    return {
		xtype: 'fieldset',
		border: false,
		layout: {
		    type: 'hbox',
		    pack: 'start',
		    align: 'middle'
		},
		height: 25,
		style: {
		    marginTop: '0.75em'
		},
		defaults: {
		    border: false,
		    autoHeight: true
		},
		items: row
	    };
	});
} else {
    var examDescriptionTextAreaHeight = '17em';
    var physicalExamFooter = {xtype:'label', text:''};
}

var physicalExamPanel = new Ext.FormPanel({
	title: '<?=_('EXAMEN PHYSIQUE')?>',
	id: 'physicalExam',
	border: false,
	autoHeight: true,
	autoScroll: true,
	padding: 8,
	defaults: {layout: 'form'},
	items: [{
<? 
if ($isFollowupEncounter) { echo "
		boxLabel: '" . _('Non effectue') . "'," .
		genExtWidget('nonEffectuePhysicalExam', 'checkbox', 1) . 
       "},{";                   
} 
?>
		xtype: 'panel',
		layout: {type: 'hbox'},
		border: false,
		items: [{
			xtype: 'panel',
			border: false,
			autoHeight: true,
			autoWidth: true,
			layout: {type: 'table', columns: 4},
			items: examListItems
		},{
			xtype: 'panel',
			border: false,
			padding: '0 8',
			layout: {type: 'table', columns: 1},
			items: [
				{xtype:'label', text:'<?= _('Description des conclusions anormales') ?>'},
				{width: 450, height: examDescriptionTextAreaHeight, <?= genExtWidget('otherExamComment123', 'textarea', 0) ?>} 
			]
		}]
	}].concat(physicalExamFooter)
});
