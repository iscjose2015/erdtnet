  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<?php session_start();
date_default_timezone_set('America/Mexico_City');


error_reporting(0);

include("../../head.php");
include("../../conecta_facturacion.php");
include("../../funciones_factura.php");

//------------- Recibimos el valor de la factura
$valo = $_GET[cve];
$consulta_invo = mysqli_query($cone,"SELECT * FROM `invoices` where id = '$valo'; ");
$re = mysqli_fetch_array($consulta_invo);


   

//-------------- Datos del emisor-------------------------------------------------
$emp = $re['emisor'];
$consulta_emp = mysqli_query($cone,"SELECT * FROM `empresas` where id = '$emp'; ");
$re_emp = mysqli_fetch_array($consulta_emp);

$NoCertificado       = $re_emp['no_certificado'];
$RfcEmisor           = $re_emp['rfc'];
$NombreEmisor        = $re_emp['nombre'];
$RegimenFiscal       = $re_emp['regimen_fiscal'];
$Certificado         = $re_emp['certificado'];

$_SESSION[emisor] = $RfcEmisor ;

echo "emisor". $_SESSION[emisor];


//------------Datos del receptor---------------------------------------------------
$clie = $re['receptor'];
//echo "aqu".$clie;
$consulta_clie = mysqli_query($cone,"SELECT * FROM `clientes` where id_cliente = '$clie'; ");
$re_clie = mysqli_fetch_array($consulta_clie);

$NombreReceptor      = utf8_encode($re_clie['nombre_cliente']);
$RfcReceptor         = $re_clie['rfc'];

//-----------------Datos deñ cfdi------------------------------------------------

$UsoCFDI             = $re['uso'];

$Fecha               = $re[fecha_emision]."T".$re[hora];  //2021-08-30T00:57:28
$Serie               = $re[serie];
$Folio               = $re[id];
$LugarExpedicion     = $re['lugar'];
$CondicionesDePago   = $_POST['CondicionesDePago'];
$Moneda              = $re['moneda'];;
$TipoDeComprobante   = $re['tipo_cfdi'];
$MetodoDePago        = $re['metodo_pago'];
$FormaDePago         = $re['forma_pago'];
$version="3.3";


//------ total de la factura --->

$factu = $re[id];

$sub  = number_format(saber_total_factura($factu),2);
$i_v_a = number_format((saber_total_factura($factu) * 0.16),2);
$tot  = number_format((saber_total_factura($factu) * 1.16),2) ;

//_________________________________________

//echo $sub;
//echo $i_v_a;
//echo $tot;

$consulta_detalle = mysqli_query($cone,"SELECT * FROM `detalle_invoices`where idfactura = '$valo'");
echo mysqli_num_rows($consulta_detalle);

//----Crer el XML con la ruta----------------
//../files/xml/test.xml
$arch = $Serie."_".$Folio.".xml";
$ruta = "../files/xml/".$arch;

//echo $ruta;

$w = new XMLWriter;
$w->openMemory();
$w->openURI($ruta);
$w->setIndent(true);

$w->startDocument('1.0','utf-8');

$w->startElementNS('cfdi', 'Comprobante', null);//Comprobante

$w->startAttribute('xmlns:xsi');
$w->text( "http://www.w3.org/2001/XMLSchema-instance" );
$w->endAttribute();

$w->startAttribute('xmlns:cfdi');
$w->text( "http://www.sat.gob.mx/cfd/3" );
$w->endAttribute();

$w->startAttribute('xsi:schemaLocation');
$w->text( "http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd" );
$w->endAttribute();	

$w->writeAttribute('LugarExpedicion',$LugarExpedicion); 
$w->writeAttribute('MetodoPago',$MetodoDePago);
$w->writeAttribute('TipoDeComprobante',$TipoDeComprobante);  
$w->writeAttribute('SubTotal',$sub); // Subtotal de la Factura
$w->writeAttribute('Total',$tot); // Total ya con IVA del 16 %
$w->writeAttribute('Moneda',$Moneda); 
$w->writeAttribute('Certificado',$Certificado);
$w->writeAttribute('NoCertificado',$NoCertificado);
$w->writeAttribute('FormaPago',$FormaDePago); 
$w->writeAttribute('Fecha',$Fecha); 
$w->writeAttribute('Serie',$Serie); 
$w->writeAttribute('Folio',$Folio); 
$w->writeAttribute('Version',$version);


//$w->writeAttribute('NoCertificado',trim($NoCertificado));
//$w->writeAttribute('Certificado',preg_replace ("[\n|\r|\n\r]",'',$Certificado));

$w->startElementNS('cfdi','Emisor', null);
$w->writeAttribute('Rfc',$RfcEmisor); 
$w->writeAttribute('Nombre',$NombreEmisor); 
$w->writeAttribute('RegimenFiscal',$RegimenFiscal); 
$w->endElement();//Emisor



$w->startElementNS('cfdi','Receptor', null);
$w->writeAttribute('Rfc',$RfcReceptor); 
$w->writeAttribute('Nombre',$NombreReceptor); 
$w->writeAttribute('UsoCFDI',$UsoCFDI); 
$w->endElement();//Receptor

$w->startElementNS('cfdi','Conceptos', null);

// consulta detalle de la factura



while($re_detalle = mysqli_fetch_array($consulta_detalle)){

  $impo =number_format($re_detalle[importe] * $re_detalle[cantidad],2);
  $iva = number_format(($impo * 0.16),2);



$w->startElementNS('cfdi','Concepto', null);
$w->writeAttribute('ClaveProdServ',$re_detalle[codigo_sat]); // Clave del Sat
$w->writeAttribute('NoIdentificacion',$re_detalle[c_producto]); // Clave Interno
$w->writeAttribute('Cantidad',$re_detalle[cantidad]); // Cantidad con 4 ceros
$w->writeAttribute('ClaveUnidad','H87'); // Clave unidad del Sat
$w->writeAttribute('Unidad',$re_detalle[unidad_sat]); // Unidad del SAT
$w->writeAttribute('Descripcion',$re_detalle[descripcion]); // Descripcion del Producto
$w->writeAttribute('ValorUnitario',$re_detalle[importe]); // Valor unitario del Producto
$w->writeAttribute('Importe',$impo); // Cantidad por Valor Unitario

$w->startElementNS('cfdi','Impuestos', null);
$w->startElementNS('cfdi','Traslados', null);
$w->startElementNS('cfdi','Traslado', null);
$w->writeAttribute('Base',$impo); // Base a Calcular el impuesto
$w->writeAttribute('Impuesto','002'); // Tipo de Impuesto  FIJO
$w->writeAttribute('TipoFactor','Tasa');  // Tipo de Factor FIJO
$w->writeAttribute('TasaOCuota','0.160000'); // Tipo Fijo
$w->writeAttribute('Importe',$iva); // El valor del impuesto
$w->endElement();
$w->endElement();
$w->endElement();


$w->startElementNS('cfdi','InformacionAduanera', null);
$w->writeAttribute('NumeroPedimento',"21  16  1774  1000299");  // Aqui va el pedimento
$w->endElement();


$w->endElement();


}


/*
$w->startElementNS('cfdi','Concepto', null);
$w->writeAttribute('ClaveProdServ',"48101505");
$w->writeAttribute('NoIdentificacion','ELT0006');
$w->writeAttribute('Cantidad','1.0000');
$w->writeAttribute('ClaveUnidad','H87');
$w->writeAttribute('Unidad','PIEZA');
$w->writeAttribute('Descripcion','Cafetera Beach 40715');
$w->writeAttribute('ValorUnitario','1000.0000');
$w->writeAttribute('Importe','1000.00');

$w->startElementNS('cfdi','Impuestos', null);
$w->startElementNS('cfdi','Traslados', null);
$w->startElementNS('cfdi','Traslado', null);
$w->writeAttribute('Base','1000.00'); //
$w->writeAttribute('Impuesto','002');
$w->writeAttribute('TipoFactor','Tasa');
$w->writeAttribute('TasaOCuota','0.160000');
$w->writeAttribute('Importe','160.00');
$w->endElement();
$w->endElement();
$w->endElement();
$w->endElement();
*/



$w->endElement();//Conceptos

$w->startElementNS('cfdi','Impuestos', null);
$w->writeAttribute('TotalImpuestosTrasladados',$i_v_a); // Suma de Impuesto

$w->startElementNS('cfdi','Traslados', null);
$w->startElementNS('cfdi','Traslado', null);
$w->writeAttribute('TipoFactor','Tasa'); // FIJO
$w->writeAttribute('TasaOCuota','0.160000'); // FIJO
$w->writeAttribute('Importe',$i_v_a); // Suma de Impuesto
$w->writeAttribute('Impuesto','002'); // FIJO
$w->endElement();
$w->endElement();
$w->endElement();

$w->endElement();//Comprobante

$w->endDocument();


 $w->outputMemory();
 $w->formatOutput = true;

/*||||||||||||||||||||||||||||||||||||||||||||||*/

$resultado = $w->formatOutput;


if($resultado == 1){ 


    ?>
    
    <p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
  


<table width="100%" border="0">
  <tr>
    <td align="center">

    <?php

    echo '<img src="https://img.icons8.com/color/48/000000/edit--v3.png"/>';

echo "Se ha creado correctamente el XML";
echo '<a href="https://elreydeltornillo.com/sit/facturacion/timbrado/files/xml/'.$arch.'">Ver XML</a>';

echo "<br>";


echo '<a href="xml_timbrar.php?xml='.$arch.'"><img src="https://img.icons8.com/pastel-glyph/64/000000/create-new--v2.png"/> Timbrar </a>';



?>


    </td>
  </tr>
</table>
    

<?php

    
     }

?>



<!-- https://elreydeltornillo.com/sit/facturacion/timbrado/php/xml_timbrar.php -->



<?php
 //echo "<script language='javascript'>window.parent.location='xml_timbrar.php?xml='.$arch.'</script>";

?>






