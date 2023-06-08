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
$consulta_invo = mysqli_query($cone,"SELECT * FROM `complementos` where id = '$valo'; ");
$re = mysqli_fetch_array($consulta_invo);

$total_monto = $re[total];

//-------------- Datos del emisor-------------------------------------------------
$emp = $re['emisor'];
$consulta_emp = mysqli_query($cone,"SELECT * FROM `empresas` where id = '$emp'; ");
$re_emp = mysqli_fetch_array($consulta_emp);

$NoCertificado       = $re_emp['no_certificado'];
$RfcEmisor           = $re_emp['rfc'];
$NombreEmisor        = $re_emp['nombre'];
$RegimenFiscal       = "601";
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
$cpReceptor          = $re_clie['cp'];

//-----------------Datos deñ cfdi------------------------------------------------

$UsoCFDI             = $re['uso'];

$Fecha               = $re[fecha_emision]."T".$re[hora];  //2021-08-30T00:57:28
$Serie               = $re[serie];
$Folio               = $re[id];
$LugarExpedicion     = $re['lugar'];
$CondicionesDePago   = $_POST['CondicionesDePago'];
$Moneda              = "XXX";
$TipoDeComprobante   = $re['tipo_cfdi'];
$MetodoDePago        = $re['metodo_pago'];
$FormaDePago         = $re['forma_pago'];
$version="4.0";


//------ total de la factura --->

$factu = $re[id];

$sub  = number_format(saber_total_factura($factu),2, '.', '');
$i_v_a = number_format((saber_total_factura($factu) * 0.16),2, '.', '');
$tot  = number_format((saber_total_factura($factu) * 1.16),2, '.', '');

//_________________________________________

//echo $sub;
//echo $i_v_a;
//echo $tot;

$consulta_detalle = mysqli_query($cone,"SELECT * FROM `detalle_complementos` where idfactura = '$valo'");
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


$w->startAttribute('xmlns:pago20');
$w->text( "http://www.sat.gob.mx/Pagos20" );
$w->endAttribute();


$w->startAttribute('xmlns:cfdi');
$w->text( "http://www.sat.gob.mx/cfd/4" );
$w->endAttribute();

$w->startAttribute('xsi:schemaLocation');
$w->text( "http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd http://www.sat.gob.mx/Pagos20 http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos20.xsd" );
$w->endAttribute();	

$w->writeAttribute('Exportacion',"01"); 
$w->writeAttribute('LugarExpedicion',"44270"); 
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
$w->writeAttribute('DomicilioFiscalReceptor',$cpReceptor); 
$w->writeAttribute('RegimenFiscalReceptor',"601"); 
$w->writeAttribute('UsoCFDI',"CP01"); 
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
$w->writeAttribute('ObjetoImp',"01"); // Cantidad por Valor Unitario

$w->endElement();//Fin de Concepto

$w->endElement();//Conceptos

$w->startElementNS('cfdi','Complemento', null);
  $w->startElementNS('pago20','Pagos', null);
  $w->writeAttribute('Version',"2.0");


  $w->startElementNS('pago20','Totales', null);

  if ($re[tipo_cambio] <> 0){
    $monto=  number_format($re[total] / $re[tipo_cambio],2, '.', '');

    $monto_total =  number_format($re[tipo_cambio] * $monto,2, '.', '');

  }

  if ($re[tipo_cambio] == 0){
    $monto_total =  number_format($re[total],2, '.', '');


  }

   $subtotal = number_format($monto_total / 1.16,2, '.', '');
   $iva_del_total = number_format($monto_total - $subtotal,2, '.', '');

   
   /*
   $iva_del_total  = number_format($monto_total * 0.16,2, '.', '');
   $monto_sin_iva = number_format($monto_total - $iva_del_total,2, '.', '');

   $iva_del_total_  = number_format($monto_total * 0.16,6, '.', '');
   $monto_sin_iva_ = number_format($monto_total - $iva_del_total,6, '.', '');
   */

  $w->writeAttribute('TotalTrasladosBaseIVA16',$subtotal); // Este valor es sin el 16 %
  $w->writeAttribute('TotalTrasladosImpuestoIVA16',$iva_del_total);  // Este valor es el 16 %
  $w->writeAttribute('MontoTotalPagos',$monto_total);

  $w->endElement();//

  $ord =  $re[ordenante];
  $ben =  $re[beneficiario];

 // echo "Aqui".$ord.$ben;


  $consulta_orde = mysqli_query($cone,"SELECT * FROM `cuentas_ordenantes` where id = '$ord';");
  $re_o = mysqli_fetch_array($consulta_orde);

  $consulta_ben = mysqli_query($cone,"SELECT * FROM `cuentas_bancaras` where id = '$ben';");
  $re_b = mysqli_fetch_array($consulta_ben);
  

    $w->startElementNS('pago20','Pago', null);
   // $w->writeAttribute('CtaBeneficiario',$re_b[cuenta]);
   // $w->writeAttribute('CtaOrdenante',$re_o[cuenta]);
    $w->writeAttribute('FechaPago',$re[fecha_pago]."T12:00:00");
    $w->writeAttribute('FormaDePagoP',$FormaDePago);

    if ($re[tipo_cambio] == 0){

      $w->writeAttribute('MonedaP',"MXN");
      $monto = (number_format($re[total],2, '.', ''));
      $w->writeAttribute('Monto',$monto);
	  $bandera = 0;
    
    }else{

      $w->writeAttribute('MonedaP',"USD");
      $w->writeAttribute('TipoCambioP',$re[tipo_cambio]);
      $monto=  number_format($re[total] / $re[tipo_cambio],2, '.', '');
      $w->writeAttribute('Monto',$monto);
	  
	  $monto_usd = $monto;
	  $bandera = 1;

    }


    if ($re[tipo_cambio] == 0){
    $w->writeAttribute('TipoCambioP',"1");  // Para pesos Mexicanos
    }

     $consulta_detalle_comple = mysqli_query($cone,"SELECT * FROM `detalle_complementos` where idorden = '$Folio';");

     while($re_de = mysqli_fetch_array($consulta_detalle_comple)){

           

    // Aqui se tiene que repetir

    $w->startElementNS('pago20','DoctoRelacionado', null);
    $w->writeAttribute('IdDocumento',$re_de[uuid]);
    $w->writeAttribute('Serie',$re_de[serie]);
    $w->writeAttribute('Folio',$re_de[folio]);
    $w->writeAttribute('MonedaDR',"MXN");
    //$w->writeAttribute('MetodoDePagoDR',$re_de[metodopago]);
    $w->writeAttribute('NumParcialidad',$re_de[parcialidad]);
    $w->writeAttribute('ImpSaldoAnt',number_format($re_de[saldo],2, '.', ''));
    //$w->writeAttribute('ImpSaldoAnt',$re_de[saldo]);
    $w->writeAttribute('ImpPagado',number_format($re_de[importe],2, '.', ''));
	  $insoluto = $re_de[saldo] - $re_de[importe];
	
    $w->writeAttribute('ImpSaldoInsoluto',number_format($insoluto,2, '.', ''));
    $w->writeAttribute('ObjetoImpDR',"02");

     if ( $re[tipo_cambio] == 0) {

      $equi = 1;


     }else{

       $equi = $re[tipo_cambio];

     }

    $w->writeAttribute('EquivalenciaDR',$equi); //

    // Calculos del Producto

    /*
    $iva_importe = $re_de[importe] * 0.16;
    $importe_pagado = number_format($re_de[importe],6, '.', '') - number_format($iva_importe,2, '.', '');
    $iva_importe_pagado = number_format($iva_importe,6, '.', '');
    */

    $importe_pagado = number_format($re_de[importe] / 1.16,6, '.', '');

    $iva_importe_pagado =  number_format($re_de[importe] - $importe_pagado,6, '.', '');

    // Aqui un nodo
    $w->startElementNS('pago20','ImpuestosDR', null);
      $w->startElementNS('pago20','TrasladosDR', null);
      $w->startElementNS('pago20','TrasladoDR', null);
        
      $w->writeAttribute('BaseDR',$importe_pagado);
      $w->writeAttribute('ImpuestoDR',"002");
      $w->writeAttribute('TipoFactorDR',"Tasa");
      $w->writeAttribute('TasaOCuotaDR',"0.160000");
      $w->writeAttribute('ImporteDR',$iva_importe_pagado);

      
      $w->endElement();//Fin de TrasladoDR
      $w->endElement();//Fin de TrasladosDR
    $w->endElement();//Fin de ImpuestosDR

    $w->endElement();//Fin de pago20 DoctoRelacionado

     }


     $w->startElementNS('pago20','ImpuestosP', null);
     $w->startElementNS('pago20','TrasladosP', null);
     $w->startElementNS('pago20','TrasladoP', null);
	 
	 
	 if ($bandera == 1){
		 
		 $subtotal = number_format($monto_usd / 1.16,2, '.', '');
		 $iva_del_total = number_format($monto_usd - $subtotal,2, '.', '');
		 	 
		 
	 }
       
     $w->writeAttribute('BaseP',$subtotal);
     $w->writeAttribute('ImpuestoP',"002");
     $w->writeAttribute('TipoFactorP',"Tasa");
     $w->writeAttribute('TasaOCuotaP',"0.160000");
     $w->writeAttribute('ImporteP',$iva_del_total);

     
     $w->endElement();//Fin de TrasladoP
     $w->endElement();//Fin de TrasladosP
   $w->endElement();//Fin de ImpuestosP



  $w->endElement();//Fin de pago20 Pago
$w->endElement();//Fin de pago20 Pagos

$w->endElement();//Fin de Cfdi Complemento

$w->endElement();//Comprobante

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

echo "Se ha creado correctamente el XML";
echo '<a href="https://www.elreydeltornillo.com/sit/facturacion/timbrado/files/xml/'.$arch.'">Ver XML</a>';

echo "<br>";


echo '<a href="xml_timbrar_comple.php?xml='.$arch.'"><img src="https://img.icons8.com/pastel-glyph/64/000000/create-new--v2.png"/> Timbrar </a>';



?>


    </td>
  </tr>
</table>
    

    <p>
  <?php

    
     }

?>
      
      
      
  <!-- https://elreydeltornillo.com/sit/facturacion/timbrado/php/xml_timbrar.php -->
      
      
      
  <?php
 //echo "<script language='javascript'>window.parent.location='xml_timbrar.php?xml='.$arch.'</script>";

?>
      
      
      
      
      
      
    </p>


<table width="200" border="1" align="center">
  <tr>
    <td><iframe id="inlineFrameExample"
    title="Inline Frame Example"
    width="1000"
    height="1800"
    src="https://www.elreydeltornillo.com/sit/facturacion/pdfdom/crearPdf_comple.php?idorden=<?php echo $valo; ?>"> </iframe></td>
  </tr>
</table>



    