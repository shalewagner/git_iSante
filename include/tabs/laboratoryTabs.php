<?php

$tabsSetup = "setupPanes('container1','pane1Tab');";

$tabHeaders = "
<!-- ------------------------ Tab Headers -------------------------------- -->
<div class=\"tab-container\" id=\"container1\">
  <table border=\"0\">
    <tr>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane1', this)\"
        id=\"pane1Tab\" class=\"first-tab\">" .
        ucfirst(strtolower($visitType_header[$lang][0])) . "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane2', this)\"
        id=\"pane2Tab\">" . $labs_header[$version][$lang][0] . "</a></td>
    </tr>  </table>";

?>
