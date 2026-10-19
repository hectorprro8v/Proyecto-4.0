<?php
session_start();
require_once __DIR__ . "/../../conexion.php";
require_once __DIR__ . "/../../verificacion.php";
Nolink();

if (empty($_SESSION["id"])) {
  header("Location: ../index.php"); exit;
}

date_default_timezone_set("America/Mexico_City");
setlocale(LC_TIME, 'spanish');

$pdo = conectar();
$pdo->exec("SET NAMES utf8mb4");

// Acción: ejecutar SP 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'asignar_dois') {
  try {
    $pdo->exec("CALL sp_actualiza_identificadores_aceptados()");
    header("Location: " . $_SERVER['PHP_SELF'] . "?ok=1"); exit;
  } catch (Throwable $e) {
    header("Location: " . $_SERVER['PHP_SELF'] . "?error=" . urlencode($e->getMessage())); exit;
  }
}

// Consulta artículos
$sql = "SELECT
          a.idArticulo      AS id,
          a.Clave_Articulo  AS clave,
          a.Nombre_Articulo AS titulo,
          a.doi             AS doi,
          a.Url_Landing     AS url_landing,
          a.url             AS url_publica,
          GROUP_CONCAT(
            TRIM(CONCAT(au.Nombres, ' ', au.Apellido_Paterno, ' ', au.Apellido_Materno))
            ORDER BY CAST(au.Principal AS UNSIGNED) DESC, au.idautor ASC
            SEPARATOR ', '
          ) AS autores
        FROM articulo a
        LEFT JOIN autores au
               ON au.idArticulo = a.idArticulo
        WHERE a.Aceptado = b'1'
        GROUP BY
          a.idArticulo, a.Clave_Articulo, a.Nombre_Articulo,
          a.doi, a.Url_Landing, a.url
        ORDER BY a.idArticulo DESC";

try {
  $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo '<pre>Error en consulta:' . "\n" . htmlspecialchars($sql) . "\n\n" . $e->getMessage() . '</pre>';
  exit;
}

function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
$ids = array_column($rows, 'id');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>ARTÍCULOS ACEPTADOS — DOI/XML</title>

  <!-- CSS -->
  <link href="..css/bootstrap.min.css" rel="stylesheet">
  <link href="..css/index/indexstyle.css" rel="stylesheet">
  <link href="..css/index/estilos.css" rel="stylesheet">
  <link href="..css/index/navbar-fixed-left.min.css" rel="stylesheet">

  <!-- JS -->
  <script src="..js/index/jquery-1.9.1.min.js"></script>
  <script src="..js/bootstrap.min.js"></script>

  <!-- Alertify -->
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />

  <style>
    .btn-action { margin-right: 8px; }
    .mono { font-family: ui-monospace, Menlo, Consolas, monospace; }
    td.wrap, th.wrap { word-break: break-word; white-space: normal; }
    #sombra { box-shadow: 0 2px 10px rgba(0,0,0,.08); }

    table { table-layout: auto; }
    th, td { white-space: normal; vertical-align: top; }

    .multiline { white-space: normal; line-height: 1.4; text-align: left; }
    .mono-small { font-family: ui-monospace,Menlo,Consolas,monospace; font-size: 13px; }
    .url-link { display: block; white-space: normal; word-break: break-all; color:#0b5ed7; text-decoration: underline; text-align:left; }
  </style>
</head>
<body>
  <!-- Cabecera -->
  <div class="logos">
    <img class="imagenlogo" src="..img/header_portal_vigente_1170.png" alt="Encabezado">
  </div>
  <br>

  <!-- Menú lateral -->
  <div class="container">
    <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-left" role="navigation">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
          <img src="..img/menu.png" alt="Menú">
        </button>
        <a class="navbar-brand" href="..Administrador/index.php" style="margin-left: 15px;">SICSACID</a>
      </div>
      <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
          <div class="image">
            <img src="..img/Logo_Revista.png" width="90" height="120" alt="User" style="margin-left:40px;">
          </div>
          <br>

          <li class="dropdown">
            <button href="#" class="btn btn-info dropdown-toggle" data-toggle="dropdown" type="button" style="margin-left:10px;">
              <?php echo h($_SESSION["nameuser"] ?? ""); ?> <b class="caret"></b>
            </button>
            <ul class="dropdown-menu">
              <li><a href="..perfil.php">Perfil</a></li>
              <li class="divider"></li>
              <li><a href="..destruir_sesion.php">Salir</a></li>
            </ul>
          </li>

          <li><a href="..Administrador/altas.php">Alta usuarios</a></li>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Resúmenes <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="..Administrador/asignar_CE.php">Asignar comité editorial</a></li>
              <li class="divider"></li>
              <li><a href="..Administrador/resumenes.php">Ver resumen</a></li>
            </ul>
          </li>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Artículos <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="..Administrador/asignar_Revisores.php">Asignar artículos</a></li>
              <li class="divider"></li>
              <li><a href="..Administrador/articulos.php">Ver artículos</a></li>
              <li class="divider"></li>
              <li><a href="..Administrador/detalles_articulos.php">Detalles artículos</a></li>
              <li class="divider"></li>
              <li><a href="..Administrador/gxml/indexdoi.php">DOI / Generar XML</a></li>
            </ul>
          </li>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Documentos <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="..Administrador/fichas_pago.php">Ficha de Pago</a></li>
            </ul>
          </li>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="..Administrador/reportes/reporte_res.php">Resumen</a></li>
              <li><a href="..Administrador/reportes/reporte_art.php">Artículo</a></li>
              <li><a href="..Administrador/reportes/reporte_us.php">Usuarios</a></li>
              <li><a href="..Administrador/reportes/reporte_fin.php">Financieros</a></li>
            </ul>
          </li>

          <li><a href="..Administrador/parametros.php">Parámetros</a></li>
        </ul>
      </div>
    </nav>
  </div>

  <!-- Contenido -->
  <div class="container-fluid">
    <div class="panel panel-default" id="sombra">
      <div class="panel-body">
        <h2>ARTÍCULOS — DOI/XML</h2>
        <hr>

        <div class="panel panel-default">
          <div class="panel-heading" style="background-color:<?=color_revista()?>"></div>
          <div class="panel-body">
            <div class="row" style="margin-bottom: 12px;">
              <div class="col-md-12">
                <form method="post" style="display:inline-block;">
                  <input type="hidden" name="action" value="asignar_dois">
                  <button class="btn btn-primary btn-action" type="submit">Asignar identificadores (pendientes)</button>
                </form>

                <form method="post" action="generatexml.php" style="display:inline-block;">
                  <input type="hidden" name="ids" value="<?= h(implode(',', $ids)) ?>">
                  <button class="btn btn-warning btn-action" type="submit">Generar XML (publicados)</button>
                </form>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-hover" style="text-align: center">
                <thead style="background-color: black; color: white;">
                  <tr>
                    <th>ID</th><th>Clave</th><th>Título</th>
                    <th class="wrap">Autores</th><th>DOI</th>
                    <th class="wrap">URL Landing</th><th class="wrap">URL</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($rows as $r): ?>
                    <tr>
                      <td><?= (int)$r['id'] ?></td>
                      <td><?= h($r['clave']) ?></td>
                      <td><?= h($r['titulo']) ?></td>

                      
                      <td class="wrap multiline"><?= h($r['autores'] ?: '—') ?></td>

                      <td class="mono-small"><?= h($r['doi']) ?></td>

                      <!-- URL Landing -->
                      <td class="wrap multiline">
                        <?php if (!empty($r['url_landing'])): ?>
                          <a class="mono-small url-link" href="<?= h($r['url_landing']) ?>" target="_blank">
                            <?= h($r['url_landing']) ?>
                          </a>
                        <?php else: ?>
                          <span class="muted">—</span>
                        <?php endif; ?>
                      </td>

                      <!-- URL pública -->
                      <td class="wrap multiline">
                        <?php if (!empty($r['url_publica'])): ?>
                          <a class="mono-small url-link" href="<?= h($r['url_publica']) ?>" target="_blank">
                            <?= h($r['url_publica']) ?>
                          </a>
                        <?php else: ?>
                          <span class="muted">—</span>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>