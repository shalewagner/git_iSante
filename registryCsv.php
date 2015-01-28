<?php
$ts = date('m/d/Y');
header("content-type: text/csv");

if (strpos($_SERVER["HTTP_USER_AGENT"],'MSIE')!==false){
  header('Content-Disposition: inline; filename="' . date('Y-m-d').'_registre.csv"');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Pragma: public');
} else {
  header("Content-Disposition: attachment; filename=\"$ts._registre.csv\"");
}
	
echo $_POST['regcsv'];
?>