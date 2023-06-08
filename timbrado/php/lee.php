<?php



$archi_xml = $_GET[xml];

$ruta_cfdi = "../files/cfdi/".$archi_xml."_timbrado.xml";


$xml = simplexml_load_file($ruta_cfdi); 



$xml = simplexml_load_file( 'https://elreydeltornillo.com/sit/facturacion/timbrado/files/cfdi/T_1012_timbrado.xml', 'SimpleXMLElement', 0, 'cfdi', true );
$ns = $xml->getNamespaces(true);
$xml->registerXPathNamespace('c', $ns['cfdi']);
$xml->registerXPathNamespace('t', $ns['tfd']);
 
 
//EMPIEZO A LEER LA INFORMACION DEL CFDI E IMPRIMIRLA 
foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 

      echo $cfdiComprobante['LugarExpedicion']; 
      echo "<br />"; 
      echo $cfdiComprobante['MetodoPago']; 
      echo "<br />"; 
      echo $cfdiComprobante['TipoDeComprobante']; 
      echo "<br />"; 
      echo $cfdiComprobante['SubTotal']; 
      echo "<br />"; 
      echo $cfdiComprobante['Total']; 
      echo "<br />"; 
      echo $cfdiComprobante['Moneda']; 
      echo "<br />"; 
      echo $cfdiComprobante['NoCertificado']; 
      echo "<br />"; 
      echo $cfdiComprobante['FormaPago']; 
      echo "<br />"; 
      echo $cfdiComprobante['Fecha']; 
      echo "<br />"; 
      echo $cfdiComprobante['Serie']; 
      echo "<br />"; 
      echo $cfdiComprobante['Folio']; 
      echo "<br />"; 
      echo $cfdiComprobante['Version']; 
      echo "<br />"; 

} 
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
   echo $Emisor['Rfc']; 
   echo "<br />"; 
   echo $Emisor['Nombre']; 
   echo "<br />"; 
   echo $Emisor['RegimenFiscal']; 
   echo "<br />"; 
} 


foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
   echo $Receptor['Rfc']; 
   echo "<br />"; 
   echo $Receptor['Nombre']; 
   echo "<br />"; 
   echo $Receptor['UsoCFDI']; 
   echo "<br />"; 
} 

foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto){ 
   echo "<br />"; 
   echo $Concepto['ClaveProdServ']; 
   echo "<br />"; 
   echo $Concepto['NoIdentificacion']; 
   echo "<br />"; 
   echo $Concepto['cantidad']; 
   echo "<br />"; 
   echo $Concepto['descripcion']; 
   echo "<br />"; 
   echo $Concepto['valorUnitario']; 
   echo "<br />";   
   echo "<br />"; 
} 

/*
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado){ 
   echo $Traslado['Base']; 
   echo "<br />"; 
   echo $Traslado['Impuesto']; 
   echo "<br />"; 
   echo $Traslado['TipoFactor']; 
   echo "<br />";   
   echo "<br />"; 
} 

*/
 
//ESTA ULTIMA PARTE ES LA QUE GENERABA EL ERROR
foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
   echo $tfd['SelloCFD']; 
   echo "<br />"; 
   echo $tfd['FechaTimbrado']; 
   echo "<br />"; 
   echo $tfd['UUID']; 
   echo "<br />"; 
   echo $tfd['noCertificadoSAT']; 
   echo "<br />"; 
   echo $tfd['RfcProvCertif']; 
   echo "<br />"; 
   echo $tfd['Version']; 
   echo "<br />"; 
   echo $tfd['SelloSAT']; 
} 
?>