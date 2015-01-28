#!/usr/bin/php
<?php

$_REQUEST['noid'] = 'true';
require_once 'backend/config-edit.php';

#discard program name
array_shift($argv);

if (count($argv) == 2) {
  editConfig(array_shift($argv), array_shift($argv));
} else if (count($argv) == 1) {
  editConfig(array_shift($argv), null);
}

?>