<?php

$tabsSetup = "setupPanes('container1', 'pane1Tab');";

$tabHeaders = "
<!-- ********************************* Tab Headers ****************************** -->
<div class=\"tab-container\" id=\"container1\">
  <table border=\"0\">
    <tr>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane1', this)\"
             id=\"pane1Tab\" class=\"first-tab\">"  . $vitals_header[$lang][1] . "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane2', this)\"
              id=\"pane2Tab\">"  . $vitals_header[$lang][3] .  "</a></td>
    </tr>
  </table>
";
?>