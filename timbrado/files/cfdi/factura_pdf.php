<?php
require('fpdf.php');

$cad = explode("_",$_GET[cve]);


class PDF extends FPDF
{

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Creación del objeto de la clase heredada


include("conecta_facturacion.php");


$valo = $cad[1];
$consulta_invo = mysqli_query($cone,"SELECT * FROM `invoices` where id = '$valo'; ");
$re = mysqli_fetch_array($consulta_invo);

//
$emi = $re[emisor];
$consulta_emp = mysqli_query($cone,"SELECT * FROM `empresas` where id = '$emi'; ");
$re_emp = mysqli_fetch_array($consulta_emp);

//
$rece = $re[receptor];
$consulta_rece = mysqli_query($cone,"SELECT * FROM `clientes` where id_cliente= '$rece'; ");
$re_cep = mysqli_fetch_array($consulta_rece);


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->Image('logo.png',10,8,33);
$pdf->SetFont('Arial','',10);
$pdf->Cell(-80);
$pdf->Cell(0,10,"Serie y Folio: ".$re['serie']." ".$re['id'],0,0,'C');
$pdf->Cell(-190);
$pdf->Cell(0,10,"Tipo de CFDI: ".$re['tipo_cfdi'],0,0,'C');
$pdf->Cell(-80);
$pdf->Cell(0,10,"Fecha de Emision: ".$re[fecha_emision],0,0,'C');
$pdf->Cell(-268);
$pdf->Cell(0,23,"Tipo de Moneda: ".$re[moneda],0,0,'C');
$pdf->Cell(-86);
$pdf->Cell(0,23,"Hora de Emision: ".$re['hora'],0,0,'C');
$pdf->Cell(-235);
$pdf->Cell(0,35,"No de Certificado: ".$re_emp[no_certificado],0,0,'C');




$pdf->Cell(-192);
$pdf->Cell(0,40,'_________________________________________________________________________________________________');

$pdf->Cell(-192);
$pdf->Cell(0,60,'Emisor: '.$re_emp[rfc]);
$pdf->Cell(-192);
$pdf->Cell(0,70,'Nombre del Emisor: '.$re_emp[nombre]);
$pdf->Cell(-192);
$pdf->Cell(0,80,'Direccion del Emisor: '.$re_emp[direccion]);
$pdf->Cell(-192);
$pdf->Cell(0,90,'Telefono: '.$re_emp[telefono]);
$pdf->Cell(-192);
$pdf->Cell(0,100,'Lugar de Expedicion: '.$re[lugar]);
$pdf->Cell(-192);
$pdf->Cell(0,110,'Regimen Fiscal: '.$re_emp[regimen_fiscal]);


$pdf->Cell(-95);
$pdf->Cell(0,60,'Receptor: '.$re_cep[rfc]);
$pdf->Cell(-95);
$pdf->Cell(0,70,'Nombre del Receptor '.$re_cep[nombre_cliente]);
$pdf->Cell(-95);
$pdf->Cell(0,80,'Direccion del Emisor '.$re_cep[direccion_cliente]);
$pdf->Cell(-95);
$pdf->Cell(0,90,'Telefono: '.$re_cep[telefono_cliente]);





$pdf->Cell(-192);
$pdf->Cell(0,115,'_________________________________________________________________________________________________');

$pdf->Cell(-192);
$pdf->Cell(0,127,'Forma de Pago: '.$re[forma_pago]);

$pdf->Cell(-130);
$pdf->Cell(0,127,'Metodo de Pago: '.$re[metodo_pago]);

$pdf->Cell(-50);
$pdf->Cell(0,127,'Uso: '.$re[uso]);


$pdf->Cell(-192);
$pdf->Cell(0,130,'_________________________________________________________________________________________________');


//for($i=1;$i<=100;$i++)
//$pdf->Cell(0,10,'Imprimiendo línea número '.$i,0,1);

$pdf->Cell(-192);
$pdf->Cell(0,200,'_________________________________________________________________________________________________');



$pdf->SetFont('Arial','',7);
$pdf->SetXY(-203,115);
$pdf->MultiCell(195,3,$re[sello_cfdi],'0','J'); // hasta donde abarca, interlineado


$pdf->SetFont('Arial','',7);
$pdf->SetXY(-203,125);
$pdf->MultiCell(150,3,$re[cadena],'0','J'); // hasta donde abarca, interlineado


$pdf->SetFont('Arial','',7);
$pdf->SetXY(-203,145);
$pdf->MultiCell(150,3,$re[sello_sat],'0','J'); // hasta donde abarca, interlineado


$imagen_qr = $_GET[cve]."_QR.jpg";

$pdf->Image($imagen_qr,160,127,33);

$pdf->Cell(-192);
$pdf->Cell(0,10,'_________________________________________________________________________________________________');



$pdf->Output();
?>