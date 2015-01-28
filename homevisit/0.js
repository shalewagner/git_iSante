	
Ext.onReady(function() {

	
	var txtArr = Ext.util.getElementsByType(document.mainForm,"text");
	
	var txtFormat;
	var root;
	var suffix;
        var names = new Array();
        var allElements = Ext.util.getAllElements(document.mainForm,names);
	var tempRadioArr = allElements["radio"]; 
	var radioArr = Ext.util.getAllRadios(tempRadioArr);	

	for(i=0;i<txtArr.length;i++)
	{	
		suffix = txtArr[i].id.substring(txtArr[i].id.length-2);
		if(suffix == "Dt")
		{
			txtFormat= new Ext.form.DateField({
				fieldLabel: '',
				maskRe : /[\d{1,2}\/]/,
				validationEvent: false,
				allowBlank:true
			});
		}
		else
		{
			txtFormat = new Ext.form.TextField({
				fieldLabel: '',
				validationEvent: false,
				allowBlank:true
			});
		}
		txtFormat.applyToMarkup(txtArr[i]);		
	}
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
	
	var beforeDates = new Array();
	beforeDates[0]=document.getElementById('missedDateDt');
	beforeDates[1]=document.getElementById('arvDiscontinuationDt');
	beforeDates[2]=document.getElementById('careDiscDeathDateDt');
	for(i=0;i<beforeDates.length;i++)
	{
		(Ext.get(beforeDates[i].id)).on('blur', function(){
			errMsg =  Ext.util.validateRxDispDate(document.getElementById(this.id),document.getElementById(this.id + 'Title'),'');
			Ext.util.splitDate(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-2) + "Dd"),document.getElementById(this.id.substring(0,this.id.length-2) + "Mm"),document.getElementById(this.id.substring(0,this.id.length-2) + "Yy"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg,errCount);

		});
		errMsg = Ext.util.validateRxDispDate(document.getElementById(beforeDates[i].id),document.getElementById(beforeDates[i].id + 'Title'),'');
		Ext.util.splitDate(document.getElementById(beforeDates[i].id),document.getElementById(beforeDates[i].id.substring(0,beforeDates[i].id.length-2) + "Dd"),document.getElementById(beforeDates[i].id.substring(0,beforeDates[i].id.length-2) + "Mm"),document.getElementById(beforeDates[i].id.substring(0,beforeDates[i].id.length-2) + "Yy"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,beforeDates[i].id.substring(0,beforeDates[i].id.length-2),errMsg,errCount);
	}
	var afterDates = new Array();
	afterDates[0]=document.getElementById('nextClinicVisitDt');
	afterDates[1]=document.getElementById('nextHomeVisitDt');
	for(i=0;i<afterDates.length;i++)
	{
		(Ext.get(afterDates[i].id)).on('blur', function(){
			errMsg =  Ext.util.validateDateFieldNonPatientFurture(document.getElementById(this.id),'',document.getElementById('vDate'),document.getElementById(this.id + 'Title'));
			Ext.util.splitDate(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-2) + "Dd"),document.getElementById(this.id.substring(0,this.id.length-2) + "Mm"),document.getElementById(this.id.substring(0,this.id.length-2) + "Yy"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg,errCount);

		});
		errMsg = Ext.util.validateDateFieldNonPatientFurture(document.getElementById(afterDates[i].id),'',document.getElementById('vDate'),document.getElementById(afterDates[i].id + 'Title'));
		Ext.util.splitDate(document.getElementById(afterDates[i].id),document.getElementById(afterDates[i].id.substring(0,afterDates[i].id.length-2) + "Dd"),document.getElementById(afterDates[i].id.substring(0,afterDates[i].id.length-2) + "Mm"),document.getElementById(afterDates[i].id.substring(0,afterDates[i].id.length-2) + "Yy"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,afterDates[i].id.substring(0,afterDates[i].id.length-2),errMsg,errCount);
	}	
								
	Ext.get('nextClinicVisitDays').on('blur', function(){
		errMsg = Ext.util.isValueInBound(document.mainForm.nextClinicVisitDays,document.getElementById("nextClinicVisitDaysTitle"),'1','360','');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'nextClinicVisitDays',errMsg,errCount);	
		});
	errMsg = Ext.util.isValueInBound(document.mainForm.nextClinicVisitDays,document.getElementById("nextClinicVisitDaysTitle"),'1','360','');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'nextClinicVisitDays',errMsg,errCount);
	
	Ext.get('nextHomeVisitDays').on('blur', function(){
		errMsg = Ext.util.isValueInBound(document.mainForm.nextHomeVisitDays,document.getElementById("nextHomeVisitDaysTitle"),'1','360','');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'nextHomeVisitDays',errMsg,errCount);	
	});
	errMsg = Ext.util.isValueInBound(document.mainForm.nextHomeVisitDays,document.getElementById("nextHomeVisitDaysTitle"),'1','360','');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'nextHomeVisitDays',errMsg,errCount);

	var patientFollowupArr = new Array();
	patientFollowupArr[0] = document.getElementById('contactDuringVisit1');
	patientFollowupArr[1] = document.getElementById('contactDuringVisit2');

	var treatmentFollowupArr = new Array();
	treatmentFollowupArr[0] = document.getElementById('contactDuringVisit3');
	treatmentFollowupArr[1] = document.getElementById('contactDuringVisit4');
	for(i = 0; i < patientFollowupArr.length; i++)
	{
		Ext.get(patientFollowupArr[i]).on('click', function(){
			for(i = 0; i < patientFollowupArr.length; i++)
			{
				errMsg = Ext.util.checkItemSelected(patientFollowupArr, document.getElementById('contactDuringVisit1Title'));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,'contactDuringVisit1' ,errMsg,errCount);
			}

			for(i = 0; i < treatmentFollowupArr.length; i++)
			{
				errMsg = Ext.util.checkItemSelected(treatmentFollowupArr, document.getElementById('contactDuringVisit3Title'));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,'contactDuringVisit3' ,errMsg,errCount);
			}
			Ext.util.countRadioValue(patientFollowupArr,treatmentFollowupArr,document.mainForm.contactDuringVisit);
		}, document.getElementById(this.id), {delay: 5});
	}



	for(i = 0; i < treatmentFollowupArr.length; i++)
	{
		Ext.get(treatmentFollowupArr[i]).on('click', function(){
			for(i = 0; i < patientFollowupArr.length; i++)
			{
				errMsg = Ext.util.checkItemSelected(patientFollowupArr, document.getElementById('contactDuringVisit1Title'));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,'contactDuringVisit1' ,errMsg,errCount);
			}

			for(i = 0; i < treatmentFollowupArr.length; i++)
			{
				errMsg = Ext.util.checkItemSelected(treatmentFollowupArr, document.getElementById('contactDuringVisit3Title'));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,'contactDuringVisit3' ,errMsg,errCount);
			}
			Ext.util.countRadioValue(patientFollowupArr,treatmentFollowupArr,document.mainForm.contactDuringVisit);
		}, document.getElementById(this.id), {delay: 5});

	}

	Ext.get('vDate').on('blur', function(){
		for(i = 0; i < patientFollowupArr.length; i++)
		{
			errMsg = Ext.util.checkItemSelected(patientFollowupArr, document.getElementById('contactDuringVisit1Title'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'contactDuringVisit1' ,errMsg,errCount);
		}

		for(i = 0; i < treatmentFollowupArr.length; i++)
		{
			errMsg = Ext.util.checkItemSelected(treatmentFollowupArr, document.getElementById('contactDuringVisit3Title'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'contactDuringVisit3' ,errMsg,errCount);
		}
		Ext.util.countRadioValue(patientFollowupArr,treatmentFollowupArr,document.mainForm.contactDuringVisit);
 	});

	if(document.mainForm.vDate.value.length > 0 && document.mainForm.vDate.value!='//')
	{
		for(i = 0; i < patientFollowupArr.length; i++)
		{
			errMsg = Ext.util.checkItemSelected(patientFollowupArr, document.getElementById('contactDuringVisit1Title'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'contactDuringVisit1' ,errMsg,errCount);
		}

		for(i = 0; i < treatmentFollowupArr.length; i++)
		{
			errMsg = Ext.util.checkItemSelected(treatmentFollowupArr, document.getElementById('contactDuringVisit3Title'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'contactDuringVisit3' ,errMsg,errCount);
		}
		Ext.util.countRadioValue(patientFollowupArr,treatmentFollowupArr,document.mainForm.contactDuringVisit);
	}
	//Ext.util.clickRadio(document.mainForm);
	 
});


