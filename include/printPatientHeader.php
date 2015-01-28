<div id="printPatientHeader" class="hide-this print-show">
    <table class="print-patient-info">
        <tr>
            <td><img src="<? if (isset($printHeaderPath)) echo $printHeaderPath ?>images/isante_logo_bw_large.png" alt="iSante" title="iSante" /></td>
            <td>
            <?
            echo "<h2>".$fname ." ". $lname."</h2>";
            echo "<div><span>".$dobDd[$lang][1].$colon[$lang][0]."</span> ".$patientDOB." <span>".$sex[$lang][0].$colon[$lang][0]."</span> ".$mf." <span>".$patName[$lang][4].$colon[$lang][0]."</span> ".$fnamemom."</div>";
            echo "<div><span>".$clinicPatientID[$lang][1].$colon[$lang][0]."</span> ".$clinID." <span>".$nationalID[$lang][1].$colon[$lang][0]."</span> ".$natID."</div>";
            //echo "<div>".$tabLabels[$lang][7]."</div>";
            ?>
            </td>
        </tr>
    </table>
 <?
 if (isset($printHeaderTitle)) {
     echo "<div class='print-report-title'>".$printHeaderTitle."</div>";
 }
 ?>
</div>