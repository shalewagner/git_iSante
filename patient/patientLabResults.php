<?php
chdir('..');
include ("include/standardHeaderBasic.php");
$testNameLang = 'testNameFr';
if ($lang == 'en') {
    $testNameLang = 'testNameEn';
}
?>
    <link rel="stylesheet" type="text/css" media="all" href="../default.css">
    <!--[if lte IE 7]>
    <link rel="stylesheet" type="text/css" href="../default-ie7.css">
    <![endif]-->
    <!--[if ie 9]>
    <link rel="stylesheet" type="text/css" href="../default-ie9.css">
    <![endif]-->
    <link rel="stylesheet" type="text/css" media="print" href="../print.css">
<?php
function getHistory($pid, $lang) {
	$sql = "(select v.visitDate as vDate, v.labid, v.labGroup, v.testName" . ucfirst($lang) . ", case when (encounterType in (6,19) and formVersion = 3) or resulttimestamp is not null then result else case when resultType = 1 and result != '' then case when result = '1' then resultLabel" . ucfirst($lang) . "1 when result = '2' then resultLabel" . ucfirst($lang) . "2 when result = '4' then resultLabel" . ucfirst($lang) . "3 when result = '8' then resultLabel" . ucfirst($lang) . "4 when result = '16' then resultLabel" . ucfirst($lang) . "5 end when resultType = 2 and result != '' then concat(result,' ',resultLabel" . ucfirst($lang) . "1) when resultType = 3 and result != '' then concat(result,' ',resultLabel" . ucfirst($lang) . "1) when resultType = 4 and result != '' then case when result = '1' then resultLabel" . ucfirst($lang) . "1  when result = '2' then resultLabel" . ucfirst($lang) . "3 when result = '4' then resultLabel" . ucfirst($lang) . "4 end when resultType = 5 and result IS NOT NULL then case when result2 = '1' then concat(result,' ',resultLabel" . ucfirst($lang) . "1) when result2 = '2' then concat(result,' ',resultLabel" . ucfirst($lang) . "2) end when resultType = 6 and result != '' then case when result = '1' then resultLabel" . ucfirst($lang) . "1 when result = '2' then resultLabel" . ucfirst($lang) . "5 end else '' end end as result, case when resultType = 2 and result2 IS NOT NULL then concat(result2,' ',resultLabel" . ucfirst($lang) . "1) when resultType = 3 and result2 IS NOT NULL then concat(result2,' ', resultLabel" . ucfirst($lang) . "2) when resultType = 4 and result2 IS NOT NULL then case when result2 != '1' and result2 != '2' and result2 != '4' then concat(result2,' ',resultLabel" . ucfirst($lang) . "2) end when resultType = 6 and result2 IS NOT NULL then case when result2 = '2' then resultLabel" . ucfirst($lang) . "3  when result2 = '3' then concat(result2,' ',resultLabel" . ucfirst($lang) . "4) end else '' end as result2, case when resultType = 3 and result3 IS NOT NULL then concat(result3,' ',resultLabel" . ucfirst($lang) . "3) else '' end as result3, resultType, resultAbnormal, resultRemarks, case when resultTimestamp is null and isdate(ymdToDate(resultDateYy,resultDateMm, resultDateDd)) = 1 then concat(ymdToDate(resultDateYy,resultDateMm, resultDateDd),' (HND)') when resultTimestamp is null and isdate(ymdToDate(resultDateYy,resultDateMm, resultDateDd)) != 1 then concat(v.visitDate,' (DV/HND)') else resultTimestamp end as resultDate, concat(v.minValue,'-', v.maxValue) as valueRange, v.units, v.panelName, v.sectionOrder, v.sendingSiteName, accessionNumber, v.testOrder, resultStatus, supersededDate from a_labs v where ((result is not null and result <> '') or isdate(ymdToDate(resultDateYy,resultDateMm, resultDateDd)) = 1) and patientid = '" . $pid . "')
	union
	(select 
	ymdToDate(visitdateYy, visitdateMm, visitdateDd),
	'labid',
	labGroup,
	labName,
	result,
	result2,
	'result3',
	'resultType',
	resultAbnormal,
	resultRemarks,
	case when sendingSiteName = 'iSanté' and isdate(ymdToDate(resultDateYy,resultDateMm, resultDateDd)) = 1 then concat(ymdToDate(resultDateYy,resultDateMm, resultDateDd),' NTA') 
	when sendingSiteName = 'iSanté' and isdate(ymdToDate(resultDateYy,resultDateMm, resultDateDd)) != 1 then concat(ymdToDate(visitdateYy, visitdateMm, visitdateDd),' VD/NTA') else resultTimestamp end,
	concat(minValue,'-', maxValue) as valueRange,
	units,
	panelName,
	sectionOrder,
	sendingSiteName,
	accessionNumber,
	testOrder,
	0,
	null
	from otherLabs where ((result is not null and result <> '') or isdate(ymdToDate(resultDateYy,resultDateMm, resultDateDd)) = 1) and patientid = '" . $pid . "')
	order by resultDate DESC, sectionOrder, testOrder";  
	$arr = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
	return($arr);
}
?>
</head>
<body>

<?php
$printHeaderTitle = $tabLabels[$lang][7];
$printHeaderPath = '../';
include("include/printPatientHeader.php");
?>

<?php
$allTests = getHistory($pid,$lang);
// Begin display of lab results
// Code looks at each row and compares it to previous row in array. If the
// date is different, start new date/accession <div>. If section is different
// add new section header, same with panel.
// TODO: The nested IF statements are really hard to read. Refine.

$numberTests = count($allTests);
if ($numberTests < 1 ) {
    echo "<div class='container-960 lab-results'>";
    echo "<p><strong>".$labLabels[$lang][9]."</strong>.</p>";
    echo "</div>";
} else {
    echo "<div class='container-960 lab-results'>";
    $currentSection = '';
    $currentPanel = '';
    $labDate = '';
    $i = 0;

    echo "<div class='print-hide'><a class='button12 button-maker' onClick='window.print()' href='#'>".$labLabels[$lang][8]."</a></div><div class='print-hide'><br clear='all' /></div>";
    foreach ($allTests as $i => $row) { 
	/* TODO: once the test catalog gets loaded to labLookup and/or the test catalog stabilizes further
	 * the lines below can be removed 
	 */
	//if ($row['labGroup'] == '') $row['labGroup'] = 'A Missing Section';
	// concat isanté results in the same way OE results are concatenated
	if ($row['result2'] != '') $row['result'] .= ", " . $row['result2'];
	if ($row['result3'] != '' && $row['result3'] != 'result3') $row['result'] .= ", " . $row['result3'];
	if ($row['resultAbnormal'] == '1') $row['result'] .= ", anormal";
	if ($row['valueRange'] == 'n/a-n/a') $row['valueRange'] = ''; 
	      
        $labResultHeader = "<div class=\"result-sort\"><span>".$labLabels[$lang][5].$colon[$lang][0]." ".$row['resultDate']."</span></div>";
        // Shows header for first result
        if ($i == 0) {
            echo $labResultHeader;
        }
        // If previous row was a diff date or section, closes that result table
        if (($currentSection != $row['labGroup'] && $currentSection != '' && $i != 0) || ($currentSection == '' && $row['result'] != '' && $i != 0) || ($i != 0 && $labDate != $row['resultDate'])) {
            echo "</tbody></table></div>";
            // Inserts main header with date/accession/site if date is different than previous row
            if ($labDate != $row['resultDate']) {
                echo $labResultHeader;
            }
        }
        // Inserts Section header if different than previous row or it's a 
        // new result date
        if ($currentSection != $row['labGroup'] || $labDate != $row['resultDate']) {
            echo "<div class='lab-section-header'>";
            echo "<div>".$row['labGroup']."</div>";
            if ($row['accessionNumber'] != '') echo "<span>Accession".$colon[$lang][0]." ".$row['accessionNumber']."</span>";
            if ($row['sendingSiteName'] != '') echo "<span>".$bannerSite[$lang].$colon[$lang][0]." ".$row['sendingSiteName']."</span>";         
            echo "</div>";
        }
        if ($currentSection != $row['labGroup'] || $row['labGroup'] == '' || $labDate != $row['resultDate']) {
            echo "<div class='lab-section-container'><table class='table table-bordered panel-table'><thead><tr><th class='width-220'>".$labLabels[$lang][1]."</th><th class='width-150'>".$labLabels[$lang][2]."</th><th class='width-150'>".$labLabels[$lang][10]."</th><th>".$labLabels[$lang][7]."</th></tr></thead><tbody>";
        }
        if (($currentPanel != $row['panelName'] || $currentSection != $row['labGroup']) && $row['panelName'] != '') {
            echo "<tr><td colspan=4 class='lab-panel'><strong>" . $row['panelName'] . "</strong></td></tr>";
        }
        // Only show result if testName or result are populated
        if ($row[$testNameLang] != '' || $row['result'] != '') {
            if ($row['panelName'] != '') { 
                echo "<tr class='results'>";
            } else {
                echo "<tr class='results single-result'>";
            }
            // Add line breaks to multiple results
            $resultArray = explode(', ',$row['result']);
            $row['result'] = implode('<br />',$resultArray);
                echo "<td>" . $row[$testNameLang] . "</td><td>" .  $row['result'];
                if ($row['units'] != '' && $row['units'] != 'n/a' && count($resultArray) == 1) {
                    echo " " . $row['units'];
                }
		if ($row['resultStatus'] == 1) {
			if ($row['resultRemarks'] != '') $row['resultRemarks'] .= "<br>";
			$row['resultRemarks'] .= _('Il s’agit d’un résultat mis à jour.');
		}
		if ($row['resultStatus'] == 2) {
			if ($row['resultRemarks'] != '') $row['resultRemarks'] .= "<br>";
			$row['resultRemarks'] .= _('Ce résultat a été remplacé par un nouveau résultat daté du ') . $row['supersededDate'];
		}
                echo "</td><td>".$row['valueRange']."</td><td>".$row['resultRemarks']."</td>";
            echo "</tr>";
        }
        
        // Set variables used on next loop through
        $currentSection = $row['labGroup'];
        $currentPanel = $row['panelName'];
        $labDate = $row['resultDate'];
        $i++;
        if ( $i == $numberTests) {
            echo "</tbody></table></div><br>";
        }
    }
    // Builds print link
    echo "<a class='button12 button-maker print-hide' onClick='window.print()' href='#'>".$labLabels[$lang][8]."</a>";
    echo "</div>";
    if (DEBUG_FLAG) print_r($allTests);
}
?>
</body></html>
