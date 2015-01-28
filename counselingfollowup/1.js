Ext.onReady(function(){

	BddyAIDSTrainCmpltDate = new Ext.form.TextField({
		fieldLabel: '',
		name: 'BddyAIDSTrainCmpltDate',
		maskRe : /[\d\./xX]/,
                validationEvent: false,
                allowBlank:true
        });
	BddyAIDSTrainCmpltDate.applyToMarkup(document.mainForm.BddyAIDSTrainCmpltDate);



	Ext.get('BddyAIDSTrainCmplt1').on('blur', function(){
		errMsg = Ext.util.checkRadioCorresponding(document.getElementById('BddyAIDSTrainCmplt1'), document.getElementById('BddyAIDSTrainCmpltDate'),document.getElementById('BddyAIDSTrainCmpltDateTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg,errCount);
	});
	

	BddyAIDSTrainCmpltDate.on('blur', function(){
		me = document.getElementById('BddyAIDSTrainCmpltDate');
		errMsg = Ext.util.validateDateField(me, document.getElementById(me.id +  "Title"),'');
		errCount = Ext.util.showErrorHead(errFields,errMsgs,me.id.substring(0,me.id.length-2),errMsg,errCount);

	});


	ptRcvdRefAndSrvcsReason = new Ext.form.TextField({
		fieldLabel: '',
		name: 'ptRcvdRefAndSrvcsReason',
		maskRe : /[a-z1-9\.?!]/,
                validationEvent: false,
                allowBlank:true
        });
	ptRcvdRefAndSrvcsReason.applyToMarkup(document.mainForm.ptRcvdRefAndSrvcsReason);

	ptRcvdRefAndSrvcsNo = new Ext.form.Radio({
		name: 'ptRcvdRefAndSrvcsNo',
		allowBlank: true
	});
	ptRcvdRefAndSrvcsNo.applyToMarkup(document.mainForm.ptRcvdRefAndSrvcsNo);

	Ext.get('ptRcvdRefAndSrvcsReason').on('blur', function(){
		errMsg = Ext.util.checkRadioTextCorresponding(document.getElementById('ptRcvdRefAndSrvcsNo'), document.getElementById('ptRcvdRefAndSrvcsReason'),document.getElementById('ptRcvdRefAndSrvcsTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg,errCount);
	});

	Ext.get('ptRcvdRefAndSrvcsNo').on('blur', function(){
		errMsg = Ext.util.checkRadioTextCorresponding(document.getElementById('ptRcvdRefAndSrvcsNo'), document.getElementById('ptRcvdRefAndSrvcsReason'),document.getElementById('ptRcvdRefAndSrvcsTitle'));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg,errCount);

	});



	var dateFields = new Array("BddyAIDSTrainCompltDate", "ptMissedCinicVisitDate", "ptMissOtherAptsDate", "NextPsychAppt");

        for(var i = 0; i < dateFields.length; i++){
             var tmpStr = dateFields[i];

             Thing = new Ext.form.TextField({
                     fieldLabel: '',
                     name: tmpStr,
                     maskRe: /[\d\/]/,
                     validationEvent: false,
                     allowBlank: true
             });
             var tmpThing = document.getElementsByName(tmpStr)[0];
             Thing.applyToMarkup(tmpThing);


        }




});


	
