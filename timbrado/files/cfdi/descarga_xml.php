

<?php

$archivo = $_GET['valor']."_timbrado.xml";

header('Content-Type: text/xml');
header("Content-Disposition:attachment ; filename=".$archivo);
header("Expires: Mon, 26 Jul 1990 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
    ob_clean();
    flush();
 
    echo file_get_contents($archivo);
 
    exit;
 
?>

