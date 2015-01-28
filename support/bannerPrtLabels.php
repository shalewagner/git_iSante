<?php
require_once "../labels/bannerLabels.php";
$lang = "fr";
$bang = "en";
echo "
<table border=\"1\">
<tr><th>Menu</th><th>ID</th><th>EN</th><th>FR</th></tr>
<tr><td colspan=\"4\">" . $topLabels[$bang][0] . "/" . $topLabels[$lang][0] . "</td><tr>
<tr><td></td><td>" . $cmdList[0] . "</td><td>" . $cmdLabel[$bang][0] . "</td><td>" . $cmdLabel[$lang][0] ."</td></tr>
<tr><td></td><td>" . $cmdList[1] . "</td><td>" . $cmdLabel[$bang][1] . "</td><td>" . $cmdLabel[$lang][1] ."</td></tr>

<tr><td colspan=\"4\">" . $topLabels[$bang][1] . "/" . $topLabels[$lang][1] . "</td><tr>
<tr><td></td><td>" . $cmdList[2] . "</td><td>" . $cmdLabel[$bang][2] . "</td><td>" . $cmdLabel[$lang][2] ."</td></tr>
<tr><td></td><td>" . $cmdList[3] . "</td><td>" . $cmdLabel[$bang][3] . "</td><td>" . $cmdLabel[$lang][3] ."</td></tr>
<tr><td></td><td>" . $cmdList[4] . "</td><td>" . $cmdLabel[$bang][4] . "</td><td>" . $cmdLabel[$lang][4] ."</td></tr>
<tr><td></td><td>" . $cmdList[27] . "</td><td>" . $cmdLabel[$bang][27] . "</td><td>" . $cmdLabel[$lang][27] . "</td></tr> 
<tr><td></td><td>" . $cmdList[5] . "</td><td>" . $cmdLabel[$bang][5] . "</td><td>" . $cmdLabel[$lang][5] ."</td></tr>
<tr><td></td><td>" . $cmdList[6] . "</td><td>" . $cmdLabel[$bang][6] . "</td><td>" . $cmdLabel[$lang][6] ."</td></tr> 

<tr><td colspan=\"4\">" . $topLabels[$bang][2] . "/" . $topLabels[$lang][2] . "</td><tr>
<tr><td></td><td>" . $cmdList[7] . "</td><td>" . $cmdLabel[$bang][7] . "</td><td>" . $cmdLabel[$lang][7] ."</td></tr>
<tr><td></td><td>" . $cmdList[8] . "</td><td>" . $cmdLabel[$bang][8] . "</td><td>" . $cmdLabel[$lang][8] ."</td></tr> 

<tr><td colspan=\"4\">" . $topLabels[$bang][3] . "/" . $topLabels[$lang][3] . "</td><tr>
<tr><td></td><td>" . $cmdList[9] . "</td><td>" . $cmdLabel[$bang][9] . "</td><td>" . $cmdLabel[$lang][9] ."</td></tr>
<tr><td></td><td>" . $cmdList[10] . "</td><td>" . $cmdLabel[$bang][10] . "</td><td>" . $cmdLabel[$lang][10] ."</td></tr>
<tr><td></td><td>" . $cmdList[11] . "</td><td>" . $cmdLabel[$bang][11] . "</td><td>" . $cmdLabel[$lang][11] ."</td></tr>
	
<tr><td colspan=\"4\">" . $topLabels[$bang][4] . "/" . $topLabels[$lang][4] . "</td><tr>
<tr><td></td><td>" . $cmdList[12] . "</td><td>" . $cmdLabel[$bang][12] . "</td><td>" . $cmdLabel[$lang][12] ."</td></tr>

<tr><td colspan=\"4\">" . $topLabels[$bang][5] . "/" . $topLabels[$lang][5] . "</td><tr>
<tr><td></td><td>" . $cmdList[15] . "</td><td>" . $cmdLabel[$bang][15] . "</td><td>" . $cmdLabel[$lang][15] ."</td></tr>
<tr><td></td><td>" . $cmdList[16] . "</td><td>" . $cmdLabel[$bang][16] . "</td><td>" . $cmdLabel[$lang][16] ."</td></tr>
<tr><td></td><td>" . $cmdList[17] . "</td><td>" . $cmdLabel[$bang][17] . "</td><td>" . $cmdLabel[$lang][17] ."</td></tr>

<tr><td colspan=\"4\">" . $topLabels[$bang][6] . "/" . $topLabels[$lang][6] . "</td><tr>
<tr><td></td><td>" . $cmdList[18] . "</td><td>" . $cmdLabel[$bang][18] . "</td><td>" . $cmdLabel[$lang][18] ."</td></tr>
<tr><td></td><td>" . $cmdList[19] . "</td><td>" . $cmdLabel[$bang][19] . "</td><td>" . $cmdLabel[$lang][19] ."</td></tr>
<tr><td></td><td>" . $cmdList[20] . "</td><td>" . $cmdLabel[$bang][20] . "</td><td>" . $cmdLabel[$lang][20] ."</td></tr>
<tr><td></td><td>" . $cmdList[24] . "</td><td>" . $cmdLabel[$bang][24] . "</td><td>" . $cmdLabel[$lang][24] ."</td></tr>
<tr><td></td><td>" . $cmdList[25] . "</td><td>" . $cmdLabel[$bang][25] . "</td><td>" . $cmdLabel[$lang][25] ."</td></tr>
<tr><td></td><td>" . $cmdList[26] . "</td><td>" . $cmdLabel[$bang][26] . "</td><td>" . $cmdLabel[$lang][26] ."</td></tr> 
<tr><td></td><td>" . $cmdList[21] . "</td><td>" . $cmdLabel[$bang][21] . "</td><td>" . $cmdLabel[$lang][21] ."</td></tr>
<tr><td></td><td>" . $cmdList[22] . "</td><td>" . $cmdLabel[$bang][22] . "</td><td>" . $cmdLabel[$lang][22] ."</td></tr>
</table>
"; 
?>
