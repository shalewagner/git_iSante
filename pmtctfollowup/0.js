	
Ext.onReady(function() {
	var names = new Array();
	names[0] = "arvPrevious";
	names[1] = "aMed";
	var allElements = Ext.util.getAllElements(document.mainForm,names);
	var txtArr = allElements["text"];
	var txtFormat = new Array();
	var root;
	var suffix;

	for(i=0;i<txtArr.length;i++)
	{	
		suffix = txtArr[i].id.substring(txtArr[i].id.length-2);

		if(suffix == "Dt")
		{
			txtFormat[txtArr[i].id] = new Ext.form.DateField({
				fieldLabel: '',
				maskRe : /[\d{1,2}\/]/,
				validationEvent: false,
				allowBlank:true
			});
			txtFormat[txtArr[i].id].applyToMarkup(txtArr[i]);

			Ext.get(txtArr[i].id).on('blur', function(){	
				if(this.id != 'probBirthDt')
					errMsg = Ext.util.validateDateField(document.getElementById(this.id), document.getElementById(this.id + 'Title'),'');
				else
					errMsg =  Ext.util.validateDateFieldNonPatientFurture(document.getElementById('probBirthDt'), '', document.mainForm.vDate, document.getElementById('probBirthDtTitle'));
				Ext.util.splitDate(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-2) + "Dd"),document.getElementById(this.id.substring(0,this.id.length-2) + "Mm"),document.getElementById(this.id.substring(0,this.id.length-2) + "Yy"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
			});
			if(txtArr[i].id != 'probBirthDt')
				errMsg = Ext.util.validateDateField(document.getElementById(txtArr[i].id), document.getElementById(txtArr[i].id + "Title"), "");
			else
				errMsg =  Ext.util.validateDateFieldNonPatientFurture(document.getElementById('probBirthDt'), '', document.mainForm.vDate, document.getElementById('probBirthDtTitle'));
			Ext.util.splitDate(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Dd"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Mm"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Yy"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id,errMsg,errCount);
		}	
		else if(suffix == 'MY')
		{
			txtFormat[i] = new Ext.form.TextField({
				fieldLabel: '',
				maskRe : /[\Xx{1,2}\d{1,2}\/]/,
				validationEvent: false,
				allowBlank:true
			});
			txtFormat[i].applyToMarkup(txtArr[i]);
			root = txtArr[i].id.substring(0,txtArr[i].id.length-2);
			for(var i1=1;i1<3;i1++)
			{

				(Ext.get(root + 'Active' + i1)).on('click', function(){
					var checkboxArray = new Array(2);
					for(var j=1;j<3;j++)
					{
						checkboxArray[j-1] = document.getElementById(this.id.substring(0,this.id.length-1)+j);
					}
					errMsg = Ext.util.checkUniqueCheckboxWithMY(checkboxArray,document.getElementById(this.id.substring(0, this.id.length-7)+"MY"),document.getElementById(this.id.substring(0, this.id.length-7)+"YM"),document.getElementById(this.id.substring(0, this.id.length-1)+"Title"));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-1),errMsg,errCount);
					errMsg = Ext.util.checkMYWithCheckbox(checkboxArray,document.getElementById(this.id.substring(0, this.id.length-7)+"MY"),document.getElementById(this.id.substring(0, this.id.length-7)+"YM"),'XX', document.getElementById(this.id.substring(0, this.id.length-7)+"Title"));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7), errMsg,errCount);
				});
			}
			(Ext.get(root + 'MY')).on('blur', function(){
				var checkboxArray = new Array(2);
				for(var j=1;j<3;j++)
				{
					checkboxArray[j-1] = document.getElementById(this.id.substring(0,this.id.length-2)+'Active' + j);
				}
				errMsg = Ext.util.checkUniqueCheckboxWithMY(checkboxArray,document.getElementById(this.id.substring(0, this.id.length-2)+"MY"),document.getElementById(this.id.substring(0, this.id.length-2)+"YM"),document.getElementById(this.id.substring(0, this.id.length-2)+"ActiveTitle"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2) + 'Active',errMsg,errCount);
				errMsg = Ext.util.checkMYWithCheckbox(checkboxArray,document.getElementById(this.id.substring(0, this.id.length-2)+"MY"),document.getElementById(this.id.substring(0, this.id.length-2)+"YM"),'XX', document.getElementById(this.id.substring(0, this.id.length-2)+"Title"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2), errMsg,errCount);
			});
			(Ext.get(root + 'YM')).on('blur', function(){
				var checkboxArray = new Array(2);
				for(var j=1;j<3;j++)
				{
					checkboxArray[j-1] = document.getElementById(this.id.substring(0,this.id.length-2)+'Active' + j);
				}
				errMsg = Ext.util.checkUniqueCheckboxWithMY(checkboxArray,document.getElementById(this.id.substring(0, this.id.length-2)+"MY"),document.getElementById(this.id.substring(0, this.id.length-2)+"YM"),document.getElementById(this.id.substring(0, this.id.length-2)+"ActiveTitle"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2) + 'Active',errMsg,errCount);
				errMsg = Ext.util.checkMYWithCheckbox(checkboxArray,document.getElementById(this.id.substring(0, this.id.length-2)+"MY"),document.getElementById(this.id.substring(0, this.id.length-2)+"YM"),'XX', document.getElementById(this.id.substring(0, this.id.length-2)+"Title"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2), errMsg,errCount);
			});
			var checkboxArray = new Array(2);
			for(var j=1;j<3;j++)
			{
				checkboxArray[j-1] = document.getElementById(root+'Active' + j);
			}
			errMsg = Ext.util.checkUniqueCheckboxWithMY(checkboxArray,document.getElementById(root+"MY"),document.getElementById(root+"YM"),document.getElementById(root+"ActiveTitle"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2) + 'Active',errMsg,errCount);
			errMsg = Ext.util.checkMYWithCheckbox(checkboxArray,document.getElementById(root+"MY"),document.getElementById(root+"YM"),'XX', document.getElementById(root +"Title"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root, errMsg,errCount);
		}
		else if(suffix == 'Mm' || suffix == 'Yy' || suffix == 'MM' || suffix == 'YY'  )
		{
			txtFormat[i] = new Ext.form.TextField({
				fieldLabel: '',
				maskRe : /[\Xx{1,2}\Nn{1,2}\d{1,2}\/]/,
				validationEvent: false,
				allowBlank:true
			});
			//root = txtArr[i].name.substring(0, txtArr[i].name.length-2);
			txtFormat[i].applyToMarkup(txtArr[i]);
			if(suffix == 'Mm' || suffix == 'Yy')
			{
				(Ext.get(txtArr[i].id)).on('blur', function(){
					errMsg = Ext.util.validateMY(document.getElementById(this.id.substring(0, this.id.length-2)+"Mm"),document.getElementById(this.id.substring(0, this.id.length-2)+"Yy"),document.getElementById(this.id.substring(0, this.id.length-2)+"Title"),"XX");
					errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2),errMsg,errCount);

				});
				errMsg = Ext.util.validateMY(document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Mm"),document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Yy"),document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Title"),"XX");
				errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2),errMsg,errCount);
			}
			else
			{
				suffix70 = txtArr[i].id.substring(txtArr[i].id.length-7, txtArr[i].id.length);
				if(suffix70 == 'StartMM')
				{
					root = txtArr[i].id.substring(0,txtArr[i].id.length-7);
					Ext.get( root+ 'StartMM').on('blur', function(){
						errMsg = Ext.util.checkDrugStartDate(document.getElementById(this.id.substring(0,this.id.length-7)+"StartMM"),document.getElementById(this.id.substring(0,this.id.length-7)+"StartYY"),document.getElementById(this.id.substring(0,this.id.length-7)+"StartTitle"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopMM"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYY"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopTitle"),'XX');
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg[0],errCount);
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7) + 'Stop',errMsg[1],errCount);
					});
					Ext.get( root+ 'StartYY').on('blur', function(){
						errMsg = Ext.util.checkDrugStartDate(document.getElementById(this.id.substring(0,this.id.length-7)+"StartMM"),document.getElementById(this.id.substring(0,this.id.length-7)+"StartYY"),document.getElementById(this.id.substring(0,this.id.length-7)+"StartTitle"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopMM"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYY"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopTitle"),'XX');
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg[0],errCount);
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7)+ 'Stop' ,errMsg[1],errCount);
					});
					Ext.get( root+ 'StopMM').on('blur', function(){
						errMsg = Ext.util.checkDrugStartDate(document.getElementById(this.id.substring(0,this.id.length-6)+"StartMM"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartYY"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartTitle"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopMM"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYY"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopTitle"),'XX');
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + 'Start',errMsg[0],errCount);
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg[1],errCount);
					});					
					Ext.get( root+ 'StopYY').on('blur', function(){
						errMsg = Ext.util.checkDrugStartDate(document.getElementById(this.id.substring(0,this.id.length-6)+"StartMM"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartYY"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartTitle"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopMM"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYY"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopTitle"),'XX');
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + 'Start',errMsg[0],errCount);
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg[1],errCount);;
					});
					errMsg = Ext.util.checkDrugStartDate(document.getElementById(root+"StartMM"),document.getElementById(root+"StartYY"),document.getElementById(root+"StartTitle"),document.getElementById(root+"StopMM"),document.getElementById(root+"StopYY"),document.getElementById(root+"StopTitle"),'XX');
					errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2),errMsg[0],errCount);
					errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-7) + 'Stop',errMsg[1],errCount);
				}
			}	
		}
		else
		{
			txtFormat[i] = new Ext.form.TextField({
				fieldLabel: '',
				validationEvent: false,
				allowBlank:true
			});
			txtFormat[i].applyToMarkup(txtArr[i]);
			

		}
	}
    var posNbrArr = new Array();
	posNbrArr[0] = 'gravida';
	posNbrArr[1] = 'para';
	posNbrArr[2] = 'aborta';
	posNbrArr[3] = 'oldGestWeeks';
	posNbrArr[4] = 'uterHeight';
	posNbrArr[5] = 'treatmentTBText';
	posNbrArr[6] = 'inhPreventionText';
	posNbrArr[7] = 'childBirthAge';
	posNbrArr[8] = 'childUterHeight';
	
	for(i=0;i<posNbrArr.length;i++)
	{	
		if(document.getElementById(posNbrArr[i])==null)
			//alert(posNbrArr[i]);
		Ext.get(posNbrArr[i]).on('blur', function(){
			errMsg = Ext.util.isBiggerEqualThan0(document.getElementById(this.id),document.getElementById(this.id + "Title"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
		});
		errMsg = Ext.util.isBiggerEqualThan0(document.getElementById(posNbrArr[i]),document.getElementById(posNbrArr[i] + "Title"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,posNbrArr[i],errMsg,errCount);
	}	
	
	var hourArr = new Array();
	hourArr[0] = 'returnDateHour';
	hourArr[1] = 'childBirthHour';
	hourArr[2] = 'ruptureHour';
	for(i=0;i<hourArr.length;i++)
	{
		Ext.get(hourArr[i]).on('blur', function(){
			errMsg = Ext.util.isValueInBound(document.getElementById(this.id),document.getElementById(this.id + "Title"),'0', '23', '');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
		});
		errMsg = Ext.util.isValueInBound(document.getElementById(hourArr[i]),document.getElementById(hourArr[i] + "Title"),'0', '23', '');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,hourArr[i],errMsg,errCount);
	}	

	var minArr = new Array();
	minArr[0] = 'returnDateMin';
	minArr[1] = 'childBirthMin';
	minArr[2] = 'ruptureMin';
	for(i=0;i<minArr.length;i++)
	{
		Ext.get(minArr[i]).on('blur', function(){
			errMsg = Ext.util.isValueInBound(document.getElementById(this.id),document.getElementById(this.id + "Title"),'0', '59', '');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
		});
		errMsg = Ext.util.isValueInBound(document.getElementById(minArr[i]),document.getElementById(minArr[i] + "Title"),'0', '59', '');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,minArr[i],errMsg,errCount);
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

	Ext.get('noneTreatments').on('click', function(){

		Ext.util.disableAssociated(document.getElementById('noneTreatments'), allElements['aMed']);
		for(var i = 0; i < allElements['aMed'].length; i++)
		{
			var errLoc = document.getElementById(allElements['aMed'][i].id + 'Title');
			if(errLoc!=null)
			{
				Ext.util.showErrorIcon('', errLoc);
				errCount = Ext.util.showErrorHead(errFields,errMsgs,allElements['aMed'][i].id,'',errCount);
			}
			else
			{
				errLoc = document.getElementById(allElements['aMed'][i].id.substring(0, allElements['aMed'][i].id.length-2) + 'Title');
				if(errLoc!=null)
				{
					Ext.util.showErrorIcon('', errLoc);
					errCount = Ext.util.showErrorHead(errFields,errMsgs,allElements['aMed'][i].id.substring(0, allElements['aMed'][i].id.length-2),'',errCount);
				}
			}
		}
	});	
	errMsg = Ext.util.disableAssociated(document.getElementById('noneTreatments'), allElements["aMed"]);
	
	var tempRadioArr = allElements["radio"]; 
	var radioArr = Ext.util.getAllRadiosNoMultiSelected(tempRadioArr);	
	
	vitalHeight = new Ext.form.TextField({
		fieldLabel: '',
		name: 'vitalHeight',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});
	vitalHeight.applyToMarkup(document.mainForm.vitalHeight); 
	Ext.get('vitalHeight').on('blur', function(){
		errMsg = Ext.util.checkHeight(document.mainForm.vitalHeight,document.getElementById("vitalHeightTitle"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalHeight',errMsg,errCount);
	
	});
	errMsg = Ext.util.checkHeight(document.mainForm.vitalHeight,document.getElementById("vitalHeightTitle"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalHeight',errMsg,errCount);
	
	vitalHeightCm = new Ext.form.TextField({
		fieldLabel: '',
		name: 'vitalHeightCm',
		maskRe : /[\d]/,
		validationEvent: false,
		allowBlank:true
	});
	vitalHeightCm.applyToMarkup(document.mainForm.vitalHeightCm); 
	Ext.get('vitalHeightCm').on('blur', function(){
		errMsg = Ext.util.checkHeightCm(document.mainForm.vitalHeightCm,document.getElementById("vitalHeightCmTitle"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalHeightCm',errMsg,errCount);
	});	
	errMsg = Ext.util.checkHeightCm(document.mainForm.vitalHeightCm,document.getElementById("vitalHeightCmTitle"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalHeightCm',errMsg,errCount);		
	
	vitalTemp = new Ext.form.TextField({
		fieldLabel: '',
		name: 'vitalTemp',
		maskRe : /[\d]/,
		validationEvent: false,
		allowBlank:true
	});
	vitalTemp.applyToMarkup(document.mainForm.vitalTemp);
	Ext.get('vitalTemp').on('blur', function(){
		errMsg = Ext.util.checkTemp2(document.getElementById(this.id), document.getElementById(this.id + '1'),document.getElementById(this.id+'Unit1'),document.getElementById(this.id+'Unit2'), radioArr, true, document.getElementById(this.id + 'Title'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
		errMsg = Ext.util.checkUnit2(document.getElementById(this.id), document.getElementById(this.id + '1'),document.getElementById(this.id+'Unit1'),document.getElementById(this.id+'Unit2'), radioArr, true, document.getElementById(this.id + 'UnitTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id + 'Unit',errMsg,errCount);
	});
	Ext.get('vitalTemp1').on('blur', function(){
		var root = this.id.substring(0,this.id.length-1);
		errMsg = Ext.util.checkTemp2(document.getElementById(root), document.getElementById(root+ '1'),document.getElementById(root+'Unit1'),document.getElementById(root+'Unit2'), radioArr, true, document.getElementById(root + 'Title'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,root+'1',errMsg,errCount);
		errMsg = Ext.util.checkUnit2(document.getElementById(root), document.getElementById(root + '1'),document.getElementById(root+'Unit1'),document.getElementById(root+'Unit2'), radioArr, true, document.getElementById(root + 'UnitTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'Unit',errMsg,errCount);
	});
	Ext.get('vitalTempUnit1').on('click', function(){
		var root = this.id.substring(0,this.id.length-5);
		errMsg = Ext.util.checkTemp2(document.getElementById(root), document.getElementById(root+ '1'),document.getElementById(root+'Unit1'),document.getElementById(root+'Unit2'), radioArr, true, document.getElementById(root + 'Title'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,root+'1',errMsg,errCount);
		errMsg = Ext.util.checkUnit2(document.getElementById(root), document.getElementById(root + '1'),document.getElementById(root+'Unit1'),document.getElementById(root+'Unit2'), radioArr, true, document.getElementById(root + 'UnitTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'Unit',errMsg,errCount);
	}, document.getElementById(this.id), {delay: 5});
	Ext.get('vitalTempUnit2').on('click', function(){
		var root = this.id.substring(0,this.id.length-5);
		errMsg = Ext.util.checkTemp2(document.getElementById(root), document.getElementById(root+ '1'),document.getElementById(root+'Unit1'),document.getElementById(root+'Unit2'), radioArr, true, document.getElementById(root + 'Title'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,root+'1',errMsg,errCount);
		errMsg = Ext.util.checkUnit2(document.getElementById(root), document.getElementById(root + '1'),document.getElementById(root+'Unit1'),document.getElementById(root+'Unit2'), radioArr, true, document.getElementById(root + 'UnitTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'Unit',errMsg,errCount);
	}, document.getElementById(this.id), {delay: 5});
	errMsg = Ext.util.checkTemp2(document.getElementById('vitalTemp'),document.getElementById('vitalTemp1'),document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'),radioArr, true,document.getElementById('vitalTempTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
	errMsg = Ext.util.checkUnit2(document.getElementById('vitalTemp'),document.getElementById('vitalTemp1'),document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'),radioArr, true,document.getElementById('vitalTempUnitTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTempUnit',errMsg,errCount);

	
	vitalHr = new Ext.form.TextField({
		fieldLabel: '',
		name: 'vitalHr',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});
	vitalHr.applyToMarkup(document.mainForm.vitalHr); 
	Ext.get('vitalHr').on('blur', function(){
		errMsg = Ext.util.checkHr(document.mainForm.vitalHr,document.getElementById("vitalHrTitle"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalHr',errMsg,errCount);	
	});
	errMsg = Ext.util.checkHr(document.mainForm.vitalHr,document.getElementById("vitalHrTitle"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalHr',errMsg,errCount);

	vitalRr = new Ext.form.TextField({
		fieldLabel: '',
		name: 'vitalRr',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});
	vitalRr.applyToMarkup(document.mainForm.vitalRr); 
	Ext.get('vitalRr').on('blur', function(){
		errMsg = Ext.util.checkRr(document.mainForm.vitalRr,document.getElementById("vitalRrTitle"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalRr',errMsg,errCount);
	});
	errMsg = Ext.util.checkRr(document.mainForm.vitalRr,document.getElementById("vitalRrTitle"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalRr',errMsg,errCount);
	
	vitalWeight = new Ext.form.TextField({
		fieldLabel: '',
		name: 'vitalWeight',
		maskRe : /[\d]/,
		validationEvent: false,
		allowBlank:true
	});
	vitalWeight.applyToMarkup(document.mainForm.vitalWeight); 
	Ext.get('vitalWeight').on('blur', function(){
		errMsg = Ext.util.checkWeight2(document.mainForm.vitalWeight,document.mainForm.vitalWeight1,document.getElementById("vitalWeightTitle"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeight',errMsg,errCount);
		errMsg = Ext.util.checkUnit2(document.mainForm.vitalWeight,document.mainForm.vitalWeight1,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr, true,document.getElementById("vitalWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
	
	});
	vitalWeight1 = new Ext.form.TextField({
		fieldLabel: '',
		name: 'vitalWeight',
		maskRe : /[\d]/,
		validationEvent: false,
		allowBlank:true
	});
	vitalWeight1.applyToMarkup(document.mainForm.vitalWeight1); 
	Ext.get('vitalWeight1').on('blur', function(){
		errMsg = Ext.util.checkWeight2(document.mainForm.vitalWeight,document.mainForm.vitalWeight1,document.getElementById("vitalWeightTitle"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeight',errMsg,errCount);
		errMsg = Ext.util.checkUnit2(document.mainForm.vitalWeight,document.mainForm.vitalWeight1,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr, true,document.getElementById("vitalWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
	
	});
	Ext.get('vitalWeightUnit1').on('click', function(){
		errMsg = Ext.util.checkUnit2(document.mainForm.vitalWeight,document.mainForm.vitalWeight1, document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr, true,document.getElementById("vitalWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
	
	}, document.getElementById(this.id), {delay: 5});
	Ext.get('vitalWeightUnit2').on('click', function(){
		errMsg = Ext.util.checkUnit2(document.mainForm.vitalWeight,document.mainForm.vitalWeight1,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr, true,document.getElementById("vitalWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
	
	}, document.getElementById(this.id), {delay: 5});
	errMsg = Ext.util.checkWeight2(document.mainForm.vitalWeight,document.mainForm.vitalWeight1,document.getElementById("vitalWeightTitle"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeight',errMsg,errCount);
	errMsg = Ext.util.checkUnit2(document.mainForm.vitalWeight,document.mainForm.vitalWeight1,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr, true,document.getElementById("vitalWeightUnitTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
 	
	Ext.get('motherPregWeeks').on('blur', function(){
		errMsg = Ext.util.isValueInBound(document.mainForm.motherPregWeeks,document.getElementById("motherPregWeeksTitle"),'0',41,'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'motherPregWeeks',errMsg,errCount);		
	
	});		
	errMsg = Ext.util.isValueInBound(document.mainForm.motherPregWeeks,document.getElementById("motherPregWeeksTitle"),'0',41,'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'motherPregWeeks',errMsg,errCount);		

	birthNNWeight = new Ext.form.TextField({
		fieldLabel: '',
		name: 'birthNNWeight',
		maskRe : /[\d]/,
		validationEvent: false,
		allowBlank:true
	});
	birthNNWeight.applyToMarkup(document.mainForm.birthNNWeight); 
	Ext.get('birthNNWeight').on('blur', function(){
		errMsg = Ext.util.checkWeight2(document.mainForm.birthNNWeight,document.mainForm.birthNNWeight1,document.getElementById("birthNNWeightTitle"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'birthNNWeight',errMsg,errCount);
		errMsg = Ext.util.checkUnit2(document.mainForm.birthNNWeight,document.mainForm.birthNNWeight1,document.getElementById("birthNNWeightUnit1"),document.getElementById("birthNNWeightUnit2"),radioArr, true,document.getElementById("birthNNWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'birthNNWeightUnit',errMsg,errCount);		
	});
	birthNNWeight1 = new Ext.form.TextField({
		fieldLabel: '',
		name: 'birthNNWeight1',
		maskRe : /[\d]/,
		validationEvent: false,
		allowBlank:true
	});
	birthNNWeight1.applyToMarkup(document.mainForm.birthNNWeight1); 
	Ext.get('birthNNWeight1').on('blur', function(){
		errMsg = Ext.util.checkWeight2(document.mainForm.birthNNWeight,document.mainForm.birthNNWeight1,document.getElementById("birthNNWeightTitle"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'birthNNWeight',errMsg,errCount);
		errMsg = Ext.util.checkUnit2(document.mainForm.birthNNWeight,document.mainForm.birthNNWeight1,document.getElementById("birthNNWeightUnit1"),document.getElementById("birthNNWeightUnit2"),radioArr, true,document.getElementById("birthNNWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'birthNNWeightUnit',errMsg,errCount);		
	});
	
	Ext.get('birthNNWeightUnit1').on('click', function(){
		errMsg = Ext.util.checkUnit2(document.mainForm.birthNNWeight,document.mainForm.birthNNWeight1,document.getElementById("birthNNWeightUnit1"),document.getElementById("birthNNWeightUnit2"),radioArr, true,document.getElementById("birthNNWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'birthNNWeightUnit',errMsg,errCount);		
	
	}, document.getElementById(this.id), {delay: 5});
	Ext.get('birthNNWeightUnit2').on('click', function(){
		errMsg = Ext.util.checkUnit2(document.mainForm.birthNNWeight,document.mainForm.birthNNWeight1,document.getElementById("birthNNWeightUnit1"),document.getElementById("birthNNWeightUnit2"),radioArr, true,document.getElementById("birthNNWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'birthNNWeightUnit',errMsg,errCount);		
	
	}, document.getElementById(this.id), {delay: 5});
	errMsg = Ext.util.checkWeight2(document.mainForm.birthNNWeight,document.mainForm.birthNNWeight1,document.getElementById("birthNNWeightTitle"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'birthNNWeight',errMsg,errCount);
	errMsg = Ext.util.checkUnit2(document.mainForm.birthNNWeight,document.mainForm.birthNNWeight1,document.getElementById("birthNNWeightUnit1"),document.getElementById("birthNNWeightUnit2"),radioArr, true,document.getElementById("birthNNWeightUnitTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'birthNNWeightUnit',errMsg,errCount);

	
	vitalBp1 = new Ext.form.TextField({
		fieldLabel: '',
		name: 'vitalBp1',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});
	vitalBp1.applyToMarkup(document.mainForm.vitalBp1);
	
	vitalBp2 = new Ext.form.TextField({
		fieldLabel: '',
		name: 'vitalBp2',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});
	vitalBp2.applyToMarkup(document.mainForm.vitalBp2); 
	
	Ext.get('vitalBp1').on('blur', function(){
		errMsg = Ext.util.checkBp1(document.mainForm.vitalBp1,document.getElementById("vitalBp1Title"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBp1',errMsg,errCount);
		errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1, document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"), document.getElementById("vitalBpUnit2"), radioArr, true, document.getElementById("vitalBpUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);
	});	
	Ext.get('vitalBp2').on('blur', function(){
		errMsg = Ext.util.checkBp2(document.mainForm.vitalBp2,document.getElementById("vitalBp2Title"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBp2',errMsg,errCount);
		errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"),radioArr, true,document.getElementById("vitalBpUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);
		
	});
	Ext.get('vitalBpUnit1').on('click', function(){
		errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"),radioArr, true,document.getElementById("vitalBpUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);
		
	}, document.getElementById(this.id), {delay: 5});
	Ext.get('vitalBpUnit2').on('click', function(){
		errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"),radioArr, true,document.getElementById("vitalBpUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);
		
	}, document.getElementById(this.id), {delay: 5});	
	
	errMsg = Ext.util.checkBp1(document.mainForm.vitalBp1,document.getElementById("vitalBp1Title"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBp1',errMsg,errCount);
	errMsg = Ext.util.checkBp2(document.mainForm.vitalBp2,document.getElementById("vitalBp2Title"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBp2',errMsg,errCount);
	errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"),radioArr, true,document.getElementById("vitalBpUnitTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);
	
	var vitalFormatArr = new Array();
	var vIdx = 0;
	vitalArr = new Array();
	vitalArr[0] = 'work';
	vitalArr[1] = 'pp';
	vitalArr[2] = 'a6';
	for(i=0;i<vitalArr.length;i++)
	{
		vitalFormatArr[vIdx] = new Ext.form.TextField({
			fieldLabel: '',
			maskRe : /[\d]/,
			validationEvent: false,
			allowBlank:true
		});
		vitalFormatArr[vIdx++].applyToMarkup(document.getElementById(vitalArr[i] + 'VitalTemp'));
		Ext.get(vitalArr[i] + 'VitalTemp').on('blur', function(){
			errMsg = Ext.util.checkTemp2(document.getElementById(this.id), document.getElementById(this.id + '1'),document.getElementById(this.id+'Unit1'),document.getElementById(this.id+'Unit2'), radioArr, true, document.getElementById(this.id + 'Title'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
			errMsg = Ext.util.checkUnit2(document.getElementById(this.id), document.getElementById(this.id + '1'),document.getElementById(this.id+'Unit1'),document.getElementById(this.id+'Unit2'), radioArr, true, document.getElementById(this.id + 'UnitTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id + 'Unit',errMsg,errCount);
		});
		//vitalFormatArr[vIdx] = new Ext.form.TextField({
		//	fieldLabel: '',
		//	maskRe : /[\d]/,
		//	validationEvent: false,
		//	allowBlank:true
		//});
		//vitalFormatArr[vIdx++].applyToMarkup(document.getElementById(vitalArr[i] + 'VitalTemp1'));
		Ext.get(vitalArr[i] + 'VitalTemp1').on('blur', function(){
			var root = this.id.substring(0,this.id.length-1);
			errMsg = Ext.util.checkTemp2(document.getElementById(root), document.getElementById(root+ '1'),document.getElementById(root+'Unit1'),document.getElementById(root+'Unit2'), radioArr, true, document.getElementById(root + 'Title'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root+'1',errMsg,errCount);
			errMsg = Ext.util.checkUnit2(document.getElementById(root), document.getElementById(root + '1'),document.getElementById(root+'Unit1'),document.getElementById(root+'Unit2'), radioArr, true, document.getElementById(root + 'UnitTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'Unit',errMsg,errCount);
		});
		Ext.get(vitalArr[i] + 'VitalTempUnit1').on('click', function(){
			var root = this.id.substring(0,this.id.length-5);
			errMsg = Ext.util.checkTemp2(document.getElementById(root), document.getElementById(root+ '1'),document.getElementById(root+'Unit1'),document.getElementById(root+'Unit2'), radioArr, true, document.getElementById(root + 'Title'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root+'1',errMsg,errCount);
			errMsg = Ext.util.checkUnit2(document.getElementById(root), document.getElementById(root + '1'),document.getElementById(root+'Unit1'),document.getElementById(root+'Unit2'), radioArr, true, document.getElementById(root + 'UnitTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'Unit',errMsg,errCount);
		}, document.getElementById(this.id), {delay: 5});
		Ext.get(vitalArr[i] + 'VitalTempUnit2').on('click', function(){
			var root = this.id.substring(0,this.id.length-5);
			errMsg = Ext.util.checkTemp2(document.getElementById(root), document.getElementById(root+ '1'),document.getElementById(root+'Unit1'),document.getElementById(root+'Unit2'), radioArr, true, document.getElementById(root + 'Title'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root+'1',errMsg,errCount);
			errMsg = Ext.util.checkUnit2(document.getElementById(root), document.getElementById(root + '1'),document.getElementById(root+'Unit1'),document.getElementById(root+'Unit2'), radioArr, true, document.getElementById(root + 'UnitTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'Unit',errMsg,errCount);
		}, document.getElementById(this.id), {delay: 5});
		errMsg = Ext.util.checkTemp2(document.getElementById(vitalArr[i] + 'VitalTemp'),document.getElementById(vitalArr[i] + 'VitalTemp1'),document.getElementById(vitalArr[i] + 'VitalTempUnit1'),document.getElementById(vitalArr[i] + 'VitalTempUnit2'),radioArr, true,document.getElementById(vitalArr[i] + 'VitalTempTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,vitalArr[i] + 'VitalTemp',errMsg,errCount);
		errMsg = Ext.util.checkUnit2(document.getElementById(vitalArr[i] + 'VitalTemp'),document.getElementById(vitalArr[i] + 'VitalTemp1'),document.getElementById(vitalArr[i] + 'VitalTempUnit1'),document.getElementById(vitalArr[i] + 'VitalTempUnit2'),radioArr, true,document.getElementById(vitalArr[i] + 'VitalTempUnitTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,vitalArr[i] + 'VitalTempUnit',errMsg,errCount);
		vitalFormatArr[vIdx] = new Ext.form.TextField({
			fieldLabel: '',
			maskRe : /[\d\.]/,
			validationEvent: false,
			allowBlank:true
		});
		vitalFormatArr[vIdx++].applyToMarkup(document.getElementById(vitalArr[i] + 'VitalRr'));		
		Ext.get(vitalArr[i] + 'VitalRr').on('blur', function(){
			errMsg = Ext.util.checkRr(document.getElementById(this.id),document.getElementById(this.id+'Title'),'');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
		});
		errMsg = Ext.util.checkRr(document.getElementById(vitalArr[i] + 'VitalRr'),document.getElementById(vitalArr[i] + 'VitalRrTitle'),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,vitalArr[i] + 'VitalRr',errMsg,errCount);
		vitalFormatArr[vIdx] = new Ext.form.TextField({
			fieldLabel: '',
			maskRe : /[\d\.]/,
			validationEvent: false,
			allowBlank:true
		});
		vitalFormatArr[vIdx++].applyToMarkup(document.getElementById(vitalArr[i] + 'VitalHr'));			
		Ext.get(vitalArr[i] + 'VitalHr').on('blur', function(){
			errMsg = Ext.util.checkHr(document.getElementById(this.id),document.getElementById(this.id+'Title'),'');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
		});
		errMsg = Ext.util.checkHr(document.getElementById(vitalArr[i] + 'VitalHr'),document.getElementById(vitalArr[i] + 'VitalHrTitle'),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,vitalArr[i] + 'VitalHr',errMsg,errCount);
		
		vitalFormatArr[vIdx] = new Ext.form.TextField({
			fieldLabel: '',
			maskRe : /[\d\.]/,
			validationEvent: false,
			allowBlank:true
		});
		vitalFormatArr[vIdx++].applyToMarkup(document.getElementById(vitalArr[i] + 'VitalBp1'));	
		Ext.get(vitalArr[i] + 'VitalBp1').on('blur', function(){
			var root = this.id.substring(0, this.id.length-1);
			errMsg = Ext.util.checkBp1(document.getElementById(root + '1'),document.getElementById(root+'1Title'),'');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root + '1',errMsg,errCount);
			errMsg = Ext.util.checkBPUnit(document.getElementById(root + '1'),document.getElementById(root + '2'), document.getElementById(root +'Unit1'),document.getElementById(root +'Unit2'),radioArr, true,document.getElementById(root + 'UnitTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'Unit',errMsg,errCount);
		});
		vitalFormatArr[vIdx] = new Ext.form.TextField({
			fieldLabel: '',
			maskRe : /[\d\.]/,
			validationEvent: false,
			allowBlank:true
		});
		vitalFormatArr[vIdx++].applyToMarkup(document.getElementById(vitalArr[i] + 'VitalBp2'));
		Ext.get(vitalArr[i] + 'VitalBp2').on('blur', function(){
			var root = this.id.substring(0, this.id.length-1);
			errMsg = Ext.util.checkBp2(document.getElementById(root + '2'),document.getElementById(root+'2Title'),'');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root + '2',errMsg,errCount);
			errMsg = Ext.util.checkBPUnit(document.getElementById(root + '1'),document.getElementById(root + '2'), document.getElementById(root +'Unit1'),document.getElementById(root +'Unit2'),radioArr, true,document.getElementById(root + 'UnitTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'Unit',errMsg,errCount);
			
		});
		Ext.get(vitalArr[i] + 'VitalBpUnit1').on('click', function(){
			var root = this.id.substring(0, this.id.length-5);
			errMsg = Ext.util.checkBPUnit(document.getElementById(root + '1'),document.getElementById(root + '2'), document.getElementById(root +'Unit1'),document.getElementById(root +'Unit2'),radioArr, true,document.getElementById(root + 'UnitTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'Unit',errMsg,errCount);
			
		}, document.getElementById(this.id), {delay: 5});
		Ext.get(vitalArr[i] + 'VitalBpUnit2').on('click', function(){
			var root = this.id.substring(0, this.id.length-5);
			errMsg = Ext.util.checkBPUnit(document.getElementById(root + '1'),document.getElementById(root + '2'), document.getElementById(root +'Unit1'),document.getElementById(root +'Unit2'),radioArr, true,document.getElementById(root + 'UnitTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'Unit',errMsg,errCount);
		}, document.getElementById(this.id), {delay: 5});
		errMsg = Ext.util.checkBp1(document.getElementById(vitalArr[i] + 'VitalBp1'),document.getElementById(vitalArr[i] + 'VitalBp1Title'),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,vitalArr[i]  + 'VitalBp1',errMsg,errCount);
		errMsg = Ext.util.checkBp2(document.getElementById(vitalArr[i] + 'VitalBp2'),document.getElementById(vitalArr[i] + 'VitalBp2Title'),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,vitalArr[i]  + 'VitalBp2',errMsg,errCount);
		errMsg = Ext.util.checkBPUnit(document.getElementById(vitalArr[i] + 'VitalBp1'),document.getElementById(vitalArr[i] + 'VitalBp2'), document.getElementById(vitalArr[i] + 'VitalBpUnit1'),document.getElementById(vitalArr[i] + 'VitalBpUnit2'),radioArr, true,document.getElementById(vitalArr[i] + 'VitalBpUnitTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,vitalArr[i] + 'VitalBpUnit',errMsg,errCount);

		vitalFormatArr[vIdx] = new Ext.form.TextField({
			fieldLabel: '',
			maskRe : /[\d]/,
			validationEvent: false,
			allowBlank:true
		});
		vitalFormatArr[vIdx++].applyToMarkup(document.getElementById(vitalArr[i] + 'VitalWeight'));
		Ext.get(vitalArr[i] + 'VitalWeight').on('blur', function(){
			errMsg = Ext.util.checkWeight2(document.getElementById(this.id),document.getElementById(this.id+'1'),document.getElementById(this.id+'Title'),'');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
			errMsg = Ext.util.checkUnit2(document.getElementById(this.id),document.getElementById(this.id+'1'),document.getElementById(this.id+'Unit1'),document.getElementById(this.id+'Unit2'),radioArr, true,document.getElementById(this.id+'UnitTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id+'Unit',errMsg,errCount);		
		});
		//vitalFormatArr[vIdx] = new Ext.form.TextField({
		//	fieldLabel: '',
		//	maskRe : /[\d]/,
		//	validationEvent: false,
		//	allowBlank:true
		//});
		//vitalFormatArr[vIdx++].applyToMarkup(document.getElementById(vitalArr[i] + 'VitalWeight1'));
		Ext.get(vitalArr[i] + 'VitalWeight1').on('blur', function(){
			var root = this.id.substring(0, this.id.length-1);
			errMsg = Ext.util.checkWeight2(document.getElementById(root),document.getElementById(root+'1'),document.getElementById(root+'Title'),'');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root,errMsg,errCount);
			errMsg = Ext.util.checkUnit2(document.getElementById(root),document.getElementById(root+'1'),document.getElementById(root+'Unit1'),document.getElementById(root+'Unit2'),radioArr, true,document.getElementById(root+'UnitTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root+'Unit',errMsg,errCount);		
		});
		Ext.get(vitalArr[i] + 'VitalWeightUnit1').on('click', function(){
			var root = this.id.substring(0, this.id.length-5);
			errMsg = Ext.util.checkUnit2(document.getElementById(root),document.getElementById(root+'1'),document.getElementById(root+'Unit1'),document.getElementById(root+'Unit2'),radioArr, true,document.getElementById(root+'UnitTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root+'Unit',errMsg,errCount);	
		}, document.getElementById(this.id), {delay: 5});
		Ext.get(vitalArr[i] + 'VitalWeightUnit2').on('click', function(){
			var root = this.id.substring(0, this.id.length-5);
			errMsg = Ext.util.checkUnit2(document.getElementById(root),document.getElementById(root+'1'),document.getElementById(root+'Unit1'),document.getElementById(root+'Unit2'),radioArr, true,document.getElementById(root+'UnitTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root+'Unit',errMsg,errCount);	
		}, document.getElementById(this.id), {delay: 5});
		errMsg = Ext.util.checkWeight2(document.getElementById(vitalArr[i] + 'VitalWeight'),document.getElementById(vitalArr[i] + 'VitalWeight1'),document.getElementById(vitalArr[i] + 'VitalWeightTitle'),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,vitalArr[i] + 'VitalWeight',errMsg,errCount);
		errMsg = Ext.util.checkUnit2(document.getElementById(vitalArr[i] + 'VitalWeight'),document.getElementById(vitalArr[i] + 'VitalWeight1'),document.getElementById(vitalArr[i] + 'VitalWeightUnit1'),document.getElementById(vitalArr[i] + 'VitalWeightUnit2'),radioArr, true,document.getElementById(vitalArr[i] + 'VitalWeightUnitTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,root+'VitalWeightUnit',errMsg,errCount);	
	
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
	

});


