<?php

$tabsSetup = "setupPanes('container1','pane1Tab');";
$pane3Label = ($encType == "17") ? $clinicalExam[$lang][0] : $conditions_header[$lang][1];
$pane4Label = ($encType == "17") ? $conditions_header[$lang][1] : $clinicalExam[$lang][0];

$tabHeaders = "
<!-- ------------------------ Tab Headers -------------------------------- -->
<div class=\"tab-container\" id=\"container1\">
  <table border=\"0\">
    <tr>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane1', this)\"
             id=\"pane1Tab\" class=\"first-tab\">" . $nurseSection[$lang][1] .  "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane2', this)\"
             id=\"pane2Tab\">" . $symptoms_header[$lang][0] .  "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane3', this)\"
             id=\"pane3Tab\">" . $pane3Label  .  "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane4', this)\"
             id=\"pane4Tab\">" . $pane4Label  . "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane5', this)\"
             id=\"pane5Tab\">" . $treatmentTab[$lang][1] . "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane6', this)\"
             id=\"pane6Tab\">" . $medicalEligARVs_header[$lang][1] . "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane7', this)\"
             id=\"pane7Tab\">" . $followupComments[$lang][1] . "</a></td>
    </tr>
  </table>";

?>
