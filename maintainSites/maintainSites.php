Ext.onReady(function(){
	//var win;
	var task;
	var depts = new Ext.data.ArrayStore({
		id: 'depts',
		fields: ['dept','department'],
		data: [
		 	 ['',''],
			 ['Artibonite','Artibonite'],                    
			 ['Centre','Centre'],                            
			 ['Grande-anse','Grande-anse'],                  
			 ['Nippes','Nippes'],                            
			 ['Nord','Nord'],                                
			 ['Nord-est','Nord-est'],                        
			 ['Nord-ouest','Nord-ouest'],                    
			 ['Ouest','Ouest'],                              
			 ['Sud','Sud'],                                  
			 ['Sud-est','Sud-est'] 
		]
	});
	
	var deptCombo = { 
		xtype: 'combo', hiddenName: 'sdept', id: 'sdept', typeAhead: true, triggerAction: 'all', lazyRender:true, mode: 'local', 
		store: depts, valueField: 'dept', displayField: 'department', fieldLabel: '<?=_('Département');?>', value: ''
	};  
	
	var dcombo = { 
		xtype: 'combo', hiddenName: 'dcombo', id: 'dcombo', typeAhead: true, triggerAction: 'all', lazyRender:true, mode: 'local', 
		store: depts, valueField: 'dept', displayField: 'department', fieldLabel: '<?=_('Département');?>', value: '', allowBlank: false
	};
	
	var communes = new Ext.data.ArrayStore({
		id: 'communes',
		fields: [ 'comm', 'commune'],
		data: [
			<?php 
				$flag = false;
				$result = database()->query('select distinct commune from clinicLookup order by 1'); 
				while ($row = $result->fetch()) {
					if ($flag) echo ","; 
					echo "['" . $row['commune'] . "','" . $row['commune'] . "']";  
					$flag = true;
				}
			?> 
		] 
	}); 
	
	var communeCombo = { 
		xtype: 'combo', hiddenName: 'scommune', id: 'scommune', typeAhead: true, triggerAction: 'all', lazyRender:true, mode: 'local', 
		store: communes, valueField: 'comm', displayField: 'commune', fieldLabel: '<?=_('Commune');?>', value: ''
	};
	
	var ccombo = { 
		xtype: 'combo', hiddenName: 'ccombo', id: 'ccombo', typeAhead: true, triggerAction: 'all', lazyRender:true, mode: 'local', 
		store: communes, valueField: 'comm', displayField: 'commune', fieldLabel: '<?=_('Commune');?>', value: '', allowBlank: false
	};
	
	var networks = new Ext.data.ArrayStore({
		id: 'networks',
		fields: [ 'net', 'network'],
		data: [
			<?php
				$result = database()->query('select distinct network from clinicLookup order by 1');
				$flag = false;
				while ($row = $result->fetch()) {
					if ($flag) echo ","; 
					echo "['" . $row['network'] . "','" . $row['network'] . "']";
					$flag = true;
				}
			?> 
		] 
	}); 
	
	var networkCombo = { 
		xtype: 'combo', hiddenName: 'snetwork', id: 'snetwork', typeAhead: true, triggerAction: 'all', lazyRender:true, mode: 'local', 
		store: networks, valueField: 'net', displayField: 'network', fieldLabel: '<?=_('Réseau');?>', value: ''
	};
	
	var ncombo = { 
		xtype: 'combo', hiddenName: 'ncombo', id: 'ncombo', typeAhead: true, triggerAction: 'all', lazyRender:true, mode: 'local', 
		store: networks, valueField: 'net', displayField: 'network', fieldLabel: '<?=_('Réseau');?>', value: ''
	};

	var refreshGrid = {
		xtype: 'button',
		cls: 'formButton',
		text: '<?=_('Recherche');?>',
		handler: function (){ 
			var cntField = Ext.getCmp('echoCount');
			cntField.setText('');
			store.load({
				params: {
					department: Ext.getCmp('sdept').getValue(),
					commune: Ext.getCmp('scommune').getValue(), 
					clinic: Ext.getCmp('sclinic').getValue(),
					network: Ext.getCmp('snetwork').getValue(),
					sitecode: Ext.getCmp('ssitecode').getValue(),
					incphr: Ext.getCmp('sincphr').getValue() 
				},
				callback: function(r,options,success) {
					cntField.setText(store.getTotalCount() + '<?=_(' établissements répondent ce à des critères.');?>');
				}
			}); 
		}
	};
	
	searchForm = { 
		xtype: 'panel',
		layout: 'hbox',
		width: 300,
		defaults: { style: 'padding: 6px 12px; font-size: 12px' },  
		items: [
			{ xtype: 'form', width: 350,
				items: [
					{ xtype: 'label', text: '<?=_('Critères de recherche :');?>'},
					deptCombo,
					communeCombo,
					{xtype: 'textfield', name: 'sclinic', id: 'sclinic', fieldLabel: '<?=_('Établissement');?>', value: ''},
					{xtype: 'textfield', name: 'ssitecode', id: 'ssitecode', fieldLabel: '<?=_('Code de Site');?>', value: ''},
					networkCombo,
					{xtype: 'checkbox', name: 'sincphr', id: 'sincphr', fieldLabel: '<?=_('iSanté seulement');?>', checked: true},
					refreshGrid
				]
			}  
		]
	}; 
	
	var record = new Ext.data.Record.create([
		{name: 'incphr', type: 'boolean'},
		{name: 'department', type: 'string'},
		{name: 'commune', type: 'string'},
		{name: 'clinic', type: 'string'},
		{name: 'category', type: 'string'},
		{name: 'type', type: 'string'},
		{name: 'sitecode', type: 'int'},
		{name: 'dbsite', type: 'int'},
		{name: 'ipAddress', type: 'string'},
		{name: 'network', type: 'string'},
		{name: 'lat', type: 'float'},
		{name: 'lng', type: 'float'},
		{name: 'dbVersion', type: 'string'}
	]);

	var reader = new Ext.data.JsonReader({root: 'data',totalProperty: 'total'}, record);

	var store = new Ext.data.Store({
		id: 'store', 
		baseParams: {
			department: '',
			commune: '', 
			clinic: '',
			network: '',
			sitecode: '',
			incphr: 'true'
		},
		proxy: new Ext.data.HttpProxy({
			url: 'maintainSites/siteService.php',
			method: 'GET'
		}),
		reader: reader,
		remoteSort: true
	}); 

	store.load({
		callback: function(r,options,success) {
			var ec = Ext.getCmp('echoCount')
			ec.setText(store.getTotalCount() + '<?=_(' établissements répondent ce à des critères.');?>');
		}
	});
	
	var colModel = new Ext.grid.ColumnModel({
	    defaults: {
	        sortable: false,
	        menuDisabled: true,
	        width: 90
	    },
	    columns: [
			new Ext.grid.CheckColumn({ header: '<?=_('iSanté');?>', type: 'bool', editable: false, dataIndex: 'incphr', width: 50}),
			{ header: '<?=_('Département');?>',   type: 'string', dataIndex: 'department'},
			{ header: 'Commune',                  type: 'string', dataIndex: 'commune'},
			{ header: '<?=_('Établissement');?>', type: 'string', dataIndex: 'clinic', width: 200},
	        	{ header: '<?=_('Réseau');?>',        type: 'string', dataIndex: 'network'},
			{ header: '<?=_('Code de Site');?>',  type: 'int',    dataIndex: 'sitecode', width: 65, css: 'body { margin:0;padding:0;} .right {float:right;}'},
			{ header: 'Dbsite ',                  type: 'int',    dataIndex: 'dbsite', width: 50, css: 'float: right'},
			{ header: 'IP Address',               type: 'string', dataIndex: 'ipAddress'},
			{ header: 'Latitude',                 type: 'float',  dataIndex: 'lat', width: 75},
			{ header: 'Longitude',                type: 'float',  dataIndex: 'lng', width: 75},
			{ header: '<?=_('Category');?>',      type: 'string', dataIndex: 'category', width: 65}, 
			{ header: '<?=_('Type');?>',          type: 'string', dataIndex: 'type', width: 65}, 
			{ header: 'DB Version',               type: 'string', dataIndex: 'dbVersion', width: 65}
	    ]
	});
	
	var echoCount = {
		xtype: 'label',
		id: 'echoCount',
		text: '0'
	}; 

	var dbsiteList = new Ext.data.ArrayStore({
		id: 'dbsiteList',
		fields: [ 'dbsite', 'dbsiteDisplay'],
		data: [
			[0,0],
			<?php 
				$qry = 'select distinct dbsite+1 as dbsite from clinicLookup 
					where dbsite+1 not in (select dbsite 
					from clinicLookup) and dbsite+1 between 10 and 200 order by 1'; 
				$result = database()->query($qry);
				$flag = false;
				while ($row = $result->fetch()) {
					if ($flag) echo ","; 
					echo "['" . $row['dbsite'] . "','" . $row['dbsite'] . "']"; 
					$flag = true;
				}
			?> 
		] 
	});
	
	var dbcombo = { 
		xtype: 'combo', hiddenName: 'dbcombo', id: 'dbcombo', typeAhead: true, triggerAction: 'all', lazyRender:true, mode: 'local', 
		store: dbsiteList, valueField: 'dbsite', displayField: 'dbsiteDisplay', fieldLabel: '<?=_('Dbsite');?>', value: 0
	};
	
	
	var catstore = new Ext.data.ArrayStore({
		id: 'catstore',
		fields: [ 'cat', 'category'],
		data: [
			<?php
				$result = database()->query('select distinct category from clinicLookup order by 1'); 
				$flag = false;
				while ($row = $result->fetch()) { 
					if ($flag) echo ",";
					echo "['" . $row['category'] . "','" . $row['category'] . "']";
					$flag = true;  
				}
			?>
		] 
	});

	var catcombo = {
		xtype: 'combo', hiddenName: 'catcombo', id: 'catcombo', typeAhead: true, triggerAction: 'all', lazyRender:true, mode: 'local',
		store: catstore, valueField: 'cat', displayField: 'category', fieldLabel: '<?=_('Category');?>', value: ''
	} 
	
	var typestore = new Ext.data.ArrayStore({
		id: 'typestore',
		fields: [ 'type', 'typeDisplay'],
		data: [
			<?php
				$result = database()->query('select distinct type from clinicLookup order by 1'); 
				$flag = false;
				while ($row = $result->fetch()) {
					if ($flag) echo ",";
					echo "['" . $row['type'] . "','" . $row['type'] . "']"; 
					$flag = true;
				}
			?>
		] 
	});

	var typecombo = {
		xtype: 'combo', hiddenName: 'typecombo', id: 'typecombo', typeAhead: true, triggerAction: 'all', lazyRender:true, mode: 'local',
		store: typestore, valueField: 'type', displayField: 'typeDisplay', fieldLabel: '<?=_('Type');?>', value: ''
	}
      
	var window = new Ext.Window({
		title: 'Edit Site',
		id: 'wnd',
		el:'hello-win',
		closable: true,
		closeAction: 'hide',
		width: 600,
		minWidth: 350,
		height: 400,
		layout: 'form',
		bodyStyle: 'padding: 5px;',
		items: [
			{ fieldLabel: 'iSanté ?', xtype: 'checkbox',  name: 'fincphr', id: 'fincphr'}, 
			dcombo,
			ccombo,
			{ fieldLabel: 'Établissement', xtype: 'textfield', name: 'fclinic', id: 'fclinic', allowBlank:false, width: 350},
			catcombo,
			typecombo,
			dbcombo,
			{ fieldLabel: 'Code de Site&nbsp;', xtype: 'numberfield', name: 'fsitecode', id: 'fsitecode', allowBlank:false, maxLength: 5, minLength: 5, maxLengthText: 'Site code must be 5 digits', minLengthText: 'Site code must be 5 digits'},
			{ fieldLabel: 'IP Address', xtype: 'textfield', name: 'fipAddress', id: 'fipAddress'},
			ncombo,
			{ fieldLabel: 'Latitude', xtype: 'numberfield', name: 'flat', id: 'flat', decimalSeparator: '.', minValue: 18, maxValue: 20},
			{ fieldLabel: 'Longitude', xtype: 'numberfield', name: 'flng', id: 'flng', decimalSeparator: '.', minValue: -75, maxValue: -71},
			{ xtype: 'panel', header: false, layout: 'hbox', closable: false, height: 20, width: 200, defaults: {cls: 'formButton'},
			    items: [ 
				 { text: '<?=_('Sauvegarder');?>', xtype: 'button', name: 'submitButton', id: 'submitButton',
					height: 18,
					handler: function() { 
						var win = Ext.getCmp('wnd');
						var dept = Ext.getCmp('dcombo').getValue();
						var commune = Ext.getCmp('ccombo').getValue();
						var sc = Ext.getCmp('fsitecode').getValue(); 
						var clinic = Ext.getCmp('fclinic').getValue();
						if (dept === '') alert('Department must be chosen')
						else if (commune === '') alert('Commune must be chosen') 
						else if (clinic === '') alert('Établissement must be filled in') 
						else if (sc < 10000 || sc > 99999) alert('Sitecode must be 5 digits')
						else
						    Ext.Ajax.request({
							waitMsg: 'submitting changes...',
							url: 'maintainSites/siteService.php', 
							method: 'POST',
							params: {
								task: task,
								incphr: Ext.getCmp('fincphr').getValue(), 
								department: Ext.getCmp('dcombo').getValue(),
								commune: Ext.getCmp('ccombo').getValue(),
								clinic: Ext.getCmp('fclinic').getValue(),
								ipAddress: Ext.getCmp('fipAddress').getValue(),
								dbsite: Ext.getCmp('dbcombo').getValue(),
								sitecode: Ext.getCmp('fsitecode').getValue(),
								network: Ext.getCmp('ncombo').getValue(),
								lat: Ext.getCmp('flat').getValue(),
								lng: Ext.getCmp('flng').getValue(),
								category: Ext.getCmp('catcombo').getValue(),
								type: Ext.getCmp('typecombo').getValue()
							},
							callback: function (options, success, response) { 
								var responseData = Ext.util.JSON.decode(response.responseText);
								if (success) { 
									alert(responseData['message']);
									win.hide(); 
									document.forms[0].submit();
								} else {
									alert(responseData['message']);
								}
							}
						});
					}  
				},
				{ xtype: 'label', width: 30},
				{ text: '<?=_('Annuler');?>', xtype: 'button', name: 'cancelButton', id: 'cancelButton',
					height: 18,
					handler: function() {
						var win = Ext.getCmp('wnd'); 
						win.hide();
					}                       
				}
     					    ]           
			}
		] 
	});
	
	//buildValidation(98, makeTestInNumericRange('flat', 18, 20));
	//buildValidation(99, makeTestInNumericRange('flng', -75, -71)); 
	
	function doWindow(sr) {
		var win = Ext.getCmp('wnd');
		if (sr == null) {
			task = 'insert';  
			win.setTitle('<?=_('Ajoutez l’etablissement');?>');
			Ext.getCmp('fincphr').setValue(true); 
			Ext.getCmp('dcombo').setValue('');
			Ext.getCmp('ccombo').setValue(''); 
			Ext.getCmp('fclinic').setValue('');
			Ext.getCmp('catcombo').setValue('');
			Ext.getCmp('typecombo').setValue('');
			Ext.getCmp('fipAddress').setValue('');                                                              
			Ext.getCmp('dbcombo').setValue(0); 
			Ext.getCmp('dbcombo').enable();
			Ext.getCmp('fsitecode').setValue('');
			Ext.getCmp('fsitecode').enable();
		        Ext.getCmp('ncombo').setValue('');
			Ext.getCmp('flat').setValue();
			Ext.getCmp('flng').setValue();
		} else {
			task = 'update';
			win.setTitle('<?=_('Éditez l’etablissement');?>'); 
			Ext.getCmp('fincphr').setValue(sr.get('incphr')); 
			Ext.getCmp('dcombo').setValue(sr.get('department'));
			Ext.getCmp('ccombo').setValue(sr.get('commune')); 
			Ext.getCmp('fclinic').setValue(sr.get('clinic'));
			Ext.getCmp('catcombo').setValue(sr.get('category'));
			Ext.getCmp('typecombo').setValue(sr.get('type'));
			Ext.getCmp('fipAddress').setValue(sr.get('ipAddress')); 
			// if the dbsite value is 0, then it is ok to change it, otherwise the combo is disabled
			var curDbsiteVal = sr.get('dbsite');
			if (curDbsiteVal > 0) Ext.getCmp('dbcombo').disable();                                                             
			Ext.getCmp('dbcombo').setValue(curDbsiteVal);
			Ext.getCmp('fsitecode').setValue(sr.get('sitecode'));
			Ext.getCmp('fsitecode').disable();
		        Ext.getCmp('ncombo').setValue(sr.get('network'));
			Ext.getCmp('flat').setValue(sr.get('lat'));
			Ext.getCmp('flng').setValue(sr.get('lng')); 
		} 
		win.show();
	} 
	
	var editSite = {
		xtype: 'button',
		cls: 'formButton',
		text: '<?=_('Éditez l’etablissement');?>',
		handler: function() {
			var grid = Ext.getCmp('grid'); 
			var sr = grid.getSelectionModel().getSelected();
			if (sr == null) {
				alert('<?=_('Veuillez choisir un établissement.');?>');
			} else {
				doWindow(sr); 
			}
		}
	};
	
	var unloadSite = { 
		xtype: 'button', 
		cls: 'formButton',
		text: '<?=_('Déchargez les données d’etablissement');?>',  
		handler: function() {
			var sr = Ext.getCmp('grid').getSelectionModel().getSelected();
			if (sr == null) {
				alert ('<?=_('Veuillez choisir un établissement.');?>');
			} else {
				// fetch the selected sitecode here and pass it to the ajax call
				Ext.Ajax.request({   
					url: 'maintainSites/siteService.php',
					method: 'GET',
					params: {
						task: 'unload',
						sitecode: sr.get('sitecode'),
						clinic: sr.get('clinic')
					},
					failure:function(response,options){
						alert('Oops...');
					},                                  
					success:function(response,options){
						alert('Des données seront déchargées à /var/backups/itech/unloads/' + sr.get('sitecode') + '.csv.gz, mais peuvent prendre à 3 heures pour finir.\r\nVous devez attendre pour la décharger à terminer avant de copier le fichier');
					} 
				}); 
			}     
		} 
	};
	
	var getGzFile = {
		xtype: 'button',
		cls: 'formButton',
		text: 'Copier le fichier GZ',
		handler: function() {
			var sr = Ext.getCmp('grid').getSelectionModel().getSelected();
			if (sr == null) {
				alert ('<?=_('Veuillez choisir un établissement.');?>');
			} else {
				document.location = './maintainSites/getGzFile.php?file=' + sr.get('sitecode') + '.csv.gz';
			}      
		}
	} 
	
	var getStatsFile = {
		xtype: 'button',
		cls: 'formButton',
		text: 'Copier le fichier {sitecode}.txt',
		handler: function() {
			var sr = Ext.getCmp('grid').getSelectionModel().getSelected();
			if (sr == null) {
				alert ('<?=_('Veuillez choisir un établissement.');?>');
			} else {
				document.location = './maintainSites/getGzFile.php?file=' + sr.get('sitecode') + '.txt';
			}      
		}
	}

	var addSite = {
		xtype: 'button',
		cls: 'formButton',
		text: '<?=_('Ajoutez l’etablissement');?>',
		handler: function() { 
			doWindow(null); 
		}
	};
	
	var siteGrid = new Ext.grid.GridPanel({ 
		id: 'grid',
		store: store,
		cm: colModel, 
		width: 1100,
		height: 500, 
		autoScroll: true,
		stripeRows: true, 
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: true
		}), 
		tbar: [editSite, '-', unloadSite, '-', getGzFile, '-', getStatsFile, '-', addSite],
		bbar: [echoCount]
	});
	
	var topPanel = {
		xtype: 'panel', 
		title: '<?=_('Entretien des cliniques de iSanté');?>',
		region: 'center',
		height: 500,
		width: 1500,
		items: [
		     searchForm,
		     siteGrid
		]
	};      
	
	var layout = new Ext.Viewport ({ 
		//forceFit: true,
		//hideMode: 'offsets',
		layout: 'border',
		items:[
			{xtype: 'box', region:'north', el:'banner', height: 67, margins: '<? if (preg_match('/(test|demo)/i', APP_VERSION) > 0) { echo "24 0 0 0"; } // Checks for test version, if yes msg displays via bannerbody ?>'},
			topPanel
		] 
	});
});