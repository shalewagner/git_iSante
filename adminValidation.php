<?php

require_once 'backend.php';
require_once 'labels/menu.php';

if (!empty ($_GET['lang'])) $lang = $_GET['lang'];
if (!empty ($_POST['lang'])) $lang = $_POST['lang'];
$lang = (empty ($lang) || !in_array ($lang, $langs)) ? $def_lang : $lang;
//$pid = (!empty ($_GET['pid'])) ? $_GET['pid'] : "";
//$eid = (!empty ($_GET['eid'])) ? $_GET['eid'] : "";
$type = (!empty ($_GET['type'])) ? $_GET['type'] : "";
$field = (!empty ($_GET['field'])) ? $_GET['field'] : "";
$msg = (!empty ($_GET['msg'])) ? $_GET['msg'] : "";

// Check authorization
if (getAccessLevel (getSessionUser ()) != "2") {
  header ("Location: error.php?type=auth&lang=$lang");
  exit;
}

if (!empty ($_POST)) {
  if (!empty ($_POST['fieldName']) && !empty ($_POST['encounterType'])) {
    if (setValidations (array ('fieldName' => $_POST['fieldName'], 'encounterType' => $_POST['encounterType'], 'fieldMandatory' => ((isset ($_POST['fieldRequired']) && $_POST['fieldRequired'] == 2) ? '1' : NULL), 'fieldNonBlank' => ((isset ($_POST['fieldRequired']) && $_POST['fieldRequired'] == 1) ? '1' : NULL), 'fieldRegEx' => ((isset ($_POST['fieldRegEx'])) ? $_POST['fieldRegEx'] : NULL), 'fieldLowerBound' => ((isset ($_POST['fieldLowerBound'])) ? $_POST['fieldLowerBound'] : NULL), 'fieldUpperBound' => ((isset ($_POST['fieldUpperBound'])) ? $_POST['fieldUpperBound'] : NULL), 'fieldLinkage' => ((isset ($_POST['fieldLinkage'])) ? $_POST['fieldLinkage'] : NULL), 'checkLinkageIfBlank' => ((isset ($_POST['checkLinkageIfBlank'])) ? '1' : NULL), 'lastModified' => date ("m/d/Y H:i:s"), 'lastModifiedBy' => getSessionUser ())) !== false) {
      header ("Location: adminValidation.php?lang=$lang&type=" . urlencode ($_POST['encounterType']) . "&field=" . urlencode ($_POST['fieldName']) . "&msg=" . urlencode ($allEnc[$lang][28]));
      exit;
    }
  }
  header ("Location: adminValidation.php?lang=$lang&msg=" . urlencode ($allEnc[$lang][29]));
  exit;
}

echo "
<html>
 <head>
  <link href=\"default.css\" type=\"text/css\" rel=\"StyleSheet\">
  <title>" . $allEnc[$lang][13] . "</title>
 </head>
 <body>
  <table class=\"header\">
   <tr>
    <td class=\"m_header\">" . $allEnc[$lang][13] . "</td>
   </tr>
   <tr>
    <td class=\"statusMsg\">" . $msg . "</td>
   </tr>
  </table>";

// Retrieve current rules for the field, if any
if (!empty ($field) && !empty ($type)) {
  $validation = getValidations ($type, "fieldName = '$field'");

  echo "
        <form name=\"mainForm\" action=\"\" method=\"post\">
        <input type=\"hidden\" name=\"fieldName\" value=\"$field\">
        <input type=\"hidden\" name=\"encounterType\" value=\"$type\">
        <table class=\"header\">
         <tr>
          <td width=\"30%\"><b>" . $allEnc[$lang][15] . "</b></td>
          <td width=\"70%\" align=\"left\">$field</td>
         </tr>
         <tr>
          <td><b>" . $allEnc[$lang][16] . "</b></td>
          <td>";

  $encs = getEncTypes ("encounterType = '$type'");
  echo $encs[0][$lang . 'Name'];

  echo "</td>
         </tr>
         <tr>
          <td colspan=\"2\"><hr width=\"98%\" noshade></td>
         </tr>
         <tr>
          <td colspan=\"2\"><input type=\"radio\" name=\"fieldRequired\" value=\"2\" " . ((isset ($validation[0]['fieldMandatory']) && $validation[0]['fieldMandatory'] == 1) ? "checked" : "") . "> " . $allEnc[$lang][17] . "</td>
         </tr>
         <tr>
          <td colspan=\"2\"><input type=\"radio\" name=\"fieldRequired\" value=\"1\" " . ((isset ($validation[0]['fieldNonBlank']) && $validation[0]['fieldNonBlank'] == 1) ? "checked" : "") . "> " . $allEnc[$lang][18] . "</td>
         </tr>
         <tr>
          <td colspan=\"2\"><input type=\"radio\" name=\"fieldRequired\" value=\"0\" " . ((isset ($validation[0]['fieldMandatory']) && isset ($validation[0]['fieldNonBlank']) && $validation[0]['fieldMandatory'] != 1 && $validation[0]['fieldNonBlank'] != 1) ? "checked" : "") . "> " . $allEnc[$lang][19] . "</td>
         </tr>
         <tr>
          <td colspan=\"2\"><hr width=\"98%\" noshade></td>
         </tr>
         <tr>
          <td colspan=\"2\"><input type=\"radio\" name=\"fieldRegEx\" value=\"/^[\d,-.]+$/\" " . ((isset ($validation[0]['fieldRegEx']) && $validation[0]['fieldRegEx'] == '/^[\d,-.]+$/') ? "checked" : "") . "> " . $allEnc[$lang][20] . "</td>
         </tr>
         <tr>
          <td colspan=\"2\"><input type=\"radio\" name=\"fieldRegEx\" value=\"/^\D+$/\" " . ((isset ($validation[0]['fieldRegEx']) && $validation[0]['fieldRegEx'] == '/^\D+$/') ? "checked" : "") . "> " . $allEnc[$lang][22] . "</td>
         </tr>
         <tr>
          <td colspan=\"2\"><input type=\"radio\" name=\"fieldRegEx\" value=\"custom\" " . ((isset ($validation[0]['fieldRegEx']) && $validation[0]['fieldRegEx'] != '/^[\d,-.]+$/' && $validation[0]['fieldRegEx'] != '/^\D+$/') ? "checked" : "") . "> " . $allEnc[$lang][23] . " <input type=\"text\" name=\"fieldRegExCustom\" size=\"30\" maxlength=\"1024\" " . ((isset ($validation[0]['fieldRegEx']) && $validation[0]['fieldRegEx'] != '/^[\d,-.]+$/' && $validation[0]['fieldRegEx'] != '/^\D+$/') ? "value=\"" . $validation[0]['fieldRegEx'] : "") . "\"></td>
         </tr>
         <tr>
          <td colspan=\"2\"><hr width=\"98%\" noshade></td>
         </tr>
         <tr>
          <td colspan=\"2\">" . $allEnc[$lang][24] . " <input type=\"text\" name=\"fieldLowerBound\" size=\"10\" maxlength=\"255\" " . ((isset ($validation[0]['fieldLowerBound'])) ? "value=\"" . $validation[0]['fieldLowerBound'] . "\"" : "") . "></td>
         </tr>
         <tr>
          <td colspan=\"2\">" . $allEnc[$lang][25] . " <input type=\"text\" name=\"fieldUpperBound\" size=\"10\" maxlength=\"255\" " . ((isset ($validation[0]['fieldUpperBound'])) ? "value=\"" . $validation[0]['fieldUpperBound'] . "\"" : "") . "></td>
         </tr>
         <tr>
          <td colspan=\"2\"><hr width=\"98%\" noshade></td>
         </tr>
         <tr>
          <td colspan=\"2\">" . $allEnc[$lang][26] . "<br><textarea name=\"fieldLinkage\" rows=\"5\" cols=\"70\">" . ((isset ($validation[0]['fieldLinkage'])) ? $validation[0]['fieldLinkage'] : "") . "</textarea></td>
         </tr>
         <tr>
          <td colspan=\"2\"><input type=\"checkbox\" name=\"checkLinkageIfBlank\" value=\"On\" " . ((isset ($validation[0]['checkLinkageIfBlank']) && $validation[0]['checkLinkageIfBlank'] == 1) ? "checked" : "") . ">" . $allEnc[$lang][30] . "</td>
         </tr>
         <tr>
          <td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"" . $formSubmit[$lang][1] . "\" value=\"" . $formSubmit[$lang][1] . "\"> <input type=\"reset\" name=\"" . $formReset[$lang][1] . "\" value=\"" . $formReset[$lang][1] . "\"><br><input type=\"button\" name=\"close\" value=\"" . $allEnc[$lang][27] . "\" onClick=\"window.close()\"></td>
        </table>
        </form>";
} else {
  echo "
     <h4 align=\"center\">" . $allEnc[$lang][14] . "</h4>";
}

echo "
 </body>
</html>
";

?>
