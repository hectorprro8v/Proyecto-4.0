<?php

session_start();
if (empty($_SESSION["id"])) { header("Location: ../index.php"); exit; }

require '../vendor/autoload.php';
require '../conexion.php';
require '../verificacion.php';
Nolink();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set("America/Mexico_City");
@ini_set('max_execution_time', '300');
@set_time_limit(300);

$pdo = conectar();
$pdo->exec("SET NAMES utf8mb4");


define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_USER', 'revistacid@itslerdo.edu.mx');
define('MAIL_PASS', 'sbjh xlan pnvf ttoa'); 
define('MAIL_PORT', 587);
define('MAIL_NAME', 'Revista CID Tec Lerdo');


$sql = "
  SELECT 
      u.idUsuario,
      u.Correo_Electronico AS email,
      TRIM(CONCAT_WS(' ', u.Nombres, u.Apellido_Paterno, u.Apellido_Materno)) AS nombre,
      GROUP_CONCAT(a.Clave_Articulo ORDER BY a.Clave_Articulo SEPARATOR ', ') AS claves
  FROM articulo a
  INNER JOIN usuario u ON u.idUsuario = a.idContacto
  WHERE a.Publicado = 1 
    AND u.Correo_Electronico IS NOT NULL 
    AND u.Correo_Electronico <> ''
  GROUP BY u.idUsuario, u.Correo_Electronico, u.Nombres, u.Apellido_Paterno, u.Apellido_Materno
";
$rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

if (empty($rows)) {
    die("⚠️ No hay contactos con artículos publicados o sin correos válidos.");
}


$asunto = "Aviso: Cartas de publicación disponibles";
$plantillaHTML = function($nombre, $claves) {
    $extra = $claves ? "<p><b>Artículos:</b> ".htmlspecialchars($claves)."</p>" : "";
    return '
        <p>Estimado(a) '.htmlspecialchars($nombre ?: 'autor(a)').',</p>
        <p>Le informamos que las <b>cartas de publicación</b> correspondientes a los artículos publicados en la <b>Revista CIENCIA, INGENIERÍA Y DESARROLLO TEC LERDO</b> ya se encuentran disponibles en la plataforma.</p>
        '.$extra.'
        <p>Por favor, ingrese a su cuenta para <b>descargarlas</b> desde el módulo correspondiente.</p>
        <p>Atentamente,<br><b>Comité Editorial — Revista CID Tec Lerdo</b></p>
    ';
};

function enviarAviso($para, $nombre, $asunto, $html) {
    $mail = new PHPMailer(true);
    try {
        
        if (isset($_GET['debug']) && $_GET['debug'] == '1') {
            $mail->SMTPDebug  = 2;
            $mail->Debugoutput = 'html';
        }

        $mail->isSMTP();
        $mail->Host       = MAIL_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_USER;
        $mail->Password   = MAIL_PASS;
        $mail->Port       = MAIL_PORT;
        $mail->CharSet    = 'UTF-8';
        $mail->Encoding   = 'base64';

        $mail->setFrom(MAIL_USER, MAIL_NAME);
        $mail->addAddress($para, $nombre ?: $para);

        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $html;
        $mail->AltBody = strip_tags(preg_replace('/<br\s*\/?>/i', "\n", $html));

        return [$mail->send(), $mail->ErrorInfo ?: ''];
    } catch (Exception $e) {
        return [false, $e->getMessage()];
    }
}


$enviados = 0;
$fallidos = 0;

echo "<div style='font-family:Arial; padding:16px'>";
echo "<h3>📩 Envío de avisos a contactos de artículos publicados</h3>";
echo "<table border='1' cellpadding='6' cellspacing='0' style='border-collapse:collapse; font-size:14px;' width='100%'>
        <tr style='background:#007bff; color:#fff;'>
            <th>#</th><th>Nombre</th><th>Correo</th><th>Artículos</th><th>Estado</th>
        </tr>";

$i = 1;
foreach ($rows as $r) {
    $nombre = trim($r['nombre'] ?? '');
    $email  = trim($r['email'] ?? '');
    $claves = trim($r['claves'] ?? '');

    $html = $plantillaHTML($nombre, $claves);
    list($ok, $err) = enviarAviso($email, $nombre, $asunto, $html);

    echo "<tr>
            <td>{$i}</td>
            <td>".htmlspecialchars($nombre)."</td>
            <td>".htmlspecialchars($email)."</td>
            <td>".htmlspecialchars($claves)."</td>
            <td>".($ok ? "✅ Enviado" : "❌ Falló: ".htmlspecialchars($err))."</td>
          </tr>";

    if ($ok) $enviados++; else $fallidos++;
    $i++;

    
}

echo "</table>";
echo "<p><b>Correos enviados:</b> {$enviados} &nbsp; | &nbsp; <b>Fallidos:</b> {$fallidos}</p>";
echo "<hr>";
echo "<a href='ficha_pago.php' style='text-decoration:none; color:#007bff;'>&laquo; Regresar</a>";
echo "</div>";
?>