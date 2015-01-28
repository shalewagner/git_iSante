<? 
header('Content-Type: text/javascript; charset=UTF-8');  
chdir('..');
require_once "backend.php";

if ( isset($_SERVER['HTTP_X_FORWARDED_HOST']) && NATIONAL_IDENTIFIED_SERVER === $_SERVER['HTTP_X_FORWARDED_HOST'] . '/consolidatedId/isante') define(SITE_TABLE, 'clinicLookup');
else define(SITE_TABLE, 'steveLookup');

if ($_SERVER['REQUEST_METHOD'] == 'GET') getSites();
else  updateSite();

function getSites(){
	if ($_GET['task'] == 'unload') { 
		$path = '/var/backups/itech/unloads/';
		$cmd = "/usr/bin/perl ./replication/readSource.pl --site " . $_GET['sitecode'] . " --file " . $path . $_GET['sitecode'] . ".csv.gz > " . $path . $_GET['sitecode'] . ".txt 2> " . $path . $_GET['sitecode'] . "errors.txt &";
		exec('/bin/bash -c "' . $cmd . '"');
		echo '{"success":"true","message":"Unloaded data for ' . $_GET['clinic'] . ' will be unloaded to ' . $path . '/' . $sitecode . '.csv.gz","data":"xxx"}';
	} else {
		$arr = array(); 
		$sql = "select case when incphr = 1 then ? else ? end as incphr, department, commune, clinic, category, type, dbsite, sitecode, ipAddress, network, dbVersion, lat, lng 
			from " . SITE_TABLE . " where department like ? and commune like ? and clinic like ? and sitecode like concat(?) and network like ?";
		if ($_GET['incphr'] == 'true') $sql .= ' and incphr = 1 '; 
		$sql .= 'order by 2,3,4'; 
		$arr = database()->query($sql,array('true', 'false', '%' . $_GET['department'] .'%', '%' . $_GET['commune'] .'%', '%' . $_GET['clinic'] . '%', '%' . $_GET['sitecode'] . '%', '%' . $_GET['network'] . '%'))->fetchAll();
		$data = json_encode($arr);  
		echo '({"total":"' . count($arr) . '","success":"true","data":' . $data . '})';  
	}
}
function updateSite() {  
	if ($_POST['task'] == 'update') { 
		if (isset($_POST['incphr'])) $_POST['incphr'] = 1;
		$qry = "UPDATE " . SITE_TABLE . " SET incphr = ?, department = ?, commune = ?, clinic = ?, category = ?, type = ?, dbsite = ?, network = ?, ipAddress = ?, lat = ?, lng = ? WHERE sitecode = ?"; 
		$rowCnt = database()->query($qry, array($_POST['incphr'], $_POST['department'], $_POST['commune'], $_POST['clinic'], $_POST['category'], $_POST['type'], $_POST['dbsite'], $_POST['network'], $_POST['ipAddress'],  $_POST['lat'], $_POST['lng'], $_POST['sitecode']))->rowCount();
		if ($rowCnt == 0) { 
			$mess = 'Le changement échoué pour ' . $_POST['clinic'];
			echo '{"success":"false","message":"' . $mess . '","data":"xxx"}';
		} else { 
			$mess = $_POST['clinic'] . ' a été changée.';
			echo '{"success":"true","message":"' . $mess . '","data":"xxx"}'; 
		}   
	} else {
		$qry = "SELECT count(*) as cnt from " . SITE_TABLE . " where sitecode = ?"; 
		$rowCnt = database()->query($qry, array($_POST['sitecode']))->fetchAll(); 
		// can't insert an existing sitecode
		if ($rowCnt[0]['cnt'] > 0) { 
			$mess = 'L’ajouter a échoué pour ' . $_POST['clinic'] . '--code de site ' . $_POST['sitecode'] . ' existe déjà. Veuillez faire une mise à jour.';
			echo '{"success":"false","message":"' . $mess . '","data":"xxx"}';
			exit;
		} 
		// we assume below that a clinic/sitecode getting added from scratch will automatically be an iSante site.
		$qry = "INSERT INTO " . SITE_TABLE . " (incphr, department, commune, clinic, category, type, sitecode, dbsite, network, ipAddress, lat, lng) VALUES (1,?,?,?,?,?,?,?,?,?,?,?)"; 
		$rowCnt = database()->query($qry, array($_POST['department'], $_POST['commune'], $_POST['clinic'], $_POST['category'], $_POST['type'], $_POST['sitecode'], $_POST['dbsite'], $_POST['network'], $_POST['ipAddress'], $_POST['lat'], $_POST['lng']))->rowCount();
		if ($rowCnt == 0) {
			$mess = 'L’ajouter a échoué pour ' . $_POST['clinic'];
			echo '{"success":"false","message":"' . $mess . '","data":"xxx"}';
		} else {
			$mess = $_POST['clinic'] . ' a été ajoutée.';
			echo '{"success":"true","message":"' . $mess . '","data":"xxx"}'; 
		}                           
	}
}
?>
