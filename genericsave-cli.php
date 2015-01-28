#!/usr/bin/php
<?php

$_REQUEST['noid'] = 'true';

#discard program name
array_shift($argv);

if (count($argv) % 2 == 0) {
  while (count($argv) > 0) {
    $key = array_shift($argv);
    $value = array_shift($argv);
    $_POST[$key] = $value;
  }
  include 'genericsave.php';
}

?>