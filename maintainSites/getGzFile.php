<?php
$file = $_REQUEST['file'];
$filePath = "/var/backups/itech/unloads/" . $file;
if (is_file($filePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filePath));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        ob_clean();
        flush();
        readfile($filePath);
} else {
        echo "Fichier introuvable";
}
?>