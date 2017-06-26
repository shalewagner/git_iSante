<?php
require_once ("backend.php");

require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";  

	$excelRow=0;
	$labRow=0;

if ($_FILES[csv][size] > 0) { 

    //get the csv file 
    $file = $_FILES[csv][tmp_name]; 
    //$handle = fopen($file,"r");
	
	 $lines = readInputFromFile($file);
	 database()->query("truncate table viralLoad");
    //loop through the csv file and insert into database 
	for ($i = 0; $i < count($lines); $i++)
	{
      $data = explode(",", $lines[$i]);
	  
      $query="INSERT INTO viralLoad (siteCode, stCode, visitDate,result,resultDate,note) VALUES (?,?,?,?,?,?)";
	  $result=database()->query($query,array(addslashes($data[0]),addslashes($data[1]),addslashes($data[2]),addslashes($data[3]),addslashes($data[4]),addslashes($data[5])));	 
      $excelRow=$excelRow+$result->rowCount();
	  
	  $query="update labs l,patient p
                   set l.result=?,
                   l.resultDateDd=Day(date(?)),
                   l.resultDateMm=Month(date(?)),
                   l.resultDateYy=date_format(date(?),?),
                   l.resultRemarks=?
             where p.clinicPatientID=? and p.patientID=l.patientID and
                   l.siteCode=? and 
	               l.labID IN (103, 1257) and 
	               ymdToDate(visitDateYy,visitDateMm,visitDateDd)=date(?)";				   
	$result=database()->query($query,array(addslashes($data[3]),addslashes($data[4]),addslashes($data[4]),addslashes($data[4]),'%y',addslashes($data[5]),addslashes($data[1]),addslashes($data[0]),addslashes($data[2])));  
	$labRow=$labRow+$result->rowCount(); 
	
	if ($result->rowCount()==1)
	database()->query("update viralLoad set updated=1 where siteCode=? and stCode=? and visitDate=? and resultDate=?",array(addslashes($data[0]),addslashes($data[1]),addslashes($data[2]),addslashes($data[4])));	 
    	
	}	
    //redirect 	
	$output='<br><br><b align="center">Resultat n\'ayant pas ete importe:</b><br><br><table align="center" id="viral_load"><tr><th>Site Code</th><th>Code ST</th><th>Visit Date</th><th>Result </th> <th>Result Date</th></tr>';
 $result1=database()->query("select * from viralLoad where updated=0");
 while($row = $result1->fetch()) {
	 $output.="<tr><td>".$row['siteCode']."</td><td>".$row['stCode']."</td><td>".$row['visitDate']."</td><td>".$row['result']."</td><td>".$row['resultDate']."</td></tr>";
 }	  
	
	echo $output.'</table>';
	
   // header('Location:loadViral.php?success=1&excel='.$excelRow.'&labs='.$labRow); die; 

} 

function readInputFromFile($file)
{
   $fh = fopen($file, 'r');
   while (!feof($fh))
   {
      $ln = fgets($fh);
      $parts[] = $ln;
   }
   fclose($fh);
   return $parts;
}

?>



function saveLabOrder() {
	/* output formAuthor */
	var firstName = Ext.getCmp('first').getRawValue();
	var lastName = Ext.getCmp('last').getRawValue(); 
	//alert(firstName + ' ' + lastName);
	var obsData = {}; 
	var kpair = fetchContainerContents('labHeader');
	kpair.each(function(conceptName, obsValue) {
		obsData[conceptName] = obsValue;
	});
	var vDateArray = document.getElementById('vDate').value.split('/');
	Ext.Ajax.request({   
		waitMsg: 'Saving changes...',
		url: 'genericsave.php',
		params: {
			type: '<?=$type ?>',
			version: '<?=$version ?>',
			site: '<?=$site; ?>',
			lang: '<?=$lang; ?>',
			visitDateDd: vDateArray[0],
			visitDateMm: vDateArray[1],
			visitDateYy: vDateArray[2],
			eid: '<?=$eid; ?>', 
			pid: '<?=$pid; ?>',
			formAuthor: firstName + ' ' + lastName,
			jsonData: Ext.util.JSON.encode(obsData)
		},                                  
		failure:function(response,options){
			Ext.MessageBox.alert('Warning','Oops...');
		},                                  
		success:function(response,options){
			var responseData = Ext.util.JSON.decode(response.responseText); 
			saveLabOrderItems();
			Ext.MessageBox.alert('Fin', '<?=$labLoc['saveSuccessful'][$lang]?>');
		} 
	});
};

function saveLabOrderItems () {
	jsonData = '[';
	for (i=0; i<a_labsDs.getCount(); i++) {
		record = a_labsDs.getAt(i); 
		if (jsonData != '[') jsonData += ',';
		if (record.get('labid0') != '') jsonData += Ext.util.JSON.encode(record.data);
	}    
	jsonData += ']';
	//submit to server 
	Ext.Ajax.request({   
		waitMsg: 'Saving changes...',
		url: 'laboratory/labService.php?eid=<?=$eid;?>&site=<?=$site;?>', 
		params: {
			task: 'saveOrderedLabs',
			eid: '<?=$eid?>',
			pid: '<?=$pid?>',
			site: '<?=$site?>',
			data: jsonData
		},
		failure:function(response,options){
			Ext.MessageBox.alert('Warning','Oops...');
		},                                  
		success:function(response,options){
			var responseData = Ext.util.JSON.decode(response.responseText);
			a_labsDs.commitChanges(); 
			allDirty = false;
			a_labsDs.load({params: {task: 'getOrdered'}}); 
			adjustDisplayedWidgets(usingOE, iFlag,oFlag,sent);
		} 
	});
} 
