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

//echo "emisor". $_SESSION[emisor];


//------------Datos del receptor---------------------------------------------------
$clie = $re['receptor'];
//echo "aqu".$clie;
$consulta_clie = mysqli_query($cone,"SELECT * FROM `clientes` where id_cliente = '$clie'; ");
$re_clie = mysqli_fetch_array($consulta_clie);

$NombreReceptor      = utf8_encode($re_clie['nombre_cliente']);
$RfcReceptor         = $re_clie['rfc'];

$DomicilioFiscalReceptor  = $re_clie[cp];
$RegimenFiscalReceptor    = "601";

//-----------------Datos deñ cfdi------------------------------------------------

//UsoCFDI             = $re['uso'];  /*    */

$UsoCFDI             = $re['uso'];   

$Fecha               = $re[fecha_emision]."T".$re[hora];  //2021-08-30T00:57:28
$Serie               = $re[serie];
$Folio               = $re[id];
$LugarExpedicion     = "56260";
$CondicionesDePago   = $_POST['CondicionesDePago'];
$Moneda              = $re['moneda'];;
$TipoDeComprobante   = $re['tipo_cfdi'];
$MetodoDePago        = $re['metodo_pago'];
$FormaDePago         = $re['forma_pago'];
$version             = "4.0";
$_SESSION[version] =   "4.0";
$uuid_rel            = $re['relacionado'];
$tip                 = $re['tiporelacionado'];
$tipoc               = $re['tipocambio'];


//------ total de la factura --->

$factu = $re[id];

$sub  = number_format(saber_total_factura($factu),2, '.', '');
$i_v_a = number_format((saber_total_factura($factu) * 0.16),3, '.', '');
$suma_total = $sub+$i_v_a;
$tot  = number_format($suma_total,2, '.', '');


//$tot  = number_format((saber_total_factura($factu) * 1.16),2, '.', '');

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
$w->text( "http://www.sat.gob.mx/cfd/4" );
$w->endAttribute();

$w->startAttribute('xsi:schemaLocation');
$w->text( "http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd" );
$w->endAttribute();	

$w->writeAttribute('Exportacion',"01"); 
$w->writeAttribute('LugarExpedicion',$LugarExpedicion); 
$w->writeAttribute('MetodoPago',$MetodoDePago);
$w->writeAttribute('TipoDeComprobante',$TipoDeComprobante);  
$w->writeAttribute('SubTotal',$sub); // Subtotal de la Factura
$w->writeAttribute('Total',$tot); // Total ya con IVA del 16 %
$w->writeAttribute('Moneda',$Moneda); 
$w->writeAttribute('TipoCambio',$tipoc); 
$w->writeAttribute('Certificado',$Certificado);
$w->writeAttribute('NoCertificado',$NoCertificado);
$w->writeAttribute('FormaPago',$FormaDePago); 
$w->writeAttribute('Fecha',$Fecha); 
$w->writeAttribute('Serie',$Serie); 
$w->writeAttribute('Folio',$Folio); 
$w->writeAttribute('Version',$version);


// Si existe el Id relacionado adelante

if ($uuid_rel == ''){}
else{

$w->startElementNS('cfdi','CfdiRelacionados', null);
$w->writeAttribute('TipoRelacion',$tip); 

    $w->startElementNS('cfdi','CfdiRelacionado', null);
    $w->writeAttribute('UUID',$uuid_rel); 
    $w->endElement();//Tipo de Relacion

$w->endElement();//Cfdi Relacionados

}




$w->startElementNS('cfdi','Emisor', null);
$w->writeAttribute('Rfc',$RfcEmisor); 
$w->writeAttribute('Nombre',$NombreEmisor); 
$w->writeAttribute('RegimenFiscal',$RegimenFiscal); 
$w->endElement();//Emisor



$w->startElementNS('cfdi','Receptor', null);
$w->writeAttribute('Rfc',$RfcReceptor); 
$w->writeAttribute('Nombre',$NombreReceptor); 
//DomicilioFiscalReceptor
$w->writeAttribute('DomicilioFiscalReceptor',$DomicilioFiscalReceptor); 
//RegimenFiscalReceptor="616"
$w->writeAttribute('RegimenFiscalReceptor',$RegimenFiscalReceptor); 

$w->writeAttribute('UsoCFDI',$UsoCFDI); 
$w->endElement();//Receptor

$w->startElementNS('cfdi','Conceptos', null);

// consulta detalle de la factura



while($re_detalle = mysqli_fetch_array($consulta_detalle)){

  $impo =number_format($re_detalle[monto] * $re_detalle[cantidad],2, '.', '');
  $iva = number_format(($impo * 0.16),3, '.', '');



$w->startElementNS('cfdi','Concepto', null);
$w->writeAttribute('ClaveProdServ',trim($re_detalle[codigo_sat])); // Clave del Sat
$w->writeAttribute('NoIdentificacion',$re_detalle[c_producto]); // Clave Interno
$w->writeAttribute('Cantidad',$re_detalle[cantidad]); // Cantidad con 4 ceros
$w->writeAttribute('ClaveUnidad','H87'); // Clave unidad del Sat
$w->writeAttribute('Unidad',$re_detalle[unidad_sat]); // Unidad del SAT
$w->writeAttribute('Descripcion',$re_detalle[descripcion]); // Descripcion del Producto
//ObjetoImp="02"
$w->writeAttribute('ObjetoImp','02'); // Descripcion del Producto
$w->writeAttribute('ValorUnitario',$re_detalle[monto]); // Valor unitario del Producto
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


if ($_SESSION[tipo] == 'anticipo' or $re[pedimento] == ''){

  // Si es anticipo no pongas nada
}else{

$w->startElementNS('cfdi','InformacionAduanera', null);
$pedi = acomoda_pedimento($re[pedimento]);
$w->writeAttribute('NumeroPedimento',$pedi);  // Aqui va el pedimento
$w->endElement();
}


$w->endElement();


}


$w->endElement();//Conceptos


$w->startElementNS('cfdi','Impuestos', null);
$w->writeAttribute('TotalImpuestosTrasladados',number_format($i_v_a,2,'.','')); // Suma de Impuesto

$w->startElementNS('cfdi','Traslados', null);
$w->startElementNS('cfdi','Traslado', null);
$w->writeAttribute('Base',$sub); // FIJO$
$w->writeAttribute('TipoFactor','Tasa'); // FIJO
$w->writeAttribute('TasaOCuota','0.160000'); // FIJO
$w->writeAttribute('Importe',number_format($i_v_a,2,'.','')); // Suma de Impuesto
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
    
    <table width="100%" border="0">
  <tr>
    <td align="center">

    <?php

    echo '<img src="https://img.icons8.com/color/48/000000/edit--v3.png"/>';

echo "Se ha creado correctamente ";
echo '<a href="https://elreydeltornillo.com/sit/facturacion/timbrado/files/xml/'.$arch.'">Ver XML</a>';

echo '<a href="xml_timbrar.php?xml='.$arch.'"><img src="https://img.icons8.com/windows/68/null/paid-bill.png"/> Timbrar </a>';



?>


    </td>
  </tr>
</table>
    <table width="100%" border="0">
  <tr>
    <td width="60%" align="center"><p>&nbsp;</p>
    <p>&nbsp;</p></td>
    <td width="40%" align="left"><?php

    
     }

?>
      <!-- https://elreydeltornillo.com/sit/facturacion/timbrado/php/xml_timbrar.php -->
    <?php
 //echo "<script language='javascript'>window.parent.location='xml_timbrar.php?xml='.$arch.'</script>";

?></td>
  </tr>
  <tr>
    <td align="center"><a href="https://elreydeltornillo.com/sit/facturacion/detalle_invoices.php?idorden=<?php echo $valo; ?>&serie=<?php echo $valo; ?>"><img src="https://img.icons8.com/ios-filled/50/null/high-risk.png"/>No esta correcta, regresar </a></td>
    <td align="left"></td>
  </tr>
    </table>
<table width="200" border="1" align="center">
  <tr>

    <td><iframe id="inlineFrameExample"
    title="Inline Frame Example"
    width="1000"
    height="1800"
    src="https://elreydeltornillo.com/sit/facturacion/pdfdom/crearPdf.php?idorden=<?php echo $valo; ?>"> </iframe></td>
  </tr>
</table>
<p>&nbsp;</p>
    