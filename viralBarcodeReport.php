<?
	//include "backend.php";
function generateBarcode($qry, $start, $end, $site, $lang) {
	$resultArray = databaseSelect()->query($qry)->fetchAll();
	echo '
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title></title>
	<style type="text/css">
	body {
		margin:50px 50px 50px 50px;
	}
	checkbox {
		margin:5px 5px 5px 5px;
	}
	textarea {
		margin:5px 5px 5px 5px;
	}
	input {
		margin:5px 5px 5px 5px;
	}
	table, td, th { 
		border: 3px solid gray;
		text-align:center; 
		width: 1200px;
	}
	.sup {
		position: relative;
		bottom: 1ex;
		font-size: 50%;
	}
	</style>
	<script src="JsBarcode-master/dist/JsBarcode.all.js"></script>
	<script>
		Number.prototype.zeroPadding = function(){
			var ret = "" + this.valueOf();
			return ret.length == 1 ? "0" + ret : ret;
		};
	</script>
</head>
<body>
	Plage de dates : ' . $start . ' - ' . $end . '
	<table border="1">';
	$i = 0;
	echo '<tr>
			<th>NDM#</th>
			<th>Médecin traitant<br>Clinique</th> 
			<th>Commentaire<br>de Patient</th> 
			<th>DDN</th> 
			<th>Sexe</th> 
			<th>#Séjour</th>
			<th>Date de Prélevé</th>
			<th>Test ID</th>
		</tr>';
	foreach ($resultArray as $row) {
		$i++;
		echo ' 
		<tr>
			<td> ' . genBarcode($i,'mr', $row['patientid']) . '</td>
			<td> ' . genBarcode($i,'sc', $row['sitecode']) . '</td> 
			<td> ' . genBarcode($i,'st', $row['stcode']) . '</td> 
			<td> ' . $row['dob'] . '</td> 
			<td> ' . $row['sex'] . '</td> 
			<td> ' . genBarcode($i,'on', $row['orderNumber']) . ' </td>
			<td> ' . $row['orderDate'] . ' </td>
			<td> ' . $row['sampleCode'] . ' </td>
		</tr>';
	}
}
	function genBarcode ($i,$type,$value) {
			return '<img id="' . $type . $i . '"/>
			<script>JsBarcode("#' . $type . $i . '", "' . $value . '", {
				width:  2, height: 40, quite: 10, format: "CODE128", displayValue: true, fontOptions: "", 
				font:"monospace", textAlign:"left", fontSize: 14, backgroundColor:"", lineColor:"#000" 
				});
			</script>';
	}
?>
	<table>
</body>
</html>
