<? 
    $isAdultEncounter = in_array($type, array(27,28));
    $isPediatricEncounter = in_array($type, array(29,31));
    $isObgynEncounter = in_array($type, array(24,25,26));
    $isLabForm = in_array($type, array(13));

    $isIntakeEncounter = in_array($type, array(24,27,29));
    $isFollowupEncounter = in_array($type, array(25,28,31));

    $patientStatus = getPatientStatus ($pid);
    if ($eid == "" && $pid != "") {
	$newForm = true;
	$alreadySent = false;
        if ($eid == "") {
            // let's generate this encounter
            $curUser = getSessionUser();
            $eid = addEncounter ($pid, date ("d"), date ("m"), date ("y"), $site, date ("Y-m-d H:i:s"),
                $type, "added automatically when starting primary care form", $curUser, $curUser, "",
                "", "", "", $formVersion[$type], getSessionUser(), date ("Y-m-d H:i:s"));
            getExistingData ($eid, $tables); 
	    /* 
		exception below allows new forms to pick up the most recent visit date concept records from previous tb forms AND from the new 
		tb section of all other forms.
		since the new forms automatically adopt the current date as the visit date, the tb form will pick up anything previously entered.
		When the form is re-initialized for edit, only the previously stored data element values will be fetched--this is normal behavior
		for all forms
	     */ 
	    // set hivPositive globals if new non-HIV forms
	    if (getHivPositive($pid)) { 
		if ($isIntakeEncounter) $GLOBALS['existingData']['hivPositiveN'] = 1; 
	        if ($isFollowupEncounter) $GLOBALS['existingData']['hivPositiveA'] = 1; 
	    } 
	    if (in_array($type, array(24,25,27,28,29,31,32))) fetchSaveCarryForwardData();
        }
    } else {
	$newForm = false;
	if ($isLabForm) {
		$sql = 'select count(*) from encounterQueue where encounter_id = ? and sitecode = ?';
		$rc = database()->query($sql,array($eid,$site))->rowCount(); 
		if ($rc == 1) $alreadySent = true;
		else $alreadySent = false;
	}
    }
    if ($eid == "")  {
      header ("Location: error.php?type=eid&lang=$lang");
      exit;
    }  
	$vDate = getData ("visitDateDd", "textarea") . "/" . getData ("visitDateMm", "textarea") . "/" . getData ("visitDateYy", "textarea");
	$nxtDate = getData ("nxtVisitDd", "textarea") . "/" . getData ("nxtVisitMm", "textarea") . "/" . getData ("nxtVisitYy", "textarea");    
?>
<script type="text/javascript" src="include/formValidationExt.js"></script>
<script type="text/javascript">
	function unloadStoreKeyValuePairs(curStore) {
	    var jsonData = '';
	    for (i = 0; i < curStore.getCount(); i++) {
	        record = curStore.getAt(i);
	        if (record.get('selected')) {
		    jsonData += '"' + record.get('conceptKey') + '":"On",';
	        } else if (record.get('selected') > 0) 	 {
		    jsonData += '"' + record.get('conceptKey') + '":"' + record.get('selected') + '",';
		}
		if (record.get('specify') != '') {
		    jsonData += '"' + record.get('conceptKey') + '_specify":"' + record.get('specify') + '",';
		}
	    } 
	    curStore.commitChanges();
	    return jsonData;
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
							/* handle unselecting a selected radio
							if (curVal == '' || curVal == null) {
								curVal = "Off";
							} */
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
	
	function saveAllSections (panels, arrayList) {
		var obsData = {};
		var errFields = [];
		var errMsgs = [];
		var vDateArray = document.getElementById('vDate').value.split('/');
		var nxtdd = '';
		var nxtmm = '';
		var nxtyy = '';
		var nxtDate = document.getElementById('nxtVisitD2'); 

		if (nxtDate) {
			var nxtDateArray = nxtDate.value.split('/'); 
			if (nxtDateArray.length > 0) {    
				nxtdd = nxtDateArray[0];
				nxtmm = nxtDateArray[1];
				nxtyy = nxtDateArray[2];
			}                              
		}

		panels.forEach(function (panel) {
			postVar = fetchContainerContents(panel.id);
			postVar.each(function(conceptName, obsValue) {
				obsData[conceptName] = obsValue;
				ComponentErrors.getByName(conceptName).forEach(function(errorId) {
					errFields.push(conceptName);
					errMsgs.push(errorId);
				});
			});
		});
	
		/*
		  unloadStoreKeyValuePairs nees to be updated to work with non-string obsData
		if (arrayList != null) {
		    for (var i = 0; i < arrayList.length; i++) {
				obsData += unloadStoreKeyValuePairs(arrayList[i]);
		    } 
		} 
		*/
		var type = '<?=$type; ?>';
		Ext.Ajax.request({   
			waitMsg: 'Saving changes...',
			url: 'genericsave.php',
			params: {
				type: type,
				version: '<?=$version ?>',
				site: '<?=$site; ?>',
				lang: '<?=$lang; ?>',
				visitDateDd: vDateArray[0],
				visitDateMm: vDateArray[1],
				visitDateYy: vDateArray[2],
				nxtVisitDd: nxtdd,
				nxtVisitMm: nxtmm,
				nxtVisitYy: nxtyy, 
				eid: '<?=$eid; ?>', 
				pid: '<?=$pid; ?>',
				jsonData: Ext.util.JSON.encode(obsData),
				errFields: errFields.toString(),
				errMsgs: errMsgs.toString()
			},                                  
			callback:function(options, success, response){ 
				try {
					var responseData = Ext.util.JSON.decode(response.responseText);
					if (typeof(responseData.retcode) == 'number') {
						updateBannerIfChanged (); 
						if (responseData.retcode == 0) {
							Ext.MessageBox.alert('Fin', '<?=_('La fiche sauvée avec succès');?>');
						} else {
							Ext.MessageBox.alert('Fin', '<?=_('La fiche sauvée avec ');?>' + responseData.retcode + '<?=_(' erreurs');?>'); }
					} else { 
						Ext.MessageBox.alert('SaveFailedTry', responseData + '<?=_(": Veuillez fournir ce message d’erreur à votre administrateur!");?>'); 
					}
				} catch (response) { 
					Ext.MessageBox.alert('SaveFailedCatch', response + '<?=_(": Veuillez fournir ce message d’erreur à votre administrateur!");?>'); 
				}
			} 
		});  
	}
	
    function goBack() {
		<?="	location.href= 'allEnc.php?pid=$pid&lang=$lang&site=$site';\n";?>
    } 

/* special processing for hivPositiveN/hivPositiveA concepts */

toggleCheckbox = function () {
	var value = 0;
	var status = parent.document.getElementById('hivStatusId');
	var label = <? if (empty ($patientStatus)) echo "'" . $patStatusLabels[$lang][11] . "'"; else echo "'" . $patStatusLabels[$lang][$patientStatus]. "'"; ?>;
	if (this.getValue()) {
		value = 1;
		newHivLabel = label;
	} else { 
		value = 0;
		newHivLabel = '<?=$patStatusLabels[$lang][13];?>';
	} 
	newClinSumLinkLabel = '<a onclick="launchClinicalSummary(value)" href="#"><?=$sumTitle[$lang];?></a>';
	Ext.Ajax.request({
		url: 'jsonUtil.php',
		params: {
			task: 'toggleHivStatus',
			pid: '<?=$pid; ?>',
			value: value
		}
	});
};
 
Ext.ComponentMgr.onAvailable('hivPositiveN1', function() {
	this.on('check', toggleCheckbox);
})
Ext.ComponentMgr.onAvailable('hivPositiveA1', function() {
   		this.on('check', toggleCheckbox);
}) 

function transposeExtTableItems(items, columns, empty) {
    var output = [];

    var listColmplete = [];
    for (var i=0; i<items.length; i++) {
        var item = items[i];
        if ('rowspan' in item) {
            listColmplete.push(item);
            for (var j=1; j<item.rowspan; j++) {
                listColmplete.push({dummy: true});
            }
        } else {
            listColmplete.push(item);
        }
    }

    var extraCellsNeeded = columns - (listColmplete.length % columns);
    if (extraCellsNeeded == columns) {
        extraCellsNeeded = 0;
    }

    for (var i=0; i<extraCellsNeeded; i++) {
        listColmplete.push(empty);
    }

    var rows = listColmplete.length / columns;
    for (var y=0; y<rows; y++) {
        for (var x=0; x<columns; x++) {
            var item = listColmplete[y+x*rows];
            if (!('dummy' in item)) {
                output.push(listColmplete[y+x*rows]);
            }
        }
    }

    return output;
}

function changeHeaderGender (name, val) {
  var display = parent.document.getElementById('genderDisplayId');
  var labels = new Array ();
<? for ($z = 0; $z < count ($sex[$lang]); $z++) echo "  labels[" . $z . "] = '" . $sex[$lang][$z] . "';\n"; ?>
  if (val == true) {
    newSexLabel = labels[name.substring(3)];
  } else {
    newSexLabel = labels[3];
  }
}

function makeRadiosUncheckable (container) {
    var inputElements = container.getElementsByTagName("INPUT");
    var checkedRadios = new Array();

    for (var i=0; i<inputElements.length; i++) {
	if (inputElements[i].type == "radio") {
	    checkedRadios[inputElements[i].id] = inputElements[i].checked;
	    Ext.get(inputElements[i]).on({
		    click: {
			fn: function() {
			    var component = Ext.getCmp(this.id);
			    if (checkedRadios[this.id] == true) {
				component.setValue(false);
				checkedRadios[this.id] = false;
			    } else {
				var groupedRadios = document.getElementsByName(this.name);
				for (var j=0; j<groupedRadios.length; j++) {
				    checkedRadios[groupedRadios[j].id] = false;
				}
				component.setValue(true);
				checkedRadios[this.id] = true;
			    }
                            // change header display if gender is clicked
                            if (this.id == 'sex1' || this.id == 'sex2') {
                              changeHeaderGender(component.getId(), component.getValue());
                            }
			},
			delay: 100
		    }
		});
	}
    }
}
    
<?  if (DEBUG_FLAG) fb($GLOBALS['existingData'], 'globals'); ?>

<? $tabIndex = 2000; ?>

var encounterType = <?=$type ?>;

var isAdultEncounter = <?= $isAdultEncounter ? 'true' : 'false' ?>;
var isPediatricEncounter = <?= $isPediatricEncounter ? 'true' : 'false' ?>;
var isObgynEncounter = <?= $isObgynEncounter ? 'true' : 'false' ?>;

var isIntakeEncounter = <?= $isIntakeEncounter ? 'true' : 'false' ?>;
var isFollowupEncounter = <?= $isFollowupEncounter ? 'true' : 'false' ?>;

function renderVerticalTabForm(panels, southLabel) {  

    //Make radios uncheckable
    var uncheckableEventFunction = function () {
	var element = this.getEl().dom;
	if ('getElementsByTagName' in element) {
	    makeRadiosUncheckable(element);
	}
    };
    panels.forEach(function (panel) {
	    panel.on({
		    expand: {
			fn: uncheckableEventFunction,
			single: true
                    }
		});
	});
    //special treatment for the first panel which doesn't get expanded when first rendered
    panels[0].on({
	    afterrender: {
		fn: uncheckableEventFunction,
		single: true,
		delay: 100 //this shouldn't need to be here but it doesn't work without it
	    }
	});


    var gtp = new Ext.Panel({
		region: 'center',
		id: 'formSections',
		layout: 'accordion',
		autoScroll: true,
		layoutConfig: {
			// layout-specific configs go here
			titleCollapse: true,
			animate: true
		},
		items: [panels]
 }); 

/*
    var gtp = { 
	xtype: 'grouptabpanel', 
	region: 'center',
	id: 'formSections',
	activeGroup: 0, 
	tabWidth: 280,
	autoScroll: true,
    	items: panels.map(function (panel) {
		return {
		    mainItem: 0,
		    items: [panel]
		};
	    })
    };
*/	
    <?php include 'include/visitDatePanel.php'; ?>

    var vp = new Ext.Viewport({
	layout: 'border',
	id: 'vp',
	items: [ 
		visitDatePanel,
		gtp,
		footerPanel
	] 
     });
}

Ext.onReady(function() {
	    <?php include ($typeArray[$type] . "/" . $version . ".php"); ?>
});
</script>
<title><? echo ${$typeArray[$type] . 'FormTitle'}[$lang][1]; ?></title>

<style type="text/css">
/* These hide the tab group expansion + widget that normally appears to the left of each tab group. */
.x-grouptabs-expand {
    display: none;
}
.x-tab-panel-left .x-tab-panel-header ul.x-grouptabs-strip a.x-grouptabs-text {
    padding-left: 0px;
}

td.relativesPanel {
    text-align: center;
}

td.personalHistoryPanel {
    width: 38ex;
}

td.consultationPanel {
    width: 50ex;
}

td.proceduresPanel {
    width: 37ex;
}

td.diagnosisPanel {
    width: 55ex;
}

td.openElisPanel {
    width: 80ex;
}

td.physicalExamRadio {
    width: 14ex;
    text-align: center;
}

td.psychomotorHeader {
    width: 36ex;
    font-weight: bold;
    text-decoration: underline;
}

/* for vaccine on obgyn form */
.obVaccins td {
    border: 1px solid black;
}
td.obVaccineHeader {
    background-color: #eee;
    font-weight: bold;
    padding: 5px;
}
td.obVaccineColumnHeader {
    padding-left: 5px;
}

.birthControlTable table {
    width: 135ex;
}

td.birthPlanAlign {
    vertical-align: bottom;
}
td.birthPlanCenter {
    text-align: center;
    padding: 0px 0px 0px 1em;
}

</style>

</head>
<body> 
<form name="mainForm">
</form>
</body>
</html>
