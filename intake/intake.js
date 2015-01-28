window.onload = init;

function init(){
	var sex = Ext.getDom('sex1').value;
	handlePreg(sex);
	/**
	if(Ext.getDom('encounterType') && (Ext.getDom('encounterType').value == '16' || Ext.getDom('encounterType').value == '17')){
		handleNos('arvEver', 'pedARVever', 'radio');
		handleNos('pedMedAllergN', 'pedMedAllergy', 'radio');
		handleNos('pedMedAllergU', 'pedMedAllergy', 'radio');
		handleNos('pedImmVaccN', 'pedImmVacc', 'radio');
		handleNos('pedImmVaccU', 'pedImmVacc', 'radio');
	} else {
		handleNos('noDiagnosis', 'conditions', 'checkbox');
		handleNos('noneTreatments', 'medAllergy', 'checkbox');
		handleNos('arvN', 'arvPrevious', 'radio');
		handleNos('pregYesNo2', 'preg', 'radio');
		handleNos('pregYesNo3', 'preg', 'radio');
	}
	if(sex == 2){
		handleNos('placeHolder', 'femOnly', 'none');
	} 
	*/
}		

function handlePreg(sex){
	if(Ext.getDom('ARVex1') && Ext.getDom('ARVex2') && Ext.getDom('ARVex3')){
		var ex1 = Ext.getDom('ARVex1'); var ex2 = Ext.getDom('ARVex2');
		var ex3 = Ext.getDom('ARVex3');
		var arv1 = Ext.getDom('zidovudineARVpreg'); 
		var arv2 = Ext.getDom('nevirapineARVpreg');
		var arv3 = Ext.getDom('unknownARVpreg');
		var arv4 = Ext.getDom('otherARVpreg');
		if(sex == 2){
			ex1.disabled = true;  ex2.disabled = true;  ex3.disabled = true;
		}
		if(ex2.checked == true || ex3.checked == true || sex == 2){
			arv1.disabled = true; arv2.disabled = true;
			arv3.disabled = true; arv4.disabled = true;
		} else if(ex1.checked == true){
			arv1.disabled = false; arv2.disabled = false;
			arv3.disabled = false; arv4.disabled = false;
		}
	}
	if(Ext.getDom('pregnant1') && Ext.getDom('pregnant2') && Ext.getDom('pregnant3')){
		var p1 = Ext.getDom('pregnant1'); var p2 = Ext.getDom('pregnant2');
		var p3 = Ext.getDom('pregnant3');
		var pre1 = Ext.getDom('pregnantPrenatal1');
		var pre2 = Ext.getDom('pregnantPrenatal2');
		if(p2.checked == true || p3.checked == true || p1.checked == false){
			pre1.disabled = true; pre2.disabled = true;
		} else if(p1.checked == true){
			pre1.disabled = false; pre2.disabled = false;
		} else {
			pre1.disabled = true; pre2.disabled = true;
		}
	}
	if(Ext.getDom('pregYesNo1')){
		var p1 = Ext.getDom('pregYesNo1'); var p2 = Ext.getDom('pregYesNo2');
		var p3 = Ext.getDom('pregYesNo3'); var lmp = Ext.getDom('pregnantLmpDt');
		var pre1 = Ext.getDom('prenat1'); var pre2 = Ext.getDom('prenat2');
		var first = Ext.getDom('pregnantPrenatalFirstDt');
		var last = Ext.getDom('pregnantPrenatalLastDt');
		if(p1.checked == true){
			lmp.disabled = false; pre1.disabled = false; pre2.disabled = false;
			first.disabled = false; last.disabled = false;
		} else {
			lmp.disabled = true; pre1.disabled = true; pre2.disabled = true;
			first.disabled = true; last.disabled = true;
		}
	}
	if(Ext.getDom('pedMensesY')){
		var pm1 = Ext.getDom('pedMensesY'); var pm2 = Ext.getDom('pedMensesN');
		var pm3 = Ext.getDom('pedMensesU');
		if(pm2.checked == true || pm3.checked == true){
			pm1.className = ''; pm2.className = ''; pm3.className = '';
			handleNos('placeHolder', 'femOnly', 'none');
		} else if(pm1.checked == true){
			handleNos('revert', 'femOnly', 'none');
		}
		var pPreg1 = Ext.getDom('pedPreg1'); var pPreg2 = Ext.getDom('pedPreg2');
		var pPreg3 = Ext.getDom('pedPreg3'); var pPren1 = Ext.getDom('pedPrenat1');
		var pPren2 = Ext.getDom('pedPrenat2'); var pPren3 = Ext.getDom('pedPrenat3');
		var pDt1 = Ext.getDom('pregnantPrenatalFirstDt'); 
		var pDt2 = Ext.getDom('pregnantPrenatalLastDt');
		if(pPreg1.checked == true){
			pPren1.disabled = false; pPren2.disabled = false; pPren3.disabled = false;
			pDt1.disabled = false; pDt2.disabled = false;
		} else if (pPreg2.checked == true || pPreg3.checked == true){
			pPren1.disabled = true; pPren2.disabled = true; pPren3.disabled = true;
			pDt1.disabled = true; pDt2.disabled = true;
		}
		var pap1 = Ext.getDom('pap1'); var pap2 = Ext.getDom('pap2');
		var pap3 = Ext.getDom('pap3'); var papN = Ext.getDom('papN');
		var papA = Ext.getDom('papA'); var papDt = Ext.getDom('papTestDt');
		if(pap1.checked == true){
			papN.disabled = false; papA.disabled = false; papDt.disabled = false;
		} else if(pap2.checked == true || pap3.checked == true){
			papN.disabled = true; papA.disabled = true; papDt.disabled = true;
		}
	}
}
/**
function handleNos(trigger, class_name, input_type){
	var txtArr = Ext.util.getElementsByType(document.mainForm,"text");
	var chkArr = Ext.util.getElementsByType(document.mainForm, "checkbox");
	var radArr = Ext.util.getElementsByType(document.mainForm, "radio");
	var yes_no = 'x';
	if(input_type == 'radio')
		yes_no = trigger.charAt(trigger.length -1);
	if(trigger == 'arvEver' || trigger == 'pregYesNo2' || trigger == 'placeHolder')
		yes_no = 'N';
	if(trigger == 'pregYesNo1')
		yes_no = 'Y';
	if(trigger == 'pregYesNo3')
		yes_no = 'U';
	if(trigger == 'revert')
		yes_no = 'Y';
	for(i=0;i<txtArr.length;i++){
		var _class = txtArr[i].className.substr(0, class_name.length);
		if( _class == class_name){
			if(trigger == 'revert'){
				txtArr[i].disabled = false;
			}else if(trigger == 'placeHolder' ||(Ext.getDom(trigger) != null && Ext.getDom(trigger).checked == true)){
				if(yes_no == 'N' || yes_no == 'U' || input_type != 'radio'){
					txtArr[i].disabled = true;
				} else {
					txtArr[i].disabled = false;
				}				
			} else {
				txtArr[i].disabled = false;
			}
		}
	}
	for(i=0;i<chkArr.length; i++){
		var _class = chkArr[i].className.substr(0, class_name.length);
		if( _class == class_name){
			if(trigger == 'revert'){
				chkArr[i].disabled = false;
			} else if(trigger == 'placeHolder' || (Ext.getDom(trigger) != null && Ext.getDom(trigger).checked == true)){
				if(yes_no == 'N' || yes_no == 'U' || input_type != 'radio'){
					chkArr[i].disabled = true;
				} else {
					chkArr[i].disabled = false;
				}
			}	else{
				chkArr[i].disabled = false;
			}
		}
	}
	for(i=0;i<radArr.length; i++){
		var _class = radArr[i].className.substr(0, class_name.length);
		if( _class == class_name){
			if(trigger == 'revert'){
				radArr[i].disabled = false;
			} else if(trigger == 'placeHolder' || (Ext.getDom(trigger) != null && Ext.getDom(trigger).checked == true)){
				if(yes_no == 'N' || yes_no == 'U' || input_type != 'radio'){
					radArr[i].disabled = true;
				} else {
					radArr[i].disabled = false;
				}
			}	else{
				radArr[i].disabled = false;
			}
		}
	}
}
*/