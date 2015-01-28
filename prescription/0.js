Ext.onReady(function() {
	var i;
	var suffix;
	var names = new Array();
	var allElements = Ext.util.getAllElements(document.mainForm,names);
	var txtArr = allElements["text"];
	var txtFormat = new Array();
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
				errMsg = Ext.util.validateRxDispAltDosageSpecify1(document.getElementById(this.id.substring(0,this.id.length-10)+ 'Dispensed'),document.getElementById(this.id.substring(0,this.id.length-10) + 'DispAltDosageSpecify'),document.getElementById(this.id.substring(0,this.id.length-10) + 'DispAltNumDaysSpecify'), document.getElementById(this.id.substring(0,this.id.length-10) + 'DispensedTitle'));	
			 	errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-10)+ 'Dispensed',errMsg,errCount);
 				if(errMsg == '')
 				{
 					errMsg =  Ext.util.validateRxDispensed1(document.getElementById(this.id.substring(0,this.id.length-10)+ 'Dispensed'),document.getElementById(this.id.substring(0,this.id.length-10) + 'StdDosage'),document.getElementById(this.id.substring(0,this.id.length-10) + 'AltDosageSpecify'), document.getElementById(this.id.substring(0,this.id.length-10) + 'DispensedTitle'));
			 		errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-10)+ 'Dispensed',errMsg,errCount);
			 		if(errMsg == '')
			 		{
			 			errMsg = Ext.util.validateRxDispensed3(document.getElementById(this.id.substring(0,this.id.length-10)+ 'Dispensed'),document.getElementById(this.id), document.getElementById(this.id.substring(0,this.id.length-10)+'DispensedTitle'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-10)+ 'Dispensed',errMsg,errCount);	
			 		}
			 		
 				}
 				errMsg =  Ext.util.validateRxDispDate(document.getElementById(this.id),document.getElementById(this.id + 'Title'),'');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);		
				Ext.util.splitDate(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-2) + "Dd"),document.getElementById(this.id.substring(0,this.id.length-2) + "Mm"),document.getElementById(this.id.substring(0,this.id.length-2) + "Yy"));
				if(errMsg == '')
				{
	 				errMsg = Ext.util.validateRxDispAltDosageSpecify2(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-10) + 'DispAltDosageSpecify'),document.getElementById(this.id.substring(0,this.id.length-10) + 'DispAltNumDaysSpecify'),  document.getElementById(this.id.substring(0,this.id.length-10) + 'DispDateDtTitle'));	
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);	
				 	if(errMsg == '')
				 	{
				 		errMsg =  Ext.util.validateRxDispensed2(document.getElementById(this.id.substring(0,this.id.length-10)+ 'Dispensed'),document.getElementById(this.id),document.getElementById(this.id + 'Title'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);					 
					}
				}
			});
			Ext.util.splitDate(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Dd"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Mm"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Yy"));
		    	if(document.getElementById(root + 'StdDosage')!=null)
		    	{
				Ext.get(root + 'StdDosage').on('click', function(){
					errMsg = Ext.util.validateRxStdDosage(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-9) + 'AltDosageSpecify'),document.getElementById(this.id.substring(0,this.id.length-9) + 'NumDaysDesc'),document.getElementById(this.id + 'Title'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
					errMsg = Ext.util.validateRxDispensed1(document.getElementById(this.id.substring(0,this.id.length-9) + 'Dispensed'),document.getElementById(this.id), document.getElementById(this.id.substring(0,this.id.length-9) + 'AltDosageSpecify'), document.getElementById(this.id.substring(0,this.id.length-9) + 'DispensedTitle'));
					errCount = Ext.util.showErrorHead(errFields,this.id.substring(0,this.id.length-9)+ 'Dispensed' ,errMsg,errCount);		
					if(errMsg == '')
					{
						errMsg =  Ext.util.validateRxDispAltDosageSpecify1(document.getElementById(this.id.substring(0,this.id.length-9) + 'Dispensed'),document.getElementById(this.id.substring(0,this.id.length-9) + 'DispAltDosageSpecify'),document.getElementById(this.id.substring(0,this.id.length-9) + 'DispAltNumDaysSpecify'), document.getElementById(this.id.substring(0,this.id.length-9) + 'DispensedTitle'));	
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9)+ 'Dispensed' ,errMsg,errCount);						
					}
				});			
				errMsg = Ext.util.validateRxStdDosage(document.getElementById(root + 'StdDosage'),document.getElementById(root + 'AltDosageSpecify'),document.getElementById(root + 'NumDaysDesc'),document.getElementById(root + 'StdDosageTitle'));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'StdDosage',errMsg, errCount);							
			}
			if(prefix != 'other')
			{
				Ext.get(root + 'AltDosageSpecify').on('blur', function(){
					if(document.getElementById(this.id.substring(0,this.id.length-16) + 'StdDosage')!=null)
					{
						errMsg = Ext.util.validateRxStdDosage(document.getElementById(this.id.substring(0,this.id.length-16) + 'StdDosage'),document.getElementById(this.id.substring(0,this.id.length-16) + 'AltDosageSpecify'),document.getElementById(this.id.substring(0,this.id.length-16) + 'NumDaysDesc'),document.getElementById(this.id.substring(0,this.id.length-16) + 'StdDosageTitle'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-16) + 'StdDosage',errMsg,errCount);
					}	
					errMsg = Ext.util.validateNumDaysDesc(document.getElementById(this.id.substring(0,this.id.length-16) + 'StdDosage'),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-16) + 'NumDaysDesc'),document.getElementById(this.id.substring(0,this.id.length-16) + 'NumDaysDescTitle'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-16) + 'NumDaysDesc',errMsg,errCount);
				  	errMsg = Ext.util.validateRxAltDosageSpecify(document.getElementById(this.id.substring(0,this.id.length-16) + 'StdDosage'),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-16) + 'NumDaysDesc'),document.getElementById(this.id.substring(0,this.id.length-16) + 'AltDosageSpecifyTitle'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);

					errMsg = Ext.util.validateRxDispensed1(document.getElementById(this.id.substring(0,this.id.length-16) + 'Dispensed'),document.getElementById(this.id.substring(0,this.id.length-16) + 'StdDosage'), document.getElementById(this.id), document.getElementById(this.id.substring(0,this.id.length-16) + 'DispensedTitle'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-16) + 'Dispensed',errMsg,errCount);
					errMsg =  Ext.util.validateRxDispDate(document.getElementById(this.id.substring(0,this.id.length-16) + 'DispDateDt'),document.getElementById(this.id.substring(0,this.id.length-16) + 'DispDateDtTitle'),'');
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-16) + 'DispDateDt',errMsg,errCount);		
					if(errMsg == '')
					{
						errMsg = Ext.util.validateRxDispAltDosageSpecify2(document.getElementById(this.id.substring(0,this.id.length-16) + 'DispDateDt'),document.getElementById(this.id.substring(0,this.id.length-16) + 'DispAltDosageSpecify'),document.getElementById(this.id.substring(0,this.id.length-16) + 'DispAltNumDaysSpecify'),  document.getElementById(this.id.substring(0,this.id.length-16) + 'DispDateDtTitle'));	
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-16) + 'DispDateDt',errMsg,errCount);	
						if(errMsg == '')
						{
							errMsg =  Ext.util.validateRxDispensed2(document.getElementById(this.id.substring(0,this.id.length-16)+ 'Dispensed'),document.getElementById(this.id.substring(0,this.id.length-16) + 'DispDateDt'),document.getElementById(this.id + 'Title'));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-16) + 'DispDateDt',errMsg,errCount);					 
						}
					}					});			

				Ext.get(root + 'NumDaysDesc').on('blur', function(){
					if(document.getElementById(this.id.substring(0,this.id.length-11) + 'StdDosage')!=null)
					{
						errMsg = Ext.util.validateRxStdDosage(document.getElementById(this.id.substring(0,this.id.length-11) + 'StdDosage'),document.getElementById(this.id.substring(0,this.id.length-11) + 'AltDosageSpecify'),document.getElementById(this.id.substring(0,this.id.length-11) + 'NumDaysDesc'),document.getElementById(this.id.substring(0,this.id.length-11) + 'StdDosageTitle'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-11) + 'StdDosage',errMsg,errCount);
					}
					errMsg = Ext.util.validateNumDaysDesc(document.getElementById(this.id.substring(0,this.id.length-11) + 'StdDosage'),document.getElementById(this.id.substring(0,this.id.length-11) + 'AltDosageSpecify'),document.getElementById(this.id),document.getElementById( this.id+ 'Title'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
					errMsg = Ext.util.validateRxAltDosageSpecify(document.getElementById(this.id.substring(0,this.id.length-11) + 'StdDosage'),document.getElementById(this.id.substring(0,this.id.length-11) + 'AltDosageSpecify'),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-11) + 'AltDosageSpecifyTitle'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-11) + 'AltDosageSpecify',errMsg,errCount);
					errMsg =  Ext.util.validateRxDispDate(document.getElementById(this.id.substring(0,this.id.length-11) + 'DispDateDt'),document.getElementById(this.id.substring(0,this.id.length-11) + 'DispDateDtTitle'),'');
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-11) + 'DispDateDt',errMsg,errCount);		
					if(errMsg == '')
					{
						errMsg = Ext.util.validateRxDispAltDosageSpecify2(document.getElementById(this.id.substring(0,this.id.length-11) + 'DispDateDt'),document.getElementById(this.id.substring(0,this.id.length-11) + 'DispAltDosageSpecify'),document.getElementById(this.id.substring(0,this.id.length-11) + 'DispAltNumDaysSpecify'),  document.getElementById(this.id.substring(0,this.id.length-11) + 'DispDateDtTitle'));	
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-11) + 'DispDateDt',errMsg,errCount);	
						if(errMsg == '')
						{
							errMsg =  Ext.util.validateRxDispensed2(document.getElementById(this.id.substring(0,this.id.length-11)+ 'Dispensed'),document.getElementById(this.id.substring(0,this.id.length-11) + 'DispDateDt'),document.getElementById(this.id.substring(0,this.id.length-11) + 'DispDateDtTitle'));
							errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-11) + 'DispDateDt',errMsg,errCount);					 
						}
					}		
				});		
		
				errMsg = Ext.util.validateRxAltDosageSpecify(document.getElementById(root + 'StdDosage'),document.getElementById(root + 'AltDosageSpecify'),document.getElementById(root + 'NumDaysDesc'),document.getElementById(root + 'AltDosageSpecifyTitle'));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'AltDosageSpecify',errMsg,errCount);
				errMsg = Ext.util.validateNumDaysDesc(document.getElementById(root + 'StdDosage'),document.getElementById(root + 'AltDosageSpecify'),document.getElementById(root + 'NumDaysDesc'),document.getElementById(root + 'NumDaysDescTitle'));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'NumDaysDesc',errMsg,errCount);
			}
			else
			{
				Ext.get(root + 'NumDaysDesc').on('blur', function(){
					errMsg = Ext.util.isValueInBound(document.getElementById(this.id), document.getElementById(this.id + "Title"),'0', '', '');
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);

				});		
				errMsg = Ext.util.isValueInBound(document.getElementById(root + "NumDaysDesc"), document.getElementById(root + "NumDaysDescTitle"),'0', '', '');	
				errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'NumDaysDesc',errMsg,errCount);
			}

			Ext.get(root + 'Dispensed').on('click', function(){
				errMsg = Ext.util.validateRxDispAltDosageSpecify1(document.getElementById(this.id.substring(0,this.id.length-9) + 'Dispensed'),document.getElementById(this.id.substring(0,this.id.length-9)  + 'DispAltDosageSpecify'),document.getElementById(this.id.substring(0,this.id.length-9)  + 'DispAltNumDaysSpecify'), document.getElementById(this.id.substring(0,this.id.length-9)  + 'DispensedTitle'));	
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9) + 'Dispensed',errMsg,errCount);
				if(errMsg == '')
				{
					errMsg =  Ext.util.validateRxDispensed1(document.getElementById(this.id.substring(0,this.id.length-9) + 'Dispensed'),document.getElementById(this.id.substring(0,this.id.length-9)  + 'StdDosage'),document.getElementById(this.id.substring(0,this.id.length-9)  + 'AltDosageSpecify'), document.getElementById(this.id.substring(0,this.id.length-9)  + 'DispensedTitle'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9) + 'Dispensed',errMsg,errCount);
					if(errMsg == '')
					{
						errMsg = Ext.util.validateRxDispensed3(document.getElementById(this.id.substring(0,this.id.length-9) + 'Dispensed'),document.getElementById(this.id.substring(0,this.id.length-9) + 'DispDateDt'), document.getElementById(this.id.substring(0,this.id.length-9) +'DispensedTitle'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9) + 'Dispensed',errMsg,errCount);	
					}
				}	


				errMsg = Ext.util.validateRxDispensed2(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-9) + 'DispDateDt'), document.getElementById(this.id.substring(0,this.id.length-9) + 'DispDateDtTitle'));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9) + 'DispDateDt',errMsg,errCount);
				if(errMsg == '')
				{								
				
					errMsg = Ext.util.validateRxDispensed2(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-9) + 'DispDateDt'), document.getElementById(this.id.substring(0,this.id.length-9) + 'DispDateDtTitle'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9) + 'DispDateDt',errMsg,errCount);
					if(errMsg == '')
					{
						errMsg =  Ext.util.validateRxDispAltDosageSpecify2(document.getElementById(this.id.substring(0,this.id.length-9) + 'DispDateDt'),document.getElementById(this.id.substring(0,this.id.length-9) + 'DispAltDosageSpecify'),document.getElementById(this.id.substring(0,this.id.length-9) + 'DispAltNumDaysSpecify'), document.getElementById(this.id.substring(0,this.id.length-9) + 'DispDateDtTitle'));	
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9) + 'DispDateDt',errMsg,errCount);
					}
				}
			});			
			
			Ext.get(root + 'DispAltDosageSpecify').on('blur', function(){
				errMsg = Ext.util.validateRxDispAltDosageSpecify1(document.getElementById(this.id.substring(0,this.id.length-20) + 'Dispensed'),document.getElementById(this.id.substring(0,this.id.length-20)  + 'DispAltDosageSpecify'),document.getElementById(this.id.substring(0,this.id.length-20)  + 'DispAltNumDaysSpecify'), document.getElementById(this.id.substring(0,this.id.length-20)  + 'DispensedTitle'));	
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-20) + 'Dispensed',errMsg,errCount);
				if(errMsg == '')
				{
					errMsg =  Ext.util.validateRxDispensed1(document.getElementById(this.id.substring(0,this.id.length-20) + 'Dispensed'),document.getElementById(this.id.substring(0,this.id.length-20)  + 'StdDosage'),document.getElementById(this.id.substring(0,this.id.length-20)  + 'DispAltDosageSpecify'), document.getElementById(this.id.substring(0,this.id.length-20)  + 'DispensedTitle'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-20) + 'Dispensed',errMsg,errCount);
					if(errMsg == '')
					{
						errMsg = Ext.util.validateRxDispensed3(document.getElementById(this.id.substring(0,this.id.length-20) + 'Dispensed'),document.getElementById(this.id.substring(0,this.id.length-20) + 'DispDateDt'), document.getElementById(this.id.substring(0,this.id.length-20) +'DispensedTitle'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-20) + 'Dispensed',errMsg,errCount);	
					}
				}				
				errMsg =  Ext.util.validateRxDispDate(document.getElementById(this.id.substring(0,this.id.length-20) + 'DispDateDt'),document.getElementById(this.id.substring(0,this.id.length-20) + 'DispDateDtTitle'),'');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-20) + 'DispDateDt',errMsg,errCount);		
				if(errMsg == '')
				{
					errMsg = Ext.util.validateRxDispensed2(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-20) + 'DispDateDt'), document.getElementById(this.id.substring(0,this.id.length-20) + 'DispDateDtTitle'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-20) + 'DispDateDt',errMsg,errCount);
					if(errMsg == '')
					{
						errMsg =  Ext.util.validateRxDispAltDosageSpecify2(document.getElementById(this.id.substring(0,this.id.length-20) + 'DispDateDt'),document.getElementById(this.id.substring(0,this.id.length-20) + 'DispAltDosageSpecify'),document.getElementById(this.id.substring(0,this.id.length-20) + 'DispAltNumDaysSpecify'), document.getElementById(this.id.substring(0,this.id.length-20) + 'DispDateDtTitle'));	
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-20) + 'DispDateDt',errMsg,errCount);
					}
				}
				errMsg = Ext.util.validateRxAltDosageSpecify(document.getElementById(this.id.substring(0,this.id.length-20) + 'StdDosuage'),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-20) + 'DispAltNumDaysSpecify'), document.getElementById(this.id + 'Title'));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
				errMsg = Ext.util.validateNumDaysDesc(document.getElementById(this.id.substring(0,this.id.length-20) + 'StdDosage'),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-20) + 'DispAltNumDaysSpecify'), document.getElementById(this.id.substring(0,this.id.length-20) + 'DispAltNumDaysSpecifyTitle'));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-20) + 'DispAltNumDaysSpecify',errMsg,errCount);
			});

			Ext.get(root + 'DispAltNumDaysSpecify').on('blur', function(){
				errMsg = Ext.util.validateRxDispAltDosageSpecify1(document.getElementById(this.id.substring(0,this.id.length-21) + 'Dispensed'),document.getElementById(this.id.substring(0,this.id.length-21)  + 'DispAltDosageSpecify'),document.getElementById(this.id.substring(0,this.id.length-21)  + 'DispAltNumDaysSpecify'), document.getElementById(this.id.substring(0,this.id.length-21)  + 'DispensedTitle'));	
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-21) + 'Dispensed',errMsg,errCount);
				if(errMsg == '')
				{
					errMsg =  Ext.util.validateRxDispensed1(document.getElementById(this.id.substring(0,this.id.length-21) + 'Dispensed'),document.getElementById(this.id.substring(0,this.id.length-21)  + 'StdDosage'),document.getElementById(this.id.substring(0,this.id.length-21)  + 'DispAltDosageSpecify'), document.getElementById(this.id.substring(0,this.id.length-21)  + 'DispensedTitle'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-21) + 'Dispensed',errMsg,errCount);
					if(errMsg == '')
					{
						errMsg = Ext.util.validateRxDispensed3(document.getElementById(this.id.substring(0,this.id.length-21) + 'Dispensed'),document.getElementById(this.id.substring(0,this.id.length-21) + 'DispDateDt'), document.getElementById(this.id.substring(0,this.id.length-21) +'DispensedTitle'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-21) + 'Dispensed',errMsg,errCount);	
					}
				}				
				errMsg =  Ext.util.validateRxDispDate(document.getElementById(this.id.substring(0,this.id.length-21) + 'DispDateDt'),document.getElementById(this.id.substring(0,this.id.length-21) + 'DispDateDtTitle'),'');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-21) + 'DispDateDt',errMsg,errCount);		

				if(errMsg == '')
				{

					errMsg = Ext.util.validateRxDispensed2(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-21) + 'DispDateDt'), document.getElementById(this.id.substring(0,this.id.length-21) + 'DispDateDtTitle'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-21) + 'DispDateDt',errMsg,errCount);
					if(errMsg == '')
					{
						errMsg =  Ext.util.validateRxDispAltDosageSpecify2(document.getElementById(this.id.substring(0,this.id.length-21) + 'DispDateDt'),document.getElementById(this.id.substring(0,this.id.length-21) + 'DispAltDosageSpecify'),document.getElementById(this.id.substring(0,this.id.length-21) + 'DispAltNumDaysSpecify'), document.getElementById(this.id.substring(0,this.id.length-21) + 'DispDateDtTitle'));	
						errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-21) + 'DispDateDt',errMsg,errCount);
					}
				}

			
			  	errMsg = Ext.util.validateNumDaysDesc(document.getElementById(this.id.substring(0,this.id.length-21) + 'StdDosage'),document.getElementById(this.id.substring(0,this.id.length-21) + 'DispAltDosageSpecify'),document.getElementById(this.id), document.getElementById(this.id + 'Title'));
			  	errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);
			  	errMsg = Ext.util.validateRxAltDosageSpecify(document.getElementById(this.id.substring(0,this.id.length-21) + 'StdDosage'),document.getElementById(this.id.substring(0,this.id.length-21) + 'DispAltDosageSpecify'),document.getElementById(this.id), document.getElementById(this.id.substring(0,this.id.length-21) + 'DispAltDosageSpecifyTitle'));
			  	errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-21) + 'DispAltDosageSpecify',errMsg,errCount);

			});
		  	errMsg = Ext.util.validateRxAltDosageSpecify(document.getElementById(root + 'StdDosage'),document.getElementById(root + 'DispAltDosageSpecify'),document.getElementById(root + 'DispAltNumDaysSpecify'), document.getElementById(root + 'DispAltDosageSpecifyTitle'));
		  	errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'DispAltDosageSpecify',errMsg,errCount);			
			errMsg = Ext.util.validateNumDaysDesc(document.getElementById(root + 'StdDosage'),document.getElementById(root + 'DispAltDosageSpecify'),document.getElementById(root + 'DispAltNumDaysSpecify'), document.getElementById(root + 'DispAltNumDaysSpecifyTitle'));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'DispAltNumDaysSpecify',errMsg,errCount);			
			errMsg = Ext.util.validateRxDispAltDosageSpecify1(document.getElementById(root+ 'Dispensed'),document.getElementById(root + 'DispAltDosageSpecify'),document.getElementById(root + 'DispAltNumDaysSpecify'), document.getElementById(root + 'DispensedTitle'));	
		 	errCount = Ext.util.showErrorHead(errFields,errMsgs,root+ 'Dispensed',errMsg,errCount);
			if(errMsg == '')
			{
				errMsg =  Ext.util.validateRxDispensed1(document.getElementById(root+ 'Dispensed'),document.getElementById(root + 'StdDosage'),document.getElementById(root + 'AltDosageSpecify'), document.getElementById(root + 'DispensedTitle'));
		 		errCount = Ext.util.showErrorHead(errFields,errMsgs,root+ 'Dispensed',errMsg,errCount);

	 		 	if(errMsg == '')
		 		{
		 			errMsg = Ext.util.validateRxDispensed3(document.getElementById(root+ 'Dispensed'),document.getElementById(root+ 'DispDateDt'), document.getElementById(root+'DispensedTitle'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,root+ 'Dispensed',errMsg,errCount);	
		 		}

			}
			errMsg =  Ext.util.validateRxDispDate(document.getElementById(root+'DispDateDt'),document.getElementById(root+'DispDateDtTitle'),'');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,root+'DispDateDt',errMsg,errCount);		
			Ext.util.splitDate(document.getElementById(root+'DispDateDt'),document.getElementById(root+'DispDateDd'),document.getElementById(root+'DispDateMm'),document.getElementById(root+'DispDateYy'));
			if(errMsg == '')
			{
 				errMsg = Ext.util.validateRxDispAltDosageSpecify2(document.getElementById(root+'DispDateDt'),document.getElementById(root + 'DispAltDosageSpecify'),document.getElementById(root + 'DispAltNumDaysSpecify'),  document.getElementById(root + 'DispDateDtTitle'));	
				errCount = Ext.util.showErrorHead(errFields,errMsgs,root+'DispDateDt',errMsg,errCount);	
			 	if(errMsg == '')
			 	{
			 		errMsg =  Ext.util.validateRxDispensed2(document.getElementById(root+ 'Dispensed'),document.getElementById(root+'DispDateDt'),document.getElementById(root+'DispDateDtTitle'));
					errCount = Ext.util.showErrorHead(errFields,errMsgs,root+'DispDateDt',errMsg,errCount);
					if(errMsg == '')
					{
						errMsg = Ext.util.validateRxDispensed2(document.getElementById(root+ 'Dispensed'),document.getElementById(root + 'DispDateDt'), document.getElementById(root + 'DispDateDtTitle'));
						errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'DispDateDt',errMsg,errCount);
						if(errMsg == '')
						{
							errMsg =  Ext.util.validateRxDispAltDosageSpecify2(document.getElementById(root + 'DispDateDt'),document.getElementById(root + 'DispAltDosageSpecify'),document.getElementById(root + 'DispAltNumDaysSpecify'), document.getElementById(root + 'DispDateDtTitle'));	
							errCount = Ext.util.showErrorHead(errFields,errMsgs,root + 'DispDateDt',errMsg,errCount);
						}
					}
				}			
			}
	  	} 
	 	else if(suffix == 'ovalDateDt')
		{
			
			txtFormat[i] = new Ext.form.DateField({
				fieldLabel: '',
				maskRe : /[\d{1,2}\/]/,
				validationEvent: false,
				allowBlank:true
			});
			txtFormat[i].applyToMarkup(txtArr[i]);
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
			txtFormat[i] = new Ext.form.TextField({
				fieldLabel: '',
				validationEvent: false,
				allowBlank:true
			});
			txtFormat[i].applyToMarkup(txtArr[i]);	
		
		}
		
	}
	var otherRootArr = new Array(2);
	var otherSuffixArr = new Array(3);
	otherRootArr[0] = 'other1';
	otherRootArr[1] = 'other2';
	otherSuffixArr[0] = 'RxText';
	otherSuffixArr[1] = 'AltDosageSpecify';
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
	nxtVisitD2Format= new Ext.form.DateField({
		fieldLabel: '',
		maskRe : /[\d{1,2}\/]/,
		validationEvent: false,
		allowBlank:true
	});
	nxtVisitD2Format.applyToMarkup('nxtVisitD2');		
	Ext.get('nxtVisitD2').on('blur', function(){

		errMsg = Ext.util.validateNextPickupDt(document.getElementById('nxtVisitD2'), document.mainForm.vDate , document.getElementById('eid'),document.getElementById('nxtVisitD2Title'));
		Ext.util.splitDate(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-2) + "Dd"),document.getElementById(this.id.substring(0,this.id.length-2) + "Mm"),document.getElementById(this.id.substring(0,this.id.length-2) + "Yy"));
		errCount = Ext.util.showErrorHead(errFields,errMsgs,'nxtVisitD2',errMsg,errCount);

	});
	errMsg = Ext.util.validateNextPickupDt(document.getElementById('nxtVisitD2'), document.mainForm.vDate , document.getElementById('eid'),document.getElementById('nxtVisitD2Title'));
	Ext.util.splitDate(document.getElementById('nxtVisitD2'),document.getElementById('nxtVisitDd'),document.getElementById('nxtVisitMm'),document.getElementById('nxtVisitYy'));
	errCount = Ext.util.showErrorHead(errFields,errMsgs,'nxtVisitD2',errMsg,errCount);
	var tempRadioArr = allElements["radio"]; 
	var radioArr = Ext.util.getAllRadios(tempRadioArr);
});

