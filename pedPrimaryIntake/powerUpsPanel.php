
var powerUpEmptyItem = {xtype:'label', text:'', ctCls: 'powerUpEmpty'};
<?
echo "
	var vaccineTableData = [
		[{xtype: 'label', text: '" . _('BCG') . "', ctCls: 'powerUpColumnHeader'},
		[powerUpEmptyItem,
		{" . genExtWidget('bcgDt1','datefield',0) . "},
		powerUpEmptyItem,
		powerUpEmptyItem,
		powerUpEmptyItem,
		powerUpEmptyItem]],
		[{xtype: 'label', text: '" . _('Polio') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('polioDtD0','datefield',0) . "},
		{" . genExtWidget('polioDtD1','datefield',0) . "},
		{" . genExtWidget('polioDtD2','datefield',0) . "},
		{" . genExtWidget('polioDtD3','datefield',0) . "},
		{" . genExtWidget('polioDtR1','datefield',0) . "},
		{" . genExtWidget('polioDtR2','datefield',0) . "}]],
		[{xtype: 'label', text: '" . _('DTPer') . "', ctCls: 'powerUpColumnHeader'},
		[powerUpEmptyItem,
		{" . genExtWidget('dtperDtD1','datefield',0) . "},
		{" . genExtWidget('dtperDtD2','datefield',0) . "},
		{" . genExtWidget('dtperDtD3','datefield',0) . "},
		{" . genExtWidget('dtperDtR1','datefield',0) . "},
		{" . genExtWidget('dtperDtR2','datefield',0) . "}]],
		[{xtype: 'label', text: '" . _('Rougeole') . "', ctCls: 'powerUpColumnHeader'},
		[powerUpEmptyItem,
		{" . genExtWidget('rougeoleDtD1','datefield',0) . "},
		{" . genExtWidget('rougeoleDtD2','datefield',0) . "},
		{" . genExtWidget('rougeoleDtD3','datefield',0) . "},
		{" . genExtWidget('rougeoleDtR1','datefield',0) . "},
		{" . genExtWidget('rougeoleDtR2','datefield',0) . "}]],
		[{xtype: 'label', text: '" . _('RR') . "', ctCls: 'powerUpColumnHeader'},
		[powerUpEmptyItem,
		{" . genExtWidget('rrDtD1','datefield',0) . "},
		{" . genExtWidget('rrDtD2','datefield',0) . "},
		{" . genExtWidget('rrDtD3','datefield',0) . "},
		{" . genExtWidget('rrDtR1','datefield',0) . "},
		{" . genExtWidget('rrDtR2','datefield',0) . "}]],
		[{xtype: 'label', text: '" . _('DT') . "', ctCls: 'powerUpColumnHeader'},
		[powerUpEmptyItem,
		{" . genExtWidget('dtDtD1','datefield',0) . "},
		{" . genExtWidget('dtDtD2','datefield',0) . "},
		{" . genExtWidget('dtDtD3','datefield',0) . "},
		{" . genExtWidget('dtDtR1','datefield',0) . "},
		{" . genExtWidget('dtDtR2','datefield',0) . "}]],
		[{xtype: 'label', text: '" . _('Hépatite B') . "', ctCls: 'powerUpColumnHeader'},
		[powerUpEmptyItem,
		{" . genExtWidget('hepbDtD1','datefield',0) . "},
		{" . genExtWidget('hepbDtD2','datefield',0) . "},
		{" . genExtWidget('hepbDtD3','datefield',0) . "},
		{" . genExtWidget('hepbDtR1','datefield',0) . "},
		{" . genExtWidget('hepbDtR2','datefield',0) . "}]],
		[{xtype: 'label', text: '" . _('Act Hib') . "', ctCls: 'powerUpColumnHeader'},
		[powerUpEmptyItem,
		{" . genExtWidget('actHibDtD1','datefield',0) . "},
		{" . genExtWidget('actHibDtD2','datefield',0) . "},
		{" . genExtWidget('actHibDtD3','datefield',0) . "},
		{" . genExtWidget('actHibDtR1','datefield',0) . "},
		{" . genExtWidget('actHibDtR2','datefield',0) . "}]],
		[{xtype: 'label', text: '" . _('Pentavalent(Mspp)') . "', ctCls: 'powerUpColumnHeader'},
		[powerUpEmptyItem,
		{" . genExtWidget('pentavDtD1','datefield',0) . "},
		{" . genExtWidget('pentavDtD2','datefield',0) . "},
		{" . genExtWidget('pentavDtD3','datefield',0) . "},
		{" . genExtWidget('pentavDtR1','datefield',0) . "},
		{" . genExtWidget('pentavDtR2','datefield',0) . "}]],
		[{xtype: 'fieldset', layout:'column',
		ctCls: 'powerUpColumnHeader',
		border: false,
		items: [{xtype: 'label', text: '" . _('Autre') . " : '},
		{" . genExtWidget('vOther1desc','textfield',0) . ", ctCls: 'powerUpOtherInput'}]},
		[powerUpEmptyItem,
		{" . genExtWidget('vOther1DtD1','datefield',0) . "},
		{" . genExtWidget('vOther1DtD2','datefield',0) . "},
		{" . genExtWidget('vOther1DtD3','datefield',0) . "},
		{" . genExtWidget('vOther1DtD4','datefield',0) . "},
		{" . genExtWidget('vOther1DtD5','datefield',0) . "}]], 
		[{xtype: 'fieldset', layout:'column',
		ctCls: 'powerUpColumnHeader',
		border: false,
		items: [{xtype: 'label', text: '" . _('Autre') . " : '},
		{" . genExtWidget('vOther2desc','textfield',0) . ", ctCls: 'powerUpOtherInput'}]},
		[powerUpEmptyItem,
		{" . genExtWidget('vOther2DtD1','datefield',0) . "},
		{" . genExtWidget('vOther2DtD2','datefield',0) . "},
		{" . genExtWidget('vOther2DtD3','datefield',0) . "},
		{" . genExtWidget('vOther2DtD4','datefield',0) . "},
		{" . genExtWidget('vOther2DtD5','datefield',0) . "}]]
		/*		[{
		xtype: 'fieldset', layout:'column',
		ctCls: 'powerUpColumnHeader',
		border: false,
		items: [{xtype: 'label', text: '" . _('Autre') . " : '},
		{" . genExtWidget('vOther3desc','textfield',0) . ", ctCls: 'powerUpOtherInput'}]},
				[{" . genExtWidget('vOther3DtD0','datefield',0) . "},
				{" . genExtWidget('vOther3DtD1','datefield',0) . "},
				{" . genExtWidget('vOther3DtD2','datefield',0) . "},
				{" . genExtWidget('vOther3DtD3','datefield',0) . "},
				{" . genExtWidget('vOther3DtD4','datefield',0) . "},
				{" . genExtWidget('vOther3DtD5','datefield',0) . "}]] */
	];
	
	var supplementTableData = [
		[{xtype: 'label', text: '" . _('Vitamine A') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('supplementVitA1','datefield',0) . "},
		{" . genExtWidget('supplementVitA2','datefield',0) . "},
		{" . genExtWidget('supplementVitA3','datefield',0) . "},
		{" . genExtWidget('supplementVitA4','datefield',0) . "},
		{" . genExtWidget('supplementVitA5','datefield',0) . "},
		{" . genExtWidget('supplementVitA6','datefield',0) . "},
		{" . genExtWidget('supplementVitA7','datefield',0) . "}]],
		[{xtype: 'label', text: '" . _('Fer.') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('supplementIron1','datefield',0) . "},
		{" . genExtWidget('supplementIron2','datefield',0) . "},
		{" . genExtWidget('supplementIron3','datefield',0) . "},
		{" . genExtWidget('supplementIron4','datefield',0) . "},
		{" . genExtWidget('supplementIron5','datefield',0) . "},
		{" . genExtWidget('supplementIron6','datefield',0) . "},
		{" . genExtWidget('supplementIron7','datefield',0) . "}]],
		[{xtype: 'label', text: '" . _('Iode') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('supplementIodine1','datefield',0) . "},
		{" . genExtWidget('supplementIodine2','datefield',0) . "},
		{" . genExtWidget('supplementIodine3','datefield',0) . "},
		{" . genExtWidget('supplementIodine4','datefield',0) . "},
		{" . genExtWidget('supplementIodine5','datefield',0) . "},
		{" . genExtWidget('supplementIodine6','datefield',0) . "},
		{" . genExtWidget('supplementIodine7','datefield',0) . "}]],
		[{xtype: 'label', text: '" . _('Déparasitage') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('supplementDeworm1','datefield',0) . "},
		{" . genExtWidget('supplementDeworm2','datefield',0) . "},
		{" . genExtWidget('supplementDeworm3','datefield',0) . "},
		{" . genExtWidget('supplementDeworm4','datefield',0) . "},
		{" . genExtWidget('supplementDeworm5','datefield',0) . "},
		{" . genExtWidget('supplementDeworm6','datefield',0) . "},
		{" . genExtWidget('supplementDeworm7','datefield',0) . "}]],
		[{xtype: 'label', text: '" . _('Zinc') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('supplementZinc1','datefield',0) . "},
		{" . genExtWidget('supplementZinc2','datefield',0) . "},
		{" . genExtWidget('supplementZinc3','datefield',0) . "},
		{" . genExtWidget('supplementZinc4','datefield',0) . "},
		{" . genExtWidget('supplementZinc5','datefield',0) . "},
		{" . genExtWidget('supplementZinc6','datefield',0) . "},
		{" . genExtWidget('supplementZinc7','datefield',0) . "}]] 
	];
";
?>

function powerUpExtTable(tableType) { 
	switch (tableType) {
		case 'vaccine':
		var sectionTitleText = '<?=_('VACCINATION')?>';
		var tableTitleText = '<?=_('Vaccin')?>';
		var dataTable = vaccineTableData; 
		var extDataTableItems = [tableTitleText,
					 '<?=_('Dose 0')?>','<?=_('Dose 1')?>',
					 '<?=_('Dose 2')?>','<?=_('Dose 3')?>',
					 '<?=_('Rappel 1')?>','<?=_('Rappel 2')?>'].map(function(label) {
						 return {xtype:'label', text:label, ctCls: 'powerUpHeader'};
					     }); 
		break;
		case 'supplement':
		var sectionTitleText = '<?=_('SUPPLEMENTATION EN VITAMINE A (VIT. A), FER, IODE, ZINC, DEPARASITAGE (DEP.)')?>';
		var tableTitleText = '';
		var dataTable = supplementTableData; 
		var extDataTableItems = [tableTitleText,
					 '<?=_('Date')?>','<?=_('Date')?>',
					 '<?=_('Date')?>','<?=_('Date')?>',
					 '<?=_('Date')?>','<?=_('Date')?>',
					 '<?=_('Date')?>'].map(function(label) {
						 return {xtype:'label', text:label, ctCls: 'powerUpHeader'};
					     });  
		break;
	}

    extDataTableItems = extDataTableItems.concat(dataTable.map(function(rowData) {
	 	var rowDataExt = [rowData[0]];
		rowDataExt = rowDataExt.concat(rowData[1].map(function(rowItem) {
			    rowItem.width = '10em';
			    return rowItem;
			}));
		return rowDataExt;
	    }));

    var columnCount = tableType == 'vaccine' ? 7 : 8;
    var extDataTable = {
	xtype: 'panel',
	border: false,
	autoHeight: true,
	padding: 0,
	cls: 'powerUp',
        layout: {
            type: 'table',
            columns: columnCount,
            tableAttrs: {
                cls: 'table table-bordered power-up-table'
            }
        },
	items: extDataTableItems
    };

    return new Ext.FormPanel({
	        title: sectionTitleText,
		id: tableType,
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
