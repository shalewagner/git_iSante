
function toggleDisplay(index, numRows){
	var sectionY = Ext.getDom('section' + index +'Y');
	var sectionN = Ext.getDom('section' + index +'N');
	if(sectionY.style.display=='none'){
		sectionN.style.display= 'none';
		sectionY.style.display='inline';
		for(var i = 0; i < numRows; i++){
			var node = Ext.getDom('row'+ index + i);
			node.style.display= 'none';
		}
	} else {
		sectionN.style.display='inline';
		sectionY.style.display='none';
		for(var i = 0; i < numRows; i++){
			var node = Ext.getDom('row'+ index + i);
			node.style.display='';
		}
	}
}