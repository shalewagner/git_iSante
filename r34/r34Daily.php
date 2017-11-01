<?
function runR34($endOfPeriod) {
	$start0    = ' DATE(DATE_ADD(' . $endOfPeriod . ',INTERVAL -90 DAY)) ';
	$end0      = ' DATE(' . $endOfPeriod . ') ';
	$start90   = ' DATE(DATE_ADD(' . $endOfPeriod . ',INTERVAL -180 DAY)) ';
	$end90     = ' DATE(DATE_ADD(' . $endOfPeriod . ',INTERVAL -90 DAY)) ';
	$start180  = ' DATE(DATE_ADD(' . $endOfPeriod . ',INTERVAL -180 DAY)) ';
	$end180    = ' DATE(DATE_ADD(' . $endOfPeriod . ',INTERVAL -0 DAY)) ';	
	include "r34/query.php";

	$counter = 0;
	foreach($queryList as $fh => $qry) {
		if (is_array($qry)) {
			$dataArray = explode(",", $qry['data']);
			$result = database()->query($qry['query'], $dataArray)->fetchAll();
		}
		else {
			$result = database()->query($qry)->fetchAll();
		}
	    $counter++;
		if (is_array($result)) $x = count($result);
		else $x = $result;
		$qry = "SELECT ROW_COUNT() as foo";
		$x = database()->query($qry)->fetchAll();
	    echo date("h:i:sa",time()) . " : " . $counter . ":" . $fh . " " , $x[0]['foo'] . "\n";
	}
}
?>
