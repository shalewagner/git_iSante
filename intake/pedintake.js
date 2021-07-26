	
Ext.onReady(function() {
	var txtFormat = new Array();
	var pedMotherFormat = new Array();
	var pedFratFormat = new Array();
	var root;
	var suffix;
	var i;
	var suffix70;
	var prefix4;
	var prefix9;
	var root;
	var startMm,startYy,startErrLoc,stopMm,stopYy,stopErrLoc,continuing,continuingErrLoc;
	var reasonsErrLoc;
	var defaultVal;
	var sexFlg = Ext.getDom('sex1').value;
   var clinicalExamFormat = new Array(1);
	var j=0;
	var k=0;

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
		
 	pedVitCurWtLast = new Ext.form.TextField({
		fieldLabel: '',
		name: 'pedVitCurWtLast',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});

	pedVitCurWtLast.applyToMarkup(document.mainForm.pedVitCurWtLast); 
	
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
	pedVitCurPt2 = new Ext.form.TextField({
		fieldLabel: '',
		name: 'pedVitCurPt2',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});
	pedVitCurPt2.applyToMarkup(document.mainForm.pedVitCurPt2); 
	Ext.get('pedVitCurPt2').on('blur', function(){
		errMsg = Ext.util.isValueInBound(document.getElementById('pedVitCurPt2'),document.getElementById('pedVitCurPt2Title'),'0','100','');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurPt2',errMsg,errCount);	
	});
	errMsg = Ext.util.isValueInBound(document.getElementById('pedVitCurPt2'),document.getElementById('pedVitCurPt2Title'),'0','100','');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurPt2',errMsg,errCount);
	pedVitCurHeadCirc = new Ext.form.TextField({
		fieldLabel: '',
		name: 'pedVitCurHeadCirc',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});
	pedVitCurHeadCirc.applyToMarkup(document.mainForm.pedVitCurHeadCirc); 
	Ext.get('pedVitCurHeadCirc').on('blur', function(){
		errMsg = Ext.util.isValueInBound(document.getElementById('pedVitCurHeadCirc'),document.getElementById('pedVitCurHeadCircTitle'),'0','100','');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurHeadCirc',errMsg,errCount);	
	});
	errMsg = Ext.util.isValueInBound(document.getElementById('pedVitCurHeadCirc'),document.getElementById('pedVitCurHeadCircTitle'),'0','100','');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurHeadCirc',errMsg,errCount);
	pedVitCurCircCirc = new Ext.form.TextField({
		fieldLabel: '',
		name: 'pedVitCurCircCirc',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});
	pedVitCurCircCirc.applyToMarkup(document.mainForm.pedVitCurCircCirc); 
	Ext.get('pedVitCurCircCirc').on('blur', function(){
		errMsg = Ext.util.isValueInBound(document.getElementById('pedVitCurCircCirc'),document.getElementById('pedVitCurCircCircTitle'),'0','100','');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurCircCirc',errMsg,errCount);	
	});
	errMsg = Ext.util.isValueInBound(document.getElementById('pedVitCurCircCirc'),document.getElementById('pedVitCurCircCircTitle'),'0','100','');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurCircCirc',errMsg,errCount);
	pedVitCurBracCirc = new Ext.form.TextField({
		fieldLabel: '',
		name: 'pedVitCurBracCirc',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});
	pedVitCurBracCirc.applyToMarkup(document.mainForm.pedVitCurBracCirc); 
	Ext.get('pedVitCurBracCirc').on('blur', function(){
		errMsg = Ext.util.isValueInBound(document.getElementById('pedVitCurBracCirc'),document.getElementById('pedVitCurBracCircTitle'),'0','100','');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurBracCirc',errMsg,errCount);	
	});
	errMsg = Ext.util.isValueInBound(document.getElementById('pedVitCurBracCirc'),document.getElementById('pedVitCurBracCircTitle'),'0','100','');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurBracCirc',errMsg,errCount);
	pedVitCurOxySat = new Ext.form.TextField({
		fieldLabel: '',
		name: 'pedVitCurOxySat',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});
	pedVitCurOxySat.applyToMarkup(document.mainForm.pedVitCurOxySat); 
	Ext.get('pedVitCurOxySat').on('blur', function(){
		errMsg = Ext.util.isValueInBound(document.getElementById('pedVitCurOxySat'),document.getElementById('pedVitCurOxySatTitle'),'0','100','');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurOxySat',errMsg,errCount);	
	});
	errMsg = Ext.util.isValueInBound(document.getElementById('pedVitCurOxySat'),document.getElementById('pedVitCurOxySatTitle'),'0','100','');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurOxySat',errMsg,errCount);
	Ext.get('pedMotherHistAge').on('blur', function(){
		errMsg = Ext.util.isValueInBound(document.getElementById('pedMotherHistAge'),document.getElementById('pedMotherHistAgeTitle'),'0','','');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedMotherHistAge',errMsg,errCount);	
	});
	errMsg = Ext.util.isValueInBound(document.getElementById('pedMotherHistAge'),document.getElementById('pedMotherHistAgeTitle'),'0','','');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedMotherHistAge',errMsg,errCount);

	var positiveNumArr = new Array(3);
	positiveNumArr[0] = 'pedVitBirLen';
	positiveNumArr[1] = 'pedVitBirPc';
	positiveNumArr[2] = 'pedVitBirGest';
	var positiveNumFmatArr = new Array();
	for(i=0;i<positiveNumArr.length;i++)
	{

		positiveNumFmatArr[i] = new Ext.form.TextField({
			fieldLabel: '',
			maskRe : /[\d\.]/,
			validationEvent: false,
			allowBlank:true
		});	
		positiveNumFmatArr[i].applyToMarkup(positiveNumArr[i]); 	
		Ext.get(positiveNumArr[i]).on('blur', function(){
			errMsg = Ext.util.isValueInBound(document.getElementById(this.id),document.getElementById(this.id + 'Title'),'0','100','');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);	
		});
		errMsg = Ext.util.isValueInBound(document.getElementById(positiveNumArr[i]),document.getElementById(positiveNumArr[i] + 'Title'),'0','100','');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,positiveNumArr[i],errMsg,errCount);		
	}
	var pedVitBirWt = new Ext.form.TextField({
		fieldLabel: '',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});	
	pedVitBirWt.applyToMarkup(document.getElementById('pedVitBirWt')); 	
	
	Ext.get('pedVitBirWt').on('blur', function(){
		errMsg = Ext.util.isValueInBound(document.mainForm.pedVitBirWt,document.getElementById('pedVitBirWt'),'0','500','');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitBirWt',errMsg,errCount);	
		errMsg = Ext.util.checkUnit(document.mainForm.pedVitBirWt,document.getElementById("pedVitBirWtUnit1"),document.getElementById("pedVitBirWtUnit2"), radioArr, true, document.getElementById("pedVitBirWtUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitBirWtUnit',errMsg,errCount);

	});
	Ext.get('pedVitBirWtUnit1').on('click', function(){
		errMsg = Ext.util.checkUnit(document.mainForm.pedVitBirWt,document.getElementById("pedVitBirWtUnit1"),document.getElementById("pedVitBirWtUnit2"), radioArr, true, document.getElementById("pedVitBirWtUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitBirWtUnit',errMsg,errCount);
	}, document.getElementById(this.id), {delay: 5});
	Ext.get('pedVitBirWtUnit2').on('click', function(){
		errMsg = Ext.util.checkUnit(document.mainForm.pedVitBirWt,document.getElementById("pedVitBirWtUnit1"),document.getElementById("pedVitBirWtUnit2"), radioArr, true, document.getElementById("pedVitBirWtUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitBirWtUnit',errMsg,errCount);

	}, document.getElementById(this.id), {delay: 5});
	errMsg = Ext.util.isValueInBound(document.mainForm.pedVitBirWt,document.getElementById('pedVitBirWt'),'0','500','');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitBirWt',errMsg,errCount);	
	errMsg = Ext.util.checkUnit(document.mainForm.pedVitBirWt,document.getElementById("pedVitBirWtUnit1"),document.getElementById("pedVitBirWtUnit2"), radioArr, true, document.getElementById("pedVitBirWtUnitTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitBirWtUnit',errMsg,errCount);
	var pedFeedAgeArr = new Array(4);
	pedFeedAgeArr[0] = 'pedFeedBreastAge';
	pedFeedAgeArr[1] = 'pedFeedFormulaAge';
	pedFeedAgeArr[2] = 'pedFeedMixedAge';
	pedFeedAgeArr[3] = 'pedFeedOtherAge';
	for(i=0;i<pedFeedAgeArr.length;i++)
	{	
		Ext.get(pedFeedAgeArr[i]).on('blur', function(){
			errMsg = Ext.util.isValueInBound(document.getElementById(this.id),document.getElementById(this.id + 'Title'),'0','100','');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);	
		});
		errMsg = Ext.util.isValueInBound(document.getElementById(pedFeedAgeArr[i]),document.getElementById(pedFeedAgeArr[i] + 'Title'),'0','100','');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,pedFeedAgeArr[i],errMsg,errCount);		
	}
	
	var pedMotherHistGrosArr = new Array(7);
 	pedMotherHistGrosArr[0] = 'pedMotherHistGrosGrav';
	pedMotherHistGrosArr[1] = 'pedMotherHistGrosPara';
	pedMotherHistGrosArr[2] = 'pedMotherHistGrosAbor';
	pedMotherHistGrosArr[3] = 'pedMotherHistGrosViva';
	pedMotherHistGrosArr[4] = 'pedMotherHistGrosDeadAge1';
	pedMotherHistGrosArr[5] = 'pedMotherHistGrosDeadAge2';
	pedMotherHistGrosArr[6] = 'pedMotherHistGrosDeadAge3';

	for(i=0;i<pedMotherHistGrosArr.length;i++)
	{	
		Ext.get(pedMotherHistGrosArr[i]).on('blur', function(){
			errMsg = Ext.util.isValueInBound(document.getElementById(this.id),document.getElementById(this.id + 'Title'),'0','','');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);	
		});
		errMsg = Ext.util.isValueInBound(document.getElementById(pedMotherHistGrosArr[i]),document.getElementById(pedMotherHistGrosArr[i] + 'Title'),'0','','');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,pedMotherHistGrosArr[i],errMsg,errCount);		
	}	
	var names = new Array();
	names[0] = "pedRapidHiv";
	names[1] = "pedPcr";
	names[2] = "pedElisa";
	names[3] = "pedAntigen";
	names[4] = "pedARVever";
	names[5] = "pedMedAllergy";
	names[6] = "pedImmVacc";
	names[7] = "pedMenses";
	names[8] = "pedPreg";
	names[9] = "pedPregPrenat";
	names[10] = "papTest";
	names[11] = "pedMotherHist";
	names[12] = "pedFratHist"; 
	names[13] = "papTestResult";
	names[14] = "pedFeed";
	names[15] = "pedArvKnown";
	names[16] = "pedMedElig";
	names[17] = "conditions";
	
	var allElements = Ext.util.getAllElements(document.mainForm,names);
	var txtArr = allElements["text"];

	var tempRadioArr = allElements["radio"]; 
	var radioArr = Ext.util.getAllRadios(tempRadioArr);
	
	for(i=0;i<txtArr.length;i++)
	{	
		suffix = txtArr[i].id.substring(txtArr[i].id.length-2);
		prefix9 = txtArr[i].name.substring(0,9);
		if(suffix == "Dt")
		{
			txtFormat[txtArr[i].id] = new Ext.form.DateField({
				fieldLabel: '',
				maskRe : /[\Xx{1,2}\d{1,2}\/]/,
				validationEvent: false,
				allowBlank:true
			});
			txtFormat[txtArr[i].id].applyToMarkup(txtArr[i]);
			
			prefix4 = txtArr[i].id.substring(0,4);
			if(prefix4=='immu')
			{
				defaultVal = 'XX';
			}
			else
			{
				defaultVal = '';
			}
			if(txtArr[i].id != 'bloodTransDt')
			{
				(Ext.get(txtArr[i].id)).on('blur', function(){
					if(this.id.substring(0,4)=='immu')
					{
						defaultVal = 'XX';
					}
					else
					{
						defaultVal = '';
					}
					if(this.id.substring(this.id.length-7,this.id.length)=='StartDt')
					{
						errMsg =  Ext.util.validateStartEndDate(document.getElementById(this.id),document.getElementById(this.id + 'Title'),document.getElementById(this.id.substring(0,this.id.length-7) + 'StopDt'),document.getElementById(this.id.substring(0,this.id.length-7) + 'StopDtTitle'), defaultVal);
					}
					else if(this.id.substring(this.id.length-6,this.id.length)=='StopDt')
					{
						errMsg =  Ext.util.validateStartEndDate(document.getElementById(this.id.substring(0,this.id.length-6) + 'StartDt'),document.getElementById(this.id.substring(0,this.id.length-6) + 'StartDtTitle'),document.getElementById(this.id),document.getElementById(this.id + 'Title'), defaultVal);
					}
					else
					{
						errMsg =  Ext.util.validateDateFieldNonPatient(document.getElementById(this.id),document.getElementById(this.id + 'Title'),defaultVal);
					}
					Ext.util.splitDate(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-2) + "Dd"),document.getElementById(this.id.substring(0,this.id.length-2) + "Mm"),document.getElementById(this.id.substring(0,this.id.length-2) + "Yy"));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg,errCount);
				});
				if(txtArr[i].id.substring(txtArr[i].id.length-7,txtArr[i].id.length)=='StartDt')
				{
					errMsg =  Ext.util.validateStartEndDate(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id + 'Title'),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-7) + 'StopDt'),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-7) + 'StopDtTitle'), defaultVal);
				}
				else if(txtArr[i].id.substring(txtArr[i].id.length-6,txtArr[i].id.length)=='StopDt')
				{
					errMsg =  Ext.util.validateStartEndDate(document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-6) + 'StartDt'),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-6) + 'StartDtTitle'),document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id + 'Title'), defaultVal);
				}
				else
				{
					errMsg = Ext.util.validateDateFieldNonPatient(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id + 'Title'),defaultVal);
				}
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
							errMsg =  Ext.util.checkDrugReasons1(document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscProph"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTitle"));
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
							errMsg =  Ext.util.checkDrugReasons1(document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscProph"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTitle"));
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
							errMsg =  Ext.util.checkDrugReasons1(document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscProph"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscTitle"));
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
							errMsg =  Ext.util.checkDrugReasons1(document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscProph"),document.getElementById(this.id.substring(0,this.id.length-6)+"DiscTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6)+"Disc",errMsg,errCount);
					
						});
						(Ext.get(root+"Continued")).on('click', function(){

							errMsg =  Ext.util.checkDtContinuing(document.getElementById(this.id.substring(0,this.id.length-9)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-9)+"StartTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9)+"Start",errMsg,errCount);						
							errMsg =  Ext.util.checkDrugContinuing1(document.getElementById(this.id.substring(0,this.id.length-9)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopYy"),document.getElementById(this.id),document.getElementById(this.id + "Title"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
						});
						(Ext.get(root+"DiscTox")).on('click', function(){
							errMsg =  Ext.util.checkDrugReasons1(document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscProph"),document.getElementById(this.id.substring(0,this.id.length-7)+"DiscTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7)+"Disc",errMsg,errCount);

						});
						(Ext.get(root+"DiscIntol")).on('click', function(){
							errMsg =  Ext.util.checkDrugReasons1(document.getElementById(this.id.substring(0,this.id.length-9)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscProph"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9)+"Disc",errMsg,errCount);
						});
						(Ext.get(root+"DiscProph")).on('click', function(){
							errMsg =  Ext.util.checkDrugReasons1(document.getElementById(this.id.substring(0,this.id.length-9)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscProph"),document.getElementById(this.id.substring(0,this.id.length-9)+"DiscTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9)+"Disc",errMsg,errCount);
						});
						(Ext.get(root+"DiscFail")).on('click', function(){
							errMsg =  Ext.util.checkDrugReasons1(document.getElementById(this.id.substring(0,this.id.length-8)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-8)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-8)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-8)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-8)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-8)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-8)+"DiscProph"),document.getElementById(this.id.substring(0,this.id.length-8)+"DiscTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-8)+"Disc",errMsg,errCount);
						});
						
						(Ext.get(root+"DiscUnknown")).on('click', function(){
							errMsg =  Ext.util.checkDrugReasons1(document.getElementById(this.id.substring(0,this.id.length-11)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-11)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-11)+"DiscTox"),document.getElementById(this.id.substring(0,this.id.length-11)+"DiscIntol"),document.getElementById(this.id.substring(0,this.id.length-11)+"DiscFail"),document.getElementById(this.id.substring(0,this.id.length-11)+"DiscUnknown"),document.getElementById(this.id.substring(0,this.id.length-11)+"DiscProph"),document.getElementById(this.id.substring(0,this.id.length-11)+"DiscTitle"));
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
							errCount = Ext.util.showErrorHead(errFields,errMsgs,root,errMsg,errCount);
						}
						errMsg =  Ext.util.checkDrugContinuing1(document.getElementById(root+"StartMm"),document.getElementById(root+"StartYy"),document.getElementById(root+"StopMm"),document.getElementById(root+"StopYy"),document.getElementById(root+"Continued"),document.getElementById(root+"ContinuedTitle"));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,root+"Continued",errMsg,errCount);
						errMsg =  Ext.util.checkDrugReasons1(document.getElementById(root+"StopMm"),document.getElementById(root+"StopYy"),document.getElementById(root+"DiscTox"),document.getElementById(root+"DiscIntol"),document.getElementById(root+"DiscFail"),document.getElementById(root+"DiscUnknown"),document.getElementById(root+"DiscProph"),document.getElementById(root+"DiscTitle"));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,root+"Disc",errMsg,errCount);
					}
					
				}
				else
				{
			            if(txtArr[i].id != 'pedCompleteTreatStartMm' && txtArr[i].id != 'pedCompleteTreatStartYy' && txtArr[i].id != 'pedCompleteTreatStopMm' && txtArr[i].id != 'pedCompleteTreatStopYy' && txtArr[i].id != 'debutINHStartMm' && txtArr[i].id != 'debutINHStartYy' && txtArr[i].id != 'debutINHStopMm' && txtArr[i].id != 'debutINHStopYy') {
					(Ext.get(txtArr[i].id)).on('blur', function(){
						errMsg = Ext.util.validateMY(document.getElementById(this.id.substring(0, this.id.length-2)+"Mm"),document.getElementById(this.id.substring(0, this.id.length-2)+"Yy"),document.getElementById(this.id.substring(0, this.id.length-2)+"Title"),'XX');
						errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2),errMsg,errCount);

					}, document.getElementById(this.id), {delay: 5});
                                    }
					errMsg =  Ext.util.validateMY(document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Mm"),document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Yy"),document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Title"),'XX');
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
					var checkboxArray = new Array(2);
					for(var j=1;j<4;j++)
					{
						checkboxArray[j-1] = document.getElementById(this.id.substring(0,this.id.length-1)+j);
					}
					errMsg = Ext.util.checkCheckboxesWithMY(checkboxArray,document.getElementById(this.id.substring(0, this.id.length-7)+"MY"),document.getElementById(this.id.substring(0, this.id.length-7)+"YM"),document.getElementById(this.id.substring(0, this.id.length-1)+"Title"));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-1),errMsg,errCount);
					errMsg = Ext.util.checkMYWithCheckbox(checkboxArray,document.getElementById(this.id.substring(0, this.id.length-7)+"MY"),document.getElementById(this.id.substring(0, this.id.length-7)+"YM"),'XX', document.getElementById(this.id.substring(0, this.id.length-7)+"Title"));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7), errMsg,errCount);
				});
			}
			(Ext.get(root + 'MY')).on('blur', function(){
				var checkboxArray = new Array(2);
				for(var j=1;j<4;j++)
				{
					checkboxArray[j-1] = document.getElementById(this.id.substring(0,this.id.length-2)+'Active' + j);
				}
				errMsg = Ext.util.checkCheckboxesWithMY(checkboxArray,document.getElementById(this.id.substring(0, this.id.length-2)+"MY"),document.getElementById(this.id.substring(0, this.id.length-2)+"YM"),document.getElementById(this.id.substring(0, this.id.length-2)+"ActiveTitle"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2) + 'Active',errMsg,errCount);
				errMsg = Ext.util.checkMYWithCheckbox(checkboxArray,document.getElementById(this.id.substring(0, this.id.length-2)+"MY"),document.getElementById(this.id.substring(0, this.id.length-2)+"YM"),'XX', document.getElementById(this.id.substring(0, this.id.length-2)+"Title"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2), errMsg,errCount);
			});
			(Ext.get(root + 'YM')).on('blur', function(){
				var checkboxArray = new Array(2);
				for(var j=1;j<4;j++)
				{
					checkboxArray[j-1] = document.getElementById(this.id.substring(0,this.id.length-2)+'Active' + j);
				}
				errMsg = Ext.util.checkCheckboxesWithMY(checkboxArray,document.getElementById(this.id.substring(0, this.id.length-2)+"MY"),document.getElementById(this.id.substring(0, this.id.length-2)+"YM"),document.getElementById(this.id.substring(0, this.id.length-2)+"ActiveTitle"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2) + 'Active',errMsg,errCount);
				errMsg = Ext.util.checkMYWithCheckbox(checkboxArray,document.getElementById(this.id.substring(0, this.id.length-2)+"MY"),document.getElementById(this.id.substring(0, this.id.length-2)+"YM"),'XX', document.getElementById(this.id.substring(0, this.id.length-2)+"Title"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2), errMsg,errCount);
			});
			var checkboxArray = new Array(2);
			for(var j=1;j<4;j++)
			{
				checkboxArray[j-1] = document.getElementById(root+'Active' + j);
			}
			errMsg = Ext.util.checkCheckboxesWithMY(checkboxArray,document.getElementById(root+"MY"),document.getElementById(root+"YM"),document.getElementById(root+"ActiveTitle"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2) + 'Active',errMsg,errCount);
			errMsg = Ext.util.checkMYWithCheckbox(checkboxArray,document.getElementById(root+"MY"),document.getElementById(root+"YM"),'XX', document.getElementById(root +"Title"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root, errMsg,errCount);
		}
		else
		{
			if(prefix9 == "pedMother")
			{
				pedMotherFormat[j] = new Ext.form.TextField({
					fieldLabel: '',
					validationEvent: false,
					allowBlank:true
				});
				pedMotherFormat[j].applyToMarkup(txtArr[i]);
				j++;
				
			}
			else if(prefix9 == "pedFratHi")
			{
				pedFratFormat[k] = new Ext.form.TextField({
					fieldLabel: '',
					validationEvent: false,
					allowBlank:true
				});
				pedFratFormat[k].applyToMarkup(txtArr[i]);
				k++;				
			}
			else
			{
				txtFormat[i] = new Ext.form.TextField({
					fieldLabel: '',
					validationEvent: false,
					allowBlank:true
				});
				txtFormat[i].applyToMarkup(txtArr[i]);
				if(txtArr[i].id.substring(txtArr[i].id.length-3) == 'Age' && isNaN(txtArr[i].id.substring(txtArr[i].id.length-4, txtArr[i].id.length-3)) == false)
				{
					
					(Ext.get(txtArr[i].id)).on('blur', function(){
						errMsg = Ext.util.isValueInBound(document.getElementById(this.id),document.getElementById(this.id + 'Title'),'0','','');
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);	
						errMsg = Ext.util.checkUnit(document.getElementById(this.id), document.getElementById(this.id + 'Unit1'),document.getElementById(this.id + 'Unit2'), radioArr, true, document.getElementById(this.id + 'UnitTitle'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id + 'Unit',errMsg,errCount);
					});
					Ext.get(txtArr[i].id + 'Unit1').on('click', function(){
						errMsg = Ext.util.checkUnit(document.getElementById(this.id.substring(0,this.id.length-5)),document.getElementById(this.id), document.getElementById(this.id.substring(0,this.id.length-1) + '2'), radioArr, true, document.getElementById(this.id.substring(0,this.id.length-1) + 'Title'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-1),errMsg,errCount);
					}, document.getElementById(this.id), {delay: 5});
					Ext.get(txtArr[i].id + 'Unit2').on('click', function(){
						errMsg = Ext.util.checkUnit(document.getElementById(this.id.substring(0,this.id.length-5)), document.getElementById(this.id.substring(0,this.id.length-1) + '1'),document.getElementById(this.id), radioArr, true, document.getElementById(this.id.substring(0,this.id.length-1) + 'Title'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-1),errMsg,errCount);
					}, document.getElementById(this.id), {delay: 5});	
					errMsg = Ext.util.isValueInBound(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id + 'Title'),'0','','');
					errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id,errMsg,errCount);
					errMsg = Ext.util.checkUnit(document.getElementById(txtArr[i].id), document.getElementById(txtArr[i].id + 'Unit1'),document.getElementById(txtArr[i].id + 'Unit2'), radioArr, true, document.getElementById(txtArr[i].id + 'UnitTitle'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id,errMsg,errCount);
				}
				
			}
		}
	}

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
	

	var evalTBArray = new Array(12);
	evalTBArray[0] = 'completeTreat';
	evalTBArray[1] = 'currentTreat';
	evalTBArray[2] = 'propINH';
	evalTBArray[3] = 'currentProp';
	evalTBArray[4] = 'pedCompleteTreatStartMm';
	evalTBArray[5] = 'pedCompleteTreatStartYy';
	evalTBArray[6] = 'pedCompleteTreatStopMm';
	evalTBArray[7] = 'pedCompleteTreatStopYy';
	evalTBArray[8] = 'debutINHStartMm';
	evalTBArray[9] = 'debutINHStartYy';
	evalTBArray[10] = 'debutINHStopMm';
	evalTBArray[11] = 'debutINHStopYy';
	
	Ext.get('antecedentTb').on('click', function(){
		dis = document.getElementById('antecedentTb').checked;
		for(i=0;i<evalTBArray.length;i++)
		{
			document.getElementById(evalTBArray[i]).disabled = dis;
		}
	});
	dis = document.getElementById('antecedentTb').checked;
	for(i=0;i<evalTBArray.length;i++)
	{
		document.getElementById(evalTBArray[i]).disabled = dis;
	}

	Ext.get('pedArvKnownY').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById("pedArvKnownN"), radioArr, true, allElements["pedARVever"]);
	});
	Ext.get('pedArvKnownN').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById("pedArvKnownN"), radioArr, true, allElements["pedARVever"]);
	});

	Ext.get('pedArvEver1').on('click', function(){
		Ext.util.checkUnique(document.getElementById('pedArvEver1'),document.getElementById('pedArvEver2'),document.getElementById('arvEverY'));
                Ext.util.addToCheckedRadios(document.getElementById('arvEverY'));
		Ext.util.disableSectionByRadio(document.getElementById("arvEverY"), radioArr, true, allElements["pedArvKnown"]);
		Ext.util.disableSectionByRadio(document.getElementById("arvEverY"), radioArr, true, allElements["pedARVever"]);
	});
	Ext.get('pedArvEver2').on('click', function(){
		Ext.util.checkUnique(document.getElementById('pedArvEver2'),document.getElementById('pedArvEver1'),document.getElementById('arvEverY'));
                Ext.util.addToCheckedRadios(document.getElementById('arvEverY'));
	        Ext.util.disableSectionByRadio(document.getElementById("arvEverY"), radioArr, true, allElements["pedArvKnown"]);
	        Ext.util.disableSectionByRadio(document.getElementById("arvEverY"), radioArr, true, allElements["pedARVever"]);
	});
	Ext.get('arvEverY').on('click', function(){
		Ext.util.checkUnique(document.getElementById('arvEverY'),document.getElementById('pedArvEver1'),document.getElementById('pedArvEver2'));
                Ext.util.addToCheckedRadios(document.getElementById('pedArvEver1'));
	        Ext.util.disableSectionByRadio(document.getElementById("arvEverY"), radioArr, true, allElements["pedArvKnown"]);
	        Ext.util.disableSectionByRadio(document.getElementById("arvEverY"), radioArr, true, allElements["pedARVever"]);
	});
	Ext.util.disableSectionByRadio(document.getElementById("arvEverY"), radioArr, true, allElements["pedArvKnown"]);
	Ext.util.disableSectionByRadio(document.getElementById("arvEverY"), radioArr, true, allElements["pedARVever"]);
	
	if( sexFlg == '2')
	{
		var oHistArray = new Array(5);
		oHistArray[0] = document.getElementsByName('pedReproHealthMenses[]');
		oHistArray[1] = document.getElementsByName('pregnant[]');
		oHistArray[2] = document.getElementsByName('pregnantPrenatal[]');
		oHistArray[3] = document.getElementsByName('papTest[]');
		oHistArray[4] = document.getElementsByName('pedPapTestRes[]');

		for(i = 0;i<oHistArray.length;i++)
		{
			for(j = 0; j < oHistArray[i].length; j++)
			{
				oHistArray[i][j].disabled = true;
			}
		}
	}


	var labOrDrugArray = new Array(4);
	labOrDrugArray[0] = document.getElementById("labOrDrugForm1");
	labOrDrugArray[1] = document.getElementById("labOrDrugForm2");
	labOrDrugArray[2] = document.getElementById("labOrDrugForm3");
	labOrDrugArray[3] = document.getElementById("labOrDrugForm4");

	Ext.get('labOrDrugForm1').on('click', function(){
//		if(Ext.util.compareBin(document.getElementById('labOrDrugForm').value,1)) 
//		{
//				document.getElementById('labOrDrugForm').value -=  2;
//		}
//		document.getElementById('labOrDrugForm').value =  Number(document.getElementById('labOrDrugForm').value) + 1;
                Ext.util.computeHiddenValue(document.getElementById('labOrDrugForm'), labOrDrugArray);
	});
	Ext.get('labOrDrugForm2').on('click', function(){
//		if(Ext.util.compareBin(document.getElementById('labOrDrugForm').value,0)) 
//		{
//				document.getElementById('labOrDrugForm').value -=  1;
//		}
//		document.getElementById('labOrDrugForm').value =   Number(document.getElementById('labOrDrugForm').value) + 2;
                Ext.util.computeHiddenValue(document.getElementById('labOrDrugForm'), labOrDrugArray);
	});
	Ext.get('labOrDrugForm3').on('click', function(){
//		if(Ext.util.compareBin(document.getElementById('labOrDrugForm').value,3)) 
//		{
//				document.getElementById('labOrDrugForm').value -=  8;
//		}
//		document.getElementById('labOrDrugForm').value =   Number(document.getElementById('labOrDrugForm').value) + 4;
                Ext.util.computeHiddenValue(document.getElementById('labOrDrugForm'), labOrDrugArray);
	});
	Ext.get('labOrDrugForm4').on('click', function(){
//		if(Ext.util.compareBin(document.getElementById('labOrDrugForm').value,2)) 
//		{
//				document.getElementById('labOrDrugForm').value -=  4;
//		}
//		document.getElementById('labOrDrugForm').value =  Number(document.getElementById('labOrDrugForm').value) + 8;
                Ext.util.computeHiddenValue(document.getElementById('labOrDrugForm'), labOrDrugArray);
	});
	var nxtVisitIntArr = new Array(3);
	nxtVisitIntArr[0] = 'pedNextVisitDays';
	nxtVisitIntArr[1] = 'pedNextVisitWeeks';
	nxtVisitIntArr[2] = 'pedNextVisitMos';
	for(i = 0; i < nxtVisitIntArr.length; i++)
	{
			(Ext.get(nxtVisitIntArr[i])).on('blur', function(){
				errMsg = Ext.util.isValueInBound(document.getElementById(this.id),document.getElementById(this.id + 'Title'),'0','','');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);	
			});
			errMsg = Ext.util.isValueInBound(document.getElementById(nxtVisitIntArr[i]),document.getElementById(nxtVisitIntArr[i] + 'Title'),'0','','');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,nxtVisitIntArr[i],errMsg,errCount);				
	}
	var loadArr = new Array(3);
	loadArr[0] = 'pedFratHistHivStatNumNeg';
	loadArr[1] = 'pedFratHistHivStatNumPos';
	loadArr[2] = 'pedFratHistHivStatNumUnk';
	loadArr[3] = 'pedFratHistHivStatNumDead';
	
	for(i = 0; i < loadArr.length; i++)
	{
			(Ext.get(loadArr[i])).on('blur', function(){
				errMsg = Ext.util.isValueInBound(document.getElementById(this.id),document.getElementById(this.id + 'Title'),'0','','');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);	
			});
			errMsg = Ext.util.isValueInBound(document.getElementById(loadArr[i]),document.getElementById(loadArr[i] + 'Title'),'0','','');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,loadArr[i],errMsg,errCount);				
	}
	Ext.get('pedMotherHistUnk').on('click', function(){	
		Ext.util.disableSectionByRadio(document.mainForm.pedMotherHistUnk, radioArr, true, allElements["pedMotherHist"]);
	});
	Ext.util.disableSectionByRadio(document.mainForm.pedMotherHistUnk, radioArr, true, allElements["pedMotherHist"]);
	Ext.get('pedFratHistUnk').on('click', function(){	
		Ext.util.disableSectionByRadio(document.mainForm.pedFratHistUnk, radioArr, true, allElements["pedFratHist"]);
	});
	Ext.util.disableSectionByRadio(document.mainForm.pedFratHistUnk, radioArr, true, allElements["pedFratHist"]);

	var whoStages = new Array(5);
	whoStages[0] = document.getElementById('asymptomaticWho');
	whoStages[1] = document.getElementById('pedSympWhoDiarrhea');
	whoStages[2] = document.getElementById('pedSympWhoWtLoss2');
	whoStages[3] = document.getElementById('pedSympWhoWtLoss3');
	whoStages[4] = document.getElementById('feverPlusMo');
	for(i=0;i<whoStages.length;i++)
	{
		Ext.get(whoStages[i].id).on('click', function(){
			errMsg = Ext.util.checkWhoStage(whoStages,document.getElementById('whoStageTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'whoStage',errMsg,errCount);

		});

	}
	var TBStatusArray = new Array(4);
	TBStatusArray[0] = document.getElementById("pedTbEvalRecentExp");
	TBStatusArray[1] = document.getElementById("suspicionTBwSymptoms");
	TBStatusArray[2] = document.getElementById("presenceBCG");
	TBStatusArray[3] = document.getElementById("noTBsymptoms");
	Ext.get('vDate').on('blur', function(){
		errMsg = Ext.util.checkItemSelected(TBStatusArray, document.getElementById('tbStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbStatus',errMsg,errCount);
		errMsg = Ext.util.checkWhoStage(whoStages,document.getElementById('whoStageTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'whoStage',errMsg,errCount);
 	});
	if(document.mainForm.vDate.value!='' && document.mainForm.vDate.value!='//')
	{
		errMsg = Ext.util.checkItemSelected(TBStatusArray, document.getElementById('tbStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbStatus',errMsg,errCount);
		errMsg = Ext.util.checkWhoStage(whoStages,document.getElementById('whoStageTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'whoStage',errMsg,errCount);
	}

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
                errMsg = Ext.util.validatePediatricTbHistorySection(document.getElementById('propINH'),document.getElementById('currentProp'),document.getElementById('debutINHStartMm'),document.getElementById('debutINHStartYy'),document.getElementById('debutINHStopMm'),document.getElementById('debutINHStopYy'),document.getElementById('propINHTitle'),document.getElementById('currentPropTitle'),document.getElementById('debutINHStartTitle'),document.getElementById('debutINHStopTitle'));
	}, document.getElementById(this.id), {delay: 5});
	Ext.get('debutINHStartMm').on('blur', function(){
                errMsg = Ext.util.validatePediatricTbHistorySection(document.getElementById('propINH'),document.getElementById('currentProp'),document.getElementById('debutINHStartMm'),document.getElementById('debutINHStartYy'),document.getElementById('debutINHStopMm'),document.getElementById('debutINHStopYy'),document.getElementById('propINHTitle'),document.getElementById('currentPropTitle'),document.getElementById('debutINHStartTitle'),document.getElementById('debutINHStopTitle'));
	});
	Ext.get('debutINHStartYy').on('blur', function(){
                errMsg = Ext.util.validatePediatricTbHistorySection(document.getElementById('propINH'),document.getElementById('currentProp'),document.getElementById('debutINHStartMm'),document.getElementById('debutINHStartYy'),document.getElementById('debutINHStopMm'),document.getElementById('debutINHStopYy'),document.getElementById('propINHTitle'),document.getElementById('currentPropTitle'),document.getElementById('debutINHStartTitle'),document.getElementById('debutINHStopTitle'));
	});
	Ext.get('debutINHStopMm').on('blur', function(){
                errMsg = Ext.util.validatePediatricTbHistorySection(document.getElementById('propINH'),document.getElementById('currentProp'),document.getElementById('debutINHStartMm'),document.getElementById('debutINHStartYy'),document.getElementById('debutINHStopMm'),document.getElementById('debutINHStopYy'),document.getElementById('propINHTitle'),document.getElementById('currentPropTitle'),document.getElementById('debutINHStartTitle'),document.getElementById('debutINHStopTitle'));
	}, document.getElementById(this.id), {delay: 5});
	Ext.get('debutINHStopYy').on('blur', function(){
                errMsg = Ext.util.validatePediatricTbHistorySection(document.getElementById('propINH'),document.getElementById('currentProp'),document.getElementById('debutINHStartMm'),document.getElementById('debutINHStartYy'),document.getElementById('debutINHStopMm'),document.getElementById('debutINHStopYy'),document.getElementById('propINHTitle'),document.getElementById('currentPropTitle'),document.getElementById('debutINHStartTitle'),document.getElementById('debutINHStopTitle'));
	}, document.getElementById(this.id), {delay: 5});
	
	Ext.get('currentProp').on('click', function(){
                errMsg = Ext.util.validatePediatricTbHistorySection(document.getElementById('propINH'),document.getElementById('currentProp'),document.getElementById('debutINHStartMm'),document.getElementById('debutINHStartYy'),document.getElementById('debutINHStopMm'),document.getElementById('debutINHStopYy'),document.getElementById('propINHTitle'),document.getElementById('currentPropTitle'),document.getElementById('debutINHStartTitle'),document.getElementById('debutINHStopTitle'));
	}, document.getElementById(this.id), {delay: 5});

	Ext.get('currentTreat').on('click', function(){
                errMsg = Ext.util.validatePediatricTbHistorySection(document.getElementById('completeTreat'),document.getElementById('currentTreat'),document.getElementById('pedCompleteTreatStartMm'),document.getElementById('pedCompleteTreatStartYy'),document.getElementById('pedCompleteTreatStopMm'),document.getElementById('pedCompleteTreatStopYy'),document.getElementById('completeTreatTitle'),document.getElementById('currentTreatTitle'),document.getElementById('pedCompleteTreatStartTitle'),document.getElementById('pedCompleteTreatStopTitle'));
  	}, document.getElementById(this.id), {delay: 5});
	
	Ext.get('completeTreat').on('click', function(){
                errMsg = Ext.util.validatePediatricTbHistorySection(document.getElementById('completeTreat'),document.getElementById('currentTreat'),document.getElementById('pedCompleteTreatStartMm'),document.getElementById('pedCompleteTreatStartYy'),document.getElementById('pedCompleteTreatStopMm'),document.getElementById('pedCompleteTreatStopYy'),document.getElementById('completeTreatTitle'),document.getElementById('currentTreatTitle'),document.getElementById('pedCompleteTreatStartTitle'),document.getElementById('pedCompleteTreatStopTitle'));
  	}, document.getElementById(this.id), {delay: 5});
  	Ext.get('pedCompleteTreatStartMm').on('blur', function(){
                errMsg = Ext.util.validatePediatricTbHistorySection(document.getElementById('completeTreat'),document.getElementById('currentTreat'),document.getElementById('pedCompleteTreatStartMm'),document.getElementById('pedCompleteTreatStartYy'),document.getElementById('pedCompleteTreatStopMm'),document.getElementById('pedCompleteTreatStopYy'),document.getElementById('completeTreatTitle'),document.getElementById('currentTreatTitle'),document.getElementById('pedCompleteTreatStartTitle'),document.getElementById('pedCompleteTreatStopTitle'));
  	}, document.getElementById(this.id), {delay: 5});
  	Ext.get('pedCompleteTreatStartYy').on('blur', function(){
                errMsg = Ext.util.validatePediatricTbHistorySection(document.getElementById('completeTreat'),document.getElementById('currentTreat'),document.getElementById('pedCompleteTreatStartMm'),document.getElementById('pedCompleteTreatStartYy'),document.getElementById('pedCompleteTreatStopMm'),document.getElementById('pedCompleteTreatStopYy'),document.getElementById('completeTreatTitle'),document.getElementById('currentTreatTitle'),document.getElementById('pedCompleteTreatStartTitle'),document.getElementById('pedCompleteTreatStopTitle'));
  	}, document.getElementById(this.id), {delay: 5});
  	Ext.get('pedCompleteTreatStopMm').on('blur', function(){
                errMsg = Ext.util.validatePediatricTbHistorySection(document.getElementById('completeTreat'),document.getElementById('currentTreat'),document.getElementById('pedCompleteTreatStartMm'),document.getElementById('pedCompleteTreatStartYy'),document.getElementById('pedCompleteTreatStopMm'),document.getElementById('pedCompleteTreatStopYy'),document.getElementById('completeTreatTitle'),document.getElementById('currentTreatTitle'),document.getElementById('pedCompleteTreatStartTitle'),document.getElementById('pedCompleteTreatStopTitle'));
  	}, document.getElementById(this.id), {delay: 5});
  	Ext.get('pedCompleteTreatStopYy').on('blur', function(){
                errMsg = Ext.util.validatePediatricTbHistorySection(document.getElementById('completeTreat'),document.getElementById('currentTreat'),document.getElementById('pedCompleteTreatStartMm'),document.getElementById('pedCompleteTreatStartYy'),document.getElementById('pedCompleteTreatStopMm'),document.getElementById('pedCompleteTreatStopYy'),document.getElementById('completeTreatTitle'),document.getElementById('currentTreatTitle'),document.getElementById('pedCompleteTreatStartTitle'),document.getElementById('pedCompleteTreatStopTitle'));
  	}, document.getElementById(this.id), {delay: 5});
        errMsg = Ext.util.validatePediatricTbHistorySection(document.getElementById('propINH'),document.getElementById('currentProp'),document.getElementById('debutINHStartMm'),document.getElementById('debutINHStartYy'),document.getElementById('debutINHStopMm'),document.getElementById('debutINHStopYy'),document.getElementById('propINHTitle'),document.getElementById('currentPropTitle'),document.getElementById('debutINHStartTitle'),document.getElementById('debutINHStopTitle'));
        errMsg = Ext.util.validatePediatricTbHistorySection(document.getElementById('completeTreat'),document.getElementById('currentTreat'),document.getElementById('pedCompleteTreatStartMm'),document.getElementById('pedCompleteTreatStartYy'),document.getElementById('pedCompleteTreatStopMm'),document.getElementById('pedCompleteTreatStopYy'),document.getElementById('completeTreatTitle'),document.getElementById('currentTreatTitle'),document.getElementById('pedCompleteTreatStartTitle'),document.getElementById('pedCompleteTreatStopTitle'));

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
		errMsg = Ext.util.checkTextDtCorresponding(document.getElementById('pedCd4CntPerc'),document.getElementById('lowestCd4CntDT'),document.getElementById('pedCd4CntPercTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedCd4CntPerc',errMsg,errCount);
		errMsg = Ext.util.checkDtTextCorresponding(document.getElementById('lowestCd4Cnt'),document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntDTTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'lowestCd4CntDT',errMsg,errCount);
		if(errMsg == '')
		{
			errMsg = Ext.util.checkDtTextCorresponding(document.getElementById('pedCd4CntPerc'),document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntDTTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedCd4CntPercDT',errMsg,errCount);
		}
	});	
	Ext.get('pedCd4CntPerc').on('blur',function() {
		errMsg = Ext.util.checkTextDtCorresponding(document.getElementById('lowestCd4Cnt'),document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'lowestCd4Cnt',errMsg,errCount);
		errMsg = Ext.util.checkTextDtCorresponding(document.getElementById('pedCd4CntPerc'),document.getElementById('lowestCd4CntDT'),document.getElementById('pedCd4CntPercTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedCd4CntPerc',errMsg,errCount);
		errMsg = Ext.util.checkDtTextCorresponding(document.getElementById('lowestCd4Cnt'),document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntDTTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'lowestCd4CntDT',errMsg,errCount);
		if(errMsg == '')
		{
			errMsg = Ext.util.checkDtTextCorresponding(document.getElementById('pedCd4CntPerc'),document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntDTTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedCd4CntPercDT',errMsg,errCount);
		}
	});		
	Ext.get('lowestCd4CntDT').on('blur',function() {
		errMsg = Ext.util.checkTextDtCorresponding(document.getElementById('lowestCd4Cnt'),document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'lowestCd4Cnt',errMsg,errCount);
		errMsg = Ext.util.checkTextDtCorresponding(document.getElementById('pedCd4CntPerc'),document.getElementById('lowestCd4CntDT'),document.getElementById('pedCd4CntPercTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedCd4CntPerc',errMsg,errCount);
		errMsg = Ext.util.checkDtTextCorresponding(document.getElementById('lowestCd4Cnt'),document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntDTTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'lowestCd4CntDT',errMsg,errCount);
		if(errMsg == '')
		{
			errMsg = Ext.util.checkDtTextCorresponding(document.getElementById('pedCd4CntPerc'),document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntDTTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedCd4CntPercDT',errMsg,errCount);
		}
		Ext.util.splitDate(document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntDd'),document.getElementById('lowestCd4CntMm'),document.getElementById('lowestCd4CntYy'));
	});
	errMsg = Ext.util.checkTextDtCorresponding(document.getElementById('lowestCd4Cnt'),document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstViralLoad',errMsg,errCount);
	errMsg = Ext.util.checkTextDtCorresponding(document.getElementById('pedCd4CntPerc'),document.getElementById('lowestCd4CntDT'),document.getElementById('pedCd4CntPercTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedCd4CntPerc',errMsg,errCount);
	errMsg = Ext.util.checkDtTextCorresponding(document.getElementById('lowestCd4Cnt'),document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntDTTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'lowestCd4CntDT',errMsg,errCount);
	if(errMsg == '')
	{
		errMsg = Ext.util.checkDtTextCorresponding(document.getElementById('pedCd4CntPerc'),document.getElementById('lowestCd4CntDT'),document.getElementById('lowestCd4CntDTTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedCd4CntPercDT',errMsg,errCount);
	}
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
	
	Ext.get('pedRapidHivOrderedY').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById("pedRapidHivOrderedN"), radioArr, false, allElements["pedRapidHiv"]);
	});
	Ext.get('pedRapidHivOrderedN').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById(this.id), radioArr, true, allElements["pedRapidHiv"]);
	});
	
	Ext.get('pedPcrOrderedY').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById("pedPcrOrderedN"), radioArr, false, allElements["pedPcr"]);
	});
	Ext.get('pedPcrOrderedN').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById(this.id), radioArr, true, allElements["pedPcr"]);
	});
		
	Ext.get('pedElisaOrderedY').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById("pedElisaOrderedN"), radioArr, false, allElements["pedElisa"]);
	});
	Ext.get('pedElisaOrderedN').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById(this.id), radioArr, true, allElements["pedElisa"]);
	});
		
	Ext.get('pedAntigenOrderedY').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById("pedAntigenOrderedN"), radioArr, false, allElements["pedAntigen"]);
	});
	Ext.get('pedAntigenOrderedN').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById(this.id), radioArr, true, allElements["pedAntigen"]);
	});

	Ext.get('pedMedAllergY').on('click',function() {
		//Ext.util.disableSectionByRadio(document.getElementById("pedMedAllergY"), radioArr, true, allElements["pedMedAllergy"]);
                Ext.util.enableAssociated(document.getElementById('pedMedAllergY'), allElements["pedMedAllergy"]);
	});
	Ext.get('pedMedAllergU').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById("pedMedAllergU"), radioArr, true, allElements["pedMedAllergy"]);
	});
	Ext.get('pedMedAllergN').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById("pedMedAllergN"), radioArr, true, allElements["pedMedAllergy"]);
	});
	Ext.util.disableSectionByRadio(document.getElementById("pedMedAllergN"), radioArr, false, allElements["pedMedAllergy"]);
	Ext.util.disableSectionByRadio(document.getElementById("pedMedAllergU"), radioArr, false, allElements["pedMedAllergy"]);

  var pedImmVaccArr = new Array();
  pedImmVaccArr[0] = "pedImmVaccY";
  pedImmVaccArr[1] = "pedImmVaccN";
  pedImmVaccArr[2] = "pedImmVaccU";
  
	Ext.get('pedImmVaccY').on('click',function() {
		Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(pedImmVaccArr), allElements["pedImmVacc"], txtFormat);
	});
	Ext.get('pedImmVaccU').on('click',function() {
		Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(pedImmVaccArr), allElements["pedImmVacc"], txtFormat);
	});
	Ext.get('pedImmVaccN').on('click',function() {
		Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(pedImmVaccArr), allElements["pedImmVacc"], txtFormat);
	});
	Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(pedImmVaccArr), allElements["pedImmVacc"], txtFormat);

	var disSec = new Array();
	disSec[0] = "pedMenses";
	disSec[1] = "pedPreg";
	disSec[2] = "pedPregPrenat";
	disSec[3] = "papTest";
	//disSec[4] = "pedFeed";
	if(sexFlg == "2")
  {

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

  	
  	for(i=0;i<disSec.length;i++)
  	{
	  	var tempArr = new Array();
	  	tempArr[0] = disSec[i] + "Y";
	  	tempArr[1] = disSec[i] + "N";
	  	tempArr[2] = disSec[i] + "U";
  		for(var j=0; j < tempArr.length; j++)
	  	{
	  		Ext.get(tempArr[j]).on('click', function(){
	  				var tempArr1 = new Array();
	  				var root = this.id.substring(0,this.id.length-1);
				  	tempArr1[0] = root + "Y";
				  	tempArr1[1] = root + "N";
				  	tempArr1[2] = root + "U";

						Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(tempArr1), allElements[this.id.substring(0,this.id.length-1)], txtFormat);
				});
	  	}
			Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(tempArr), allElements[disSec[i]], txtFormat);
    }
  }
  	
	var TreatArray = new Array(2);
	TreatArray[0] = document.getElementById("completeTreat");
	TreatArray[1] = document.getElementById("currentTreat");

	for(i=0;i<TreatArray.length;i++)
	{
		Ext.get(TreatArray[i].id).on('click', function(){
			var key = Ext.util.getKeyByID(TreatArray, this.id)
			Ext.util.checkUniqueRadio(TreatArray,key,radioArr);
		});
	}


	for(i=0;i<TBStatusArray.length;i++)
	{
		Ext.get(TBStatusArray[i]).on('click', function(){
			var key = Ext.util.getKeyByID(TBStatusArray, this.id)
			Ext.util.checkUniqueRadio(TBStatusArray,key,radioArr);
			errMsg = Ext.util.checkItemSelected(TBStatusArray, document.getElementById('tbStatusTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbStatus',errMsg,errCount);
		});
	}

	var INHArray = new Array(2);
	INHArray[0] = document.getElementById("propINH");
	INHArray[1] = document.getElementById("currentProp");

	for(i=0;i<INHArray.length;i++)
	{
		Ext.get(INHArray[i].id).on('click', function(){
			var key = Ext.util.getKeyByID(INHArray, this.id)
			Ext.util.checkUniqueRadio(INHArray,key,radioArr);
		}, document.getElementById(this.id), {delay: 5});
	}

//  var tempRadioArr = allElements["radio"]; 
//	var radioArr = Ext.util.getAllRadios(tempRadioArr);		

	var medEligRadios= new Array(3);
	medEligRadios[0] = "medEligY";
	medEligRadios[1] = "medEligN";
	medEligRadios[2] = "medEligU";
	for(var i=0;i<medEligRadios.length;i++)
	{
		Ext.get(medEligRadios[i]).on('click', function(){
			Ext.util.disableElements(document.getElementById(medEligRadios[0]),allElements["pedMedElig"], radioArr, true);
			
		}, document.getElementById(this.id), {delay: 5});		
	}		
    //Ext.util.disableElements(document.getElementById(medEligRadios[0]),allElements["pedMedElig"], radioArr, false);
    Ext.util.disableSectionByRadio(document.getElementById(medEligRadios[0]),radioArr, false, allElements["pedMedElig"]);

	var pedCurrHivProb = new Array(2);
	pedCurrHivProb[0] = document.getElementById('pedCurrHivProb1');
	pedCurrHivProb[1] = document.getElementById('pedCurrHivProb2');
	for(i=0;i<4;i++)
	{
		Ext.get('pedCurrHiv' + i).on('click', function(){

			Ext.util.disableElements(document.getElementById('pedCurrHiv3'), pedCurrHivProb, radioArr, true);
		}, document.getElementById(this.id), {delay: 5});
	}
	Ext.util.disableElements(document.getElementById('pedCurrHiv3'), pedCurrHivProb, radioArr, true);

	Ext.get('noDiagnosis').on('click',function() {
			Ext.util.disableSectionByRadio(document.getElementById("noDiagnosis"), radioArr, false, allElements["conditions"]);
			//errCount = Ext.util.clearElements(allElements["conditions"], errFields,errMsgs, errCount);
	});	
	Ext.util.disableSectionByRadio(document.mainForm.noDiagnosis, radioArr, true, allElements["conditions"]);	

	Ext.get('vitalTemp').on('blur', function(){
		errMsg = Ext.util.checkTemp(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'),radioArr,true, document.getElementById('vitalTempTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr,true,document.getElementById('vitalTempUnitTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTempUnit',errMsg,errCount);
	
	});
	Ext.get('vitalTempUnit1').on('click', function(){
		errMsg = Ext.util.checkTemp(document.mainForm.vitalTemp,document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr,true,document.getElementById('vitalTempTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr,true,document.getElementById("vitalTempUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTempUnit',errMsg,errCount);
	}, document.getElementById(this.id), {delay: 5});
	Ext.get('vitalTempUnit2').on('click', function(){
		errMsg = Ext.util.checkTemp(document.mainForm.vitalTemp,document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr,false,document.getElementById('vitalTempTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr,true,document.getElementById('vitalTempUnitTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTempUnit',errMsg,errCount);

	}, document.getElementById(this.id), {delay: 5});

	errMsg = Ext.util.checkTemp(document.mainForm.vitalTemp,document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'),radioArr,true,document.getElementById('vitalTempTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
	errMsg = Ext.util.checkUnit(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'),radioArr,true, document.getElementById("vitalTempUnitTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTempUnit',errMsg,errCount);

	Ext.get('vitalBp1').on('blur', function(){
		errMsg = Ext.util.checkBp1(document.mainForm.vitalBp1,document.getElementById("vitalBp1Title"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBp1',errMsg,errCount);
		errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"),radioArr,true,document.getElementById("vitalBpUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);

	});
	errMsg = Ext.util.checkBp1(document.mainForm.vitalBp1,document.getElementById("vitalBp1Title"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBp1',errMsg,errCount);
	
	Ext.get('vitalBp2').on('blur', function(){
		errMsg = Ext.util.checkBp2(document.mainForm.vitalBp2, document.getElementById("vitalBp2Title"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBp2',errMsg,errCount);
		errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"),radioArr,true, document.getElementById("vitalBpUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);
		
	});
	Ext.get('vitalBpUnit1').on('click', function(){
		errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"),radioArr,true, document.getElementById("vitalBpUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);
	}, document.getElementById(this.id), {delay: 5});
	Ext.get('vitalBpUnit2').on('click', function(){
		errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"),radioArr,true, document.getElementById("vitalBpUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);
		
	}, document.getElementById(this.id), {delay: 5});	
	errMsg = Ext.util.checkBp2(document.mainForm.vitalBp2,document.getElementById("vitalBp2Title"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBp2',errMsg,errCount);
	errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"),radioArr,true, document.getElementById("vitalBpUnitTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);	
	
	Ext.get('vitalWeight').on('blur', function(){
		errMsg = Ext.util.checkWeight(document.mainForm.vitalWeight,document.getElementById("vitalWeightTitle"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeight',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.mainForm.vitalWeight,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr,true, document.getElementById("vitalWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
	
	});
	Ext.get('vitalWeightUnit1').on('click', function(){
		errMsg = Ext.util.checkUnit(document.mainForm.vitalWeight,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr,true, document.getElementById("vitalWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
	
	}, document.getElementById(this.id), {delay: 5});
	Ext.get('vitalWeightUnit2').on('click', function(){
		errMsg = Ext.util.checkUnit(document.mainForm.vitalWeight,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr,true, document.getElementById("vitalWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
	
	}, document.getElementById(this.id), {delay: 5});
	errMsg = Ext.util.checkWeight(document.mainForm.vitalWeight,document.getElementById("vitalWeightTitle"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeight',errMsg,errCount);
	errMsg = Ext.util.checkUnit(document.mainForm.vitalWeight,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr,true, document.getElementById("vitalWeightUnitTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);	
	
	Ext.get('pedVitCurWtLast').on('blur', function(){
		errMsg = Ext.util.checkWeight(document.mainForm.pedVitCurWtLast,document.getElementById("pedVitCurWtLastTitle"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurWtLast',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.mainForm.pedVitCurWtLast,document.getElementById("pedVitCurWtLastUnit1"),document.getElementById("pedVitCurWtLastUnit2"),radioArr, true, document.getElementById("pedVitCurWtLastUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurWtLastUnit',errMsg,errCount);

	});
	Ext.get('pedVitCurWtLastUnit1').on('click', function(){
		errMsg = Ext.util.checkUnit(document.mainForm.pedVitCurWtLast,document.getElementById("pedVitCurWtLastUnit1"),document.getElementById("pedVitCurWtLastUnit2"),radioArr, true,document.getElementById("pedVitCurWtLastUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurWtLastUnit',errMsg,errCount);

	}, document.getElementById(this.id), {delay: 5});
	Ext.get('pedVitCurWtLastUnit2').on('click', function(){
		errMsg = Ext.util.checkUnit(document.mainForm.pedVitCurWtLast,document.getElementById("pedVitCurWtLastUnit1"),document.getElementById("pedVitCurWtLastUnit2"),radioArr, true,document.getElementById("pedVitCurWtLastUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurWtLastUnit',errMsg,errCount);

	}, document.getElementById(this.id), {delay: 5});
	errMsg = Ext.util.checkWeight(document.mainForm.pedVitCurWtLast,document.getElementById("pedVitCurWtLastTitle"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurWtLast',errMsg,errCount);
	errMsg = Ext.util.checkUnit(document.mainForm.pedVitCurWtLast,document.getElementById("pedVitCurWtLastUnit1"),document.getElementById("pedVitCurWtLastUnit2"),radioArr, true,document.getElementById("pedVitCurWtLastUnitTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurWtLastUnit',errMsg,errCount);
	
});


