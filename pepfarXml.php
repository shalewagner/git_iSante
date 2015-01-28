<?php
header("Content-Type: text/xml");
header("Content-Disposition: inline; filename=MESI-Indicators-$site-$month-$year.xml");
echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
include ("backend.php");

// Set some vars
$site = !empty ($_GET['site']) ? $_GET['site'] : "";
$month = !empty ($_GET['month']) ? $_GET['month'] : "";
$year = !empty ($_GET['year']) ? $_GET['year'] : "";
// Lookup site name
$sql = "SELECT clinic as Institution FROM clinicLookup WHERE SiteCode = '" . $site . "'";
$result = dbQuery ($sql);
$row = psRowFetch ($result);
$sitename = (isset ($row['Institution']) && !empty ($row['Institution']) ? $row['Institution'] : "ERROR");

/* Get data
$sql = "SELECT
CASE WHEN col2 REGEXP '[a-z]. [0-9]' THEN SUBSTRING(col2, LOCATE('.', col2) + 2, LEN(col2)) ELSE NULL END AS col2,
CASE WHEN col3 REGEXP '[a-z]. [0-9]' THEN SUBSTRING(col3, LOCATE('.', col3) + 2, LEN(col3)) ELSE NULL END AS col3,
CASE WHEN col4 REGEXP '[a-z]. [0-9]' THEN SUBSTRING(col4, LOCATE('.', col4) + 2, LEN(col4)) ELSE NULL END AS col4
FROM pepfarRecords
ORDER BY id ASC";
*/
$sql = "select col2, col3, col4 from pepfarRecords order by id asc";
$result = dbQuery ($sql);

// Begin XML
echo "<!DOCTYPE site [
<!ELEMENT site (month)>
<!ELEMENT month (indicator+)>
<!ELEMENT indicator (#PCDATA)>
<!ATTLIST site name CDATA \"\">
<!ATTLIST site code CDATA \"\">
<!ATTLIST month name CDATA \"\">
<!ATTLIST month year CDATA \"\">
<!ATTLIST indicator id CDATA \"\">
]>
<site name=\"$sitename\" code=\"$site\">
 <month name=\"$month\" year=\"$year\">
";

// Store data values
$cnt = 1;
while ($row = psRowFetch ($result)) {
  $col2 = $row['col2'];
  $col3 = $row['col3'];
  $col4 = $row['col4'];
  $data[$cnt.'.1'] = (ereg("[a-z]. [0-9]",$col2)) ? substr($col2, strpos($col2,".") + 2, strlen ($col2)) : "";
  $data[$cnt.'.2'] = (ereg("[a-z]. [0-9]",$col3)) ? substr($col3, strpos($col3,".") + 2, strlen ($col3)) : "";
  $data[$cnt.'.3'] = (ereg("[a-z]. [0-9]",$col4)) ? substr($col4, strpos($col4,".") + 2, strlen ($col4)) : "";
  $cnt++;
}

// Map data values into indicator id array:                          Indicator #
$ind = array (-1,                                                         // 0

// Section #1 - HIV Care non-ART and ART - new enrollees
$data['10.1'], $data['10.2'], $data['10.3'],                              // 3
$data['11.1'], $data['11.2'], $data['11.3'],                              // 6
$data['12.1'], $data['12.2'], $data['12.3'],                              // 9
$data['10.1'] + $data['11.1'] + $data['12.1'],                            // 10
$data['10.2'] + $data['11.2'] + $data['12.2'],                            // 11
$data['10.3'] + $data['11.3'] + $data['12.3'],                            // 12
-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,   // 30
-1, -1, -1, -1, -1, -1,                                                   // 36
$data['13.1'] + $data['14.1'],                                            // 37
$data['13.2'] + $data['14.2'],                                            // 38
$data['13.3'] + $data['14.3'],                                            // 39
$data['17.3'],                                                            // 40

// Section #2 - ART Care - new and cumulative enrollees
$data['24.1'], $data['24.2'], $data['24.3'],                              // 43
$data['25.1'], $data['25.2'], $data['25.3'],                              // 46
$data['26.1'], $data['26.2'], $data['26.3'],                              // 49
$data['24.1'] + $data['25.1'] + $data['26.1'],                            // 50
$data['24.2'] + $data['25.2'] + $data['26.2'],                            // 51
$data['24.3'] + $data['25.3'] + $data['26.3'],                            // 52
-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,   // 70
-1, -1, -1, -1, -1, -1,                                                   // 76
$data['27.1'] + $data['28.1'],                                            // 77
$data['27.2'] + $data['28.2'],                                            // 78
$data['27.3'] + $data['28.3'],                                            // 79
$data['35.3'],                                                            // 80
-1, -1,                                                                   // 82

// Section #3 - Patients on ART - referred from other sites
$data['44.1'], $data['44.2'], $data['44.3'],                              // 85
$data['45.1'], $data['45.2'], $data['45.3'],                              // 88
$data['46.1'], $data['46.2'], $data['46.3'],                              // 91
$data['44.1'] + $data['45.1'] + $data['46.1'],                            // 92
$data['44.2'] + $data['45.2'] + $data['46.2'],                            // 93
$data['44.3'] + $data['45.3'] + $data['46.3'],                            // 94
-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,   // 112
-1, -1, -1, -1, -1, -1,                                                   // 118
$data['47.1'] + $data['48.1'],                                            // 119
$data['47.2'] + $data['48.2'],                                            // 120
$data['47.3'] + $data['48.3'],                                            // 121

// Section #4 - Patients on IHN prophylaxis (non-ART and ART)
$data['56.1'], $data['56.2'], $data['56.3'],                              // 124
$data['57.1'], $data['57.2'], $data['57.3'],                              // 127
$data['58.1'], $data['58.2'], $data['58.3'],                              // 130
$data['56.1'] + $data['57.1'] + $data['58.1'],                            // 131
$data['56.2'] + $data['57.2'] + $data['58.2'],                            // 132
$data['56.3'] + $data['57.3'] + $data['58.3'],                            // 133
-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,   // 151
-1, -1, -1, -1, -1, -1,                                                   // 157
$data['59.1'] + $data['60.1'],                                            // 158
$data['59.2'] + $data['60.2'],                                            // 159
$data['59.3'] + $data['60.3'],                                            // 160

// Section #5 - Patients on CTX prophylaxis (non-ART and ART)
$data['68.1'], $data['68.2'], $data['68.3'],                              // 163
$data['69.1'], $data['69.2'], $data['69.3'],                              // 166
$data['70.1'], $data['70.2'], $data['70.3'],                              // 169
$data['68.1'] + $data['69.1'] + $data['70.1'],                            // 170
$data['68.2'] + $data['69.2'] + $data['70.2'],                            // 171
$data['68.3'] + $data['69.3'] + $data['70.3'],                            // 172
-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,   // 190
-1, -1, -1, -1, -1, -1,                                                   // 196
$data['71.1'] + $data['72.1'],                                            // 197
$data['71.2'] + $data['72.2'],                                            // 198
$data['71.3'] + $data['72.3'],                                            // 199

// Section #6 - Patients on anti-TB treatment
$data['92.1'], $data['92.2'], $data['92.3'],                              // 202
$data['93.1'], $data['93.2'], $data['93.3'],                              // 205
$data['94.1'], $data['94.2'], $data['94.3'],                              // 208
$data['92.1'] + $data['93.1'] + $data['94.1'],                            // 209
$data['92.2'] + $data['93.2'] + $data['94.2'],                            // 210
$data['92.3'] + $data['93.3'] + $data['94.3'],                            // 211
-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,   // 229
-1, -1, -1, -1, -1, -1,                                                   // 235
$data['95.1'] + $data['96.1'],                                            // 236
$data['95.2'] + $data['96.2'],                                            // 237
$data['95.3'] + $data['96.3'],                                            // 238
-1, -1, -1, -1, -1,                                                       // 243

// Section #7 - Patients by regimen at end of month
$data['102.1'], $data['102.2'],                                           // 245
$data['103.1'], $data['103.2'],                                           // 247
$data['104.1'], $data['104.2'],                                           // 249
$data['105.1'], $data['105.2'],                                           // 251
-1, -1, -1, -1, -1, -1,                                                   // 257
$data['107.1'], $data['107.2'], $data['107.3'],                           // 260
$data['109.1'], $data['109.2'],                                           // 262
$data['110.1'], $data['110.2'],                                           // 264
$data['111.1'], $data['111.2'],                                           // 266
$data['112.1'], $data['112.2'],                                           // 268
$data['114.1'], $data['114.2'], $data['114.3'],                           // 271
$data['115.1'], $data['115.2'], $data['115.3'],                           // 274
$data['120.1'], $data['120.2'],                                           // 276
$data['121.1'], $data['121.2'],                                           // 278
-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,   // 296
-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,   // 314
-1, -1, -1, -1,                                                           // 318
$data['122.1'], $data['122.2'], $data['122.3'],                           // 321
$data['124.1'], $data['124.2'],                                           // 323
$data['125.1'], $data['125.2'],                                           // 325
$data['126.1'], $data['126.2'], $data['126.3'],                           // 328
$data['127.1'], $data['127.2'], $data['127.3'],                           // 331
$data['129.1'], $data['129.2'], $data['129.3'],                           // 334
-1, -1, -1, -1, -1, -1, -1, -1, -1,                                       // 343
$data['129.1'], $data['129.2'], $data['129.3'],                           // 346

// Section #8 - Non-active Patients
$data['133.1'], $data['133.2'], $data['133.3'],                           // 349
$data['134.1'], $data['134.2'], $data['134.3'],                           // 352
$data['135.1'], $data['135.2'], $data['135.3'],                           // 355
$data['136.1'], $data['136.2'], $data['136.3'],                           // 358
$data['137.1'], $data['137.2'], $data['137.3'],                           // 361
$data['33.3']                                                             // 362
);

// Loop over indicator id array and output to XML
foreach ($ind as $i => $v) {
  if ($v < 0) continue;
  echo "  <indicator id=\"$i\">" . $v . "</indicator>
";
}

// Close open tags
echo " </month>
</site>
";

?>
