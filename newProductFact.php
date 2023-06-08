<?php
function NewDataFa($id, $cantidad, $precio, $factura){
    include("conecta_facturacion.php");
    $sql = "SELECT * FROM products where codigo_producto = '$id'";
    $result = mysqli_query($cone, $sql);
    if ($result) {
        $arr_res = mysqli_fetch_array($result);

        $codigo     = $arr_res['codigo_producto'];
        $producto   = $arr_res['nombre_producto'];
        $cantidad   = $cantidad;
        $precio     = $precio;
        $unidad     = $arr_res['unidad'];
        $factura    = $factura;
        $importe    = 2 + 3;
        $idSat      = $arr_res['id_sat'];

        $inserta = mysqli_query($cone,"INSERT INTO detalle_invoices (id, idorden, c_producto, descripcion, cantidad, monto, unidad, idfactura, importe, unidad_sat, codigo_sat) 
        VALUES (NULL, '0', '$codigo', '$producto', '$cantidad', '$precio', '$unidad', '$factura', '$importe', '$unidad', '$idSat')");

        //$response[0] = 1;
        echo "1";



    }/* else {
        $err_res['errors'][] = 'noResults';
    }

    if (count($err_res['errors']) != 0) {
        return $err_res;
    }*/

    return $response;
} //EDITAR DETALLE FACTURA CONI

if (isset($_POST['name']) && isset($_POST['id']) && isset($_POST['cantidad']) && isset($_POST['ttalprecio']) && isset($_POST['factura'])) {
    $type       = $_POST['name'];
    $id         = $_POST['id'];
    $cantidad   = $_POST['cantidad'];
    $precio     = $_POST['ttalprecio'];
    $factura    = $_POST['factura'];

    switch ($type) {
        case 'NewDataFa':
            echo json_encode(NewDataFa($id, $cantidad, $precio, $factura));
            break;
    }
}

?>