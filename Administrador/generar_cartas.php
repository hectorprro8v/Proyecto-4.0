<?php
/**
 * Genera cartas de presentación (un PDF por artículo publicado)
 * con encabezado, pie y sello institucional.
 * 1️Guarda cada PDF en la carpeta /Documentos/Carta_Publicacion
 * 2Descarga un ZIP con todos los PDFs generados
 */
session_start();
if (empty($_SESSION["id"])) { header("Location: ../index.php"); exit; }

require '../vendor/autoload.php';
require '../conexion.php';
require '../verificacion.php';
Nolink();

use Spipu\Html2Pdf\Html2Pdf;

date_default_timezone_set("America/Mexico_City");
setlocale(LC_TIME, 'es_MX.UTF-8');

@ini_set('max_execution_time', '600');
@set_time_limit(600);
@ini_set('memory_limit', '512M');

$pdo = conectar();
$pdo->exec("SET NAMES utf8mb4");

/* ======= Funciones auxiliares ======= */
function fecha_larga_mx($fecha = null) {
    $ts = $fecha ? strtotime($fecha) : time();
    $meses = [
        1=>'enero',2=>'febrero',3=>'marzo',4=>'abril',5=>'mayo',6=>'junio',
        7=>'julio',8=>'agosto',9=>'septiembre',10=>'octubre',11=>'noviembre',12=>'diciembre'
    ];
    return "Ciudad Lerdo, Durango a ".date('j',$ts)." de ".$meses[(int)date('n',$ts)]." de ".date('Y',$ts);
}

function autores_de_articulo(PDO $pdo, $idArticulo) {
    $sql = "SELECT TRIM(CONCAT_WS(' ', Nombres, Apellido_Paterno, Apellido_Materno)) AS nombre
            FROM autores WHERE idArticulo = :id
            ORDER BY COALESCE(Principal,0) DESC, Apellido_Paterno ASC";
    $st = $pdo->prepare($sql);
    $st->execute([':id'=>$idArticulo]);
    return $st->fetchAll(PDO::FETCH_COLUMN);
}

function esc($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

/* ======= Rutas ======= */
$imgHeader = realpath(__DIR__ . "/../img/Encabezado.jpg") ?: '';
$imgFooter = realpath(__DIR__ . "/../img/PieDePagina.jpg") ?: '';
$imgSello  = realpath(__DIR__ . "/../img/SELLO.jpeg") ?: '';

$saveDir = realpath(__DIR__ . "/../Documentos") . "/Carta_Publicacion";
if (!is_dir($saveDir)) mkdir($saveDir, 0777, true);

/* ======= Artículos publicados ======= */
$sql = "SELECT idArticulo, Clave_Articulo AS clave, Nombre_Articulo AS titulo,
               Anio AS anio, Volumen AS volumen, Numero AS numero, URL AS url
        FROM articulo WHERE Publicado = 1 ORDER BY idArticulo";
$arts = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
if (!$arts) die("No hay artículos publicados.");

/* ======= Parámetros generales ======= */
$fecha = fecha_larga_mx();
$css = <<<CSS
.content { font-family: DejaVu Sans, sans-serif; font-size: 11pt; color:#000; }
.centro  { text-align:center; }
.autores { margin: 6px 0 10px 0; }
.block   { text-align: justify; line-height: 1.5; margin: 3mm 0; }
.table   { width:100%; border-collapse: collapse; margin-top: 6px; }
.table th, .table td { border:1px solid #000; padding:5px; font-size:10.5pt; }
.table th { background:#eee; text-align:left; width:38%; }
.sello   { text-align:center; margin-top:15mm; }
.header-img, .footer-img { width:100%; height:auto; }
CSS;

/* Carpeta temporal para el ZIP */
$tmpDir = sys_get_temp_dir() . '/cp_' . session_id() . '_' . uniqid();
@mkdir($tmpDir, 0777, true);
$generated = [];

/* ======= Generar PDF por cada artículo ======= */
foreach ($arts as $a) {

    $id     = (int)$a['idArticulo'];
    $clave  = $a['clave'] ?: ('CID'.str_pad($id,3,'0',STR_PAD_LEFT));
    $titulo = $a['titulo'] ?: 'Artículo sin título';
    $anio   = $a['anio'] ?: date('Y');
    $vol    = $a['volumen'] ?: '1';
    $num    = $a['numero'] ?: '1';
    $url    = $a['url'] ?: '';
    $autores = autores_de_articulo($pdo, $id);
    $autoresHtml = esc(implode("\n", $autores));

    $intro = "Por este medio es grato informarle que su artículo titulado: <b>“".esc($titulo)."”</b>, "
           . "con clave <b>“".esc($clave)."”</b>, ha sido aceptado para publicación y se ha incluido "
           . "en la edición número <b>".esc($num)."</b>, volumen <b>".esc($vol)."</b> de nuestra revista "
           . "del Instituto Tecnológico Superior de Lerdo. A continuación, se detallan los datos de su artículo.";

    $html = '<style>'.$css.'</style>
<page backtop="48mm" backbottom="30mm" backleft="20mm" backright="20mm">
    <page_header>'.($imgHeader ? '<img src="'.$imgHeader.'" class="header-img">' : '').'</page_header>
    <page_footer>'.($imgFooter ? '<img src="'.$imgFooter.'" class="footer-img">' : '').'</page_footer>

    <div class="content">
        <div class="centro">'.esc($fecha).'</div>
        <p>Distinguidos(as):</p>
        <div class="autores">'.nl2br($autoresHtml).'</div>
        <div class="block">'.$intro.'</div>

        <table class="table">
            <tr><th>Año de publicación</th><td>'.esc($anio).'</td></tr>
            <tr><th>Volumen</th><td>'.esc($vol).'</td></tr>
            <tr><th>Número</th><td>'.esc($num).'</td></tr>
            <tr><th>DOI / Enlace</th><td>'.esc($url).'</td></tr>
        </table>

        <p class="block">Además, se hace de su conocimiento que la revista cuenta con DOI: https://revistacid.itslerdo.edu.mx/revistacid'.esc($anio).'; garantizando la visibilidad de su artículo.</p>

        '.($imgSello ? '<div class="sello"><img src="'.$imgSello.'" style="width:500px;"></div>' : '').'
    </div>
</page>';

    try {
        $pdf = new Html2Pdf('P', 'LETTER', 'es', true, 'UTF-8', [0,0,0,0]);
        $pdf->setDefaultFont('DejaVu Sans');
        $pdf->writeHTML($html);

        $fileName = "CP_".preg_replace('/[^A-Za-z0-9_\-]/','_',$clave).".pdf";

        // GUARDAR EN CARPETA DEFINITIVA
        $finalPath = $saveDir . "/" . $fileName;
        $pdf->output($finalPath, 'F');

        // GUARDAR TAMBIÉN TEMP PARA ZIP
        $tmpPath = $tmpDir . "/" . $fileName;
        $pdf->output($tmpPath, 'F');

        $generated[] = $tmpPath;
    } catch (Exception $e) { continue; }
}

/* ======= Descargar ZIP ======= */
if (!empty($generated)) {
    $zipPath = $tmpDir . '/Cartas_Publicacion.zip';
    $zip = new ZipArchive();
    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
        foreach ($generated as $pdf) { 
            $zip->addFile($pdf, basename($pdf)); 
        }
        $zip->close();
    }

    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="Cartas_Publicacion.zip"');
    header('Content-Length: ' . filesize($zipPath));
    readfile($zipPath);

    // Eliminar temporales
    foreach ($generated as $pdf) @unlink($pdf);
    @unlink($zipPath);
    @rmdir($tmpDir);
    exit;
} else {
    die("No se generaron cartas.");
}