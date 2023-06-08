<?php
// http://localhost/curso_cfdi/php/csd_procesar.php

error_reporting(E_ALL); ini_set('display_errors', '1');
if( isset( $_POST["rfc"] ) ){
	// echo "<br> "; echo "<br><pre>"; print_r( $_POST ); echo "</pre><br>";
	// echo "<br> "; echo "<br><pre>"; print_r( $_FILES ); echo "</pre><br>";
	$rfc = strtoupper( trim( $_POST[ "rfc" ] ) );
	$password = trim( $_POST[ "password" ] );
	// Subir los archivos:
	if( isset($_FILES["cer"]["tmp_name"]) ) $file_cer = trim($_FILES["cer"]["tmp_name"]);
	if( isset($_FILES["key"]["tmp_name"]) ) $file_key = trim($_FILES["key"]["tmp_name"]);	
	$ruta_documentos = "../files/csd/".$rfc."/";
	if( !file_exists( $ruta_documentos ) ){
		if( !mkdir( $ruta_documentos, 0777, true ) ){ 
			die('<br>Error al crear: '. $ruta_documentos );
		}else{ 
			// echo "<br>Se crea la carpeta: $ruta_documentos";			
		}	
	}
	$file_cer2 = $ruta_documentos.trim($_FILES["cer"]["name"]);
	$file_key2 = $ruta_documentos.trim($_FILES["key"]["name"]);
	$empdockeypem = "";
	// echo "<p> ($file_empdoccer) ==> ($file_cer) </p>";
	// echo "<p> ($file_empdockey) ==> ($empdockey) </p>";
	// echo "<p> ($file_empdockeypem) ==> ($empdockeypem) </p>";
	if(!move_uploaded_file($file_cer, $file_cer2)){
		echo "<br> Error al subir el archivo: ($file_cer)."; exit;
	}
	if(!move_uploaded_file($file_key, $file_key2)) {
		echo "<br> Error al subir el archivo: ($file_key).";  exit;
	}	
	
	// Procesar los CSD:
	
	// Generar el archivo .key.pem
	$archivo_key_pem = $ruta_documentos."".$rfc.".key.pem";
	$generar_key_pem = "openssl pkcs8 -inform DER -in $file_key2 -passin pass:".$password." -out ".$archivo_key_pem;
	echo "<br> $generar_key_pem";
	exec($generar_key_pem);
	// echo "<br> "; echo "<br><pre>"; print_r( $generar_key_pem ); echo "</pre><br>"; // exit;	

	// Generar el archivo .cer.pem
	$archivo_cer_pem = $ruta_documentos."".$rfc.".cer.pem";
	// $generar_cer_pem = "openssl pkcs8 -inform DER -in $file_cer2 -passin pass:".$password." -out ".$archivo_cer_pem;
	$generar_cer_pem = "openssl x509 -inform DER -outform PEM -in $file_cer2 -pubkey > ".$archivo_cer_pem;
	echo "<br> $generar_cer_pem";
	exec($generar_cer_pem);
	
	if( file_exists( $archivo_cer_pem ) ){
		// Vigencia, noCertificado, Certificado:
		$fechaInicio = "openssl x509 -in ".$archivo_cer_pem." -startdate -noout";
		echo "<br> $fechaInicio";
		$fechaInicio = exec($fechaInicio);
		// echo "<br> R= $fechaInicio";
		$fechaInicio = substr($fechaInicio,10);
		$fechaInicio = DateTime::createFromFormat("F j H:i:s Y e",$fechaInicio);
		$fechaInicio = $fechaInicio->format("Y-m-d");
		
		$fechaFin = "openssl x509 -in ".$archivo_cer_pem." -enddate -noout";
		echo "<br> $fechaFin";
		$fechaFin = exec($fechaFin);
		$fechaFin = substr($fechaFin,9);
		$fechaFin = DateTime::createFromFormat("F j H:i:s Y e",$fechaFin);
		$fechaFin = $fechaFin->format("Y-m-d");
		
		// Serial:
		$serial = "openssl x509 -in ".$archivo_cer_pem." -serial -noout";
		echo "<br> $fechaFin";
		$serial = exec($serial);
		$serial = substr($serial, 7);
		$nvoSerial = "";
		for($i=0;$i<strlen($serial);$i++){
			if(($i % 2)!=0){
				$nvoSerial .= $serial[$i];
			}
		}
		$noCertificado = $nvoSerial;

		// Certificado
		$cadenaSerial = "openssl x509 -in ".$archivo_cer_pem." -serial";
		$arregloResultados = array();
		exec($cadenaSerial, $arregloResultados);
		$cadenaSerial = implode("",$arregloResultados);
		$posicion = strpos($cadenaSerial, "-----BEGIN CERTIFICATE-----");
		$cadenaSerial = substr($cadenaSerial, $posicion+27);
		$cadenaSerial = substr($cadenaSerial, 0, -25);
		$cadenaSerial = str_replace("", "\n",$cadenaSerial);
		$Certificado = $cadenaSerial;
	   
		echo "
			<p> No Certificado: <br><input type='text' class='caja1c' value='$noCertificado'/> </p>
			<p> Vigencia inicio: <br><input type='text'  class='caja1c' value='$fechaInicio'/> </p>
			<p> Vigencia fin: <br><input type='text'  class='caja1c' value='$fechaFin'/> </p>
			<p> Certificado: <br><textarea cols='100' rows='5' class='caja1c'>$Certificado</textarea> </p>		
		";   
		$sql = "
			UPDATE cfdi_series 
			SET 
				cfdiserdesnocer='".$noCertificado."', 
				cfdiserdes_cerini='".$fechaInicio."', 
				cfdiserdes_cerfin='".$fechaFin."', 			
				cfdiserdescertif='".$Certificado."'
			WHERE empid=0 AND cfdiserid=0;
		";
		echo "<p> $sql </p>";
	}else{
		echo "<p> El archivo:$archivo_cer_pem no se gener&oacute; correctamente. </p>";
		
	}
}
?>
<style>
	.tabla_zebra{ border-left:#ccc 1px solid; border-top:#ccc 1px solid;background-color:white; }
	.tabla_zebra td{ border-right:#ccc 1px solid; border-bottom:#ccc 1px solid; }
	.tabla_zebra th{ border-right:#ccc 1px solid; border-bottom:#ccc 1px solid; }
	.tabla_zebra tr:nth-child(even) {background-color: #f2f2f2;}

	.tbl_csd{}
	.tbl_csd th{ text-align:left;}
	.caja1c{ padding:10px; margin-left:20px; }
	.boton1{ padding:10px;width:150px; }
</style>
<form name="frm_csd" action="csd_procesar.php" method="POST" enctype="multipart/form-data">
	<table align="center" border="0" cellpadding="10" cellspacing="0" class="tbl_csd tabla_zebra">
	<tr>
		<th> RFC </th>
		<td> <input type="text" class="caja1c" id="rfc" name="rfc" value="" placeholder="RFC" maxlength="13" required /> </td>
	</tr>	
	<tr>	
		<th> Archivo .CER </th>
		<td> <input type="file" class="caja1c" id="cer" name="cer" accept=".cer" required /> </td>
	</tr>
	<tr>
		<th> Archivo .KEY </th>
		<td> <input type="file" class="caja1c" id="key" name="key" accept=".key" required /> </td>
	</tr>
	<tr>		
		<th> Contrase&ntilde;a </th>
		<td> <input type="password" class="caja1c" id="password" name="password"  value="" maxlength="40" required /> </td>
	</tr>
	<tr>		
		<td colspan="2" align="center"> <input type="submit" class="boton1" id="btn_ma_empresa_documento_guardar1" value=" √   Guardar"/> </td>
	</tr>
	</table>
</form>