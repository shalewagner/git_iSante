Ext.onReady(function(){


	//this section applies masks to DOM elements, restricting what can be entered as input

	var dateFields = new Array("NextPsychAppt");

	applyMarkupLoop(dateFields, "/\d-/");

	var namesForDates = new Array();
        namesForDates.push("NextPsychAppt");
        for(var i = 1; i <= 10; i++){
                var tmpStr = 'householdAge' + i;
                namesForDates.push(tmpStr);
        }
	
	applyMarkupLoop(namesForDates, "/\d\./");





//Ext.util.checkRadioTextCorresponding = function(_radioEl, _textEl,  _errLoc)
/*	var rad = document.getElementsByName('SexAgresVictim[]')[0];
	var textPlace = document.getElementsByName("SexAgresVictimText")[0];
	var titleEl = document.getElementById("SexAgresVictimTitle");
	var rad2 = document.getElementsByName('SexAgresVictim[]')[1];
*/

	var rad = getName("SexAgresVictim[]",0);
	var textPlace = getName("SexAgresVictimText",0);
	var titleEl = getID("SexAgresVictimTitle");
	var rad2 = getName("SexAgresVictim[]",1);

	radioValidation(rad, rad, textPlace, titleEl);
	radioValidation(rad2, rad, textPlace, titleEl);
	radioValidation(textPlace, rad, textPlace, titleEl);

	rad = getName("PtBddyRelation[]", 5);
 	textPlace = getName("PtBddyRelationOther",0);
	titleEl = getID("PtBddyRelationTitle");
	rad1 = getName("PtBddyRelation[]", 1);
	rad2 = getName("PtBddyRelation[]", 2);
	var rad3 = getName("PtBddyRelation[]", 3);
	var rad4 = getName("PtBddyRelation[]", 4);
	var rad0 = getName("PtBddyRelation[]", 0);
	radioValidation(rad, rad, textPlace, titleEl);
	radioValidation(rad0, rad, textPlace, titleEl);
	radioValidation(rad1, rad, textPlace, titleEl);
	radioValidation(rad2, rad, textPlace, titleEl);
	radioValidation(rad4, rad, textPlace, titleEl);
	radioValidation(rad3, rad, textPlace, titleEl);
	radioValidation(textPlace, rad, textPlace, titleEl);

	rad = getName("PtTestRecall[]", 0);
	rad2 = getName("PtTestRecall[]", 1);
	textPlace = getName("PtTestActual",0);
	titleEl = getID("PtTestRecallTitle");

	radioValidation(rad, rad, textPlace, titleEl);
	radioValidation(rad2, rad, textPlace, titleEl);
	radioValidation(textPlace, rad, textPlace, titleEl);

	rad = getName("BddyCar[]", 0);
	rad2 = getName("BddyCar[]", 1);
	textPlace = getName("BddyCarType",0);
	titleEl= getID("BddyCarTitle");

	radioValidation(rad, rad, textPlace, titleEl);
	radioValidation(rad2, rad, textPlace, titleEl);
	radioValidation(textPlace, rad, textPlace, titleEl);

	function getID(idstring){
		return document.getElementById(idstring);
	}
	function getName(namestring,num){
		return document.getElementsByName(namestring)[num];
	}


	
	function radioValidation(ele, radio, textField, titleElement){
		ele.onblur = function(){
			errMsg = Ext.util.checkRadioTextCorresponding(radio,textField,titleElement);		
			errCount = Ext.util.showErrorHead(errFields,errMsgs, radio, errMsg, errCount);
		}
	}





	function applyMarkupLoop(arr, mask){

	        for(var i = 0; i < arr.length; i++){
	                var tmpStr = arr[i];
	
	                Thing = new Ext.form.TextField({
	                        fieldLabel: '',
	                        name: tmpStr,
	                        maskRe: mask,
	                        validationEvent: false,
	                        allowBlank: true
	
	                });
	                var tmpThing = document.getElementsByName(tmpStr)[0];
	                Thing.applyToMarkup(tmpThing);
	        }
	}


});


	
