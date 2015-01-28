<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
require_once 'backend.php';
require_once 'backend/constants.php';

$lang = (isset($_GET['lang'])) ? $_GET['lang'] : (isset ($_POST['lang']) ? $_POST['lang'] : "fr");
$url = "";

echo "
<head>
<meta http-equiv=\"content-type\" content=\"text/html; charset=" . CHARSET . "\" />"; 
?>
<title>iSanté Form Section Editor</title>
<link rel="stylesheet" type="text/css" href="ext-<?= EXTJS_VERSION ?>/resources/css/ext-all.css" />
<script type="text/javascript" src="ext-<?= EXTJS_VERSION ?>/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="ext-<?= EXTJS_VERSION ?>/ext-all.js"></script>
<script type="text/javascript">
Ext.BLANK_IMAGE_URL = 'ext-<?= EXTJS_VERSION ?>/resources/images/default/s.gif';
var fm = Ext.form;    
Ext.onReady(function(){
	var fName = new Array();
	fName[10] = 'Registration';
	fName[15] = 'Pediatric Registration';
	fName[30] = 'Records request';  
	fName[27] = 'Primary care--intake form';
	fName[28] = 'Primary care--followup form'; 
	fName[24] = 'Ob/gyn intake'; 
	fName[25] = 'Ob/gyn followup'; 
	fName[26] = 'Labor & delivery'; 
	fName[1] = 'HIV Intake'; 
	fName[16] = 'HIV Pediatric Intake';  
	fName[2] = 'HIV Followup'; 
	fName[17] = 'HIV Pediatric Followup'; 
	fName[3] = 'HIV Counseling Intake'; 
	fName[4] = 'HIV Counseling Followup'; 
	fName[5] = 'HIV Prescription'; 
	fName[18] = 'HIV Pediatric Prescription'; 
	fName[6] = 'HIV Laboratory'; 
	fName[19] = 'HIV Pediatric Laboratory'; 
	fName[14] = 'HIV Adherence Counseling'; 
	fName[20] = 'HIV Pediatric Adherence Counseling'; 
	fName[7] = 'HIV Home Visit'; 
	fName[9] = 'HIV Referral Tracking'; 
	fName[11] = 'HIV Selection Committee Report'; 
	fName[12] = 'Discontinuation';  
	fName[21] = 'Pediatric Discontinuation';
	
	function formName(val){
		return fName[val];
	}
   
	var resultRecord = new Ext.data.Record.create([
		{name: 'encounterType', type: 'int'},
		{name: 'section', type: 'int'},
		{name: 'sectionTitleEn', type: 'string'},
		{name: 'sectionTitleFr', type: 'string'} 
	]);
	
	var resultReader = new Ext.data.JsonReader({ //creates array from JSON response
		root: 'results', // name of the property that is container for an Array of row objects
		totalProperty: 'total'
		},
	    resultRecord
	); 
	
	var sql = 'select encounterType, section, sectionTitleEn, sectionTitleFr ';
	sql = sql + ' from sectionLookup';
	sql = sql + ' order by 1,2';

	var resultStore = new Ext.data.Store({
		id: 'resultStore',
		proxy: new Ext.data.HttpProxy({
	        url: 'jsonUtil.php',
	        method: 'POST'
	    }),
		reader: resultReader,
	    baseParams:{
			task: 'read',
			query: sql
		}
	});
	
	var addButton = new Ext.Button({    
		text: 'Add', 
		iconCls: 'original-icon-save',
		handler: function(){  
			//alert('this is supposed to add a new row that can be filled in');
			resultStore.add(new resultRecord({
			    encounterType: 10,
				section: 1,
				sectionTitleEn: '',
				sectionTitleFr: ''
			}));
	    }
	});
	
	var saveButton = new Ext.Button({    
		text: 'Save', 
		iconCls: 'original-icon-save',
		handler: function(){  
			jsonData = '[';
			for (i = 0; i < resultStore.getCount(); i++) {
				record = resultStore.getAt(i);
				if (record.data.newRecord || record.dirty) {
					if (jsonData != '[') jsonData += ',';
					jsonData += Ext.util.JSON.encode(record.data);
				} 
			}    
			jsonData = jsonData.substring(0,jsonData.length-1) + '}]';
			//alert(jsonData);
			Ext.Ajax.request({
				waitMsg: 'Saving changes...',
				url: 'jsonUtil.php',
				params: {
					task: 'saveData',
					table: 'sectionLookup',
					data: jsonData
				},
				callback: function (options, success, response) {
					//Ext.MessageBox.alert('Response: ',response.responseText);
					if (success)  resultStore.load({});
				}
			}); 
	    }
	});

	var resultGrid = new Ext.grid.EditorGridPanel({
	    store: resultStore,
	    columns: [
		    {header: 'Form', width: 200, sortable: true, renderer: formName, dataIndex: 'encounterType'},
		    {id:'encounterType', header: 'Form#', dataIndex: 'encounterType',editor: new fm.NumberField({allowBlank: false})},
		    {id:'section',header: 'Section#', width: 100, sortable: true, dataIndex: 'section',editor: new fm.NumberField({allowBlank: false})},   
		    {id:'sectionTitleEn',header: 'English Section', width: 400, sortable: true, dataIndex: 'sectionTitleEn',editor: new fm.TextField({allowBlank: false})},
		    {id:'sectionTitleFr',header: 'French Section', width: 400, sortable: true, dataIndex: 'sectionTitleFr',editor: new fm.TextField({allowBlank: false})}],
	    stripeRows: true,
	    autoHeight: true,
	    autoWidth: true       
	});   
	
	resultStore.load({});  
	
	var resultPanel = new Ext.Panel({ 
	   // overflow: 'auto', 
	    autoScroll: true,
		height: 600,
		width: 1500, 
		items: resultGrid,
		tbar: new Ext.Toolbar({items:[addButton]}), 
		bbar: new Ext.Toolbar({items:[saveButton]})
	})
	 
	var viewport = new Ext.Viewport({  
	    layout: 'form', 
	    items: [ 
			resultPanel
		]
	});
});
</script>
</head>
<body>
<form action="sectionEditor.php" method="post">
</form>
</body>
</html>
