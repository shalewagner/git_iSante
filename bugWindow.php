<?php
$subject = $_GET['subject'];
$subject = str_replace("X","'", $subject);
$lang = $_GET['lang'];
$user = $_GET['username'];
require_once ('labels/labels.php');

 echo "
<html xmlns=\"http://www.w3.org/1999/xhtml\">
 <head>";
 
if(eregi('WIN',PHP_OS))
   echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=iso8859-1\" />";
else
   echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />";
echo "
  <title>".$subject."</title>
  <link href=\"bug.css\" type=\"text/css\" rel=\"StyleSheet\" />
  <script language=\"javascript\" type=\"text/javascript\">
		window.onload = init;
		function init(){
			var sel = document.getElementById('select');
			sel.value = 0;
			var mb = document.getElementById('mb');
			var text = mb.innerHTML;
			document.getElementById('mBody').value= text;
			mb.value = '';
		}

	</script>
   	</head>
   	<body>
   	<form action=\"bugMessage.php\" method=\"get\">
	<p class=\"info\">" . $errorType[$lang][1] . " : <span class=\"info\">" . $user . "</span></p>
	<p class=\"info\">" . $errorType[$lang][2] . " : <span class=\"info\">" . $subject . "</span></p>
	<input type=\"hidden\" name=\"userName\" value=\"" . $user . "\" id=\"user\"/>
	<input type=\"hidden\" name=\"lang\" value=\"" . $lang . "\" id=\"lang\"/>
	<p class=\"info\">" . $errorOptions[$lang][1] . ": </p><select name=\"errorType\" size=0 class=\"info\" id=\"select\">
		<option value=\"0\" selected=\"yes\"></option>
		<option value=\"2\">" . $errorOptions[$lang][2] . "</option>
		<option value=\"3\">" . $errorOptions[$lang][3] . "</option>
		<option value=\"4\">" . $errorOptions[$lang][4] . "</option>
		<option value=\"5\">" . $errorOptions[$lang][5] . "</option>
		<option value=\"6\">" . $errorOptions[$lang][6] . "</option>
	</select>
	<div id=\"message\">
	<label>" . $errorType[$lang][3] . " : <br/><textarea cols=\"65\" rows=\"10\" name=\"messageBody\" id=\"mb\"></textarea></label><br/></div>
	<input type=\"hidden\" name=\"subject\" value=\"" . $subject . "\" id=\"subject\"/>
	<input type=\"submit\" value=\"" . $errorType[$lang][4] . "\" id=\"submit\" />
	<input type=\"hidden\" name=\"mBody\" id=\"mBody\"/>
	</form>
</body>
</html>
";
?>
