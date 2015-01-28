<?php

print itech_hello_world() . '<br><br>';

print_r(itech_translateSql('select getdate();'));
print '<br><br>';

print_r(itech_splitSql(' select getdate();;;;; ;; ; ; ; bar; ";;;"; '));
print '<br><br>';

print_r(itech_splitSql(''));
print '<br><br>';

print_r(itech_splitSql('"'));
print '<br><br>';

?>