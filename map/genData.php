<?
chdir('..');
require_once('backend.php');

$lang = (isset($_GET['lang'])) ? $_GET['lang'] : 'fr';
$result = database()->query('
select markerText from lastMarkers2
order by lastMarkersDate desc limit 1;');
echo 'var markers = [';
while ($row = $result->fetch()) {
	echo $row['markerText'];
}
echo '];';
include 'app.js';
?>
