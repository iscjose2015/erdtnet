<?php session_start();

include("conecta_facturacion.php");

$orden = $_POST[idorden];

//echo "Orden: ".$orden;
//echo "<br>";

//echo "Factura: ".$_SESSION['factura_seleccionada'];
//echo "<br>";

$factu = $_SESSION['factura_seleccionada'];

$consulta_seleccione = mysqli_query($cone,"select * from detalle_ordenes where idorden = '$orden'");

while($re_seleccione=mysqli_fetch_array($consulta_seleccione)){

    $id = $re_seleccione[id];


    

    if($_POST[$id] == on) {
    // $id;
     $_POST['txt_'.$id]; 

    $cant = $_POST['txt_'.$id]; 


       

    
        // consulta del id de detalle
        $consulta_detalle = mysqli_query($cone,"SELECT * FROM `detalle_ordenes` where id = '$id'");
        $re_detalle = mysqli_fetch_array($consulta_detalle);

        $cod_prod =$re_detalle['c_producto'];

      // $cod_prod;

        

        
        $consulta_llena = mysqli_query($cone,"SELECT a.id,a.c_producto, b.nombre_producto, b.id_sat, b.nom_sat, b.unidad_sat, a.unidad, b.unidad, a.monto FROM `detalle_ordenes` a 
        INNER JOIN products b ON a.c_producto = b.codigo_producto where c_producto = '$cod_prod' and idorden = '$orden'");

        $re_prod = mysqli_fetch_array($consulta_llena);

        $des = $re_prod['nombre_producto'];
        $uni = $re_prod['unidad'];
        $mon = $re_prod['monto'];

       // echo $des;
       // echo $uni;
       // echo $mon;
       $u_sat = $re_prod['unidad_sat'];
        $c_sat = $re_prod['id_sat'];
        $cprod = $re_prod['c_producto'];

        $impo = $cant * $mon;

        

        $inserta = mysqli_query($cone,"INSERT INTO `detalle_fact_provee` (`id`, `idorden`, `c_producto`, `descripcion`,
         `cantidad`, `monto`, `unidad`, `idfactura`, `importe`, `unidad_sat`, `codigo_sat`) 
        VALUES (NULL, '$orden', '$cprod', '$des', '$cant', '$mon', '$uni', '$factu', '$impo', '$u_sat', '$c_sat');");


        $cantidad_nueva = $re_detalle[cantidad] - $cant;


        echo $cantidad_nueva;


        $act = mysqli_query($cone,"UPDATE `detalle_ordenes` SET `cantidad` = '$cantidad_nueva' WHERE `detalle_ordenes`.`id` = '$id';");

        $ingreso = mysqli_query($cone,"INSERT INTO `inventario` (`id`, `idproducto`, `cantidad`, `fact`, `tipo`) 
        VALUES (NULL, '$cprod', '$cant', '$orden', 'INGRESO');");

        // Actualizar Inventario

        $consulta_prod = mysqli_query($cone,"SELECT * FROM `products` WHERE `codigo_producto` = '$cprod'");
        $re_prod = mysqli_fetch_array($consulta_prod);

        $existencia = $re_prod[existencia];

      
        echo "Existencia Guardada: ".$existencia;
        echo "<br>";

        $nueva_existencia = $cant + $existencia;

        echo "Cantidad".$cant;
        echo "<br>";

        echo "Nueva Existencia: ".$nueva_existencia;
        echo "<br>";

        echo $cprod;

        

        $actualiza_existencia = mysqli_query($cone,"UPDATE `products` SET `existencia` = '$nueva_existencia' 
        WHERE `products`.`codigo_producto` = '$cprod';");


    

    }


}

echo "<script language='javascript'>window.parent.location='detalle_fact_reg.php?idorden=".$factu."&serie=".$factu."'</script>";

?>
