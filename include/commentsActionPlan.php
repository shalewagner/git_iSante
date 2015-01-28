<?php

echo "


  <table class=\"header\">
   <tr>
    <td>
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">" . $obstaclesRemarks[$lang][1] . "</td>
      </tr>
      <tr>
       <td><textarea tabindex=\"" . ($tabIndex + 1) . "\" name=\"obstaclesRemarks\" cols=\"80\" rows=\"10\">" . getData ("obstaclesRemarks", "textarea") . "</textarea></td>
      </tr>
     </table>
    </td>
   </tr>
  </table>
";
?>
