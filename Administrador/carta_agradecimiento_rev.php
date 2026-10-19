<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["id"] == "") {
    header("Location: ../index.php");
    exit();
}

require '../vendor/autoload.php';
include("../conexion.php");
include("../verificacion.php");
Nolink();

use Spipu\Html2Pdf\Html2Pdf;

date_default_timezone_set("America/Mexico_City");
setlocale(LC_TIME, 'spanish');

$conexion = conectar();

$idRevisor = isset($_GET['Revisor']) ? (int) $_GET['Revisor'] : 0;
if ($idRevisor <= 0) { die("Parámetro Revisor inválido."); }

// --- Carpetas de salida ---
$baseDir = realpath(__DIR__ . "/../Documentos");
if ($baseDir === false) { $baseDir = __DIR__ . "/../Documentos"; }
if (!is_dir($baseDir)) { mkdir($baseDir, 0775, true); }

$outDir = $baseDir . "/Cartas_Terminacion";
if (!is_dir($outDir)) { mkdir($outDir, 0775, true); }

// --- Recursos (rutas relativas a /Administrador/) ---
$imgHeader = realpath(__DIR__ . "/../img/Encabezado.jpg");
$imgFooter = realpath(__DIR__ . "/../img/PieDePagina.jpg");
$imgSello  = realpath(__DIR__ . "/../img/SELLO.jpeg");

$imgHeader = $imgHeader ?: '';
$imgFooter = $imgFooter ?: '';
$imgSello  = $imgSello  ?: '';

// --- Datos del revisor (según tu esquema) ---
$sqlRevisor = "
    SELECT 
        r.idRevisor,
        r.Grado_Estudios,
        u.Nombres, u.Apellido_Paterno, u.Apellido_Materno,
        u.Institucion,
        u.Correo_Electronico
    FROM revisor r
    INNER JOIN usuario u ON u.idUsuario = r.idUsuario
    WHERE r.idRevisor = :rev
    LIMIT 1;
";
$st = $conexion->prepare($sqlRevisor);
$st->execute([':rev' => $idRevisor]);
$revisor = $st->fetch(PDO::FETCH_ASSOC);
if (!$revisor) { die("Revisor no encontrado."); }

$nombreRevisor   = trim(($revisor['Nombres'] ?? '') . ' ' . ($revisor['Apellido_Paterno'] ?? '') . ' ' . ($revisor['Apellido_Materno'] ?? ''));
$gradoEstudios   = trim($revisor['Grado_Estudios'] ?? '');
$nombreConGrado  = trim(($gradoEstudios ? $gradoEstudios . ' ' : '') . $nombreRevisor);
$correoRevisor   = $revisor['Correo_Electronico'] ?? '';
$instRevisor     = $revisor['Institucion'] ?? '';

// --- Artículos asignados (usa la clave real) ---
$sqlArts = "
    SELECT a.idArticulo, a.Nombre_Articulo AS titulo, a.Clave_Articulo AS clave
    FROM extenso_revisor er
    INNER JOIN articulo a ON a.idArticulo = er.idArticulo
    WHERE er.idRevisor = :rev
    ORDER BY a.idArticulo;
";
$stA = $conexion->prepare($sqlArts);
$stA->execute([':rev' => $idRevisor]);
$articulos = $stA->fetchAll(PDO::FETCH_ASSOC);

if (!$articulos) {
    echo "<script>alert('El revisor no tiene artículos asignados.'); window.location='detalle_revisores.php';</script>";
    exit();
}

// --- Texto fijo de la carta ---
$parrafo1 = "Por medio de la presente, reciba un sincero agradecimiento por su participación como
revisor(a) de artículos científicos en la Revista Ciencia, Ingeniería y Desarrollo Tec Lerdo,
en su edición número 11, volumen 1, correspondiente al año 2026. Su trabajo y compromiso
con la excelencia académica han sido fundamentales para garantizar la calidad científica
de los contenidos publicados. La revisión que usted ha brindado no solo fortalece cada
artículo, sino que también contribuye al desarrollo del conocimiento en nuestras disciplinas.";

$parrafo2 = "Nos complace informarle que la revista estará disponible en el portal oficial a partir del 29
de junio de 2026, en el siguiente enlace:
https://revistacid.itslerdo.edu.mx/revistacidep2026";

$parrafoFinal = "A nombre del comité editorial, reiteramos nuestro reconocimiento por su contribución y
esperamos contar con su participación en futuras ediciones.";

// ---------------------------
//  CSS global
// ---------------------------
$css = <<<CSS
.content { font-family: DejaVu Sans, sans-serif; font-size: 11pt; color:#000; }
.linea { margin: 2mm 0; }
.presente { margin-top: 2mm; }
.block { white-space: pre-line; text-align: justify; line-height: 1.5; margin: 3mm 0; }
.label { font-weight: bold; }
.sello { text-align: center; margin-top: 10mm; }
/* nuevo: contenedor justificado para todo lo que sigue a PRESENTE */
.just { text-align: justify; }
CSS;

// ---------------------------
//  Construimos TODAS las páginas (solo <page>, sin <html>/<body>)
// ---------------------------
$pagesHtml = '<style>'.$css.'</style>';
foreach ($articulos as $art) {
    $titulo = $art['titulo'] ?? 'Artículo sin título';
    $clave  = $art['clave']  ?? ('CID' . str_pad((string)($art['idArticulo'] ?? 0), 3, '0', STR_PAD_LEFT));

    $pagesHtml .= '
<page backtop="48mm" backbottom="30mm" backleft="20mm" backright="20mm">
  <page_header>'.($imgHeader ? '<img src="'.$imgHeader.'" style="width:100%; height:auto;">' : '').'</page_header>
  <page_footer>'.($imgFooter ? '<img src="'.$imgFooter.'" style="width:100%; height:auto;">' : '').'</page_footer>

  <div class="content">
    <div class="linea">'.htmlspecialchars($nombreConGrado).'</div>
    <div class="linea">'.htmlspecialchars($instRevisor).'</div>
    <div class="linea">'.htmlspecialchars($correoRevisor).'</div>
    <div class="linea presente"><span class="label">PRESENTE.-</span></div>

    <div class="just">
      <div class="block">'.htmlspecialchars($parrafo1).'</div>
      <div class="block">'.htmlspecialchars($parrafo2).'</div>

      <div class="linea"><span class="label">Gracias por su valiosa colaboración en la revisión del siguiente artículo:</span></div>
      <div class="linea"><span class="label">Clave:</span> '.htmlspecialchars($clave).'</div>
      <div class="linea"><span class="label">Nombre:</span> '.htmlspecialchars($titulo).'</div>

      <div class="block">'.htmlspecialchars($parrafoFinal).'</div>
    </div>

    '.($imgSello ? '<div class="sello"><img src="'.$imgSello.'" style="width:650px; height:auto;"></div>' : '').'
  </div>
</page>';
}

// ---------------------------
//  Generamos un SOLO PDF con todas las páginas
// ---------------------------
try {
    $pdf = new Html2Pdf('P', 'Letter', 'es', true, 'UTF-8', array(0,0,0,0));
    $pdf->setDefaultFont('DejaVu Sans');
    $pdf->writeHTML($pagesHtml);

    $fileName = "CT-{$idRevisor}.pdf";
    $fullPath = $outDir . "/" . $fileName;

    $pdf->output($fullPath, 'F');
    $publicUrl = "../Documentos/Cartas_Terminacion/" . $fileName;
    header("Location: " . $publicUrl);
    exit();
} catch (Exception $e) {
    $msg = "Error al generar el PDF: " . $e->getMessage();
    echo "<script>alert(".json_encode($msg)."); window.location='detalle_revisores.php';</script>";
    exit();
}
