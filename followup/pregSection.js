
window.onload=init;

function init() {
	var sex = Ext.getDom('sex1').value;
	if(sex=='2'){
		grayOut();
	}	
}

function grayOut(){
	if(Ext.getDom('pregYesNo1') && Ext.getDom('pregYesNo2') && Ext.getDom('pregYesNo3')){
		var preg1 = Ext.getDom('pregYesNo1');
		var preg2 = Ext.getDom('pregYesNo2');
		var preg3 = Ext.getDom('pregYesNo3');
		preg1.disabled='disabled'; 
		preg2.disabled='disabled'; 
		preg3.disabled='disabled'; 
	}
	
	if(Ext.getDom('prenat1') && Ext.getDom('prenat2')){
		var pren1 = Ext.getDom('prenat1');
		var pren2 = Ext.getDom('prenat2');
		if(Ext.getDom('prenat3')){
			var pren3 = Ext.getDom('prenat3');
			pren3.disabled='disabled';
		}
		pren1.disabled='disabled';
		pren2.disabled='disabled'; 
	}	
	if(Ext.getDom('mense1') && Ext.getDom('mense2') && Ext.getDom('mense3')){
		var mense1 = Ext.getDom('mense1');
		var mense2 = Ext.getDom('mense2');
		var mense3 = Ext.getDom('mense3');
		mense1.disabled = 'disabled';
		mense2.disabled= 'disabled'; 
		mense3.disabled = 'disabled';
	}
	if(Ext.getDom('pap1') && Ext.getDom('pap2') && Ext.getDom('pap3')){
		var pap1 = Ext.getDom('pap1');
		var pap2 = Ext.getDom('pap2');
		var pap3 = Ext.getDom('pap3');
		pap1.disabled= 'disabled';
		pap2.disabled= 'disabled'; 
		pap3.disabled = 'disabled';
	}
	if(Ext.getDom('papRes1') && Ext.getDom('papRes2')){
		var papRes1 = Ext.getDom('papRes1');
		var papRes2 = Ext.getDom('papRes2');
		papRes1.disabled= 'disabled';
		papRes2.disabled = 'disabled';
	}
}


