<?php
/**
 * New account page template
 *
 * @author	Svend Sorensen
 * @version	$Id: new.tmpl.php 142 2006-10-25 21:02:16Z svends $
 */
?>

<?php include ('include/header.tmpl.php'); ?>

<?php if ($errors) { ?>
	<p><?php print gettext("Please correct these errors"); ?>:</p>
	<ul class="error">
<?php foreach ($errors as $error) { ?>
		<li><?php print $error; ?></li>
<?php } // End foreach ?>
	</ul>
<?php } // End if ?>

	<form action="<?php print $submit_url; ?>" method="post">
	<fieldset>
		<fieldset>
			<legend><?php print gettext("Account information"); ?></legend>
			<label for="username"><?php print gettext("Username"); ?>:</label>
			<input name="username" id="username" value="<?php print (!empty ($form['username'])) ? $form['username'] : "newUser"; ?>" /><br />
			<label for="password"><?php print gettext("Password"); ?>*:</label>
			<input type="password" name="password" id="password" /><br />
			<p class="description"><?php print gettext("Password must be at least 8 characters long and must contain at least one letter, one number, and one symbol."); ?></p>
			<label for="password2"><?php print gettext("Confirm"); ?>*:</label>
			<input type="password" name="password2" id="password2" />
		</fieldset>
		<fieldset>
			<legend><?php print gettext ("User information"); ?></legend>
			<label for="firstname"><?php print gettext("First name"); ?>*:</label>
			<input name="firstname" id="firstname" value="<?php print $form['firstname']; ?>" /><br />
			<label for="lastname"><?php print gettext("Last name"); ?>*:</label>
			<input name="lastname" id="lastname" value="<?php print $form['lastname']; ?>" /><br />
			<label for="mail"><?php print gettext("Email address"); ?>*:</label>
			<input name="mail" id="mail" value="<?php print $form['mail']; ?>" /><br />
			<label for="org"><?php print gettext("Organization name"); ?>*:</label>
			<input name="org" id="org" value="<?php print $form['org']; ?>" /><br />
			<label for="phone"><?php print gettext("Phone number"); ?>:</label>
			<input name="phone" id="phone" value="<?php print $form['phone']; ?>" /><br />
			<label for="comments"><?php print gettext("Comments"); ?>:</label>
			<textarea name="comments" id="comments" cols="40" rows="8"><?php print $form['comments']; ?></textarea><br />
		</fieldset>
		<label for="submit"></label>
		<input type="submit" id="submit" value="<?php print gettext("Submit"); ?>" class="submit" />
		<input type="button" value="<?php print gettext("Cancel"); ?>" class="cancel" onclick="self.location='<?php print $cancel_url; ?>'" />
		<input type="hidden" name="_submit_check" value="1" />
		<p>*: <?php print gettext("Required field"); ?></p>
	</fieldset>
	</form>
