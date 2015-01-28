<?php

require_once 'backend.php';
require_once 'labels/newsLabels.php';

if (empty($_GET['lang']) )
	$lang = "fr";
else
	$lang = $_GET['lang'];

echo "
<html>
 <head>
  <meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\">
  <title>" . $menu['title'][$lang] . "</title>
  <link href=\"default.css\" type=\"text/css\" rel=\"StyleSheet\">
 </head>
 <body>
   <table class=\"header\">
    <tr>
     <td class=\"m_header\">" . $menu['title'][$lang] . "</td>
    </tr>
   </table><p />

   <center>
   <table>
      <tr>
         <td>" .
      		$menu['header2'][$lang] . "
		 </td>
	  </tr>
	  <tr>
	     <td>" .
   			$menu['footer1'][$lang] . "
		 </td>
	  </tr>
	</table><p />"
	. $menu['footer2'][$lang] . " " . date('d-M-Y') . "<br />
	<table>
		<tr>
			<th>" .
				$menu['footer3'][$lang] . "
			</th>
		</tr>";
		getPatients();
	echo "</table>
	</center>
 </body>
</html>
";

?>
