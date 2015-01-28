<?php
require_once 'backendAddon.php';
require_once 'labels/report.php';

$reportType = $_POST['reportType'];
$lang = $_POST['lang'];
$indicator = $_POST['indicator'];
$timePeriod = $_POST['timePeriod'];
$year = $_POST['year'];
$period = $_POST['period'];

// Indicator query
$sql = "select addrSection, addrTown, COUNT( DISTINCT p.patientid ) AS  'caseCount'
  from dw_" . $reportType . "_patients m, clinicLookup c, patient p
  where indicator = '$indicator' and LEFT( m.patientid, 5 ) = c.sitecode and m.patientid = p.patientid
  and m.time_period = '$timePeriod' and m.year = '$year' and m.period = '$period'
  and addrSection != ''  
  group by 1, 2 order by 3 desc";

$resultArray = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
// TODO - switch to creating a JSON array of patients and then letting datatables
// parse and display it. Would be much faster/efficient. Use json_encode as below.
//$data = json_encode($resultArray);

// Output indicator table
?>
<table id="sectionTable" class="table table-bordered table-hover table-striped table-condensed">
  <thead>
    <tr>
      <th><?php echo $reportFilteringLabels[$lang][39] ?></th><th><?php echo $patientCount[$lang]?></th>
    </tr>
  </thead>
  <tbody>
<?php
// Create the table rows for patients results
for ($i = 0; $i < count($resultArray); $i++) {
  echo "<tr>";
  // Create link to view patient in new browser window
  echo "<td>" . $resultArray[$i]['addrSection'] . " - ";
  if ( $resultArray[$i]['addrTown'] != '') {
    echo $resultArray[$i]['addrTown'];
  } else {
    echo "<em>".$reportFilteringLabels[$lang][38]."</em>";
  }
  echo "</td>";
  echo "<td>" . $resultArray[$i]['caseCount'] . "</td>";
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
