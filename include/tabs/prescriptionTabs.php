<?php

$tabsSetup = "setupPanes('container1','pane1Tab');";
$tabHeaders = "
<!-- ------------------------ Tab Headers -------------------------------- -->
<div class=\"tab-container\" id=\"container1\">
  <table border=\"0\">
    <tr>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane1', this)\"
             id=\"pane1Tab\" class=\"first-tab\">"  . $committeeApproval[$lang][1] . "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane2', this)\"
             id=\"pane2Tab\">" . $newprescription_header[$lang][0] .  "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane3', this)\"
             id=\"pane3Tab\">" . $adherenceCounseling_header[$lang][0] .   "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane4', this)\"
             id=\"pane4Tab\">" . $pickupPersonInfo[$lang][0] . "</a></td>
    </tr>
  </table>";


if ( $version == 1 )
{
$tabHeaders = "
<!-- ------------------------ Tab Headers -------------------------------- -->
<div class=\"tab-container\" id=\"container1\">
  <table border=\"0\">
    <tr>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane1', this)\"
             id=\"pane1Tab\" class=\"first-tab\">"  . ucfirst(strtolower($visitType_header[$lang][0])) . "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane2', this)\"
             id=\"pane2Tab\">" . $newprescription_header[$lang][0] .  "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane4', this)\"
             id=\"pane4Tab\">" . $pickupPersonInfo[$lang][0] . "</a></td>
    </tr>
  </table>";
}
?>
