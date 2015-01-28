
function hemDtAlert(fieldId, section, extraFlag, msg) {
    var checked = Ext.getDom('hemAlertDone').value;
	var id = fieldId + 'TestDt';
	var date = Ext.getDom(id).value;
	if (date != '' && checked == 'false'){	
		if (confirm(msg)) {
			var extraFields = ['aso','ccmh','tcmh','vgm']; 
			if (section == 'subhead3') var temp = ['bloodtype', 'reticulocyte','wbc','lymphocytes', 'monocytes','polymorphs', 'eospinophils', 'basophils', 'hematocrit', 'platelets', 'esr'];
			if (section == 'subhead31')var temp = [ 'bloodtype','reticulocyte','wbc','lymphocytes', 'monocytes','polymorphsEospinophils','polymorphsNeutrophils','polymorphsBasophils', 'hematocrit', 'hemoglobine', 'platelets', 'esr','electrophorese'];
			if (section == 'subhead31' && extraFlag == 1) var testList = temp.concat(extraFields);
			else var testList = temp;
			for (var i = 0; i< testList.length; i++) {
			   if(document.getElementById(testList[i] + 'TestDt')){
				var currDateField = document.getElementById(testList[i] + 'TestDt');
				if (currDateField.value == '') {
					currDateField.value = date;
					Ext.util.splitDate(currDateField,document.getElementById(testList[i] + "TestDd"), document.getElementById(testList[i] + "TestMm"), document.getElementById(testList[i] + "TestYy"));
				}
			   }
			}
		}
		Ext.getDom('hemAlertDone').value = true;
	}
}
