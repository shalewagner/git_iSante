<?php
require_once ("backend.php");
require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";  

$table='';
$indicateur=$_REQUEST['indicateur'];
$startDate=$_REQUEST['startDate'];
$endDate=$_REQUEST['endDate'];
$iap=getIap($indicateur);

switch ($indicateur) {
	case '1':{
/* Numerateur */
$num=0;
$query_num="select count(distinct p.patientID) as cnt
from patientDispenses p,(
select patientID,dispd,nxt_dispd from patientDispenses p1
where p1.nxt_dispd between '".$startDate."' and '".$endDate."') pd 
where p.patientID=pd.patientID and 
      p.dispd between '".$startDate."' and '".$endDate."' and 
      p.dispd<=pd.nxt_dispd+2";
$result = databaseSelect()->query($query_num)->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row) {$num=$row['cnt'];}

/* Denominateur */
$den=1;
$query_den="select count(distinct p.patientID) as cnt
from patientDispenses p,(
select patientID,dispd,nxt_dispd from patientDispenses 
where nxt_dispd  between '".$startDate."' and '".$endDate."') pd
where p.patientID=pd.patientID and 
      p.dispd  between '".$startDate."' and '".$endDate."'";
$result = databaseSelect()->query($query_den)->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row) { $den=$row['cnt'];}
$valeur=0;			
if ($den>0)
$valeur=round(($num/$den)*100,2);

		$table="<div style=\" display:inline-block;width:60%;float:left; padding:20px 20px;\">
		<table class=\"gridtable\" cellspacing=\"0\" cellpadding=\"0\">
		<thead><tr>
			<th>Numerateur</th>
			<th>Denominateur</th>
			<th>Valeur</th></tr></thead><tbody>";
		$table.="<tr>
			<td><a target=\"_blank\" rel=\"noopener noreferrer\" href=\"./iap_patient_list.php?indicateur=1&startDate=".$startDate."&endDate=".$endDate."&type=num\">".$num." </a></td>
			<td><a target=\"_blank\" rel=\"noopener noreferrer\" href=\"./iap_patient_list.php?indicateur=1&startDate=".$startDate."&endDate=".$endDate."&type=den\">".$den."</a></td>
			<td>".$valeur." %</td></tr>";
	    $table.="</tbody></table></div>";
	}	
	      break;
case '2':{
/* Numerateur */
$num=0;
$query_num="select count(distinct p.patientID) as cnt
  FROM 
(select patientID, min(visitDate) as visitDate 
from pepfarTable p group by patientID
having TIMESTAMPDIFF(MONTH, min(visitDate),'".$endDate."')=12
) p,`patientStatusTemp` pt
WHERE patientStatus in (6,8) and 
endDate between '".$startDate."' and '".$endDate."' and 
p.patientID=pt.patientID";

$result = databaseSelect()->query($query_num)->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row) {$num=$row['cnt'];}

/* Denominateur */
$den=1;
$query_den="select count(distinct p.patientID) as cnt
FROM 
(select patientID, min(visitDate) as visitDate 
from pepfarTable p group by patientID
having TIMESTAMPDIFF(MONTH, min(visitDate),'".$endDate."')=12
) p,`patientStatusTemp` pt
WHERE patientStatus <>2 and 
endDate between '".$startDate."' and '".$endDate."' and 
p.patientID=pt.patientID";
$result = databaseSelect()->query($query_den)->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row) { $den=$row['cnt'];}
$valeur=0;			
if ($den>0)
$valeur= round(($num/$den)*100,2);
		$table="<div style=\" display:inline-block;width:60%;float:left; padding:20px 20px;\">
		<table class=\"gridtable\" cellspacing=\"0\" cellpadding=\"0\">
		<thead><tr>
			<th>Numerateur</th>
			<th>Denominateur</th>
			<th>Valeur</th></tr></thead><tbody>";
		$table.="<tr>
			<td><a target=\"_blank\" rel=\"noopener noreferrer\" href=\"./iap_patient_list.php?indicateur=2&startDate=".$startDate."&endDate=".$endDate."&type=num\">".$num." </a></td>
			<td><a target=\"_blank\" rel=\"noopener noreferrer\" href=\"./iap_patient_list.php?indicateur=2&startDate=".$startDate."&endDate=".$endDate."&type=den\">".$den."</a></td>
			<td>".$valeur." %</td></tr>";
	    $table.="</tbody></table></div>";
	}	
	      break;	
		  
case '3':{
/* Numerateur */
$query_num="select drugLabel,sum(TIMESTAMPDIFF(DAY,
case when startDate<DATE_ADD('".$endDate."', INTERVAL -12 MONTH) then DATE_ADD('".$endDate."', INTERVAL -12 MONTH)
     else startDate end , endDate)) as numerateur, 365 as denominateur
from drugRupture d,drugLookup l where l.drugID=d.drugID and endDate between DATE_ADD('".$endDate."', INTERVAL -12 MONTH) and '".$endDate."'
 group by 1";
 
$result = databaseSelect()->query($query_num)->fetchAll(PDO::FETCH_ASSOC);
$table="<div style=\" display:inline-block;width:60%;float:left; padding:20px 20px;\">
		<table class=\"gridtable\" cellspacing=\"0\" cellpadding=\"0\">
		<thead><tr>
		    <th>ART</th>
			<th>Numerateur</th>
			<th>Denominateur</th>
			<th>Valeur</th></tr></thead><tbody>";
foreach($result as $row) {
	$valeur= round(($row['numerateur']/$row['denominateur'])*100,2);
	$table.="<tr>
			<td>".$row['drugLabel']."</td>
			<td>".$row['numerateur']."</td>
			<td>".$row['denominateur']."</td>
			<td>".$valeur." %</td></tr>";    	
	}

$table.="</tbody></table></div>";
	
	}	
	      break;	
			  
		  
		  
		  
	
case '4':{
/* Numerateur */
$num=0;
$query_num="select count(distinct p.patientID) as cnt
  FROM 
(select patientID, min(visitDate) as visitDate 
from pepfarTable p group by patientID
having TIMESTAMPDIFF(MONTH, min(visitDate),'".$endDate."') between 9 and 15
) p,`patientStatusTemp` pt,(select  p.patientID FROM patient p,labs l
WHERE l.labID IN (103, 1257) and digits(l.result)>0
and ymdToDate(l.visitdateyy,l.visitDateMm,l.visitDateDd) between '".$startDate."' and '".$endDate."'
and p.patientID=l.patientID And digits(result)+0<1000) l
WHERE patientStatus<>1 and 
l.patientID=p.patientID";

$result = databaseSelect()->query($query_num)->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row) {$num=$row['cnt'];}

/* Denominateur */
$den=1;
$query_den="select count(distinct p.patientID) as cnt
FROM 
(select patientID, min(visitDate) as visitDate 
from pepfarTable p group by patientID
having TIMESTAMPDIFF(MONTH, min(visitDate),'".$endDate."') between 9 and 15
) p,`patientStatusTemp` pt,(select  p.patientID FROM patient p,labs l
WHERE l.labID IN (103, 1257) and digits(l.result)>0
and ymdToDate(l.visitdateyy,l.visitDateMm,l.visitDateDd) between '".$startDate."' and '".$endDate."'
and p.patientID=l.patientID) l
WHERE patientStatus<>1 and 
l.patientID=p.patientID";
$result = databaseSelect()->query($query_den)->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row) { $den=$row['cnt'];}
$valeur=0;			
if ($den>0)
$valeur= round(($num/$den)*100,2);
		$table="<div style=\" display:inline-block;width:60%;float:left; padding:20px 20px;\">
		<table class=\"gridtable\" cellspacing=\"0\" cellpadding=\"0\">
		<thead><tr>
			<th>Numerateur</th>
			<th>Denominateur</th>
			<th>Valeur</th></tr></thead><tbody>";
		$table.="<tr>
			<td><a target=\"_blank\" rel=\"noopener noreferrer\" href=\"./iap_patient_list.php?indicateur=4&startDate=".$startDate."&endDate=".$endDate."&type=num\">".$num." </a></td>
			<td><a target=\"_blank\" rel=\"noopener noreferrer\" href=\"./iap_patient_list.php?indicateur=4&startDate=".$startDate."&endDate=".$endDate."&type=den\">".$den."</a></td>
			<td>".$valeur." %</td></tr>";
	    $table.="</tbody></table></div>";
	}	
	      break;	

case '5':{
/* Numerateur */
$num=0;
$query_num="select count(distinct p.patientID) as cnt
  FROM 
(select patientID, min(visitDate) as visitDate 
from pepfarTable p group by patientID
having TIMESTAMPDIFF(MONTH, min(visitDate),'".$endDate."') between 9 and 15
) p,(select  p.patientID FROM patient p,labs l
WHERE l.labID IN (103, 1257) and digits(l.result)>0
and ymdToDate(l.visitdateyy,l.visitDateMm,l.visitDateDd) between '".$startDate."' and '".$endDate."') l
WHERE l.patientID=p.patientID";

$result = databaseSelect()->query($query_num)->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row) {$num=$row['cnt'];}

/* Denominateur */
$den=1;
$query_den="select count(distinct p.patientID) as cnt FROM 
(select patientID, min(visitDate) as visitDate 
from pepfarTable p group by patientID
having TIMESTAMPDIFF(MONTH, min(visitDate),'".$endDate."') between 9 and 15
) p";
$result = databaseSelect()->query($query_den)->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row) { $den=$row['cnt'];}
$valeur=0;			
if ($den>0)
$valeur= round(($num/$den)*100,2);
		$table="<div style=\" display:inline-block;width:60%;float:left; padding:20px 20px;\">
		<table class=\"gridtable\" cellspacing=\"0\" cellpadding=\"0\">
		<thead><tr>
			<th>Numerateur</th>
			<th>Denominateur</th>
			<th>Valeur</th></tr></thead><tbody>";
		$table.="<tr>
			<td><a target=\"_blank\" rel=\"noopener noreferrer\" href=\"./iap_patient_list.php?indicateur=5&startDate=".$startDate."&endDate=".$endDate."&type=num\">".$num." </a></td>
			<td><a target=\"_blank\" rel=\"noopener noreferrer\" href=\"./iap_patient_list.php?indicateur=5&startDate=".$startDate."&endDate=".$endDate."&type=den\">".$den."</a></td>
			<td>".$valeur." %</td></tr>";
	    $table.="</tbody></table></div>";
	}	
	      break;	


case '6':{
/* Numerateur */
$num=0;
$query_num="select count(distinct A.patientID) as cnt from (
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
where A.patientID=B.patientID and C.patientID=A.patientID and STRCMP(A.regimen,B.regimen)<>0";


$result = databaseSelect()->query($query_num)->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row) {$num=$row['cnt'];}

/* Denominateur */
$den=1;
$query_den="select count(distinct l.patientID) as cnt from labViral l,
(select patientID,max(resultDate) as resultDate from labViral l where l.resultDate<='".$endDate."' group by 1) l1
where l.patientID=l1.patientID and 
      l.resultDate=l1.resultDate and
      l.result>1000 and l.past_result>1000 and 
	  l.resultDate<='".$endDate."'";
	  
$result = databaseSelect()->query($query_den)->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row) { $den=$row['cnt'];}
$valeur=0;			
if ($den>0)
$valeur= round(($num/$den)*100,2);
		$table="<div style=\" display:inline-block;width:60%;float:left; padding:20px 20px;\">
		<table class=\"gridtable\" cellspacing=\"0\" cellpadding=\"0\">
		<thead><tr>
			<th>Numerateur</th>
			<th>Denominateur</th>
			<th>Valeur</th></tr></thead><tbody>";
		$table.="<tr>
			<td><a target=\"_blank\" rel=\"noopener noreferrer\" href=\"./iap_patient_list.php?indicateur=6&startDate=".$startDate."&endDate=".$endDate."&type=num\">".$num." </a></td>
			<td><a target=\"_blank\" rel=\"noopener noreferrer\" href=\"./iap_patient_list.php?indicateur=6&startDate=".$startDate."&endDate=".$endDate."&type=den\">".$den."</a></td>
			<td>".$valeur." %</td></tr>";
	    $table.="</tbody></table></div>";
	}	
	      break;	


case '7':{
/* Numerateur */
$num=0;
$query_num="select count(distinct p.patientID) as cnt
  FROM 
(select patientID, min(visitDate) as visitDate 
from pepfarTable p group by patientID
having TIMESTAMPDIFF(MONTH, min(visitDate),'".$endDate."')=12
) p,`patientStatusTemp` pt
WHERE patientStatus=9 and 
p.patientID=pt.patientID and
endDate between '".$startDate."' and '".$endDate."'";

$result = databaseSelect()->query($query_num)->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row) {$num=$row['cnt'];}

/* Denominateur */
$den=1;
$query_den="select count(distinct p.patientID) as cnt
FROM 
(select patientID, min(visitDate) as visitDate 
from pepfarTable p group by patientID
having TIMESTAMPDIFF(MONTH, min(visitDate),'".$endDate."')=12
) p,`patientStatusTemp` pt
WHERE patientStatus in (6,8,9) and 
p.patientID=pt.patientID and 
endDate between '".$startDate."' and '".$endDate."'";
$result = databaseSelect()->query($query_den)->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row) { $den=$row['cnt'];}
$valeur=0;			
if ($den>0)
$valeur= round(($num/$den)*100,2);
		$table="<div style=\" display:inline-block;width:60%;float:left; padding:20px 20px;\">
		<table class=\"gridtable\" cellspacing=\"0\" cellpadding=\"0\">
		<thead><tr>
			<th>Numerateur</th>
			<th>Denominateur</th>
			<th>Valeur</th></tr></thead><tbody>";
		$table.="<tr>
			<td><a target=\"_blank\" rel=\"noopener noreferrer\" href=\"./iap_patient_list.php?indicateur=7&startDate=".$startDate."&endDate=".$endDate."&type=num\">".$num." </a></td>
			<td><a target=\"_blank\" rel=\"noopener noreferrer\" href=\"./iap_patient_list.php?indicateur=7&startDate=".$startDate."&endDate=".$endDate."&type=den\">".$den."</a></td>
			<td>".$valeur." %</td></tr>";
	    $table.="</tbody></table></div>";
	}	
	      break;	
	case 'remove':
			$id = $_REQUEST['id'];
		$sql = "delete from drugRupture where id=? "; 
		
		$rc = database()->query($sql,array($id));			
		break;
		
}

?> 

<style type="text/css">

  input[type="submit"] { padding:3px; border:1px solid #F5C5C5; border-radius:2px; width:142px;
}

#keywords {
  margin: 0 auto;
  font-size: 1.2em;
}
table { 
  border-collapse: collapse; border-spacing: 0; width:100%; 
}
#keywords thead {
  cursor: pointer;
  background: #c9dff0;
}
label {
	padding-right:50px;
}

#keywords thead tr th { 
  font-weight: bold;
  padding: 5px 5px;
  padding-left: 42px;
}
#keywords thead tr th span { 
  padding-right: 20px;
  background-repeat: no-repeat;
  background-position: 100% 100%;
}

#keywords thead tr th.headerSortUp, #keywords thead tr th.headerSortDown {
  background: #acc8dd;
}

#keywords tbody tr { 
  color: #555;
}
#keywords tbody tr td {
  text-align: center;
  padding-right: 20px;
}
#keywords tbody tr td.lalign {
  text-align: left;
}

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

<script type="text/javascript">
			function showHideDiv(ele) {
				if(ele == "vitals") 
				{ 
			      document.getElementById("vital").style.backgroundColor ="#8899AA";
				  document.getElementById("veineuses").style.display = 'none';
				  document.getElementById("interventions").style.display = 'none';
				}
                else document.getElementById("vital").style.backgroundColor ="#AABBCC";
					  
				if(ele == "veineuses") 
				{
					document.getElementById("veineuse").style.backgroundColor ="#8899AA";
					document.getElementById("vitals").style.display = 'none';
					document.getElementById("interventions").style.display = 'none';
				}
				else document.getElementById("veineuse").style.backgroundColor ="#AABBCC";
				
				if(ele == "interventions") 
				{
					document.getElementById("intervention").style.backgroundColor ="#8899AA";
					document.getElementById("vitals").style.display = 'none';
					document.getElementById("veineuses").style.display = 'none';
				}
				else document.getElementById("intervention").style.backgroundColor ="#AABBCC";
				
				
				
				var srcElement = document.getElementById(ele);
				if (srcElement != null) {
					if (srcElement.style.display == "block") {
						srcElement.style.display = 'none';						
					}
					else {
						srcElement.style.display = 'block';
					}
					return false;
				}
			}
		</script>

</head>

<body text="#000000" link="#000000" alink="#000000" vlink="#000000" align="left"> 

<? include ("bannerbody.php"); ?>
	
<div style="border-left: 1px solid #99BBE8;">

<table id="keywords">
   <thead>
       <tr><th> Indicateur d'alerte precoce </th></tr>
    </thead>
    <form id="form" name="form" method="post" action="" >
       <tr><td>   
              <div style="padding:5px; float:left">
	              <label id="vitalTempTitle" style="width:50px">Indicateur</label>
		          <div style="display:inline-block; padding-left:10px">
		             <select name="indicateur" id="indicateur">
		              <?php echo getIapOptions($indicateur);?>
		             </select>
		           </div>
               </div>	
           </td>
	    </tr>  
        <tr><td>
		        <div style="padding:5px; float:left">
		           <label id="vitalTempTitle" style="width:50px">Date de debut</label>
		           <input id="startDate" name="startDate"  type="date" value="<?php echo $startDate; ?>"> 
		        </div>
            </td>
		</tr>  
        <tr><td>		 
		       <div style="padding:5px; float:left">
		           <label id="vitalTempTitle" style="width:50px">Date de fin</label>
		           <input id="endDate" name="endDate"  type="date" value="<?php echo $endDate; ?>"> 
		       </div>
            </td>
		</tr>  
        <tr><td>
	           <div class="" style="padding:15px ; float:left">
                   <button type="submit" class="" >Submit</button>
                   <button class="">Cancel</button>
               </div>   
            </td>
		</tr>
    </form>
	<?php if (isset($_REQUEST['indicateur'])) {?>
    <thead>
        <tr><th>Indicateur: <?php echo $iap['name']; ?> </th></tr>
    </thead>
	<?php } ?>
</table>
 
 
	</div>	
  
  <?php ?>
<div style="display: inline-block; width:65%; vertical-align:top;border-left: 1px solid #99BBE8;">
      <div class="tablex" style="padding:5px">

<?php if (isset($_REQUEST['indicateur'])) {?>	  
<table class="tablex1">
  <tbody>
    <tr><td>Definition</td><td><?php echo $iap['definition']; ?></td></tr>
	<tr><td>Numerateur</td><td><?php echo $iap['numerotor']; ?></td></tr>
	<tr><td>Denominateur</td><td><?php echo $iap['denominator']; ?></td></tr>
  </tbody>
</table>
	<?php } ?>	  
	  
     </div>
		 
		   <?php echo $table; ?>
		 
	  </div> 
  
  

  
  
  
  </body>
</html>

    

