<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["id"] == "") {
    header("Location: ../index.php");
    exit();
}

include("../verificacion.php");
Nolink();
include("../conexion.php");
$conexion = conectar();

require '../vendor/autoload.php';

date_default_timezone_set("America/Mexico_City");
setlocale(LC_TIME, 'spanish');
$fecha = strftime("%d de %B del %Y");

// =========================
//  CONSULTA (try/catch)
//  Revisor -> extenso_revisor -> articulo (Nombre_Articulo)
//  Agrupamos con separador '|||', luego lo partimos para <ul><li>
// =========================
try {
    $detalle_revisores = "
        SELECT
    (@rn := @rn + 1) AS Clave,
    t.idRevisor,
    t.nombre,
    t.articulos
FROM (
    SELECT
        r.idRevisor,
        CONCAT(u.Nombres, ' ', u.Apellido_Paterno, ' ', u.Apellido_Materno) AS nombre,
        COALESCE(
            GROUP_CONCAT(DISTINCT a.Nombre_Articulo ORDER BY a.Nombre_Articulo SEPARATOR '|||'),
            ''
        ) AS articulos
    FROM revisor r
    INNER JOIN usuario u
        ON u.idUsuario = r.idUsuario
    LEFT JOIN extenso_revisor er
        ON er.idRevisor = r.idRevisor
    LEFT JOIN articulo a
        ON a.idArticulo = er.idArticulo
    GROUP BY r.idRevisor, nombre
    ORDER BY r.idRevisor ASC
) AS t
CROSS JOIN (SELECT @rn := 0) AS x;

    ";
    $gsent = $conexion->prepare($detalle_revisores);
    $gsent->execute();
    $detalle_result = $gsent->fetchAll();
} catch (PDOException $e) {
    $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error al consultar. Error: " . $e->getMessage() . "')";
    $detalle_result = [];
    echo $_SESSION['mensaje'];
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<head>
    <link href="../css/index/indexstyle.css" rel="stylesheet" media="screen" />
    <script src="../js/index/jquery-1.9.1.min.js"></script>
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script src="../js/bootstrap.min.js"></script>
    <link href="../css/index/estilos.css" rel="stylesheet" media="screen">
    <link href="../css/index/navbar-fixed-left.min.css" rel="stylesheet">
    <!-- ALERTAS -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
    <title>DETALLE REVISORES - CID TEC LERDO</title>
</head>

<body>
    <br />
    <div class="logos table-responsive">
        <img class="imagenlogo" src="../img/header_portal_vigente_1170.png" />
    </div>
    <br>
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-left" role="navigation">
            <div class="navbar-header">
                <button type="button" style="color:red;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <img src=../img/menu.png>
                </button>
                <a class="navbar-brand" href="index.php" style="margin-left: 15px;">SICSACID</a>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <div class="image">
                        <img src="../img/Logo_Revista.png" width="90" height="120" alt="User" style="margin-left:40px;">
                    </div>
                    <br>
                    <li class="dropdown">
                        <ul class="dropdown-menu">
                            <li><a href="perfil.php"><span class="glyphicon glyphicon-user"></span> Perfil</a></li>
                            <li class="divider"></li>
                            <li><a href="../destruir_sesion.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Revisores <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="alta_revisores.php">Alta Revisores</a></li>
                            <li class="divider"></li>
                            <li><a href="detalle_revisores.php">Detalle Revisores</a></li>
                        </ul>
                    </li>
                    <li class=""><a href="altas.php">Alta usuarios</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Resúmenes <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="asignar_CE.php">Asignar comité editorial</a></li>
                            <li class="divider"></li>
                            <li><a href="resumenes.php">Ver resumen</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown" data-toggle="dropdown"> Artículos <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="asignar_Revisores.php">Asignar artículos</a></li>
                            <li class="divider"></li>
                            <li><a href="articulos.php">Ver artículos</a></li>
                            <li class="divider"></li>
                            <li><a href="detalles_articulos.php">Detalles artículos</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Documentos <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="fichas_pago.php">Ficha de Pago</a></li>
                            <li class="divider"></li>
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
                            <li class="divider"></li>
                            <li><a href="reportes/reporte_fin.php">Financieros</a></li>
                            <li class="divider"></li>
                        </ul>
                    </li>
                    <li class=""><a href="parametros.php">Parámetros</a></li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="container-fluid">
        <div class="panel panel-default" ver="sombra">
            <div class="panel-body">
                <h2>Generar Carta de agradecimiento</h2>
                <hr>
                <div class="container-fluid">
                    <div class="panel panel-default">
                        <div class="panel panel-heading" style="background-color:<?= color_revista() ?>"></div>
                        <div class="container-fluid">
                            <div class="table-responsive">
                                <table id="tabla" class="table table-hover" style="text-align: center">
                                    <thead style="background-color: black; color: white;">
                                        <tr>
                                            <th>Clave</th>
                                            <th>Nombre del revisor</th>
                                            <th>Artículos asignados</th>
                                            <th>Generar Carta de Agradecimiento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php foreach ($detalle_result as $dato):
    $idRev         = $dato['idRevisor'];
    $Nom           = $dato['nombre'];
    $ArticulosStr  = (string)(isset($dato['articulos']) ? $dato['articulos'] : '');
    $items         = array_filter(array_map('trim', explode('|||', $ArticulosStr)));
?>
                                        <tr>
                                            <td><br><?= htmlspecialchars($idRev) ?></td>
                                            <td><br><?= htmlspecialchars($Nom) ?></td>
                                            <td style="text-align:left;">
                                                <?php if (empty($items)): ?>
                                                    <em>Sin artículos</em>
                                                <?php else: ?>
                                                    <ul style="margin: 0 0 0 18px; padding: 0;">
                                                        <?php foreach ($items as $t): ?>
                                                            <li><?= htmlspecialchars($t) ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-success" href="carta_agradecimiento_rev.php?Revisor=<?= urlencode($idRev) ?>">
                                                    Generar
                                                </a>
                                            </td>
                                        </tr>
<?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <?php /* Si hubo error ya se mostró con alertify arriba */ ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br><br>
        <div class="contactos">
            <table>
                <tr>
                    <td><a href="https://www.facebook.com/pages/Instituto-Tecnol%C3%B3gico-Superior-de-Lerdo-P%C3%A1gina-Oficial/285056498195463"><img src="../img/face.jpg" /></a></td>
                    <td><a href="https://twitter.com/ITSLerdo?ref_src=twsrc%5Etfw&ref_url=http%3A%2F%2Fwww.itslerdo.edu.mx%2F"><img src="../img/tw.jpg" /></a></td>
                    <td><a><img src="../img/correoitsl.gif" /></a></td>
                </tr>
            </table>
        </div>

        <div class="pie_pagina">
            <img src="../img/pie_pagina.jpg" />
            <p>
                Av. Tecnológico N 1555 Sur Periferico Gomez Lerdo Km. 14.5
                <br />C.P. 35150 Cd. Lerdo, Dgo
                <br />Tels. 01 (871) 725 23 71, 725 57 79, 725 58 02
            </p>
        </div>

        <script type="text/javascript" src="../js/funciones/articulo.js"></script>
        <script>
            // Si luego quieres paginación/búsqueda, aquí podemos integrar DataTables
        </script>
    </div>
</body>
</html>
