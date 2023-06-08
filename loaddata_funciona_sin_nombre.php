<?php
// Conectar a la base de datos
//$cone = new mysqli("localhost","root","","facturacion");
include("conecta_facturacion.php");
// Crear una variable para almacenar los datos
$data_array = array();
// SQL para obtener los datos
$sql = mysqli_query ($cone, "SELECT id_producto, codigo_producto, nombre_producto, id_sat, nom_sat, unidad_sat, peso, idfamilia, familia FROM products");
//$sql = "SELECT * FROM products";

// Ejeuctar el SQL
//$query = $cone->query($sql);
// Recorrer los resultados
//while($data = $query->mysqli_fetch_array()){
while($data = mysqli_fetch_array($sql)){

	$idProduct	= $data['id_producto'];
	$codProduc	= $data['codigo_producto'];
	$nomProduc	= $data['nombre_producto'];
	$idSat		= $data['id_sat'];
	$nomSat		= $data['nom_sat'];
	$unidSat	= $data['unidad_sat'];
	$pesokg		= $data['peso'];
	$idFamilia	= $data['idfamilia'];
	$familia	= $data['familia'];

	// Poner los datos en un array en el orden de los campos de la tabla
	//$data_array[] = array($data->id_producto, $data->codigo_producto , $data->nombre_producto, $data->id_sat, $data->nom_sat, $data->unidad_sat, $data->id_producto);
	$data_array[] = array('idproduct'=>$idProduct, 'codproduct'=>$codProduc, 'idsat'=>$idSat, 'nombsat'=>$nomSat, 'unidadsat'=>$unidSat, 'peso'=>$pesokg,'idFamilia'=>$idFamilia, 'familia'=>$familia);
}
// crear un array con el array de los datos, importante que esten dentro de : data
$json_string = json_encode($data_array);
echo $json_string;

?>