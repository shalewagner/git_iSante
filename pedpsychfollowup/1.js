Ext.onReady(function(){

	BddyAIDSTrainCmpltDate = new Ext.form.TextField({
		fieldLabel: '',
		name: 'BddyAIDSTrainCmpltDate',
		maskRe : /[\d\./xX]/,
                validationEvent: false,
                allowBlank:true
        });
	BddyAIDSTrainCmpltDate.applyToMarkup(document.mainForm.BddyAIDSTrainCmpltDate);

	BddyInfoUnderstandingText = new Ext.form.TextField({
		fieldLabel: '',
		name: 'BddyInfoUnderstandingText',
                validationEvent: false,
                allowBlank:true
        });
	BddyInfoUnderstandingText.applyToMarkup(document.mainForm.BddyInfoUnderstandingText);


	Ext.get('BddyInfoUnderstanding').on('blur', function(){
		errMsg = Ext.util.checkRadioCorresponding(document.getElementById('BddyInfoUnderstanding'), 
document.getElementById('BddyInfoUnderstandingText'),document.getElementById('BddyInfoUnderstandingTextTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg,errCount);
	});


	Ext.get('BddyAIDSTrainCmplt1').on('blur', function(){
		errMsg = Ext.util.checkRadioCorresponding(document.getElementById('BddyAIDSTrainCmplt1'), document.getElementById('BddyAIDSTrainCmpltDate'),document.getElementById('BddyAIDSTrainCmpltDateTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg,errCount);
	});
	

	BddyAIDSTrainCmpltDate.on('blur', function(){
		me = document.getElementById('BddyAIDSTrainCmpltDate');
		errMsg = Ext.util.validateDateField(me, document.getElementById(me.id +  "Title"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,me.id.substring(0,me.id.length-2),errMsg,errCount);
		//errMsg = Ext.util.checkRadioCorresponding(document.getElementById('BddyAIDSTrainCmplt1'), document.getElementById('BddyAIDSTrainCmpltDate'),document.getElementById('BddyAIDSTrainCmpltDateTitle'));
		//errCount = Ext.util.showErrorHead(errFields,errMsgs,me.id.substring(0,me.id.length-2),errMsg,errCount);


	});

	BddyChng1 = new Ext.form.TextField({
		fieldLabel: '',
		name: 'BddyChng1',
		maskRe : /[\d\./xX]/,
                validationEvent: false,
                allowBlank:true
        });
	BddyChng1.applyToMarkup(document.mainForm.BddyChng1);


/*	BddyEducation = new Ext.form.Radio({
		fieldLabel: '',
		name: 'BddyEducation',
                validationEvent: false,
                allowBlank:true
        });
	BddyEducation.applyToMarkup(document.mainForm.BddyEducation1);
	BddyEducation.applyToMarkup(document.mainForm.BddyEducation2);
	BddyEducation.applyToMarkup(document.mainForm.BddyEducation3);
	BddyEducation.applyToMarkup(document.mainForm.BddyEducation4);


	BddyGender = new Ext.form.RadioGroup({
		fieldLabel: '',
		name: 'BddyGender',
                validationEvent: false,
                allowBlank:true
        });
	BddyGender.applyToMarkup(document.mainForm.BddyGender);
*/


	ptRcvdRefAndSrvcsReason = new Ext.form.TextField({
		fieldLabel: '',
		name: 'ptRcvdRefAndSrvcsReason',
		maskRe : /[a-z1-9\.?!]/,
                validationEvent: false,
                allowBlank:true
        });
	ptRcvdRefAndSrvcsReason.applyToMarkup(document.mainForm.ptRcvdRefAndSrvcsReason);

/*	ptRcvdRefAndSrvcsNo = new Ext.form.Radio({
		name: 'ptRcvdRefAndSrvcsNo',
		allowBlank: true
	});
	ptRcvdRefAndSrvcsNo.applyToMarkup(document.mainForm.ptRcvdRefAndSrvcsNo);
*/
	Ext.get('ptRcvdRefAndSrvcsReason').on('blur', function(){
		errMsg = Ext.util.checkRadioTextCorresponding(document.getElementById('ptRcvdRefAndSrvcsNo'), document.getElementById('ptRcvdRefAndSrvcsReason'),document.getElementById('ptRcvdRefAndSrvcsTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg,errCount);
	});

/*	Ext.get('ptRcvdRefAndSrvcsNo').on('blur', function(){
		errMsg = Ext.util.checkRadioTextCorresponding(document.getElementById('ptRcvdRefAndSrvcsNo'), document.getElementById('ptRcvdRefAndSrvcsReason'),document.getElementById('ptRcvdRefAndSrvcsTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg,errCount);

	});
*/
});


	
