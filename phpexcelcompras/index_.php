<?php session_start();   ?>
<!DOCTYPE html>
<html>
<head>
	<title>Cargando Excel...</title>
</head>
<body>
<h1>&nbsp;</h1>
<table width="100%" border="0">
  <tr>
    <td align="center"><strong><em><h1>Se han cargado los productos para la factura <?php echo $_SESSION[facturaCompra]; ?></h1> </em></strong></td>
  </tr>
</table>
<p></p>
<table width="100%" border="0" align="center">
  <tr align="center">
    <td align="center">
    
      <?php
require_once 'PHPExcel/Classes/PHPExcel.php';


include("head.php");
include("navbar.php");







$archivo = $_GET['arch'];

$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();

include("../conecta_facturacion.php");

for ($row = 1; $row <= $highestRow; $row++){ 

		$ref =  $sheet->getCell("A".$row)->getValue();
		$cod  =  $sheet->getCell("B".$row)->getValue();
		$cant = $sheet->getCell("C".$row)->getValue();
		$cost = $sheet->getCell("D".$row)->getValue();
		$facto = $sheet->getCell("E".$row)->getValue();
		$ped =  $sheet->getCell("F".$row)->getValue();
		$cont =  $sheet->getCell("G".$row)->getValue();
		$sucu =  $sheet->getCell("H".$row)->getValue();
	//	echo "<br>";



		$consulta = mysqli_query($cone,"SELECT * FROM `products` where codigo_producto = '$cod';");

		$re = mysqli_fetch_array($consulta);
		$desc = $re['nombre_producto'];
		$uni =  $re['unidad'];
		$uni_sat =  $re['unidad_sat'];
		$c_sat =  $re['id_sat'];




		
		if ($ref != '')
		{

			//echo "Entro";

			//echo $sucu;

			$idf =  $_SESSION[idfactura];

		$inserta_compra_prov = mysqli_query($cone,"INSERT INTO `detalle_fact_provee` (`id`, `idorden`, `c_producto`, `descripcion`, `cantidad`,
		 `monto`, `unidad`, `idfactura`, `importe`, `unidad_sat`, `codigo_sat`, `pedimento`, `contenedor`, `referencia`, `factor`, `sucursal`) 
		VALUES (NULL, '0', '$cod', '$desc', '$cant', '$cost', '$uni', '$idf', '$impor', '$uni_sat', '$c_sat', '$ped', '$cont', '$ref', '$facto', '$sucu')");

		}


		// Saca cuantos hay

		$ref =  $sheet->getCell("A".$row)->getValue();
		$cod  =  $sheet->getCell("B".$row)->getValue();


	//	echo $ref;
	//	echo $cod;


		if ($ref != '')
		{


		$consulta_cuantos_hay = mysqli_query($cone,"SELECT * FROM `detalle_ordenes` where referencia = '$ref' and c_producto = '$cod';");
		$re_cuantos_hay = mysqli_fetch_array($consulta_cuantos_hay);

		$cuantos_hay =  $re_cuantos_hay ['cantidad'];
	
		$nueva_existencia = $cuantos_hay - $cant;

		//echo "Nueva Existencia: ".$nueva_existencia;


		$cantidad = mysqli_query($cone,"update detalle_ordenes set cantidad = '$nueva_existencia' where c_producto = '$cod' and referencia = '$ref';");

		$ingreso_almacen = mysqli_query($cone,"INSERT INTO `inventario` (`id`, `idproducto`, `cantidad`, `fact`, `tipo`, `referencia`, `pedimento`, `contenedor`) 
		VALUES (NULL, '$cod', '$cant', '0', 'INGRESO', '$ref', '$ped', '$cont');");

			
		// Actualiza Existencia en Productos


			$consulta_pro = mysqli_query($cone,"SELECT * FROM `products` where codigo_producto = '$cod';");
			$re_pro = mysqli_fetch_array($consulta_pro);


			$exitencia_actual = $re_pro[existencia];

			$existencia = $cant + $exitencia_actual;


		//	echo "Para almacen".$existencia;

			$actualiza = mysqli_query($cone,"UPDATE `products` SET `existencia` = '$existencia', `precio` = '$facto' 
			WHERE `products`.`codigo_producto` = '$cod';");


		//	echo "<a href='../registra_factura.php'></a>";

		}

		// Turn autocommit off
		mysqli_autocommit($cone,FALSE);

	
       

if (!mysqli_commit($cone)) {
	echo "Commit transaction failed";
	exit();
}




/*
	$valor = $sheet->getCell("A".$row)->getValue();


	if ($valor != '')
	{
		echo "entro";

		$canti = $sheet->getCell("A".$row)->getValue();
		$cod = $sheet->getCell("B".$row)->getValue();
		$pre = $sheet->getCell("C".$row)->getValue();



		$consulta = mysqli_query($cone,"SELECT * FROM `products` where codigo_producto = '$cod';");

		$re = mysqli_fetch_array($consulta);


		$desc = $re['nombre_producto'];
		$uni =  $re['unidad'];
		$ord =  $_SESSION[orden];



		$consulta = mysqli_query($cone,"INSERT INTO `detalle_ordenes` (`id`, `idorden`, `c_producto`, `descripcion`, `cantidad`, `monto`, `unidad`, `inicial`) 
		VALUES (NULL, '$ord', '$cod', '$desc', '$canti', '$pre', '$uni', '$canti')");



		$ingreso_almacen = mysqli_query($cone,"INSERT INTO `inventario` (`id`, `idproducto`, `cantidad`, `fact`, `tipo`) 
		VALUES (NULL, '$cod', '$cant', '$ord', 'INGRESO');");


		/* Disminuye la canttUdad disponible

		$nueva_cantidad =  mysqli_query($cone,"SELECT * FROM `ordenes` where id = '$ord';");
		$re_cantidad = mysqli_fetch_array($consulta_cantidad);

		$nueva_cantidad = $re[]

		$cantidad = mysqli_query($cone,"UPDATE `detalle_ordenes` SET `cantidad` = '45' WHERE `detalle_ordenes`.`id` = 102;")

		



	}  */


}

$use = $_SESSION['user_name'];
		$hoy_log = date("Y-m-d H:i:s");
		$accion = "Subio Archivo de Ingreso de Factura: ".$rf;

		$inserta_log = mysqli_query($cone,"INSERT INTO `log` (`id`, `fecha`, `accion`, `modulo`, `usuario`) 
		VALUES (NULL, '$hoy_log','$accion', 'Ordenes de Compra', '$use');");


 echo '<img src="https://img.icons8.com/officel/160/null/checked--v1.png"/>';

?>


<a href="../detalle_fact_reg.php?idorden=<?PHP	echo  $_SESSION[idfactura]; ?>">Ver Compra</a>
    
    </td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
