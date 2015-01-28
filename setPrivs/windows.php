<?php
//populate the userName widget
$nameResults = getCurrentUsers();
echo "
	<tr>
		<td>
			<input type=\"button\" name=\"addUser\" onclick=\"doAddUser()\" value=\"Add User\" />
		</td>
	</tr>
    <tr>
		<td>
			<input type=\"button\" name=\"deleteUser\" onclick=\"doDeleteUser()\" value=\"Delete User\" />
		</td>
	</tr>";

function getCurrentUsers () {
	$currUsers = array ();
	$qry = "SELECT distinct username from userPrivilege order by 1";
	$result = dbQuery ($qry) or	die("Could not query for current users.");
	while ($row = psRowFetch ($result))
		array_push ($currUsers, $row['username']);
	return ($currUsers);
}
?>
