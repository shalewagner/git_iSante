<?php
require_once 'backend.php';
require_once 'labels/labels.php';
$lang = !empty ($_REQUEST['lang']) ? $_REQUEST['lang'] : "fr";
$ts = !empty ($_REQUEST['ts']) ? $_REQUEST['ts'] : "";
$conn = !empty ($_REQUEST['conn']) ? $_REQUEST['conn'] : "";
$report = !empty ($_REQUEST['report']) ? $_REQUEST['report'] : "";
$username = !empty ($_REQUEST['username']) ? $_REQUEST['username'] : "";

$verifiedUsername = ereg_replace ('[^A-Za-z0-9]', '', getSessionUser());
if ($username != $verifiedUsername) {
  header("Location: error.php?type=auth&lang=$lang");
  exit;
} else {
  dbBeginTransaction ();
  dbLockTables (array('staticReportData'));
  $result = dbQuery ("
    SELECT connID
    FROM staticReportData
    WHERE reportNumber = '$report'
     AND username = '$verifiedUsername'
     AND connID = $conn
     AND runningSince = '$ts'");
  while ($row = psRowFetch ($result)) {
    if (!empty ($row[0]) && $conn == $row[0]) {
      // Make sure process still exists before killing it
      $result2 = dbQuery ("
        SHOW PROCESSLIST");
      while ($row2 = psRowFetch ($result2)) {
        if ($row2[0] == $row[0]) {
          $result2 = dbQuery ("
            KILL " . $row[0]);
          break;
        }
      }
    }
  }
  dbQuery ("
    UPDATE staticReportData
    SET runningSince = NULL
    WHERE reportNumber = $report
     AND username = '$verifiedUsername'");
  dbCommit ();
  dbUnlockTables ();
}

echo "
<html>
 <head>
  <title>" . $alreadyRunning[$lang][10] . "</title>
  <link href=\"default.css\" type=\"text/css\" rel=\"StyleSheet\">
 </head>
 <body>";

echo "<center>
   <h3>" . $alreadyRunning[$lang][12] . "</h3>
   <h4>" . $alreadyRunning[$lang][13] . "<br/>
   <a href=\"javascript:window.close()\">" . $alreadyRunning[$lang][11] . "</a></h4>";

echo"
 </center>
 </body>
</html>
";
?>
