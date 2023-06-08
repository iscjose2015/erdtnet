<?php
//$serverName = "172.18.10.45"; //CONEXION REMOTA
$serverName = "elreysa.ddns.net"; //CONEXION REMOTA 

// Puesto que no se han especificado UID ni PWD en el array  $connectionInfo,
// La conexión se intentará utilizando la autenticación Windows.


$connectionInfo = array( "UID"=>"desarrollo", "PWD"=>"Desarrollo8", "Database"=>"ELREYSA");

$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {

      error_reporting(0);
      echo "CONEXION EXITOSA!!";

}else{
     echo "Conexión no se pudo establecer.<br />";
     die( print_r( sqlsrv_errors(), true));
}

?>