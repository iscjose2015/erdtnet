<?php

include('conecta_facturacion.php');
if(isset($_POST['email']) && isset($_POST['opc'])){
    $id = $_POST['id'];
    $email = $_POST['email'];
    $option = $_POST['opc'];

    if($option == 1){ // Cuando son nuevos registros
        $insert = mysqli_query($cone, "INSERT INTO cuenta_correos (`correo`, `activo`) VALUES ('$email', '1')");
        if($insert){
            echo 'success';
        }else{
            echo 'error';
        }
        
    }else if($option == 3){ // Cuando es una actualización
        $insert = mysqli_query($cone, "UPDATE `cuenta_correos` SET `correo`='$email',`activo`='1' WHERE `id` = $id");
        if($insert){
            echo 'success';
        }else{
            echo 'error';
        }
    }
    
}

?>