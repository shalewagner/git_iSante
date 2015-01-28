	
Ext.onReady(function() {
	var i;
	var OtherArvArr = new Array(15);
	OtherArvArr[0]='ethambutol';
	OtherArvArr[1]='isoniazid';
	OtherArvArr[2]='pyrazinamide';
	OtherArvArr[3]='rifampicine';
	OtherArvArr[4]='streptomycine';
	OtherArvArr[5]='acyclovir';
	OtherArvArr[6]='azythroProph';
	OtherArvArr[7]='azythroOther';
	OtherArvArr[8]='clarithromycin';
	OtherArvArr[9]='cotrimoxazoleProph';
	OtherArvArr[10]='cotrimoxazoleOther';
	OtherArvArr[11]='fluconazole';
	OtherArvArr[12]='ketaconazole';
	OtherArvArr[13]='traditional';
	OtherArvArr[14]='other3';
	if(document.getElementById(OtherArvArr[0]+"StartMm")!=null)
	{
		for(i=0;i<OtherArvArr.length;i++)
		{
			(Ext.get(OtherArvArr[i]+"StartMm")).on('blur', function(){
				errMsg =  Ext.util.checkDrugStartDate1(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-7)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"StartTitle"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"Continued"),'XX');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7) + 'Start',errMsg,errCount);
				errMsg = Ext.util.checkDrugStopDate1(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-7)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopTitle"),document.getElementById(this.id.substring(0,this.id.length-7)+"Continued"),'XX');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7) + 'Stop',errMsg,errCount);
				errMsg = Ext.util.checkDrugContinuing1(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-7)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-7)+"ContinuedTitle"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7) + 'Continued',errMsg,errCount);		
			});
			(Ext.get(OtherArvArr[i]+"StartYy")).on('blur', function(){
				errMsg =  Ext.util.checkDrugStartDate1(document.getElementById(this.id.substring(0,this.id.length-7)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"StartTitle"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"Continued"),'XX');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7) + 'Start',errMsg,errCount);
				errMsg = Ext.util.checkDrugStopDate1(document.getElementById(this.id.substring(0,this.id.length-7)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopTitle"),document.getElementById(this.id.substring(0,this.id.length-7)+"Continued"),'XX');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7) + 'Stop',errMsg,errCount);
				errMsg = Ext.util.checkDrugContinuing1(document.getElementById(this.id.substring(0,this.id.length-7)+"StartMm"),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-7)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-7)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-7)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-7)+"ContinuedTitle"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-7) + 'Continued',errMsg,errCount);		

			});
			(Ext.get(OtherArvArr[i]+"StopMm")).on('blur', function(){
				errMsg =  Ext.util.checkDrugStartDate1(document.getElementById(this.id.substring(0,this.id.length-6)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartTitle"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"Continued"),'XX');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + 'Start',errMsg,errCount);
				errMsg = Ext.util.checkDrugStopDate1(document.getElementById(this.id.substring(0,this.id.length-6)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopTitle"),document.getElementById(this.id.substring(0,this.id.length-6)+"Continued"),'XX');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + 'Stop',errMsg,errCount);
				errMsg =  Ext.util.checkDrugContinuing1(document.getElementById(this.id.substring(0,this.id.length-6)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-6)+"ContinuedTitle"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + 'Continued',errMsg,errCount);
			});
			(Ext.get(OtherArvArr[i]+"StopYy")).on('blur', function(){
				errMsg =  Ext.util.checkDrugStartDate1(document.getElementById(this.id.substring(0,this.id.length-6)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartTitle"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"Continued"),'XX');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + 'Start',errMsg,errCount);
				errMsg = Ext.util.checkDrugStopDate1(document.getElementById(this.id.substring(0,this.id.length-6)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopTitle"),document.getElementById(this.id.substring(0,this.id.length-6)+"Continued"),'XX');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + 'Stop',errMsg,errCount);
				errMsg =  Ext.util.checkDrugContinuing1(document.getElementById(this.id.substring(0,this.id.length-6)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-6)+"ContinuedTitle"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + 'Continued',errMsg,errCount);
			});
			(Ext.get(OtherArvArr[i]+"Continued")).on('click', function(){
				errMsg =  Ext.util.checkDrugStartDate1(document.getElementById(this.id.substring(0,this.id.length-9)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"StartTitle"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"Continued"),'XX');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9) + 'Start',errMsg,errCount);
				errMsg = Ext.util.checkDrugStopDate1(document.getElementById(this.id.substring(0,this.id.length-9)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopTitle"),document.getElementById(this.id.substring(0,this.id.length-9)+"Continued"),'XX');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9) + 'Stop',errMsg,errCount);
				errMsg =  Ext.util.checkDrugContinuing1(document.getElementById(this.id.substring(0,this.id.length-9)+"StartMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StartYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-9)+"ContinuedTitle"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9) + 'Continued',errMsg,errCount);
			});
			errMsg =  Ext.util.checkDrugStartDate1(document.getElementById(OtherArvArr[i]+"StartMm"),document.getElementById(OtherArvArr[i]+"StartYy"),document.getElementById(OtherArvArr[i]+"StartTitle"),document.getElementById(OtherArvArr[i]+"StopMm"),document.getElementById(OtherArvArr[i]+"StopYy"),document.getElementById(OtherArvArr[i]+"Continued"),'XX');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,OtherArvArr[i] + 'Start',errMsg,errCount);
			errMsg = Ext.util.checkDrugStopDate1(document.getElementById(OtherArvArr[i]+"StartMm"),document.getElementById(OtherArvArr[i]+"StartYy"),document.getElementById(OtherArvArr[i]+"StopMm"),document.getElementById(OtherArvArr[i]+"StopYy"),document.getElementById(OtherArvArr[i]+"StopTitle"),document.getElementById(OtherArvArr[i]+"Continued"),'XX');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,OtherArvArr[i] + 'Stop',errMsg,errCount);
			errMsg =  Ext.util.checkDrugContinuing1(document.getElementById(OtherArvArr[i]+"StartMm"),document.getElementById(OtherArvArr[i]+"StartYy"),document.getElementById(OtherArvArr[i]+"StopMm"),document.getElementById(OtherArvArr[i]+"StopYy"),document.getElementById(OtherArvArr[i]+"Continued"),document.getElementById(OtherArvArr[i]+"ContinuedTitle"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,OtherArvArr[i] + 'Continued',errMsg,errCount);
		}        
	}
	else
	{

		for(i=0;i<OtherArvArr.length;i++)
		{

			(Ext.get(OtherArvArr[i]+"StopMm")).on('blur', function(){
				errMsg =  Ext.util.checkOtherContinued(document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopTitle"),'XX');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6),errMsg,errCount);
				errMsg =  Ext.util.checkDrugContinuing(document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-6)+"ContinuedTitle"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + "Continued",errMsg,errCount);
			});
			(Ext.get(OtherArvArr[i]+"StopYy")).on('blur', function(){
				errMsg =  Ext.util.checkOtherContinued(document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id),document.getElementById(this.id.substring(0,this.id.length-6)+"StopTitle"),'XX');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6),errMsg,errCount);
				errMsg =  Ext.util.checkDrugContinuing(document.getElementById(this.id.substring(0,this.id.length-6)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-6)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-6)+"Continued"),document.getElementById(this.id.substring(0,this.id.length-6)+"ContinuedTitle"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-6) + "Continued",errMsg,errCount);

			});
			(Ext.get(OtherArvArr[i]+"Continued")).on('click', function(){
				errMsg =  Ext.util.checkOtherContinued(document.getElementById(this.id.substring(0,this.id.length-9)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopYy"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopTitle"),'XX');
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id.substring(0,this.id.length-9),errMsg,errCount);
				errMsg =  Ext.util.checkDrugContinuing(document.getElementById(this.id.substring(0,this.id.length-9)+"StopMm"),document.getElementById(this.id.substring(0,this.id.length-9)+"StopYy"),document.getElementById(this.id),document.getElementById(this.id + "Title"));
				errCount = Ext.util.showErrorHead(errFields,errMsgs,this.id,errMsg,errCount);

			});
			errMsg =  Ext.util.checkOtherContinued(document.getElementById(OtherArvArr[i]+"StopMm"),document.getElementById(OtherArvArr[i]+"StopYy"),document.getElementById(OtherArvArr[i]+"StopTitle"),'XX');
			errCount = Ext.util.showErrorHead(errFields,errMsgs,OtherArvArr[i],errMsg,errCount);
			errMsg =  Ext.util.checkDrugContinuing(document.getElementById(OtherArvArr[i]+"StopMm"),document.getElementById(OtherArvArr[i]+"StopYy"),document.getElementById(OtherArvArr[i]+"Continued"),document.getElementById(OtherArvArr[i]+"ContinuedTitle"));
			errCount = Ext.util.showErrorHead(errFields,errMsgs,OtherArvArr[i] + "Continued" ,errMsg,errCount);
		}	
	}
});