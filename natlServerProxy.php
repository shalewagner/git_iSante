<?php
require_once 'backend.php'; 
$progress = false; 

if (isset($_REQUEST['progress']) && $_REQUEST['progress'] == "true") $progress = true;

if (empty ($_REQUEST['name']) || empty ($_REQUEST['pwd']) || empty ($_REQUEST['action'])) {
  echo "Required parameter missing!";
} else {
  switch ($_REQUEST['action']) {
    case "auth":
      // Configure URL for credential check
      $cred_url = "https://" . NATIONAL_IDENTIFIED_SERVER . "/error.php";
      // Make a quick query to see if the nat'l server is reachable
      // and see if login credentials are valid.
      $cred_handle = curl_init ();
      curl_setopt ($cred_handle, CURLOPT_URL, $cred_url);
      curl_setopt ($cred_handle, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt ($cred_handle, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt ($cred_handle, CURLOPT_HEADER, 1);
      curl_setopt ($cred_handle, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt ($cred_handle, CURLOPT_CONNECTTIMEOUT, 60);
      curl_setopt ($cred_handle, CURLOPT_TIMEOUT, 60);
      curl_setopt ($cred_handle, CURLOPT_USERPWD, $_REQUEST['name'] . ":" . $_REQUEST['pwd']);
      $res = curl_exec ($cred_handle);
      if (!empty ($res)) {
        if (stripos ($res, "http/1.1 401 authorization required") === 0) {
          echo "Login credentials invalid.";
    	  if ($progress) $pb->advance(2/3,'FAILED', "Login credentials invalid"); $pb=null;     
        } else if (stripos ($res, "http/1.1 404 not found") === 0) {
          echo "File not found.";
    	  if ($progress) $pb->advance(2/3,'FAILED', "Unable to test credentials, file not found."); $pb=null;
        } else if (!stripos ($res, "http/1.1 200 ok") === 0) {
          echo "Connection error: " . $res;   
    	  if ($progress) $pb->advance(2/3,'FAILED', "Connection error: " . $res); $pb=null;
        } else {
          curl_close ($cred_handle);
        }
      }
      break;
    case "search":
      if (empty ($_REQUEST['site']) || (empty ($_REQUEST['ST']) && empty ($_REQUEST['nationalId']) && empty ($_REQUEST['last']) && empty ($_REQUEST['first']))) {
        echo "Required parameter missing!";  
      } else {
        // Configure URL for nat'l search
        $search_url = "https://" . substr (NATIONAL_IDENTIFIED_SERVER, 0, strrpos (NATIONAL_IDENTIFIED_SERVER, "/")) . "/PatientSearchService/iSante/services/patients?debug=true&site=" . $_REQUEST['site'] . (!empty ($_REQUEST['ST']) ? "&ST=" . $_REQUEST['ST'] : "") . (!empty ($_REQUEST['nationalId']) ? "&nationalId=" . $_REQUEST['nationalId'] : "") . (!empty ($_REQUEST['last']) ? "&last=" . urlencode ($_REQUEST['last']) : "") . (!empty ($_REQUEST['first']) ? "&first=" . urlencode ($_REQUEST['first']) : "") . "&name=cirgSvcUser&pwd=cirg01itech10haiti";
        $search_handle = curl_init ();
        curl_setopt ($search_handle, CURLOPT_URL, $search_url);
        curl_setopt ($search_handle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($search_handle, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt ($search_handle, CURLOPT_HEADER, 0);
        curl_setopt ($search_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($search_handle, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt ($search_handle, CURLOPT_TIMEOUT, 60);
        curl_setopt ($search_handle, CURLOPT_SSLVERSION, 3);
        curl_setopt ($search_handle, CURLOPT_USERPWD, $_REQUEST['name'] . ":" . $_REQUEST['pwd']);
        $res = curl_exec ($search_handle);
        if (!empty ($res)) {
          header ("Content-type: text/xml");
          echo ($res);
          curl_close ($search_handle);
        } else {
          $err = curl_errno ($search_handle);
          echo "Error retrieving XML results: $err.";
        }
      }
      break;

    case "clinsum":
      if (empty ($_REQUEST['url'])) {
        echo "Required parameter missing!";  
      } else {
        // Configure URL for nat'l search
        $clinsum_url = $_REQUEST['url'];
        $clinsum_handle = curl_init ();
        curl_setopt ($clinsum_handle, CURLOPT_URL, $clinsum_url);
        curl_setopt ($clinsum_handle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($clinsum_handle, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt ($clinsum_handle, CURLOPT_HEADER, 0);
        curl_setopt ($clinsum_handle, CURLOPT_RETURNTRANSFER, 0);
        curl_setopt ($clinsum_handle, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt ($clinsum_handle, CURLOPT_TIMEOUT, 60);
        curl_setopt ($clinsum_handle, CURLOPT_SSLVERSION, 3);
        curl_setopt ($clinsum_handle, CURLOPT_USERPWD, $_REQUEST['name'] . ":" . $_REQUEST['pwd']);
        if (stripos($clinsum_url, "jrreport.php") !== false) {
          header ("Content-type: application/pdf");
  	  header('Content-disposition: attachment; filename="report.pdf"');
        } else {
          header ("Content-type: text/html");
  	  header('Content-disposition: attachment; filename="report.html"');
        }
        $res = curl_exec ($clinsum_handle);
        if (empty ($res)) {
          echo "Error retrieving PDF results.";
        }
      }
      break;

    case "xfer":
      if (empty ($_REQUEST['source']) || empty ($_REQUEST['target']) || empty ($_REQUEST['lang']) || empty ($_REQUEST['pid']) || empty ($_REQUEST['type'])) {
        echo "Required parameter missing!";
	    if ($progress) $pb->advance(2/5,'FAILED', "Required parameter missing!."); $pb=null;
      } else {
        // Configure URL for transfer file generation
        // Don't add to event log on the national server, do it locally next
        $xfer_url = "https://" . NATIONAL_IDENTIFIED_SERVER . "/genRecordsRequest.php?donotlog=1&source=" . $_REQUEST['source'] . "&target=" . $_REQUEST['target'] . "&lang=" . $_REQUEST['lang'] . "&pid=" . $_REQUEST['pid'] . (!empty ($_REQUEST['newpid']) ? "&newpid=" . $_REQUEST['newpid'] : "") . "&type=" . $_REQUEST['type'];

        // Event log addition for generation of clinical summary
        $argumentsArray = array (
          "report" => "214",
          "format" => "html",
          "siteName" => $_REQUEST['source'],
          "pid" => $_REQUEST['pid'],
          "lang" => $_REQUEST['lang'],
          "site" => $_REQUEST['source'],
          "transferTo" => $_REQUEST['target'],
          "source" => "natlServerProxy.php"
        );
        recordEvent ('jrReport', $argumentsArray);  
  
        if ($progress) {
          $script_end = (float) $sec + (float) $usec;
          $elapsed = round($script_end - $script_start, 5);
          $script_start = $script_end;
          $pb->advance(2/5,'Export', $msgArray[$_REQUEST['lang']][1] . " " . $elapsed . " seconds"); 
        }

        $xfer_handle = curl_init ();
        curl_setopt ($xfer_handle, CURLOPT_URL, $xfer_url);
        curl_setopt ($xfer_handle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($xfer_handle, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt ($xfer_handle, CURLOPT_HEADER, 0);
        curl_setopt ($xfer_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($xfer_handle, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt ($xfer_handle, CURLOPT_TIMEOUT, 60);
        curl_setopt ($xfer_handle, CURLOPT_SSLVERSION, 3);
        curl_setopt ($xfer_handle, CURLOPT_USERPWD, $_REQUEST['name'] . ":" . $_REQUEST['pwd']);
        $res = curl_exec ($xfer_handle);
        if (!empty ($res)) {
          mkdir (getPatientTransferDir () . "/incomingTransfers");
          $out_handle = fopen (getPatientTransferDir () . "/incomingTransfers/transfer_" . $_REQUEST['pid'] . "_" . $_REQUEST['source'] . "_" . $_REQUEST['target'] . ".tgz", "wb");
          fwrite ($out_handle, $res);
          fclose ($out_handle);
          curl_close ($xfer_handle); 
		  if ($progress) {
			$script_end = (float) $sec + (float) $usec;
			$elapsed = round($script_end - $script_start, 5);
			$script_start = $script_end;
			$pb->advance(3/5,'Import', $msgArray[$_REQUEST['lang']][2] . " " . $elapsed . " seconds"); 
		  } 
        } else {
          echo "Error retrieving transfer file."; 
	  	  if (progress) $pb->advance(2/3,'FAILED', "Error retrieving transfer file."); 
        }
      }
      break;
  }
}

?>
