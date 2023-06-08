<?php		
		include("conecta.php");
		


  		error_reporting(0);
		// Import PHPMailer classes into the global namespace
		// These must be at the top of your script, not inside a function
		use PHPMailer\PHPMailer\PHPMailer;
		use PHPMailer\PHPMailer\Exception;
		use PHPMailer\PHPMailer\SMTP;
		
		require 'PHPMailer/src/Exception.php';
		require 'PHPMailer/src/PHPMailer.php';
		require 'PHPMailer/src/SMTP.php';
	
	
	

// Load Composer's autoloader
// require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
	$mail->SMTPDebug = 0;                      // Enable verbose debug output
	//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtpout.secureserver.net';             // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'quejas@elreydeltornillo.com';          // SMTP username
    $mail->Password   = 'N0R3pLy.2019';                          // SMTP password
//    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         	// Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	$mail->Port       = 465;                                    // TCP port to connect to, use 465 for `						PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('noreply@elreydeltornillo.com', 'Queja / Sugerencia de la pagina');
    $mail->addAddress('jjrodriguez@elreydeltornillo.com', 'Julian Rodríguez');     // Add a recipient
    //$mail->addAddress('jjrodriguez@hotmail.com', 'Julian Rodríguez');   
	 //$mail->addAddress('ventas@elreydeltornillo.com', 'Ventas');  
	// $mail->addAddress($email, $nombre);   
	
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');

    // Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true); 
    $path = "https://www.elreydeltornillo.com/sit/facturacion/timbrado/files/cfdi/T_1190_timbrado.xml";
    $mail->AddAttachment($path); //Adds an attachment from a path on the filesystem                                // Set email format to HTML
    $mail->Subject = 'El Rey del Tornillo';
    $mail->Body    = '<html>'.
	'<head><title>El rey del Tornillo</title></head>'.
	'<body><table width="100%" height="326" border="0">
  <tr>
    <td align="center"><p><img src="https://elreydeltornillo.com/img/logo-erdt.png" alt="" width="230" height="142" /></p>
    <p>Mensaje recibido desde la pagina</p></td>
  </tr>
  <tr>
    <td align="center"><table width="31%" class="table table-striped table-hover">
      <thead class="thead-green">
        <tr>
          <th width="38%">&nbsp;</th>
          <th width="62%">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Nombre</td>
          <td>'.$nombre.'</td>
        </tr>
        <tr>
          <td>Correo electronico</td>
          <td>'.strtolower($email).'</td>
        </tr>
        <tr>
          <td>Telefono</td>
          <td>'.$telefono.'</td>
        </tr>
        <tr>
          <td>Estado</td>
          <td>'.$est.'</td>
        </tr>
        <tr>
          <td>Mensaje</td>
          <td>'.$mensaje.'</td>
        </tr>
      </tbody>
    </table></td>
  </tr>
</table>'.
	'</body>'.
	'</html>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    //echo 'Message has been sent';
	echo "<script language='javascript'>window.parent.location='https://elreydeltornillo.com/queja.php?mensaje=1'</script>";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

