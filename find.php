<?php
require_once 'include/standardHeaderExt.php';
require_once 'labels/findLabels.php';
require_once 'labels/menu.php';
require_once 'backend/fingerprint.php';

if (empty($site)) {
    header("Location: error.php?type=auth&lang=$lang");
    exit;
}
$currentqry = (!empty($_REQUEST['qrystring'])) ? $_REQUEST['qrystring'] : "";
if (DEBUG_FLAG)
    print_r($_GET);
$page = (getAccessLevel(getSessionUser()) === 0) ? "find.php" : "allEnc.php";
$pageNum = (!empty($_POST['pageNum'])) ? $_POST['pageNum'] : 1;
$existingData = array("lastPage" => 1);
echo "
<title>" . $find_labels['header'][$lang] . "</title>";
?>
<script language="javascript" type="text/javascript">
<!--
function onSubmit() {
    document.forms['mainForm'].pageNum.value = 1;
    document.forms['mainForm'].submit()
} 

function submitIt (num) {
    document.forms['mainForm'].pageNum.value = num;
    document.forms['mainForm'].submit()
} 

// jquery functions begin here
$(document).ready(function(){

    // Makes entire row clickable except last <td> which has merge function
    $(".find-table tbody tr td:not(:last-child)").click(function() {
        var linkId = $(this).parent().attr("id");
        var patientLink = 'patienttabs.php?pid=' + linkId + '&lang=<?= $lang; ?>&site=<?= $site; ?>';
        // Quick fade on click to indicate action has been taken. TODO: could be
        // refined to including loading.gif.
        $("#findResults").fadeTo('fast', 0.6);
        // Loads patient page in current window
        window.location.href = patientLink;
    });
    // Changes cursor for last cell which contains buttons
    $('.find-table tr td:last-child').css('cursor','default');
    
    // Merge functions
    // Gets placement/width of merge column so buttons can be aligned
    combinePosition();
    $(window).resize(combinePosition); //Checks again if window is resized
    function combinePosition() {
        var colWidth = $('#mergeCol').width();
        var colPos = $('#mergeCol').position();
        $('.combine-button-container').css({'width': colWidth, 'margin-left': colPos.left});
        $('.combine-button').css({'max-width': colWidth});
    }
    // Toggle for "main" record for merge
    $("input.merge-button").toggle(function (){
        var selectedPid = $(this).attr('id').replace('mm', '');
        $(this).val('<?= $find_labels['mainMerge'][$lang] ?>');
        $(".merge-button:not(#mm" + selectedPid +")").attr("disabled", true);
        $(".add-to-button:not(#at" + selectedPid +")").removeAttr("disabled");
        // Add to main form values
        document.forms['mainForm'].selectedPatient.value=selectedPid;
        document.forms['mainForm'].pidCollection.value=selectedPid;
        $(this).closest('tr').addClass('merge-row-main');
    }, function(){
        var selectedPid = $(this).attr('id').replace('mm', '');
        $(this).val('<?= $find_labels['merge'][$lang] ?>');
        $(".merge-button:not(#mm" + selectedPid +")").removeAttr("disabled");
        $(".add-to-button").attr("disabled", true).val('<?= $find_labels['addToMerge'][$lang] ?>');
        document.forms['mainForm'].selectedPatient.value=''; 
        document.forms['mainForm'].pidCollection.value=''; 
        $(this).closest('tr').removeClass('merge-row-main');
        $('.find-table tr').removeClass('merge-row');
        checkMerge();
    });
    // Toggle for adding/removing additional IDs.
    $("input.add-to-button").toggle(function (){
        var addToPid = $(this).attr('id').replace('at', '');
        $(this).val('<?= $find_labels['selectedMerge'][$lang] ?>');
        var pcoll = document.forms['mainForm'].pidCollection;
        if (pcoll.value != '') {
            pcoll.value += ',';
        } 
        pcoll.value += addToPid;
        $(this).closest('tr').addClass('merge-row');
        // Check merge buttons
        checkMerge();
    }, function(){
        var addToPid = $(this).attr('id').replace('at', '');
        var pcoll = document.forms['mainForm'].pidCollection;
        var newPids = $(pcoll).val().replace(',' + addToPid, '');
        document.forms['mainForm'].pidCollection.value = newPids;
        $(this).val('<?= $find_labels['addToMerge'][$lang] ?>');
        $(this).closest('tr').removeClass('merge-row');
        // Check merge buttons
        checkMerge();
    });
    // Enables/disble merge button function
    function checkMerge() {
        var pidGroup = document.forms['mainForm'].pidCollection.value;
        if (pidGroup.indexOf(",") >= 0) {
            var count = pidGroup.match(/,/g);
            var matchCount = count.length + 1;
            $('.combine-button').val('<?= $find_labels['merge'][$lang] ?> ' + matchCount + ' <?= $find_labels['mergeRecords'][$lang] ?>');
            $('.combine-button').removeAttr("disabled");
        } else {
            $('.combine-button').attr("disabled", true);
            $('.combine-button').val('<?= $find_labels['merge'][$lang] ?>');
        }
    }

});


// Triggers merge - FIXME: could be moved to jquery
function selPat() {
    var pid = document.forms['mainForm'].selectedPatient.value; 
    var newUrl = ''; 
    if (pid == '') {
        alert('<?= $find_labels['notSelected'][$lang]; ?>');
    } else {
        var pidCollection = document.forms['mainForm'].pidCollection.value;
        if (pidCollection.indexOf(',') > 0) {
            var retVal = confirm('<?= _("Êtes-vous sûr que vous voudriez combiner ces patients ? Cette action ne peut pas être renversée ! ! !"); ?>');
            if (retVal) newUrl = 'patienttabs.php?pid=' + pid + '&pidCollection=' + pidCollection + '&lang=<?= $lang; ?>&site=<?= $site; ?>';
            else {
                pid = '';
                pidCollection = '';
                document.forms['mainForm'].qrystring.value = '<?= $currentqry; ?>'; 
                document.forms['mainForm'].submit();
            }
        } else
            newUrl = 'patienttabs.php?pid=' + pid + '&lang=<?= $lang; ?>&site=<?= $site; ?>';   
        if (newUrl != '') location.href = newUrl; 
    }
}

// -->
</script>
</head>
<body>
    <?
    if (!empty($pid) && $pid != "") {
        echo "
<script type=\"text/javascript\">
document.getElementById('" . $pid . "').checked = 'checked';
</script>
";
    }
    echo "
<form name=\"mainForm\" action=\"find.php\" method=\"post\">
<input tabindex=\"0\" name=\"type\" value=\"$type\" type=\"hidden\" />
<input tabindex=\"0\" name=\"version\" value=\"$version\" type=\"hidden\"  />
<input tabindex=\"0\" name=\"eid\" value=\"$eid\" type=\"hidden\" />
<input tabindex=\"0\" name=\"pid\" value=\"$pid\" type=\"hidden\" />
<input type=\"hidden\" name=\"lang\" value=\"$lang\"/>
<input type=\"hidden\" id=\"pageNum\" name=\"pageNum\" value=\"$pageNum\" />
<input type=\"hidden\" name=\"clinicNumber\" value=\"" . $site . "\" />
<input type=\"hidden\" name=\"selectedPatient\" /> 
<input type=\"hidden\" name=\"pidCollection\" />
<input type=\"hidden\" name=\"selectedPatientName\" />
<input type=\"hidden\" name=\"selectedSite\" value=\"$site\" />";
    include 'bannerbody.php';
    echo "
<div class=\"contentArea\">
<table class=\"header\" >
	<tr>
		<td class=\"m_header\">" . $find_labels['header'][$lang] . "</td>
	</tr>
</table>
<table class='margin-vertical'>
	<tr>
		<td>" . $find_labels['clinicIdLabel'][$lang] . ", " . $find_labels['fnameLabel'][$lang] . ", " . $find_labels['nameLabel'][$lang] . ":</td>
		<td><input type=\"text\" id=\"qrystring\"  name=\"qrystring\" value=\"" . $currentqry . "\" /></td>
                    <td>&nbsp;&nbsp;<input type=\"button\" class=\"button-maker button12\" name=\"submitButton\" onclick=\"onSubmit()\" value=\"" . $find_labels['formSubmit'][$lang] . "\" />
		</td>
	</tr>
	</table>
";

    if (!empty($currentqry)) {
        $results = fbn($currentqry, $site, $lang, $pageNum, true);

        // output the result header
        $qryArray = explode(" ", $currentqry);
        if (!empty($results)) {
            // Previous/Next Page - repeats below.
            // TODO: Combine into a single set of code
            if ($pageNum > 1 || $pageNum < $existingData['lastPage']) {
                echo "<div style='float: left'>" . $allEnc[$lang][11] . " " . $pageNum . " " . $allEnc[$lang][12] . " " . $existingData['lastPage'] . "&nbsp;&nbsp;&nbsp;";
                echo ($pageNum > 1) ? "<a class=\"onWhite\"  onClick=\"submitIt ('" . ($pageNum - 1) . "'); return false;\" href=\"javascript:void(0)\">" . $allEnc[$lang][4] . "</a>" : $allEnc[$lang][4];
                echo " | ";
                echo ($pageNum < $existingData['lastPage']) ? "<a  class=\"onWhite\"  onClick=\"submitIt ('" . ($pageNum + 1) . "'); return false;\" href=\"javascript:void(0)\">" . $allEnc[$lang][5] . "</a>" : $allEnc[$lang][5];
                echo "</div>";
            }
            echo "
                        <div class='combine-button-container'><input type=\"button\" class=\"button-maker button12 combine-button\" name=\"combineButton\" id=\"combineButtonTop\" onClick=\"selPat(); return false;\" value=\"" . $find_labels['merge'][$lang] . "\" disabled /></div>
			<table id=\"findResults\" name=\"findResults\" border=\"0\" class=\"find-table table table-bordered table-condensed\">
			<tr>
   			<th class=\"sm_header_lt\">No. de code PC</th>
			<th class=\"sm_header_lt\">No. de code OD</th>
			<th class=\"sm_header_lt\">No. de code ST</th>
			<th class=\"sm_header_lt\">" . $find_labels['column2'][$lang] . "</th>
			<th class=\"sm_header_lt\">" . $find_labels['column1'][$lang] . "</th>
			<th class=\"sm_header_lt\">" . $find_labels['column3'][$lang] . "</th>
			<th class=\"sm_header_lt\">" . $find_labels['column4'][$lang] . "</th>
			<th class=\"sm_header_lt\">" . $find_labels['column5'][$lang] . "</th>
                        <th class=\"sm_header_lt\" id=\"mergeCol\">" . $find_labels['merge'][$lang] . "</th>";
            if (DEBUG_FLAG)
                echo "<th class=\"sm_header_lt\">fp?</th>";
            echo "
			</tr>";
            $j = 0;
            foreach ($results as $row) {
                $natID = $row['nationalID'];
                $stID = $row['clinicPatientID'];
                $pcID = $row['primCareID'];
                $odID = $row['obgynID'];
                $fname = $row['fname'];
                $lname = $row['lname'];
                $checked = "";
                $replArray = array('|!', '#$', '%^');
                $i = 0;
                foreach ($qryArray as $token) {
                    $natID = str_ireplace($token, $replArray[$i], $natID);
                    $stID = str_ireplace($token, $replArray[$i], $stID);
                    $pcID = str_ireplace($token, $replArray[$i], $pcID);
                    $odID = str_ireplace($token, $replArray[$i], $odID);
                    $fname = str_ireplace($token, $replArray[$i], $fname);
                    $lname = str_ireplace($token, $replArray[$i], $lname);
                    $i++;
                }
                $front = '<span style="background-color:lightblue;">';
                $back = "</span>";
                $i = 0;
                foreach ($qryArray as $token) {
                    $token = ucfirst($token);
                    $natID = strtoupper(str_ireplace($replArray[$i], $front . $token . $back, $natID));
                    $stID = str_ireplace($replArray[$i], $front . $token . $back, $stID);
                    $pcID = str_ireplace($replArray[$i], $front . $token . $back, $pcID);
                    $odID = str_ireplace($replArray[$i], $front . $token . $back, $odID);
                    $fname = ucwords(utf8_strtolower(str_ireplace($replArray[$i], $front . $token . $back, $fname)));
                    $fname = find_ucfirst($fname);
                    $lname = ucwords(utf8_strtolower(str_ireplace($replArray[$i], $front . $token . $back, $lname)));
                    $lname = find_ucfirst($lname);
                    $i++;
                }
                $j++;
                if (isset($index) && $j == $index) {
                    $checked = "checked";
                } else {
                    $checked = "";
                }
                if ($j % 2 == 0)
                    echo "<tr id=\"" . $row['siteCode'] . $row['person_id'] . "\">";
                else
                    echo "<tr id=\"" . $row['siteCode'] . $row['person_id'] . "\" class='row-stripe'>";
                $disabled = "";
                if (getAccessLevel(getSessionUser()) == 0 || SERVER_ROLE == "consolidated")
                    $disabled = "disabled";
                echo "
		   <td>" . $pcID . "</td>
		   <td>" . $odID . "</td> 
		   <td>" . $stID . "</td> 
		   <td>" . $fname . "</td>
		   <td>" . $lname . "</td>";
                if (strlen(trim($row['dobDd'])) == 1)
                    $row['dobDd'] = "0" . trim($row['dobDd']);
                if (strlen(trim($row['dobMm'])) == 1)
                    $row['dobMm'] = "0" . trim($row['dobMm']);
                echo "<td>" . $row['dobDd'];
                if ($row['dobMm'] != '')
                    echo "/" . $row['dobMm'];
                if ($row['dobYy'] != '')
                    echo "/" . $row['dobYy'];
                echo "</td>
		   <td>" . ucwords(utf8_strtolower($row['fnameMother'])) . "</td>
		   <td>" . $natID . "</td>
		   <td style='text-align: center'>
                   <div style='float: left; width: 50%'>
<input type=\"button\" class='button-maker button-subdued button10 merge-button' name='combineButton' id=\"mm" . $row['siteCode'] . $row['person_id'] . "\" value=\"" . $find_labels['merge'][$lang] . "\" />
                   </div><div style='float: right; width: 50%'><input type=\"button\" class='button-maker button-subdued button10 add-to-button' name='addToButton' id=\"at" . $row['siteCode'] . $row['person_id'] . "\" disabled=\"disabled\" value=\"" . $find_labels['addToMerge'][$lang] . "\" /></div></td>";
                if (DEBUG_FLAG) {
                    if (hasFingerprints(getMasterPid($row['siteCode'] . $row['person_id'])))
                        echo "<td><img src=\"images/thumb.jpg\" height=\"20%\" width=\"20%\" alt=\"fp\"/></td>";
                    else
                        echo "<td>&nbsp;</td>";
                }
                echo "
		   </tr>";
            }
            echo "
		  </table>
                <div class='combine-button-container'><input type=\"button\" class=\"button-maker button12 combine-button\" name=\"combineButtonBottom\" id=\"combineButtonBottom\" onClick=\"selPat(); return false;\" value=\"" . $find_labels['merge'][$lang] . "\" disabled /></div>";
            // Previous/Next Page
            if ($pageNum > 1 || $pageNum < $existingData['lastPage']) {
                echo "<div>" . $allEnc[$lang][11] . " " . $pageNum . " " . $allEnc[$lang][12] . " " . $existingData['lastPage'] . "&nbsp;&nbsp;&nbsp;";
                echo ($pageNum > 1) ? "<a class=\"onWhite\"  onClick=\"submitIt ('" . ($pageNum - 1) . "'); return false;\" href=\"javascript:void(0)\">" . $allEnc[$lang][4] . "</a>" : $allEnc[$lang][4];
                echo " | ";
                echo ($pageNum < $existingData['lastPage']) ? "<a  class=\"onWhite\"  onClick=\"submitIt ('" . ($pageNum + 1) . "'); return false;\" href=\"javascript:void(0)\">" . $allEnc[$lang][5] . "</a>" : $allEnc[$lang][5];
                echo "</div>";
            }
            echo "
                <br clear='all' />
                    <div class=\"formVersion\">" . $find_labels['version'][$lang] . "</div>
";
        } else {
            echo "<br /><p><b>" . $find_labels['error1'][$lang] . " <a  href=\"register.php?type=10&amp;site=$site&amp;lang=$lang&amp;version=" . $formVersion["10"] . "\">" . $find_labels['error2'][$lang] . "</a> " . $find_labels['error3'][$lang] . "</b></p>";
        }
    }

    function fbn($nm = "", $site, $lang, $pg = "", $ifOnlyOne = true) {
        $nm = trim($nm);
        $finalResults = array();
        $cntSelect = "SELECT COUNT(DISTINCT person_id) AS total FROM patient ";
        $patientSelect = "SELECT DISTINCT ltrim(rtrim(lname)) as lname, ltrim(rtrim(fname)) as fname, dobMm, dobDd, dobYy, nationalID, person_id, location_id as siteCode, clinicPatientID, fnameMother, sex, patientID FROM patient ";
        $where = " WHERE patStatus <> 1 and patStatus < 255 and location_id = " . $site . " and ";
        if (!empty($nm)) {
            $results = array();
            if (preg_match('/\d+$/', $nm)) {
                // extract alpha characters and search on the number part of the entered data only
                $nm = '%' . preg_replace('/[A-Za-z-.]/', '', $nm) . '%';
                $multiID = "(select person_id from patient where replace(replace(clinicPatientID,?,?),?,?) like ? and location_id = " . $site . " union 
				select person_id from obs o, concept c where o.location_id = " . $site . " and o.concept_id = c.concept_id and short_name in (?, ?) and replace(replace(value_text,?,?),?,?) like ?)";
                $cntSelect .= $where . " person_id in " . $multiID;
                $patientSelect .= $where . " person_id in " . $multiID;
                $paramArray = array('-', '', '.', '', $nm, 'obgynID', 'primCareID', '-', '', '.', '', $nm);
            } else {
                $cntSelect .= $where . " ((lname like ? OR nationalID like ? OR fname like ?) ";
                $patientSelect .= $where . " ((lname like ? OR nationalID like ? OR fname like ?) ";
                $paramArray = array('%' . $nm . '%', '%' . $nm . '%', '%' . $nm . '%');
                $numwords = str_word_count($nm, 0);
                $addConditions = "";
                if (strpos($nm, " ") !== false) {
                    $split = -1;
                    for ($i = 0; $i < $numwords - 1; $i++) {
                        $split = strpos($nm, ' ', $split + 1);
                        $first = substr($nm, 0, $split);
                        $last = substr($nm, $split);
                        $first = trim($first);
                        $last = trim($last);
                        $addConditions .= "OR (lname LIKE ? AND fname LIKE ?) OR (fname LIKE ? AND lname LIKE ?) ";
                        array_push($paramArray, '%' . $first . '%', '%' . $last . '%', '%' . $first . '%', '%' . $last . '%');
                        $first = str_replace(" ", "-", $first);
                        $last = str_replace(" ", "-", $last);
                        $addConditions .= "OR (lname LIKE ? AND fname LIKE ?) OR (fname LIKE ? AND lname LIKE ?) ";
                        array_push($paramArray, '%' . $first . '%', '%' . $last . '%', '%' . $first . '%', '%' . $last . '%');
                    }
                    if ($numwords == 2) {
                        $addConditions .= "OR lname LIKE ? OR fname LIKE ? ";
                        array_push($paramArray, '%' . str_replace(" ", "-", $nm) . '%', '%' . str_replace(" ", "-", $nm) . '%');
                    }
                    $cntSelect .= $addConditions;
                    $patientSelect .= $addConditions;
                }
                $cntSelect .= ")";
                $patientSelect .= ")";
            }
            $row = database()->query($cntSelect, $paramArray)->fetchAll();
            $GLOBALS['existingData']['lastPage'] = ceil($row[0]['total'] / PATIENTS_PER_PAGE);
            if ($GLOBALS['existingData']['lastPage'] < $pg)
                $pg = $GLOBALS['existingData']['lastPage'];
            // Limit number of rows returned based on page
            $cnt = $pg * PATIENTS_PER_PAGE;
            if (DEBUG_FLAG)
                echo $patientSelect;
            $result = database()->query($patientSelect . " ORDER BY clinicPatientID, lname, fname limit " . $cnt, $paramArray);
            if (!$result)
                die("FATAL ERROR: Could not search for patient in patient and obs." . $patientSelect);
            else {
                $cnt = 0;
                while ($row = $result->fetch()) {
                    $row['patientID'] = $row['siteCode'] . $row['person_id'];
                    $row['obgynID'] = "";
                    $row['primCareID'] = "";
                    $cnt++;
                    if ($pg > 0 && ($cnt < (($pg - 1) * PATIENTS_PER_PAGE + 1) || $cnt > ($pg * PATIENTS_PER_PAGE)))
                        continue;
                    array_push($results, $row);
                }
                $qry = "select c.short_name, value_text from obs o, concept c where o.concept_id = c.concept_id and short_name in (?, ?) and person_id = ? and location_Id = ?";
                $statement = database()->prepare($qry);
                foreach ($results as $row) {
                    $paramArray = array('obgynID', 'primCareID', $row['person_id'], $row['siteCode']);
                    $statement->execute($paramArray);
                    while ($rw2 = $statement->fetch()) {
                        $row[$rw2['short_name']] = $rw2['value_text'];
                    }
                    array_push($finalResults, $row);
                }
                if (count($finalResults) == 1 && $ifOnlyOne && $pg == 1) {
                    echo "
					<script type=\"text/javascript\">
					<!--
					  var xloc = 'patienttabs.php?pid=' + " . $results[0]['siteCode'] . $results[0]['person_id'] . " + '&lang=" . $lang . "&site=" . $site . "';
					 //alert (xloc);
					  window.location.href = xloc;
					//-->
					</script>";
                }
            }
        }
        return ($finalResults);
    }

    function find_ucfirst($haystack) {
        $needle = "<span";
        $result = strallpos($haystack, $needle);
        $outString = $haystack;
        foreach ($result as $ipos) {
            if ($ipos === 0 || substr($outString, $ipos - 1, 1) == ' ') {
                $ipos2 = strpos($outString, '>', $ipos + 1) + 1;
                $outString = substr($outString, 0, $ipos2) . ucfirst(substr($outString, $ipos2));
            }
        }
        return $outString;
    }

    function strallpos($haystack, $needle, $offset = 0) {
        $result = array();
        for ($i = $offset; $i < strlen($haystack); $i++) {
            $pos = strpos($haystack, $needle, $i);
            if ($pos !== FALSE) {
                $offset = $pos;
                if ($offset >= $i) {
                    $i = $offset;
                    $result[] = $offset;
                }
            }
        }
        return $result;
    }

    function utf8_strtolower($string) {
        return utf8_encode(strtolower(utf8_decode($string)));
    }

    function utf8_ucfirst($string) {
        return utf8_encode(ucfirst(utf8_decode($string)));
    }
    ?>
</div>
</form>

</body>
</html>
