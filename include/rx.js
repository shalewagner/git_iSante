var fm = Ext.form;

function formatDate(value){
    return value ? value.dateFormat('d/m/y') : '';
};

// record descriptor
var myRecordObj = new Ext.data.Record.create([
{name: 'vDate', type: 'date'}, 
{name: 'drugID', type: 'string'}, 
{name: 'drugGroup', type: 'string'}, 
{name: 'drugName', type: 'string'}, 
{name: 'isContinued', type: 'bool'}, 
{name: 'startDate', type: 'date'}, 
{name: 'toxicity', type: 'bool'}, 
{name: 'intolerance', type: 'bool'}, 
{name: 'failure', type: 'bool'}, 
{name: 'stockOut', type: 'bool'}, 
{name: 'stopDate', type: 'date'}
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
{header: 'VDate', dataIndex: 'vDate', type: 'date',  width: 100, sortable: true,  renderer: formatDate, editor: new fm.DateField({format: 'd/m/y'}), hidden: true},
{header: 'DrugID', dataIndex: 'drugID', type: 'string',  width: 120, sortable: true,  hidden: false},
{header: 'DrugGroup', dataIndex: 'drugGroup', type: 'string',  width: 120, sortable: true,  hidden: false},
{header: 'DrugName', dataIndex: 'drugName', type: 'string',  width: 120, sortable: true,  hidden: false},
{header: 'IsContinued', dataIndex: 'isContinued', type: 'bool',  width: 30, sortable: true,  hidden: false},
{header: 'StartDate', dataIndex: 'startDate', type: 'date',  width: 100, sortable: true,  renderer: formatDate, editor: new fm.DateField({format: 'd/m/y'}), hidden: false},
{header: 'Toxicity', dataIndex: 'toxicity', type: 'bool',  width: 30, sortable: true,  hidden: false},
{header: 'Intolerance', dataIndex: 'intolerance', type: 'bool',  width: 30, sortable: true,  hidden: false},
{header: 'Failure', dataIndex: 'failure', type: 'bool',  width: 30, sortable: true,  hidden: false},
{header: 'StockOut', dataIndex: 'stockOut', type: 'bool',  width: 30, sortable: true,  hidden: false},
{header: 'StopDate', dataIndex: 'stopDate', type: 'date',  width: 50, sortable: true,  renderer: formatDate, editor: new fm.DateField({format: 'd/m/y'}), hidden: false}
]);

Ext.onReady(function() {
	
// create grid (referencing the columnModel object)
	var grid = new Ext.grid.EditorGridPanel({
	id: 'grid',
	store: ds,
	cm: cm,
	view: new Ext.grid.GroupingView({
		forceFit:true,
		groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Articles" : "Article"]})',
		startCollapsed: true
	}),
	stripeRows: true,
	renderTo: 'content',
	autoExpandColumn: 'WhoStage',
	selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
	title: 'Medication history',
	height: 350,
	width: 800,
	clicksToEdit: 1,
	stripeRows: true,
	bbar: [{
		text: 'Delete selected Dx',
		tooltip: 'Click to delete the selected Dx',
		handler: handleDelete
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

var addform = new Ext.FormPanel({
        labelWidth:70,
        frame:true,
        bodyStyle:'padding:5px 5px 0',
        defaultType:'textfield',
        defaults: {width: 100},
        autoWidth:true,
        monitorValid: true,
        autoHeight:true,
        buttons: [
			{
		        text:'Add',
		        handler: function(){
			        win.hide();
		        }
	        }, {
		        text: 'Close',
		        handler: function(){
					win.hide();
		        }
	        }
        ],
        items: [
		 new fm.DateField({
			fieldLabel: 'VDate',
			id: 'vDate',
			name: 'vDate',
			width: 100,  
			format: 'd/m/y',
			allowBlank: true,  
			renderer: formatDate
		}),
		 new fm.TextField({
			fieldLabel: 'DrugGroup',
			id: 'drugGroup',
			name: 'drugGroup',
			width: 120, 
			allowBlank: true 
		}),
		new fm.TextField({
			fieldLabel: 'DrugName',
			id: 'drugName',
			name: 'drugName',
			width: 100, 
			readonly: true
		}),
		new fm.Checkbox({
			fieldLabel: 'IsContinued',
			id: 'isContinued',
			name: 'isContinued',
			width: 30, 
			allowBlank: true
		}),
		new fm.DateField({
			fieldLabel: 'StartDate',
			id: 'startDate',
			name: 'startDate',
			width: 100,  format: 'd/m/y',
			allowBlank: true,  renderer: formatDate
		}),
		new fm.Checkbox({
			fieldLabel: 'Toxicity',
			id: 'toxicity',
			name: 'toxicity',
			width: 30, 
			allowBlank: true 
		}),
		new fm.Checkbox({
			fieldLabel: 'Intolerance',
			id: 'intolerance',
			name: 'intolerance',
			width: 30, 
			allowBlank: true 
		}),
		new fm.Checkbox({
			fieldLabel: 'Failure',
			id: 'failure',
			name: 'failure',
			width: 30, 
			allowBlank: true 
		}),
		new fm.Checkbox({
			fieldLabel: 'StockOut',
			id: 'stockOut',
			name: 'stockOut',
			width: 30, 
			allowBlank: true
		}),
		new fm.DateField({
			fieldLabel: 'StopDate',
			id: 'stopDate',
			name: 'stopDate',
			width: 50,  
			format: 'd/m/y',
			allowBlank: true,  
			renderer: formatDate
		})
		]
});
		
function showDialog(group){
	alert (group);
	//var currAttributes = fromLink.split(':');
	var dt = new Date()
	var dtf = dt.format('d/m/y');
	var my = dt.format('d/m/y');
	//currAttributes.splice(0,0,dtf); // add in dtf
	//currAttributes.push(my);
	//var data = new Array(currAttributes);
	//var arrayReader = new Ext.data.ArrayReader({}, myRecordObj);
	//var rs = new Ext.data.Store({ data: data, reader: arrayReader});
	//var r = rs.getAt(0);
	// create the window on the first click and reuse on subsequent clicks
	if(!win){
		win = new Ext.Window({
			el:'hello-win',
			layout:'form',
			width:400,
			height:400,
			closeAction:'hide',
			items: addform
		});
	} 
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