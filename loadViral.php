<?php
require_once ("backend.php");

require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";  
?> 
<html>
<head>
  <title></title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>  
  <script> 
      $(document).ready(function(){  
           $('#form1').on("submit", function(e){  
                e.preventDefault(); //form will not submitted  
                $.ajax({  
                     url:"uploadCsv.php",  
                     method:"POST",  
                     data:new FormData(this),  
                     contentType:false,          // The content type used when sending data to the server.  
                     cache:false,                // To unable request pages to be cached  
                     processData:false,          // To send DOMDocument or non processed data file it is set to false  
                     success: function(data){  
                          if(data=='Error1')  
                          {  
                               alert("Invalid File");  
                          }  
                          else if(data == "Error2")  
                          {  
                               alert("Please Select File");  
                          }  
                          else  
                          {  
                               $('#viral_load').html(data);  
                          }  
                     }  
                })  
           });  
      });  
</script>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <style type="text/css">
    a {text-decoration: none}
	input[type="file"] { padding:3px; border:1px solid #F5C5C5; border-radius:2px; width:500px;}
	input[type="submit"] { padding:3px; border:1px solid #F5C5C5; border-radius:2px; width:142px;}
  </style>  
</head>
<body text="#000000" link="#000000" alink="#000000" vlink="#000000" align="center"> 

<?php 
$excelRow=$_GET[excel]; $labRow=$_GET[labs];
$success=$_GET[success];

if($excelRow>0) echo "<script type='text/javascript'>alert('EXCEL row inserted: ".$excelRow.";  LABS row Updated : ".$labRow."');</script>";?> 

<? include ("bannerbody.php"); ?>
<div id="dialog" title="Upload Viral Load" style="padding:20px; float:center">
<?php if (!empty($_GET[success])) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?> 

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
  <input name="csv" type="file" id="csv" placeholder="Choose your csv file"/> 
  <input type="submit" name="Submit" value="Submit" id="submit" />   
</form> 

<div id="viral_load"></div>
</div>
</body>
</html>
