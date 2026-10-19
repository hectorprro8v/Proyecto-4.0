<?php
//////// CONEXION A LA BASE DE DATOS /////////
include('conexion.php');
include ('mail/class.phpmailer.php');
include ('mail/class.smtp.php');
$conexion=conectar();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//////////REGISTRO NUEVO USUARIO ////////////
if (isset($_POST['Enviar'])){ //// SI SE PRESIONA EL BOTÓN "ENVIAR" OCURRE LO SIGUIENTE 
    //variables de registro
    $email_reg=$_POST['email_reg'];

    //variables de enviar email
     $email_user = "revistacid@itslerdo.edu.mx";
    $email_password = "sbjh xlan pnvf ttoa";
    $the_subject = "RESTAURAR CONTRASEÑA";
    $address_to = $email_reg;
    $from_name = "REVISTA CID TECLERDO";
     $phpmailer = new PHPMailer();
    
    $sql = $conexion->query("SELECT Anio FROM parametros_revista");
    foreach($sql as $dato){
        $añorev= $dato["Anio"];
    }
   
      $existente = $conexion->query("select * from usuario where Correo_Electronico = '$email_reg'");
   
    foreach($existente as $dato){
        $idUsuario= $dato["idUsuario"];
    }
       /// COMPROBAR SI EL YA ESTA REGISTRADO
        if ($existente->rowCount()>0) /// SI EXISTE ENTONCES EL MENSAJE SERÁ:
        {
            
      
    
            try
        { 
          
             $logitud = 8;
            $psswd = substr( md5(microtime()), 8, $logitud);
            
            $nuevoUsuario = $conexion -> prepare("call sp_ActualizaContraseniaUser('$psswd',  $idUsuario)");

            // ---------- datos de la cuenta de Gmail -------------------------------
            $phpmailer->Username = $email_user;
            $phpmailer->Password = $email_password; 
            //-----------------------------------------------------------------------
            // $phpmailer->SMTPDebug = 1;
            $phpmailer->SMTPSecure = 'ssl';
            $phpmailer->Host = "smtp.gmail.com"; // GMail
            $phpmailer->Port = 465;
            $phpmailer->IsSMTP(); // use SMTP
            $phpmailer->SMTPAuth = true;

            $phpmailer->setFrom($phpmailer->Username,$from_name);
            $phpmailer->AddAddress($address_to); // para quien sera enviado // recipients email

             $phpmailer->Subject = utf8_decode($the_subject);	
            $body_email = "<div style='background:#fff;background-color:#fff;Margin:0px auto;max-width:500px'><table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#000;background-color:#fff;width:100%'><tbody><tr><td><div style='font-size:13px;width:100%'><table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top' width='100%'><tbody><tr><td><img alt='Bienvenido/a' src='http://sicsacid.itslerdo.edu.mx/img/BannerCIDTEC.jpg' width='500'> <br><br></td></tr><tr><td><img  align='right' src='http://www.itslerdo.edu.mx/images/descargas/institucion/logo_tec/logo_oficial_tec_lerdo_nov2017_transparente.png' width='20%'> <div align='center'><h3>BIENVENIDO/A A SICSACID</h3><h1>REVISTA CID TEC LERDO</h1></div></td> </tr> </tbody></table></div></td></tr></tbody></table></div><div style='background:#fff;background-color:#fff;Margin:0px auto;max-width:500px'><table border='0' cellpadding='0' cellspacing='0' role='presentation'><tbody><tr><td><div><table border='0' cellpadding='0' cellspacing='0' role='presentation'><tbody><tr><td style='padding:10px 25px;'><div style='font-family:Raleway,Helvetica,Arial,sans-serif;font-size:15px;line-height:22px;text-align:left;color:#666666'> <p><b>¡Hola {$usuario}!</b> </p> <p>Se ha restaurado su contraseña para poder acceder al sistema SICSACID</p> <p>la nueva contraseña es la siguiente:</p></div> </td> </tr><tr><td style='font-size:0px;padding:10px 25px;word-break:break-word'> <div style='font-family:Raleway,Helvetica,Arial,sans-serif;font-size:15px;line-height:22px;text-align:left;color:#666666'> <p style='background-color:#e9e9e9;padding:20px;text-decoration:none;color:#666666!important'><strong>DATOS: </strong><br><strong><span class='il'>Contraseña</span>:</strong> {$psswd} <br> </p> </div></td></tr></tbody></table> <div style='width: 100%; text-align: center'><a style='text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #3498db' href='http://sicsacid.itslerdo.edu.mx/'>Ir al sistema</a> </div><p style='color: #b3b3b3; font-size: 12px; text-align: center;margin: 30px 0 0'>Revista CID {$añorev}</p><br> </div> </td></tr></tbody> </table></div>";
            $phpmailer->Body = utf8_decode($body_email);
            $phpmailer->Body .= "<p>Fecha y Hora: ".date("d-m-Y h:i:s")."</p>";
            $phpmailer->IsHTML(true);

            if (!$phpmailer->send()) 
            {
                //echo $phpmailer->ErrorInfo
                $_SESSION["mensaje"]="alertify.error('Ha ocurrido un error, no se ha podido enviar el correo.)";
                header("Location: recupera.php");
            }
            else 
            {
                $ejecutar= $nuevoUsuario -> execute(); 
                if($ejecutar) // MENSAJE DE EXITO
                {
                    $_SESSION["mensaje"]="alertify.success('La contraseña se ha restaurado de manera exitosa, se ha enviado la nueva contraseña al correo ingresado anteriormente, utilizala para iniciar sesión.')";
                    header("Location: index.php");
                }
            }
        }
        catch (PDOException $error) 
    { /// MENSAJE POR SI SURGE ALGÚN ERROR
        //echo $error->getMessage();
        $_SESSION["mensaje"]="alertify.error('Ha ocurrido un error, no se ha podido enviar el correo. \n\nError: ".$error->getMessage()."')";
         header("Location: recupera.php");
    }
        
    } 
    else
        {
            $_SESSION['mensaje'] = "alertify.error('Lo sentimos, el correo ingresado no existe. Registrate si no tienes una cuenta.')";
            header("Location: recupera.php");
        }
   
}
?>

