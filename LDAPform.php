<?php
/**
 * Account list page
 *
 * @author	Steve Wagner
 * @version	$Id: LDAPform.php 2009-04-08 19:24:38Z shw2 $
 */
require_once 'backend/config.php';
chdir("./ldap");
require_once ('./include/app.php');

$title = gettext("Account list");

$list = $accounts->find_all();
sort($list);
chdir("..");
require_once 'include/standardHeaderExt.php';
require_once 'labels/setPriv.php';
echo "
<style>
    .demo-ct .x-panel-btns-ct {
        border-left: 1px solid #99BBE8;
        border-bottom: 1px solid #99BBE8;
        border-right: 1px solid #99BBE8;
        background: #DFE8F6;
    }
</style>
<script language=\"javascript\" type=\"text/javascript\">";
require_once 'ldap/recordform.php';
echo "
</script>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"ldap/css/icons.css\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"ldap/css/Ext.ux.grid.RowActions.css\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"ldap/css/empty.css\" id=\"theme\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"ldap/css/webpage.css\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"ldap/css/recordform.css\">
    <script type=\"text/javascript\" src=\"ldap/js/Ext.ux.util.js\"></script>
    <script type=\"text/javascript\" src=\"ldap/js/WebPage.js\"></script>
    <script type=\"text/javascript\" src=\"ldap/js/Ext.ux.form.ThemeCombo.js\"></script>
    <script type=\"text/javascript\" src=\"ldap/js/Ext.ux.Toast.js\"></script>
    <script type=\"text/javascript\" src=\"ldap/js/Ext.ux.grid.Search.js\"></script>
    <script type=\"text/javascript\" src=\"ldap/js/Ext.ux.menu.IconMenu.js\"></script>
    <script type=\"text/javascript\" src=\"ldap/js/Ext.ux.grid.RowActions.js\"></script>
    <script type=\"text/javascript\" src=\"ldap/js/Ext.ux.grid.RecordForm.js\"></script>
    <script type=\"text/javascript\" src=\"ldap/js/Ext.ux.form.DateTime.js\"></script>
    <script type=\"text/javascript\" src=\"ldap/js/ItemSelector.js\"></script>
    <script type=\"text/javascript\" src=\"ldap/js/MultiSelect.js\"></script>
    <script type=\"text/javascript\" src=\"ldap/js/DDView.js\"></script>
    <title id=\"page-title\">" . $access_labels['header'][$lang] . "</title>
</head>
<body>
<form name=\"mainForm\" action=\"LDAPform.php\" method=\"get\">";
include ("bannerbody.php");

echo "
  <div class=\"contentArea\">
	<table class=\"formType\">
	<tr >
	<td id=\"title\" class=\"m_header\" width=\"50%\">" .  $access_labels['header'][$lang] . "</td>
	<td id=\"errorText\" width=\"50%\"></td>
  </tr>
 </table>
";

// Display and remove any messages passed from another LDAP page (as done in
// ldap/include/header.tmpl.php)
if (isset ($_SESSION['messages'])) {
  $messages = $_SESSION['messages'];
  if (array_key_exists('error', $messages)) {
    echo "<ul class=\"errorMsg\">\n";
    foreach ($messages['error'] as $message) {
      echo "<li>$message</li>\n";
    }
    echo "</ul>\n";
  }

  if (array_key_exists('info', $messages)) {
    echo "<ul class=\"infoMsg\">\n";
    foreach ($messages['info'] as $message) {
      echo "<li>$message</li>\n";
    }
    echo "</ul>\n";
  }

  unset ($_SESSION['messages']);
}

echo "
<div id=\"west-content\" class=\"x-hidden\">
<div id=\"itemselector\"></div>
</div>
</div>
</form>
</body>
</html>";
?>
