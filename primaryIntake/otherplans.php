
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('antenatalVisit0'),
                                      makeTestAnyIsChecked('suiviPrenatal0', 'dispensationARV0',
							   'educationInd0', 'educationBddy0',
							   'homeVisit0', 'groupSupport0', 'breastfeeding0')));

buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('birthHospitalName0'),
                                      makeTestAnyIsChecked('birthPlace1')));
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('birthPlanHIVPrevention0'),
                                      makeTestAnyIsChecked('HIVBabyPreventionPlan1')));
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('residentialPlanMatronName0'),
                                      makeTestAnyIsChecked('residentialPlanMatron1')));

var otherplansPanel = new Ext.Panel({
	title: '<?=_('AUTRE PLAN')?>',
	id: 'otherplans',
	border: false,
        autoHeight: true,
        padding: 5,
	defaults: {
            style: {
                marginBottom: '1em'
            },
            layout: 'form'
        },
	items: [{
		width: '80em',
		height: '8em',
		<?= genExtWidget('otherPlan1','textarea',0); ?>
	    <?php if ($isObgynEncounter) { ?>
	    },{
		xtype: 'fieldset',
		title: '<?=_('Plan de d’accouchement')?>',
		padding: 5,
		items: [{
      border: false,
      layout: {type: 'hbox'},
      defaults: {margins: '0 3'},
      items: [{
        xtype: 'label',
        forId: 'antenatalVisit0',
				text: '<?=_('Date de prochaine visite : ')?>'
      },{
        width: 90,
        <?= genExtWidget('antenatalVisit', 'datefield', 0); ?>
      }]
    },{
			border: false,
			layout: {
				type: 'table',
				columns: 7
			},
			items: transposeExtTableItems([{
				    xtype: 'label',
				    ctCls: 'birthPlanAlign birthPlanCenter',
				    forId: 'suiviPrenatal0',
				    text: '<?=_('Suivi Prénatal')?>'
				},{
				    ctCls: 'birthPlanCenter',
				    <?= genExtWidget ('suiviPrenatal', 'checkbox', 0); ?>
				},{
				    xtype: 'label',
				    ctCls: 'birthPlanAlign birthPlanCenter',
				    forId: 'dispensationARV0',
				    text: '<?=_('Dispensation ARV')?>'
				},{
				    ctCls: 'birthPlanCenter',
				    <?= genExtWidget ('dispensationARV', 'checkbox', 0); ?>
				},{
				    xtype: 'label',
				    ctCls: 'birthPlanAlign birthPlanCenter',
				    forId: 'educationInd0',
				    html: '<?=_('Education<br> Individuelle')?>'
				},{
				    ctCls: 'birthPlanCenter',
				    <?= genExtWidget ('educationInd', 'checkbox', 0); ?>
				},{
				    xtype: 'label',
				    ctCls: 'birthPlanAlign birthPlanCenter',
				    forId: 'educationBddy0',
				    html: '<?=_('Education des<br> Accompagnateurs')?>'
				},{
				    ctCls: 'birthPlanCenter',
				    <?= genExtWidget ('educationBddy', 'checkbox', 0); ?>
				},{
				    xtype: 'label',
				    ctCls: 'birthPlanAlign birthPlanCenter',
				    forId: 'homeVisit0',
				    html: '<?=_('Visite<br> Domiciliaire')?>'
				},{
				    ctCls: 'birthPlanCenter',
				    <?= genExtWidget ('homeVisit', 'checkbox', 0); ?>
				},{
				    xtype: 'label',
				    ctCls: 'birthPlanAlign birthPlanCenter',
				    forId: 'groupSupport0',
				    html: '<?=_('Club des Mères')?> /<br><?=_('Groupe de Support')?>'
				},{
				    ctCls: 'birthPlanCenter',
				    <?= genExtWidget ('groupSupport', 'checkbox', 0); ?>
				},{
				    xtype: 'label',
				    ctCls: 'birthPlanAlign birthPlanCenter',
				    forId: 'breastfeeding0',
				    html: '<?=_('Conseils sur')?><br><?=_('l’allaitement maternel')?>'
				},{
				    ctCls: 'birthPlanCenter',
				    <?= genExtWidget ('breastfeeding', 'checkbox', 0); ?>
				}], 7, {})
			}]
	   },{
		xtype: 'fieldset',
		title: '',
		padding: 5,
		items: [{
			layout: 'hbox',
			border: false,
			defaults: {margins: '4 3'},
			items: [{
				xtype: 'label',
				text: '<?=_('Date Probable d’accouchement')?>'
			    },{
				width: '10em',
				<?= genExtWidget('probableBirth', 'datefield', 0); ?>
			    },{
				xtype: 'spacer', height: '1em', width: '8em'
			    },{
				xtype: 'label',
				text: '<?=_('Lieu')?> :'
			    },{
				boxLabel: '<?=_('Domicile')?>',
				<?= genExtWidget ('birthPlace', 'radio', 2); ?>
			    },{
				boxLabel: '<?=_('Hôpital, précisez')?> :',
				<?= genExtWidget ('birthPlace', 'radio', 1); ?>
			    },{
				<?= genExtWidget ('birthHospitalName', 'textfield', 0); ?>
			    }]
		    },{
			layout: 'hbox',
			border: false,
			defaults: {margins: '4 3'},
			items: [{
				xtype: 'label',
				text: '<?=_('Si domicile et femme VIH positif : est-ce qu’il y a une planification faite pour la prophylaxie ARV de l’enfant')?> :'
			    },{
				boxLabel: '<?=_('Oui')?>',
				<?= genExtWidget ('HIVBabyPreventionPlan', 'radio', 1); ?>
			    },{
				boxLabel: '<?=_('Non')?>',
				<?= genExtWidget ('HIVBabyPreventionPlan', 'radio', 2); ?>
			    }]
		    },{
			layout: 'hbox',
			border: false,
			defaults: {margins: '4 3'},
			items: [{
				xtype: 'label',
				text: '<?=_('Si oui, précisez')?> :'
			    },{
				width: '50em',
				<?= genExtWidget ('birthPlanHIVPrevention', 'textfield', 0); ?>
			    }]
		    },{
			layout: 'hbox',
			border: false,
			defaults: {margins: '4 3'},
			items: [{
				xtype: 'label',
				text: '<?=_('Si domicile : Planification pour la présence d’une matrone')?> :'
			    },{
				boxLabel: '<?=_('Oui')?>',
				<?= genExtWidget ('residentialPlanMatron', 'radio', 1); ?>
			    },{
				boxLabel: '<?=_('Non')?>',
				<?= genExtWidget ('residentialPlanMatron', 'radio', 2); ?>
			    }]
		    },{
			layout: 'hbox',
			border: false,
			defaults: {margins: '4 3'},
			items: [{
				xtype: 'label',
				text: '<?=_('Si oui, nom de la matrone')?> :'
			    },{
				width: '25em',
				<?= genExtWidget ('residentialPlanMatronName', 'textfield', 0); ?>
			    }]
		    },{
			layout: 'hbox',
			border: false,
			defaults: {margins: '4 3'},
			items: [{
				xtype: 'label',
				text: '<?=_('Planification pour un Accompagnateur')?> :'
			    },{
				boxLabel: '<?=_('Oui')?>',
				<?= genExtWidget ('BddyPresent', 'radio', 1); ?>
			    },{
				boxLabel: '<?=_('Non')?>',
				<?= genExtWidget ('BddyPresent', 'radio', 2); ?>
			    }]
		    },{
			layout: 'hbox',
			border: false,
			defaults: {margins: '4 3'},
			items: [{
				xtype: 'label',
				text: '<?=_('Planification pour transition dans une Maison de Naissance')?> :'
			    },{
				boxLabel: '<?=_('Oui')?>',
				<?= genExtWidget ('birthTransitionPlan', 'radio', 1); ?>
			    },{
				boxLabel: '<?=_('Non')?>',
				<?= genExtWidget ('birthTransitionPlan', 'radio', 2); ?>
			    }]
		    },{
			layout: 'hbox',
			border: false,
			defaults: {margins: '4 3'},
			items: [{
				xtype: 'label',
				text: '<?=_('Inscrite dans un Club des Mères')?> :'
			    },{
				boxLabel: '<?=_('Oui')?>',
				<?= genExtWidget ('motherClub', 'radio', 1); ?>
			    },{
				boxLabel: '<?=_('Non')?>',
				<?= genExtWidget ('motherClub', 'radio', 2); ?>
			    }]
		    }]
	    <?php } ?>
	    },{
		layout: {type: 'hbox'},
		defaults: {margins: '0 3'},
		border: false,
		items: [{
			xtype: 'label',
			text: '<?= _('Date de Prochaine Visite') ?> : '
		    },{
			format: 'd/m/y',
			width: 100,
			id: 'nxtVisitD2',
			name: 'nxtVisitD2',
			xtype: 'datefield',
			value: '<? echo $nxtDate; ?>'
		    },{
			xtype: 'label', 	
			text: '<?= _('(jj/mm/aa)') ?>'
		    }]   
	    },{
		layout: {type: 'hbox'},
		defaults: {margins: '0 3'},
		border: false,
		items: [{
			xtype: 'label',
			text: '<?= _('Nom et Prénom 1') ?>'
		    },{
			width: 200,
			<?= genExtWidget('formAuthor2','textfield',0); ?>
		    },{
			xtype: 'spacer', height: 25, width: '4ex'
		    },{
			xtype: 'label',
			text: '<?= _('Nom et Prénom 2') ?>'
		    },{
			width: 200,
			<?= genExtWidget('formAuthor3','textfield',0); ?>
		    }]
	    },{
		layout: {type: 'hbox'},
		defaults: {margins: '0 3'},
		border: false,
		items: [{
			xtype: 'label',
			text: '<?= _('Nom et Prénom 3') ?>'
		    },{
			width: 200,
			<?= genExtWidget('formAuthor4','textfield',0); ?>
		    }]
	    }]
});
