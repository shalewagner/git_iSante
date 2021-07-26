Ext.onReady(function() {
  //Date.useStrict = true;
  var names = new Array();
  var allElements = Ext.util.getAllElements(document.mainForm,names);
  var txtArr = allElements["text"];
  var txtFormat = new Array();
  var dobDtFormat;
  var root;
  var suffix;
  for(i=0;i<txtArr.length;i++)
  {	
  	txtFormat[i] = new Ext.form.TextField({
  		fieldLabel: '',
  		validationEvent: false,
  		allowBlank:true
  	});
  	txtFormat[i].applyToMarkup(txtArr[i]);
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

  var dobDtStyle = document.getElementById('dobDt').value;
  if ( dobDtStyle.match(/x/i) || dobDtStyle.match(/^\/{1,2}[0-9]/i) ) {
    dobDtFormat = new Ext.form.TextArea({
      fieldLabel: '',
      width: 100, // Added to fix bug dateField width in Firefox/IE
      maskRe : /[\Xx{1,4}\d{1,2}\/]/,
      allowBlank:true
    });
  } else {
    dobDtFormat = new Ext.form.DateField({
      fieldLabel: '',
      format: 'd/m/Y',
      altFormat: 'j/n/Y',
      width: 100, // Added to fix bug dateField width in Firefox/IE
      maskRe: /[Xx\d/]/,
      validationEvent: false,
      allowBlank:true
    });
  }
  dobDtFormat.applyToMarkup(document.mainForm.dobDt);  

  var deathDtStyle = document.getElementById('deathDt').value;
  if ( deathDtStyle.match(/x/i) || deathDtStyle.match(/^\/{1,2}[0-9]/i) ) {
    deathDtFormat = new Ext.form.TextArea({
      fieldLabel: '',
      width: 100, // Added to fix bug dateField width in Firefox/IE
      maskRe : /[\Xx{1,4}\d{1,2}\/]/,
      allowBlank:true
    });
  } else {
    deathDtFormat = new Ext.form.DateField({
      fieldLabel: '',
      format: 'd/m/Y',
      altFormat: 'j/n/Y',
      width: 100, // Added to fix bug dateField width in Firefox/IE
      maskRe: /[Xx\d/]/,
      validationEvent: false,
      allowBlank:true
    });
  }
  deathDtFormat.applyToMarkup(document.mainForm.deathDt);

  
  Ext.get('dobDt').on('blur', function(){	  
  	errMsg =  Ext.util.checkDobDt(document.getElementById('dobDt'),'XX',document.getElementById('dobDtTitle'));
  	Ext.util.splitDate(document.getElementById('dobDt'),document.getElementById('dobDd'),document.getElementById('dobMm'),document.getElementById('dobYy'));
  	errCount = Ext.util.showErrorHead(errFields,errMsgs,'DobDt',errMsg,errCount);
  if(document.getElementById('dobDt').value.length==0&&document.getElementById('ageYears').value.length==0)
  {
	  errMsg=93;
	  errCount= Ext.util.showErrorHead(errFields,errMsgs,'DobDt',errMsg,errCount); 
  }
  });
  errMsg =  Ext.util.checkDobDt(document.getElementById('dobDt'),'XX', document.getElementById('dobDtTitle'));
  Ext.util.splitDate(document.getElementById('dobDt'),document.getElementById('dobDd'),document.getElementById('dobMm'),document.getElementById('dobYy'));
  errCount = Ext.util.showErrorHead(errFields,errMsgs,'DobDt',errMsg,errCount);
  
  Ext.get('deathDt').on('blur', function(){
  	errMsg =  Ext.util.checkDobDt(document.getElementById('deathDt'),'XX',document.getElementById('deathDtTitle'));
  	//Ext.util.splitDate(document.getElementById('deathDt'),document.getElementById('dobDd'),document.getElementById('dobMm'),document.getElementById('dobYy'));
  	errCount = Ext.util.showErrorHead(errFields,errMsgs,'deathDt',errMsg,errCount);
  });
  errMsg =  Ext.util.checkDobDt(document.getElementById('deathDt'),'XX', document.getElementById('deathDtTitle'));
  //Ext.util.splitDate(document.getElementById('dobDt'),document.getElementById('dobDd'),document.getElementById('dobMm'),document.getElementById('dobYy'));
  errCount = Ext.util.showErrorHead(errFields,errMsgs,'DobDt',errMsg,errCount);
  
  //Ext.util.setDefaultRadio(document.getElementsByName('sex[]'), 2);
  Ext.util.setDefaultRadio(document.getElementsByName('maritalStatus[]'), 5);
  
  Ext.get('ageYears').on('blur', function(){
  	errMsg = Ext.util.validateAge(document.mainForm.ageYears,document.getElementById("ageYearsTitle"),'');
  	errCount = Ext.util.showErrorHead(errFields,errMsgs,'ageYears',errMsg,errCount);	
 
 if(document.getElementById('dobDt').value.length==0&&document.getElementById('ageYears').value.length==0)
  {
	  errMsg=93;
	  errCount= Ext.util.showErrorHead(errFields,errMsgs,'DobDt',errMsg,errCount);
  }  
  });
  errMsg = Ext.util.validateAge(document.mainForm.ageYears,document.getElementById("ageYearsTitle"),'');
  errCount = Ext.util.showErrorHead(errFields,errMsgs,'ageYears',errMsg,errCount);
  
  Ext.get('vDate').on('blur', function(){
  	errMsg = Ext.util.checkFName(document.getElementById('fname'),document.getElementById('fnameTitle'),'');
  	errCount = Ext.util.showErrorHead(errFields,errMsgs,'fname',errMsg,errCount);
  	errMsg = Ext.util.checkLName(document.getElementById('lname'),document.getElementById("lnameTitle"),'');
  	errCount = Ext.util.showErrorHead(errFields,errMsgs,'lname',errMsg,errCount);
  	//errMsg = Ext.util.checkClinicId(document.getElementById('clinicPatientID'),document.getElementById("clinicPatientIDTitle"),'');
  	//errCount = Ext.util.showErrorHead(errFields,errMsgs,'clinicPatientID',errMsg,errCount);	
  	errMsg = Ext.util.checkNationalId(document.getElementById('nationalID'),document.getElementById("nationalIDTitle"),'');
  	errCount = Ext.util.showErrorHead(errFields,errMsgs,'nationalID',errMsg,errCount);
    errMsg = Ext.util.checkSex(document.getElementsByName('sex[]'),document.getElementById("sexTitle"),'');
  	errCount = Ext.util.showErrorHead(errFields,errMsgs,'sexTitle',errMsg,errCount);

  if(document.getElementById('dobDt').value.length==0&&document.getElementById('ageYears').value.length==0)
  {
	  errMsg=93;
	  errCount= Ext.util.showErrorHead(errFields,errMsgs,'DobDt',errMsg,errCount);
  }
	
  });
  Ext.get('nationalID').on('blur', function(){
  	errMsg = Ext.util.checkNationalId(document.getElementById('nationalID'),document.getElementById("nationalIDTitle"),'');
  	errCount = Ext.util.showErrorHead(errFields,errMsgs,'nationalID',errMsg,errCount);	
  });
  /*Ext.get('clinicPatientID').on('blur', function(){
  	errMsg = Ext.util.checkClinicId(document.getElementById('clinicPatientID'),document.getElementById("clinicPatientIDTitle"),'');
  	errCount = Ext.util.showErrorHead(errFields,errMsgs,'clinicPatientID',errMsg,errCount);	
  }); zohyishahm*/
   
  if(document.getElementById('dobDt').value.length==0&&document.getElementById('ageYears').value.length==0)
  {
	  errMsg=93;
	  errCount= Ext.util.showErrorHead(errFields,errMsgs,'DobDt',errMsg,errCount);
  } 
   
  if(document.getElementById('sexF').checked==false)
  {
  errMsg = Ext.util.checkSex(document.getElementsByName('sex[]'),document.getElementById("sexTitle"),'');
  errCount = Ext.util.showErrorHead(errFields,errMsgs,'sexTitle',errMsg,errCount);
  }
  
  Ext.get('sexF').on('blur', function(){	  
  	errMsg = Ext.util.checkSex(document.getElementsByName('sex[]'),document.getElementById("sexTitle"),'');
  	errCount = Ext.util.showErrorHead(errFields,errMsgs,'sexTitle',errMsg,errCount);	

  });
  
  if(document.getElementById('sexH').checked==false)
  {
  errMsg = Ext.util.checkSex(document.getElementsByName('sex[]'),document.getElementById("sexTitle"),'');
  errCount = Ext.util.showErrorHead(errFields,errMsgs,'sexTitle',errMsg,errCount);
  }
  
  Ext.get('sexH').on('blur', function(){	  
  	errMsg = Ext.util.checkSex(document.getElementsByName('sex[]'),document.getElementById("sexTitle"),'');
  	errCount = Ext.util.showErrorHead(errFields,errMsgs,'sexTitle',errMsg,errCount);	

  });
  
  if(document.getElementById('sexI').checked==false)
  {
  errMsg = Ext.util.checkSex(document.getElementsByName('sex[]'),document.getElementById("sexTitle"),'');
  errCount = Ext.util.showErrorHead(errFields,errMsgs,'sexTitle',errMsg,errCount);
  }
  
  Ext.get('sexI').on('blur', function(){	  
  	errMsg = Ext.util.checkSex(document.getElementsByName('sex[]'),document.getElementById("sexTitle"),'');
  	errCount = Ext.util.showErrorHead(errFields,errMsgs,'sexTitle',errMsg,errCount);	

  });
 /* end of radio group */ 
  Ext.get('fname').on('blur', function(){
  	errMsg = Ext.util.checkFName(document.getElementById('fname'),document.getElementById('fnameTitle'),'');
  	errCount = Ext.util.showErrorHead(errFields,errMsgs,'fname',errMsg,errCount);
  });
  
  Ext.get('lname').on('blur', function(){
  	errMsg = Ext.util.checkLName(document.getElementById('lname'),document.getElementById("lnameTitle"),'');
  	errCount = Ext.util.showErrorHead(errFields,errMsgs,'lname',errMsg,errCount);	
  });
  
  if(document.getElementById('vDate').value!='')
  {
  	errMsg = Ext.util.checkFName(document.getElementById('fname'),document.getElementById('fnameTitle'),'');
  	errCount = Ext.util.showErrorHead(errFields,errMsgs,'fname',errMsg,errCount);
  	errMsg = Ext.util.checkLName(document.getElementById('lname'),document.getElementById("lnameTitle"),'');
  	errCount = Ext.util.showErrorHead(errFields,errMsgs,'lname',errMsg,errCount);
  	//errMsg = Ext.util.checkClinicId(document.getElementById('clinicPatientID'),document.getElementById("clinicPatientIDTitle"),'');
  	//errCount = Ext.util.showErrorHead(errFields,errMsgs,'clinicPatientID',errMsg,errCount);	
  	errMsg = Ext.util.checkNationalId(document.getElementById('nationalID'),document.getElementById("nationalIDTitle"),'');
  	errCount = Ext.util.showErrorHead(errFields,errMsgs,'nationalID',errMsg,errCount);	
	
	errMsg = Ext.util.checkSex(document.getElementsByName('sex[]'),document.getElementById("sexTitle"),'');
  	errCount = Ext.util.showErrorHead(errFields,errMsgs,'sexTitle',errMsg,errCount);
  	
  if(document.getElementById('dobDt').value.length==0&&document.getElementById('ageYears').value.length==0)
  {
	  errMsg=93;	  
	  errCount= Ext.util.showErrorHead(errFields,errMsgs,'DobDt',errMsg,errCount);
  }
  
  }
  //Allow multi-seletion of radios
  var tempRadioArr = allElements["radio"]; 
  var radioArr = Ext.util.getAllRadios(tempRadioArr);
});


