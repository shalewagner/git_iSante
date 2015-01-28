<?php

//Some functions for making it easy to render common from widgets.
//They are only used in froms ew added for now.

//For autogenerating tab index values.
$nextTabIndex = 1000;

function renderRadio($baseName, $order, $label, $tabIndex = null, $asCheckbox = false) {
  global $nextTabIndex;

  if (!defined($tabIndex)) {
    $tabIndex = $nextTabIndex;
    $nextTabIndex = $nextTabIndex + 10;
  }
  
  $id = $baseName . $order;
  $value = pow(2, $order);

  if ($asCheckbox) {
    $type = 'checkbox';
  } else {
    $type = 'radio';
  }

  ?>
<label for="<?= $id ?>">
<span id="<?= $id ?>ErrorWidget"></span>
<input type="<?= $type ?>" tabindex="<?= $tabIndex ?>" name="<?= $baseName ?>" id="<?= $id ?>"
value="<?= $value ?>" <?= getData($baseName, 'checkbox', $value) ?>/>
<?= $label ?>&nbsp;
</label>
  <?php
}

function renderRadios($baseName, $labels, $tabIndex = null, $asCheckbox = false) {
  global $nextTabIndex;

  if (!defined($tabIndex)) {
    $tabIndex = $nextTabIndex;
    $nextTabIndex = $nextTabIndex + 10 + floor(count($labels)/10);
  }

  $labelOrdinal = 0;
  foreach ($labels as $label) {
    renderRadio($baseName, $labelOrdinal, $label, $tabIndex, $asCheckbox);
    $tabIndex++;
    $labelOrdinal++;
  }
}

function renderTextArea($baseName, $width, $height = 1, $tabIndex = null) {
  global $nextTabIndex;

  if (!defined($tabIndex)) {
    $tabIndex = $nextTabIndex;
    $nextTabIndex = $nextTabIndex + 10;
  }

  if ($height == 1) {
  ?>
<span id="<?= $baseName ?>ErrorWidget"></span>
<input tabindex="<?= $tabIndex ?>" id="<?= $baseName ?>" name="<?= $baseName ?>"
type="text" size="<?= $width ?>" maxlength="255" <?= getData($baseName, 'text') ?>/>
  <?php
  } else {
  ?>
<span id="<?= $baseName ?>ErrorWidget"></span>
<textarea tabindex="<?= $tabIndex ?>" id="<?= $baseName ?>" name="<?= $baseName ?>"
cols="<?= $width ?>" rows="<?= $height ?>"><?= getData($baseName, 'textarea') ?></textarea>
  <?php
  }
}

function renderDateTimeInput($baseName, $showTime = true, $tabIndex = null, $show24 = true) {
  global $nextTabIndex;

  if (!defined($tabIndex)) {
    $tabIndex = $nextTabIndex;
    $nextTabIndex = $nextTabIndex + 10;
  }
  $tabIndex2 = $tabIndex + 1;

  $value = getData($baseName, 'textarea');
  $valueDate = '';
  $valueTime = '00:00';
  if ($value != '') {
    $valueTs = strtotime($value);
    $valueDate = date('d/m/Y', $valueTs);
    $valueTime = date('H:i', $valueTs);
  }

  $timeStyle='';
  if (!$showTime) {
    $timeStyle='display:none;';
  }

  ?>
<table style="border-collapse: collapse; border: 0px;">
   <tr>
      <td>
	 <span id="<?= $baseName ?>ErrorWidget"></span>
      </td>
      <td>
	 <input style="width: 11.25ex;" tabindex="<?= $tabIndex ?>" type="text" value="<?= $valueDate ?>"
	 id="<?= $baseName ?>Date" name="<?= $baseName ?>Date"/>
      </td>
      <td style="<?= $timeStyle ?>">
	 <input style="width: 6ex;" tabindex="<?= $tabIndex + 1 ?>" type="text" value="<?= $valueTime ?>"
	 id="<?= $baseName ?>Time" name="<?= $baseName ?>Time"/>
	 <input type="hidden" value="<?= $value ?>" id="<?= $baseName ?>" name="<?= $baseName ?>"/>
      </td>
      <?php if ($show24) { ?>
      <td style="padding-left: 2px; <?= $timeStyle ?>">
	(24h)
      </td>
      <?php } ?>
   </tr>
</table>
<script language="JavaScript" type="text/javascript">
   laborEnableDateField('<?= $baseName ?>');
</script>

  <?php
}

