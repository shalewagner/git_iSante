<?php
echo "
<script language=\"JavaScript\" type=\"text/javascript\" src=\"include/ajax.js\"></script>
<script language=\"javascript\" type=\"text/javascript\">
var newUserName = ''
function doAddUser() {
    newUserName = prompt('Please enter your new user name.','<username>')
    if (newUserName == '<username>')
		alert('You did not enter a name, please try again')
	else if (newUserName != '' && newUserName != 'null') {
		un = document.getElementById('userName')
		unOptNew = document.createElement('option')
		unOptNew.text = newUserName
		unOptNew.value = newUserName
		try {
			un.add(unOptNew, null) // standards compliant; doesn't work in IE
		}
		catch(ex) {
			alert('add to list failed') 
			un.add(unOptNew) // IE only
		}
		saveUser(newUserName)
	}
}

var saveUserObject = createHTTPObject();
function saveUser(newUser) {
    url = encodeURI('execProc.php?proc=sp_addToUserPrivilege&userName=' + newUser)
    saveUserObject.open('GET', url, true)
    saveUserObject.onreadystatechange = handleHttpResponse
    saveUserObject.send(null)
}

function doDeleteUser() {
    un = document.getElementById('userName')
    for (i = un.options.length-1; i>=0; i--) {
    	o = un.options[i]
	if (o.selected) {
	  oldUser = o.value
	  un.options[i] = null
	}
    }
    deleteUser(oldUser)
}

var deleteUserObject = createHTTPObject();
function deleteUser(oldUser) {
    url = encodeURI('execProc.php?proc=sp_removeUser&userName=' + oldUser)
    deleteUserObject.open('GET', url, true)
    deleteUserObject.onreadystatechange = handleHttpResponse
    deleteUserObject.send(null)
}

function handleHttpResponse() {
  // activates when the proc is finished
  if (deleteUserObject.readyState == 4) {
    document.forms[0].submit()
  }
  if (saveUserObject.readyState == 4) {
      document.forms[0].selUser.value = newUserName
      //document.forms[0].submit()
  }
}

</script>";
?>