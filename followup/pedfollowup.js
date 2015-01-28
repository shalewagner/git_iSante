	
Ext.onReady(function() {
	var root;
	var suffix;
	var suffix70;
	var prefix4;
	var root;
	var startErrLoc,stopMm,stopYy,stopErrLoc,continuing,continuingErrLoc;
	var stopReasonsErrLoc,interruptErrLoc;
	var stopReasonsArr = new Array(5);
	var interruptReasonsArr = new Array(7);
	var sexFlg = Ext.getDom('sex1').value;
	var prefix5;
	var txtFormat = new Array();
	var root;
	var suffix;

	var names = new Array();
	names[0] = "conditions";
	names[1] = "pedMedAllerg";
	names[2] = "pedMenses";
	names[3] = "pedPreg";
	names[4] = "pedPregPrenat";
	names[5] = "papTest";
	names[6] = "papTestResult";
	names[7] = "pedFeed";
	names[8] = "pedARVever";
	var allElements = Ext.util.getAllElements(document.mainForm,names);
	var txtArr = allElements["text"];
	var tempRadioArr = allElements["radio"]; 
	var radioArr = Ext.util.getAllRadios(tempRadioArr);	
	
	vitalTemp = new Ext.form.TextField({
		fieldLabel: '',
		name: 'vitalTemp',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});
	vitalTemp.applyToMarkup(document.mainForm.vitalTemp);
	Ext.get('vitalTemp').on('blur', function(){
		errMsg = Ext.util.checkTemp(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, false, document.getElementById('vitalTempTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, true, document.getElementById('vitalTempUnitTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTempUnit',errMsg,errCount);
	
	});
	Ext.get('vitalTempUnit1').on('click', function(){
		errMsg = Ext.util.checkTemp(document.mainForm.vitalTemp,document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, false, document.getElementById('vitalTempTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, true, document.getElementById("vitalTempUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTempUnit',errMsg,errCount);
	});
	Ext.get('vitalTempUnit2').on('click', function(){
		errMsg = Ext.util.checkTemp(document.mainForm.vitalTemp,document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, false, document.getElementById('vitalTempTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, true, document.getElementById('vitalTempUnitTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTempUnit',errMsg,errCount);

	});

	errMsg = Ext.util.checkTemp(document.mainForm.vitalTemp,document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, false,document.getElementById('vitalTempTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
	errMsg = Ext.util.checkUnit(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, true, document.getElementById("vitalTempUnitTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTempUnit',errMsg,errCount);



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
		errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"), radioArr, true, document.getElementById("vitalBpUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);

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
		errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"), radioArr, true, document.getElementById("vitalBpUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);
		
	});
	Ext.get('vitalBpUnit1').on('click', function(){
		errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"), radioArr, true, document.getElementById("vitalBpUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);
		
	});
	Ext.get('vitalBpUnit2').on('click', function(){
		errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"), radioArr, true, document.getElementById("vitalBpUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);
		
	});	
	errMsg = Ext.util.checkBp2(document.mainForm.vitalBp2,document.getElementById("vitalBp2Title"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBp2',errMsg,errCount);
	errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"), radioArr, true, document.getElementById("vitalBpUnitTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);	
	
	
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
	vitalWeight = new Ext.form.TextField({
		fieldLabel: '',
		name: 'vitalWeight',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});

	vitalWeight.applyToMarkup(document.mainForm.vitalWeight); 
	Ext.get('vitalWeight').on('blur', function(){
		errMsg = Ext.util.checkWeight(document.mainForm.vitalWeight,document.getElementById("vitalWeightTitle"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeight',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.mainForm.vitalWeight,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"), radioArr, true,document.getElementById("vitalWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
	
	});
	Ext.get('vitalWeightUnit1').on('click', function(){
		errMsg = Ext.util.checkUnit(document.mainForm.vitalWeight,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"), radioArr, true,document.getElementById("vitalWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
	
	});
	Ext.get('vitalWeightUnit2').on('click', function(){
		errMsg = Ext.util.checkUnit(document.mainForm.vitalWeight,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"), radioArr, true,document.getElementById("vitalWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
	
	});
	errMsg = Ext.util.checkWeight(document.mainForm.vitalWeight,document.getElementById("vitalWeightTitle"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeight',errMsg,errCount);
	errMsg = Ext.util.checkUnit(document.mainForm.vitalWeight,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"), radioArr, true,document.getElementById("vitalWeightUnitTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
 	pedVitCurWtLast = new Ext.form.TextField({
		fieldLabel: '',
		name: 'pedVitCurWtLast',
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});

	pedVitCurWtLast.applyToMarkup(document.mainForm.pedVitCurWtLast); 
	Ext.get('pedVitCurWtLast').on('blur', function(){
		errMsg = Ext.util.checkWeight(document.mainForm.pedVitCurWtLast,document.getElementById("pedVitCurWtLastTitle"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurWtLast',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.mainForm.pedVitCurWtLast,document.getElementById("pedVitCurWtLastUnit1"),document.getElementById("pedVitCurWtLastUnit2"), radioArr, true,document.getElementById("pedVitCurWtLastUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurWtLastUnit',errMsg,errCount);

	});
	Ext.get('pedVitCurWtLastUnit1').on('click', function(){
		errMsg = Ext.util.checkUnit(document.mainForm.pedVitCurWtLast,document.getElementById("pedVitCurWtLastUnit1"),document.getElementById("pedVitCurWtLastUnit2"), radioArr, true,document.getElementById("pedVitCurWtLastUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurWtLastUnit',errMsg,errCount);

	});
	Ext.get('pedVitCurWtLastUnit2').on('click', function(){
		errMsg = Ext.util.checkUnit(document.mainForm.vitalWeight,document.getElementById("pedVitCurWtLastUnit1"),document.getElementById("pedVitCurWtLastUnit2"), radioArr, true,document.getElementById("pedVitCurWtLastUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurWtLastUnit',errMsg,errCount);

	});
	errMsg = Ext.util.checkWeight(document.mainForm.pedVitCurWtLast,document.getElementById("pedVitCurWtLastTitle"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurWtLast',errMsg,errCount);
	errMsg = Ext.util.checkUnit(document.mainForm.pedVitCurWtLast,document.getElementById("pedVitCurWtLastUnit1"),document.getElementById("pedVitCurWtLastUnit2"), radioArr, true,document.getElementById("pedVitCurWtLastUnitTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'pedVitCurWtLastUnit',errMsg,errCount);
	
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

	Ext.get('vitalRr').on('blur', function(){
		errMsg = Ext.util.isValueInBound(document.getElementById('vitalRr'),document.getElementById('vitalRrTitle'),'0','360','');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalRr',errMsg,errCount);	
	});
	errMsg = Ext.util.isValueInBound(document.getElementById('vitalRr'),document.getElementById('vitalRrTitle'),'0','360','');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalRr',errMsg,errCount);	
	
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

	for(i=0;i<txtArr.length;i++)
	{	
		suffix = txtArr[i].id.substring(txtArr[i].id.length-2);
	  	prefix4 = txtArr[i].id.substring(0,4);
		if(suffix == "Dt")
		{
			if(prefix4 == 'immu')
			{					       
			         dis = false;			
				
				(Ext.get(txtArr[i].id.substring(0,txtArr[i].id.length-2) + 'Given1')).on('click', function(){			
                                        errMsg = Ext.util.checkGivenCorresponding(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6) + 'Doses1'),document.getElementById(this.id.substring(0,this.id.length-6) + 'Dt'), document.getElementById(this.id.substring(0,this.id.length-6) + 'Given1Title'));			
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);	
                                        errMsg = Ext.util.checkDosesCorresponding(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6) + 'Doses1'),document.getElementById(this.id.substring(0,this.id.length-6) + 'Dt'), document.getElementById(this.id.substring(0,this.id.length-6) + 'Doses1Title'));			
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + 'Doses1',errMsg,errCount);	
					errMsg = Ext.util.checkDateCorresponding1(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6) + 'Doses1'),document.getElementById(this.id.substring(0,this.id.length-6) + 'Dt'),'XX',document.getElementById(this.id.substring(0,this.id.length-6) + 'DtTitle'));					
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + 'Dt',errMsg,errCount);
				});
				(Ext.get(txtArr[i].id.substring(0,txtArr[i].id.length-2) + 'Doses1')).on('blur', function(){			
				        errMsg = Ext.util.checkGivenCorresponding(document.getElementById(this.id.substring(0,this.id.length-6) + 'Given1'),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6) + 'Dt'), document.getElementById(this.id.substring(0,this.id.length-6) + 'Given1Title'));			
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + 'Given1',errMsg,errCount);	
				        errMsg = Ext.util.checkDosesCorresponding(document.getElementById(this.id.substring(0,this.id.length-6) + 'Given1'),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6) + 'Dt'), document.getElementById(this.id.substring(0,this.id.length-6) + 'Doses1Title'));			
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);	
					errMsg = Ext.util.checkDateCorresponding1(document.getElementById(this.id.substring(0,this.id.length-6) + 'Given1'),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6) + 'Dt'),'XX',document.getElementById(this.id.substring(0,this.id.length-6) + 'DtTitle'));					
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + 'Dt',errMsg,errCount);
				});								
				errMsg = Ext.util.checkGivenCorresponding(document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + 'Given1'),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + 'Doses1'),document.getElementById(txtArr[i].id), document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + 'Given1Title'));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2) + 'Given1',errMsg,errCount);
				errMsg = Ext.util.checkDosesCorresponding(document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + 'Given1'),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + 'Doses1'),document.getElementById(txtArr[i].id), document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + 'Doses1Title'));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2) + 'Doses1',errMsg,errCount);							
				errMsg = Ext.util.checkDateCorresponding1(document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + 'Given1'),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + 'Doses1'),document.getElementById(txtArr[i].id),'XX',document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + 'DtTitle'));		
			}
			else
			{
				
				
								
				errMsg = Ext.util.validateDateFieldNonPatient(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id + 'Title'),'');
			}
			txtFormat[txtArr[i].id] = new Ext.form.DateField({
				fieldLabel: '',
				maskRe : /[\Xx{1,2}\d{1,2}\/]/,
				validationEvent: false,
				allowBlank:true
			});
			txtFormat[txtArr[i].id].applyToMarkup(txtArr[i]);
			if(txtArr[i].id != 'completeTreatDt') {
			  (Ext.get(txtArr[i].id)).on('blur', function(){
				if(this.id.substring(0,4) == 'immu')
				{
					errMsg = Ext.util.checkGivenCorresponding(document.getElementById(this.id.substring(0,this.id.length-2) + 'Given1'),document.getElementById(this.id.substring(0,this.id.length-2) + 'Doses1'),document.getElementById(this.id), document.getElementById(this.id.substring(0,this.id.length-2) + 'Given1Title'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2) + 'Given1',errMsg,errCount);
					errMsg = Ext.util.checkDosesCorresponding(document.getElementById(this.id.substring(0,this.id.length-2) + 'Given1'),document.getElementById(this.id.substring(0,this.id.length-2) + 'Doses1'),document.getElementById(this.id), document.getElementById(this.id.substring(0,this.id.length-2) + 'Doses1Title'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2) + 'Doses1',errMsg,errCount);


					errMsg = Ext.util.checkDateCorresponding1(document.getElementById(this.id.substring(0,this.id.length-2) + 'Given1'),document.getElementById(this.id.substring(0,this.id.length-2) + 'Doses1'),document.getElementById(this.id),'XX',document.getElementById(this.id.substring(0,this.id.length-2) + 'DtTitle'));		
				}
				else
				{
					errMsg =  Ext.util.validateDateFieldNonPatient(document.getElementById(this.id),document.getElementById(this.id + 'Title'),'');

				}
				Ext.util.splitDate(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-2) + "Dd"),document.getElementById(this.id.substring(0,this.id.length-2) + "Mm"),document.getElementById(this.id.substring(0,this.id.length-2) + "Yy"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg,errCount);
			  });
			  Ext.util.splitDate(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Dd"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Mm"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Yy"));
			  errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2),errMsg,errCount);
                        }
		}  
	  	else if(suffix == 'Mm' || suffix == 'Yy' || suffix == 'MM' || suffix == 'YY'  )
		{
			txtFormat[i] = new Ext.form.TextField({
				fieldLabel: '',
				maskRe : /[\Xx{1,2}\Nn{1,2}\d{1,2}]/,
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
					suffix60 = txtArr[i].id.substring(txtArr[i].id.length-6, txtArr[i].id.length);
					if(suffix60 == 'StopMm')
					{
						root = txtArr[i].id.substring(0,txtArr[i].id.length-6);

						(Ext.get(root+"StopMm")).on('blur', function(){

							errMsg = Ext.util.validateMY(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopTitle"),'XX','');
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + 'Stop',errMsg,errCount);
							if(errMsg == '')
							{
								stopReasonsArr = Ext.util.createStopReasons(this.id.substring(0,this.id.length-6));
								interruptReasonsArr = Ext.util.createPedInterruptReasons(this.id.substring(0,this.id.length-6));
								var reasonArr = Ext.util.mergeArrays(stopReasonsArr, interruptReasonsArr);
								errMsg =  Ext.util.checkStopReasons(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),reasonArr,document.getElementById(this.id.substring(0,this.id.length-6)+"StopTitle"));
								errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6)+"Stop",errMsg,errCount);
							}
							errMsg =  Ext.util.checkDrugContinuing(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6) + 'StopYy'),document.getElementById(this.id.substring(0,this.id.length-6)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-6)+"ContinuedTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6)+"Continued",errMsg,errCount);																	
							
						});
						(Ext.get(root+"StopYy")).on('blur', function(){
							errMsg = Ext.util.validateMY(document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6)+"StopTitle"),'XX','');
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + 'Stop',errMsg,errCount);
							if(errMsg == '')
							{
								stopReasonsArr = Ext.util.createStopReasons(this.id.substring(0,this.id.length-6));
								interruptReasonsArr = Ext.util.createPedInterruptReasons(this.id.substring(0,this.id.length-6));
								var reasonArr = Ext.util.mergeArrays(stopReasonsArr, interruptReasonsArr);
								errMsg =  Ext.util.checkStopReasons(document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id),reasonArr,document.getElementById(this.id.substring(0,this.id.length-6)+"StopTitle"));
								errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6)+"Stop",errMsg,errCount);					
							}
							errMsg =  Ext.util.checkDrugContinuing(document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-6)+"ContinuedTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6)+"Continued",errMsg,errCount);						
							
							
						});
						(Ext.get(root+"Continued")).on('click', function(){
							errMsg =  Ext.util.checkDrugContinuing(document.getElementById(this.id.substring(0,this.id.length-9)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopYy"),document.getElementById(this.id),document.getElementById(this.id + "Title"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
						});
						stopReasonsArr = Ext.util.createStopReasons(root);
						interruptReasonsArr = Ext.util.createPedInterruptReasons(root);
						var j;
						for(j = 0; j < stopReasonsArr.length; j++)
						{	
							(Ext.get(stopReasonsArr[j].id)).on('click', function(){
								var reasonRoot  = this.id.substring(0,this.id.lastIndexOf('Disc'));
								errMsg = Ext.util.validateMY(document.getElementById(reasonRoot+"StopMm"),document.getElementById(reasonRoot+"StopYy"),document.getElementById(reasonRoot+"StopTitle"),'XX','');
								errCount = Ext.util.showErrorHead(errFields,errMsgs,reasonRoot + 'Stop',errMsg,errCount);

								if(errMsg == '')
								{
									var stopReasonsArr1 = Ext.util.createStopReasons(reasonRoot);
									var interruptReasonsArr1 = Ext.util.createPedInterruptReasons(reasonRoot);
									var reasonArr1 = Ext.util.mergeArrays(stopReasonsArr1,interruptReasonsArr1);
									
									errMsg =  Ext.util.checkStopReasons(document.getElementById(reasonRoot+"StopMm"),document.getElementById(reasonRoot+"StopYy"),reasonArr1,document.getElementById(reasonRoot+"StopTitle"));
									errCount = Ext.util.showErrorHead(errFields,errMsgs,reasonRoot + "Stop",errMsg,errCount);
								}
							});
						}
						for(j = 0; j < interruptReasonsArr.length; j++)
						{	
							(Ext.get(interruptReasonsArr[j].id)).on('click', function(){
								var interRoot = this.id.substring(0,this.id.lastIndexOf('Inter'));
								errMsg = Ext.util.validateMY(document.getElementById(interRoot+"StopMm"),document.getElementById(interRoot+"StopYy"),document.getElementById(interRoot+"StopTitle"),'XX','');
								errCount = Ext.util.showErrorHead(errFields,errMsgs,interRoot+ 'Stop',errMsg,errCount);

								if(errMsg == '')
								{
									var stopReasonsArr1 = Ext.util.createStopReasons(interRoot);
									var interruptReasonsArr1 = Ext.util.createPedInterruptReasons(interRoot);
									var reasonArr1 = Ext.util.mergeArrays(stopReasonsArr1,interruptReasonsArr1);

									errMsg =  Ext.util.checkStopReasons(document.getElementById(interRoot+"StopMm"),document.getElementById(interRoot+"StopYy"),reasonArr1,document.getElementById(interRoot+"StopTitle"));
									errCount = Ext.util.showErrorHead(errFields,errMsgs,interRoot + "Stop",errMsg,errCount);
								}
							});
						}
						errMsg = Ext.util.validateMY(document.getElementById(root + "StopMm"),document.getElementById(root+"StopYy"),document.getElementById(root+"StopTitle"),'XX','');
						errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'Stop',errMsg,errCount);

						if(errMsg == '')
						{
							var reasonArr = Ext.util.mergeArrays(stopReasonsArr,interruptReasonsArr);
							errMsg =  Ext.util.checkStopReasons(document.getElementById(root+"StopMm"),document.getElementById(root+"StopYy"),reasonArr,document.getElementById(root+"StopTitle"));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,root + "Stop",errMsg,errCount);					
	
						}
						errMsg =  Ext.util.checkDrugContinuing(document.getElementById(root + "StopMm"),document.getElementById(root + 'StopYy'),document.getElementById(root+"Continued"),document.getElementById(root+"ContinuedTitle"));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,root+"Continued",errMsg,errCount);						

					}

				}
				else
				{
					(Ext.get(txtArr[i].id)).on('blur', function(){
						errMsg = Ext.util.validateMY(document.getElementById(this.id.substring(0, this.id.length-2)+"Mm"),document.getElementById(this.id.substring(0, this.id.length-2)+"Yy"),document.getElementById(this.id.substring(0, this.id.length-2)+"Title"),"XX");
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg,errCount);

					});
					errMsg =  Ext.util.validateMY(document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Mm"),document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Yy"),document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Title"),"XX");
					errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2),errMsg,errCount);

				}
			}
			else
			{
				
				(Ext.get(txtArr[i].id)).on('blur', function(){
					errMsg = Ext.util.validateMY(document.getElementById(this.id.substring(0, this.id.length-2)+"MM"),document.getElementById(this.id.substring(0, this.id.length-2)+"YY"),document.getElementById(this.id.substring(0, this.id.length-2)+"Title"),"XX");
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg,errCount);

				});
				errMsg =  Ext.util.validateMY(document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"MM"),document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"YY"),document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Title"),"XX");
				errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2),errMsg,errCount);
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

	var TBStatusArray1 = new Array(3);
	TBStatusArray1[0] = document.getElementById("asymptomaticTb[]");
	TBStatusArray1[1] = document.getElementById("completeTreat[]");
	TBStatusArray1[2] = document.getElementById("currentTreat[]");

	var TBStatusArray2 = new Array(3);
	TBStatusArray2[0] = "asymptomaticTb[]";
	TBStatusArray2[1] = "completeTreat[]";
	TBStatusArray2[2] = "currentTreat[]";

	var functionStatus = new Array(3);
	functionStatus[0] = document.getElementById("functionalStatus1");
	functionStatus[1] = document.getElementById("functionalStatus2");
	functionStatus[2] = document.getElementById("functionalStatus4");
	
	var whoStages = new Array(5);
	whoStages[0] = document.getElementById('asymptomaticWho');
	whoStages[1] = document.getElementById('pedSympWhoDiarrhea');
	whoStages[2] = document.getElementById('pedSympWhoWtLoss2');
	whoStages[3] = document.getElementById('pedSympWhoWtLoss3');
	whoStages[4] = document.getElementById('feverPlusMo');
		
	Ext.get('vDate').on('blur', function(){
		errMsg = Ext.util.checkItemSelected(TBStatusArray1, document.getElementById('tbStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbStatus',errMsg,errCount);
		errMsg = Ext.util.checkItemSelected(functionStatus, document.getElementById('functionalStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'functionalStatus',errMsg,errCount);
		errMsg = Ext.util.checkWhoStage(whoStages,document.getElementById('whoStageTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'whoStage',errMsg,errCount);
 	});
	if(document.mainForm.vDate.value!='' && document.mainForm.vDate.value!='//')
	{
		errMsg = Ext.util.checkItemSelected(TBStatusArray1, document.getElementById('tbStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbStatus',errMsg,errCount);
		errMsg = Ext.util.checkItemSelected(functionStatus, document.getElementById('functionalStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'functionalStatus',errMsg,errCount);
		errMsg = Ext.util.checkWhoStage(whoStages,document.getElementById('whoStageTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'whoStage',errMsg,errCount);

	}
	var hiddenTBArr = new Array();
	for(i=0;i<TBStatusArray2.length;i++)
	{
		hiddenTBArr[i] = TBStatusArray2[i].substring(0, TBStatusArray2[i].indexOf('[]'));
	}
	for(var i=0;i<TBStatusArray1.length;i++)
	{
//                var inName = TBStatusArray1[i].id;
//                var hidName = inName.substr(0, inName.indexOf('[]'));
		Ext.get(TBStatusArray1[i]).on('click', function(){
			var key = Ext.util.getKeyByID(TBStatusArray1, this.id);
			Ext.util.selectDiffRadio(document.getElementById(this.id), hiddenTBArr, key,radioArr);
//			Ext.util.checkUniqueRadio(TBStatusArray1,key,radioArr);
//                        Ext.util.toggleHiddenValues(TBStatusArray1, key);
			errMsg = Ext.util.checkItemSelected1(TBStatusArray2, radioArr, true, document.getElementById('tbStatusTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbStatus',errMsg,errCount);
                        errMsg = Ext.util.validateAdultTbStatusSection(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatFac'),document.getElementById('completeTreatTitle'),document.getElementById('completeTreatDtTitle'),document.getElementById('completeTreatFacTitle'));
                        errMsg = Ext.util.validateAdultTbStatusSection(document.getElementById('currentTreat[]'),document.getElementById('currentTreatNo'),document.getElementById('currentTreatFac'),document.getElementById('currentTreatTitle'),document.getElementById('currentTreatNoTitle'),document.getElementById('currentTreatFacTitle'));
//			errMsg = Ext.util.checkRadioCorresponding(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatTitle'));
//			errCount = Ext.util.showErrorHead(errFields,errMsgs,'completeTreat[]',errMsg,errCount);

//			errMsg = Ext.util.checkDateCorresponding(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatDtTitle'));
//			errCount = Ext.util.showErrorHead(errFields,errMsgs,'completeTreatDt',errMsg,errCount);

		}, document.getElementById(this.id), {delay: 5});
	}
		
//	Ext.get('completeTreatDt').on('blur',function() {
//		errMsg = Ext.util.checkRadioCorresponding(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatTitle'));
//		errCount = Ext.util.showErrorHead(errFields,errMsgs,'completeTreat[]',errMsg,errCount);
//
//		errMsg = Ext.util.checkDateCorresponding(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatDtTitle'));
//		errCount = Ext.util.showErrorHead(errFields,errMsgs,'completeTreatDt',errMsg,errCount);
//
//	});
//	errMsg = Ext.util.checkRadioCorresponding(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatTitle'));
//	errCount = Ext.util.showErrorHead(errFields,errMsgs,'completeTreat[]',errMsg,errCount);
//	errMsg = Ext.util.checkDateCorresponding(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatDtTitle'));
//	errCount = Ext.util.showErrorHead(errFields,errMsgs,'completeTreatDt',errMsg,errCount);
	
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

	for(i=0;i<whoStages.length;i++)
	{
		Ext.get(whoStages[i]).on('click', function(){
			errMsg = Ext.util.checkWhoStage(whoStages,document.getElementById('whoStageTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'whoStage',errMsg,errCount);

		});
	}

	for(i=0;i<3;i++)
	{
		Ext.get(functionStatus[i]).on('click', function(){

			errMsg = Ext.util.checkItemSelected(functionStatus, document.getElementById('functionalStatusTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'functionalStatus',errMsg,errCount);
		});
	}
	var tbEval = new Array(4);
	tbEval[0] = document.getElementById("pedTbEvalRecentExp");
	tbEval[1] = document.getElementById("suspicionTBwSymptoms");
	tbEval[2] = document.getElementById("presenceBCG");
	tbEval[3] = document.getElementById("noTBsymptoms");
	for(i=0;i<4;i++)
	{
		Ext.get(tbEval[i]).on('click', function(){

			errMsg = Ext.util.checkItemSelected(tbEval, document.getElementById('tbEvaluationTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbEvaluation',errMsg,errCount);
		});
	}


	Ext.get('vDate').on('blur', function(){
		errMsg = Ext.util.checkItemSelected1(TBStatusArray2, radioArr, true, document.getElementById('tbStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbStatus',errMsg,errCount);
		errMsg = Ext.util.checkItemSelected(tbEval, document.getElementById('tbEvaluationTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbEvaluation',errMsg,errCount);
		errMsg = Ext.util.checkItemSelected(functionStatus, document.getElementById('functionalStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'functionalStatus',errMsg,errCount);
		errMsg = Ext.util.checkWhoStage(whoStages,document.getElementById('whoStageTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'whoStage',errMsg,errCount);
 	});
	
	if(document.mainForm.vDate.value!='' && document.mainForm.vDate.value!='//')
	{
		errMsg = Ext.util.checkItemSelected1(TBStatusArray2, radioArr, true, document.getElementById('tbStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbStatus',errMsg,errCount);
		errMsg = Ext.util.checkItemSelected(tbEval, document.getElementById('tbEvaluationTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbEvaluation',errMsg,errCount);
		errMsg = Ext.util.checkItemSelected(functionStatus, document.getElementById('functionalStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'functionalStatus',errMsg,errCount);
		errMsg = Ext.util.checkWhoStage(whoStages,document.getElementById('whoStageTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'whoStage',errMsg,errCount);
	}

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
			Ext.util.disableSectionByRadio(document.getElementById("noDiagnosis"), radioArr, true, allElements["conditions"]);
	});	
	Ext.util.disableSectionByRadio(document.mainForm.noDiagnosis, radioArr, true, allElements["conditions"]);

	Ext.get('arvEverN').on('click',function() {
			Ext.util.disableSectionByRadio(document.getElementById("arvEverN"), radioArr, true, allElements["pedARVever"]);
	});	
	Ext.get('arvEverY').on('click',function() {
			Ext.util.disableSectionByRadio(document.getElementById("arvEverN"), radioArr, true, allElements["pedARVever"]);
	});	
	Ext.util.disableSectionByRadio(document.getElementById("arvEverN"), radioArr, true, allElements["pedARVever"]);
		
	var pedMedAllergArr = new Array();
	pedMedAllergArr[0] = "pedMedAllergY";
	pedMedAllergArr[1] = "pedMedAllergN";
	pedMedAllergArr[2] = "pedMedAllergU";
	for(i=0; i < pedMedAllergArr.length; i++)
	{
		Ext.get(pedMedAllergArr[i]).on('click', function(){
				Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(pedMedAllergArr), allElements["pedMedAllerg"], txtFormat);
		});
	}
	Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(pedMedAllergArr), allElements["pedMedAllerg"], txtFormat);
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

  	
  	for(i=0;i<disSec.length-1;i++)
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

	var medEligSection = new Array(6);
	medEligSection[0] = document.mainForm.pedMedEligCd4Cnt;
	medEligSection[1] = document.mainForm.pedMedEligWho3;
	medEligSection[2] = document.mainForm.pedMedEligWho4;
	medEligSection[3] = document.mainForm.pedMedEligTlc;
	medEligSection[4] = document.mainForm.pedMedEligPmtct;
	medEligSection[5] = document.mainForm.pedMedEligFormerTherapy;
	
	var medEligChoices = new Array(3);
	medEligChoices[0] = "medEligY";
	medEligChoices[1] = "medEligN";
	medEligChoices[2] = "medEligU";
	
	for(var i=0;i<medEligChoices.length;i++)
	{
		Ext.get(medEligChoices[i]).on('click', function(){
			Ext.util.disableElements(document.getElementById(medEligChoices[0]),medEligSection, radioArr, true);
		}, document.getElementById(this.id), {delay: 5});
	}	
	Ext.util.disableElements(document.getElementById(medEligChoices[0]),medEligSection, radioArr, true);	


	var TBStatusArray = new Array(4);
	TBStatusArray[0] = document.getElementById("pedTbEvalRecentExp");
	TBStatusArray[1] = document.getElementById("suspicionTBwSymptoms");
	TBStatusArray[2] = document.getElementById("presenceBCG");
	TBStatusArray[3] = document.getElementById("noTBsymptoms");
	var key = -1;
	for(i=0;i<TBStatusArray.length;i++)
	{
		Ext.get(TBStatusArray[i]).on('click', function(){
			key = Ext.util.getKeyByID(TBStatusArray, this.id)
			Ext.util.checkUniqueRadio(TBStatusArray,key,radioArr);
			errMsg = Ext.util.checkItemSelected(TBStatusArray, document.getElementById('tbEvaluationTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbStatus',errMsg,errCount);
		});
	}

});


