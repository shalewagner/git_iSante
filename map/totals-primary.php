<?
header('Content-Type: text/javascript; charset=UTF-8');
chdir('..'); 
$lang = 'fr';
require_once 'backend.php';
require_once 'labels/splash.php'; 
$sql = "select c.siteCode, case when c.dbSite != 0 then '" . $splashLabels[$lang]['sLocal'] . "' else '' end as 
'local', c.clinic, date(max(e.lastModified)) as lastModified, dbVersion, count(distinct e.patientid) as total, count(*) as totalForms 
from encValidAll e, clinicLookup c 
where e.siteCode = c.siteCode and lastModified > '2011-03-31' and (
   encounterType in (27,28,29,31) or 
   (encounterType in (24,25) and formVersion = 2) or 
   (encounterType = 26 and formVersion > 0)
) group by 1 order by lastModified desc, total desc";
$arr = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
$final = array();
$totalT = 0;
$totalF = 0;
foreach ($arr as $row) {
	// display the local APP_VERSION for the dbVersion if the defsite value matches; otherwise use clinicLookup table value 
	$row['dbVersion'] = ($row["siteCode"] == DEF_SITE) ? APP_VERSION : $row["dbVersion"]; 
	// tweak dbVersion if it uses the new numbering convention
	if (strpos($row['dbVersion'],'(') > 0) $row['dbVersion'] = substr($row['dbVersion'],0,5);
	$final[$row['siteCode']] = $row;  
	$totalT += intval($row['total']);
	$totalF += $row['totalForms'];
} 
$sql = "select e.siteCode, count(distinct patientid) as primAdult, count(*) as primAdultForms 
from encValidAll e, clinicLookup c where e.siteCode = c.siteCode and encounterType in (27,28) and lastModified > '2011-03-31' group by 1";
$brr = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
$primAdultT = 0;
$primAdultF = 0; 
foreach ($brr as $row) {
	$final[$row['siteCode']] = array_merge($final[$row['siteCode']], $row); 
	$primAdultT += $row['primAdult'];
	$primAdultF += $row['primAdultForms'];
} 
$sql = "select siteCode, count(distinct patientid) as primPed, count(*) as primPedForms from encValidAll where encounterType in (29,31) and lastModified > '2011-03-31' group by 1";
$crr = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
$primPedT = 0;
$primPedF = 0;
foreach ($crr as $row) {
	$final[$row['siteCode']] = array_merge($final[$row['siteCode']], $row);
	$primPedT += $row['primPed'];
	$primPedF += $row['primPedForms'];
}
$sql = "select siteCode, count(distinct patientid) as obgyn, count(*) as obgynForms from encValidAll where ((encounterType in (24,25) and formVersion = 2) or (encounterType = 26 and formVersion = 1)) and lastModified > '2011-03-31' group by 1"; 
$drr = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
$obgynT = 0;
$obgynF = 0; 
foreach ($drr as $row) {
	$final[$row['siteCode']] = array_merge($final[$row['siteCode']], $row); 
	$obgynT += $row['obgyn'];
	$obgynF += $row['obgynForms'];
}
$totals = array('clinic' => _('Totaux généraux'), 'local' => '-', 'dbVersion' => '-', 'lastModified' => '-', 'primAdult' => $primAdultT, 'primAdultForms' => $primAdultF, 'primPed' => $primPedT, 'primPedForms' => $primPedF, 'obgyn' => $obgynT, 'obgynForms' => $obgynF, 'total' => $totalT, 'totalForms' => $totalF); 
array_push($final, $totals);
$arr = array();
foreach ($final as $row) {
	$arr[] = $row;
}
$data = json_encode($arr);
echo '({"total":"' . $rows . '","results":' . $data . '})';  

