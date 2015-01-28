<?
$radioLabels = array("Pos","Neg");
function tbMakeRadioSet($concept, $radioLabels) {
	global $tabIndex;
	$output = "{
		xtype: 'fieldset',
		layout: 'column',
		collapsible: false,
		autoHeight: true,
		border: false,
		items: [";
		for ($i = 0; $i < 2; $i++) {
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
echo "
	var tbEvalTableData = [
	[{xtype: 'label', text: '0', ctCls: 'tbEvalColumnHeader'},
	[{" . genExtWidget('tbEvalDt0','datefield',0) . "},
	" . tbMakeRadioSet('tbEvalresult0',$radioLabels) . ",
	{" . genExtWidget('tbEvalweight0','numberfield',0) . "}]],
	[{xtype: 'label', text: '2', ctCls: 'tbEvalColumnHeader'},
	[{" . genExtWidget('tbEvalDt2','datefield',0) . "},
	" . tbMakeRadioSet('tbEvalresult2',$radioLabels) . ",
	{" . genExtWidget('tbEvalweight2','numberfield',0) . "}]],
	[{xtype: 'label', text: '3', ctCls: 'tbEvalColumnHeader'},
	[{" . genExtWidget('tbEvalDt3','datefield',0) . "},
	" . tbMakeRadioSet('tbEvalresult3',$radioLabels) . ",
	{" . genExtWidget('tbEvalweight3','numberfield',0) . "}]],
	[{xtype: 'label', text: '5', ctCls: 'tbEvalColumnHeader'},
	[{" . genExtWidget('tbEvalDt5','datefield',0) . "},
	" . tbMakeRadioSet('tbEvalresult5',$radioLabels) . ",
	{" . genExtWidget('tbEvalweight5','numberfield',0) . "}]],
	[{xtype: 'label', text: 'Fin de rx', ctCls: 'tbEvalColumnHeader'},
	[{" . genExtWidget('tbEvalDtFin','datefield',0) . "},
	" . tbMakeRadioSet('tbEvalresultFin',$radioLabels) . ",
	{" . genExtWidget('tbEvalweightFin','numberfield',0) . "}]]
	];
"; 
?>

function tbEvalExtTable(tableType) { 
	var sectionTitleText = 'SURVEILLANCE DU TRAITEMENT<? if ($_REQUEST['type'] != 32) echo " (TB)"; ?>';
	var tableTitleText = '<?=_('Mois')?>';
        var dataTable = tbEvalTableData; 
        var extDataTableItems = [tableTitleText,
		 '<?=_('Date')?>','<?=_('Bacilloscopie')?>','<?=_('Poids (kg)')?>'].map(function(label) {
			 return {xtype:'label', text:label, ctCls: 'tbEvalHeader'};
		     }); 

    extDataTableItems = extDataTableItems.concat(dataTable.map(function(rowData) {
	 	var rowDataExt = [rowData[0]];
		rowDataExt = rowDataExt.concat(rowData[1].map(function(rowItem) {
			    rowItem.width = '10em';
			    return rowItem;
		}));
		return rowDataExt;
	}));

    var columnCount = 4;

    var extDataTable = {
	xtype: 'panel',
	border: false,
	autoHeight: true,
	padding: 0,
	cls: 'tbEval',
        layout: {
            type: 'table',
            columns: columnCount,
            tableAttrs: {
                cls: 'table table-bordered power-up-table'
            }
        },
	items: extDataTableItems
    };

    return new Ext.Panel({
	    title: sectionTitleText,
		id: tableType,
		<?   
		     if ($_REQUEST['type'] < 24) echo "
			cls: 'extToOldForm',
		        renderTo: 'surveillancePanel',";
		?>
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
		items: [	
			{xtype: 'label', text: '<?=_('              RESULTATS DE L’EXPECTORATION');?>'}
			,extDataTable
		]
		});
};
<?
if ($_REQUEST['type'] < 24) echo "
tbEvalExtTable ('tbEval'); 
";
?>
