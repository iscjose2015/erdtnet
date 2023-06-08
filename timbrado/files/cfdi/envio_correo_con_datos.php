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
                      
                      
                      $mail->setFrom('noreply@elreydeltornillo.com', 'Recordatorio del sistema de KPIS');
                       
                      //Agregar destinatario
                    $mail->AddAddress("iscjose@hotmail.com");
                    $mail->AddAddress("jjrodriguez@elreydeltornillo.com");
   
					  
                      $mail->isHTML(true);  
                      $path = '/sit/facturacion/timbrado/files/cfdiT_1190_timbrado.xml';
                      $mail->AddAttachment($path); //Adds an attachment from a path on the filesystem                                 // Set email format to HTML
                      $mail->Subject = "'Quejas / Sugerencias '";
                      $mail->Body = '<html>'.
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
                       
                      
                      if ($mail->Send()) { echo "correcto";  } else {  echo "No se envio";  }
                      
                      
                      
                      } catch (Exception $e) {
                          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                      
	
	
	

					  }

