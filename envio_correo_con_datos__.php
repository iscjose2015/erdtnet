<?php		
include("conecta.php");

  $fact      = $_POST['idorden'];
  $addresses = $_POST['to'];

  // Import PHPMailer classes into the global namespace
  // These must be at the top of your script, not inside a function
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  use PHPMailer\PHPMailer\SMTP;
  
  require 'PHPMailer/src/Exception.php';
  require 'PHPMailer/src/PHPMailer.php';
  require 'PHPMailer/src/SMTP.php';		

try{
  $mail = new PHPMailer();
  $mail->IsSMTP();
                       
  //Configuracion servidor mail
  $mail->From = "noreply@elreydeltornillo.com"; //remitente
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = 'tls'; //seguridad
  $mail->Host = "smtp.office365.com"; // servidor smtp
  $mail->Port = 587; //puerto
  $mail->Username ='noreply@elreydeltornillo.com'; //nombre usuario
  $mail->Password = 'N0R3pLy.2019'; //contraseña
  
  $mensaje = 'Envio de Factura automatica '.$fact;
  $mail->setFrom('noreply@elreydeltornillo.com', $mensaje);
  
  foreach($addresses as $email){ //Agregar destinatarios
    $mail->AddAddress();
    $mail->AddAddress("$email");
  }
					  
  $mail->isHTML(true);  
  $path = 'sit/facturacion/timbrado/files/cfdi/T_'.$fact.'_timbrado.xml';
  $mail->AddAttachment($path); //Adds an attachment from a path on the filesystem       
  $path = 'sit/facturacion/timbrado/files/cfdi/T_'.$fact.'_timbrado.xml';
  $mail->AddAttachment($path2); //Adds an attachment from a path on the filesystem
  $mail->Subject = "'Envio de Factura'";
  $mail->Body = '<html>'.
    '<head><title>El rey del Tornillo</title></head>'.
    '<body>
      <table width="100%" height="96" border="0">
        <tr>
          <td height="21" align="center"><p>&nbsp;</p></td>
        </tr>
        <tr>
          <td height="69" align="center"><table width="31%" class="table table-striped table-hover">
        <thead class="thead-green">
        <tr>
          <th width="62%">Envio de Factura  </th>
        </tr>
        </thead>
        <tbody>
          <tr>
            <td align="center"><a href="https://elreydeltornillo.com/sit/facturacion/pdfdom/crearPdf.php?idorden='.$fact.'">Descarga aqui la Factura en PDF</a></td>
          </tr>
        </tbody>
      </table>
      </td>
    </tr>
    </table>'.
  '</body>'.
'</html>';
                       
  if ($mail->Send()) { 
    echo "correcto"; 
    echo "<script language='javascript'>window.parent.location='https://elreydeltornillo.com/sit/facturacion/detalle_invoices.php?idorden=$fact&serie=$fact'</script>";  
  } else {  echo "No se envio";  } 
                    
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

