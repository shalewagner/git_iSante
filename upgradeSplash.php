<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$lang = $_GET['lang'];
$status = $_GET['status'];
if ($lang == "en")
	$title = "Upgrade";
else
	$title = "Mise &agrave; jour de la base de donn&eacute;es";
echo "
  <title>" . $title . "</title>
  <link href=\"default.css\" type=\"text/css\" rel=\"StyleSheet\">
</head>
<body>";
if ($status == "user") {
	if ($lang == 'en')
		echo "Your administrator must perform an upgrade before you can use this application.<p />Please contact your administrator.";
	else
		echo "Votre administrateur doit ex&eacute;cuter une mise à jour avant que vous puissiez utiliser cette application.<p />Veuillez le contacter.";
} else {
	if ($lang == 'en') {
		$buttonText = "Upgrade";
		echo "You must do a database upgrade before anyone can use this application.<p />From the isante directory: sh support/upgrade-database.sh > upgradeDB-log.txt";
	} else {
		$buttonText = "Mise &agrave; jour de la base de donn&eacute;es";
		echo "Vous devez mettre &agrave; jour la base de donn&eacute;es<p />avant de pouvoir utiliser cette application.<p />En dir isante: sh support/upgrade-database.sh > upgradeDB-log.txt";
	}
}
?>
</body>
</html>
