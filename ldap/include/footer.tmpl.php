<?php
/**
 * Page footer template
 *
 * @author	Svend Sorensen
 * @version	$Id: footer.tmpl.php 66 2006-04-26 19:24:38Z svends $
 */
?>

<?php if (isset($_SESSION['username'])) { ?>
	<div id="footer">
		<a href="<?php print $_SERVER['PHP_SELF']; ?>?action=logout">
			<?php print gettext("Logout"); ?>
			<?php print $_SESSION['username']; ?>
		</a>
	</div>
<?php } // End if ?>
</body>
</html>
