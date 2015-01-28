<!doctype html>
<meta charset=utf-8>

<?php
if (isset($_REQUEST['query'])) {
  if (!function_exists('itech_translateSql')) {
    echo 'sqlProcess php extension not found';
  } else {
    list($type, $message) = itech_translateSql($_REQUEST['query']);
    if ($type == 'SQL') {
      echo $message;
    } else if ($type == 'ERROR') {
      echo 'Problem translating SQL statement: ' . $message;
    } else {
      echo 'Got unexpected return type from sqlProcess.';
    }
  }
  echo '<br>';
}
?>

<form action="." method="post">
<textarea cols="80" rows="24" name="query"></textarea>
<br>
<input type="submit" value="Submit">
</form>
