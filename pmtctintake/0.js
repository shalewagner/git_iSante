	
Ext.onReady(function() {
	var names = new Array();
	names[0] = "arvPrevious";
	names[1] = "aMed";
	var allElements = Ext.util.getAllElements(document.mainForm,names);
	var txtArr = allElements["text"];
	var txtFormat = new Array();
	var root;
	var suffix;
	var sideEffects = new Array(11);
	sideEffects[0]='sideNausea';
	sideEffects[1]='sideDiarrhea';
	sideEffects[2]='sideRash';
	sideEffects[3]='sideHeadache';
	sideEffects[4]='sideAbPain';
	sideEffects[5]='sideWeak';
	sideEffects[6]='sideNumb';
	sideEffects[7]='jaundice';
	sideEffects[8]='severeAllergicReactions';
	sideEffects[9]='behaviorProblem';
	sideEffects[10]='neuroMuscularDisorder';
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
					errMsg = Ext.util.validateMY(document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Mm"),document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Yy"),document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Title"),"XX");
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
	/* Disable associated textfields, radios, and etc */
	for(i = 0;i < 3;i++)
	{
		Ext.get('papTest' + i).on('click', function(){
			var papAnmlArr = new Array(3);
			for(var j = 0; j < 3; j++)
			{
				papAnmlArr[j] = document.getElementById('papAnml' + j);
			}
			Ext.util.enableAssociated(document.getElementById('papTest0'),papAnmlArr);
		});
	}
	var papAnmlArr = new Array(3);
	for(var j = 0; j < 3; j++)
	{
		papAnmlArr[j] = document.getElementById('papAnml' + j);
	}
	Ext.util.enableAssociated(document.getElementById('papTest0'),papAnmlArr);
		
	Ext.get('famPlanOther').on('click', function(){
		Ext.util.enableAssociated(document.getElementById('famPlanOther'),new Array(document.getElementById('famPlanOtherText')));
	});	
	Ext.util.enableAssociated(document.getElementById('famPlanOther'),new Array(document.getElementById('famPlanOtherText')));
	
	for( i = 0; i < 2; i++)
	{
		Ext.get('lastHIVTestFac' + i).on('click', function(){
			Ext.util.enableAssociated(document.getElementById('lastHIVTestFac1'),new Array(document.getElementById('lastHIVTestOtherText')));
		});	
	}
	Ext.util.enableAssociated(document.getElementById('lastHIVTestFac1'),new Array(document.getElementById('lastHIVTestOtherText')));	
	
	for(var j = 0; j < 3; j++)
	{
		Ext.get('lastVIHTest' + j).on('click', function(){
			Ext.util.enableAssociatedDt(document.getElementById('lastVIHTest0'),txtFormat['lastVIHTestDt']);
			errMsg = Ext.util.validateDateField(document.getElementById('lastVIHTestDt'), document.getElementById('lastVIHTestDtTitle'),"");
			Ext.util.splitDate(document.getElementById('lastVIHTestDt'),document.getElementById('lastVIHTestDd'),document.getElementById('lastVIHTestMm'),document.getElementById('lastVIHTestYy'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'lastVIHTestDt',errMsg,errCount);
		});	
	}
	Ext.util.enableAssociatedDt(document.getElementById('lastVIHTest0'),txtFormat['lastVIHTestDt']);		
	
	Ext.get('transferIn').on('click', function(){
		Ext.util.enableAssociated(document.getElementById('transferIn'),new Array(document.getElementById('firstCareOtherFacText')));
	});	
	Ext.util.enableAssociated(document.getElementById('transferIn'),new Array(document.getElementById('firstCareOtherFacText')));

	for(var j = 0; j < 2; j++)
	{
		Ext.get('bloodExpAnswer' + j).on('click', function(){
			Ext.util.enableAssociated(document.getElementById('bloodExpAnswer0'),new Array(document.getElementById('bloodExpCommentComment')));
			Ext.util.enableAssociatedDt(document.getElementById('bloodExpAnswer0'),txtFormat['bloodExpDt']);
			errMsg = Ext.util.validateDateField(document.getElementById('bloodExpDt'), document.getElementById('bloodExpDtTitle'),"");
			Ext.util.splitDate(document.getElementById('bloodExpDt'),document.getElementById('bloodExpDd'),document.getElementById('bloodExpMm'),document.getElementById('bloodExpYy'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodExpDt',errMsg,errCount);
		});	
	}
	Ext.util.enableAssociated(document.getElementById('bloodExpAnswer0'),new Array(document.getElementById('bloodExpCommentComment')));
	Ext.util.enableAssociatedDt(document.getElementById('bloodExpAnswer0'),txtFormat['bloodExpDt']);
		
	for(var j = 0; j < 2; j++)
	{
		Ext.get('bloodTransAnswer' + j).on('click', function(){
			Ext.util.enableAssociated(document.getElementById('bloodTransAnswer0'),new Array(document.getElementById('bloodTransCommentComment')));
			Ext.util.enableAssociatedDt(document.getElementById('bloodTransAnswer0'),txtFormat['bloodTransDt']);
			errMsg = Ext.util.validateDateField(document.getElementById('bloodTransDt'), document.getElementById('bloodTransDtTitle'),"");
			Ext.util.splitDate(document.getElementById('bloodTransDt'),document.getElementById('bloodTransDd'),document.getElementById('bloodTransMm'),document.getElementById('bloodTransYy'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'bloodTransDt',errMsg,errCount);
		});	
	}
	Ext.util.enableAssociated(document.getElementById('bloodTransAnswer0'),new Array(document.getElementById('bloodTransCommentComment')));
	Ext.util.enableAssociatedDt(document.getElementById('bloodTransAnswer0'),txtFormat['bloodTransDt']);	


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

	for(var j = 0; j < 3; j++)
	{
		Ext.get('lowestCd4CntNotDone' + j).on('click', function(){
			Ext.util.enableAssociated(document.getElementById('lowestCd4CntNotDone0'),new Array(document.getElementById('lowestCd4Cnt')));
			Ext.util.enableAssociatedDt(document.getElementById('lowestCd4CntNotDone0'),txtFormat['lowestCd4CntDt']);
			errMsg = Ext.util.validateDateField(document.getElementById('lowestCd4CntDt'), document.getElementById('lowestCd4CntDtTitle'),"");
			Ext.util.splitDate(document.getElementById('lowestCd4CntDt'),document.getElementById('lowestCd4CntDd'),document.getElementById('lowestCd4CntMm'),document.getElementById('lowestCd4CntYy'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'lowestCd4CntDt',errMsg,errCount);
		});	
	}
	Ext.util.enableAssociated(document.getElementById('lowestCd4CntNotDone0'),new Array(document.getElementById('lowestCd4Cnt')));
	Ext.util.enableAssociatedDt(document.getElementById('lowestCd4CntNotDone0'),txtFormat['lowestCd4CntDt']);
	
	for(var j = 0; j < 3; j++)
	{
		Ext.get('firstViralLoadNotDone' + j).on('click', function(){
			Ext.util.enableAssociated(document.getElementById('firstViralLoadNotDone0'),new Array(document.getElementById('firstViralLoad')));
			Ext.util.enableAssociatedDt(document.getElementById('firstViralLoadNotDone0'),txtFormat['firstViralLoadDt']);
			errMsg = Ext.util.validateDateField(document.getElementById('firstViralLoadDt'), document.getElementById('firstViralLoadDtTitle'),"");
			Ext.util.splitDate(document.getElementById('firstViralLoadDt'),document.getElementById('firstViralLoadDd'),document.getElementById('firstViralLoadMm'),document.getElementById('firstViralLoadYy'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'firstViralLoadDt',errMsg,errCount);
		});	
	}
	Ext.util.enableAssociated(document.getElementById('firstViralLoadNotDone0'),new Array(document.getElementById('firstViralLoad')));
	Ext.util.enableAssociatedDt(document.getElementById('firstViralLoadNotDone0'),txtFormat['firstViralLoadDt']);
	
	Ext.get('completeTreat').on('click', function(){
		Ext.util.enableAssociated(document.getElementById('completeTreat'),new Array(document.getElementById('completeTreatFac')));
		Ext.util.enableAssociatedDt(document.getElementById('completeTreat'),txtFormat['completeTreatDt']);
		errMsg = Ext.util.validateDateField(document.getElementById('completeTreatDt'), document.getElementById('completeTreatDtTitle'),"");
		Ext.util.splitDate(document.getElementById('completeTreatDt'),document.getElementById('completeTreatDd'),document.getElementById('completeTreatMm'),document.getElementById('completeTreatYy'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'completeTreatDt',errMsg,errCount);
	});	
	Ext.util.enableAssociated(document.getElementById('completeTreatDt'),new Array(document.getElementById('completeTreatFac')));
	Ext.util.enableAssociatedDt(document.getElementById('completeTreat'),txtFormat['completeTreatDt']);
	
	Ext.get('currentTreat').on('click', function(){
		Ext.util.enableAssociated(document.getElementById('currentTreat'),new Array(document.getElementById('currentTreatNo'), document.getElementById('currentTreatFac')));
	});	
	Ext.util.enableAssociated(document.getElementById('currentTreat'),new Array(document.getElementById('currentTreatNo'), document.getElementById('currentTreatFac')));

	var vaccArr = new Array(5);
	vaccArr[0] = 'toxTetanus';
	vaccArr[1] = 'immunHepB';
	vaccArr[2] = 'pneumovax';
	vaccArr[3] = 'rhogam';
	vaccArr[4] = 'immunOther';
	for(i=0; i<vaccArr.length;i++)
	{
		for(j=1;j<4;j++)
		{
			Ext.get(vaccArr[i] + j + 'DtToday').on('click', function(){
				Ext.util.selectToday(document.getElementById(this.id),txtFormat[this.id.substring(0, this.id.length-5)]);
				errMsg = Ext.util.validateDateField(document.getElementById(this.id.substring(0, this.id.length-5)), document.getElementById(this.id.substring(0, this.id.length-5) + 'Title'),"");
				Ext.util.splitDate(document.getElementById(this.id.substring(0, this.id.length-5)),document.getElementById(this.id.substring(0, this.id.length-7)+ 'Dd'),document.getElementById(this.id.substring(0, this.id.length-7)+ 'Mm'),document.getElementById(this.id.substring(0, this.id.length-7)+ 'Yy'));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0, this.id.length-5),errMsg,errCount);
			});	
		}
	}
	
	for(var j = 1; j < 3; j++)
	{
		Ext.get('underArv' + j).on('click', function(){
			Ext.util.enableAssociated(document.getElementById('underArv2'),new Array(document.getElementById('arvInit')));		
		});	
	}
	/** Disable chebox multi-selection*/
	/*
	var checkboxArr = new Array(22);
	checkboxArr[0] = new Array(2);
	checkboxArr[0][0] =  "papTest";
	checkboxArr[0][1] =  3;
	checkboxArr[1] = new Array(2);
	checkboxArr[1][0] =  "papAnml";
	checkboxArr[1][1] =  3;
	checkboxArr[2] = new Array(2);
	checkboxArr[2][0] =  "famPlan";
	checkboxArr[2][1] =  2;
	checkboxArr[3] = new Array(2);
	checkboxArr[3][0] =  "lastVIHTest";
	checkboxArr[3][1] =  3;
	checkboxArr[4] = new Array(2);
	checkboxArr[4][0] =  "lastVIHTestResult";
	checkboxArr[4][1] =  3;
	checkboxArr[5] = new Array(2);
	checkboxArr[5][0] =  "lastHIVTestFac";
	checkboxArr[5][1] =  2;	
	checkboxArr[6] = new Array(2);
	checkboxArr[6][0] =  "maleWfemaleAnswer";
	checkboxArr[6][1] =  3;	
	checkboxArr[7] = new Array(2);
	checkboxArr[7][0] =  "bloodTransAnswer";
	checkboxArr[7][1] =  3;
	checkboxArr[8] = new Array(2);
	checkboxArr[8][0] =  "femaleWfemaleAnswer";
	checkboxArr[8][1] =  3;
	checkboxArr[9] = new Array(2);
	checkboxArr[9][0] =  "sexAnalNoWrapAnswer";
	checkboxArr[9][1] =  3;
	checkboxArr[10] = new Array(2);
	checkboxArr[10][0] =  "partnerPositiveAnswer";
	checkboxArr[10][1] =  3;
	checkboxArr[11] = new Array(2);
	checkboxArr[11][0] =  "bloodExpAnswer";
	checkboxArr[11][1] =  3;
	checkboxArr[12] = new Array(2);
	checkboxArr[12][0] =  "sexWithIvDrugUserAnswer";
	checkboxArr[12][1] =  3;
	checkboxArr[13] = new Array(2);
	checkboxArr[13][0] =  "sexWithHomoBiAnswer";
	checkboxArr[13][1] =  3;
	checkboxArr[14] = new Array(2);
	checkboxArr[14][0] =  "sexWorkerAnswer";
	checkboxArr[14][1] =  3;
	checkboxArr[15] = new Array(2);
	checkboxArr[15][0] =  "verticalTransmissionAnswer";
	checkboxArr[15][1] =  3;
	checkboxArr[16] = new Array(2);
	checkboxArr[16][0] =  "noIDAnswer";
	checkboxArr[16][1] =  2;
	checkboxArr[17] = new Array(2);
	checkboxArr[17][0] =  "sharedNeedlesAnswer";
	checkboxArr[17][1] =  3;
	checkboxArr[18] = new Array(2);
	checkboxArr[18][0] =  "arv";
	checkboxArr[18][1] =  2;
	checkboxArr[19] = new Array(2);
	checkboxArr[19][0] =  "lastQuarterSex";
	checkboxArr[19][1] =  3;
	checkboxArr[20] = new Array(2);
	checkboxArr[20][0] =  "lastQuarterSexWithoutCondom";
	checkboxArr[20][1] =  3;
	checkboxArr[21] = new Array(2);
	checkboxArr[21][0] =  "lastQuarterSeroStatPart";
	checkboxArr[21][1] =  3;	
	
	
	
	var cx,cy;
	for(cx = 0; cx < checkboxArr.length; cx++)
	{
		for(cy=0;cy<checkboxArr[cx][1];cy++)
		{
			if(document.getElementById(checkboxArr[cx][0]+cy)==null)
				alert(checkboxArr[cx][0]+cy);
			(Ext.get(checkboxArr[cx][0]+cy)).on("click", function(){

				var tChkRoot = this.id.substring(0,this.id.length-1);
				var tChkPro = this.id.substring(this.id.length-1);
				var key = Ext.util.getKeyByVal(checkboxArr, tChkRoot);
				var tChkArr = new Array(checkboxArr[key][1]);
				for(var cz = 0; cz < checkboxArr[key][1]; cz++)
				{
					tChkArr[cz] = document.getElementById(tChkRoot + cz);
				}
				Ext.util.checkUniqueCheckbox(tChkArr,Number(tChkPro));
			});
		}
	}

	*/
	var medPregArr = new Array(7);
	medPregArr[0] = 'gravida';
	medPregArr[1] = 'para';
	medPregArr[2] = 'aborta';
	medPregArr[3] = 'mortFoetal';
	medPregArr[4] = 'fulltimePreg';
	medPregArr[5] = 'prematurity';
	medPregArr[6] = 'ectPreg';

	for(i=0;i<medPregArr.length;i++)
	{
		Ext.get(medPregArr[i]).on('blur', function(){
			errMsg = Ext.util.isBiggerEqualThan0(document.getElementById(this.id),document.getElementById(this.id + "Title"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
		});
		errMsg = Ext.util.isBiggerEqualThan0(document.getElementById(medPregArr[i]),document.getElementById(medPregArr[i] + "Title"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,medPregArr[i],errMsg,errCount);
	}

	var tempRadioArr = allElements["radio"]; 
	var radioArr = Ext.util.getAllRadios(tempRadioArr);	
	
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
		maskRe : /[\d\.]/,
		validationEvent: false,
		allowBlank:true
	});
	vitalTemp.applyToMarkup(document.mainForm.vitalTemp);
	Ext.get('vitalTemp').on('blur', function(){
		errMsg = Ext.util.checkTemp(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, true, document.getElementById('vitalTempTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, true, document.getElementById('vitalTempUnitTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTempUnit',errMsg,errCount);	
	});
	Ext.get('vitalTempUnit1').on('click', function(){
		errMsg = Ext.util.checkTemp(document.mainForm.vitalTemp,document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, true, document.getElementById('vitalTempTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, true,document.getElementById("vitalTempUnitTitle"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTempUnit',errMsg,errCount);
	}, document.getElementById(this.id), {delay: 5});
	Ext.get('vitalTempUnit2').on('click', function(){
		errMsg = Ext.util.checkTemp(document.mainForm.vitalTemp,document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, true,document.getElementById('vitalTempTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
		errMsg = Ext.util.checkUnit(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, true,document.getElementById('vitalTempUnitTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTempUnit',errMsg,errCount);
	}, document.getElementById(this.id), {delay: 5});
	errMsg = Ext.util.checkTemp(document.mainForm.vitalTemp,document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'),radioArr, true,document.getElementById('vitalTempTitle'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'vitalTemp',errMsg,errCount);
	errMsg = Ext.util.checkUnit(document.mainForm.vitalTemp, document.getElementById('vitalTempUnit1'),document.getElementById('vitalTempUnit2'), radioArr, true,document.getElementById("vitalTempUnitTitle"));
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
 	
	Ext.get('motherPregWeeks').on('blur', function(){
		errMsg = Ext.util.isValueInBound(document.mainForm.motherPregWeeks,document.getElementById("motherPregWeeksTitle"),'0',41,'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'motherPregWeeks',errMsg,errCount);		
	
	});	
	errMsg = Ext.util.isValueInBound(document.mainForm.motherPregWeeks,document.getElementById("motherPregWeeksTitle"),'0',41,'');
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'motherPregWeeks',errMsg,errCount);		
	
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
	//Ext.util.clickRadio(document.mainForm);
	
});


