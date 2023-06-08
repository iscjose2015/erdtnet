<?php session_start();
    

    
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
                      $mail->AddAddress($correo_cliente);

                      $archivo = 'prueba.pdf';
                      $mail->AddAttachment($archivo,$archivo);



                 
                      $archivo = '../file/xml/files/T_1016.xml';
                      $mail->AddAttachment($archivo,$archivo);

                      $mail->AddAddress("jjrodriguez@elreydeltornillo.com");
                      $mail->isHTML(true);                                  // Set email format to HTML
                      $mail->Subject = "'SIAVCOM WEB Factura'";


                    

                        //$correo_cliente = "iscjose@hotmail.com";
                       // $pass_cliente = "425041";


                      $mail->Body = utf8_decode('<p>&nbsp;</p>
                      <p>Buen día </p>
                      <p>EL sistema de Certificados del Rey del Tornillo le notifica que un certifcado nuevo le ha sido asignado.</p>
                      <p>Favor de ingresar al portal el documento '.$document.' esta listo para descargar.</p>
                      <p></p>
                      <p>&nbsp;</p>
                      <p>Sin mas por el momento , se agradece su atencion;</p>');
                       

                      if ($mail->Send()) {  } else {  }
                      
                      } catch (Exception $e) {
                          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                      }


    

     ?>

