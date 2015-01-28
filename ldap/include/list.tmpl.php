<?php
/**
 * Account list page template
 *
 * @author	Svend Sorensen
 * @version	$Id: list.tmpl.php 66 2006-04-26 19:24:38Z svends $
 */
?>

<?php include ('include/header.tmpl.php'); ?>

	<p>
		<a href="new.php"><?php print gettext("New account"); ?></a>
	</p>
	<table>
		<thead>
			<tr>
				<th><?php print gettext("Username"); ?></th>
				<th><?php print gettext("Full name"); ?></th>
				<th><?php print gettext("Email address"); ?></th>
				<th><?php print gettext("Organization name"); ?></th>
				<th><?php print gettext("Phone number"); ?></th>
				<th><?php print gettext("Comments"); ?></th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
<?php foreach ($list as $account) {
	// Make strings HTML safe
	$username = htmlspecialchars($account->username);
	$username_url = urlencode($account->username);
	$name = htmlspecialchars($account->commonName);
	$mail = htmlspecialchars($account->mail);
	$org = htmlspecialchars($account->organizationName);
	$phone = htmlspecialchars($account->telephoneNumber); 
	$desc = htmlspecialchars($account->description);
?>
		<tr>
			<td>
				<a href="edit.php?id=<?php print $username_url; ?>"><?php print $username; ?></a>
			</td>
			<td>
				<?php print $name; ?>
			</td>
			<td>
				<?php print $mail; ?>
			</td>
			<td>
				<?php print $org; ?>
			</td>
			<td>
				<?php print $phone; ?>
			</td>
			<td>
				<?php print $desc; ?>
			</td>
			<td>
				<a href="delete.php?id=<?php print $username_url; ?>" onclick="return confirm('<?php print gettext("Are you sure?"); ?>');"><?php print gettext("Delete"); ?></a>
			</td>
		</tr>
<?php } // End foreach ?>
		</tbody>
	</table>

<?php include ('include/footer.tmpl.php'); ?>
