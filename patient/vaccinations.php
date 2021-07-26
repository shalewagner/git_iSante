<? 
loadVaccinations($pid);
echo "
	var powerUpEmptyItem = {xtype:'label', text:'', ctCls: 'powerUpEmpty'};
	var vaccineTableData = [
		[{xtype: 'label', text: '" . _('BCG') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('bcg0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('bcg1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('bcg2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('bcg3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('bcg4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('bcg5','textfield',0) . ", readOnly: true}]],
		[{xtype: 'label', text: '" . _('HÃ©patite B') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('hepb0','textfield',0) . ", readOnly: true}, 
		{" . genExtWidget('hepb1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('hepb2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('hepb3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('hepb4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('hepb5','textfield',0) . ", readOnly: true}]],
		[{xtype: 'label', text: '" . _('Polio') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('polio0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('polio1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('polio2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('polio3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('polio4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('polio5','textfield',0) . ", readOnly: true}]],
		[{xtype: 'label', text: '" . _('DTPer') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('dtper0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('dtper1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('dtper2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('dtper3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('dtper4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('dtper5','textfield',0) . ", readOnly: true}]],
		[{xtype: 'label', text: '" . _('Act Hib') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('hib0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('hib1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('hib2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('hib3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('hib4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('hib5','textfield',0) . ", readOnly: true}]],
		[{xtype: 'label', text: '" . _('Pentavalent') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('penta0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('penta1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('penta2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('penta3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('penta4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('penta5','textfield',0) . ", readOnly: true}]],
		[{xtype: 'label', text: '" . _('Pneumocoque') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('pneumocoque0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('pneumocoque1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('pneumocoque2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('pneumocoque3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('pneumocoque4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('pneumocoque5','textfield',0) . ", readOnly: true}]],
		[{xtype: 'label', text: '" . _('Pneumovax') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('pneumovax0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('pneumovax1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('pneumovax2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('pneumovax3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('pneumovax4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('pneumovax5','textfield',0) . ", readOnly: true}]],
		[{xtype: 'label', text: '" . _('Rotavirus') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('rotavirus0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('rotavirus1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('rotavirus2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('rotavirus3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('rotavirus4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('rotavirus5','textfield',0) . ", readOnly: true}]],
	    [{xtype: 'label', text: '" . _('Rougeole') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('rougeole0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('rougeole1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('rougeole2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('rougeole3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('rougeole4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('rougeole5','textfield',0) . ", readOnly: true}]],
		[{xtype: 'label', text: '" . _('ROR') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('ror0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('ror1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('ror2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('ror3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('ror4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('ror5','textfield',0) . ", readOnly: true}]],		
		[{xtype: 'label', text: '" . _('RR') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('rr0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('rr1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('rr2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('rr3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('rr4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('rr5','textfield',0) . ", readOnly: true}]],		
		[{xtype: 'label', text: '" . _('DT') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('dt0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('dt1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('dt2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('dt3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('dt4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('dt5','textfield',0) . ", readOnly: true}]],		
		[{xtype: 'label', text: '" . _('Tetanos') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('tetanos0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('tetanos1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('tetanos2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('tetanos3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('tetanos4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('tetanos5','textfield',0) . ", readOnly: true}]],
		[{xtype: 'label', text: '" . _('Varicelle') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('varicel0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('varicel1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('varicel2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('varicel3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('varicel4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('varicel5','textfield',0) . ", readOnly: true}]],		
		[{xtype: 'label', text: '" . _('Typhimvi') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('typhimvi0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('typhimvi1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('typhimvi2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('typhimvi3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('typhimvi4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('typhimvi5','textfield',0) . ", readOnly: true}]],
		[{xtype: 'label', text: '" . _('Meningo AC') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('menengoAc0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('menengoAc1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('menengoAc2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('menengoAc3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('menengoAc4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('menengoAc5','textfield',0) . ", readOnly: true}]],
        [{xtype: 'label', text: '" . _('Hepatite A') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('hepatiteA0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('hepatiteA1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('hepatiteA2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('hepatiteA3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('hepatiteA4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('hepatiteA5','textfield',0) . ", readOnly: true}]],          
        [{xtype: 'label', text: '" . _('Cholera') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('cholera0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('cholera1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('cholera2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('cholera3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('cholera4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('cholera5','textfield',0) . ", readOnly: true}]],		
		[{xtype: 'label', text: '" . _('Astrazeneca') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('covid_astrazeneca0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_astrazeneca1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_astrazeneca2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_astrazeneca3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_astrazeneca4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_astrazeneca5','textfield',0) . ", readOnly: true}]],		
		[{xtype: 'label', text: '" . _('Moderna') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('covid_moderna0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_moderna1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_moderna2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_moderna3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_moderna4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_moderna5','textfield',0) . ", readOnly: true}]],		
		[{xtype: 'label', text: '" . _('Pfizer Biontech') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('covid_pfizer_biontech0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_pfizer_biontech1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_pfizer_biontech2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_pfizer_biontech3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_pfizer_biontech4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_pfizer_biontech5','textfield',0) . ", readOnly: true}]],		
		[{xtype: 'label', text: '" . _('Gamaleya Sputnickv') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('covid_gamaleya_sputnickv0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_gamaleya_sputnickv1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_gamaleya_sputnickv2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_gamaleya_sputnickv3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_gamaleya_sputnickv4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_gamaleya_sputnickv5','textfield',0) . ", readOnly: true}]],		
		[{xtype: 'label', text: '" . _('Sinovac/Sinopharm') . "', ctCls: 'powerUpColumnHeader'},
		[{" . genExtWidget('covid_sinovac_sinopharm0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_sinovac_sinopharm1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_sinovac_sinopharm2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_sinovac_sinopharm3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_sinovac_sinopharm4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('covid_sinovac_sinopharm5','textfield',0) . ", readOnly: true}]],
		[{xtype: 'fieldset', layout:'column', 
		ctCls: 'powerUpColumnHeader',
		border: false,
		items: [{" . genExtWidget('vOther1desc','textfield',0) . ", readOnly: true}]}, 
		[{" . genExtWidget('vOther1DtD0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('vOther1DtD1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('vOther1DtD2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('vOther1DtD3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('vOther1DtD4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('vOther1DtD5','textfield',0) . ", readOnly: true}]], 
		[{xtype: 'fieldset', layout:'column',
		ctCls: 'powerUpColumnHeader',
		border: false,
		items: [{" . genExtWidget('vOther2desc','textfield',0) . ", readOnly: true}]},
		[{" . genExtWidget('vOther2DtD0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('vOther2DtD1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('vOther2DtD2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('vOther2DtD3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('vOther2DtD4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('vOther2DtD5','textfield',0) . ", readOnly: true}]], 
		[{xtype: 'fieldset', layout:'column',
		ctCls: 'powerUpColumnHeader',
		border: false,
		items: [{" . genExtWidget('vOther3desc','textfield',0) . ", readOnly: true}]},
		[{" . genExtWidget('vOther3DtD0','textfield',0) . ", readOnly: true},
		{" . genExtWidget('vOther3DtD1','textfield',0) . ", readOnly: true},
		{" . genExtWidget('vOther3DtD2','textfield',0) . ", readOnly: true},
		{" . genExtWidget('vOther3DtD3','textfield',0) . ", readOnly: true},
		{" . genExtWidget('vOther3DtD4','textfield',0) . ", readOnly: true},
		{" . genExtWidget('vOther3DtD5','textfield',0) . ", readOnly: true}]],
		[{xtype: 'fieldset', layout:'column',
		ctCls: 'powerUpColumnHeader',
		border: false,
		items: [{" . genExtWidget('otherdesc0','textfield',0) . ", readOnly: true}]},
		[{" . genExtWidget('other0','textfield',0) . ", readOnly: true},
		powerUpEmptyItem,
		powerUpEmptyItem,
		powerUpEmptyItem,
		powerUpEmptyItem,
		powerUpEmptyItem]],
		[{xtype: 'fieldset', layout:'column',
		ctCls: 'powerUpColumnHeader',
		border: false,
		items: [{" . genExtWidget('otherdesc1','textfield',0) . ", readOnly: true}]},
		[{" . genExtWidget('other1','textfield',0) . ", readOnly: true},
		powerUpEmptyItem,
		powerUpEmptyItem,
		powerUpEmptyItem,
		powerUpEmptyItem,
		powerUpEmptyItem]],
		[{xtype: 'fieldset', layout:'column',
		ctCls: 'powerUpColumnHeader',
		border: false,
		items: [{" . genExtWidget('otherdesc2','textfield',0) . ", readOnly: true}]},
		[{" . genExtWidget('other2','textfield',0) . ", readOnly: true},
		powerUpEmptyItem,
		powerUpEmptyItem,
		powerUpEmptyItem,
		powerUpEmptyItem,
		powerUpEmptyItem]]
	]; 
";
?>
	function powerUpExtTable(tableType) { 
		var sectionTitleText = '<?=_('Vaccination')?>';
		var tableTitleText = '<?=_('Vaccin')?>';
		var dataTable = vaccineTableData; 
		var extDataTableItems = [tableTitleText,
					 '<?=_('Dose 0')?>','<?=_('Dose 1')?>',
					 '<?=_('Dose 2')?>','<?=_('Dose 3')?>',
					 '<?=_('Dose 4')?>','<?=_('Dose 5')?>'].map(function(label) {
					 	return {xtype:'label', text:label, ctCls: 'powerUpHeader'};
					 }); 

		extDataTableItems = extDataTableItems.concat(dataTable.map(function(rowData) {
		 	var rowDataExt = [rowData[0]];
			rowDataExt = rowDataExt.concat(rowData[1].map(function(rowItem) {
				    rowItem.width = '11em';
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
			cls: 'powerUp container-960',
			layout: {
			    type: 'table',
			    columns: columnCount,
			    tableAttrs: {
				cls: 'table table-bordered power-up-table hide-inputs'
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
<? 
function loadVaccinations ($pid) {
    $cnt = array (
	'bcg' => 0,
	'hepb' => 1,
	'polio' => 0,
	'dtper' => 1, 
	'hib' => 1,
	'ror' => 1,
	'rougeole' => 1,
	'dt' => 1,
	'other' => 1,
	'tetanos' => 1,
	'pneumovax' => 1,
	'penta' => 1,
	'hx' => 1,
	'rr' => 1,
	'rotavirus'=>1,
	'varicel'=>1,
	'typhimvi'=>1,
	'pneumocoque'=>1,
	'hepatiteA'=>1,
	'menengoAc'=>1,
	'cholera'=>1,
	'cholera'=>1,
	'cholera'=>1,
	'cholera'=>1,
	'cholera'=>1,
	'covid_astrazeneca'=>1,
	'covid_moderna'=>1,
	'covid_pfizer_biontech'=>1,
	'covid_gamaleya_sputnickv'=>1,
	'covid_sinovac_sinopharm'=>1
    );
    $qry = "(select distinct 'immunization' as 'vtype', case
		when immunizationID = 1 then 'bcg'
		when immunizationID = 2 then 'hepb'
		when immunizationID = 3 then 'polio'
		when immunizationID = 4 then 'dtper' 
		when immunizationID = 5 then 'hib'
		when immunizationID = 6 then 'ror'
                when immunizationID = 7 then 'rougeole'
		when immunizationID = 20 then 'penta'
		when immunizationID = 21 then 'rr'
		when immunizationID = 8 then 'dt'
		when immunizationID = 9 then 'other'
		when immunizationID = 10 then 'tetanos'
		when immunizationID = 13 then 'rotavirus'
		when immunizationID = 14 then 'pneumocoque'
		when immunizationID = 15 then 'varicel'
		when immunizationID = 16 then 'typhimvi'
		when immunizationID = 17 then 'menengoAc'
		when immunizationID = 18 then 'hepatiteA'
		when immunizationID = 19 then 'cholera'		
		when immunizationID = 12 then 'hx' else 'other' end as 'icode', ymdToDate(immunizationYy,immunizationMm,immunizationDd) as 'idate', immunizationComment 
		from immunizations 
		where patientid = '" . $pid . "' and isdate(ymdToDate(immunizationYy,immunizationMm,immunizationDd)) = 1
	) union
	(select distinct 'concept', case
		when short_name like 'bcgDt%' then 'bcg' 
		when short_name like 'hepbDt%' then 'hepb'
		when short_name like 'polioDt%' then 'polio'
		when short_name like 'dtperDt%' then 'dtper'
		when short_name like 'rougeoleDt%' then 'rougeole' 
		when short_name like 'dtDt%' then 'dt'
		when short_name like 'tetanosDt%' then 'tetanos'
		when short_name like 'pnuemovaxDt%' or short_name like 'pneumovax_Dt' then 'pneumovax'
		when short_name like 'rrDt%' then 'rr'
		when short_name like 'actHib%' then 'hib'
		when short_name like 'pentavDt%' then 'penta'
		when short_name like 'rotavirusDt%' then 'rotavirus' 
		when short_name like 'pneumocoqueDt%' then 'pneumocoque' 
		when short_name like 'varicelDt%' then 'varicel' 
		when short_name like 'typhimviDt%' then 'typhimvi' 
		when short_name like 'menengoACDt%' then 'menengoAc' 
		when short_name like 'hepatiteADt%' then 'hepatiteA' 
		when short_name like 'choleraDt%' then 'cholera'
        when short_name like 'covid_astrazenecaDt%' then 'covid_astrazeneca'
        when short_name like 'covid_modernaDt%' then 'covid_moderna'
        when short_name like 'covid_pfizer_biontechDt%' then 'covid_pfizer_biontech'
        when short_name like 'covid_gamaleya_sputnickvDt%' then 'covid_gamaleya_sputnickv'		
        when short_name like 'covid_sinovac_sinopharmDt%' then 'covid_sinovac_sinopharm'
        when short_name like 'rorD%' then 'ror'		 
		else 'xxxx' end, value_datetime, '' 
		from obs o, concept c 
		where concat(location_id, person_id) = '" . $pid . "' and o.concept_id = c.concept_id and value_datetime is not null and (
		c.short_name like 'bcgDt%' or c.short_name like 'hepbDt%' or c.short_name like 'polioDt%' or c.short_name like 'dtperDt%' or 
		c.short_name like 'rougeoleDt%' or c.short_name like 'rrDt%' or c.short_name like 'dtDt%' or short_name like 'tetanosDt%' or 
		short_name like 'pnuemovaxDt%' or short_name like 'pneumovax_Dt%' or short_name like 'actHibDt%' or short_name like 'pentavDt%' or
		short_name like 'rotavirusDt%'  or short_name like 'pneumocoqueDt%'  or short_name like 'varicelDt%'  or short_name like 'typhimviDt%' or
		short_name like 'menengoACDt%'  or short_name like 'hepatiteADt%'  or short_name like 'choleraDt%' or short_name like 'rorD%' or 
		short_name like 'covid_astrazenecaDt%' or short_name like 'covid_modernaDt%'  or
        short_name like 'covid_pfizer_biontechDt%' or short_name like 'covid_gamaleya_sputnickvDt%' or		
        short_name like 'covid_sinovac_sinopharmDt%')
	) union
	(select distinct 'otherconcept', a.short_name, oa.value_datetime, ob.value_text 
		from concept a, concept b, obs oa, obs ob 
		where concat(oa.location_id,oa.person_id) = '" . $pid . "' and concat(ob.location_id,ob.person_id) = '" . $pid . "' and 
		a.concept_id = oa.concept_id and b.concept_id = ob.concept_id and 
		a.short_name like 'vOther_DtD%' and b.short_name like 'vOther_desc' and 
		substring(a.short_name,7,1) = substring(b.short_name,7,1) 
	) union
	(select distinct 'other', 'other', ymdToDate(immunizationYy,immunizationMm,immunizationDd), immunizationName 
		from otherImmunizations where patientid = '" . $pid . "' and isdate(ymdToDate(immunizationYy,immunizationMm,immunizationDd)) = 1
	) order by 2,3"; 
	//echo $qry;
	$result = databaseSelect()->query($qry)->fetchAll(PDO::FETCH_ASSOC);
	//print_r($result);
	//exit;
	foreach ($result as $row) {
		$vtype = $row['vtype'];
		$icode = $row['icode']; 
		$idateArray = explode('-', substr($row['idate'],0,10));
		$idate = $idateArray[2] . '/' . $idateArray[1] . '/' . $idateArray[0];
		if ($vtype == 'otherconcept') $GLOBALS['existingData'][$icode] = $idate;
		else $GLOBALS['existingData'][$icode . $cnt[$icode]] = $idate;
		if ($icode == 'other' && ($vtype == 'immunization' || $vtype == 'other')) $GLOBALS['existingData'][$icode . 'desc' . $cnt[$icode]] = $row['immunizationComment'];
		if ($vtype == 'otherconcept') $GLOBALS['existingData']['vOther' . substr($icode,6,1) . 'desc'] = $row['immunizationComment']; 
		if ($vtype != 'otherconcept') $cnt[$icode]++; 
	} 
}   
?>
