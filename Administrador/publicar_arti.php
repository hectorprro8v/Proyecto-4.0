<?php

    include("../conexion.php");
    include("../mail/class.phpmailer.php");
    include("../mail/class.smtp.php");
    $conexion = conectar();
    session_start();
    $idArt = $_GET['btnPublicar'];
  
    //ACTUALIZAR EL REGISTRO PUBLICADO
   $sql = $conexion->prepare("CALL publicar($idArt);");
    $sql->execute();

    //OBTENER EL CORREO DEL USUARIO DEL ARTICULO
    $sql3 = "SELECT A.idArticulo, U.Correo_Electronico AS Correo, U.Nombres FROM articulo AS A INNER JOIN recibo_pago_detalle AS RPD ON A.idArticulo = RPD.idArticulo INNER JOIN usuario AS U ON U.idUsuario = A.idContacto WHERE A.idArticulo = $idArt;";
    $agente3 = $conexion->prepare($sql3);
    $agente3->execute();
    $resutado3 = $agente3->fetchAll();

    foreach ($resutado3 as $llave2) {
        $correo = $llave2['Correo'];
        $nombre = $llave2['Nombres'];
    }
    //Enviar corre con la verificacion de subida del extenso---------
    //variables de enviar email
    $email_user = "revistacid@itslerdo.edu.mx";
    $email_password = "sbjh xlan pnvf ttoa";
    $the_subject = "PUBLICACION DE ARTICULOS";
    $address_to = $correo;
    $from_name = "REVISTA CID TECLERDO";
    
    $phpmailer = new PHPMailer();
    try {
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
       $body_email = "<div style='background:#fff;background-color:#fff;Margin:0px auto;max-width:500px'><table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#000;background-color:#fff;width:100%'><tbody><tr><td><div style='font-size:13px;width:100%'><table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top' width='100%'><tbody><tr><td><img alt='Bienvenido/a' src='http://sicsacid.itslerdo.edu.mx/img/BannerCIDTEC.jpg' width='500'> <br><br></td></tr><tr><td><img  align='right' src='http://www.itslerdo.edu.mx/images/descargas/institucion/logo_tec/logo_oficial_tec_lerdo_nov2017_transparente.png' width='20%'> <div align='center'><h3>BIENVENIDO/A A SICSACID</h3><h1>REVISTA CID TEC LERDO</h1></div></td> </tr> </tbody></table></div></td></tr></tbody></table></div><div style='background:#fff;background-color:#fff;Margin:0px auto;max-width:500px'><table border='0' cellpadding='0' cellspacing='0' role='presentation'><tbody><tr><td><div><table border='0' cellpadding='0' cellspacing='0' role='presentation'><tbody><tr><td style='padding:10px 25px;'><div style='font-family:Raleway,Helvetica,Arial,sans-serif;font-size:15px;line-height:22px;text-align:left;color:#666666'> <p><b>¡Hola {$nombre}!</b> </p> <p>Se notifica que su artículo ha sido publicado con exito!</p><p>Entrar al sistema SICSACID para verificarlo.</p></div> </td> </tr></tbody></table> <div style='width: 100%; text-align: center'><a style='text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #3498db' href='http://sicsacid.itslerdo.edu.mx/'>Ir al sistema</a> </div><p style='color: #b3b3b3; font-size: 12px; text-align: center;margin: 30px 0 0'>Revista CID 2023</p><br> </div> </td></tr></tbody> </table></div>";
       $phpmailer->Body = utf8_decode($body_email);
       $phpmailer->Body .= "<p>Fecha y Hora: ".date("d-m-Y h:i:s")."</p>";
       $phpmailer->IsHTML(true);
        if (!$phpmailer->send()) 
       {
           $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error durante la subida de archivos, los archivos no se han enviado.')";
       }
       else
       {      
            $_SESSION['mensaje'] = "alertify.success('Sus archivos se han enviado correctamente')";
            header("Location: fichas_pago.php");
       } 
    }
    catch (PDOException $error) { /// MENSAJE POR SI SURGE ALGÚN ERROR
            $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error al intentar registrarte.\n\nError: ".$error->getMessage()."')";
            header("Location: fichas_pago.php");
        }      
     //---------------------------------------------------------------
     header('Location: fichas_pago.php');
?>