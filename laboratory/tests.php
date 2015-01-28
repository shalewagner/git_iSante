
function doCheckbox (obj) {
	var itemArray = obj.id.split(':');
	if (obj.getValue(true)) {
       		var record = new sampleRec ({
				labGroup: itemArray[1],
				theType: itemArray[0],
				testNameFr: itemArray[2], 
				sampletype: itemArray[3],
				result: '---'
		});
		var records = a_labsDs.getRange();
		var doesnotExist = true;
		for(var i = 0; i < records.length; i++){
			var rec = records[i];
			if(itemArray[3].indexOf(rec.get('labid')) != -1) doesnotExist = false;
		}
		if (doesnotExist) { 
			var idArray = itemArray[3].split(',');
			if (idArray.length == 1 || !usingOE) insertRow(record); 
			else openSampleDialog(record);
		} 
	} else {
		var records = a_labsDs.getRange();
		for(var i = 0; i < records.length; i++){
			var rec = records[i];
			if(itemArray[3].indexOf(rec.get('labid')) != -1) {
				a_labsDs.removeAt(i);
				allDirty = true;
			}
		}
	}
};

function transposeExtTableItems(items, columns, empty) {
    var output = [];
    var listComplete = [];
    for (var i=0; i<items.length; i++) {
        var item = items[i];
        if ('rowspan' in item) {
            listComplete.push(item);
            for (var j=1; j<item.rowspan; j++) {
                listComplete.push({dummy: true});
            }
        } else {
            listComplete.push(item);
        }
    }

    var extraCellsNeeded = columns - (listComplete.length % columns);
    if (extraCellsNeeded == columns) {
        extraCellsNeeded = 0;
    }

    for (var i=0; i<extraCellsNeeded; i++) {
        listComplete.push(empty);
    }

    var rows = listComplete.length / columns;
    for (var y=0; y<rows; y++) {
        for (var x=0; x<columns; x++) {
            var item = listComplete[y+x*rows];
            if (!('dummy' in item)) {
                output.push(listComplete[y+x*rows]);
            }
        }
    }
    return output;
}

<?
$tabIndex = 10;

function consultationMakeEmpty() {
  return "{border: false, html: '&nbsp;', ctCls: 'consultationPanel'}";
} 

function makeCheckbox ($id, $lab, $panel) {
  if ($panel == 'P') {
    $lab = 'P : '.$lab;
    $panelCls = 'test-list-panel';
  }
  $output = "{
	xtype: 'checkbox', 
	id: '$id',
	boxLabel: '$lab',
  ctCls: '$panelCls',
	handler: function(b, e) { doCheckbox(b); }
  }";
  return $output;
} 

$groupArray = array ( 
        'dummy', 
        'Hematologie', 
        'Biochimie',  
        'Cytobacteriologie', 
        'Bacteriologie', 
        'ECBU', 
        'Parasitologie', 
        'Immuno-Virologie', 
        'Mycobacteriologie', 
        'Endocrinologie', 
        'Liquides biologique', 
        'Serologie', 
        'CDV', 
        'Autres Tests',  
        'Biologie moleculaire'
);

$colCount = array ( 0, 4, 7, 3, 2, 3, 2, 1, 2, 1, 1, 3, 1, 1, 2 );
 
$testPanelData = array();
$st = (getConfig('labOrderUrl') != NULL) ? '|",a.sampletype':'|iSanté"';
$sql5 = '(select b.labGroupLookup_id, "Test" as theType, replace(a.testNameFr,?,?) as testNameFr, group_concat(concat(a.labid,"' . $st . ')) as sampletype 
	from labLookup a, labGroupLookup b where (a.status = 2 or labid in (181,103) or labid between 300 and 312) and a.labgroup = b.labgroup group by 1,3)';
	if (getConfig('labOrderUrl') != NULL) $sql5 .= ' union
 	(select labGroupLookup_id, "Panel", panelName, concat(labPanelLookup_id,"|", sampletype) 
	from labGroupLookup a, labPanelLookup b where a.labGroup = b.labGroup group by 1,3)';
	$sql5 .= ' order by 1,2,3';
	 
$labitems = databaseSelect()->query($sql5, array("'","’"))->fetchAll(PDO::FETCH_ASSOC);
 
foreach($labitems as $row) { 
	$panel = 'P';
	if ($row['theType'] == 'Test') $panel = 'T';
	$tnf = $row['testNameFr'];
	$testPanelData[$row['labGroupLookup_id']][] = makeCheckbox ($panel . ":" . $groupArray[$row['labGroupLookup_id']] . ":" . $tnf . ":" . $row['sampletype'], $tnf, $panel); 
}  

for ($i = 1; $i < 15; $i++) {
	echo 
	"var tests" . $i . " = new Ext.FormPanel({
		title: '" . $groupArray[$i] . "',
		id: 'tests" . $i . "',
		autoHeight: true,
		autoScroll: true,
		padding: 5,
		defaults: {
		    border: false,
	            autoHeight: true
		},
		items: [{
      cls: 'checkbox-list',
			layout: {
				type: 'table',
				columns: " . $colCount[$i] . "
			},
			items: transposeExtTableItems([" . implode(",\n", $testPanelData[$i]) . "], " . $colCount[$i] . ", {xtype: 'label', text: ''})
		}]   
	});"; 
}
?>

var panels = [tests1 <? for ($i = 2; $i < 15; $i++) echo ",tests" . $i . "\n"; ?>];

var testLookupPanel = { 
	xtype: 'tabpanel', 
	id: 'testLookupPanel',
	activeTab: 0, 
	tabWidth: 280,
	autoScroll: true,
  border: false,
	items: [
		panels
	]
};

var enclosingPanel = {
	xtype: 'panel',
	id: 'enclosingPanel',
  cls: 'print-hide',
	layout: 'hbox',
        border: true,
        //defaults: { margins: '0 2'},
        flex: 0.3,
	items: [
		testLookupPanel
	],
	tbar: new Ext.Toolbar({
		items:[{
		        xtype: 'label',
		        text: '<?=$labLoc['tChoose'][$lang]?>'
		}, '-',
		{
		        xtype: 'label',
		        text: '<?=$labLoc['searchLabel'][$lang]?> :'
		},{
		        xtype: 'textfield',
		        id: 'searchField',
		        name: 'searchField'
		}, '-',{   
			xtype: 'button',
			id: 'searchButton', 
			autoWidth: true,
			text: '<?=$labLoc['searchButton'][$lang]?>',
			cls: 'formButton',
			height: 16,
			handler: function() {
				var sf = Ext.getCmp('searchField'); 
				var sv = sf.getValue().toLowerCase();      
				// finds any simple input widgets and fills them or checks them 
				var j = 0;
				var sample = [];
				for (var k = 1; k < 15; k++) {
					i = Ext.getCmp('tests'+k);     
					Ext.each(i.findByType('checkbox'), function ( a, b) { 
						record = a.id.split(':');
						if (record[2].toLowerCase().indexOf(sv) != -1) {
							sample[j] = [record[1], record[0], record[2], record[3], record[3]];
							j++;   
						}
					});                  
				}  
				if (j == 0) alert ('<?=$labLoc['searchNothing'][$lang]?>');
				else {
					sf.setValue('');
					sampleDs.loadData(sample);
					openSearchDialog();
				}
			} 
		}]
	})        
}; 
