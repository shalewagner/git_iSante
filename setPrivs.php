<?
require_once 'include/standardHeaderExt.php';
require_once 'labels/setPriv.php';

// Check authorization
if (getAccessLevel (getSessionUser ()) < 2) {
  header ("Location: error.php?type=auth&lang=$lang");
  exit;
}
if (empty ($_GET['selUser']))
	header ("Location: error.php?type=username&lang=$lang");
else
	$selUser  = $_GET['selUser'];
	
// return existing privileges or defaults for new user
$privilegeArray = getPrivAttributes($selUser, DEF_SITE); 
$defSite = $privilegeArray['siteCode'];
?>
<title><?=$access_labels['header'][$lang];?></title>
<link rel="stylesheet" type="text/css" href="bootstrap.css?<?= urlencode(APP_VERSION) ?>">
<link rel="stylesheet" type="text/css" href="reporting.css">
<script type="text/javascript" src="include/bootstrap.js"></script>
<script type="text/javascript" src="include/jquery.datatables.js"></script>
<script type="text/javascript">
function displaySuccess() {
  $('#successModal').modal();
}
function onSave() {
	var sites = '';
	var defVal = '';
  defVal = $("select#defaultSite").val();
  // Get IDs of all sites that are checked.
  $("#siteTable input[name='sitecode']:checked").each(function(){
    sites = sites + $(this).attr("id") + ',';
  });
	document.forms[0].trans.value = 0;
	document.forms[0].debug.value = 0;
	// translate and debug flags are set only if privlevel is 3
	if (document.forms[0].priv[3] && document.forms[0].priv[3].checked) {
		if (document.forms[0].translateFlag.checked) document.forms[0].trans.value = 1;
		if (document.forms[0].debugFlag.checked) document.forms[0].debug.value = 1;
	}
	if(defVal.length == 5) {
		var priv = getCheckedValue(document.forms[0].priv);
		var tpw = '<?=$_SESSION["password"];?>';
		var pw = '';
		var serviceArea = 0;
		if (document.forms[0].sapc.checked) serviceArea = 1;
		if (document.forms[0].saobgyn.checked) serviceArea += 2;
		if (document.forms[0].sahiv.checked) serviceArea += 4; 
		ival = document.forms[0].network.selectedIndex;
		var sNetwork = document.forms[0].network[ival].text
		if (priv >= 2) pw = tpw;
		Ext.Ajax.request({
			method: 'POST'
			,url: 'process-request.php?cmd=saveDatax'
			,params: {
				userName: '<?=$selUser;?>'
				,debug: document.forms[0].debug.value
				,trans: document.forms[0].trans.value
				,serviceArea: serviceArea
				,priv: priv
				,uiConfig: getCheckedValue(document.forms[0].uiConfig)
				,network: sNetwork
				,def: defVal
				,sites: sites
				,pw: pw
			}
    });
		displaySuccess();
		if (defVal != '<?=$defSite;?>' && '<?=$selUser;?>' == '<?=getSessionUser();?>') document.location = 'setPrivs.php?selUser=<?=$selUser;?>&site=' + defVal + '&lang=fr&lastPid=<?=$lastPid;?>';
	} else {
    /* TODO - only error checking is to see that a default site is chosen. Should
     * update to make sure form is posted, etc */
		if ('$lang' == 'en')
			alert('The default site must be checked in the viewable site list.');
		else
			alert('<?=_("L’emplacement de défaut doit être signé la liste visualisable d’emplacement.");?>');
	}
}

$(document).ready(function() {

  // Show site list
  $("#displayTableButton").click(function() {
    $("#siteTableContainer").css("visibility","hidden");
    $("#siteTableContainer").fadeIn('slow', function() {
      oTable.fnAdjustColumnSizing();
      $("#siteTableContainer").css("visibility","visible");
    });
    $(this).hide();
    $("#hideTableButton").show();
    return false;
  });
  // Hide site list
  $("#hideTableButton").on('click', function() {
    $("#siteTableContainer").fadeOut('slow');
    $(this).hide();
    $("#displayTableButton").show();
    return false;
  });
  // Updates the site list with new default site
  function defaultSwitch(thisValue){
    $("#siteTable input[data-default='yes']").removeAttr("disabled");
    $("#defaultNote").remove();
    var defaultNote = '<span id="defaultNote" style="margin-left: 10px; font-weight: bold">(<?php echo $access_labels['defaultSite'][$lang]?>)</span>';
    $("#siteTable input[id="+thisValue+"]").prop('checked', true).attr("disabled", true).attr("data-default","yes").parent().next().append(defaultNote);
  }
  // On page load, find default site and check it
  var loadedSite = $("select#defaultSite").val();
  defaultSwitch(loadedSite);
  // If default site is changed
  $("select#defaultSite").change(function(){
    var thisValue = $(this).val();
    defaultSwitch(thisValue);
  });
  /* Datatables for displaying table and allowing filter/sort. */
  $.extend( true, $.fn.dataTable.defaults, {
    "sDom": "<'row-fluid'<'span4 tableHead'><'span8'f>r>t<'row-fluid'<'span6'i>>",
    "oLanguage": {
        // FIXME - Not localized
        "sSearch": "Filtrer : ",
        "sInfo": " _START_ à _END_ de _TOTAL_",
        "sInfoFiltered": "(filtrée à partir de _MAX_)",
        "sZeroRecords": "Aucun patient correspondant n'a été trouvé."
    }
  });
  var oTable = $('#siteTable').dataTable({
    "sScrollY": "300px", /* limit size of table */
    "bPaginate": false,
    "bAutoWidth": false,
    "aaSorting": [[ 2, "asc" ]],
    "aoColumnDefs": [
        { 'bSortable': false, 'aTargets': [ 0 ] } /* Turn off sorting on "view" */
     ]
  });
  $("div.tableHead").html('<h3><?php echo $access_labels['siteAccess'][$lang]?></h3>');
  
  // Select or deselect all sites
  $("#contentArea").on("click", "#addAll", function(){
    $("#siteTable input[name='sitecode']").each(function(){
      $(this).prop('checked', true);
    });
    return false;
  });
  $("#contentArea").on("click", "#clearAll", function(){
    $("#siteTable input[name='sitecode']").each(function(){
      $(this).prop('checked', false);
    });
    return false;
  });
  
});
</script>
</head>
<body>
<?
include ("bannerbody.php");
?>
<div id="contentArea" class="contentArea">
<form name="mainForm" action="LDAPform.php" method="get">
  
  <div class="row-fluid">
    <div class="span12">
      <h1 class="page-header"><?php echo $access_labels['privilege'][$lang] . " : " . $selUser?></h1>      
    </div>
  </div>  
  
  <div class="row">
    <div class="span" style="margin-right: 20px">
      <?php
      $userPriv = getAccessLevel(getSessionUser());
      $selPriv = $privilegeArray['privLevel'];
      echo "<p><b>" . $access_labels['privLevel'][$lang] . "</b><br />";
      if ($userPriv == 3)
        $maxLevel = 3;
      else
        $maxLevel = 2;
      for ($i = 0; $i <= $maxLevel; $i++) {
        if ($selPriv == $i)
          echo "<label class=\"radio\"><input type=\"radio\" name=\"priv\" value=\"" . $i . "\" checked />";
        else
          echo "<label class=\"radio\"><input type=\"radio\" name=\"priv\" value=\"" . $i . "\" />";
        echo "&nbsp;" . $access_labels['privLabels'][$lang][$i + 1] . "</label><br />";
      }
      echo "</p>";    
      if ($userPriv == 3) {
        $ck0 = ($privilegeArray['debugFlag'] == 1) ? "checked": "";
        $ck1 = ($privilegeArray['translateFlag'] == 1) ? "checked": "";
        echo "
        &nbsp;&nbsp;&nbsp;<label class=\"checkbox\"><input type=\"checkbox\" name=\"debugFlag\"" . $ck0 . " />&nbsp;" . $access_labels['debug'][$lang] . "</label><br />
        &nbsp;&nbsp;&nbsp;<label class=\"checkbox\"><input type=\"checkbox\" name=\"translateFlag\"" . $ck1 . " />&nbsp;" . $access_labels['translate'][$lang] . "</label><br />
        ";
      }
      ?>
    </div>
    <div class="span" style="margin-right: 20px">
      <p><b><?=$access_labels['uiConfig'][$lang];?></b><br />
        <input type="radio" id="dataClerk" name="uiConfig" value="2" <?=($privilegeArray['uiConfiguration'] == 2 ? "checked" : "");?> />&nbsp;<?=$access_labels['ui'][$lang][0];?><br />
        <input type="radio" id="clinician" name="uiConfig" value="3" <?=($privilegeArray['uiConfiguration'] == 3 ? "checked" : "");?> />&nbsp;<?=$access_labels['ui'][$lang][1];?>
      </p>
      <br />
      <p><b><?php echo $access_labels['defaultNetwork'][$lang].$colon[$lang][0]?></b>&nbsp;<?=loadDropdown ("network", $lang, "9999", 1,$privilegeArray['network'], "");?></p>
    </div>
    <div class="span">
      <p><b><?=$access_labels['serviceAreas'][$lang].$colon[$lang][0];?></b><br />
        <label class="checkbox"><input type="checkbox" id="sapc" name="sapc" value="1" <?=isItemChecked($privilegeArray['serviceArea'], 1);?> />&nbsp;<?=$access_labels['serviceArea1'][$lang]?></label><br />
        <label class="checkbox"><input type="checkbox" id="saobgyn" name="saobgyn" value="2" <?=isItemChecked($privilegeArray['serviceArea'], 2);?> />&nbsp;Ob-Gyn</label><br />
        <label class="checkbox"><input type="checkbox" id="sahiv" name="sahiv" value="4" <?=isItemChecked($privilegeArray['serviceArea'], 4);?> />&nbsp;VIH</label>
      </p>
    </div>
  </div>
  
  <br />
  <div>
    <span style="font-size: 14px; font-weight: bold; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;"><?php echo $access_labels['defaultSite'][$lang].$colon[$lang][0]?></span> &nbsp;
    <select id="defaultSite">
      <?
      // create and populate the siteAccess table
      $results = getPrivSiteAccess ($selUser);
      $j = 0;
      foreach ($results as $row) {
      $sn = $row['clinic'];
      $sc = $row['siteCode'];
      $ha = $row['hasAccess'];
      if ($sc == $defSite)
        echo "<option value=\"" . $sc . "\" selected>".$sc." - ".$sn."</option>";
      else
        echo "<option value=\"" . $sc . "\">".$sc." - ".$sn."</option>";
      $j++;
      }
      ?>
    </select>
    &nbsp;&nbsp;&nbsp;
    <button id="displayTableButton" class="btn btn-small"><?php echo $access_labels['showSites'][$lang]?></button>
    <button id="hideTableButton" style="display: none" class="btn btn-small"><?php echo $access_labels['hideSites'][$lang]?></button>
  </div>
 
  <div class="hide" id="siteTableContainer">
    <br />
    <div class="row-fluid">
      <div class="span9">
        <table id="siteTable" class="table table-bordered table-hover table-condensed">
          <thead>
            <tr>
              <th><?php echo $access_labels['column0'][$lang]?></th>
              <th><?php echo $access_labels['column2'][$lang]?></th>
              <th><?php echo $access_labels['siteCode'][$lang]?></th>
          </tr>
        </thead>
        <tbody>
  <?
    // create and populate the siteAccess table
    $results = getPrivSiteAccess ($selUser);
    $j = 0;
    foreach ($results as $row) {
    $sn = $row['clinic'];
    $sc = $row['siteCode'];
    $ha = $row['hasAccess'];
    echo "
      <tr>
        <td>";
          if ($ha || $sc == $defSite)
              echo "<input type=\"checkbox\" id=\"" . $sc . "\" name=\"sitecode\" checked />";
          else
              echo "<input type=\"checkbox\" id=\"" . $sc . "\" name=\"sitecode\" />";
        echo "
        </td>
        <td>" . $sn . "</td>
        <td>" . $sc . "</td>
      </tr>";
    $j++;
    }
    ?>

      </tbody>
    </table>
    </div>
   </div>
    <div style="margin-bottom: 1em">
      <button id="addAll" class="btn btn-mini"><?php echo $access_labels['allSites'][$lang]?></button> 
      <button id="clearAll" class="btn btn-mini"><?php echo $access_labels['clearSites'][$lang]?></button>
    </div>
  </div>
 

 <br />
 <div>
  <input type="button" name="save" class="btn btn-primary" value="<?php echo $access_labels['formSave'][$lang]?>" onclick="onSave()" />
  <input type="submit" name="retList" class="btn" value="<?php echo $access_labels['return'][$lang]?>" />
 </div>
  
<div align="right">
	<font face="Verdana, Arial, Sans" size="2">I-TECH USER ACCESS Form (Version Date: April 2013)</font>
</div>
<?php echo "
<input type=\"hidden\" name=\"lang\" value=\"" . $lang . "\" />
<input type=\"hidden\" name=\"site\" value=\"" . $site . "\" />
<input type=\"hidden\" name=\"lastPid\" value=\"" . $_GET['lastPid'] . "\" />
<input type=\"hidden\" name=\"selUser\" value=\"" . $selUser . "\" />
<input type=\"hidden\" name=\"trans\" value=\"" . getTranslateFlag($selUser) . "\" />
<input type=\"hidden\" name=\"debug\" value=\"" . getDebugFlag($selUser) . "\" />
";?>
</form>
</div>
  
<!-- Modal for success on save -->
<div id="successModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="muccessModalLabel" aria-hidden="true">
 <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php echo $privSaveMsg[$lang][2]; ?></h3>
  </div>
  <div class="modal-body">
    <p><?php echo $privSaveMsg[$lang][0]; ?></p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>

</body>
</html>
<?php
function isItemChecked ($value, $bin) {
	$binstring = strrev (decbin ($value));
        return (!empty ($binstring{log ($bin, 2)}) && $binstring{log ($bin, 2)} == 1) ? "checked" : "";
}

function getPrivSiteAccess ($selectedUser = "") {
	$results = array ();
	$qry = "select case when l.sitecode in (select sitecode from siteAccess where username = '" . $selectedUser . "') then 1 else 0 end as hasAccess, 
		l.siteCode, l.clinic from clinicLookup l where incphr = 1";
	$result = dbQuery ($qry);
	if (!$result)
		die("Could not query.");
	else {
		while ($row = psRowFetch ($result))
			array_push ($results, $row);
	}
	return ($results);
}
?>
