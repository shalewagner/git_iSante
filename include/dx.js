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
{name: 'conditions_id', type: 'string'}, 
{name: 'whoStage', type: 'string'}, 
{name: 'conditionNameFr', type: 'string'}, 
{name: 'active', type: 'bool'}, 
{name: 'resolved', type: 'bool'}, 
{name: 'onsetDate', type: 'date'}
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
{header: 'Conditions_id', dataIndex: 'conditions_id', type: 'string',  width: 120, sortable: true,  hidden: true},
{header: 'WhoStage', dataIndex: 'whoStage', type: 'string',  width: 120, sortable: true,  hidden: false},
{header: 'ConditionNameFr', dataIndex: 'conditionNameFr', type: 'string',  width: 120, sortable: true,  hidden: false},
{header: 'Active', dataIndex: 'active', type: 'bool',  width: 30, sortable: true,  hidden: false},
{header: 'Resolved', dataIndex: 'resolved', type: 'bool',  width: 30, sortable: true,  hidden: false},
{header: 'OnsetDate', dataIndex: 'onsetDate', type: 'date',  width: 100, sortable: true,  renderer: formatDate, editor: new fm.DateField({format: 'd/m/y'}), hidden: false}
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
	title: 'Diagnosis history',
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
			width: 100,  format: 'd/m/y',
			allowBlank: true,  renderer: formatDate
		});
		var conditions_id= new fm.TextField({
			fieldLabel: 'Conditions_id:',
			id: 'conditions_id',
			name: 'conditions_id',
			width: 120, 
			allowBlank: true
		});
		var whoStage= new fm.TextField({
			fieldLabel: 'WhoStage:',
			id: 'whoStage',
			name: 'whoStage',
			width: 120, 
			allowBlank: true 
		});
		var conditionNameFr= new fm.TextField({
			fieldLabel: 'ConditionNameFr:',
			id: 'conditionNameFr',
			name: 'conditionNameFr',
			width: 120, 
			allowBlank: true 
		});
		var active= new fm.Checkbox({
			fieldLabel: 'Active:',
			id: 'active',
			name: 'active',
			width: 30, 
			allowBlank: true
		});
		var resolved= new fm.Checkbox({
			fieldLabel: 'Resolved:',
			id: 'resolved',
			name: 'resolved',
			width: 30, 
			allowBlank: true 
		});
		var onsetDate= new fm.DateField({
			fieldLabel: 'OnsetDate:',
			id: 'onsetDate',
			name: 'onsetDate',
			width: 100,  format: 'd/m/y',
			allowBlank: true,  renderer: formatDate
		});
		win = new Ext.Window({
			el:'hello-win',
			layout:'form',
			width:400,
			height:400,
			closeAction:'hide',
			items: [			vDate,
			conditions_id,
			whoStage,
			conditionNameFr,
			active,
			resolved,
			onsetDate
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
					r.set('conditions_id',conditions_id.getValue());
					r.set('whoStage',whoStage.getValue());
					r.set('conditionNameFr',conditionNameFr.getValue());
					r.set('active',active.getValue());
					r.set('resolved',resolved.getValue());
					r.set('onsetDate',onsetDate.getValue());
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
		var conditions_id = Ext.getCmp('conditions_id');
		var whoStage = Ext.getCmp('whoStage');
		var conditionNameFr = Ext.getCmp('conditionNameFr');
		var active = Ext.getCmp('active');
		var resolved = Ext.getCmp('resolved');
		var onsetDate = Ext.getCmp('onsetDate');
	}
	vDate.setValue(r.get('vDate'));
	conditions_id.setValue(r.get('conditions_id'));
	whoStage.setValue(r.get('whoStage'));
	conditionNameFr.setValue(r.get('conditionNameFr'));
	active.setValue(r.get('active'));
	resolved.setValue(r.get('resolved'));
	onsetDate.setValue(r.get('onsetDate'));
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
