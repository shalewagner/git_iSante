// start of coverpage tab
coverpageUi = new Ext.Container({
	autoEl: 'div',
	id: 'coverp',
	title: '<?=$tabLabels[$lang][0];?>',
	width: 900,
	height: 1200,
	boxMinHeight: 1050,
	layout: 'border',
	autoHeight: false,
	autoWidth: true,
	items: [{
		layout: { type: 'vbox',
                  align : 'stretch',
                  pack  : 'start'
                },
		width: 500,
		region: 'center',
		id: 'summaryView',
		items: [{
			//xtype: 'panel',
			title: false,
            flex: 1,
            autoScroll: true,
			border: false,
			html: '<div class="cover-list-box"><?=$alertes;?></div><div class="cover-list-box"><?=$allergies;?></div><div class="cover-list-box"><?=$vitals;?></div><div class="cover-list-box"><?=$anthro;?></div><div class="cover-list-box"><?=$forms;?></div><?php if (getHivPositive($pid)) { ?><div class="cover-list-box"><?=$arvInfo.$regtable;?></div><div class="cover-list-box"><?=$cd4info.$cd4table;?></div><?php } ?>'
		}] 
	},{
		xtype: 'form',
		id: 'mygraph',
		//activeTab: 0,
		region: 'west',
		width: 550,
		//for height check item rendered by CoverSheetGraph.ext2
		 items: [CoverSheetGraph.ext2(),CoverSheetBMI.ext3()
		
            
	<? 
	if ($treatmentRowcount > 0) echo "
		,{
		xtype: 'panel',
		id: 'drugline',
		title: 'Dispensations',
		header: true,
		height: 350,
		boxMaxHeight: 350,
		autoScroll: true,
		layout: 'fit',
		contentEl: iframeTreatment
		}"; 
	?>  ]
	}]
}),
// end of coverpage tab
