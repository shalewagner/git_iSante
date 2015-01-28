	
Ext.onReady(function() {
	var names = new Array();
	var allElements = Ext.util.getAllElements(document.mainForm,names);
	var txtArr = allElements["text"];

	
	var txtFormat = new Array();
	var root;
	var suffix;
	for(i=0;i<txtArr.length;i++)
	{	

		txtFormat[i] = new Ext.form.TextField({
			fieldLabel: '',
			validationEvent: false,
			allowBlank:true
		});
		txtFormat[i].applyToMarkup(txtArr[i]);
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
	var tempRadioArr = allElements["radio"]; 
	var radioArr = Ext.util.getAllRadios(tempRadioArr);	

});


