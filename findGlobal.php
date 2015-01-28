<?php    
require_once 'backend/constants.php';
require_once 'include/standardHeaderExt.php';  
include "labels/findLabels.php";
include "labels/labels.php";
include "labels/registry.php";
include "labels/site.php";
include "labels/splash.php";
include "labels/intake.php";
include "labels/pmtctintake.php";
include "labels/reportSetupLabels.php";

$lang = (isset($_GET['lang'])) ? $_GET['lang'] : (isset ($_POST['lang']) ? $_POST['lang'] : "fr");
$headerLabel =      ($lang == "fr") ? "Serveur National de Ha&iuml;ti- Requ&ecirc;te pour un dossier patient (Recherche)" : "Haiti National Server Patient Records Request (Search)";
$userLabel =        ($lang == "fr") ? "Nom d&#x27;utilisateur pour le serveur national" : "National Server Username";
$passLabel =        ($lang == "fr") ? "Mot de passe pour le serveur national" : "National Server Password";
$testLabel =        ($lang == "fr") ? "Connection test" : "Test Connection";
$passNotBlank =     ($lang == "fr") ? "Vous devez forunir votre nom d&#x27;utilisateur et mot de passe pour acc&eacute;der au serveur national." : "You must provide your national server username and password."; 
$connSuccess =  	($lang == "fr") ? "Connect&eacute; avec succ&egrave;s" : "Connection successful";
$connFail =  		($lang == "fr") ? "Echec de connection, v&eacute;rifier le nom d&#x27;utilisateur et mot de passe" : "Connection failed, check username and password";
$warnLabel =		($lang == "fr") ? "Alerte" : "Warning";
$searchButton = 	($lang == "fr") ? "Recherche" : "Search";
$clinicLabel = 		($lang == "fr") ? "Clinique" : "Clinic";
$deptLabel = 		($lang == "fr") ? "D&eacute;partement" : "Department";
$language = 		($lang == "fr") ? "Langue" : "Language";
$sumTitle2 = 		($lang == "fr") ? "Demande de dossier" : "Records request";
$sumTitle3 = 		($lang == "fr") ? "Demande de transfert" : "Transfer request";
$selectMsg = 		($lang == "fr") ? "Veuillez choisir un patient pour pouvoir acc&eacute;der &agrave; son dossier." : "Select a patient to view detailed information";    
$fetchMsg = 		($lang == "fr") ? "Recherche en cours. Veuillez patienter..." : "Searching for patients, please wait...";
$searchMsg = 		($lang == "fr") ? "Recherche..." : "Searching...";  
$noPatients = 		($lang == "fr") ? "Aucun patients" : "No patients"; 
$noPatientsMsg = 	($lang == "fr") ? "Votre recherche n&#x27;a trouv&eacute; aucun patient. Essayez encore." : "Your search found no patients, please try again.";
$blankFields = 		($lang == "fr") ? "Aucun champs de recherche" : "No search fields"; 
$blankFieldsMsg = 	($lang == "fr") ? "Veuillez compl&eacute;ter au moins un des gisements des textes" : "Please fill in at least one of the text fields."; 
$shortFields = 		($lang == "fr") ? "Entr&eacute;e trop courte" : "Entry too short"; 
$shortFieldsMsg = 	($lang == "fr") ? "Les champs de recherche doivent contenir au moins 3 caract&egrave;res" : "Search fields must contain at least 3 characters."; 
$generateLabel1 = 	($lang == "fr") ? "Traitement de la demande de dossier" : "Processing records request";
$generateLabel2 = 	($lang == "fr") ? "Traitement de la demande de transfert" : "Processing transfer request";
$waitPDF = 			($lang == "fr") ? "Note : Cette demande prend normalement 30 secondes (ou plus) pour aboutir." : "Note: This request normally takes 30 seconds or more to complete.";

$name = isset ($_POST["name"]) ? $_POST['name'] : "";
$pwd = isset ($_POST["pwd"]) ? $_POST['pwd'] : "";
$dept = isset ($_POST["dept"]) ? $_POST['dept'] : "Ouest"; 
$sitecode = isset ($_POST["sitecode"]) ? $_POST['sitecode'] : "";
$firstname = isset ($_POST["fname"]) ? $_POST['fname'] : "";
$lastname = isset ($_POST["lname"]) ? $_POST['lname'] : "";
$st = isset ($_POST["clinicPatientID"]) ? $_POST['clinicPatientID'] : "";
$nationalid = isset ($_POST["nationalid"]) ? $_POST['nationalid'] : "";
$ageInYears = isset ($_POST["ageInYears"]) ? $_POST['ageInYears'] : "";
?>
<head>
<script type="text/javascript">
function testConnection (type, param1, param2) {  
	retVar = true;
	var natName = document.getElementById('nuser').value;
	var natPass = document.getElementById('npass').value;
	if (natName == '' || natPass == '') {
		Ext.MessageBox.alert('<?php echo $warnLabel; ?>','<?php echo $passNotBlank; ?>');
		retVar = false;  
	}   
	if (retVar) {
		retVar = Ext.Ajax.request({   
			waitMsg: 'Making request...',
			url: 'natlServerProxy.php',
			method: 'POST',
			params: {
			    name: natName,
				pwd: natPass,
				action: 'auth' 
			},                                 
			callback:function(options,success,response){
				if (response.responseText == '') {
						switch (type) {
							case 0: // auth check only
								Ext.MessageBox.alert('','<?php echo $connSuccess; ?>');
								break;
							case 1: // search
								param1.proxy.conn.url = param2;
								param1.load();
								break;
							case 2: // clinsum
								Ext.MessageBox.alert('','<?php echo $waitPDF; ?>');							
								getClinicalSummary ('natlServerProxy.php', natName, natPass, param1);
								break;
							case 3: // records request
							case 4: // patient transfer
								execWithProgress('<?php echo $generateLabel1; ?>','transfer-request.php',param1);
								break;
						}
				} else {
					Ext.MessageBox.alert('<?php echo $warnLabel; ?>','<?php echo $connFail; ?>');  
				}
			}
		});
	}
	return retVar;
}
function populate() {
	var y = document.getElementById('dept');
	var z = document.getElementById('searchsitecode');
	for (m = z.options.length - 1; m > 0; m--) z.options[m] = null;
	var selIndex = y.selectedIndex;
	var selArray = eval(y.options[selIndex].value);
	var j = 0;
    for (i = 0; i < selArray.length; i++) {
		if (selArray[i].value != '<?php echo $site; ?>') {
			z.options[j] = new Option(selArray[i].text, selArray[i].value); 
			j++;
		}
	}
}

function getClinicalSummary (url, nm, pw, path) {
  // create hidden target iframe
  var id = Ext.id();
  var frame = document.createElement('iframe');
  frame.id = id;
  frame.name = id;
  frame.className = 'x-hidden';
  if(Ext.isIE) {
      frame.src = Ext.SSL_SECURE_URL;
  }
  
  document.body.appendChild(frame);
  
  if(Ext.isIE) {
      document.frames[id].name = id;
  }
  
  var form = Ext.DomHelper.append(document.body, {
      tag:'form',
      method:'post',
      action:url,
      target:id
  });
  
  document.body.appendChild(form);
  
  var hidden = document.createElement ('input');
  hidden.type = 'hidden';
  hidden.name = 'name';
  hidden.value = nm;
  form.appendChild (hidden);

  hidden = document.createElement ('input');
  hidden.type = 'hidden';
  hidden.name = 'pwd';
  hidden.value = pw;
  form.appendChild (hidden);

  hidden = document.createElement ('input');
  hidden.type = 'hidden';
  hidden.name = 'action';
  hidden.value = 'clinsum';
  form.appendChild (hidden);

  hidden = document.createElement ('input');
  hidden.type = 'hidden';
  hidden.name = 'url';
  hidden.value = path;
  form.appendChild (hidden);

  form.submit();
}

function execWithProgress(title,url,params) {
	var iframe,pbw;
	window.top.mk_update_progress=function(value,msg1,msg2) {
		if (value<0) {
			pbw.hide();
			iframe.remove();  
			window.top.mk_update_progress=null;
			return;
		}
		pbw.updateProgress(value,msg1,msg2);  
		if (msg1 == 'Finishing') {  
			var responseData = Ext.util.JSON.decode(msg2);
			document.getElementById('exportTime').value = responseData.exportTime;
			document.getElementById('importTime').value = responseData.importTime;
		} else if (msg1 == 'Finished request') {  
			var responseData = Ext.util.JSON.decode(msg2); 
	 		if (responseData.success) {
				<?php
				if (!DEBUG_FLAG) echo "
					var path = 'patienttabs.php?lang=$lang&site=$site&pid=' + responseData.pid + '&fid=' + responseData.eid;
					parent.location.href = path;
					";
				?>
			} else 
				alert('did not work');
		} else if (msg1 == 'FAILED') {
			Ext.MessageBox.hide();
			var failMsg = msg2;			
			alert (failmsg);
		} 
	}
	pbw=Ext.Msg.progress(title,'','');
	if (params) url+='?'+Ext.urlEncode(params);
	iframe = Ext.getBody().createChild({
		tag:'IFRAME',
		style:'display:none',
		src:url
	});
}

Ext.onReady(function(){ 
	// create the Data Store
	var store = new Ext.data.Store({
		// load using HTTP
		storeId: 'st',
		url: 'dummy',
		// the return will be XML, so lets set up a reader
		reader: new Ext.data.XmlReader({
			   // records will have an "Item" tag
			   record: 'Patient',
			   id: 'GUID',
			   totalRecords: '@total'
		   }, [
			   // set up the fields mapping into the xml doc
			   // The first needs mapping, the others are very basic
			   'clinicalSummaryLink',
			   'firstName',
			   'lastName',
			   'STNumber',
			   'nationalId',
			   'mothersFirstName',
			   'patientStatus',
			   'gender',
			   {name: 'dobdy', mapping: 'DOB@day'},
			   {name: 'dobmo', mapping: 'DOB@month'},
			   {name: 'dobyr', mapping: 'DOB@year'},
			   {name: 'ht', mapping: 'ht@value'},
			   {name: 'htunit', mapping: 'ht@unit'},
			   {name: 'htdy', mapping: 'ht@day'},
			   {name: 'htmo', mapping: 'ht@month'},
			   {name: 'htyr', mapping: 'ht@year'},
			   {name: 'wt', mapping: 'wt@value'},
			   {name: 'wtunit', mapping: 'wt@unit'},
			   {name: 'wtdy', mapping: 'wt@day'},
			   {name: 'wtmo', mapping: 'wt@month'},
			   {name: 'wtyr', mapping: 'wt@year'},
			   {name: 'district', mapping: 'address > district'},
			   {name: 'section', mapping: 'address > section'},
			   {name: 'town', mapping: 'address > town'},
			   'pregnant',
			   'pregnancyWeeks',
			   {name: 'enccount', mapping: 'encounters@count'},
			   {name: 'encdy', mapping: 'encounters@day'},
			   {name: 'encmo', mapping: 'encounters@month'},
			   {name: 'encyr', mapping: 'encounters@year'},
			   {name: 'arvstartdy', mapping: 'artStart@day'},
			   {name: 'arvstartmo', mapping: 'artStart@month'},
			   {name: 'arvstartyr', mapping: 'artStart@year'},
			   {name: 'cd4count', mapping: 'cd4@count'},
			   {name: 'cd4dy', mapping: 'cd4@day'},
			   {name: 'cd4mo', mapping: 'cd4@month'},
			   {name: 'cd4yr', mapping: 'cd4@year'},
				'gender',
				'telephone',
				'contactName',
				'occupation',
				'patientId',
			   // Detail URL is not part of the column model of the grid
			   'DetailPageURL'
		   ])
	});
	
	function formatDob(value, m, record){ 
		var dt = value + '.' + record.get('dobmo') + '.' + record.get('dobyr');
	    return dt;
	}; 

	// create the grid
	var grid = new Ext.grid.GridPanel({
		id: 'grid',
		store: store,
		columns: [
			{header: '<?php echo $find_labels['clinicIdLabel'][$lang]; ?>', width: 20, dataIndex: 'STNumber', sortable: false},
			{header: '<?php echo $find_labels['column2'][$lang]; ?>', width: 20, dataIndex: 'firstName', sortable: false},
			{header: '<?php echo $find_labels['column1'][$lang]; ?>', width: 20, dataIndex: 'lastName', sortable: false},
			{header: '<?php echo $find_labels['dobPreLabel'][$lang]; ?>', width: 12, sortable: false, renderer: formatDob, dataIndex: 'dobdy'}, 
			{header: '<?php echo $find_labels['NatLabel'][$lang]; ?>', width: 20, dataIndex: 'nationalId',  sortable: false}, 
			{header: '<?php echo $addrDistrict[$lang][1]; ?>', width: 40, dataIndex: 'district',  sortable: false}
		],
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: true
		}),
		viewConfig: {
			forceFit: true
		},
		height:300,
		split: true,
		region: 'north'
	}); 

	// define a template to use for the detail view
	var bookTplMarkup = [
		'<b><?php echo $vitals_header[$lang][1]; ?>:</b><br />',
		//'GUID: <a href="{DetailPageURL}" target="_blank">{Title}</a><br />',
		'<?php echo $find_labels['clinicIdLabel'][$lang]; ?>: {STNumber}<br />',
		//'<?php echo $find_labels['NatLabel'][$lang]; ?>: {nationalId}<br />',
		'<?php echo $fnameMother[$lang][1]; ?>: {mothersFirstName}<br />',
		'<?php echo $addrDistrict[$lang][1]; ?>: {district}<br />',
		'<?php echo $addrSection[$lang][1]; ?>: {section}<br />',
		'<?php echo $addrTown[$lang][1]; ?>: {town}<br />',
		'T&eacute;l&eacute;phone: {telephone}<br/>',
		'Contact: {contactName}<br/>',
		'Profession: {occupation}<br/>',
		'<?php echo $needsAss_header[$lang][2]; ?>: {patientStatus}<br/>',
		//'<?php echo $sex[$lang][0]; ?>: {gender}<br/>',
		'<?php echo $find_labels['dobPreLabel'][$lang] . ": " . (strtolower($lang) == "fr" ? "{dobdy}/{dobmo}" : "{dobmo}/{dobdy}"); ?>/{dobyr}<br/>',
		'<BR /><B><?php echo $lang == "fr" ? substr ($vihPosSec[$lang][9], 6, 8) : substr ($vihPosSec[$lang][9], 0, 8); ?>:</B><BR />',
		'<?php echo $ARVlabels[$lang][17] . ": {ht} {htunit}, " . $lowestCd4CntYy[$lang][0] . ": " . (strtolower($lang) == "fr" ? "{htdy}/{htmo}" : "{htmo}/{htdy}"); ?>/{htyr}<br/>',
		'<?php echo $ARVlabels[$lang][16] . ": {wt} {wtunit}, " . $lowestCd4CntYy[$lang][0] . ": " . (strtolower($lang) == "fr" ? "{wtdy}/{wtmo}" : "{wtmo}/{wtdy}"); ?>/{wtyr}<br/>',
		'<?php echo $pregnant1[$lang][5]; ?>: {pregnant}<br/>',
		'<?php echo ucfirst ($vihPosSec[$lang][2]); ?>: {pregnancyWeeks}<br/>',
		'<?php echo $dupLabels[$lang][1]; ?>: {enccount}<br/>',
		'<?php echo preg_replace ('/<br \/>/', ' ', $splashLabels[$lang]['recent']) . ": " . (strtolower($lang) == "fr" ? "{encdy}/{encmo}" : "{encmo}/{encdy}"); ?>/{encyr}<br/>',
		'<?php echo $ARVlabels[$lang][0] . ": " . (strtolower($lang) == "fr" ? "{arvstartdy}/{arvstartmo}" : "{arvstartmo}/{arvstartdy}"); ?>/{arvstartyr}<br/>',
		'<?php echo $cd4_section[$lang][2] . ": {cd4count}, " . $lowestCd4CntYy[$lang][0] . ": " . (strtolower($lang) == "fr" ? "{cd4dy}/{cd4mo}" : "{cd4mo}/{cd4dy}"); ?>/{cd4yr}<br/>'];
	var bookTpl = new Ext.Template(bookTplMarkup);   
	
	var ct = new Ext.Panel({
		renderTo: 'binding-example',
		frame: true,
		hidden: true,
		autoDestroy: true,
		title: 'Patients (<?php echo $selectMsg; ?>)',
		width: 1200,
		height: 575,
		layout: 'border',
		items: [
			grid, {
				id: 'detailPanel',
				region: 'center',
				bodyStyle: {
					background: '#ffffff',
					padding: '7px',
					overflow: 'auto'
				},
				tbar:[{ 
					text:'<?php echo $sumTitle[$lang]; ?>', 
					handler:function(){
						var path = document.getElementById('pdf').value;
                                                loadFlag = testConnection (2, path, null);
				    }
					},'-','-',{
					text: '<?php echo $sumTitle2; ?>',
					handler:function(){
						var z = document.getElementById('searchsitecode'); 
						var sc = z.options[z.selectedIndex].value; 
						<?php 
						// fromPid will be null if this request is coming from the UI top menu; contain a value if coming from a selected patient's forms list page.
						$fromPid = (isset($_GET['pid'])) ? $_GET['pid'] : "";
						?>
						var currPid = document.getElementById('pid').value; 
						var natName = document.getElementById('nuser').value;
						var natPass = document.getElementById('npass').value;
						var params = {"newpid": "<?php echo $fromPid; ?>", "progress":"true","name": natName, "pwd": natPass, "action":"xfer", "source": sc , "target":"<?php echo $site; ?>", "pid": currPid , "lang":"<?php echo $lang; ?>", "type":"1" };
                                                loadFlag = testConnection (3, params, null);
					}
					},'-','-',{
						text: '<?php echo $sumTitle3; ?>',
						handler:function(){
							var z = document.getElementById('searchsitecode'); 
							var sc = z.options[z.selectedIndex].value; 
							<?php 
							// fromPid will be null if this request is coming from the UI top menu; contain a value if coming from a selected patient's forms list page.
							$fromPid = (isset($_GET['pid'])) ? $_GET['pid'] : "";
							?>  
							var currPid = document.getElementById('pid').value;
							var natName = document.getElementById('nuser').value;
							var natPass = document.getElementById('npass').value;
							var params = {"newpid": "<?php echo $fromPid; ?>", "progress":"true","name": natName, "pwd": natPass, "action":"xfer", "source": sc , "target":"<?php echo $site; ?>", "pid": currPid , "lang":"<?php echo $lang; ?>", "type":"2" }; 
                                                        loadFlag = testConnection (4, params, null);
						}
					} 
				<?php
				if (DEBUG_FLAG) {
					echo ",'-','-',{
						text: 'Time',
						handler:function(){
							Ext.MessageBox.alert('Timings','Export: ' + document.getElementById('exportTime').value + ' Import: ' + document.getElementById('importTime').value);
						} 
					}";
				}
				?>
				]
			}
		]
	});
	
	grid.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		var detailPanel = Ext.getCmp('detailPanel');
		bookTpl.overwrite(detailPanel.body, r.data);
		document.getElementById('pdf').value = r.get('clinicalSummaryLink');
		document.getElementById('pid').value = r.get('patientId');
		detailPanel.show();
	});

	store.on('beforeload', function() { 
	   ct.hide();   
	   var detailPanel = Ext.getCmp('detailPanel');
	   detailPanel.hide() 	
	   Ext.MessageBox.show({
		   msg: '<?php echo $fetchMsg; ?>',
		   progressText: '<?php echo $searchMsg; ?>',
		   width:300,
		   wait:true,
		   waitConfig: {interval:200},
		   icon:'ext-mb-download', //custom class in msg-box.html
		   animEl: 'mb'
	   });
	});
	
	store.on('load', function() { 
		Ext.MessageBox.hide();
		if (store.getTotalCount() > 0) ct.show();
		else {
			//ct.hide();
			Ext.MessageBox.alert('<?php echo $noPatients; ?>', '<?php echo $noPatientsMsg; ?>');
		}
	});

	Ext.get('mybutton').on('click', function() {
	   	var fn = document.forms[0];
	    var utf8_fname = "";
	    var utf8_lname = ""; 
	    for (var n = 0; n < fn.fname.value.length; n++) {
	        var c = fn.fname.value.charCodeAt(n);
	        if (c < 128) {
	             utf8_fname += String.fromCharCode(c);
	        } else if((c > 127) && (c < 2048)) {
	             utf8_fname += String.fromCharCode((c >> 6) | 192);
	             utf8_fname += String.fromCharCode((c & 63) | 128);
	        } else {
	             utf8_fname += String.fromCharCode((c >> 12) | 224);
	             utf8_fname += String.fromCharCode(((c >> 6) & 63) | 128);
	             utf8_fname += String.fromCharCode((c & 63) | 128); 
	        }
	    }
	    for (var n = 0; n < fn.lname.value.length; n++) {
	        var c = fn.lname.value.charCodeAt(n);
	        if (c < 128) {
	             utf8_lname += String.fromCharCode(c);
	        } else if((c > 127) && (c < 2048)) {
	             utf8_lname += String.fromCharCode((c >> 6) | 192);
	             utf8_lname += String.fromCharCode((c & 63) | 128);
	        } else {
	             utf8_lname += String.fromCharCode((c >> 12) | 224);
	             utf8_lname += String.fromCharCode(((c >> 6) & 63) | 128);
	             utf8_lname += String.fromCharCode((c & 63) | 128);
	        } 
	    } 
		var first = escape(utf8_fname);
		var last = escape(utf8_lname);
		var st = fn.clinicPatientID.value;
		var natid = fn.nationalid.value;
		var natName = document.getElementById('nuser').value;
		var natPass = document.getElementById('npass').value;	
		var loadFlag = true;
		if (first == '' && last == '' && st == '' && natid == '') {
			loadFlag = false;
			Ext.MessageBox.alert( '<?php echo $warnLabel; ?>','<?php echo $blankFieldsMsg; ?>');
		}
		if (loadFlag && ((first != '' && first.length < 3) || (last != '' && last.length < 3) || (st != '' && st.length < 3) || (natid != '' && natid.length < 3))) {
			loadFlag = false;
		    Ext.MessageBox.alert('<?php echo $warnLabel; ?>','<?php echo $shortFieldsMsg; ?>');
		}
		if (loadFlag) {
			var z = document.getElementById('searchsitecode'); 
			var sc = z.options[z.selectedIndex].value;
			var natName = document.getElementById('nuser').value;
			var natPass = escape(document.getElementById('npass').value); 
			var url = 'natlServerProxy.php?action=search&name='+ natName +'&pwd='+natPass+'&ST='+st+'&site='+sc+'&nationalId='+natid+'&last='+last+'&first='+first;
			loadFlag = testConnection(1, store, url); 
		} else ct.hide(); 
	}); 
});                 
</script>

<style type="text/css">
	body {
		padding: 15px;
	}
	.x-panel-mc {
		font-size: 12px;
		line-height: 18px;
	}
	.x-window-dlg .ext-mb-download {
		background:transparent url(ext-<?= EXTJS_VERSION ?>/examples/message-box/images/download.gif) no-repeat top left;
		height:46px;
	}
</style>
<link rel="stylesheet" type="text/css" href="ext-<?= EXTJS_VERSION ?>/examples/shared/examples.css" />
</head>
<body>
<form name="mainForm" target="_parent" action="patienttabs.php" method="get" accept-charset="utf-8"> 
<?php 
if ($pid == "") include 'bannerbody.php'; 
?>
<input type="hidden" name="pid" id="pid">
<input type="hidden" name="eid" id="eid">
<input type="hidden" name="pdf" id="pdf"> 
<input type="hidden" name="exportTime" id="exportTime">
<input type="hidden" name="importTime" id="importTime">  
<input type="hidden" name="site" id="site" value="<?php echo $site; ?>">
  <table class="formType">
   <tr>
    <td class="m_header"><?php echo $headerLabel; ?>
	<?php 
	if ($pid != '') {
		echo "
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" id=\"goBack\" name=\"goBack\" value=\"" . $allEnc[$lang][0] . "/". $formCancel[$lang][1] . "\" onclick='location.href=\"allEnc.php?pid=$pid&amp;lang=$lang&amp;site=$site\";'/>";	
	}
	?> 
   </td></tr>
</table>
<table border="0" cellspacing="5" cellpadding="5"> 
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td><label for="nuser"><?php echo $userLabel; ?>:</label></td><td><input type="text" id="nuser" name="nuser" /></td>
		<td><label for="npass"><?php echo $passLabel; ?>:</label></td><td><input type="password" id="npass" name="npass" /></td>
		<td><input type="button" id="test" name="test" onclick="testConnection(0,null,null)" value="<?php echo $testLabel; ?> &rarr;" /></td>
	</tr>
	<tr><td class="top_line">&nbsp;</td><td class="top_line">&nbsp;</td><td class="top_line">&nbsp;</td><td class="top_line">&nbsp;</td><td class="top_line">&nbsp;</td></tr>
	<tr><td><label for="dept"><?php echo $deptLabel; ?>:</label></td><td>
		<select id="dept" name="dept" size="1" onchange="populate()">
		<option value="Artibonite">Artibonite</option> 
		<option value="Centre">Centre</option>
		<option value="Grandeanse">Grande-anse</option>
		<option value="Nippes">Nippes</option>
		<option value="Nord">Nord</option>
		<option value="Nordest">Nord-est</option>
		<option value="Nordouest">Nord-ouest</option>
		<option value="Ouest">Ouest</option>
		<option value="Sud">Sud</option>
		<option value="Sudest">Sud-est</option>
		</select>
		<td><label for="sitecode">Clinique:</label></td><td>		
		<select name="sitecode" id="searchsitecode" size="1">
		</select>
		<tr><td><label for="fname"><?php echo $find_labels['column2'][$lang]; ?>:</label></td><td><input type="text" name="fname" value="<?php echo !empty ($firstname) ? $firstname : ""; ?>" id="fname"></td>
			<td><label for="lname"><?php echo $find_labels['column1'][$lang]; ?>:</label></td><td><input type="text" name="lname" value="<?php echo !empty ($lastname) ? $lastname : ""; ?>" id="lname"><br /></td></tr>
		<tr><td><label for="nationalid"><?php echo $find_labels['column5'][$lang]; ?>:</label></td><td><input type="text" name="nationalid" value="<?php echo !empty ($nationalid) ? $nationalid : ""; ?>" id="nationalid"> </td>
			<td><label for="clinicPatientid"><?php echo $find_labels['column6'][$lang]; ?>:</label></td><td><input type="text" name="clinicPatientID" value="<?php echo !empty ($st) ? $st : ""; ?>" id="clinicPatientID"><br /></td>
			<td><input type="button" id="mybutton" name="mybutton" value="<?php echo $searchButton; ?> &rarr;" /></td></tr>
</table>
<div id="binding-example"></div> 
<?php include "include/clinics.php"; ?>
</form>
</body>
</html>
