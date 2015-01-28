<?php
require_once 'backendAddon.php';
require_once 'labels/report.php';

$lang = $_POST['lang'];
$type = $_POST['type']; // To determine whether main or subrow. FIXME - looks at class
$sitecode = $_POST['sitecode'];
$orgunit = $_POST['orgunit'];
$orgname = str_replace ("'", "''", $_POST['orgname']);
$tblname = $_POST['tblname'];
$olevel = $_POST['olevel'];
$olevelval = $_POST['olevelval'];

$sql = "";
if ( $type == 'report-subrow') {
  // Patient query for subrows
  $sql = "select distinct p.clinicPatientID, p.patientID, p.fname, p.lname, p.sex, p.dobDd, p.dobMm, p.dobYy from patient p, $tblname t where p.patientID = t.pid and p.location_id = $sitecode";
} else if ($type == 'report-totalrow') {
  // All patients
  $sql = "select distinct p.clinicPatientID, p.patientID, p.fname, p.lname, p.sex, p.dobDd, p.dobMm, p.dobYy from patient p, $tblname t where p.patientID = t.pid"; 
} else {  // Must put main row query here since it could have multiple classes
  // Patient query for main rows
  $sql = "select distinct p.clinicPatientID, p.patientID, p.fname, p.lname, p.sex, p.dobDd, p.dobMm, p.dobYy from patient p, $tblname t where p.patientID = t.pid and p.location_id in (select siteCode from clinicLookup where $orgunit = '$orgname')"; 
}

$sqlAdd = "";
if ($type != 'report-totalrow' && $olevel == 2) {
  $sqlAdd = " and (p.sex ";
  switch ($olevelval) {
    case "H":
    case "M":
      $sqlAdd .= "= 2)";
      break;
    case "F":
      $sqlAdd .= "= 1)";
      break;
    default:
      $sqlAdd .= "not in (1, 2) or p.sex is null)";
      break;
  }
} else if ($type != 'report-totalrow' && $olevel == 3) {
  $range = "";
  switch ($olevelval) {
    case "0-14":
      $range = " 0 and 14";
      break;
    case "15-20":
      $range = " 15 and 20";
      break;
    case "21-30":
      $range = " 21 and 30";
      break;
    case "31-40":
      $range = " 31 and 40";
      break;
    case "41-50":
      $range = " 41 and 50";
      break;
    case "51-60":
      $range = " 51 and 60";
      break;
    case "61-70":
      $range = " 61 and 70";
      break;
    case "71-80":
      $range = " 71 and 80";
      break;
    case "81-90":
      $range = " 81 and 90";
      break;
    case "91-100":
      $range = " 91 and 100";
      break;
    case "101-110":
      $range = " 101 and 110";
      break;
    default:
      $sqlAdd = " and case when isnumeric(p.dobYy) <> 1 then true when isnumeric(p.dobYy) = 1 and isnumeric(p.dobMm) <> 1 and ((isdate(dbo.ymdToDate(p.dobYy, '06', '15')) = 1 and datediff(year, dbo.ymdToDate(p.dobYy, '06', '15'), getdate()) not between 0 and 110) or isdate(dbo.ymdToDate(p.dobYy, '06', '15')) <> 1) then true when isnumeric(p.dobYy) = 1 and isnumeric(p.dobMm) = 1 and isnumeric(p.dobDd) <> 1 and ((isdate(dbo.ymdToDate(p.dobYy, p.dobMm, '15')) = 1 and datediff(year, dbo.ymdToDate(p.dobYy, p.dobMm, '15'), getdate()) not between 0 and 110) or isdate(dbo.ymdToDate(p.dobYy, p.dobMm, '15')) <> 1) then true when isnumeric(p.dobYy) = 1 and isnumeric(p.dobMm) = 1 and isnumeric(p.dobDd) = 1 and ((isdate(dbo.ymdToDate(p.dobYy, p.dobMm, p.dobDd)) = 1 and datediff(year, dbo.ymdToDate(p.dobYy, p.dobMm, p.dobDd), getdate()) not between 0 and 110) or isdate(dbo.ymdToDate(p.dobYy, p.dobMm, p.dobDd)) <> 1) then true else false end";
      break;
  }
  if (strlen (trim ($range)) > 0)
    $sqlAdd = " and case when isnumeric(p.dobYy) = 1 and isnumeric(p.dobMm) <> 1 and isdate(dbo.ymdToDate(p.dobYy, '06', '15')) = 1 and datediff(year, dbo.ymdToDate(p.dobYy, '06', '15'), getdate()) between $range then true when isnumeric(p.dobYy) = 1 and isnumeric(p.dobMm) = 1 and isnumeric(p.dobDd) <> 1 and isdate(dbo.ymdToDate(p.dobYy, p.dobMm, '15')) = 1 and datediff(year, dbo.ymdToDate(p.dobYy, p.dobMm, '15'), getdate()) between $range then true when isnumeric(p.dobYy) = 1 and isnumeric(p.dobMm) = 1 and isnumeric(p.dobDd) = 1 and isdate(dbo.ymdToDate(p.dobYy, p.dobMm, p.dobDd)) = 1 and datediff(year, dbo.ymdToDate(p.dobYy, p.dobMm, p.dobDd), getdate()) between $range then true else false end";
}
$sql .= $sqlAdd;

$resultArray = dbQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
//$data = json_encode($resultArray);
echo '
<table id="patientTable" class="table table-bordered table-hover table-striped table-condensed">
 <thead>
  <tr>
   <th>' . $clinicPatientID[$lang][1] . '</th><th>' . $reportFilteringLabels[$lang][25] . '</th><th>' . $reportFilteringLabels[$lang][26] . '</th><th>' . $reportFilteringLabels[$lang][27] . '</th><th>' . $reportFilteringLabels[$lang][28] . '</th>
  </tr>
 </thead>
 <tbody id="output">
';
for ($i = 0; $i < count($resultArray); $i++) {
  echo "<tr>";
  echo "<td><a href='patienttabs.php?lang=" .$lang. "&site=".substr($resultArray[$i]['patientID'], 0, 5)."&pid=" . $resultArray[$i]['patientID'] . "' target='mainWindow' onclick='javascript:window.blur()'>" . (strlen (trim ($resultArray[$i]['clinicPatientID'])) > 0 ? $resultArray[$i]['clinicPatientID'] : "N/A") . "</a></td>";
  echo "<td>" . $resultArray[$i]['fname'] . "</td>";
  echo "<td>" . $resultArray[$i]['lname'] . "</td>";
  echo "<td>";
  if ( $resultArray[$i]['sex'] == '1' ) {
    echo $reportFilteringLabels[$lang][21];
  } else if ($resultArray[$i]['sex'] == '2') {
    echo $reportFilteringLabels[$lang][22];
  } else {
    echo $reportFilteringLabels[$lang][24];
  }
  echo "</td>";
  if (strlen(trim($resultArray[$i]['dobDd'])) == 1)
    $resultArray[$i]['dobDd'] = "0" . trim($resultArray[$i]['dobDd']);
  if (strlen(trim($resultArray[$i]['dobMm'])) == 1)
      $resultArray[$i]['dobMm'] = "0" . trim($resultArray[$i]['dobMm']);
  echo "<td>" . ($lang == "fr" ? $resultArray[$i]['dobDd'] : $resultArray[$i]['dobMm']);
  echo "/" . ($resultArray[$i]['dobMm'] != '' ? ($lang == "fr" ? $resultArray[$i]['dobMm'] : $resultArray[$i]['dobDd']) : "");
  if ($resultArray[$i]['dobYy'] != '')
      echo "/" . $resultArray[$i]['dobYy'];
  echo "</td>";
  echo "</tr>";
}
echo '
 </tbody>
</table>
';
// Debug info
echo "<div " . (DEBUG_FLAG ? "" : "class=\"hidden\"") . ">$sql</div>";
?>
