
var fm = Ext.form;
function formatDate(value){
    return value ? value.dateFormat('Y-m-d') : '';
};

function formatBool(value){
    return value ? 'anormal' : '';
};

var a_labsRec = new Ext.data.Record.create([
	{name: 'vDate', type: 'date'},
	{name: 'labid', type: 'string'},
	{name: 'labGroup', type: 'string'},
	{name: 'theType', type: 'string'},
	{name: 'testNameFr', type: 'string'},
	{name: 'sampletype', type: 'string'},
	{name: 'result', type: 'string'},
	{name: 'result2', type: 'string'},
	{name: 'result3', type: 'string'},
	{name: 'resultAbnormal', type: 'bool'},
	{name: 'resultRemarks', type: 'string'},
	{name: 'resultDate', type: 'date', dateFormat: 'Y-m-d'},
	{name: 'accessionNumber', type: 'string'},
	{name: 'sendingSiteName', type: 'string'}
]);

var sampleRec = new Ext.data.Record.create([
	{name: 'labGroup', type: 'string'},
	{name: 'theType', type: 'string'},
	{name: 'testNameFr', type: 'string'}, 
	{name: 'labid', type: 'string'},   
	{name: 'sampletype', type: 'string'}
])
var orderReader = new Ext.data.JsonReader({root: 'results',totalProperty: 'total'}, a_labsRec);

var sampleDs = new Ext.data.SimpleStore({
	fields: sampleRec
});

var a_labsDs = new Ext.data.GroupingStore({
	id: 'a_labsDs',
	proxy: new Ext.data.HttpProxy({
		url: 'laboratory/labService.php',
		method: 'POST'
	}),
	reader: orderReader,
	remoteSort: true,
	pruneModifiedRecords: true,
	sortInfo: [
		{field: 'labGroup', direction: 'ASC'},
		{field: 'testNameFr', direction: 'ASC'}
	],
	groupField: 'labGroup',
	listeners: {
		load: function(t, records, options) {
			for (var i=0; i<records.length; i++) {
				// check the panels/tests that are currently in the grid
				var rec = records[i]; 
				checkTest(rec.get('labid'));
			}
		}  
	},
	baseParams: {eid:'<?=$eid;?>', pid:'<?=$pid;?>',lang:'<?=$lang;?>'}
}); 

var sampleCm = new Ext.grid.ColumnModel([ 
	{header: '<?=$labLoc['cmGroup'][$lang]?>', dataIndex: 'labGroup', type: 'string', width: 100, sortable: false, hidden: false},
	{header: 'Type', dataIndex: 'theType', type: 'string', width: 60, sortable: false,  hidden: false},
	{header: '<?=$labLoc['cmName'][$lang]?>', dataIndex: 'testNameFr', type: 'string', width: 180, sortable: false,  hidden: false}, 
	{header: 'labid', dataIndex: 'labid', type: 'string', width: 120, sortable: false,  hidden: false}, 
	{header: '<?=$labLoc['cmSampleType'][$lang]?>', dataIndex: 'sampletype', type: 'string', width: 120, sortable: false,  hidden: false}
]);

function displayDash() {
	return '-';
}
function displayDelete() {
return '<div class="hover-icon-red"><i class="icon-remove icon-gray"></i></div>';
}

var a_labsCm = new Ext.grid.ColumnModel([ 
	{header: 'Labid', dataIndex: 'labid', type: 'integer', width: 20, sortable: false,  hidden: true}, 
	{header: '<?=$labLoc['cmGroup'][$lang]?>', dataIndex: 'labGroup', type: 'string', width: 100, sortable: false, hidden: false},
	{header: 'Type', dataIndex: 'theType', type: 'string', width: 50, sortable: false,  hidden: false},
	{header: '<?=$labLoc['cmName'][$lang]?>', dataIndex: 'testNameFr', type: 'string', width: 180, sortable: false,  hidden: false},
	{header: '<?=$labLoc['cmSampleType'][$lang]?>', dataIndex: 'sampletype', type: 'string', width: 120, sortable: false, editor: new fm.TextField({allowBlank: false}), hidden: false},
	{header: '<?=$labLoc['cmResultDate'][$lang]?>', dataIndex: 'resultDate', type: 'date', width: 120, sortable: true, renderer: formatDate, editor: new fm.DateField({format: 'Y-m-d'}), hidden: true}, 
	{header: '<?=$labLoc['cmResult'][$lang]?>', dataIndex: 'result', type: 'string', width: 120, sortable: false, editor: new fm.TextField({allowBlank: true}), hidden: false},
	//{header: 'Résultat2', dataIndex: 'result2', type: 'string', width: 120, sortable: false, editor: new fm.TextField({allowBlank: false}), hidden: true},
	//{header: 'Résultat3', dataIndex: 'result3', type: 'string', width: 120, sortable: false, editor: new fm.TextField({allowBlank: false}), hidden: true},
	//new Ext.grid.CheckColumn({ header: 'Anormal', dataIndex: 'resultAbnormal', type: 'bool', width: 60, editable: true, hidden: true}),  
	{header: '<?=$labLoc['cmRemarks'][$lang]?>', dataIndex: 'resultRemarks', type: 'string', width: 200, sortable: false, editor: new fm.TextField({allowBlank: true}), hidden: true},
	{header: '<?=$labLoc['cmAccNum'][$lang]?>', dataIndex: 'accessionNumber', type: 'string', width: 120, sortable: true, hidden: false},
	//{header: 'Order Date', dataIndex: 'vDate', type: 'date', width: 80, sortable: true, renderer: formatDate, hidden: true},
	//{header: '<?=$labLoc['cmSourceLab'][$lang]?>', dataIndex: 'sendingSiteName', type: 'string', width: 20, sortable: false, hidden: true},
	{header: '<?=$labLoc['cmDelete'][$lang]?>', dataIndex: 'theType', type: 'string', renderer: displayDelete, width: 65, sortable: false, hidden:  <?=($_REQUEST['sent'] == 1 || $alreadySent) ?   "true":"false"; ?>}
]); 

var sampleGrid = new Ext.grid.GridPanel({
	id: 'sampleGrid',
	store: sampleDs,
	header: true,
	title: '<?=$labLoc['tChooseSample'][$lang]?>',
	cm: sampleCm, 
	sm: new Ext.grid.RowSelectionModel({ singleSelect: true }),
	listeners: {
		'rowdblclick': function(grid, rowindex, e){ 
			win2.hide();
			var record = sampleDs.getAt(rowindex);
			var records = a_labsDs.getRange();
			var doesnotExist = true;
			for(var i = 0; i < records.length; i++){
				var rec = records[i];
				if(record.get('sampletype').indexOf(rec.get('labid')) != -1) doesnotExist = false;
			}
			if (doesnotExist) {
				var idArray = record.get('sampletype').split(',');
				if (idArray.length != 1 || dialogType == 'search') {
					// need to break into separate rows in sampleDs
					openSampleDialog(record);
				} else {
					insertRow(record);
				}
			} else {
				alert('<?=$labLoc['itemInOrder'][$lang]?>');
			}
		} 
	},
	height: 200,
	width: 500
});

function checkTest(labid) {      
	// finds and checks the checkbox containing this labid
	var flag = false;
	for (var k = 1; k < 15; k++) {
		parentContainer = Ext.getCmp('tests'+k);
		parentContainer.cascade(function(i) {  
			if ('items' in i && i.items.length > 0) {     
				Ext.each(i.findByType('checkbox'), function ( a, b) {
					record = a.id.split(':');
					if (record[3].indexOf(labid) != -1) {
						if (! a.getValue()) a.setValue(true); 
						flag = true;
					}
				});                 
			}
		});
		//if (flag) break;  
	}
}

function uncheckTest(labid) {      
	// finds and unchecks the checkbox containing this labid
	var flag = false;
	for (var k = 1; k < 15; k++) {
		parentContainer = Ext.getCmp('tests'+k);
		parentContainer.cascade(function(i) {  
			if ('items' in i && i.items.length > 0) {     
				Ext.each(i.findByType('checkbox'), function ( a, b) {
					record = a.id.split(':');
					if (record[3].indexOf(labid) != -1) {
						a.setValue(false); 
						flag = true;
					}
				});                 
			}
		});
		//if (flag) break;  
	}
} 

var allDirty = false;

var a_labsSm = new Ext.grid.CellSelectionModel({
        listeners: {
		cellselect: function(sm,row,col) { 
		        var rec = a_labsDs.getAt(row);
			if (col == 9) {  
			        var labid = rec.get('labid'); 
				rec.markDirty();
				allDirty = true; 
				a_labsDs.removeAt(row); 
				uncheckTest(labid);   
			}
			if (col == 4) {
			        var tp = rec.get('theType');
			        if (tp == 'P') {

        				alert('<?=$labLoc['noPanelsDirectly'][$lang];?>'); 

			        }
			}
		}
	         
	}
});

var a_labsGrid = new Ext.grid.EditorGridPanel({
	id: 'a_labsGrid',
	store: a_labsDs,
	cm: a_labsCm,
	sm: a_labsSm,
	baseCls:'x-custgrid3-row',
	containerScroll: true,
	autoScroll: true,
	stripeRows: true,
	tbar: new Ext.Toolbar({
		items:[{
			xtype: 'label',
			text: '<?=$labLoc['gridLabel'][$lang]?>'
		}
		,'-'
		,sendLabButton
		,'-'
	        ,saveResultsButton
		]
	}), 
	height: 225,
	//width: 1200,
	frame: true
});

function adjustDisplayedWidgets (usingOE,iFlag,oFlag,sent) {
        var alg = a_labsGrid.getColumnModel(); 
        var oCnt = a_labsDs.getCount();
        if (oCnt > 0) {
                iFlag = 0;
                oFlag = 0;
                for (i=0; i<oCnt; i++) {
        		record = a_labsDs.getAt(i);
        		var st = record.get('sampletype'); 
        		if (record.get('labid') < 1000 || st == 'isante' || st == 'iSanté' || st == 'isanté' || st == 'iSante') iFlag = 1;
        		if (record.get('labid') > 1000 && st != 'isante' && st != 'iSanté' && st != 'isanté' && st != 'iSante') oFlag = 1;
        	} 
	}
	if (sent == 0) { 
                if (oFlag && usingOE) {
                        Ext.getCmp('sendLabButton').setVisible(true);
                        Ext.getCmp('saveResultsButton').setVisible(false); 
                }
                if ((iFlag && oFlag == 0) || !usingOE) { 
                        Ext.getCmp('saveResultsButton').setVisible(true);
                        Ext.getCmp('sendLabButton').setVisible(false);
                        resultColsNotShowing = false;
			for (var i = 5; i < 9; i++) alg.setHidden(i, resultColsNotShowing); 
                }
        } else { // sent = 1
		Ext.getCmp('saveButtonHeader').setDisabled(true);
		Ext.getCmp('saveButtonFooter').setDisabled(true);
		Ext.getCmp('sendLabButton').setVisible(false); 
		Ext.getCmp('enclosingPanel').hide();
		// if there are any isante items
		if (iFlag || !usingOE) Ext.getCmp('saveResultsButton').setVisible(true);
		a_labsGrid.setHeight(800);
		resultColsNotShowing = false;
		for (var i = 5; i < 9; i++) alg.setHidden(i, resultColsNotShowing);
		alg.setHidden(9,true); 
	} 
}  

function insertRow(record) {  
	var idSample = record.get('sampletype').split('|');
	if (idSample.length == 1) {
		var labid = record.get('labid');
		var st = record.get('sampletype');
	} else { 
		var labid = idSample[0];
		var st = idSample[1];
	}
	var newTestRec = new a_labsRec({
		labGroup: record.get('labGroup'),
		theType: record.get('theType'),
		testNameFr: record.get('testNameFr'), 
		labid: labid,
		sampletype: st
	});
	newTestRec.markDirty(); 
	a_labsDs.insert(a_labsDs.getCount(), newTestRec);
	checkTest(labid); 
}

win2 = new Ext.Window({
	el:'win2',
	id: 'win',
	layout:'form',
	width: 600,
	height: 'auto',
	hidden: true,
	closeAction:'hide',
	plain: true,
	items: {
		xtype: 'form',
		id: 'sampleDialog',
		name: 'sampleDialog',
		frame:true,
		bodyStyle:'padding:5px 5px 0',
		autoWidth:true,
		autoHeight:true,
		items: [   
			sampleGrid
		],
		buttons: [{text:'<?=$labLoc['select'][$lang]?>',
			handler: function(){
				var i = sampleDs.indexOf(sampleGrid.getSelectionModel().getSelected()); 
				if (i == -1) {
					alert ('<?=$labLoc['tMustSelect'][$lang]?>');
				} else {
					win2.hide();
					var record = sampleDs.getAt(i);
					var records = a_labsDs.getRange();
					var doesnotExist = true;
					for(var i = 0; i < records.length; i++){
						var rec = records[i];
						if(record.get('sampletype').indexOf(rec.get('labid')) != -1) doesnotExist = false;
					}
					if (doesnotExist) {
						var idArray = record.get('sampletype').split(',');
						if (idArray.length != 1 || dialogType == 'search') {
							// need to break into separate rows in sampleDs
							openSampleDialog(record);
						} else {
							insertRow(record);
						}
					} else {
						alert('<?=$labLoc['itemInOrder'][$lang]?>');
					} 
				}
			}
		},{
			text:'<?=$labLoc['cancel'][$lang]?>',
			handler: function(){
				win2.hide();
			}
		}] 
	}
});

dialogType = null;

function openSearchDialog(){ 
	sampleGrid.setTitle('<?=$labLoc['tChoose'][$lang]?>');
	dialogType = 'search';
	// want to show labGroup, theType, testNameFr, but not sampletype
	var scm = sampleGrid.getColumnModel();
	for (var i = 0; i < 3; i++) scm.setHidden(i, false);
	for (var i = 3; i < 5; i++) scm.setHidden(i, true);  
	win2.show(); 
};

function openSampleDialog(record) { 
	sampleGrid.setTitle('<?=$labLoc['tChooseSample'][$lang]?>');
	dialogType = 'select';
	// want to hide all columns except sampletype
	var scm = sampleGrid.getColumnModel();
	for (var i = 0; i < 4; i++) scm.setHidden(i, true);
	scm.setHidden(4, false);
	var idArray = record.get('sampletype').split(',');
	if (idArray.length == 1) insertRow(record);
	else {
		// load the sampleDs from the idArray 
		var sample = [];
		for (var i = 0; i < idArray.length; i++) {
			var idSample = idArray[i].split('|'); 
			sample[i] = [record.get('labGroup'), record.get('theType'), record.get('testNameFr'), idSample[0], idSample[1]];
		} 
		sampleDs.loadData(sample);
		win2.show(); 
	}
};
