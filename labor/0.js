
//This is shared between all form versions.

//global list of all current errors
var laborErrorRegistry = {};

//store a list of which fields have errors that prevent the form from being saved
var criticalErrorFields = {};

//Hijack the save buttons onClick event.
//This is done to prevent submission of impropperly formated dates which can not be saved. 
var oldFormSaveButtonOnClick;

function newFormSaveButtonOnClick() {
    var datesHaveErrors = false;
    for (i in criticalErrorFields) {
	datesHaveErrors = datesHaveErrors | criticalErrorFields[i];
    }

    if (datesHaveErrors) {
	alert(errors[15]);
	return false;
    }

    oldFormSaveButtonOnClick();
}

function formatAsTimeField(baseName, blankOk, shouldSubmit) {
    var timeForamt = new Ext.form.TimeField({
	    fieldLabel : '',
	    increment : 5,
	    format : 'H:i',
	    maskRe : /[\d]/,
	    validationEvent : false,
	    allowBlank : blankOk,
	    blankText : '',
	    submitValue : shouldSubmit,
	    applyTo : baseName
	});
}

Ext.onReady(function() {
	var formSaveButton = document.getElementById('formSaveButton');
	oldFormSaveButtonOnClick = formSaveButton.onclick;
	formSaveButton.onclick = newFormSaveButtonOnClick;

	var names = new Array();
	var allElements = Ext.util.getAllElements(document.mainForm, names);
	var txtArr = allElements["text"];
	var txtFormat = new Array();
	for (i=0; i<txtArr.length; i++) {
	    txtFormat[i] = new Ext.form.TextField({
		    fieldLabel: '',
		    validationEvent: false,
		    allowBlank: true
		});
	    txtFormat[i].applyToMarkup(txtArr[i]);
	}

	var root;
	var suffix;

	var taArr = Ext.util.getElementsByType(document.mainForm, "textarea");
	var taFormat;
	for (i=0; i<taArr.length; i++) {
	    taFormat= new Ext.form.TextArea({
		    fieldLabel: '',
		    validationEvent: false,
		    allowBlank:true
		});
	    taFormat.applyToMarkup(taArr[i]);
	}

        var tempRadioArr = allElements["radio"];
        var radioArr = Ext.util.getAllRadios(tempRadioArr);

	var onsetText = new Ext.form.TextField({
		maskRe : /[:\d]/,
		fieldLabel : '',
		validationEvent : false,
		allowBlank : true,
		applyTo : 'laborOnset'
	    });
	
});

function attachEventTo(fieldName, event, action) {
    var field = document.getElementById(fieldName);
    var oldEvent = field[event];
    field[event] = function() {
	if (oldEvent != undefined) {
	     oldEvent();
	}
	action();
    }
    action();
}

function checkNumberRange(number, min, max) {
    if (!isNaN(number)) {
	if (number >= min && number <= max) {
	    return true;
	}
    }

    return false;
}

function makeTestOneIsChecked() {
    var checks = [];
    
    for (var i = 0; i < arguments.length; i++) {
	checks[i] = document.getElementById(arguments[i]);
    }

    return function() {
	for (var i = 0; i < checks.length; i++) {
	    if (checks[i].checked) {
		return true;
	    }
	}
	return false;
    };
}

function makeTestAnyNotBlank() {
    var textareas = [];

    for (var i = 0; i < arguments.length; i++) {
	textareas[i] = document.getElementById(arguments[i]);
    }

    return function() {
	for (var i = 0; i < textareas.length; i++) {
	    if (textareas[i].value != '') {
		return true;
	    }
	}
	return false;
    };
}

function setFieldError(baseName, error, value) {
    if (laborErrorRegistry[baseName] == undefined) {
	laborErrorRegistry[baseName] = {};
    }

    laborErrorRegistry[baseName][error] = value;
}

function reportFieldErrors(baseName) {
    if (laborErrorRegistry[baseName] != undefined) {
	showErrorIcons(baseName);
	for (var i in laborErrorRegistry[baseName]) {
	    if (laborErrorRegistry[baseName][i] == true) {
		errCount = Ext.util.showErrorHead(errFields, errMsgs, baseName, i, errCount);
		return;
	    }
	}
	errCount = Ext.util.showErrorHead(errFields, errMsgs, baseName, '', errCount);
    }    
}

function makeXorErrorValidation(baseName, error, checkFunctionOne, checkFunctionTwo) {
    var field = document.getElementById(baseName);
    var errorWidget = document.getElementById(baseName + 'ErrorWidget');

    var checkXor = function() {
	setFieldError(baseName, error, false);

	var checkOne = checkFunctionOne();
	var checkTwo = checkFunctionTwo();

	if ( (!checkOne && checkTwo)
	     || (checkOne && !checkTwo) ) {
	    setFieldError(baseName, error, true);
	}
	
	reportFieldErrors(baseName);
    };

    return checkXor;
}

function makeDateNotFutureValidation(baseName) {
    var field = document.getElementById(baseName);
    var errorWidget = document.getElementById(baseName + 'ErrorWidget');

    var dateCheck = function() {
	setFieldError(baseName, 17, false);
	
	var value = field.value;
	
	if (value != '') {
	    var date = Date.parseDate(value, 'Y-m-d H:i:s');
	    var now = new Date();
	    if (date != undefined) {
		if (date > now) {
		    setFieldError(baseName, 17, true);
		}
	    }
	}

	reportFieldErrors(baseName);
    };

    return dateCheck;
}

function makeNumericRangeValidation(baseName, min, max, error) {
    var field = document.getElementById(baseName);
    var errorWidget = document.getElementById(baseName + 'ErrorWidget');
    
    var checkRange = function() {
	setFieldError(baseName, error, false);

	var value = field.value;

	if (value != '') {
	    if (!checkNumberRange(value, min, max)) {
		setFieldError(baseName, error, true);
	    }
	}
	
	reportFieldErrors(baseName);
    };

    return checkRange;
}

function makeTempRangeValidation(baseName, c_radioName, f_radioName) {
    var field = document.getElementById(baseName);
    var errorWidget = document.getElementById(baseName + 'ErrorWidget');
    var c_radio = document.getElementById(c_radioName);
    var f_radio = document.getElementById(f_radioName);
    
    var checkRange = function() {
	var unitError = 74;
	var value = field.value;
	var min, max;
	var unitSelected = false;
	var celRangeError = 83;
	var farRangeError = 29;
	var rangeError;

	setFieldError(baseName, unitError, false);
	setFieldError(baseName, celRangeError, false);
	setFieldError(baseName, farRangeError, false);
	
	if (c_radio.checked) {
	    min = 32;
	    max = 43;
	    unitSelected = true;
	    rangeError = celRangeError;
	} else if (f_radio.checked) {
	    min = 89.6;
	    max = 109.4;
	    unitSelected = true;
	    rangeError = farRangeError;
	}
	    
	if (value != '' && unitSelected) {
	    if (!checkNumberRange(value, min, max)) {
		setFieldError(baseName, rangeError, true);
	    }
	}
	
	if ( (value != '' && !unitSelected)
	     || (value == '' && unitSelected) ) { //xor where are you???
	    setFieldError(baseName, unitError, true);
	}

	reportFieldErrors(baseName);
    };

    return checkRange;
}

function laborEnableDateField(baseName) {
    var dateFormat = new Ext.form.DateField({
	    fieldLabel : '',
	    format : 'd/m/Y',
	    maskRe : /[\d\/]/,
	    validationEvent : false,
	    allowBlank : true,
	    submitValue : false,
	    applyTo : baseName + 'Date'
	});

    formatAsTimeField(baseName + 'Time', false, false);
    
    var dateCheckFunction = function() {
	var invalidDateMsg = 15;
	setFieldError(baseName, invalidDateMsg, false);

	var dateString = Ext.get(baseName + 'Date').getValue();
	var timeString = Ext.get(baseName + 'Time').getValue();

	var date = Date.parseDate(dateString, 'd/m/Y');
	if (date == null) {
	    date = Date.parseDate(dateString, 'd/m/y');
	}

	if ( (date == null && dateString != '')
	     || timeString == '' ) {
	    setFieldError(baseName, invalidDateMsg, true);
	    criticalErrorFields[baseName] = true;
	} else {
	    criticalErrorFields[baseName] = false;
	}

	if (!criticalErrorFields[baseName] && dateString != '') {
	    document.getElementById(baseName).value = date.format('Y-m-d') + ' ' + timeString + ':00';
	} else {
	    document.getElementById(baseName).value = '';
	}
	
	reportFieldErrors(baseName);
    };

    attachEventTo(baseName + 'Date', 'onblur', dateCheckFunction);
    attachEventTo(baseName + 'Time', 'onblur', dateCheckFunction);
}

function showErrorIcons(baseName) {
    var errorSpan = document.getElementById(baseName + 'ErrorWidget');

    if (errorSpan != null) {
	if (laborErrorRegistry[baseName] != undefined) {
	    var newHtml = '';
	    for (var i in laborErrorRegistry[baseName]) {
		if (laborErrorRegistry[baseName][i] == true) {
		    newHtml = newHtml + '<span title="' + errors[i] + '"><img src="images/exclamation.gif"></span>';
		}
	    }
	    errorSpan.innerHTML = newHtml;
	}
    }
}

