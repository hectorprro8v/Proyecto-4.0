<?php
include_once "../conexion.php";
$con=conectar();
date_default_timezone_set("America/Mexico_City");
setlocale(LC_TIME, 'spanish'); 
$fecha=strftime("%d de %B del %Y");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 
require '../vendor/autoload.php'; 
use Spipu\Html2Pdf\Html2Pdf;
error_reporting(E_ALL ^ E_NOTICE);
if(isset($_POST['val']))
{
   try
   {
       $idRecibo=$_POST['val'];
        $consulta = $con->prepare("select idArticulo as art from recibo_pago_detalle
        where idRecibo='$idRecibo'");
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_ASSOC);
        $res=$consulta->fetchAll();
        $sql = $con->prepare("update recibo_pago set Validado=1 where idRecibo='$idRecibo'");
        $sql->execute();
        $x=0;
         foreach($res as $row)
            {
            $ids[$x]=$row['art']; 
            $sql2=$con->prepare("select a.Clave_Articulo as clave,CONCAT(Nombres,' ',Apellido_Paterno,' ',Apellido_Materno) as autores, a.Institucion as ins, a.Nombre_Articulo as nombre,p.Nombre_Revista as revista,p.Anio as anio, p.Volumen as vol, p.Numero as num, p.ISSN as issn, p.Link_Publicacion as link from articulo as a inner join autores as au on a.idArticulo=au.idArticulo inner join parametros as p where a.idArticulo='$ids[$x]' and au.Principal=1 and Aceptado=1");
           
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                $result2=$sql2->fetchAll();
                                       
                 foreach($result2 as $row)
                {
                       $Nombreart=$row['nombre'];
                       $Inst=$row['ins'];
                       $clave=$row['clave'];
                       $revista=$row['revista'];
                       $vol=$row['vol'];
                        $num=$row['num'];
                        $issn=$row['issn'];
                        $link=$row['link'];
                        $Anio=$row['anio'];
                        $Autor=$row['autores'];
                 }
                $sql3=$con->prepare("select CONCAT(Nombres,' ',Apellido_Paterno,' ',Apellido_Materno) as coautores from autores where idArticulo='$ids[$x]' and Principal=0");
                $sql3->execute();
                $sql3->setFetchMode(PDO::FETCH_ASSOC);
                $result3=$sql3->fetchAll();
                $Coautor="";                 
                 foreach($result3 as $row)
                {
                      $Coautor.=$row['coautores']."<br>";
                }

             ob_start();
//                
                    ?>
                    <style type='text/css'>
                        table{ padding-left: 30px; border-collapse: collapse;}
                        th{text-align: left; padding-left: 15px;}
                        td{text-align: right; background-color: #008CB0;}
                            #fot{background-color:#008CB0; text-align: center;}
                            p{font-family: Arial; font-size: 11em; line-height: 150%}
                            h2,h3{
                                float:left;
                            }
                            #jus{position:relative; text-align: justify; padding-left: 50px; padding-right: 50px;  }
                            #coautor{ padding-left: 30px;}
                    </style>
                      <page backtop='35mm' backbottom='0mm' backleft='15mm' backright='15mm'>
                    <page_header>
                                <img class='imagen' src='../img/Logo3.png'width='500' height='110'/> 
                               
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
         echo "<div style='position: relative; text-align: right;'>
                                <p>Ciudad Lerdo, Durango a ".utf8_encode($fecha)."</p>
                      </div>
                      <br>
                       <p align='center'>CARTA PUBLICACIÓN</p>
                       <div align='left'>
                           <p>
                               <b>Distinguido(a):</b>
                           </p>
                       </div>
                       
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
                            <p align='left'><b>".$Inst."</b></p>
                            <p align='justify'>Por este medio me es grato informar a usted que el artículo, titulado:  <b>".$Nombreart."</b>, <b>con clave ".$clave."</b> ha sido <b>Aceptado</b>, para ser publicado en la <b>".$revista."</b> del Instituto Tecnológico Superior de Lerdo.</p><br>
                            <table class='tableau' >
                                <tr><td>Nombre Revista</td><th>".$revista."</th></tr>
                                <tr><td>Año de publicacion</td><th>".$Anio."</th></tr>
                                <tr><td>Volumen</td><th>".$vol."</th></tr>
                                <tr><td>Numero</td><th>".$num."</th></tr>
                                <tr><td>ISSN</td><th>".$issn."</th></tr>
                                <tr><td>Publicado en:</td><th>".$link."</th>
                                </tr>
                            </table>
                        <br>
                            <p align='justify'>Agradezco la atención prestada y me despido enviándole un saludo.</p>
                    </div>
                    <br>
                        <div style='position: fixed;  top: 100px;>
                                    <img style='position: relative; left: 165px;' src='../img/SELLO.JPG'/> 
                            </div> ";
             
       ?>
       </page>
       <?php
                $html=ob_get_contents();
                ob_clean();
                $pdf = new Html2Pdf('P','LETTER','es','true','UTF-8',array(0, 0, 0, 0));
                $pdf->pdf->SetDisplayMode('fullpage');
                $pdf->writeHTML($html);
                $sql4=$con->prepare("insert into documento(idArticulo,Nombre_Documento,Tipo_Documento,URL,Fecha_Envio,Fecha_Recepcion)values('$ids[$x]','Carta Publicación','CP','../Documentos/Carta_Publicacion/CP-".$clave.".pdf',curdate(),NULL)");
                $sql4->execute();
                $pdf->output($_SERVER['DOCUMENT_ROOT']."/Documentos/Carta_Publicacion/CP-".$clave.".pdf","F");
                $x++;
                }
                $_SESSION['mensaje'] = "alertify.success('Se ha valido el pago correctamente!')";
                header('location: fichas_pago.php');
            }
                
   
     catch(PDOException $e)
    {
        print "Error: ".$e->getMessage()."<br>";
        $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error, intentelo de nuevo.')";
        header('location: fichas_pago.php');
    }
    
    
}


?>