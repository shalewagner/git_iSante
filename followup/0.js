Ext.onReady(function() {
	//var start = (new Date()).getTime();
	var root;
	var suffix;
	var suffix70;
	var prefix4;
	var root;
	var startErrLoc,stopMm,stopYy,stopErrLoc,continuing,continuingErrLoc;
	var stopReasonsErrLoc,interruptErrLoc;
	var sexFlg = Ext.getDom('sex1').value;
	var stopReasonsArr = new Array(5);
	var interruptReasonsArr = new Array(7);
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
	
	vitalHr = new Ext.form.TextField({
		fieldLabel: '',
		name: 'vitalHr',
		maskRe : /[\d]/,
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
		maskRe : /[\d]/,
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

	var names = new Array();
	names[0] = "clinicalExam";
	names[1] = "arvPrevious";
	names[2] = "preg";
	names[3] = "pregPrenat";
	var allElements = Ext.util.getAllElements(document.mainForm,names);
	var txtArr = allElements["text"];
	var txtFormat = new Array();



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
			//root = txtArr[i].id.substring(0, txtArr[i].name.length-2);
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
								interruptReasonsArr = Ext.util.createInterruptReasons(this.id.substring(0,this.id.length-6));
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
								interruptReasonsArr = Ext.util.createInterruptReasons(this.id.substring(0,this.id.length-6));
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
						interruptReasonsArr = Ext.util.createInterruptReasons(root);
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
									var interruptReasonsArr1 = Ext.util.createInterruptReasons(reasonRoot);
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
									var interruptReasonsArr1 = Ext.util.createInterruptReasons(interRoot);
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
						errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2),errMsg,errCount);

					});
					Ext.util.validateMY(document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Mm"),document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Yy"),document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Title"),"XX");
					errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2),errMsg,errCount);

				}
			}
			else
			{
				(Ext.get(txtArr[i].id)).on('blur', function(){
					errMsg = Ext.util.validateMY(document.getElementById(this.id.substring(0, this.id.length-2)+"MM"),document.getElementById(this.id.substring(0, this.id.length-2)+"YY"),document.getElementById(this.id.substring(0, this.id.length-2)+"Title"),"XX");
					errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2),errMsg,errCount);

				});
				Ext.util.validateMY(document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"MM"),document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"YY"),document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Title"),"XX");
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
		errMsg = Ext.util.checkRadioCorresponding(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'completeTreat[]',errMsg,errCount);
		errMsg = Ext.util.checkDateCorresponding(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatDtTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'completeTreatDt',errMsg,errCount);
	});
	errMsg = Ext.util.checkRadioCorresponding(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'completeTreat[]',errMsg,errCount);
	errMsg = Ext.util.checkDateCorresponding(document.getElementById('completeTreat[]'),document.getElementById('completeTreatDt'),document.getElementById('completeTreatDtTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'completeTreatDt',errMsg,errCount);
	var OtherArvArr = new Array(11);
	OtherArvArr[0]='ethambutol';
	OtherArvArr[1]='isoniazid';
	OtherArvArr[2]='pyrazinamide';
	OtherArvArr[3]='rifampicine';
	OtherArvArr[4]='streptomycine';
	OtherArvArr[5]='acyclovir';
	OtherArvArr[6]='cotrimoxazole';
	OtherArvArr[7]='fluconazole';
	OtherArvArr[8]='ketaconazole';
	OtherArvArr[9]='traditional';
	OtherArvArr[10]='other3';
	for(i=0;i<OtherArvArr.length;i++)
	{
		
		(Ext.get(OtherArvArr[i]+"StopMm")).on('blur', function(){
			errMsg =  Ext.util.checkOtherContinued(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopTitle"),'XX');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6),errMsg,errCount);
			errMsg =  Ext.util.checkDrugContinuing(document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-6)+"ContinuedTitle"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + "Continued",errMsg,errCount);
		});
		(Ext.get(OtherArvArr[i]+"StopYy")).on('blur', function(){
			errMsg =  Ext.util.checkOtherContinued(document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6)+"StopTitle"),'XX');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6),errMsg,errCount);
			errMsg =  Ext.util.checkDrugContinuing(document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-6)+"ContinuedTitle"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + "Continued",errMsg,errCount);
	
		});
		(Ext.get(OtherArvArr[i]+"Continued")).on('click', function(){
			errMsg =  Ext.util.checkOtherContinued(document.getElementById(this.id.substring(0,this.id.length-9)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopTitle"),'XX');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9),errMsg,errCount);
			errMsg =  Ext.util.checkDrugContinuing(document.getElementById(this.id.substring(0,this.id.length-9)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopYy"),document.getElementById(this.id),document.getElementById(this.id + "Title"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
	
		});
		errMsg =  Ext.util.checkOtherContinued(document.getElementById(OtherArvArr[i]+"StopMm"),document.getElementById(OtherArvArr[i]+"StopYy"),document.getElementById(OtherArvArr[i]+"StopTitle"),'XX');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,OtherArvArr[i],errMsg,errCount);
		errMsg =  Ext.util.checkDrugContinuing(document.getElementById(OtherArvArr[i]+"StopMm"),document.getElementById(OtherArvArr[i]+"StopYy"),document.getElementById(OtherArvArr[i]+"Continued"),document.getElementById(OtherArvArr[i]+"ContinuedTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,OtherArvArr[i] + "Continued" ,errMsg,errCount);

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
		
	});
	Ext.util.disableSectionByRadio(document.getElementById('physicalDone'), radioArr, true, clinicalExamArr);

	if(sexFlg == "2")
    {
  		var disSec = new Array();
  		disSec[0] = "preg";
  		disSec[1] = "pregPrenat";
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
		var pregArr = new Array();
		pregArr[0] = "pregY";
		pregArr[1] = "pregN";
		pregArr[2] = "pregU";
		for(i=0; i < pregArr.length; i++)
		{
			Ext.get(pregArr[i]).on('click', function(){
						Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(pregArr), allElements["preg"], txtFormat);
				});
		}
		  Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(pregArr), allElements["preg"], txtFormat);	

		var pregPrenatArr = new Array();
		pregPrenatArr[0] = "pregPrenatY";
		pregPrenatArr[1] = "pregPrenatN";
		for(i=0; i < pregPrenatArr.length; i++)
		{
			Ext.get(pregPrenatArr[i]).on('click', function(){
						Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(pregPrenatArr), allElements["pregPrenat"], txtFormat);
				});
		}
		Ext.util.disableSectionByInternalRadios(Ext.util.getElementsByArr(pregPrenatArr), allElements["pregPrenat"], txtFormat);	
    }	

    //Allow multi-seletion of radios
	var tempRadioArr = allElements["radio"]; 
	var radioArr = Ext.util.getAllRadios(tempRadioArr);
	//All the radio validation would be better placed after the previous multi-selection
	var functionStatus = new Array(3);
	functionStatus[0] = "functionalStatus1";
	functionStatus[1] = "functionalStatus2";
	functionStatus[2] = "functionalStatus4";

	var TBStatusArray = new Array(5);
	TBStatusArray[0] = "completeTreat[]";
	TBStatusArray[1] = "asymptomaticTb[]";
	TBStatusArray[2] = "suspectedTb[]";
	TBStatusArray[3] = "currentTreat[]";
	TBStatusArray[4] = "currentProp[]";	
	
	for(i=0;i<3;i++)
	{
		Ext.get(functionStatus[i]).on('click', function(){
			errMsg = Ext.util.isItemSelected(functionStatus, radioArr, false, document.getElementById('functionalStatusTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'functionalStatus',errMsg,errCount);
		}, document.getElementById(this.id), {delay: 5});
	}
	Ext.get('vDate').on('blur', function(){
		if(document.getElementById(TBStatusArray[0])!=null)
		{
			errMsg = Ext.util.checkItemSelected1(TBStatusArray, radioArr, true, document.getElementById('tbStatusTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbStatus',errMsg,errCount);
		}
		errMsg = Ext.util.isItemSelected(functionStatus, radioArr, false, document.getElementById('functionalStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'functionalStatus',errMsg,errCount);
		errMsg = Ext.util.checkWhoStage(whoStages,document.getElementById('whoStageTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'whoStage',errMsg,errCount);

 	});

	if(document.mainForm.vDate.value!='' && document.mainForm.vDate.value!='//')
	{
		if(document.getElementById(TBStatusArray[0])!=null)
		{
			errMsg = Ext.util.checkItemSelected1(TBStatusArray, radioArr, true, document.getElementById('tbStatusTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'tbStatus',errMsg,errCount);
		}
		errMsg = Ext.util.isItemSelected(functionStatus,radioArr, false, document.getElementById('functionalStatusTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'functionalStatus',errMsg,errCount);
		errMsg = Ext.util.checkWhoStage(whoStages,document.getElementById('whoStageTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'whoStage',errMsg,errCount);

	}
	
	Ext.get('arvY').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById("arvN"), radioArr,false, allElements["arvPrevious"]);
	});
	Ext.get('arvN').on('click',function() {
		Ext.util.disableSectionByRadio(document.getElementById(this.id),radioArr,false,  allElements["arvPrevious"]);
	});
	Ext.util.disableSectionByRadio(document.getElementById("arvN"),radioArr,true,  allElements["arvPrevious"]);	
	


	var key = -1;
	for(i=0;i<5;i++)
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
	
    Ext.get('vitalTemp').on('blur', function(){

		errMsg = Ext.util.checkTemp(document.mainForm.vitalTemp,null,null,null,true, document.getElementById("vitalTempTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
	
	});

	errMsg = Ext.util.checkTemp(document.mainForm.vitalTemp,null,null,null, false,document.getElementById("vitalTempTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
	
	Ext.get('vitalBp1').on('blur', function(){
		errMsg = Ext.util.checkBp1(document.mainForm.vitalBp1,document.getElementById("vitalBp1Title"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBp1',errMsg,errCount);
		errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"),radioArr, true, document.getElementById("vitalBpUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);

	});
	errMsg = Ext.util.checkBp1(document.mainForm.vitalBp1,document.getElementById("vitalBp1Title"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBp1',errMsg,errCount);
	vitalBp2.applyToMarkup(document.mainForm.vitalBp2); 
	Ext.get('vitalBp2').on('blur', function(){
		errMsg = Ext.util.checkBp2(document.mainForm.vitalBp2,document.getElementById("vitalBp2Title"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBp2',errMsg,errCount);
		errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"),radioArr, true, document.getElementById("vitalBpUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);
		
	});
	Ext.get('vitalBpUnit1').on('click', function(){
		errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"),radioArr, false, document.getElementById("vitalBpUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);
		
	});
	Ext.get('vitalBpUnit2').on('click', function(){
		errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"),radioArr, false, document.getElementById("vitalBpUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);
		
	});	
	errMsg = Ext.util.checkBp2(document.mainForm.vitalBp2,document.getElementById("vitalBp2Title"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBp2',errMsg,errCount);
	errMsg = Ext.util.checkBPUnit(document.mainForm.vitalBp1,document.mainForm.vitalBp2, document.getElementById("vitalBpUnit1"),document.getElementById("vitalBpUnit2"),radioArr, true, document.getElementById("vitalBpUnitTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalBpUnit',errMsg,errCount);	
	
Ext.get('vitalWeight').on('blur', function(){
		errMsg = Ext.util.checkWeight(document.mainForm.vitalWeight,document.getElementById("vitalWeightTitle"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeight',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.mainForm.vitalWeight,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr, true,document.getElementById("vitalWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
	
	});
	Ext.get('vitalWeightUnit1').on('click', function(){
		errMsg = Ext.util.checkUnit(document.mainForm.vitalWeight,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr, false,document.getElementById("vitalWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
	
	});
	Ext.get('vitalWeightUnit2').on('click', function(){
		errMsg = Ext.util.checkUnit(document.mainForm.vitalWeight,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr, false,document.getElementById("vitalWeightUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
	
	});
	errMsg = Ext.util.checkWeight(document.mainForm.vitalWeight,document.getElementById("vitalWeightTitle"),'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeight',errMsg,errCount);
	errMsg = Ext.util.checkUnit(document.mainForm.vitalWeight,document.getElementById("vitalWeightUnit1"),document.getElementById("vitalWeightUnit2"),radioArr, true,document.getElementById("vitalWeightUnitTitle"));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalWeightUnit',errMsg,errCount);		
});


