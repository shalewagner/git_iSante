function chkDate() {
  visitDate = document.forms[0].visitDateMm.value + '/' + document.forms[0].visitDateDd.value + '/' + document.forms[0].visitDateYy.value
  if (visitDate == '//') {
  	alert('Veuillez saisir une date valide de visite.')
	document.forms[0].visitDateDd.focus()  	
  } else {
  	/*
  	url = 'execProc.php?proc=sp_chkVisitDate&visitDate=' + visitDate
	onYearObject.open('GET', url, true)
	onYearObject.onreadystatechange = handleHttpResponse
	onYearObject.send(null)
	*/
	dd = document.forms[0].visitDateDd.value;
	mm = document.forms[0].visitDateMm.value;
	yy = document.forms[0].visitDateYy.value;
	if ((dd < 1 || dd > 31) || (mm == 2 && dd > 29)) {
		alert ('Day no good') ;
		document.forms[0].visitDateDd.focus();
	}
	else if (mm < 1 || mm > 12) {
		alert ('Month no good');
		document.forms[0].visitDateMm.focus();
	}
	if (yy > 7) {
		alert ('Year no good');
		document.forms[0].visitDateYy.focus();
	}
  }
}

function isNumeric(sText) {
   var ValidChars = "0123456789.";
   var IsNumber=true;
   var Char;
   if (sText == '' || sText == 'null')
     return false;
   for (i = 0; i < sText.length && IsNumber == true; i++) { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) {
         IsNumber = false;
      }
   }
   return IsNumber;
}

function ckDob() {
  dobDd = document.forms[0].dobDd.value
  dobMm = document.forms[0].dobMm.value
  dobYy = document.forms[0].dobYy.value
  ageYears = document.forms[0].ageYears.value
  visitYy = document.forms[0].visitDateYy.value
  if ( (dobYy == '' || dobYy.toLowerCase() == 'xx' || dobYy == 'null') && (isNumeric(ageYears) && isNumeric(visitYy)) ){
  	if(eval(ageYears) < 10)
      document.forms[0].dobYy.value = '0' + eval((100 + eval(visitYy) - eval(ageYears))%100);
      else 
      	document.forms[0].dobYy.value = eval(100 + eval(visitYy) - eval(ageYears))
      }
  if ( (dobDd == '' || dobDd.toLowerCase() == 'xx' || dobDd == 'null') && 
       (isNumeric(ageYears) && isNumeric(visitYy)) )
      document.forms[0].dobDd.value = 'XX';
  if ( (dobMm == '' || dobMm.toLowerCase() == 'xx' || dobMm == 'null') && 
       (isNumeric(ageYears) && isNumeric(visitYy)) )
      document.forms[0].dobMm.value = 'XX';
}