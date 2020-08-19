<? 
header('Content-Type: text/javascript; charset=UTF-8');  
require_once "backend.php"; 

switch ($_REQUEST['task']) {
	case 'save':
			$drugid = $_REQUEST['drugid'];
			$startDate = $_REQUEST['startDate'];
			$endDate  = $_REQUEST['endDate'];
			$siteCode    = $_REQUEST['siteCode'];
			$signature  = $_REQUEST['signature'];
		$sql = "insert into drugRupture (sitecode, drugID, startDate, endDate, signature, createDate, lastDate) values (?,?,?,?,?,now(),now())"; 
		
		$rc = database()->query($sql,array($siteCode,$drugid,$startDate,$endDate,$signature));			
		break;
		
	case 'update':
			$drugid = $_REQUEST['drugid'];
			$id = $_REQUEST['id'];
			$startDate = $_REQUEST['startDate'];
			$endDate  = $_REQUEST['endDate'];
			$signature  = $_REQUEST['signature'];
		$sql = "update drugRupture set drugID=?, startDate=?, endDate=?, signature=?, lastDate=now() where id=? "; 
		
		$rc = database()->query($sql,array($drugid,$startDate,$endDate,$signature,$id));			
		break;	

	case 'remove':
			$id = $_REQUEST['id'];
		$sql = "delete from drugRupture where id=? "; 
		
		$rc = database()->query($sql,array($id));			
		break;
		
	case 'load':
		$qry = "select t.id,t.drugID, t.startDate,t.endDate,d.drugLabel,t.signature from drugRupture t, drugLookup d where d.drugID=t.drugID order by startDate desc";
		$result = databaseSelect()->query($qry)->fetchAll(PDO::FETCH_ASSOC);
		$table="<div style=\" display:block;float:left;overflow:auto;height:400px; padding:20px 20px;\"><table class=\"gridtable\" cellspacing=\"0\" cellpadding=\"0\"><thead><tr>
			<th>Date Debut</th>
			<th>Date fin</th>
			<th>Medicament</th>
			<th>User</th>
			<th>Action</th></tr></thead><tbody>";
		foreach($result as $row) {
		$table.="<tr>
			<td>".$row['startDate']."</td>
			<td>".$row['endDate']."</td>
			<td>".$row['drugLabel']."</td>
			<td>".$row['signature']."</td>
			<td><a href=\"./drugRupture.php?id=".$row['id']."&drugid=".$row['drugID']."&startDate=".$row['startDate']."&endDate=".$row['endDate']."&signature=".$row['signature']." \">Modifier</a></td></tr>";
	}
	$table.="</tbody></table></div>";
		print_r($table);
} 
?>  
