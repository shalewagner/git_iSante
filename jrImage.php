<?php

if (!empty($_REQUEST['image'])) {
  $imageName = $_REQUEST['image'];
  $imageName = ereg_replace('[^A-Za-z0-9]', '', $imageName);
  $imageName = 'jasper' . $imageName;
  
  header ("Location: getTempFile.php?baseName=$imageName&extension=png");
}

?>