
Ext.onReady(function() {
	var txtFormat = new Array();
	var root;
	var suffix;
	var i;
	var suffix70;
	var prefix4;
	var root;
	var startMm,startYy,startErrLoc,stopMm,stopYy,stopErrLoc,continuing,continuingErrLoc;
	var reasonsErrLoc;
	var sexFlg = Ext.getDom('sex1').value;
	var startErrMsg, stopErrMsg;
	var reasonArr = new Array();
	var clinicalExamFormat = new Array(1);
	var conditionSection = new Array(1);
	vitalTemp = new Ext.form.TextField({
		fieldLabel: '',
		name: 'vitalTemp',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});
	vitalTemp.applyToMarkup(document.mainForm.vitalTemp);	

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
	errMsg = Ext.util.checkBp1(document.mainForm.vitalHr,document.getElementById("vitalHrTitle"),'');
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

	
	vitalWeight = new Ext.form.TextField({
		fieldLabel: '',
		name: 'vitalWeight',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});

	vitalWeight.applyToMarkup(document.mainForm.vitalWeight); 

 	vitalPrevWt = new Ext.form.TextField({
		fieldLabel: '',
		name: 'vitalPrevWt',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});

	vitalPrevWt.applyToMarkup(document.mainForm.vitalPrevWt); 

	
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
	
	var positiveFieldArr = new Array();
	positiveFieldArr[0] = 'gravida';
	positiveFieldArr[1] = 'para';
	positiveFieldArr[2] = 'aborta';
	positiveFieldArr[3] = 'children';

	for(i = 0; i < positiveFieldArr.length; i++)
	{
		Ext.get(positiveFieldArr[i]).on('blur', function(){
			errMsg = Ext.util.isValueInBound(document.getElementById(this.id),document.getElementById(this.id + "Title"),'0','','');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);

		});
		
		errMsg = Ext.util.isValueInBound(document.getElementById(positiveFieldArr[i]),document.getElementById(positiveFieldArr[i] + "Title"),'0','','');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,positiveFieldArr[i],errMsg,errCount);
	}

//	(Ext.get('dmType1Active')).on('change', function(){
//		Ext.util.checkUnique2(document.getElementById('dmType1Active'),document.getElementById('dmType2Active'));
//	});
//	(Ext.get('dmType2Active')).on('change', function(){
//		Ext.util.checkUnique2(document.getElementById('dmType2Active'),document.getElementById('dmType1Active'));
//	});

	Ext.get('transferIn').on('click', function(){
		errMsg = Ext.util.checkCheckboxCorresponding1(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),document.getElementById("transferInTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'transferIn',errMsg,errCount);
		errMsg = Ext.util.checkTextCorresponding(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),document.getElementById("firstCareOtherFacTextTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstCareOtherFacText',errMsg,errCount);
		errMsg = Ext.util.checkDateCorresponding1(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),'',document.getElementById("firstCareOtherDTTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstCareOtherDT',errMsg,errCount);
	
	});	
	Ext.get('firstCareOtherFacText').on('blur', function(){
		errMsg = Ext.util.checkCheckboxCorresponding1(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),document.getElementById("transferInTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'transferIn',errMsg,errCount);
		errMsg = Ext.util.checkTextCorresponding(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),document.getElementById("firstCareOtherFacTextTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstCareOtherFacText',errMsg,errCount);
		errMsg = Ext.util.checkDateCorresponding1(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),'',document.getElementById("firstCareOtherDTTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstCareOtherDT',errMsg,errCount);	
	
	});
	txtFormat['firstCareOtherDT'] = new Ext.form.DateField({
		fieldLabel: '',
		maskRe : /[\d{1,2}\/]/,
		validationEvent: false,
		allowBlank:true,
		disabled: false
	});
	txtFormat['firstCareOtherDT'].applyToMarkup(document.getElementById('firstCareOtherDT'));
	Ext.get('firstCareOtherDT').on('blur', function(){
		errMsg = Ext.util.checkCheckboxCorresponding1(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),document.getElementById("transferInTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'transferIn',errMsg,errCount);
		errMsg = Ext.util.checkTextCorresponding(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),document.getElementById("firstCareOtherFacTextTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstCareOtherFacText',errMsg,errCount);
		errMsg = Ext.util.checkDateCorresponding1(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),'',document.getElementById("firstCareOtherDTTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstCareOtherDT',errMsg,errCount);
		Ext.util.splitDate(document.getElementById('firstCareOtherDT'),document.getElementById('firstCareOtherDd'),document.getElementById('firstCareOtherMm'),document.getElementById('firstCareOtherYy'));
	
	});
	errMsg = Ext.util.checkCheckboxCorresponding1(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),document.getElementById("transferInTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'transferIn',errMsg,errCount);
	errMsg = Ext.util.checkTextCorresponding(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),document.getElementById("firstCareOtherFacTextTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstCareOtherFacText',errMsg,errCount);
	errMsg = Ext.util.checkDateCorresponding1(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),'',document.getElementById("firstCareOtherDTTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstCareOtherDT',errMsg,errCount);
	Ext.util.splitDate(document.getElementById('firstCareOtherDT'),document.getElementById('firstCareOtherDd'),document.getElementById('firstCareOtherMm'),document.getElementById('firstCareOtherYy'));

	var names = new Array();
	names[0] = "famPlan";
	names[1] = "conditions";
	names[2] = "arvPrevious";
	names[3] = "medAllergy";
	names[4] = "oh1";
	names[5] = "oh2";
	names[6] = "oh3";
	names[7] = "arvExcl";
	names[8] = "bloodTrans";
	names[9] = "bloodExp";
	names[10] = "papTest";
	names[11]  = 'clinicalExam';
	
	var allElements = Ext.util.getAllElements(document.mainForm,names);

	var txtArr = allElements["text"];
	var tempRadioArr = allElements["radio"]; 
	var radioArr = Ext.util.getAllRadios(tempRadioArr);	
    var j = 0;
	for(i=0;i<txtArr.length;i++)
	
	{	

		suffix = txtArr[i].id.substring(txtArr[i].id.length-2);	
	
		if(suffix == 'Dt')
		{
			txtFormat[txtArr[i].id] = new Ext.form.DateField({
				fieldLabel: '',
				maskRe : /[\Xx{1,2}\d{1,2}\/]/,
				validationEvent: false,
				allowBlank:true
			});

			txtFormat[txtArr[i].id].applyToMarkup(txtArr[i]);
			if(txtArr[i].id!='bloodTransDt' && txtArr[i].id!='bloodExpDt' && txtArr[i].id != 'completeTreatDt')
			{
				(Ext.get(txtArr[i].id)).on('blur', function(){
					errMsg =  Ext.util.validateDateFieldNonPatient(document.getElementById(this.id),document.getElementById(this.id + "Title"),'');
					Ext.util.splitDate(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-2) + "Dd"),document.getElementById(this.id.substring(0,this.id.length-2) + "Mm"),document.getElementById(this.id.substring(0,this.id.length-2) + "Yy"));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg,errCount);

				});
				errMsg = Ext.util.validateDateFieldNonPatient(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id + "Title"),'');
				Ext.util.splitDate(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Dd"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Mm"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Yy"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2),errMsg,errCount);
			}
		}  
	  else if(suffix == 'Mm' || suffix == 'Yy' || suffix == 'MM' || suffix == 'YY'  )
		{
			txtFormat[i] = new Ext.form.TextField({
				fieldLabel: '',
				maskRe : /[\Xx{1,2}\Nn{1,2}\d{1,2}\/]/,
				validationEvent: false,
				allowBlank:true
			});

			txtFormat[i].applyToMarkup(txtArr[i]);
			if(suffix == 'Mm' || suffix == 'Yy')
			{
				prefix4 = txtArr[i].id.substring(0,4);
				if(prefix4 == "arv_")
				{
					suffix70 = txtArr[i].id.substring(txtArr[i].id.length-7, txtArr[i].id.length);
					if(suffix70 == 'StartMm')
					{
						root = txtArr[i].id.substring(0,txtArr[i].id.length-7);

						(Ext.get(root+"StartMm")).on('blur', function(){
							startErrMsg = Ext.util.validateMY(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-7)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"StartTitle"), 'XX', '');
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7) + 'Start',startErrMsg,errCount);
							if(startErrMsg == '')
							{
								startErrMsg =  Ext.util.checkDtContinuing(document.getElementById(this.id.substring(0,this.id.length-7)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-7)+"StartTitle"));
						
								errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7)+"Start",startErrMsg,errCount);						

							}							
							
							stopErrMsg =  Ext.util.validateMY(document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopTitle"),'XX','');
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7) + 'Stop',stopErrMsg,errCount);
							if(startErrMsg == '' && stopErrMsg == '')
							{
								errMsg = Ext.util.checkStartStopDate(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-7)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"StartTitle"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopTitle"),'XX');
								errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7),errMsg,errCount);
							}
							errMsg =  Ext.util.checkDrugContinuing1(document.getElementById(this.id.substring(0,this.id.length-7)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-7)+"ContinuedTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7)+"Continued",errMsg,errCount);						
							errMsg =  Ext.util.checkDrugReasons(document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-7)+"finPTME"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7)+"Disc",errMsg,errCount);
						});
				
						(Ext.get(root+"StartYy")).on('blur', function(){
			
							startErrMsg = Ext.util.validateMY(document.getElementById(this.id.substring(0,this.id.length-7)+"StartMm"),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-7)+"StartTitle"), 'XX', '');
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7) + 'Start',startErrMsg,errCount);
							if(startErrMsg == '')
							{
								startErrMsg =  Ext.util.checkDtContinuing(document.getElementById(this.id.substring(0,this.id.length-7)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-7)+"StartTitle"));
						
								errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7)+"Start",startErrMsg,errCount);						

							}							
							stopErrMsg =  Ext.util.validateMY(document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopTitle"), 'XX','');
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7) + 'Stop',stopErrMsg,errCount);
							if(startErrMsg == '' && stopErrMsg == '')
							{
								errMsg = Ext.util.checkStartStopDate(document.getElementById(this.id.substring(0,this.id.length-7)+"StartMm"),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-7)+"StartTitle"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopTitle"),'XX');
								errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7),errMsg,errCount);
							}
							
							errMsg =  Ext.util.checkDrugContinuing1(document.getElementById(this.id.substring(0,this.id.length-7)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-7)+"ContinuedTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7)+"Continued",errMsg,errCount);						
							errMsg =  Ext.util.checkDrugReasons(document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-7)+"finPTME"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7)+"Disc",errMsg,errCount);
							
						});
						(Ext.get(root+"StopMm")).on('blur', function(){
							startErrMsg = Ext.util.validateMY(document.getElementById(this.id.substring(0,this.id.length-6)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartTitle"), 'XX', '');
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + 'Start',startErrMsg,errCount);
							if(startErrMsg == '')
							{
								startErrMsg =  Ext.util.checkDtContinuing(document.getElementById(this.id.substring(0,this.id.length-6)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartTitle"));
								errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6)+"Start",startErrMsg,errCount);						

							}							
														
							
							stopErrMsg =  Ext.util.validateMY(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopTitle"), 'XX','');
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + 'Stop',stopErrMsg,errCount);
							if(startErrMsg == '' && stopErrMsg == '')
							{
								errMsg = Ext.util.checkStartStopDate(document.getElementById(this.id.substring(0,this.id.length-6)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartTitle"),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopTitle"),'XX');
								errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6),errMsg,errCount);
							}
							errMsg =  Ext.util.checkDrugContinuing1(document.getElementById(this.id.substring(0,this.id.length-6)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartYy"),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-6)+"ContinuedTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6)+"Continued",errMsg,errCount);
							errMsg =  Ext.util.checkDrugReasons(document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-6)+"finPTME"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6)+"Disc",errMsg,errCount);
						});
						(Ext.get(root+"StopYy")).on('blur', function(){
							startErrMsg = Ext.util.validateMY(document.getElementById(this.id.substring(0,this.id.length-6)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartTitle"), 'XX', '');
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + 'Start',startErrMsg,errCount);
							if(startErrMsg == '')
							{
								startErrMsg =  Ext.util.checkDtContinuing(document.getElementById(this.id.substring(0,this.id.length-6)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartTitle"));
								errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6)+"Start",startErrMsg,errCount);						

							}								
							stopErrMsg =  Ext.util.validateMY(document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6)+"StopTitle"), 'XX','');
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + 'Stop',stopErrMsg,errCount);
							if(startErrMsg == '' && stopErrMsg == '')
							{
								errMsg = Ext.util.checkStartStopDate(document.getElementById(this.id.substring(0,this.id.length-6)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartTitle"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6)+"StopTitle"),'XX');
								errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6),errMsg,errCount);
							}
							errMsg =  Ext.util.checkDrugContinuing1(document.getElementById(this.id.substring(0,this.id.length-6)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-6)+"ContinuedTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6)+"Continued",errMsg,errCount);						
							errMsg =  Ext.util.checkDrugReasons(document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-6)+"finPTME"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6)+"Disc",errMsg,errCount);
					
						});
						(Ext.get(root+"Continued")).on('click', function(){
							errMsg =  Ext.util.checkDtContinuing(document.getElementById(this.id.substring(0,this.id.length-9)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-9)+"StartTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9)+"Start",errMsg,errCount);						
					
							errMsg =  Ext.util.checkDrugContinuing1(document.getElementById(this.id.substring(0,this.id.length-9)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopYy"),document.getElementById(this.id),document.getElementById(this.id + "Title"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
						});
						(Ext.get(root+"DiscTox")).on('click', function(){
							errMsg =  Ext.util.checkDrugReasons(document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-7)+"finPTME"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7)+"Disc",errMsg,errCount);

						});
						(Ext.get(root+"DiscIntol")).on('click', function(){
							errMsg =  Ext.util.checkDrugReasons(document.getElementById(this.id.substring(0,this.id.length-9)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-9)+"finPTME"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9)+"Disc",errMsg,errCount);
						});
						(Ext.get(root+"DiscFail")).on('click', function(){
							errMsg =  Ext.util.checkDrugReasons(document.getElementById(this.id.substring(0,this.id.length-8)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-8)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-8)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-8)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-8)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-8)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-8)+"finPTME"),document.getElementById(this.id.substring(0,this.id.length-8)+"DiscTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-8)+"Disc",errMsg,errCount);
						});
						(Ext.get(root+"DiscUnknown")).on('click', function(){
							errMsg =  Ext.util.checkDrugReasons(document.getElementById(this.id.substring(0,this.id.length-11)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-11)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-11)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-11)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-11)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-11)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-11)+"finPTME"),document.getElementById(this.id.substring(0,this.id.length-11)+"DiscTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-11)+"Disc",errMsg,errCount);
						});
						(Ext.get(root+"finPTME")).on('click', function(){
							errMsg =  Ext.util.checkDrugReasons(document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-7)+"finPTME"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7)+"Disc",errMsg,errCount);
						});
													
						startErrMsg = Ext.util.validateMY(document.getElementById(root+"StartMm"),document.getElementById(root+"StartYy"),document.getElementById(root+"StartTitle"), 'XX', '');
						errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'Start',startErrMsg,errCount);
						if(startErrMsg == '')
						{
							startErrMsg =  Ext.util.checkDtContinuing(document.getElementById(root+"StartMm"),document.getElementById(root+"StartYy"),document.getElementById(root+"StopMm"),document.getElementById(root+"StopYy"),document.getElementById(root+"Continued"),document.getElementById(root+"StartTitle"));

							errCount = Ext.util.showErrorHead(errFields,errMsgs,root +"Start",startErrMsg,errCount);						

						}						
						stopErrMsg =  Ext.util.validateMY(document.getElementById(root+"StopMm"),document.getElementById(root+"StopYy"),document.getElementById(root+"StopTitle"), 'XX','');
						errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'Stop',stopErrMsg,errCount);
						if(startErrMsg == '' && stopErrMsg == '')
						{
							errMsg = Ext.util.checkStartStopDate(document.getElementById(root+"StartMm"),document.getElementById(root+"StartYy"),document.getElementById(root+"StartTitle"),document.getElementById(root + "StopMm"),document.getElementById(root+"StopYy"),document.getElementById(root+"StopTitle"),'XX');
							errCount = Ext.util.showErrorHead(errFields,errMsgs,root ,errMsg,errCount);
						}
						errMsg =  Ext.util.checkDrugContinuing1(document.getElementById(root+"StartMm"),document.getElementById(root+"StartYy"),document.getElementById(root+"StopMm"),document.getElementById(root+"StopYy"),document.getElementById(root+"Continued"),document.getElementById(root+"ContinuedTitle"));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,root+"Continued",errMsg,errCount);
						errMsg =  Ext.util.checkDrugReasons(document.getElementById(root+"StopMm"),document.getElementById(root+"StopYy"),document.getElementById(root+"DiscTox"),document.getElementById(root+"DiscIntol"),document.getElementById(root+"DiscFail"),document.getElementById(root+"DiscUnknown"),document.getElementById(root+"finPTME"),document.getElementById(root+"DiscTitle"));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,root+"Disc",errMsg,errCount);
					}
					
				}
				else
				{
					(Ext.get(txtArr[i].id)).on('blur', function(){
						errMsg = Ext.util.validateMY(document.getElementById(this.id.substring(0, this.id.length-2)+"Mm"),document.getElementById(this.id.substring(0, this.id.length-2)+"Yy"),document.getElementById(this.id.substring(0, this.id.length-2)+"Title"),"XX");
						errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2),errMsg,errCount);

					});
					Ext.util.validateMY(document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Mm"),document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Yy"),document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Title"),"XX");
					errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2),errMsg,errCount);

				}
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


	var taArr = allElements["textarea"];
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

	Ext.get('completeTreatDt').on('blur',function() {
                errMsg = Ext.util.validateAdultTbStatusSection(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatFac'),document.getElementById('completeTreatTitle'),document.getElementById('completeTreatDtTitle'),document.getElementById('completeTreatFacTitle'));
	});
	Ext.get('completeTreatFac').on('blur',function() {
                errMsg = Ext.util.validateAdultTbStatusSection(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatFac'),document.getElementById('completeTreatTitle'),document.getElementById('completeTreatDtTitle'),document.getElementById('completeTreatFacTitle'));
	});
        errMsg = Ext.util.validateAdultTbStatusSection(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatFac'),document.getElementById('completeTreatTitle'),document.getElementById('completeTreatDtTitle'),document.getElementById('completeTreatFacTitle'));
	Ext.get('currentTreatNo').on('blur',function() {
                errMsg = Ext.util.validateAdultTbStatusSection(document.getElementById('currentTreat[]'),document.getElementById('currentTreatNo'),document.getElementById('currentTreatFac'),document.getElementById('currentTreatTitle'),document.getElementById('currentTreatNoTitle'),document.getElementById('currentTreatFacTitle'));
	});
	Ext.get('currentTreatFac').on('blur',function() {
                errMsg = Ext.util.validateAdultTbStatusSection(document.getElementById('currentTreat[]'),document.getElementById('currentTreatNo'),document.getElementById('currentTreatFac'),document.getElementById('currentTreatTitle'),document.getElementById('currentTreatNoTitle'),document.getElementById('currentTreatFacTitle'));
	});
        errMsg = Ext.util.validateAdultTbStatusSection(document.getElementById('currentTreat[]'),document.getElementById('currentTreatNo'),document.getElementById('currentTreatFac'),document.getElementById('currentTreatTitle'),document.getElementById('currentTreatNoTitle'),document.getElementById('currentTreatFacTitle'));

	
	var taArr = Ext.util.getElementsByType(document.mainForm,"textarea");
	var taFormat = new Array();
	for(i=0;i<taArr.length;i++)
	{
			if(taArr[i].name == 'clinicalExam')
			{
				taFormat[i] = new Ext.form.TextField({
					fieldLabel: '',
					validationEvent: false,
					allowBlank:true
				});
				taFormat[i].applyToMarkup(taArr[i]);
			}
			else
			{
				clinicalExamFormat[0] =  new Ext.form.TextField({
					fieldLabel: '',
					validationEvent: false,
					allowBlank:true
				});
				clinicalExamFormat[0].applyToMarkup(taArr[i]);
			}
		
	}
	

	if( sexFlg == '2')
	{
		var oHistArray = new Array(3);
		oHistArray[0] = document.getElementsByName('papTest[]');
		oHistArray[1] = document.getElementsByName('pregnant[]');
		oHistArray[2] = document.getElementsByName('pregnantPrenatal[]');
		var j;
		for(i = 0;i<oHistArray.length;i++)
		{
			for(j = 0; j < oHistArray[i].length; j++)
			{
				oHistArray[i][j].disabled = true;
			}
		}
	}

	var arvPregArray = new Array(4);
	arvPregArray[0] = document.getElementById("zidovudineARVpreg[]");
	arvPregArray[1] = document.getElementById("nevirapineARVpreg[]");
	arvPregArray[2] = document.getElementById("unknownARVpreg[]");
	arvPregArray[3] = document.getElementById("otherARVpreg[]");

	for(i = 0; i < arvPregArray.length; i++) {
	        Ext.get(arvPregArray[i]).on('click', function(){
                        var key = Ext.util.getKeyByID(arvPregArray, this.id);
                        Ext.util.toggleHiddenValues(arvPregArray, key);
	        }, document.getElementById(this.id), {delay: 5});
        }

	var labOrDrugArray = new Array(4);
	labOrDrugArray[0] = document.getElementById("labOrDrugForm1");
	labOrDrugArray[1] = document.getElementById("labOrDrugForm2");
	labOrDrugArray[2] = document.getElementById("labOrDrugForm4");
	labOrDrugArray[3] = document.getElementById("labOrDrugForm8");

	Ext.get('labOrDrugForm1').on('click', function(){
//		if(Ext.util.compareBin(document.getElementById('labOrDrugForm').value,1)) 
//		{
//				document.getElementById('labOrDrugForm').value -=  2;
//		}
//		document.getElementById('labOrDrugForm').value =  Number(document.getElementById('labOrDrugForm').value) + 1;
                Ext.util.computeHiddenValue(document.getElementById('labOrDrugForm'), labOrDrugArray);
	}, document.getElementById(this.id), {delay: 5});
	Ext.get('labOrDrugForm2').on('click', function(){
//		if(Ext.util.compareBin(document.getElementById('labOrDrugForm').value,0)) 
//		{
//				document.getElementById('labOrDrugForm').value -=  1;
//		}
//		document.getElementById('labOrDrugForm').value =   Number(document.getElementById('labOrDrugForm').value) + 2;
                Ext.util.computeHiddenValue(document.getElementById('labOrDrugForm'), labOrDrugArray);
	}, document.getElementById(this.id), {delay: 5});
	Ext.get('labOrDrugForm4').on('click', function(){
//		if(Ext.util.compareBin(document.getElementById('labOrDrugForm').value,3)) 
//		{
//				document.getElementById('labOrDrugForm').value -=  8;
//		}
//		document.getElementById('labOrDrugForm').value =   Number(document.getElementById('labOrDrugForm').value) + 4;
                Ext.util.computeHiddenValue(document.getElementById('labOrDrugForm'), labOrDrugArray);
	}, document.getElementById(this.id), {delay: 5});
	Ext.get('labOrDrugForm8').on('click', function(){
//		if(Ext.util.compareBin(document.getElementById('labOrDrugForm').value,2)) 
//		{
//				document.getElementById('labOrDrugForm').value -=  4;
//		}
//		document.getElementById('labOrDrugForm').value =  Number(document.getElementById('labOrDrugForm').value) + 8;
                Ext.util.computeHiddenValue(document.getElementById('labOrDrugForm'), labOrDrugArray);
	}, document.getElementById(this.id), {delay: 5});

	var loadArr = new Array(2);
	loadArr[0] = 'lowestCd4Cnt';
	loadArr[1] = 'firstViralLoad';
	for(i = 0; i < loadArr.length; i++)
	{
			(Ext.get(loadArr[i])).on('blur', function(){
				errMsg = Ext.util.isValueInBound(document.getElementById(this.id),document.getElementById(this.id + 'Title'),'0','','');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);	
			});
			errMsg = Ext.util.isValueInBound(document.getElementById(loadArr[i]),document.getElementById(loadArr[i] + 'Title'),'0','','');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,loadArr[i],errMsg,errCount);				
	}
	var whoStages = new Array(9);
	whoStages[0] = document.getElementById('asymptomaticWho');
	whoStages[1] = document.getElementById('weightLossLessTenPercMo');
	whoStages[2] = document.getElementById('weightLossPlusTenPercMo');
	whoStages[3] = document.getElementById('wtLossTenPercWithDiarrMo');
	whoStages[4] = document.getElementById('chronicWeakness');
	whoStages[5] = document.getElementById('feverLessMo');
	whoStages[6] = document.getElementById('feverPlusMo');
	whoStages[7] = document.getElementById('diarrheaLessMo');
	whoStages[8] = document.getElementById('diarrheaPlusMo');
	for(i=0;i<whoStages.length;i++)
	{
		Ext.get(whoStages[i].id).on('click', function(){
			errMsg = Ext.util.checkWhoStage(whoStages,document.getElementById('whoStageTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'whoStage',errMsg,errCount);
		});
	}
	var clinicalExamArr = Ext.util.getNewRadios(allElements['clinicalExam']);
	Ext.get('physicalDone').on('click', function(){	
		Ext.util.disableSectionByRadio(document.getElementById('physicalDone'), radioArr, true, clinicalExamArr);
		clinicalExamFormat[0].disabled = document.getElementById('physicalDone').checked;
	});
	Ext.util.disableSectionByRadio(document.getElementById('physicalDone'), radioArr, true, clinicalExamArr);
	clinicalExamFormat[0].disabled = document.getElementById('physicalDone').checked;
	
	var dtFlg = document.getElementById('bloodTransDt') == null?false:true;
	if(dtFlg)
        {
		var bloodTransArr = new Array();
		bloodTransArr[0] = "bloodTransAnswer0";
		bloodTransArr[1] = "bloodTransAnswer1";
		//bloodTransArr[2] = "bloodTransAnswer2";
		for(i = 0; i < 2; i++)
		{
			Ext.get('bloodTransAnswer'+i).on('click', function(){
				var bTAArr = new Array();
				bTAArr[0] = document.getElementById('bloodTransDt');
			Ext.util.disableSectionByInternalRadio(document.getElementById('bloodTransAnswer0'), bTAArr, txtFormat, radioArr, true);
			errMsg = Ext.util.checkRadioCorresponding4IE7(document.getElementById('bloodTransAnswer0'),document.getElementById('bloodTransDt'),radioArr, true, document.getElementById('bloodTransAnswerTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodTransAnswer[]',errMsg,errCount);

			errMsg = Ext.util.checkDateCorresponding4IE7(document.getElementById('bloodTransAnswer0'),document.getElementById('bloodTransDt'), radioArr, true, document.getElementById('bloodTransDtTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodTransDt',errMsg,errCount);

		        }, document.getElementById(this.id), {delay: 5});
                }	
	        Ext.get('bloodTransDt').on('blur',function() {
		        errMsg = Ext.util.checkRadioCorresponding4IE7(document.getElementById('bloodTransAnswer0'),document.getElementById('bloodTransDt'),radioArr, true, document.getElementById('bloodTransAnswerTitle'));
		        errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodTransAnswer[]',errMsg,errCount);
		        errMsg = Ext.util.checkDateCorresponding4IE7(document.getElementById('bloodTransAnswer0'),document.getElementById('bloodTransDt'),radioArr, true, document.getElementById('bloodTransDtTitle'));
		        errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodTransDt',errMsg,errCount);
		        Ext.util.splitDate(document.getElementById('bloodTransDt'),document.getElementById('bloodTransDd'),document.getElementById('bloodTransMm'),document.getElementById('bloodTransYy'));
	        });
		var bTAArr = new Array();
		bTAArr[0] = document.getElementById('bloodTransDt');
	        Ext.util.disableSectionByInternalRadio(document.getElementById('bloodTransAnswer0'), bTAArr, txtFormat,radioArr, true);
	        errMsg = Ext.util.checkRadioCorresponding4IE7(document.getElementById('bloodTransAnswer0'),document.getElementById('bloodTransDt'),radioArr, true, document.getElementById('bloodTransAnswerTitle'));
	        errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodTransAnswer[]',errMsg,errCount);
	        errMsg = Ext.util.checkDateCorresponding4IE7(document.getElementById('bloodTransAnswer0'),document.getElementById('bloodTransDt'),radioArr, true, document.getElementById('bloodTransDtTitle'));
	        errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodTransDt',errMsg,errCount);
	        Ext.util.splitDate(document.getElementById('bloodTransDt'),document.getElementById('bloodTransDd'),document.getElementById('bloodTransMm'),document.getElementById('bloodTransYy'));
        }

	dtFlg = document.getElementById('bloodExpDt') == null?false:true;
	if(dtFlg)
        {
		var bloodExpArr = new Array();
		bloodExpArr[0] = "bloodExpAnswer0";
		bloodExpArr[1] = "bloodExpAnswer1";
		//bloodExpArr[2] = "bloodExpAnswer2";
		for(i = 0; i < 2; i++)
		{
			Ext.get('bloodExpAnswer'+i).on('click', function(){
				var bTAArr = new Array();
				bTAArr[0] = document.getElementById('bloodExpDt');
			Ext.util.disableSectionByInternalRadio(document.getElementById('bloodExpAnswer0'), bTAArr, txtFormat, radioArr, true);
			errMsg = Ext.util.checkRadioCorresponding4IE7(document.getElementById('bloodExpAnswer0'),document.getElementById('bloodExpDt'),radioArr, true, document.getElementById('bloodExpAnswerTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodExpAnswer[]',errMsg,errCount);

			errMsg = Ext.util.checkDateCorresponding4IE7(document.getElementById('bloodExpAnswer0'),document.getElementById('bloodExpDt'), radioArr, true, document.getElementById('bloodExpDtTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodExpDt',errMsg,errCount);

		        }, document.getElementById(this.id), {delay: 5});
                }	
	        Ext.get('bloodExpDt').on('blur',function() {
		        errMsg = Ext.util.checkRadioCorresponding4IE7(document.getElementById('bloodExpAnswer0'),document.getElementById('bloodExpDt'),radioArr, true, document.getElementById('bloodExpAnswerTitle'));
		        errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodExpAnswer[]',errMsg,errCount);
		        errMsg = Ext.util.checkDateCorresponding4IE7(document.getElementById('bloodExpAnswer0'),document.getElementById('bloodExpDt'),radioArr, true, document.getElementById('bloodExpDtTitle'));
		        errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodExpDt',errMsg,errCount);
		        Ext.util.splitDate(document.getElementById('bloodExpDt'),document.getElementById('bloodExpDd'),document.getElementById('bloodExpMm'),document.getElementById('bloodExpYy'));
	        });
		var bTAArr = new Array();
		bTAArr[0] = document.getElementById('bloodExpDt');
	        Ext.util.disableSectionByInternalRadio(document.getElementById('bloodExpAnswer0'), bTAArr, txtFormat,radioArr, true);
	        errMsg = Ext.util.checkRadioCorresponding4IE7(document.getElementById('bloodExpAnswer0'),document.getElementById('bloodExpDt'),radioArr, true, document.getElementById('bloodExpAnswerTitle'));
	        errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodExpAnswer[]',errMsg,errCount);
	        errMsg = Ext.util.checkDateCorresponding4IE7(document.getElementById('bloodExpAnswer0'),document.getElementById('bloodExpDt'),radioArr, true, document.getElementById('bloodExpDtTitle'));
	        errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodExpDt',errMsg,errCount);
	        Ext.util.splitDate(document.getElementById('bloodExpDt'),document.getElementById('bloodExpDd'),document.getElementById('bloodExpMm'),document.getElementById('bloodExpYy'));
        }
	
	Ext.get('propINH').on('click', function(){
		errMsg = Ext.util.checkCheckBoxCorresponding(document.getElementById('propINH'),document.getElementById('debutINHStartMM'),document.getElementById('debutINHStartYY'),document.getElementById('propINHTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'propINHT',errMsg,errCount);
		errMsg = Ext.util.checkMYCorresponding(document.getElementById('propINH'),document.getElementById('debutINHStartMM'),document.getElementById('debutINHStartYY'),document.getElementById('debutINHStartTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'debutINHStart',errMsg,errCount);
	});
	Ext.get('debutINHStartMM').on('blur', function(){
		errMsg = Ext.util.checkCheckBoxCorresponding(document.getElementById('propINH'),document.getElementById('debutINHStartMM'),document.getElementById('debutINHStartYY'),document.getElementById('propINHTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'propINHT',errMsg,errCount);
		errMsg = Ext.util.checkMYCorresponding(document.getElementById('propINH'),document.getElementById('debutINHStartMM'),document.getElementById('debutINHStartYY'),document.getElementById('debutINHStartTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'debutINHStart',errMsg,errCount);
	});
	Ext.get('debutINHStartYY').on('blur', function(){
		errMsg = Ext.util.checkCheckBoxCorresponding(document.getElementById('propINH'),document.getElementById('debutINHStartMM'),document.getElementById('debutINHStartYY'),document.getElementById('propINHTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'propINHT',errMsg,errCount);
		errMsg = Ext.util.checkMYCorresponding(document.getElementById('propINH'),document.getElementById('debutINHStartMM'),document.getElementById('debutINHStartYY'),document.getElementById('debutINHStartTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'debutINHStart',errMsg,errCount);
	});
	errMsg = Ext.util.checkCheckBoxCorresponding(document.getElementById('propINH'),document.getElementById('debutINHStartMM'),document.getElementById('debutINHStartYY'),document.getElementById('propINHTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'propINH',errMsg,errCount);
	errMsg = Ext.util.checkMYCorresponding(document.getElementById('propINH'),document.getElementById('debutINHStartMM'),document.getElementById('debutINHStartYY'),document.getElementById('debutINHStartTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'debutINHStart',errMsg,errCount);
	for(i=1;i<4;i++)
	{
		Ext.get('vaccHepB' + i).on('click', function(){	
			var vaccHepArr = new Array();
			vaccHepArr[0] = document.getElementById('vaccHepBMm');
			vaccHepArr[1] = document.getElementById('vaccHepBYy');
			vaccHepArr[2] = document.getElementById('hepBdoses');
			Ext.util.disableSectionByInternalRadio(document.getElementById('vaccHepB1'), vaccHepArr, txtFormat, radioArr, true);
			errMsg = Ext.util.checkRadioCorrespondingWithDose(document.getElementById('vaccHepB1'),document.getElementById('vaccHepBMm'),document.getElementById('vaccHepBYy'),document.getElementById('hepBdoses'),radioArr, true,document.getElementById('vaccHepBRadioTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'vaccHepB[]',errMsg,errCount);
			errMsg = Ext.util.checkMYCorresponding(document.getElementById('vaccHepB1'),document.getElementById('vaccHepBMm'),document.getElementById('vaccHepBYy'),document.getElementById('vaccHepBTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'vaccHepB',errMsg,errCount);
			errMsg = Ext.util.checkDoseCorresponding(document.getElementById('vaccHepB1'),document.getElementById('hepBdoses'),document.getElementById('hepBdosesTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'hepBdoses',errMsg,errCount);
		}, document.getElementById(this.id), {delay: 5});
	}
	Ext.get('vaccHepBMm').on('blur', function(){	
		errMsg = Ext.util.checkRadioCorrespondingWithDose(document.getElementById('vaccHepB1'),document.getElementById('vaccHepBMm'),document.getElementById('vaccHepBYy'),document.getElementById('hepBdoses'),radioArr, true,document.getElementById('vaccHepBRadioTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vaccHepB[]',errMsg,errCount);
		errMsg = Ext.util.checkMYCorresponding(document.getElementById('vaccHepB1'),document.getElementById('vaccHepBMm'),document.getElementById('vaccHepBYy'),document.getElementById('vaccHepBTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vaccHepB',errMsg,errCount);
	});	
	Ext.get('vaccHepBYy').on('blur', function(){	
		errMsg = Ext.util.checkRadioCorrespondingWithDose(document.getElementById('vaccHepB1'),document.getElementById('vaccHepBMm'),document.getElementById('vaccHepBYy'),document.getElementById('hepBdoses'),radioArr, true,document.getElementById('vaccHepBRadioTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vaccHepB[]',errMsg,errCount);
		errMsg = Ext.util.checkMYCorresponding(document.getElementById('vaccHepB1'),document.getElementById('vaccHepBMm'),document.getElementById('vaccHepBYy'),document.getElementById('vaccHepBTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vaccHepB',errMsg,errCount);
	});
	Ext.get('hepBdoses').on('blur', function(){	
		errMsg = Ext.util.checkRadioCorrespondingWithDose(document.getElementById('vaccHepB1'),document.getElementById('vaccHepBMm'),document.getElementById('vaccHepBYy'),document.getElementById('hepBdoses'),radioArr, true,document.getElementById('vaccHepBRadioTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vaccHepB[]',errMsg,errCount);
		errMsg = Ext.util.checkDoseCorresponding(document.getElementById('vaccHepB1'),document.getElementById('hepBdoses'),document.getElementById('hepBdosesTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'hepBdoses',errMsg,errCount);

	});
	
	var vaccHepArr = new Array();
	vaccHepArr[0] = document.getElementById('vaccHepBMm');
	vaccHepArr[1] = document.getElementById('vaccHepBYy');
	vaccHepArr[2] = document.getElementById('hepBdoses');
	Ext.util.disableSectionByInternalRadio(document.getElementById('vaccHepB1'), vaccHepArr, txtFormat, radioArr, true);
			
	errMsg = Ext.util.checkRadioCorrespondingWithDose(document.getElementById('vaccHepB1'),document.getElementById('vaccHepBMm'),document.getElementById('vaccHepBYy'),document.getElementById('hepBdoses'),radioArr, true,document.getElementById('vaccHepBRadioTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vaccHepB[]',errMsg,errCount);
	errMsg = Ext.util.checkMYCorresponding(document.getElementById('vaccHepB1'),document.getElementById('vaccHepBMm'),document.getElementById('vaccHepBYy'),document.getElementById('vaccHepBTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vaccHepB',errMsg,errCount);
	errMsg = Ext.util.checkDoseCorresponding(document.getElementById('vaccHepB1'),document.getElementById('hepBdoses'),document.getElementById('hepBdosesTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'hepBdoses',errMsg,errCount);
	for(i=1;i<4;i++)
	{
		Ext.get('vaccTetanus' + i).on('click', function(){		
			var vaccTetanusArr = new Array();
			vaccTetanusArr[0] = document.getElementById('vaccTetanusMm');
			vaccTetanusArr[1] = document.getElementById('vaccTetanusYy');
			vaccTetanusArr[2] = document.getElementById('tetDoses');
			Ext.util.disableSectionByInternalRadio(document.getElementById('vaccTetanus1'), vaccTetanusArr, txtFormat, radioArr, true);
			errMsg = Ext.util.checkRadioCorrespondingWithDose(document.getElementById('vaccTetanus1'),document.getElementById('vaccTetanusMm'),document.getElementById('vaccTetanusYy'),document.getElementById('tetDoses'),radioArr, true, document.getElementById('vaccTetanusRadioTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'vaccTetanus[]',errMsg,errCount);
			errMsg = Ext.util.checkMYCorresponding(document.getElementById('vaccTetanus1'),document.getElementById('vaccTetanusMm'),document.getElementById('vaccTetanusYy'),document.getElementById('vaccTetanusTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'vaccTetanus',errMsg,errCount);
			errMsg = Ext.util.checkDoseCorresponding(document.getElementById('vaccTetanus1'),document.getElementById('tetDoses'),document.getElementById('tetDosesTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'tetDoses',errMsg,errCount);
		}, document.getElementById(this.id), {delay: 5});
	}
	Ext.get('vaccTetanusMm').on('blur', function(){	
		errMsg = Ext.util.checkRadioCorrespondingWithDose(document.getElementById('vaccTetanus1'),document.getElementById('vaccTetanusMm'),document.getElementById('vaccTetanusYy'),document.getElementById('tetDoses'),radioArr, true,document.getElementById('vaccTetanusRadioTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vaccTetanus[]',errMsg,errCount);
		errMsg = Ext.util.checkMYCorresponding(document.getElementById('vaccTetanus1'),document.getElementById('vaccTetanusMm'),document.getElementById('vaccTetanusYy'),document.getElementById('vaccTetanusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vaccTetanus',errMsg,errCount);
	});	
	Ext.get('vaccTetanusYy').on('blur', function(){	
		errMsg = Ext.util.checkRadioCorrespondingWithDose(document.getElementById('vaccTetanus1'),document.getElementById('vaccTetanusMm'),document.getElementById('vaccTetanusYy'),document.getElementById('tetDoses'),radioArr, true,document.getElementById('vaccTetanusRadioTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vaccTetanus[]',errMsg,errCount);
		errMsg = Ext.util.checkMYCorresponding(document.getElementById('vaccTetanus1'),document.getElementById('vaccTetanusMm'),document.getElementById('vaccTetanusYy'),document.getElementById('vaccTetanusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vaccTetanus',errMsg,errCount);
	});
	Ext.get('tetDoses').on('blur', function(){	
		errMsg = Ext.util.checkRadioCorrespondingWithDose(document.getElementById('vaccTetanus1'),document.getElementById('vaccTetanusMm'),document.getElementById('vaccTetanusYy'),document.getElementById('tetDoses'),radioArr, true,document.getElementById('vaccTetanusRadioTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vaccTetanus[]',errMsg,errCount);
		errMsg = Ext.util.checkDoseCorresponding(document.getElementById('vaccTetanus1'),document.getElementById('tetDoses'),document.getElementById('tetDosesTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'tetDoses',errMsg,errCount);

	});
	var vaccTetanusArr = new Array();
	vaccTetanusArr[0] = document.getElementById('vaccTetanusMm');
	vaccTetanusArr[1] = document.getElementById('vaccTetanusYy');
	vaccTetanusArr[2] = document.getElementById('tetDoses');
	Ext.util.disableSectionByInternalRadio(document.getElementById('vaccTetanus1'), vaccTetanusArr, txtFormat, radioArr, true);
	errMsg = Ext.util.checkRadioCorrespondingWithDose(document.getElementById('vaccTetanus1'),document.getElementById('vaccTetanusMm'),document.getElementById('vaccTetanusYy'),document.getElementById('tetDoses'),radioArr, true,document.getElementById('vaccTetanusRadioTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vaccTetanus[]',errMsg,errCount);
	errMsg = Ext.util.checkMYCorresponding(document.getElementById('vaccTetanus1'),document.getElementById('vaccTetanusMm'),document.getElementById('vaccTetanusYy'),document.getElementById('vaccTetanusTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vaccTetanus',errMsg,errCount);
	errMsg = Ext.util.checkDoseCorresponding(document.getElementById('vaccTetanus1'),document.getElementById('tetDoses'),document.getElementById('tetDosesTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'tetDoses',errMsg,errCount);
	txtFormat['papTestDT'] = new Ext.form.DateField({
		fieldLabel: '',
		maskRe : /[\d{1,2}\/]/,
		validationEvent: false,
		allowBlank:true
	});
	txtFormat['papTestDT'].applyToMarkup('papTestDT');

	txtFormat['lowestCd4CntDT'] = new Ext.form.DateField({
		fieldLabel: '',
		maskRe : /[\d{1,2}\/]/,
		validationEvent: false,
		allowBlank:true
	});
	txtFormat['lowestCd4CntDT'].applyToMarkup('lowestCd4CntDT');
	Ext.get('lowestCd4Cnt').on('blur',function() {
		errMsg = Ext.util.checkTextDtCorresponding(document.getElementById('lowestCd4Cnt'),document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'lowestCd4Cnt',errMsg,errCount);
		errMsg = Ext.util.checkDtTextCorresponding(document.getElementById('lowestCd4Cnt'),document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntDTTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'lowestCd4CntDT',errMsg,errCount);
	});		
	Ext.get('lowestCd4CntDT').on('blur',function() {
		errMsg = Ext.util.checkTextDtCorresponding(document.getElementById('lowestCd4Cnt'),document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'lowestCd4Cnt',errMsg,errCount);
		errMsg = Ext.util.checkDtTextCorresponding(document.getElementById('lowestCd4Cnt'),document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntDTTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'lowestCd4CntDT',errMsg,errCount);
		Ext.util.splitDate(document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntDd'),document.getElementById('lowestCd4CntMm'),document.getElementById('lowestCd4CntYy'));
	});
	errMsg = Ext.util.checkTextDtCorresponding(document.getElementById('lowestCd4Cnt'),document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'lowestCd4Cnt',errMsg,errCount);
	errMsg = Ext.util.checkDtTextCorresponding(document.getElementById('lowestCd4Cnt'),document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntDTTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'lowestCd4CntDT',errMsg,errCount);
	Ext.util.splitDate(document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntDd'),document.getElementById('lowestCd4CntMm'),document.getElementById('lowestCd4CntYy'));

	txtFormat['firstViralLoadDT'] = new Ext.form.DateField({
		fieldLabel: '',
		maskRe : /[\d{1,2}\/]/,
		validationEvent: false,
		allowBlank:true
	});
	txtFormat['firstViralLoadDT'].applyToMarkup('firstViralLoadDT');
	Ext.get('firstViralLoad').on('blur',function() {
		errMsg = Ext.util.checkTextDtCorresponding(document.getElementById('firstViralLoad'),document.getElementById('firstViralLoadDT'),document.getElementById('firstViralLoadTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstViralLoad',errMsg,errCount);
		errMsg = Ext.util.checkDtTextCorresponding(document.getElementById('firstViralLoad'),document.getElementById('firstViralLoadDT'),document.getElementById('firstViralLoadDTTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstViralLoadDT',errMsg,errCount);
	});		
	Ext.get('firstViralLoadDT').on('blur',function() {
		errMsg = Ext.util.checkTextDtCorresponding(document.getElementById('firstViralLoad'),document.getElementById('firstViralLoadDT'),document.getElementById('firstViralLoadTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstViralLoad',errMsg,errCount);
		errMsg = Ext.util.checkDtTextCorresponding(document.getElementById('firstViralLoad'),document.getElementById('firstViralLoadDT'),document.getElementById('firstViralLoadDTTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstViralLoadDT',errMsg,errCount);
		Ext.util.splitDate(document.getElementById('firstViralLoadDT'),document.getElementById('firstViralLoadDd'),document.getElementById('firstViralLoadMm'),document.getElementById('firstViralLoadYy'));
	});
	errMsg = Ext.util.checkTextDtCorresponding(document.getElementById('firstViralLoad'),document.getElementById('firstViralLoadDT'),document.getElementById('firstViralLoadTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstViralLoad',errMsg,errCount);
	errMsg = Ext.util.checkDtTextCorresponding(document.getElementById('firstViralLoad'),document.getElementById('firstViralLoadDT'),document.getElementById('firstViralLoadDTTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstViralLoadDT',errMsg,errCount);
	Ext.util.splitDate(document.getElementById('firstViralLoadDT'),document.getElementById('firstViralLoadDd'),document.getElementById('firstViralLoadMm'),document.getElementById('firstViralLoadYy'));

	var newFamPlanArr = Ext.util.getNewRadios(allElements["famPlan"]);
	Ext.get('fp1').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById("fp2"), radioArr, true, newFamPlanArr);
	}, document.getElementById(this.id), {delay: 5});
	Ext.get('fp2').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById(this.id),  radioArr, true, newFamPlanArr);
		//errCount = Ext.util.clearElements(allElements["famPlan"], errFields,errMsgs, errpCount);
	}, document.getElementById(this.id), {delay: 5});
	Ext.util.disableSectionByRadio(document.getElementById("fp2"),  radioArr, true, newFamPlanArr);

	
	Ext.get('noDiagnosis').on('click',function() {
			Ext.util.disableSectionByRadio(document.getElementById("noDiagnosis"), radioArr, true, allElements["conditions"]);
			//errCount = Ext.util.clearElements(allElements["conditions"], errFields,errMsgs, errCount);
	});	
	Ext.util.disableSectionByRadio(document.getElementById("noDiagnosis"),  radioArr, true,allElements["conditions"]);
		
	Ext.get('arvY').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById("arvN"),radioArr, false, allElements["arvPrevious"]);
	});
	Ext.get('arvN').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById(this.id), radioArr, false,allElements["arvPrevious"]);
		//errCount = Ext.util.clearElements(allElements["arvPrevious"], errFields,errMsgs, errCount);
	});
	Ext.util.disableSectionByRadio(document.getElementById("arvN"), radioArr, true, allElements["arvPrevious"]);	

	Ext.get('noneTreatments').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById(this.id),radioArr, false, allElements["medAllergy"]);
		//errCount = Ext.util.clearElements(allElements["medAllergy"], errFields,errMsgs, errCount);
	});
	Ext.util.disableSectionByRadio(document.getElementById("noneTreatments"),radioArr, true, allElements["medAllergy"]);	

  if(sexFlg == "2")
  {
  		var disSec = new Array();
  		disSec[0] = "oh1";
  		disSec[1] = "oh2";
  		disSec[2] = "oh3";
  		disSec[3] = "arvExcl";
  		for(i = 0; i < disSec.length; i++)
  		{
  			for(j = 0; j < allElements[disSec[i]].length; j++)
  			{
  				var temp = allElements[disSec[i]][j];
  				temp.disabled = true;

  				if(temp.id.substring(temp.id.length-2) == "Dt" || temp.id.substring(temp.id.length-2) == "DT")
  				{
  					txtFormat[temp.id].disable();
  				}
  			}
  		}
  }
  else
  {
//  	var oh2Arr = new Array();
//  	oh2Arr[0] = "papTest1";
//  	oh2Arr[1] = "papTest2";
//  	oh2Arr[2] = "papTest3";
//  	for(i=0; i < oh2Arr.length; i++)
//  	{
//  		Ext.get(oh2Arr[i]).on('click', function(){
//				Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(oh2Arr), allElements["oh2"], txtFormat);
//				if(this.id != oh2Arr[0] )
//				{
//
//				}
//					
//			});
//  	}
//  	Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(oh2Arr), allElements["oh2"],txtFormat);
  	
  	var oh3Arr = new Array();
  	oh3Arr[0] = "pregnant1";
  	oh3Arr[1] = "pregnant2";
  	oh3Arr[2] = "pregnant3";
  	for(i=0; i < oh3Arr.length; i++)
  	{
  		Ext.get(oh3Arr[i]).on('click', function(){
					Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(oh3Arr), allElements["oh3"], txtFormat);
					if(this.id != oh3Arr[0] )
					{
						//errCount = Ext.util.clearElements(allElements["oh3"], errFields,errMsgs, errCount);
					}
			});
  	}
	Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(oh3Arr), allElements["oh3"], txtFormat);	

  	var arvArr = new Array();
  	arvArr[0] = "ARVex1";
  	arvArr[1] = "ARVex2";
  	arvArr[2] = "ARVex3";
  	for(i=0; i < arvArr.length; i++)
  	{
  		Ext.get(arvArr[i]).on('click', function(){
			Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(arvArr), allElements["arvExcl"], txtFormat);
			if(this.id != arvArr[0] )
			{
				//errCount = Ext.util.clearElements(allElements["arvExcl"], errFields,errMsgs, errCount);
			}
			});
		}
		Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(arvArr), allElements["arvExcl"], txtFormat);	 
	}

	

	
	var firstTestThisFac = new Array(2);
	firstTestThisFac[0] = document.getElementById("firstTestThisFac");
	firstTestThisFac[1] = document.getElementById("firstTestOtherFac");

	for(i=0;i<firstTestThisFac.length;i++)
	{
		Ext.get(firstTestThisFac[i].id).on('click', function(){
			var key1 = Ext.util.getKeyByID(firstTestThisFac, this.id);
			
			Ext.util.checkUniqueRadio(firstTestThisFac,key1,radioArr);
		});
	}
		
    var TBStatusArray = new Array(3);
	TBStatusArray[0] = "asymptomaticTb[]";
	TBStatusArray[1] = "completeTreat[]";
	TBStatusArray[2] = "currentTreat[]";	
	var functionStatus = new Array(3);
	functionStatus[0] = "functionalStatus1";
	functionStatus[1] = "functionalStatus2";
	functionStatus[2] = "functionalStatus4";


	for(i=0;i<3;i++)
	{
		Ext.get(functionStatus[i]).on('click', function(){
			errMsg = Ext.util.isItemSelected(functionStatus, radioArr, false,document.getElementById('functionalStatusTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'functionalStatus',errMsg,errCount);
	        }, document.getElementById(this.id), {delay: 5});
	}
	
	Ext.get('vDate').on('blur', function(){
		errMsg = Ext.util.checkItemSelected1(TBStatusArray, radioArr, true, document.getElementById('tbStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbStatus',errMsg,errCount);
		errMsg = Ext.util.isItemSelected(functionStatus, radioArr, false,document.getElementById('functionalStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'functionalStatus',errMsg,errCount);
		errMsg = Ext.util.checkWhoStage(whoStages,document.getElementById('whoStageTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'whoStage',errMsg,errCount);
 	});

	if(document.mainForm.vDate.value!='' && document.mainForm.vDate.value!='//')
	{
		errMsg = Ext.util.checkItemSelected1(TBStatusArray, radioArr, true, document.getElementById('tbStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbStatus',errMsg,errCount);
		errMsg = Ext.util.isItemSelected(functionStatus, radioArr, false,document.getElementById('functionalStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'functionalStatus',errMsg,errCount);
		errMsg = Ext.util.checkWhoStage(whoStages,document.getElementById('whoStageTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'whoStage',errMsg,errCount);

	}

	var hiddenTBArr = new Array();
	for(i=0;i<TBStatusArray.length;i++)
	{
		hiddenTBArr[i] = TBStatusArray[i].substring(0, TBStatusArray[i].indexOf('[]'));
	}
//	for(i=0;i<TBStatusArray.length; i++)
//	{
//		(Ext.get(TBStatusArray[i])).on('click', function(){
//			var loc = Ext.util.getKeyByID1(TBStatusArray, this.id);
//			Ext.util.selectDiffRadio(document.getElementById(this.id), hiddenTBArr, loc,radioArr);
//		});	
//	}
	
	Ext.get('vitalTemp').on('blur', function(){
		errMsg = Ext.util.checkTemp(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, true,document.getElementById('vitalTempTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, true, document.getElementById('vitalTempUnitTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTempUnit',errMsg,errCount);
	
	});
	Ext.get('vitalTempUnit1').on('click', function(){
		errMsg = Ext.util.checkTemp(document.mainForm.vitalTemp,document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, true,document.getElementById('vitalTempTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'),radioArr, true, document.getElementById("vitalTempUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTempUnit',errMsg,errCount);
	}, document.getElementById(this.id), {delay: 5});
	Ext.get('vitalTempUnit2').on('click', function(){
		errMsg = Ext.util.checkTemp(document.mainForm.vitalTemp,document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, true,document.getElementById('vitalTempTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'),radioArr, true, document.getElementById('vitalTempUnitTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTempUnit',errMsg,errCount);

	}, document.getElementById(this.id), {delay: 5});
	errMsg = Ext.util.checkTemp(document.mainForm.vitalTemp,document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'),radioArr, true,document.getElementById('vitalTempTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
	errMsg = Ext.util.checkUnit(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, true,document.getElementById("vitalTempUnitTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTempUnit',errMsg,errCount);

	Ext.get('vitalBp1').on('blur', function(){
		errMsg = Ext.util.checkBp1(document.mainForm.vitalBp1,document.getElementById("vitalBp1Title"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBp1',errMsg,errCount);
		errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"),radioArr, true,document.getElementById("vitalBpUnitTitle"));
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

	Ext.get('vitalWeight').on('blur', function(){
		errMsg = Ext.util.checkWeight(document.mainForm.vitalWeight,document.getElementById("vitalWeightTitle"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeight',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.mainForm.vitalWeight,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr, true,document.getElementById("vitalWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
	
	});
	Ext.get('vitalWeightUnit1').on('click', function(){
		errMsg = Ext.util.checkUnit(document.mainForm.vitalWeight,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr, true,document.getElementById("vitalWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
	
	}, document.getElementById(this.id), {delay: 5});
	Ext.get('vitalWeightUnit2').on('click', function(){
		errMsg = Ext.util.checkUnit(document.mainForm.vitalWeight,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr, true,document.getElementById("vitalWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
	
	}, document.getElementById(this.id), {delay: 5});
	errMsg = Ext.util.checkWeight(document.mainForm.vitalWeight,document.getElementById("vitalWeightTitle"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeight',errMsg,errCount);
	errMsg = Ext.util.checkUnit(document.mainForm.vitalWeight,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr, true,document.getElementById("vitalWeightUnitTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);	

	Ext.get('vitalPrevWt').on('blur', function(){
		errMsg = Ext.util.checkWeight(document.mainForm.vitalPrevWt,document.getElementById("vitalPrevWtTitle"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalPrevWt',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.mainForm.vitalPrevWt,document.getElementById("vitalPrevWtUnit1"),document.getElementById("vitalPrevWtUnit2"),radioArr, true,document.getElementById("vitalPrevWtUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalPrevWtUnit',errMsg,errCount);

	});
	Ext.get('vitalPrevWtUnit1').on('click', function(){
		errMsg = Ext.util.checkUnit(document.mainForm.vitalPrevWt,document.getElementById("vitalPrevWtUnit1"),document.getElementById("vitalPrevWtUnit2"),radioArr, true,document.getElementById("vitalPrevWtUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalPrevWtUnit',errMsg,errCount);
	}, document.getElementById(this.id), {delay: 5});
	Ext.get('vitalPrevWtUnit2').on('click', function(){
		errMsg = Ext.util.checkUnit(document.mainForm.vitalPrevWt,document.getElementById("vitalPrevWtUnit1"),document.getElementById("vitalPrevWtUnit2"),radioArr, true,document.getElementById("vitalPrevWtUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalPrevWtUnit',errMsg,errCount);

	}, document.getElementById(this.id), {delay: 5});
	errMsg = Ext.util.checkWeight(document.mainForm.vitalPrevWt,document.getElementById("vitalPrevWtTitle"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalPrevWt',errMsg,errCount);
	errMsg = Ext.util.checkUnit(document.mainForm.vitalPrevWt,document.getElementById("vitalPrevWtUnit1"),document.getElementById("vitalPrevWtUnit2"),radioArr, true,document.getElementById("vitalPrevWtUnitTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalPrevWtUnit',errMsg,errCount);	

	var  expFromD1 = new Ext.form.DateField({
		fieldLabel: '',
		maskRe : /[\Xx{1,2}\d{1,2}\/]/,
		validationEvent: false,
		allowBlank:true
	});
	expFromD1.applyToMarkup('expFromD1');
        Ext.get('PEP').on('click', function(){
                errMsg = Ext.util.checkRadioCorresponding4IE7(document.getElementById('PEP'),document.getElementById('expFromD1'), radioArr, true, document.getElementById('PEPTitle'));
                errCount = Ext.util.showErrorHead(errFields,errMsgs,'PEP',errMsg,errCount);

                errMsg = Ext.util.checkDateCorresponding4IE7(document.getElementById('PEP'),document.getElementById('expFromD1'), radioArr, true, document.getElementById('expFromD1Title'));
                errCount = Ext.util.showErrorHead(errFields,errMsgs,'expFromD1',errMsg,errCount);

        }, document.getElementById(this.id), {delay: 5});
	Ext.get('expFromD1').on('blur', function(){
		errMsg = Ext.util.checkRadioCorresponding4IE7(document.getElementById('PEP'), document.getElementById('expFromD1'), radioArr, true, document.getElementById('PEPTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'PEP',errMsg,errCount);
		errMsg = Ext.util.checkDateCorresponding4IE7(document.getElementById('PEP'), document.getElementById('expFromD1'), radioArr, true, document.getElementById('expFromD1Title'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'expFromD1',errMsg,errCount);	

		if(errMsg == '' )
		{
			errMsg =  Ext.util.validateDateFieldNonPatient(document.getElementById('expFromD1'),document.getElementById('expFromD1Title'),'');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'expFrom',errMsg,errCount);	
		}

		Ext.util.splitDate(document.getElementById('expFromD1'),document.getElementById('expFromDt'),document.getElementById('expFromMm'),document.getElementById('expFromYy'));
	});
	errMsg = Ext.util.checkRadioCorresponding4IE7(document.getElementById('PEP'), document.getElementById('expFromD1'), radioArr, true, document.getElementById('PEPTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'PEP',errMsg,errCount);
	errMsg = Ext.util.checkDateCorresponding4IE7(document.getElementById('PEP'), document.getElementById('expFromD1'), radioArr, true, document.getElementById('expFromD1Title'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'expFromD1',errMsg,errCount);	

	if(errMsg == '' )
	{
		errMsg =  Ext.util.validateDateFieldNonPatient(document.getElementById('expFromD1'),document.getElementById('expFromD1Title'),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'expFrom',errMsg,errCount);	
	}

	Ext.util.splitDate(document.getElementById('expFromD1'),document.getElementById('expFromDt'),document.getElementById('expFromMm'),document.getElementById('expFromYy'));

	var medEligYes = document.getElementById('medElig1');
	var medEligSection = new Array(9);
	medEligSection[0] = document.mainForm.cd4LT200;
	medEligSection[1] = document.mainForm.WHOIII;
	medEligSection[2] = document.mainForm.WHOIV;
	medEligSection[3] = document.mainForm.PMTCT;
	medEligSection[4] = document.mainForm.medEligHAART;
	medEligSection[5] = document.mainForm.formerARVtherapy;
	medEligSection[6] = document.mainForm.PEP;
	medEligSection[7] = document.mainForm.expFromD1;
	medEligSection[8] = document.mainForm.tlcLT1200;   
	Ext.util.disableElements(medEligYes,medEligSection,radioArr,true);
	Ext.util.disableAssoDt(document.getElementById('medElig1'),expFromD1, document.mainForm.expFromD1,radioArr,true);
	
	for(var i=1;i<4;i++)
	{
		Ext.get('medElig' + i).on('click', function(){
			Ext.util.disableElements(document.getElementById('medElig1'),medEligSection,radioArr,true);
			Ext.util.disableAssoDt(document.getElementById('medElig1'),expFromD1, document.mainForm.expFromD1,radioArr,true);
			if( !document.getElementById('medElig1').checked){
                                Ext.util.clearElements(medEligSection, errFields, errMsgs, errCount);
                        }	
	}, document.getElementById(this.id), {delay: 5});		
	}


	for(i=0;i<TBStatusArray.length;i++)
	{
		Ext.get(TBStatusArray[i]).on('click', function(){
			var key = Ext.util.getKeyByID1(TBStatusArray, this.id);
			Ext.util.selectDiffRadio(document.getElementById(this.id), hiddenTBArr, key,radioArr);
			errMsg = Ext.util.checkItemSelected1(TBStatusArray, radioArr, true,document.getElementById('tbStatusTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbStatus',errMsg,errCount);
                        errMsg = Ext.util.validateAdultTbStatusSection(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatFac'),document.getElementById('completeTreatTitle'),document.getElementById('completeTreatDtTitle'),document.getElementById('completeTreatFacTitle'));
                        errMsg = Ext.util.validateAdultTbStatusSection(document.getElementById('currentTreat[]'),document.getElementById('currentTreatNo'),document.getElementById('currentTreatFac'),document.getElementById('currentTreatTitle'),document.getElementById('currentTreatNoTitle'),document.getElementById('currentTreatFacTitle'));
		}, document.getElementById(this.id), {delay: 5});
	}
//	var hiddenTBArr = new Array();
//	for(i=0;i<TBStatusArray.length;i++)
//	{
//		hiddenTBArr[i] = TBStatusArray[i].substring(0, TBStatusArray[i].indexOf('[]'));
//	}
//	for(i=0;i<TBStatusArray.length; i++)
//	{
//		(Ext.get(TBStatusArray[i])).on('click', function(){
//			var loc = Ext.util.getKeyByID1(TBStatusArray, this.id);
//			Ext.util.selectDiffRadio(document.getElementById(this.id), hiddenTBArr, loc,radioArr);
//		});	
//	}
	for(i=1;i<4;i++)
	{
		Ext.get('papTest'+i).on('click', function(){
			var papTestArr = new Array();
			papTestArr[0] = document.getElementById('papTestDT');
			Ext.util.disableSectionByInternalRadio(document.getElementById('papTest1'), papTestArr, txtFormat,radioArr, true);
			errMsg = Ext.util.checkRadioCorresponding4IE7(document.getElementById('papTest1'),document.getElementById('papTestDT'),radioArr, true, document.getElementById('papTestTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'papTest[]',errMsg,errCount);

			errMsg = Ext.util.checkDateCorresponding4IE7(document.getElementById('papTest1'),document.getElementById('papTestDT'), radioArr, true, document.getElementById('papTestDTTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'papTestDT',errMsg,errCount);

		}, document.getElementById(this.id), {delay: 5});
	}

	
	Ext.get('papTestDT').on('blur',function() {
		errMsg = Ext.util.checkRadioCorresponding4IE7(document.getElementById('papTest1'),document.getElementById('papTestDT'),radioArr, true, document.getElementById('papTestTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'papTest[]',errMsg,errCount);
		errMsg = Ext.util.checkDateCorresponding4IE7(document.getElementById('papTest1'),document.getElementById('papTestDT'),radioArr, true, document.getElementById('papTestDTTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'papTestDT',errMsg,errCount);
		Ext.util.splitDate(document.getElementById('papTestDT'),document.getElementById('papTestDd'),document.getElementById('papTestMm'),document.getElementById('papTestYy'));
	});
	var papTestArr = new Array();
	papTestArr[0] = document.getElementById('papTestDT');
	Ext.util.disableSectionByInternalRadio(document.getElementById('papTest1'), papTestArr, txtFormat,radioArr, true);
	errMsg = Ext.util.checkRadioCorresponding4IE7(document.getElementById('papTest1'),document.getElementById('papTestDT'),radioArr, true, document.getElementById('papTestTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'papTest[]',errMsg,errCount);
	errMsg = Ext.util.checkDateCorresponding4IE7(document.getElementById('papTest1'),document.getElementById('papTestDT'),radioArr, true, document.getElementById('papTestDTTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'papTestDT',errMsg,errCount);
	Ext.util.splitDate(document.getElementById('papTestDT'),document.getElementById('papTestDd'),document.getElementById('papTestMm'),document.getElementById('papTestYy'));
});


