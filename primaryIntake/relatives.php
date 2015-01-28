<?php

function relativesMakeMultiSelection($concept, $label) {
  if (isset($label)) {
    $checkWidgetM = genExtWidget($concept."_mother", 'checkbox', 1);
    $checkWidgetF = genExtWidget($concept."_father", 'checkbox', 1);
    $checkWidgetBS = genExtWidget($concept."_bs", 'checkbox', 1);
    return "
    {
        html: '$label'
    },{
        ctCls: 'relativesPanel',
        $checkWidgetM
    },{
        ctCls: 'relativesPanel',
        $checkWidgetF
    },{
        ctCls: 'relativesPanel',
        $checkWidgetBS
    }";
  } else {
    if ($concept == 'dummy') {
	return "
	    {
	        colspan: 4,
	        html: '&nbsp;'
	    }";
    } else {
    	$specifyWidget = genExtWidget($concept, 'textfield', 0);
    	return "
	   {
	       colspan: 4,
	       width: 150,
	       $specifyWidget
	   }"; 
    }
  }
}  

$relativesAll = array(
    'rel_asthme' => _('Asthme'),
    'rel_diabete' => _('Diabète'),
    'rel_cancer' => _('Cancer, précisez') . ':',
    'rel_epilepsie' => _('Epilepsie'),
    'rel_cancer_specify' => null,
    'rel_hta' => _('HTA'),
    'rel_cardiopathie' => _('Cardiopathie'),
    'rel_pulmTBActive' => _('Tuberculose'),
    'dummy' => null,
    'rel_mdrtb' => 'MDR TB' 

);

$relativesItemsEXT = array(); // output
foreach ($relativesAll as $concept => $description) {
  $relativesItemsEXT[] = relativesMakeMultiSelection($concept, $description);
}  
?>

buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('rel_cancer_specify0'),
				      makeTestAnyIsChecked('rel_cancer_mother1',
							   'rel_cancer_father1',
							   'rel_cancer_bs1')));

var relativesPanel = new Ext.FormPanel({
    title: '<?=_("ANTECEDENTS HEREDO-COLLATERAUX")?>',
    id: 'relatives',
    autoHeight: true, autoScroll: true,
    border: false,
    defaults: {
	    style: {
		marginBottom: '0em'
	    },
	    layout: 'form'
	},
    items: [{
		padding: 8,
		border: false,
		defaults: {border: false},
		items: [{
			layout: {
			    type: 'hbox'
			},
			defaults: {
			    margins: '3 25'
			},
			items: [{
				boxLabel: '<?=_('Aucune')?>',
				<?= genExtWidget('aucuneRelatives', 'radio', 1) ?>
			    },{
				boxLabel: '<?=_('Inconnu')?>',
				<?= genExtWidget('aucuneRelatives', 'radio', 2) ?> 
		    	}]
		},{
			layout: {type: 'table', columns: 8},
			defaults: {border: false},
			style: {marginBottom: '1em'},
			items: [{
				width: '25ex', html: ''
			    },{
				ctCls: 'relativesPanel',
				width: '6ex', html: '<?=_('Mère')?>'
			    },{
				ctCls: 'relativesPanel',
				width: '6ex', html: '<?=_('Père')?>'
			    },{
				ctCls: 'relativesPanel',
				width: '12ex', html: '<?=_('Frère/Sœur')?>'
			    },{
				width: '25ex', html: ''
			    },{
				ctCls: 'relativesPanel',
				width: '6ex', html: '<?=_('Mère')?>'
			    },{
				ctCls: 'relativesPanel',
				width: '6ex', html: '<?=_('Père')?>'
			    },{
				ctCls: 'relativesPanel',
				width: '12ex', html: '<?=_('Frère/Sœur')?>'
			    },<?=implode(",\n", $relativesItemsEXT)?>]
		    },{
			fieldLabel: '<?=_("Autres")?>',
			width: 500, 
			<?=genExtWidget('other_relative', 'textfield', 0)?>
		    }]
	    }]      
    }); 


