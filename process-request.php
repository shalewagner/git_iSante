<?php
// in ~isante
require_once 'backend.php';
$ccwd = getcwd();
chdir('./ldap');
require_once ('./include/app.php');
if ($_REQUEST['cmd'] == "getDatax") {
  header('Content-Type: text/plain'); //if this causes problems check with ew
  echo getDatax($accounts);
} else {
  saveDatax();
}

function getDatax($accounts) {
	$list = $accounts->find_all();
	sort($list);
	$dataString = generateUserArray($list);
	$response = "{ \"success\":true,\"totalCount\":".count($list).",\"rows\":".json_encode($dataString)." }";
	return $response;
}
function saveDatax() {
	doAccessSave($_POST['userName'], $_POST['debug'] ,$_POST['trans'] ,$_POST['serviceArea'] ,$_POST['priv'] ,
	$_POST['uiConfig'] ,$_POST['def'] ,$_POST['sites'] ,$_POST['pw'],$_POST['network']);
}
function generateUserArray ($list){
    $finalArray = array();
	$i = 0;
	$existingArray = array();
	// fetch all existing users in db 
	// stop getting lastLogin because it is REALLY slowing things down
    //$qry = "select u.username, u.privLevel, u.siteCode, u.debugFlag, u.uiConfiguration, max(e.lastModified) as lastLogin from userPrivilege u left join encounter e on u.username = e.lastmodifier group by u.username, u.privLevel, u.siteCode, u.debugFlag, u.uiConfiguration";
    $qry = "select u.username, u.privLevel, u.siteCode, u.debugFlag, u.uiConfiguration, '1970-01-01' as lastLogin from userPrivilege u group by u.username, u.privLevel, u.siteCode, u.debugFlag, u.uiConfiguration";
	$result = dbQuery($qry);
	while ($row = psRowFetch($result)) { 
		// fill existingArray with attributes fetched
		$existingArray[$row['username']] = array (
			'privLevel' => $row['privLevel'],
			'siteCode' => $row['siteCode'],
			'clinic' => $row['siteCode'],
			'debugFlag' => $row['debugFlag'],
			'uiConfiguration' => $row['uiConfiguration'],
			'lastLogin' => $row['lastLogin']
		);
	}
	// if user has provided a search qualification that will limit returns, limit to those
	$searchPhrase = "";
	if (isset($_POST['query'])) $searchPhrase = $_POST['query']; 
	// loop through all the LDAP entries, skipping a name or sitecode if it doesn't satisfy the searchPhrase
    foreach ($list as $account) {
		$rowArray = array();
		$username = htmlspecialchars($account->username);
		$username_url = urlencode($account->username);
		$name = htmlspecialchars($account->commonName);
		$fn = htmlspecialchars($account->givenname);
		$ln = htmlspecialchars($account->surname);
		$phone = $account->telephoneNumber;
		// apply attributes from the first query result to the current LDAP entry
        $institution =     (empty($existingArray[$username]['siteCode'])) ? "-" : $existingArray[$username]['siteCode'];
		$sitecode = 	   (empty($existingArray[$username]['siteCode'])) ? "-" :  $existingArray[$username]['siteCode'];
		if ($searchPhrase != "" && strpos($sitecode, $searchPhrase) === false && strpos($name, $searchPhrase) === false && strpos($username, $searchPhrase) === false) continue;
        $privLevel =       (empty($existingArray[$username]['privLevel'])) ? "0" : $existingArray[$username]['privLevel'];
        $uiConfiguration = (empty($existingArray[$username]['uiConfiguration'])) ? "0": $existingArray[$username]['uiConfiguration'];
        $debugFlag =       (empty($existingArray[$username]['debugFlag'])) ? "0": $existingArray[$username]['debugFlag']; 
        $lastLogin =       (isset($existingArray[$username]['lastLogin'])) ? substr($existingArray[$username]['lastLogin'],0,10) : "2001-01-01";
		$i++;
		$rowArray = array ("compID" => $i, "institution" => $institution, "sitecode" => $sitecode,"username"=> $username,"fn"=> $fn,"ln"=> $ln,"phone"=> $phone,"privLevel"=> $privLevel,"debugFlag"=> $debugFlag,"uiConfiguration"=> $uiConfiguration,"lastLogin"=> $lastLogin);
		array_push ($finalArray, $rowArray); 
    }
	return $finalArray;
}

function doAccessSave ($userName,$debug,$trans,$serviceArea,$priv,$uiConfig,$def,$sites,$pw,$network) {
	// Check for required fields
	$retVal = "failed";
	if (empty ($userName)) {
	  header ("Location: error.php?type=username&lang=$lang");
	}
	$debug = (isset($debug)) ? $debug : "0";
	$trans = (isset($trans)) ? $trans : "0";
	// first delete current entry for the user
	$qry = "delete from userPrivilege where username = '" . $userName . "'";
	dbQuery($qry);
	// set priv level, uiConfiguration, debug, etc. values
	$qry = "insert into userPrivilege (username, privLevel, allowTrans, uiConfiguration, debugFlag, serviceArea, network, sitecode) 
	                  values ('" . $userName . "'," . $priv . "," . $trans . "," . $uiConfig . "," . $debug . "," . $serviceArea . ",'" . $network . "'," . $def . ")";
	dbQuery($qry);
	if ($priv >= 2) {
		setLDAPAdmin($pw,$userName);
	}
	// delete current site entries for the user
	$qry = "delete from siteAccess where username = '" . $userName . "'";
	dbQuery($qry);
	// now add back checkboxed sites
	$scArray = explode(",",$sites);
	foreach ($scArray as $sc) {
	    if (!empty($sc)) {
	    	//do insert to siteAccess table
	    	$qry = "insert into siteAccess (username, siteCode) values ('" . $userName . "', '" . $sc . "')";
	    	dbQuery($qry);
	    	if (isset( $def) && $def == $sc) {
	    		// set default site
			setDefaultSite ($userName, $sc);
          	}
	    }
	}
}
?>
