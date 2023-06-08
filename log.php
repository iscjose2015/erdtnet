  <?php
  


  function agrega_log($us,$acc,$mod){

    include("conecta_facturacion.php");
    date_default_timezone_set('America/Mexico_City');

    $hoy = date("Y-m-d H:i:s");


    $inserta_log = mysqli_query($cone,"INSERT INTO `log` (`id`, `fecha`, `accion`, `modulo`, `usuario`) 
    VALUES (NULL, '$hoy', '$acc', '$mod', '$us');");



  }




  //echo agrega_log("Ian","Ingreso Compa","Compras");

  ?>