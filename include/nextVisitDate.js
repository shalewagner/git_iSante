
Ext.onReady(function() {
	nxtVisitD2Format= new Ext.form.DateField({
		fieldLabel: '',
		maskRe : /[\d{1,2}\/]/,
		validationEvent: false,
		allowBlank:true
	});
	nxtVisitD2Format.applyToMarkup('nxtVisitD2');		
	Ext.get('nxtVisitD2').on('blur', function(){
		errMsg = Ext.util.validateNextVisitDt(document.getElementById('nxtVisitD2'), document.mainForm.vDate , document.getElementById('eid'),document.getElementById('nxtVisitD2Title'));
		Ext.util.splitDate(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-2) + "Dd"),document.getElementById(this.id.substring(0,this.id.length-2) + "Mm"),document.getElementById(this.id.substring(0,this.id.length-2) + "Yy"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'nxtVisitD2',errMsg,errCount);

	});
	
  var nxtVisitDateValue  = document.getElementById('nxtVisitD2').value.replace(/^\s+|\s+$/g,"");

	if(nxtVisitDateValue == "/   /" || nxtVisitDateValue == "/  /" || nxtVisitDateValue == "/ /")
	{
		document.getElementById('nxtVisitD2').value = "";
	}
	errMsg = Ext.util.validateNextVisitDt(document.getElementById('nxtVisitD2'), document.mainForm.vDate , document.getElementById('eid'),document.getElementById('nxtVisitD2Title'));
	Ext.util.splitDate(document.getElementById('nxtVisitD2'),document.getElementById('nxtVisitDd'),document.getElementById('nxtVisitMm'),document.getElementById('nxtVisitYy'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'nxtVisitD2',errMsg,errCount);

});


