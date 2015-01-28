
Ext.onReady(function() {
	
	var txtFormat = new Array();
	var root;
	var suffix;
	var suffix70;
	var prefix4;
	var root;
	var startMm,startYy,startErrLoc,stopMm,stopYy,stopErrLoc,continuing,continuingErrLoc;
	var reasonsErrLoc;
	var clinicalExamFormat = new Array(1);
	var sexFlg = Ext.getDom('sex1').value;
	vitalTemp = new Ext.form.TextField({
		fieldLabel: '',
		name: 'vitalTemp',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});
	vitalTemp.applyToMarkup(document.mainForm.vitalTemp);
	Ext.get('vitalTemp').on('blur', function(){
		errMsg = Ext.util.isValueInBound(document.mainForm.vitalTemp,document.getElementById("vitalTempTitle"),35,43,'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
	
	});
	
	errMsg = Ext.util.isValueInBound(document.mainForm.vitalTemp,document.getElementById("vitalTempTitle"),35,43,'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
	
	vitalBp1 = new Ext.form.TextField({
		fieldLabel: '',
		name: 'vitalBp1',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});
	vitalBp1.applyToMarkup(document.mainForm.vitalBp1);
	Ext.get('vitalBp1').on('blur', function(){
		errMsg = Ext.util.checkBp1(document.mainForm.vitalBp1,document.getElementById("vitalBp1Title"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBp1',errMsg,errCount);	
	});
	

	errMsg = Ext.util.checkBp1(document.mainForm.vitalBp1,document.getElementById("vitalBp1Title"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBp1',errMsg,errCount);
	
	vitalBp2 = new Ext.form.TextField({
		fieldLabel: '',
		name: 'vitalBp2',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});
	vitalBp2.applyToMarkup(document.mainForm.vitalBp2); 
	Ext.get('vitalBp2').on('blur', function(){
		errMsg = Ext.util.checkBp2(document.mainForm.vitalBp2,document.getElementById("vitalBp2Title"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBp2',errMsg,errCount);	
		
	});
	errMsg = Ext.util.checkBp2(document.mainForm.vitalBp2,document.getElementById("vitalBp2Title"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBp2',errMsg,errCount);
	
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
	errMsg = Ext.util.checkBp1(document.mainForm.vitalBp1,document.getElementById("vitalHrTitle"),'');
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
		maskRe : /[\d\.]/,
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
	
	Ext.get('transferIn').on('click', function(){
		errMsg = Ext.util.checkCheckboxCorresponding1(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),document.getElementById("transferInTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'trabsferIn',errMsg,errCount);
		errMsg = Ext.util.checkTextCorresponding(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),document.getElementById("firstCareOtherFacTextTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstCareOtherFacText',errMsg,errCount);
		errMsg = Ext.util.checkDateCorresponding1(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),'',document.getElementById("firstCareOtherDTTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstCareOtherDT',errMsg,errCount);
	
	});	
	Ext.get('firstCareOtherFacText').on('blur', function(){
		errMsg = Ext.util.checkCheckboxCorresponding1(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),document.getElementById("transferInTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'trabsferIn',errMsg,errCount);
		errMsg = Ext.util.checkTextCorresponding(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),document.getElementById("firstCareOtherFacTextTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstCareOtherFacText',errMsg,errCount);
		errMsg = Ext.util.checkDateCorresponding1(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),'',document.getElementById("firstCareOtherDTTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstCareOtherDT',errMsg,errCount);	
	
	});
	var firstCareOtherDT = new Ext.form.DateField({
		fieldLabel: '',
		maskRe : /[\d{1,2}\/]/,
		validationEvent: false,
		allowBlank:true,
		disabled: false
	});
	firstCareOtherDT.applyToMarkup(document.getElementById('firstCareOtherDT'));
	Ext.get('firstCareOtherDT').on('blur', function(){
		errMsg = Ext.util.checkCheckboxCorresponding1(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),document.getElementById("transferInTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'trabsferIn',errMsg,errCount);
		errMsg = Ext.util.checkTextCorresponding(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),document.getElementById("firstCareOtherFacTextTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstCareOtherFacText',errMsg,errCount);
		errMsg = Ext.util.checkDateCorresponding1(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),'',document.getElementById("firstCareOtherDTTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstCareOtherDT',errMsg,errCount);	
		Ext.util.splitDate(document.getElementById('firstCareOtherDT'),document.getElementById('firstCareOtherDd'),document.getElementById('firstCareOtherMm'),document.getElementById('firstCareOtherYy'));
	});
	errMsg = Ext.util.checkCheckboxCorresponding1(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),document.getElementById("transferInTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'trabsferIn',errMsg,errCount);
	errMsg = Ext.util.checkTextCorresponding(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),document.getElementById("firstCareOtherFacTextTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstCareOtherFacText',errMsg,errCount);
	errMsg = Ext.util.checkDateCorresponding1(document.getElementById('transferIn'),document.getElementById("firstCareOtherFacText"),document.getElementById("firstCareOtherDT"),'',document.getElementById("firstCareOtherDTTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstCareOtherDT',errMsg,errCount);	
	Ext.util.splitDate(document.getElementById('firstCareOtherDT'),document.getElementById('firstCareOtherDd'),document.getElementById('firstCareOtherMm'),document.getElementById('firstCareOtherYy'));
	var names = new Array();
	names[0] = "famPlan";
	names[1] = "arvPrevious";
	names[2] = "medAllergy";	
	names[3] = "oh2";
	names[4] = "oh2_sub";
	names[5] = "arvExcl";
	var allElements = Ext.util.getAllElements(document.mainForm,names);
	var txtArr = allElements["text"];

	for(i=0;i<txtArr.length;i++)
	{	

		suffix = txtArr[i].id.substring(txtArr[i].id.length-2);
		if(suffix == "Dt")
		{
			txtFormat[txtArr[i].id] = new Ext.form.DateField({
				fieldLabel: '',
				maskRe : /[\Xx{1,2}\d{1,2}\/]/,
				validationEvent: false,
				allowBlank:true
			});
			txtFormat[txtArr[i].id].applyToMarkup(txtArr[i]);
	
			(Ext.get(txtArr[i].id)).on('blur', function(){
				errMsg =  Ext.util.validateDateFieldNonPatient(document.getElementById(this.id),document.getElementById(this.id + "Title"),'');

				Ext.util.splitDate(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-2) + "Dd"),document.getElementById(this.id.substring(0,this.id.length-2) + "Mm"),document.getElementById(this.id.substring(0,this.id.length-2) + "Yy"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg,errCount);

			});
			errMsg = Ext.util.validateDateFieldNonPatient(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id + "Title"),'');
			Ext.util.splitDate(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Dd"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Mm"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Yy"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2),errMsg,errCount);
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
							errMsg =  Ext.util.checkDrugReasons(document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTitle"));
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
							errMsg =  Ext.util.checkDrugReasons(document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTitle"));
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
							errMsg =  Ext.util.checkDrugReasons(document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscTitle"));
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
							errMsg =  Ext.util.checkDrugReasons(document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6)+"Disc",errMsg,errCount);
					
						});
						(Ext.get(root+"Continued")).on('click', function(){

							errMsg =  Ext.util.checkDtContinuing(document.getElementById(this.id.substring(0,this.id.length-9)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-9)+"StartTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9)+"Start",errMsg,errCount);						

							errMsg =  Ext.util.checkDrugContinuing1(document.getElementById(this.id.substring(0,this.id.length-9)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopYy"),document.getElementById(this.id),document.getElementById(this.id + "Title"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
						});
						(Ext.get(root+"DiscTox")).on('click', function(){
							errMsg =  Ext.util.checkDrugReasons(document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7)+"Disc",errMsg,errCount);

						});
						(Ext.get(root+"DiscIntol")).on('click', function(){
							errMsg =  Ext.util.checkDrugReasons(document.getElementById(this.id.substring(0,this.id.length-9)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9)+"Disc",errMsg,errCount);
						});
						(Ext.get(root+"DiscFail")).on('click', function(){
							errMsg =  Ext.util.checkDrugReasons(document.getElementById(this.id.substring(0,this.id.length-8)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-8)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-8)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-8)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-8)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-8)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-8)+"DiscTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-8)+"Disc",errMsg,errCount);
						});
						(Ext.get(root+"DiscUnknown")).on('click', function(){
							errMsg =  Ext.util.checkDrugReasons(document.getElementById(this.id.substring(0,this.id.length-11)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-11)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-11)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-11)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-11)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-11)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-11)+"DiscTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-11)+"Disc",errMsg,errCount);
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
						errMsg =  Ext.util.checkDrugReasons(document.getElementById(root+"StopMm"),document.getElementById(root+"StopYy"),document.getElementById(root+"DiscTox"),document.getElementById(root+"DiscIntol"),document.getElementById(root+"DiscFail"),document.getElementById(root+"DiscUnknown"),document.getElementById(root+"DiscTitle"));
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
			for(var i1=1;i1<4;i1++)
			{

				(Ext.get(root + 'Active' + i1)).on('click', function(){
					var checkboxArray = new Array(3);
					for(var j=1;j<4;j++)
					{
						checkboxArray[j-1] = document.getElementById(this.id.substring(0,this.id.length-1)+j);
					}
					var checkboxRules = new Array(2);
					checkboxRules[0] = checkboxArray[0];
					checkboxRules[1] = checkboxArray[2];
					errMsg = Ext.util.checkCheckboxRulesWithMY(checkboxArray,checkboxRules,document.getElementById(this.id.substring(0, this.id.length-7)+"MY"),document.getElementById(this.id.substring(0, this.id.length-7)+"YM"),document.getElementById(this.id.substring(0, this.id.length-1)+"Title"));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-1),errMsg,errCount);
					errMsg = Ext.util.checkMYWithCheckbox(checkboxArray,document.getElementById(this.id.substring(0, this.id.length-7)+"MY"),document.getElementById(this.id.substring(0, this.id.length-7)+"YM"),'XX', document.getElementById(this.id.substring(0, this.id.length-7)+"Title"));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7), errMsg,errCount);
				});
			}
			(Ext.get(root + 'MY')).on('blur', function(){
				var checkboxArray = new Array(3);
				for(var j=1;j<4;j++)
				{
					checkboxArray[j-1] = document.getElementById(this.id.substring(0,this.id.length-2)+'Active' + j);
				}
				var checkboxRules = new Array(2);
				checkboxRules[0] = checkboxArray[0];
				checkboxRules[1] = checkboxArray[2];
				errMsg = Ext.util.checkCheckboxRulesWithMY(checkboxArray,checkboxRules,document.getElementById(this.id.substring(0, this.id.length-2)+"MY"),document.getElementById(this.id.substring(0, this.id.length-2)+"YM"),document.getElementById(this.id.substring(0, this.id.length-2)+"ActiveTitle"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2) + 'Active',errMsg,errCount);
				errMsg = Ext.util.checkMYWithCheckbox(checkboxArray,document.getElementById(this.id.substring(0, this.id.length-2)+"MY"),document.getElementById(this.id.substring(0, this.id.length-2)+"YM"),'XX', document.getElementById(this.id.substring(0, this.id.length-2)+"Title"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2), errMsg,errCount);
			});
			(Ext.get(root + 'YM')).on('blur', function(){
				var checkboxArray = new Array(3);
				for(var j=1;j<4;j++)
				{
					checkboxArray[j-1] = document.getElementById(this.id.substring(0,this.id.length-2)+'Active' + j);
				}
				var checkboxRules = new Array(2);
				checkboxRules[0] = checkboxArray[0];
				checkboxRules[1] = checkboxArray[2];
				errMsg = Ext.util.checkCheckboxRulesWithMY(checkboxArray,checkboxRules,document.getElementById(this.id.substring(0, this.id.length-2)+"MY"),document.getElementById(this.id.substring(0, this.id.length-2)+"YM"),document.getElementById(this.id.substring(0, this.id.length-2)+"ActiveTitle"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2) + 'Active',errMsg,errCount);
				errMsg = Ext.util.checkMYWithCheckbox(checkboxArray,document.getElementById(this.id.substring(0, this.id.length-2)+"MY"),document.getElementById(this.id.substring(0, this.id.length-2)+"YM"),'XX', document.getElementById(this.id.substring(0, this.id.length-2)+"Title"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2), errMsg,errCount);
			});
			var checkboxArray = new Array(3);
			for(var j=1;j<4;j++)
			{
				checkboxArray[j-1] = document.getElementById(root+'Active' + j);
			}
			var checkboxRules = new Array(2);
			checkboxRules[0] = checkboxArray[0];
			checkboxRules[1] = checkboxArray[2];
			errMsg = Ext.util.checkCheckboxRulesWithMY(checkboxArray,checkboxRules,document.getElementById(root+"MY"),document.getElementById(root+"YM"),document.getElementById(root+"ActiveTitle"));
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
	(Ext.get('dmType1Active')).on('change', function(){
		Ext.util.checkUnique2(document.getElementById('dmType1Active'),document.getElementById('dmType2Active'));
	});
	(Ext.get('dmType2Active')).on('change', function(){
		Ext.util.checkUnique2(document.getElementById('dmType2Active'),document.getElementById('dmType1Active'));
	});
	Ext.get('completeTreatDt').on('blur',function() {
		errMsg = Ext.util.checkRadioCorresponding(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'completeTreat[]',errMsg,errCount);
		errMsg = Ext.util.checkDateCorresponding(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatDtTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'completeTreatDt',errMsg,errCount);
	});
	errMsg = Ext.util.checkRadioCorresponding(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'completeTreat[]',errMsg,errCount);
	errMsg = Ext.util.checkDateCorresponding(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatDtTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'completeTreatDt',errMsg,errCount);

	var taArr = allElements["textarea"];
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

	
	var TBStatusArray = new Array(5);
	TBStatusArray[0] = "completeTreat[]";
	TBStatusArray[1] = "asymptomaticTb[]";
	TBStatusArray[2] = "suspectedTb[]";
	TBStatusArray[3] = "currentTreat[]";
	TBStatusArray[4] = "currentProp[]";

	var dtFlg = document.getElementById('bloodTransDt') == null?false:true;
	if(dtFlg)
	{
		var bloodTransArr = new Array();
		bloodTransArr[0] = 'bloodTransAnswer0';
		bloodTransArr[1] = 'bloodTransAnswer1';
		bloodTransArr[2] = 'bloodTransAnswer2';
		for(i = 0; i< bloodTransArr.length; i++)
		{
			Ext.get(bloodTransArr[i]).on('click', function(){
				var bTAArr = new Array();
				bTAArr[0] = document.getElementById('bloodTransDt');
				bTAArr[1] = document.getElementById('bloodTransCommentComment');
				Ext.util.disableSectionByInternalRadio(document.getElementById('bloodTransAnswer0'), bTAArr, txtFormat,radioArr, false);
				errMsg = Ext.util.checkRadioCorresponding(document.getElementById(bloodTransArr[0]),document.getElementById('bloodTransDt'),document.getElementById('bloodTransAnswerTitle'));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodTransAnswer[]',errMsg,errCount);
				errMsg = Ext.util.checkDateCorresponding(document.getElementById(bloodTransArr[0]),document.getElementById('bloodTransDt'),document.getElementById('bloodTransDtTitle'));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodTransDt',errMsg,errCount);
			});
		}
		Ext.get('bloodTransDt').on('blur', function(){
			errMsg = Ext.util.checkRadioCorresponding(document.getElementById(bloodTransArr[0]),document.getElementById('bloodTransDt'),document.getElementById('bloodTransAnswerTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodTransAnswer[]',errMsg,errCount);
			errMsg = Ext.util.checkDateCorresponding(document.getElementById(bloodTransArr[0]),document.getElementById('bloodTransDt'),document.getElementById('bloodTransDtTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodTransDt',errMsg,errCount);
			Ext.util.splitDate(document.getElementById('bloodTransDt'),document.getElementById("bloodTransDd"),document.getElementById("bloodTransMm"),document.getElementById("bloodTransYy"));
		});
		var bTAArr = new Array();
		bTAArr[0] = document.getElementById('bloodTransDt');
		bTAArr[1] = document.getElementById('bloodTransCommentComment');
		Ext.util.disableSectionByInternalRadio(document.getElementById('bloodTransAnswer0'), bTAArr, txtFormat,radioArr, true);
		errMsg = Ext.util.checkRadioCorresponding(document.getElementById(bloodTransArr[0]),document.getElementById('bloodTransDt'),document.getElementById('bloodTransAnswerTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodTransAnswer[]',errMsg,errCount);
		errMsg = Ext.util.checkDateCorresponding(document.getElementById(bloodTransArr[0]),document.getElementById('bloodTransDt'),document.getElementById('bloodTransDtTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodTransDt',errMsg,errCount);		
		Ext.util.splitDate(document.getElementById('bloodTransDt'),document.getElementById("bloodTransDd"),document.getElementById("bloodTransMm"),document.getElementById("bloodTransYy"));

	}
	var lowestCd4CntDT = new Ext.form.DateField({
		fieldLabel: '',
		maskRe : /[\d{1,2}\/]/,
		validationEvent: false,
		allowBlank:true
	});
	lowestCd4CntDT.applyToMarkup('lowestCd4CntDT');
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

	var firstViralLoadDT = new Ext.form.DateField({
		fieldLabel: '',
		maskRe : /[\d{1,2}\/]/,
		validationEvent: false,
		allowBlank:true
	});
	firstViralLoadDT.applyToMarkup('firstViralLoadDT');
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
		Ext.util.disableSectionByRadio(document.getElementById("fp2"), radioArr, false, newFamPlanArr);
	});
	Ext.get('fp2').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById(this.id),  radioArr, false, newFamPlanArr);
		//errCount = Ext.util.clearElements(allElements["famPlan"], errFields,errMsgs, errpCount);
	});
	Ext.util.disableSectionByRadio(document.getElementById("fp2"),  radioArr, true, newFamPlanArr);
	
		
	Ext.get('arvY').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById("arvN"), radioArr, false, allElements["arvPrevious"]);
	});
	Ext.get('arvN').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById(this.id), radioArr, false, allElements["arvPrevious"]);
	});
	Ext.util.disableSectionByRadio(document.getElementById("arvN"), radioArr, true,  allElements["arvPrevious"]);	

	Ext.get('noneTreatments').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById(this.id), radioArr, false, allElements["medAllergy"]);
	});
	Ext.util.disableSectionByRadio(document.getElementById("noneTreatments"), radioArr, true, allElements["medAllergy"]);		

	if(sexFlg == "2")
    {
  		var disSec = new Array();
  		disSec[0] = "oh2";
  		disSec[1] = "arvExcl";
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
 
  	var oh2Arr = new Array();
  	oh2Arr[0] = "pregnant1";
  	oh2Arr[1] = "pregnant2";
  	oh2Arr[2] = "pregnant3";
  	for(i=0; i < oh2Arr.length; i++)
  	{
  		Ext.get(oh2Arr[i]).on('click', function(){
					Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(oh2Arr), allElements["oh2"], txtFormat);
			});
  	}
	  Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(oh2Arr), allElements["oh2"], txtFormat);	

  	var oh2subArr = new Array();
  	oh2subArr[0] = "pregnantPrenatal1";
  	oh2subArr[1] = "pregnantPrenatal2";
  	for(i=0; i < oh2subArr.length; i++)
  	{
  		Ext.get(oh2subArr[i]).on('click', function(){
					Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(oh2subArr), allElements["oh2_sub"], txtFormat);
			});
  	}
	  Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(oh2subArr), allElements["oh2_sub"], txtFormat);	
	  
  	var arvArr = new Array();
  	arvArr[0] = "ARVex1";
  	arvArr[1] = "ARVex2";
  	arvArr[2] = "ARVex3";
  	for(i=0; i < arvArr.length; i++)
  	{
  		Ext.get(arvArr[i]).on('click', function(){
					Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(arvArr), allElements["arvExcl"], txtFormat);
			});
  	}
	  Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(arvArr), allElements["arvExcl"], txtFormat);	 
  }
  
	var tempRadioArr = allElements["radio"]; 
	var radioArr = Ext.util.getAllRadios(tempRadioArr);
	
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
	
	for(i=0;i<TBStatusArray.length;i++)
	{
		Ext.get(TBStatusArray[i]).on('click', function(){
			var key = Ext.util.getKeyByID1(TBStatusArray, this.id)
			errMsg = Ext.util.checkItemSelected1(TBStatusArray, radioArr, true,document.getElementById('tbStatusTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbStatus',errMsg,errCount);
			errMsg = Ext.util.checkRadioCorresponding1(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'), radioArr, document.getElementById('completeTreatTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'completeTreat[]',errMsg,errCount);
			errMsg = Ext.util.checkDateCorresponding(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatDtTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'completeTreatDt',errMsg,errCount);		
		});
	}
	
	var hiddenTBArr = new Array();
	for(i=0;i<TBStatusArray.length;i++)
	{
		hiddenTBArr[i] = TBStatusArray[i].substring(0, TBStatusArray[i].indexOf('[]'));
	}
	for(i=0;i<TBStatusArray.length; i++)
	{
		(Ext.get(TBStatusArray[i])).on('click', function(){
			var loc = Ext.util.getKeyByID1(TBStatusArray, this.id);
			Ext.util.selectDiffRadio(document.getElementById(this.id), hiddenTBArr, loc,radioArr);
		});	
	}
	
	var functionStatus = new Array(3);
	functionStatus[0] = "functionalStatus1";
	functionStatus[1] = "functionalStatus2";
	functionStatus[2] = "functionalStatus4";
	for(i=0;i<3;i++)
	{
		Ext.get(functionStatus[i]).on('click', function(){
			errMsg = Ext.util.isItemSelected(functionStatus, radioArr, false, document.getElementById('functionalStatusTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'functionalStatus',errMsg,errCount);
		}, document.getElementById(this.id), {delay: 5});
	}
	Ext.get('vDate').on('blur', function(){
		errMsg = Ext.util.checkItemSelected1(TBStatusArray, radioArr, true, document.getElementById('tbStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbStatus',errMsg,errCount);
		errMsg = Ext.util.isItemSelected(functionStatus,radioArr,false, document.getElementById('functionalStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'functionalStatus',errMsg,errCount);
		errMsg = Ext.util.checkWhoStage(whoStages,document.getElementById('whoStageTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'whoStage',errMsg,errCount);
 	});
	if(document.mainForm.vDate.value!='' && document.mainForm.vDate.value!='//')
	{
		errMsg = Ext.util.checkItemSelected1(TBStatusArray, radioArr, true,document.getElementById('tbStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbStatus',errMsg,errCount);
		errMsg = Ext.util.isItemSelected(functionStatus, radioArr, false, document.getElementById('functionalStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'functionalStatus',errMsg,errCount);
		errMsg = Ext.util.checkWhoStage(whoStages,document.getElementById('whoStageTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'whoStage',errMsg,errCount);
	}

	Ext.get('vitalWeight').on('blur', function(){
		errMsg = Ext.util.checkWeight(document.getElementById('vitalWeight'),document.getElementById("vitalWeightTitle"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeight',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.getElementById('vitalWeight'),document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr, false, document.getElementById("vitalWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
	
	});
	
	
	Ext.get('vitalWeightUnit1').on('click', function(){
		errMsg = Ext.util.checkUnit(document.getElementById('vitalWeight'),document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr, false, document.getElementById("vitalWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
	
	});
	Ext.get('vitalWeightUnit2').on('click', function(){
		errMsg = Ext.util.checkUnit(document.getElementById('vitalWeight'),document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr, false, document.getElementById("vitalWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
	
	});

	errMsg = Ext.util.checkWeight(document.getElementById('vitalWeight'),document.getElementById("vitalWeightTitle"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeight',errMsg,errCount);
	errMsg = Ext.util.checkUnit(document.getElementById('vitalWeight'),document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr, true, document.getElementById("vitalWeightUnitTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		

	
	Ext.get('vitalPrevWt').on('blur', function(){
		errMsg = Ext.util.checkWeight(document.mainForm.vitalPrevWt,document.getElementById("vitalPrevWtTitle"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalPrevWt',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.getElementById('vitalPrevWt'),document.getElementById("vitalPrevWtUnit1"),document.getElementById("vitalPrevWtUnit2"),radioArr, false, document.getElementById("vitalPrevWtUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalPrevWtUnit',errMsg,errCount);

	});
	Ext.get('vitalPrevWtUnit1').on('click', function(){
		errMsg = Ext.util.checkUnit(document.getElementById('vitalPrevWt'),document.getElementById("vitalPrevWtUnit1"),document.getElementById("vitalPrevWtUnit2"),radioArr, false, document.getElementById("vitalPrevWtUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalPrevWtUnit',errMsg,errCount);

	});
	Ext.get('vitalPrevWtUnit2').on('click', function(){
		errMsg = Ext.util.checkUnit(document.getElementById('vitalPrevWt'),document.getElementById("vitalPrevWtUnit1"),document.getElementById("vitalPrevWtUnit2"),radioArr, false, document.getElementById("vitalPrevWtUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalPrevWtUnit',errMsg,errCount);

	});
	errMsg = Ext.util.checkWeight(document.getElementById('vitalPrevWt'),document.getElementById("vitalPrevWtTitle"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalPrevWt',errMsg,errCount);
	errMsg = Ext.util.checkUnit(document.getElementById('vitalPrevWt'),document.getElementById("vitalPrevWtUnit1"),document.getElementById("vitalPrevWtUnit2"),radioArr, true, document.getElementById("vitalPrevWtUnitTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalPrevWtUnit',errMsg,errCount);
});


