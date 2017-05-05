<?
require_once 'include/standardHeaderExt.php';
require_once 'labels/report.php';
require_once 'labels/splash.php';  
?>
<script type="text/javascript" src="map/Ext.ux.GMapPanel3.js"></script>
<script type="text/javascript"> 
var fm = Ext.form;
function formatDate(value){
    return value ? value.dateFormat('Y-m-d') : '';
};
function formatDateShort(value){
    return value ? value.dateFormat('y-m') : '';
};
Ext.onReady(function() {  
	function copyText(text) {
		if (window.clipboardData) { // Internet Explorer
			window.clipboardData.setData("Text", "" + text);
		} else if (window.netscape) { // Mozilla 
			try {
				netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect');
				var gClipboardHelper = Components.classes["@mozilla.org/widget/clipboardhelper;1"].getService(Components.interfaces.nsIClipboardHelper);
				gClipboardHelper.copyString(text);
			} catch(e) {
				return alert(e + 'Please type: "about:config" in your address bar. Then filter by "signed". Change the value of "signed.applets.codebase_principal_support" to true. You should then be able to use this feature.');
			}
		} else { 
			return alert('Your browser may not support this feature');
		}
	};
	
	function gridToCsv (cm, store) {
		var gridData = '';
		for (j = 0; j < cm.getColumnCount(); j++) {
			if (gridData != '') gridData += ', ';
			gridData += cm.getColumnHeader(j)
		} 
		gridData += '\n';
		for (i=0; i < store.getCount(); i++) {
			record = store.getAt(i);
			flag = false;
			for (j = 0; j < cm.getColumnCount(); j++) {
				if (flag) gridData += ', ';
				flag = true;
				gridData += record.get(cm.getDataIndex(j));
			}
			gridData += '\n';
		} 
		Ext.getCmp('copyGrid').setValue(gridData);
		//document.mainForm.regcsv.value = gridData;
		//document.mainForm.submit();
		//localStorage.setItem("gridData", gridData);
		//document.write(localStorage.getItem("gridData")); 
		//alert(gridData);
		//copyText(gridData);
	}

	var record = new Ext.data.Record.create([
		{name: 'clinic', type: 'string'},
		{name: 'dbVersion', type: 'string'},
		{name: 'local', type: 'string'}, 
		{name: 'lastModified', type: 'string'},
		{name: 'primAdult', type: 'int'},
		{name: 'primPed', type: 'int'},
		{name: 'obgyn', type: 'int'},
		{name: 'primAdultForms', type: 'int'},
		{name: 'primPedForms', type: 'int'},
		{name: 'obgynForms', type: 'int'},
		{name: 'total', type: 'float'},
		{name: 'totalForms', type: 'float'}
	]);

	var reader = new Ext.data.JsonReader({root: 'results',totalProperty: 'total'}, record);

	var store = new Ext.data.Store({
		id: 'store',
		proxy: new Ext.data.HttpProxy({
			url: 'map/totals-primary.php'
		}),
		reader: reader,
		remoteSort: true
	}); 

    	store.load();
  
	var cm = new Ext.grid.ColumnModel([
		{header: '<?=_('Établissement');?>', dataIndex: 'clinic', type: 'string',  width: 250, sortable: true, fixed: true},
		{header: 'Version', dataIndex: 'dbVersion', type: 'string',  width: 75, fixed: true, align: 'right'},
		{header: '<?=$splashLabels[$lang]["dbSite"];?>', dataIndex: 'local', type: 'string',  width: 75, sortable: false, fixed: true, align: 'right', hideable: false},
		{header: '<?=$splashLabels[$lang]["recent"];?>', dataIndex: 'lastModified', type: 'string',  width: 100, sortable: true,  align: 'right', fixed: true},
		{header: 'PA', dataIndex: 'primAdult', type: 'int',  width: 60, sortable: false, align: 'right', fixed: true}, 
		{header: 'VPA', dataIndex: 'primAdultForms', type: 'int',  width: 60, sortable: false, align: 'right', fixed: true},
		{header: 'PP', dataIndex: 'primPed', type: 'int',  width: 60, sortable: false, align: 'right', fixed: true},
		{header: 'VPP', dataIndex: 'primPedForms', type: 'int',  width: 60, sortable: false, align: 'right', fixed: true},
		{header: 'OB', dataIndex: 'obgyn', type: 'int',  width: 60, sortable: false, align: 'right', fixed: true}, 
		{header: 'VOB', dataIndex: 'obgynForms', type: 'int',  width: 60, sortable: false, align: 'right', fixed: true},
		{header: 'Patients<br />total', dataIndex: 'total', type: 'float',  width: 100, sortable: false, align: 'right', fixed: true},
		{header: '<?=_('Fiche<br />total');?>', dataIndex: 'totalForms', type: 'float',  width: 100, sortable: false, align: 'right', fixed: true}
	]); 

	var grid = new Ext.grid.GridPanel({
		id: 'grid',
		store: store,
		cm: cm,
		stripeRows: true,
		height: 325,
		width: 1100,  
		frame: true,
		bbar: [
			{
				text: '<?=$splashLabels[$lang]["toClip"];?>', 
				id: 'splash-bbar-button',
				handler: function (){
					gridToCsv (cm, store);
				}
			}
		]
	});
	 
	<?	
	// format legend for bottom of hiv panel
	$statusMessage1 = array ("fr" => "<font color=\"blue\">Bleu</font>--Sites utilisant iSant&eacute; pendant moins de 90 jours.", "en" => "<font color=\"blue\">Blue</font>--Sites who have been using iSant&eacute; for 90 days or less.");
	$statusMessage2 = array ("fr" => "<font color=\"red\">Rouge</font>--Sites dont le transfert des donnees n\'a pas ete fait depuis au moins deux semaines.", "en" => "<font color=\"red\">Red</font>--Sites with no forms entered in the last two weeks.");
	?>
	
	var statusTab = Ext.DomHelper.append(document.body,{tag: 'iframe',name:'statusTab',id:'statusTab', layout:'fit',frameBorder: 0, src: 'statusTab.php',width: '100%', height: '100%'});
    var hiv = {
      xtype: 'panel',
      title: 'Dashboard VIH',
      layout: 'vbox',
      items: [statusTab]
  };

	
	var primary = {
		xtype: 'panel', 
		title: 'Dashboard soins de santé primaire',
		layout: 'vbox',
		items: [
			grid,
			{ xtype: 'panel',
			 	title: '<?=_('Légende');?>',
				items: [
					{xtype: 'label', html: '<?=_('PA: Patients adultes soins de santé primaires<br>');?>'},
					{xtype: 'label', html: '<?=_('VPA: Adulte visites soins de santé primaires<br>');?>'},
					{xtype: 'label', html: '<?=_('PP: Patients pédiatrique soins de santé primaires<br>');?>'},
					{xtype: 'label', html: '<?=_('VPP: Pédiatrique visites soins de santé primaires<br>');?>'},
					{xtype: 'label', html: '<?=_('OB: Patients ob-gyn<br>');?>'},
					{xtype: 'label', html: '<?=_('VOB: Visites ob-gyn<br>');?>'},
					{xtype: 'label', html: '<?=_('Remarques : ');?>'},
					{xtype: 'label', html: '<?=_('Les totaux sont cumulatifs à partir de 01.04.2011 à la date actuelle.<br>');?>'},
					{xtype: 'label', html: '<?=_('Totals des patients est inférieure à la somme de la zone de service totaux en raison de patients communs.');?>'}
				]
		        }
		]      	
	};
	
	var mapPanel = {
		xtype: 'gmappanel',  
    		zoomLevel: 8,
    		gmapType: 'map',
		height: 350,
		width: 800,
    		setCenter: {
			lat: 19.0,
			lng: -72.75
    		},
                mapConfOpts: ['enableScrollWheelZoom','enableDoubleClickZoom','enableDragging'],
                mapControls: ['GSmallMapControl','GMapTypeControl','NonExistantControl'],
    		markers: [ 
			<?
			$result = database()->query('select markerText from lastMarkers2 order by lastMarkersDate desc limit 1;');
			while ($row = $result->fetch()) {
				echo $row['markerText'];
			} 
			?> 
		]
	};
	
	var map = {
		xtype: 'panel', 
		title: 'Format Graphique',
		layout: 'vbox',
		items: [
			mapPanel,
			{ xtype: 'panel', title: '<?=_('Remarques');?>', 
				items: [
					{xtype: 'label', html: '<font color="green"><?=_('Vert');?></font> : <?=_('Serveur local<br>');?>'},
					{xtype: 'label', html: '<font color="blue"><?=_('Bleu');?></font> : <?=_('Utilisant le serveur d’asp.<br>');?>'},
					{xtype: 'label', html: '<?=_('Planez au-dessus d’un marqueur pour voir le nom d’emplacement.<br>');?>'},
					{xtype: 'label', html: '<?=_('Cliquez sur un marqueur pour voir l’information additionnelle d’emplacement.<br>');?>'},
					{xtype: 'label', html: '<?=_('Drague/baisse/bourdonnement au foyer dedans sur un secteur spécifique');?>'}
				]
		        }
		]      	
	};      

	var layout = new Ext.Viewport ({ 
		forceFit: true,
		hideMode: 'offsets',
		layout: 'border', 
		items:[
			{ xtype: 'box', region:'north', el:'banner', height: 67, margins: '<? if (preg_match('/(test|demo)/i', APP_VERSION) > 0) { echo "24 0 0 0"; } // Checks for test version, if yes msg displays via bannerbody ?>'},
			{ xtype: 'tabpanel', id: 'centerPanel', region: 'center', activeTab: <? if (! HIV_AUTH) echo "1"; else echo "0";?>, defaults: {autoScroll: true},
				items: [
					hiv,
					primary,
					map
				]
			},
			{ xtype: 'textarea', region: 'south', height: 20, width: 100, id: 'copyGrid', name: 'copyGrid'}
		] 
	});
});
</script>
</head>
<body>
<form name="mainForm" action="#" method="post">
<? include ("bannerbody.php"); ?>
<div class="contentArea">
</div> 
</form>
</body>
</html>
