<?php
include 'include/standardHeaderExt.php';

if (isset($_GET['titleen']) || isset($_GET['titlefr'])) {
  $title = urldecode($_GET['title' . $lang]);
  $title = iconv('ISO-8859-1', CHARSET, $title);
  //convert html entities
  $title = html_entity_decode($title, ENT_QUOTES, CHARSET);
} else {
  $title = ($lang == 'fr') ? 'Dossier d’aide' : 'Help File';
}
?>

<title><?= $title ?></title>
</head>
<body>
<a name="_top"></a>
<form name="mainForm">

<?php
include 'bannerbody.php';
echo '<br>';
if (isset($_GET['file'])) {
  $file = $_GET['file'];
  if (isset($_GET['extension'])) {
    $extension = '.' . $_GET['extension'];
  } else {
    $extension = '.htm';
  }
  #remove characters that shouldn't be there for security
  $badCharactersRegexp = '/[^a-zA-Z0-9_\.]/';
  $file = preg_replace($badCharactersRegexp, '', $file);
  $lang = preg_replace($badCharactersRegexp, '', $lang);
  $extension = preg_replace($badCharactersRegexp, '', $extension);
  include('helpfiles/' . $file . $lang . $extension);
}

?>
</form>
</body>
</html>