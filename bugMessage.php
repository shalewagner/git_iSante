<?php

require_once('backend.php');
require_once('backendAddon.php');
require_once('labels/labels.php');

$body = $_GET['messageBody'];
$user = $_GET['userName'];
$subject = stripslashes($_GET['subject']);
$error = $_GET['errorType'];
$lang = $_GET['lang'];
echo"
<html>
<head>
<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\" />
<title>".$subject."</title>
<link href=\"bug.css\" type=\"text/css\" rel=\"StyleSheet\" />
</head>
<body>
";
$close = array (
	"en" => array ("Close Window","Thank you, ","Your error message has been recorded.  You will receive a confirmation email when your message has been processed."), 
	"fr" => array ("Fermer la fen&ecirc;tre","Merci, ", "Votre message d'erreur a &eacute;t&eacute; enregistr&eacute;.  Vous recevrez un message &eacute;lectronique de confirmation lorsque votre requ&ecirc;te sera ex&eacute;cut&eacute;e.")
);

function addslashes_mssql($str){
    if (is_array($str)) {
        foreach($str AS $id => $value) {
            $str[$id] = addslashes_mssql($value);
        }
    } else {
        $str = str_replace("'", "''", $str);
    }

    return $str;
}
$priority = $errorOptions[$lang][$error];

recordEvent('bugReport', array('subject' => $subject,
			       'priority' => $priority,
			       'body' => $body));

	echo "
	<p id=\"response\">" . $close[$lang][1]  . "<span id=\"response\">" . $user ."</span>.<br/>" . $close[$lang][2] . "</p>
	<form method=\"post\">
	<input id=\"close\" type=\"button\" value=\"" . $close[$lang][0] . "\" onclick=\"window.close()\">
	</form>

</body>
</html>";
?>
