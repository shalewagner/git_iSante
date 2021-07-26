
Ext.onReady(function() {

	Ext.get('PEP').on('click', function(){
		errMsg = Ext.util.checkRadioCorresponding(document.mainForm.PEP, document.getElementById('expFromD1'),document.getElementById('PEPTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'PEP',errMsg,errCount);
		errMsg = Ext.util.checkDateCorresponding(document.mainForm.PEP, document.getElementById('expFromD1'),document.getElementById('expFromD1Title'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'expFrom',errMsg,errCount);	
		if(errMsg == '' )
		{
			errMsg =  Ext.util.validateDateFieldNonPatient(document.getElementById('expFromD1'),document.getElementById('expFromD1Title'),'');
			Ext.util.splitDate(document.getElementById('expFromD1'),document.getElementById('expFromDt'),document.getElementById('expFromMm'),document.getElementById('expFromYy'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'expFrom',errMsg,errCount);	
		}
	});

	
});


