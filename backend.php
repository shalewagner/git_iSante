<?php
require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backendAddon.php';
require_once 'backend/concept.php';
require_once 'backend/fingerprint.php';
require_once 'labels/labels.php';

// $idColumnType is the datatype of the auto_icrement columns
$idColumnType = 'int unsigned';
$siteCodeColumnType = 'mediumint unsigned';

$sessionUser = getSessionUser();
if ( getAccessLevel($sessionUser) == "3" && getDebugFlag($sessionUser) == "1")
	define ("DEBUG_FLAG", true);
else
	define ("DEBUG_FLAG", false);
	
// Don't go to application if db version isn't up to date
if (! isDatabaseSchemaUpToDate()) {
  // if admin, branch to upgrade page
  if (getAccessLevel ($sessionUser) < 2) {
    $status = "user";
  } else {
    $status = "admin";
  }
  header ("Location: upgradeSplash.php?status=" . $status . "&lang=" . ((empty ($_GET['lang'])) ? $GLOBALS['def_lang'] : $_GET['lang']));
  exit;
}

# Authorization check
# Dump user if $sessionUser is not in the 'userPrivilege' table and $_GET['noid'] isn't set to true.
if (verifyUserAuth($sessionUser) == 0 
    && !(isset($_REQUEST['noid']) && $_REQUEST['noid'] == 'true')) {
  header("Location: error.php?type=auth&lang=" 
	 . ((empty ($_GET['lang'])) ? $GLOBALS['def_lang'] : $_GET['lang']));
  exit;
} 

$privArray = getPrivAttributes ($sessionUser, DEF_SITE);
define ("PC_AUTH", isAuthTrue($privArray['serviceArea'], 1));
define ("OB_AUTH", isAuthTrue($privArray['serviceArea'], 2));
define ("HIV_AUTH", isAuthTrue($privArray['serviceArea'], 4));                                                  
/* set ui configuration for the user
 * data entry clerk = non-tabbed version or point of care = tabbed version
 * (currently deprecated)
 */
$tabsOn = $privArray['uiConfiguration'];
//$tabsOn = getUiConfig($sessionUser);

// Remove extra backslashes from GET and POST arrays
if (!empty ($_GET)) $_GET = array_map ("stripslashes", $_GET);
//if (!empty ($_POST)) $_POST = array_map ("stripslashes", $_POST);

function getPrivAttributes ($username, $site = 0) {
	$retVal = array('username' => $username, 'privLevel' => 1, 'siteCode' => $site, 'allowTrans' => 0, 'allowValidate' => 0, 'uiConfiguration' => 3, 'debugFlag' => 0, 'network' => '', 'serviceArea' => 7);  
	$rows = database()->query('SELECT * FROM userPrivilege where username = ?',array($username))->fetchAll(PDO::FETCH_ASSOC);
	if (count($rows) > 0) $retVal = $rows[0];
	return $retVal; 
}

function isAuthTrue ($value, $bin) {
	$binstring = strrev (decbin ($value));
        return (!empty ($binstring{log ($bin, 2)}) && $binstring{log ($bin, 2)} == 1) ? true : false;
}

// Zero-pad (left) a string for display
function zpad ($str = "", $len) {
  if (trim($str) == "" || is_null($str)){ return $str;}
  while (strlen($str) < $len){ $str = "0" . $str;}
  return $str;
}

/* Assume a two-digit year greater than the cutoff value is in the previous */
/* century, else current century, return 4-digit year or -1 on bad input */
function assumeYear ($yr) {
  /* Set this cutoff value to whatever year you want to use as a breakpoint */
  $cutoff = 15;

  /* Only handle one or two digit years */
  $yr = trim ($yr);
  if (!is_numeric ($yr)) return (-1);
  switch (strlen ($yr)) {
    case 0:
      return (-1);
      break;
    case 1:
      $yr = "0" . $yr;
    case 2:
      if ($yr > $cutoff) {
        return (substr (date ("Y", strtotime ("now")), 0, 2) - 1 . $yr);
      } else {
        return (substr (date ("Y", strtotime ("now")), 0, 2) . $yr);
      }
      break;
    default:
      return (-1);
  }
}

// Convert text date string to MySQL format for database insertion
function dateToMySQL ($dateString) {

  $monthNums = array ("jan" => 1, "feb" => 2, "mar" => 3, "apr" => 4, "may" => 5, "jun" => 6, "jul" => 7, "aug" => 8, "sep" => 9, "oct" => 10, "nov" => 11, "dec" => 12);

  # Find 4-digit year at front, otherwise assume last field is year
  if (eregi ("^([0-9]{4})[ .,/-]+([a-z0-9]+)[ .,/-]+([a-z0-9]+)", $dateString, $splitdate)) {
    list ($string, $year, $value1, $value2) = $splitdate;
  } else if (eregi ("([a-z0-9]+)[ .,/-]+([a-z0-9]+)[ .,/-]+([0-9]{1,4})$", $dateString, $splitdate)) {
    # 1 to 4-digit year at end
    list ($string, $value1, $value2, $year) = $splitdate;
    if (strlen ($year) < 3) {
      # Make assumptions about century
      $now = time ();
      $y1 = date ("Y", $now);
      $y2 = $y1 + 10;
      $year += 1900;
      while ($year < $y1) $year += 100;
      while ($year > $y2) $year -= 100;
    }

  } else {
    # Error - invalid format
    return (0);
  }

  # Look for an alphabetic month
  if (eregi ("[a-z]+", $value1)) {
    $month = $monthNums[strtolower (substr ($value1, 0, 3))];
    $day = $value2;
  } else if (eregi ("[a-z]+", $value2)) {
    $month = $monthNums[strtolower (substr ($value2, 0, 3))];
    $day = $value1;
  } else if ($value1 > 12) {
    # Determine if first value is month or day
    $day = $value1;
    $month = $value2;
  } else {
    $month = $value1;
    $day = $value2;
  }

  # Check to see if it's a valid date
  if (!checkdate ($month, $day, $year)) return (0);

  # Return date string in MySQL format
  $sqlDate = sprintf ("%04d-%02d-%02d", $year, (int)$month, (int)$day);

  return ($sqlDate);
}

// Compute difference between two dates, return difference in days
function dateDiff ($date1, $date2) {
  if (empty ($date1) || empty ($date2)) return;
  list ($year1, $month1, $day1) = explode ('-', $date1);
  list ($year2, $month2, $day2) = explode ('-', $date2);
  //$time1 = (date ('H', $date1) * 3600) + (date ('i', $date1) * 60) + (date ('s',$date1));
  //$time2 = (date ('H', $date2) * 3600) + (date ('i', $date2) * 60) + (date ('s',$date2));
  $diff = $year2 - $year1;
  if ($month1 > $month2) {
    $diff -= 1;
  } elseif ($month1 == $month2) {
    if ($day1 > $day2) {
      $diff -= 1;
    //} elseif ($day1 == $day2) {
    //  if ($time1 > $time2) {
    //    $diff -= 1;
    //  }
    }
  }
  return ($diff);
}

// Repetitive table gen functions

function houseCompCols ($cnt = 0, $idx = 1) {
  $str = "";

  for ($i = 1; $i <= $cnt; $i++) {
    $str .= "
      <tr>
       <td width=\"25%\"><input tabindex=\"" . $idx++ . "\"  name=\"householdName" . $i . "\" " . getData ("householdName" . $i, "text") . " type=\"text\" size=\"30\" maxlength=\"255\"></td>
       <td width=\"10%\"><table><tr><td  id=\"householdAge" . $i . "Title\">&nbsp;</td><td><input tabindex=\"" . $idx++ . "\" id=\"householdAge" . $i . "\" name=\"householdAge" . $i . "\" " . getData ("householdAge" . $i, "text") . " type=\"text\" size=\"5\" maxlength=\"64\"></td></tr></table></td>
       <td width=\"20%\"><input tabindex=\"" . $idx++ . "\" name=\"householdRel" . $i . "\" " . getData ("householdRel" . $i, "text") . " type=\"text\" size=\"25\" maxlength=\"255\"></td>
       <td width=\"20%\"><input tabindex=\"" . $idx++ . "\" name=\"householdHiv" . $i . "[]\" " . getData ("householdHiv" . $i, "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $GLOBALS['householdComp_hivStatus'][$GLOBALS['lang']][1] . " <input tabindex=\"" . $idx++ . "\" name=\"householdHiv" . $i . "[]\" " . getData ("householdHiv" . $i, "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $GLOBALS['householdComp_hivStatus'][$GLOBALS['lang']][2] . " <input tabindex=\"" . $idx++ . "\" name=\"householdHiv" . $i . "[]\" " . getData ("householdHiv" . $i, "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $GLOBALS['householdComp_hivStatus'][$GLOBALS['lang']][3] . "</td>
       <td width=\"15%\"><input tabindex=\"" . $idx++ . "\" name=\"householdDisc" . $i . "[]\" " . getData ("householdDisc" . $i, "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $GLOBALS['householdComp_disclosure'][$GLOBALS['lang']][1] . " <input tabindex=\"" . $idx++ . "\" name=\"householdDisc" . $i . "[]\" " . getData ("householdDisc" . $i, "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $GLOBALS['householdComp_disclosure'][$GLOBALS['lang']][2] . "</td>
      </tr>\n";
  }

  return ($str);
}

function labRowsWithCheckboxes($resultIndex, $hasTextField, $isUnitOption, &$result, $labData, $a, $lang, &$cnt) {
  //is of type checkbox with text field associated, but this specific option
  //does not have a corresponding text field
  if ((empty($labData[$a]['resultLabel' . init_upper ($lang) . $resultIndex]))
     and ($hasTextField) and (fmod($resultIndex,2) != 0))
    return FALSE;
  //after last item, either type 4 or 3
  if ((empty($labData[$a]['resultLabel' . init_upper ($lang) . $resultIndex]))
     and ( (($hasTextField) and (fmod($resultIndex,2) == 0)) //type 4
       or  (!$hasTextField) ) ) //type 3
    return TRUE;

  //is a checkbox
  if ((!empty ($labData[$a]['resultLabel' . init_upper ($lang) . $resultIndex]))
      and ((!$hasTextField) or
           (($hasTextField) and (fmod($resultIndex,2) != 0)) )) {
    $checkboxIndex = $resultIndex-1;
    $savedDBCol = "2"; //result column in the labs database
    if (($hasTextField) or (!$hasTextField and $isUnitOption == ""))
    {
      $checkboxIndex = ($hasTextField) ? ($resultIndex+1)/2 -1 : $resultIndex-1;
      $savedDBCol = "";
    }
    $optionValue = pow(2,$checkboxIndex);
    $result .= "
      <input tabindex=\"" . $cnt++ . "\" id=\"" . $a .
      "TestResult" . $savedDBCol . $checkboxIndex ."\" name=\"" . $a .
      "TestResult" . $savedDBCol . "[]\" " .
      getData ($a . "TestResult". $savedDBCol, "checkbox", $optionValue) .
      " type=\"radio\" value=\"" . $optionValue . "\">" .
      $labData[$a]['resultLabel' . init_upper ($lang) . $resultIndex] . "\n";
    return FALSE;
  }

  //is a text field associated with a previous checkbox
  if ((!empty ($labData[$a]['resultLabel' . init_upper ($lang) . $resultIndex]))
      and ($hasTextField) and (fmod($resultIndex,2) == 0) ) {
    $result .= " <table><tr><td id=\"" . $a .
      "TestResult" . ($resultIndex - ($resultIndex/2 -1)) . "Title\"></td><td><input tabindex=\"" . $cnt++ . "\" id=\"" . $a .
      "TestResult" . ($resultIndex - ($resultIndex/2 -1)) . "\" name=\"" . $a .
      "TestResult" . ($resultIndex - ($resultIndex/2 -1)) . "\" " .
      getData ($a . "TestResult" . ($resultIndex - ($resultIndex/2 -1)), "text") .
      " type=\"text\" size=\"10\" maxlength=\"64\" class=\"small_cnt\"> " .
      $labData[$a]['resultLabel' . init_upper ($lang) . $resultIndex] . "<br></td></tr></table>\n";
    return FALSE;
  }
}

function labRows ($cnt = 0, $version) {
  $cols = array ("full" => "", "bottom" => "");
  $labData = lookupLabs ($version, "");
  $lang = $GLOBALS['lang'];
  $rowClass = "reg";
  $maxColsDB = 6;
  $section = '';
  $confirm = array (
   "en" => array ("Would you like to use this date for all fields in the hematology panel?"),
   "fr" => array (html_entity_decode("Vous aiment employer cette date pour tous les champs en h&eacute;matologie lambrissent ?",ENT_QUOTES, CHARSET))
  );
  $extraFields = (getUiConfig(getSessionUser()) != "2" && getUiConfig(getSessionUser()) != "3") ? 0:1;
  foreach ($GLOBALS['labs' . $version] as $a) {
    $result = "";
	$callHemDtAlert = "";
    if ($lang == "fr" && $a == "otherLab2") continue;
    if(in_array($a,$GLOBALS['labPOCadditions']) && getUiConfig(getSessionUser()) != "2" && getUiConfig(getSessionUser()) != "3")	continue;
	if(in_array($a,$GLOBALS['labPOCadditions']) && $version == 0) continue;
	if (strpos ($a, "subhead") === false) {
	  if($section == "subhead3" || $section == "subhead31") $callHemDtAlert = " onblur=\"hemDtAlert('" . $a . "', '" . $section . "'," . $extraFields . ", '". $confirm[$lang][0] . "')\"";
      $rowClass = ($rowClass == "reg") ? "alt" : "reg";
      if(in_array($a,$GLOBALS['labPOCadditions'])){
	  $cols["full"] .= "
      <tr class=\"" . $rowClass . "\">";
	  }else{
	  $cols["full"] .= "
      <tr class=\"" . $rowClass . "\">";
	  }
	  $cols["full"] .= "
       <td class=\"sm_header_cnt\" valign=\"middle\" width=\"10%\"><table><tr><td width=\"5%\" id=\"" . $a . "Test[]Title\">
         </td><td class=\"sm_header_cnt\" valign=\"left\" ><input tabindex=\"" . $cnt++ .
         "\" id=\"" . $a . "Test[]\" name=\"" . $a . "Test[]\" " . getData ($a . "Test", "checkbox") .
         " type=\"checkbox\" value=\"On\"></td></tr></table></td>";
      if (strpos ($a, "other") === 0) {
        $result .= "<input tabindex=\"" . $cnt++ . "\" id=\"" . $a .
          "TestResult\" name=\"" . $a .
          "TestResult\" " . getData ($a . "TestResult", "text") .
          " type=\"text\" size=\"40\" maxlength=\"255\" class=\"small_cnt\">";
        $label = $GLOBALS['labs_subheadOther'][$GLOBALS['lang']][1];
      } else {
        $label = $labData[$a]['testName' . init_upper ($lang)];

//In the future, it would be nice to redo the following solution
//A better way would be to have it designed so one type of field can be
//followed by another and have a followedBy column in the database. It would
//also be important to think about fields inbetween fields, like checboxes that
//have textfields between options (e.g. ppd/mantoux and malaria)
        switch ($labData[$a]['resultType']) {
          case 1: //checkbox
            for ($i = 1; $i <= $maxColsDB; $i++) {
               $last = labRowsWithCheckboxes($i, FALSE, "", $result, $labData,
                 $a, $lang, $cnt);
               if ($last) break;
            }
            break;
          case 2: //text field for one unit
            $result .= "<input tabindex=\"" . $cnt++ . "\" id=\"" . $a .
              "TestResult\"  name=\"" . $a .
              "TestResult\" " . getData ($a . "TestResult", "text") .
              " type=\"text\" size=\"10\" maxlength=\"64\" class=\"small_cnt\"> " .
              $labData[$a]['resultLabel' . init_upper ($lang) . '1']. "\n";
            break;
          case 3: //text fields for 2 or more units
          //if a field with more than 4 text fields is created, labs table needs
          //to be updated to include columns for them
            $result .= "\n<table><tr><td><input tabindex=\"" . $cnt++ . "\" id=\"" . $a .
              "TestResult\" name=\"" . $a .
              "TestResult\" " . getData ($a . "TestResult", "text") .
              " type=\"text\" size=\"10\" maxlength=\"64\" class=\"small_cnt\"> " .
              $labData[$a]['resultLabel' . init_upper ($lang) . '1'] .
              "\n</td><td id=\"" . $a . "TestResult2Title\" >&nbsp;</td><td>
              <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "TestResult2\" name=\"" . $a . "TestResult2\" " .
              getData ($a . "TestResult2", "text") .
              " type=\"text\" size=\"3\" maxlength=\"64\" class=\"small_cnt\"> " .
              $labData[$a]['resultLabel' . init_upper ($lang) . '2'] . "\n</td>";
            if (!empty ($labData[$a]['resultLabel' . init_upper ($lang) . '3']))
              $result .= "<td id=\"" . $a . "TestResult3Title\" >&nbsp;</td><td><input tabindex=\"" . $cnt++ . "\" id=\"" . $a .
              "TestResult3\" name=\"" . $a .
              "TestResult3\" " . getData ($a . "TestResult3", "text") .
              " type=\"text\" size=\"3\" maxlength=\"64\" class=\"small_cnt\"> " .
              $labData[$a]['resultLabel' . init_upper ($lang) . '3'] . "\n</td>";
            if (!empty ($labData[$a]['resultLabel' . init_upper ($lang) . '4']))
              $result .= "<td id=\"" . $a . "TestResult4Title\" >&nbsp;</td><td><input tabindex=\"" . $cnt++ . "\" id=\"" . $a .
              "TestResult4\" name=\"" . $a .
              "TestResult4\" " . getData ($a . "TestResult4", "text") .
              " type=\"text\" size=\"10\" maxlength=\"64\" class=\"small_cnt\"> " .
              $labData[$a]['resultLabel' . init_upper ($lang) . '4'] . "\n</td>";
            $result .= "</tr></table>";
            break;
          case 4: //checkbox followed by a text field
            for ($i = 1; $i <= $maxColsDB; $i++) {
              $last = labRowsWithCheckboxes($i, TRUE, "", $result, $labData,
                                            $a, $lang, $cnt);
              if ($last) break;
            }
            break;
          case 5: //one text field followed by checkboxes as options for units
            //text field
            $result .= "<table><tr><td><input tabindex=\"" . $cnt++ . "\" id=\"" . $a .
              "TestResult\" name=\"" . $a .
              "TestResult\" " . getData ($a . "TestResult", "text") .
              " type=\"text\" size=\"10\" maxlength=\"64\" class=\"small_cnt\"> " .
              $GLOBALS['labs_unitOfMeasure'][$GLOBALS['lang']][0] . "\n</td><td id=\"" . $a ."TestResultUnitTitle\">&nbsp;</td><td>";

            //checkboxes for the different unit options
            for ($i = 1; $i <= $maxColsDB; $i++) {
              $last = labRowsWithCheckboxes($i, FALSE, "Unit", $result,
                                            $labData, $a, $lang, $cnt);
              if ($last) break;
            }
            $result .= "</td></tr></table>";
            break;
          case 6: //malaria (I know, it's terrible to have this exception!)
            //checkbox option Positive
            //positive option 
            $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult1" name="' . $a . 'TestResult[]" ' . getData ($a . "TestResult", "checkbox", 1) . ' type="radio" value="1">' . $labData[$a]['resultLabel' . init_upper ($lang) . '1'] . '&nbsp;';
            //FT
            $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult2" name="' . $a . 'TestResult2[]" ' . getData ($a . "TestResult2", "checkbox", 1) . ' type="checkbox" value="1">' . $labData[$a]['resultLabel' . init_upper ($lang) . '2'] . '&nbsp;';
            //FG
            $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult3" name="' . $a . 'TestResult2[]" ' . getData ($a . "TestResult2", "checkbox", 2) . ' type="checkbox" value="2">' . $labData[$a]['resultLabel' . init_upper ($lang) . '3'] . '&nbsp;';
            //Vx
            $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult4" name="' . $a . 'TestResult2[]" ' . getData ($a . "TestResult2", "checkbox", 4) . ' type="checkbox" value="4">Vx&nbsp;';
            //Ov
            $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult5" name="' . $a . 'TestResult2[]" ' . getData ($a . "TestResult2", "checkbox", 8) . ' type="checkbox" value="8">Ov&nbsp;';
            //Mal
            $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult6" name="' . $a . 'TestResult2[]" ' . getData ($a . "TestResult2", "checkbox", 16) . ' type="checkbox" value="16">Mal&nbsp;';
            //text field
            $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult7" name="' . $a . 'TestResult3" ' . getData ($a . "TestResult3", "text") . ' type="text" size="10" maxlength="64" class="small_cnt"> ' . $labData[$a]['resultLabel' . init_upper ($lang) . '4'];
            //negative option
            $result .= '<br><input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult8" name="' . $a . 'TestResult[]" ' . getData ($a . "TestResult", "checkbox", 2) . ' type="radio" value="2">' . $labData[$a]['resultLabel' . init_upper ($lang) . '5'];
            break;
          case 8: //special case for ped form blood type (order of boxes is different and one label shouldn't have a box
            $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult8" name="' . $a . 'TestResult[]" ' . getData ($a . "TestResult", "checkbox", 8) . ' type="radio" value="8"> ' . $labData[$a]['resultLabel' . init_upper ($GLOBALS['lang']) . '1'];
            $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult1" name="' . $a . 'TestResult[]" ' . getData ($a . "TestResult", "checkbox", 1) . ' type="radio" value="1"> ' . $labData[$a]['resultLabel' . init_upper ($GLOBALS['lang']) . '2'];
            $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult2" name="' . $a . 'TestResult[]" ' . getData ($a . "TestResult", "checkbox", 2) . ' type="radio" value="2"> ' . $labData[$a]['resultLabel' . init_upper ($GLOBALS['lang']) . '3'];
            $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult4" name="' . $a . 'TestResult[]" ' . getData ($a . "TestResult", "checkbox", 4) . ' type="radio" value="4"> ' . $labData[$a]['resultLabel' . init_upper ($GLOBALS['lang']) . '4'];
           $result .= '<br/>';
            $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult16" name="' . $a . 'TestResult2" ' . getData ($a . "TestResult2", "checkbox", 1) . ' type="radio" value="1"> ' . $labData[$a]['resultLabel' . init_upper ($GLOBALS['lang']) . '5'];
            $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult32" name="' . $a . 'TestResult2" ' . getData ($a . "TestResult2", "checkbox", 2) . ' type="radio" value="2"> ' . $labData[$a]['resultLabel' . init_upper ($GLOBALS['lang']) . '6'];
            break;
          default:
            $result = "";
            break;
        }
      }

      $cols["full"] .= "
       <td id=\"" . $a . "TestResultTitle\" width=\"20%\" class=\"small_cnt\">$label</td>
       <td width=\"35%\" class=\"small_cnt\"  valign=\"middle\" >$result</td>
       <td class=\"sm_header_cnt\" width=\"10%\">
        <table><tr><td id=\"" . $a . "TestAbnormal[]Title\"></td><td><input tabindex=\"" .
         $cnt++ . "\" id=\"" . $a . "TestAbnormal[]\" name=\"" . $a . "TestAbnormal[]\" " .
         getData ($a . "TestAbnormal", "checkbox") . " type=\"checkbox\" value=\"On\">
        </td></tr></table></td>
       <td width=\"5%\" id=\"" . $a . "TestDtTitle\">&nbsp;</td>
       <td width=\"20%\" class=\"small_cnt\" >
		<table><tr><td><input tabindex=\"" . $cnt++ .
		         "\" id=\"" . $a . "TestDt\" name=\"" . $a . "TestDt\" " . $callHemDtAlert . "
 				value=\"" . getData ($a . "TestDd", "textarea") . "/". getData ($a . "TestMm", "textarea") ."/". getData ($a . "TestYy", "textarea") . "\"
 				type=\"text\" size=\"8\" maxlength=\"8\" class=\"small_cnt\">
       	<input id=\"" . $a . "TestDd\"  name=\"" . $a . "TestDd\" " . getData ($a . "TestDd", "text") .
         " type=\"hidden\" class=\"small_cnt\"><input tabindex=\"" .
         $cnt++ . "\" id=\"" . $a . "TestMm\" name=\"" . $a . "TestMm\" " . getData ($a . "TestMm", "text") .
         " type=\"hidden\"  class=\"small_cnt\"><input tabindex=\"" .
         $cnt++ . "\" id=\"" . $a . "TestYy\" name=\"" . $a . "TestYy\" " . getData ($a . "TestYy", "text") .
         " type=\"hidden\"  class=\"small_cnt\"></td><td> <i>" .
         $GLOBALS['labs_resultDate'][$lang][2] . "</i></td></tr></table></td>
      </tr>";
    } else {
	  $section = $a;
      $rowClass = "reg";
      $cols["full"] .= "
      <tr>
       <td width=\"10%\">&nbsp;</td>
       <td colspan=\"5\" width=\"90%\"><b>" . $GLOBALS["labs_" . $a][$GLOBALS['lang']][1] . "</b></td>
      </tr>";
    }
  }

  $tabIndex = $cnt;

  return ($cols);
}

function pedLabRows ($cnt = 0) {
  $cols = array ("full" => "", "bottom" => "");
  $query = "SELECT * FROM labLookup WHERE version1 = '1'";
  $result = dbQuery ($query);

  $labData = array ();
  while ($row = psRowFetch ($result)) {
    $labData[$row['labName']] = $row;
  }
  $lang = $GLOBALS['lang'];
  $rowClass = "reg";
  $maxColsDB = 7;
  $section = '';
  $confirm = array (
   "en" => array ("Would you like to use this date for all fields in the hematology panel?"),
   "fr" => array (html_entity_decode("Vous aiment employer cette date pour tous les champs en h&eacute;matologie lambrissent ?",ENT_QUOTES, CHARSET))
  );
  $extraFields = (getUiConfig(getSessionUser()) != "2" && getUiConfig(getSessionUser()) != "3") ? 0:1;
  
  foreach ($GLOBALS['pedLabs'] as $a) {
    $result = "";
	if(in_array($a,$GLOBALS['labPOCadditions']) && getUiConfig(getSessionUser()) != "2" && getUiConfig(getSessionUser()) != "3")	continue;
    if (strpos ($a, "subhead") === false) {
	  if($section == "subhead3" || $section == "subhead31") 
	  {
		$callHemDtAlert = " onblur=\"hemDtAlert('" . $a . "', '" . $section . "'," . $extraFields . ", '". $confirm[$lang][0] . "')\"";
      }
	  else
	  {
		$callHemDtAlert = "";
	  }
	  $rowClass = ($rowClass == "reg") ? "alt" : "reg";
      if(in_array($a,$GLOBALS['labPOCadditions'])){
		  	$cols["full"] .= "
	      <tr class=\"" . $rowClass . "\">";
		  }else{
		  	$cols["full"] .= "
	      <tr class=\"" . $rowClass . "\">";
		  }
      $cols["full"] .= "
       <td class=\"sm_header_cnt\" valign=\"middle\" width=\"10%\"><table><tr><td width=\"5%\" id=\"" . $a . "Test[]Title\">
         </td><td class=\"sm_header_cnt\" valign=\"left\" >
         <input tabindex=\"" . $cnt++ .
         "\" id=\"" . $a . "Test[]\" name=\"" . $a . "Test[]\" " . getData ($a . "Test", "checkbox") .
         " type=\"checkbox\" value=\"On\"></td></tr></table></td>";
      if (strpos ($a, "other") === 0) {
        $label = $GLOBALS['pedLaboratory'][$GLOBALS['lang']][7] . " <i>" . $GLOBALS['pedLaboratory'][$GLOBALS['lang']][8] . "</i> <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "TestText\" name=\"" . $a . "TestText\" " . getData ($a . "TestText", "text") . " type=\"text\" size=\"20\" maxlength=\"255\" class=\"small_cnt\">";
        $result .= "<input tabindex=\"" . $cnt++ . "\" id=\"" . $a .
          "TestResult\" id=\"" . $a .
          "TestResult\" name=\"" . $a .
          "TestResult\" " . getData ($a . "TestResult", "text") .
          " type=\"text\" size=\"40\" maxlength=\"255\" class=\"small_cnt\">";
      } else {
        $label = $labData[$a]['testName' . init_upper ($lang)];

        // If ped specific labels exist, use them instead of the original ones
        if (!empty ($labData[$a]['pedResultLabelEn1'])) for ($i = 1; $i <= $maxColsDB; $i++) $labData[$a]['resultLabel' . init_upper ($lang) . $i] = $labData[$a]['pedResultLabel' . init_upper ($lang) . $i];

        // Same for ped specific result type
        if (!empty ($labData[$a]['pedResultType'])) $labData[$a]['resultType'] = $labData[$a]['pedResultType'];

        switch ($labData[$a]['resultType']) {
          case 1: //checkbox
            for ($i = 1; $i <= $maxColsDB; $i++) {
               $last = labRowsWithCheckboxes($i, FALSE, "", $result, $labData,
                 $a, $lang, $cnt);
               if ($last) break;
            }
            break;
          case 2: //text field for one unit
            $result .= "<input tabindex=\"" . $cnt++ . "\" id=\"" . $a .
              "TestResult\" name=\"" . $a .
              "TestResult\" " . getData ($a . "TestResult", "text") .
              " type=\"text\" size=\"10\" maxlength=\"64\" class=\"small_cnt\"> " .
              $labData[$a]['resultLabel' . init_upper ($lang) . '1']. "\n";
            break;
          case 3: //text fields for 2 or more units
          //if a field with more than 4 text fields is created, labs table needs
          //to be updated to include columns for them
            $result .= "\n<table><tr><td><input tabindex=\"" . $cnt++ . "\" id=\"" . $a .
              "TestResult\"  name=\"" . $a .
              "TestResult\" " . getData ($a . "TestResult", "text") .
              " type=\"text\" size=\"10\" maxlength=\"64\" class=\"small_cnt\"> " .
              $labData[$a]['resultLabel' . init_upper ($lang) . '1'] .
              "\n</td><td id=\"" . $a . "TestResult2Title\" >&nbsp;</td><td><input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "TestResult2\" name=\"" . $a . "TestResult2\" " .
              getData ($a . "TestResult2", "text") .
              " type=\"text\" size=\"3\" maxlength=\"64\" class=\"small_cnt\"> " .
              $labData[$a]['resultLabel' . init_upper ($lang) . '2'] . "\n";
            if (!empty ($labData[$a]['resultLabel' . init_upper ($lang) . '3']))
              $result .= "<td id=\"" . $a . "TestResult3Title\" >&nbsp;</td><td><input tabindex=\"" . $cnt++ . "\" id=\"" . $a .
              "TestResult3\" name=\"" . $a .
              "TestResult3\" " . getData ($a . "TestResult3", "text") .
              " type=\"text\" size=\"3\" maxlength=\"64\" class=\"small_cnt\"> " .
              $labData[$a]['resultLabel' . init_upper ($lang) . '3'] . "\n</td>";
            if (!empty ($labData[$a]['resultLabel' . init_upper ($lang) . '4']))
              $result .= "<td id=\"" . $a . "TestResult4Title\" >&nbsp;</td><td><input tabindex=\"" . $cnt++ . "\" id=\"" . $a .
              "TestResult4\" name=\"" . $a .
              "TestResult4\" " . getData ($a . "TestResult4", "text") .
              " type=\"text\" size=\"10\" maxlength=\"64\" class=\"small_cnt\"> " .
              $labData[$a]['resultLabel' . init_upper ($lang) . '4'] . "\n</td>";
              $result .= "</tr></table>";
            break;
          case 4: //checkbox followed by a text field
            for ($i = 1; $i <= $maxColsDB; $i++) {
              $last = labRowsWithCheckboxes($i, TRUE, "", $result, $labData,
                                            $a, $lang, $cnt);
              if ($last) break;
            }
            break;
          case 5: //one text field followed by checkboxes as options for units
            //text field
            $result .= "<table><tr><td><input tabindex=\"" . $cnt++ . "\" id=\"" . $a .
              "TestResult\" name=\"" . $a .
              "TestResult\" " . getData ($a . "TestResult", "text") .
              " type=\"text\" size=\"10\" maxlength=\"64\" class=\"small_cnt\"> " .
              $GLOBALS['labs_unitOfMeasure'][$GLOBALS['lang']][0] . "</td><td id=\"" . $a ."TestResultUnitTitle\">&nbsp;</td><td>";

            //checkboxes for the different unit options
            for ($i = 1; $i <= $maxColsDB; $i++) {
              $last = labRowsWithCheckboxes($i, FALSE, "Unit", $result,
                                            $labData, $a, $lang, $cnt);
              if ($last) break;
            }
            $result .= "</td></tr></table>";
            break;
          case 6: //malaria (I know, it's terrible to have this exception!)
          //checkbox option Positive
          //positive option 
          $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult1" name="' . $a . 'TestResult[]" ' . getData ($a . "TestResult", "checkbox", 1) . ' type="radio" value="1">' . $labData[$a]['resultLabel' . init_upper ($lang) . '1'] . '&nbsp;';
          //FT
          $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult2" name="' . $a . 'TestResult2[]" ' . getData ($a . "TestResult2", "checkbox", 1) . ' type="checkbox" value="1">' . $labData[$a]['resultLabel' . init_upper ($lang) . '2'] . '&nbsp;';
          //FG
          $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult3" name="' . $a . 'TestResult2[]" ' . getData ($a . "TestResult2", "checkbox", 2) . ' type="checkbox" value="2">' . $labData[$a]['resultLabel' . init_upper ($lang) . '3'] . '&nbsp;';
          //Vx
          $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult4" name="' . $a . 'TestResult2[]" ' . getData ($a . "TestResult2", "checkbox", 4) . ' type="checkbox" value="4">Vx&nbsp;';
          //Ov
          $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult5" name="' . $a . 'TestResult2[]" ' . getData ($a . "TestResult2", "checkbox", 8) . ' type="checkbox" value="8">Ov&nbsp;';
          //Mal
          $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult6" name="' . $a . 'TestResult2[]" ' . getData ($a . "TestResult2", "checkbox", 16) . ' type="checkbox" value="16">Mal&nbsp;';
          //text field
          $result .= '<input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult7" name="' . $a . 'TestResult3" ' . getData ($a . "TestResult3", "text") . ' type="text" size="10" maxlength="64" class="small_cnt"> ' . $labData[$a]['resultLabel' . init_upper ($lang) . '4'];
          //negative option
          $result .= '<br><input tabindex="' . $cnt++ . '" id="' . $a . 'TestResult8" name="' . $a . 'TestResult[]" ' . getData ($a . "TestResult", "checkbox", 2) . ' type="radio" value="2">' . $labData[$a]['resultLabel' . init_upper ($lang) . '5'];
          break;
          case 7: //set of checkboxes followed by a single text box
            for ($i = 1; $i <= $maxColsDB; $i++) {
               $last = labRowsWithCheckboxes($i, FALSE, "", $result, $labData,
                 $a, $lang, $cnt);
               if ($last) break;
            }
            $result .= " <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "TestResult2Txt\" name=\"" . $a . "TestResult2\" " . getData ($a . "TestResult2", "text") . " type=\"text\" size=\"15\" maxlength=\"255\" class=\"small_cnt\">";
            break;
          case 8: //special case for ped form blood type (order of boxes
                  //is different and one label shouldn't have a box
            $result .= "<input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "TestResult8\" name=\"" . $a . "TestResult[]\" " . getData ($a . "TestResult", "checkbox", 8) . " type=\"radio\" value=\"8\"> " . $labData[$a]['resultLabel' . init_upper ($GLOBALS['lang']) . '1'];
            $result .= " <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "TestResult1\" name=\"" . $a . "TestResult[]\" " . getData ($a . "TestResult", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $labData[$a]['resultLabel' . init_upper ($GLOBALS['lang']) . '2'];
            $result .= " <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "TestResult2\" name=\"" . $a . "TestResult[]\" " . getData ($a . "TestResult", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $labData[$a]['resultLabel' . init_upper ($GLOBALS['lang']) . '3'];
            $result .= " <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "TestResult4\" name=\"" . $a . "TestResult[]\" " . getData ($a . "TestResult", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $labData[$a]['resultLabel' . init_upper ($GLOBALS['lang']) . '4'];
            $result .= $labData[$a]['resultLabel' . init_upper ($GLOBALS['lang']) . '5'] . " ";
            $result .= " <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "TestResult16\" name=\"" . $a . "TestResult2\" " . getData ($a . "TestResult2", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $labData[$a]['resultLabel' . init_upper ($GLOBALS['lang']) . '6'];
            $result .= " <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "TestResult32\" name=\"" . $a . "TestResult2\" " . getData ($a . "TestResult2", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $labData[$a]['resultLabel' . init_upper ($GLOBALS['lang']) . '7'];
            break;
          case 9: //special case for ped form lipase and amylase tests
            // Need to know which result field to pull data from by
            // looking at which checkbox/radio was selected
            $res3 = getData ($a . "TestResult3", "textarea");
            $result .= "<input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "TestResult\" name=\"" . $a . "TestResult\" " . getData ($a . ($res3 == 2 ? "TestResult2" : "TestResult"), "text") . " type=\"text\" size=\"10\" maxlength=\"255\" class=\"small_cnt\"> " . $GLOBALS['labs_unitOfMeasure'][$GLOBALS['lang']][0] . "\n";
            $result .= " <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "TestResult3_1\" name=\"" . $a . "TestResult3[]\" " . getData ($a . "TestResult3", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $labData[$a]['resultLabel' . init_upper ($GLOBALS['lang']) . '1'];
            $result .= " <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "TestResult3_2\" name=\"" . $a . "TestResult3[]\" " . getData ($a . "TestResult3", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $labData[$a]['resultLabel' . init_upper ($GLOBALS['lang']) . '2'];
            break;
          default:
            $result = "";
            break;
        }
      }

      $cols["full"] .= "
       <td id=\"" . $a . "TestResultTitle\" width=\"20%\" class=\"small_cnt\">$label</td>
       <td width=\"35%\" class=\"small_cnt\"  valign=\"middle\" >$result</td>
       <td class=\"sm_header_cnt\" width=\"10%\">
       <table><tr><td id=\"" . $a . "TestAbnormal[]Title\"></td><td>
       	<input tabindex=\"" .
         $cnt++ . "\" id=\"" . $a . "TestAbnormal[]\" name=\"" . $a . "TestAbnormal[]\" " .
         getData ($a . "TestAbnormal", "checkbox") . " type=\"checkbox\" value=\"On\">
        </td></tr></table></td>
       <td width=\"5%\" id=\"" . $a . "TestDtTitle\">&nbsp;</td>
       <td width=\"20%\" class=\"small_cnt\" >
	   		<table><tr><td><input tabindex=\"" . $cnt++ .
	   		         "\" id=\"" . $a . "TestDt\" name=\"" . $a . "TestDt\" " . $callHemDtAlert . "
	    				value=\"" . getData ($a . "TestDd", "textarea") . "/". getData ($a . "TestMm", "textarea") ."/". getData ($a . "TestYy", "textarea") . "\"
	    				type=\"text\" size=\"8\" maxlength=\"8\" class=\"small_cnt\">
	          	<input id=\"" . $a . "TestDd\"  name=\"" . $a . "TestDd\" " . getData ($a . "TestDd", "text") .
	            " type=\"hidden\" class=\"small_cnt\"><input tabindex=\"" .
	            $cnt++ . "\" id=\"" . $a . "TestMm\" name=\"" . $a . "TestMm\" " . getData ($a . "TestMm", "text") .
	            " type=\"hidden\"  class=\"small_cnt\"><input tabindex=\"" .
	            $cnt++ . "\" id=\"" . $a . "TestYy\" name=\"" . $a . "TestYy\" " . getData ($a . "TestYy", "text") .
	            " type=\"hidden\"  class=\"small_cnt\"></td><td> <i>" .
         $GLOBALS['labs_resultDate'][$lang][2] . "</i></td></tr></table></td>
      </tr>";
    } else {
	  $section = $a;
      $rowClass = "reg";
      $cols["full"] .= "
      <tr>
       <td width=\"10%\">&nbsp;</td>
       <td colspan=\"5\" width=\"90%\"><b>" . $GLOBALS["labs_" . $a][$GLOBALS['lang']][1] . "</b></td>
      </tr>";
    }
  }

  $tabIndex = $cnt;

  return ($cols);
}

function init_upper ($str = "") {
  return (substr_replace ($str, strtoupper ($str[0]), 0, 1));
}

function datetime_conv ($str = "", $inc_time = 0) {
  //if (empty($str)) $str = "Apr 01 2000 12:00AM";
  if (empty($str)) $str = "2000-01-01 12:00:00.000";
  //$mos = array ("Jan" => "01", "Feb" => "02", "Mar" => "03", "Apr" => "04", "May" => "05", "Jun" => "06", "Jul" => "07", "Aug" => "08", "Sep" => "09", "Oct" => "10", "Nov" => "11", "Dec" => "12");
  $date1 = explode (" ", $str);
  $date = explode ("-", $date1[0]);
  $time = explode (":", $date1[1]);
 //return ($inc_time) ? zpad ($date[1], 2) . "-" . $mos[$date[0]] . "-" . $date[2] . " " . $date[3] . ((!empty ($date[4])) ? $date[4] : "") : zpad ($date[1], 2) . "-" . $mos[$date[0]] . "-" . $date[2];
 if ($inc_time) return (zpad($date[2],2) . "/" . zpad($date[1],2) . "/" . zpad($date[0],4) . " " . zpad($time[0],2) . ":" .  zpad($time[1],2));
 else return (zpad($date[2],2) . "/" . zpad($date[1],2) . "/" . zpad($date[0],4));
}

function conditionRows ($grp, $tbi = 0, $start = 1, $cnt = 0) {
	if ($cnt == 0) $cnt = count ($GLOBALS['cond_list'][$grp]);
	$ind = 0;
	$bgColor = "#FFFFFF";
	foreach ($GLOBALS['cond_list'][$grp] as $x) {
	$ind++;
	$bgColor = ($bgColor == "#FFFFFF") ? "#D8D8D8" : "#FFFFFF";
	if (($x['code'] == "dmType2") || ($x['code'] == "dmType1") || ($ind < $start) || ($ind > ($start + $cnt - 1))) continue;
	$code = $x['code'];
	echo "
		<tr bgcolor=\"$bgColor\">
		<td align=\"center\" valign=\"top\"><table><tr><td id=\"" . $code . "ActiveTitle\"></td><td><input tabindex=\"" . $tbi++ . "\" id=\"" . $code . "Active1\" name=\"" . $code . "Active[]\" " . getData ($code . "Active", "checkbox", 1) . " type=\"checkbox\" value=\"1\"></td></tr></table></td>
		<td align=\"center\" valign=\"top\"><input tabindex=\"" . $tbi++ . "\" id=\"" . $code . "Active2\" name=\"" . $code . "Active[]\" " . getData ($code . "Active", "checkbox", 2) . " type=\"checkbox\" value=\"2\"></td>
		<td align=\"center\" valign=\"top\"><input tabindex=\"" . $tbi++ . "\" id=\"" . $code . "Active3\" name=\"" . $code . "Active[]\" " . getData ($code . "Active", "checkbox", 4) . " type=\"checkbox\" value=\"4\"></td>
		<td id=\"" . $code . "Title\" class=\"small_cnt\">" . $x[$GLOBALS['lang']];
	if ($code == "dm") {
		echo " <input tabindex=\"" . $tbi++ . "\" id=\"dmType2Active\" name=\"dmType2Active\" " . getData ("dmType2Active", "radio") . " type=\"radio\" value=\"On\">" . $GLOBALS['dmType2Active'][$GLOBALS['lang']][1] . " <input tabindex=\"" . $tbi++ . "\" id=\"dmType1Active\" name=\"dmType1Active\" " . getData ("dmType1Active", "radio") . " type=\"radio\" value=\"On\">" . $GLOBALS['dmType1Active'][$GLOBALS['lang']][1] . "";
	}
	echo "</td>
		<td valign=\"top\"><input tabindex=\"" . $tbi++ .
		"\" id=\"" . $code . "MY\" name=\"" . $code . "Mm\" " . getData ($code . "Mm", "text") .
		" type=\"text\" class=\"small_cnt\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . $tbi++ . "\" id=\"" . $code . "YM\" name=\"" . $code . "Yy\" " .
	getData ($code . "Yy", "text") .
	" type=\"text\" class=\"small_cnt\" size=\"2\" maxlength=\"2\"></td>
	</tr>";
	}
	return ($tbi);
}

function pedConditionRows ($tbi = 0, $start = 1, $cnt = 0, $grp = 0) {
  $ind = 0;
  $bgColor = "#FFFFFF";
  $tbMarkup = "<br /><i>Si actif, complétez la section Tuberculose</i>";
  $tbArray = array("pulmTB", "mdrTB" , "extrapulmTB", "mtbPulm", "pulTB", "tbExtrapulm", "pedLymphTb","pedPulmTb","pedExtrapulmTbDissem");
  if(isset($GLOBALS['cond_list'][$grp])){
      $otherReason = array("pedOtherCondition");
	  foreach ($GLOBALS['cond_list'] as $x) {
		$ind++;
		$bgColor = ($bgColor == "#FFFFFF") ? "#D8D8D8" : "#FFFFFF";
		if (($ind < $start) || ($ind > ($start + $cnt - 1))) continue;
		$code = $x['code'];
                $newgrp = $x['group'];
                if ($grp != $newgrp) {
                  $grp = $newgrp;
                  echo "
                  <tr bgcolor=\"#FFFFFF\">
                   <td colspan=\"3\" valign=\"top\">&nbsp;</td>
                   <td colspan=\"2\" valign=\"top\"><b>" . $GLOBALS['pedCond'][$GLOBALS['lang']][$grp - 2] . "</b></td>
                  </tr>";
                }
		echo "
		  <tr bgcolor=\"$bgColor\">
		   <td align=\"center\" valign=\"top\"><table><tr><td id=\"" . $code . "ActiveTitle\" valign=\"top\"></td><td> <input class=\"conditions\" tabindex=\"" . $tbi++ . "\" id=\"" . $code . "Active1\" name=\"" . $code . "Active[]\" " . getData ($code . "Active", "checkbox", 1) . " type=\"checkbox\" value=\"1\"></td></tr></table></td>
		   <td align=\"center\" valign=\"top\"><input class=\"conditions\" tabindex=\"" . $tbi++ . "\" id=\"" . $code . "Active2\" name=\"" . $code . "Active[]\" " . getData ($code . "Active", "checkbox", 2) . " type=\"checkbox\" value=\"2\"></td>
		   <td align=\"center\" valign=\"top\"><input class=\"conditions\" tabindex=\"" . $tbi++ . "\" id=\"" . $code . "Active3\" name=\"" . $code . "Active[]\" " . getData ($code . "Active", "checkbox", 4) . " type=\"checkbox\" value=\"4\"></td>
		   <td class=\"small_cnt\" id=\"" . $code . "Title\">" . $x[$GLOBALS['lang']]  ;
		if (in_array ($code, $tbArray)) echo $tbMarkup; 
		if (in_array ($code, $otherReason))
		{
			echo "<br /><input class=\"conditions\" tabindex=\"" . $tbi++ . "\" name=\"" . $code . "Comment\" " . getData (  $code . "Comment", "text") . " type=\"text\" size=\"35\" maxlength=\"200\">";

		}
		echo "</td>
		   <td valign=\"top\"><input class=\"conditions\" tabindex=\"" . $tbi++ .
				"\" id=\"" . $code . "MY\" name=\"" . $code . "Mm\" " . getData ($code . "Mm", "text") .
				" type=\"text\"  size=\"2\" maxlength=\"2\">
				/<input class=\"conditions\" tabindex=\"" . $tbi++ . "\" id=\"" . $code . "YM\" name=\"" . $code . "Yy\" " .
				getData ($code . "Yy", "text") .
				" type=\"text\"  size=\"2\" maxlength=\"2\"></td>
		  </tr>";
	    $tbi +=6;
	  }
  }
  return ($tbi);
}

function rxRows ($cnt = 0, $version = 0) {
  $cols = array ("full" => "");
  $dosageCnt = 0;
  $rowClass = "reg";
  $sectionIndex=0;
  $rowIndex = 0;
  if ($version == 0 )
        $rx = $GLOBALS['rxs'];
  if ( $version == 1 )
        $rx = $GLOBALS['rxs_1'];

  foreach ( $rx as $a) {
    if (strpos ($a, "subhead") === false) {
      $rowClass = ($rowClass == "reg") ? "alt" : "reg";
      $label = (strpos ($a, "other") === 0) ? "<input tabindex=\"" . $cnt++ .
        "\" name=\"" . $a . "RxText\" " . getData ($a . "RxText", "text") .
        " type=\"text\" size=\"15\" maxlength=\"255\" class=\"small_cnt\">" :
          $GLOBALS[$a . "StartMm"][$GLOBALS['lang']][0];
      $cols["full"] .= "
      <tr  id=\"row" . $sectionIndex . $rowIndex . "\" class=\"" . $rowClass . "\" style=\"display:visible\">
       <td width=\"15%\" class=\"small_cnt\">" . $label . "</td>

	  <td width =\"5%\">";
	  if(getUiConfig(getSessionUser()) == "2" || getUiConfig(getSessionUser()) == "3" ){$cols["full"] .= "  <table><tr class = \"POC\"><td><input tabindex=\"".$cnt++."\" id=\"".$a."forPepPmtctRx\" name=\"".$a."forPepPmtct\" " . getData ($a."forPepPmtct", "radio", 2) . " type=\"radio\" value=\"2\">" .  $GLOBALS['forPepPmtct'][$GLOBALS['lang']][2] . "</td><td> <input tabindex=\"".$cnt++."\" id=\"".$a."forPepPmtctProphy\" name=\"".$a."forPepPmtct\" " . getData ($a."forPepPmtct", "radio", 1) . " type=\"radio\" value=\"1\">" .  $GLOBALS['forPepPmtct'][$GLOBALS['lang']][1]. "</i></td>
       </tr></table>";
	   }
	   $cols["full"] .= "
	   </td>

	  <td width=\"3%\" class=\"small_cnt\"><table><tr><td  id=\"" . $a . "StdDosageTitle\"></td><td>
         <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "StdDosage\" name=\"" . $a . "StdDosage\" " .
           getData ($a . "StdDosage", "checkbox") . " type=\"checkbox\" value=\"On\"></td></tr></table></td>
       <td width=\"11%\" class=\"small_cnt\" id=\"" . $a ."AltDosageSpecifyTitle\">";

        // This line will put another text box after 'Standard Dosage'
//      $cols["left"] .= (isset ($GLOBALS['rxStdDosage'][$GLOBALS['lang']][$dosageCnt])) ? $GLOBALS['rxStdDosage'][$GLOBALS['lang']][$dosageCnt] : "<input tabindex=\"" . $cnt++ . "\" name=\"" . $a . "StdDosageSpecify\" " . getData ($a . "StdDosageSpecify", "text") . " type=\"text\" size=\"15\" maxlength=\"255\"></td>";

      // This one doesn't put a text box after 'Standard Dosage'
      $cols["full"] .= (isset ($GLOBALS['rxStdDosage' . $version][$GLOBALS['lang']][$dosageCnt])) ? $GLOBALS['rxStdDosage' . $version][$GLOBALS['lang']][$dosageCnt] : "";
      $dosageCnt++;

      $cols["full"] .= "</td>

       <td class=\"sm_header_lt_pd\"  width=\"11%\">
           <input tabindex=\"" . $cnt++ . "\" id=\"" . $a ."AltDosageSpecify\"  name=\"" . $a .
           "AltDosageSpecify\" " . getData ($a . "AltDosageSpecify", "text") .
           " type=\"text\" size=\"15\" maxlength=\"255\" class=\"small_cnt\"></td>

       <td class=\"sm_header_lt_pd\" width=\"8%\">
         <table><tr><td id=\"" . $a . "NumDaysDescTitle\">&nbsp;</td><td><input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "NumDaysDesc\" name=\"" . $a . "NumDaysDesc\" " .
         getData ($a . "NumDaysDesc", "text") . " type=\"text\" size=\"5\"
         maxlength=\"255\" class=\"small_cnt\"></td></tr></table></td>

       <td width=\"5%\" class=\"small_cnt\">
         <table><tr><td id=\"" . $a . "DispensedTitle\">&nbsp;</td><td><input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "Dispensed\" name=\"" . $a . "Dispensed\" " .
           getData ($a . "Dispensed", "checkbox") . " type=\"checkbox\"
             value=\"On\">" .
             $GLOBALS['newprescription_subhead8'][$GLOBALS['lang']][1] .
       "</td></tr></table></td>

       <td class=\"sm_lt_pd\" width=\"16%\">
        <table><tr><td id=\"" . $a . "DispDateDtTitle\">&nbsp;</td><td><input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "DispDateDt\" name=\"" . $a . "DispDateDt\" value=\"" . getData ($a ."DispDateDd", "textarea") . "/". getData ($a ."DispDateMm", "textarea") ."/". getData ($a ."DispDateYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
	        <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "DispDateDd\"  name=\"" . $a . "DispDateDd\" " . getData ($a . "DispDateDd", "text") . " type=\"hidden\">
	        <input tabindex=\"" . $cnt++ . "\"  id=\"" . $a . "DispDateMm\"  name=\"" . $a . "DispDateMm\" " . getData ($a . "DispDateMm", "text") . " type=\"hidden\">
       		<input tabindex=\"" . $cnt++ . "\"  id=\"" . $a . "DispDateYy\"  name=\"" . $a . "DispDateYy\" " . getData ($a . "DispDateYy", "text") . " type=\"hidden\">
       	</td></tr></table></td>

       <td class=\"sm_header_lt_pd\" width=\"11%\">
        <table><tr><td id=\"" . $a . "DispAltDosageSpecifyTitle\">&nbsp;</td><td><input tabindex=\"" .
           $cnt++ . "\" id=\"" . $a . "DispAltDosageSpecify\" name=\"" . $a . "DispAltDosageSpecify\" " .
           getData ($a . "DispAltDosageSpecify", "text") . " type=\"text\"
           size=\"15\" maxlength=\"255\" class=\"small_cnt\">
        </td></tr></table></td>

       <td class=\"sm_header_lt_pd\">
         <table><tr><td width=\"9%\"  id=\"" . $a . "DispAltNumDaysSpecifyTitle\">&nbsp;</td><td><input tabindex=\"" .
           $cnt++ . "\" id=\"" . $a . "DispAltNumDaysSpecify\" name=\"" . $a . "DispAltNumDaysSpecify\" " .
           getData ($a . "DispAltNumDaysSpecify", "text") .
           " type=\"text\" size=\"5\" maxlength=\"255\" class=\"small_cnt\">
        </td></tr></table></td>

	   <td class=\"sm_header_lt_pd\">
         <table><tr class = \"POC\"><td width=\"9%\"  id=\"" . $a . "DispAltNumPillsTitle\">&nbsp;</td><td><input tabindex=\"" .
           $cnt++ . "\" id=\"" . $a . "DispAltNumPills\" name=\"" . $a . "DispAltNumPills\" " .
           getData ($a . "DispAltNumPills", "text") .
           " type=\"text\" size=\"5\" maxlength=\"255\" class=\"small_cnt\">
        </td></tr></table></td>
      </tr>";
      $rowIndex++;
    } else {
      $rowClass = "reg";
      $sectionIndex++;
      $rowIndex = 0;
      $cols["full"] .= "
       <tr>
         <td colspan=\"5\" width=\"52%\">
           <b><a class=\"toggle_display\" onclick=\"toggleDisplay(" .
             $sectionIndex . ", " . $GLOBALS['rxSubHeadElems'][$sectionIndex] .
             ");\" title=\"Toggle display\">
            <span id=\"section" . $sectionIndex . "Y\" style=\"display:none\">(+)</span>
            <span id=\"section" . $sectionIndex . "N\">(-)&nbsp;</span>" .
             $GLOBALS["newprescription_" . $a][$version][$GLOBALS['lang']][1] . "</a></b>
         </td>
         <td colspan=\"4\" width=\"45%\">&nbsp;</td>
        </tr>";
    }
  }

  return ($cols);
}

function rxOtherRows ($cnt = 0, $version = 0) {
  $rowClass = "reg";
  $cols = array ("full" => "");

  //$rx = getDrugOrder( $encounter_type, $formVersion );
  if (  $version == 0 )
    $rx = $GLOBALS['other_rxs'];
  else
    $rx = $GLOBALS['other_rxs_1'];

  foreach ($rx as $a) {
    if (strpos ($a, "subhead") === false) {
      $label = (strpos ($a, "other") === 0) ? "<table><tr><td id=\"" . $a . "RxTextTitle\">&nbsp;</td><td><input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "RxText\" name=\"" . $a . "RxText\" " . getData ($a . "RxText", "text") . " type=\"text\" size=\"24\" maxlength=\"255\"></td></tr></table>" : $GLOBALS[$a . "StartMm"][$GLOBALS['lang']][0]; // getDrugName( $a, $lang )

	if(in_array($a,$GLOBALS['prescriptionPOCadditions']) && getUiConfig(getSessionUser()) != "2" && getUiConfig(getSessionUser()) != "3"){
		continue;
	}
         $rowClass = ($rowClass == "reg") ? "alt" : "reg";
         $cols["full"] .= "<tr class=\"" . $rowClass;
	 if (in_array($a,$GLOBALS['prescriptionPOCadditions'])){
		$cols["full"] .= " POC>";
	  }
          $cols["full"] .= "\">
       <td width=\"13%\">" . $label . "</td>";

	   if(($a == 'isoniazid' || $a == 'cotrimoxazole') && (getUiConfig(getSessionUser()) == "2" || getUiConfig(getSessionUser()) == "3")){
	   	  $cols["full"] .= "<td width =\"10%\">
	   <table><tr class = \"POC\"><td><input tabindex=\"".$cnt++."\" id=\"".$a."forPepPmtctRx\" name=\"".$a."forPepPmtct\" " . getData ($a."forPepPmtct", "radio", 2) . " type=\"radio\" value=\"2\">" . $GLOBALS['forPepPmtct'][$GLOBALS['lang']][2] . "</td><td> <input tabindex=\"".$cnt++."\" id=\"".$a."forPepPmtctProphy\" name=\"".$a."forPepPmtct\" " . getData ($a."forPepPmtct", "radio", 1) . " type=\"radio\" value=\"1\">" . $GLOBALS['forPepPmtct'][$GLOBALS['lang']][1]  . "</i></td>
       </tr></table>
	   </td>";
	   }else{
		$cols["full"] .= "<td width =\"10%\">
	   </td>";
	   }

	   $cols["full"] .= "
	   <td colspan=\"3\" class=\"sm_header_lt_pd\" width=\"25%\">
        <table><tr><td id=\"" . $a . "AltDosageSpecifyTitle\">&nbsp;</td><td>
         <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "AltDosageSpecify\" name=\"" . $a . "AltDosageSpecify\" " . getData ($a . "AltDosageSpecify", "text") . " type=\"text\" size=\"35\" maxlength=\"255\">
        </td></tr></table></td>
       <td class=\"sm_header_lt_pd\" width=\"8%\">
        <table><tr><td id=\"" . $a . "NumDaysDescTitle\">&nbsp;</td><td>
         <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "NumDaysDesc\" name=\"" . $a . "NumDaysDesc\" " . getData ($a . "NumDaysDesc", "text") . " type=\"text\" size=\"5\" maxlength=\"255\">
        </td></tr></table></td>
       <td width=\"5%\">
        <table><tr><td id=\"" . $a . "DispensedTitle\">&nbsp;</td><td>
         <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "Dispensed\" name=\"" . $a . "Dispensed\" " . getData ($a . "Dispensed", "checkbox") . " type=\"checkbox\" value=\"On\">
        </td></tr></table></td>
       <td class=\"sm_lt_pd\" width=\"16%\">
        <table><tr><td id=\"" . $a . "DispDateDtTitle\">&nbsp;</td><td>
         <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "DispDateDt\" name=\"" . $a . "DispDateDt\" value=\"" . getData ($a ."DispDateDd", "textarea") . "/". getData ($a ."DispDateMm", "textarea") ."/". getData ($a ."DispDateYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
       		<input tabindex=\"" . $cnt++ . "\"  id=\"" . $a . "DispDateDd\"  name=\"" . $a . "DispDateDd\" " . getData ($a . "DispDateDd", "text") . " type=\"hidden\"/>
       		<input tabindex=\"" . $cnt++ . "\"  id=\"" . $a . "DispDateMm\"  name=\"" . $a . "DispDateMm\" " . getData ($a . "DispDateMm", "text") . " type=\"hidden\"/>
       		<input tabindex=\"" . $cnt++ . "\"  id=\"" . $a . "DispDateYy\"  name=\"" . $a . "DispDateYy\" " . getData ($a . "DispDateYy", "text") . " type=\"hidden\"/>
         </td></tr></table></td>
       <td class=\"sm_header_lt_pd\" width=\"11%\">
        <table><tr><td id=\"" . $a . "DispAltDosageSpecifyTitle\">&nbsp;</td><td>
         <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "DispAltDosageSpecify\" name=\"" . $a . "DispAltDosageSpecify\" " . getData ($a . "DispAltDosageSpecify", "text") . " type=\"text\" size=\"15\" maxlength=\"255\">
        </td></tr></table></td>
       <td class=\"sm_header_lt_pd\" width=\"9%\">
        <table><tr><td id=\"" . $a . "DispAltNumDaysSpecifyTitle\">&nbsp;</td><td>
         <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "DispAltNumDaysSpecify\" name=\"" . $a . "DispAltNumDaysSpecify\" " . getData ($a . "DispAltNumDaysSpecify", "text") . " type=\"text\" size=\"5\" maxlength=\"255\">
        </td></tr></table></td>
		
	    <td class=\"sm_header_lt_pd\">
         <table><tr class = \"POC\"><td width=\"9%\"  id=\"" . $a . "DispAltNumPillsTitle\">&nbsp;</td><td><input tabindex=\"" .
           $cnt++ . "\" id=\"" . $a . "DispAltNumPills\" name=\"" . $a . "DispAltNumPills\" " .
           getData ($a . "DispAltNumPills", "text") .
           " type=\"text\" size=\"5\" maxlength=\"255\" class=\"small_cnt\">
        </td></tr></table></td>
      </tr>";
    } else {
      $cols["full"] .= "
      <tr>
       <td colspan=\"5\" width=\"52%\"><b>" . $GLOBALS["newprescription_" . $a][$GLOBALS['lang']][1] . "</b></td>
       <td colspan=\"4\" width=\"45%\">&nbsp;</td>
      </tr>";
    }
  }

  return ($cols);
}

function pedRxRows ($cnt = 0, $version = 0) {
  $cols = array ("full" => "");
  $dosageCnt = 0;
  $rowClass = "reg";
  $sectionIndex=0;
  $rowIndex = 0;

  $rx = $GLOBALS['pedRxs'];

  // Get labels from drugLookup table
  $query = "SELECT * FROM drugLookup";
  $result = dbQuery ($query);
  $labels = array ();
  while ($row = psRowFetch ($result)) {
    $labels[$row['drugName']] = $row;
  }

  foreach ( $rx as $a) {
    if (strpos ($a, "subhead") === false) {
      $rowClass = ($rowClass == "reg") ? "alt" : "reg";
      $label = (strpos ($a, "other") === 0) ? "<table><tr><td id=\"" . $a . "RxTextTitle\">&nbsp;</td><td> <input tabindex=\"" . $cnt++ .
        "\" id=\"" . $a . "RxText\" name=\"" . $a . "RxText\" " . getData ($a . "RxText", "text") .
        " type=\"text\" size=\"15\" maxlength=\"255\" class=\"small_cnt\"></td></tr></table>" .
        "" :
          $GLOBALS[$a . "StartMm"][$GLOBALS['lang']][0];
      if (strpos ($a, "ritonavir2") === 0) $a = "ritonavir";
      $cols["full"] .= "
      <tr  id=\"row" . $sectionIndex . $rowIndex . "\" class=\"" . $rowClass . "\" >
       <td width=\"15%\" class=\"small_cnt\">" . $label . "</td>";

	    if(getUiConfig(getSessionUser()) == "2" || getUiConfig(getSessionUser()) == "3"){
		    $cols["full"] .= " <td width =\"10%\">
		      <table>
		       <tr class = \"POC\"><td><input tabindex=\"".$cnt++."\" id=\"".$a."forPepPmtctRx\" name=\"".$a."forPepPmtct\" " . getData ($a."forPepPmtct", "radio", 2) . " type=\"radio\" value=\"2\">" .  $GLOBALS['forPepPmtct'][$GLOBALS['lang']][2] . "</td><td> <input tabindex=\"".$cnt++."\" id=\"".$a."forPepPmtctProphy\" name=\"".$a."forPepPmtct\" " . getData ($a."forPepPmtct", "radio", 1) . " type=\"radio\" value=\"1\">" .  $GLOBALS['forPepPmtct'][$GLOBALS['lang']][1]. "</i></td>
	         </tr>
	        </table>
		     </td>";
			}else{
				$cols["full"] .= "<td>&nbsp;</td>";
			}
      $cols["full"] .= " <td  width=\"3%\" class=\"small_cnt\">

         <input tabindex=\"" . $cnt++ . "\" name=\"" . $a . "StdDosage[]\" " .
           getData ($a . "StdDosage", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td  width=\"12%\" class=\"small_cnt\" id=\"" . $a . "AltDosageSpecifyTitle\">";

      $cols["full"] .= (!empty ($labels[$a]['pedStdDosage' . init_upper ($GLOBALS['lang']) . '1'])) ? $labels[$a]['pedStdDosage' . init_upper ($GLOBALS['lang']) . '1'] : "";

      if (!empty ($labels[$a]['pedStdDosage' . init_upper ($GLOBALS['lang']) . '2'])) $new_tbi = $cnt++;

      $cols["full"] .= "</td>
       <td class=\"sm_lt_pd\"
         width=\"20%\"><table><tr><td id=\"" . $a . "PedDosageSpecifyTitle\">&nbsp;</td><td>
           <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "PedDosageSpecify\" name=\"" . $a .
           "PedDosageSpecify\" " . getData ($a . "PedDosageSpecify", "text") .
           " type=\"text\" size=\"25\" maxlength=\"255\" class=\"small_cnt\"></td><td>" . ((!empty ($labels[$a]['pedDosageLabel'])) ? " " . $labels[$a]['pedDosageLabel'] : "") . "</td></tr></table></td>
       <td class=\"sm_lt_pd\" width=\"12%\">
        <table><tr><td id=\"" . $a . "NumDaysDescTitle\">&nbsp;</td><td>
         <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "NumDaysDesc\" name=\"" . $a . "NumDaysDesc\" " .
         getData ($a . "NumDaysDesc", "text") . " type=\"text\" size=\"5\"
         maxlength=\"255\" class=\"small_cnt\">
        </td></tr></table></td>
       <td width=\"5%\" class=\"sm_cnt\">
        <table><tr><td id=\"" . $a . "DispensedTitle\">&nbsp;</td><td>
         <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "Dispensed\" name=\"" . $a . "Dispensed\" " .
           getData ($a . "Dispensed", "checkbox") . " type=\"checkbox\"
             value=\"On\">" .
             $GLOBALS['newprescription_subhead8'][$GLOBALS['lang']][1] .
       "</td></tr></table></td>
       <td  class=\"sm_lt_pd\" width=\"15%\">
        <table><tr><td id=\"" . $a . "DispDateDtTitle\">&nbsp;</td><td>
       	    <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "DispDateDt\" name=\"" . $a . "DispDateDt\" value=\"" . getData ($a ."DispDateDd", "textarea") . "/". getData ($a ."DispDateMm", "textarea") ."/". getData ($a ."DispDateYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\" class=\"small_cnt\">
           <input tabindex=\"" . $cnt++ . "\" id=\"" . $a .
           	 "DispDateDd\" name=\"" . $a . "DispDateDd\" " .
             getData ($a . "DispDateDd", "text") . " type=\"hidden\">
           <input tabindex=\"" . $cnt++ . "\" id=\"" . $a .
             "DispDateMm\"  name=\"" . $a .
             "DispDateMm\" " . getData ($a . "DispDateMm", "text") .
             " type=\"hidden\">
           <input tabindex=\"" . $cnt++ . "\" id=\"" . $a .
             "DispDateYy\" name=\"" . $a .
             "DispDateYy\" " . getData ($a . "DispDateYy", "text") .
             " type=\"hidden\">
       </td></tr></table></td>
       <td class=\"sm_header_lt_pd\" width=\"15%\">
        <table><tr><td id=\"" . $a . "DispAltNumDaysSpecifyTitle\">&nbsp;</td><td>
        <input tabindex=\"" .
           $cnt++ . "\" id=\"" . $a . "DispAltNumDaysSpecify\" name=\"" . $a . "DispAltNumDaysSpecify\" " .
           getData ($a . "DispAltNumDaysSpecify", "text") .
           " type=\"text\" size=\"5\" maxlength=\"255\" class=\"small_cnt\">
        </td></tr></table></td>
        <td class=\"sm_header_lt_pd\">
         <table><tr class = \"POC\"><td width=\"3%\"  id=\"" . $a . "DispAltNumPillsTitle\">&nbsp;</td><td><input tabindex=\"" .
           $cnt++ . "\" id=\"" . $a . "DispAltNumPills\" name=\"" . $a . "DispAltNumPills\" " .
           getData ($a . "DispAltNumPills", "text") .
           " type=\"text\" size=\"5\" maxlength=\"255\" class=\"small_cnt\">
        </td></tr></table></td>
      </tr>";
      $rowIndex++;
      if (!empty ($labels[$a]['pedStdDosage' . init_upper ($GLOBALS['lang']) . '2'])) {
        $cols["full"] .= "
      <tr  id=\"row" . $sectionIndex . $rowIndex . "\" class=\"" . $rowClass . "\" style=\"display:visible\">
       <td width=\"15%\" id=\"" . $a . "StdDosageTitle\">&nbsp;</td>
       <td width=\"10%\"></td>
       <td width=\"3%\" class=\"small_cnt\">
         <input tabindex=\"" . $new_tbi . "\" id=\"" . $a . "StdDosage\" name=\"" . $a . "StdDosage[]\" " .
           getData ($a . "StdDosage", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td  width=\"12%\" class=\"small_cnt\">" . $labels[$a]['pedStdDosage' . init_upper ($GLOBALS['lang']) . '2'] . "</td>
       <td>&nbsp;</td>
	   <td>&nbsp;</td>
       <td colspan=\"5\" width=\"35%\">&nbsp;</td>
	   
	   
      </tr>";
        $rowIndex++;
      }
    } else {
      $rowClass = "reg";
      $sectionIndex++;
      $rowIndex = 0;
      $cols["full"] .= "
       <tr>
         <td colspan=\"5\" width=\"62%\">
           <b><a class=\"toggle_display\" onclick=\"toggleDisplay(" .
             $sectionIndex . ", " . $GLOBALS['pedRxSubHeadElems'][$sectionIndex] .
             ");\" title=\"Toggle display\">
            <span id=\"section" . $sectionIndex . "Y\" style=\"display:none\">(+)</span>
            <span id=\"section" . $sectionIndex . "N\">(-)&nbsp;</span>" .
             $GLOBALS["newprescription_" . $a][$version][$GLOBALS['lang']][1] . "</a></b>
         </td>
         <td colspan=\"3\" width=\"35%\">&nbsp;</td>
        </tr>";
    }
  }

  return ($cols);
}

function pedRxOtherRows ($cnt = 0, $version = 0) {
  $rowClass = "reg";

  $cols = array ("full" => "");

  $rx = $GLOBALS['pedOther_rxs'];

  foreach ($rx as $a) {
    if (strpos ($a, "subhead") === false) {
      $rowClass = ($rowClass == "reg") ? "alt" : "reg";
	if(in_array($a,$GLOBALS['prescriptionPOCadditions']) && getUiConfig(getSessionUser()) != "2" && getUiConfig(getSessionUser()) != "3"){
		continue;
	}
      $label = (strpos ($a, "other") === 0) ? "<table><tr><td id=\"" . $a . "RxTextTitle\">&nbsp;</td><td> <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "RxText\" name=\"" . $a . "RxText\" " . getData ($a . "RxText", "text") . " type=\"text\" size=\"20\" maxlength=\"255\"></td></tr></table>"  : $GLOBALS[$a . "StartMm"][$GLOBALS['lang']][0]; // getDrugName( $a, $lang )

	 /**if (in_array($a,$GLOBALS['prescriptionPOCadditions'])){
		$cols["full"] .= "<tr class=\"POC\">";
	  }else{
		 $cols["full"] .= "<tr class=\"" . $rowClass . "\">";
	  }**/
	   $cols["full"] .= "<tr class=\"" . $rowClass . "\">";
	  $cols["full"] .= "
       <td width=\"15%\">" . $label . "</td>";

	   if(($a == 'isoniazid' || $a == 'cotrimoxazole') && (getUiConfig(getSessionUser()) == "2" || getUiConfig(getSessionUser()) == "3")){
	   	  $cols["full"] .= "<td width =\"10%\">
	   <table><tr class = \"POC\"><td><input tabindex=\"".$cnt++."\" id=\"".$a."forPepPmtctRx\" name=\"".$a."forPepPmtct\" " . getData ($a."forPepPmtct", "radio", 2) . " type=\"radio\" value=\"2\">" . $GLOBALS['forPepPmtct'][$GLOBALS['lang']][2] . "</td><td> <input tabindex=\"".$cnt++."\" id=\"".$a."forPepPmtctProphy\" name=\"".$a."forPepPmtct\" " . getData ($a."forPepPmtct", "radio", 1) . " type=\"radio\" value=\"1\">" . $GLOBALS['forPepPmtct'][$GLOBALS['lang']][1]  . "</i></td>
       </tr></table>
	   </td>";
	   }else{
		$cols["full"] .= "<td width =\"10%\">
	   </td>";
	   }

	    $cols["full"] .= "
       <td colspan=\"2\" class=\"sm_lt_pd\" width=\"15%\">
        <table><tr><td id=\"" . $a . "PedPresSpecifyTitle\">&nbsp;</td><td>
         <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "PedPresSpecify\" name=\"" . $a . "PedPresSpecify\" " . getData ($a . "PedPresSpecify", "text") . " type=\"text\" size=\"15\" maxlength=\"255\">
        </td></tr></table></td>
       <td class=\"sm_lt_pd\" width=\"20%\">
        <table><tr><td id=\"" . $a . "PedDosageSpecifyTitle\">&nbsp;</td><td>
         <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "PedDosageSpecify\" name=\"" . $a . "PedDosageSpecify\" " . getData ($a . "PedDosageSpecify", "text") . " type=\"text\" size=\"25\" maxlength=\"255\">
        </td></tr></table></td>
       <td class=\"sm_lt_pd\" width=\"12%\">
        <table><tr><td id=\"" . $a . "NumDaysDescTitle\">&nbsp;</td><td>
         <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "NumDaysDesc\" name=\"" . $a . "NumDaysDesc\" " . getData ($a . "NumDaysDesc", "text") . " type=\"text\" size=\"5\" maxlength=\"255\">
        </td></tr></table></td>
       <td class=\"sm_cnt\" width=\"5%\">
         <table><tr><td id=\"" . $a . "DispensedTitle\">&nbsp;</td><td>
          <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "Dispensed\" name=\"" . $a . "Dispensed\" " . getData ($a . "Dispensed", "checkbox") . " type=\"checkbox\" value=\"On\"></td><td>" . $GLOBALS['newprescription_subhead8'][$GLOBALS['lang']][1] . "
         </td></tr></table></td>
       <td class=\"sm_lt_pd\" width=\"18%\">
         <table><tr><td id=\"" . $a . "DispDateDtTitle\">&nbsp;</td><td>
          <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "DispDateDt\" name=\"" . $a . "DispDateDt\" value=\"" . getData ($a ."DispDateDd", "textarea") . "/". getData ($a ."DispDateMm", "textarea") ."/". getData ($a ."DispDateYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
       		<input id=\"" . $a . "DispDateDd\"  name=\"" . $a . "DispDateDd\" " . getData ($a . "DispDateDd", "text") . " type=\"hidden\">
       		<input tabindex=\"" . $cnt++ . "\"  id=\"" . $a . "DispDateMm\"  name=\"" . $a . "DispDateMm\" " . getData ($a . "DispDateMm", "text") . " type=\"hidden\">
       		<input tabindex=\"" . $cnt++ . "\"  id=\"" . $a . "DispDateYy\"  name=\"" . $a . "DispDateYy\" " . getData ($a . "DispDateYy", "text") . " type=\"hidden\">
         </td></tr></table></td>
        <td class=\"sm_lt_pd\" width=\"15%\">
         <table><tr><td id=\"" . $a . "DispAltNumDaysSpecifyTitle\">&nbsp;</td><td>
          <input tabindex=\"" . $cnt++ . "\" id=\"" . $a . "DispAltNumDaysSpecify\" name=\"" . $a . "DispAltNumDaysSpecify\" " . getData ($a . "DispAltNumDaysSpecify", "text") . " type=\"text\" size=\"5\" maxlength=\"255\">
        </td></tr></table></td>
		 <td class=\"sm_header_lt_pd\">
         <table><tr class = \"POC\"><td width=\"3%\"  id=\"" . $a . "DispAltNumPillsTitle\">&nbsp;</td><td><input tabindex=\"" .
           $cnt++ . "\" id=\"" . $a . "DispAltNumPills\" name=\"" . $a . "DispAltNumPills\" " .
           getData ($a . "DispAltNumPills", "text") .
           " type=\"text\" size=\"5\" maxlength=\"255\" class=\"small_cnt\">
        </td></tr></table></td>
      </tr>";
    } else {
      $cols["full"] .= "
      <tr>
       <td colspan=\"5\" width=\"62%\"><b>" . $GLOBALS["pedRx_" . $a][$GLOBALS['lang']][0] . "</b></td>
       <td colspan=\"3\" width=\"35%\">&nbsp;</td>
      </tr>";
    }
  }

  return ($cols);
}

function arvRows ($cnt, $followup = 0) {
 // if ($followup) $str = "<tr>";
  $str = "";
  $sectionIndex=0;
  $rowIndex = 0;
  $rowClass = "reg";
  foreach ($GLOBALS['arvs'] as $a) {
    if (strpos ($a, "other") === 0) {
      $otherText = "";
      $startMo = "MM";
      $startYr = "YY";
      $stopMo = "SpMM";
      $stopYr = "SpYY";
    } else {
      $otherText = "";
      $startMo = "StartMm";
      $startYr = "StartYy";
      $stopMo = "StopMm";
      $stopYr = "StopYy";
    }
    $startMoId = "StartMm";
	$startYrId = "StartYy";
	$stopMoId = "StopMm";
    $stopYrId = "StopYy";
    if (strpos ($a, "subhead") === 0) {
      $sectionIndex++;
      $rowIndex = 0;
      $rowClass = "reg";

      $str .= "\n<tr>";
      $str .= ($followup) ?
	    "\n<td colspan=\"9\">
             <b><a class=\"toggle_display\" onclick=\"toggleDisplay(" .
               $sectionIndex . ", " . $GLOBALS['arvSubHeadElems'][$sectionIndex] .
               ");\" title=\"Toggle display\">
               <span id=\"section" . $sectionIndex . "Y\" style=\"display:none\">(+)</span>
               <span id=\"section" . $sectionIndex . "N\">(-)&nbsp;</span>" .
               $GLOBALS['arv_' . $a][$GLOBALS['version']][$GLOBALS['lang']][1] . "</a></b>
            </td>
            <td>&nbsp;</td>
            <td colspan=\"7\">&nbsp;</td>"
       :
        "<td colspan=\"9\">
           <b><a class=\"toggle_display\" onclick=\"toggleDisplay(" .
             $sectionIndex . ", " . $GLOBALS['arvSubHeadElems'][$sectionIndex] .
             ");\" title=\"Toggle display\">
            <span id=\"section" . $sectionIndex . "Y\" style=\"display:none\">(+)</span>
            <span id=\"section" . $sectionIndex . "N\">(-)&nbsp;</span>" .
             $GLOBALS['arv_' . $a][$GLOBALS['version']][$GLOBALS['lang']][1] . "</a></b>
         </td>
         </tr>";
    } else {
      $rowClass = ($rowClass == "reg") ? "alt" : "reg";
      $str .= ($followup) ? "
      <tr id=\"row" . $sectionIndex . $rowIndex . "\" class=\"" . $rowClass . "\" style=\"display:visible\">
       <td class=\"small_cnt\" id=\"arv_" . $a . "ContinuedTitle\">" . $GLOBALS[$a . "StartMm"][$GLOBALS['lang']][0] . $otherText . "</td>
       <td class=\"sm_header_cnt_np\" >
         <input class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "Continued\" name=\"" . $a . "Continued\" " . getData ($a .
           "Continued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td width=\"3%\" id=\"arv_". substr(($a . $stopMoId ), 0,-2) . "Title\">&nbsp;</td>"
      : "
      </tr>
      <tr id=\"row" . $sectionIndex . $rowIndex . "\" class=\"" . $rowClass . "\" style=\"display:visible\">
       <td id=\"arv_". substr(($a . $startMoId ), 0,-2) . "Title\" class=\"small_cnt\">" . $GLOBALS[$a . "StartMm"][$GLOBALS['lang']][0] . $otherText . "</td>
       <td>
         <input class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a .
           $startMoId . "\" name=\"" . $a .
           $startMo . "\" " . getData ($a . $startMo, "text") .
          " type=\"text\" size=\"2\" maxlength=\"2\">/<input  class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" .
            $a . $startYrId . "\" name=\"" .
            $a . $startYr . "\" " . getData ($a . $startYr, "text") .
            " type=\"text\" size=\"2\" maxlength=\"2\"></td>";

      //mm/yy field
      $str .= ($followup) ? "
       <td><table><tr><td></td><td><input class=\"arvPrevious\" tabindex=\"" .
         $cnt++ . "\" id=\"arv_" . $a . $stopMoId . "\" name=\"" . $a . $stopMo . "\" " . getData ($a . $stopMo, "text") .
         " type=\"text\" size=\"2\" maxlength=\"2\">/<input class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . $stopYrId . "\" name=\"" . $a . $stopYr . "\" " .
         getData ($a . $stopYr, "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></td></tr></table></td>"
      : "
       <td ><table><tr><td  id=\"arv_". substr(($a . $stopMoId ), 0,-2) . "Title\">&nbsp;</td><td>
         <input class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . $stopMoId . "\" name=\"" . $a .
           $stopMo . "\" " . getData ($a . $stopMo, "text") . " type=\"text\"
           size=\"2\" maxlength=\"2\">/<input  class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" .
           $a . $stopYrId . "\" name=\"" .
           $a . $stopYr . "\" " . getData ($a . $stopYr, "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td></tr></table></td>";

      $str .= ($followup) ? "
       <td class=\"sm_header_cnt_np\"><table><tr><td id=\"arv_" . $a . "DiscTitle\"></td><td><input class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "DiscTox\" name=\"" . $a . "DiscTox\" " . getData ($a . "DiscTox", "checkbox") . " type=\"checkbox\" value=\"On\"></td></tr></table></td>
       <td class=\"sm_header_cnt_np\"><input class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "DiscIntol\" name=\"" . $a . "DiscIntol\" " . getData ($a . "DiscIntol", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\"><input class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "DiscFailVir\" name=\"" . $a . "DiscFailVir\" " . getData ($a . "DiscFailVir", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\"><input class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "DiscFailImm\" name=\"" . $a . "DiscFailImm\" " . getData ($a . "DiscFailImm", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\"><input class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "DiscFailClin\" name=\"" . $a . "DiscFailClin\" " . getData ($a . "DiscFailClin", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td width=\"3%\" id=\"arv_" . $a . "InterTitle\">&nbsp;</td>
       <td class=\"sm_header_cnt_np\"><input class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "InterStock\" name=\"" . $a . "InterStock\" " . getData ($a . "InterStock", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\"><input class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "InterPreg\" name=\"" . $a . "InterPreg\" " . getData ($a . "InterPreg", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\"><input class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "InterHop\" name=\"" . $a . "InterHop\" " . getData ($a . "InterHop", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\"><input class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "InterMoney\" name=\"" . $a . "InterMoney\" " . getData ($a . "InterMoney", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\"><input class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "InterAlt\" name=\"" . $a . "InterAlt\" " . getData ($a . "InterAlt", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\"><input class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "InterLost\" name=\"" . $a . "InterLost\" " . getData ($a . "InterLost", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\"><input class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "InterPref\" name=\"" . $a . "InterPref\" " . getData ($a . "InterPref", "checkbox") . " type=\"checkbox\" value=\"On\"></td>"
       : "

       <td class=\"sm_header_cnt_np\"><table><tr><td id=\"arv_" . $a . "ContinuedTitle\"></td><td><input tabindex=\"" . $cnt++ . "\" class=\"arvPrevious\" id=\"arv_" . $a . "Continued\"  name=\"" . $a . "Continued\" " . getData ($a . "Continued", "checkbox") . " type=\"checkbox\" value=\"On\"></td></tr></table></td>
	   <td class=\"sm_header_cnt_np\" id=\"arv_" . $a . "DiscTitle\">&nbsp;</td>
       <td class=\"sm_header_cnt_np\"><span><input class=\"arvPrevious\"  tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "DiscTox\" name=\"" . $a . "DiscTox\" " . getData ($a . "DiscTox", "checkbox") . " type=\"checkbox\" value=\"On\"></span></td>
       <td class=\"sm_header_cnt_np\"><span><input class=\"arvPrevious\"  tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "DiscIntol\" name=\"" . $a . "DiscIntol\" " . getData ($a . "DiscIntol", "checkbox") . " type=\"checkbox\" value=\"On\"></span></td>
       <td class=\"sm_header_cnt_np\"><span><input class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "DiscFail\" name=\"" . $a . "DiscFail\" " . getData ($a . "DiscFail", "checkbox") . " type=\"checkbox\" value=\"On\"></span></td>
       <td class=\"sm_header_cnt_np\"><span><input class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "DiscUnknown\" name=\"" . $a . "DiscUnknown\" " . getData ($a . "DiscUnknown", "checkbox") . " type=\"checkbox\" value=\"On\"></span></td>
       <td class=\"sm_header_cnt_np\"><span><input class=\"arvPrevious\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "finPTME\" name=\"" . $a . "finPTME\" " . getData ($a . "finPTME", "checkbox") . " type=\"checkbox\" value=\"On\"></span></td>";

      $str .="
      </tr>";
      $rowIndex++;
    }
  }
  return ($str);
}

function pedArvRows ($cnt, $followup = 0) {
  $str = "";
  $sectionIndex=0;
  $rowIndex = 0;
  $rowClass = "reg";

  foreach ($GLOBALS['pedArvList'] as $a) {
    if (strpos ($a, "other") === 0) {
//      $otherText = " <input tabindex=\"" . $cnt++ . "\" name=\"" . $a . "Text\" " . getData ($a . "Text", "text") . " type=\"text\" size=\"20\" maxlength=\"255\">";
//      $otherText = " <input tabindex=\"0\" name=\"" . $a . "Text\" value=\"" . $a . "ArvName\" type=\"hidden\">";
      $otherText = "";
      $startMo = "MM";
      $startYr = "YY";
      $stopMo = "SpMM";
      $stopYr = "SpYY";;
    } else {
      $otherText = "";
      $startMo = "StartMm";
      $startYr = "StartYy";
      $stopMo = "StopMm";
      $stopYr = "StopYy";
    }
    $startMoId = "StartMm";
	$startYrId = "StartYy";
	$stopMoId = "StopMm";
    $stopYrId = "StopYy";
    if (strpos ($a, "subhead") === 0) {
      $sectionIndex++;
      $rowIndex = 0;
      $rowClass = "reg";

      $str .= "\n<tr>";
      $str .= ($followup) ?
	    "\n<td colspan=\"19\" width=\"100%\">
             <b><a class=\"toggle_display\" onclick=\"toggleDisplay(" .
               $sectionIndex . ", " . $GLOBALS['pedArvSubHeadElems'][$sectionIndex] .
               ");\" title=\"Toggle display\">
               <span id=\"section" . $sectionIndex . "Y\" style=\"display:none\">(+)</span>
               <span id=\"section" . $sectionIndex . "N\">(-)&nbsp;</span>" .
               $GLOBALS['arv_' . $a][$GLOBALS['version']][$GLOBALS['lang']][1] . "</a></b>
            </td>
"
       :
        "<td colspan=\"11\" width=\"100%\">
           <b><a class=\"toggle_display\" onclick=\"toggleDisplay(" .
             $sectionIndex . ", " . $GLOBALS['pedArvSubHeadElems'][$sectionIndex] .
             ");\" title=\"Toggle display\">
            <span id=\"section" . $sectionIndex . "Y\" style=\"display:none\">(+)</span>
            <span id=\"section" . $sectionIndex . "N\">(-)&nbsp;</span>" .
             $GLOBALS['arv_' . $a][$GLOBALS['version']][$GLOBALS['lang']][1] . "</a></b>
         </td>
";
    } else {
      $rowClass = ($rowClass == "reg") ? "alt" : "reg";
      $str .= ($followup) ? "
      <tr id=\"row" . $sectionIndex . $rowIndex . "\" class=\"" . $rowClass . "\" style=\"display:visible\">
       <td class=\"small_cnt\" width=\"15%\" id=\"arv_" . $a . "ContinuedTitle\">" . ((strpos ($a, "other") === 0) ? $GLOBALS["pedFollowup"][$GLOBALS['lang']][39] . " <i>" . $GLOBALS["pedFollowup"][$GLOBALS['lang']][40] . "</i>" : $GLOBALS[$a . "StartMm"][$GLOBALS['lang']][0]) . $otherText . "</td>
       <td class=\"sm_header_cnt_np\" width=\"5%\">
         <input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "Continued\" name=\"" . $a . "Continued\" " . getData ($a .
           "Continued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td width=\"5%\" id=\"arv_". substr(($a . $stopMoId ), 0,-2) . "Title\">&nbsp;</td>"
      : "
      <tr id=\"row" . $sectionIndex . $rowIndex . "\" class=\"" . $rowClass . "\" style=\"display:visible\">
       <td class=\"small_cnt\" width=\"15%\"  id=\"arv_". substr(($a . $startMoId ), 0,-2) . "Title\">" . $GLOBALS[$a . "StartMm"][$GLOBALS['lang']][0] . $otherText . "</td>
       <td width=\"15%\">
         <input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a .
           $startMoId . "\" name=\"" . $a .
           $startMo . "\" " . getData ($a . $startMo, "text") .
          " type=\"text\" size=\"2\" maxlength=\"2\">/<input  class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" .
            $a . $startYrId . "\" name=\"" .
            $a . $startYr . "\" " . getData ($a . $startYr, "text") .
            " type=\"text\" size=\"2\" maxlength=\"2\"></td>";

      // vert line between date fields, intake only
      $str .= ($followup) ? ""
      : "
       <td width=\"5%\">&nbsp;</td>
";

      // stop mm/yy field
      $str .= ($followup) ? "
       <td  width=\"15%\"><input class=\"pedARVever\" tabindex=\"" .
         $cnt++ . "\" id=\"arv_" . $a . $stopMoId . "\" name=\"" . $a . $stopMo . "\" " . getData ($a . $stopMo, "text") .
         " type=\"text\" size=\"2\" maxlength=\"2\">/<input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . $stopYrId . "\" name=\"" . $a . $stopYr . "\" " .
         getData ($a . $stopYr, "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></td>"
      : "
       <td  width=\"15%\">
         <table><tr><td  id=\"arv_". substr(($a . $stopMoId ), 0,-2) . "Title\"></td><td><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a .
           $stopMoId . "\" name=\"" . $a .
           $stopMo . "\" " . getData ($a . $stopMo, "text") . " type=\"text\"
           size=\"2\" maxlength=\"2\">/<input  class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" .
           $a . $stopYrId . "\" name=\"" .
           $a . $stopYr . "\" " . getData ($a . $stopYr, "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td></tr></table></td>";

      $str .= ($followup) ? "
       <td class=\"sm_header_cnt_np\" width=\"4%\"><table><tr><td id=\"arv_" . $a . "DiscTitle\" ></td><td><input tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "DiscTox\" name=\"" . $a . "DiscTox\" " . getData ($a . "DiscTox", "checkbox") . " type=\"checkbox\" class=\"pedARVever\" value=\"On\"></td></tr></table></td>
       <td class=\"sm_header_cnt_np\" width=\"4%\"><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "DiscIntol\" name=\"" . $a . "DiscIntol\" " . getData ($a . "DiscIntol", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\" width=\"4%\"><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "DiscFailVir\" name=\"" . $a . "DiscFailVir\" " . getData ($a . "DiscFailVir", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\" width=\"4%\"><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "DiscFailImm\" name=\"" . $a . "DiscFailImm\" " . getData ($a . "DiscFailImm", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\" width=\"4%\"><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "DiscFailClin\" name=\"" . $a . "DiscFailClin\" " . getData ($a . "DiscFailClin", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\" width=\"4%\"><table><tr><td id=\"arv_" . $a . "InterTitle\" ></td><td><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "InterStock\" name=\"" . $a . "InterStock\" " . getData ($a . "InterStock", "checkbox") . " type=\"checkbox\" value=\"On\"></td></tr></table></td>
       <td class=\"sm_header_cnt_np\" width=\"4%\"><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "InterPreg\" name=\"" . $a . "InterPreg\" " . getData ($a . "InterPreg", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\" width=\"4%\"><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "InterHop\" name=\"" . $a . "InterHop\" " . getData ($a . "InterHop", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\" width=\"4%\"><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "InterMoney\"name=\"" . $a . "InterMoney\" " . getData ($a . "InterMoney", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\" width=\"4%\"><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "InterAlt\" name=\"" . $a . "InterAlt\" " . getData ($a . "InterAlt", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\" width=\"4%\"><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "InterLost\" name=\"" . $a . "InterLost\" " . getData ($a . "InterLost", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\" width=\"4%\"><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "InterPref\" name=\"" . $a . "InterPref\" " . getData ($a . "InterPref", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\" width=\"9%\"><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "InterUnk\" name=\"" . $a . "InterUnk\" " . getData ($a . "InterUnk", "checkbox") . " type=\"checkbox\" value=\"On\"></td>"
       : "
       <td class=\"sm_header_cnt_np\" width=\"15%\"><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "ProphDose\" name=\"" . $a . "ProphDose\" " . getData ($a . "ProphDose", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\" width=\"15%\"><table><tr><td id=\"arv_" . $a . "ContinuedTitle\"></td><td><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "Continued\" name=\"" . $a . "Continued\" " . getData ($a . "Continued", "checkbox") . " type=\"checkbox\" value=\"On\"></td></tr></table></td>
       <td class=\"sm_header_cnt_np\" width=\"4%\"><table><tr><td id=\"arv_" . $a . "DiscTitle\"></td><td><span><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "DiscTox\" name=\"" . $a . "DiscTox\" " . getData ($a . "DiscTox", "checkbox") . " type=\"checkbox\" value=\"On\"></span></td></tr></table></td>
       <td class=\"sm_header_cnt_np\" width=\"4%\"><span><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "DiscIntol\" name=\"" . $a . "DiscIntol\" " . getData ($a . "DiscIntol", "checkbox") . " type=\"checkbox\" value=\"On\"></span></td>
       <td class=\"sm_header_cnt_np\" width=\"4%\"><span><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "DiscFail\" name=\"" . $a . "DiscFail\" " . getData ($a . "DiscFail", "checkbox") . " type=\"checkbox\" value=\"On\"></span></td>
       <td class=\"sm_header_cnt_np\" width=\"4%\"><span><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "DiscProph\" name=\"" . $a . "DiscProph\" " . getData ($a . "DiscProph", "checkbox") . " type=\"checkbox\" value=\"On\"></span></td>
       <td class=\"sm_header_cnt_np\" width=\"4%\"><input class=\"pedARVever\" tabindex=\"" . $cnt++ . "\" id=\"arv_" . $a . "DiscUnknown\" name=\"" . $a . "DiscUnknown\" " . getData ($a . "DiscUnknown", "checkbox") . " type=\"checkbox\" value=\"On\"></td>";

      $rowIndex++;
    }
    $str .= "
      </tr>
";
  }
  return ($str);
}

function arvColumns ($followup = 0) {
  $cols = array ("left" => "", "center" => "", "right" => "");
  $cnt = 5001;
  if ($followup)
	$globVar = "arvsf";
  else
	$globVar = "arvs";

  foreach ($GLOBALS[$globVar] as $a) {
    if (strpos ($a, "subhead") === false) {
      if ($followup) {
	  if (strpos ($a, "other") === 0) {
              $label = ($a == "other1") ? "" : $GLOBALS['otherTreat'][$GLOBALS['lang']][1];
	      $otherText = $label . " <input tabindex=\"" . $cnt++ . "\" name=\"" . $a . "Text\" " . getData ($a . "Text", "text") . " type=\"text\" size=\"20\" maxlength=\"255\">";
          }
          $foll =  "<td align=\"center\" height=\"25\"><input tabindex=\"" . $cnt++ . "\" name=\"" . $a . "Continued\" " . getData ($a . "Continued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>";
      }
      else {
          $foll = "<td align=\"center\" height=\"25\"><input tabindex=\"" . $cnt++ . "\" name=\"" . $a . "StartMm\" " . getData ($a . "StartMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . $cnt++ . "\" name=\"" . $a . "StartYy\" " . getData ($a . "StartYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></td>";
          $otherText = "";
      }

//      $followup_arvs = array ("cotrimoxazole", "fluconazole", "isoniazid", "ethambutol", "ketaconazole", "pyrazinamide", "rifampicine", "streptomycine", "other1", "other2", "other3");
//      $stopMo = ($followup && in_array ($a, $followup_arvs)) ? "SpMM" : "StopMm";
//      $stopYr = ($followup && in_array ($a, $followup_arvs)) ? "SpYY" : "StopYy";
      $stopMo = ($followup && strpos ($a, "other") === 0) ? "SpMM" : "StopMm";
      $stopYr = ($followup && strpos ($a, "other") === 0) ? "SpYY" : "StopYy";

      $cols['left'] .= "
      <tr>
       <td>" . $GLOBALS[$a . "StartMm"][$GLOBALS['lang']][0] . $otherText . "</td>" . $foll .
       "<td align=\"center\" height=\"25\"><input tabindex=\"" . $cnt++ . "\" name=\"" . $a . $stopMo . "\" " . getData ($a . $stopMo, "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . $cnt++ . "\" name=\"" . $a . $stopYr . "\" " . getData ($a . $stopYr, "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></td>
      </tr>\n";

      $cols['center'] .= "
      <tr>
       <td align=\"center\" height=\"25\"><input tabindex=\"" . $cnt++ . "\" name=\"" . $a . "DiscTox\" " . getData ($a . "DiscTox", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\" height=\"25\"><input tabindex=\"" . $cnt++ . "\" name=\"" . $a . "DiscIntol\" " . getData ($a . "DiscIntol", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\" height=\"25\"><input tabindex=\"" . $cnt++ . "\" name=\"" . $a . "DiscFail\" " . getData ($a . "DiscFail", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
      </tr>\n";

      $cols['right'] .= "
      <tr>
       <td align=\"center\" height=\"25\"><input tabindex=\"" . $cnt++ . "\" name=\"" . $a . "InterStock\" " . getData ($a . "InterStock", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\" height=\"25\"><input tabindex=\"" . $cnt++ . "\" name=\"" . $a . "InterPreg\" " . getData ($a . "InterPreg", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\" height=\"25\"><input tabindex=\"" . $cnt++ . "\" name=\"" . $a . "InterHop\" " . getData ($a . "InterHop", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\" height=\"25\"><input tabindex=\"" . $cnt++ . "\" name=\"" . $a . "InterMoney\" " . getData ($a . "InterMoney", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\" height=\"25\"><input tabindex=\"" . $cnt++ . "\" name=\"" . $a . "InterAlt\" " . getData ($a . "InterAlt", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\" height=\"25\"><input tabindex=\"" . $cnt++ . "\" name=\"" . $a . "InterLost\" " . getData ($a . "InterLost", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\" height=\"25\"><input tabindex=\"" . $cnt++ . "\" name=\"" . $a . "InterPref\" " . getData ($a . "InterPref", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\" height=\"25\"><input tabindex=\"" . $cnt++ . "\" name=\"" . $a . "Comments\" " . getData ($a . "Comments", "text") . " type=\"text\" size=\"20\" maxlength=\"255\"></td>
      </tr>\n";
    } else {
      $cols['left'] .= "
      <tr>
       <td colspan=\"3\" height=\"25\"><b>" . $GLOBALS["arv_" . $a][$GLOBALS['lang']][1] . "</b></td>
      </tr>\n";

      $cols['center'] .= "
      <tr>
       <td colspan=\"3\" height=\"25\">&nbsp;</td>
      </tr>\n";

      $cols['right'] .= "
      <tr>
       <td colspan=\"3\" height=\"25\">&nbsp;</td>
      </tr>\n";
    }
  }

  return ($cols);
}

function getData ($name, $type, $bin = 0) {
  if (isset ($GLOBALS['existingData'][$name]) && (!empty ($GLOBALS['existingData'][$name]) || trim ($GLOBALS['existingData'][$name]) == "0")) {

    switch ($type) {
      case "text":
        return ("value=\"" . htmlspecialchars ($GLOBALS['existingData'][$name], ENT_QUOTES) . "\"");
        break;
      case "checkbox":
        if ($bin > 0) {
          $binstring = strrev (decbin ($GLOBALS['existingData'][$name]));
          return (!empty ($binstring{log ($bin, 2)}) &&
                  $binstring{log ($bin, 2)} == 1) ? "checked" : "";
        } else {
		  /** load the name of the checkbox if it is == 1, since we may need to POST it when user unchecks it
			* this array will be imploded to the hidden field 'checkedBoxes' at the bottom of the form in the saveButtons.php file
		  if ($GLOBALS['existingData'][$name] == 1) $GLOBALS['checkedBoxes'][] = $name;
		    */
          return ($GLOBALS['existingData'][$name] == 1) ? "checked" : "";
        }
        break;
      case "radio":
        if ($bin > 0) {
          $binstring = strrev (decbin ($GLOBALS['existingData'][$name]));
		  if (!empty ($binstring{log ($bin, 2)}) && $binstring{log ($bin, 2)} == 1) 
		  {
			//$GLOBALS['checkedRadios'][] = $name;
			return  " title=\"true\" checked";
		  }
          return "";
        } else {
		  if($GLOBALS['existingData'][$name] == 1)
		  {
			//$GLOBALS['checkedRadios'][] = $name;
			return  " title=\"true\" checked";
		  }
          return "";
        }
        break;
      case "textarea":
        return (htmlspecialchars ($GLOBALS['existingData'][$name], ENT_QUOTES));
        break;
		
		case "select":
        return "<option value=\"".(htmlspecialchars ($GLOBALS['existingData'][$name], ENT_QUOTES))."\" selected >".(htmlspecialchars ($GLOBALS['existingData'][$name], ENT_QUOTES))."</option>";
        break;
    }
  }
}

function showValidationIcon ($type, $field) {
  //$str = "";
  //if (!empty ($type) && !empty ($field) && verifyValidationEditor (getSessionUser ()))
  //  $str .= "<a href=\"javascript:void(0)\" onClick=\"openValidationWindow ('" . $GLOBALS['lang'] . "', '$type', '$field')\">+</a>";
  //return ($str);
  return '';
}

function getErrors (&$arr, $type = 0, $check = 0) {
  $errors = array ();

  if (!verifyEncType ($type)) {
    if (!empty ($_GET['lang'])) $lang = $_GET['lang'];
    if (empty ($lang) && !empty ($_POST['lang'])) $lang = $_POST['lang'];
    if (empty ($lang)) $lang = $GLOBALS['def_lang'];
    $loc = "Location: ";
    if (strpos ($_SERVER['REQUEST_URI'], "include/") !== false) $loc .= "../";
    header ($loc . "error.php?type=encType&lang=$lang");
    exit;
  }

  // Hit database to get list of fields that need to be validated
  // If form is other than version 0, restrict list by formVersion column
  if ($type != 13 && isset ($arr['formVersion']) && $arr['formVersion'] > 0)
    $valData = getValidations ($type, "formVersion = " . $arr['formVersion']);
  else
    $valData = getValidations ($type, "(formVersion = 0 OR formVersion IS NULL)");

  // Populate error message list if any errors found
  $mand_missing = 0;
  foreach ($valData as $row) {
    $err_list = array ();

    // Trim the data field, if empty several validation checks can be skipped
    $t = (isset ($arr[$row['fieldName']]) && strlen ($arr[$row['fieldName']]) > 0) ? trim ($arr[$row['fieldName']]) : "";

    // Check if field is mandatory
    if ($row['fieldMandatory']) {
      if (strlen ($t) < 1) {
        if (!in_array ('nonBlank', $err_list)) array_push ($err_list, 'nonBlank');
        $mand_missing = 1;
        if ($check) return ($mand_missing) ? 2 : 1;
      }
    }

    // Check if non-mandatory field must be non-blank
    if ($row['fieldMandatory'] != 1 && $row['fieldNonBlank']) {
      if (strlen ($t) < 1) {
        if (!in_array ('nonBlank', $err_list)) array_push ($err_list, 'nonBlank');
        if ($check) return ($mand_missing) ? 2 : 1;
      }
    }

    // Check value against field's regex, if exists
    if (!empty ($row['fieldRegEx']) && strlen ($t) > 0) {
      if (!preg_match ($row['fieldRegEx'], $t)) {
        if (!in_array ('badValue', $err_list)) array_push ($err_list, 'badValue');
        if ($check) return ($mand_missing) ? 2 : 1;
      }
    }

    // Check value against upper and lower bounds, if they exist
    if (!empty ($row['fieldLowerBound']) && strlen ($t) > 0) {
      // This check only makes sense for numeric data
      if (is_numeric (str_replace (',', '.', $t)) && $t < $row['fieldLowerBound']) {
        if (!in_array ('badValue', $err_list)) array_push ($err_list, 'badValue');
        if ($check) return ($mand_missing) ? 2 : 1;
      }
    }

    if (!empty ($row['fieldUpperBound']) && strlen ($t) > 0) {
      // This check only makes sense for numeric data
      if (is_numeric (str_replace (',', '.', $t)) && $t > $row['fieldUpperBound']) {
        if (!in_array ('badValue', $err_list)) array_push ($err_list, 'badValue');
        if ($check) return ($mand_missing) ? 2 : 1;
      }
    }

    // Check linked fields or arbitrary SQL query, if exists
    $bracket = '';
    if (!empty ($row['fieldLinkage']) &&
        ($row['checkLinkageIfBlank'] == 1 || strlen ($t) > 0)) {
      $res = doValidationQuery ($arr['eid'], $row['fieldLinkage']);
      if (strpos($row['fieldLinkage'], 'Checkbox')) {
        $bracket = '[]';
      }
      foreach ($res as $r) {
        if (!in_array ($r, $err_list)) array_push ($err_list, $r);
        if ($check) return ($mand_missing) ? 2 : 1;
      }
    }

    if (!empty ($err_list)) {
      $errors[$row['fieldName'] . $bracket] = $err_list;
    }
  }

  //return ($check) ? 0 : $errors;
  return 0;
}

// SQL functions below

function doValidationQuery ($eid, $qry) {
  $results = array ();
  if (!empty ($eid) && !empty ($qry)) {
    $qry = str_replace ('@eid', $eid, $qry);
    $content = dbQuery ($qry);
    //or die ("FATAL ERROR: Couldn't do validation query: $qry.");
    if ($content !== TRUE) {
      while ($row = psRowFetch ($content)) {
        foreach ($row as $k => $v)
          if (preg_match ('/^[A-Za-z]+$/', $k) && $v === 1) array_push ($results, $k);
      }
    }
  }
  return ($results);
}

function verifyUserAuth($username) {
  $content = database()->query('SELECT username FROM userPrivilege WHERE username = ?',
			       array($username));
  if ($content->fetch()) {
    $content->closeCursor();
    return 1;
  } else {
    return 0;
  }
}

function getValidations ($type, $where = "") {
  $results = array ();
  $queryStmt = "SELECT * FROM validations WHERE encounterType = '$type'";
  if (!empty ($where))
    $queryStmt .= " AND $where";
  $content = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search validations table.");
  while ($row = psRowFetch ($content))
    array_push ($results, $row);
  return ($results);
}

function setValidations ($values, $whereClause = "") {
  if (!empty ($values['fieldName']) && !empty ($values['encounterType'])) {
    $queryStmt = "SELECT * FROM validations WHERE fieldName = '" . $values['fieldName'] . "' AND encounterType = '" . $values['encounterType'] . "'";
    $results = dbQuery ($queryStmt) or die ("FATAL ERROR: Unable to search validations table.");

    if (psRowFetch($results)) {
      $queryStmt = "UPDATE validations SET ";
      $cnt = 0;
      foreach ($values as $k => $v) {
        $cnt++;
        if ($k == 'fieldName' || $k == 'encounterType' || $k == 'validations_id') continue;
        if ($v === NULL || is_null ($v)) $queryStmt .= "$k = NULL"; else $queryStmt .= "$k = '$v'";
        if (count ($values) > $cnt) $queryStmt .= ", ";
      }
      $queryStmt .= " WHERE fieldName = '" . $values['fieldName'] . "' AND encounterType = '" . $values['encounterType'] . "'";
      if (!empty ($whereClause)) $queryStmt .= " AND $whereClause";
    } else {
      $queryStmt = "INSERT validations ";
      $cnt = 0;
      $cols = "(";
      $vals = "(";
      foreach ($values as $k => $v) {
        $cols .= $k;
        if ($v === NULL || is_null ($v)) $vals .= "NULL"; else $vals .= "'$v'";
        $cnt++;
        if (count ($values) > $cnt) {
          $cols .= ", ";
          $vals .= ", ";
        }
      }
      $queryStmt .= $cols. ") VALUES " . $vals . ")";
    }
  } else {
    return FALSE;
  }
  $id = dbQuery ($queryStmt . "; SELECT SCOPE_IDENTITY() AS id") or die ("FATAL ERROR: Couldn't add to validations table using $queryStmt.");
  $rows = psRowFetch ($id);

  return $rows['id'];
}

function getEncTypes ($where = "") {
  $results = array ();
  $queryStmt = "SELECT * FROM encTypeLookup";
  if (!empty ($where))
    $queryStmt .= " WHERE $where";
  $content = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search encTypeLookup table.");
  while ($row = psRowFetch ($content))
    array_push ($results, $row);
  return ($results);
}

function verifyEncType ($type) {
  $queryStmt = "SELECT TOP 1 encounterType FROM encTypeLookup WHERE encounterType = '$type'";
  $content = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search encTypeLookup table.");
  $row = psRowFetchAssoc ($content);
  return (isset ($row['encounterType']) && $row['encounterType'] == $type) ? 1 : 0;
}

function getAnnouncements ($since = "", $ver = "", $inc_hidden = 0, $where = "") {
  $results = array ();
  $queryStmt = "SELECT * FROM announcements WHERE hidden = 0 OR hidden = NULL";
  if ($inc_hidden) $queryStmt .= " OR hidden = 1";
  if (!empty ($since) && dateToMySQL ($since) !== 0)
    $queryStmt .= " AND dateStamp >= '" . dateToMySQL ($since) . "'";
  if (!empty ($ver))
    $queryStmt .= " AND version >= '$ver'";
  if (!empty ($where))
    $queryStmt .= " AND $where";
  $queryStmt .= " ORDER BY dateStamp DESC";
  $content = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search announcements table.");
  while ($row = psRowFetch ($content))
    array_push ($results, $row);
  return ($results);
}

function setAnnouncements ($vals, $where = "") {
  if (!empty ($vals)) {
    $queryStmt = "UPDATE announcements SET ";
    $cnt = 0;
    foreach ($vals as $k => $v) {
      if (strpos ($v, "'") !== false) $v = str_replace ("'", "''", $v);
      if ($v === NULL || is_null ($v)) $queryStmt .= "$k = NULL"; else $queryStmt .= "$k = '$v'";
      $cnt++;
      if (count ($vals) > $cnt) $queryStmt .= ", ";
    }
    if (!empty ($where)) $queryStmt .= " WHERE $where";
    $content = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search announcements table.");
  }
}

function verifyTranslator ($id) {
  $queryStmt = "SELECT TOP 1 username FROM userPrivilege WHERE username = '$id' AND allowTrans = 1";
  $content = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search userPrivilege table.");
  $row = psRowFetchAssoc ($content);
  return ($row['username'] == $id) ? 1 : 0;
}

function verifyValidationEditor ($id) {
  $queryStmt = "SELECT TOP 1 username FROM userPrivilege WHERE username = '$id' AND allowValidate = 1";
  $content = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search userPrivilege table.");
  $row = psRowFetchAssoc ($content);
  return ($row['username'] == $id) ? 1 : 0;
}

// Only allow one registration form and intake form per patient. This
// function returns TRUE if the patient already has the form type given.
function verifyExistingForm ($id, $type) {
  $queryStmt = "SELECT count(encounter_id) AS cnt FROM encounter WHERE patientID = '$id' AND encounterType = $type AND encStatus < 255";
  $content = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search encounter table.");
  $row = psRowFetchAssoc ($content);
  return ($row['cnt'] > 0) ? 1 : 0;
}  

function findByName ($nm = "",$site, $lang, $pg = "", $ifOnlyOne = true ) {
	// Do query
	$cnt = $pg * PATIENTS_PER_PAGE;
	if (!empty ($nm)) {
		// Limit number of rows returned based on page
		//print "Pages: " . $pg . " Limit # (cnt): " . $cnt;
		$results = array ();
		if(preg_match('/\d+$/',$nm)){
			 // Compute last page, don't let user go beyond last page
			$nm = preg_replace('/[A-Za-z^-]/', '',$nm);
			$nm = trim($nm);
			$queryStmt = "
				select count(distinct patientID) AS total 
				FROM patient 
				where patStatus = 0 and location_id = ".$site. " and (replace(clinicPatientID,'-','') like '%".$nm."%' )";
		    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search patient table." . $queryStmt);
		    $row = psRowFetch ($result);
		    $GLOBALS['existingData']['lastPage'] = ceil ($row['total'] / PATIENTS_PER_PAGE);
		    if ($GLOBALS['existingData']['lastPage'] < $pg) $pg = $GLOBALS['existingData']['lastPage'];
			$qry = "
				SELECT distinct top $cnt ltrim(rtrim(lname)) as lname, ltrim(rtrim(fname)) as fname, dobMm, dobDd, dobYy, 
				nationalID, patientID, location_id as siteCode, clinicPatientID, fnameMother, sex
				FROM patient
				WHERE patStatus = 0 and location_id = ".$site." and (replace(clinicPatientID,'-','') like '%".$nm."%' )
				ORDER BY clinicPatientID, lname, fname";
		} else {
			$numwords = str_word_count($nm,0);
			$nm = trim($nm);
			if (strpos($nm," ") !== false){
				$split = -1;
				for($i = 0; $i < $numwords - 1; $i++ ){
					$split = strpos($nm,' ',$split + 1);
					$first = substr($nm,0,$split);
					$last = substr($nm,$split);
					$first = trim($first);
					$last = trim($last);
					$addConditions .= "OR (lname LIKE '%".trim($first)."%' AND fname LIKE '%".trim($last)."%') OR (fname LIKE '%".trim($first)."%' AND lname LIKE '%".trim($last)."%')  ";
					$first = str_replace(" ","-",$first);
					$last = str_replace(" ","-",$last);
					$addConditions .= "OR (lname LIKE '%".trim($first)."%' AND fname LIKE '%".trim($last)."%') OR (fname LIKE '%".trim($first)."%' AND lname LIKE '%".trim($last)."%')  ";
				}
				if ($numwords == 2) $addConditions .= "OR lname LIKE '%".str_replace(" ","-",$nm)."%' OR fname LIKE '%".str_replace(" ","-",$nm)."%'  ";
				$qry = "SELECT distinct top $cnt ltrim(rtrim(lname)) as lname, ltrim(rtrim(fname)) as fname, dobMm, dobDd, dobYy, nationalID, patientID, location_id as siteCode, clinicPatientID, fnameMother , sex
					FROM patient
					WHERE patStatus = 0 and location_id = " . $site . " and ( lname like '%".$nm."%' OR nationalID like '%".$nm."%' OR fname like '%".$nm."%' ".$addConditions.")
					ORDER BY lname, fname, clinicPatientID";
				$queryStmt = "SELECT count(distinct patientID) AS total FROM patient where patStatus = 0 and location_id = ".$site." and (lname like '%".$nm."%' OR nationalID like '%".$nm."%' OR fname like '%".$nm."%' ".$addConditions.")";
			    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search patient table." . $queryStmt);
			    $row = psRowFetch ($result);
			    $GLOBALS['existingData']['lastPage'] = ceil ($row['total'] / PATIENTS_PER_PAGE);
			    if ($GLOBALS['existingData']['lastPage'] < $pg) $pg = $GLOBALS['existingData']['lastPage'];
			} else {
				$queryStmt = "SELECT count(distinct patientID) AS total FROM patient where patStatus = 0 and location_id = ".$site." and ( lname like '%".$nm."%' OR fname like '%".$nm."%' OR  nationalID like '%".$nm."%')";
			    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search patient table." . $queryStmt);
			    $row = psRowFetch ($result);
			    $GLOBALS['existingData']['lastPage'] = ceil ($row['total'] / PATIENTS_PER_PAGE);
			    if ($GLOBALS['existingData']['lastPage'] < $pg) $pg = $GLOBALS['existingData']['lastPage'];
				$qry = "SELECT distinct top $cnt ltrim(rtrim(lname)) as lname, ltrim(rtrim(fname)) as fname, dobMm, dobDd, dobYy, nationalID, patientID, location_id as siteCode, clinicPatientID, fnameMother, sex
					FROM patient
					WHERE patStatus = 0 and location_id = ".$site." and ( lname like '%".$nm."%' OR fname like '%".$nm."%' OR  nationalID like '%".$nm."%')
					ORDER BY lname,fname, clinicPatientID";
			}
		}
		if (DEBUG_FLAG) echo $qry . "<br />";
		$result = dbQuery ($qry);
		if (!$result)
			die("FATAL ERROR: Could not search patient table." . $qry);
		else {
			$cnt = 0;
			while ($row = psRowFetch($result)) {
				$cnt++;
				if ($pg > 0 && ($cnt < (($pg - 1) * PATIENTS_PER_PAGE + 1) || $cnt > ($pg * PATIENTS_PER_PAGE))) continue;
				array_push($results, $row);
			}
			if(count($results) == 1 && $ifOnlyOne && $pg == 1) {
				echo "
					<script type=\"text/javascript\">
					<!--
					  var xloc = 'patienttabs.php?pid=' + " . $results[0]['patientID'] . " + '&lang=" . $lang . "&site=" . $site . "';
					 //alert (xloc);
					  window.location.href = xloc;
					//-->
					</script>";
			}
		}
	}
	return ($results);
}

function lookupSite ($site = "") {
  if (!empty ($site)) {
    $queryStmt = "SELECT RTRIM(siteCode) AS siteCode FROM clinicLookup WHERE LOWER(siteCode) = LOWER('$site')";
    $content = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search clinicLookup table.");
    $row = psRowFetchAssoc ($content);
    return ($row['siteCode']);
  }
}

function lookupSiteName ($site = "") {
  if (!empty ($site)) {
    $queryStmt = "SELECT LTRIM(RTRIM(clinic)) AS siteName FROM clinicLookup WHERE LOWER(siteCode) = LOWER('$site')";
    $content = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search clinicLookup table.");
    $row = psRowFetchAssoc ($content);
    return ($row['siteName']);
  }
}

function setByEncounterID ($id, $where, $table, $values, $whereClause = "") {
	// If table is 'encounter' just use id
	if ($table == "encounter") $where = " WHERE encounter_id = $id";
	// If table is 'patient' just use the left-hand part of $where
	if ($table == "patient")  $where = substr ($where, 0, stripos($where,"and",0));
	// otherwise, use the passed in $where (this saves 18 fetches from the encounter table)
	if (!empty ($whereClause)) $where .= " AND $whereClause";
	$res = dbQuery ("SELECT * FROM " . $table . " " . $where) or die ("FATAL ERROR: Unable to search $table with SELECT * FROM $table $where.");
	if (psRowFetch($res)) {
		// rows found, need to update
		$queryStmt = "UPDATE $table SET ";
		$cnt = 0;
		foreach ($values as $k => $v) {
			if ($v === NULL) $queryStmt .= "$k = ''";
			else if ($v == "getDate()") $queryStmt .= "$k = $v";
			//else if (is_numeric($v)) $queryStmt .= "$k = $v";
			else $queryStmt .= "$k = '$v'";
			$cnt++;
			if (count ($values) > $cnt) $queryStmt .= ", ";
		}
		$queryStmt .= $where;
	} else {
		// this is a new record, build an insert (patient, encounter, and obs table records are not inserted here)
		$values['patientID'] = $GLOBALS['existingData']['patientID'];
		$values['dbSite'] = DB_SITE;
		$values['siteCode'] = $GLOBALS['existingData']['siteCode'];
		$values['visitDateDd'] = $GLOBALS['existingData']['visitDateDd'];
		$values['visitDateMm'] = $GLOBALS['existingData']['visitDateMm'];
		$values['visitDateYy'] = $GLOBALS['existingData']['visitDateYy'];
		$values['seqNum'] = $GLOBALS['existingData']['seqNum'];
		if (empty ($values['visitDateYy']) || empty ($values['visitDateMm']) || empty ($values['visitDateDd']) || strtotime($values['visitDateYy'] . "-" . $values['visitDateMm'] . "-" . $values['visitDateDd']) === false) {        
			header ("Location: error.php?type=badDate&lang=$lang");
        		exit;
    		}
		$queryStmt = "INSERT $table ";
		$cnt = 0;
		$cols = "(";
		$vals = "(";
		foreach ($values as $k => $v) {
			$cols .= $k;
			if ($v === NULL) $vals .= "NULL";
			else $vals .= "'$v'";
			$cnt++;
			if (count ($values) > $cnt) {
				$cols .= ", ";
				$vals .= ", ";
			}
		}
		$queryStmt .= $cols. ") VALUES " . $vals . ")";
	}

	$id = dbQuery ($queryStmt . "; SELECT SCOPE_IDENTITY() AS id") or die ("FATAL ERROR: Couldn't add to $table using $queryStmt.");
	$rows = psRowFetch ($id);
	return $rows['id'];
}

function delPatient ($pid) {
	if (!empty ($pid)) {
		$queryStmt = "SELECT encounter_id FROM encounter WHERE patientID = '$pid'";
		$content = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search encounter table.");
		while ($row = psRowFetch ($content)) {
			setStatusByEncounterID ($row['encounter_id'], 255, "", TRUE);
		}
		setStatusByPatientID ($pid, 255);
		return TRUE;
	} else {
		return FALSE; 
	} 
}

function addPatient ($site = "", $values) {
	// amend values array with appropriate values
	$values['location_id'] = $site;
	if (isset($values['clinicPatientID'])) $values['stid'] = preg_replace('/[^0-9]/', '', $values['clinicPatientID']);
	$queryStmt = "INSERT patient ";
	$cnt = 0;
	$cols = "(";
	$vals = "(";
	foreach ($values as $k => $v) {
		$cols .= $k;
		if ($v === NULL || is_null ($v))
			$vals .= "NULL";
		else
			$vals .= "'$v'";
		$cnt++;
		if (count ($values) > $cnt) {
			$cols .= ", ";
			$vals .= ", ";
		}
	}
	$queryStmt .= $cols. ") VALUES " . $vals . ")";
	dbBeginTransaction();
	$result = dbQuery ($queryStmt) or die ("FATAL ERROR: Unable to add to patient table: $queryStmt.");

	$queryStmt = "SELECT SCOPE_IDENTITY() AS id";
	$result = dbQuery ($queryStmt) or die ("FATAL ERROR: Can't fetch identity value.");
	$row = psRowFetch ($result);
	/* in MySql person_id will be incremented separately for each location_id (site)
	 * in most cases there will be only one site per database, so this shouldn't be confusing or a problem
	 */
	$personID = $row['id'];
	$pid = $site . $personID;
	/* Generate and store a GUID for the patient - for use with OpenELIS.
	 * Yes, calling Java like this is a bit kludgey, but PHP doesn't have a good way to generate UUIDs at the present time. 
	 * Plus, we have a similar mechanism for calling the reports via 'jrReport.php', so there is some precedent - JS 6/26/09 
	 */
	$uuid = "";
	$uuid = exec ("java -cp " . substr ($_SERVER["SCRIPT_FILENAME"], 0, strrpos ($_SERVER["SCRIPT_FILENAME"], DIRECTORY_SEPARATOR)) . DIRECTORY_SEPARATOR . "support uuidGen");
	if (!empty ($uuid) && preg_match ('/^[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{12}$/i', $uuid)) {
		// doing update because MySql trigger for auto-increment is buggy
		$qry = "update patient set patientid = '" . $pid . "', masterPid = '" . $pid . "', patGuid = '" . $uuid . "' where location_id = " . $site . " and person_id = " . $personID;
		$result2 = dbQuery ($qry); 
	}
	if (!empty($result2)) {
		dbCommit();
		return $pid;
	} else {
		dbRollback();
		return "";
	}
}

function addEncounter ($patientid = "", $day = "", $mo = "", $yr = "", $site = "", $date = "", $encountertype = "", $comments = "", $formAuthor = "", $formAuthor2 = "", $labOrDrugForm = "",  $nxtVisitDd = "", $nxtVisitMm = "", $nxtVisitYy = "", $formVersion = "", $creator = "", $createDate = "") {

    if (empty ($yr) || empty ($mo) || empty ($day) || strtotime($yr . "-" . $mo . "-" .  $day) === false) {
	  	header ("Location: error.php?type=badDate&lang=$lang");
	  	exit;
    }
	$seq = 0;
    $queryStmt = "SELECT * FROM encounter WHERE patientID = '$patientid' AND visitDateDd = '$day' AND visitDateMm = '$mo' AND visitDateYy = '$yr' AND siteCode = '$site' ORDER BY seqNum DESC";
	$content = dbQuery ($queryStmt) or die ("FATAL ERROR: Unable to search encounter table.");
    if ($rows = psRowFetch ($content)) {
		$seq = $rows['seqNum'] + 1;
	}   
	$queryStmt = "INSERT encounter (dbSite, patientID, visitDateDd, visitDateMm, visitDateYy, siteCode, lastModified, encounterType, seqNum, encComments, formAuthor, formAuthor2, labOrDrugForm, nxtVisitDd, nxtVisitMm, nxtVisitYy, formVersion, creator, createDate, lastModifier, visitDate) VALUES (" . DB_SITE . ", '$patientid', '$day', '$mo', '$yr', '$site', '$date', '$encountertype', '$seq', '$comments', '$formAuthor', '$formAuthor2', '$labOrDrugForm', '$nxtVisitDd', '$nxtVisitMm', '$nxtVisitYy', '$formVersion', '$creator', '$createDate', '$creator', dbo.ymdToDate('$yr','$mo','$day'))";
	$result = dbQuery ($queryStmt) or die ("FATAL ERROR: Unable to add to encounter table.");
	$queryStmt = "SELECT SCOPE_IDENTITY() AS id";
	$result = dbQuery ($queryStmt) or die ("FATAL ERROR: Unable to fetch encounter id.");
	$row = psRowFetch ($result);
	return $row['id'];
} 

function updEncounterKeys ($id, $table, $day, $mo, $yr, $seq, $where) {
	if ($table == "encounter")
		$updStmt = "UPDATE $table SET visitDateDd = '" . $day . "', visitDateMm = '" . $mo . "', visitDateYy = '" . $yr . "', visitDate = dbo.ymdToDate('" . $yr . "','" . $mo . "','" . $day . "'), seqNum = '" . $seq . "' " . $where;
	else
		$updStmt = "UPDATE $table SET visitDateDd = '" . $day . "', visitDateMm = '" . $mo . "', visitDateYy = '" . $yr . "', seqNum = '" . $seq . "' " . $where;
	$content = dbQuery ($updStmt) or die ("FATAL ERROR: Unable to update records in $table.");
}

function getStatusByEncounterID ($id, $whereClause = "") {
        $queryStmt = "SELECT encStatus FROM encounter WHERE encounter_id = '" . $id . "' and sitecode = '" . $_GET['site'] . "'";
        $queryStmt .= (empty ($whereClause)) ? "" : " AND $whereClause";
	$content = dbQuery ($queryStmt) or die ("FATAL ERROR: Unable to search encounter table.");
        $keys = psRowFetch ($content);
        return ($keys['encStatus']);
}

function getStatusByPatientID ($id, $whereClause = "") {
        $queryStmt = "SELECT patStatus FROM patient WHERE patientID = '" . $id . "'";
        $queryStmt .= (empty ($whereClause)) ? "" : " AND $whereClause";
	$content = dbQuery ($queryStmt) or die ("FATAL ERROR: Unable to search patient table.");
        $keys = psRowFetch ($content);
        return ($keys['patStatus']);
}

/** sets encounter status
 ** parameters:
 **    id - encounterID
 **    stat - status value (255 or greater means deleted)
 **    whereClause - extra optional where clause
 **    deleteFlag - if true, encounter should get it's lastModified date set to the current date (added 08/18/2010)
 **/ 
function setStatusByEncounterID ($id, $stat = 0, $whereClause = "", $deleteFlag = FALSE) {
	$queryStmt = "UPDATE encounter SET encStatus = $stat ";
	$queryStmt .= ($deleteFlag) ? ", lastModified = getDate() " : ""; 
	$queryStmt .= " WHERE encounter_id = " . $id;
	$queryStmt .= (empty ($whereClause)) ? "" : " AND $whereClause";
	$content = dbQuery ($queryStmt) or die ("FATAL ERROR: Unable to set status in encounter table. $queryStmt");
}

function setStatusByPatientID ($id, $stat = 0, $whereClause = "") {
        $queryStmt = "UPDATE patient SET patStatus = '$stat' WHERE patientID = '" . $id . "'";
        $queryStmt .= (empty ($whereClause)) ? "" : " AND $whereClause";
	$content = dbQuery ($queryStmt) or die ("FATAL ERROR: Unable to set status in patient table.");
}

function delByEncounterID ($id, $where, $table, $whereClause = "") {
	//echo $id . ":" . $where . ":" . $table . ":" . $whereClause . "<br>";
	// using the passed in $where saves 15 fetches from the encounter table
	$where .= (empty ($whereClause)) ? "" : " AND $whereClause";
	if ($where == "") die ("FATAL ERROR: Missing where clause for normalized delete of individual object.");
	$queryStmt = "DELETE FROM $table $where";
	$content = dbQuery ($queryStmt) or die ("FATAL ERROR: Unable to delete from $table.");
	if ($table == "prescriptions") {
		$queryStmt = "DELETE FROM pepfarTable where patientid = '" . $GLOBALS['existingData']['patientID'] . "' and visitdate = dbo.ymdToDate('" . $GLOBALS['existingData']['visitDateYy'] . "','" . $GLOBALS['existingData']['visitDateMm'] . "','" . $GLOBALS['existingData']['visitDateDd'] . "')";
		$content = dbQuery ($queryStmt) or die ("FATAL ERROR: Unable to delete from pepfarTable.");
	}
}

function encounterKeysChanged ($site, $eid, $day, $mo, $yr) {
	$where = "";
	$queryStmt = "SELECT dbsite, siteCode, patientID, visitDateDd, visitDateMm, visitDateYy, seqNum FROM encounter WHERE sitecode = '" . $site . "' and encounter_id = '$eid'";
	$content = dbQuery ($queryStmt) or die ("FATAL ERROR: Unable to search encounter table.");
	$keys = psRowFetch ($content);
	if (strcmp (trim ($keys['visitDateDd']), trim ($day)) != 0 ||
		strcmp (trim ($keys['visitDateMm']), trim ($mo)) != 0 ||
		strcmp (trim ($keys['visitDateYy']), trim ($yr)) != 0) {
		// need to build whereclause
		$where = " WHERE dbsite = " . $keys['dbsite'] . " and siteCode = '" . $keys['siteCode'] . "' AND patientID = '" . $keys['patientID'] . "' AND visitDateDd = '" . $keys['visitDateDd'] . "' AND visitDateMm = '" . $keys['visitDateMm'] . "' AND visitDateYy = '" . $keys['visitDateYy'] . "' AND seqNum = " . $keys['seqNum'];
	}
	return ($where);
}

function doLookup ($tab = "", $id = "", $nm = "", $where = "") {
   $query = "SELECT $id, $nm FROM $tab";
   if (!empty ($where)) $query .= " WHERE " . $where;
   $result = dbQuery($query);
   $vals = array ();
   while ($row = psRowFetch ($result)) {
      $vals[$row[$id]] = $row[$nm];
   }

   return $vals;
}

function lookupLabs ($version, $labNames) {
  //SEE if/how to use the labNames variable to cols[full] too
  $query = "SELECT * FROM labLookup WHERE version" . $version . "=1";
  $query .= (!empty ($labNames)) ? " AND labName IN (" . $labNames . ")" : "";
  $result = dbQuery ($query);

   $vals = array ();
   while ($row = psRowFetch ($result)) {
     $vals[$row['labName']] = $row;
   }

   return $vals;
}

function loadColumnNames ($table = "") {
   $tableSchema = " and table_schema = '" . DB_NAME . "'";
   $result = dbQuery("select column_name, data_type from information_schema.columns where table_name = '" . $table . "'" . $tableSchema);
   $colnames = array ();
   while ($row = psRowFetch ($result)) {
      $colnames[$row['column_name']] = $row['data_type'];
   }

   return $colnames;
}

function generateConditionList ($lang = "") {
  $conditionList = array ();
  $sortCol = ($lang == "en") ? "conditionSortEn" : "conditionSort";

  $queryStmt = "SELECT conditionCode, conditionNameEn, conditionNameFr, conditionGroup, $sortCol FROM conditionLookup WHERE conditionDisplay = '1' ORDER BY conditionGroup, $sortCol";
  $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't read conditionLookup table.");
  while ($row = psRowFetch ($result)) {
    $conditionList[$row['conditionGroup']][$row[$sortCol]]['code'] = $row['conditionCode'];
    $conditionList[$row['conditionGroup']][$row[$sortCol]]['en'] = $row['conditionNameEn'];
    $conditionList[$row['conditionGroup']][$row[$sortCol]]['fr'] = $row['conditionNameFr'];
  }

  return ($conditionList);
}

function generatePedConditionList ($lang = "") {
  $conditionList = array ();
  $sortCol = ($lang == "en") ? "ConditionSortEn" : "ConditionSort";

  $queryStmt = "SELECT ConditionCode, ConditionNameEn, ConditionNameFr, ConditionGroup, $sortCol FROM conditionLookup WHERE ConditionGroup BETWEEN 10 AND 14 AND ConditionDisplay = '1' ORDER BY ConditionGroup, $sortCol";
  $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't read conditionLookup table.");
  while ($row = psRowFetch ($result)) {
    $conditionList[$row[$sortCol]]['group'] = $row['ConditionGroup'];
    $conditionList[$row[$sortCol]]['code'] = $row['ConditionCode'];
    $conditionList[$row[$sortCol]]['en'] = $row['ConditionNameEn'];
    $conditionList[$row[$sortCol]]['fr'] = $row['ConditionNameFr'];
  }

  return ($conditionList);
}

function generatePedImmunizationList ($lang = "", $encType, $version) {
  $immList = array ();
  $sortCol = ($lang == "en") ? "immunizationOrderEn" : "immunizationOrderFr";
  $langCol = ($lang == "en") ? "immunizationNameEn" : "immunizationNameFr";

  $queryStmt = "SELECT l.immunizationCode, l." . $langCol . ", r.immunizationGroup, r." . $sortCol . ", r.immunizationCnt FROM immunizationLookup l, immunizationRendering r WHERE r.immunizationGroup = 1 AND l.immunizationID = r.immunizationID AND r.immunizationEncounterType = $encType AND r.immunizationFormVersion = $version ORDER BY $sortCol";
  $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't read immunizationLookup table.");
  while ($row = psRowFetch ($result)) {
    $immList[$row[$sortCol]]['cnt'] = $row['immunizationCnt'];
    $immList[$row[$sortCol]]['code'] = $row['immunizationCode'];
    $immList[$row[$sortCol]]['label'] = $row[$langCol];
  }

  return ($immList);
}

function generatePedLabsList ($lang = "", $encType, $version, $grp = 0) {
  $labList = array ();
  $sortCol = ($lang == "en") ? "pedLabsOrderEn" : "pedLabsOrderFr";
  $langCol = ($lang == "en") ? "pedLabsNameEn" : "pedLabsNameFr";

  $queryStmt = "SELECT l.pedLabsCode, l." . $langCol . ", r.pedLabsGroup, r." . $sortCol . ", r.pedLabsCnt FROM pedLabsLookup l, pedLabsRendering r WHERE l.pedLabsID = r.pedLabsID AND r.pedLabsEncounterType = $encType AND r.pedLabsFormVersion = $version";
  if (!empty ($grp)) $queryStmt .= " AND r.pedLabsGroup = $grp";
  $queryStmt .= " ORDER BY $sortCol";
  $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't read pedLabsLookup table.");
  while ($row = psRowFetch ($result)) {
    $labList[$row[$sortCol]]['cnt'] = $row['pedLabsCnt'];
    $labList[$row[$sortCol]]['code'] = $row['pedLabsCode'];
    $labList[$row[$sortCol]]['label'] = $row[$langCol];
  }

  foreach ($labList as $lab) {
    echo "
         <tr>
          <td  colspan=\"3\"><b>" . $lab['label'] . "</b> <input tabindex=\"" . $GLOBALS['tabIndex']++ . "\" id=\"" . $lab['code'] . "OrderedY\" name=\"" . $lab['code'] . "Ordered[]\" " . getData ($lab['code'] . "Ordered", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $GLOBALS['ynu'][$lang][0] . " <input tabindex=\"" . $GLOBALS['tabIndex']++ . "\" id=\"" . $lab['code'] . "OrderedN\" name=\"" . $lab['code'] . "Ordered[]\" " . getData ($lab['code'] . "Ordered", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $GLOBALS['ynu'][$lang][1] . "</td>
         </tr>
";
    for ($i = 1; $i <= $GLOBALS['max_pedLabs']; $i++) {
      if ($lab['cnt'] <= $i) {
        echo "
         <tr>
          <td id=\"" . $lab['code'] . $i . "AgeTitle\">&nbsp;</td>
          <td><table><tr><td><input tabindex=\"" . $GLOBALS['tabIndex']++ . "\" id=\"" . $lab['code'] . $i . "Age\" name=\"" . $lab['code'] . "Age" . $i . "\" " . getData ($lab['code'] . "Age" . $i, "text") . " type=\"text\" size=\"2\" maxlength=\"2\" class=\"" . $lab['code'] . "\" ></td><td id=\"" . $lab['code'] . $i . "AgeUnitTitle\"></td><td><input tabindex=\"" . $GLOBALS['tabIndex']++ . "\" id=\"" . $lab['code'] . $i . "AgeUnit1\" name=\"" . $lab['code'] . "AgeUnits" . $i . "[]\" " . getData ($lab['code'] . "AgeUnits" . $i, "checkbox", 1) . " type=\"radio\" value=\"1\" class=\"" . $lab['code'] . "\" ><i>" . $GLOBALS['pedSero'][$lang][5] . "</i> <input tabindex=\"" . $GLOBALS['tabIndex']++ . "\" id=\"" . $lab['code'] . $i . "AgeUnit2\" name=\"" . $lab['code'] . "AgeUnits" . $i . "[]\" " . getData ($lab['code'] . "AgeUnits" . $i, "checkbox", 2) . " type=\"radio\" value=\"2\" class=\"" . $lab['code'] . "\" ><i>" . $GLOBALS['pedSero'][$lang][6] . "</i></td></tr></table></td>
          <td><input tabindex=\"" . $GLOBALS['tabIndex']++ . "\" id=\"" . $lab['code'] . $i . "Res1\" name=\"" . $lab['code'] . "Res" . $i . "[]\" " . getData ($lab['code'] . "Res" . $i, "checkbox", 2) . " type=\"radio\" value=\"2\" class=\"" . $lab['code'] . "\" >" . $GLOBALS['npi'][$lang][0] . " <input tabindex=\"" . $GLOBALS['tabIndex']++ . "\" id=\"" . $lab['code'] . $i . "Res2\" name=\"" . $lab['code'] . "Res" . $i . "[]\" " . getData ($lab['code'] . "Res" . $i, "checkbox", 1) . " type=\"radio\" value=\"1\" class=\"" . $lab['code'] . "\" >" . $GLOBALS['npi'][$lang][1] . " <input tabindex=\"" . $GLOBALS['tabIndex']++ . "\" id=\"" . $lab['code'] . $i . "Res3\" name=\"" . $lab['code'] . "Res" . $i . "[]\" " . getData ($lab['code'] . "Res" . $i, "checkbox", 4) . " type=\"radio\" value=\"4\" class=\"" . $lab['code'] . "\" >" . $GLOBALS['npi'][$lang][2] . "</td>
         </tr>
";
      }
    }
  }
}

function generateInsertArray ($tab) {
  $excl = array ("patientID", "siteCode", "visitDateDd", "visitDateMm", "visitDateYy", "seqNum", "dbSite");
  $cols = loadColumnNames ($tab);

  $valueList = array ();

  foreach ($cols as $name => $type) {
	//echo $name . " " . $_POST[$name] . "<br/>";
    if (isset ($_POST[$name]) ) {
		if(!empty ($_POST[$name]))
		{
			$valueList[$name] = (eregi ("^on$", $_POST[$name]) && $type == "tinyint") ? 1 : $_POST[$name];
		}
		else
		{
			$valueList[$name] = $_POST[$name];
		}
    } 
	/**else if ( isset ($_POST[$name]) && $_POST[$name] !='' && trim ($_POST[$name]) == "0") 
	{
		$valueList[$name] = (eregi ("^on$", $_POST[$name]) && $type == "tinyint") ? 1 : $_POST[$name];
	}
			
	*/
	/*else {
		if ($type == 'int' || strpos($type,'int') > 0)
		    $valueList[$name] = 'nullint';
		else
      		$valueList[$name] = '';
    }*/
  }
  return ($valueList);
}

function allergyNameConvert ($name, $cnt) {
  switch ($name) {
    case "allergyName": return 'aMed' . $cnt; break;
    case "allergyStartMm": return 'aMed' . $cnt . "MM"; break;
    case "allergyStartYy": return 'aMed' . $cnt . "YY"; break;
    case "allergyStopMm": return 'aMed' . $cnt . "SpMM"; break;
    case "allergyStopYy": return 'aMed' . $cnt . "SpYY"; break;
    case "rash": return 'aMed' . $cnt . "Rash"; break;
    case "rashF": return 'aMed' . $cnt . "RashF"; break;
    case "ABC": return 'aMed' . $cnt . "ABC"; break;
    case "hives": return 'aMed' . $cnt . "Hives"; break;
    case "SJ": return 'aMed' . $cnt . "SJ"; break;
    case "anaph": return 'aMed' . $cnt . "Anaph"; break;
    case "allergyOther": return 'aMed' . $cnt . "Other"; break;
    default: return ""; break;
  }
}

function allowedDiscNameConvert ($name, $cnt) {
  switch ($name) {
    case "disclosureName": return 'discloseStatusName' . $cnt; break;
    case "disclosureRel": return 'discloseStatusRel' . $cnt; break;
    case "disclosureAddress": return 'discloseStatusAddress' . $cnt; break;
    case "disclosureTelephone": return 'discloseStatusTelephone' . $cnt; break;
    default: return ""; break;
  }
}

function conditionsNameConvert ($cond, $name) {
  switch ($name) {
    case "conditionMm": return $cond . "Mm"; break;
    case "conditionYy": return $cond . "Yy"; break;
    case "conditionActive": return $cond . "Active"; break;
    case "conditionComment": return $cond . "Comment"; break;
    default: return ""; break;
  }
}

function drugNameConvert ($drug, $name) {
  switch ($name) {
    case "startMm": return $drug . "StartMm"; break;
    case "startYy": return $drug . "StartYy"; break;
    case "isContinued": return $drug . "Continued"; break;
    case "stopMm": return $drug . "StopMm"; break;
    case "stopYy": return $drug . "StopYy"; break;
    case "toxicity": return $drug . "DiscTox"; break;
    case "prophDose": return $drug . "ProphDose"; break;
    case "intolerance": return $drug . "DiscIntol"; break;
    case "failure": return $drug . "DiscFail"; break;
    case "failureVir": return $drug . "DiscFailVir"; break;
    case "failureImm": return $drug . "DiscFailImm"; break;
    case "failureClin": return $drug . "DiscFailClin"; break;
    case "failureProph": return $drug . "DiscProph"; break;
    case "discUnknown": return $drug . "DiscUnknown"; break;
    case "stockOut": return $drug . "InterStock"; break;
    case "pregnancy": return $drug . "InterPreg"; break;
    case "patientHospitalized": return $drug . "InterHop"; break;
    case "lackMoney": return $drug . "InterMoney"; break;
    case "alternativeTreatments": return $drug . "InterAlt"; break;
    case "missedVisit": return $drug . "InterLost"; break;
    case "patientPreference": return $drug . "InterPref"; break;
    case "interUnk": return $drug . "InterUnk"; break;
    case "reasonComments": return $drug . "Comments"; break;
	case "forPepPmtct": return $drug . "forPepPmtct"; break;
	case "finPTME": return $drug . "finPTME"; break;
    default: return ""; break;
  }
}

function householdCompNameConvert ($name, $cnt) {
  switch ($name) {
    case "householdName": return 'householdName' . $cnt; break;
    case "householdAge": return 'householdAge' . $cnt; break;
    case "householdRel": return 'householdRel' . $cnt; break;
    case "hivStatus": return 'householdHiv' . $cnt; break;
    case "householdDisc": return 'householdDisc' . $cnt; break;
    default: return ""; break;
  }
}

function immunizationNameConvert ($imm, $name, $cnt) {
  switch ($name) {
    case "immunizationDd": return $imm . "Dd" . $cnt; break;
    case "immunizationMm": return $imm . "Mm" . $cnt; break;
    case "immunizationYy": return $imm . "Yy" . $cnt; break;
    case "immunizationGiven": return $imm . "Given" . $cnt; break;
    case "immunizationDoses": return $imm . "Doses" . $cnt; break;
    case "immunizationComment": return $imm . "Text"; break;
    default: return ""; break;
  }
}   

function otherImmunizationNameConvert ($name, $cnt) {
  switch ($name) {
    case "immunizationName": return 'immunOther' . 'Text1'; break;
    case "immunizationDd": return 'immunOther' . 'Dd' . $cnt; break;
    case "immunizationMm": return 'immunOther' . 'Mm' . $cnt; break;
    case "immunizationYy": return 'immunOther' . 'Yy' . $cnt; break;
    case "immunizationGiven": return 'immunOther' . 'Given' . $cnt; break;
    case "immunizationDoses": return 'immunOther' . 'Doses' . $cnt; break;
    default: return ""; break;      
  }
}

function pedLabsNameConvert ($code, $name, $cnt) {
  switch ($name) {
    case "pedLabsOrdered": return $code . "Ordered"; break;
    case "pedLabsResult": return $code . "Res" . $cnt; break;
    case "pedLabsResultAge": return $code . "Age" . $cnt; break;
    case "pedLabsResultAgeUnits": return $code . "AgeUnits" . $cnt; break;
    default: return ""; break;
  }
}

function labNameConvert ($lab, $name) {
  switch ($name) {
    case "ordered": return $lab . "Test"; break;
    case "result": return $lab . "TestResult"; break;
    case "result2": return $lab . "TestResult2"; break;
    case "result3": return $lab . "TestResult3"; break;
    case "result4": return $lab . "TestResult4"; break;
    case "resultDateDd": return $lab . "TestDd"; break;
    case "resultDateMm": return $lab . "TestMm"; break;
    case "resultDateYy": return $lab . "TestYy"; break;
    case "resultAbnormal": return $lab . "TestAbnormal"; break;
    case "resultRemarks": return $lab . "TestRemarks"; break;
    default: return ""; break;
  }
}

function otherDrugNameConvert ($name, $cnt) {
  switch ($name) {
    case "drugName": return 'other' . $cnt . 'Text'; break;
    case "startMm": return 'other' . $cnt . 'MM'; break;
    case "startYy": return 'other' . $cnt . 'YY'; break;
    case "isContinued": return 'other' . $cnt . 'Continued'; break;
    case "stopMm": return 'other' . $cnt . 'SpMM'; break;
    case "stopYy": return 'other' . $cnt . 'SpYY'; break;
    case "toxicity": return 'other' . $cnt . 'DiscTox'; break;
    case "prophDose": return 'other' . $cnt . 'ProphDose'; break;
    case "intolerance": return 'other' . $cnt . 'DiscIntol'; break;
    case "failure": return 'other' . $cnt . 'DiscFail'; break;
    case "failureVir": return 'other' . $cnt . 'DiscFailVir'; break;
    case "failureImm": return 'other' . $cnt . 'DiscFailImm'; break;
    case "failureClin": return 'other' . $cnt . 'DiscFailClin'; break;
    case "failureProph": return 'other' . $cnt . 'DiscProph'; break;
    case "discUnknown": return 'other' . $cnt . "DiscUnknown"; break;
    case "stockOut": return 'other' . $cnt . 'InterStock'; break;
    case "pregnancy": return 'other' . $cnt . 'InterPreg'; break;
    case "patientHospitalized": return 'other' . $cnt . 'InterHop'; break;
    case "lackMoney": return 'other' . $cnt . 'InterMoney'; break;
    case "alternativeTreatments": return 'other' . $cnt . 'InterAlt'; break;
    case "missedVisit": return 'other' . $cnt . 'InterLost'; break;
    case "patientPreference": return 'other' . $cnt . 'InterPref'; break;
    case "interUnk": return 'other' . $cnt . 'InterUnk'; break;
    case "reasonComments": return 'other' . $cnt . 'Comments'; break;
    case "finPTME": return 'other' . $cnt . 'finPTME'; break;
    default: return ""; break;
  }
}

function otherLabNameConvert ($name, $cnt) {
  switch ($name) {
    case "labName": return 'otherLab' . $cnt . 'TestText'; break;
    case "ordered": return 'otherLab' . $cnt . 'Test'; break;
    case "result": return 'otherLab' . $cnt . 'TestResult'; break;
    case "resultDateDd": return 'otherLab' . $cnt . 'TestDd'; break;
    case "resultDateMm": return 'otherLab' . $cnt . 'TestMm'; break;
    case "resultDateYy": return 'otherLab' . $cnt . 'TestYy'; break;
    case "resultAbnormal": return 'otherLab' . $cnt . 'TestAbnormal'; break;
    default: return ""; break;
  }
}

function referralNameConvert ($ref, $name) {
  switch ($name) {
    case "referralChecked": return $ref . "Checked"; break;
    case "refClinic": return $ref . "Clinic"; break;
    case "refAdateDd": return $ref . "AdateDd"; break;
    case "refAdateMm": return $ref . "AdateMm"; break;
    case "refAdateYy": return $ref . "AdateYy"; break;
    case "refFdateDd": return $ref . "FdateDd"; break;
    case "refFdateMm": return $ref . "FdateMm"; break;
    case "refFdateYy": return $ref . "FdateYy"; break;
    case "refAkept": return $ref . "Akept"; break;
    default: return ""; break;
  }
}

function riskAssessmentsNameConvert ($code, $name, $type) {
  if ($type == "checkbox") {
    switch ($name) {
      case "riskAnswer": return $code . "Answer"; break;
      case "riskDd": return $code . "Dd"; break;
      case "riskMm": return $code . "Mm"; break;
      case "riskYy": return $code . "Yy"; break;
      default: return ""; break;
    }
  } else if ($type == "text") {
    switch ($name) {
      case "riskComment": return $code . "Comment"; break;
      default: return ""; break;
    }
  } else if ($type == "date") {
    switch ($name) {
      case "riskDd": return $code . "Dd"; break;
      case "riskMm": return $code . "Mm"; break;
      case "riskYy": return $code . "Yy"; break;
      default: return ""; break;
    }
  }
}

function rxNameConvert ($drug, $name) {
  switch ($name) {
    case "stdDosage": return $drug . "StdDosage"; break;
    case "stdDosageSpecify": return $drug . "StdDosageSpecify"; break;
    case "pedDosageDesc": return $drug . "PedDosageSpecify"; break;
    case "pedPresentationDesc": return $drug . "PedPresSpecify"; break;
    case "altDosage": return $drug . "AltDosage"; break;
    case "altDosageSpecify": return $drug . "AltDosageSpecify"; break;
    case "numDays": return $drug . "NumDays"; break;
    case "numDaysDesc": return $drug . "NumDaysDesc"; break;
    case "dispensed": return $drug . "Dispensed"; break;
    case "dispDateDd": return $drug . "DispDateDd"; break;
    case "dispDateMm": return $drug . "DispDateMm"; break;
    case "dispDateYy": return $drug . "DispDateYy"; break;
    case "dispAltDosage": return $drug . "DispAltDosage"; break;
    case "dispAltDosageSpecify": return $drug . "DispAltDosageSpecify"; break;
    case "dispAltNumDays": return $drug . "DispAltNumDays"; break;
    case "dispAltNumDaysSpecify": return $drug . "DispAltNumDaysSpecify"; break;
	case "forPepPmtct": return $drug . "forPepPmtct"; break;
	case "dispAltNumPills": return $drug . "DispAltNumPills"; break;
    default: return ""; break;
  }
}

function otherRxNameConvert ($name, $cnt) {
  switch ($name) {
    case "drug": return 'other' . $cnt . 'RxText'; break;
    case "stdDosage": return 'other' . $cnt . "StdDosage"; break;
    case "stdDosageSpecify": return 'other' . $cnt . "StdDosageSpecify"; break;
    case "pedDosageDesc": return 'other' . $cnt . "PedDosageSpecify"; break;
    case "pedPresentationDesc": return 'other' . $cnt . "PedPresSpecify"; break;
    case "altDosage": return 'other' . $cnt . "AltDosage"; break;
    case "altDosageSpecify": return 'other' . $cnt . "AltDosageSpecify"; break;
    case "numDays": return 'other' . $cnt . "NumDays"; break;
    case "numDaysDesc": return 'other' . $cnt . "NumDaysDesc"; break;
    case "dispensed": return 'other' . $cnt . "Dispensed"; break;
    case "dispDateDd": return 'other' . $cnt . "DispDateDd"; break;
    case "dispDateMm": return 'other' . $cnt . "DispDateMm"; break;
    case "dispDateYy": return 'other' . $cnt . "DispDateYy"; break;
    case "dispAltDosage": return 'other' . $cnt . "DispAltDosage"; break;
    case "dispAltDosageSpecify": return 'other' . $cnt . "DispAltDosageSpecify"; break;
    case "dispAltNumDays": return 'other' . $cnt . "DispAltNumDays"; break;
    case "dispAltNumDaysSpecify": return 'other' . $cnt . "DispAltNumDaysSpecify"; break;
	case "forPepPmtct": return 'other' . $cnt . "forPepPmtct"; break;
	case "dispAltNumPills": return 'other' . $cnt . "DispAltNumPills"; break;
    default: return ""; break;
  }
}

function calcPedLabsResultDate ($pid, $cnt, $units) {
  if ($units == 1) $datepart = "dd";
  else if ($units == 2) $datepart = "mm";
  $queryStmt = "SELECT dateadd(" . $datepart . ", $cnt,
   CASE  WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, '06', '15')) = 1 THEN dbo.ymdToDate(dobYy, '06', '15')
   WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, '15')) = 1 THEN dbo.ymdToDate(dobYy, dobMm, '15')
   WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) = 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, dobDd)) = 1 THEN dbo.ymdToDate(dobYy, dobMm, dobDd) ELSE NULL END) AS resDate FROM patient WHERE patientID = '$pid'";
  $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search patient table.");
  $vals = array ();
  while ($row = psRowFetch ($result)) {
    if (empty ($row['resDate'])) continue;
    $tmp_date = date ("Y-m-d", strtotime ($row['resDate']));
    $vals['Dd'] = substr ($tmp_date, 8, 2);
    $vals['Mm'] = substr ($tmp_date, 5, 2);
    $vals['Yy'] = substr ($tmp_date, 2, 2);
  }

  return $vals;
}

function getPatientData ($pid) {
        $excl = array ("patient_id", "siteCode", "nxtVisitDd", "nxtVisitMm", "nxtVisitYy", "stID");
        if (strpos($pid,",") > 0) 
                $queryStmt = "SELECT * FROM patient WHERE patientID in ($pid)";
        else
                $queryStmt = "SELECT * FROM patient WHERE patientID = '$pid'";
        $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search patient table.");
        if (count($result) > 0) {
                foreach (psRowFetch ($result) as $name => $val) {
                        if ($name == 'deathDt' && !empty($val)) {
                                $deathDate = explode('-', substr($val,0,10));
                                $val = implode('/', array_reverse($deathDate));   
                        }
                        if (!empty ($val)) $GLOBALS['existingData'][$name] = rtrim ($val);
                }
        }    
}

function getExistingData ($eid, $tables) {
  $excl = array ("patientID", "siteCode", "visitDateDd", "visitDateMm", "visitDateYy", "seqNum");
  // initialize GLOBAL to hold existing checked checkboxes;
  $GLOBALS['checkedBoxes'] = array();

  $queryStmt = "SELECT encounter_id, RTRIM(siteCode), RTRIM(visitDateDd), RTRIM(visitDateMm), RTRIM(visitDateYy), seqNum, formAuthor,
	visitPointer, encComments, formVersion, formAuthor2, labOrDrugForm, nxtVisitDd, nxtVisitMm, nxtVisitYy, creator, lastModifier, encounterType, patientID
	FROM encounter
	WHERE encounter_id = '$eid' and RTRIM(sitecode) = '" . $_GET['site'] . "'";

  $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search encounter table.");

  while ($row = psRowFetch ($result)) {
    $GLOBALS['existingData']['eid'] = $row[0];
    $GLOBALS['existingData']['siteCode'] = $row[1];
    $GLOBALS['existingData']['visitDateDd'] = $row[2];
    $GLOBALS['existingData']['visitDateMm'] = $row[3];
    $GLOBALS['existingData']['visitDateYy'] = $row[4];
    $GLOBALS['existingData']['seqNum'] = $row['seqNum'];
    $GLOBALS['existingData']['formAuthor'] = $row[6];
    $GLOBALS['existingData']['visitPointer'] = $row[7];
    $GLOBALS['existingData']['encComments'] = "\n\n\n----------------- " . getSessionUser() . ", " . date ("d-M-Y g:i A") . ((empty ($row['encComments']) || preg_match ('/^\s/', $row['encComments'])) ? "" : "\n") . $row['encComments'];
    $GLOBALS['existingData']['formVersion'] = $row[9];
    $GLOBALS['existingData']['formAuthor2'] = $row[10];
    $GLOBALS['existingData']['labOrDrugForm'] = $row[11];
    $GLOBALS['existingData']['nxtVisitDd'] = $row[12];
    $GLOBALS['existingData']['nxtVisitMm'] = $row[13];
    $GLOBALS['existingData']['nxtVisitYy'] = $row[14];
    $GLOBALS['existingData']['creator'] = $row[15];
    $GLOBALS['existingData']['lastModifier'] = $row[16];
    $GLOBALS['existingData']['encounterType'] = $row['encounterType'];
    $GLOBALS['existingData']['patientID'] = $row['patientID'];
  }

  getPatientData ($GLOBALS['existingData']['patientID']);

  // Re-useable where clause
  $where = " WHERE siteCode = '" . $GLOBALS['existingData']['siteCode'] . "' AND patientID = '" . $GLOBALS['existingData']['patientID'] . "' AND visitDateDd = '" . $GLOBALS['existingData']['visitDateDd'] . "' AND visitDateMm = '" . $GLOBALS['existingData']['visitDateMm'] . "' AND visitDateYy = '" . $GLOBALS['existingData']['visitDateYy'] . "' AND seqNum = '" . $GLOBALS['existingData']['seqNum'] . "'";
  
  // Get any allergies
  if (in_array ("allergies", $tables)) {
    $queryStmt = "SELECT * FROM allergies $where ORDER BY allergySlot ASC";
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search allergies.");
    while ($row = psRowFetch ($result)) {
      $cnt = $row['allergySlot'];
      foreach ($row as $name => $val) {
        if (in_array ($name, $excl)) continue;
        if (!empty ($val) || trim ($val) == "0") {
          $lab = allergyNameConvert ($name, $cnt);
          if (!empty ($lab)) $GLOBALS['existingData'][$lab] = rtrim ($val);
        }
      }
    }
  }

  // Get any allowed disclosures
  if (in_array ("allowedDisclosures", $tables)) {
    $queryStmt = "SELECT * FROM allowedDisclosures $where ORDER BY disclosureSlot ASC";
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search allowedDisclosuresergies.");
    while ($row = psRowFetch ($result)) {
      $cnt = $row['disclosureSlot'];
      foreach ($row as $name => $val) {
        if (in_array ($name, $excl)) continue;
        if (!empty ($val) || trim ($val) == "0") {
          $lab = allowedDiscNameConvert ($name, $cnt);
          if (!empty ($lab)) $GLOBALS['existingData'][$lab] = rtrim ($val);
        }
      }
    }
  }


  
  // Get any conditions
  if (in_array ("conditions", $tables)) {
    $queryStmt = "SELECT conditions.*, conditionLookup.conditionCode FROM conditions, conditionLookup $where AND conditions.conditionID = conditionLookup.conditionsID";
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search conditions.");
    while ($row = psRowFetch ($result)) {
      $cond = $row['conditionCode'];
      foreach ($row as $name => $val) {
        if (in_array ($name, $excl)) continue;
        if (!empty ($val) || trim ($val) == "0") {
          $lab = conditionsNameConvert ($cond, $name);
          if (!empty ($lab)) $GLOBALS['existingData'][$lab] = rtrim ($val);
        }
      }
    }
  }

  // Get any drugs
  if (in_array ("drugs", $tables)) {
    $queryStmt = "SELECT drugs.*, drugLookup.drugName FROM drugs, drugLookup $where AND drugs.drugID = drugLookup.drugID";
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search drugs.");
    while ($row = psRowFetch ($result)) {
      $drug = $row['drugName'];
      foreach ($row as $name => $val) {
        if (in_array ($name, $excl)) continue;
        if (!empty ($val) || trim ($val) == "0") {
          $lab = drugNameConvert ($drug, $name);
          if (!empty ($lab)) $GLOBALS['existingData'][$lab] = rtrim ($val);
        }
      }
    }
  }

  // Get any household members
  if (in_array ("householdComp", $tables)) {
    $queryStmt = "SELECT * FROM householdComp $where ORDER BY householdSlot ASC";
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search householdComp.");
    while ($row = psRowFetch ($result)) {
      $cnt = $row['householdSlot'];
      foreach ($row as $name => $val) {
        if (in_array ($name, $excl)) continue;
        if (!empty ($val) || trim ($val) == "0") {
          $lab = householdCompNameConvert ($name, $cnt);
          if (!empty ($lab)) $GLOBALS['existingData'][$lab] = rtrim ($val);
        }
      }
    }
  }

  // Get any immunizations
  if (in_array ("immunizations", $tables)) {
    $queryStmt = "SELECT immunizations.*, immunizationLookup.immunizationCode FROM immunizations, immunizationLookup $where AND immunizations.immunizationID = immunizationLookup.immunizationID ORDER BY immunizations.immunizationSlot ASC";
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search immunizations.");
    while ($row = psRowFetch ($result)) {
      $cnt = $row['immunizationSlot'];
      $imm = $row['immunizationCode'];
      foreach ($row as $name => $val) {
        if (in_array ($name, $excl)) continue;
        if (!empty ($val) || trim ($val) == "0") {
          $lab = immunizationNameConvert ($imm, $name, $cnt);
          if (!empty ($lab)) $GLOBALS['existingData'][$lab] = rtrim ($val);
        }
      }
    }
  }  

  // Get other immunizations
  if (in_array ("otherImmunizations", $tables)) {
    $queryStmt = "SELECT * FROM otherImmunizations $where ORDER BY immunizationSlot ASC";
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search otherImmunizations."); 
  	if (DEBUG_FLAG) fb($queryStmt, "otherimmQuery");
    while ($row = psRowFetch ($result)) { 
  	if (DEBUG_FLAG) fb($row, "current immno row");
      $cnt = $row['immunizationSlot'];
      foreach ($row as $name => $val) {
        if (in_array ($name, $excl)) continue;
        if (!empty ($val) || trim ($val) == "0") {
          $lab = otherImmunizationNameConvert ($name, $cnt);
          if (!empty ($lab)) {
  			$GLOBALS['existingData'][$lab] = rtrim ($val);
  			if (DEBUG_FLAG) fb($GLOBALS['existingData'][$lab], $lab . " value");
  		}
        }
      }
    }
  } 

  // Get any labs
  if (in_array ("labs", $tables)) {
    $queryStmt = "SELECT labs.*, labLookup.labName FROM labs, labLookup $where AND labs.labID = labLookup.labID";
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search labs.");
    while ($row = psRowFetch ($result)) {
      $test = $row['labName'];
      // Special case for ped lab form amylase and lipase results
      if ($_GET['title'] == "19" && ($test == "amylase" || $test == "lipase")) {
        $row['result'] = trim ($row['result']);
        $row['result2'] = trim ($row['result2']);
        if (((!empty ($row['result']) || $row['result'] == "0") || (!empty ($row['result2']) || $row['result2'] == "0")) && $row['result3'] == 2) $row['result'] = $row['result2'];
      }
      foreach ($row as $name => $val) {
        if (in_array ($name, $excl)) continue;
        if (!empty ($val) || trim ($val) == "0") {
          $lab = labNameConvert ($test, $name);
          if (!empty ($lab)) $GLOBALS['existingData'][$lab] = rtrim ($val);
        }
      }
    }
    $queryStmt = "select labid from labs $where and ordered = 1 and result is null"; 
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search labs. Query was: " . $queryStmt); 
    while ($row = psRowFetch ($result)) {
	$GLOBALS['existingData']['labid' . $row['labid']] = 1;
    }  
  }

  // Get any other drugs
  if (in_array ("otherDrugs", $tables)) {
    $queryStmt = "SELECT * FROM otherDrugs $where ORDER BY drugSlot ASC";
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search otherDrugs.");
    while ($row = psRowFetch ($result)) {
      $cnt = $row['drugSlot'];
      foreach ($row as $name => $val) {
        if (in_array ($name, $excl)) continue;
        if (!empty ($val) || trim ($val) == "0") {
          $lab = otherDrugNameConvert ($name, $cnt);
          if (!empty ($lab)) $GLOBALS['existingData'][$lab] = rtrim ($val);
        }
      }
    }
  }

  // Get any other labs
  if (in_array ("otherLabs", $tables)) {
    $queryStmt = "SELECT * FROM otherLabs $where ORDER BY labSlot ASC";
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search otherLabs.");
    while ($row = psRowFetch ($result)) {
      $cnt = $row['labSlot'];
      foreach ($row as $name => $val) {
        if (in_array ($name, $excl)) continue;
        if (!empty ($val) || trim ($val) == "0") {
          $lab = otherLabNameConvert ($name, $cnt);
          if (!empty ($lab)) $GLOBALS['existingData'][$lab] = rtrim ($val);
        }
      }
    }
  }

  // Get any pedLabs
  if (in_array ("pedLabs", $tables)) {
    $queryStmt = "SELECT pedLabs.*, pedLabsLookup.pedLabsCode FROM pedLabs, pedLabsLookup $where AND pedLabs.pedLabsID = pedLabsLookup.pedLabsID ORDER BY pedLabs.pedLabsSlot ASC";
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search pedLabs.");
    while ($row = psRowFetch ($result)) {
      $cnt = $row['pedLabsSlot'];
      $code = $row['pedLabsCode'];
      foreach ($row as $name => $val) {
        if (in_array ($name, $excl)) continue;
        if (!empty ($val) || trim ($val) == "0") {
          $lab = pedLabsNameConvert ($code, $name, $cnt);
          if (!empty ($lab)) $GLOBALS['existingData'][$lab] = rtrim ($val);
        }
      }
    }
  }

  // Get any prescriptions
  if (in_array ("prescriptions", $tables)) {
    $queryStmt = "SELECT prescriptions.*, drugLookup.drugName FROM prescriptions, drugLookup $where AND prescriptions.drugID = drugLookup.drugID";
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search prescriptions.");
    while ($row = psRowFetch ($result)) {
      $drug = $row['drugName'];
      foreach ($row as $name => $val) {
        if (in_array ($name, $excl)) continue;
        if (!empty ($val) || trim ($val) == "0") {
          $lab = rxNameConvert ($drug, $name);
          if (!empty ($lab)) $GLOBALS['existingData'][$lab] = rtrim ($val);
        }
      }
    }
  }

  // Get any other prescriptions
  if (in_array ("otherPrescriptions", $tables)) {
    $queryStmt = "SELECT * FROM otherPrescriptions $where ORDER BY rxSlot ASC";
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search otherPrescriptions.");
    while ($row = psRowFetch ($result)) {
      $cnt = $row['rxSlot'];
      foreach ($row as $name => $val) {
        if (in_array ($name, $excl)) continue;
        if (!empty ($val) || trim ($val) == "0") {
          $lab = otherRxNameConvert ($name, $cnt);
          if (!empty ($lab)) $GLOBALS['existingData'][$lab] = rtrim ($val);
        }
      }
    }
  }

  // Get any referrals
  if (in_array ("referrals", $tables)) {
    $queryStmt = "SELECT * FROM referrals $where";
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search referrals.");
    while ($row = psRowFetch ($result)) {
      foreach ($row as $name => $val) {
        if (in_array ($name, $excl)) continue;
        if (!empty ($val) || trim ($val) == "0") {
          $lab = referralNameConvert ($row['referral'], $name);
          if (!empty ($lab)) $GLOBALS['existingData'][$lab] = rtrim ($val);
        }
      }
    }
  }

  // Get any riskAssessments
  if (in_array ("riskAssessments", $tables)) {
    $queryStmt = "SELECT riskAssessments.*, riskLookup.fieldName FROM riskAssessments, riskLookup $where AND riskAssessments.riskID = riskLookup.riskID";
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search riskAssessments.");
    while ($row = psRowFetch ($result)) {
      $code = $row['fieldName'];
      foreach ($row as $name => $val) {
        if (in_array ($name, $excl)) continue;
        if (!empty ($val) || trim ($val) == "0") {
          $type = "checkbox";
          if (strpos ($name, "Comment")) {
	    $type = "text";
          } else if (strpos ($name, "Date")) {
  	    $type = "date";
          }
          $lab = riskAssessmentsNameConvert ($code, $name, $type);
          if (!empty ($lab)) $GLOBALS['existingData'][$lab] = rtrim ($val);
        }
      }
    }
  }

  // get concept instances for this encounter from the obs table
  getConceptData($eid, $_GET['site']);

  // Get the rest
  foreach ($tables as $tab) {
	// don't get normalized tables
    if (in_array ($tab, $GLOBALS['norm_tables'])) continue;
    $queryStmt = "SELECT * FROM $tab $where";
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search $tab.");
    if ($row = psRowFetch($result)) {
      foreach ($row as $name => $val) {
        if (in_array ($name, $excl)) continue;
        if (!empty ($val) || trim ($val) == "0") $GLOBALS['existingData'][$name] = rtrim ($val);
      }
    }
  }
}

function getPatients() {
        $queryStmt = "select e.siteCode as site,
        count(distinct p.patientID) as patCnt,
        count(distinct e.encounter_id) as encCnt
        from encounter e, patient p
        where p.patientID = e.patientID
        and p.patStatus = 0
        group by e.siteCode order by 1";
	$content = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search patient table.");
        while ($row = psRowFetch ($content))
                echo "<tr><td>" . $row['site'] . "</td><td>" . $row['patCnt'] . "</td><td>" . $row['encCnt'] . "</td></tr>";
}

function getDrugOrder( $encounter_type, $formVersion, $lang )
{
    $drugOrder = array();
    // $drugOrder = array( "subhead1", "drug2", "drug3", "subhead4", "drug5" );
    $heading_query = "SELECT v.drugGroupID, min(versionOrder), l.DrugGroupen FROM drugVersionOrder v, drugGroupLookup l WHERE v.drugGroupID = l.drugGroupID AND encounterType = $encounter_type AND formVersion = $formVersion GROUP BY v.drugGroupID, l.drugGroupen ORDER BY min(versionOrder)";
    //sql select
    $heading_res = dbQuery($heading_query) or die ( "ERROR: unable to select from drugVersionOrder" );



    $i = 0;
    while ( $drugGroup = psRowFetch( $heading_res ) )
    {
        $drugOrder[$i] = $drugGroup[2];

        $drugs_query = "SELECT drugLookup.drugName FROM drugVersionOrder LEFT JOIN drugLookup on (drugVersionOrder.drugID = drugLookup.drugID) WHERE encounterType = '$encounter_type' AND formVersion = '$formVersion' AND drugGroupID = $drugGroup[0] ORDER BY drugLabel" . $lang;
        //sql select
        $drugs_res = dbQuery($drugs_query) or die ( "ERROR: unable to select from drugVersionOrder or drugLookup" );

        while ( $drug = psRowFetch( $drugs_res ) )
        {
            $i++;
            $drugOrder[$i] = $drug[0];
        }
        $i++;
    }

    return $drugOrder;
}

function getFieldValue($fieldName) {
	$result = "";
	if(isset($_POST[$fieldName])) {
		$result = $_POST[$fieldName];
	}
	return $result;
}
function generateConditionListInOrder ($lang = "",$version, $type) {
  $conditionList = array ();

  $queryStmt = "SELECT conditionCode, conditionNameEn, conditionNameFr, conditionGroupID, conditionOrder FROM conditionLookup, conditionOrder WHERE conditionsID=conditionID and conditionVersion = ".$version. " AND conditionEncounterType = '" . $type . "' ORDER BY conditionGroupID, conditionOrder";
  $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't read conditionLookup or conditionOrder table.");
  while ($row = psRowFetch ($result)) {
    $conditionList[$row['conditionGroupID']][$row['conditionOrder']]['code'] = $row['conditionCode'];
    $conditionList[$row['conditionGroupID']][$row['conditionOrder']]['en'] = $row['conditionNameEn'];
    $conditionList[$row['conditionGroupID']][$row['conditionOrder']]['fr'] = $row['conditionNameFr'];
    //$conditionList[$row['conditionGroupID']][$row['conditionOrder']]['conditionComment'] = $row['conditionComment'];

  }
  return ($conditionList);
}

function generatePMTCTConditionListInOrder ($lang = "",$type, $version) {

  $conditionList = array ();

  $queryStmt = "SELECT conditionCode, conditionNameEn, conditionNameFr, conditionGroupID, conditionOrder FROM conditionLookup l, conditionOrder o WHERE l.conditionsID=o.conditionID 
and conditionVersion = ".$version. " and conditionEncounterType = ". $type . " ORDER BY conditionGroupID, conditionOrder";

  $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't read conditionLookup or conditionOrder table.");
  while ($row = psRowFetch ($result)) {
    $conditionList[$row['conditionGroupID']][$row['conditionOrder']]['code'] = $row['conditionCode'];
    $conditionList[$row['conditionGroupID']][$row['conditionOrder']]['en'] = $row['conditionNameEn'];
    $conditionList[$row['conditionGroupID']][$row['conditionOrder']]['fr'] = $row['conditionNameFr'];
    //$conditionList[$row['conditionGroupID']][$row['conditionOrder']]['conditionComment'] = $row['conditionComment'];

  }

  return ($conditionList);
}


function conditionRows_1 ($grp, $tbi = 0, $start = 1, $cnt = 0, $preMarkup='') {
  if ($cnt == 0)
  {
    if(isset($GLOBALS['cond_list'][$grp]))
   	{
  		$cnt = count ($GLOBALS['cond_list'][$grp]);
  	}
  }
  $ind = 0;
  $bgColor = "#FFFFFF";
  $tbMarkup = "<br /><i>Si actif, complétez la section Tuberculose</i>";
  $tbArray = array("pulmTB", "mdrTB" , "extrapulmTB", "mtbPulm", "pulTB", "tbExtrapulm", "pedLymphTb","pedPulmTb","pedExtrapulmTbDissem");
  if(isset($GLOBALS['cond_list'][$grp])){
      $otherReason = array("otherStd", "otherInfec", "otherMentalHealth", "otherToxic");
	  foreach ($GLOBALS['cond_list'][$grp] as $x) {
		$ind++;
		$bgColor = ($bgColor == "#FFFFFF") ? "#D8D8D8" : "#FFFFFF";

		if (($x['code'] == "dmType2") || ($x['code'] == "dmType1") || ($ind < $start) ||
			($ind > ($start + $cnt - 1))) continue;
		$code = $x['code'];

		echo "
		  <tr bgcolor=\"$bgColor\">
		   <td align=\"center\" valign=\"top\"><table><tr><td id=\"" . $code . "ActiveTitle\"></td><td><input tabindex=\"" . $tbi++ . "\" id=\"" . $code . "Active1\" name=\"" . $code . "Active[]\" " . getData ($code . "Active", "checkbox", 1) . " class=\"conditions\" type=\"checkbox\" value=\"1\"></td></tr></table></td>
		   <td align=\"center\" valign=\"top\"><input tabindex=\"" . $tbi++ . "\" class=\"conditions\" id=\"" . $code . "Active2\" name=\"" . $code . "Active[]\" " . getData ($code . "Active", "checkbox", 2) . " type=\"checkbox\" value=\"2\"></td>
		   <td id=\"" .$code . "Title\" class=\"small_cnt\">" .$preMarkup.  $x[$GLOBALS['lang']]  ;
		if (in_array($code, $tbArray)) echo $tbMarkup;
		if ($code == "dm")
		{
		  echo "<input tabindex=\"" . $tbi++ . "\" id=\"dmType2Active\" name=\"dmType2Active\" " . getData ("dmType2Active", "checkbox") . " type=\"checkbox\" class=\"conditions\" value=\"On\"> " . $GLOBALS['dmType2Active'][$GLOBALS['lang']][1] . " <input tabindex=\"" . $tbi++ . "\" id=\"dmType1Active\" name=\"dmType1Active\" " . getData ("dmType1Active", "checkbox") . " type=\"checkbox\" class=\"conditions\" value=\"On\">" . $GLOBALS['dmType1Active'][$GLOBALS['lang']][1] . "";
		}
		else
		{
			if(in_array($code,$otherReason))
			{
				echo "<br /><input tabindex=\"" . $tbi++ . "\" name=\"" . $code . "Comment\" " . getData (  $code . "Comment", "text") . " type=\"text\" class=\"conditions\"
				size=\"15\" maxlength=\"200\">";

			}
		}
		echo "</td>
		      <td  valign=\"top\"><input tabindex=\"" . $tbi++ .
				"\" id=\"" .$code . "MY\"  name=\"" . $code . "Mm\" " . getData ($code . "Mm", "text") .
				" type=\"text\" class=\"conditions\" size=\"2\" maxlength=\"2\">/
				<input tabindex=\"" . $tbi++ . "\" id=\"" .$code . "YM\" name=\"" . $code . "Yy\" " .
				getData ($code . "Yy", "text") .
				" type=\"text\" class=\"conditions\" size=\"2\" maxlength=\"2\"></td>
		  </tr>";
	    $tbi +=5;
	  }
  }
  return ($tbi);
}
function findGender ( $clinicNumber = "",$unassignedFlag = "", $orderID = "") {
  $queryFlag = 0;
  // patient is deleted, so should not be found here
  // only look in the registration forms--the rest of the forms inherit clinicPatientID from this initial registration form value.
  $whereClause = " p.patStatus = 0 and e.encounterType in ( 10, 15 ) ";
  $order = " order by ";

  if (!empty($clinicNumber)) {
      $queryFlag = 1;
      $whereClause .= " and l.siteCode = '" . $clinicNumber . "'";
  }

  if (!empty($unassignedFlag) ) {

        $queryFlag = 1;
        if($unassignedFlag == 'Y') {
        	$whereClause .= " and p.sex not in (1,2) ";
        }
  }
  if (empty($orderID)){
  		$order .=" p.clinicPatientID";
  }
  else {
  	if($orderID == 1){
  		$order .=" ltrim(rtrim(p.clinicPatientID))";
  	} else if($orderID == 2){
  		$order .=" ltrim(rtrim(p.lname))";
  	} else if($orderID == 3){
  		$order .=" ltrim(rtrim(p.fname))";
  	} else {
  		$order .=" p.clinicPatientID";
  	}
  }
  // Do query
  if ($queryFlag) {
	$results = array ();
	$qry = "SELECT distinct p.patientID, ltrim(rtrim(p.lname)) as lname, ltrim(rtrim(p.fname)) as fname, p.dobMm, p.dobDd, p.dobYy, p.nationalID, p.patientID, l.siteCode, ltrim(rtrim(p.clinicPatientID)) as clinicPatientID, p.fnameMother , p.sex FROM patient p, encounter e, clinicLookup l where p.patientid = e.patientid and l.sitecode = e.sitecode and" . $whereClause . $order;
	$result = dbQuery ($qry);
	if (!$result)
		die("FATAL ERROR: Could not search patient table." . $qry);
	else {
	        while ($row = psRowFetch($result)) {
			//if ($pg > 0 && ($i < (($pg - 1) * PATIENTS_PER_PAGE + 1) || $i > ($pg * PATIENTS_PER_PAGE))) continue;
			array_push ($results, $row);
		}
		return ($results);
	}
  }
  return (array ());
  }

function insertFormErrors ($encounter_id, $errFields, $errMsgs) {
	dbBeginTransaction();
  	$delStmt = " delete from formErrors where encounter_id = ". $encounter_id;

  	dbQuery ($delStmt) or dbRollback();
  	$fieldArr = explode(',',$errFields);
  	$msgArr = explode(',',$errMsgs);
	$count = 0;
	$insertStmtHead = "insert into formErrors(encounter_id,fieldName,fieldError) ";

	for($i = 0; $i < count($fieldArr); $i++)
	{

		if(strlen($msgArr[$i])>0)
		{

			$insertStmt= $insertStmtHead . "  values( ". $encounter_id . ",'". $fieldArr[$i] . "','" . $msgArr[$i] ."') ";
			dbQuery ($insertStmt) or dbRollback();
			$count++;
		}
	}

  	dbCommit();
  	return $count;
}

function getRegistVisitDt ($pid, $site) {
  if (!empty ($pid)) {
    // Compute last page, don't let user go beyond last page
	// add deleted discontinuation forms to the list
    $queryStmt = "SELECT visitDateDd + '/' + visitDateMm + '/' + visitDateYy AS visitDate  FROM encounter WHERE patientID = '$pid' AND siteCode = '$site' AND encStatus < 255 AND encounterType in (10,15)";
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search encounter table.");
    $row = psRowFetch ($result);
    return $row['visitDate'];
  }
  return "";
}

function isPatientStatusExist ($date) {
  $result = dbQuery("select top 1 * from patientStatusTemp where endDate = '$date'");
  if ($row = psRowFetch($result)) {
    return true;
  }
  return false;
}


function getPatientStatusTemp ($endDate) {
  return dbQuery("select patientID, patientStatus from patientStatusTemp where endDate = '$endDate'");
}

function runEncounterQueue ($resend = false) {
  // Do not run this on a consolidated server
  if (getConfig ('serverRole') == 'consolidated') return;

  // Just handling lab orders at this time, there may be other types in future
  $url = getConfig ("labOrderUrl");

  // Want to send statuses 1 (new), 3 (rejected) and 4 (xmit failed),
  // and optionally 2 (previously sent) in case we ever want to resend
  // all previoulsy sent orders
  $types = "6, 19";
  $statuses = "1, 3, 4" . ($resend ? ", 2" : "");

  if (empty ($url)) { // No 'labOrderUrl' config option set
//    recordEvent ('labOrderErr',
//      array (
//        'msg' => "Empty value for 'labOrderUrl' config option."
//      )
//    );
    setQueueStatusByTypeAndStatus ($types, $statuses, 4);
  } else {
    $orig_inc_path = get_include_path ();
    set_include_path ($orig_inc_path . PATH_SEPARATOR . './classes');
    require_once ("Net/HL7/HohConnection.php");

    $conn = new Net_HL7_HohConnection ($url);

    // Find orders we're interested in and try to send again
    $orders = database()->query ('
      SELECT encounter_id AS id, sitecode
      FROM encounterQueue
      WHERE encounterType IN (' . $types . ')
       AND encounterStatus IN (' . $statuses . ')')->fetchAll ();
    foreach ($orders as $row) {
      $eventArgs = array ();
      $msg = createLabOrderMsg ($row['id']);
      if (empty ($msg)) continue;
      if (DEBUG_FLAG) {
        recordEvent ('labOrderDebug',
          array (
            'orderMsg' => $msg->toString ()
          )
        );
      }
      list ($success, $resp) = $conn->send ($msg);
      if ($success) {
        // Check MSA-1 field for acknowledgement code
        $msa1 = $resp->getSegmentFieldAsString (1, 1);
        if (strcasecmp ($msa1, "AA") == 0 || strcasecmp ($msa1, "CA") == 0) {
          // Order accepted, update status
          setQueueStatusById ($row['id'], 2);
        } else {
          // Problem with order message content, set status and log it
          setQueueStatusById ($row['id'], 3);
          $eventArgs['msg'] = "Ack. code: $msa1";
          // Loop over any ERR segments and append errors to event msg.
          $errs = $resp->getSegmentsByName ("ERR");
          foreach ($errs as $err) {
            $loc = $err->getField (2);
            $code = $err->getField (3);
            if (!empty ($loc)) {
              $eventArgs['msg'] .= "; Location: " . (is_array ($loc) ? implode ("^", $loc) : $loc);
            } else {
              $eventArgs['msg'] .= "; Location: N/A";
            }
            if (!empty ($code)) {
              $eventArgs['msg'] .= ", Code: " . (is_array ($code) ? implode ("^", $code) : $code);
            }
          }
        }
      } else {
        // Problem transmitting order message, log it  
        setQueueStatusById ($row['id'], 4);
        $eventArgs['msg'] = "Transmission problem with lab order message, curl_eror = $resp";
      }
      if (!empty ($eventArgs)) {
        $eventArgs['orderId'] = $row['id'];
        $eventArgs['site'] = $row['sitecode'];
        $eventArgs['source'] = "backend.php:runEncounterQueue()";
        recordEvent ("labOrderErr", $eventArgs);
      }
    }

    set_include_path ($orig_inc_path);
  }
}

function createLabOrderMsg ($id) {
  require_once ("Net/HL7/Segments/MSH.php");

  // pull demog. and misc. data needed for message generation
  $demogData = database()->query ('
    SELECT l.clinic, p.clinicPatientID, p.nationalID, p.patGuid,
     o1.value_text AS pcID, o2.value_text AS obID, p.fname, p.lname, p.sex,
     p.addrDistrict, p.addrSection, p.addrTown, p.telephone, p.maritalStatus,
     e.siteCode, e.formAuthor
    FROM clinicLookup l, encValidAll e, patient p
     LEFT JOIN obs o1 ON p.person_id = o1.person_id
      AND p.location_id = o1.location_id
      AND o1.concept_id = 70039
     LEFT JOIN obs o2 ON p.person_id = o2.person_id
      AND p.location_id = o2.location_id
      AND o2.concept_id = 70040
    WHERE l.siteCode = e.siteCode
     AND p.patientID = e.patientID
     AND e.encounter_id = ?', array ($id))->fetchAll ();

  // pull data to calculate whatever we can for date of birth
  $dobData = database()->query ('
    SELECT
     CASE WHEN ISNUMERIC(p.dobYy) = 1
      AND ISNUMERIC(p.dobMm) <> 1
      AND ISDATE(ymdToDate(p.dobYy, ?, ?)) = 1
      THEN LEFT(ymdToDate(p.dobYy, ?, ?), 4)
     WHEN ISNUMERIC(p.dobYy) = 1
      AND ISNUMERIC(p.dobMm) = 1
      AND ISNUMERIC(p.dobDd) <> 1
      AND ISDATE(ymdToDate(p.dobYy, p.dobMm, ?)) = 1
      THEN LEFT(ymdToDate(p.dobYy, p.dobMm, ?), 7)
     WHEN ISNUMERIC(p.dobYy) = 1
      AND ISNUMERIC(p.dobMm) = 1
      AND ISNUMERIC(p.dobDd) = 1
      AND ISDATE(ymdToDate(p.dobYy, p.dobMm, p.dobDd)) = 1
      THEN ymdToDate(p.dobYy, p.dobMm, p.dobDd)
     ELSE NULL END AS dob,
     CASE WHEN ISNUMERIC(p.ageYears) = 1
      AND YEAR(e.visitDate) - p.ageYears <= YEAR(now())
      THEN YEAR(e.visitDate) - p.ageYears
      ELSE NULL END AS birthYear, p.nationalID
    FROM encValidAll e, patient p
    WHERE p.patientID = e.patientID
     AND e.encounterType IN (10, 15)
     AND p.patientID =
      (SELECT patientID FROM encValidAll WHERE encounter_id = ?)', array ('01', '01', '01', '01', '01', '01', $id))->fetchAll ();
  if (empty ($dobData[0]['dob'])) {
    // No useable data found in dobXx fields, try to calc. dob some other way
    if (!is_null (trim ($dobData[0]['nationalID'])) && trim ($dobData[0]['nationalID']) != "") {
      // Use middle part of national ID, if valid, for birth month and year
      $mo = substr ($dobData[0]['nationalID'], 2, 2);
      $yr = substr ($dobData[0]['nationalID'], 4, 2);
      if (checkdate ($mo, 1, assumeYear ($yr))) {
        $dobData[0]['dob'] = assumeYear ($yr) . "-" . zpad ($mo, 2);
      }
    }
    if (empty ($dobData[0]['dob']) && !is_null (trim ($dobData[0]['birthYear'])) && trim ($dobData[0]['birthYear']) != "") {
      // Use ageYears and visitDate of reg. encounter to estimate birth year
      if (checkdate (1, 1, $dobData[0]['birthYear'])) {
        $dobData[0]['dob'] = $dobData[0]['birthYear'];
      }
    }
  }

  // pull all lab test data for the order
  $testData = database()->query ('
    SELECT k.testNameFr, t.sampleType as testSample,
     n.panelName, n.sampleType as panelSample
    FROM encValidAll e, labs t
     LEFT JOIN labLookup k ON t.labID = k.labID
     LEFT JOIN labPanelLookup n ON t.labID = n.labPanelLookup_id
    WHERE e.encounter_id = ?
     AND e.patientID = t.patientID
     AND e.siteCode = t.siteCode
     AND e.visitDateYy = t.visitDateYy
     AND e.visitDateMm = t.visitDateMm
     AND e.visitDateDd = t.visitDateDd
     AND e.seqNum = t.seqNum
     AND t.labid > 1000 
     AND t.sampleType <> ?', array ($id, 'isante'))->fetchAll ();

  // if no lab test data (encounter auto-saved, but no lab tests ordered),
  // return empty string which will skip this encounter
  if (empty ($testData)) return ("");

  $hl7 = new Net_HL7 ();
  $msg = $hl7->createMessage ();

  // MSH segment
  $msh = $hl7->createMSH ();
  $msh->setField (3, "^iSanté^99LAB");
  $msh->setField (4, "^" . hl7StringEscape (trim ($demogData[0]['clinic'])) . "^99LAB");
  $msh->setField (5, "^OpenELIS^99LAB");
  $msh->setField (6, "^" . hl7StringEscape (trim ($demogData[0]['clinic'])) . "^99LAB");
  $msh->setField (9, "OML^O21^OML_O21");
  $msh->setField (11, "P");
  $msh->setField (18, "UTF-8");
  $msg->addSegment ($msh);

  // PID segment
  $pid = new Net_HL7_Segment ("PID");
  $pid->setField (1, 1);
  $ids = $demogData[0]['patGuid'] . "^^^^GU";
  if (!is_null (trim ($demogData[0]['nationalID'])) && trim ($demogData[0]['nationalID']) != "")
    $ids .= "~" . hl7StringEscape (trim ($demogData[0]['nationalID'])) . "^^^^NA";
  if (!is_null (trim ($demogData[0]['clinicPatientID'])) && trim ($demogData[0]['clinicPatientID']) != "")
    $ids .= "~" . hl7StringEscape (trim ($demogData[0]['clinicPatientID'])). "^^^^ST";
  if (!is_null (trim ($demogData[0]['pcID'])) && trim ($demogData[0]['pcID']) != "")
    $ids .= "~" . hl7StringEscape (trim ($demogData[0]['pcID'])) . "^^^^PC";
  if (!is_null (trim ($demogData[0]['obID'])) && trim ($demogData[0]['obID']) != "")
    $ids .= "~" . hl7StringEscape (trim ($demogData[0]['obID'])) . "^^^^OB";
  $pid->setField (3, $ids);
  $pid->setField (5, hl7StringEscape (trim ($demogData[0]['lname'])) . "^" . hl7StringEscape (trim ($demogData[0]['fname'])));
  $pid->setField (7, empty ($dobData[0]['dob']) ? "" : str_replace ("-", "", $dobData[0]['dob']));
  $sex = "U";
  if ($demogData[0]['sex'] == 1) $sex = "F";
  if ($demogData[0]['sex'] == 2) $sex = "M";
  $pid->setField (8, $sex);
  $addr = "";
  if (!is_null (trim ($demogData[0]['addrDistrict'])) && trim ($demogData[0]['addrDistrict']) != "")
    $addr .= hl7StringEscape (trim ($demogData[0]['addrDistrict']));
  if (!is_null (trim ($demogData[0]['addrSection'])) && trim ($demogData[0]['addrSection']) != "")
    $addr .= "^" . hl7StringEscape (trim ($demogData[0]['addrSection']));
  if (!is_null (trim ($demogData[0]['addrTown'])) && trim ($demogData[0]['addrTown']) != "")
    $addr .= (!is_null (trim ($demogData[0]['addrSection'])) && trim ($demogData[0]['addrSection']) != "" ? "^" : "^^") . hl7StringEscape (trim ($demogData[0]['addrTown']));
  $pid->setField (11, $addr);
//  $phone = "";
//  if (!is_null (trim ($demogData[0]['telephone'])) && trim ($demogData[0]['telephone']) != "")
//    $phone .= hl7StringEscape (trim ($demogData[0]['telephone']));
//  $pid->setField (13, "^^^^^^$phone");
  $mstat = "T";
  if ($demogData[0]['maritalStatus'] == 1) $mstat = "M";
  if ($demogData[0]['maritalStatus'] > 1 && $demogData[0]['maritalStatus'] < 4) $mstat = "G";
  if ($demogData[0]['maritalStatus'] > 3 && $demogData[0]['maritalStatus'] < 8) $mstat = "W";
  if ($demogData[0]['maritalStatus'] > 7 && $demogData[0]['maritalStatus'] < 16) $mstat = "A";
  if ($demogData[0]['maritalStatus'] > 15 && $demogData[0]['maritalStatus'] < 32) $mstat = "S";
  if ($demogData[0]['maritalStatus'] > 31) $mstat = "U";
  $pid->setField (16, $mstat);
  $msg->addSegment ($pid);

  // ORC, OBR & OBX segment groups (one group per test/panel)
  $cnt = 1;
  foreach ($testData as $test) {
    $orc = new Net_HL7_Segment ("ORC");
    $orc->setField (1, "NW");
    $orc->setField (2, $demogData[0]['siteCode'] . "-$id");
    $orc->setField (4, $demogData[0]['siteCode'] . "-$id-1");
    $doctor = "";
    if (!is_null (trim ($demogData[0]['formAuthor'])) && trim ($demogData[0]['formAuthor']) != "") {
      $nameParts = preg_split ("/\s+/", hl7StringEscape (trim ($demogData[0]['formAuthor'])));
      $doctor = $demogData[0]['siteCode'] . "-" . implode ($nameParts) . "^";
      $fn = "";
      if (count ($nameParts) > 1) {
        $fn = array_shift ($nameParts);
      }
      $doctor .= implode (" ", $nameParts) . "^" . $fn . "^^^^^^^^^^U";
      $orc->setField (12, $doctor);
    }
    $obr = new Net_HL7_Segment ("OBR");
    $obr->setField (1, $cnt++);
    $obr->setField (2, $demogData[0]['siteCode'] . "-$id");
    $testName = (!is_null (trim ($test['testNameFr'])) && trim ($test['testNameFr']) != "" ? "T-" . hl7StringEscape (trim ($test['testNameFr'])) . "^" . hl7StringEscape (trim ($test['testNameFr'])) : "P-" . hl7StringEscape (trim ($test['panelName'])) . "^" . hl7StringEscape (trim ($test['panelName']))) . "^99LAB";
    $obr->setField (4, $testName);
    $obx = new Net_HL7_Segment ("OBX");
    $obx->setField (1, "1");
    $obx->setField (2, "ST");
    $obx->setField (3, "SPEC_TYPE^Specimen Type^99LAB");
    $sampType = !is_null (trim ($test['testSample'])) && trim ($test['testSample']) != "" ? hl7StringEscape (trim ($test['testSample'])) : hl7StringEscape (trim ($test['panelSample']));
    $obx->setField (5, $sampType);
    $obx->setField (11, "F");
    $msg->addSegment ($orc);
    $msg->addSegment ($obr);
    $msg->addSegment ($obx);
  }

  return ($msg);
}

function hl7StringEscape ($in) {
  return (str_replace ("|", "\\F\\",
          str_replace ("^", "\\S\\",
          str_replace ("~", "\\R\\",
          str_replace ("&", "\\T\\",
          str_replace ("\\", "\\E\\", $in))))));
}

function setQueueStatusById ($id, $status) {
  database()->exec ('
    UPDATE encounterQueue
    SET encounterStatus = ' . $status . ', lastStatusUpdate = now()
    WHERE encounter_id = ' . $id);
}

function setQueueStatusByTypeAndStatus ($type, $statuses, $status) {
  database()->exec ('
    UPDATE encounterQueue
    SET encounterStatus = ' . $status . ', lastStatusUpdate = now()
    WHERE encounterType IN (' . $type . ')
     AND encounterStatus IN (' . $statuses . ')');
}

function setQueueAccessionAndStatusById ($id, $accNo, $status) {
  database()->query ('
    UPDATE encounterQueue
    SET accessionNumber = ?, encounterStatus = ?, lastStatusUpdate = now()
    WHERE encounter_id = ' . $id, array ($accNo, $status));
}

function getDrugArv($drugid)
{
    $drugOptions='';
    $drugs_query = "SELECT drugID, drugLabel FROM drugLookup WHERE drugID IN ( 1, 3, 4, 5, 6, 7, 8, 10, 11, 12, 15, 16, 17, 20, 21, 22, 23, 26, 27, 28, 29, 31, 32, 33, 34, 87, 88, 89, 90, 91 ) ";
    $drugs_res = dbQuery($drugs_query) or die ( "ERROR: unable to select from  drugLookup" );
        while ( $drug = psRowFetch( $drugs_res ) )
        {
            $i++; 
			if($drugid==$drug[0])
			$drugOptions=$drugOptions.'<option value="'.$drug[0].'" selected >'.$drug[1].'</option>';
		else 
			$drugOptions=$drugOptions.'<option value="'.$drug[0].'">'.$drug[1].'</option>';
        }


    return $drugOptions;
}

function getIapOptions($id)
{
    $iapOptions='';
    $iap_query = "SELECT indicatorID, name FROM iap_indicator ";
    $iap_res = dbQuery($iap_query) or die ( "ERROR: unable to select from  drugLookup" );
        while ( $iap = psRowFetch( $iap_res ) )
        {
            $i++; 
			if($id==$iap[0])
			$iapOptions=$iapOptions.'<option value="'.$iap[0].'" selected >'.$iap[1].'</option>';
		else 
			$iapOptions=$iapOptions.'<option value="'.$iap[0].'">'.$iap[1].'</option>';
        }


    return $iapOptions;
}

function getIap($id)
{   
    $iapArray='';
	if($id>0)
    $iap_query = "SELECT * FROM iap_indicator where indicatorID=".$id;
else 
	$iap_query = "SELECT * FROM iap_indicator where 1";
    $iap_res = dbQuery($iap_query) or die ( "ERROR: unable to select from  iap_indicator" );
        while ( $iap = psRowFetch( $iap_res ) )
        {
			$iapArray=$iap;
           }
    return $iapArray;
}


?>
