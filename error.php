<?php
//////////
// Don't include/require any file that will include 'backend.php' in this
// page, else you'll get an infinite redirect loop.
/////////
//require_once 'include/standardHeaderExt.php';
require_once 'labels/labels.php';

echo "
<html>
 <head>
  <title>" . $errorPageTitle[$_GET['lang']][1] . "</title>
  <link href=\"default.css\" type=\"text/css\" rel=\"StyleSheet\">
 </head>
 <body>";

/////////
// Bannerbody cannot be included in this page because backend isn't loaded
/////////
// include ('bannerbody.php');
 echo "<center>
   <h3>" . ${'error_' . $_GET['type']}[$_GET['lang']][1] . "</h3>
   <h4>" . ${'error_' . $_GET['type']}[$_GET['lang']][2] . "</h4><br/>";
   if($_GET['type'] == 'dupePatient'){
        $url1 ="patienttabs.php?pid=$pid&lang=$lang";
		echo"
			<a href=\"" . $url1 ."\" class=\"link_back\">" . $dupLabels[$lang][2] . "</a>
		";
   } elseif ($_GET['type'] == 'dupekey'){
        $root = $rootArray[$_GET['encType']];
        $url1 = "patienttabs.php?fid=" . $_GET['dup'] . "&pid=$pid&lang=$lang";
        $url2 = "patienttabs.php?pid=$pid&lang=$lang&tab=forms&site=$site";
		echo"
			<a href=\"" . $url1 . "\" class=\"link_back\">" . $dupLabels[$lang][0] . "</a>
			<a href=\"" . $url2 . "\" class=\"link_back\">" . $dupLabels[$lang][1] . "</a>

		";
   }
   echo"
 </center>
 </body>
</html>
";
?>
