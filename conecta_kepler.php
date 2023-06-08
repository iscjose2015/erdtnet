
<?php


$data  =  @file_get_contents("
http://172.18.10.77/ws/ws_kepler/productos.php?codigo=001COLONIA05001");

  $items = json_decode($data, true);

  $tot = count($items);


  echo "Hola".$items[0]['nombre_familia'];
  

?>