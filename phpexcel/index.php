<?php session_start();   
		 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Cargando Excel...</title>
</head>
<body>
<h1>Espere</h1>
<?php
require_once 'PHPExcel/Classes/PHPExcel.php';
$archivo = $_GET['arch'];
$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();

include("../conecta_facturacion.php");

for ($row = 1; $row <= $highestRow; $row++){ 
	//	echo $sheet->getCell("A".$row)->getValue()." - ";
	//	echo $sheet->getCell("B".$row)->getValue()." - ";
	//	echo $sheet->getCell("C".$row)->getValue();
	//	echo "<br>";


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
		$rf=  $_SESSION[referencia];


		echo $ord;

		$consulta = mysqli_query($cone,"INSERT INTO `detalle_ordenes` (`id`, `idorden`, `c_producto`, `descripcion`, `cantidad`, `monto`, `unidad`, `inicial`, `referencia`) 
		VALUES (NULL, '$ord', '$cod', '$desc', '$canti', '$pre', '$uni', '$canti', '$rf')");

		
	



		$ingreso_almacen = mysqli_query($cone,"INSERT INTO `inventario` (`id`, `idproducto`, `cantidad`, `fact`, `tipo`) 
		VALUES (NULL, '$cod', '$cant', '$ord', 'INGRESO');");


		/* Disminuye la canitdad disponible

		$nueva_cantidad =  mysqli_query($cone,"SELECT * FROM `ordenes` where id = '$ord';");
		$re_cantidad = mysqli_fetch_array($consulta_cantidad);

		$nueva_cantidad = $re[]

		$cantidad = mysqli_query($cone,"UPDATE `detalle_ordenes` SET `cantidad` = '45' WHERE `detalle_ordenes`.`id` = 102;")

		*/



	}


}

		$use = $_SESSION['user_name'];
		$hoy_log = date("Y-m-d H:i:s");
		$accion = "Subio Archivo de compra: ".$rf;

		$inserta_log = mysqli_query($cone,"INSERT INTO `log` (`id`, `fecha`, `accion`, `modulo`, `usuario`) 
		VALUES (NULL, '$hoy_log','$accion', 'Ordenes de Compra', '$use');");

echo "<script language='javascript'>window.parent.location='../detalle_orden.php?idorden=$ord'</script>";


?>
</body>
</html>
