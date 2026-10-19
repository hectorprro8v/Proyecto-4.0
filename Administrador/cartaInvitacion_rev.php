<?php 
session_start();
include("../verificacion.php");
Nolink();
include("../conexion.php");

$conexion = conectar();
require '../vendor/autoload.php';
date_default_timezone_set("America/Mexico_City");
setlocale(LC_TIME, 'spanish');

$fecha = strftime("%d de %B del %Y");
use Spipu\Html2Pdf\Html2Pdf;

$nombre_reg = $_GET['nombre_reg'];
$apellido_paterno_reg = $_GET['apellido_paterno_reg'];
$apellido_materno_reg = $_GET['apellido_materno_reg'];
$email_reg = $_GET['email_reg'];

// Construir el nombre completo
$nombre_completo = $nombre_reg;
if (!empty($apellido_paterno_reg)) {
    $nombre_completo .= " " . $apellido_paterno_reg;
}
if (!empty($apellido_materno_reg)) {
    $nombre_completo .= " " . $apellido_materno_reg;
}

// OBTENER GRADO DE ESTUDIOS E INSTITUCIÓN DEL REVISOR
$sql = "SELECT u.Institucion, r.Grado_Estudios 
        FROM usuario u 
        INNER JOIN revisor r ON r.idUsuario = u.idUsuario 
        WHERE u.Correo_Electronico = :correo";

$sentencia = $conexion->prepare($sql);
$sentencia->bindParam(':correo', $email_reg);
$sentencia->execute();

$institucion = "";
$grado_estudios = "";
if ($fila = $sentencia->fetch(PDO::FETCH_ASSOC)) {
    $institucion = $fila['Institucion'];
    $grado_estudios = $fila['Grado_Estudios'];
}

// Construir el nombre con grado de estudios
$nombre_con_grado = "";
if (!empty($grado_estudios)) {
    $nombre_con_grado = $grado_estudios . ". " . $nombre_completo;
} else {
    $nombre_con_grado = $nombre_completo;
}

//ID DEL REVISOR
$sql = "SELECT r.idRevisor 
        FROM usuario u 
        INNER JOIN revisor r ON r.idUsuario = u.idUsuario 
        WHERE u.Correo_Electronico = :correo";

$sentencia = $conexion->prepare($sql);
$sentencia->bindParam(':correo', $email_reg);
$sentencia->execute();

$idRevisor = null;
if ($fila = $sentencia->fetch(PDO::FETCH_ASSOC)) {
    $idRevisor = $fila['idRevisor'];
}

try {
    ob_start();
    ?>
    <style type="text/css">
    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10.5pt;
        color: #000;
    }

    .encabezado {
        width: 100%;
        border-bottom: 2px solid #281196;
        padding-bottom: 4px;
        margin-bottom: 8px;
    }

    .encabezado td {
        vertical-align: middle;
    }

    .logo-izq {
        width: 20%;
        text-align: left;
    }

    .logo-der {
        width: 20%;
        text-align: right;
    }

    .titulo-encabezado {
        width: 60%;
        text-align: center;
        font-size: 10pt;
        line-height: 1.2;
    }

    .titulo-encabezado b {
        font-size: 11pt;
    }

    .fecha {
        text-align: right;
        font-size: 10pt;
        margin-top: 2px;
        margin-bottom: 8px;
    }

    .titulo-documento {
        text-align: center;
        font-size: 12pt;
        font-weight: bold;
        margin-top: 6px;
        margin-bottom: 10px;
    }

    .datos-destinatario {
        margin-bottom: 8px;
        line-height: 1.3;
        text-align: left;
    }

    .contenido {
        text-align: justify;
        line-height: 1.35;
        font-size: 10.5pt;
        margin-bottom: 6px;
    }

    .responsabilidades {
        text-align: justify;
        line-height: 1.3;
        font-size: 10pt;
        margin-top: 4px;
        margin-bottom: 6px;
    }

    .firma {
        margin-top: 14px;
        text-align: center;
        line-height: 1.3;
        font-size: 10.5pt;
    }

    .sello {
        text-align: center;
        margin-top: 6px;
    }

    .small {
        font-size: 9pt;
    }
</style>

<page backtop="30mm" backbottom="15mm" backleft="18mm" backright="18mm">

    <page_header>
        <table class="encabezado" cellspacing="0" cellpadding="0">
            <tr>
                <td class="logo-izq">
                    <img src="../img/LogoTEC.png" style="width: 72px;">
                </td>
                <td class="titulo-encabezado">
                    <b>Revista Ciencia, Ingeniería y Desarrollo Tec Lerdo</b><br>
                    Tecnológico Nacional de México<br>
                    Instituto Tecnológico Superior de Lerdo
                </td>
                <td class="logo-der">
                    <img src="../img/Logo_Revista.png" style="width: 72px;">
                </td>
            </tr>
        </table>
    </page_header>

    <page_footer>
        <div style="text-align:center; font-size:10pt; color:#555; border-top:2px solid #281196; padding-top:5px;">
        Revista Ciencia, Ingeniería y Desarrollo Tec Lerdo
    </div>
    </page_footer>

    <div class="fecha">
        Ciudad Lerdo, Durango, a <?php echo $fecha; ?><br>
        
    </div>

    <div class="titulo-documento">
        CARTA DE INVITACIÓN <br>
    </div>

    <div class="datos-destinatario">
        <b><?php echo htmlspecialchars($nombre_con_grado); ?></b><br>
        <?php echo htmlspecialchars($email_reg); ?><br>
        <?php echo htmlspecialchars($institucion); ?><br><br>
        <b>P R E S E N T E</b>
    </div>

    <div class="contenido">
Por medio de la presente, nos es grato extender a usted una cordial invitación para integrarse como
<b>miembro del Comité Revisor</b> de la revista arbitrada
<b>“Ciencia, Ingeniería y Desarrollo Tec Lerdo”</b>, publicación académica del
<b>Instituto Tecnológico Superior de Lerdo</b>, adscrito al <b>Tecnológico Nacional de México</b>.
</div>
    <div class="contenido">
        Considerando su trayectoria académica, experiencia profesional y aportaciones en su área de especialidad, estimamos que su participación constituirá un valioso apoyo para fortalecer la calidad científica, académica y editorial de nuestra publicación.
    </div>

    <div class="contenido">
        En este sentido, su colaboración como revisor consistirá, de manera general, en las siguientes responsabilidades:
    </div>

    <div class="responsabilidades">
        1. Evaluar la calidad, pertinencia y relevancia científica de los manuscritos recibidos, de acuerdo con las líneas de investigación de la revista.<br>
        2. Emitir observaciones, comentarios y sugerencias de carácter académico que contribuyan al fortalecimiento de los trabajos sometidos.<br>
        3. Verificar que los artículos cumplan con los criterios éticos, metodológicos y científicos establecidos por la revista.<br>
        4. Realizar la evaluación conforme a la rúbrica e instrumentos definidos en la plataforma institucional <b>SICSACID</b>.<br>
        5. Llevar a cabo el proceso de revisión exclusivamente mediante la plataforma web oficial.<br>
        6. Mantener la confidencialidad de los manuscritos evaluados, absteniéndose de compartir o divulgar su contenido sin autorización expresa.<br>
        7. Cumplir con los tiempos establecidos para la entrega de las evaluaciones, a fin de garantizar la agilidad y eficiencia del proceso editorial.<br><br>
    </div>

    <div class="contenido">
        Agradecemos de antemano la atención brindada a la presente invitación y confiamos en contar con su valiosa participación
        en beneficio de la comunidad académica y científica. <br><br>
    </div>

    <div class="contenido">
        Sin otro particular, quedamos a su disposición para cualquier información adicional.
    </div>

    <div class="firma">
        <b>Atentamente</b><br><br>
        Revista Ciencia, Ingeniería y Desarrollo Tec Lerdo<br>
        ISSN 2448-623X<br>
    </div>

    <div class="sello">
        <img src="../img/SELLO.JPEG" style="width: 400px;">
    </div>

</page>
<?php
        $html = ob_get_contents();
        ob_clean();

        $pdf = new Html2Pdf('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($html);

        // Ruta donde se guardará el archivo
        $filePath = "../Documentos/Cartas_Invitacion/OA-" . $idRevisor . ".pdf";
        $pdf->output($filePath, "F");

        $insert = $conexion->prepare("INSERT INTO documento (Nombre_Documento, Tipo_Documento, URL, Fecha_Envio, Fecha_Recepcion) VALUES ( 'Cartas Invitacion', 'CI', :url, curdate(), NULL)");
        $insert->bindParam(':url', $filePath);
        // $insert->execute();

        $_SESSION['mensaje'] = "alertify.success('Se generó la carta de invitación correctamente!')";
        $password_temporal = '2eBHJ7467hWA';
        // ENVÍO DEL CORREO ELECTRÓNICO
        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'revistacid@itslerdo.edu.mx'; 
            $mail->Password = 'sbjh xlan pnvf ttoa'; 
            $mail->Port = 587;

            // 🔑 Forzar UTF-8
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            
            // Configurar remitente y destinatario
            $mail->setFrom('revistacid@itslerdo.edu.mx', 'Revista CIENCIA, INGENIERÍA Y DESARROLLO TEC LERDO');
            $mail->addAddress($email_reg, $nombre_con_grado);
            
            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'REGISTRO REVISOR EXITOSO - REVISTA CID TECLERDO';
            $mail->Body = '
              <html>
<body>

<p>Estimado/a ' . $nombre_con_grado . ':</p>

<p>Reciba un cordial saludo. Su registro como revisor en la plataforma <b>SICSACID</b> ha sido realizado correctamente.</p>

<p>Su contraseña temporal de acceso es:</p>

<p><b>' . $password_temporal . '</b></p>

<p>Por motivos de seguridad, deberá cambiar esta contraseña al ingresar a la plataforma por primera vez.</p>

<p>Asimismo, su carta de invitación ya se encuentra disponible en el sistema.</p>

<p>
<a style="text-decoration:none; border-radius:5px; padding:11px 23px; color:white; background-color:#3498db;"
href="http://sicsacid.itslerdo.edu.mx/">
Acceder a la plataforma
</a>
</p>

<p>
Saludos cordiales,<br>
<b>Revista Ciencia, Ingeniería y Desarrollo Tec Lerdo</b>
</p>

</body>
</html>
            ';
            
         $mail->AltBody = "Estimado/a {$nombre_con_grado},

Su registro como revisor en SICSACID ha sido realizado correctamente.

Contraseña temporal: {$password_temporal}

Debe cambiarla al ingresar por primera vez.

Acceso al sistema:
http://sicsacid.itslerdo.edu.mx/

Revista Ciencia, Ingeniería y Desarrollo Tec Lerdo";
            
            // Enviar el correo
            if ($mail->send()) {
                $_SESSION['mensaje'] = "alertify.success('Se generó la carta de invitación y se envió el correo correctamente!')";
            } else {
                $_SESSION['mensaje'] = "alertify.success('Se generó la carta de invitación, pero hubo un error al enviar el correo: " . $mail->ErrorInfo . "')";
            }
        } catch (Exception $e) {
            $_SESSION['mensaje'] = "alertify.success('Se generó la carta de invitación, pero hubo un error al enviar el correo: " . $e->getMessage() . "')";
        }

        // Redirigir a una página que abra el PDF en una nueva pestaña
        header("Location: ver_pdf.php?file=" . urlencode($filePath));
        exit();

} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
    $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error, inténtelo de nuevo.')";
    header("Location: alta_revisores.php");
}
?>
