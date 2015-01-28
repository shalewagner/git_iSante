<?php
require_once 'backend.php';
require_once 'labels/reportSetupLabels.php';
require_once 'labels/bannerLabels.php';

if (!empty ($_GET['lang'])) $lang = $_GET['lang'];
if (!empty ($_POST['lang'])) $lang = $_POST['lang'];
$lang = (empty ($lang) || !in_array ($lang, $langs)) ? $def_lang : $lang;
if (!empty ($_GET['site']))
	$site = $_GET['site'];
else
	$site = $_POST['site'];

// Check authorization
if (getAccessLevel (getSessionUser ()) === 0) {
  header ("Location: error.php?type=auth&lang=$lang");
  exit;
}

if (!empty ($_GET['code'])) {
	$paramList = explode("|", $_GET['natID'] );
	$startMm = $paramList[0];
	$startYy = $paramList[1];
	$endMm = $paramList[2];
	$endYy = $paramList[3];
	$siteCode = $paramList[4];
} else {
	$siteCode = $site;
	$startMm = "02";
	$startYy = "06";
	$endMm = "03";
	$endYy = "06";
}

$existingData = array ("startMm" => $startMm, "startYy" => $startYy, "endMm" => $endMm, "endYy" => $endYy);

$errors = (!empty ($_GET['code'])) ? getErrors ($existingData, 14) : array ();

echo "
<html>
 <head>
  <meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\">
  <title>" . $reportSetupHeader[$lang] . "</title>
  <link href=\"default.css\" type=\"text/css\" rel=\"StyleSheet\">
  <script language=\"JavaScript\" type=\"text/javascript\">
  <!--
    function openValidationWindow (lang, type, field) {
		window.open ('adminValidation.php?lang=' + escape (lang) + '&type=' + escape (type) + '&field=' + escape (field), '', 'fullscreen=no,toolbar=no,status=no,menubar=no,scrollbars=yes,resizable=yes,directories=no,location=no,width=650,height=600');
    }
    function doSubmit () {
    	alert('calling pepfarLoad with ' + document.forms[0].action)
		document.forms[0].submit()
    }";

echo "
   // -->
  </script>
 </head>
 <body>
   <form name=\"reportSetup\" target=\"content\" action=\"pepfarLoad.php?lang=" . $lang . "&site=" . $site . "\" method=\"post\">
   <input type=\"hidden\" name=\"site\" value=\"" . $site . "\">
   <input type=\"hidden\" name=\"lang\" value=\"" . $lang . "\">
   <input type=\"hidden\" name=\"reportFormat\" value=\"" . $_POST['reportFormat'] . "\" />
   <table class=\"header\">
   <tr>
    <td class=\"m_header\">" . $reportSetupHeader[$lang] . "</td>
   </tr>
  </table><p />

  <table border=\"0\">
    <tr>
      <td>" . $enterSite[$lang] . ":</td>
      <td>
        <input type=\"input\" name=\"siteCode\" value=\"$site\" readonly>
		</td>
    </tr>
    <tr>
      <td colspan=\"2\">" .
      		$dateRange[$lang] . ":
      </td>
    </tr>
    <tr>
       <td>" . $start[$lang] . "</td>
       <td valign=\"top\">
		   <input tabindex=\"1\" type=\"text\" name=\"startMm\" value=\"" . $startMm . "\"  size=\"2\" maxlength=\"2\">" . showValidationIcon ("14", "startMm") . "/
		   <input tabindex=\"2\" type=\"text\" name=\"startYy\" value=\"" . $startYy . "\"  size=\"2\" maxlength=\"2\">" . showValidationIcon ("14", "startYy") . "(" . $dateFormat[$lang] . ")
       </td>
    </tr>
    <tr>
      <td>" . $end[$lang] . "</td>
       <td valign=\"top\">
		   <input tabindex=\"3\" type=\"text\" name=\"endMm\" value=\"" . $endMm . "\" size=\"2\" maxlength=\"2\">" . showValidationIcon ("14", "endMm") . "/
		   <input tabindex=\"4\" type=\"text\" name=\"endYy\" value=\"" . $endYy . "\"  size=\"2\" maxlength=\"2\">" . showValidationIcon ("14", "endYy") . "(" . $dateFormat[$lang] . ")
       </td>
    </tr>
  </table>
  <input tabindex=\"5\" type=\"submit\" onclick=\"doSubmit\" value=\"" . $goButton[$lang] . "\" />
  <br /><br />" . $waitMessage[$lang] . "
  </form>
 </body>
</html>
";

?>

