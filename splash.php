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
	<?php
		$result = database()->query('select splashText from lastSplashText order by lastSplashText_id');
		while ($row = $result->fetch()) {
			echo str_replace('X', "\'", $row['splashText']);
		} 	?>
	var hivStore = new Ext.data.SimpleStore({
	    fields: [
			{name: 'clinic', type: 'string'},
			{name: 'sitecode', type: 'string'},
			{name: 'dbVersion', type: 'string'},
			{name: 'local', type: 'string'},
			{name: 'modifyDate', type: 'date', format: 'Y-m-d'},
			{name: 'minDate', type: 'date', format: 'Y-m-d'},
			{name: 'preRecent', type: 'string'},
			{name: 'preActive', type: 'string'},
			{name: 'preLost', type: 'string'},
			{name: 'preTransf', type: 'string'},
			{name: 'preDeces', type: 'string'},
			{name: 'preTotal', type: 'string'},
			{name: 'artRegulier', type: 'string'},
			{name: 'artMissing', type: 'string'},
			{name: 'artLost', type: 'string'},
			{name: 'artStop', type: 'string'},
			{name: 'artTransf', type: 'string'},
			{name: 'artDeces', type: 'string'},
			{name: 'artTotal', type: 'string'},
			{name: 'Total', type: 'string'}
		],
		sortInfo:{
			field:'modifyDate', direction:'DESC'
		}
	});

	hivStore.loadData(myData);

	var spcm = new Ext.grid.ColumnModel([
		{header: '<?=_('Établissement');?>', dataIndex: 'clinic', type: 'string',  width: 250, sortable: true, fixed: true, hideable: true},
		{header: '<?=$splashLabels[$lang]["sitecode"];?>', dataIndex: 'sitecode', type: 'string',  width: 300, sortable: true, fixed: true, hideable: true, hidden: true},
		{header: 'Version', dataIndex: 'dbVersion', type: 'string',  width: 65, fixed: true, align: 'right', hideable: true},
		{header: '<?=$splashLabels[$lang]["dbSite"];?>', dataIndex: 'local', type: 'string',  width: 65, sortable: false, fixed: true, align: 'right', hideable: true},
		{header: '<?=$splashLabels[$lang]["recent"];?>', dataIndex: 'modifyDate', type: 'date',  width: 100, sortable: true,  align: 'right', renderer: formatDate, fixed: true, hideable: true},
		{header: '<?=$splashLabels[$lang]["minDate"];?>', dataIndex: 'minDate', type: 'date',  width: 100, sortable: true,  align: 'right', renderer: formatDate, fixed: true, hideable: true},
		{header: '<?=$splashLabels[$lang]["preRecent"];?>', dataIndex: 'preRecent', type: 'string',  width: 75, sortable: false, align: 'center', fixed: true, hideable: true},
		{header: '<?=$splashLabels[$lang]["preActive"];?>', dataIndex: 'preActive', type: 'string',  width: 75, sortable: false, align: 'center', fixed: true, hideable: true},
		{header: '<?=$splashLabels[$lang]["preLost"];?>', dataIndex: 'preLost', type: 'string',  width: 75, sortable: false, align: 'center', fixed: true, hideable: true},
		{header: '<?=$splashLabels[$lang]["preTransf"];?>', dataIndex: 'preTransf', type: 'string',  width: 75, sortable: false, align: 'center', fixed: true, hideable: true},
		{header: '<?=$splashLabels[$lang]["preDeces"];?>', dataIndex: 'preDeces', type: 'string',  width: 75, sortable: false, align: 'center', fixed: true, hideable: true},
		{header: '<?=$splashLabels[$lang]["total"];?>', dataIndex: 'preTotal', type: 'string',  width: 65, sortable: true, align: 'center', fixed: true, hideable: true},
		{header: '<?=$splashLabels[$lang]["artRegulier"];?>', dataIndex: 'artRegulier', type: 'string',  width: 70, sortable: false, align: 'center', fixed: true, hideable: true},
		{header: '<?=$splashLabels[$lang]["artMissing"];?>', dataIndex: 'artMissing', type: 'string',  width: 70, sortable: false, align: 'center', fixed: true, hideable: true},
		{header: '<?=$splashLabels[$lang]["artLost"];?>', dataIndex: 'artLost', type: 'string',  width: 70, sortable: false,  align: 'center', fixed: true, hideable: true},
		{header: '<?=$splashLabels[$lang]["artStop"];?>', dataIndex: 'artStop', type: 'string',  width: 70, sortable: false,  align: 'center', fixed: true, hideable: true},
		{header: '<?=$splashLabels[$lang]["artTransf"];?>', dataIndex: 'artTransf', type: 'string',  width: 70, sortable: false,  align: 'center', fixed: true, hideable: true},
		{header: '<?=$splashLabels[$lang]["artDeces"];?>', dataIndex: 'artDeces', type: 'string',  width: 70, sortable: false,  align: 'center', fixed: true, hideable: true},
		{header: '<?=$splashLabels[$lang]["total"];?>', dataIndex: 'artTotal', type: 'string',  width: 70, sortable: true,align: 'center', fixed: true, hideable: true},
		{header: '<?=$splashLabels[$lang]["grandTotals2"];?>', dataIndex: 'Total', type: 'string',  width: 170, sortable: true, align: 'center', fixed: true, hideable: true}
	]);

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

	var spgrid = new Ext.grid.GridPanel({
		id: 'spgrid',
		//autoresize: true,
		store: hivStore,
		cm: spcm,
		stripeRows: true,
		height: 400,
		width: 1780,
		stripeRows: true,
		frame: true,
		//footer: true,
		tbar: [
			{ xtype: 'field',id: 'xxx', name: 'xxx', width: 585, readOnly: true},
			{ xtype: 'field',id: 'yyy', name: 'yyy', width: 445, value: '<?=$splashLabels[$lang]["inClinic"];?>', style: 'text-align: center', readOnly: true},
			{ xtype: 'field',id: 'zzz', name: 'zzz', width: 498, value: '<?=$splashLabels[$lang]["onART"];?>', style: 'text-align: center', readOnly: true},
			{ xtype: 'field',id: 'xx3',name: 'xx3', width: 170, value: '<?=$splashLabels[$lang]["grandTotals"];?>', style: 'text-align: center', readOnly: true}
		],
		bbar: [
			{
				text: '<?=$splashLabels[$lang]["toClip"];?>', 
				id: 'splash-bbar-button',
				handler: function (){
					gridToCsv (spcm, hivStore);
				}
			},
			{ xtype: 'field',id: 'bbb', name: 'bbb', type: 'string',  width: 160,readOnly: true, style: 'text-align: right', value: '<?=$splashLabels[$lang]["grandTotals"];?>:'},
			{ xtype: 'field',id: 'ccc', name: 'ccc', type: 'string',  width:  50, readOnly: true, style: 'text-align: right', value: totalVector[3]},
			{ xtype: 'field',id: 'ddd', name: 'ddd', type: 'string',  width: 50, style: 'text-align: right', value: totalVector[2]},
			{ xtype: 'field',id: 'eee', name: 'eee', type: 'string',  width: 215, readOnly: true},
			{ xtype: 'field',id: 'preRecent', name: 'preRecent', type: 'string',  width: 75, readOnly: true, style: 'text-align: center;', value: totalVector[4], hideable: true},
			{ xtype: 'field',id: 'preActive', name: 'preActive', type: 'string',  width: 75, readOnly: true, style: 'text-align: center', value: totalVector[5]},
			{ xtype: 'field',id: 'preLost', name: 'preLost', type: 'string',  width: 75, readOnly: true, style: 'text-align: center', value: totalVector[6], hideable: true},
			{ xtype: 'field',id: 'preTransf', name: 'preTransf', type: 'string',  width: 75, readOnly: true, style: 'text-align: center', value: totalVector[7]},
			{ xtype: 'field',id: 'preDeces', name: 'preDeces', type: 'string',  width: 75, readOnly: true, style: 'text-align: center', value: totalVector[8]},
			{ xtype: 'field',id: 'preTotal', name: 'preTotal', type: 'string',  width: 65, readOnly: true, style: 'text-align: center', value: totalVector[9]},
			{ xtype: 'field',id: 'artRegulier', name: 'artRegulier', type: 'string',  width: 70, readOnly: true, style: 'text-align: center', value: totalVector[10], hideable: true},
			{ xtype: 'field',id: 'artMissing', name: 'artMissing', type: 'string',  width: 70, style: 'text-align: center', value: totalVector[11]},
			{ xtype: 'field',id: 'artLost', name: 'artLost', type: 'string',  width: 70, style: 'text-align: center', value: totalVector[12], hideable: true},
			{ xtype: 'field',id: 'artStop', name: 'artStop', type: 'string',  width: 70, style: 'text-align: center', value: totalVector[13]},
			{ xtype: 'field',id: 'artTransf', name: 'artTransf', type: 'string',  width: 70, style: 'text-align: center', value: totalVector[14]},
			{ xtype: 'field',id: 'artDeces', name: 'artDeces', type: 'string',  width: 70, style: 'text-align: center', value: totalVector[15]},
			{ xtype: 'field',id: 'artTotal', name: 'artTotal', type: 'string',  width: 70, style: 'text-align: center', value: totalVector[16], hideable: true},
			{ xtype: 'field',id: 'Total', name: 'Total', type: 'string',  width: 170, readOnly: true, style: 'text-align: center', value: totalVector[17]}
		]
	});
<? if (getConfig('serverRole') == 'consolidated') echo "/*"; ?>
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
<? if (getConfig('serverRole') == 'consolidated') echo "*/"; ?>
	<?	
	// format legend for bottom of hiv panel
	$statusMessage1 = array ("fr" => "<font color=\"blue\">Bleu</font>--Sites utilisant iSant&eacute; pendant moins de 90 jours.", "en" => "<font color=\"blue\">Blue</font>--Sites who have been using iSant&eacute; for 90 days or less.");
	$statusMessage2 = array ("fr" => "<font color=\"red\">Rouge</font>--Sites dont le transfert des donnees n\'a pas ete fait depuis au moins deux semaines.", "en" => "<font color=\"red\">Red</font>--Sites with no forms entered in the last two weeks.");
	?>
	
	var hiv = {
		xtype: 'panel',
		title: 'Dashboard VIH',
		layout: 'vbox',
		items: [
			spgrid,
			{ xtype: 'panel',
			 	title: 'Légende',
				items: [
					{xtype: 'label', html: '<?=$statusMessage1[$lang];?><br />'},
					{xtype: 'label', html: '<?=$statusMessage2[$lang];?><br />'},
					{xtype: 'label', html: '<?=_('* Autre : Patients en soins de santé primaires (adulte, pédiatrique, ob-gyn) et les patients avec fiche d’enregistrement seulement');?>'}
				]
		        }]
		
	};
<? if (getConfig('serverRole') == 'consolidated') echo "/*"; ?>
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
<? if (getConfig('serverRole') == 'consolidated') echo "*/"; ?>
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
<? if (getConfig('serverRole') != 'consolidated') echo "					primary,"; ?>
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
