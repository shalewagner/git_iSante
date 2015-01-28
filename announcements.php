<?php
require_once 'include/standardHeaderExt.php';
require_once 'labels/announceLabels.php';

$lang = (empty ($_GET['lang'])) ? $def_lang : $_GET['lang'];

if (!empty ($_POST)) {
  if (verifyTranslator (getSessionUser ())) {
    foreach ($_POST as $name => $val) {
      $val = trim ($val);
      if (preg_match ('/^\d+$/', $name) && !empty ($val) && $_POST['unchanged'] != 1)
        setAnnouncements (array ("bodyFr" => $val, "lastTrans" => getSessionUser (), "lastTransDate" => date ("m/d/Y H:i:s")), "announcements_id = '$name'");
    }
  }
  header ("Location: announcements.php");
  exit;
}

$annc = getAnnouncements ();

echo "
<html>
 <head>
  <meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\">
  <title>" . $annc_title[$lang] . "</title>
  <link href=\"default.css\" type=\"text/css\" rel=\"StyleSheet\">
 </head>
 <body>
 <form name=\"mainForm\">";

 include ("bannerbody.php");

 echo "
<div class=\"contentArea\">
 <table class=\"formType\">
 			<tr >
 			<td id=\"title\" class=\"m_header\" width=\"50%\">" . $annc_title[$lang] . "</td>
 				<td id=\"errorText\" width=\"50%\"></td>
 			</tr>
 			</table>";

foreach ($annc as $row) {
  echo "
  <table>
   <tr>
    <td valign=\"top\" class=\"top_pad_date\">" . datetime_conv ($row['dateStamp']) . "</td>
   </tr>
   <tr>
    <td valign=\"top\" class=\"top_pad_lang\">" . $english_title[$lang] . "</td>
   </tr>
   <tr>
    <td valign=\"top\" class=\"top_pad_announc\">" . $row['bodyEn'] . "</td>
   </tr>
   <tr>
    <td valign=\"top\" class=\"top_pad_lang\">" . $french_title[$lang] . "</td>
   </tr>";

  $french = trim ($row['bodyFr']);
  if (empty ($french))
    if (verifyTranslator (getSessionUser ()))
      echo "
       <tr>
        <td valign=\"top\" class=\"top_pad_announc\">
         <form name=\"form" . $row['announcements_id'] . "\" action=\"\" method=\"post\">
          <input type=\"hidden\" name=\"unchanged\" value=\"1\">
          <textarea name=\"" . $row['announcements_id'] . "\" cols=\"30\" rows=\"3\" onClick=\"javascript:if (this.value == 'S\'il vous pla&#xee;t, traduire l\'annonce en fran&#xe7;ais. (Votre nom et le date seront annex&#xe9;)') this.value=''\" onChange=\"javascript:document.forms['form" . $row['announcements_id'] . "'].elements['unchanged'].value = 0\">S'il vous pla&#xee;t, traduire l'annonce en fran&#xe7;ais. (Votre nom et le date seront annex&#xe9;)</textarea><br><input type=\"submit\" value=\"Sauvegarder\">
         </form>
        </td>
       </tr>";
    else
      echo "
    <tr>
     <td valign=\"top\" class=\"top_pad_announc\"><span style=\"color: #777777; font-style: italic\">En attente de traduction.</span></td>
    </tr>";
  else
    if (verifyTranslator (getSessionUser ()))
      echo "
    <tr>
     <td valign=\"top\" class=\"top_pad_announc\">
      <form action=\"\" method=\"post\">
       <textarea name=\"" . $row['announcements_id'] . "\" cols=\"30\" rows=\"3\">" . $row['bodyFr'] . "</textarea><br><span style=\"color: #777777; font-style: italic; font-size: 10px;\">- " . $row['lastTrans'] . " " . datetime_conv ($row['lastTransDate'], 1) . "</span><br><input type=\"submit\" value=\"Sauvegarder\">
      </form>
     </td>
    </tr>";
    else
      echo "
    <tr>
     <td valign=\"top\" class=\"top_pad_announc\">" . $row['bodyFr'] . "<br><span style=\"color: #777777; font-style: italic; font-size: 10px;\">- " . $row['lastTrans'] . " " . datetime_conv ($row['lastTransDate'], 1) . "</span></td>
    </tr>";
}

echo "
  </table>
  </div>
 </form>
 </body>
</html>
";

?>
