 <?php

include_once('../conexion.php');
include ('../mail/class.phpmailer.php');
include ('../mail/class.smtp.php');
$conexion=conectar();

    $idart = $_GET["idarticulo"];

    $sqlParam = $conexion->query("SELECT Anio FROM parametros");
    foreach($sqlParam as $dato){
        $añorev = $dato["Anio"];
    }

    $sqlReg = $conexion->prepare("SELECT reg.Fecha_Limite_Revision_Resumen, reg.Fecha_Limite_Revision_Extenso 
                                   FROM registro AS reg 
                                   INNER JOIN articulo AS a ON a.idRegistro = reg.id_registro 
                                   WHERE a.idArticulo = :idart");
    $sqlReg->bindParam(':idart', $idart);
    $sqlReg->execute();
    foreach($sqlReg as $dato){
        $fecha_resumen = $dato["Fecha_Limite_Revision_Resumen"];
        $fecha_ext = $dato["Fecha_Limite_Revision_Extenso"];
    }


if(isset($_POST["guardar"]))
{
    $ids = $_POST["check"];
    
    try
    {        
        for($x=0; $x<count($ids); $x++)
        { 
            $sql_insert2 = "insert into resumen_comite(idArticulo,idUsuario, Fecha_Asignacion) values($idart, $ids[$x], CURDATE())";
            $sentencia = $conexion->prepare($sql_insert2);
            $sentencia->execute();
        }
        
        $email= $conexion->prepare("select Correo_Electronico as Correo, CONCAT (U.Nombres,'  ', U.Apellido_Paterno, '  ', U.Apellido_Materno) as NombreCo from usuario as u inner join resumen_comite as r on r.idUsuario=u.idUsuario where r.idArticulo=$idart");
        $email-> execute();
        
        $email->setFetchMode(PDO::FETCH_ASSOC);
        $result = $email->fetchAll();
        $var =0;    
        foreach($result as $row)
        {
            $C1[$var]=$row['Correo'];
            
            //variables de enviar email
            $email_user = "revistacid@itslerdo.edu.mx";
            $email_password = "sbjh xlan pnvf ttoa";
            $the_subject = "RESUMEN ASIGNADO";
            $address_to= $C1[$var];
            $from_name = "REVISTA CID TEC LERDO";

            $phpmailer = new PHPMailer();
            
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
            $body_email = "<div style='background:#fff;background-color:#fff;Margin:0px auto;max-width:500px'><table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#000;background-color:#fff;width:100%'><tbody><tr><td><div style='font-size:13px;width:100%'><table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top' width='100%'><tbody><tr><td><img alt='Bienvenido/a' src='http://sicsacid.itslerdo.edu.mx/img/BannerCIDTEC.jpg' width='500'> <br><br></td></tr><tr><td><img  align='right' src='http://www.itslerdo.edu.mx/images/descargas/institucion/logo_tec/logo_oficial_tec_lerdo_nov2017_transparente.png' width='20%'> <div align='center'><h3>BIENVENIDO/A A SICSACID</h3><h1>REVISTA CID TEC LERDO</h1></div></td> </tr> </tbody></table></div></td></tr></tbody></table></div><div style='background:#fff;background-color:#fff;Margin:0px auto;max-width:500px'><table border='0' cellpadding='0' cellspacing='0' role='presentation'><tbody><tr><td><div><table border='0' cellpadding='0' cellspacing='0' role='presentation'><tbody><tr><td style='padding:10px 25px;'><div style='font-family:Raleway,Helvetica,Arial,sans-serif;font-size:15px;line-height:22px;text-align:left;color:#666666'> <p><b>Estimado Comité editorial:</b> </p> <p style='justify-content: center'>Recibe un cordial saludo de la comunidad tecnológica del ITSL.</p><p style='justify-content: center'> A continuación se le envía un <b>RESUMEN</b> para que sea revisado.</p> <label style='justify-content: center'>Por favor ingrese al sistema para checarlo</label>  <br> <div style='font-family:Raleway,Helvetica,Arial,sans-serif;font-size:15px;line-height:22px;text-align:right;color:#666666'> <p> <strong><span class='il text-right'>*Tiene hasta {$fecha_resumen} para dar su evaluacion</span></strong> <br></p> </div></div></td></tr></tbody></table> <div style='width: 100%; text-align: center'><a style='text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #3498db' href='http://sicsacid.itslerdo.edu.mx/'>Ir al sistema</a> </div><p style='color: #b3b3b3; font-size: 12px; text-align: center;margin: 30px 0 0'>Revista CID {$añorev}</p><br> </div> </td></tr></tbody> </table></div>";
            $phpmailer->Body .= utf8_decode($body_email);
            $phpmailer->Body .= "<p>Fecha y Hora: ".date("d-m-Y h:i:s")."</p>";
            $phpmailer->IsHTML(true);
            
            $var++;
            if (!$phpmailer->send()) 
            {   
                $_SESSION['mensaje'] = "alertify.error('HA OCURRIDO UN ERROR <br> EL CORREO NO SE PUDO ENVIAR, VERIFIQUE SU CONEXION.')";
                 header("Location: asignar_CE.php");
                
            }
            else 
            { 
               
                if($sentencia) // MENSAJE DE EXITO
                {
                    $_SESSION['mensaje'] = "alertify.success('COMITE EDITORIAL AGREGADO AL ARTICULO CORRECTAMENTE <br> EMAIL ENVIADO AL REVISOR')";
                    header("Location: asignar_CE.php"); 
                }  
                
            }
        }
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
    
}

if(isset($_POST["guardarREV"]))
{
    $ids = $_POST["check"];
    try
    {
        for($x=0; $x<count($ids); $x++)
        {
            $sql_insert = "insert into extenso_revisor(idArticulo,idRevisor,Fecha_Asignacion) values($idart, $ids[$x], CURDATE())";
            $sentencia = $conexion->prepare($sql_insert);
            $sentencia->execute();
        }
        
        $email= $conexion->prepare("select CONCAT (U.Nombres,'  ', U.Apellido_Paterno, '  ', U.Apellido_Materno) as NombreCo, 
        Correo_Electronico  as Correo from usuario as U left join revisor as r on r.idUsuario=u.idUsuario inner join extenso_revisor as ex on ex.idRevisor=r.idRevisor where idArticulo=$idart;");
        $email-> execute();
        
        $email->setFetchMode(PDO::FETCH_ASSOC);
        $result = $email->fetchAll();
        $var =0;    
        foreach($result as $row)
        {
            $C1[$var]=$row['Correo'];
            
            //variables de enviar email
            $email_user = "revistacid@itslerdo.edu.mx";
            $email_password = "sbjh xlan pnvf ttoa";
            $the_subject = "ARTICULO ASIGNADO";
            $address_to= $C1[$var];
            $from_name = "REVISTA CID TEC LERDO";

            $phpmailer = new PHPMailer();
            
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
            $body_email= "<div style='background:#fff;background-color:#fff;Margin:0px auto;max-width:500px'><table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#000;background-color:#fff;width:100%'><tbody><tr><td><div style='font-size:13px;width:100%'><table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top' width='100%'><tbody><tr><td><img alt='Bienvenido/a' src='http://sicsacid.itslerdo.edu.mx/img/BannerCIDTEC.jpg' width='500'> <br><br></td></tr><tr><td><img  align='right' src='http://www.itslerdo.edu.mx/images/descargas/institucion/logo_tec/logo_oficial_tec_lerdo_nov2017_transparente.png' width='20%'> <div align='center'><h3>BIENVENIDO/A A SICSACID</h3><h1>REVISTA CID TEC LERDO</h1></div></td> </tr> </tbody></table></div></td></tr></tbody></table></div><div style='background:#fff;background-color:#fff;Margin:0px auto;max-width:500px'><table border='0' cellpadding='0' cellspacing='0' role='presentation'><tbody><tr><td><div><table border='0' cellpadding='0' cellspacing='0' role='presentation'><tbody><tr><td style='padding:10px 25px;'><div style='font-family:Raleway,Helvetica,Arial,sans-serif;font-size:15px;line-height:22px;text-align:left;color:#666666'> <p><b>Estimado Revisor:</b> </p> <p style='justify-content: center'>Recibe un cordial saludo de la comunidad tecnológica del ITSL.</p><p style='justify-content: center'> A continuación se le envía un <b>EXTENSO</b> para que sea revisado.</p> <label style='justify-content: center'>Por favor ingrese al sistema para checarlo</label>  <br> <div style='font-family:Raleway,Helvetica,Arial,sans-serif;font-size:15px;line-height:22px;text-align:right;color:#666666'> <p> <strong><span class='il text-right'>*Tiene hasta {$fecha_ext} para dar su evaluacion</span></strong> <br></p> </div></div></td></tr></tbody></table> <div style='width: 100%; text-align: center'><a style='text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #3498db' href='http://sicsacid.itslerdo.edu.mx/'>Ir al sistema</a> </div><p style='color: #b3b3b3; font-size: 12px; text-align: center;margin: 30px 0 0'>Revista CID {$añorev}</p><br> </div> </td></tr></tbody> </table></div>";
            $phpmailer->Body .= utf8_decode($body_email);
            $phpmailer->Body .= "<p>Fecha y Hora: ".date("d-m-Y h:i:s")."</p>";
            $phpmailer->IsHTML(true);
            
            $var++;
            if (!$phpmailer->send()) 
            {   
                $_SESSION['mensaje'] = "alertify.error('HA OCURRIDO UN ERROR <br> EL CORREO NO SE PUDO ENVIAR, VERIFIQUE SU CONEXION.')";
                 header("Location: asignar_Revisores.php");
                
            }
            else 
            { 
                if($sentencia) // MENSAJE DE EXITO
                {
                    $_SESSION['mensaje'] = "alertify.success('REVISOR AGREGADO AL ARTICULO CORRECTAMENTE <br> EMAIL ENVIADO AL REVISOR')";
                    header("Location: asignar_Revisores.php"); 
                }  
                
            }
        }
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
       // header("Location: mi_perfil.php");
    }

}
else
{
    
}