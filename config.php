<?php

require_once 'backend/config.php';
require_once 'backend/config-edit.php';
require_once 'backend/fingerprint.php';

require_once 'backendAddon.php';

function renderConfigUI() {
  $configParameters = getConfigParameters();

  echo '<form method="post" action="config.php?mode=save&lang=' . $_REQUEST['lang'] . '">';
  foreach ($configParameters as $configName => $parameters) {
    $currentValue = getConfig($configName, '', true);
    $disabled = $parameters['changeable'] || $currentValue == '' ? '' : 'disabled="disabled"';
    echo "<h2>$parameters[name]</h2>";
    echo "<p>$parameters[description]</p>";
    if (is_null($parameters['enumerations'])) {
      ?>
      <input type="text" name="<?=$configName?>" value="<?=$currentValue?>" size="80" <?=$disabled?> />
      <?php
    } else {
      ?>
      <select name="<?=$configName?>">
	<?php foreach ($parameters['enumerations'] as $enum => $enumText) { ?>
	  <option value="<?=$enum?>" <?=$currentValue==$enum?'selected':''?>><?=$enumText?></option>
	<?php } ?>
      </select>
      <?php
    }
    echo "<br><br>";
  }
  echo '<input type="submit" value="' . _('Sauvegarder') . '" /></form>';
}

function saveConfig() {
  if (getAccessLevel(getSessionUser()) < ADMIN) {
    ?>
    <span style="color:red;"><?=_('en:not an administrator')?></span><br>
    <?php
    return;
  }

  $allConfigParameters = getConfigParameters();
  foreach ($_POST as $key => $value) {
    if (array_key_exists($key, $allConfigParameters)) {
      $configParameters = $allConfigParameters[$key];
      $name = $configParameters['name'];
      $currentValue = getConfig($key, '', true);
      if ($value != $currentValue) {
	if (!$configParameters['changeable']) {
	  ?>
	  <span style="color:red;"><?=$name?> <?=_('en:can not be changed')?></span><br>
	  <?php
	  continue;
	}

	if (!is_null($configParameters['validationRegexp']) &&
	    preg_match("/$configParameters[validationRegexp]/", $value) == 0) {
	  ?>
	  <span style="color:red;"><?=$name?> <?=_('en:value is invalid')?></span><br>
	  <?php
	  continue;
	}

	if ($value == '') {
	  echo $name . ' ' . _('en:set to default') . '<br>';
	} else {
	  echo $name . ' ' . _('en:set to') . " $value <br>";
	}
	editConfig($key, $value);
      }
    }
  }
}

include 'include/standardHeaderExt.php';
echo '<form name="mainForm" action="find.php" method="post">';
include 'bannerbody.php';
echo '</form>';

?>
<div style="margin: 2ex;">
<table class="header">
<tr><td class="m_header"><?=_('Paramètres de configuration')?></td></tr>
</table>
<br>
<?php


if (array_key_exists('mode', $_GET) && $_GET['mode'] == 'save') {
  ?>
  <script type="text/javascript">
  // Notification text - used by notificationBar.php
  Ext.onReady(function() {
    Ext.get('notification-text').createChild("<? echo $formStatus[$lang][0]; ?>");
  });
  </script>
  <?php
  saveConfig();
  list($fingerprintServerVersion, $fingerprintServerError) = getFingerprintServerStatus();
  if (is_null($fingerprintServerVersion)) {
    ?>
    <span style="color:red;"><?=$fingerprintServerError?></span><br>
    <?php
  } else {
    echo 'Fingerprint ' . _('server version') . ': ' . $fingerprintServerVersion;
  }

  echo '<br><br>';
}

renderConfigUI()
?>
</div>
    
</body>
</html>
