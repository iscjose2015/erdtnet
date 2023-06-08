<?php
$cone = mysqli_connect("167.114.158.234","ian","Esteban7","facturacion");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
?>