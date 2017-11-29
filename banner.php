<?
$menustring = "lang=$lang&site=$site&lastPid=$lastPid";
require_once 'labels/setPriv.php';
?>

<script type="text/javascript">
Ext.onReady(function(){
// create user extensions namespace (Ext.ux.form)
Ext.namespace('Ext.ux.form');

//  Ext.ux.form.SearchableTextField constructor
Ext.ux.form.SearchableTextField = function(config) {
    // call parent constructor
    Ext.ux.form.SearchableTextField.superclass.constructor.call(this, config);
    // associate ENTER key with button click
    this.on('specialkey', function(f, e) {
        if (e.getKey() == e.ENTER) {  
            this.onTriggerClick();
        }
    }, this);
} // end of Ext.ux.form.SearchableTextField constructor

// extend
Ext.extend(Ext.ux.form.SearchableTextField, Ext.form.TriggerField, {
    triggerClass: 'x-form-search-trigger',
    onTriggerClick : function() {
        alert('customize in you app code');
    }
}); // end of extend

	var tb = new Ext.Toolbar({
		renderTo: 'searchbox'
	});

	var search = new Ext.ux.form.SearchableTextField({
		triggerClass:'x-form-search-trigger',
		id:'banner-searchbox',
		width:100,
		onTriggerClick: function(){ 
      // .method = 'get' was causing errors on some pages. Removing for now.
			//document.forms[0].method = 'get';
			//document.forms[0].action = '#';
			//document.forms[0].target = '';
			top.location.href = 'find.php?site=<?=$site?>&lang=<?=$lang?>&qrystring=' + this.getRawValue();
		}
	});
	var searchPat = tb.add('-','<?=$menuPatients[$lang][2]?>: ', ' ', search);
	tb.doLayout();
<?
if (basename($_SERVER["SCRIPT_NAME"]) == "find.php") {
echo "
	var search2 = new Ext.ux.form.SearchableTextField({
		triggerClass:'x-form-search-trigger',
		id:'find-searchbox',
		applyTo: 'qrystring',
		onTriggerClick: function(){
			var x = this.getRawValue();
			this.setRawValue('');
			document.forms[0].method = 'post';
			document.forms[0].action = 'find.php?site=$site&lang=$lang';
			document.forms[0].qrystring.value = x; 
			document.forms[0].pageNum.value = 1; 
			document.forms[0].submit();
		}
	});
";
}

$targetGroup = (isset($_GET['targetGroup'])) ? $_GET['targetGroup'] : "Home";

$noidFromGet = '';
if (array_key_exists('noid', $_GET)) {
  $noidFromGet = $_GET['noid'];
}
echo "
function onSubmenuClick (item){
		if (item.id == 'deid') {
		   stuff = 'width=1200,height=700,toolbar=no,location=no,directories=no,scrollbars=yes,menubar=no,resizable=yes';
		   page = 'https://" . CONSOLIDATED_SERVER . "?lang=$lang';
	   	   currWindow = window.open(page, 'SiteConsolide', stuff); 
		} else {
			//var url = page;
			var url = page + 'lang=$lang&site=$site&lastPid=$lastPid';
			window.location = url;
		}
};
});
function setParam (theType, theValue) {
	var newLoc = 'splash.php?lang=';
	newLoc = newLoc + '$lang&site=' + theValue;
	window.location = newLoc;
};
function bugPopUp (subject, lang, user) {
	stuff = 'width=600,height=500,toolbar=no,location=no,directories=no,scrollbars=yes,menubar=no,resizable=yes';
	var url = 'bugWindow.php?username=' + user + '&subject=' + subject + '&lang=$lang';
	currWindow = window.open(url, 'BugWindow', stuff);
};
</script>
";  
?>
