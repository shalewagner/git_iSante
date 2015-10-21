function obVaccinPanel() {
    var dataTable = [
		     [{xtype:'label', text:'<?=_('Hépatite B')?>', ctCls: 'obVaccineColumnHeader'},
		      [{<?=genExtWidget('hepbDtD1','datefield',0)?>},
                       {<?=genExtWidget('hepbDtD2','datefield',0)?>},
                       {<?=genExtWidget('hepbDtD3','datefield',0)?>},
                       {<?=genExtWidget('hepbDtUnknown','checkbox',0)?>},
                       {<?=genExtWidget('hepbNever','checkbox',0)?>}]
		      ],
		     [{xtype:'label', text:'<?=_('Tétanos Texoïde')?>', ctCls: 'obVaccineColumnHeader'},
		      [{<?=genExtWidget('tetanosDtD1','datefield',0)?>},
                       {<?=genExtWidget('tetanosDtD2','datefield',0)?>},
                       {<?=genExtWidget('tetanosDtD3','datefield',0)?>},
                       {<?=genExtWidget('tetanosDtUnknown','checkbox',0)?>},
                       {<?=genExtWidget('tetanosNever','checkbox',0)?>}]
		      ],
		     [{xtype:'label', text:'<?=_('pneumocoque')?>', ctCls: 'obVaccineColumnHeader'},
		      [{<?=genExtWidget('pneumocoqueDtD1','datefield',0)?>},
                       {<?=genExtWidget('ppneumocoqueDtD2','datefield',0)?>},
                       {<?=genExtWidget('pneumocoqueDtD3','datefield',0)?>},
                       {<?=genExtWidget('pneumocoqueDtUnknown','checkbox',0)?>},
                       {<?=genExtWidget('pneumocoqueNever','checkbox',0)?>}]
		      ],
		     [{
			ctCls: 'obVaccineColumnHeader',
			border: false,
			items: [{xtype: 'label', text: '<?=_('Autre')?> : '},
                                {<?=genExtWidget('otherVaccinText','textfield',0)?>}]
		       },
		      [{<?=genExtWidget('otherVaccinDtD1','datefield',0)?>},
                       {<?=genExtWidget('otherVaccinDtD2','datefield',0)?>},
                       {<?=genExtWidget('otherVaccinDtD3','datefield',0)?>},
                       {<?=genExtWidget('otherVaccinDtUnknown','checkbox',0)?>},
                       {<?=genExtWidget('otherVaccinNever','checkbox',0)?>}]
		      ]
		     ];

    var extDataTableItems = ['<?=_('Type')?>',
			     '<?=_('Date Reçu')?>','<?=_('Date Reçu')?>','<?=_('Date Reçu')?>',
			     '<?=_('Reçu, Date Inconnu')?>','<?=_('Jamais Reçu')?>'].map(function(label) {
				     return {xtype:'label', text:label, ctCls: 'obVaccineHeader'};
				 });
    extDataTableItems = extDataTableItems.concat(dataTable.map(function(rowData) {
		var rowDataExt = [rowData[0]];
		rowDataExt = rowDataExt.concat(rowData[1].map(function(rowItem) {
			    rowItem.width = '10em';
			    return rowItem;
			}));
		return rowDataExt;
	    }));

    var extDataTable = {
	xtype: 'panel',
	border: false,
	autoHeight: true,
	padding: 0,
	cls: 'obVaccins',
	layout: {
	    type: 'table',
	    columns: 6,
	    tableAttrs: {
		style: {
		    width: '100%',
		    //'border-collapse': 'collapse',
		    border: '1px solid black'
		}
	    }
	},
	items: extDataTableItems
    };

    return new Ext.FormPanel({
	        title: '<?=_('VACCINS')?>',
		id: 'obVaccinPanel',
		border: false,
		padding: 5,
		autoHeight: true,
		autoScroll: true,
		defaults: {
		style: {
		    marginBottom: '0em'
			},
		    layout: 'form'
		    },
		items: [extDataTable]
		});
}
