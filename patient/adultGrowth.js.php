<script>
Ext.onReady (function(){
/** Alert on load -- currently uses top notification bar **/ 
	function loadAlert (type, alertText) {
		alertText = alertText.slice(0,-2);
		$('#notification-text').html(alertText);
		$('#notification-bar').addClass('notification-' + type);
		$('#notification-pull').addClass('notification-' + type);
		setTimeout(showNotificationOverlay,100);
		hideTimer = setTimeout( noShowNotificationOverlay,10000);
	} 
	function showAlerts() {  
		var modalCheck = false;
		var alertText = "<?= $adultGrowthLabels[$lang][15] ?>"; 
		var alertText2 = "<?= $adultGrowthLabels[$lang][18] ?>";
		$("table.nutrition-table tbody tr").each(function(){
			measureName = $(this).find("td:first").text();
			if ($(this).hasClass('error')) {
				alertText += measureName+", ";  
				loadAlert('failure', alertText);
			} else if ($(this).hasClass('warning')) {
				alertText2 += measureName+", ";  
				loadAlert('failure', alertText2);
			}
		});
	}
	showAlerts();
});
</script>