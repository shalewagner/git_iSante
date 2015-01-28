<?php

$tabsSetup = "setupPanes('container1','pane1Tab');";
if ($version == "1" || $encType == "16") {
	$p3Header =  $clinicalExam[$lang][0];
	$p4Header =  $conditions_header[$lang][1];
} else {
	$p4Header =  $clinicalExam[$lang][0];
	$p3Header =  $conditions_header[$lang][1];	
}

$tabHeaders = "
<!-- ------------------------ Tab Headers -------------------------------- -->
<div class=\"tab-container\" id=\"container1\">
  <table border=\"0\">
    <tr>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane1', this)\"
             id=\"pane1Tab\" class=\"first-tab\">"  . $nurseSection[$lang][1] .  "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane2', this)\"
             id=\"pane2Tab\">" . $symptoms_header[$lang][0] .  "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane3', this)\"
             id=\"pane3Tab\">" . $p3Header .  "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane4', this)\"
             id=\"pane4Tab\">" . $p4Header . "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane5', this)\"
             id=\"pane5Tab\">" . $noneTreatments[$lang][0] . "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane6', this)\"
             id=\"pane6Tab\">" . $treatmentTab[$lang][1] . "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane7', this)\"
             id=\"pane7Tab\">" . $medicalEligARVs_header[$lang][1] . "</a></td>
      <td class=\"tabs\" nowrap><a href=\"#\" onClick=\"return showPane('pane8', this)\"
             id=\"pane8Tab\">" . $assessmentPlan_header[$lang][1] . "</a></td>
    </tr>
  </table>";

?>