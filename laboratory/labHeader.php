
<?

function parseFormAuthor ($namePart) {
	$formAuthor = trim($GLOBALS['existingData']['formAuthor']);
	$authorArray = explode(" ", $formAuthor);
	if (count($authorArray) == 1) {
		$first = '';  
		$last = $authorArray[0]; 
	} else {
		$first = $authorArray[0];
		$x = array_shift($authorArray);
		$last = implode(' ',$authorArray); 
	}
	if ($namePart == 'first') return ($first);
	else return ($last);
} 

function getGender() { 
	$mf = getData("sex", "textarea"); 
        switch ($mf) {
	case 1:
		return "F";
		break;
	case 2: 
		return "H";
		break;
	default:
		return "I";
	}
}

function getDob() {
	$dob = $GLOBALS['existingData']['dobDd'] . '/' . $GLOBALS['existingData']['dobMm'] . '/' . $GLOBALS['existingData']['dobYy'];
	return $dob;
}

function formMaker($formType, $fillIn, $fillValue) {
  $creator = '<input type="'.$formType.'" id="'.$fillIn.$fillValue.'" name="'.$fillIn.'" value="'.$fillValue.'">';
  return $creator;
}
?>
/* alt method without extjs - doesn't play well with validation
var visitType = {
	//layout: 'hbox',
	border: false,
  html: '<?=$labLoc['visitType'][$lang]?> &nbsp; <?
  $i = 1;
  while ($i < 5) {
    echo formMaker('radio','labVisitType',$i);
    echo '<label for="labVisitType'.$i.'">'.$labLoc['labVisitType'.$i][$lang].'</label> ';
    $i++;
  } ?>'
}*/
var visitType = {
	layout: 'hbox',
	border: false,
	defaults: { margins: '0 3 3 3'},
	flex: 0.3,
	items: [{
		xtype: 'label', text: '<?=$labLoc['visitType'][$lang]?>'
	},{
		boxLabel: '<?=$labLoc['labVisitType1'][$lang]?>',
		<?= genExtWidget ('labVisitType', 'radio', 1); ?> 
	},{
		boxLabel: '<?=$labLoc['labVisitType2'][$lang]?>',
		<?= genExtWidget ('labVisitType', 'radio', 2); ?> 
	},{
		boxLabel: '<?=$labLoc['labVisitType3'][$lang]?>',
		<?= genExtWidget ('labVisitType', 'radio', 3); ?> 
	},{
		boxLabel: '<?=$labLoc['labVisitType4'][$lang]?>',
		<?= genExtWidget ('labVisitType', 'radio', 4); ?>
	}]  
}; 

buildValidation(90, makeTestAnyIsChecked('labVisitType1', 'labVisitType2', 'labVisitType3', 'labVisitType4'));

<?
function showPatientIdentifier ($pid, $text, $identifier) {
	if ($text != 'Code national')  $identifier = getID($pid,$identifier);
	if ($identifier != '') return "<span>".$text." : ".$identifier."</span>";
	else return "";
}
?>

var patientInfo = {
	border: false,
	style: { margin: '0 3px 3px'},
	html: '<div class="print-break-before">PATIENTs <span><? echo htmlspecialchars($GLOBALS['existingData']['lname'],ENT_QUOTES).', '.htmlspecialchars($GLOBALS['existingData']['fname'],ENT_QUOTES).'</span> <span>'.$labLoc['dob'][$lang].' : ' . getDob().'</span><span>'.$labLoc['sex'][$lang].' : '.getGender().'</span><span>'.$labLoc['fnameMother'][$lang].' : '.htmlspecialchars($GLOBALS['existingData']['fnameMother'],ENT_QUOTES).'</span>'; ?>&nbsp;</div><div class="print-break-before"><?=$labLoc['identifiers'][$lang]?> <?=showPatientIdentifier($pid, 'Code national', $GLOBALS['existingData']['nationalID']).showPatientIdentifier($pid, 'Code PC', 'pc').showPatientIdentifier($pid, 'Code OG', 'ob').showPatientIdentifier($pid, 'Code ST', 'st')?></div>'
}

var orderNumber = {
	layout: 'hbox',
	border: false,
	id: 'orderNumber',
  // Removing print-break here - causing spacing issue in IE8
  //cls: 'print-break-before',
	defaults: { margins: '0 3 3 3'},
	flex: 0.3,
	items: [{
		xtype: 'label',
		text: '<?=$labLoc['labOrderNumber'][$lang]?> : '
	},{
		xtype: 'label',
		text: '<? echo $site . "-" . $eid; ?>',
		name: 'labOrderNumber',
		id: 'labOrderNumber0'
	},{
		xtype: 'label',
		text: '<?=$labLoc['doctorSignature1'][$lang]?> : '
	},{
		width: '5em',
		xtype: 'textfield',
		id: 'first',
		name: 'first',
		value: '<?=parseFormAuthor('first')?>'
	},{
		xtype: 'label',
		text: '<?=$labLoc['doctorSignature2'][$lang]?> : '
	},{
		width: '10em',
		xtype: 'textfield',
		id: 'last', 
		name: 'last',
		value: '<?=parseFormAuthor('last')?>'
	},{
		xtype: 'button', 
		cls: 'formButton print-hide', 
		text: '<?=$labLoc['printButton'][$lang]?>',
		handler: function() {
			window.print();
		}
	}
	]
} 

var sendLabButton = {
	xtype: 'button',
	id: 'sendLabButton', 
	autoWidth: true,
	text: '<?=$labLoc['sendLabButton'][$lang]?>',
	cls: 'formButton',
	hidden: true,
	height: 16,
	handler: function() {
		var dirty = false;
		var records = a_labsDs.getRange();
		for(var i =0; i < records.length; i++){
			var rec = records[i];
			if(rec.dirty == true) dirty = true;
		}
		if (dirty || allDirty) {
			alert('<?=$labLoc['orderUnsaved'][$lang]?>');
		} else if (records.length === 0) alert('<?=$labLoc['orderNoItems'][$lang]?>'); 
		else {
			Ext.Ajax.request({   
				waitMsg: 'Saving changes...',
				url: 'laboratory/labService.php',
				params: {
					task: 'queueEncounter',
					type: '<?=$type; ?>',
					site: '<?=$site; ?>',
					eid: '<?=$eid; ?>'
				}
				,                                  
				callback:function(options, success, response){
					var jsonString = Ext.util.JSON.decode(response.responseText); 
					if (jsonString.retVal) {
        					alert('<?=$labLoc['orderSent'][$lang]?>');
        					Ext.getCmp('saveButtonHeader').setDisabled(true);
        					Ext.getCmp('saveButtonFooter').setDisabled(true);
        					Ext.getCmp('enclosingPanel').hide();
        					Ext.getCmp('sendLabButton').setDisabled(true);
        					a_labsGrid.getColumnModel().setHidden(9, true);
        					a_labsGrid.setHeight(800);
        					sent = 1;
        					oFlag = 0;
        					a_labsDs.load({params: {task: 'getOrdered'}}); 
        					adjustDisplayedWidgets(usingOE, iFlag,oFlag,sent); 
					} else alert('Send to external lab failed');
				}  
			});
		}

	} 
} 

function saveLabOrder() {
	/* output formAuthor */
	var firstName = Ext.getCmp('first').getRawValue();
	var lastName = Ext.getCmp('last').getRawValue(); 
	//alert(firstName + ' ' + lastName);
	var obsData = {}; 
	var kpair = fetchContainerContents('labHeader');
	kpair.each(function(conceptName, obsValue) {
		obsData[conceptName] = obsValue;
	});
	var vDateArray = document.getElementById('vDate').value.split('/');
	Ext.Ajax.request({   
		waitMsg: 'Saving changes...',
		url: 'genericsave.php',
		params: {
			type: '<?=$type ?>',
			version: '<?=$version ?>',
			site: '<?=$site; ?>',
			lang: '<?=$lang; ?>',
			visitDateDd: vDateArray[0],
			visitDateMm: vDateArray[1],
			visitDateYy: vDateArray[2],
			eid: '<?=$eid; ?>', 
			pid: '<?=$pid; ?>',
			formAuthor: firstName + ' ' + lastName,
			jsonData: Ext.util.JSON.encode(obsData)
		},                                  
		failure:function(response,options){
			Ext.MessageBox.alert('Warning','Oops...');
		},                                  
		success:function(response,options){
			var responseData = Ext.util.JSON.decode(response.responseText); 
			saveLabOrderItems();
			Ext.MessageBox.alert('Fin', '<?=$labLoc['saveSuccessful'][$lang]?>');
		} 
	});
};

function saveLabOrderItems () {
	jsonData = '[';
	for (i=0; i<a_labsDs.getCount(); i++) {
		record = a_labsDs.getAt(i); 
		if (jsonData != '[') jsonData += ',';
		if (record.get('labid0') != '') jsonData += Ext.util.JSON.encode(record.data);
	}    
	jsonData += ']';
	//submit to server 
	Ext.Ajax.request({   
		waitMsg: 'Saving changes...',
		url: 'laboratory/labService.php?eid=<?=$eid;?>&site=<?=$site;?>', 
		params: {
			task: 'saveOrderedLabs',
			eid: '<?=$eid?>',
			pid: '<?=$pid?>',
			site: '<?=$site?>',
			data: jsonData
		},
		failure:function(response,options){
			Ext.MessageBox.alert('Warning','Oops...');
		},                                  
		success:function(response,options){
			var responseData = Ext.util.JSON.decode(response.responseText);
			a_labsDs.commitChanges(); 
			allDirty = false;
			a_labsDs.load({params: {task: 'getOrdered'}}); 
			adjustDisplayedWidgets(usingOE, iFlag,oFlag,sent);
		} 
	});
} 

function fetchContainerContents (parentContainer) { 
	/*
	 *** call below uses the hashtable code documented here:
	 *** http://www.timdown.co.uk/jshashtable/
	 */
	var kPair = new Hashtable();        
	// finds any simple input widgets and records their current values in the hashtable
	parentContainer = Ext.getCmp(parentContainer);
	parentContainer.cascade(function(i) {  
		if ('items' in i && i.items.length > 0) {     
			Ext.each(i.findByType('field'), function ( a, b) {
				if (a.name != null) {
				    switch (a.getXType()) {
					    case 'datefield':
						var curVal = a.getValue();
						if (curVal != null && curVal != '') {
						    curVal = curVal.format('Y-m-d'); 
						}
						break;
					    case 'checkbox':
						var curVal = a.getValue();
						if (curVal == true) {
						    curVal = 'On';
						} else {
							// handle unchecking checked boxes
							// don't really need to post them at all, right?
							//curVal = 'Off';
							curVal = null;
						} 
						break;
					    case 'radio':
						var curVal = a.getGroupValue();
						// handle unselecting a selected radio
						if (curVal == '' || curVal == null) {
							curVal = "Off";
						}
						break;
					    default:
						var curVal = a.getRawValue();
					}
					if (curVal != null && curVal != '') {
						kPair.put(a.name, curVal);
					}
				}
			});                 
		}
	});
	return kPair;
} 

var saveResultsButton = {
	xtype: 'button',
	id: 'saveResultsButton', 
	autoWidth: true,
	text: '<?=$labLoc['saveResultsButton'][$lang]?>',
	cls: 'formButton',
	hidden: true,
	height: 16,
	handler: function() {
		saveLabOrderItems();
		alert('<?=$labLoc['saveResults'][$lang]?>');
	} 
} 

var labHeader = new Ext.Panel ({
	header: false,
	layout: 'form', 
	id: 'labHeader',
	closable: false,
	style: 'font-size: 12px; background-image: none', 
	items: [
		visitType,
                patientInfo,
                orderNumber
	]
});
