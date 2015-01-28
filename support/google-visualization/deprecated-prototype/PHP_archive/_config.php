<?php

/*** mysql hostname ***/
$hostname = 'localhost';

/*** mysql username ***/
$username = 'root';

/*** mysql password ***/
$password = '';


$dbh = new PDO("mysql:host=$hostname;dbname=itech", $username, $password);

function write($fh, $string, $display=True) {
	if ($display) {
		if ($string == PHP_EOL) {
			echo '<br />';
		} else {
			echo $string;
		}
	}
	fwrite($fh, $string);
}

function clean_file($file) {
	$myFile = 'DSPL/'.$file;
	$fh = fopen($myFile, 'w');
	fwrite($fh, '');
	fclose($fh);
}

class DSPL {

	private $dbh;

	// class constructor
	public function __construct($dbh) {
		$this->dbh = $dbh;
		$this->tables = array();
		$this->datasetslices = '';
		$this->datasettables = '';
	}

	// output the given slice
	protected function create_slice($title,$fields,$concept,$table) {
	

		$file_sep = '_';
		$file = '';
		foreach($fields as $field => $value) {
			$file .= $file_sep.$field;
		}
		
		$sep = ',';
		$group = '';
		$DSPLfields = array_merge($concept,$fields);
		foreach($DSPLfields as $field => $value) {
			$group .= $field.$sep;
		}
		
		// generate the query
		$sql = "SELECT ".$group."day,SUM(population) as population
		FROM  `".$table."`
		GROUP BY ".$group."day
		ORDER BY ".$group."day";
		
		// output the created csv file
		$this->output_mysql($sql,$title.$file.'_slice.csv',False);
		$this->tables[] = $title.$file.'_slice.csv';
		
		// display the DSPL xml code
		$columns = '';
		$concepts = '';
		
		foreach($DSPLfields as $key => $value) {
			$columns.=PHP_EOL.'	  <column id="'.$key.'" type="string"/>';
			$concepts.=PHP_EOL.'	  <dimension concept="'.$key.'"/>';
		}
		
		$this->datasettables .= '
	<table id="'.$title.$file.'_slice_table">'.$columns.'
      <column id="day" type="date" format="yyyy-MM-dd"/>
      <column id="population" type="integer"/>
	  <data>
		<file format="csv" encoding="utf-8">'.$title.$file.'_slice.csv</file>
	  </data>
	</table>
	';
	
		$this->datasetslices .= '
	<slice id="'.$title.$file.'_slice">'.$concepts.'
      <dimension concept="time:day"/>
      <metric concept="population"/>
	  <table ref="'.$title.$file.'_slice_table"/>
	</slice>
	';

	}

	// Output all relevant slices
	public function create_all_slices($fields,$title,$concept,$table) {
			// add main slice
			$DSPLfields = array();
			$this->create_slice($title,$DSPLfields,$concept,$table);
		
			// add each department subslice
			foreach ($fields as $key1 => $value1) {
				$DSPLfields = array($key1 => $value1);
				$this->create_slice($title,$DSPLfields,$concept,$table);
			}

			// add each department subslice
			foreach ($fields as $key1 => $value1) {
				$DSPLfields = array();
				foreach ($fields as $key2 => $value2) {
					if ($key2 != $key1) {
						$DSPLfields[$key2] = $value2;
					}
				}
				$this->create_slice($title,$DSPLfields,$concept,$table);
			}
			
			// add each department subslice
				$DSPLfields = $fields;
				$this->create_slice($title,$DSPLfields,$concept,$table);
	}
		
	// execute the sql query
	public function output_mysql($sql,$file,$display=True,$mode='w') {

		$myFile = 'DSPL/'.$file;
		$fh = fopen($myFile, $mode);
		
		echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>';
		
		echo $sql.'<br />';

		$result = $this->dbh->query($sql);
		if (!$result) {
			echo 'error in sql query';
		}
		
		$meta = array();

		$i=0;
		while( $row = $result->fetch(PDO::FETCH_ASSOC) ) {
		
			// If first line, build header
			if ($i==0) {
					$sep = '';
					$j = 0;
					$header = '';
					foreach($row as $key => $value) {
						$array = $result->getColumnMeta($j);
						if (isset($array['native_type'])) {
							$meta[$key] = $array['native_type'];
						} else {
							$meta[$key] = 'UNK';
						}
						$header .= $sep.$key;
						$sep = ',';
						$j++;
					}
					// if we are appending, we do not need to display header
					if ($mode == 'w' || ($mode == 'a' && count(file($myFile)) <= 1)) {
						write($fh, $header, $display);
						write($fh, PHP_EOL, $display);
					}
			}
			// print rows
			$sep = '';
			foreach($row as $key => $value) {
				if ($meta[$key]=='VAR_STRING') {
					$value = str_replace(',','',$value);
					write($fh, $sep.'""'.$value.'""', $display);
				} else {
					write($fh, $sep.$value, $display);
				}
				$sep = ',';
			}
			write($fh, PHP_EOL, $display);
			$i++;
		}
		fclose($fh);

	}

	// print all the created table files
	public function print_created_tables() {
		foreach($this->tables as $filename) {
			echo $filename.' ';
		}
		echo '<br />';
	}
	
// display the DSPL xml code
	public function print_add_to_dataset($outfile) {
		
		$myFile = 'DSPL/'.$outfile;
		$fh = fopen($myFile, 'w');
		
		write($fh,$this->datasetslices,False);
		
		write($fh,'
==============================================================
==============================================================
==============================================================

',False);
		
		write($fh,$this->datasettables,False);
				
		fclose($fh);

	}
	
}


$DSPL = new DSPL($dbh);

?>
