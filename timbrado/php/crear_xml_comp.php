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

$sub  = number_format(saber_total_factura($factu),2, '.', '');
$i_v_a = number_format((saber_total_factura($factu) * 0.16),2, '.', '');
$tot  = number_format((saber_total_factura($factu) * 1.16),2, '.', '');

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

$w->startAttribute('xmlns:pagos10');
$w->text( "http://www.sat.gob.mx/Pagos" );
$w->endAttribute();

$w->startAttribute('xmlns:xsi');
$w->text( "http://www.w3.org/2001/XMLSchema-instance" );
$w->endAttribute();

$w->startAttribute('xmlns:cfdi');
$w->text( "http://www.sat.gob.mx/cfd/3" );
$w->endAttribute();

$w->startAttribute('xsi:schemaLocation');
$w->text( "http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd http://www.sat.gob.mx/Pagos http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos10.xsd" );
$w->endAttribute();	

$w->writeAttribute('LugarExpedicion',$LugarExpedicion); 
$w->writeAttribute('TipoDeComprobante',"P");  
$w->writeAttribute('SubTotal',"0"); // Subtotal de la Factura
$w->writeAttribute('Total',"0"); // Total ya con IVA del 16 %
$w->writeAttribute('Moneda',$Moneda); 
$w->writeAttribute('Certificado',$Certificado);
$w->writeAttribute('NoCertificado',$NoCertificado);
$w->writeAttribute('Fecha',$Fecha); 
$w->writeAttribute('Serie',$Serie); 
$w->writeAttribute('Folio',$Folio); 
$w->writeAttribute('Version',$version);


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

    $w->startElementNS('cfdi','Concepto', null);
    $w->writeAttribute('ClaveProdServ',"84111506"); // Clave del Sat
    $w->writeAttribute('Cantidad',"1"); // Cantidad con 4 ceros
    $w->writeAttribute('ClaveUnidad','ACT'); // Clave unidad del Sat
    $w->writeAttribute('Descripcion',"Pago"); // Descripcion del Producto
    $w->writeAttribute('ValorUnitario',"0"); // Valor unitario del Producto
    $w->writeAttribute('Importe',"0"); // Cantidad por Valor Unitario
    $w->endElement(); // Fin del concepto

$w->endElement();//Conceptos


$w->startElementNS('cfdi','Complemento', null);
$w->writeAttribute('Version 1.0');  



$w->endElement();//Conceptos



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






