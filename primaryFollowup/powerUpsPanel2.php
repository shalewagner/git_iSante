<?
echo "
var vaccineTableData = [
	[{xtype: 'label', text: '" . _('BCG') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('bcgDt1','datefield',0) . "}],[{" . genExtWidget('bcgDose','textfield',0) . "},{}]],
	[{xtype: 'label', text: '" . _('Hépatite B') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('hepbDtD1','datefield',0) . "}],[{" . genExtWidget('hepbDose','textfield',0) . "},{}]],
	[{xtype: 'label', text: '" . _('Polio') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('polioDtD1','datefield',0) . "}],[{" . genExtWidget('polioDose','textfield',0) . "},{}]],
	[{xtype: 'label', text: '" . _('DTPer') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('dtperDtD1','datefield',0) . "}],[{" . genExtWidget('dtperDose','textfield',0) . "},{}]],
	[{xtype: 'label', text: '" . _('HIB') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('hibDtD1','datefield',0) . "}],[{" . genExtWidget('hibDose','textfield',0) . "},{}]],
	[{xtype: 'label', text: '" . _('Pentavalent') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('pentavDtD1','datefield',0) . "}],[{" . genExtWidget('pentavDose','textfield',0) . "},{}]],
	[{xtype: 'label', text: '" . _('Pneumocoque') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('pneumocoqueDtD1','datefield',0) . "}],[{" . genExtWidget('pneumocoqueDose','textfield',0) . "},{}]],
	[{xtype: 'label', text: '" . _('Rotavirus') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('rotavirusDtD1','datefield',0) . "}],[{" . genExtWidget('rotavirusDose','textfield',0) . "},{}]],
	[{xtype: 'label', text: '" . _('RR') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('rrDtD1','datefield',0) . "}],[{" . genExtWidget('rrDose','textfield',0) . "},{}]],
	[{xtype: 'label', text: '" . _('ROR') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('rorDtD1','datefield',0) . "}],[{" . genExtWidget('rorDose','textfield',0) . "},{}]],
	[{xtype: 'label', text: '" . _('DT') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('dtDtD1','datefield',0) . "}],[{" . genExtWidget('dtDose','textfield',0) . "},{}]],	
	[{xtype: 'label', text: '" . _('Varicelle') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('varicelDtD1','datefield',0) . "}],[{" . genExtWidget('varicelDose','textfield',0) . "},{}]],
	
	[{xtype: 'label', text: '" . _('Typhimvi') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('typhimviDtD1','datefield',0) . "}],[{" . genExtWidget('typhimviDose','textfield',0) . "},{}]],
	[{xtype: 'label', text: '" . _('Meningo AC') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('menengoAcDtD1','datefield',0) . "}],[{" . genExtWidget('menengoAcDose','textfield',0) . "},{}]],
	[{xtype: 'label', text: '" . _('Hepatite A') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('hepatiteADtD1','datefield',0) . "}],[{" . genExtWidget('hepatiteADose','textfield',0) . "},{}]],	
	[{xtype: 'label', text: '" . _('Cholera') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('choleraDtD1','datefield',0) . "}],[{" . genExtWidget('choleraDose','textfield',0) . "},{}]],
	
	[{xtype: 'label', text: '" . _('Covid 19 Oxford-AstraZeneca') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('covid_astrazenecaDt','datefield',0) . "}],[{" . genExtWidget('covid_astrazenecaDose','textfield',0) . "},{" . genExtWidget('covid_astrazenecaLot','textfield',0) . "}]],
	[{xtype: 'label', text: '" . _('Covid 19 Moderna') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('covid_modernaDt','datefield',0) . "}],[{" . genExtWidget('covid_modernaDose','textfield',0) . "},{" . genExtWidget('covid_modernaLot','textfield',0) . "}]],
	[{xtype: 'label', text: '" . _('Covid 19 Pfizer-BioNTech') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('covid_pfizer_biontechDt','datefield',0) . "}],[{" . genExtWidget('covid_pfizer_biontechDose','textfield',0) . "},{" . genExtWidget('covid_pfizer_biontechLot','textfield',0) . "}]],
	[{xtype: 'label', text: '" . _('Covid 19 Gamaleya sputnickV') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('covid_gamaleya_sputnickvDt','datefield',0) . "}],[{" . genExtWidget('covid_gamaleya_sputnickvDose','textfield',0) . "},{" . genExtWidget('covid_gamaleya_sputnickvLot','textfield',0) . "}]],
	[{xtype: 'label', text: '" . _('Covid 19 Sinovac Sinopharm') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('covid_sinovac_sinopharmDt','datefield',0) . "}],[{" . genExtWidget('covid_sinovac_sinopharmDose','textfield',0) . "},{" . genExtWidget('covid_sinovac_sinopharmLot','textfield',0) . "}]],	
	[{xtype: 'label', text: '" . _('Covid 19 Johnson&Johnson') . "', ctCls: 'powerUpColumnHeader'},[{" . genExtWidget('covid_johnson_johnsonDt','datefield',0) . "}],[{" . genExtWidget('covid_johnson_johnsonDose','textfield',0) . "},{" . genExtWidget('covid_johnson_johnsonLot','textfield',0) . "}]],	
	
	[{
	xtype: 'fieldset', layout:'column',
	ctCls: 'powerUpColumnHeader',
	border: false,
	items: [
		{xtype: 'label', text: '" . _('Autre') . " : '},
		{" . genExtWidget('vOther1desc','textfield',0) . ", ctCls: 'powerUpOtherInput'}
	]},
	[{" . genExtWidget('vOther1DtD0','datefield',0) . "}],[{" . genExtWidget('vOther1Dose','numberfield',0) . "},{}]]
];  
";

?>

function powerUp2ExtTable(tableTitle, tableData, padding, colCnt) {

	var extDataTableItems = [tableTitle,'<?=_('Date')?>'].map(function(label) {
		return {xtype:'label', text:label, ctCls: 'powerUpHeader'};
	 });
        
	if (colCnt == 4) {
		extDataTableItems = extDataTableItems.concat(['<?=_('Dose')?>'].map(function(label) {
			return {xtype:'label', text:label, ctCls: 'powerUpHeader'};
	 })); 
	 extDataTableItems = extDataTableItems.concat(['<?=_('Lot')?>'].map(function(label) {
			return {xtype:'label', text:label, ctCls: 'powerUpHeader'};
	 })); 

	}

    extDataTableItems = extDataTableItems.concat(tableData.map(function(rowData) {
 	var rowDataExt = [rowData[0]];
	rowDataExt = rowDataExt.concat(rowData[1].map(function(rowItem) {
		    rowItem.width = '10em';
		    return rowItem;
		})); 
	if (colCnt == 4) rowDataExt = rowDataExt.concat(rowData[2].map(function(rowItem) {
		    rowItem.width = '10em';
		    return rowItem;
		}));
	return rowDataExt;
    })); 

    return {
	xtype: 'panel',
	flex: 0,
	border: false,
	autoHeight: true,
	padding: '0 0 0 ' + padding,
	cls: 'powerUp',
        layout: {
            type: 'table',
            columns: colCnt,
            tableAttrs: {
                cls: 'table table-bordered power-up-table'
            }
        },
	items: extDataTableItems
    };
}

var powerUpVaccSupp = new Ext.FormPanel({
	title: '<?=_('VACCINATION')?>',
	id: 'vaccSupp',
	border: false,
	padding: 5,
	autoHeight: true,
	autoWidth: true,
	autoScroll: true,
	items: [{ 
		layout: 'hbox',
		defaults: {
			style: {marginBottom: '0em'}
		},
		items: [
			powerUp2ExtTable('<?=_('Vaccin')?>', vaccineTableData, 0, 4)
		]  
	}
        ]
});
