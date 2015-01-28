<?php
include ("../backend.php");
/*
** first column in query MUST be the visit data and MUST be named vDate
** other date columns must include the characters "Date" within them.
** fields meant to be checkboxes or radios should be 1 byte (tinyint in mssql) integers and will become "bool" in the js code.
** all other fields will be strings?
** the generated js code can be tweaked after generation for labels/renderers, etc.
** query cannot have line feeds in it
** TODO: how to put XX in the date parts???
** 
*/
$gridNamePrefix = "sp";
$query = "select left(patientid,5) as sitecode, '01/01/01' as modifyDate, 100 as ccNew, 100 as ccActive, 100 as ccAtRisk, 100 as ccTotal, 100 as artNew, 100 as artActive, 100 as artAtRisk, 100 as artTotal, 100 as ccInactive, 100 as artInactive, 100 as ccDisc, 100 as artDisc, count(*) as Total from v_patients where encounterType in (10,15) group by left(patientid,5)";
//$query = "select visitdateDd + '/' + visitdateMm + '/' + visitdateYy as vDate, labid, testNameFr, result, result2, resultAbnormal, resultRemarks,  resultdateDd + '/' + resultdateMm + '/' + resultdateYy as resultDate from v_labs";
//$query = "select visitdateDd + '/' + visitdateMm + '/' + visitdateYy as vDate, v.drugID, drugGroup, v.drugName, isContinued, '01/' + startMm + '/' + startYy as startDate, '01/' + stopMm + '/' + stopYy as stopDate, toxicity, intolerance, failureVir, failureImm, failureClin, stockOut, pregnancy, patientHospitalized, lackMoney, alternativeTreatments, missedVisit, patientPreference from v_drugs v, drugLookup l where v.drugid = l.drugid";
//$query = "select visitdateDd + '/' + visitdateMm + '/' + visitdateYy as vDate, conditions_id, whoStage, conditionNameFr, case when conditionactive = 1 then convert(tinyint,1) else convert(tinyint,0) end as active, case when conditionactive = 2 then convert(tinyint,1) else convert(tinyint,0) end as resolved, '01/01/01' as onsetDate from v_conditions";
// use this at run time
//$query2 = $query . " and patientid = '$pid'";
$query2 = $query;
// use this at compile time
//$query .= " and patientid = '11208296'";
// want an array of column names and datatypes to use throughout this code
$colArray = fetchQueryColumns($query2);
$recordDescriptor = genRecordDescriptor($colArray);
echo "
// db query used for fetching patient's data (move to main file)
var " . $gridNamePrefix . "QueryVar = \"" . $query2 . "\";
var fm = Ext.form;
function WhoStage(val){
    if(val == 'Stage I'){
        return '<span style=\"color:green;\">' + val + '</span>';
    }else if(val == 'Stage II'){
        return '<span style=\"color:red;\">' + val + '</span>';
    }else if(val == 'Stage III'){
        return '<span style=\"color:blue;\">' + val + '</span>';
    }else
        return '<span style=\"color:yellow;\">' + val + '</span>';
    return val;
}
function formatDate(value){
    return value ? value.dateFormat('d/m/y') : '';
};
function formatDate2(value){
    return value ? value.dateFormat('m/y') : '';
};
// record descriptor
var " . $gridNamePrefix . "Rec = new Ext.data.Record.create([
";
echo $recordDescriptor;
echo "
]);

// reader based upon record descriptor
var " . $gridNamePrefix . "Reader = new Ext.data.JsonReader({
	root: 'results',
	totalProperty: 'total'
},  
    " . $gridNamePrefix . "Rec
);

// datastore referencing reader and url for fetching/storing to/from db
var " . $gridNamePrefix . "Ds = new Ext.data.GroupingStore({
	id: '" . $gridNamePrefix . "Ds',
	proxy: new Ext.data.HttpProxy({
		url: 'include/jsonUtil.php',
		method: 'POST'
	}),
	reader: " . $gridNamePrefix . "Reader,
	sortInfo:{field: 'vDate', direction: 'DESC'},
	groupField:'vDate',
	baseParams:{task: 'read'}
});
";
$colModel = genColumnModel($colArray);
echo "
// columnModel for grid (could be inside the grid definition also)
var " . $gridNamePrefix . "cm = new Ext.grid.ColumnModel([
";
echo $colModel;
echo "
var " . $gridNamePrefix . "win;
var ". $gridNamePrefix . "form = new Ext.FormPanel({
";
$dialogForm = genDialogForm($colArray);
echo $dialogForm;
echo "
function showDialog(fromLink){
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
	if(!" . $gridNamePrefix . "win){
";
echo "
		" . $gridNamePrefix . "win = new Ext.Window({
			el:'" . $gridNamePrefix . "win',
			layout:'form',
			width:400,
			height:400,
			closeAction:'hide',
			items: " . $gridNamePrefix . "form,
			bbar: [{
				text: 'Delete Item',
				handler: handleDelete
			}, {
				text: 'Save Updates',
				handler: handleSave(" . $gridNamePrefix . "Ds)
			} 
			]
		});
	} 
 }

// Handler for saving record(s) 
function handleSave(ds) {
	jsonData = '[';
	for (i=0; i < ds.getCount(); i++) {
		// TODO: put filter here to get only new, deleted, or updated records
		record = ds.getAt(i);
		if (jsonData != '[') jsonData += ',';
		jsonData += Ext.util.JSON.encode(record.data);
     }    
	jsonData = jsonData.substring(0,jsonData.length-1) + ' }]';
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
}
Ext.onReady(function() {
// create grid (referencing the columnModel object)
	var " . $gridNamePrefix . "grid = new Ext.grid.EditorGridPanel({
	id: '" . $gridNamePrefix . "grid',
	store: " . $gridNamePrefix . "Ds,
	cm: " . $gridNamePrefix . "cm,
	view: new Ext.grid.GroupingView({
		forceFit:true,
		groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? \"Articles\" : \"Article\"]})'
	}),
	stripeRows: true,
	renderTo: '" . $gridNamePrefix . "content',
	selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
	title: 'Diagnosis History',
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
function handleDelete() {
	var selectedKeys = " . $gridNamePrefix . "grid.selModel.selections.keys;
	if(selectedKeys.length == 1)
		Ext.MessageBox.confirm('Message','Do you really want to delete this?', deleteRecord);
	else
        Ext.MessageBox.alert('Message','Please select only one for deletion');
}; 
function deleteRecord(btn) {
	if(btn=='yes') {
		var selectedRow = " . $gridNamePrefix . "grid.getSelectionModel().getSelected();
		if(selectedRow) " . $gridNamePrefix . "Ds.remove(selectedRow);
	}
}

" . $gridNamePrefix . "grid.render('" . $gridNamePrefix . "content');

" . $gridNamePrefix . "Ds.load({params: {
    start: 0, 
    limit: 1000,
	query: " . $gridNamePrefix . "queryVar
	}
});	
});
";

function genRecordDescriptor($colArray) {
	$retVar = "";
	foreach ($colArray as $col => $attr) {
		if ($retVar != "") $retVar .= ", \n";
		$retVar .= "{name: '" . $col . "', type: '" . $attr[0] . "'}";
	}
	return $retVar;
}

function genColumnModel($colArray) {
	$rxLabelArray = array (
		"toxicity" => array("Tox", "Tox"),
		"intolerance" => array("Intol", "Intol"),
		"failureVir" => array("Ech clin", "Vir fail"),
		"failureImm" => array("Ech Imm", "Imm fail"),
		"failureClin" => array("Ech clin", "Clin fail"),
		"stockOut" => array("RS", "Stock"),
		"pregnancy" => array("Gros", "Preg"),
		"patientHospitalized" => array("Hop", "Hosp"),
		"lackMoney" => array("Arg", "Money"),
		"alternativeTreatments" => array("Alt", "Alt"),
		"missedVisit" => array("Suiv", "Lost"),
		"patientPreference" => array("Pref", "Pref")
	);
	$retVar = "";
	foreach ($colArray as $col => $attr) {
		if ($retVar != "")
			$retVar .= ",\n";
		switch ($attr[0]) {
			case "date":
			$rend = " renderer: formatDate,";
			$width = " width: 80,";
			$hidden = " hidden: false";
			$editor = " editor: new fm.DateField({format: 'd/m/y'}),";
			break;
			case "bool":
			$rend = "";
			$width = " width: 30,";
			$hidden = " hidden: false";
			$editor = "";
			break;
			default:
			$rend = "";
			$width = " width: 120,";
			$hidden = " hidden: false";
			$editor = "";
		}
		if (isset($rxLabelArray[$col][0])) $currLabel = $rxLabelArray[$col][0];
		else $currLabel = ucfirst($col);
		if ($attr[0] == "bool") $retVar .= "new Ext.grid.CheckColumn(";
		$retVar .= "{header: '" . $currLabel . "', dataIndex: '" . $col . "', type: '" . $attr[0] . "', " . $width . " sortable: true, " . $rend .  $editor . $hidden . "}";
		if ($attr[0] == "bool") $retVar .= ")";
	}
	return $retVar;	
}

function genDialogForm($colArray) {
	$retVar = "labelWidth:70,
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
					var j = 0;
					var currDate = vDate.getValue().format('d/m/y');
					for (var i = 0; i < " . $gridNamePrefix . "Ds.getCount(); i++) {
						record = " . $gridNamePrefix . "Ds.getAt(i);
						if (record.get('vDate').format('d/m/y') == currDate) {
							j = i;
							break;
						}
					}
					win.hide();
				}
			}, 
			{
				text: 'Close',
				handler: function(){
					win.hide();
				}
			}
        ],
        items: [
	";
	$flag = false;
	foreach ($colArray as $col => $attr) {
		if ($flag) $retVar .= ",\n	";
		$flag = true;
		switch ($attr[0]) {
			case "date":
				$field = "DateField";
				$format = " format: 'd/m/y',";
				$width = "80";
				$rend = " renderer: formatDate,";
			break;
			case "bool":
				$field = "Checkbox";
				$format = "";
				$width = "30";
				$rend = "";
			break;
			default:
				$field = "TextField";
				$format = "";
				$width = "120";
				$rend = "";
		}
		$retVar .= "	new fm." . $field . "({
			fieldLabel: '" . ucfirst($col) . "',
			id: '" . $col . "',
			name: '" . $col . "',
			width: " . $width . ", " . $format . $rend . "
			allowBlank: true 
		})";
	}
	$retVar .= "\n	]
	});";
	return $retVar;
}

function genAssignToR ($colArray) {
	$retVar = "";
	foreach ($colArray as $col => $attr) {
		if ($retVar != "") $retVar .= "\n";
		$retVar .= "\t\t\t\t\tr.set('" . $col . "'," . $col . ".getValue());";
	}
	return $retVar;	
}

function genInitDialogFields($colArray) {
	$retVar = "";
	foreach ($colArray as $col => $attr) {
		if ($retVar != "") $retVar .= "\n";
		$retVar .= "\t\tvar " . $col . " = Ext.getCmp('" . $col . "');";
	}
	return $retVar;	
}

function genAssignToDialogFields($colArray) {
	$retVar = "";
	foreach ($colArray as $col => $attr) {
		if ($retVar != "") $retVar .= "\n";
		$retVar .= "\t" . $col . ".setValue(r.get('" . $col . "'));";
	}
	return $retVar;	
}
?>