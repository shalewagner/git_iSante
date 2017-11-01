<? 
header('Content-Type: text/javascript; charset=UTF-8');  
chdir('..');
require_once "backend.php"; 
$event = $_REQUEST['eventType'];
recordEvent($event,$_REQUEST);

?> 
