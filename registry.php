<?php
require_once 'include/standardHeaderExt.php';
require_once 'labels/findLabels.php';
require_once 'labels/registry.php';

$lang = $_GET['lang'];
$arv = $_GET['arv'];
  	echo "<script type=\"text/javascript\">";
	if(!empty($_GET['pid'])){
		echo "function getPID(){
			var pid = ".$_GET['pid'].";
			return pid;
		};";
	} else {
		echo "function getPID(){
			var pid = 'ST0';
			return pid;
		};";
	}
	echo " function getSite(){
		var site = ".$site.";
		return site;
	}";
	echo "</script>";

	echo "<script type=\"text/javascript\">";
	
	if(trim($arv) == '1' || $arv == 1 || $arv){
		include("edit-grid-ART2.php");
	}else{
		include("edit-grid-ART1.php");
	}
	echo "
</script>
</head>
<body>";
$formTarget = (eregi("msie",$_SERVER['HTTP_USER_AGENT'])) ? " target=\"_blank\"" : "";
 echo "
 <form name=\"mainForm\" action=\"registryCsv.php\" method=\"post\" " . $formTarget . ">";
  include ("bannerbody.php");
  echo "
 <!-- div style=\"margin:0px;background-color:#ffffff;padding:10px;\" -->
 <div class=\"contentArea\">
 <table class=\"formType\">
 	<tr >";
 	if(trim($arv) == '1' || $arv == 1 || $arv){
		echo "<td id=\"title\" class=\"m_header\" width=\"50%\">" . $find_labels['regheader2'][$lang] . "</td>";
	}else{
		echo "<td id=\"title\" class=\"m_header\" width=\"50%\">" . $find_labels['regheader'][$lang] . "</td>";
	}
	echo "<td id=\"errorText\" width=\"50%\"></td>
 	</tr>
</table>
";
//echo "<input type=\"hidden\" name =\"pid\" value=\"".$_GET['pid']."\" \>";
?>
<br/>
<input type="hidden" name="regcsv" id="regcsv" />
<!-- you must define the select box here -->
<select name="sex" id="sex" style="display: none;">
	<option value="Inconnu">Inconnu</option>
	<option value="Femme">Femme</option>
	<option value="Homme">Homme</option>
</select>

<select name="elig" id="elig" style="display: none;">
	<option value="CD4 Count">CD4 Count</option>
	<option value="Clinical Only">Clinical Only</option>
	<option value="TLC">TLC</option>
</select>
<?php
         //$temp = getData ("addrSection", "textarea");
         //$extra = getExtra($temp, $lang);
         genCommuneDropDown ("addrSection", "1006", "", "");
?>
<table>
<tr><td>
<div id="hello-win" class="x-hidden">
    <div class="x-window-header">New Pre-ARV Registry Entry</div>
 </div>
 	<select name="sex2" id="sex2" style="display: none;">
	<option value="Inconnu">Inconnu</option>
	<option value="Femme">Femme</option>
	<option value="Homme">Homme</option>
</select>
 
<div id="tabs1" height = "0">
   <div id="reg" class="tab-content">
</div>
<div id="tb" class="tab-content"></div>
<div id="sym" class="tab-content"></div>
<div id="art" class="tab-content"></div>
</div>
<div id="editGrid">
</div>
</div>
<div id="editor-grid"></div>
</td></tr>
</table>
</div>
</form>
</body>
</html>
