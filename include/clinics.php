<script lang="text/javascript">
var y = document.getElementById('dept');
for (i = 0; i < y.options.length; i++) { 
	if (y.options[i].value == '<?php echo $dept; ?>') y.selectedIndex = i;
}  
var z = document.getElementById('searchsitecode');
var Artibonite = Array();
<?php genDeptEntries ('Artibonite','Artibonite'); ?>
var Centre = Array();
<?php genDeptEntries ('Centre','Centre'); ?>
var Grandeanse = Array();
<?php genDeptEntries ('Grande-anse','Grandeanse'); ?>
var Nippes = Array();
<?php genDeptEntries ('Nippes','Nippes'); ?>
var Nord = Array();
<?php genDeptEntries ('Nord','Nord'); ?>
var Nordest = Array();
<?php genDeptEntries ('Nord-est','Nordest'); ?>
var Nordouest = Array();
<?php genDeptEntries ('Nord-ouest','Nordouest'); ?>
var Ouest = Array();
<?php genDeptEntries ('Ouest','Ouest'); ?>
var Sud = Array();
<?php genDeptEntries ('Sud','Sud'); ?>
var Sudest = Array();
<?php genDeptEntries ('Sud-est','Sudest'); ?>
/*
function populate() {  
	alert('hello, populate');
	for (m = z.options.length - 1; m > 0; m--) z.options[m] = null; 
	var selIndex = y.selectedIndex;    
	var selArray = eval(y.options[selIndex].value)
    for (i = 0; i < selArray.length; i++) z.options[i] = new Option(selArray[i].text, selArray[i].value);
}*/
populate();
for (i = 0; i < z.options.length; i++) {
        if (z.options[i].value == '<?php echo $sitecode; ?>') z.selectedIndex = i;
}
</script>
<?php
function genDeptEntries ($deptName, $arrayName) {
	$sql = "select clinic, sitecode from clinicLookup where incphr = 1 and department = ? order by 1";
	$clinicArray = database()->query($sql,array($deptName))->fetchAll(PDO::FETCH_ASSOC);
	foreach ($clinicArray as $i => $row) {
		echo $arrayName . '[' . $i . '] = new Option("' . $row['clinic'] . '","' . $row['sitecode'] . '"); ';
	}
}
?>
