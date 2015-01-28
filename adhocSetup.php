<?php
require_once 'include/standardHeaderExt.php';
require_once 'labels/report.php';
require_once 'labels/menu.php';

if (DEBUG_FLAG) print_r ($_GET);
if (!empty ($_GET['rtype'])) $rtype = $_GET['rtype'];
else $rtype = "adhoc";
if (!empty ($_GET['site'])) $site = $_GET['site'];
if (!empty ($_GET['lang'])) $lang = $_GET['lang'];
$lang = (empty ($lang) || !in_array ($lang, $langs)) ? "fr" : $lang;
if (!empty ($_GET['pid'])) $pid = $_GET['pid'];
else $pid = "";

echo "
<title>" . $reportFormTitle2[$lang] . "</title>
<script type=\"text/javascript\">
function openWin (wName) {
	var authorized = true;";
	if ($userAccessLevel < 3) 
		echo "authorized = false;";
	echo "
	curQuery = document.forms[0].adhocQuery.value.toLowerCase()
	myRegExp = 'delete |update | insert |create |drop | index|alter |execute |transaction ';
	matchPos1 = curQuery.search(myRegExp)
	if (matchPos1 != -1) {
		alert('$adHocError[$lang]')
		return false
	} else if (!authorized) {
		alert('Vous n´êtes pas autorisé à exécuter des requêtes adhoc');
		return false;
	} else {
		stuff = 'width=800,height=600,scrollbars=1,resizable=1'
		popWin = window.open('' ,wName, stuff)
		popWin.focus()
		return true
	}
}
</script>
</head>
<body>
<form name=\"mainForm\" action=\"runQuery.php\" method=\"post\" target=\"newWin\" onsubmit=\"return openWin('newWin')\">";
include 'bannerbody.php';
 echo "
 <div class=\"contentArea\">
 <table class=\"formType\">
 			<tr >
 			<td id=\"title\" class=\"m_header\" width=\"50%\">" . $menuReports[$lang][5] . "</td>
 				<td id=\"errorText\" width=\"50%\"></td>
 			</tr>
		</table>

  <table>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td>
			<textarea name=\"adhocQuery\" cols=\"100\" rows=\"20\"></textarea>
		</td>
	</tr>
	<tr>
		<td>
			<input type=\"submit\" value=\"" . $repButton[$lang] . "\" />
		</td>
	</tr>
  </table>
  </form>
  </div>
</body>
</html>
";

?>