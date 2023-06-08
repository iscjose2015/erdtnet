<?php


echo "Hola"; 


$xml = simplexml_load_file("A_166.xml"); 
$ns = $xml->getNamespaces(true);
$xml->registerXPathNamespace('c', $ns['cfdi']);
$xml->registerXPathNamespace('t', $ns['tfd']);
 
 
//EMPIEZO A LEER LA INFORMACION DEL CFDI E IMPRIMIRLA 
foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
      echo $cfdiComprobante['version']; 
      echo "<br />"; 
      echo $cfdiComprobante['fecha']; 
      echo "<br />"; 
      echo $cfdiComprobante['sello']; 
      echo "<br />"; 
      echo $cfdiComprobante['total']; 
      echo "<br />"; 
      echo $cfdiComprobante['subTotal']; 
      echo "<br />"; 
      echo $cfdiComprobante['certificado']; 
      echo "<br />"; 
      echo $cfdiComprobante['formaDePago']; 
      echo "<br />"; 
      echo $cfdiComprobante['noCertificado']; 
      echo "<br />"; 
      echo $cfdiComprobante['tipoDeComprobante']; 
      echo "<br />"; 
} 
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
   echo $Emisor['rfc']; 
   echo "<br />"; 
   echo $Emisor['nombre']; 
   echo "<br />"; 
} 
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor//cfdi:DomicilioFiscal') as $DomicilioFiscal){ 
   echo $DomicilioFiscal['pais']; 
   echo "<br />"; 
   echo $DomicilioFiscal['calle']; 
   echo "<br />"; 
   echo $DomicilioFiscal['estado']; 
   echo "<br />"; 
   echo $DomicilioFiscal['colonia']; 
   echo "<br />"; 
   echo $DomicilioFiscal['municipio']; 
   echo "<br />"; 
   echo $DomicilioFiscal['noExterior']; 
   echo "<br />"; 
   echo $DomicilioFiscal['codigoPostal']; 
   echo "<br />"; 
} 
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor//cfdi:ExpedidoEn') as $ExpedidoEn){ 
   echo $ExpedidoEn['pais']; 
   echo "<br />"; 
   echo $ExpedidoEn['calle']; 
   echo "<br />"; 
   echo $ExpedidoEn['estado']; 
   echo "<br />"; 
   echo $ExpedidoEn['colonia']; 
   echo "<br />"; 
   echo $ExpedidoEn['noExterior']; 
   echo "<br />"; 
   echo $ExpedidoEn['codigoPostal']; 
   echo "<br />"; 
} 
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
   echo $Receptor['rfc']; 
   echo "<br />"; 
   echo $Receptor['nombre']; 
   echo "<br />"; 
} 
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor//cfdi:Domicilio') as $ReceptorDomicilio){ 
   echo $ReceptorDomicilio['pais']; 
   echo "<br />"; 
   echo $ReceptorDomicilio['calle']; 
   echo "<br />"; 
   echo $ReceptorDomicilio['estado']; 
   echo "<br />"; 
   echo $ReceptorDomicilio['colonia']; 
   echo "<br />"; 
   echo $ReceptorDomicilio['municipio']; 
   echo "<br />"; 
   echo $ReceptorDomicilio['noExterior']; 
   echo "<br />"; 
   echo $ReceptorDomicilio['noInterior']; 
   echo "<br />"; 
   echo $ReceptorDomicilio['codigoPostal']; 
   echo "<br />"; 
} 
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto){ 
   echo "<br />"; 
   echo $Concepto['unidad']; 
   echo "<br />"; 
   echo $Concepto['importe']; 
   echo "<br />"; 
   echo $Concepto['cantidad']; 
   echo "<br />"; 
   echo $Concepto['descripcion']; 
   echo "<br />"; 
   echo $Concepto['valorUnitario']; 
   echo "<br />";   
   echo "<br />"; 
} 
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado){ 
   echo $Traslado['tasa']; 
   echo "<br />"; 
   echo $Traslado['importe']; 
   echo "<br />"; 
   echo $Traslado['impuesto']; 
   echo "<br />";   
   echo "<br />"; 
} 
 
//ESTA ULTIMA PARTE ES LA QUE GENERABA EL ERROR
foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
   echo $tfd['selloCFD']; 
   echo "<br />"; 
   echo $tfd['FechaTimbrado']; 
   echo "<br />"; 
   echo $tfd['UUID']; 
   echo "<br />"; 
   echo $tfd['noCertificadoSAT']; 
   echo "<br />"; 
   echo $tfd['version']; 
   echo "<br />"; 
   echo $tfd['selloSAT']; 
} 
?>