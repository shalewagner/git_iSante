<?php
require_once 'backendAddon.php';
require_once 'labels/report.php';

$reportType = $_POST['reportType'];
$lang = $_POST['lang'];
$type = $_POST['type']; // To determine whether main or subrow. FIXME - looks at class
$sitecode = $_POST['sitecode'];
$display = $_POST['display']; 
if ($display == 'Commune') $dispWhere = "concat(c.department,'-',c.commune)";
else $dispWhere = 'c.' . $display;
$displayUnit = $_POST['displayUnit'];
$indicator = $_POST['indicator'];
$indicator2 = $_POST['indicator2'];
$timePeriod = $_POST['timePeriod'];
$year = $_POST['year'];
$period = $_POST['period'];
$gender = $_POST['gender'];
$limitGender = "";
if ($gender != "") {
  $limitGender = "and sex ='$gender'";
}
// Add'l query details needed for complement query. Denom is main indicator,
// Num is used for comp exclusion

$sql = "select p.location_id, m.patientid, p.nationalid, fname, lname, sex, dobDd, dobMm, dobYy, concat('District: ', addrDistrict, ' Section: ', addrSection, ' Town: ', addrTown) as location, max(concat(e.nxtVisitYy,'/',e.nxtVisitMm,'/',e.nxtVisitDd)) as nxtVisit from encounter e, patient p, dw_" . $reportType . "_patients m";
if ( $type == 'report-subrow') {
  // Patient query for subrows
  if ($display == 'SiteCode') {
    $sql .= " where e.patientid = p.patientid and p.patientid = m.patientid and m.indicator = '$indicator' and m.time_period = '$timePeriod' and m.year = '$year' and m.period = '$period' and p.location_id = '$sitecode' $limitGender"; 
    if ($indicator2 != "") {
      $sql .= " and m.patientid not in (select patientid from dw_". $reportType ."_patients where indicator = '$indicator2' and time_period = '$timePeriod' and year = '$year' and period = '$period' and left(patientid, 5) = '$sitecode' $limitGender)";
    }
  } else {
    $sql .= ", clinicLookup c where e.patientid = p.patientid and p.patientid = m.patientid and m.indicator = '$indicator' and m.time_period = '$timePeriod' and m.year = '$year' and m.period = '$period' and p.location_id = c.siteCode and $dispWhere = '$displayUnit' $limitGender";
    if ($indicator2 != "") {
      $sql .= " and m.patientid not in (select patientid from dw_".$reportType."_patients where indicator = '$indicator2' and time_period = '$timePeriod' and year = '$year' and period = '$period' and left(patientid, 5) = c.siteCode and $dispWhere = '$displayUnit' $limitGender)";
    }
  }
} else {
  // Patient query for main rows
  $sql .= " where e.patientid = p.patientid and p.patientid = m.patientid and m.indicator = '$indicator' and m.time_period = '$timePeriod' and m.year = '$year' and m.period = '$period' $limitGender"; 
  if ($indicator2 != "") {
    $sql .= " and m.patientid not in (select patientid from dw_".$reportType."_patients where indicator = '$indicator2' and time_period = '$timePeriod' and year = '$year' and period = '$period' $limitGender)";
  }
} 
$sql .= " group by 2";
$resultArray = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
// TODO - switch to creating a JSON array of patients and then letting datatables
// parse and display it. Would be much faster/efficient. Use json_encode as below.
//$data = json_encode($resultArray);

// Count of patients - used to update display in modal
echo "<div id='patientRowCount' count='" . count($resultArray) ."' style='display: none'></div>";

// Output the table of patients
?>
<table id="patientTable" class="table table-bordered table-hover table-striped table-condensed">
  <thead>
    <tr>
      <th><?php echo $nationalID[$lang][1]?></th><th><?php echo $reportFilteringLabels[$lang][25]?></th><th><?php echo $reportFilteringLabels[$lang][26]?></th><th><?php echo $reportFilteringLabels[$lang][27]?></th><th><?php echo $reportFilteringLabels[$lang][28]?></th><th><?=$reportFilteringLabels[$lang][56]?></th><th>Location</th>
    </tr>
  </thead>
  <tbody>
<?php
// Create the table rows for patients results
for ($i = 0; $i < count($resultArray); $i++) {
  echo "<tr>";
  // Create link to view patient in new browser window
  echo "<td><a href='patienttabs.php?lang=" .$lang. "&site=".$resultArray[$i]['location_id']."&pid=" . $resultArray[$i]['patientid'] . "' target='_blank'>";
  // Display nationalID if present, otherwise Null
  if ($resultArray[$i]['nationalid'] == (Null || '')) {
    echo "Null";
  } else {
    echo $resultArray[$i]['nationalid'];
  }
  echo "</a></td>";
  echo "<td>" . $resultArray[$i]['fname'] . "</td>";
  echo "<td>" . $resultArray[$i]['lname'] . "</td>";
  echo "<td>";
  if ( $resultArray[$i]['sex'] == '1' ) {
    echo $reportFilteringLabels[$lang][21];
  } else {
    echo $reportFilteringLabels[$lang][22];
  }
  echo "</td>";
  if (strlen(trim($resultArray[$i]['dobDd'])) == 1)
    $resultArray[$i]['dobDd'] = "0" . trim($resultArray[$i]['dobDd']);
  if (strlen(trim($resultArray[$i]['dobMm'])) == 1)
      $resultArray[$i]['dobMm'] = "0" . trim($resultArray[$i]['dobMm']);
  echo "<td>";
  if ($resultArray[$i]['dobDd'] == '') {
    echo 'XX';
  } else {
    echo $resultArray[$i]['dobDd'];
  }
  echo '/';
  if ($resultArray[$i]['dobMm'] == '') {
    echo 'XX';
  } else {
    echo $resultArray[$i]['dobMm'];
  }
  echo '/';
  if ($resultArray[$i]['dobYy'] == '') {
    echo 'XXXX';
  } else {
    echo $resultArray[$i]['dobYy'];
  }
  echo "</td>";
  $nxtVisit = explode('/', $resultArray[$i]['nxtVisit']);
  if ($nxtVisit[0] == '') echo  "<td>&nbsp;</td>";
  else echo "<td>" . $nxtVisit[2] . '/' . $nxtVisit[1] . '/20' . $nxtVisit[0] . "</td>";
  $location = $resultArray[$i]['location'];
  if ($location == '') echo  "<td>&nbsp;</td>";
  else echo "<td>" . $location . "</td>";   
  echo "</tr>";
}
?>
  </tbody>
</table>

<div class="hidden">
<?php  // Debug info
echo $sql;
?>
</div>
