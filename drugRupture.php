<?php
require_once ("backend.php");
require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";  

$drugid=$_REQUEST['drugid'];
$startDate=$_REQUEST['startDate'];
$endDate=$_REQUEST['endDate'];
$siteCode=$_REQUEST['siteCode'];
$signature=$_REQUEST['signature'];
$id=$_REQUEST['id'];

?> 
<title>Rupture de stock</title>
<script type="text/javascript">	

	
	function sendToServer() {
		
		var medicament=document.getElementById('medicament');
	       var drugid = medicament.options[medicament.selectedIndex].value;
	       var startDate=document.getElementById('startDate').value;
	       var endDate=document.getElementById('endDate').value;
	       var signature=document.getElementById('signature').value;
	       var siteCode=document.getElementById('siteCode').value; 
           var task=document.getElementById('task').value;	
           var id=document.getElementById('id').value;		   
		var box = Ext.MessageBox.wait('Patientez pendant que les enregistrements sont en cours de chargement', 'Enregistrement dans la base de donn&eacute;e');
		box.minWidth = 800;
		Ext.Ajax.request({
			waitMsg: 'Saving changes...',
			url: 'drugRuptureService.php', 
			params: {
				task:task,
				id:id,
				drugid: drugid,
				startDate: startDate,
				endDate: endDate,
				siteCode: siteCode,
				signature: signature
			},
			failure:function(response,options){
				box.hide();
				Ext.MessageBox.alert('Warning','processing timed out...need to increase the current timeout beyond 240 seconds in Ext.Ajax.timeout');
			},
			success:function(response,options){
				box.hide();
				window.location.reload();
			}
		});
	}

	
	function removeToServer() {
           var id=document.getElementById('id').value;		   
		var box = Ext.MessageBox.wait('Patientez pendant que les enregistrements sont en cours de chargement', 'Enregistrement dans la base de donn&eacute;e');
		box.minWidth = 800;
		Ext.Ajax.request({
			waitMsg: 'Saving changes...',
			url: 'drugRuptureService.php', 
			params: {
				task:'remove',
				id:id
			},
			failure:function(response,options){
				box.hide();
				Ext.MessageBox.alert('Warning','processing timed out...need to increase the current timeout beyond 240 seconds in Ext.Ajax.timeout');
			},
			success:function(response,options){
				box.hide();
				window.location.reload();
			}
		});
	}

	
		function displayDrug(e) {
		e.preventDefault();
		Ext.Ajax.request({
			waitMsg: 'load Changes ..... ',
			url: 'drugRuptureService.php', 
			params: {
				task: 'load'
			},
			failure:function(response,options){
				Ext.MessageBox.alert('Warning','Oops...');
			},
			success:function(response,options){
				var table = document.createElement("p");
		         table.innerHTML = response.responseText;
				 document.getElementById("dialog").appendChild(table);
			    }
		});
	}
	
	window.onload = function() {
		displayDrug(event);
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
  border-collapse: collapse; border-spacing: 0; width:100%; 
}
#keywords thead {
  cursor: pointer;
  background: #c9dff0;
}
label {
	padding-right:50px;
}

#keywords thead tr th { 
  font-weight: bold;
  padding: 5px 5px;
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
  padding-right: 20px;
}
#keywords tbody tr td.lalign {
  text-align: left;
}

table.gridtable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}
table.gridtable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 4px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}

</style>
</head>
<body text="#000000" link="#000000" alink="#000000" vlink="#000000" align="left"> 

<? include ("bannerbody.php"); ?>
<div id="dialog" title="Upload Viral Load">
<table id="keywords">
<thead>
<tr><th> Signaler une rupture de stock</th></tr>
</thead>
<tr><td>
<form action="dummy" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
<input name="siteCode" type="hidden" id="siteCode" value="<?php echo  DEF_SITE; ?>"/>
<input name="task" type="hidden" id="task" value="<?php if($drugid>0) echo 'update'; else echo 'save'; ?>"/>
<input name="id" type="hidden" id="id" value="<?php echo $id; ?>"/>
<div style="padding:15px;float:left">
<label>Medicament : 
  <select name="medicament" id="medicament"> 
  <?php
  echo getDrugArv($drugid); ?>
  </select> 
</label>

<label>Date de debut : 
  <input name="startDate" type="date" id="startDate" value="<?php echo $startDate; ?>"/> 
</label>

<label>Date de fin : 
  <input name="endDate" type="date" id="endDate"  value="<?php echo $endDate; ?>"/> 
</label>
</div>
<div style="padding:15px;float:left">
<label>signature du medecin 
  <input name="signature" type="text" size="50" id="signature"  value="<?php echo $signature; ?>"/> 
</label>
</div>

</form> 
</td></tr>
<tr><td>
<div id="viral_load" style="padding:15px;float:left">	
	<input type="button" name="errorButton" value="Enregistrer" onclick="sendToServer()"/>
	<?php 
	if($drugid>0){ ?>
	<input type="button" name="errorButton" value="supprimer" onclick="removeToServer()"/>
	<?php } ?>	
</div>
</td></tr>
<thead>
<tr><th> Historique des ruptures de stock</th></tr>
</thead>
</table>
</div>
</body>
</html>
