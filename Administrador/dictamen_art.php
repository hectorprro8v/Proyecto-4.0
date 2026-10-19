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
if(isset($_POST["env"]))
  {
    
        $mod = $_POST["modificacion"];
        $ob = $_POST["observacion"];
        $crit = $_POST["criterios"];
        $dictamen = $_POST["opciones"];
        $id= $_POST["env"];
        // Se le agrega intval para que nos regrese un entero.
        $idArticulo = intval($id);

      //  try
      //  {
       

          
        
           $sql3 = $con->query("SELECT Anio FROM parametros_revista");
                foreach($sql3 as $dato){
                        $añorev= $dato["Anio"];
                }
                // Se tenia un error en el procedimiento, ya que aquí exigia 6 parametros, pero en mysql solo se encontraban cinco y faltaba "crit", y presentaba otros errores, como que en modificaciones y observaciones se estaba insertando lo mismo ya que tenian el mismo paramtero.
            $sql = $con->prepare("CALL spDictamen_A($dictamen,'$mod','$ob','$id','$idUsuario','$crit');");
            
            $sql2 = $con->prepare("SELECT concat(u.Nombres,' ',u.Apellido_Paterno,' ',u.Apellido_Materno) as Nombre, u.Correo_Electronico 
                                     from usuario as u
                                     inner join usuario_tipo as UT on UT.Usuario = u.idUsuario
                                    inner join tipo_usuario as TP on UT.TipoUsuario = TP.Id_Tipo_Usuario
                                    inner join articulo as a on a.idContacto = u.idUsuario
                                    where TP.Caracter_tipo='C' and idArticulo = '$id'");
         
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
             $the_subject = "Dictamen Artículo";
             $address_to = $correo;
             $from_name = "REVISTA CID TECLERDO";
 
             $phpmailer = new PHPMailer();

 // ---------- datos de la cuenta de Gmail -------------------------------
            $phpmailer->Username = $email_user;
            $phpmailer->Password = $email_password; 
            //-----------------------------------------------------------------------
            //$phpmailer->SMTPDebug = 1;
            $phpmailer->SMTPSecure = 'ssl';
            $phpmailer->Host = "smtp.gmail.com"; // GMail
            $phpmailer->Port = 465;
            $phpmailer->IsSMTP(); // use SMTP
            $phpmailer->SMTPAuth = true;
            
            $phpmailer->setFrom($phpmailer->Username,$from_name);
            $phpmailer->AddAddress($address_to); // para quien sera enviado // recipients email
            
            $phpmailer->Subject = utf8_decode($the_subject);	
            $body_email = "<div style='background:#fff;background-color:#fff;Margin:0px auto;max-width:500px'><table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#000;background-color:#fff;width:100%'><tbody><tr><td><div style='font-size:13px;width:100%'><table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top' width='100%'><tbody><tr><td><img alt='Bienvenido/a' src='http://sicsacid.itslerdo.edu.mx/img/BannerCIDTEC.jpg' width='500'> <br><br></td></tr><tr><td><img  align='right' src='http://www.itslerdo.edu.mx/images/descargas/institucion/logo_tec/logo_oficial_tec_lerdo_nov2017_transparente.png' width='20%'> <div align='center'><h3>BIENVENIDO/A A SICSACID</h3><h1>REVISTA CID TEC LERDO</h1></div></td> </tr> </tbody></table></div></td></tr></tbody></table></div><div style='background:#fff;background-color:#fff;Margin:0px auto;max-width:500px'><table border='0' cellpadding='0' cellspacing='0' role='presentation'><tbody><tr><td><div><table border='0' cellpadding='0' cellspacing='0' role='presentation'><tbody><tr><td style='padding:10px 25px;'><div style='font-family:Raleway,Helvetica,Arial,sans-serif;font-size:15px;line-height:22px;text-align:left;color:#666666'> <p><b>¡Hola {$usuario}!</b> </p> <p>Se notifica que su <b>EXTENSO</b> ya tiene un dictamen</p><p>Entra al sistema SICSACID para verificarlo.</p></div> </td> </tr></tbody></table> <div style='width: 100%; text-align: center'><a style='text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #3498db' href='http://sicsacid.itslerdo.edu.mx/'>Ir al sistema</a> </div><p style='color: #b3b3b3; font-size: 12px; text-align: center;margin: 30px 0 0'>Revista CID {$añorev}</p><br> </div> </td></tr></tbody> </table></div>";
            $phpmailer->Body = utf8_decode($body_email);                                                                                
            $phpmailer->Body .= "<p>Fecha y Hora: ".date("d-m-Y h:i:s")."</p>";
            $phpmailer->IsHTML(true);
            
           if (!$phpmailer->send()) 
         {
                echo "Error: " . $phpmailer->ErrorInfo;
                $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error, no se envio correo.')";
                header("Location:articulos.php");
                
            }
            else 
            {
                // Se agrega esta consulta que nos regresa los revisores de cada artículo, y el status que le dio a cada criterio con el que lo evaluó.
                // Preparar la consulta SQL que selecciona información relacionada con criterios, revisores y estatus
                $CriteroRe = $con->prepare("SELECT 
                C.idCriterio AS Criterio, 
                C.descripcion AS Descripcion, 
                CER.estatus AS Estatus, 
                ER.idRevisor AS Revisor
            FROM 
                criterio_extenso_revisor as CER INNER JOIN
                criterios AS C ON C.idCriterio = CER.idCriterio INNER JOIN
                extenso_revisor AS ER ON CER.id_extenso_revisor = ER.id_extenso_revisor 
                where ER.idArticulo = :idArticulo
                order by C.idCriterio, ER.idRevisor");
            // Vincular el parámetro :idArticulo con el valor de $idArticulo (evitar inyección SQL)
            $CriteroRe->bindParam(":idArticulo", $idArticulo, PDO::PARAM_INT);
            $CriteroRe ->execute();
            // Obtener todos los resultados de la consulta en un array asociativo
            $resultadosCR = $CriteroRe ->fetchAll(PDO::FETCH_ASSOC);
            //Se calcula la cantidad de revisores. Si hay resultados, se establece en 1; de lo contrario, se establece en 0.
            $cantidadRevisores = count($resultadosCR) > 0 ? 1 : 0;
            //Primero se asegura de que $resultadosCR contenga un resultados, si los contiene, se asigna el valor del criterio del primer resultado a $criterioidaux; de lo contrario, se asigna el valor -1
            $criterioidaux = count($resultadosCR) > 0 ? $resultadosCR[0]['Criterio'] : -1;
            $i = 0;
            // Este bucle calcula cuantos revisores contiene cada criterio, por ejmeplo si se repite el mismo criterio pero tiene diferente idRevisor, eso quiere decir que los divide por cada revisor.
            for(; $i < count($resultadosCR); $i++) {
                // Se verifica si el criterio actual ($resultadosCR[$i]['Criterio']) es diferente al criterio almacenado en $criterioidaux.
                if($criterioidaux!= $resultadosCR[$i]['Criterio']) {
                    // Si son diferentes, se ejecuta break, lo que termina el bucle.
                    break;
                }
            }  
        // La variable $cantidadRevisores ahora tiene el número de revisores para el primer criterio.
            $cantidadRevisores = $i;

                $sql->execute();
                $sql4 = $con->prepare("SELECT
                CONCAT(au.Nombres, ' ', au.Apellido_Paterno, ' ', au.Apellido_Materno) as Autor,
                a.Clave_Articulo as Clave,
                a.Institucion as Ins,
                Nombre_Articulo as Art,
                Status_Ext as Estatus, 
                Observaciones as Obs,
                Modificaciones as Mods,
                ObsCriterio as Criterios,
                Nombre_Revista as Rev,
                p.Anio from parametros_revista as p,
                extenso as e
                inner join articulo as a on a.idArticulo=e.idArticulo
                inner join autores as au on a.idArticulo=au.idArticulo
                where e.idArticulo='$id' and au.Principal=1;");
                $sql4->execute();
                $sql4->setFetchMode(PDO::FETCH_ASSOC);
                $result4 = $sql4->fetchAll();
                 foreach($result4 as $row)
                {
                   $Autor=$row['Autor'];
                   $Inst=$row['Ins'];
                   $Art=$row['Art'];
                   $Estatus=$row['Estatus'];
                   $Obser=$row['Obs'];
                   $Modifi=$row['Mods'];
                   $Revista=$row['Rev'];
                   $Anio=$row['Anio'];
                   $Clave=$row['Clave'];
                   $Criterios=$row['Criterios'];
                   
                 }
                $actual  = array('1.-', '2.-', '3.-', '4.-', '5.-','6.-','7.-','8.-','9.-','10.-','11.-','12.-','13.-','14.-','15.-','16.-','17.-','18.-','19.-','20.-');
                $remplazo = array('1.-', '<br>2.-', '<br>3.-', '<br>4.-', '<br>5.-','<br>6.-','<br>7.-','<br>8.-','<br>9.-','<br>10.-','<br>11.-','<br>12.-','<br>13.-','<br>14.-','<br>15.-','<br>16.-','<br>17.-','<br>18.-','<br>19.-','<br>20.-');
                $Mods=str_replace($actual,$remplazo,$Modifi);
                $Obs=str_replace($actual,$remplazo,$Obser);
                $Criter=str_replace($actual,$remplazo,$Criterios);

                $sql5=$con->prepare("select CONCAT(Nombres,' ',Apellido_Paterno,' ',Apellido_Materno) as coautores from autores where idArticulo='$id' and Principal=0");
                $sql5->execute();
                $sql5->setFetchMode(PDO::FETCH_ASSOC);
                $result5=$sql5-> fetchAll();
                $Coautor="";                   
                 foreach($result5 as $row)
                {
                     $Coautor.=$row['coautores']."<br>";
                 }

              $Yes=""; $No="";
              $Acept=""; 
              $NoAcept="";$TextoAcept="";
              $TextoNoAcept="";
              echo $Estatus;
             
              if($Estatus=="Aceptado")
              { 
                  $Acept.="Por este medio nos es grato informar que el artículo <b>".$Art."</b>, <b>con clave ".$Clave."</b>, fue sometido a revisión y es <b>ACEPTADO</b> para ser publicado en la <b>".$Revista."</b> en su edición del año <b>".$Anio."</b>.";
                  $Yes="X";
                  $TextoAcept="Se le solicita atender las modificaciones y enviar nuevamente el extenso en formato WORD con sus correcciones en un lapso de 15 días hábiles. Una vez que se reciba el extenso final se emitirá el documento de aceptación para ser publicado su artículo en la Revista Ciencia, Ingeniería y Desarrollo Tec Lerdo.";
                  $TextoNoAcept="";
                  $NoAcept="";
                
              }
              if($Estatus=="No Aceptado")
                {
                    $NoAcept.="Por este medio se informa que, el artículo titulado: <b>".$Art."</b>,<b>con clave ".$Clave."</b>, <b>NO</b> ha sido <b>ACEPTADO</b> para ser publicado en la <b>".$Revista."</b> en su edición del año <b>".$Anio."</b>. En este mismo documento se indica los motivos de porque no fue aceptado y ya no será posible someterlo a otra revisión.";
                    $TextoNoAcept="Cabe mencionar que los trabajos fueron revisados por el comité técnico y el comité de revisores conformado por investigadores de distintas universidades.";
                    $No="X";
                    $TextoAcept="";
                    $Acept="";
                }
            
              if($Estatus=="Segunda Revision")
                {
                    $NoAcept.="Por este medio se informa que, el artículo <b>".$Art."</b>, <b>con clave ".$Clave."</b>, será sometido nuevamente a revisión por el comité técnico y el comité de revisores y así evaluar si podrá ser publicado en la <b>".$Revista."</b> en su edición del año <b>".$Anio."</b>.";
                    $TextoNoAcept="Se le solicita atender las modificaciones y enviar nuevamente el extenso en formato WORD con sus correcciones en un lapso de 15 días hábiles para su revisión";
                    $Seg="X";
                    $TextoAcept="";
                    $Acept="";
                }
              
                ob_start();
    ?>


<style type='text/css'>
#fot { background-color: #8A2D05; text-align: center; }
#hea { background-color: #8A2D05; text-align: center; }
p { font-family: Arial; font-size: 11em; line-height: 150%}
h2, h3 {   float: left; }
#mod-obs { border: black; position: relative; text-align: justify; padding-left: 30px; padding-right: 30px}
#jus {border: black; position: relative; text-align: justify; padding-left: 30px;  padding-right: 30px;}
#coautor { padding-left: 30px;}

/* Se le da diseño a la tabla de los revisores */
        .ok { 
                display: flex;
                width: 10px;
                height: 10px;
                background-color: green;
            }
            .bad { 
                display: flex;
                width: 10px;
                height: 10px;
                background-color: red;
            }
            .tabla-criterios {
                margin: auto;
            }
            td,th{
                padding: 5px;
                max-width: 300px;
            }
            .tabla-criterio-celda-descripcion {
                padding: 0.5rem;
                width: 300px;
            }
            .tabla-criterio-celda-revisor {
                text-align: center;
            }

</style>

<page backtop='35mm' backbottom='0mm' backleft='15mm' backright='15mm'>
    <page_header>
        <div id='hea'>
            <b align='center' style="color: white;">
                Revista CIENCIA, INGENIERÍA Y DESARROLLO TEC LERDO
                <br>
                <br>Tecnológico Nacional de México
                <br>Insituto Tecnológico Superior de Lerdo
            </b><br><br><br>
        </div>
    </page_header>

    <page_footer>
        <div id='fot'>
            <b align='center' style="color: white;">
                           </b>
        </div>
    </page_footer>


<!--  -->
    <?php
        echo "  
        
            <div style='position: relative; text-align: right;'>
                <p>Ciudad Lerdo, Durango a ".utf8_encode($fecha)."</p>
            </div>
        
            <br>
            <br>
            <div>
                <p align='center'>DICTAMEN</p>   
                <div align='left'>
                    <p>
                        <b>".$Autor."</b>
                    </p>
                </div>
                <div>
                    <p id='coautor'>
                        ".$Coautor."
                    </p>
                </div>

                <div align='center'>
                    
                    <p align='left'><b>".$Inst." </b></p>
                    <p align='justify'>".$Acept."".$NoAcept."</p>
                    <p align='justify'>".$TextoNoAcept."".$TextoAcept."</p>
                    <br>

                </div>

                <div style='position: fixed;'>
                        <b>Criterios</b>
                        <br>
                        <br>
                        <div id='mod-obs'>
                            <p align='justify'>".$crit."</p>
                        </div>
                </div>

                <br>

                <div style='position: fixed;'>
                    <b>Observaciones</b>
                    <br><br>
                        
                    <div id='mod-obs'>
                        <p align='justify'>".$Obs."</p>
                    </div>
                </div>

                <br>
                             
                <div style='position: fixed;'>  
                    <b>Modificaciones</b>
                    <br><br>
                    
                    <div id='mod-obs'>
                        <p align='justify'>".$Mods."</p>
                    </div>

                </div>

                <br>

                <div style='position: fixed; top: 50px;'>

                    <div style='text-align: right;'>
                        <h5>RESULTADO DE ARBITRAJE: 
                            <p>POSITIVO(<b>".$Yes."</b>)</p>
                            <p>NEGATIVO (<b>".$No."</b>)</p>
                            <p>SEGUNDA REVISIÓN (<b>".$Seg."</b>)</p>
                        </h5>
                    </div>
                    
                    <div style='position: fixed;  top: 100px;'>
                            <img style='position: fixed; left: 165px;' src='../img/SELLO.JPEG'/> 
                    </div>
                             
                </div>

                            
            </div>";
            
          
    ?>
    <!-- Se agrega la tabla de revisores -->
    <table style="position: absolute; bottom: 0;" class="tabla-criterios" border="1">
                <tr>
                    <th>Número</th>
                    <th>Descripción</th>
                    <?php 
                    // Este for calcula cuantos revisores tiene el artículo, y los agrega como columna con el encabezado Revisor 1, Revisor 2 ...
                    for ( $i = 0; $i < $cantidadRevisores; $i++) {
                        echo '<th class="tabla-criterio-columna">Revisor ' . ($i + 1) . "</th>";
                    }
                    ?>
                </tr>
                <?php
                // Verifica si hay resultados en $resultadosCR
                if ( count($resultadosCR) > 0 ) {
                        // Inicia un bucle para iterar sobre los resultados, avanzando por la cantidad de revisores
                    for ($i = 0; $i < count($resultadosCR); $i += $cantidadRevisores ) {
                        echo "<tr>";
                        // Imprime la celda con el número del criterio
                        echo '<td class="tabla-criterio-celda-numero">' . htmlspecialchars($resultadosCR[$i]['Criterio']) . "</td>";
                         // Imprime la celda con la descripción del criterio
                        echo '<td class="tabla-criterio-celda-descripcion">' . htmlspecialchars($resultadosCR[$i]['Descripcion']) . "</td>";
                        // Inicia un bucle para imprimir las celdas con el estado de revisión para cada revisor
                            for ($j = 0 ; $j < $cantidadRevisores; $j++) 
                        // Imprime una celda con la imagen "ok.png" o "notok.png" según el status.
                            {
                                echo '<td class="tabla-criterio-celda-revisor">' . ($resultadosCR[$i + $j]['Estatus'] === '1' 
                                                    ? '<img style="width: 15px; height: 15px;" src="../img/ok.png">' 
                                                    : '<img style="width: 15px; height: 15px;" src="../img/notok.png">') 
                                    .  "</td>";
                            }
                        echo "</tr>";
                    }
                }
                ?>
            </table>
</page>

<?php
               
                $html=ob_get_contents();
                ob_clean();
                $pdf = new Html2Pdf('P','LETTER','es','true','UTF-8',array(0, 0, 0, 0));
                $pdf->pdf->SetDisplayMode('fullpage');
                $pdf->writeHTML($html);
                 $pdf->output("../Documentos/Dictamen/Articulo/DA-".$Clave.".pdf","F");
                $insert=$con->prepare("insert into documento(idArticulo,Nombre_Documento,Tipo_Documento,URL,Fecha_Envio,Fecha_Recepcion)values('$id','Dictamen Articulo','DA','../Documentos/Dictamen/Articulo/DA-".$Clave.".pdf',curdate(),NULL)");
                $insert->execute();
                $_SESSION['mensaje'] = "alertify.success('Se genero el dictamen correctamente! <br><br> ¡Email enviado!')";
                header("Location:articulos.php");
            } 
           
       
                       
        }
        
      // catch(PDOException $e)
       //{
            //echo 'ERROR: '.$error->getMessage();
            
           // print 'Error'.$e->getMessage();
            $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error, intentelo de nuevo.')";
            header("Location:articulos.php");
            
     //  }
             
        
   //}
  
     
?>