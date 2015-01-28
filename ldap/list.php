<?php
/**
 * Account list page
 *
 * @author	Svend Sorensen
 * @version	$Id: list.php 66 2006-04-26 19:24:38Z svends $
 */

require_once ('./include/app.php');

$title = gettext("Account list");

$list = $accounts->find_all();
sort($list);

include ('./include/list.tmpl.php');
?>
