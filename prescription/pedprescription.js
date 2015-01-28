Ext.onReady(function() {
	var i;
	var suffix;
	var names = new Array();
	var allElements = Ext.util.getAllElements(document.mainForm,names);
	var txtArr = allElements["text"];
	var txtFormat;
	var tempRadioArr = allElements["radio"]; 
	var radioArr = Ext.util.getAllRadios(tempRadioArr);
	var root;
	var tfFormat;
	for(i=0;i<txtArr.length;i++)
	{	
		suffix = txtArr[i].id.substring(txtArr[i].id.length-10);


		if(suffix == 'DispDateDt')
		{
			prefix = txtArr[i].id.substring(0,5);

			root = txtArr[i].id.substring(0,txtArr[i].id.length-10);
			tfFormat = new Ext.form.DateField({
				fieldLabel: '',
				maskRe : /[\d{1,2}\/]/,
				validationEvent: false,
				allowBlank:true
			});
			tfFormat.applyToMarkup(txtArr[i]);
			(Ext.get(txtArr[i].id)).on('blur', function(){
				var rootins = this.id.substring(0,this.id.length-10);
				var rootDate =this.id.substring(0,this.id.length -2);
				var thisElt = document.getElementById(this.id);
			
				errMsg =  Ext.util.validateRxDispDate(document.getElementById(this.id),document.getElementById(this.id + 'Title'),'');
				Ext.util.splitDate(thisElt,document.getElementById(rootDate+ "Dd"),document.getElementById(rootDate + "Mm"),document.getElementById(rootDate+ "Yy"));	 
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
				if(errMsg == '')
				{
					errMsg = Ext.util.validateRxDispensed2(document.getElementById(rootins + 'Dispensed'), thisElt,document.getElementById(this.id + 'Title'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);	
				}
				errMsg = Ext.util.validateRxDispensed3(document.getElementById(rootins + 'Dispensed'), thisElt,document.getElementById(rootins + 'DispensedTitle'));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,rootins+ 'Dispensed',errMsg,errCount);	
			});


			Ext.get(txtArr[i].id.substring(0,txtArr[i].id.length-10) + 'DispAltNumDaysSpecify').on('blur', function(){
					errMsg = Ext.util.isValueInBound(document.getElementById(this.id),document.getElementById(this.id + 'Title'), '1','','');
					errCount = Ext.util.showErrorHead(errFields, errMsgs, this.id, errMsg, errCount);
			});
			errMsg = Ext.util.isValueInBound(document.getElementById(root + 'DispAltNumDaysSpecify'),document.getElementById(root + 'DispAltNumDaysSpecifyTitle'), '1','','');
			errCount = Ext.util.showErrorHead(errFields, errMsgs, root +'DispAltNumDaysSpecify' , errMsg, errCount);

			(Ext.get(txtArr[i].id.substring(0,txtArr[i].id.length-10) + 'DispAltNumPills')).on('blur', function(){
					errMsg = Ext.util.isValueInBound(document.getElementById(this.id),document.getElementById(this.id + 'Title'), '1','','');
				errCount = Ext.util.showErrorHead(errFields, errMsgs, this.id, errMsg, errCount);	
			});
			errMsg = Ext.util.isValueInBound(document.getElementById(root + 'DispAltNumPills'),document.getElementById(root + 'DispAltNumPillsTitle'), '1','','');
				errCount = Ext.util.showErrorHead(errFields, errMsgs, root + 'DispAltNumPills', errMsg, errCount);	
		    
			(Ext.get(txtArr[i].id.substring(0,txtArr[i].id.length-10) + 'Dispensed')).on('click', function(){
				errMsg =  Ext.util.validateRxDispDate(document.getElementById(this.id.substring(0,this.id.length-9)+'DispDateDt'),document.getElementById(this.id.substring(0,this.id.length-9)+'DispDateDtTitle'),'');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9)+'DispDateDt',errMsg,errCount);
				if(errMsg == '')
				{
					errMsg = Ext.util.validateRxDispensed2(document.getElementById(this.id), document.getElementById(this.id.substring(0,this.id.length-9)+'DispDateDt'),document.getElementById(this.id.substring(0,this.id.length-9)+ 'DispDateDtTitle'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9)+'DispDateDt',errMsg,errCount);
				}
				errMsg = Ext.util.validateRxDispensed3(document.getElementById(this.id), document.getElementById(this.id.substring(0,this.id.length-9)+'DispDateDt'),document.getElementById(this.id + 'Title'));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);	
			});
			errMsg = Ext.util.validateRxDispDate(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id + 'Title'),'');
			Ext.util.splitDate(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Dd"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Mm"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Yy"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id,errMsg,errCount);
			if(errMsg == '')
			{
				errMsg = Ext.util.validateRxDispensed2(document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-10) + 'Dispensed'), document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id + 'Title'));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-10) + 'Dispensed',errMsg,errCount);				 
	  		}
			errMsg = Ext.util.validateRxDispensed3(document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-10) + 'Dispensed'), document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-10) + 'DispDateDt'),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-10) + 'DispensedTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-10) + 'Dispensed',errMsg,errCount);				 	


			var suffixArr = new Array(2);
			suffixArr[0] = 'PedDosageSpecify';
			suffixArr[1] = 'NumDaysDesc';
			for(var f = 0; f < suffixArr.length;f++){
				Ext.get(root + suffixArr[f]).on('blur', function(){
					var rootIns;
					if(this.id.substring(this.id.length -4) == "Desc"){
						rootIns = this.id.substring(0, this.id.length - 11);
					}
					else{
						rootIns = this.id.substring(0, this.id.length - 16);
					}
					
					errMsg = Ext.util.validateRxDosageNumDays(document.getElementById(rootIns + suffixArr[0]),document.getElementById(rootIns + suffixArr[1]),document.getElementById(rootIns + suffixArr[0] + 'Title'),document.getElementById(rootIns + suffixArr[1] + 'Title'));

					errCount = Ext.util.showErrorHead(errFields,errMsgs,rootIns+suffixArr[0],errMsg,errCount);
					errCount = Ext.util.showErrorHead(errFields,errMsgs,rootIns+suffixArr[1],errMsg,errCount);
				});
			}			
		  } 
		  else if(suffix == 'tartDateDt')
		  {
			tfFormat = new Ext.form.DateField({
				fieldLabel: '',
				maskRe : /[\d{1,2}\/]/,
				validationEvent: false,
				allowBlank:true
			});
			tfFormat.applyToMarkup(txtArr[i]);
			(Ext.get(txtArr[i].id)).on('blur', function(){
				errMsg =  Ext.util.validateRxDispDate(document.getElementById(this.id),document.getElementById(this.id + 'Title'),'');
				Ext.util.splitDate(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-2) + "Dd"),document.getElementById(this.id.substring(0,this.id.length-2) + "Mm"),document.getElementById(this.id.substring(0,this.id.length-2) + "Yy"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
			});
			errMsg = Ext.util.validateRxDispDate(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id + 'Title'),'');
			Ext.util.splitDate(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Dd"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Mm"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Yy"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id,errMsg,errCount);

		  }

		  else
		  {
			txtFormat = new Ext.form.TextField({
				fieldLabel: '',
				validationEvent: false,
				allowBlank:true
			});
			txtFormat.applyToMarkup(txtArr[i]);	
			//if(suffix == 'umDaysDesc' || suffix == 'ageSpecify' || suffix == 'aysSpecify' )
			if(suffix == 'umDaysDesc'  )
			{
				(Ext.get(txtArr[i].id)).on('blur', function(){
					errMsg =  Ext.util.isValueInBound(document.getElementById(this.id), document.getElementById(this.id + 'Title'),'0', '', '');
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
				});	
				errMsg =  Ext.util.isValueInBound(document.getElementById(txtArr[i].id), document.getElementById(txtArr[i].id + 'Title'),'0', '', '');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id,errMsg,errCount);		
			}
		 }
		
	}
	var arvStartDateDtFmt =new Ext.form.DateField({
		fieldLabel: '',
		maskRe : /[\d{1,2}\/]/,
		validationEvent: false,
		allowBlank:true
	});
	arvStartDateDtFmt.applyToMarkup('arvStartDate');
	arvStartDateDtFmt.applyToMarkup('arvStartDate');
	(Ext.get('arvStartDate')).on('blur', function(){
				Ext.util.splitDate(document.getElementById('arvStartDate'),document.getElementById('arvStartDateDd'),document.getElementById('arvStartDateMm'),document.getElementById('arvStartDateYy'));
  });
	Ext.util.splitDate(document.getElementById('arvStartDate'),document.getElementById('arvStartDateDd'),document.getElementById('arvStartDateMm'),document.getElementById('arvStartDateYy'));
	
	var startedArv = document.getElementById('startedArv1');
  
	Ext.util.disableAssoDt(startedArv,arvStartDateDtFmt,document.mainForm.arvStartDateDt,radioArr,true);
	for(var i=0;i<2;i++)
	{
		Ext.get('startedArv' + i).on('click', function(){
			Ext.util.disableAssoDt(document.getElementById('startedArv1'),arvStartDateDtFmt,document.mainForm.arvStartDateDt,radioArr,true);
		});		
	}
	var otherRootArr = new Array(3);
	var otherSuffixArr = new Array(3);
	otherRootArr[0] = 'other1';
	otherRootArr[1] = 'other2';
	otherRootArr[2] = 'other3';
	otherSuffixArr[0] = 'RxText';
	otherSuffixArr[1] = 'PedDosageSpecify';
	otherSuffixArr[2] = 'NumDaysDesc';
  	var j;
	for(i = 0; i < otherRootArr.length; i++)
	{
		for(j = 0; j < otherSuffixArr.length; j++)
		{
			Ext.get(otherRootArr[i] + otherSuffixArr[j]).on('blur', function(){
				var key1 = Ext.util.getKeyByVal(otherRootArr, this.id.substring(0,6));
				errMsg = Ext.util.validateRxOther(document.getElementById(otherRootArr[key1]+otherSuffixArr[0]),document.getElementById(otherRootArr[key1]+otherSuffixArr[1]),document.getElementById(otherRootArr[key1]+otherSuffixArr[2]),document.getElementById(otherRootArr[key1]+otherSuffixArr[0]+'Title'),document.getElementById(otherRootArr[key1]+otherSuffixArr[1]+'Title'),document.getElementById(otherRootArr[key1]+otherSuffixArr[2]+'Title'));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,otherRootArr[key1]+otherSuffixArr[0],errMsg,errCount);
				errCount = Ext.util.showErrorHead(errFields,errMsgs,otherRootArr[key1]+otherSuffixArr[1],errMsg,errCount);
				errCount = Ext.util.showErrorHead(errFields,errMsgs,otherRootArr[key1]+otherSuffixArr[2],errMsg,errCount);
			});
			errMsg = Ext.util.validateRxOther(document.getElementById(otherRootArr[i]+otherSuffixArr[0]),document.getElementById(otherRootArr[i]+otherSuffixArr[1]),document.getElementById(otherRootArr[i]+otherSuffixArr[2]),document.getElementById(otherRootArr[i]+otherSuffixArr[0]+'Title'),document.getElementById(otherRootArr[i]+otherSuffixArr[1]+'Title'),document.getElementById(otherRootArr[i]+otherSuffixArr[2]+'Title'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,otherRootArr[i] + otherSuffixArr[j],errMsg,errCount);
		}
		
	}


	var taArr = allElements["textarea"];
	var taFormat= new Ext.form.TextArea({
		fieldLabel: '',
		validationEvent: false,
		allowBlank:true
	});
	for(i=0;i<taArr.length;i++)
	{

		taFormat.applyToMarkup(taArr[i]);
		
	}
	Ext.get('nxtVisitD2').on('blur', function(){
		errMsg = Ext.util.validateNextPickupDt(document.getElementById('nxtVisitD2'), document.mainForm.vDate , document.getElementById('eid'),document.getElementById('nxtVisitD2Title'));
		Ext.util.splitDate(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-2) + "Dd"),document.getElementById(this.id.substring(0,this.id.length-2) + "Mm"),document.getElementById(this.id.substring(0,this.id.length-2) + "Yy"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'nxtVisitD2',errMsg,errCount);

	});
	errMsg = Ext.util.validateNextPickupDt(document.getElementById('nxtVisitD2'), document.mainForm.vDate , document.getElementById('eid'),document.getElementById('nxtVisitD2Title'));
	Ext.util.splitDate(document.getElementById('nxtVisitD2'),document.getElementById('nxtVisitDd'),document.getElementById('nxtVisitMm'),document.getElementById('nxtVisitYy'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'nxtVisitD2',errMsg,errCount);
	
});
