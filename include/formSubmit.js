var errFields = new Array();
var errMsgs = new Array();
var errCount = 0;

function checkValuesM(code, errMsg){
	document.getElementById('pregnantLmpDd').value='';
	document.getElementById('pregnantLmpMm').value='';
	document.getElementById('pregnantLmpYy').value='';
	document.getElementById('pregnantPrenatalFirstDd').value='';
	document.getElementById('pregnantPrenatalFirstMm').value='';
	document.getElementById('pregnantPrenatalFirstYy').value='';
	document.getElementById('pregnantPrenatalLastDd').value='';
	document.getElementById('pregnantPrenatalLastMm').value='';
	document.getElementById('pregnantPrenatalLastYy').value='';
	combineValues(code, errMsg);
}
function combineValues (code, errMsg) { 
   //assures fill out option is selected in save
    if (code == null) {
	fillOutOption = -1;
	for (i=document.forms['mainForm'].elements['errorOverride'].length-1; i > -1; i--) {
	  if (document.forms['mainForm'].elements['errorOverride'][i].checked) {
		fillOutOption = i;
		break;
	  }
	}
	if (fillOutOption == -1) {
	  return false;
	}
	
    }
    var i;
    if(document.getElementById('errorSave')){
    	var errFlg = 0;
    	for(i = 0; i < errMsgs.length; i++)
    	{
    		if(errMsgs[i] != '' && errMsgs[i] != undefined)
    		{
    			errFlg = 1;
    			break;

    		}
    	}
    	document.getElementById('errorSave').value = errFlg;

    } 
    for(i=0;i<errFields.length;i++)
    {

    	if(errFields[i] == 'vDate')
    	{
    		if(errMsgs[i]!='')
    		{
    			alert(errors[errMsgs[i]]);
				document.mainForm.vDate.focus();
    			return false;
    		}
    	}
    }
    if(document.mainForm.vDate.value.trim().length == 0 || document.mainForm.vDate.value == '//' )
    {
        alert(errors["77"]);
		document.mainForm.vDate.focus(true);
        return false;
    }  
    /*** removing this validation since we now have identifiers for primary care and obgyn
     *** TODO we may want to add in a check to make sure at least one of these is filled in, but I'm not going to do that now 12/12/2010 shw
    if(document.mainForm.clinicPatientID.value.trim().length == 0)
    {
		var foo = errors["43"];
		if (foo.indexOf("clinique") > 0) foo = "L'identification de clinique ne devrait pas \352tre vide!";
		alert (foo);
    	return false;
    }*/
    if(document.mainForm.fname.value.trim().length == 0 && document.mainForm.lname.value.trim().length == 0)
    {
        alert(errors["70"]);
        return false;
    }
    document.forms['mainForm'].submit ();

}

function showErrors (errors) {
  var errColor = '#DD3344';
  var errFields = errors.split (';');

  for (i in errFields) {
    if (errFields[i] == '') continue;
    if (document.getElementsById && document.getElementById(errFields[i])) document.getElementById(errFields[i]).style.backgroundColor = errColor;
  }
}

function openValidationWindow (lang, type, field) {
  window.open ('adminValidation.php?lang=' + escape (lang) + '&type=' + escape (type) + '&field=' + escape (field), '', 'fullscreen=no,toolbar=no,status=no,menubar=no,scrollbars=yes,resizable=yes,directories=no,location=no,width=650,height=600');
}
function bugPopUp (sub, lang, user) {
        stuff = 'width=600,height=500,toolbar=no,location=no,directories=no,scrollbars=yes,menubar=no,resizable=yes';
        var url = 'bugWindow.php?username=' + user + '&subject=' + sub + '&lang=' + lang;
        currWindow = window.open(url, 'BugWindow', stuff);
}

Ext.onReady(function(){
    
    extDate = new Ext.form.DateField({
	fieldLabel: '',
	maskRe : /[\d\/]/,
	name: 'vDate',
	width:100,
	validationEvent: false,
	allowBlank:true
    });
    
  
    extDate.applyToMarkup (document.mainForm.vDate); 
    //extDate.applyToMarkup (document.getElementById('vDate'));
    var errMsg = "";
    var dateVal = document.mainForm.vDate.value;
    var compRegDtFlag = false;
    if(dateVal.length > 5)
    {
	errMsg = Ext.util.chkDate(dateVal,"");	
	if(document.mainForm.registVisitDt != null && errMsg == '' )
	{
		errMsg = Ext.util.compareRegistVisitDt(document.mainForm.vDate,  document.mainForm.registVisitDt, document.getElementById('vDateTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'vDateTemp',errMsg,errCount);
		compRegDtFlag = true;
	}
    }

    if(!compRegDtFlag)
    {
    	Ext.util.showErrorIcon(errMsg, document.getElementById('vDateTitle'));
    	errCount = Ext.util.showErrorHead(errFields,errMsgs,"vDate",errMsg,errCount);
    }

    Ext.util.splitDate(document.mainForm.vDate,document.mainForm.visitDateDd,document.mainForm.visitDateMm,document.mainForm.visitDateYy);
    Ext.get('vDate').on('blur', function(){
		var errMsg = "";
		var dateVal = document.mainForm.vDate.value;
		if(dateVal.length == 0 || dateVal.value == '//' )
		{

			errMsg = 77;
		}
		else
		{
			errMsg = Ext.util.chkDate(dateVal,"");	
		}
		
		Ext.util.showErrorIcon(errMsg, document.getElementById('vDateTitle'));

		errCount = Ext.util.showErrorHead(errFields,errMsgs,"vDate",errMsg,errCount);

		Ext.util.splitDate(document.mainForm.vDate,document.mainForm.visitDateDd,document.mainForm.visitDateMm,document.mainForm.visitDateYy);			
		if(document.mainForm.registVisitDt != null && errMsg == '' )
		{
			errMsg = Ext.util.compareRegistVisitDt(document.mainForm.vDate,  document.mainForm.registVisitDt, document.getElementById('vDateTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,'vDateTemp',errMsg,errCount);
		}
		var nextVisitDt = document.getElementById('nxtVisitD2');
		if(nextVisitDt != null)
		{		
			errMsg = Ext.util.validateNextVisitDt(nextVisitDt, document.mainForm.vDate , document.getElementById('eid'),document.getElementById('nxtVisitD2Title'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,"nxtVisitD2",errMsg,errCount);			
		}
		
	});
	
}); 
