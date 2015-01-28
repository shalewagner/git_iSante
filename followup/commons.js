Ext.util.createStopReasons = function(_head)
{	
	var stops = new Array();
	stops[0] = _head + 'DiscTox';
	stops[1] = _head + 'DiscIntol';
	stops[2] = _head + 'DiscFailVir';
	stops[3] = _head + 'DiscFailImm';
	stops[4] = _head + 'DiscFailClin';
	return  Ext.util.getElements(stops);
};
Ext.util.createInterruptReasons = function(_head)
{	
	var stops = new Array();
	stops[0] = _head + 'InterStock';
	stops[1] = _head + 'InterPreg';
	stops[2] = _head + 'InterHop';
	stops[3] = _head + 'InterMoney';
	stops[4] = _head + 'InterAlt';
	stops[5] = _head + 'InterLost';
	stops[6] = _head + 'InterPref';
	return  Ext.util.getElements(stops);	
};
Ext.util.createPedInterruptReasons = function(_head)
{	
	var stops = new Array();
	stops[0] = _head + 'InterStock';
	stops[1] = _head + 'InterPreg';
	stops[2] = _head + 'InterHop';
	stops[3] = _head + 'InterMoney';
	stops[4] = _head + 'InterAlt';
	stops[5] = _head + 'InterLost';
	stops[6] = _head + 'InterPref';
	stops[7] = _head + 'InterUnk';
	return  Ext.util.getElements(stops);	
};
Ext.util.mergeArrays = function(_arr1, _arr2)
{
	var result = new Array();
	var i;
	var j = 0;
	for(i=0;i<_arr1.length;i++)
	{
		result[j++] = _arr1[i];
	}
	for(i=0;i<_arr2.length;i++)
	{
		result[j++] = _arr2[i];
	}
	return result;
}
Ext.util.getElements = function(_array)
{
	var elements = new Array();
	var i;
	for(i = 0;i < _array.length; i++)
	{
		elements[i] = document.getElementById(_array[i]);
	}
	return elements;
}

