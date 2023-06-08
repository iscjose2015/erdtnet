<?php
//EDITAR FACTURA
function Cliente($id)
{
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

function product_up($id)
{
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

function empresIMG($id)
{
    include("conecta_facturacion.php");
    $response = array(
        0 => null,
        'id' => null,
        1 => null,
        'empresa' => null,
        2 => null,
        'logo' => null,
    );
    $err_res = array(
        'errors' => array(),
    );

    $sql = "SELECT b.id_relacion, a.empresa, b.documento  FROM empresas AS a
	    INNER JOIN dctos_releciones AS b
            ON a.id = b.id_relacion
        WHERE a.id = '$id'";
    $result = mysqli_query($cone, $sql);
    if ($result) {
        $arr_res = mysqli_fetch_array($result);

        $id         = $arr_res['id_relacion'];
        $nombreEmp  = $arr_res['empresa'];
        $img        = $arr_res['documento'];

        $response[0] = $id;
        $response[1] = $nombreEmp;
        $response[2] = $img;

    } else {
        $err_res['errors'][] = 'noResults';
    }

    if (count($err_res['errors']) != 0) {
        return $err_res;
    }

    return $response;
} //EDITAR EMPRESA CONI


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
    }
}
