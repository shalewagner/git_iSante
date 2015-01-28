<?php
/**
 * Login page template
 *
 * @author	Svend Sorensen
 * @version	$Id: login.tmpl.php 116 2006-10-19 22:44:48Z svends $
 */
?>

<?php include ('include/header.tmpl.php'); ?>

	<form action="<?php print $login_action; ?>" method="post">
	<fieldset>
		<label for="username"><?php print gettext("Username"); ?>:</label>
		<?php $ro = (isset($_GET['passFlag'])) ? "readonly" : ""; ?>
		<input name="username" id="username" value="<?php print $username . "\" " . $ro; ?> /><br />
		<label for="password"><?php print gettext("Password"); ?>:</label>
		<input type="password" name="password" id="password" /><br />
		<label for="submit"></label>
		<input type="submit" id="submit" value="<?php print gettext("Submit"); ?>" />
		<input type="hidden" name="_auth_submit_check" value="1" />
	</fieldset>
	</form>

<?php include ('include/footer.tmpl.php'); ?>
