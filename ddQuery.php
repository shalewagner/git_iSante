<?
require_once 'backend/constants.php';
require_once 'include/standardHeaderExt.php'; 
?>
<style type="text/css">
	.x-grid3 .x-window-ml{
		padding-left: 0;	
	} 
	.x-grid3 .x-window-mr {
		padding-right: 0;
	} 
	.x-grid3 .x-window-tl {
		padding-left: 0;
	} 
	.x-grid3 .x-window-tr {
		padding-right: 0;
	} 
	.x-grid3 .x-window-tc .x-window-header {
		height: 3px;
		padding:0;
		overflow:hidden;
	} 
	.x-grid3 .x-window-mc {
		border-width: 0;
		background: #cdd9e8;
	} 
	.x-grid3 .x-window-bl {
		padding-left: 0;
	} 
	.x-grid3 .x-window-br {
		padding-right: 0;
	}
	.x-grid3 .x-panel-btns {
		padding:0;
	}
	.x-grid3 .x-panel-btns td.x-toolbar-cell {
		padding:3px 3px 0;
	}
	.x-box-inner {
		zoom:1;
	}
    .original-icon-user-add {
        background-image: url(ext-<?= EXTJS_VERSION ?>/examples/shared/icons/fam/user_add.gif) !important;
    }
    .original-icon-user-delete {
        background-image: url(ext-<?= EXTJS_VERSION ?>/examples/shared/icons/fam/user_delete.gif) !important;
    }        
</style>
<script type="text/javascript">
Ext.BLANK_IMAGE_URL = 'ext-<?= EXTJS_VERSION ?>/resources/images/default/s.gif'; 
var fm = Ext.form; 
scrollToRow = 0;
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
Ext.ns("Ext.ux.renderer");

Ext.ux.renderer.ComboRenderer = function(options) {
    var value = options.value;
    var combo = options.combo;

    var returnValue = value;
    var valueField = combo.valueField;
        
    var idx = combo.store.findBy(function(record) {
        if(record.get(valueField) == value) {
            returnValue = record.get(combo.displayField);
            return true;
        }
    });
    
    // This is our application specific and might need to be removed for your apps
    if(idx < 0 && value == 0) {
        returnValue = '';
    }
    
    return returnValue;
};

Ext.ux.renderer.Combo = function(combo) {
    return function(value, meta, record) {
        return Ext.ux.renderer.ComboRenderer({value: value, meta: meta, record: record, combo: combo});
    };
}

Ext.onReady(function(){
	Ext.QuickTips.init();
	
	var win;
	var win2;
	
	function runQuery () {
		var et = Ext.getCmp('encType');
		var encType = et.getValue();
		var ver = 0;
		var verObject = Ext.getCmp('vPanel');
		for (var i = 0; i < 3; i++) {
			if (verObject.getComponent('ver0').getValue()) ver = 0;
			if (verObject.getComponent('ver1').getValue()) ver = 1;
			if (verObject.getComponent('ver2').getValue()) ver = 2;
		} 
		resultStore.removeAll();
		resultStore.load({params: {encType: encType, formVersion: ver, fieldLabel: '%', conceptKey: '%'}}); 
	} 
	
	function runConceptQuery () {
		var fl = document.getElementById('fieldLabel'); 
		var con = document.getElementById('concept'); 
		resultStore.removeAll();
		resultStore.load({params: {encType: '%', formVersion: '%', fieldLabel: fl.value, conceptKey: con.value}}); 
	}

	var classes = new Ext.data.ArrayStore({
		id: 'classes',
		fields: ['concept_class_id','name'],
		data: [ 
			[1, 'Test'],
			[2, 'Procedure'],
			[3, 'Drug'],
			[4, 'Diagnosis'],
			[5, 'Finding'],
			[6, 'Anatomy'],
			[7, 'Question'],
			[8, 'LabSet'],
			[9, 'MedSet'],
			[10, 'ConvSet'],
			[11, 'Misc'],
			[12, 'Symptom'],
			[13, 'Symptom/Finding'],
			[14, 'Specimen'],
			[15, 'Misc Order'],
			[16, 'Program'],
			[17, 'Workflow'], 
			[18, 'State']
		]
	}); 
	
	var datatypes = new Ext.data.ArrayStore({
		id: 'datatypes',
		fields: ['concept_datatype_id','name'],
		data: [
			[1, 'Numeric'],
			[2, 'Coded'],
			[3, 'varchar(2000)'],
			[5, 'Document'],
			[6, 'Date'],
			[7, 'Time'],
			[8, 'Datetime'],
			[10, 'Boolean'],
			[11, 'Rule'],
			[12, 'Structured Numeric']
		]
	});

	var encArrayStore = new Ext.data.ArrayStore({
	       id: 'encArray',
	       fields: ['encID','formtype'],
	       data: [
			[24,'Ob/gyn intake'],
			[25,'Ob/gyn followup'],
			[26,'Labor & delivery'], 
			[27,'Primary care--intake form'],
			[28,'Primary care--followup form'],
			[29,'Pediatric Primary care--intake form'],
			[31,'Pediatric Primary care--followup form'],
			[0,'      '],
			[10,'Registration'],
			[15,'Pediatric Registration'],
			//[30,'Records request'],  
			[1,'HIV Intake'],
			[16,'HIV Pediatric Intake'], 
			[2,'HIV Followup'],
			[17,'HIV Pediatric Followup'],
			[3,'HIV Counseling Intake'],
			[4,'HIV Counseling Followup'],
			[5,'HIV Prescription'],
			[18,'HIV Pediatric Prescription'],
			[6,'HIV Laboratory'],
			[19,'HIV Pediatric Laboratory'],
			[14,'HIV Adherence Counseling'],
			[20,'HIV Pediatric Adherence Counseling'],
			[7,'HIV Home Visit'],
			[9,'HIV Referral Tracking'],
			[11,'HIV Selection Committee Report'],
			[12,'Discontinuation'], 
			[21,'Pediatric Discontinuation'] 
		]
	});

	var queryPanel = new Ext.FormPanel({
	   	title: 'Query by form type and version...',
		labelWidth: 75,
		fieldWidth: 400,
		width: 600,
		height: 150,
		defaultType: 'textfield',
		items: [
			/* in future, query by label or conceptKey
			{fieldLabel: 'Field Label', name: 'fieldLabel', id: 'fieldLabel' },
			{fieldLabel: 'Concept', name: 'concept', id: 'concept' },*/
			{xtype: 'combo', id: 'encType', fieldLabel: 'Form', typeAhead: true, triggerAction: 'all', lazyRender:true, mode: 'local', store: encArrayStore, valueField: 'encID', displayField: 'formtype'},
			{xtype: 'panel',
				id: 'vPanel',
				layout: 'hbox',
				items: [
					{ xtype: 'label', width: '100', text: 'Version: ' },
					{ xtype: 'radio', id: 'version', name: 'version', itemId: 'ver0', inputValue: 0, boxLabel: '0' },
					{ xtype: 'radio', id: 'version', name: 'version', itemId: 'ver1', inputValue: 1, boxLabel: '1' },
					{ xtype: 'radio', id: 'version', name: 'version', itemId: 'ver2', inputValue: 2, boxLabel: '2', checked: true }
				]
			}
		],  
		bbar: new Ext.Toolbar({items:[{
			xtype: 'button',
			text: 'Search', 
			iconCls: 'original-icon-save',
			handler: function(){  
				runQuery();
		    }
		}]})	
	});
	
	var queryByConcept = new Ext.FormPanel({
	   	title: 'Concept Query...',
		//region: 'north',
		labelWidth: 75,
		fieldWidth: 400,
		width: 600,
		height: 150,
		defaultType: 'textfield',
		items: [
			{fieldLabel: 'Field Label', name: 'fieldLabel', id: 'fieldLabel' },
			{fieldLabel: 'Concept', name: 'concept', id: 'concept' }
		],  
		bbar: new Ext.Toolbar({items:[{
			xtype: 'button',
			text: 'Search', 
			iconCls: 'original-icon-save',
			handler: function(){  
				runConceptQuery();
		    }
		}]})	
	}); 
	
	var formCombo = Ext.getCmp('encType');
	formCombo.setValue('24');
	 
	var resultRecord = new Ext.data.Record.create([
		{name: 'encType', type: 'int'},
		{name: 'formVersion', type: 'int'},
		//{name: 'sectionTitleEn', type: 'string'},
		//{name: 'sectionTitleFr', type: 'string'},
		{name: 'section', type: 'int'}, 
   		{name: 'field', type: 'int'},
		{name: 'labelEn', type: 'string'},
		{name: 'labelFr', type: 'string'},
		{name: 'conceptKey', type: 'string'},
		{name: 'conceptOrTable', type: 'string'},
		{name: 'concept_class_id', type: 'string'},
		{name: 'concept_datatype_id', type: 'string'}
	]);
	
	var resultReader = new Ext.data.JsonReader({
		fields: resultRecord, 
		root: 'results',
		totalProperty: 'total'
	});

	var resultStore = new Ext.data.GroupingStore({
		id: 'resultStore',
		proxy: new Ext.data.HttpProxy({
	        url: 'conceptObject.php',
	        method: 'POST'
	    }),
		reader: resultReader,
		groupField: 'encType',
	    baseParams:{
			what: 'readDD'
		},
		sortInfo: {
			field: 'encType', direction: 'ASC',
			field: 'section', direction: 'ASC'
		}
	}); 
	
	resultStore.on('load', function() {
		document.getElementById('totalRows').value = this.getCount(); 
		resultGrid.getView().focusRow(scrollToRow + 1);
	}); 
	 
	var classCombo = { 
		xtype: 'combo', name: 'concept_class', id: 'concept_class', typeAhead: true, triggerAction: 'all', lazyRender:true, mode: 'local', store: classes, valueField: 'concept_class_id', displayField: 'name', fieldLabel: 'Class', value: 5
	};
	
	var datatypeCombo = 	{ 
		xtype: 'combo', name: 'concept_datatype', id: 'concept_datatype', typeAhead: true, triggerAction: 'all', lazyRender:true, mode: 'local', store: datatypes, valueField: 'concept_datatype_id', displayField: 'name', fieldLabel: 'Datatype', value: 10, width: 150 
	}; 

	function openConceptDialog(){
		if(!win2){
			win2 = new Ext.Window({
				el:'hello-win2',
				layout:'form',
				width:500,
				height: 'auto',
				closeAction:'hide',
				plain: true,
				items: {
					xtype: 'form',
					id: 'conceptDialog',
					name: 'conceptDialog',
					labelWidth:70,
					frame:true,
					bodyStyle:'padding:5px 5px 0',
					defaultType:'textfield',
					defaults: {width: 180},
					autoWidth:true,
					monitorValid: true,
					autoHeight:true,
					items: [   
						{xtype: 'numberfield', fieldLabel: 'Section Number', name: 'section', width: 100, allowBlank:false},
						{xtype: 'numberfield', fieldLabel: 'Field Number', name: 'fieldNum', width: 100, allowBlank:false},
						{fieldLabel: 'Concept Key', name: 'conceptKey', width: 100, allowBlank:false, type: 'string'},
						{fieldLabel: 'French Label', name: 'frLabel', width: 100, allowBlank:false, type: 'string'},
						{fieldLabel: 'English Label', name: 'enLabel', width: 100, allowBlank:false, type: 'string'},
						classCombo,
						datatypeCombo
					],
					buttons: [{
				        text:'Apply',
						handler: function(){
							var cf = Ext.getCmp('conceptDialog');
							var ver = 0;
							var verObject = Ext.getCmp('vPanel');
							for (var i = 0; i < 3; i++) {
								if (verObject.getComponent('ver0').getValue()) ver = 0;
								if (verObject.getComponent('ver1').getValue()) ver = 1;
								if (verObject.getComponent('ver2').getValue()) ver = 2;
							} 
							var cd = cf.getForm();
							var defaultData = new resultRecord({
								encType : Ext.getCmp('encType').getValue(),
								formVersion: ver, 
								section: cd.findField('section').getValue(),
								field: cd.findField('fieldNum').getValue(),
								conceptKey: cd.findField('conceptKey').getValue(), 
								labelFr: cd.findField('frLabel').getValue(),
								labelEn: cd.findField('enLabel').getValue(),
								concept_class_id: cd.findField('concept_class').getValue(),
								concept_datatype_id: cd.findField('concept_datatype').getValue()
							}); 
							defaultData.markDirty();
							scrollToRow = resultStore.indexOf(resultGrid.getSelectionModel().getSelected()); 
							resultStore.insert(0, defaultData);
							saveGrid();    
							//Ext.MessageBox.alert('Response: ','Field added');
							cd.findField('conceptKey').setValue('');
							cd.findField('frLabel').setValue('');
							cd.findField('enLabel').setValue('');
							cd.findField('concept_class').setValue(5);  
							cd.findField('concept_datatype').setValue(10);  
							win2.hide();
						}
					}]
                 }
			});
		}
		win2.show(this); 
	};
	
	function saveGrid () {
		jsonData = '[';
		for (i = 0; i < resultStore.getCount(); i++) {
			record = resultStore.getAt(i);
			if (record.dirty) {
				if (jsonData != '[') jsonData += ',';
				jsonData += Ext.util.JSON.encode(record.data);
			} 
		}    
		jsonData = jsonData.substring(0,jsonData.length-1) + '}]';
		Ext.Ajax.request({
			waitMsg: 'Saving changes...',
			url: 'conceptObject.php',
			params: {
				what: 'updateDD',
				data: jsonData
			},
			callback: function (options, success, response) {
				//Ext.MessageBox.alert('Response: ',response.responseText);
				if (success) {
					if (document.getElementById('fieldLabel').value != '' || document.getElementById('concept').value != '')
						runConceptQuery();
					else
						runQuery();
					}
			}
		}); 
    };
	
	var saveButton = new Ext.Button({    
		text: 'Save Changes', 
		iconCls: 'original-icon-save',
		handler: function(){ 
			scrollToRow = 0; 
			saveGrid();
		}
	});  
		
	function typeLabeler (encType) {
		switch (encType) {
		case 24:
		 	return 'ob-gyn in'; 
			break;
		case 25:
			return 'ob-gyn fu'; 
			break;
		case 27:
			return 'adult prim in';
			break;
		case 28:
			return 'adult prim fu';
			break;
		case 29:
			return 'ped prim in';
			break;
		case 31:
			return 'ped prim fu';
			break;
		default:
			return 'unknown';
		}
	} 

	var resultGrid = new Ext.grid.EditorGridPanel({ 
		id: 'resultGrid',  
		margins: '0 5 5 5',
		//autoExpandColumn: 'conceptKey',
		//plugins: [editor],
		view: new Ext.grid.GroupingView({ markDirty: true}),
		store: resultStore,
		autoscroll: true, 
		selectedRowClass: '.x-grid3-row-selected {background-color: green;} .x-grid3-cell-inner { color: red;}',
		height: 400,
		columns: [
	        new Ext.grid.RowNumberer(), 
			{id:'encType',header: 'Form', dataIndex: 'encType', renderer: typeLabeler, width: 75},
			{id:'formVersion',header: 'Version', dataIndex: 'formVersion', width: 40},
			{id:'section',header: 'Section#', width: 40, sortable: true, dataIndex: 'section', editor: new fm.NumberField({allowBlank: false})}, 
		    {id:'field',header: 'Field#', width: 40, sortable: true, dataIndex: 'field', editor: new fm.NumberField({allowBlank: false})},
			{id:'labelEn',header: 'English Label', width: 150, sortable: true, dataIndex: 'labelEn', editor: new fm.TextField({allowBlank: false})},
			{id:'labelFr',header: 'French Label', width: 150, sortable: true, dataIndex: 'labelFr', editor: new fm.TextField({allowBlank: false})}, 
			{id:'conceptKey',header: 'Concept Key', width: 150, sortable: true, dataIndex: 'conceptKey', editor: new fm.TextField({allowBlank: false})}, 
			{id: 'concept_class', header: 'Class', dataIndex: 'concept_class_id', value: 5, renderer: Ext.ux.renderer.Combo(classCombo), editor: classCombo},
			{id: 'concept_datatype', header: 'Datatype', dataIndex: 'concept_datatype_id', width: 80, value: 10, renderer: Ext.ux.renderer.Combo(datatypeCombo), editor: datatypeCombo},
			{id:'conceptOrTable',header: 'Concept ID or Tablename', width: 100, sortable: true, dataIndex: 'conceptOrTable'}
		],
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: true,
			listeners: {
				rowselect: function(smObj, rowIndex, record) {
					selRecordStore = record;
					var curConcept = selRecordStore.get('conceptKey');
					Ext.Ajax.request({
						waitMsg: 'Checking for concept...',
						url: 'conceptObject.php',
						params: {
							what: 'exists',
							conceptName: curConcept
						},
						callback: function (options, success, response) {
							var tabArray = response.responseText.split(':');
							if (isNumber(response.responseText))
								selRecordStore.set('conceptOrTable', response.responseText);
							else if (tabArray.length > 1) { 
								selRecordStore.set('conceptOrTable', tabArray[0]); 
								selRecordStore.set('concept_class_id', tabArray[1]);
								selRecordStore.set('concept_datatype_id', tabArray[2]);
							} else {
								selRecordStore.set('concept_class_id', 5); 
								selRecordStore.set('concept_datatype_id', 10); 
								selRecordStore.set('conceptOrTable', 'NOT FOUND');
								//Ext.MessageBox.alert('Response: ','Warning -- concept does not currently exist for this field -- use Create concept' ); 
							}
						}
					});
				}
			}
		}),
	    stripeRows: true,
	    autoHeight: true,
		width: 1000,
	    autoSizeColumns: true,
	    trackMouseOver: true
	});
	
	var resultTbar = new Ext.Toolbar({
		items:[{ 
			xtype: 'button',
			iconCls: 'original-icon-user-add',    
			text: 'Insert Form Field', 
			iconCls: 'original-icon-save',
			handler: function(){   
				openConceptDialog(); 
		    }
		},{
			xtype: 'button',
			iconCls: 'original-icon-user-delete',
			text: 'Delete Form Field',     
			iconCls: 'original-icon-save',
			handler: function(){
				var resultGrid = Ext.getCmp('resultGrid');
				var selected_row = resultGrid.getSelectionModel().getSelected();
				jsonData = '[{"deleteFlag":"1",' + Ext.util.JSON.encode(selected_row.data).substring(1) + ']';
				jsonData.substring(0,jsonData.length-1)
				Ext.Ajax.request({
					waitMsg: 'Deleting field...',
					url: 'conceptObject.php',
					params: {
						what: 'updateDD',
						data: jsonData
					},
					callback: function (options, success, response) {
						if (success) { 
							resultStore.remove(selected_row);
							//Ext.MessageBox.alert('Response: ','Field deleted'); 
						} else {
							Ext.MessageBox.alert('Response: ','Warning -- field was not deleted');
						}
					}
				}); 
			}
		},{
			xtype: 'button',    
			text: 'Create/Modify concept', 
			iconCls: 'original-icon-save',
			handler: function(){
				var resultGrid = Ext.getCmp('resultGrid');
				var selected_row = resultGrid.getSelectionModel().getSelected();
				Ext.Ajax.request({
					waitMsg: 'Checking for concept...',
					url: 'conceptObject.php',
					params: {
						what: 'add',
						conceptName: selected_row.get('conceptKey'),
						enLabel: selected_row.get('labelEn'),
						frLabel: selected_row.get('labelFr'),
						description: selected_row.get('labelEn'),
						classId: selected_row.get('concept_class_id'),
						datatypeId: selected_row.get('concept_datatype_id')
					},
					callback: function (options, success, response) {
						if (response.responseText == '') { 
							Ext.MessageBox.alert('Response: ','Warning -- concept was not created'); 
						} else {
							if (isNumber(response.responseText)) {
							//Ext.MessageBox.alert('Concept Id: ', response.responseText);
						} else 
							Ext.MessageBox.alert('Tablename: ', response.responseText);
							selected_row.set('conceptOrTable', response.responseText);
						}
					}
				}); 
			}
		},{
			xtype: 'button',    
			text: 'View concept', 
			iconCls: 'original-icon-save',
			handler: function(){
				var resultGrid = Ext.getCmp('resultGrid');
				var selected_row = resultGrid.getSelectionModel().getSelected();
				Ext.Ajax.request({
					waitMsg: 'Dumping concept info...',
					url: 'conceptObject.php',
					params: {
						what: 'get',
						conceptId: selected_row.get('conceptOrTable')
					},
					callback: function (options, success, response) {
						if (response.responseText == '') { 
							Ext.MessageBox.alert('Response: ','Warning -- concept dump failed'); 
						} else { 
							Ext.MessageBox.alert('Concept Info: ', response.responseText);;
						}
					}
				});
			}           
		}
		/*,{
			xtype: 'button',    
			text: 'Delete concept', 
			iconCls: 'original-icon-save',
			handler: function(){
				var resultGrid = Ext.getCmp('resultGrid');
				var selected_row = resultGrid.getSelectionModel().getSelected();
				Ext.Ajax.request({
					waitMsg: 'Deleting concept...',
					url: 'conceptObject.php',
					params: {
						what: 'delete',
						conceptId: selected_row.get('conceptOrTable')
					},
					callback: function (options, success, response) {
						if (response.responseText == '') { 
							Ext.MessageBox.alert('Response: ','Warning -- delete failed'); 
						} else { 
							Ext.MessageBox.alert('Concept Delete: ', response.responseText);;
						}
					}
				});
			}           
		}*/
		]      
	});
	
	var resultPanel = new Ext.Panel({ 
		title: 'Form dictionary contents...', 
		autoScroll: true,
		height: 600,
		width: 1100, 
		items: resultGrid, 
		tbar: resultTbar, 
		bbar: new Ext.Toolbar({
			items:[
				saveButton,
			{ 
				xtype: 'label',
				text: 'Number of rows that satisfied the current query :'
			},{
				xtype: 'numberfield',
				id: 'totalRows',
				name: 'totalRows'
			}]
		})
	});
	 
	var viewport = new Ext.Viewport({  
		layout: 'form', 
		id: 'xxxx',
		autoHeight: true,
		overflow: 'auto',
		autoScroll: true,
		items: [{
		 	xtype: 'panel',
			layout: 'hbox',
			items: [
				queryPanel,
				queryByConcept
			]},
			{xtype: 'panel', height:50 },
			resultPanel
		]
	}); 

});
</script>
</head>
<body>
<form action="ddQuery.php" method="post"> 
<div id="hello-win" class="x-hidden">
    <div class="x-window-header">Update Section Number</div>
 </div>
<div id="hello-win2" class="x-hidden">
    <div class="x-window-header">New Form Field</div>
 </div>
</form>
</body>
</html>
