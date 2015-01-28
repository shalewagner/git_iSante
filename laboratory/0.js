	
Ext.onReady(function() {
	var resultArr = new Array("cd4TestResult","cd4TestResult2","viralLoadTestResult","wbcTestResult","wbcTestResult2",
				    "lymphocytesTestResult","lymphocytesTestResult2","monocytesTestResult","monocytesTestResult2","polymorphsTestResult","polymorphsTestResult2",
				    "eospinophilsTestResult","eospinophilsTestResult2","basophilsTestResult","basophilsTestResult2","hematocritTestResult",
				    "plateletsTestResult","esrTestResult",
				    "sodiumTestResult","potassiumTestResult","chlorineTestResult","bicarbonateTestResult","bloodUreaTestResult",
				    "creatinineTestResult","randomGlucoseTestResult","fastingGlucoseTestResult","astSgotTestResult","altSgptTestResult","totalBilirubinTestResult",
				    "amylaseTestResult","totalCholesterolTestResult",
				    "ldlTestResult","hdlTestResult","triglycerideTestResult","ppdMantouxTestResult");

	var lowerArr = new Array("0",	  "0",		"0",	"0", 	"0",  	
				  "1","0","0","0","0","0",
				  "0","0","0","0","0",
				  "140","0",
				  "133","3.3","100","20","1",
				  "0","2","2","0","0","0",
				  "14","0",
				  "0","34","0","0");

	var upperArr = new Array("3000", "100",	"", 	"30",	"100",	
				  "5.1",  "100",	"8",	"100",	"5",	"100",
				  "",	  "100",	"3",	"100",	"100", 	
				  "450",  "",
				  "151",	"",	"113",	"33",	"26",
				  "2",	  "20",		"20",	"",	"",	"1.5",
				  "90",   "400",
				  "",	  "",	  	"200",	"");
 	var sexFlg = Ext.getDom('sex1').value;
	var prefix7;
	var dis = false;
	var root;
	var suffix;
	var tfFormat,taFormat,txtFormat;


	var result = Ext.util.getLabTestResultElements();
	var rowResult;
	var i = 0;
	var tempArr;
	var disableElements = new Array();
	var dI = 0;
	
	for(key1 in result)
	{	
		rowResult = result[key1];
		tempArr = new Array();

		var j = 0;
		for(i = 0; i < rowResult.length; i++)
		{
			if(rowResult[i] == null)
			{
				continue;
			}
			suffix = rowResult[i].name.substring(rowResult[i].name.length-2);
			prefix7 = rowResult[i].name.substring(0,7);
			if(sexFlg == '2')
			{
				if(prefix7 == 'frottis' || prefix7 == 'papTest')
				{
					dis = true;
					disableElements[dI++] = rowResult[i];
				}
				else
				{
					dis = false;
				}
			}
			else
			{
				dis = false;
			}
			var tmpResult = Ext.util.extractLabTestResultElements(result[key1]);
			if(rowResult[i].type == 'text')
			{
				
				if(suffix == "Dt")
				{
					tfFormat= new Ext.form.DateField({
						fieldLabel: '',
						maskRe : /[\d{1,2}\/]/,
						validationEvent: false,
						allowBlank:true,
						disabled: dis
					});
					tfFormat.applyToMarkup(rowResult[i]);
					(Ext.get(rowResult[i].id)).on('blur', function(){
						var indexLoc = this.id.indexOf('Test');
						var tmpResult = Ext.util.extractLabTestResultElements(result[this.id.substring(0,indexLoc)]);
						
						errMsg =  Ext.util.validateRxDispDate(document.getElementById(this.id.substring(0,this.id.length-2) + 'Dt'),document.getElementById(this.id.substring(0,this.id.length-2) + 'DtTitle'),'');
						Ext.util.splitDate(document.getElementById(this.id.substring(0,this.id.length-2) + 'Dt'),document.getElementById(this.id.substring(0,this.id.length-2) + "Dd"),document.getElementById(this.id.substring(0,this.id.length-2) + "Mm"),document.getElementById(this.id.substring(0,this.id.length-2) + "Yy"));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
						if(errMsg=='')
						{
							errMsg =  Ext.util.validateTestResultExclCheckbox(document.getElementById(this.id.substring(0,this.id.length-2) + '[]'), tmpResult, document.getElementById(this.id.substring(0,this.id.length-2) + 'Dt'), document.getElementById(this.id.substring(0,this.id.length-2) + 'DtTitle'));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
	
						}
						errMsg =  Ext.util.validateTestResult( document.getElementById(this.id.substring(0,this.id.length-2) + '[]'), tmpResult, resultArr, lowerArr, upperArr, document.getElementById(this.id.substring(0,this.id.length-2) + 'Dt'),document.getElementById(this.id.substring(0,this.id.length-2) +  'ResultTitle'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2) + 'Result' ,errMsg,errCount);
						errMsg =  Ext.util.validateTestResultExclCheckbox1(document.getElementById(this.id.substring(0,this.id.length-2) + '[]'),tmpResult, document.getElementById(this.id.substring(0,this.id.length-2) + 'Dt'),document.getElementById(this.id.substring(0,this.id.length-2) + '[]Title'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2) + '[]',errMsg,errCount);
	
					});
				  
					errMsg =  Ext.util.validateRxDispDate(document.getElementById(key1 + 'TestDt'),document.getElementById(key1 + 'TestDtTitle'),'');
					errCount = Ext.util.showErrorHead(errFields,errMsgs,key1 + 'TestDt',errMsg,errCount);
					if(errMsg == '')
					{
						errMsg =  Ext.util.validateTestResultExclCheckbox(document.getElementById(key1 + 'Test[]'),tmpResult, document.getElementById(key1 + 'TestDt'),document.getElementById(key1 + 'TestDtTitle'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,key1 + 'TestDt',errMsg,errCount);
					}
				}
				else
				{
					txtFormat = new Ext.form.TextField({
						fieldLabel: '',
						validationEvent: false,
						allowBlank:true
					});
					txtFormat.applyToMarkup(rowResult[i]);
					(Ext.get(rowResult[i].id)).on('blur', function(){
						var indexLoc = this.id.indexOf('Test');
						var tmpResult = Ext.util.extractLabTestResultElements(result[this.id.substring(0,indexLoc)]);
						errMsg =  Ext.util.validateRxDispDate(document.getElementById(this.id.substring(0,indexLoc) + 'TestDt'),document.getElementById(this.id.substring(0,indexLoc) + 'TestDtTitle'),'');
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,indexLoc) + 'TestDt',errMsg,errCount);
						if(errMsg == '')
						{
							errMsg =  Ext.util.validateTestResultExclCheckbox(document.getElementById(this.id.substring(0,indexLoc) + 'Test[]'),tmpResult, document.getElementById(this.id.substring(0,indexLoc) + 'TestDt'),document.getElementById(this.id.substring(0,indexLoc) + 'TestDtTitle'));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,indexLoc) + 'TestDt',errMsg,errCount);
						}
	
						errMsg =  Ext.util.validateTestResult(document.getElementById(this.id.substring(0,indexLoc) + 'Test[]'),tmpResult, resultArr, lowerArr, upperArr,  document.getElementById(this.id.substring(0,indexLoc) + 'TestDt'),document.getElementById(this.id.substring(0,indexLoc) + 'TestResultTitle'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,indexLoc) + 'TestResult',errMsg,errCount);
						errMsg =  Ext.util.validateTestResultExclCheckbox1( document.getElementById(this.id.substring(0,indexLoc) + 'Test[]'),tmpResult, document.getElementById(this.id.substring(0,indexLoc) + 'TestDt'),document.getElementById(this.id.substring(0,indexLoc) + 'Test[]Title'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,indexLoc) + 'Test[]',errMsg,errCount);				
								
					
					});
					tempArr[j++] = rowResult[i];
				}
			}
			else if(rowResult[i].type == 'radio')
			{
				(Ext.get(rowResult[i].id)).on('click', function(){
					var indexLoc = this.id.indexOf('Test');
					var tmpResult = Ext.util.extractLabTestResultElements(result[this.id.substring(0,indexLoc)]);
					if(document.getElementById(this.id.substring(0,indexLoc) + 'TestDtTitle') == null)
						alert(this.id.substring(0,indexLoc) + 'TestDtTitle');
					errMsg =  Ext.util.validateRxDispDate(document.getElementById(this.id.substring(0,indexLoc) + 'TestDt'),document.getElementById(this.id.substring(0,indexLoc) + 'TestDtTitle'),'');
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,indexLoc) + 'TestDt',errMsg,errCount);
					if(errMsg == '')
					{
						errMsg =  Ext.util.validateTestResultExclCheckbox(document.getElementById(this.id.substring(0,indexLoc) + 'Test[]'),tmpResult, document.getElementById(this.id.substring(0,indexLoc) + 'TestDt'),document.getElementById(this.id.substring(0,indexLoc) + 'TestDtTitle'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,indexLoc) + 'TestDt',errMsg,errCount);
					}

					errMsg =  Ext.util.validateTestResult(document.getElementById(this.id.substring(0,indexLoc) + 'Test[]'),tmpResult, resultArr, lowerArr, upperArr,  document.getElementById(this.id.substring(0,indexLoc) + 'TestDt'),document.getElementById(this.id.substring(0,indexLoc) + 'TestResultTitle'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,indexLoc) + 'TestResult',errMsg,errCount);
			
					errMsg =  Ext.util.validateTestResultExclCheckbox1( document.getElementById(this.id.substring(0,indexLoc) + 'Test[]'),tmpResult, document.getElementById(this.id.substring(0,indexLoc) + 'TestDt'),document.getElementById(this.id.substring(0,indexLoc) + 'Test[]Title'));
					
										
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,indexLoc) + 'Test[]',errMsg,errCount);				
										
							
				
				});
				tempArr[j++] = rowResult[i];

			}
			else if(rowResult[i].type == 'checkbox')
			{
				var suffix1 = rowResult[i].id.substring(rowResult[i].id.length-6)
				if(suffix1 == 'Test[]')
				{
					(Ext.get(rowResult[i].id)).on('click', function(){
						var indexLoc = this.id.indexOf('Test');
						var tmpResult = Ext.util.extractLabTestResultElements(result[this.id.substring(0,indexLoc)]);
						errMsg =  Ext.util.validateRxDispDate(document.getElementById(this.id.substring(0,indexLoc) + 'TestDt'),document.getElementById(this.id.substring(0,indexLoc) + 'TestDtTitle'),'');
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,indexLoc) + 'TestDt',errMsg,errCount);
						if(errMsg == '')
						{
							errMsg =  Ext.util.validateTestResultExclCheckbox(document.getElementById(this.id.substring(0,indexLoc) + 'Test[]'),tmpResult, document.getElementById(this.id.substring(0,indexLoc) + 'TestDt'),document.getElementById(this.id.substring(0,indexLoc) + 'TestDtTitle'));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,indexLoc) + 'TestDt',errMsg,errCount);
						}
	
						errMsg =  Ext.util.validateTestResult(document.getElementById(this.id.substring(0,indexLoc) + 'Test[]'),tmpResult, resultArr, lowerArr, upperArr,  document.getElementById(this.id.substring(0,indexLoc) + 'TestDt'),document.getElementById(this.id.substring(0,indexLoc) + 'TestResultTitle'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,indexLoc) + 'TestResult',errMsg,errCount);
						errMsg =  Ext.util.validateTestResultExclCheckbox1( document.getElementById(this.id.substring(0,indexLoc) + 'Test[]'),tmpResult, document.getElementById(this.id.substring(0,indexLoc) + 'TestDt'),document.getElementById(this.id.substring(0,indexLoc) + 'Test[]Title'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,indexLoc) + 'Test[]',errMsg,errCount);				
											
					});

					errMsg =  Ext.util.validateTestResultExclCheckbox1( document.getElementById(key1 + 'Test[]'),tmpResult, document.getElementById(key1 + 'TestDt'),document.getElementById(key1 + 'Test[]Title'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,key1 + 'Test[]',errMsg,errCount);			
				}
				else if(suffix1 == "rmal[]")
				{
					(Ext.get(rowResult[i].id)).on('click', function(){
						var indexLoc = this.id.indexOf('Test');
						var tmpResult = Ext.util.extractLabTestResultElements(result[this.id.substring(0,indexLoc)]);
						errMsg =  Ext.util.validateTestResultExclCheckbox2( document.getElementById(this.id.substring(0,indexLoc) + 'TestAbnormal[]'),tmpResult, document.getElementById(this.id.substring(0,indexLoc) + 'TestDt'),document.getElementById(this.id.substring(0,indexLoc) + 'TestAbnormal[]Title'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,indexLoc) + 'TestAbnormal[]',errMsg,errCount);				
					
					});
					errMsg =  Ext.util.validateTestResultExclCheckbox2( document.getElementById(key1 + 'TestAbnormal[]'),tmpResult, document.getElementById(key1 + 'TestDt'),document.getElementById(key1 + 'TestAbnormal[]Title'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,key1 + 'TestAbnormal[]',errMsg,errCount);				
			
				}
			}

			errMsg =  Ext.util.validateTestResult(document.getElementById(key1 + 'Test[]'),tmpResult, resultArr, lowerArr, upperArr,  document.getElementById(key1 + 'TestDt'),document.getElementById(key1 + 'TestResultTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,key1 + 'TestResult',errMsg,errCount);
		}
		
	}

	var tftFormat1 = new Ext.form.TextField({
		fieldLabel: '',
		validationEvent: false,
		allowBlank:true
	});
	tftFormat1.applyToMarkup(document.mainForm.formAuthor);
	var tftFormat2 = new Ext.form.TextField({
		fieldLabel: '',
		validationEvent: false,
		allowBlank:true
	});
	tftFormat2.applyToMarkup(document.mainForm.formAuthor2);
	var taFormat1 = new Ext.form.TextArea({
		fieldLabel: '',
		validationEvent: false,
		allowBlank:true
	});
	taFormat1.applyToMarkup(document.mainForm.encComments);



	var loc = -1;

	
	if(sexFlg == '2')
	{
		for(var x = 0; x < disableElements.length; x++)
		{
			disableElements[x].disabled = true;
		}
		if(document.mainForm.frottisvaginalTestRemarks != null)
			document.mainForm.frottisvaginalTestRemarks.disabled = true;
		if(document.mainForm.papTestTestRemarks!=null)
			document.mainForm.papTestTestRemarks.disabled = true;
	}
	
//	Ext.util.clickRadio(document.mainForm);
});
	
