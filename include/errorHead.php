<?php
require_once 'include/errorMessages.php';

echo "<script type=\"text/javascript\">\n";
echo "var errorMsg = '<'+'span class=\"error\">" . $errorMsg[$lang][0]."&nbsp;&nbsp;<'+'img src=\"images/exclamation.gif\" /><'+'/span>';\n";
echo "var errorColor = '". ERR_COLOR . "';\n";
echo "var errors =  new Array(); \n";
foreach ($errorMessages[$lang] as $key => $value) {
	echo "errors[$key] = \"". $value."\";\n";
}
echo "</script>\n";
?>
