<?php 

require_once 'backend/materializedViews.php';

if (empty($_POST)) {
    // We only accept POSTs
    header('HTTP/1.0 403 Forbidden');
    exit;
} else {
    // Handle a POST
    $fingerprintData =  $_POST['upload'];
    $fileName =  $_POST['filename'];
    if ($fingerprintData == '') {
        echo 'No data was uploaded';
    } else {
        
        // write to the appropriate file
        $myFile = "/var/backups/itech/fpDuplicateLogs/".basename(str_replace('\\','/',$fileName));
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $fingerprintData);
        fclose($fh);
        
        // start the merging script
        mergeFingerprintData(basename(str_replace('\\','/',$fileName)));
        
        // feedback for cURL
        echo $fileName; // should be that exact value for the windeows side curl script to acknowledge the feedback
    }
}

?>