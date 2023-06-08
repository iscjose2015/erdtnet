<?php

include("conecta_facturacion.php");


function agrega_alog($usuario,$accion,$modulo){

      date_default_timezone_set("America/Mexico_City");

      $fe = date("Y-m-d H:i:sa");
      $acc = $accion;
      $mod = $modulo;
      $us = $_SESSION['user_name'];
    
      $inserta = mysqli_query($cone,"INSERT INTO `log` (`id`, `fecha`, `accion`, `modulo`, `usuario`) 
      VALUES (NULL, '$fe', '$acc', '$mod', '$us');");

}

agrega_alog("usuario","Hola","mod");



?>
