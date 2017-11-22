<?php
require_once ("backend.php");
require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";  
?> 
<title>Upload Test Results</title>
<script type="text/javascript">	
	var globalErrors = '';
	var data;
	
	window.onload = function() {
		var fileInput = document.getElementById('fileInput');
		fileInput.addEventListener('change', function(e) {
			var file = fileInput.files[0];
			Papa.parse(file, {
				complete: function(results) {
					sendToServer(results.data);
				}
			});
		});
	}
	
	function sendToServer(result) {
		var params = JSON.stringify(result);
		Ext.Ajax.timeout = 240000; // 120 seconds
		var box = Ext.MessageBox.wait('Patientez pendant que les enregistrements sont en cours de chargement', 'Enregistrement dans la base de donn&eacute;e');
		box.minWidth = 800;
		Ext.Ajax.request({
			waitMsg: 'Saving changes...',
			url: 'laboratory/labService.php', 
			params: {
				task: 'loadViral',
				params: params
			},
			failure:function(response,options){
				box.hide();
				Ext.MessageBox.alert('Warning','processing timed out...need to increase the current timeout beyond 240 seconds in Ext.Ajax.timeout');
			},
			success:function(response,options){
				box.hide();
				alert(response.responseText)
			}
		});
	}
	
	function displayErrors(e) {
		e.preventDefault();
		Ext.Ajax.request({
			waitMsg: 'Enregistrement des erreurs...',
			url: 'laboratory/labService.php', 
			params: {
				task: 'fetchViralErrors'
			},
			failure:function(response,options){
				Ext.MessageBox.alert('Warning','Oops...');
			},
			success:function(response,options){
				parseFileContents(response.responseText);
			}
		});
	}
	
	function parseFileContents(result) {
		var table = document.createElement("p");
		table.innerHTML = result;
		document.body.appendChild(table);
	}
</script>
<script type="text/javascript" src="include/papaparse.min.js"></script>
<style type="text/css">
a {
  text-decoration: none
}
  input[type="file"] { padding:3px; border:1px solid #F5C5C5; border-radius:2px; width:500px;
}
  input[type="submit"] { padding:3px; border:1px solid #F5C5C5; border-radius:2px; width:142px;
}
#keywords {
  margin: 0 auto;
  font-size: 1.2em;
}
table { 
  border-collapse: collapse; border-spacing: 0; 
}
#keywords thead {
  cursor: pointer;
  background: #c9dff0;
}
#keywords thead tr th { 
  font-weight: bold;
  padding: 12px 30px;
  padding-left: 42px;
}
#keywords thead tr th span { 
  padding-right: 20px;
  background-repeat: no-repeat;
  background-position: 100% 100%;
}

#keywords thead tr th.headerSortUp, #keywords thead tr th.headerSortDown {
  background: #acc8dd;
}

#keywords tbody tr { 
  color: #555;
}
#keywords tbody tr td {
  text-align: center;
}
#keywords tbody tr td.lalign {
  text-align: left;
}
input[type="file"] {
    display: none;
}
.custom-file-upload {
  border: 2px solid #ccc;
  border-radius: 5px;
  display: inline-block;
  padding: 6px 12px;
  cursor: pointer;
}
</style>
</head>
<body text="#000000" link="#000000" alink="#000000" vlink="#000000" align="center"> 

<? include ("bannerbody.php"); ?>
<div id="dialog" title="Upload Viral Load" style="padding:20px; float:center">
<?php if (!empty($_GET[success])) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?> 

<form action="dummy" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
<label class="custom-file-upload">
  <input name="csv" type="file" id="fileInput" /> 
  <? $prompt = ($lang == 'fr') ? 'Choisissez votre fichier csv':'Select csv file for upload';
  	 echo $prompt;
  ?>
</label>
</form> 

<div id="viral_load">
	<? $prompt2 = ($lang == 'fr') ? 'Afficher les enregistrements d´erreur':'Show records with errors'; ?>
	<input type="button" name="errorButton" value="<? echo $prompt2; ?>" onclick="displayErrors(event)"/>
</div>
</div>
</body>
</html>
