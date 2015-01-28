	
Ext.onReady(function() {

	var txtArr = Ext.util.getElementsByType(document.mainForm,"text");
	
	var txtFormat = new Array();
	var root;
	var suffix;
	for(i=0;i<txtArr.length;i++)
	{	
		suffix = txtArr[i].name.substring(txtArr[i].name.length-2);

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
				maskRe : /[\d{1,2}\/]/,
				validationEvent: false,
				allowBlank:true
			});
			txtFormat[i].applyToMarkup(txtArr[i]);
			(Ext.get(txtArr[i].id)).on('blur', function(){
				errMsg =  Ext.util.validateDateFieldPatient(document.getElementById(this.id),document.getElementById(this.id + 'Title'),'');
				Ext.util.splitDate(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-2) + "DD"),document.getElementById(this.id.substring(0,this.id.length-2) + "MM"),document.getElementById(this.id.substring(0,this.id.length-2) + "YY"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg,errCount);
			});
			errMsg =  Ext.util.validateDateFieldPatient(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id + 'Title'),'');
			Ext.util.splitDate(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "DD"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "MM"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "YY"));
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
	
	(Ext.get("sideEffects")).on("click", function(){
		Ext.util.checkUnique(document.getElementById("sideEffects"),document.getElementById("opportunInf"), document.getElementById("discDeathOther"));
	});
	(Ext.get("opportunInf")).on("click", function(){
		Ext.util.checkUnique(document.getElementById("opportunInf"),document.getElementById("sideEffects"), document.getElementById("discDeathOther"));
	});
	(Ext.get("discDeathOther")).on("click", function(){
		Ext.util.checkUnique(document.getElementById("discDeathOther"),document.getElementById("opportunInf"), document.getElementById("sideEffects"));
	});

	//Ext.util.clickRadio(document.mainForm);	
});


