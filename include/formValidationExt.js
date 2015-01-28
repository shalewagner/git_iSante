
/* These functions are the public interface for creating Ext form validations and getting info about the state of validation errors. */

/* There is a bunch of stuff at the bottom of this file that overrides the way validations for Ext radios and checkboxes are displayed. */

//buildValidation set an error on each Ext component involved in a test if the test fails
//errorId: An id for an error message from include/errorMessages.php
//test: A test created from one of the makeTest* functions. If this test fails all components in the test will be flagged with errorId.
function buildValidation(errorId, test) {
    buildTestAction(test,
		    function(componentId, passed) {
			ComponentErrors.set(componentId, errorId, !passed);
			
			var errorIds = ComponentErrors.getById(componentId);
			if (errorIds.length == 0) {
			    Ext.getCmp(componentId).clearInvalid();
			} else {
			    Ext.getCmp(componentId).markInvalid(errors[errorIds[0]]);
			}
		    });
}

//This acts as a registry for all current form error codes. Current errors can be retrieved by component id or name. They can be set by component id only.
var ComponentErrors = (function() {
	var __errorRegistry = {};

	return {
	    //Returns an array of all errorIds that are currently associated with a particular Ext component id.
	    getById: function(componentId) {
		if (__errorRegistry[componentId] == undefined) {
		    return [];
		} else {
		    var errorIds = [];
		    for (var i in __errorRegistry[componentId]) {
			if (__errorRegistry[componentId][i] == true) {
			    errorIds.push(i);
			}
		    }
		    return errorIds;
		}
	    },
		
	    //Returns an array of all unique errorIds that are currently associated with a particular Ext component id.
	    getByName: function(componentName) {
		var errorHash = {};
		for (var id in __errorRegistry) {
		    var component = Ext.getCmp(id);
		    if (component.name == componentName) {
			for (var i in __errorRegistry[id]) {
			    if (__errorRegistry[id][i] == true) {
				errorHash[i] = 1;
			    }
			}
		    }
		}
		var errorIds = [];
		for (var i in errorHash) {
		    errorIds.push(i);
		}
		return errorIds;
	    },
		
	    //Set/unset an error for a particular Ext component.
	    //value: Is true/false. True means the error is currently applies.
	    set: function(componentId, errorId, value) {
		if (__errorRegistry[componentId] == undefined) {
		    __errorRegistry[componentId] = {};
		}
		__errorRegistry[componentId][errorId] = value;
	    }
	}
})();


/* These fuctions are the public interface for creating generic tests that can be run on Ext components and for creating actions to be executed after testing. */

/* 
A test is an object with the following two properties.
testFunction: A boolean returning function to be executed when testing. This function takes no parameters.
testComponentIds: A list of all Ext component Ids that are involved in this test. 
*/

//Takes a test as input and returns a new test that's testFunction returns !testFunction() of the original.
function makeTestNot(test) {
    return {
	testFunction: function() {
	    return !test.testFunction();
	},
	testComponentIds: test.testComponentIds
    };
}

//Creates a new test that checks the value of componentId and fails if it is a date later then today.
function makeTestDateNotFuture(componentId) {
    return {
	testFunction: function() {
	    var value = Ext.getCmp(componentId).getValue();
	    var date = Date.parseDate(value, 'Y-m-d');
	    var now = new Date();
	    if (date != undefined) {
                if (date > now) {
		    return false;
                }
            }
	    return true;
	},
	testComponentIds: [componentId]
    };
}

//Creates a new test that checks the value of componentId and fails if it is a number < min or > max.
function makeTestInNumericRange(componentId, min, max) {
    return {
	testFunction: function() {
	    var value = Ext.getCmp(componentId).getRawValue();
	    if (value != '' && !isNaN(value)) {
		if (value < min || value > max) {
		    return false;
		}
	    }
	    return true;
	},
	testComponentIds: [componentId]
    };
}

//Takes an arbitrary number of check/radio component Ids as input. Passes if any of the input components is checked.
function makeTestAnyIsChecked() {
    var componentIds = [];
    for (var i = 0; i < arguments.length; i++) {
        componentIds[i] = arguments[i];
    }

    return {
	testFunction: function() {
	    for (var i = 0; i < componentIds.length; i++) {
		var check = Ext.getCmp(componentIds[i]);
		if (check.getValue()) {
		    return true;
		}
	    }
	    return false;
	},
	testComponentIds: componentIds
    };
}

//Takes an arbitrary number of text component Ids as input. Passes if any of the input components is not blank.
function makeTestAnyNotBlank() {
    var componentIds = [];
    for (var i = 0; i < arguments.length; i++) {
        componentIds[i] = arguments[i];
    }

    return {
	testFunction: function() {
	    for (var i = 0; i < componentIds.length; i++) {
		var textBox = Ext.getCmp(componentIds[i]);
		if (textBox.getRawValue() != '') {
		    return true;
		}
	    }
	    return false;
	},
	testComponentIds: componentIds
    };
}

//Takes two tests as input. If the first test is true then the second test must also be true otherwise false. If the first test is false then true. 
//The only time this returns false is if the first test is true and the second is false.
function makeTestIfThen(ifTest, thenTest) {
    var allTestComponentIds = ifTest.testComponentIds.concat(thenTest.testComponentIds);

    return {
	testFunction: function() {
	    if (ifTest.testFunction() && !thenTest.testFunction()) {
		return false;
	    }
	    return true;
	},
	testComponentIds: allTestComponentIds
    };
}

//Takes an arbitrary number of tests as input. Creates a new test that passes only if all input tests pass or if all input tests fail. Useful for mutually exclusive type relationships.
function makeTestAllOrNone() {
    var testFunctions = [];
    var allTestComponentIds = [];
    for (var i = 0; i < arguments.length; i++) {
        testFunctions[i] = arguments[i].testFunction;
	allTestComponentIds = allTestComponentIds.concat(arguments[i].testComponentIds);
    }

    return {
	testFunction: function() {
	    var passCount = 0;
	    var failCount = 0;
	    for (var i = 0; i < testFunctions.length; i++) {
		if (testFunctions[i]()) {
		    passCount = passCount + 1;
		} else {
		    failCount = failCount + 1;
		}
	    }
	    if (passCount == 0 || failCount == 0) {
		return true;
	    } else {
		return false;
	    }
	},
	testComponentIds: allTestComponentIds
    };
}

//Takes an arbitrary number of tests as input. Creates a new test that passes if any input test passes.
function makeTestOr() {
    var testFunctions = [];
    var allTestComponentIds = [];
    for (var i = 0; i < arguments.length; i++) {
        testFunctions[i] = arguments[i].testFunction;
	allTestComponentIds = allTestComponentIds.concat(arguments[i].testComponentIds);
    }

    return {
	testFunction: function() {
	    for (var i = 0; i < testFunctions.length; i++) {
		if (testFunctions[i]()) {
		    return true;
		}
	    }
	    return false;
	},
	testComponentIds: allTestComponentIds
    };
}

//Takes a test as input. Assigns events to each Ext component involved in that test. The events fire when the contents of the component change and after all the components are rendered on the page. The events execute the test and for each component execute action.
//test: is a test created from one of the makeTest* functions.
//action: Is a function that takes two parameters. The first is the component id of an Ext component involved in the test and the second is the result of the test.
function buildTestAction(test, action) {
    //This is what gets executed during the event.
    var eventFunction = function() {
	var testComponentIds = test.testComponentIds;
	var passed = test.testFunction();
	for (var i = 0; i < testComponentIds.length; i++) {
	    action(testComponentIds[i], passed);
	}	    
    };

    //Add the event to each component involved in the test so that the test will be executed when something changes.
    for (var i = 0; i < test.testComponentIds.length; i++) {
	var addValidationEventTo = function(thing) {
	    var events = new Object();
	    events['blur'] = {
		fn: eventFunction,
		delay: 200
	    };
	    switch(thing.xtype) {
	    case 'radio':
	    case 'checkbox':
		events['check'] = {
		    fn: eventFunction,
		    delay: 200
		};
		break;
	    }
	    thing.on(events);
	};

	var component = Ext.getCmp(test.testComponentIds[i]);
	if (typeof component === 'undefined') {
	    //If Ext hasn't created the component yet then tell it what to do when it does.
	    Ext.ComponentMgr.onAvailable(test.testComponentIds[i], function() {
		    addValidationEventTo(this);
		});
	} else {
	    addValidationEventTo(component);
	}
    }

    //Execute the event once after all the components have become available.
    var allAreAvailable = function() {
	for (var i = 0; i < test.testComponentIds.length; i++) {
	    var component = Ext.getCmp(test.testComponentIds[i]);
	    if (typeof component === 'undefined') {
		return false;
	    }
	}
	return true;
    };

    //Execute the event as soon as all involved components become available. This will insure any state information is correct as soon as the form is loaded. (For example, the error registry for from validations)
    if (allAreAvailable()) {
	//Everything is available so just run the event.
	eventFunction();
    } else {
	//Every time a component becomes available check to see if they are all available. When they are run the event. 
	for (var i = 0; i < test.testComponentIds.length; i++) {
	    Ext.ComponentMgr.onAvailable(test.testComponentIds[i], function() {
		    if (allAreAvailable()) {
			eventFunction();
		    }
		});
	}	
    }

    //Execute the event as soon as all involved components are rendered. This will insure that any visual state is correct after the components are rendered.
    for (var i = 0; i < test.testComponentIds.length; i++) {
	Ext.ComponentMgr.onAvailable(test.testComponentIds[i], function() {
		this.on({
			afterrender: {
			    fn: function () {
				if (allAreAvailable()) {
				    eventFunction();
				}
			    },
			    single: true
			}
		    });
	    });
    }
}


//Enable quick tips for all component types.
Ext.QuickTips.init();

//Change the way errors are displayed for radios and checkboxes.
//Most of this was copied and modified from the testField versions of these functions.
var __radioCheckFunctions = {
    markInvalid: function(msg) {
	if (this.rendered && !this.preventMark) {
	    msg = msg || this.invalidText;
	    
	    var element = this.el.parent();
	    element.addClass(this.invalidClass);
	    element.dom.qtip = msg;
	    element.dom.qclass = 'x-form-invalid-tip';
	    if(Ext.QuickTips){ // fix for floating editors interacting with DND
		Ext.QuickTips.enable();
	    }
	}
	
	this.setActiveError(msg);
    },
    clearInvalid: function() {
	if (this.rendered && !this.preventMark) {
	    this.el.removeClass(this.invalidClass);
	    var element = this.el.parent();
	    element.removeClass(this.invalidClass);
	    element.dom.qtip = '';
	}
	this.unsetActiveError();
    }
};

Ext.override(Ext.form.Radio, __radioCheckFunctions);
Ext.override(Ext.form.Checkbox, __radioCheckFunctions);
