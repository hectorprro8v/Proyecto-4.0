<?php
    include_once 'mostrar_ficha.php';
    session_start();
    include("../verificacion.php");
    Nolink();

    if (empty($_SESSION["id"])) {
        header("Location: ../index.php");
        exit;
    }

    // Conexión a la base de datos
    require_once '../conexion.php';
    $pdo = conectar();
    $pdo->exec("SET NAMES utf8mb4");

    // Acción: actualizar el campo Publicado a 1
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['publicar_id'])) {
        $idArticulo = (int) $_POST['publicar_id'];

        try {
            $stmt = $pdo->prepare("UPDATE articulo SET Publicado = 1 WHERE idArticulo = :id");
            $stmt->bindValue(':id', $idArticulo, PDO::PARAM_INT);
            $stmt->execute();

            $_SESSION['mensaje'] = "alertify.success('Artículo publicado correctamente');";
        } catch (Throwable $e) {
            $_SESSION['mensaje'] = "alertify.error('Error al publicar: " . addslashes($e->getMessage()) . "');";
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../css/index/indexstyle.css" rel="stylesheet" media="screen">
    <link href="../css/index/menu.css" rel="stylesheet" media="screen">
    <link href="../css/index/estilos.css" rel="stylesheet" media="screen">
    <link href="../css/index/navbar-fixed-left.min.css" rel="stylesheet">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

    <!-- ALERTAS -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
    <!-- ALERTAS -->

    <title>FICHAS DE PAGO - CID TEC LERDO</title>
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
                <button type="button" style="color:red;" class="navbar-toggle" data-toggle="collapse"
                    data-target=".navbar-ex1-collapse">
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
                        <button href="#" class="btn btn-info dropdown-toggle" data-toggle="dropdown" type="button"
                            style="margin-left:10px;"><?php echo $_SESSION["nameuser"]?> <b class="caret"></b></button>
                        <ul class="dropdown-menu">
                            <li><a href="perfil.php"><span class="glyphicon glyphicon-user"></span> Perfil</a></li>
                            <li class="divider"></li>
                            <li><a href="../destruir_sesion.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
                        </ul>
                    </li>
                    <li><a href="altas.php">Alta usuarios</a></li>
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
                            <li class="divider"></li>
                            <li><a href="gxml/indexdoi.php">DOI / Generar XML</a></li>
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
                    <li><a href="parametros.php">Parámetros</a></li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="container-fluid">
        <div class="panel panel-default" id="sombra">
            <div class="panel-body">
                <h2>PAGOS</h2>

                <!-- 🔸 Botón para generar XML de artículos publicados -->
                <div class="text-right" style="margin:-10px 0 10px 0;">
                    <form method="post" action="generar_cartas.php" target="_blank" style="display:inline-block;">
    <button type="submit" class="btn btn-info">
      Generar Cartas 
    </button>
  </form>
  <!-- 🔹 Botón para enviar correos de aviso de cartas -->
<form method="get" action="enviar_aviso_cartas.php" target="_blank" style="display:inline-block; margin-left:5px;">
  <button type="submit" class="btn btn-success"
    onclick="return confirm('¿Deseas enviar correos electrónicos a los autores de los artículos publicados?');">
    <i class="fa fa-envelope"></i> Enviar Aviso de Cartas
  </button>
</form>

                    <form method="post" action="generatexml_publicados.php" target="_blank" style="display:inline-block;">
                        <button type="submit" class="btn btn-warning">
                            Generar XML 
                        </button>
                    </form>
                </div>

                <hr>
                <div class="container-fluid">
                    <div class="panel panel-default">
                        <div class="panel panel-heading" style="background-color:<?=color_revista()?>"></div>
                        <div class="container-fluid">
                            <div class="table-responsive">
                                <table id="tabla" class="table table-hover" style="text-align: center">
                                    <thead style="background-color: black; color: white;">
                                        <tr>
                                            <th style="width:15%;">Folio</th>
                                            <th style="width:10%;">Artículo</th>
                                            <th style="width:25%;">Ficha de pago</th>
                                            <th style="width:25%;">Comprobante de pago</th>
                                            <th style="width:25%;">Publicación</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($result2 as $row): 
                                            $id=$row['r'];
                                            $doc=$row['d'];
                                            $publicado=$row['p'];
                                            $idArt=$row['ai'];
                                            $clavart=$row['c'];
                                        ?>
                                        <tr>
                                            <td><?= $id ?></td>
                                            <td><?= $clavart ?></td>
                                            <td><a href="datos_recibo.php?recibo=<?=$id?>" class="btn btn-primary">Ver recibo</a></td>
                                            <td>
                                                <?php if ($doc != null): ?>
                                                    <a href="documento_recibo.php?recibo=<?=$id?>" target="_blank" class="btn btn-success">Visualizar</a>
                                                <?php else: ?>
                                                    <p>No disponible</p>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ((int)$publicado === 0): ?>
                                                    <form method="post" action="">
                                                        <input type="hidden" name="publicar_id" value="<?=$idArt;?>">
                                                        <button type="submit" class="btn btn-success">Publicar</button>
                                                    </form>
                                                <?php elseif ((int)$publicado === 1): ?>
                                                    <b>Publicado</b>
                                                <?php else: ?>
                                                    <form method="post" action="">
                                                        <input type="hidden" name="publicar_id" value="<?=$idArt;?>">
                                                        <button type="submit" class="btn btn-success">Publicar</button>
                                                    </form>
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
    </div>

    <div class="lineasep"><img src="../img/line.gif" /></div>
    <div class="contactos">
        <table>
            <tr>
                <td><a href="https://www.facebook.com/pages/Instituto-Tecnol%C3%B3gico-Superior-de-Lerdo-P%C3%A1gina-Oficial/285056498195463"><img src="../img/face.jpg" /></a></td>
                <td><a href="https://twitter.com/ITSLerdo"><img src="../img/tw.jpg" /></a></td>
                <td><a><img src="../img/correoitsl.gif" /></a></td>
            </tr>
        </table>
    </div>

    <div class="pie_pagina">
        <img src="../img/pie_pagina.jpg" />
        <p>Av. Tecnológico N 1555 Sur Periférico Gómez Lerdo Km. 14.5
            <br />C.P. 35150 Cd. Lerdo, Dgo
            <br />Tels. 01 (871) 725 23 71, 725 57 79, 725 58 02
        </p>
    </div>

    <script>
    <?php if(!empty($_SESSION['mensaje'])): ?>
        <?= $_SESSION['mensaje']; $_SESSION['mensaje']=""; ?>
    <?php endif; ?>
    </script>
</body>
</html>