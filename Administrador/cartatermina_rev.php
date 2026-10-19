<?php 
session_start();
if ($_SESSION["id"] == "") {
    header("Location: ../index.php");
    exit();
}

include("../verificacion.php");
Nolink();
include("../conexion.php");

$conexion = conectar();
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';
date_default_timezone_set("America/Mexico_City");
setlocale(LC_TIME, 'spanish'); 
$fecha = strftime("%d de %B del %Y");
use Spipu\Html2Pdf\Html2Pdf;



// Validar que 'Revisor' esté presente en la URL
if (!isset($_GET['Revisor']) || empty($_GET['Revisor'])) {
    die("El parámetro 'Revisor' es obligatorio.");
}
$idRevisor = intval($_GET['Revisor']);

  try {
    // Obtener datos del revisor
    $sql1 = $conexion->prepare("
        SELECT revisor.idRevisor,
               CONCAT(usuario.Nombres, ' ', usuario.Apellido_Paterno, ' ', usuario.Apellido_Materno) AS nombre,
               usuario.Institucion AS Institucion,
               usuario.Correo_Electronico
        FROM revisor
        INNER JOIN usuario ON revisor.idUsuario = usuario.idUsuario
        WHERE revisor.idRevisor = '$idRevisor'");
    $sql1->execute();
    $sql1->setFetchMode(PDO::FETCH_ASSOC);
    $datoRevisor = $sql1->fetch();

    if (!$datoRevisor) {
        die("No se encontró información para el revisor especificado.");
    }

    $Nom = $datoRevisor['nombre'];
    $Inst = $datoRevisor['Institucion'];
    $Correo = $datoRevisor['Correo_Electronico'];

    // Obtener artículos revisados por el revisor
    $sql2 = $conexion->prepare("
        SELECT A.Clave_Articulo, A.Nombre_Articulo, A.Aceptado 
        FROM extenso_revisor AS ER
        INNER JOIN articulo AS A ON ER.idArticulo = A.idArticulo
        WHERE ER.idRevisor = '$idRevisor'
    ");
    $sql2->execute();
    $sql2->setFetchMode(PDO::FETCH_ASSOC);
    $resultado_art_revisor = $sql2->fetchAll();

    // Generar contenido de la tabla de artículos
    $tablaArticulos = "";
    foreach ($resultado_art_revisor as $dato) {
        $tablaArticulos .= "
            <tr>
                <td>" .$dato['Clave_Articulo']. "</td>
                <td align='center' class='tabla-celda-descripcion'>" .$dato['Nombre_Articulo']. "</td>
            </tr>";
    }

    ob_start();
    ?>
    <style type='text/css'>
      #header { 
        color: white;
        background-color: #8A2D05; 
        text-align: center; 
        position: relative;
      }

      p { 
        font-family: Arial;
        font-size: 11em; 
        line-height: 150%
      }
      table {
        margin: auto;
        border: 1;
      }
      td {
        align-content: center;
        margin: 0 auto; 
        text-align: center;
        padding: 15px;
        word-wrap: break-word; 
        max-width: 300px;
        border: 1;
      }

      #revisor p {
        position: relative;
      }

      .tabla-celda-descripcion {
        padding: 0.5rem;
        width: 600px;
      }
      
      #footer { 
        text-align: center; 
      }
    </style>
    <page backtop='35mm' backbottom='0mm' backleft='15mm' backright='15mm'>
        <page_header>
            <div id='header'>
              <p align='center' style="color: white;">
                <b>  Revista CIENCIA, INGENIERÍA Y DESARROLLO TEC LERDO
                  <br>
                  <br>Tecnológico Nacional de México
                  <br>Instituto Tecnológico Superior de Lerdo
                </b>
              </p><br>
            </div>
        </page_header>
        
        <page_footer>
            <div id='footer'>
                <b align='center' style="color: white;"></b>
            </div>
        </page_footer>
        <?php
        echo "
        <div style='position: relative; text-align: right;'>
          <p>Ciudad Lerdo, Durango a ".utf8_encode($fecha)."
            <br>Revista Ciencia, Ingeniería y Desarrollo Tec Lerdo ISSN 2448-623X
          </p><br>
        </div>
        <div style='max-width: 180mm; margin: 0 auto; text-align: justify;'>
          <p align='center'><b>CARTA TERMINACIÓN</b></p>
          <div align='center' id='revisor'>
            <p align='left'>
              <b>".$Nom."
                <br>".$Inst."
                <br>".$Correo. "
              </b>
            </p>
            <p align='left'><b>PRESENTE.-</b></p>
          </div>

          <div align='center'>
            <p align='justify' style='max-width: 180mm;'>
            Por medio del presente, se le agradece sinceramente su invaluable participación como revisor de artículos científicos en la Revista Ciencia, Ingeniería y Desarrollo Tec, en su edición número 12, volumen 1, correspondiente al año 2026. Su trabajo y compromiso con la excelencia académica han sido fundamentales para asegurar la calidad de las publicaciones de nuestra revista
            </p>
            <p align='justify' style='max-width: 180mm;'>La revista, disponible en el portal <span style='color: blue'>https://revistacid.itslerdo.edu.mx/revistacidep2026</span>, cumple con los estándares y dispone del DOI <span style='color: blue'>https://doi.org/10.62805/revistaep.2026</span>, lo que subraya nuestro esfuerzo continuo en garantizar el acceso y la visibilidad de los trabajos publicados. Su contribución ha permitido que los siguientes artículos se incluyan en esta edición:</p>
            <br>
          </div>

          <div>
            <table>".$tablaArticulos."</table>
            <br>
          </div>
          <p align='justify'>Estamos a su disposición para cualquier consulta adicional que pueda tener.</p>
          <div align='center' style='position: fixed; top: 100px;'>
            <img style='position: fixed; left: 165px;' src='../img/SELLO.JPEG'/>  
          </div>
        </div> "
      ?>
      </page>
        <?php

        $html=ob_get_contents();
        ob_clean();

        $pdf = new Html2Pdf('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($html);
        $pdf->output("../Documentos/Cartas_Terminacion/CT-".$idRevisor.".pdf", "F");

        $insert = $conexion->prepare("insert into documento (Nombre_Documento, Tipo_Documento, URL, Fecha_Envio, Fecha_Recepcion) VALUES ( 'Cartas Terminacion', 'CT', '../Documentos/Cartas_Terminacion/CT-".$idRevisor.".pdf', curdate(), NULL)");
        $insert->execute();

        $update = $conexion->prepare("update revisor set Cartaterminacion = 1 WHERE idRevisor = '$idRevisor'");
        $update->execute();

        $_SESSION['mensaje'] = "alertify.success('Se generó la carta de terminación correctamente!')";
        header("Location:detalle_revisores.php");
        
  } catch (PDOException $e) {
    echo 'ERROR: ' . $e -> getMessage();
    $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error, inténtelo de nuevo.')";
    header("Location: detalle_revisores.php");
  }
?>
