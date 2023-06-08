<?php
// http://localhost/curso_cfdi/php/demo_sql.php

error_reporting(E_ALL); ini_set('display_errors', '1');
date_default_timezone_set( 'America/Mexico_City' );

include_once( "db_sqlite.php" );
$conexion1 = new db();
$conexion1->conectar();

$empid = 1;
$cfdiserid = 1;
echo "<h3 align='center'> CFDI 3.3 </h3>";

	// Eliminar Info:
$m_sql = [];
$sql = "DELETE FROM cfdi_detalle WHERE empid=".$empid.";";
$m_sql[] = $sql;
$sql = "DELETE FROM cfdi WHERE empid=".$empid.";";
$m_sql[] = $sql;
// echo "<p> Transacci&oacute;n SQL (Delete): </p>";
// echo "<br>(".count($m_sql).") <pre>"; print_r( $m_sql ); echo "</pre>"; // exit;
if( count($m_sql) > 0 ){
	$resultado = $conexion1->transaccion_sql( $m_sql );
	// echo "<h3> Resultado: ( $resultado ) </h3>";
}
// exit;

// Insertar CFDI:

// Obtener el folio Mayor:
$sql = "SELECT max( cfdiid ) FROM cfdi WHERE empid=".$empid." AND cfdiserid=$cfdiserid;";
$cfdiid = trim( $conexion1->get( $sql ) );
if( empty( $cfdiid ) ) $cfdiid = 0;
// echo "<p> ($cfdiid) $sql </p>";

// ++$cfdiid;
// $sql = "INSERT INTO cfdi 
	// ( empid,cfdiserid,cfdiid,cfdicliid,cfdifec,cfdihor ) 
	// VALUES 
	// ( '".$empid."','".$cfdiserid."','".$cfdiid."','1','".date( "Y-m-d" )."','".date( "H:i:s" )."' );
// ";
// echo "<p> $sql </p>";
// $conexion1->ejecutar( $sql );

// Insertar CFDI y Detalle mediante Transaccion SQL:
$m_sql = [];
// ( '".$empid."','".$cfdiserid."','".$cfdiid."','$cfdicliid','".date( "Y-m-d" )."','".date( "H:i:s" )."','54900' );
++$cfdiid;
$cfdicliid = rand(1,4);
$sql = "INSERT INTO cfdi 
	( empid,cfdiserid,cfdiid,cfdicliid,cfdifec,cfdihor,cfdilugexp ) 
	VALUES 
	( '".$empid."','".$cfdiserid."','".$cfdiid."','$cfdicliid','".date("Y-m-d")."','".date("H:i:s")."','54900' );
";
$m_sql[] = $sql;

// Importe del encabezado:
$cfdisub = 0;
$cfdides = 0;
$cfdiiva = 0;
$cfditottra = 0;
$cfditot = 0;
// Detalle del CFDI:
$cfdidetid = 0;
// $no_conceptos = rand(1,10);
$no_conceptos = 1;
for( $i=1;$i<=$no_conceptos;$i++ ){
	++$cfdidetid;
	// $cfdiproid = 1;
	$cfdiproid = rand(0,2);
	// $cfdidetcan = 10;
	$cfdidetcan = rand(1,100);
	// $cfdidetval = 10;
	$cfdidetval = rand(1,100);
	$cfdidetcon = "Venta $i";
	$cfdidetdes = 0;
	$cfdidetsub = round( $cfdidetcan * $cfdidetval,2 );
	$cfdidetiva = round( ( $cfdidetsub - $cfdidetdes ) * .16,2 );
	$cfdidettot = round( $cfdidetsub - $cfdidetdes + $cfdidetiva,2 );

	$sql = "INSERT INTO cfdi_detalle 
		( empid,cfdiserid,cfdiid,cfdidetid,cfdiproid,cfdidetcan,cfdidetval,cfdidetcon,cfdidetdes,cfdidetsub,cfdidetiva,cfdidettot ) 
		VALUES 
		( '".$empid."','".$cfdiserid."','".$cfdiid."',$cfdidetid,$cfdiproid,$cfdidetcan,$cfdidetval,'$cfdidetcon',$cfdidetdes,$cfdidetsub,$cfdidetiva,$cfdidettot );
	";
	$m_sql[] = $sql;	
	// Acumulamos para el Encabezado:
	$cfdisub += $cfdidetsub;
	$cfdides += $cfdidetdes;
	$cfdiiva += $cfdidetiva;	
	$cfditot += $cfdidettot;	
}
// Actualizar importe de Encabezado:
$cfditottra = $cfdiiva;

$sql = "
	UPDATE cfdi 
	SET 
		cfdisub = ".round( $cfdisub,2 ).",
		cfdides = ".round( $cfdides,2 ).",
		cfdiiva = ".round( $cfdiiva,2 ).",
		cfditottra = ".round( $cfditottra,2 ).",
		cfditot = ".round( $cfditot,2 )."
	WHERE empid=".$empid." AND cfdiserid=".$cfdiserid." AND cfdiid=".$cfdiid.";
";
$m_sql[] = $sql;

// echo "<p> Transacci&oacute;n SQL: </p>";
// echo "<br>(".count($m_sql).") <pre>"; print_r( $m_sql ); echo "</pre>"; // exit;
if( count($m_sql) > 0 ){
	$resultado = $conexion1->transaccion_sql( $m_sql );
	// echo "<h3> Resultado: ( $resultado ) </h3>";
}

// Consultar Facturas:

$m_clientes = [];
$sql = "SELECT cfdicliid as id,cfdiclinom as nom FROM cfdi_clientes WHERE empid=".$empid.";";
$m_datos = $conexion1->getM($sql); 
// echo "<br>(".count($m_datos).") $sql<pre>"; print_r( $m_datos ); echo "</pre>"; exit;
foreach( $m_datos as $reg ){
	$id = trim( $reg[ "id" ] );
	$nom = trim( $reg[ "nom" ] );
	$m_clientes[ $id ] = $nom;
}

$sql = "
	SELECT * FROM cfdi e INNER JOIN cfdi_detalle d ON e.empid=d.empid AND e.cfdiserid=d.cfdiserid AND e.cfdiid=d.cfdiid
	WHERE e.empid=".$empid." AND e.cfdiserid=".$cfdiserid." 
	ORDER BY e.cfdiid,cfdidetid;
"; // AND e.cfdiid=".$cfdiid."
$m_datos = $conexion1->getM($sql); 
// echo "<br>(".count($m_datos).") $sql<pre>"; print_r( $m_datos ); echo "</pre>"; exit;

echo '
	<style>
		.tabla_zebra{ border-left:#ccc 1px solid; border-top:#ccc 1px solid;background-color:white; }
		.tabla_zebra td{ border-right:#ccc 1px solid; border-bottom:#ccc 1px solid; }
		.tabla_zebra th{ border-right:#ccc 1px solid; border-bottom:#ccc 1px solid; }
		.tabla_zebra tr:nth-child(even) {background-color: #f2f2f2;}
	</style>	
';
echo '<p><table align="center" border="0" cellpadding="10" cellspacing="0" class="tbl_csd tabla_zebra">';
echo "
	<tr>
		<th> Folio </th>
		<th> Fecha </th>
		<th> Cliente </th>
		<th> Tipo </th>
		<th> Moneda </th>
		<th> Total </th>
		<td> &nbsp; </td>
		<th> Partida </th>
		<th> Cantidad </th>
		<th> V. Unitario </th>
		<th> Concepto </th>
		<th> Subtotal </th>
		<th> IVA </th>
		<th> Total </th>
	</tr>
";
foreach( $m_datos as $reg ){
	$cfdiid = trim( $reg[ "cfdiid" ] );
	$cfdicliid = trim( $reg[ "cfdicliid" ] ); // ID CLIENTE
	$cfdifec = trim( $reg[ "cfdifec" ] );
	$cfdimon = trim( $reg[ "cfdimon" ] );
	$cfditpocom = trim( $reg[ "cfditpocom" ] );
	$cfditot = trim( $reg[ "cfditot" ] );
	$cfdidetid = trim( $reg[ "cfdidetid" ] );
	$cfdidetcan = trim( $reg[ "cfdidetcan" ] );
	$cfdidetval = trim( $reg[ "cfdidetval" ] );
	$cfdidetcon = trim( $reg[ "cfdidetcon" ] );
	$cfdidetdes = trim( $reg[ "cfdidetdes" ] );
	$cfdidetsub = trim( $reg[ "cfdidetsub" ] );
	$cfdidetiva = trim( $reg[ "cfdidetiva" ] );
	$cfdidettot = trim( $reg[ "cfdidettot" ] );
	echo "
		<tr>
			<td align='center'> $cfdiid </td>
			<td align='center'> $cfdifec </td>
			<td> ".$m_clientes[ $cfdicliid ]." </td>
			<td align='center'> $cfditpocom </td>
			<td align='center'> $cfdimon </td>
			<td align='right'> ".number_format( $cfditot,2,".",",")." </td>
			<td> &nbsp; </td>
			<td align='center'> $cfdidetid </td>
			<td align='right'> ".number_format( $cfdidetcan,2,".",",")." </td>
			<td align='right'> ".number_format( $cfdidetval,2,".",",")." </td>
			<td> $cfdidetcon </td>
			<td align='right'> ".number_format( $cfdidetsub,2,".",",")." </td>
			<td align='right'> ".number_format( $cfdidetiva,2,".",",")." </td>
			<td align='right'> ".number_format( $cfdidettot,2,".",",")." </td>
		</tr>
	";
}	
echo '</table></p>';

// Liberar Memoria SQL:
$m_sql = null;
$m_datos = null;
$conexion1->link = null;
$conexion1 = null;
?>