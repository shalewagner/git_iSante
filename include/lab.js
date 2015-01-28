var fm = Ext.form;

function WhoStage(val){
    if(val == 'Stage I'){
        return '<span style="color:green;">' + val + '</span>';
    }else if(val == 'Stage II'){
        return '<span style="color:red;">' + val + '</span>';
    }else if(val == 'Stage III'){
        return '<span style="color:blue;">' + val + '</span>';
    }else
        return '<span style="color:yellow;">' + val + '</span>';
    return val;
}

function formatDate(value){
    return value ? value.dateFormat('d/m/y') : '';
};

function formatDate2(value){
    return value ? value.dateFormat('m/y') : '';
};

// record descriptor
var myRecordObj = new Ext.data.Record.create([
{name: 'vDate', type: 'date'}, 
{name: 'labid', type: 'string'}, 
{name: 'testNameFr', type: 'string'}, 
{name: 'result', type: 'string'}, 
{name: 'result2', type: 'string'}, 
{name: 'resultAbnormal', type: 'bool'}, 
{name: 'resultRemarks', type: 'string'}, 
{name: 'resultDate', type: 'date'}
]);

// reader based upon record descriptor
columnReader = new Ext.data.JsonReader({ //creates array from JSON response
	root: 'results', // name of the property that is container for an Array of row objects
	totalProperty: 'total'
	//id: 'objID' //the property within each row object that provides an ID for the record (optional)
},  
    myRecordObj //2nd parameter for reader constructor is record constructor object 
);

// datastore referencing reader and url for fetching/storing to/from db
var ds = new Ext.data.GroupingStore({
	id: 'ds',
	proxy: new Ext.data.HttpProxy({
        url: 'include/jsonUtil.php', //url to data object (server side script)
        method: 'POST'
    }),
	reader: columnReader,
    sortInfo:{field: 'vDate', direction: 'DESC'},
    groupField:'vDate',
    baseParams:{task: 'read'}//this parameter is passed for any HTTP request
});

// columnModel for grid (could be inside the grid definition also)
var cm = new Ext.grid.ColumnModel([
{header: 'VDate', dataIndex: 'vDate', type: 'date',  width: 80, sortable: true,  renderer: formatDate, editor: new fm.DateField({format: 'd/m/y'}), hidden: true},
{header: 'Labid', dataIndex: 'labid', type: 'string',  width: 120, sortable: true,  hidden: true},
{header: 'TestNameFr', dataIndex: 'testNameFr', type: 'string',  width: 120, sortable: true,  hidden: false},
{header: 'Result', dataIndex: 'result', type: 'string',  width: 120, sortable: true,  hidden: false},
{header: 'Result2', dataIndex: 'result2', type: 'string',  width: 120, sortable: true,  hidden: false},
{header: 'ResultAbnormal', dataIndex: 'resultAbnormal', type: 'bool',  width: 30, sortable: true,  hidden: false},
{header: 'ResultRemarks', dataIndex: 'resultRemarks', type: 'string',  width: 120, sortable: true,  hidden: false},
{header: 'ResultDate', dataIndex: 'resultDate', type: 'date',  width: 80, sortable: true,  renderer: formatDate, editor: new fm.DateField({format: 'd/m/y'}), hidden: false}
]);

Ext.onReady(function() {
	
// create grid (referencing the columnModel object)
	var grid = new Ext.grid.EditorGridPanel({
	id: 'grid',
	store: ds,
	cm: cm,
	view: new Ext.grid.GroupingView({
		forceFit:true,
		groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Articles" : "Article"]})'
	}),
	stripeRows: true,
	renderTo: 'content',
	autoExpandColumn: 'WhoStage',
	selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
	title: 'Lab result history',
	height: 350,
	width: 800,
	clicksToEdit: 1,
	stripeRows: true,
	bbar: [{
		text: 'Delete selected Dx',
		tooltip: 'Click to delete the selected Dx',
		handler: function(){
			handleDelete();
		}
	}],
	frame: true
});
	
/**
 * Handler to control grid editing / any updates to grid
 * @param {Object} oGrid_Event
 */
function handleEdit() {
	var selectedKeys = grid.selModel.selections.keys; 
	if(selectedKeys.length == 1) {
		var sr = grid.getSelectionModel().getSelected();
		showDialog(sr.get('objID') + ':' + sr.get('WhoStage') + ':' + sr.get('ConditionNameFr'));
	} else
        Ext.MessageBox.alert('Message','Please select a Dx for edit');
	};

// Handler for Deleting record(s) 
function handleDelete() {
	var selectedKeys = grid.selModel.selections.keys; //returns array of selected rows ids only
	if(selectedKeys.length == 1)
		Ext.MessageBox.confirm('Message','Do you really want to delete this Dx?', deleteRecord);
	else
        Ext.MessageBox.alert('Message','Please select one Dx for deletion');
}; 

/**
 * Function for Deleting record(s)
 * @param {Object} btn
 */ 
function deleteRecord(btn) {
	if(btn=='yes') {
		var selectedRow = grid.getSelectionModel().getSelected();
		if(selectedRow) ds.remove(selectedRow);
	}
}

grid.render('content');

ds.load({params: {
    start: 0, 
    limit: 1000,
	query: queryVar
	}
});	

});

var win;
function showDialog(fromLink){
	grid = Ext.getCmp('grid');
	var currAttributes = fromLink.split(':');
	var dt = new Date()
	var dtf = dt.format('d/m/y');
	var my = dt.format('d/m/y');
	currAttributes.splice(0,0,dtf); // add in dtf
	currAttributes.push(my);
	var data = new Array(currAttributes);
	var arrayReader = new Ext.data.ArrayReader({}, myRecordObj);
	var rs = new Ext.data.Store({ data: data, reader: arrayReader});
	var r = rs.getAt(0);

	// create the window on the first click and reuse on subsequent clicks
	if(!win){
		var vDate= new fm.DateField({
			fieldLabel: 'VDate:',
			id: 'vDate',
			name: 'vDate',
			width: 80,  format: 'd/m/y',
			allowBlank: true,  renderer: formatDate
		});
		var labid= new fm.TextField({
			fieldLabel: 'Labid:',
			id: 'labid',
			name: 'labid',
			width: 120, 
			allowBlank: true 
		});
		var testNameFr= new fm.TextField({
			fieldLabel: 'TestNameFr:',
			id: 'testNameFr',
			name: 'testNameFr',
			width: 120, 
			allowBlank: true 
		});
		var result= new fm.TextField({
			fieldLabel: 'Result:',
			id: 'result',
			name: 'result',
			width: 120, 
			allowBlank: true 
		});
		var result2= new fm.TextField({
			fieldLabel: 'Result2:',
			id: 'result2',
			name: 'result2',
			width: 120, 
			allowBlank: true 
		});
		var resultAbnormal= new fm.Checkbox({
			fieldLabel: 'ResultAbnormal:',
			id: 'resultAbnormal',
			name: 'resultAbnormal',
			width: 30, 
			allowBlank: true 
		});
		var resultRemarks= new fm.TextField({
			fieldLabel: 'ResultRemarks:',
			id: 'resultRemarks',
			name: 'resultRemarks',
			width: 120, 
			allowBlank: true
		});
		var resultDate= new fm.DateField({
			fieldLabel: 'ResultDate:',
			id: 'resultDate',
			name: 'resultDate',
			width: 80,  format: 'd/m/y',
			allowBlank: true,  renderer: formatDate
		});
		win = new Ext.Window({
			el:'hello-win',
			layout:'form',
			width:400,
			height:400,
			closeAction:'hide',
			items: [
				vDate,
				labid,
				testNameFr,
				result,
				result2,
				resultAbnormal,
				resultRemarks,
				resultDate
			],
			buttons: [{
				text:'Add',
				handler: function(){
					grid.stopEditing();
					var j = 0;
					var currDate = vDate.getValue().format('d/m/y');
					for (var i=0; i<ds.getCount(); i++) {
						record = ds.getAt(i);
						if (record.get('vDate').format('d/m/y') == currDate) {
							j = i;
							break;
						}
					}
					r.set('vDate',vDate.getValue());
					r.set('labid',labid.getValue());
					r.set('testNameFr',testNameFr.getValue());
					r.set('result',result.getValue());
					r.set('result2',result2.getValue());
					r.set('resultAbnormal',resultAbnormal.getValue());
					r.set('resultRemarks',resultRemarks.getValue());
					r.set('resultDate',resultDate.getValue());
				    ds.insert(j, r);   
				    grid.startEditing(0, 0);
			        win.hide();
				}
			},{
				text: 'Close',
				handler: function(){
				    win.hide();
				}
			}]
		});
	} else {
		var vDate = Ext.getCmp('vDate');
		var labid = Ext.getCmp('labid');
		var testNameFr = Ext.getCmp('testNameFr');
		var result = Ext.getCmp('result');
		var result2 = Ext.getCmp('result2');
		var resultAbnormal = Ext.getCmp('resultAbnormal');
		var resultRemarks = Ext.getCmp('resultRemarks');
		var resultDate = Ext.getCmp('resultDate');
	}
	vDate.setValue(r.get('vDate'));
	labid.setValue(r.get('labid'));
	testNameFr.setValue(r.get('testNameFr'));
	result.setValue(r.get('result'));
	result2.setValue(r.get('result2'));
	resultAbnormal.setValue(r.get('resultAbnormal'));
	resultRemarks.setValue(r.get('resultRemarks'));
	resultDate.setValue(r.get('resultDate'));
	win.render(document.body);
	win.show(this);
 }

// Handler for saving record(s) 
function handleSave() {
	jsonData = '[';
	for (i=0; i < ds.getCount(); i++) {
		// TODO: put filter here to get only new, deleted, or updated records
		record = ds.getAt(i);
		if (jsonData != '[') jsonData += ',';
		jsonData += Ext.util.JSON.encode(record.data);
     }    
	jsonData = jsonData.substring(0,jsonData.length-1) + ' }]';
	//alert (jsonData);
	Ext.Ajax.request({   
		waitMsg: 'Saving changes...',
		url: 'include/jsonUtil.php', 
		params: { 
			task: 'update', 
			data: jsonData  
		},
		callback: function (options, success, response) {
			Ext.MessageBox.alert('Response: ',response.responseText);  
		}                                  
	});		
};