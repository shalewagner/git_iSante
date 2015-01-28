<?php
require_once 'labels/grid.php';
$lang = "fr";
$bang = "en";
echo "
<table border=\"1\">
<tr><th>Menu</th><th>ID</th><th>EN</th><th>FR</th></tr>
<tr><td colspan=\"4\">Lab History</td><tr>";
for ($i = 0; $i < 7; $i++)
	echo "<tr><td></td><td>" . $i . "</td><td>" . $labLabels[$bang][$i] . "</td><td>" . $labLabels[$lang][$i] ."</td></tr>";
echo "
<tr><td colspan=\"4\">Diagnosis History</td><tr>";
for ($i = 0; $i < 6; $i++)
	echo "<tr><td></td><td>" . $i . "</td><td>" . $dxLabels[$bang][$i] . "</td><td>" . $dxLabels[$lang][$i] ."</td></tr>";

echo "
<tr><td colspan=\"4\">Treatment (Medication) History </td><tr>";
for ($i = 0; $i < 18; $i++)
	echo "<tr><td></td><td>" . $i . "</td><td>" . $medLabels[$bang][$i] . "</td><td>" . $medLabels[$lang][$i] ."</td></tr>";
echo "
</table>
"; 
?>
