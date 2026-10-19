<?php
include("../security.php");
include("../conexion.php");

$conexion = conectar();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["id"]) || $_SESSION["id"] == "") {
    header("Location: ../index.php");
    exit;
}

error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set("America/Mexico_City");
setlocale(LC_TIME, 'spanish');

if (!isset($_GET['Articulo']) || !is_numeric($_GET['Articulo'])) {
    header("Location: detalles_articulos.php");
    exit;
}

$idArticulo = (int) $_GET['Articulo'];

try {
    $sql = "SELECT
                A.idArticulo,
                A.Clave_Articulo,
                A.Nombre_Articulo,
                A.Institucion,
                A.Pais,
                A.Estado,
                A.Ciudad,
                A.Dictamen_Resumen,
                A.Dictamen_Extenso,
                A.Aceptado AS Aceptado_Articulo,
                A.Publicado,
                A.Anio,
                A.Volumen,
                A.Numero,
                E.Status_Ext,
                E.Aceptado AS Aceptado_Extenso,
                E.Modificaciones,
                E.Observaciones,
                E.ObsCriterio,
                E.Fecha_Recepcion,
                E.Fecha_Dictamen,
                E.idDocumentoExtenso,
                E.Concluido,
                E.idDocumentoExtensoSA,
                LI.Nombre AS Linea_Investigacion,
                RE.Aceptado AS Aceptado_Resumen,
                (SELECT GROUP_CONCAT(
                    CONCAT(AU.Nombres, ' ', AU.Apellido_Paterno, ' ', AU.Apellido_Materno)
                    SEPARATOR '<br><br>'
                )
                FROM autores AU
                WHERE AU.idArticulo = A.idArticulo) AS Autor
            FROM articulo A
            LEFT JOIN extenso E ON E.idArticulo = A.idArticulo
            LEFT JOIN linea_investigacion LI ON LI.idLinea = A.idLinea
            LEFT JOIN resumen RE ON RE.idArticulo = A.idArticulo
            WHERE A.idArticulo = :idArticulo
            LIMIT 1";

    $consulta = $conexion->prepare($sql);
    $consulta->bindValue(':idArticulo', $idArticulo, PDO::PARAM_INT);
    $consulta->execute();
    $dato = $consulta->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al consultar el artículo: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}

if (!$dato) {
    die("El artículo solicitado no existe.");
}

$idArt = $dato['idArticulo'];
$claveArt = $dato['Clave_Articulo'];
$nombreArt = $dato['Nombre_Articulo'];
$institucion = $dato['Institucion'];
$pais = $dato['Pais'];
$estado = $dato['Estado'];
$ciudad = $dato['Ciudad'];
$dictRes = $dato['Dictamen_Resumen'];
$dictExt = $dato['Dictamen_Extenso'];
$aceptadoArticulo = $dato['Aceptado_Articulo'];
$publicado = $dato['Publicado'];
$anio = $dato['Anio'];
$volumen = $dato['Volumen'];
$numero = $dato['Numero'];
$status = $dato['Status_Ext'];
$mod = $dato['Modificaciones'];
$obs = $dato['Observaciones'];
$obsCrit = $dato['ObsCriterio'];
$fechaRec = $dato['Fecha_Recepcion'];
$fechaDic = $dato['Fecha_Dictamen'];
$idDocExt = $dato['idDocumentoExtenso'];
$idDocExtSA = $dato['idDocumentoExtensoSA'];
$lineaInvest = $dato['Linea_Investigacion'];
$autores = $dato['Autor'];
$statusRes = $dato['Aceptado_Resumen'];

function existeArchivoWeb($rutaWeb) {
    return is_file(__DIR__ . '/' . $rutaWeb);
}

$dictamenResumenPath = '../Documentos/Dictamen/Resumen/DR-' . $claveArt . '.pdf';
$tieneDictamenResumen = existeArchivoWeb($dictamenResumenPath);

$extensoModPath = '../Documentos/Extenso_Modificado/' . $claveArt . '.docx';
$extensoPath = '../Documentos/Extenso/' . $claveArt . '.docx';
$tieneExtensoMod = existeArchivoWeb($extensoModPath);
$tieneExtenso = existeArchivoWeb($extensoPath);
$urlExtenso = $tieneExtensoMod ? $extensoModPath : ($tieneExtenso ? $extensoPath : '');
$puedeDescargarExtenso = ($urlExtenso != '');

$extensoSAPath = '../Documentos/ExtensosSA/' . $claveArt . '.docx';
$puedeDescargarExtensoSA = existeArchivoWeb($extensoSAPath);

$similitudPath = '../Documentos/Similitud/' . $claveArt . '.pdf';
$puedeDescargarSimilitud = existeArchivoWeb($similitudPath);

$puedeVerResumen = ($claveArt != '');
$puedeVerDictamenExt = ($status === 'Aceptado' || $status === 'No Aceptado' || $status === 'No aceptado');

if ($status === 'Aceptado') {
    $claseFila = 'fila-aceptada';
    $textoEstatus = 'ACEPTADO';
} elseif ($status === 'No Aceptado' || $status === 'No aceptado' || $status === 'Rechazado') {
    $claseFila = 'fila-rechazada';
    $textoEstatus = 'NO ACEPTADO';
} else {
    $claseFila = 'fila-evaluacion';
    $textoEstatus = ($status != '') ? $status : 'PENDIENTE';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/index/indexstyle.css" rel="stylesheet" media="screen">
    <link href="../css/index/menu.css" rel="stylesheet" media="screen">
    <link href="../css/index/estilos.css" rel="stylesheet" media="screen">
    <link href="../css/index/navbar-fixed-left.min.css" rel="stylesheet">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <title>Detalle del Artículo</title>
    <style>
        .fila-aceptada { background-color:#c3e6cb !important; color:#155724 !important; font-weight:bold; }
        .fila-rechazada { background-color:#f5c6cb !important; color:#721c24 !important; font-weight:bold; }
        .fila-evaluacion { background-color:#ffeeba !important; color:#856404 !important; font-weight:bold; }
        textarea { resize:none; }
    </style>
</head>
<body>
    <br>
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-left" role="navigation">
            <div class="navbar-header">
                <button type="button" style="color:red;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <img src="../img/menu.png" alt="menu">
                </button>
                <a class="navbar-brand" href="index.php" style="margin-left:15px;">SICSACID</a>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <div class="image">
                        <img src="../img/Logo_Revista.png" width="90" height="120" alt="User" style="margin-left:40px;">
                    </div>
                    <br>
                    <li class="dropdown">
                        <a href="#" class="dropdown" data-toggle="dropdown">Revisores <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="alta_revisores.php">Alta Revisores</a></li>
                            <li class="divider"></li>
                            <li><a href="detalle_revisores.php">Detalle Revisores</a></li>
                        </ul>
                    </li>
                    <li><a href="altas.php">Alta usuarios</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Resúmenes <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="asignar_CE.php">Asignar comité editorial</a></li>
                            <li class="divider"></li>
                            <li><a href="resumenes.php">Ver resumen</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown" data-toggle="dropdown">Artículos <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="asignar_Revisores.php">Asignar artículos</a></li>
                            <li class="divider"></li>
                            <li><a href="articulos.php">Ver artículos</a></li>
                            <li class="divider"></li>
                            <li><a href="detalles_articulos.php">Detalles artículos</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="reportes/reporte_res.php">Resumen</a></li>
                            <li class="divider"></li>
                            <li><a href="reportes/reporte_art.php">Artículo</a></li>
                            <li class="divider"></li>
                            <li><a href="reportes/reporte_us.php">Usuarios</a></li>
                        </ul>
                    </li>
                    <li><a href="correos.php">Enviar Email</a></li>
                    <li><a href="parametros.php">Parámetros</a></li>
                    <li><a href="reportes/reportes_gen.php">Reportes Generales</a></li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="container-fluid">
        <div class="panel panel-default" id="sombra">
            <div class="panel-body">
                <center><h2>Detalle de artículo</h2></center>
                <hr>
                <div class="container-fluid">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background-color:<?php echo color_revista(); ?>;"></div>
                        <div class="panel-body">
                            <fieldset>
                                <legend>DATOS DEL ARTÍCULO</legend>
                                <div class="col-md-12">
                                    <label>Nombre del artículo</label>
                                    <p><?php echo htmlspecialchars($nombreArt, ENT_QUOTES, 'UTF-8'); ?></p>
                                </div>
                                <div class="col-md-6"><label>Clave del artículo</label><p><?php echo htmlspecialchars($claveArt, ENT_QUOTES, 'UTF-8'); ?></p></div>
                                <div class="col-md-6"><label>Año</label><p><?php echo htmlspecialchars($anio, ENT_QUOTES, 'UTF-8'); ?></p></div>
                                <div class="col-md-6"><label>Autor(es)</label><p><?php echo $autores != '' ? $autores : 'N/D'; ?></p></div>
                                <div class="col-md-6"><label>Volumen</label><p><?php echo htmlspecialchars($volumen, ENT_QUOTES, 'UTF-8'); ?></p></div>
                                <div class="col-md-6"><label>Línea de investigación</label><p><?php echo htmlspecialchars($lineaInvest, ENT_QUOTES, 'UTF-8'); ?></p></div>
                                <div class="col-md-6"><label>Número</label><p><?php echo htmlspecialchars($numero, ENT_QUOTES, 'UTF-8'); ?></p></div>
                                <div class="col-md-6"><label>Publicado</label><p><?php echo ($publicado == '1') ? 'Sí' : 'No'; ?></p></div>
                                <div class="col-md-6"><label>Ciudad</label><p><?php echo htmlspecialchars($ciudad, ENT_QUOTES, 'UTF-8'); ?></p></div>
                                <div class="col-md-6"><label>Institución</label><p><?php echo htmlspecialchars($institucion, ENT_QUOTES, 'UTF-8'); ?></p></div>
                                <div class="col-md-6"><label>Estado</label><p><?php echo htmlspecialchars($estado, ENT_QUOTES, 'UTF-8'); ?></p></div>
                                <div class="col-md-6"><label>Fecha de recepción</label><p><?php echo $fechaRec != '' ? htmlspecialchars($fechaRec, ENT_QUOTES, 'UTF-8') : 'N/D'; ?></p></div>
                                <div class="col-md-6"><label>País</label><p><?php echo htmlspecialchars($pais, ENT_QUOTES, 'UTF-8'); ?></p></div>
                            </fieldset>

                            <div class="container-fluid">
                                <div class="form-group">
                                    <center><label>Observaciones de los criterios</label></center>
                                    <textarea class="form-control" readonly rows="5"><?php echo $obsCrit != '' ? htmlspecialchars($obsCrit, ENT_QUOTES, 'UTF-8') : 'N/D'; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <center><label>Observaciones</label></center>
                                    <textarea class="form-control" readonly rows="5"><?php echo $obs != '' ? htmlspecialchars($obs, ENT_QUOTES, 'UTF-8') : 'N/D'; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <center><label>Modificaciones</label></center>
                                    <textarea class="form-control" readonly rows="5"><?php echo $mod != '' ? htmlspecialchars($mod, ENT_QUOTES, 'UTF-8') : 'N/D'; ?></textarea>
                                </div>
                            </div>

                            <br><hr><br>

                            <div class="table-responsive">
                                <table class="table table-hover" style="text-align:center;">
                                    <thead style="background-color:black;color:white;">
                                        <tr>
                                            <th>Estatus revisión</th>
                                            <th>Visualizar resumen</th>
                                            <th>Dictamen resumen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="<?php echo ($statusRes == '1') ? 'fila-aceptada' : (($statusRes === null || $statusRes === '') ? 'fila-evaluacion' : 'fila-rechazada'); ?>">
                                            <td>
                                                <?php
                                                if ($statusRes === null || $statusRes === '') {
                                                    echo 'PENDIENTE';
                                                } elseif ($statusRes == '1') {
                                                    echo 'ACEPTADO';
                                                } else {
                                                    echo 'NO ACEPTADO';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($puedeVerResumen) { ?>
                                                    <a href="visualizar_res.php?clave=<?php echo urlencode($claveArt); ?>" target="_blank" class="btn btn-primary">
                                                        <span class="glyphicon glyphicon-eye-open"></span> Ver resumen
                                                    </a>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-default" disabled>No disponible</button>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($tieneDictamenResumen) { ?>
                                                    <a href="<?php echo htmlspecialchars($dictamenResumenPath, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" class="btn btn-primary">
                                                        <span class="glyphicon glyphicon-eye-open"></span> Ver dictamen
                                                    </a>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-default" disabled>No disponible</button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <br><hr><br>

                            <div class="table-responsive">
                                <table class="table table-hover" style="text-align:center;">
                                    <thead style="background-color:black;color:white;">
                                        <tr>
                                            <th>Extenso</th>
                                            <th>Extenso sin autores</th>
                                            <th>Resultado de similitud</th>
                                            <th>Fecha de dictamen</th>
                                            <th>Dictamen</th>
                                            <th>Documento de dictamen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="<?php echo $claseFila; ?>">
                                            <td>
                                                <?php if ($puedeDescargarExtenso) { ?>
                                                    <a href="<?php echo htmlspecialchars($urlExtenso, ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-warning">
                                                        <span class="glyphicon glyphicon-download"></span> Descargar
                                                    </a>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-default" disabled>No disponible</button>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($puedeDescargarExtensoSA) { ?>
                                                    <a href="<?php echo htmlspecialchars($extensoSAPath, ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-warning">
                                                        <span class="glyphicon glyphicon-download"></span> Descargar
                                                    </a>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-default" disabled>No disponible</button>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($puedeDescargarSimilitud) { ?>
                                                    <a href="<?php echo htmlspecialchars($similitudPath, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" class="btn btn-info">
                                                        <span class="glyphicon glyphicon-download-alt"></span> Descargar
                                                    </a>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-default" disabled>No disponible</button>
                                                <?php } ?>
                                            </td>
                                            <td><?php echo $fechaDic != '' ? htmlspecialchars($fechaDic, ENT_QUOTES, 'UTF-8') : 'N/D'; ?></td>
                                            <td><?php echo htmlspecialchars($textoEstatus, ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td>
                                                <?php if ($puedeVerDictamenExt) { ?>
                                                    <a href="dictamen_extenso.php?Articulo=<?php echo intval($idArticulo); ?>" target="_blank" class="btn <?php echo ($status === 'Aceptado') ? 'btn-success' : 'btn-danger'; ?>">
                                                        <span class="glyphicon glyphicon-file"></span> Dictamen
                                                    </a>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-default" disabled>No disponible</button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <hr>
                            <a class="btn btn-danger" href="detalles_articulos.php">
                                <span class="glyphicon glyphicon-chevron-left"></span> Regresar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
