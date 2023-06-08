<?php		
        include("conecta2.php");
        

 
		


  		error_reporting(0);
		// Import PHPMailer classes into the global namespace
		// These must be at the top of your script, not inside a function
		use PHPMailer\PHPMailer\PHPMailer;
		use PHPMailer\PHPMailer\Exception;
		use PHPMailer\PHPMailer\SMTP;
		
		require 'PHPMailer/src/Exception.php';
		require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';
        
        
        echo "Hola";


        $consulta_usuarios = mysqli_query($con,"select * from usuarios where nivel_acceso = '400' ");


        while($re=mysqli_fetch_array($consulta_usuarios))
        {
              echo "entro aqui";

          $usuario = $re[id];
         // echo $usuario;
          echo "<br>";
        //  echo $re[usuario];
          echo "<br>";
          echo $re[correo];
    
          $corr = $re[correo];
          
    
          $consulta_pendientes = mysqli_query($con,"SELECT a.id,a.iddepto,a.depto,a.idsuc,a.sucursal,a.idsem,a.idusuario,a.usuario,a.realizada, b.mes, b.activa, c.correo FROM `formatos` a INNER JOIN semanas b on a.idsem = b.id 
          INNER JOIN usuarios c ON a.idusuario = c.id and b.activa = 1 where idusuario = '$usuario' and a.realizada = 'PENDIENTE DE LLENADO'");
    
    
            $total = mysqli_num_rows($consulta_pendientes);
    
            $cadena = " ";
    
    
            if( $total >= 1)
            {
    
    
                    $contador = 1;
    
                    while($re2 = mysqli_fetch_array($consulta_pendientes)){
    
    
                            //echo mb_strtoupper($re2[depto], 'UTF-8');
                            //echo "<br>";
    
                            $cadena .= mb_strtoupper($re2[depto], 'UTF-8');
    
    
                            if($contador < $total)  { $cadena .= " , ";}
                            if($contador == $total-1) { $cadena .= "   ";}
    
                    }
    
    
                    echo $cadena;



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
                      $mail->AddAddress($corr);
                      $mail->isHTML(true);                                  // Set email format to HTML
                      $mail->Subject = "'Sistema de KPIS'";
                      $mail->Body = utf8_decode('<p>&nbsp;</p>
                      <p>Buen día </p>
                      <p>EL sistema de KPIS ha detectado que no se ha completado el llenado de información correspondiente a esta semana.</p>
                      <p>Favor de ingresar al sistema en las siguientes areas: </p>
                      <p>'.$cadena.'</p>
                      <p>&nbsp;</p>
                      <p>Sin mas por el momento , se agradece su atencion;</p>');
                       
                      
                      if ($mail->Send()) { echo "correcto"; } else {   }
                      
                      
                      
                      } catch (Exception $e) {
                          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                      }

    
               }else{

                $cadena = " Ha cumplido con el llenado, gracias";


               }
   

        }


     ?>


