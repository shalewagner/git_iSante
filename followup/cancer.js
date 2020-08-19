
Ext.onReady(function() {
		
		var  statusTbFDt = new Ext.form.DateField({
		fieldLabel: '',
		maskRe : /[\Xx{1,2}\d{1,2}\/]/,
		validationEvent: false,
		allowBlank:true
	});
	statusTbFDt.applyToMarkup(document.mainForm.completeTreatDt);
});


