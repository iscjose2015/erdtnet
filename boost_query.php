<?php
//EDITAR FACTURA
function Cliente($id){
    include("conecta_facturacion.php");
    $response = array(
        0 => null,
        'id' => null,
        1 => null,
        'rfc' => null,
        2 => null,
        'nomCliente' => null,
        3 => null,
        'correo' => null,
        4 => null,
        'direccion' => null,
        5 => null,
        'telefono' => null,
        6 => null,
        'colonia' => null,
        7 => null,
        'ciudad' => null,
        8 => null,
        'estado' => null,
        9 => null,
        'facoriginal' => null,
        10 => null,
        'estatus' => null,
    );
    $err_res = array(
        'errors' => array(),
    );

    $sql = "SELECT * FROM clientes WHERE id_cliente = '$id'";
    $result = mysqli_query($cone, $sql);
    if ($result) {
        $arr_res = mysqli_fetch_array($result);

        $id         = $arr_res['id_cliente'];
        $rfc        = $arr_res['rfc'];
        $nomClient  = $arr_res['nombre_cliente'];
        $correo     = $arr_res['email_cliente'];
        $direccion  = $arr_res['direccion_cliente'];
        $telefon    = $arr_res['telefono_cliente'];
        $colonia    = $arr_res['colonia'];
        $ciudad     = $arr_res['ciudad'];
        $estado     = $arr_res['estado'];
        $cp         = $arr_res['cp'];
        $estatus    = $arr_res['status_cliente'];

        $response[0] = $id;
        $response[1] = $rfc;
        $response[2] = $nomClient;
        $response[3] = $correo;
        $response[4] = $direccion;
        $response[5] = $telefon;
        $response[6] = $colonia;
        $response[7] = $ciudad;
        $response[8] = $estado;
        $response[9] = $cp;
        $response[10] = $estatus;

    } else {
        $err_res['errors'][] = 'noResults';
    }

    if (count($err_res['errors']) != 0) {
        return $err_res;
    }

    return $response;
} //EDITAR CLIENTE CONI

function product_up($id){
    include("conecta_facturacion.php");
    $response = array(
        0 => null,
        'id' => null,
        1 => null,
        'codProd' => null,
        2 => null,
        'nomProduc' => null,
        3 => null,
        'idSat' => null,
        4 => null,
        'nombSat' => null,
        5 => null,
        'unidSat' => null
    );
    $err_res = array(
        'errors' => array(),
    );

    $sql = "SELECT id_producto, codigo_producto, nombre_producto,id_sat, nom_sat, unidad_sat FROM products WHERE id_producto = '$id'";
    $result = mysqli_query($cone, $sql);
    if ($result) {
        $arr_res = mysqli_fetch_array($result);

        $id             = $arr_res['id_producto'];
        $codproduct     = $arr_res['codigo_producto'];
        $nomproduct     = $arr_res['nombre_producto'];
        $idSat          = $arr_res['id_sat'];
        $nomSat         = $arr_res['nom_sat'];
        $unidSat        = $arr_res['unidad_sat'];

        $response[0] = $id;
        $response[1] = $codproduct;
        $response[2] = $nomproduct;
        $response[3] = $idSat;
        $response[4] = $nomSat;
        $response[5] = $unidSat;

    } else {
        $err_res['errors'][] = 'noResults';
    }

    if (count($err_res['errors']) != 0) {
        return $err_res;
    }

    return $response;
} //EDITAR PRODYCTO CONI

function empresIMG($id){
    include("conecta_facturacion.php");
    $response = array(
        0 => null,
        'id' => null,
        1 => null,
        'empresa' => null,
    );
    $err_res = array(
        'errors' => array(),
    );

    $sql = "SELECT * FROM empresas WHERE id = '$id'";
    $result = mysqli_query($cone, $sql);
    if ($result) {
        $arr_res = mysqli_fetch_array($result);

        $id         = $arr_res['id'];
        $nombreEmp  = $arr_res['empresa'];

        $response[0] = $id;
        $response[1] = $nombreEmp;

    } else {
        $err_res['errors'][] = 'noResults';
    }

    if (count($err_res['errors']) != 0) {
        return $err_res;
    }

    return $response;
} //EDITAR EMPRESA CONI

function get_email($id){
    include("conecta_facturacion.php");
    $response = array(
        0 => null,
        'id' => null,
        1 => null,
        'correo' => null,
    );
    $err_res = array(
        'errors' => array(),
    );

    $sql = "SELECT * FROM cuenta_correos WHERE activo = 1 AND id = '$id'";
    $result = mysqli_query($cone, $sql);
    if ($result) {
        $arr_res = mysqli_fetch_array($result);

        $id     = $arr_res['id'];
        $correo = $arr_res['correo'];

        $response[0] = $id;
        $response[1] = $correo;

    } else {
        $err_res['errors'][] = 'noResults';
    }

    if (count($err_res['errors']) != 0) {
        return $err_res;
    }

    return $response;
}

function complement_up($id){
    include("conecta_facturacion.php");
    $response = array(
        0 => null,
        'id' => null,
        1 => null,
        'uuid' => null,
        2 => null,
        'serieFolio' => null,
        3 => null,
        'parcialidad' => null,
        4 => null,
        'saldAnterior' => null,
        5 => null,
        'serie' => null,
        6 => null,
        'folio' => null

    );
    $err_res = array(
        'errors' => array(),
    );

    $sql = "SELECT * FROM detalle_complementos where id = '$id'";
    $result = mysqli_query($cone, $sql);
    if ($result) {
        $arr_res = mysqli_fetch_array($result);

        $idCom          = $arr_res['id'];
        $uuid           = $arr_res['uuid'];
        $seriefolio     = $arr_res['serie'];
        $parcialidad    = $arr_res['parcialidad'];
        $saldoAnt       = $arr_res['saldo'];
        $importPago     = $arr_res['importe'];
        $folio          = $arr_res['folio'];

        $response[0] = $idCom;
        $response[1] = $uuid;
        $response[2] = $seriefolio;
        $response[3] = $parcialidad;
        $response[4] = $saldoAnt;
        $response[5] = $importPago;
        $response[6] = $folio;


    } else {
        $err_res['errors'][] = 'noResults';
    }

    if (count($err_res['errors']) != 0) {
        return $err_res;
    }

    return $response;
} //EDITAR COMPLEMENTO CONI

function DetsFact_up($id){
    include("conecta_facturacion.php");
    $response = array(
        0 => null,
        'id' => null,
        1 => null,
        'cantidad' => null,
        2 => null,
        'unidad' => null,
        3 => null,
        'clave' => null,
        4 => null,
        'descripcion' => null,
        5 => null,
        'pu' => null,
        6 => null,
        'importe' => null,
    );
    $err_res = array(
        'errors' => array(),
    );

    $sql = "SELECT * FROM detalle_invoices WHERE id = '$id'";
    $result = mysqli_query($cone, $sql);
    if ($result) {
        $arr_res = mysqli_fetch_array($result);

        $id         = $arr_res['id'];
        $cant       = $arr_res['cantidad'];
        $unidad     = $arr_res['unidad'];
        $clave      = $arr_res['c_producto'];
        $descrip    = $arr_res['descripcion'];
        $pu         = $arr_res['monto'];
        $importe    = ($cant * $pu);

        $response[0] = $id;
        $response[1] = $clave;
        $response[2] = $descrip;
        $response[3] = $unidad;
        $response[4] = $cant;
        $response[5] = $pu;
        $response[6] = $importe;


    } else {
        $err_res['errors'][] = 'noResults';
    }

    if (count($err_res['errors']) != 0) {
        return $err_res;
    }

    return $response;
} //EDITAR DETALLE FACTURA CONI

if (isset($_POST['name']) && isset($_POST['id'])) {
    $type = $_POST['name'];
    $id = $_POST['id'];

    switch ($type) {
        case 'cliente':
            echo json_encode(Cliente($id));
            break;
        case 'up_product':
            echo json_encode(product_up($id));
            break;
        case 'empresa':
            echo json_encode(empresIMG($id));
            break;
        case 'correo':
            echo json_encode(get_email($id));
            break;
        case 'UpComplemet':
            echo json_encode(complement_up($id));
            break;
        case 'UpDetaFactura':
            echo json_encode(DetsFact_up($id));
            break;
    }
}
