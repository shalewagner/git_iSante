<?php
require_once ("backend.php");
require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";  

$output = '';
$indicateur=$_REQUEST['indicateur'];
$startDate=$_REQUEST['startDate'];
$endDate=$_REQUEST['endDate'];
$type=$_REQUEST['type'];
$iap=getIap($indicateur);
$query='';

$categorie='';
if (isset($_REQUEST['type'])) {
	if($type=="num") $categorie="Numerateur";
	if($type=="den") $categorie="Denominateur";
}

$tableHeader='<table class="gridtable" border="1">
<thead><tr>
<th colspan="2"> Indicateur d\'alerte precoce : '.$iap['name'].'</th></tr>
<tr><td>Periode</td><td>'.$startDate.' - '.$endDate.'</td></tr>
<tr><td>Type</td><td>'.$categorie.'</td></tr>';


if (isset($_REQUEST['cle'])) $tableHeader.="<tr><th>Risk</th><th>".$_REQUEST['cle']."</th></tr>";

$tableHeader.="</thead></table>";




switch ($indicateur) {
	case '1':{
/* Numerateur */
if($type=="num")
$query="select  distinct p1.patientID,p1.location_id as siteCode,p1.clinicPatientID as ST,p1.lname as Prenom,p1.fname as Nom,case when p1.sex=2 then 'M' when p1.sex=1 then 'F' else 'I' end as Sexe,round(DATEDIFF('".$endDate."',ymdToDate(p1.dobYy,p1.dobMm,p1.dobDd))/365,0) as Age,telephone
FROM patient p1,patientDispenses p,(
select patientID,dispd,nxt_dispd from patientDispenses p1
where p1.nxt_dispd between '".$startDate."' and '".$endDate."') pd 
where p.patientID=pd.patientID and 
      p.dispd between '".$startDate."' and '".$endDate."' and 
      p.dispd<=pd.nxt_dispd+2
	  and p1.patientID=p.patientID";
if($type=="den")
$query="select  distinct p1.patientID,p1.location_id as siteCode, p1.clinicPatientID as ST,p1.lname as Prenom,p1.fname as Nom,case when p1.sex=2 then 'M' when p1.sex=1 then 'F' else 'I' end as Sexe,round(DATEDIFF('".$endDate."',ymdToDate(p1.dobYy,p1.dobMm,p1.dobDd))/365,0) as Age,telephone
FROM patient p1,patientDispenses p,(
select patientID,dispd,nxt_dispd from patientDispenses p1
where p1.nxt_dispd between '".$startDate."' and '".$endDate."') pd 
where p.patientID=pd.patientID and 
      p.dispd between '".$startDate."' and '".$endDate."' and 
	  p1.patientID=p.patientID";	
	   }		  
	  break;
	  
	  
	case '2':{
/* Numerateur */
if($type=="num")
$query="select  distinct p1.patientID,p1.location_id as siteCode,p1.clinicPatientID as ST,p1.lname as Prenom,p1.fname as Nom,case when p1.sex=2 then 'M' when p1.sex=1 then 'F' else 'I' end as Sexe,round(DATEDIFF('".$endDate."',ymdToDate(p1.dobYy,p1.dobMm,p1.dobDd))/365,0) as Age,telephone
FROM patient p1,(select patientID, min(visitDate) as visitDate 
from pepfarTable p group by patientID
having TIMESTAMPDIFF(MONTH, min(visitDate),'".$endDate."') between 12 and 12.999 
) p,`patientStatusTemp` pt
WHERE pt.patientStatus in (6,8) and 
endDate between '".$startDate."' and '".$endDate."' and 
p.patientID=pt.patientID
and p1.patientID=p.patientID";  
	  
	  
if($type=="den")
$query="select  distinct p1.patientID,p1.location_id as siteCode,p1.clinicPatientID as ST,p1.lname as Prenom,p1.fname as Nom,case when p1.sex=2 then 'M' when p1.sex=1 then 'F' else 'I' end as Sexe,round(DATEDIFF('".$endDate."',ymdToDate(p1.dobYy,p1.dobMm,p1.dobDd))/365,0) as Age,telephone
FROM patient p1,(select patientID, min(visitDate) as visitDate 
from pepfarTable p group by patientID
having TIMESTAMPDIFF(MONTH, min(visitDate),'".$endDate."') between 12 and 12.999 
) p,`patientStatusTemp` pt
WHERE pt.patientStatus <>2 and 
endDate between '".$startDate."' and '".$endDate."' and 
p.patientID=pt.patientID
and p1.patientID=p.patientID";	
	   }		  
	  break;	  

	case '4':{
/* Numerateur */
if($type=="num")
$query="select  distinct p1.patientID,p1.location_id as siteCode,p1.clinicPatientID as ST,p1.lname as Prenom,p1.fname as Nom,case when p1.sex=2 then 'M' when p1.sex=1 then 'F' else 'I' end as Sexe,round(DATEDIFF('".$endDate."',ymdToDate(p1.dobYy,p1.dobMm,p1.dobDd))/365,0) as Age,telephone
FROM patient p1,(select patientID, min(visitDate) as visitDate 
from pepfarTable p group by patientID
having TIMESTAMPDIFF(MONTH, min(visitDate),'".$endDate."') between 9 and 15
) p,`patientStatusTemp` pt,(select  p.patientID FROM patient p,labs l
WHERE l.labID IN (103, 1257) and digits(l.result)>0
and ymdToDate(l.visitdateyy,l.visitDateMm,l.visitDateDd) between '".$startDate."' and '".$endDate."'
and p.patientID=l.patientID And digits(result)+0<1000) l
WHERE pt.patientStatus<>1 and 
l.patientID=p.patientID
and p1.patientID=p.patientID";  
	  
	  
if($type=="den")
$query="select  distinct p1.patientID,p1.location_id as siteCode,p1.clinicPatientID as ST,p1.lname as Prenom,p1.fname as Nom,case when p1.sex=2 then 'M' when p1.sex=1 then 'F' else 'I' end as Sexe,round(DATEDIFF('".$endDate."',ymdToDate(p1.dobYy,p1.dobMm,p1.dobDd))/365,0) as Age,telephone
FROM patient p1,(select patientID, min(visitDate) as visitDate 
from pepfarTable p group by patientID
having TIMESTAMPDIFF(MONTH, min(visitDate),'".$endDate."') between 9 and 15
) p,`patientStatusTemp` pt,(select  p.patientID FROM patient p,labs l
WHERE l.labID IN (103, 1257) and digits(l.result)>0
and ymdToDate(l.visitdateyy,l.visitDateMm,l.visitDateDd) between '".$startDate."' and '".$endDate."'
and p.patientID=l.patientID) l
WHERE pt.patientStatus<>1 and 
l.patientID=p.patientID
and p1.patientID=p.patientID";	
	   }		  
	  break;

case '5':{
/* Numerateur */
if($type=="num")
$query="select  distinct p1.patientID,p1.location_id as siteCode,p1.clinicPatientID as ST,p1.lname as Prenom,p1.fname as Nom,case when p1.sex=2 then 'M' when p1.sex=1 then 'F' else 'I' end as Sexe,round(DATEDIFF('".$endDate."',ymdToDate(p1.dobYy,p1.dobMm,p1.dobDd))/365,0) as Age,telephone
FROM patient p1,(select patientID, min(visitDate) as visitDate 
from pepfarTable p group by patientID
having TIMESTAMPDIFF(MONTH, min(visitDate),'".$endDate."') between 9 and 15
) p,(select  p.patientID FROM patient p,labs l
WHERE l.labID IN (103, 1257) and digits(l.result)>0
and ymdToDate(l.visitdateyy,l.visitDateMm,l.visitDateDd) between '".$startDate."' and '".$endDate."') l
WHERE l.patientID=p.patientID
and p1.patientID=p.patientID";  
	  
	  
if($type=="den")
$query="select  distinct p1.patientID,p1.location_id as siteCode,p1.clinicPatientID as ST,p1.lname as Prenom,p1.fname as Nom,case when p1.sex=2 then 'M' when p1.sex=1 then 'F' else 'I' end as Sexe,round(DATEDIFF('".$endDate."',ymdToDate(p1.dobYy,p1.dobMm,p1.dobDd))/365,0) as Age,telephone
FROM patient p1,(select patientID, min(visitDate) as visitDate 
from pepfarTable p group by patientID
having TIMESTAMPDIFF(MONTH, min(visitDate),'".$endDate."') between 9 and 15
) p where p1.patientID=p.patientID";	

}		  

break;


case '6':{
/* Numerateur */
if($type=="num")
$query="select  distinct p1.patientID,p1.location_id as siteCode,p1.clinicPatientID as ST,p1.lname as Prenom,p1.fname as Nom,case when p1.sex=2 then 'M' when p1.sex=1 then 'F' else 'I' end as Sexe,round(DATEDIFF('".$endDate."',ymdToDate(p1.dobYy,p1.dobMm,p1.dobDd))/365,0) as Age,telephone
FROM patient p1,(select C.patientID from (
select p.patientID,p.visitDate,p.regimen from pepfarTable p,
(select p.patientID,max(visitDate) as visitDate from pepfarTable p,(select patientID,max(resultDate) as resultDate from labViral l where l.resultDate<='".$endDate."' group by 1) pt where p.patientID=pt.patientID and p.visitDate<=pt.resultDate group by 1) p1
where p.patientID=p1.patientID and p.visitDate=p1.visitDate
)A,
(select p.patientID,p.visitDate,p.regimen from pepfarTable p,
(select p.patientID,max(visitDate) as visitDate from pepfarTable p,(select patientID,max(resultDate) as resultDate from labViral l where l.resultDate<='".$endDate."' group by 1) pt where p.patientID=pt.patientID and p.visitDate between pt.resultDate and DATE_ADD(pt.resultDate, INTERVAL 3 month) group by 1) p1
where p.patientID=p1.patientID and p.visitDate=p1.visitDate) B , 
(select l.patientID from labViral l,
(select patientID,max(resultDate) as resultDate from labViral l where l.resultDate<='".$endDate."' group by 1) l1
where l.patientID=l1.patientID and 
      l.resultDate=l1.resultDate and
      l.result>1000 and l.past_result>1000 and 
	  l.resultDate<='".$endDate."') C
where A.patientID=B.patientID and C.patientID=A.patientID and STRCMP(A.regimen,B.regimen)<>0) l
WHERE l.patientID=p1.patientID";  
	  
	  
	  
	  
if($type=="den")
$query="select  distinct p1.patientID,p1.location_id as siteCode,p1.clinicPatientID as ST,p1.lname as Prenom,p1.fname as Nom,case when p1.sex=2 then 'M' when p1.sex=1 then 'F' else 'I' end as Sexe,round(DATEDIFF('".$endDate."',ymdToDate(p1.dobYy,p1.dobMm,p1.dobDd))/365,0) as Age,telephone
FROM patient p1,(select l.patientID from labViral l,
(select patientID,max(resultDate) as resultDate from labViral l where l.resultDate<='".$endDate."' group by 1) l1
where l.patientID=l1.patientID and 
      l.resultDate=l1.resultDate and
      l.result>1000 and l.past_result>1000 and 
	  l.resultDate<='".$endDate."') p where p1.patientID=p.patientID";	
}		  

break;

case '7':{
/* Numerateur */
if($type=="num")
$query="select  distinct p1.patientID,p1.location_id as siteCode,p1.clinicPatientID as ST,p1.lname as Prenom,p1.fname as Nom,case when p1.sex=2 then 'M' when p1.sex=1 then 'F' else 'I' end as Sexe,round(DATEDIFF('".$endDate."',ymdToDate(p1.dobYy,p1.dobMm,p1.dobDd))/365,0) as Age,telephone
FROM patient p1,(select patientID, min(visitDate) as visitDate 
from pepfarTable p group by patientID
having TIMESTAMPDIFF(MONTH, min(visitDate),'".$endDate."') between 12 and 12.999
) p,`patientStatusTemp` pt
WHERE pt.patientStatus=9 and 
p.patientID=pt.patientID and
endDate between '".$startDate."' and '".$endDate."'
and p1.patientID=p.patientID";  
	  
	  
if($type=="den")
$query="select  distinct p1.patientID,p1.location_id as siteCode,p1.clinicPatientID as ST,p1.lname as Prenom,p1.fname as Nom,case when p1.sex=2 then 'M' when p1.sex=1 then 'F' else 'I' end as Sexe,round(DATEDIFF('".$endDate."',ymdToDate(p1.dobYy,p1.dobMm,p1.dobDd))/365,0) as Age,telephone
FROM patient p1,(select patientID, min(visitDate) as visitDate 
from pepfarTable p group by patientID
having TIMESTAMPDIFF(MONTH, min(visitDate),'".$endDate."') between 12 and 12.999
) p,`patientStatusTemp` pt
WHERE pt.patientStatus in (6,8,9) and 
p.patientID=pt.patientID and 
endDate between '".$startDate."' and '".$endDate."' and p1.patientID=p.patientID";	

}		  

break;

	  
}
	  
$result = databaseSelect()->query($query)->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) == 0) return '<p><center><font color="red"><bold>Aucuns résultats trouvés</bold></font></center><p>';
        // set up the table
        $output = '<center><table id="excelTable" class="gridtable" width="90%" border="1" cellpadding="0" cellspacing="0">';
        // loop on the results 
        $i = 0;
        foreach($result as $row) {
               if ($i == 0) { 
                       // output the column header 
                       $output .= '<tr><th>Code ST</th><th>Prenom</th><th>Nom</th><th>Sexe</th><th>Age</th><th>Telephone</th></tr>';
					   }				   
                       $output .= '<tr><td><a target="_blank" rel="noopener noreferrer" href="patienttabs.php?pid='.$row['patientID'].'&lang=fr&site='.$row['siteCode'].'">'. $row['ST']. '</a></td><td>'. $row['Prenom']. '</td><td>'. $row['Nom']. '</td><td>'. $row['Sexe']. '</td><td>'. $row['Age']. '</td><td>'. $row['telephone']. '</td></tr>';
                       $i++;
               } 
              // $output .= '<tr>';
              // foreach($row as $key => $value) { if($key<>'patientID') $output .= '<td style="font-family: Lucida Console; font-size: 12.0px; padding:3px;">' . $value . '</td>'; }
             //  $output .= '</tr>';
      //  }
        // close the table 
        $output .= '</table></center>';

		


?> 
<html>
<head>
<style type="text/css">

table.gridtable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}
table.gridtable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}
</style>
<script language="javascript">
        function printdiv(printpage) {
            var headstr = "<html><head><title></title></head><body>";
            var footstr = "</body>";
            var newstr = document.all.item(printpage).innerHTML;
            var oldstr = document.body.innerHTML;
            document.body.innerHTML = headstr + newstr + footstr;
            window.print();
            document.body.innerHTML = oldstr;
            return false;
        }
    </script>
	
<script type="text/javascript">
var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
</script>	
</head>

<body text="#000000" link="#000000" alink="#000000" vlink="#000000" align="left"> 

<? include ("bannerbody.php"); ?>

    
  <?php ?>
<div style="width:65%; vertical-align:top;border-left: 1px solid #99BBE8;">
<div class="tablex" style="padding:10px;width:50%"><?php echo $tableHeader; ?></div>
<div style="float:right;padding:15px;margin-right:35px;">
 <input name="b_print" type="button"  onClick="printdiv('print_section');" value=" Imprimer ">
 <button onclick="tableToExcel('excelTable', 'List patient')">Exporter dans EXCEL</button>
 </div>
      <div id="print_section" style="padding:5px">     	 
		   <?php echo $output ; ?>		
      </div>			   
</div> 
  
  </body>
</html>

    

