<?php


if (getAccessLevel (getSessionUser ()) === 0) echo "
  <h4 align=\"center\" class=\"warning\">" . $errorMsg[$lang][1] . "</h4>";

if (!empty ($errors)) echo "
  <h4 align=\"center\" class=\"error\">" . $errorMsg[$lang][0] . "</h4>";

?>