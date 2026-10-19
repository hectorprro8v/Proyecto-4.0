<?php

    include("../conexion.php");
    include("../mail/class.phpmailer.php");
    include("../mail/class.smtp.php");

    $conexion = conectar();
    $formato = array('.docx');

    session_start();

    if(isset($_POST['subir']))
    {
       try
        {
            $titulo_articulo = $_POST["titulo_articulo"];
            $clave_articulo = $_POST["clave_articulo"];
            $nombre_archivo = $_FILES["archivo"]["name"];
            $nombre_archivoSA = $_FILES["archivoSA"]["name"];
            $tmp_nombre = $_FILES["archivo"]["tmp_name"];
            $tmp_nombreSA = $_FILES["archivoSA"]["tmp_name"];
            $destino = "../Documentos/Extensos/".$clave_articulo.".docx";
            $destinoSA = "../Documentos/ExtensosSA/".$clave_articulo.".docx";
            $extension_archivo = substr($nombre_archivo, strrpos($nombre_archivo, '.'));
            $extension_archivoSA = substr($nombre_archivoSA, strrpos($nombre_archivoSA, '.'));
            $someter_revision=0;
            $Correcto=0;
            $CorrectoSA=0;
          
               
            
            if(isset($_POST["cbox"]))  $someter_revision=1;
          /*  echo $titulo_articulo ;
            echo $clave_articulo;
            echo $nombre_archivo;
            echo $nombre_archivoSA;
            echo $tmp_nombre;
            echo $tmp_nombreSA;
            echo $destino;
            echo $destinoSA ;
            echo $extension_archivo;
            echo $extension_archivoSA ;
            echo $someter_revision;
            echo $Correcto;
            echo $CorrectoSA;*/
           

            if($nombre_archivo != "" and $nombre_archivoSA != "")
            {
                if(in_array($extension_archivo, $formato) and in_array($extension_archivoSA, $formato))
                {
                    if(file_exists("../Documentos/Extensos/$nombre_archivo")){
                        unlink("../Documentos/Extensos/$nombre_archivo");
                        
                    }
                    if(move_uploaded_file($tmp_nombre, $destino))
                       {
                           $Correcto=1;
                       } 
                    if(file_exists("../Documentos/ExtensosSA/$nombre_archivoSA")){
                        
                            unlink("../Documentos/ExtensosSA/$nombre_archivoSA");
                        
                    }
                    if(move_uploaded_file($tmp_nombreSA, $destinoSA))
                       {
                           $CorrectoSA=1;
                       }  
                                        
                    if($Correcto=1 and $CorrectoSA=1)
                    {
                        $sql = "select * from articulo where Clave_Articulo = '$clave_articulo'";
                        $gsent = $conexion->prepare($sql);
                        $gsent->execute();
                        $sql_result = $gsent->fetchAll();

                        foreach($sql_result as $dato_id) {
                            $idArticulo = $dato_id['idArticulo'];
                        }
                        $documento = $conexion->prepare("CALL spAltaSegundoExtenso('$idArticulo','$nombre_archivo', 'E','$destino','$nombre_archivoSA', 'ESA','$destinoSA','$someter_revision')");
                        $documento->execute();
                       
                        $_SESSION['mensaje']= "alertify.success('El extenso se ha enviado de manera exitosa...')";
                        //$mensaje = "El extenso se ha enviado de manera exitosa";
                        //Enviar corre con la verificacion de subida del extenso---------
                         //variables de enviar email
                   
                        $email_user = "revistacid@itslerdo.edu.mx";
                        $email_password = "sbjh xlan pnvf ttoa";
                        $the_subject = "Subida de Archivos";
                        $address_to = $_SESSION["correo"];
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
                           $phpmailer->AddAddress( $_SESSION["correo"]); // para quien sera enviado // recipients email
                           
                           $phpmailer->Subject = utf8_decode($the_subject);	
                           $body_email = "<div style='background:#fff;background-color:#fff;Margin:0px auto;max-width:500px'><table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#000;background-color:#fff;width:100%'><tbody><tr><td><div style='font-size:13px;width:100%'><table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top' width='100%'><tbody><tr><td><img alt='Bienvenido/a' src='http://sicsacid.itslerdo.edu.mx/img/BannerCIDTEC.jpg' width='500'> <br><br></td></tr><tr><td><img  align='right' src='http://www.itslerdo.edu.mx/images/descargas/institucion/logo_tec/logo_oficial_tec_lerdo_nov2017_transparente.png' width='20%'> <div align='center'><h3>BIENVENIDO/A A SICSACID</h3><h1>REVISTA CID TEC LERDO</h1></div></td> </tr> </tbody></table></div></td></tr></tbody></table></div><div style='background:#fff;background-color:#fff;Margin:0px auto;max-width:500px'><table border='0' cellpadding='0' cellspacing='0' role='presentation'><tbody><tr><td><div><table border='0' cellpadding='0' cellspacing='0' role='presentation'><tbody><tr><td style='padding:10px 25px;'><div style='font-family:Raleway,Helvetica,Arial,sans-serif;font-size:15px;line-height:22px;text-align:left;color:#666666'> <p><b>¡Hola {$usuario}!</b> </p> <p>Se notifica que los archivos de tu extenso se subieron correctamente</p><p>Entra al sistema SICSACID para verificarlo.</p></div> </td> </tr></tbody></table> <div style='width: 100%; text-align: center'><a style='text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #3498db' href='http://sicsacid.itslerdo.edu.mx/'>Ir al sistema</a> </div><p style='color: #b3b3b3; font-size: 12px; text-align: center;margin: 30px 0 0'>Revista CID {$añorev}</p><br> </div> </td></tr></tbody> </table></div>";
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
                                header("Location: index.php");
                           } 
                       }
                       catch (PDOException $error) { /// MENSAJE POR SI SURGE ALGÚN ERROR
                               $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error al intentar registrarte.\n\nError: ".$error->getMessage()."')";
                               header("Location: registro.php");
                           }      
                        //---------------------------------------------------------------
                        header('Location: articulos.php');
                    }
                    else
                    {
                        $_SESSION['mensaje']= "alertify.error('Ha ocurrido un error, el extenso no se ha enviado. Error: ".$e->getMessage().".')";
                        header('Location: articulos.php');
                    }
                }
                else
                { 
                    $_SESSION['mensaje']= "alertify.warning('El tipo de archivo no es admitido, solamente se permiten documentos .docx (documento de word)').";
                    header("Location: articulos.php");
                }
            }
            else
            {
                $_SESSION['mensaje']= "alertify.warning('No se ha especificado un nombre de archivo válido, intenta nuevamente.')";
                header("Location: articulos.php");
            }
        }
        catch(PDOException $e)
        {
            $_SESSION['mensaje']= "alertify.error('Ha ocurrido un error, el extenso no se ha enviado. Error: ".$e->getMessage().".')";
            header('Location: articulos.php');
        }
    }
    else
    {
        header("Location: articulos.php");
    }
?>