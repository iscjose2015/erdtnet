<?php error_reporting(0);
$cone = mysqli_connect("localhost","ian","Esteban7","facturacion");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
?>