<?  
function saveButtonHandler() {
	if ($_REQUEST['type'] == 6 || $_REQUEST['type'] == 19) {
		return "saveLabOrder();";
	} else {
		return "saveAllSections(panels, null);";
	}
}

function saveBut ($id) {
    $text = ($_REQUEST['lang'] == 'en') ? 'Save':'Sauvegarder';
    $retString = "{
		xtype: 'button',
		id: '" . $id . "',";
		if (getAccessLevel (getSessionUser ()) == 0 || SERVER_ROLE == "consolidated") $retString .= "disabled: true,";
	        $retString .= "autoWidth: true,
		text: '" . $text . "',
		cls: 'formButton',
		height: 24,
		handler: function(){\n" .
			saveButtonHandler() . "\n
		} 
	}"; 
	return $retString;
}

function returnBut ($id) {
	$text = ($_REQUEST['lang'] == 'en') ? 'All forms/return':'Toutes les fiches/Retourner';
	return "{
	xtype: 'button',
	id: '" . $id . "',
	autoWidth: true,
	text: '" . $text . "',
	cls: 'formButton',
	height: 24,
	handler: function() { 
		parent.location.href = 'patienttabs.php?pid=" . $_GET['pid'] . "&lang=" . $_GET['lang'] . "&site=" . $_GET['site'] . "&tab=forms';
	}                  
	}";
} 
?> 

function fillAllFields (panels) {
	panels.forEach(function (panel) {
		var parentContainer = panel.id;        
		// finds any simple input widgets and fills them or checks them
		parentContainer = Ext.getCmp(parentContainer);
		parentContainer.cascade(function(i) {  
			if ('items' in i && i.items.length > 0) {     
				Ext.each(i.findByType('field'), function ( a, b) {
					//alert(a.name);
					//if (a.name != null) { 
					    switch (a.getXType()) {
					    case 'datefield': 
							if (a.getValue() == null || a.getValue() == '') a.setValue('1988-08-08');
							break;
					    case 'checkbox':
					    case 'radio':
							a.setValue(true); 
							break;
					    case 'numberfield':
							if (a.getValue() == null || a.getValue() == '') a.setValue(99);
							break;
					    default:
							if (a.getValue() == '' || a.getValue() == null) a.setValue('merry christmas and happy new year');
					    }
					//}
				});                 
			}
		});            
	});
};

var headerPanel = new Ext.Toolbar ({
	header: false,
	layout: 'form', 
	id: 'header',
	closable: false,
	//height: <? echo (in_array($type, array(6,19))) ? 120:60 ?>,
	style: 'font-size: 12px; background-image: none; background-color: #8db2e3',
	items: [{
		xtype: 'label',
		text: '<? echo $encType[$lang][$type]; ?>',
    cls: 'print-hide',
		style: 'font-weight: bold; font-size: 16px; margin-bottom: 2px'
	},{
		xtype: 'checkboxgroup',
		columns: [200,100,125,200,<? if (DEBUG_FLAG) echo "200" ?>],
		style: 'margin-top: 4px; margin-left: -100px',
    cls: 'print-hide',
		items: [{
			xtype: 'datefield',
			fieldLabel: '<?=($_REQUEST['lang'] == 'en') ? 'Visit Date':'Date de visite'?>',
			labelAlign: 'left',
			labelStyle: 'width: 80px; font-size: 12px',
			cls: 'formDateBox',
			name: 'vDate',
			id: 'vDate',
			format: 'd/m/y',
			value: '<? echo $vDate; ?>'
		},{
			xtype: 'label',
			text: '<?= _('JJ/MM/AA') ?>',
			style: 'padding-left: 6px; line-height: 24px'
		},
		<?=saveBut('saveButtonHeader');?>
		,<?=returnBut('top');?>
		<? if (DEBUG_FLAG) echo ",{
			xtype: 'button',
			id: 'fillButton',
			autoWidth: true,
			text: '[FILL]',
			cls: 'formButton',
			height: 24,
			handler: function(){
				fillAllFields(panels);
			} 
		}";?>]   
	}
	<? if (in_array($type, array(6,19))) echo ",
		labHeader";
	?>
	]
}); 

var visitDatePanel = new Ext.Panel ({
	region: 'north',
	header: false,
	layout: 'form',
	id: 'visitdate',
	height: <? echo (in_array($type, array(6,19))) ? 118:60 ?>,
	closable: false,
	items: [
		headerPanel
        ]
});

var footerPanel = new Ext.Toolbar({
	region: 'south',
	title: 'footer',
	header: false,
	layout: 'fit', 
	id: 'footer',
	closable: false,
	height: 40,
	defaults: { labelStyle: 'font-size:12pt;font-weight:bold;color:#444444;background-color:#8db2e3;padding:6px;text-align:left;' },
	style: 'padding: 6px 12px; font-size: 12px; background-image: none; background-color: #8db2e3',
	items: [{
		xtype: 'checkboxgroup',
		columns: [150,250,600],
		items: [
		<?=saveBut('saveButtonFooter');?>
		,<?=returnBut('bottom');?>
		,{
			xtype: 'label',
			text: southLabel
		}] 
	}]           
});
