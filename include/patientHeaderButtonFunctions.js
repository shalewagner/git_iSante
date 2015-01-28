function launchClinicalSummary (hivPos) {
        if (hivPos) {
	        var url = '<?=JASPER_RENDERER;?>?report=206&rtype=individualCase&format=pdf&siteName=<?=$site;?>&pid=<?=$pid;?>&lang=<?=$lang;?>';
        } else {
	        var url = 'primCareSummaryRenderer.php?&site=<?=$site;?>&pid=<?=$pid;?>&lang=<?=$lang;?>';
        }
	stuff = 'width=800,height=600,toolbar=yes,location=yes,directories=no,scrollbars=yes,menubar=yes,resizable=yes';
	currWindow = window.open(url ,'RapportWindow', stuff);
	currWindow.focus();
}

function readSmartcard() {
	var url = 'readSmartcard.php?site=<?=$site;?>&pid=<?=$pid;?>&lang=<?=$lang;?>'; 
	document.location = url;
} 

function issueSmartcard() {
	var url = 'writeSmartcard.php?writeCard=issue&site=<?=$site;?>&pid=<?=$pid;?>&lang=<?=$lang;?>' 
	document.location = url;
}

function updateSmartcard() {
	var url = 'writeSmartcard.php?writeCard=update&site=<?=$site;?>&pid=<?=$pid;?>&lang=<?=$lang;?>' 
	document.location = url;
}

function delPatFromHeader() {
	var url = 'adminPat.php?pid=<?=$pid;?>&lang=<?=$lang;?>';
	document.location = url;
	
}

function deletePrints() {
  if (confirm("<?= _('en:Really delete this patient’s fingerprints?') ?>")) {
    document.location = '<?=$_SERVER['REQUEST_URI'] . "&deletePrints=true"?>';
  }
}

function submitPrints() {
	var url = 'fingerprint/submitPrints.php?pid=<?=$pid;?>&lang=<?=$lang;?>';
	document.location = url;
}
