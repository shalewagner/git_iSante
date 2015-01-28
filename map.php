<?php
$mssql_access = mssql_connect ("cloud", "demo", "demoSteve") or die ("FATAL ERROR: Unable to connect to the database");
mssql_select_db ("lescayes", $mssql_access) or die ("FATAL ERROR: Unable to select database.");
//error_reporting (E_ALL | E_STRICT);
error_reporting (8183);
$myFile = getTempFileName('haiti8', 'kml');
$header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<kml xmlns=\"http://www.google.com/earth/kml/2.2\">
	<Document>
	<name>Haiti Clinic Sites</name>
	<Style id=\"sn_blue-pushpin\">
		<IconStyle><scale>1.1</scale>
			<Icon><href>http://maps.google.com/mapfiles/kml/pushpin/blue-pushpin.png</href></Icon>
			<hotSpot x=\"20\" y=\"2\" xunits=\"pixels\" yunits=\"pixels\"/>
		</IconStyle>
		<LabelStyle><color>ff1f1fff</color></LabelStyle>
		<ListStyle/>
	</Style>
	<StyleMap id=\"msn_blue-pushpin\">
		<Pair>
			<key>normal</key>
			<styleUrl>#sn_blue-pushpin</styleUrl>
		</Pair>
		<Pair>
			<key>highlight</key>
			<styleUrl>#sh_blue-pushpin</styleUrl>
		</Pair>
	</StyleMap>
	<Style id=\"sh_blue-pushpin\">
		<IconStyle>
			<scale>1.3</scale>
			<Icon>
				<href>http://maps.google.com/mapfiles/kml/pushpin/blue-pushpin.png</href>
			</Icon>
			<hotSpot x=\"20\" y=\"2\" xunits=\"pixels\" yunits=\"pixels\"/>
		</IconStyle>
		<LabelStyle>
			<color>ff1f1fff</color>
			<scale>1.1</scale>
		</LabelStyle>
		<ListStyle>
		</ListStyle>
	</Style>
	<Style id=\"sn_grn-pushpin\">
		<IconStyle>
			<scale>1.1</scale>
			<Icon>
				<href>http://maps.google.com/mapfiles/kml/pushpin/grn-pushpin.png</href>
			</Icon>
			<hotSpot x=\"20\" y=\"2\" xunits=\"pixels\" yunits=\"pixels\"/>
		</IconStyle>
		<ListStyle>
		</ListStyle>
	</Style>
	<StyleMap id=\"msn_grn-pushpin\">
		<Pair>
			<key>normal</key>
			<styleUrl>#sn_grn-pushpin</styleUrl>
		</Pair>
		<Pair>
			<key>highlight</key>
			<styleUrl>#sh_grn-pushpin</styleUrl>
		</Pair>
	</StyleMap>
	<Style id=\"sh_grn-pushpin\">
		<IconStyle>
			<scale>1.3</scale>
			<Icon>
				<href>http://maps.google.com/mapfiles/kml/pushpin/grn-pushpin.png</href>
			</Icon>
			<hotSpot x=\"20\" y=\"2\" xunits=\"pixels\" yunits=\"pixels\"/>
		</IconStyle>
		<LabelStyle>
			<scale>1.1</scale>
		</LabelStyle>
		<ListStyle>
		</ListStyle>
	</Style>";
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh,utf8_encode( $header));
generateMapPage ("fr", $fh);
fwrite($fh,utf8_encode( "</Document>
</kml>"));
fclose($fh);
function generateMapPage ($lang, $fh) {
	$statusLabels = array ( 
	"en" => array ("New", "Active", "At risk", "Inactive", "Disc", "Totals"),
	"fr" => array ("Nouveaux", "Actifs", "Risque", "Inactifs", "Disc", "Totaux"),
	);
	$statusArray = array();
	// index is patientStatus, associative value is column in final report
	$statusMap = array (1 => 9, 2 => 5, 3 => 0, 4 => 7 , 5 => 2,  6 => 6,  7 => 1, 8 => 8,  9 => 4, 10 => 3);
	$qry = "select rtrim(c.sitecode) as sitecode, patientStatus, count(*)
		from v_patients p, clinicLookup c
		where rtrim(p.sitecode) = rtrim(c.sitecode) and encounterType in (10,15) and
		patientStatus between 1 and 10
		group by rtrim(c.sitecode), patientStatus";
	$result = dbQuery($qry);
	while ($row = psRowFetch ($result)) {
		if (!array_key_exists($row[0], $statusArray))
			$statusArray[$row[0]] = array(0,0,0,0,0,0,0,0,0,0);
		$statusArray[$row[0]][$statusMap[$row['patientStatus']]] = $row[2];
	}
	$qry2 = "select clinic,
		rtrim(e.sitecode) as sitecode, c.dbSite, dbVersion, c.lat, c.lng, commune,
		max(lastmodified) as 'maxDate'
		from encvalid e, clinicLookup c
		where rtrim(e.sitecode) = rtrim(c.sitecode) and e.sitecode != '00000'";
	$qry2 .= " group by clinic,rtrim(e.sitecode), c.dbSite, dbVersion, c.lat, c.lng, commune order by 5 desc";
 	$result = dbQuery($qry2);
	// format row results
	while ($row = psRowFetch($result)) {
		fwrite($fh,utf8_encode("<Placemark>
			<name>" . $row["clinic"] . " (" . dateToMySQL(substr($row["maxDate"],0,11)) . ")</name>
			<address>" . $row["commune"] . "</address>"));
			if ($row["dbSite"] > 0) fwrite($fh,utf8_encode("<styleUrl>#msn_blue-pushpin</styleUrl>"));
			else fwrite($fh,utf8_encode("<styleUrl>#msn_grn-pushpin</styleUrl>"));
		fwrite($fh,utf8_encode("<description><![CDATA[<table border=\"1\"><tr><th>Status</th><th>Soins palliatifs</th><th>Sous TAR</th></tr>"));
		for ($k = 0; $k < 5; $k++)
			fwrite($fh,utf8_encode("<tr><td>" . $statusLabels[$lang][$k] . "</td><td align=\"right\">" . $statusArray[$row[1]][$k] . "</td><td align=\"right\">" . $statusArray[$row[1]][$k+5] . "</td></tr>"));
		$t1 = $statusArray[$row[1]][0]+$statusArray[$row[1]][1]+$statusArray[$row[1]][2]+$statusArray[$row[1]][3]+$statusArray[$row[1]][4];
		$t2 = $statusArray[$row[1]][5]+$statusArray[$row[1]][6]+$statusArray[$row[1]][7]+$statusArray[$row[1]][8]+$statusArray[$row[1]][9];
		fwrite($fh,utf8_encode(  "<tr><td>" . $statusLabels[$lang][5] . "</td><td align=\"right\">" . $t1 . "</td><td align=\"right\">" . $t2 . "</td></tr>
		</table>]]></description>
				<Point>
					<coordinates>" . $row["lng"] . "," . $row["lat"] . "</coordinates>
				</Point>
		</Placemark>"));
	}
}
/*
// Selects all the rows in the markers table.
$query = 'SELECT *, clinic as name, sitecode as id, department as address, commune as description FROM clinicLookup WHERE 1';
$result = dbQuery($query);

// Creates the Document.
$dom = new DOMDocument('1.0', 'UTF-8');

// Creates the root KML element and appends it to the root document.
$node = $dom->createElementNS('http://earth.google.com/kml/2.1', 'kml');
$parNode = $dom->appendChild($node);

// Creates a KML Document element and append it to the KML element.
$dnode = $dom->createElement('Document');
$docNode = $parNode->appendChild($dnode);

// Creates the two Style elements, one for restaurant and one for bar, and append the elements to the Document element.
$restStyleNode = $dom->createElement('Style');
$restStyleNode->setAttribute('id', 'restaurantStyle');
$restIconstyleNode = $dom->createElement('IconStyle');
$restIconstyleNode->setAttribute('id', 'restaurantIcon');
$restIconNode = $dom->createElement('Icon');
$restHref = $dom->createElement('href', 'http://maps.google.com/mapfiles/kml/pal2/icon63.png');
$restIconNode->appendChild($restHref);
$restIconstyleNode->appendChild($restIconNode);
$restStyleNode->appendChild($restIconstyleNode);
$docNode->appendChild($restStyleNode);

$barStyleNode = $dom->createElement('Style');
$barStyleNode->setAttribute('id', 'barStyle');
$barIconstyleNode = $dom->createElement('IconStyle');
$barIconstyleNode->setAttribute('id', 'barIcon');
$barIconNode = $dom->createElement('Icon');
$barHref = $dom->createElement('href', 'http://maps.google.com/mapfiles/kml/pal2/icon27.png');
$barIconNode->appendChild($barHref);
$barIconstyleNode->appendChild($barIconNode);
$barStyleNode->appendChild($barIconstyleNode);
$docNode->appendChild($barStyleNode);

// Iterates through the mssql results, creating one Placemark for each row.
while ($row = @psRowFetchAssoc($result))
{
  // Creates a Placemark and append it to the Document.

  $node = $dom->createElement('Placemark');
  $placeNode = $docNode->appendChild($node);

  // Creates an id attribute and assign it the value of id column.
  $placeNode->setAttribute('id', 'placemark' . $row['id']);

  // Create name, and description elements and assigns them the values of the name and address columns from the results.
  $nameNode = $dom->createElement('name',htmlentities($row['name']));
  $placeNode->appendChild($nameNode);
  $descNode = $dom->createElement('description', $row['address']);
  $placeNode->appendChild($descNode);
  $styleUrl = $dom->createElement('styleUrl', '#' . $row['type'] . 'Style');
  $placeNode->appendChild($styleUrl);

  // Creates a Point element.
  $pointNode = $dom->createElement('Point');
  $placeNode->appendChild($pointNode);

  // Creates a coordinates element and gives it the value of the lng and lat columns from the results.
  $coorStr = $row['lng'] . ','  . $row['lat'];
  $coorNode = $dom->createElement('coordinates', $coorStr);
  $pointNode->appendChild($coorNode);
}

$kmlOutput = $dom->saveXML();
header('Content-type: application/vnd.google-earth.kml+xml');
echo $kmlOutput;*/
// Convert text date string to MySQL format for database insertion
function dateToMySQL ($dateString) {
	$monthNums = array ("jan" => 1, "feb" => 2, "mar" => 3, "apr" => 4, "may" => 5, "jun" => 6, "jul" => 7, "aug" => 8, "sep" => 9, "oct" => 10, "nov" => 11, "dec" => 12);
	# Find 4-digit year at front, otherwise assume last field is year
	if (eregi ("^([0-9]{4})[ .,/-]+([a-z0-9]+)[ .,/-]+([a-z0-9]+)", $dateString, $splitdate)) {
		list ($string, $year, $value1, $value2) = $splitdate;
	} else if (eregi ("([a-z0-9]+)[ .,/-]+([a-z0-9]+)[ .,/-]+([0-9]{1,4})$", $dateString, $splitdate)) {
		# 1 to 4-digit year at end
		list ($string, $value1, $value2, $year) = $splitdate;
		if (strlen ($year) < 3) {
			# Make assumptions about century
			$now = time ();
			$y1 = date ("Y", $now);
			$y2 = $y1 + 10;
			$year += 1900;
			while ($year < $y1) $year += 100;
			while ($year > $y2) $year -= 100;
		}
	} else {
		# Error - invalid format
		return (0);
	}
	# Look for an alphabetic month
	if (eregi ("[a-z]+", $value1)) {
		$month = $monthNums[strtolower (substr ($value1, 0, 3))];
		$day = $value2;
	} else if (eregi ("[a-z]+", $value2)) {
		$month = $monthNums[strtolower (substr ($value2, 0, 3))];
		$day = $value1;
	} else if ($value1 > 12) {
		# Determine if first value is month or day
		$day = $value1;
		$month = $value2;
	} else {
		$month = $value1;
		$day = $value2;
	}
	# Check to see if it's a valid date
	if (!checkdate ($month, $day, $year)) return (0);
	# Return date string in MySQL format
	$sqlDate = sprintf ("%04d-%02d-%02d", $year, (int)$month, (int)$day);
	return ($sqlDate);
}
?>
