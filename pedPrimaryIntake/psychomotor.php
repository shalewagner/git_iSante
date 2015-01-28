

var psychomotorPanel = new Ext.FormPanel({
    title: '<?=_('EVALUATION DU DEVELOPPEMENT PSYCHOMOTEUR')?>',
    id: 'psychomotor',
    autoHeight: true,
    border: false,
    padding: 5,
    items: [{
		border: false,
		layout: {
		    type: 'table',
		    columns: 4
		},
		items: transposeExtTableItems([{
			xtype: 'label',
			text: '<?=('Motricité Globale')?>',
			ctCls: 'psychomotorHeader'
		    },{
			boxLabel: '<?=_('Développement normal pour âge')?>',
			<?= genExtWidget('psychomotorGrossMotor', 'radio', 1); ?>
		    },{
			boxLabel: '<?=_('Retard du développement')?>',
			<?= genExtWidget('psychomotorGrossMotor', 'radio', 2); ?>
		    },{
			xtype: 'label',
			text: '<?=('Motricité Fine')?>',
			ctCls: 'psychomotorHeader'
		    },{
			boxLabel: '<?=_('Développement normal pour âge')?>',
			<?= genExtWidget('psychomotorFineMotor', 'radio', 1); ?>
		    },{
			boxLabel: '<?=_('Retard du Développement')?>',
			<?= genExtWidget('psychomotorFineMotor', 'radio', 2); ?>
		    },{
			xtype: 'label',
			text: '<?=('Langage/Compréhension')?>',
			ctCls: 'psychomotorHeader'
		    },{
			boxLabel: '<?=_('Développement normal pour âge')?>',
			<?= genExtWidget('psychomotorLanguageComprehension', 'radio', 1); ?>
		    },{
			boxLabel: '<?=_('Retard du Développement')?>',
			<?= genExtWidget('psychomotorLanguageComprehension', 'radio', 2); ?>
		    },{
			xtype: 'label',
			text: '<?=('Contact Social')?>',
			ctCls: 'psychomotorHeader'
		    },{
			boxLabel: '<?=_('Développement normal pour âge')?>',
			<?= genExtWidget('psychomotorSocialContact', 'radio', 1); ?>
		    },{
			boxLabel: '<?=_('Retard du Développement')?>',
			<?= genExtWidget('psychomotorSocialContact', 'radio', 2); ?>
		    }], 4, {xtype: 'label', text: ''})
	    }]
    });
