

Ext.onReady(function(){

	var namesForDates = new Array();

	namesForDates.push("NextPsychAppt");

	for(var i = 1; i <= 10; i++){
		var tmpStr = 'householdAge' + i;
		namesForDates.push(tmpStr);
	}

	for(var i = 0; i < namesForDates.length; i++){
		var tmpStr = namesForDates[i];

		Thing = new Ext.form.TextField({
			fieldLabel: '',
			name: tmpStr,
			maskRe: /[\d\./]/,
			validationEvent: false,
			allowBlank: true

		});
		var tmpThing = document.getElementsByName(tmpStr)[0];
		Thing.applyToMarkup(tmpThing);


	}



	

/*        BddyAIDSTrainCmpltDate = new Ext.form.TextField({
                fieldLabel: '',
                name: 'BddyAIDSTrainCmpltDate',
                maskRe : /[\d\./xX]/,
                validationEvent: false,
                allowBlank:true
        });
        BddyAIDSTrainCmpltDate.applyToMarkup(document.mainForm.BddyAIDSTrainCmpltDate);
*/


});
