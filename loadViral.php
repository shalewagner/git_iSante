<?php
require_once ("backend.php");
require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";  
?> 
<html>
<head>
  <title>file parser</title>
<script type="text/javascript">
	window.onload = function() {
		var fileInput = document.getElementById('fileInput');
		fileInput.addEventListener('change', function(e) {
			var file = fileInput.files[0];
			var textType = /text.*/;
			if (file.type.match(textType)) {
				var reader = new FileReader();
				reader.onload = function(e) {
					parseFileContents(reader.result);
				}
				reader.readAsText(file);	
			} else {
				alert("File not supported!");
			}
		});
	}
	function parseFileContents(result) {
		var table = document.createElement('table');
		table.style.border = "thick solid #0000FF";
	    //var resultArray = [];
	    result.split("\n").forEach(function(row) {
		    var tr = document.createElement('tr'); 			
	        var rowArray = [];
	        row.split(",").forEach(function(cell) {
				var td1 = document.createElement('td');
				var text1 = document.createTextNode(cell);
				td1.appendChild(text1);
				tr.appendChild(td1);
	            //rowArray.push(cell);
	        });
			table.appendChild(tr);
	        //resultArray.push(rowArray);
	    });
		document.body.appendChild(table);
	}		
</script>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <style type="text/css">
    a {text-decoration: none}
	input[type="file"] { padding:3px; border:1px solid #F5C5C5; border-radius:2px; width:500px;}
	input[type="submit"] { padding:3px; border:1px solid #F5C5C5; border-radius:2px; width:142px;}
  </style>  
</head>
<body text="#000000" link="#000000" alink="#000000" vlink="#000000" align="center"> 

<? include ("bannerbody.php"); ?>
<div id="dialog" title="Upload Viral Load" style="padding:20px; float:center">
<?php if (!empty($_GET[success])) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?> 

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
  <input name="csv" type="file" id="fileInput" placeholder="Choose your csv file"/> 
  <input type="submit" name="Submit" value="Submit" id="submit" />   
</form> 

<div id="viral_load"></div>
</div>
</body>
</html>

