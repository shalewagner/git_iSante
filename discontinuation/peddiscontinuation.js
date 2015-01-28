	
Ext.onReady(function() {

	var txtArr = Ext.util.getElementsByType(document.mainForm,"text");
	
	var txtFormat = new Array();
	var root;
	var suffix;
	for(i=0;i<txtArr.length;i++)
	{	
		suffix = txtArr[i].id.substring(txtArr[i].id.length-2);

		if(suffix == "Dt")
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
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg,errCount);

			});
			errMsg = Ext.util.validateRxDispDate(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id + 'Title'),'');
			Ext.util.splitDate(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Dd"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Mm"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Yy"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2),errMsg,errCount);
		}
		else if(suffix == "D1")
		{

			txtFormat[i] = new Ext.form.DateField({
				fieldLabel: '',
				maskRe : /[\Xx{1,2}\d{1,2}\/]/,
				validationEvent: false,
				allowBlank:true
			});
			txtFormat[i].applyToMarkup(txtArr[i]);
			(Ext.get(txtArr[i].id)).on('blur', function(){
				errMsg =  Ext.util.validateRxDispDate(document.getElementById(this.id),document.getElementById(this.id + 'Title'),'XX');
				Ext.util.splitDate(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-2) + "Dd"),document.getElementById(this.id.substring(0,this.id.length-2) + "Mm"),document.getElementById(this.id.substring(0,this.id.length-2) + "Yy"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg,errCount);
			});
			errMsg =  Ext.util.validateRxDispDate(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id + 'Title'),'XX');
			Ext.util.splitDate(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Dd"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Mm"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Yy"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2),errMsg,errCount);

		}
		else
		{
			txtFormat[i] = new Ext.form.TextField({
				fieldLabel: '',
				validationEvent: false,
				allowBlank:true
			});
			txtFormat[i].applyToMarkup(txtArr[i]);
			prefix = txtArr[i].name.substring(0,12);
			if(prefix == "householdAge")
			{
				Ext.get(txtArr[i].id).on('blur', function(){
					errMsg = Ext.util.validateAge(document.getElementById(this.id),document.getElementById(this.id + 'Title'),'');
					errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);	
				});
				errMsg = Ext.util.validateAge(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id + 'Title'),'');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id,errMsg,errCount);
			}

		}
	}
	var taArr = Ext.util.getElementsByType(document.mainForm,"textarea");
	var taFormat;
	for(i=0;i<taArr.length;i++)
	{
		taFormat= new Ext.form.TextArea({
				fieldLabel: '',
				validationEvent: false,
				allowBlank:true
		});
		taFormat.applyToMarkup(taArr[i]);	
	}
	
//      The 'clickRadio' function doesn't work, use getAllRadios for array
//	var radioArr = Ext.util.clickRadio(document.mainForm);
        var names = new Array();
        var allElements = Ext.util.getAllElements(document.mainForm,names);
        var tempRadioArr = allElements["radio"];
        var radioArr = Ext.util.getAllRadios(tempRadioArr);
	var reasonDeath = new Array(3);

	reasonDeath[0] = document.getElementById("sideEffects");
	reasonDeath[1] = document.getElementById("opportunInf");
	reasonDeath[2] = document.getElementById("discDeathOther");

	var key = -1;
	for(i=0;i<reasonDeath.length;i++)
	{
		Ext.get(reasonDeath[i].id).on('click', function(){
			key = Ext.util.getKeyByID(reasonDeath, this.id)
			Ext.util.checkUniqueRadio(reasonDeath,key, radioArr);
		});
	}
});

