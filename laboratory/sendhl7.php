<?php
$msg = array ("msg" => "MSH|^~\&|^iSantu00e9^99LAB|^Hu00f4pital Saint-Jean de Limbe^99LAB|^OpenELIS^99LAB|^Hu00f4pital Saint-Jean de Limbe^99LAB|20141118183941-0500||OML^O21^OML_O21|20141118183941-050034892|P|2.5.1||||||UTF-8 PID|1||22d0db1f-3204-4b40-a6d0-b1f52e9dd860^^^^GU~64473234^^^^NA~5645^^^^PC||01185985^91124789||20061217|F|||71604712^95268399^69144604|||||A ORC|NW|36101-396326||36101-396326-1||||||||36101-cirgadmin^cirgadmin^^^^^^^^^^^U OBR|1|36101-396326||T-Hemoglobine^Hemoglobine^99LAB OBX|1|ST|SPEC_TYPE^Specimen Type^99LAB||Sang||||||F ORC|NW|36101-396326||36101-396326-1||||||||36101-cirgadmin^cirgadmin^^^^^^^^^^^U OBR|2|36101-396326||T-INR^INR^99LAB OBX|1|ST|SPEC_TYPE^Specimen Type^99LAB||Plasma||||||F ORC|NW|36101-396326||36101-396326-1||||||||36101-cirgadmin^cirgadmin^^^^^^^^^^^U OBR|3|36101-396326||T-Heparinemie^Heparinemie^99LAB OBX|1|ST|SPEC_TYPE^Specimen Type^99LAB||Plasma||||||F "); 

#$msg = array ("msg" => "MSH|^~\&|^iSanté^99LAB|^Hôpital de la Communauté Haïtienne^99LAB|^OpenELIS^99LAB|^Hôpital de la Communauté Haïtienne^99LAB|20130606154017-0500||OML^O21^OML_O21|20130606154017-050096620|P|2.5.1||||||UTF-8\015PID|1||c07da369-e57f-4a22-a67f-c756a37f5038^^^^GU~60945361^^^^NA~01004^^^^ST||96128211^19030434||20110217|M|||24072007^24072007^24072007||^^^^^^240720078|||S\015ORC|NW|11404-265422||11404-265422-1\015OBR|1|11404-265422||P-CD4^CD4^99LAB\015OBX|1|ST|SPEC_TYPE^Specimen Type^99LAB||Sang||||||F\015ORC|NW|11404-265422||11404-265422-1\015OBR|2|11404-265422||T-CD4 Compte Absolu^CD4 Compte Absolu^99LAB\015OBX|1|ST|SPEC_TYPE^Specimen Type^99LAB||Sang||||||F\015ORC|NW|11404-265422||11404-265422-1\015OBR|3|11404-265422||T-CD4 Compte en %^CD4 Compte en %^99LAB\015OBX|1|ST|SPEC_TYPE^Specimen Type^99LAB||Sang||||||F\015ORC|NW|11404-265422||11404-265422-1\015OBR|4|11404-265422||T-Hépatite C IgM^Hépatite C IgM^99LAB\015OBX|1|ST|SPEC_TYPE^Specimen Type^99LAB||Sang||||||F\015ORC|NW|11404-265422||11404-265422-1\015OBR|5|11404-265422||T-VIH Elisa^VIH Elisa^99LAB\015OBX|1|ST|SPEC_TYPE^Specimen Type^99LAB||Plasma||||||F\015ORC|NW|11404-265422||11404-265422-1\015OBR|6|11404-265422||T-VIH test rapide^VIH test rapide^99LAB\015OBX|1|ST|SPEC_TYPE^Specimen Type^99LAB||Serum||||||F\015\012");

#$msg = array ("msg" => "MSH|^~\&|^iSanté^99LAB|^1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890^99LAB|^OpenELIS^99LAB|^1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890^99LAB|20131008143940-0500||OML^O21^OML_O21|20131008143940-050056054|P|2.5.1||||||UTF-8\015PID|1||fb3898b9-1ebc-4277-8f4e-f710287dc1ee^^^^GU~34567890^^^^NA~pc-25^^^^PC||Testlist^Long||20000101|F|||1251531531235^81870812^11533203||^^^^^^97994239|||S\015ORC|NW|11404-9999991||11404-9999991-1||||||||11404-shw2^shw2^^^^^^^^^^^U\015OBR|1|11404-9999991||P-CDV^CDV^99LAB\015OBX|1|ST|SPEC_TYPE^Specimen Type^99LAB||Serum||||||F\015\012");

$headers = "Transfer-Encoding: chunked\r\nContent-type: application/hl7-v2; charset=UTF-8\r\nContent-Length: 1\r\n";

#$xfer_url = "https://openelis-dev.cirg.washington.edu/haitiOpenElis/OrderRequest";
#$xfer_url = "http://140.142.66.149:8080/openElisGlobal/OrderRequest";
#$xfer_url = "http://140.142.66.124:8180/haitiOpenElis/OrderRequest";
$xfer_url = "http://192.168.1.108:8180/haitiOpenElis/OrderRequest";

$xfer_handle = curl_init ();
curl_setopt ($xfer_handle, CURLOPT_URL, $xfer_url);
curl_setopt ($xfer_handle, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt ($xfer_handle, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt ($xfer_handle, CURLOPT_HEADER, 0);
curl_setopt ($xfer_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($xfer_handle, CURLOPT_CONNECTTIMEOUT, 60);
curl_setopt ($xfer_handle, CURLOPT_TIMEOUT, 60);
curl_setopt ($xfer_handle, CURLOPT_HTTPHEADER, array("Content-type: application/hl7-v2; charset=UTF-8"));
curl_setopt ($xfer_handle, CURLINFO_HEADER_OUT, true);
curl_setopt ($xfer_handle, CURLOPT_POSTFIELDS, $msg['msg']);
$res = curl_exec ($xfer_handle);
echo "Request:\n" . curl_getinfo ($xfer_handle, CURLINFO_HEADER_OUT) . "\n";
if ($res !== false) {
  echo "Sent:\n$res\n";
} else {
  echo "Error:\n" . $curl_error ($xfer_handle) . "\n";
}

#$options = array ('http' => array ('method' => 'POST', 'content' => $msg, 'header' => $headers));
#$ctx = stream_context_create ($options);
#$fp = @fopen ($xfer_url, 'rb', false, $ctx);
#if (!$fp) {
#  echo "Error with $xfer_url: $php_errormsg\n";
#} else {
#  $res = @stream_get_contents ($fp);
#  if ($res !== false) {
#    echo "Sent\n$res";
#  } else {
#    echo "Error reading from $xfer_url: $php_errormsg\n";
#  }
#}

?>
