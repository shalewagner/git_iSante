var errFields = new Array();
var errMsgs = new Array();
var errCount = 0;
var errorMsg = "";
Date.useStrict = true; //Prevents default rollover of date if invalid

Ext.util.getYear4 = function(_val)
{
	var temp;
	if(_val != '')
	{
		if(_val.length == 1)
		{
				temp = '0'+_val;
		}
		else
		{
				temp=_val;
		}
		if(temp > '20')
		{
			return '19'+temp;
		}
		return '20'+temp;
	}
	return '';
};
Ext.util.convertDefault = function(_val,_default)
{	
	if(_default.length>0 && _val.toUpperCase() == _default.toUpperCase())
		return 1;
	return _val;
};

Ext.util.chkDd = function(_dd)
{
	var errorMsg = "";
	if(_dd.length > 2)
	{
		errorMsg = "15";
	}
	else if(!Ext.util.isNumValid(_dd,1,31))
	{
		errorMsg = "12";
	}
	return errorMsg;
};

Ext.util.chkMm = function(_mm)
{
	var errorMsg = "";
	if(_mm.length > 2)
	{
		errorMsg = "15";
	}
	else if(!Ext.util.isNumValid(_mm,1,12))
	{
		errorMsg = "13";
	}
	return errorMsg;
};

Ext.util.chkYy = function(_Yy)
{	
	var errorMsg = "";
	if(_Yy.length > 4)
	{
		errorMsg = "15";
	}
	else if(!Ext.util.isNumValid(_Yy,'0',99))
	{
		errorMsg = "14";
	}
	return errorMsg;
};
Ext.util.chkYy4 = function(_Yy)
{	
	var errorMsg = "";
	if(_Yy == '' || _Yy.length!=4 || !Ext.util.isNumValid(_Yy,'0',9999))
	{
		errorMsg = "69";
	}
	return errorMsg;
};
Ext.util.isNumValid = function(_input,_begin,_end)
{	
	if(!isNaN(_input))
	{
		if(_begin != '')
		{
			if(Number(_input) < Number(_begin))
			{	

				return false;
			}
		}
		if(_end != '')
		{
			if(Number(_input) > Number(_end))
			{

				return false;
			}
		}
	}
	else
	{
		return false;
	}
	return true;
};
Ext.util.isNumValid1 = function(_input,_begin,_end)
{	
	if(!isNaN(_input))
	{
		if(_begin != '')
		{
			if(Number(_input) < Number(_begin))
			{	

				return false;
			}
		}
		if(_end != '')
		{
			if(Number(_input) >= Number(_end))
			{

				return false;
			}
		}
	}
	else
	{
		return false;
	}
	return true;
};
Ext.util.isBiggerEqualThan0 = function(_input,_iconLoc)
{
	var errMsg = "";

	if(!isNaN(_input.value))
	{
		if(Number(_input.value) < 0 && _input.value !='')
		{
			errMsg = "82";
		}
	}
	else
	{
		errMsg = "82";
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};
Ext.util.isFormatted = function(_input,_pattern)
{	
	
	if(_input.match(_pattern))
		return true;
	return false;
};
Ext.util.chkDate = function(_val,_default) {
    var errMsg1 = "";
    if(_val.length > 0 && _val != '//' ) {
        var dParts = _val.split('/');
        if (dParts.length == 3) {
            var _Yy = Ext.util.convertDefault(dParts[2],_default);
            var _Mm = Ext.util.convertDefault(dParts[1],_default);
            var _Dd = Ext.util.convertDefault(dParts[0],_default);
            if (Ext.util.chkYy(_Yy) == "" && Ext.util.chkMm(_Mm) == "" && Ext.util.chkDd(_Dd) == "") {
                _Mm = _Mm - 1;
                var fullYear;
                if (_Yy.length == 1) _Yy = "0" + _Yy;
                if (Number(_Yy) <= 20) {
                    if (_Yy.length == 2) fullYear = '20' + _Yy;
                    else if(_Yy.length == 3) fullYear = '0' + _Yy;
                } else {
                    if (_Yy.length == 2) fullYear = '19' + _Yy;
                    else if (_Yy.length == 3) fullYear = '0' + _Yy;
                }
                var tempDate = new Date(fullYear,_Mm,_Dd);
                if ((fullYear == tempDate.getFullYear()) && (_Mm == tempDate.getMonth()) && (_Dd == tempDate.getDate())) {
                    var curDate = new Date();
                    if (tempDate > curDate) errMsg1 = "17";
                } else errMsg1 = "15";
            } else {
                if (Ext.util.chkDd(_Dd) != ""){
                    errMsg1 = Ext.util.chkDd(_Dd);
                } else {
                    if (Ext.util.chkMm(_Mm) != "") errMsg1 = Ext.util.chkMm(_Mm);
                    else errMsg1 = Ext.util.chkYy(_Yy);
                }
            }
        } else errMsg1 = "16";
    }
    return errMsg1;
};
Ext.util.checkDobDt = function(_dobNode,_default,_iconLoc) 
{
	var errMsg = "";
	var dob = _dobNode.value;
	if(dob.length!=0)
	{
		var dParts = dob.split('/');
		if(dParts.length==3)
		{
			var _Yy = dParts[2];
			var _Mm = Ext.util.convertDefault(dParts[1],_default);
			var _Dd = Ext.util.convertDefault(dParts[0],_default);
			errMsg = Ext.util.chkYy4(_Yy);
			if(errMsg == "")
			{
				errMsg = Ext.util.chkMm(_Mm);
				if(errMsg == "")
				{
					errMsg = Ext.util.chkDd(_Dd);
					if(errMsg == "")
					{
						_Mm = _Mm - 1;
						var tempDate = new Date(_Yy,_Mm,_Dd);
						if ( (_Yy == tempDate.getFullYear()) &&
							(_Mm == tempDate.getMonth()) &&
							(_Dd == tempDate.getDate()) )
						{

							var curDate = new Date();																
							if(tempDate > curDate)
							{
								errMsg = "17";
							}							
						} 
						else
						{
							errMsg = "15";
						}
					}
				}
			}

		}
		else
		{
			errMsg = "16";
		}
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};
Ext.util.chkBirthDate = function(_val,_default) 
{

	var errMsg1 = "";
	if(_val.length > 0 && _val != '//' )
	{
		var dParts = _val.split('/');

		if(dParts.length==3)
		{
			var _Yy = Ext.util.convertDefault(dParts[2],_default);
			var _Mm = Ext.util.convertDefault(dParts[1],_default);
			var _Dd = Ext.util.convertDefault(dParts[0],_default);

			if(Ext.util.chkYy(_Yy) == ""&&Ext.util.chkMm(_Mm) == ""&&Ext.util.chkDd(_Dd) == "")
			{
				_Mm = _Mm - 1; 
				var fullYear;
				if(_Yy.length == 1)
					_Yy = "0" + _Yy;
				if(Number(_Yy) < 20)
					fullYear = '20' + _Yy;
				else
					fullYear = '19' + _Yy;
				var tempDate = new Date(fullYear,_Mm,_Dd);


				if ( (fullYear == tempDate.getFullYear()) &&
					(_Mm == tempDate.getMonth()) &&
					(_Dd == tempDate.getDate()) )
				{

					var curDate = new Date();
					//curdate = curdate.getUTCDate();
					
					if(tempDate > curDate)
					{
						errMsg1 = "30";
					}

				}
				else
				{
					errMsg1 = "15";
				}
			}
			else
			{
				if(Ext.util.chkDd(_Dd) != ""){
					errMsg1 = Ext.util.chkDd(_Dd);
				} else 
				{
					if(Ext.util.chkMm(_Mm) != "")
						errMsg1 = Ext.util.chkMm(_Mm);
					else
						errMsg1 = Ext.util.chkYy(_Yy);
				}
			}
		}
		else
		{
			errMsg1 = "16";
		}
	}
	return errMsg1;
};
Ext.util.chkDt = function(_val,_default) 
{
	var errMsg1 = "";
	if(_val.length > 0 && _val != '//' )
	{
		var dParts = _val.split('/');

		if(dParts.length==3)
		{
			var _Yy = Ext.util.convertDefault(dParts[2],_default);
			var _Mm = Ext.util.convertDefault(dParts[1],_default);
			var _Dd = Ext.util.convertDefault(dParts[0],_default);

			if(Ext.util.chkYy(_Yy) == ""&&Ext.util.chkMm(_Mm) == ""&&Ext.util.chkDd(_Dd) == "")
			{
				_Mm = _Mm - 1; 
				var fullYear;
				if(_Yy.length == 1)
					_Yy = "0" + _Yy;
				if(Number(_Yy) < 20)
					fullYear = '20' + _Yy;
				else
					fullYear = '19' + _Yy;
				var tempDate = new Date(fullYear,_Mm,_Dd);

				if ( (fullYear != tempDate.getFullYear()) ||
					(_Mm != tempDate.getMonth()) ||
					(_Dd != tempDate.getDate()) )
				{

					errMsg1 = "15";
				}
				
			}
			else
			{
				errMsg1 = "15";
			}
		}
		else
		{
			errMsg1 = "16";
		}
	}
	return errMsg1;
};
Ext.util.chkNextDate = function(_val,_default) 
{
	var errMsg1 = "";
	if(_val.length > 0 && _val != '//')
	{
		var dParts = _val.split('/');

		if(dParts.length==3)
		{
			var _Yy = Ext.util.convertDefault(dParts[2],_default);
			var _Mm = Ext.util.convertDefault(dParts[1],_default);
			var _Dd = Ext.util.convertDefault(dParts[0],_default);

			if(Ext.util.chkYy(_Yy) == ""&&Ext.util.chkMm(_Mm) == ""&&Ext.util.chkDd(_Dd) == "")
			{
				_Mm = _Mm - 1; 
				var fullYear;
                                var curDate = new Date();
                                var currYear = curDate.getFullYear() - 2000;
				if(_Yy.length == 1)
					_Yy = "0" + _Yy;
                                // Assume century based on a 5-yr window from
                                // the current year.
				if(Number(_Yy) < currYear + 5)
					fullYear = '20' + _Yy;
				else
					fullYear = '19' + _Yy;
				var tempDate = new Date(fullYear,_Mm,_Dd);

				if ( (fullYear == tempDate.getFullYear()) &&
					(_Mm == tempDate.getMonth()) &&
					(_Dd == tempDate.getDate()) )
				{
					var curDate = new Date();
					//curdate = curdate.getUTCDate();
					if(tempDate < curDate)
					{
						errMsg1 = "18";
					}

				}
				else
				{
					errMsg1 = "15";
				}
			}
			else
			{
				if(Ext.util.chkDd(_Dd) != "")
					errMsg1 = Ext.util.chkDd(_Dd);
				else 
				{
					if(Ext.util.chkMm(_Mm) != "") {
						errMsg1 = Ext.util.chkMm(_Mm);
					} else {
						errMsg1 = Ext.util.chkYy(_Yy);
					}	 
				}
			}
		}
		else
		{
			errMsg1 = "16";
		}
	}
	return errMsg1;
};
Ext.util.showErrorIcon = function(_message, _location)
{
	var _errLoc = _location;
	var htmlStr = _errLoc.innerHTML;
	var loc = -1;
	if(htmlStr!=null){
		loc = htmlStr.toUpperCase().indexOf("</SPAN>");
	}
	if(_message != '')
	{
		if(_errLoc != null)
		{
			if(loc == -1)
			{
				_errLoc.innerHTML = "<SPAN title='" + errors[_message] + "'><img src='images/exclamation.gif' align='right'></SPAN>" + htmlStr;
			}
			else
			{
				_errLoc.innerHTML = "<SPAN title='" + errors[_message] + "'><img src='images/exclamation.gif' align='right'></SPAN>" + htmlStr.substring(loc + 7); 
			}
		}
	}
	else
	{
		if(_errLoc != null)
		{	
			if(loc >= 0)
			{
				_errLoc.innerHTML = htmlStr.substring(loc + 7); 
			}
		}
	}
};
Ext.util.showErrorIconWithMsg = function(_message, _location)
{

	var _errLoc = _location;
	var htmlStr = _errLoc.innerHTML;
	var loc = -1;
	if(htmlStr!=null)
		loc = htmlStr.toUpperCase().indexOf("</SPAN>");
	
	if(_message.length > 0)
	{
		if(_errLoc != null)
		{
			if(loc == -1)
			{
				_errLoc.innerHTML = "<SPAN title='" + _message + "'><img src='images/exclamation.gif' align='right'></SPAN>" + htmlStr;
			}
			else
			{
				_errLoc.innerHTML = "<SPAN title='" + _message + "'><img src='images/exclamation.gif' align='right'></SPAN>" + htmlStr.substring(loc + 7); 
			}
		}
	}
	else
	{
		if(_errLoc != null)
		{

			if(loc >= 0)
			{
				_errLoc.innerHTML = htmlStr.substring(loc + 7); 
			}
		}
	}
	
};
Ext.util.showErrorMessage = function( _errCount) 
{
	if(Number(_errCount)>0)
	{
		document.getElementById('errorMsg').innerHTML = errorMsg;
		document.getElementById('errorText').innerHTML = "<span id='errorWhite'>" + errors[1] + "</span>";
	}
	else
	{
		document.getElementById('errorMsg').innerHTML = "&nbsp;";
		document.getElementById('errorText').innerHTML = "";
	}
		
};

Ext.util.validateMonth = function(_node, _iconLoc, _default, _onload)
{
	var errMsg = "";
	errMsg = Ext.util.chkMm(_node.value);		
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
}
Ext.util.validateYear = function(_node, _iconLoc, _default, _onload)
{
	var errMsg = "";
	errMsg = Ext.util.chkYy(_node.value);	
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};
Ext.util.validateMY = function(_monthNode,_yearNode, _iconLoc, _default, _onload)
{
	var errMsg = "";

	var monthVal = _monthNode.value;
	var yearVal = _yearNode.value;
	if(_onload == true && monthVal == '')
	{
		monthVal = '01';
	}
	if(_onload == true && yearVal == '')
	{
		yearVal = '01';
	}
	if(monthVal != '' && yearVal != '')
	{
		if(monthVal == _default )
		{
			monthVal = '01';
		}
		if(yearVal == _default )
		{
			yearVal = '01';
		}
		errMsg = Ext.util.chkDate("01/"+monthVal+"/"+yearVal,_default);

	}
	else if((monthVal == '' && yearVal != '') || (monthVal != '' && yearVal == ''))
	{
		errMsg = '15';	
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};
Ext.util.splitDate = function (_dateNode, _ddNode, _mmNode, _yyNode)
{
	var ddVal = "";
	var mmVal = "";
	var yyVal = "";
	if(_dateNode.value.length > 0 && _dateNode.value !='//')
	{
		var dParts = _dateNode.value.split('/');
    _ddNode.value = dParts[0].toUpperCase(); //Converts 'x' to uppercase
		if (_ddNode.value.length == 1) { //Checks and adds leading zero if one digit
      _ddNode.value = '0' + dParts[0];
    }
    _mmNode.value = dParts[1].toUpperCase();
    if (_mmNode.value.length == 1) {
      _mmNode.value = '0' + dParts[1];
    }
    _yyNode.value = dParts[2];
	} 
	else 
	{
		_ddNode.value = "";
		_mmNode.value = "";
		_yyNode.value = "";
	}
};

Ext.util.mergeDate = function (_dateNode, _ddNode, _mmNode, _yyNode)
{
	var ddVal = "";
	var mmVal = "";
	var yyVal = "";
	var dateVal = _ddNode.value + "/" + _mmNode.value + "/" + _yyNode.value;
	if(dateVal != "//")
	{
		_dateNode.value = dateVal;
	}
};

Ext.util.getElements = function(_form, _name)
{
	var i;
	var j = 0;
	var result = new Array();
	for(i = 0; i < _form.elementsByTag("INPUT").length;i++)
	{	
		if(_form.elements[i].type == "text")
		{	
			if((_form.elements[i].id).indexOf(_name)==0)
			{
				result[j++] = _form.elements[i];
			}
		}
	}
	return result;
};

Ext.util.getElements = function(_form, _name)
{
	var i;
	var j = 0;
	var result = new Array();
	for(i = 0; i < _form.elementsByTag("INPUT").length;i++)
	{	
		if(_form.elements[i].type == "text")
		{	
			
			if((_form.elements[i].id).indexOf(_name)==0)
			{
				result[j++] = _form.elements[i];
			}
		}
	}
	return result;
};

Ext.util.getElementsByType = function(_form,_type)
{
	var i;
	var j = 0;
	var result = new Array();
	for(i = 0; i < _form.elements.length;i++)
	{	
		if(_form.elements[i].type == _type)
		{	
			
			result[j++] = _form.elements[i];
		}
		
	}
	return result;
};
Ext.util.clickRadio = function(_form)
{
	var radioArray = new Array();
	var nameArray = new Array();
	
	for(var i = 0; i < _form.elements.length;i++)
	{	
		if(_form.elements[i].type == 'radio')
		{	
			radioArray[_form.elements[i].id] = _form.elements[i].checked;
			nameArray[_form.elements[i].id] = _form.elements[i].name;
			this.dom.name = this.dom.id;
			Ext.get(_form.elements[i]).on('click', function(){

				if(radioArray[this.dom.id] == true)
				{
					this.dom.checked = false;
					radioArray[this.dom.id] = false;
				}
				else
				{
					/**var others = document.getElementsByName(this.dom.name);
					if(others.length > 1)
					{
						for(var j=0;j<others.length;j++)
						{
							radioArray[others[j].id] = false;
							others[j].checked = false;
						}
					}
					*/
					this.dom.checked = true;
					radioArray[this.dom.id] = true;
					
				}
				
			});

		}
	}
	return radioArray;
}
Ext.util.changeElementStatusByName = function(_form,_name,_status)
{
	var i;
	for(i = 0; i < _form.elements.length;i++)
	{	
		if(_form.elements[i].name.substring(0,_name.length) == _name)
		{	

			switch(_form.elements[i].type)
			{		
				case "radio":
					_form.elements[i].disabled = _status;
					break;
				case "checkbox":
					_form.elements[i].disabled = _status;
					break;
				default:
					break;
					
			}
		}
	}
};
Ext.util.validateDateField = function(_node,_iconLoc, _default) 
{	
	var errMsg = "";
	errMsg = Ext.util.chkDate(_node.value,_default);
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
	
};
Ext.util.validateDateFieldNonPatient = function(_node,_iconLoc, _default) 
{	
	
	var errMsg = "";
	errMsg = Ext.util.chkDate(_node.value,_default);
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
	
};
Ext.util.validateRxDispDate= function(_node,_iconLoc, _default) 
{	
	
	var errMsg = "";
	errMsg = Ext.util.chkDate(_node.value,_default);
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
	
};
Ext.util.validateDateFieldReferrals= function(_node,_iconLoc, _default) 
{	
	
	var errMsg = "";
	errMsg = Ext.util.chkDt(_node.value,_default);
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
	
};
Ext.util.validateDateFieldPatient = function(_node,_iconLoc, _default) 
{	
	var errMsg = "";
	errMsg = Ext.util.chkNextDate(_node.value,_default);
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
	
};
Ext.util.validateBirthDate = function(_node, _iconLoc, _default)
{
	var errMsg = "";
	errMsg = Ext.util.chkBirthDate(_node.value, _default);
	Ext.util.showErrorIcon(errMsg, _iconLoc);
	return errMsg;
};
Ext.util.checkTemp = function(_node,_unit1,_unit2,_radio,_flag, _iconLoc)
{
	var errMsg = '';	
	if(_unit1!=null&&_unit2!=null)
	{
		if(_node.value.length > 0)
		{	
			if((_flag && _unit2.checked == true)||(!_flag&&_radio[_unit2.tabIndex][1]==false&&_unit2.checked == true))
			{
				if(!Ext.util.isNumValid(_node.value,89.6,109.4))
				{
					errMsg = '29';
				}
			}
			else if((_flag && _unit1.checked == true)||(!_flag&&_radio[_unit1.tabIndex][1]==false&&_unit1.checked == true) )
			{
				if(!Ext.util.isNumValid(_node.value,32,43))
				{
					errMsg = '21';
				}
			}

		}
	}
	else
	{
		if(!Ext.util.isNumValid(_node.value,32,43))
		{
			errMsg = '21';
		}
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};
Ext.util.checkTemp2 = function(_node1,_node2,_unit1,_unit2,_radio,_flag, _iconLoc)
{
	var errMsg = '';	
	var sum = '';
	if(_node1.value.length > 0)
	{
		sum = _node1.value;
		if(_node2.value.length > 0)
			sum += '.' + _node2.value;
	}else if(_node2.value.length > 0)
	{
		sum = '0.' + _node2.value;
	}
	if(_unit1!=null&&_unit2!=null)
	{		
		if(_node1.value.length > 0||_node2.value.length>0)
		{	

			if((_flag && _unit2.checked == true)||(!_flag&&_radio[_unit2.tabIndex][1]==false&&_unit2.checked == true))
			{
				if(!Ext.util.isNumValid(sum,89.6,109.4))
				{
					errMsg = '29';
				}
			}
			else if((_flag && _unit1.checked == true)||(!_flag&&_radio[_unit1.tabIndex][1]==false&&_unit1.checked == true) )
			{
				if(!Ext.util.isNumValid(sum,35,43))
				{
					errMsg = '21';
				}
			}
		}
	}
	else
	{
		if(!Ext.util.isNumValid(sum,35,43))
		{
			errMsg = '21';
		}
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};
Ext.util.checkValueWithUnits = function(_node,_unit1,_lower1,_upper1,_unit2,_lower2,_upper2, _iconLoc)
{
	var errMsg = '';	
	if(_node.value.length > 0)
	{
		if(_unit2!=null && _unit2.checked == true)
		{

			errMsg = Ext.util.isValueInBound(_node,_iconLoc,_lower2,_upper2,"");
			
		}
		else if(_unit1!=null && _unit1.checked == true)
		{
			errMsg = Ext.util.isValueInBound(_node,_iconLoc,_lower1,_upper1,"");
		}
	  else
		{
			if(!Ext.util.isNumValid(_node.value,_lower1,_upper1))
			{
				errMsg = Ext.util.isValueInBound(_node,_iconLoc,_lower1,_upper1,"");
			}
		}
	}
	return errMsg;
};
Ext.util.checkUnit = function(_node,_unit1,_unit2,_radioArr,_flag,_iconLoc)
{

	var errMsg = '';

	if(_node.value.length > 0)
	{
		_unit1.disabled = false;
		_unit2.disabled = false;
		if(_flag)
		{
			if(_unit1.checked == false && _unit2.checked == false)
			{
				errMsg = '74';

			}
		}
		else
		{
			if(_radioArr[_unit1.tabIndex][1] == _unit1.checked && _radioArr[_unit2.tabIndex][1] == _unit2.checked)
			{
				errMsg = '74';

			}			
		}
	} 
	else
	{
		_unit1.checked = false;
		_unit2.checked = false;
		_unit1.disabled = true;
		_unit2.disabled = true;

	}
	Ext.util.showErrorIcon(errMsg,_iconLoc)
	return errMsg;
};
Ext.util.checkUnit2 = function(_node1,_node2,_unit1,_unit2,_radioArr,_flag,_iconLoc)
{

	var errMsg = '';

	if(_node1.value.length > 0||_node2.value.length>0)
	{
		_unit1.disabled = false;
		_unit2.disabled = false;
		if(_flag)
		{
			if(_unit1.checked == false && _unit2.checked == false)
			{
				errMsg = '74';

			}
		}
		else
		{
			if(_radioArr[_unit1.tabIndex][1] == _unit1.checked && _radioArr[_unit2.tabIndex][1] == _unit2.checked)
			{
				errMsg = '74';

			}			
		}
	} 
	else
	{
		_unit1.checked = false;
		_unit2.checked = false;
		_unit1.disabled = true;
		_unit2.disabled = true;

	}
	Ext.util.showErrorIcon(errMsg,_iconLoc)
	return errMsg;
};
Ext.util.checkUnit1 = function(_node,_unit1,_unit2,_iconLoc)
{
	var errMsg = '';

	if(_node.value.length > 0)
	{

		if(_unit1.checked == false && _unit2.checked == false)
		{
			errMsg = '74';

		}
	} 
	
	Ext.util.showErrorIcon(errMsg,_iconLoc)
	return errMsg;
};
Ext.util.enableAssociated = function(_node,_arr)
{
	for(var i=0; i < _arr.length; i++)
	{
		if(_arr[i] != null){
			_arr[i].disabled = !_node.checked;
			if(!_node.checked)
			{
				if(_arr[i].type == 'radio'|| _arr[i].type == 'checkbox')
					_arr[i].checked = false;
				if(_arr[i].type == 'text')
					_arr[i].value = '';
			}
		}
	}
};
Ext.util.disableAssociated = function(_node,_arr)
{
	for(var i=0; i < _arr.length; i++)
	{
		_arr[i].disabled = _node.checked;
		if(_node.checked)
		{
			if(_arr[i].type == 'radio'|| _arr[i].type == 'checkbox')
				_arr[i].checked = false;
			if(_arr[i].type == 'text')
				_arr[i].value = '';
		}
	}
};
Ext.util.enableAssociatedDt = function(_node,_dt)
{
	_dt.setDisabled(!_node.checked);
	if(!_node.checked)
	{
		_dt.setValue("");
	}
	
};
Ext.util.selectToday = function(_node,_dt)
{
	if(!_node.checked)
	{
		_dt.setValue("");
		_dt.setDisabled(false);
	}
	else
	{
		var time =new Date();
		var timestr = '';
		if(time.getDate()<10)
			timestr = '0' + time.getDate();
		else
			timestr = time.getDate();
		
		if(time.getMonth() < 9)
			timestr = timestr + '/' + '0' + (time.getMonth() + 1);
		else
			timestr = timestr + '/' + '0' + time.getMonth();
		
		var yearstr = String(time.getFullYear());
		if(yearstr.length == 4)
			timestr = timestr + '/' + yearstr.substring(2);
		else
			timestr = timestr + '/' + yearstr;
		_dt.setValue(timestr);
		_dt.setDisabled(true);
	}
}; 
 
Ext.util.setToVisitDt = function(_node,_dt) {
	// when _node is checked, set _dt to the visit date
	if(_node.checked) {
		_dt.setValue(document.forms[0].vDate.value); 
	}
}
 
Ext.util.compareToVisitDt = function(_dt, _node) {
	// when _dt doesn't match visit date, uncheck _node, else check it
	if(_dt != document.forms[0].vDate.value) {
		_node.checked = false; 
	} else {  
		_node.checked = true;
	}  
}

Ext.util.checkBPUnit = function(_bp1,_bp2,_unit1,_unit2,_radioArr, _flag, _iconLoc)
{
	var errMsg = '';
	if(_bp1.value.length > 0 || _bp2.value.length >0)
	{
		_unit1.disabled = false;
		_unit2.disabled = false;
		
		if(_flag)
		{
			if(_unit1.checked == false && _unit2.checked == false)
			{
				errMsg = '74';

			}
		}
		else
		{
			if(_radioArr[_unit1.tabIndex][1] == _unit1.checked && _radioArr[_unit2.tabIndex][1] == _unit2.checked)
			{
				errMsg = '74';

			}			
		}

	} 
	else
	{
			_unit1.checked = false;
			_unit2.checked = false;
			_unit1.disabled = true;
			_unit2.disabled = true;
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc)
	return errMsg;
};

Ext.util.checkBp1 = function(_node,_iconLoc,_default)
{
	var errMsg = "";

	if(_node.value.length > 0)
	{
		if(!Ext.util.isNumValid(_node.value,'0','300'))
		{
			errMsg = "22";
		}
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};
Ext.util.checkMotherPregWeeks = function(_node,_iconLoc,_default)
{
	var errMsg = "";

	if(_node.value.length > 0)
	{
		if(!Ext.util.isNumValid(_node.value,'0','45'))
		{
			errMsg = "86";
		}
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};
Ext.util.checkHU = function(_node,_iconLoc,_default)
{
	var errMsg = "";

	if(_node.value.length > 0)
	{
		if(!Ext.util.isNumValid(_node.value,'1','37'))
		{
			errMsg = "84";
		}
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};
Ext.util.checkCardRhythm = function(_node,_iconLoc,_default)
{
	var errMsg = "";

	if(_node.value.length > 0)
	{
		if(!Ext.util.isNumValid(_node.value,'0','500'))
		{
			errMsg = "85";
		}
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};
Ext.util.checkBp2 = function(_node,_iconLoc,_default)
{
	var errMsg = "";
	
	if(_node.value.length > 0)
	{
		if(!Ext.util.isNumValid(_node.value,'0','200'))
		{
			errMsg = "23";
		}
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc)
	return errMsg;
};
Ext.util.checkHr = function(_node,_iconLoc,_default)
{
	var errMsg = "";
	if(_node.value.length > 0)
	{
	
		if(!Ext.util.isNumValid(_node.value,'0','360'))
		{
			errMsg = "24";
		}
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc)
	return errMsg;
};
Ext.util.checkWeight = function(_node,_iconLoc,_default)
{
	var errMsg = "";
	if(_node.value.length > 0)
	{
		if(!Ext.util.isNumValid(_node.value,'0','500'))
		{
			errMsg = "25";
		}
	}
	
	Ext.util.showErrorIcon(errMsg,_iconLoc)
	return errMsg;
};
Ext.util.checkWeight2 = function(_node1,_node2,_iconLoc,_default)
{
	var errMsg = "";
	if(_node1.value.length > 0 || _node2.value.length>0)
	{
		var sum = '';
		if(_node1.value.length > 0)
		{
			sum = _node1.value;
			if(_node2.value.length>0)
				sum  += '.' + _node2.value;
		}
		else if ( _node2.value.length>0)
		{
			sum = '0.' + _node2.value;
		}
		if(!Ext.util.isNumValid(sum,'0','500'))
		{
			errMsg = "25";
		}
	}
	
	Ext.util.showErrorIcon(errMsg,_iconLoc)
	return errMsg;
};

Ext.util.checkRr = function(_node,_iconLoc,_default)
{
	var errMsg = "";	
	if(_node.value.length > 0)
	{
	
		if(!Ext.util.isNumValid(_node.value,'0','360'))
		{
			errMsg = "26";
		}
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc)
	return errMsg;
};
Ext.util.checkHeight = function(_node,_iconLoc,_default)
{
	var errMsg = "";
	if(_node.value.length > 0)
	{
	
		if(!Ext.util.isNumValid(_node.value,'0','3'))
		{
			errMsg = "27";
		}
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc)
	return errMsg;
};
Ext.util.checkHeightCm = function(_node,_iconLoc,_default)
{
	var errMsg = "";
	if(_node.value.length > 0)
	{
	
		if(!Ext.util.isNumValid(_node.value,1,99))
		{
			errMsg = "28";
		}
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc)
	return errMsg;
};
Ext.util.addError = function(_errors, _currLoc, _errTitle, _errMsg)
{
	var i=0,j=0;
	var result = new Array();
	var found = 0;
	if(_errMsg.length>0)
	{
		for(i=0,j=0;j<_errors.length;j++,i++)
		{
			result[0,i] = errors[0,j];
			if(_errors[0,j] == _errTitle)
			{
				result[1,i] = _errMsg;
				found = 1;
			}
			else
			{
				result[1,i] = _errors[1,j];
			}
		}
		if(found==0)
		{
			
			result[0,i] = _errTitle;
			result[1,i] = _errMsg;
		}	
	}	
	else
	{
		for(i=0,j=0;j<length;j++)
		{			
			if(_errors[0,j] != _errTitle)
			{
				result[0,i] = _errors[0,j];
		
				result[1,i] = _errors[1,j];
				i++;
			}
		}
	}
	
	
	
	return result;

};

Ext.util.getError = function(_titleArr,_msgArr, _errTitle)
{
	var i = 0;
	for(i = 0;i<_titleArr.length;i++)
	{
		if(_titleArr[i] == _errTitle)
		{

			return _msgArr[i];
		}
	}	
	return '';
};
Ext.util.addErrors = function(_titleArr,_msgArr, _errTitle, _errMsg,_errCount)
{

	var i = 0;
	var previousCount = _errCount;
	if(_errMsg!='')
	{
		for(i = 0;i<_titleArr.length;i++)
		{
			if(_titleArr[i] == _errTitle)
			{
				
				if(_msgArr[i] == '')
				{
					_errCount++;
				}
				_msgArr[i] = _errMsg;
				break;
			}
		}
		if(i == _titleArr.length)
		{
			_titleArr[i] = _errTitle;
			_msgArr[i] = _errMsg;
			_errCount++;
		}
	} 
	else
	{
		for(i = 0;i<_titleArr.length;i++)
		{
			if(_titleArr[i] == _errTitle && _msgArr[i]!='')
			{
				_msgArr[i] = '';
				_errCount--;
			}
		}
		
	}
	return _errCount;
};
Ext.util.showErrorHead = function(_titleArr,_msgArr, _errTitle, _errMsg,_errCount)
{

	var total = Ext.util.addErrors(_titleArr,_msgArr, _errTitle, _errMsg,_errCount);

	Ext.util.showErrorMessage(total);
	document.mainForm.errFields.value = _titleArr.toString();
	document.mainForm.errMsgs.value = _msgArr.toString();
	
	return total;
}
Ext.util.validateExclCheckboxPatient = function(_node, _name,_default)
{
	errMsg="";
	var boxes = _node.childNodes;
	var value = 0;
	for(var i = 0; i< boxes.length; i++){
		if(boxes[i].type=='checkbox' && boxes[i].name==_name && boxes[i].checked){
				value += boxes[i].value;
		}
	}
	if(value > Number(_default)){
		errMsg = "31";
	}
	return errMsg;

};
Ext.util.validateAge = function(_node, _iconLoc, _default)
{
	var errMsg = "";
	if(_node.value.length > 0)
	{

		if(!Ext.util.isNumValid(_node.value,'0',120))
		{
			errMsg = "31";
		}
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc)
	return errMsg;
};
Ext.util.isValueInBound = function(_node, _iconLoc,_lower, _upper, _default)
{
	var errMsg = '';
	var errMsgText = '';
	if(_node.value!=''&&_node.value.length > 0)
	{	

		if(!Ext.util.isNumValid(_node.value,_lower,_upper,""))
		{
			if(_lower != '' && _upper != '')
			{
				errMsg = '33';
				errMsgText = errors["33"];
				errMsgText = errMsgText.replace("{1}",_lower);
				errMsgText = errMsgText.replace("{2}",_upper);
			}
			else if(_lower != '')
			{
				errMsg = '61';
				errMsgText = errors["61"];
				errMsgText = errMsgText.replace("{1}",_lower);
			}
			else if(_upper != '')
			{
				errMsg = '62';
				errMsgText = errors["62"];
				errMsgText = errMsgText.replace("{1}",_upper);
			}
		}
	}
	Ext.util.showErrorIconWithMsg(errMsgText,_iconLoc)
	return errMsg;
};
Ext.util.isValueInBound1 = function(_node, _iconLoc,_lower, _upper, _default)
{
	var errMsg = '';
	var errMsgText = '';
	if(_node.value!=''&&_node.value.length > 0)
	{	

		if(!Ext.util.isNumValid1(_node.value,_lower,_upper,""))
		{
			if(_lower != '' && _upper != '')
			{
				errMsg = '33';
				errMsgText = errors["33"];
				errMsgText = errMsgText.replace("{1}",_lower);
				errMsgText = errMsgText.replace("{2}",_upper);
			}
			else if(_lower != '')
			{
				errMsg = '61';
				errMsgText = errors["61"];
				errMsgText = errMsgText.replace("{1}",_lower);
			}
			else if(_upper != '')
			{
				errMsg = '62';
			    errMsgText = errors["62"];
				errMsgText = errMsgText.replace("{1}",_upper);
			}
		}
	}
	Ext.util.showErrorIconWithMsg(errMsgText,_iconLoc)
	return errMsg;
};
Ext.util.checkUnique2 = function(_node1,_node2)
{
	if(_node1.checked == true)
	{
		_node2.checked = false;
	}

};
Ext.util.checkUnique = function(_node1,_node2,_node3)
{
	if(_node1.checked == true)
	{
		_node2.checked = false;
		_node3.checked = false;
	}

};
Ext.util.checkUnique4 = function(_node1,_node2,_node3,_node4)
{
	if(_node1.checked == true)
	{
		_node2.checked = false;
		_node3.checked = false;
		_node4.checked = false;
	}
}
Ext.util.checkUniqueRadioInOrder = function(_node1,_node2,_node3,_arr)
{

	if(_node1.checked == true)
	{
		_node2.checked = false;
		_node3.checked = false;

	}

};
Ext.util.checkUniqueCheckbox = function(_nodes, _loc)
{
	if(_nodes.length > 1)
	{
		if(Number(_loc) < _nodes.length && Number(_loc) >= 0)
		{
			if(_nodes[_loc].checked == true)
			{
				var i;
				for(i=0;i<Number(_loc);i++)
				{
					_nodes[i].checked = false;
				}
				for(i=_loc+1;i<_nodes.length;i++)
				{
					_nodes[i].checked = false;
				}
			}
		}
	}
}
Ext.util.checkUniqueRadio = function(_nodes, _loc,_arr)
{
	if(_nodes.length > 1)
	{
		if(Number(_loc) < _nodes.length && Number(_loc) >= 0)
		{
			var i;
			for(i=0;i<_nodes.length;i++)
			{
				if(i!=_loc)
				{
					_nodes[i].checked = false;
					
					_arr[_nodes[i].id]=false;
				}
				
			}
		}
	}
}
Ext.util.checkContinued = function(_name)
{
	if(document.getElementById(_name + 'Continued').checked == true)
	{
		if(_name != 'other3')
		{
			document.getElementById(_name + 'StopMm').disabled = true;
			document.getElementById(_name + 'StopYy').disabled = true;
		}
		else
		{
			document.getElementById(_name + 'SpMm').disabled = true;
			document.getElementById(_name + 'SpYy').disabled = true;
		}
	}
	else
	{
		if(_name != 'other3')
		{
			document.getElementById(_name + 'StopMm').disabled = false;
			document.getElementById(_name + 'StopYy').disabled = false;
		}
		else
		{
			document.getElementById(_name + 'SpMm').disabled = false;
			document.getElementById(_name + 'SpYy').disabled = false;
		}
	}
};
Ext.util.checkEmpty = function(_val)
{
	if(_val == '')
	{
		return true;
	}
};
Ext.util.checkFName = function(_node, _iconLoc)
{
	var errMsg = "";
	if(Ext.util.checkEmpty(_node.value))
	{
		errMsg = "41";
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};
Ext.util.checkLName = function(_node, _iconLoc)
{
	var errMsg = "";
	if(Ext.util.checkEmpty(_node.value))
	{
		errMsg = "42";
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};
Ext.util.checkClinicId = function(_node, _iconLoc)
{
	var errMsg = "";
	if(Ext.util.checkEmpty(_node.value))
	{
		errMsg = "43";
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};
Ext.util.checkNationalId = function(_node, _iconLoc)
{
	var errMsg = "";
	if(Ext.util.checkEmpty(_node.value))
	{
		errMsg = "44";
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};
Ext.util.setDefaultRadio = function(_nodes, _default)
{
	if(_nodes.length > 1)
	{
		if(Number(_default) < _nodes.length && Number(_default) >= 0)
		{
			var i;
			for(i=0;i<_nodes.length;i++)
			{
				if(_nodes[i].checked == true)
					return;
			}
			_nodes[_default].checked = true;
		}
	}
};
Ext.util.getKeyByVal = function(_arr, _value)
{
	var i;
	for(i=0;i<_arr.length;i++)
	{
		if(_arr[i].constructor == Array)
		{
			if(_arr[i][0] == _value)
			{
				return i;
			}
		}
		else
		{
			if(_arr[i] == _value)
			{
				return i;
			}
		}
	}
	return -1;
};
Ext.util.getKeyByID = function(_arr, _id)
{
	var i;
	for(i=0;i<_arr.length;i++)
	{
		if(_arr[i].id == _id)
		{
			return i;
		}
	}
	return -1;
}
Ext.util.getKeyByID1 = function(_arr, _id)
{
	var i;
	for(i=0;i<_arr.length;i++)
	{
		if(_arr[i] == _id)
		{
			return i;
		}
	}
	return -1;
}
Ext.util.checkDrugStartDate = function(_startMmNode,_startYyNode,_startErrLoc,_stopMmNode,_stopYyNode,_stopErrLoc,_default)
{
	var errMsgs = new Array(2);
	var startMsg = '';
	var stopMsg = '';
	var _startMm = _startMmNode.value;
	var _startYy = _startYyNode.value;
	var _stopMm = _stopMmNode.value;
	var _stopYy = _stopYyNode.value;

	startMsg = Ext.util.validateMY(_startMmNode,_startYyNode, _startErrLoc, _default, "");

	if(_stopMm.toUpperCase()!='NN'&&_stopYy.toUpperCase()!='NN')
	{
		stopMsg = Ext.util.validateMY(_stopMmNode,_stopYyNode, _stopErrLoc, _default, "");	
		if(stopMsg==''&&startMsg==''&&((_startMm!=''&&_startYy!=''&&_stopMm!=''&&_stopYy!='')||(_startMm==''&&_startYy!=''&&_stopMm==''&&_stopYy!='')))
		{
			 var _startYy4 = Ext.util.getYear4(_startYy);
			 var _stopYy4 = Ext.util.getYear4(_stopYy);
			 if((Number(_startYy4) > Number(_stopYy4))||(_startYy4 ==_stopYy4 && Number(_startMm) > Number(_stopMm)))
			 {
				startMsg = '45'; 
			 }
		}
		else if((_startMm==''&&_startYy ==''&&(_stopMm!=''||_stopYy!=''))&&startMsg=='')
		{
			startMsg = '11';
		}
	}
	Ext.util.showErrorIcon(startMsg,_startErrLoc);
	errMsgs[0] = startMsg;
	errMsgs[1] = stopMsg;
	return errMsgs;
};
Ext.util.checkDrugStartStopDate = function(_startMmNode,_startYyNode,_stopMmNode,_stopYyNode,_startErrLoc,_stopErrLoc,_errFields,_errMsgs)
{
	var errCount = 0;
	var startMsg = '';
	var stopMsg = '';
	var _startMm = _startMmNode.value;
	var _startYy = _startYyNode.value;
	var _stopMm = _stopMmNode.value;
	var _stopYy = _stopYyNode.value;

	startMsg = Ext.util.validateMY(_startMmNode,_startYyNode, _startErrLoc, "", "");
	errCount = Ext.util.showErrorHead(errFields,errMsgs,_startMmNode.id.substring(0,_startMmNode.id.length-2),errMsg,errCount);
	if(_stopMm.toUpperCase()!='NN'&&_stopYy.toUpperCase()!='NN')
	{
		stopMsg = Ext.util.validateMY(_stopMmNode,_stopYyNode, _stopErrLoc, "", "");	
		errCount = Ext.util.showErrorHead(errFields,errMsgs,_stopYyNode.id.substring(0,_stopYyNode.id.length-2),errMsg,errCount);
		if(stopMsg==''&&startMsg==''&&((_startMm!=''&&_startYy!=''&&_stopMm!=''&&_stopYy!='')||(_startMm==''&&_startYy!=''&&_stopMm==''&&_stopYy!='')))
		{
			 var _startYy4 = Ext.util.getYear4(_startYy);
			 var _stopYy4 = Ext.util.getYear4(_stopYy);
			 if((Number(_startYy4) > Number(_stopYy4))||(_startYy4 ==_stopYy4 && Number(_startMm) > Number(_stopMm)))
			 {
				startMsg = '45';
				Ext.util.showErrorIcon(startMsg,_startErrLoc);				
				errCount = Ext.util.showErrorHead(errFields,errMsgs,_startMmNode.id.substring(0,_startMmNode.id.length-2),errMsg,errCount);
			 }
			 
		}
		else if((_startMm==''&&_startYy ==''&&(_stopMm!=''||_stopYy!=''))&&startMsg=='')
		{
			startMsg = '11';
			Ext.util.showErrorIcon(startMsg,_startErrLoc);				
			errCount = Ext.util.showErrorHead(errFields,errMsgs,_startMmNode.id.substring(0,_startMmNode.id.length-2),errMsg,errCount);
		}
	}
	return errCount;
};
Ext.util.checkDrugStartDate1 = function(_startMmNode,_startYyNode,_startErrLoc,_stopMmNode,_stopYyNode,_continued, _default)
{
	var startMsg = '';
	var stopMsg = '';
	var _startMm = _startMmNode.value;
	var _startYy = _startYyNode.value;
	var _stopMm = _stopMmNode.value;
	var _stopYy = _stopYyNode.value;

	
	if((_startMm!=''||_startYy!='')&&(_stopMm==''&&_stopYy=='')&&_continued.checked == false)
	{
		startMsg = '72'; 
		Ext.util.showErrorIcon(startMsg,_startErrLoc);
	}
	else if(_startMm!=''||_startYy!='')
	{
		startMsg = Ext.util.validateMY(_startMmNode,_startYyNode, _startErrLoc, _default, "");
	}
	return startMsg;
};
Ext.util.checkDrugStopDate1 = function(_startMmNode,_startYyNode,_stopMmNode,_stopYyNode,_stopErrLoc,_continued, _default)
{
	var startMsg = '';
	var stopMsg = '';
	var _startMm = _startMmNode.value;
	var _startYy = _startYyNode.value;
	var _stopMm = _stopMmNode.value;
	var _stopYy = _stopYyNode.value;

	if(_stopMm!=''||_stopYy!='')
	{
		stopMsg = Ext.util.validateMY(_stopMmNode,_stopYyNode, _stopErrLoc, _default, "");	
		if(stopMsg==''&&((_startMm!=''&&_startYy!=''&&_stopMm!=''&&_stopYy!='')||(_startMm==''&&_startYy!=''&&_stopMm==''&&_stopYy!='')))
		{
			 var _startYy4 = Ext.util.getYear4(_startYy);
			 var _stopYy4 = Ext.util.getYear4(_stopYy);
			 if((Number(_startYy4) > Number(_stopYy4))||(_startYy4 ==_stopYy4 && Number(_startMm) > Number(_stopMm)))
			 {
				stopMsg = '45'; 
			 }
			
		}
	}
	Ext.util.showErrorIcon(stopMsg,_stopErrLoc);
	return startMsg;
};
Ext.util.checkStartStopDate = function(_startMmNode,_startYyNode,_startErrLoc,_stopMmNode,_stopYyNode,_stopErrLoc,_default)
{
	var errMsg = '';
	if(_startMmNode.value!=''&&_startYyNode.value!=''&&_stopMmNode.value!=''&&_stopYyNode.value!='')
	{
		var startMm = Ext.util.convertDefault(_startMmNode.value, _default);
		var startYy4 = Ext.util.getYear4(Ext.util.convertDefault(_startYyNode.value, _default));
		var stopMm = Ext.util.convertDefault(_stopMmNode.value, _default);
		var stopYy4 = Ext.util.getYear4(Ext.util.convertDefault(_stopYyNode.value, _default));
		if((Number(startYy4) > Number(stopYy4))||(startYy4 ==stopYy4 && Number(startMm) > Number(stopMm)))
		{
			errMsg = '45'; 
		}	
	}
	Ext.util.showErrorIcon(errMsg,_startErrLoc);
	Ext.util.showErrorIcon(errMsg,_stopErrLoc);
	return errMsg;
}
Ext.util.checkOtherDrugStopDate = function(_startMmNode,_startYyNode,_startErrLoc,_stopMmNode,_stopYyNode,_stopErrLoc,_default,_continuing,_continuingErrLoc)
{
	var startMsg = '';
	var stopMsg = '';
	var _startMm = _startMmNode.value;
	var _startYy = _startYyNode.value;
	var _stopMm = _stopMmNode.value;
	var _stopYy = _stopYyNode.value;
	startMsg = Ext.util.validateMY(_startMmNode,_startYyNode, _startErrLoc, _default, "");
	stopMsg = Ext.util.validateMY(_stopMmNode,_stopYyNode, _stopErrLoc, _default, "");
	if(_stopMm.toUpperCase()!='NN'&&_stopYy.toUpperCase()!='NN')
	{	
		if(stopMsg==''&&startMsg==''&&((_startMm!=''&&_startYy!=''&&_stopMm!=''&&_stopYy!='')||(_startMm==''&&_startYy!=''&&_stopMm==''&&_stopYy!='')))
		{
			 var _startYy4 = Ext.util.getYear4(_startYy);
			 var _stopYy4 = Ext.util.getYear4(_stopYy);
			 if((Number(_startYy4) > Number(_stopYy4))||(_startYy4 ==_stopYy4 && Number(_startMm) > Number(_stopMm)))
			{
				stopMsg = '45'; 
			}
			Ext.util.showErrorIcon(stopMsg,_stopErrLoc);
		}
	}
	else
	{
		stopMsg = '';
		Ext.util.showErrorIcon(stopMsg,_stopErrLoc);
	}
	if((_stopMm!=''||_stopYy!='')&&_continuing.checked==true)
	{
		stopMsg = '47';
	} else
	{
		stopMsg = '';
	}
	Ext.util.showErrorIcon(stopMsg,_continuingErrLoc);
	return stopMsg;
};
Ext.util.checkDrugReasons = function(_stopMmNode,_stopYyNode,_reason1,_reason2,_reason3,_reason4,_reason5,_reasonsErrLoc)
{
	var reasonMsg = '';
	var _stopMm = _stopMmNode.value;
	var _stopYy = _stopYyNode.value;
	var i;
	if(_stopMm==''||_stopYy=='')
	{
		if(_reason1.checked == true||_reason2.checked == true||_reason3.checked == true||_reason4.checked == true||_reason5.checked == true)
		{
			reasonMsg = '46';

		}
	}
	else if(_stopMm != '' && _stopYy != '')
	{
		if(_reason1.checked == false && _reason2.checked == false && _reason3.checked == false && _reason4.checked == false && _reason5.checked == false)
		{
			reasonMsg = '76';

		}
	}
	Ext.util.showErrorIcon(reasonMsg,_reasonsErrLoc);
	return reasonMsg;
};
Ext.util.checkReasons = function(_stopMmNode,_stopYyNode,_reasons,_reasonsErrLoc)
{
	var reasonMsg = '';
	var _stopMm = _stopMmNode.value;
	var _stopYy = _stopYyNode.value;
	var i;
	if(_stopMm==''||_stopYy=='')
	{
		for(i=0;i<_reasons.length;i++)
		{
			if(_reasons[i].checked == true)
			{
				reasonMsg = '46';
				break;
			}
		}
	}
	Ext.util.showErrorIcon(reasonMsg,_reasonsErrLoc);
	return reasonMsg;
};
Ext.util.checkFollowupStopDate = function(_stopMmNode,_stopYyNode,_stopErrLoc,_default,_continuing,_continuingErrLoc,_stopReasons,_stopReasonsLoc,_interruptReasons,_interruptReasonsLoc)
{
	var stopMsg = '';

	var _stopMm = _stopMmNode.value;
	var _stopYy = _stopYyNode.value;
	stopMsg = Ext.util.validateMY(_stopMmNode,_stopYyNode, _stopErrLoc, _default, "");
	if((_stopMm!=''||_stopYy!='')&&_continuing.checked==true)
	{
		stopMsg = '47';
	} 
	Ext.util.showErrorIcon(stopMsg,_continuingErrLoc);
	stopMsg = Ext.util.checkReasons(_stopMmNode,_stopYyNode,_stopReasons,_stopReasonsLoc);
	stopMsg = Ext.util.checkReasons(_stopMmNode,_stopYyNode,_interruptReasons,_interruptReasonsLoc);
	return stopMsg;
};
Ext.util.checkDrugStopDate = function(_startMmNode,_startYyNode,_startErrLoc,_stopMmNode,_stopYyNode,_stopErrLoc,_default,_continuing,_continuingErrLoc, _reason1,_reason2,_reason3,_reason4,_reasonsErrLoc)
{
	var startMsg = '';
	var stopMsg = '';
	var _startMm = _startMmNode.value;
	var _startYy = _startYyNode.value;
	var _stopMm = _stopMmNode.value;
	var _stopYy = _stopYyNode.value;
	startMsg = Ext.util.validateMY(_startMmNode,_startYyNode, _startErrLoc, _default, "");
	if(_stopMmNode.value.toUpperCase()!='NN'&&_stopYyNode.value.toUpperCase()!='NN')
	{
		stopMsg = Ext.util.validateMY(_stopMmNode,_stopYyNode, _stopErrLoc, _default, "");
		if(stopMsg==''&&startMsg==''&&((_startMm!=''&&_startYy!=''&&_stopMm!=''&&_stopYy!='')||(_startMm==''&&_startYy!=''&&_stopMm==''&&_stopYy!='')))
		{

			var _startYy4 = Ext.util.getYear4(_startYy);
			var _stopYy4 = Ext.util.getYear4(_stopYy);
			if((Number(_startYy4) > Number(_stopYy4))||(_startYy4 == _stopYy4 && Number(_startMm) > Number(_stopMm)))
			{
				stopMsg = '45'; 
			}
			Ext.util.showErrorIcon(stopMsg,_stopErrLoc);
		}
	}
	if((_stopMm!=''||_stopYy!='')&&_continuing.checked==true)
	{
		stopMsg = '47';
	} 
	Ext.util.showErrorIcon(stopMsg,_continuingErrLoc);
	var i;
	reasonMsg = '';
	if(_stopMm==''||_stopYy=='')
	{
		if(_reason1.checked == true||_reason2.checked == true||_reason3.checked == true||_reason4.checked == true)
		{
			reasonMsg = '46';

		}
	}
	Ext.util.showErrorIcon(reasonMsg,_reasonsErrLoc);	
	return stopMsg;
};
Ext.util.checkDrugContinuing = function( _stopMmNode,_stopYyNode,_continuing,_continuingErrLoc)
{
	var continuingMsg = '';

	var _stopMm = _stopMmNode.value;
	var _stopYy = _stopYyNode.value;
	if((_stopMm!=''||_stopYy!='')&&_continuing.checked==true)
	{
		continuingMsg = '47';
	}
	Ext.util.showErrorIcon(continuingMsg,_continuingErrLoc);
	return continuingMsg;
};
Ext.util.checkDrugContinuing1 = function(_startMmNode,_startYyNode, _stopMmNode,_stopYyNode,_continuing,_continuingErrLoc)
{
	var continuingMsg = '';
	var _startMm = _startMmNode.value;
	var _startYy = _startYyNode.value;
	var _stopMm = _stopMmNode.value;
	var _stopYy = _stopYyNode.value;
	if(((_stopMm!=''||_stopYy!='')&&_continuing.checked==true))
	{
		continuingMsg = '47';
	}
	else if(_startMm=='' && _startYy ==''&&_continuing.checked==true)
	{
		continuingMsg = '76';
	}
	Ext.util.showErrorIcon(continuingMsg,_continuingErrLoc);
	return continuingMsg;
};
Ext.util.checkDtContinuing = function(_startMmNode,_startYyNode, _stopMmNode,_stopYyNode,_continuing,_startErrLoc)
{
	var msg = '';
	var _startMm = _startMmNode.value;
	var _startYy = _startYyNode.value;
	var _stopMm = _stopMmNode.value;
	var _stopYy = _stopYyNode.value;
	if((_startMm!=''||_startYy!='')&&_continuing.checked == false&&_stopMm == '' && _stopYy == '')
	{
		msg = '76';
	}

	Ext.util.showErrorIcon(msg,_startErrLoc);
	return msg;
};
Ext.util.checkOtherContinued = function(_stopMmNode,_stopYyNode,_stopErrLoc,_default)
{
	var msg = '';
	var _stopMm = _stopMmNode.value;
	var _stopYy = _stopYyNode.value;
	if(_stopMm.toUpperCase() != 'NN'&& _stopYy.toUpperCase() != 'NN')
	{
		msg = Ext.util.validateMY(_stopMmNode,_stopYyNode, _stopErrLoc, _default, "");
	}
	Ext.util.showErrorIcon(msg,_stopErrLoc);
	return msg;
};
Ext.util.checkStopReasons = function(_stopMmNode,_stopYyNode,_reasonArr, _reasonsErrLoc)
{
	var reasonMsg = '';
	var _stopMm = _stopMmNode.value;
	var _stopYy = _stopYyNode.value;
	var i;
	if(_stopMm==''||_stopYy=='')
	{
		for(i = 0; i < _reasonArr.length; i++)
		{
			if(_reasonArr[i].checked == true)
			{
				reasonMsg = '46';
				break;
			}
		}
	}
	else
	{
		for(i = 0; i < _reasonArr.length; i++)
		{
			if(_reasonArr[i].checked == true)
			{
				break;
			}
		}
		if(i >= _reasonArr.length)
		{
			reasonMsg = '79';
		}
	}
	Ext.util.showErrorIcon(reasonMsg,_reasonsErrLoc);
	return reasonMsg;
};
Ext.util.checkStartStopDates = function(_startMmNode,_startYyNode,_startErrLoc,_stopMmNode,_stopYyNode,_stopErrLoc,_default)
{
	var startMsg = '';
	var stopMsg = '';
	var _startMm = _startMmNode.value;
	var _startYy = _startYyNode.value;
	var _stopMm = _stopMmNode.value;
	var _stopYy = _stopYyNode.value;
	startMsg = Ext.util.validateMY(_startMmNode,_startYyNode, _startErrLoc, _default, "");
	stopMsg = Ext.util.validateMY(_stopMmNode,_stopYyNode, _stopErrLoc, _default, "");
	if(stopMsg==''&&startMsg==''&&((_startMm!=''&&_startYy!=''&&_stopMm!=''&&_stopYy!='')||(_startMm==''&&_startYy!=''&&_stopMm==''&&_stopYy!='')))
	{
		var _startYy4 = Ext.util.getYear4(_startYy);
		var _stopYy4 = Ext.util.getYear4(_stopYy4);
		if((Number(_startYy4) > Number(_stopYy4))||(_startYy4 == _stopYy4 && Number(_startMm) > Number(_stopMm)))
		{
			stopMsg = '45'; 
		}
		Ext.util.showErrorIcon(stopMsg,_stopErrLoc);
	}
	return stopMsg;
};
Ext.util.getDate = function(_val,_default)
{
	var dParts = _val.split('/');
	if(dParts.length==3)
	{
		var _Yy = Ext.util.convertDefault(dParts[2],_default);
		var _Mm = Ext.util.convertDefault(dParts[1],_default);
		var _Dd = Ext.util.convertDefault(dParts[0],_default);
		_Mm = _Mm - 1;
		var fullYear;
		if(_Yy.length == 1)
			_Yy = "0" + _Yy;
	  fullYear = Ext.util.getYear4(_Yy);
		return new Date(fullYear,_Mm,_Dd);
	}
	return new Date();
};
Ext.util.validateDateFieldNonPatientFurture = function(_node,_default,_visitDt, _iconLoc)
{
		
	var errMsg = '';
	
	if(_node.value.length > 0 && _node.value != '//')
	{
		errMsg = Ext.util.chkDt(_node.value,_default);
		if(errMsg == '')
		{
			var curDate;
			var tempDate = Ext.util.getDate(_node.value,_default);
			if(_visitDt.value.length > 0)
			{
				curDate = Ext.util.getDate(_visitDt.value,_default);
				if(tempDate.getFullYear()<curDate.getFullYear()||(tempDate.getFullYear()==curDate.getFullYear()&&tempDate.getMonth()<curDate.getMonth())||(tempDate.getFullYear()==curDate.getFullYear()&&tempDate.getMonth()==curDate.getMonth()&&tempDate.getDate()<=curDate.getDate()))
				{
					errMsg = '65';
				}
			}
			else
			{
				errMsg = '63';			
			}
		}
		Ext.util.showErrorIcon(errMsg,_iconLoc)
	}	
	return errMsg;
};
Ext.util.validateRxStdDosage = function(_stdDosage,_altDosage,_numdays,_errLoc)
{
	var errMsg = '';
	if(_stdDosage!=null&&_stdDosage.checked == true)
	{
		if(_altDosage.value != '')
		{
			errMsg = '50';
		}
		else if(_numdays.value =='')
		{
			errMsg = '51';
		}	
	}
	if(_errLoc!=null)
		Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};

Ext.util.validateRxAltDosageSpecify = function(_stdDosage,_altDosage,_numdays,_altDosageLoc)
{
	var errMsg = '';
	if((_altDosage.value != '' && _numdays.value =='')||(_stdDosage == null && ((_altDosage.value != '' && _numdays.value =='') || (_altDosage.value == '' && _numdays.value !=''))))
	{
		errMsg = '51';
	}
	Ext.util.showErrorIcon(errMsg,_altDosageLoc);
	return errMsg;
};
Ext.util.validateNumDaysDesc = function(_stdDosage,_altDosage,_numdays,_numdaysLoc )
{
	var errMsg = '';
	if((_numdays.value !='' && _altDosage.value =='' && _stdDosage!=null && _stdDosage.checked == false  )||(_stdDosage == null && ((_altDosage.value != '' && _numdays.value =='') || (_altDosage.value == '' && _numdays.value !=''))))
	{
		errMsg = '51';
	}
	Ext.util.showErrorIcon(errMsg,_numdaysLoc);
	if(errMsg == '' && _numdays.value != '')
	{
		errMsg = Ext.util.isNumberPositive(_numdays.value, _numdaysLoc);
	}
	return errMsg;
};
Ext.util.validateRxDispensed1 = function(_dispensed,_stdDosage,_altDosage,_errLoc)
{
	var errMsg = '';
	if(_dispensed.checked == true)
	{
		var tempFlag = false;
		if(_stdDosage==null)
		{
			tempFlag = false;
		}
		else
		{
			tempFlag = _stdDosage.checked;
		}
		if( tempFlag == false && _altDosage.value == '')
		{
			errMsg = '52';	
		}
	}
	
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};
Ext.util.validateRxDispensed2 = function(_dispensed,_date,_errLoc)
{
	var errMsg = '';
	if(_dispensed.checked == true)
	{
		if(_date.value == '//'||_date.value == '')
		{
			errMsg = '52';	
		}
		else
		{
			errMsg = Ext.util.chkDt(_date,'');
		}
	}

	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};
Ext.util.validateRxDispensed3 = function(_dispensed,_date,_errLoc)
{
	var errMsg = '';
	if(_date.value.length > 0 && _date.value != '//')
	{
		
		if(_dispensed.checked == false)
		{
			errMsg = '52';	
		}
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};
Ext.util.validateRxDispAltDosageSpecify1 = function(_dispensed,_altDosage,_numdays,_dispensedLoc)
{
	var errMsg = '';
	if(_altDosage.value != '' || _numdays.value != '')
	{
		if(_dispensed.checked == false)
		{
			errMsg = '53';	
		}

	}
	Ext.util.showErrorIcon(errMsg,_dispensedLoc);
	return errMsg;
};
Ext.util.validateRxDispAltDosageSpecify2 = function(_date,_altDosage,_numdays,_dateLoc)
{
	var errMsg = '';
	if(_altDosage.value != '' || _numdays.value != '')
	{

		if(_date.value == '//'||_date.value == '')
		{
			errMsg = '53';	
		}
	}
	Ext.util.showErrorIcon(errMsg,_dateLoc);
	return errMsg;
};
Ext.util.validateRxOtherPmtct = function(_name,_altDosage,_date,_nameLoc,_altDosageLoc,_dateLoc )
{
	var errMsg;

	if((_name.value == '' && _altDosage.value == '' &&  _date.value == '')||(_name.value != '' && _altDosage.value != '' &&  _date.value != ''))
	{
		errMsg = '';
	}
	else
	{
		errMsg = '55';
	}
	Ext.util.showErrorIcon(errMsg,_nameLoc);
	Ext.util.showErrorIcon(errMsg,_altDosageLoc);
	Ext.util.showErrorIcon(errMsg,_date);
	return errMsg;
};
Ext.util.validateAdherenceSideEffects = function(_name,_startMm,_startYy,_doseProp,_sideEffects, _nameErrLoc,_startErrLoc,_dosePropErrLoc,_sideEffectsErrLoc,_errFields,_errMsgs)
{
	var errCount = 0;
	var errMsg = "";
	var notEmpty = false;
	for(var i=0;i<_sideEffects.length;i++)
	{
		if(_sideEffects[i].checked == true)
		{
			notEmpty = true;
			break;
		}
	}
	if(notEmpty)
	{
		if(_name.value == '')
		{
			errMsg = '76';
		}
		else
		{
			errMsg = '';		
		}
		Ext.util.showErrorIcon(errMsg,_nameErrLoc);
		errCount = Ext.util.showErrorHead(errFields,errMsgs,_name.id,errMsg,errCount);
		if(_startMm.value != ''  ||  _startYy.value != '')
		{
			errMsg = Ext.util.validateMY(_startMm,_startYy,_startErrLoc, '', true);			
		}
		else
		{
			errMsg = '76';
			Ext.util.showErrorIcon(errMsg,_startErrLoc);
		}

		errCount = Ext.util.showErrorHead(errFields,errMsgs,_startMm.id.substring(0,_startMm.id.length-2),errMsg,errCount);
		if(_doseProp.value!='')
		{
			if(!Ext.util.isNumValid(_doseProp.value,0,100))
			{
				errMsg = '64';
			}
			else
			{
				errMsg = '';
			}

			Ext.util.showErrorIcon(errMsg,_dosePropErrLoc);
			errCount = Ext.util.showErrorHead(errFields,errMsgs,_doseProp.id,errMsg,errCount);
		}
		else
		{
			errMsg = '76';
			Ext.util.showErrorIcon(errMsg,_dosePropErrLoc);
			errCount = Ext.util.showErrorHead(errFields,errMsgs,_doseProp.id,errMsg,errCount);
		}
		if( _name!='' && (_startMm.value != '' || _startYy.value != '') && _doseProp.value!='')
		{
			errMsg = "";
		}
		else
		{
			errMsg = "76";
		}
		Ext.util.showErrorIcon(errMsg,_sideEffectsErrLoc);
		errCount = Ext.util.showErrorHead(errFields,errMsgs,_startMm.id.substring(0,_startMm.id.length-7) + 'SideEffects',errMsg,errCount);
	}
	else
	{
		if(_name.value != '')
		{
			errMsg = "76";
		}
		else
		{
			errMsg = "";

		}
		Ext.util.showErrorIcon(errMsg,_nameErrLoc);
		errCount = Ext.util.showErrorHead(errFields,errMsgs,_name.id,errMsg,errCount);
		if(_startMm.value != '' ||  _startYy.value != '')
		{
			errMsg = "76";
		}
		else
		{
			errMsg = "";
		}
		Ext.util.showErrorIcon(errMsg,_startErrLoc);
		errCount = Ext.util.showErrorHead(errFields,errMsgs,_startMm.id.substring(0,_startMm.id.length-2),errMsg,errCount);
		if(_doseProp.value!='')		
		{
			errMsg = "76";

		}
		else
		{
			errMsg = "";
		}
		Ext.util.showErrorIcon(errMsg,_dosePropErrLoc);
		errCount = Ext.util.showErrorHead(errFields,errMsgs,_doseProp.id,errMsg,errCount);
		if(errMsg !='')
		{
			errMsg = "76";
		}
		else
		{
			errMsg = "";
		}
		Ext.util.showErrorIcon(errMsg,_sideEffectsErrLoc);
		errCount = Ext.util.showErrorHead(errFields,errMsgs,_startMm.id.substring(0,_startMm.id.length-7) + 'SideEffects',errMsg,errCount);
	}
	
	return errCount;
};
Ext.util.validatePercent = function(_percent, _errLoc)
{
}
Ext.util.validateRxOther = function(_name,_altDosage,_numdays,_nameLoc,_altDosageLoc,_numdaysLoc )
{
	var errMsg;

	if((_name.value == '' && _altDosage.value == '' &&  _numdays.value == '')||(_name.value != '' && _altDosage.value != '' &&  _numdays.value != ''))
	{
		errMsg = '';	
	}
	else
	{
		errMsg = '55';
	}
	Ext.util.showErrorIcon(errMsg,_nameLoc);
	Ext.util.showErrorIcon(errMsg,_altDosageLoc);
	Ext.util.showErrorIcon(errMsg,_numdaysLoc);
	return errMsg;
};
Ext.util.validateRxDosageNumDays = function(_altDosage, _numdays, _altDosageLoc, _numdaysLoc)
{
	var errMsg;

	if(( _altDosage.value == '' &&  _numdays.value == '')||( _altDosage.value != '' &&  _numdays.value != ''))
	{
		errMsg = '';	
	}
	else
	{
		errMsg = '87';
		Ext.util.showErrorIcon(errMsg,_altDosageLoc);
		Ext.util.showErrorIcon(errMsg,_numdaysLoc);

	}


	if(errMsg == '' && _numdays.value != '')
	{
		errMsg = Ext.util.isNumberPositive(_numdays.value, _numdaysLoc);
		Ext.util.showErrorIcon(errMsg,_numdaysLoc);
	}


	return errMsg;
}

Ext.util.getBinary = function(_val)
{
	var result = '';
	if(!isNaN(_val))
	{
		var temp = _val;
		while(Number(temp) > Number('0'))
		{
			result =  Math.floor(temp%2) + '' + result;
			temp = Math.floor(temp/2);
		}
	}
	return result;
};
Ext.util.compareBin = function(_val1,_val2)
{
	var val1Str= Ext.util.getBinary(_val1);
	if(val1Str!='' && val1Str.length > Number(_val2) && val1Str.substring(val1Str.length-_val2-1,val1Str.length-_val2) == '1')
		return true;
	return false;
};
Ext.util.disableSection = function(_checkbox, _form, _formPrefix, _formatArr)
{
	var j;
	if(_checkbox.checked == true)
	{
		Ext.util.changeElementStatusByName(_form,_formPrefix,true);
		if(_formatArr!=null)
		{
			for(j=0;j<_formatArr.length;j++)
			{
				_formatArr[j].disable();;
			}
		}
	}
	else
	{
		Ext.util.changeElementStatusByName(_form,_formPrefix,false);
		if(_formatArr!=null)
		{
			for(j=0;j<_formatArr.length;j++)
			{
				_formatArr[j].enable();;
			}
		}
	}
	_checkbox.disabled = false;
};
Ext.util.disableSection1 = function(_checkbox, _form, _formPrefix, _formatArr,_textarea)
{
	var status = _checkbox.checked ;

	_textarea.disabled = status;
	Ext.util.disableSection(_checkbox, _form, _formPrefix, _formatArr);
};

Ext.util.validateStartEndDate = function(_startDt, _startDtErrLoc, _endDt, _endDtErrLoc,_default)
{
	var startErr, endErr;
	startErr = Ext.util.validateDateFieldNonPatient(_startDt, _startDtErrLoc, _default);
	endErr = Ext.util.validateDateFieldNonPatient(_endDt, _endDtErrLoc, _default);
	if(_startDt.value!='' &&  _startDt.value !='//' && _endDtErrLoc!='' && _endDtErrLoc!='//' && startErr == '' && endErr == '')
	{
		var startDt = Ext.util.getDate(_startDt.value, _default);
		var endDt = Ext.util.getDate(_endDt.value, _default);
		if(startDt > endDt)
		{
			startErr = '45';
		}
	}
	Ext.util.showErrorIcon(startErr,_startDtErrLoc);
	return startErr;
};
Ext.util.validateNextVisitDt = function(_nextVistDt, _visitDt, _eid, _iconLoc)
{		
	var errMsg = '';
	if(_nextVistDt.value == ' / / ')
	{
		_nextVistDt.value = '';
	}
	if((_eid != null && _eid.value.length > 0)|| _visitDt.value.length > 0)
	{
		if(_nextVistDt.value.length == 0)
		{
			errMsg = '66';	
		}	
	}
	if(errMsg == '')
	{
		errMsg = Ext.util.chkDt(_nextVistDt.value,'');
		if(errMsg == '' && _nextVistDt.value.length > 0 )
		{
			var curDate;
			var tempDate = Ext.util.getDate(_nextVistDt.value,'');
			if(_visitDt.value.length > 0 && _visitDt.value != '//')
			{
				curDate = Ext.util.getDate(_visitDt.value,'');
				if(tempDate.getFullYear()<curDate.getFullYear()||(tempDate.getFullYear()==curDate.getFullYear()&&tempDate.getMonth()<curDate.getMonth())||(tempDate.getFullYear()==curDate.getFullYear()&&tempDate.getMonth()==curDate.getMonth()&&tempDate.getDate()<=curDate.getDate()))
				{
					errMsg = '65';
				}
				else
				{
					if(tempDate.getFullYear() == curDate.getFullYear())
					{

						if((tempDate.getMonth() - curDate.getMonth() >3) || ((tempDate.getMonth() - curDate.getMonth() ==3) && (tempDate.getDate() > curDate.getDate()))) 
						{
							errMsg = '71';
						}

					}
					
					else if(tempDate.getFullYear() - 1 == curDate.getFullYear())
					{
						if((tempDate.getMonth() - curDate.getMonth() > -9) || ((tempDate.getMonth() - curDate.getMonth() == -9) && (tempDate.getDate() > curDate.getDate())))
						{
							errMsg = '71';
						}

					}
					
					else if(tempDate.getFullYear() - 1 > curDate.getFullYear())
					{
						errMsg = '71';
	
					}
					
					
				}
			}
			else
			{
				errMsg = '63';			
			}
		}
	}

	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};
Ext.util.validateNextPickupDt = function(_nextVistDt, _visitDt, _eid, _iconLoc)
{		
	var errMsg = '';
	if(_nextVistDt.value == ' / / ')
	{
		_nextVistDt.value = '';
	}

	if(errMsg == '')
	{
		errMsg = Ext.util.chkDt(_nextVistDt.value,'');
		if(errMsg == '' && _nextVistDt.value.length > 0 )
		{
			var curDate;
			var tempDate = Ext.util.getDate(_nextVistDt.value,'');
			if(_visitDt.value.length > 0 && _visitDt.value != '//')
			{
				curDate = Ext.util.getDate(_visitDt.value,'');
				if(tempDate.getFullYear()<curDate.getFullYear()||(tempDate.getFullYear()==curDate.getFullYear()&&tempDate.getMonth()<curDate.getMonth())||(tempDate.getFullYear()==curDate.getFullYear()&&tempDate.getMonth()==curDate.getMonth()&&tempDate.getDate()<=curDate.getDate()))
				{
					errMsg = '65';
				}
				else
				{
					if(tempDate.getFullYear() == curDate.getFullYear())
					{
						if((tempDate.getMonth() - curDate.getMonth() >3) || ((tempDate.getMonth() - curDate.getMonth() ==3) && (tempDate.getDate() > curDate.getDate()))) 
						{
							errMsg = '71';
						}
					}
					else if(tempDate.getFullYear() - 1 == curDate.getFullYear())
					{
						if((tempDate.getMonth() - curDate.getMonth() > -9) || ((tempDate.getMonth() - curDate.getMonth() == -9) && (tempDate.getDate() > curDate.getDate())))
						{
							errMsg = '71';
						}
					}
					else if(tempDate.getFullYear() - 1 > curDate.getFullYear())
					{
						errMsg = '71';
					}
					
				}
			}
			else
			{
				errMsg = '63';			
			}
		}
	}
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};
Ext.util.checkWhoStage = function(_whoStages,_iconLoc)
{
	var errMsg = '';
	var i;
	for(i=0;i<_whoStages.length;i++)
	{
		if(_whoStages[i].checked == true)
		{
			break;
		}
	}
	if(i >= _whoStages.length)
		errMsg = '67';
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};

Ext.util.checkItemSelected = function(_items,_iconLoc)
{
	var errMsg = '';
	var i;
	for(i=0;i<_items.length;i++)
	{
		if(_items[i].checked)
		{
			break;
		}
	}
	if(i >= _items.length)
		errMsg = '68';
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};

Ext.util.checkItemSelected1 = function(_items,_arr,_flag, _iconLoc)
{
	var errMsg = '';
	var i;
	for(i=0;i<_items.length;i++)
	{

		if(_flag)
		{
			if(document.getElementById(_items[i]).checked)
			{
				break;
			}			
		}
		else
		{
			if(_arr[document.getElementById(_items[i]).tabIndex][1]!=document.getElementById(_items[i]).checked)
			{
				break;
			}
		}

	}
	if(i >= _items.length)
		errMsg = '68';
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};
Ext.util.isItemSelected = function(_items,_radioArr,_flag, _iconLoc)
{
	var errMsg = '';
	var i;
	var selectedNum = 0;
	for(i=0;i<_items.length;i++)
	{
		if(document.getElementById(_items[i]).checked)
		{
			if(_flag)
			{
				if(!_radioArr[document.getElementById(_items[i]).tabIndex][1])
					selectedNum++;
			}
			else
			{
				selectedNum++;
			}
		}
	}
	if(selectedNum!=1)
		errMsg = '68';
	else
		errMsg = '';
	Ext.util.showErrorIcon(errMsg,_iconLoc);
	return errMsg;
};
Ext.util.countRadioValue = function(_items1,_items2,_node)
{
	var total = 0,i;
	for(i=0;i<_items1.length;i++)
	{
		if(_items1[i].checked == true)
		{
			total += Number(_items1[i].value);
		}
	}
	for(i=0;i<_items2.length;i++)
	{
		if(_items2[i].checked == true)
		{
			total += Number(_items2[i].value);
		}
	}
	_node.value = total; 
}
Ext.util.checkDrugReasons1 = function(_stopMmNode,_stopYyNode,_reason1,_reason2,_reason3,_reason4,_reason5, _reasonsErrLoc)
{
	var reasonMsg = '';
	var _stopMm = _stopMmNode.value;
	var _stopYy = _stopYyNode.value;
	var i;
	if(_stopMm==''||_stopYy=='')
	{
		if(_reason1.checked == true||_reason2.checked == true||_reason3.checked == true||_reason4.checked == true||_reason5.checked == true)
		{
			reasonMsg = '46';

		}
	}
	else if(_stopMm != '' && _stopYy != '')
	{
		if(_reason1.checked == false && _reason2.checked == false && _reason3.checked == false && _reason4.checked == false&&_reason5.checked == false)
		{
			reasonMsg = '76';

		}
	}
	Ext.util.showErrorIcon(reasonMsg,_reasonsErrLoc);
	return reasonMsg;
};
Ext.util.checkEmptyFields = function(_form, _name)
{
	var i;
	var j = 0;
	var length = _name.length;
	var returnArr = new Array();
	for(i = 0; i < _form.elements.length;i++)
	{	
		if(_form.elements[i].tagName == 'INPUT'&& ( _form.elements[i].type == 'text' || _form.elements[i].type == 'radio') && _name == _form.elements[i].name.substring(0,length) && _name + 'Dt' != _form.elements[i].name)
		{	
			returnArr[j++] = _form.elements[i];
		}
	}
	return returnArr;
};
Ext.util.validateTestResultExclCheckbox1 = function(_checkbox,_elements,_date, _errLoc)
{
	var errMsg = '';
	var flag = false;
	var i = 0;
	for(i=0;i<_elements.length;i++)
	{
		if((_elements[i].type == 'radio' && _elements[i].checked == true) ||(_elements[i].type == 'text' && _elements[i].value.length > 0 ) )
		{
			flag = true;
			break;
		}
	}
  if (_checkbox != null)
  {
  	
		if( _checkbox.checked == true)
		{
			if(_date.value =='' || _date.value =='//'||!flag)
			{
				errMsg = "72";
	
			}
		}
		else if((_date.value!='' && _date.value!='//')||flag) 
		{
			errMsg = "72";
		
		}
		
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
}
Ext.util.validateTestResultExclCheckbox2 = function(_checkbox, _elements, _date, _errLoc)
{
	var errMsg = '';
	var flag = false;
	var i = 0;
	for(i=0;i<_elements.length;i++)
	{
		if((_elements[i].type == 'radio' && _elements[i].checked == true) ||(_elements[i].type == 'text' && _elements[i].value.length > 0 ) )
		{
			flag = true;
			break;
		}
	}

	if(_checkbox != null && _checkbox.checked == true)
	{
		if(_date.value =='' || _date.value =='//'||!flag)
		{
			errMsg = "72";

		}
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};
Ext.util.validateTestResult = function( _checkbox,_elements, _names, lowers, uppers, _date, _errLoc)
{
	var errMsg = '';
	var flag = false;

	for(var i=0;i<_elements.length;i++)
	{
		if(_elements[i].type == 'radio' && _elements[i].checked == true)
		{
			flag = true;
		}
		else if(_elements[i].type == 'text' && _elements[i].value.length > 0)
		{
			flag = true;
			for(var j=0;j < _names.length; j++)
			{
				if(_elements[i].id == _names[j])
				{
					errMsg = Ext.util.isValueInBound(document.getElementById(_elements[i].id),document.getElementById(_elements[i].id + "Title"),lowers[j],uppers[j],'');

				}
			}
		}
	}
  if(errMsg == '')
  {
  	if(flag)
  	{
  		if(_date.value=='' || _date.value=='//' || (_checkbox != null && _checkbox.checked == false))
  		{
  			errMsg = '72';
  		}
  	}
  	else if((_date.value !='' && _date.value !='//') || (_checkbox != null && _checkbox.checked == true))
  	{
  		errMsg = '72';
  	}
  	Ext.util.showErrorIcon(errMsg,_errLoc);
  }

	
	return errMsg;
};

Ext.util.validateTestResultExclCheckbox = function(_checkbox,_elements,_date, _errLoc)
{
	var errMsg = '';
	var flag = false;
	var i = 0;
	for(i=0;i<_elements.length;i++)
	{
		if((_elements[i].type == 'radio' && _elements[i].checked == true) ||(_elements[i].type == 'text' && _elements[i].value.length > 0 ) )
		{
			flag = true;
			break;
		}
	}

	if(_date.value!='' && _date.value!='//')
	{
		if((_checkbox != null && _checkbox.checked == false)||!flag)
		{
			errMsg = "72";
		}
	}
	else if((_checkbox != null && _checkbox.checked == true) || flag) 
	{
		errMsg = "72";
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
}
Ext.util.validateTestResultExclCheckbox3 = function(_arr, _checkbox, _date, _errLoc)
{

	
	var errMsg = '';
	
	if(_checkbox != null && _checkbox.checked == true)
	{
		if(_date.value =='' || _date.value =='//')
		{
			var i = 0;
			for(i=0;i<_arr.length;i++)
			{
				if((_arr[i].type == 'radio' && _arr[i].checked == true) ||(_arr[i].type == 'text' && _arr[i].value.length > 0) )
				{
					break;
				}
			}

			if(_arr.length > 0 && i == _arr.length)
			{
				errMsg = '72';
			} 

		}
	}
		
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
}
Ext.util.validateTestResult1 = function(_arr, _checkbox, _date, _errLoc)
{
	var errMsg = '';
	var i = 0;
	for(i=0;i<_arr.length;i++)
	{
		if((_arr[i].type == 'radio' && _arr[i].checked == true) ||(_arr[i].type == 'text' && _arr[i].value.length > 0) )
		{
			break;
		}
	}

	if(_arr.length > 0 && i < _arr.length)
	{
		if(_date.value=='' || _date.value=='//' || (_checkbox != null && _checkbox.checked == false))
		{
			errMsg = '72';
		}
	} 
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};
Ext.util.compareRegistVisitDt = function(_date1, _date2, _errLoc)
{
	
	var errMsg = ''
	if(_date1.value.length > 0 && _date1.value != '//' && _date2.value.length > 0)
	{
		var date1Parts = _date1.value.split('/');
		var date2Parts = _date2.value.split('/');
		if(date1Parts.length == 3 && date2Parts.length == 3)
		{
			var date1Yy = Number(date1Parts[2]);
			var date2Yy = Number(date2Parts[2]);
			if(date2Yy > date1Yy)
			{
				errMsg = '75';
			}
			else if(date2Yy == date1Yy)
			{
				var date1Mm = Number(date1Parts[1]);
				var date2Mm = Number(date2Parts[1]);
				if(date1Mm < date2Mm)
				{
					errMsg = '75';
				}
				else if(date1Mm == date2Mm)
				{
					var date1Dd = Number(date1Parts[0]);
					var date2Dd = Number(date2Parts[0]);
					if(date1Dd < date2Dd)
					{
						errMsg = '75';
					}
				}
			}
		}
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};
Ext.util.checkRadioCorresponding = function(_radio, _date, _errLoc)
{
	var errMsg = '';
	if(_radio.checked == true && _date.value.length < 3)
	{
		errMsg = '76';
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};
Ext.util.checkRadioCorresponding4IE7 = function(_radio, _date, _radioArr, _flag, _errLoc)
{
	var errMsg = '';
	if(_flag)
	{
		if(_radio.checked == true && _date.value.length < 3)
		{
			errMsg = '76';
		}
	}
	else
	{
		if(_radio.checked == true && _radioArr[_radio.tabIndex][1] == false && _date.value.length < 3)
		{
			errMsg = '76';
		}
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};

Ext.util.checkDateCorresponding = function(_radio, _date, _errLoc)
{
	var errMsg = '';
	if(_radio.checked == false && _date.value.length >= 3)
	{
		errMsg = '76';
	}
	else if(_radio.checked == true && _date.value.length >= 3)
	{
		errMsg = Ext.util.chkDate(_date.value,'') 
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};

Ext.util.checkRadioCorresponding = function(_radioName, _errLoc)
{
	var boolTrack = false;
	var radArr = document.getElementsByName(_radioName);
	for(var i = 0; i < radArr.length; i++){
		if(radArr[i].checked)
			boolTrack = true;
	}

	var errMsg = '';
	if(boolTrack == false)
	{
		errMsg = '76';
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};

Ext.util.checkRadioTextCorresponding = function(_radioEl, _textEl,  _errLoc)
{

	var errMsg = '';
	if(_radioEl.checked == true && _textEl.value != null && _textEl.value != '')
		errMsg = '';
	else if(_radioEl.checked == true && _textEl.value == '')
		errMsg = '76';
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};

Ext.util.checkDateCorresponding4IE7 = function(_radio, _date, _radioArr, _flag,  _errLoc)
{
	var errMsg = '';
	if(_flag)
	{
		if(_radio.checked == false && _date.value.length >= 3)
		{
			errMsg = '76';
		}
		else if(_radio.checked == true && _date.value.length >= 3)
		{
			errMsg = Ext.util.chkDate(_date.value,'') 
		}
	}
	else
	{
		if(_radio.checked ==  _radioArr[_radio.tabIndex][1] && _date.value.length >= 3)
		{
			errMsg = '76';
		}
		else if(_radio.checked !=  _radioArr[_radio.tabIndex][1] && _date.value.length >= 3)
		{
			errMsg = Ext.util.chkDate(_date.value,'') 
		}
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};
Ext.util.checkGivenCorresponding = function(_checkbox, _dose, _date, _errLoc)
{
	var errMsg = '';
	if(_checkbox.checked == true && (_date.value.length < 5 || _dose.value.length <1) )
	{
		errMsg = '76';
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};
Ext.util.checkGivenCorresponding = function(_checkbox, _dose, _date, _errLoc)
{
	var errMsg = '';

	if(_checkbox.checked == true && (_date.value.length < 3 || _dose.value.length <1) )
	{
		errMsg = '76';
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};
Ext.util.checkDosesCorresponding = function(_checkbox, _dose, _date, _errLoc)
{
	var errMsg = '';
	if((_checkbox.checked == false || _date.value.length < 3) && _dose.value.length >0)
	{
		errMsg = '76';
		Ext.util.showErrorIcon(errMsg,_errLoc);
	}
	else  if(_checkbox.checked == true && _date.value.length >= 3 && _dose.value.length >0)
	{
	
		errMsg =  Ext.util.isValueInBound(_dose,_errLoc,'0','','');
	} 
	else
	{
		Ext.util.showErrorIcon(errMsg,_errLoc);
	}
	return errMsg;
};


Ext.util.checkDateCorresponding1 = function(_checkbox,_dose, _date, _default, _errLoc)
{
	var errMsg = '';
	if(_checkbox.checked == true && _date.value.length >= 3 && _dose.value.length >0)
	{
		errMsg = Ext.util.chkDate(_date.value,_default); 
	}
	else if(_date.value.length >= 5&&(_checkbox.checked == false||_dose.value.length < 1))
	{
		errMsg = '76';
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};
Ext.util.checkCheckboxCorresponding1 = function(_checkbox, _text, _date, _errLoc)
{
	var errMsg = '';

	if(_checkbox.checked == true && (_date.value.length < 3 || _text.value.length <1) )
	{
		errMsg = '76';
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};
Ext.util.checkCheckboxCorresponding2 = function(_checkbox, _text1, _text2, _errLoc)
{
	var errMsg = '';

	if(_checkbox.checked == true && (_text1.value.length < 1 || _text2.value.length <1) )
	{
		errMsg = '76';
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};
Ext.util.checkTextCorresponding = function(_checkbox, _text, _date, _errLoc)
{
	var errMsg = '';
	if( (_checkbox.checked == false ||  _date.value.length < 3) && _text.value.length >0)
	{
		errMsg = '76';
		
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};

Ext.util.checkRadioTextCorresponding = function(_radio, _text, _errLoc)
{
	var errMsg = '';
	if(_radio.checked == true  && _text.value.length <= 0)
	{
		errMsg = '76';
		
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};


Ext.util.checkCheckBoxCorresponding = function(_radio, _mm, _yy, _errLoc)
{
	var errMsg = '';
	if(_radio.checked == true && (_mm.value.length == 0 || _yy.value.length == 0))
	{
		errMsg = '76';
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};
Ext.util.checkMYCorresponding = function(_radio, _mm, _yy, _errLoc)
{
	var errMsg = '';
	if(_radio.checked == false && (_mm.value.length > 0 || _yy.value.length > 0) )
	{
		errMsg = '76';
		Ext.util.showErrorIcon(errMsg,_errLoc);	

	}
	else if(_radio.checked == true && (_mm.value.length > 0 || _yy.value.length > 0))
	{
		errMsg = Ext.util.validateMY(_mm,_yy, _errLoc, 'XX', false);
	}
	else
	{
		Ext.util.showErrorIcon(errMsg,_errLoc);	
	}

	return errMsg;
};
Ext.util.checkUniqueCheckboxWithMY = function(_checkboxArr,_mm,_yy,_errLoc)
{
	var total = 0;
	var errMsg = '';
	for(var i=0;i<_checkboxArr.length;i++)
	{
		if(_checkboxArr[i].checked == true)
		{
			total++;
		}
	}
	if(total == 1  && _mm.value.length == 0 &&  _yy.value.length == 0)
	{
		errMsg = '76';
	} 
	else if(total > 1)
	{
		errMsg = '78';
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);	
	return errMsg;
};
Ext.util.checkCheckboxRulesWithMY = function(_checkboxArr,_checkboxRules,_mm,_yy,_errLoc)
{
	var total = 0;
	var errMsg = '';
	for(var i=0;i<_checkboxArr.length;i++)
	{
		if(_checkboxArr[i].checked == true)
		{
			total++;
		}
	}
	if(total > 1)
	{
		var tmpTotal = total;
		for(var j = 0;j < _checkboxRules.length; j++)
		{
			if(_checkboxRules[j].checked == true)
			{
				tmpTotal--;
			}
		}
		if(tmpTotal==total)
		{
			errMsg = '80';
		}
		else
		{
			if(tmpTotal >= 1)
			{
				errMsg = '80';
			}
		}
	}
	if(errMsg =='')
	{
		if(total >=1  && _mm.value.length == 0 &&  _yy.value.length == 0)
		{
			errMsg = '76';
		} 
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);	
	return errMsg;
};
Ext.util.checkCheckboxesWithMY = function(_checkboxArr,_mm,_yy,_errLoc)
{
	var total = 0;
	var errMsg = '';
	if((_checkboxArr[0].checked == true || _checkboxArr[1].checked == true|| _checkboxArr[2].checked == true) && _mm.value.length == 0 && _yy.value.length == 0)
	{
		errMsg = '76';
	} 
	else if(_checkboxArr[0].checked == true && _checkboxArr[1].checked == true)
	{
		errMsg = '78';
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);	
	return errMsg;
};

Ext.util.checkMYWithCheckbox = function(_checkboxArr,_mm,_yy,_default, _errLoc)
{
	var total = 0;
	var errMsg = '';
	for(var i=0;i<_checkboxArr.length;i++)
	{
		if(_checkboxArr[i].checked == true)
		{
			total++;
		}
	}
	if(total == 0  && (_mm.value.length > 0 || _yy.value.length > 0) )
	{
		errMsg = '76';
	}
	else if(total > 0 && (_mm.value.length == 0 && _yy.value.length == 0))
	{
		errMsg = '76';
	}
	else if(total > 0 && (_mm.value.length > 0 || _yy.value.length > 0))
	{
		errMsg = Ext.util.validateMY(_mm,_yy, _errLoc, _default, false);
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);	
	return errMsg;
};
Ext.util.checkRadioCorrespondingWithDose = function(_radio, _mm, _yy, _num, _radioArr,_flag, _errLoc)
{
	var errMsg = '';
	if(_flag)
	{
		if(_radio.checked == true && (_mm.value.length == 0 || _yy.value.length == 0||_num.value.length == 0 ) )
		{
			errMsg = '76';
		}
	}
	else
	{
		if(_radio.checked && !_radioArr[_radio.tabIndex][1] && (_mm.value.length == 0 || _yy.value.length == 0||_num.value.length == 0 ) )
		{
			errMsg = '76';
		}	
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};
Ext.util.checkDoseCorresponding = function(_radio, _dose, _errLoc)
{
	var errMsg = '';
	if(_radio.checked == false && _dose.value.length > 0 )
	{
		errMsg = '76';
		Ext.util.showErrorIcon(errMsg,_errLoc);	
	}
	else if(_radio.checked == true &&_dose.value.length > 0)
	{
		errMsg = Ext.util.isValueInBound(_dose, _errLoc,'0','','');
	}
	else
	{
		Ext.util.showErrorIcon(errMsg,_errLoc);	
	}
	return errMsg;
};
Ext.util.checkTextDtCorresponding = function( _text, _date, _errLoc)
{
	var errMsg = '';
	if( _date.value.length < 3 && _text.value.length >0)
	{
		errMsg = '76';
		Ext.util.showErrorIcon(errMsg,_errLoc);	
		
	}
	else if(_text.value.length > 0)
	{
		errMsg = Ext.util.isValueInBound(_text, _errLoc,'0','','');
	}
	else
	{
		Ext.util.showErrorIcon(errMsg,_errLoc);	
	}

	return errMsg;
};
Ext.util.checkDtTextCorresponding = function( _text, _date, _errLoc)
{
	var errMsg = '';
	if(_date.value.length >= 3 && _text.value.length >0)
	{
		errMsg = Ext.util.chkDate(_date.value,''); 
	}
	else if(_date.value.length >= 3&&_text.value.length < 1)
	{
		errMsg = '76';
	}
	Ext.util.showErrorIcon(errMsg,_errLoc);
	return errMsg;
};
Ext.util.getLabTestResultElements = function()
{
	var i;
	var loc = -1;
	var result = new Array();
	var keyName;
	var formElements = document.getElementsByTagName("INPUT");
	for(i = 0; i < formElements.length;i++)
	{	
		if(formElements[i].type == 'radio' || formElements[i].type == 'text' || formElements[i].type == 'textarea' || formElements[i].type == 'checkbox')
		{
			loc =  formElements[i].name.lastIndexOf('Test');
			if(loc > 0)
			{
				keyName = formElements[i].name.substring(0, loc);
				if(result[keyName] == null)
				{
					result[keyName] = new Array();
				}
				result[keyName][result[keyName].length] = formElements[i];
			}
		}
	}
	return result;
};
Ext.util.extractLabTestResultElements = function(_elements)
{
	var result = new Array();
	var j = 0;
	if(_elements.length > 1)
	{
		for(var i= 0;i<_elements.length;i++)
		{
	
				if(_elements[i].type == 'radio')
				{
					result[j++] = _elements[i];
				}
				else if( _elements[i].type == 'text' &&  _elements[i].id.substring(_elements[i].id.length-2)!='Dt')
				{
					
					result[j++] = _elements[i];
				}
		}
	}
	return result;
}
Ext.util.disableElements = function(_radio,_section,_radioArr,_flag)
{
	var status = true;
	if((_flag&&_radio.checked == true)||(!_flag&&_radio.checked!=_radioArr[_radio.tabIndex][1]&&_radioArr[_radio.tabIndex][1]!=true))
	{
		status = false;
	}
	for(var i=0;i<_section.length;i++)
	{
		_section[i].disabled = status;
	}
};
Ext.util.disableAssoDt = function(_radio,_dateFmt,_date,_radioArr,_flag)
{
	var status = true;

	if((_flag&&_radio.checked == true)||(!_flag&&_radio.checked!=_radioArr[_radio.tabIndex][1]))
	{
		status = false;
	}
	_dateFmt.disabled = status;	
	_date.disabled = status;

};
Ext.util.getAllElements = function(_form,_names)
{
	var radioArray = new Array();
	var radioCount = 0;
	var textArray  = new Array();
	var textCount = 0;
	var textareaArray = new Array();
	var textareaCount = 0;
	var result = new Array();
	var currentType = "";
	var nameCounts = new Array();
	if(_names.length > 0)
	{
		for(var iCount=0;iCount<_names.length;iCount++)
		{
			nameCounts[iCount] = 0;
			result[_names[iCount]] = new Array();
		}
	}
	var inputElements = _form.getElementsByTagName("INPUT");
	for(var i = 0; i < inputElements.length;i++)
	{	
		if(_names.length > 0)
		{
			for(var j = 0;j < _names.length; j++)
			{
				//if(inputElements[i].id.substring(0,_names[j].length) == _names[j])
				if(inputElements[i].className.substring(0,_names[j].length) == _names[j])
				{
						result[_names[j]][nameCounts[j]++] = inputElements[i];
				}
			}
		}
		currentType = inputElements[i].type; 
		if(currentType == "text")
		{
			textArray[textCount++] = inputElements[i];
		}
		else if(currentType == "textarea")
		{
			textareaArray[textareaCount++] = inputElements[i];
		}
		else if(currentType == "radio")
		{
			radioArray[radioCount++] = inputElements[i];
		}
	}
	result["text"] = textArray;
	result["textarea"] = textareaArray;
	result["radio"] = radioArray;
	return result;
};
Ext.util.getAllRadios = function(_arr)
{
//	var isIE7 = false;
//	var ua = navigator.userAgent;
//	var browserIdx  = null;
//	var strIE = "MSIE";
//	if((browserIdx = ua.indexOf(strIE)) >= 0)
//	{
//		var version = parseFloat(ua.substr(browserIdx + strIE.length));
//		if(version < 8)
//		{
//			isIE7 = true;
//		}
//	}
    var uncheckedRadios = '';
	var radioArray = new Array();
	for(var i=0;i<_arr.length;i++)
	{
	if(_arr[i].name != 'errorOverride' && _arr[i].name != 'isPediatric[]' ) {
		var tmpArr = new Array();
		tmpArr[0] =  _arr[i].name;
//		if(isIE7)
//		{
//			var radioStr = '<input type="radio" tabindex="' + _arr[i].tabIndex + '" id="' +  _arr[i].id + '"  name="' +  _arr[i].name + '" value="' + _arr[i].value + '"';
//                                if(_arr[i].checked)
//                                        radioStr += ' checked';
//				if(_arr[i].disabled)
//					radioStr += ' disabled';
//				radioStr += '>';
//				var element = document.createElement(radioStr);				
//				parentNode = _arr[i].parentNode;
//				parentNode.insertBefore(element, _arr[i]);
//				parentNode.removeChild(_arr[i]);
//				_arr[i] = element;
//			}
//			else
//			{
                                // Let's try not changing the names to be
                                // the tabIndex number
                                //_arr[i].name = _arr[i].tabIndex;
                                // You can't stuff a string into a boolean, did
                                // you mean to do the opposite (as shown below)?
                                //_arr[i].checked = _arr[i].title;
                                //_arr[i].title = _arr[i].checked;
//                        }
			tmpArr[1] = _arr[i].checked;
			radioArray[_arr[i].tabIndex] = tmpArr;
			Ext.get(_arr[i]).on('click', function(){
				if(radioArray[this.dom.tabIndex][1] == true)
				{
					this.dom.checked = false;
					radioArray[this.dom.tabIndex][1] = false;
					this.dom.name = radioArray[this.dom.tabIndex][0];
					var hiddenCheckedRadio = document.getElementById('checkedRadios');
					if( hiddenCheckedRadio!= null)
					{
						var existed = -1;
						var domName = this.dom.name;
						var loc = domName.indexOf('[]');
						if( loc >-1)
						{
							domName = domName.substring(0, loc);
						}
						if(hiddenCheckedRadio.value!='')
						{
							existed = hiddenCheckedRadio.value.indexOf(domName);
						}
;
						if(existed == -1)
						{
							if(hiddenCheckedRadio.value!='')
								hiddenCheckedRadio.value = hiddenCheckedRadio.value + "," + domName;
							else
								hiddenCheckedRadio.value = domName;
						}
					}
					for(x in radioArray)
					{
						if(radioArray[x][0] == this.dom.name)
						{
							radioArray[x][1] = false;
							for(var j = 0; j < _arr.length; j++)
							{
								if(x == _arr[j].tabIndex)
								{
									_arr[j].checked = false;
									_arr[j].name = radioArray[x][0];
                                                                        break;
								}
							}
						}
					}
				}
				else
				{
					this.dom.name = radioArray[this.dom.tabIndex][0];
					
					for(x in radioArray)
					{
						if(radioArray[x][0] == this.dom.name)
						{
							radioArray[x][1] = false;
							for(var j = 0; j < _arr.length; j++)
							{
								if(x == _arr[j].tabIndex)
								{
									_arr[j].checked = false;
									_arr[j].name = radioArray[x][0];
                                                                        break;
								}
							}
						}
					}
					this.dom.checked = true;
					radioArray[this.dom.tabIndex][1] = true;
				}
			});
		}
	}
	return radioArray;
};
Ext.util.getAllRadiosNoMultiSelected = function(_arr)
{
	var radioArray = new Array();
	for(var i=0;i<_arr.length;i++)
	{
		var tmpArr = new Array();
		tmpArr[0] =  _arr[i].name;		
		tmpArr[1] = _arr[i].checked;
		radioArray[_arr[i].tabIndex] = tmpArr;
		Ext.get(_arr[i]).on('click', function(){
			if(radioArray[this.dom.tabIndex][1] == true)
			{
				this.dom.checked = false;
				radioArray[this.dom.tabIndex][1] = false;
			}
			else
			{
				this.dom.checked = true;
				radioArray[this.dom.tabIndex][1] = true;
			}
		});
	}
	return radioArray;
};
Ext.util.disableSectionByRadio = function(_radio, _arr, _flag,  _elements)
{
	var enableDis = false;
	if(_flag == true)
		enableDis = _radio.checked;
	else
	{
		if(_arr[_radio.tabIndex]!=null&&_arr[_radio.tabIndex][1] != _radio.checked&& _radio.checked)
			enableDis = true;
	}
	for(var i=0; i < _elements.length;i++)
	{

		_elements[i].disabled = enableDis;
	}
};
Ext.util.getNewRadios = function( _elements)
{

	var result = new Array();
	for(var i=0; i < _elements.length;i++)
	{
		result[i] = document.getElementById(_elements[i].id);
	}
	return result;
};
Ext.util.disableSectionByInternalRadios = function( _radios, _elements, _formats)
{
	var flag = false;
	for(var i=1;i<_radios.length;i++)
	{
		if(_radios[i].checked == true)
		{
			flag = true;
			break;
		}
	}
	var tempFlag = true;
	for(var j=0; j < _elements.length;j++)
	{
		
		tempFlag = true;
		for(var k=0; k < _radios.length;k++)
		{
			if(_radios[k].id == _elements[j].id)
			{
					tempFlag  = false;
					break;
			}
		}
		if(tempFlag)
		{
			_elements[j].disabled = flag;
			if(_elements[j].id.substring(_elements[j].id.length-2) == "Dt" || _elements[j].id.substring(_elements[j].id.length-2) == "DT")
	  	{
	  			if(flag)
	  				_formats[_elements[j].id].disable();
	  			else
	  				_formats[_elements[j].id].enable();
	  	}
	  }
	}

};
Ext.util.disableSectionByInternalRadio = function( _radio, _elements, _formats, _radioArr, _flag)
{
	var result = true;
	if(_flag)
	{
		result = !_radio.checked;
	}
	else
	{
		if(_radio.checked && !_radioArr[_radio.tabIndex][1])
		{
			result = false;
		}
	}
	for(var j=0; j<_elements.length; j++)
	{
		_elements[j].disabled = result;
		if(result)
		{
			_elements[j].value = '';
		}
		if(_elements[j].id.substring(_elements[j].id.length-2) == "Dt" || _elements[j].id.substring(_elements[j].id.length-2) == "DT")
	  	{
	  		if(result)
	  			_formats[_elements[j].id].disable();
	  		else
	  			_formats[_elements[j].id].enable();
	  	}
	}
};
Ext.util.getElementsByArr = function(_names)
{
	var result = new Array();
	for(var i=0;i<_names.length;i++)
	{

		result[i] = document.getElementById(_names[i]);
	}
	return result;
};
Ext.util.selectDiffRadio = function(_radio, _names, _loc, _radioArr)
{
	
//	if(_radioArr[_radio.tabIndex][1] == true)
//	{
//		document.getElementById(_names[_loc]).value = '0';
//	}
//	else
//	{
		var elements = Ext.util.getElementsByArr(_names);
		for(var i = 0; i < elements.length; i++)
		{
			elements[i].value = '0';
		}
		if (_radio.checked) elements[_loc].value = '1';
//	}	
};
Ext.util.clearElements = function(_elements, _errFields,_errMsgs, _errCount)
{
	for(var i=0; i < _elements.length; i++)
	{
		if(_elements[i].type == "text" || _elements[i].type == "hidden")
		{
			_elements[i].value = "";
		}
		else if(_elements[i].type == "radio" || _elements[i].type == "checkbox")
		{
			_elements[i].checked = false;
		}
		var errorTitle;
		var eleId = _elements[i].id;
		errorTitle = document.getElementById(eleId + "Title");
		if(errorTitle == null)
		{
			errorTitle = document.getElementById(eleId.substring(0,eleId.length-2) + "Title");
			if(errorTitle == null)
			{
				errorTitle = document.getElementById(eleId.substring(0,eleId.length-1) + "Title");
			}
		}
		if( errorTitle !=null)
		{
			Ext.util.showErrorIcon("", errorTitle);
		}
		
		Ext.util.showErrorHead(_errFields,_errMsgs, _elements[i].id,"",_errCount);
	}
};
Ext.util.isNumberPositive = function(_input,_loc)
{
	var tempResult = false;
	var errMsg = '';
	if(_input!='' && _input.length > 0)
	{
		var value = parseFloat(_input);
		if(!isNaN(value))
		{		
			if(value > 0)
			{
				tempResult = true;
			}
		}
		if(!tempResult)
		{	
			errMsg = errors["81"];
			errMsg = errMsg.replace("{1}","0");		
		}
	}
	
	Ext.util.showErrorIconWithMsg(errMsg,_loc);
	if(!tempResult)
	{
		return '81';
	}
	else
	{
		return '';
	}
};


Ext.util.addToCheckedRadios = function(_input)
{
	var hiddenCheckedRadio = document.getElementById('checkedRadios');
	if( hiddenCheckedRadio!= null)
	{
		var existed = -1;
		var name = _input.name;
		var loc = name.indexOf('[]');
		if( loc > -1)
		{
			name = name.substring(0, loc);
		}
		if(hiddenCheckedRadio.value!='')
		{
			existed = hiddenCheckedRadio.value.indexOf(name);
		}

		if(existed == -1)
		{
			if(hiddenCheckedRadio.value!='')
				hiddenCheckedRadio.value = hiddenCheckedRadio.value + "," + name;
			else
				hiddenCheckedRadio.value = name;
		}
	}
};

Ext.util.computeHiddenValue = function(_hidden, _arr)
{
        var total = 0;
	for(var i=0; i < _arr.length; i++)
	{
		if(_arr[i].checked) {
                        total += Number(_arr[i].value);
		}
	}
        _hidden.value = total;
};

Ext.util.toggleHiddenValues = function(_arr, _loc)
{
	for(var i=0; i < _arr.length; i++) {
                var inName = _arr[i].id;
                var hidName = inName.substr(0, inName.indexOf('[]'));
	        if(_loc == i) {
                        if (document.getElementById(hidName).value == 0) {
                                document.getElementById(hidName).value = 1;
                        } else if (document.getElementById(hidName).value == 1) {
                                document.getElementById(hidName).value = 0;
                        }
                } else {
                        document.getElementById(hidName).value = 0;
                }
        }
};

Ext.util.validatePediatricTbHistorySection = function(_rad1, _rad2, _mm1, _yy1, _mm2, _yy2, _errLoc1, _errLoc2, _errLoc3, _errLoc4)
{
        // Validate the 'TB History' section on the ped. intake form.
        // If 'TB Treatment' is selected, all dates must be entered
        // If 'TB treament in progress' is selected, start date but no end date
        // Similar rules for 'INH Prophylaxis' inputs
	var errMsg = '';
	if (_rad1.checked == true &&
            (_mm1.value.length == 0 || _yy1.value.length == 0 ||
             _mm2.value.length == 0 || _yy2.value.length == 0))
		errMsg = '76';
	Ext.util.showErrorIcon(errMsg, _errLoc1);
	errCount = Ext.util.showErrorHead(errFields,errMsgs,_errLoc1.id.substring(0,_errLoc1.id.length-5),errMsg,errCount);

        errMsg = '';
        if (_rad2.checked == true &&
            ((_mm1.value.length == 0 || _yy1.value.length == 0) ||
             (_mm2.value.length > 0 || _yy2.value.length > 0)))
		errMsg = '76';
        Ext.util.showErrorIcon(errMsg, _errLoc2);
	errCount = Ext.util.showErrorHead(errFields,errMsgs,_errLoc2.id.substring(0,_errLoc2.id.length-5),errMsg,errCount);
        
        errMsg = '';
        if ((_rad1.checked == false && _rad2.checked == false) && 
            (_mm1.value.length > 0 || _yy1.value.length > 0))
                errMsg = '76';
        if (errMsg == '') errMsg = Ext.util.validateMY(_mm1, _yy1, '_errLoc3', 'XX');
        Ext.util.showErrorIcon(errMsg, _errLoc3);
	errCount = Ext.util.showErrorHead(errFields,errMsgs,_errLoc3.id.substring(0,_errLoc3.id.length-5),errMsg,errCount);

        errMsg = '';
        if ((_rad1.checked == false && _rad2.checked == false) && 
            (_mm2.value.length > 0 || _yy2.value.length > 0))
                errMsg = '76';
        if (errMsg == '') errMsg = Ext.util.validateMY(_mm2, _yy2, '_errLoc4', 'XX');
        Ext.util.showErrorIcon(errMsg, _errLoc4);
	errCount = Ext.util.showErrorHead(errFields,errMsgs,_errLoc4.id.substring(0,_errLoc4.id.length-5),errMsg,errCount);

	return errMsg;
};

Ext.util.validateAdultTbStatusSection = function(_rad, _text1, _text2, _errLoc1, _errLoc2, _errLoc3)
{
        // Validate the 'TB Status' section on the adult forms.
        // If 'TB Treatment Complete' is selected, date and facility must be entered
        // If 'TB treament in progress' is selected, dossier no. and facility must be entered
	var errMsg = '';
        if (_text1.id.substring(_text1.id.length - 2) == 'Dt') {
	  if (_rad.checked == true &&
              (_text1.value.length < 3 || _text2.value.length < 1))
	  	errMsg = '76';
          if (errMsg == '') {
		errMsg = Ext.util.checkCheckboxCorresponding1(_rad,_text2,_text1,_errLoc1);
          }
        } else {
	  if (_rad.checked == true &&
              (_text1.value.length < 1 || _text2.value.length < 1))
	  	errMsg = '76';
          if (errMsg == '') {
		errMsg = Ext.util.checkCheckboxCorresponding2(_rad,_text2,_text1,_errLoc1);
          }
        }
	Ext.util.showErrorIcon(errMsg, _errLoc1);
	errCount = Ext.util.showErrorHead(errFields,errMsgs,_errLoc1.id.substring(0,_errLoc1.id.length-5),errMsg,errCount);

        errMsg = '';
        if (_text1.id.substring(_text1.id.length - 2) == 'Dt') {
       	  Ext.util.splitDate(_text1,document.getElementById(_text1.id.substring(0,_text1.id.length-2) + "Dd"),document.getElementById(_text1.id.substring(0,_text1.id.length-2) + "Mm"),document.getElementById(_text1.id.substring(0,_text1.id.length-2) + "Yy"));
          if (_rad.checked == false && _text1.value.length > 2)
                errMsg = '76';
          if (errMsg == '') {
		errMsg = Ext.util.checkCheckboxCorresponding1(_rad,_text2,_text1,_errLoc2);
          }
          if (errMsg == '') {
		errMsg =  Ext.util.validateDateFieldNonPatient(_text1,_errLoc2,'');
          }
        } else {
          if (_rad.checked == false && _text1.value.length > 0)
                errMsg = '76';
          if (errMsg == '') {
		errMsg = Ext.util.checkCheckboxCorresponding2(_rad,_text2,_text1,_errLoc2);
          }
        }
        Ext.util.showErrorIcon(errMsg, _errLoc2);
	errCount = Ext.util.showErrorHead(errFields,errMsgs,_errLoc2.id.substring(0,_errLoc2.id.length-5),errMsg,errCount);

        errMsg = '';
        if (_rad.checked == false && _text2.value.length > 0)
                errMsg = '76';
        if (errMsg == '') {
		errMsg = Ext.util.checkCheckboxCorresponding2(_rad,_text2,_text1,_errLoc3);
        }
        Ext.util.showErrorIcon(errMsg, _errLoc3);
	errCount = Ext.util.showErrorHead(errFields,errMsgs,_errLoc3.id.substring(0,_errLoc3.id.length-5),errMsg,errCount);

	return errMsg;
};
// Fix IE10 in width of datepicker calendar
Ext.override(Ext.menu.Menu, {
    autoWidth : function(){
        var el = this.el, ul = this.ul;
        if(!el){
            return;
        }
        var w = this.width;
        if(w){
            el.setWidth(w);
        }else if(Ext.isIE && !Ext.isIE8){
            el.setWidth(this.minWidth);
            var t = el.dom.offsetWidth; // force recalc
            el.setWidth(ul.getWidth()+el.getFrameWidth("lr"));
        }
    }
});