	
Ext.onReady(function() {
	var names = new Array();
	var allElements = Ext.util.getAllElements(document.mainForm,names);
	var txtArr = allElements["text"];
	
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
		else if(suffix == "D2")
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
				Ext.util.splitDate(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-2) + "Dd"),document.getElementById(this.id.substring(0,this.id.length-2) + "Mm"),document.getElementById(this.id.substring(0,this.id.length-2) + "Yy"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-2),errMsg,errCount);
			});
			errMsg =  Ext.util.validateDateFieldPatient(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id + 'Title'),'');
			Ext.util.splitDate(document.getElementById(txtArr[i].id),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Dd"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Mm"),document.getElementById(txtArr[i].id.substring(0,txtArr[i].id.length-2) + "Yy"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2),errMsg,errCount);

		}
		else if(suffix =='Mm' || suffix == 'Yy')
		{		txtFormat[i] = new Ext.form.TextField({
					fieldLabel: '',
					maskRe : /[\d{1,2}\/]/,
					validationEvent: false,
					allowBlank:true
				});
				txtFormat[i].applyToMarkup(txtArr[i]);
				(Ext.get(txtArr[i].id)).on('blur', function(){
					errMsg = Ext.util.validateMY(document.getElementById(this.id.substring(0, this.id.length-2)+"Mm"),document.getElementById(this.id.substring(0, this.id.length-2)+"Yy"),document.getElementById(this.id.substring(0, this.id.length-2)+"Title"),"XX",false);
					errCount = Ext.util.showErrorHead(errFields,errMsgs,txtArr[i].id.substring(0,txtArr[i].id.length-2),errMsg,errCount);

				});
				errMsg =  Ext.util.validateMY(document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Mm"),document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Yy"),document.getElementById(txtArr[i].id.substring(0, txtArr[i].id.length-2)+"Title"),"XX",true);
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
	var taArr = allElements["textarea"];
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
	var needAccessments = new Array(15);
	needAccessments[0]="needsAssLimitUnder";
	needAccessments[1]="needsAssDenial";
	needAccessments[2]="needsAssOngRisk";
	needAccessments[3]="needsAssBarrHome";
	needAccessments[4]="needsAssMentHeal";
	needAccessments[5]="needsAssSevDepr";
	needAccessments[6]="needsAssPreg";
	needAccessments[7]="needsAssDrugs";
	needAccessments[8]="needsAssViol";
	needAccessments[9]="needsAssFamPlan";
	needAccessments[10]="needsAssTrans";
	needAccessments[11]="needsAssHousing";
	needAccessments[12]="needsAssNutr";
	needAccessments[13]="needsAssHyg";
	needAccessments[14]="needsAssOther";
	for(i=0;i<15;i++)
	{
		Ext.get(needAccessments[i]+"Del").on('click', function(){
			Ext.util.checkUnique(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-3)+"Ref"), document.getElementById(this.id.substring(0,this.id.length-3)+"Un"));
		});
		Ext.get(needAccessments[i]+"Ref").on('click', function(){
			Ext.util.checkUnique(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-3)+"Un"), document.getElementById(this.id.substring(0,this.id.length-3)+"Del"));
		});
		Ext.get(needAccessments[i]+"Un").on('click', function(){
			Ext.util.checkUnique(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-2)+"Del"), document.getElementById(this.id.substring(0,this.id.length-2)+"Ref"));
		});
	}	

	var tempRadioArr = allElements["radio"]; 
	var radioArr = Ext.util.getAllRadios(tempRadioArr);
	
});


