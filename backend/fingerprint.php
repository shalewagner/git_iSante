<?php
require_once 'backend/config.php'; 

function newFingerprintSoapClient() { 
	$currentErrorLevel = error_reporting();
	error_reporting($currentErrorLevel ^ E_WARNING); 
	/* If the host portion of the URL cannot be resolved, the call will hang regardless of the connection and function timeout parameters below
	   Conversely, if the host portion IS resolvable, but, for instance, the IIS server is down, the appropriate EXCEPTION will occur
	 */
	$url = getConfig('fingerprintURL');
	if (doesHostExist($url) == false) return null;
	$objSOAPClient = new SoapClientTimeout($url); 
	$headers = new SoapHeader("Msxml2.DomDocument.3.0", "MSSOAP.SoapClient", array("ServerHTTPRequest" => true));
	$objSOAPClient->__setSoapHeaders(array($headers));
	/* one second to connect (setConnectTimeout)
	 * four seconds to process (setTimeout) 
	 */
	$objSOAPClient->__setConnectTimeout(1);
	$objSOAPClient->__setTimeout(4);
	error_reporting($currentErrorLevel); 
	return $objSOAPClient;  
}

/* returns an array containing two elements
 * first element is the fingerprint server version string or null if one could not be obtained
 * second element is a localized error message if the first element is null or null 
 */
function getFingerprintServerStatus() {
	if (is_null(getConfig('fingerprintURL'))) {
		return array(null, _('en:Fingerprint URL NOT DEFINED'));
	}
	try {
		$objSOAPClient = newFingerprintSoapClient();
		if ($objSOAPClient == null) return array(null, _("Serveur d'empreintes digitales ne fonctionne pas ou n'est pas accessible"));
		$id = $objSOAPClient->__call("GetInfo", array(array()));
		return array($id->GetInfoResult, null);
	} catch (SoapFault $fault) {
		return array(null, _('error: ' . $fault));
	} 
}


/* takes a left or right single fingerprint and returns patientid if patient is in the local fingerprint database
 * changed for 9.0 RC3 to factor in national fingerprinting...
 * initially, patientID = masterPid. After patient visits multiple clinics, masterPid = first ever patientid and this is recorded in local fingerprint databases
 * as a result, it is necessary to convert masterPid to patientID here via via a query against the local patient table 
 */
function getFingerprintPid($leftbiodata) {
	try {
		$objSOAPClient = newFingerprintSoapClient();
		if ($objSOAPClient == null) return "-1"; 
		$id = $objSOAPClient->__call("IdentifyQuick", array(array ( 
			'FingerData' => $leftbiodata,
			'DataSize' => strlen($leftbiodata),
			'DataValue' => 1,
			'LocationID' => 1
		)));
		if ($id->IdentifyQuickResult == "-1") return "-1";
		else {
			// convert masterPid to patientID
			$arr = database()->query("select patientID from patient where masterPid = ? and patStatus <> 1", array($id->IdentifyQuickResult))->fetchAll(PDO::FETCH_ASSOC);
			return $arr[0]['patientID'];
		}
	} catch (SoapFault $fault) {
		return "-1";
	}
}

/* takes left and right fingerprints paired with which fingers they are (Type) plus the patientid printed 
 * returns pid on success (even if the patient has already registered prints under another pid) and -1 if failure
 */    
function registerFingerprints($Leftbiodata, $LeftbiodataType, $Rightbiodata, $RightbiodataType, $id){ 
    // first check to make sure fingerprint isn't already registered
    $anotherPid = getFingerprintPid($Leftbiodata);
    if ($anotherPid != "-1") return $anotherPid;
    else {
	try { 
		$objSOAPClient = newFingerprintSoapClient(); 
		if ($objSOAPClient == null) return "-1";
		$xml = $objSOAPClient->__call("Register", array(array (
			'LeftFingerData' => $Leftbiodata, 
			'LeftFingerType' => $LeftbiodataType, 
			'RightFingerData' => $Rightbiodata, 
			'RightFingerType' => $RightbiodataType, 
			'ID' => $id,
			'LocationID' => 1
		)));
		if ($xml->RegisterResult == 0){ 
			return $id; 
		}
		else return "-1";
	} catch (SoapFault $fault) {
		return "-1";
	}
    }
}

/* takes a patientid and deletes that patient's fingerprints
 */
function deleteFingerprints($pid){ 
	try {
		$objSOAPClient = newFingerprintSoapClient();
		if ($objSOAPClient == null) return "-1";  
		$xml = $objSOAPClient->__call("DeleteID", array(array ('ID' => $pid)));
		if ($xml->DeleteIDResult == 0) return $pid;
		else return "-1";
	} catch (SoapFault $fault) {
		return "-1";
	}
}

/* takes an old ID and new ID and returns true/false based on whether ID is changed or not
 * the ChangeIDResult returns '-1' on fail and '0' on success
 */
function changeFingerprintID ($old, $pid) {
	try {
		$objSOAPClient = newFingerprintSoapClient();
		if ($objSOAPClient == null) return false;
		$id = $objSOAPClient->__call('ChangeID', array(array('Old_ID' => $old, 'New_ID' => $pid)));
		if ($id->ChangeIDResult == '-1') return false;
		else return true; 
	} catch (SoapFault $fault) {
		return false;
	} catch (Exception $e) {
		return false;
	} 
}

/* takes a patientid and returns true/false based on whether that id is already printed
 * the IsRegisteredResult returns -1 on fail and a two-digit value corresponding to the fp scans on file 
 * 1 is thumb, 2 is index finger, 3 is middle, 4 is ring, 5 is pinky (i.e. 33 indicates the two middle fingers)
 * asof July 2013 correct -1 return result looks like this:
 *           <string xmlns="http://tempuri.org/">-1</string>
 * but it can return this if the configuration is set up incorrectly:
 *           <string xmlns="http://tempuri.org/">INVALID_ENGINE</string>
 */
function hasFingerprints($pid) {
	try {
		$objSOAPClient = newFingerprintSoapClient();
		if ($objSOAPClient == null) return false;
		$id = $objSOAPClient->__call('IsRegistered', array(array('ID' => $pid)));
		$curVal = $id->IsRegisteredResult;
		if ($curVal > 10 && $curVal < 56) return true; 
		else return false; 
	} catch (SoapFault $fault) {
		return false;
	} catch (Exception $e) {
		return false;
	} 
}  

/* takes a patientid and returns the actual fingerprint templates in an array
 * 
 */
function getPrints($pid) { 
	$prints = array();
	try {
		$objSOAPClient = newFingerprintSoapClient();
		if ($objSOAPClient == null) return false;
		$id = $objSOAPClient->__call('RetrieveRightTemplateData', array(array('registrationID' => $pid)));
		$curVal = $id->RetrieveRightTemplateDataResult;
		if ($curVal != '') $prints[] = $curVal; 
		else return -1; 
		$id = $objSOAPClient->__call('RetrieveLeftTemplateData', array(array('registrationID' => $pid)));
		$curVal = $id->RetrieveLeftTemplateDataResult;
		if ($curVal != '') $prints[] = $curVal; 
		else return -1;    
	} catch (SoapFault $fault) {
		return false;
	} catch (Exception $e) {
		return false;
	}   
	return ($prints);
}

/*** extension to avoid excessive timeout
 *** see <http://www.darqbyte.com/2009/10/21/timing-out-php-soap-calls/>
 ***/
class SoapClientTimeout extends SoapClient { 
	private $connectTimeout;
	private $timeout;
	public function __setTimeout($timeout){
		if (!is_int($timeout) && !is_null($timeout)){
			throw new Exception("Invalid timeout value");
		} 
		$this->timeout = $timeout;
	}

	public function __setConnectTimeout($connectTimeout){
		if (!is_int($connectTimeout) && !is_null($connectTimeout)){
			throw new Exception("Invalid connection timeout value");
		} 
		$this->connectTimeout = $connectTimeout;
	}
	 
	public function __doRequest($request, $location, $action, $version, $one_way = FALSE){
		if (!$this->timeout){
			// Call via parent because we require no timeout
			$response = parent::__doRequest($request, $location, $action, $version, $one_way);
		} else {
			// Call via Curl and use the timeout
			$curl = curl_init($location);
			curl_setopt($curl, CURLOPT_VERBOSE, FALSE);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($curl, CURLOPT_POST, TRUE);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
			curl_setopt($curl, CURLOPT_HEADER, FALSE);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: text/xml", "SOAPAction: {$action}")); 
			/* the timeout values cannot be less than 1 second, even though it would be desirable for at least the connection timeout to be less. 
			   See the discussion on these timeout parameters here: <http://www.php.net/manual/en/function.curl-setopt.php> 
			 */
			curl_setopt ($curl, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
			curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
			curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 0);
			$response = curl_exec($curl); 
			if (curl_errno($curl)){ 
				throw new SoapFault("1", curl_error($curl));
				throw new Exception();
			} 
			curl_close($curl);
		} 
		// Return?
		if (!$one_way){
			return ($response);
		}
	}
}   

function doesHostExist ($url) {
//	$host = parse_url($url, PHP_URL_HOST); 
	//echo "host is returned as :" . $host;
//	$ip = getHostByName($host);  
	//echo "ip is returned as :" . $ip;
//	if ($host == "" || $ip == "") return false;
//	if (!ip2long($ip) || gethostbyaddr($ip) == false || preg_match("/.*\.[a-zA-Z]{2,3}$/",$host) == false || ($ip == gethostbyaddr($ip) && preg_match("/.*\.[a-zA-Z]{2,3}$/",$host) === 0)) {
//		return false;
//	} else { 
		return true;
//	}
}

?>
