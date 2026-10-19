<?php
session_start();
    if($_SESSION["id"]=="")
    {
        header("Location: ../index.php");
    }
    include("../verificacion.php");
    Nolink();
include_once "../conexion.php";
$con=conectar();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 
require '../vendor/autoload.php';
date_default_timezone_set("America/Mexico_City");
setlocale(LC_TIME, 'spanish'); 
$fecha=strftime("%d de %B del %Y");
use Spipu\Html2Pdf\Html2Pdf;

$idUsuario=$_SESSION['id'];
if(isset($_POST["enviar"]))
  {
        
        $just = $_POST["just"];
        $dictamen = $_POST["opcion"];
        $id = $_POST["enviar"];
        
            $sql3 = $con->query("SELECT Anio FROM parametros");
            foreach($sql3 as $dato){
                $añorev= $dato["Anio"];
            }
            $sql = $con->prepare("CALL spDictamen('$just',$dictamen,'$id',$idUsuario);");
            
            $sql2 = $con->prepare("select concat(u.Nombres,' ',u.Apellido_Paterno,' ',u.Apellido_Materno) as Nombre, u.Correo_Electronico 
                                     from usuario as u
                                     inner join usuario_tipo as UT on UT.Usuario = u.idUsuario
                                    inner join tipo_usuario as TP on UT.TipoUsuario = TP.Id_Tipo_Usuario
                                    inner join articulo as a on a.idContacto = u.idUsuario
                                    where TP.Caracter_tipo='C' and idArticulo = $id");
               
            $sql2->execute();
            $sql2->setFetchMode(PDO::FETCH_NUM);
            $result = $sql2->fetchAll();
             foreach ($result as $row)
            {
                $usuario=$row[0];
                $correo=$row[1];
                
            }
            
    //--------ENVIAR CORREO AL CONTACTO-------        
            $email_user = "revistacid@itslerdo.edu.mx";
            $email_password = "sbjh xlan pnvf ttoa";
            $the_subject = "Dictamen Resumen";
            $address_to = $correo;
            $from_name = "REVISTA CID TECLERDO";

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
            $body_email = "<div style='background:#fff;background-color:#fff;Margin:0px auto;max-width:500px'><table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#000;background-color:#fff;width:100%'><tbody><tr><td><div style='font-size:13px;width:100%'><table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top' width='100%'><tbody><tr><td><img alt='Bienvenido/a' src='http://sicsacid.itslerdo.edu.mx/img/BannerCIDTEC.jpg' width='500'> <br><br></td></tr><tr><td><img  align='right' src='http://www.itslerdo.edu.mx/images/descargas/institucion/logo_tec/logo_oficial_tec_lerdo_nov2017_transparente.png' width='20%'> <div align='center'><h3>BIENVENIDO/A A SICSACID</h3><h1>REVISTA CID TEC LERDO</h1></div></td> </tr> </tbody></table></div></td></tr></tbody></table></div><div style='background:#fff;background-color:#fff;Margin:0px auto;max-width:500px'><table border='0' cellpadding='0' cellspacing='0' role='presentation'><tbody><tr><td><div><table border='0' cellpadding='0' cellspacing='0' role='presentation'><tbody><tr><td style='padding:10px 25px;'><div style='font-family:Raleway,Helvetica,Arial,sans-serif;font-size:15px;line-height:22px;text-align:left;color:#666666'> <p><b>¡Hola {$usuario}!</b> </p> <p>Se notifica que su <b>RESUMEN</b> ya tiene un dictamen</p><p>Entra al sistema SICSACID para verificarlo.</p></div> </td> </tr></tbody></table> <div style='width: 100%; text-align: center'><a style='text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #3498db' href='http://sicsacid.itslerdo.edu.mx/'>Ir al sistema</a> </div><p style='color: #b3b3b3; font-size: 12px; text-align: center;margin: 30px 0 0'>Revista CID {$añorev}</p><br> </div> </td></tr></tbody> </table></div>";
            $phpmailer->Body = utf8_decode($body_email);
            $phpmailer->Body .= "<p>Fecha y Hora: ".date("d-m-Y h:i:s")."</p>";
            $phpmailer->IsHTML(true);

            // El dictamen y el PDF se generan siempre, sin depender de que el correo se envíe.
            // El correo es un aviso de cortesía; si falla, no debe impedir que quede registrado el dictamen.
            $sql->execute();
            $sql4 = $con->prepare("select Nombre_Articulo as ResArt,a.Clave_Articulo as clave,
            (case r.Aceptado when '1' then 'Aceptado' when '0' then 'No Aceptado' end) as Estatus, r.Justificacion as jus,reg.Fecha_Limite_subir_Extenso as limite_subir_ext from resumen as r inner join articulo as a on r.idArticulo=a.idArticulo inner join registro as reg on reg.id_registro=a.idRegistro where r.idArticulo='$id'");
            $sql4->execute();
            $sql4->setFetchMode(PDO::FETCH_ASSOC);
            $result4 = $sql4->fetchAll();
            foreach($result4 as $row)
            {
               $clave=$row['clave'];
               $ResArt=$row['ResArt'];
               $Estatus=$row['Estatus'];
               $jus=$row['jus'];
               $limite=$row['limite_subir_ext'];                    
             }
            $fechalimite=strftime("%A, %d de %B del %Y", strtotime($limite));
            $consulta3=$con->prepare("select CONCAT(Nombres,' ',Apellido_Paterno,' ',Apellido_Materno) as autores from autores where idArticulo='$id'");
            $consulta3->execute();
            $consulta3->setFetchMode(PDO::FETCH_ASSOC);
            $result3=$consulta3-> fetchAll();
            $autor="";
            foreach($result3 as $row)
            {       
            $autor.="<br><b>".$row['autores']."</b>";
            }
            ob_start();
            ?>
                <style type='text/css'>
        #fot{background-color:#8A2D05; text-align: center;}
        #hea{background-color:#8A2D05; text-align: center;}
        p{font-family: Arial; font-size: 11em; line-height: 150%}
        
        h2,h3{
            float:left;
        }
        #jus{position:relative; text-align: justify; padding-left: 30px; padding-right: 30px; }
       
</style>
   <page backtop='35mm' backbottom='0mm' backleft='15mm' backright='15mm'>
                    <page_header>
                        <div id='hea'>
                             
                                 <b align='center'>
                                 Revista CIENCIA, INGENIERÍA Y DESARROLLO TEC LERDO
                                <br>
                                <br>Tecnológico Nacional de México
                                 </b><br><br><br>
                                
                               </div>            
                    
                               
                    </page_header>
                    
        
                    <page_footer>
                            
                               <div id='fot'>
                             
                                 <b align='center'>
                                   Insituto Tecnológico Superior de Lerdo<br>
                                Av. Tecnológico N 1555 Sur Periferico Gomez Lerdo Km. 14.5
                                <br>C.P. 35150 Cd. Lerdo, Dgo
                                <br>Tels. 01 (871) 725 23 71, 725 57 79, 725 58 02
                                 </b><br><br>
                                
                               </div>
                    </page_footer>
       <?php
                
            echo " <div style='position: relative;  text-align: right;'>
                                <p>Ciudad Lerdo, Durango a ".utf8_encode($fecha).".</p>
                      </div>
                       <br>
                        <p align='center'>DICTAMEN</p>
                       <div align='left'>
                           <p>
                               <b>Distinguido(a):</b>
                           </p>
                       </div>
                       <div style='padding-left: 30px;'>
                         ".$autor."
                        </div>
                    <div align='center'>
                            <p align='justify'>Por este medio informo a usted que el dictamen del resumen de su articulo, titulado <b>".$ResArt."</b>, <b>con clave ".$clave."</b> que usted amablemente sometió a revisión es <b> ".$Estatus.".</b> A continuación, se enuncian los comentarios que justifican este resultado:</p>
                            <p id='jus'>".$jus."</p>
                            <p align='justify'>En caso de que su resumen haya sido aceptado, se le invita cordialmente a preparar su trabajo en extenso de conformidad con el formato que se encuentra disponible en la pagina <a href='http://revistacid.itslerdo.edu.mx/'>http://revistacid.itslerdo.edu.mx/</a>, recordándole que éste será nuevamente sometido a arbitraje; la recepción de artículos inicia a partir de la fecha de la presente carta y termina el día <b>".utf8_encode($fechalimite)."</b>.<br><br>
                            Agradezco la atención prestada y me despido de usted enviándole un cordial saludo.</p>
                    </div>
                    <br>";
            if(file_exists(dirname(__DIR__)."/img/SELLO.JPEG"))
            {
                echo "<div style='position: fixed;>
                                    <img style='position: relative; left: 165px;' src='../img/SELLO.JPEG'/> 
                            </div>";
            }
            ?>
 
         </page>
               <?php
                 
            $html=ob_get_contents();
            ob_clean();
            $pdf = new Html2Pdf('P','LETTER','es','true','UTF-8',array(0, 0, 0, 0));
            $pdf->pdf->SetDisplayMode('fullpage');
            $pdf->writeHTML($html);
            $pdf->output(dirname(__DIR__)."/Documentos/Dictamen/Resumen/DR-".$clave.".pdf","F");
            $insert=$con->prepare("insert into documento(idArticulo,Nombre_Documento,Tipo_Documento,URL,Fecha_Envio,Fecha_Recepcion)values('$id','Dictamen Resumen','DR','../Documentos/Dictamen/Resumen/DR-".$clave.".pdf',curdate(),NULL)");
            $insert->execute();

            // El correo es un intento aparte: si falla, se avisa pero el dictamen y el PDF ya quedaron guardados.
            if (!$phpmailer->send()) 
            {
                $_SESSION['mensaje'] = "alertify.success('Se genero el dictamen correctamente, pero el correo no se pudo enviar. Error: ".addslashes($phpmailer->ErrorInfo)."')";
            }
            else
            {
                $_SESSION['mensaje'] = "alertify.success('Se genero el dictamen correctamente! <br><br> ¡Email enviado!')";
            }
            header('Location:resumenes.php');
            exit;
   }
?>