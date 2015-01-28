
Ext.onReady(function() {

        var names = new Array();
        var allElements = Ext.util.getAllElements(document.mainForm,names);
	var tempRadioArr = allElements["radio"]; 
	var radioArr = Ext.util.getAllRadios(tempRadioArr);	

	nextMeetingDt = new Ext.form.DateField({
			fieldLabel: '',
			name: 'nextMeetingDt',
			maskRe : /[\Xx{1,2}\d{1,2}\/]/,
			validationEvent: false,
			allowBlank:true
	});
	nextMeetingDt.applyToMarkup(document.mainForm.nextVisitD1);
	
	(Ext.get('nextVisitD1')).on('blur', function(){
		errMsg =  Ext.util.validateDateFieldPatient(document.getElementById('nextVisitD1'),document.getElementById('nextVisitD1Title'),'');
		Ext.util.splitDate(document.getElementById('nextVisitD1'),document.getElementById('nextVisitDD'),document.getElementById('nextVisitMM'),document.getElementById('nextVisitYY'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'nextVisitD1',errMsg,errCount);
	});
	errMsg = Ext.util.validateDateFieldPatient(document.getElementById('nextVisitD1'),document.getElementById('nextVisitD1Title'),'');
    	Ext.util.splitDate(document.getElementById('nextVisitD1'),document.getElementById('nextVisitDD'),document.getElementById('nextVisitMM'),document.getElementById('nextVisitYY'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'nextVisitD1',errMsg,errCount);
	
	var taArr = Ext.util.getElementsByType(document.mainForm,"textarea");
	var taFormat;
	for(i=0;i<taArr.length;i++)
	{
		taFormat= new Ext.form.TextArea({
				fieldLabel: '',
				validationEvent: false,
				allowBlank:true
		});
		taFormat.applyToMarkup(taArr[i]);	
	}
		
	
});
