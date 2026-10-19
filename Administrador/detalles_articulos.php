<?php
    include('consulta_det_art.php');

    if($_SESSION["id"]=="")
    {
        header("Location: ../index.php");
        exit;
    }

    error_reporting(E_ALL ^ E_NOTICE);

    include_once "mostrar_art.php";

    date_default_timezone_set("America/Mexico_City");
    setlocale(LC_TIME, 'spanish');
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link href="../css/index/indexstyle.css" rel="stylesheet" media="screen" />
    <script src="../js/index/jquery-1.9.1.min.js"></script>

    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script src="../js/bootstrap.min.js"></script>

    <link href="../css/index/estilos.css" rel="stylesheet" media="screen">
    <link href="../css/index/navbar-fixed-left.min.css" rel="stylesheet">

    <!-- ALERTAS -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
    <link rel="stylesheet"
          href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
    <!-- FIN ALERTAS -->

    <title>ARTÍCULOS - CID TEC LERDO</title>
</head>

<body>

    <br>

    <!-- LOGOTIPOS -->
    <div class="logos">
        <img class="imagenlogo" src="../img/header_portal_vigente_1170.png" />
    </div>
    <!-- FIN LOGOTIPOS -->

    <br>

    <!-- MENU -->
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-left" role="navigation">

            <div class="navbar-header">

                <button type="button"
                        style="color:red;"
                        class="navbar-toggle"
                        data-toggle="collapse"
                        data-target=".navbar-ex1-collapse">

                    <img src="../img/menu.png">

                </button>

                <a class="navbar-brand"
                   href="index.php"
                   style="margin-left: 15px;">
                    SICSACID
                </a>

            </div>

            <div class="collapse navbar-collapse navbar-ex1-collapse">

                <ul class="nav navbar-nav">

                    <div class="image">

                        <img src="../img/Logo_Revista.png"
                             width="90"
                             height="120"
                             alt="User"
                             style="margin-left:40px;">

                    </div>

                    <br>

                    <!-- USUARIO -->
                    <li class="dropdown">

                        <ul class="dropdown-menu">

                            <li>
                                <a href="perfil.php">
                                    <span class="glyphicon glyphicon-user"></span>
                                    Perfil
                                </a>
                            </li>

                            <li class="divider"></li>

                            <li>
                                <a href="../destruir_sesion.php">
                                    <span class="glyphicon glyphicon-log-out"></span>
                                    Salir
                                </a>
                            </li>

                        </ul>

                    </li>

                    <!-- REVISORES -->
                    <li class="dropdown">

                        <a href="#"
                           class="dropdown"
                           data-toggle="dropdown">

                            Revisores <b class="caret"></b>

                        </a>

                        <ul class="dropdown-menu">

                            <li>
                                <a href="alta_revisores.php">
                                    Alta Revisores
                                </a>
                            </li>

                            <li class="divider"></li>

                            <li>
                                <a href="detalle_revisores.php">
                                    Detalle Revisores
                                </a>
                            </li>

                        </ul>

                    </li>

                    <!-- ALTA USUARIOS -->
                    <li>
                        <a href="altas.php">
                            Alta usuarios
                        </a>
                    </li>

                    <!-- RESUMENES -->
                    <li class="dropdown">

                        <a href="#"
                           class="dropdown-toggle"
                           data-toggle="dropdown">

                            Resúmenes <b class="caret"></b>

                        </a>

                        <ul class="dropdown-menu">

                            <li>
                                <a href="asignar_CE.php">
                                    Asignar comité editorial
                                </a>
                            </li>

                            <li class="divider"></li>

                            <li>
                                <a href="resumenes.php">
                                    Ver resumen
                                </a>
                            </li>

                        </ul>

                    </li>

                    <!-- ARTICULOS -->
                    <li class="dropdown">

                        <a href="#"
                           class="dropdown"
                           data-toggle="dropdown">

                            Artículos <b class="caret"></b>

                        </a>

                        <ul class="dropdown-menu">

                            <li>
                                <a href="asignar_Revisores.php">
                                    Asignar artículos
                                </a>
                            </li>

                            <li class="divider"></li>

                            <li>
                                <a href="articulos.php">
                                    Ver artículos
                                </a>
                            </li>

                            <li class="divider"></li>

                            <li>
                                <a href="detalles_articulos.php">
                                    Detalles artículos
                                </a>
                            </li>

                        </ul>

                    </li>

                    <!-- REPORTES -->
                    <li class="dropdown">

                        <a href="#"
                           class="dropdown-toggle"
                           data-toggle="dropdown">

                            Reportes <b class="caret"></b>

                        </a>

                        <ul class="dropdown-menu">

                            <li>
                                <a href="reportes/reporte_res.php">
                                    Resumen
                                </a>
                            </li>

                            <li class="divider"></li>

                            <li>
                                <a href="reportes/reporte_art.php">
                                    Artículo
                                </a>
                            </li>

                            <li class="divider"></li>

                            <li>
                                <a href="reportes/reporte_us.php">
                                    Usuarios
                                </a>
                            </li>

                        </ul>

                    </li>

                    <!-- PARAMETROS -->
                    <li>
                        <a href="parametros.php">
                            Parámetros
                        </a>
                    </li>

                </ul>

            </div>

        </nav>
    </div>
    <!-- FIN MENU -->


<?php

try
{

    /*
        IMPORTANTE:
        Se eliminaron completamente las dependencias de:

        recibo_pago
        recibo_pago_detalle
        documentos_financiero
        fichas de pago
        facturación

        Los detalles del artículo ahora dependen únicamente
        de la información editorial.
    */

    $detalle_articulo = "
        SELECT
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

            GROUP_CONCAT(
                DISTINCT CONCAT(
                    AU.Nombres,
                    ' ',
                    AU.Apellido_Paterno,
                    ' ',
                    AU.Apellido_Materno
                )
                SEPARATOR '<br><br>'
            ) AS Autor,

            RE.Aceptado AS Aceptado_Resumen

        FROM articulo AS A

        LEFT JOIN extenso AS E
            ON A.idArticulo = E.idArticulo

        LEFT JOIN linea_investigacion AS LI
            ON A.idLinea = LI.idLinea

        LEFT JOIN autores AS AU
            ON AU.idArticulo = A.idArticulo

        LEFT JOIN resumen AS RE
            ON RE.idArticulo = A.idArticulo

        GROUP BY
            A.idArticulo,
            A.Clave_Articulo,
            A.Nombre_Articulo,
            A.Institucion,
            A.Pais,
            A.Estado,
            A.Ciudad,
            A.Dictamen_Resumen,
            A.Dictamen_Extenso,
            A.Aceptado,
            A.Publicado,
            A.Anio,
            A.Volumen,
            A.Numero,
            E.Status_Ext,
            E.Aceptado,
            E.Modificaciones,
            E.Observaciones,
            E.ObsCriterio,
            E.Fecha_Recepcion,
            E.Fecha_Dictamen,
            E.idDocumentoExtenso,
            E.Concluido,
            E.idDocumentoExtensoSA,
            LI.Nombre,
            RE.Aceptado

        ORDER BY A.idArticulo DESC
    ";

    $gsent = $conexion->prepare($detalle_articulo);

    $gsent->execute();

    $detalle_result = $gsent->fetchAll(PDO::FETCH_ASSOC);

?>

    <!-- CUERPO DE LA PAGINA -->
    <div class="container-fluid">

        <div class="panel panel-default" id="sombra">

            <div class="panel-body">

                <h1>Detalle de los Artículos</h1>

                <hr>

                <div class="container-fluid">

                    <div class="panel panel-default">

                        <div class="panel panel-heading"
                             style="background-color: <?=color_revista();?>">
                        </div>

                    </div>

                    <div class="table-responsive">

                        <table id="tabla"
                               class="table table-hover"
                               style="text-align:center;">

                            <thead style="background-color:black; color:white;">

                                <tr>

                                    <th>CLAVE</th>

                                    <th>TÍTULO</th>

                                    <th>STATUS RESUMEN</th>

                                    <th>DICTAMEN</th>

                                    <th>PUBLICADO</th>

                                    <th>VER</th>

                                </tr>

                            </thead>

                            <tbody>

                            <?php

                            if(count($detalle_result) > 0)
                            {

                                foreach($detalle_result as $dato)
                                {

                                    $idArt = $dato['idArticulo'];

                                    $claveArt = $dato['Clave_Articulo'];

                                    $nombreArt = $dato['Nombre_Articulo'];

                                    $status = $dato['Status_Ext'];

                                    $statusRes = $dato['Aceptado_Resumen'];

                                    $dictamenArticulo = $dato['Aceptado_Articulo'];

                                    $publicado = $dato['Publicado'];

                            ?>

                                <tr>

                                    <!-- CLAVE -->
                                    <td>
                                        <br>
                                        <?php echo htmlspecialchars($claveArt, ENT_QUOTES, 'UTF-8'); ?>
                                    </td>


                                    <!-- TITULO -->
                                    <td>
                                        <br>
                                        <?php echo htmlspecialchars($nombreArt, ENT_QUOTES, 'UTF-8'); ?>
                                    </td>


                                    <!-- STATUS RESUMEN -->
                                    <td>

                                        <?php

                                        if($statusRes === null || $statusRes === '')
                                        {
                                            echo "<br>Pendiente";
                                        }
                                        elseif($statusRes == '1')
                                        {
                                            echo "<br>Aceptado";
                                        }
                                        else
                                        {
                                            echo "<br>No Aceptado";
                                        }

                                        ?>

                                    </td>


                                    <!-- DICTAMEN DEL ARTICULO -->
                                    <td>

                                        <?php

                                        /*
                                            Nuevo flujo solicitado:

                                            únicamente:
                                            - Aceptado
                                            - No Aceptado

                                            Mientras no exista dictamen:
                                            - Pendiente

                                            Ya no existe Segunda Revisión.
                                        */

                                        if($dictamenArticulo === null || $dictamenArticulo === '')
                                        {
                                            echo "Pendiente";
                                        }
                                        elseif($dictamenArticulo == '1')
                                        {
                                            echo "Aceptado";
                                        }
                                        else
                                        {
                                            echo "No Aceptado";
                                        }

                                        ?>

                                    </td>


                                    <!-- PUBLICADO -->
                                    <td>

                                        <?php

                                        if($publicado == '1')
                                        {
                                            echo "<br>Sí";
                                        }
                                        else
                                        {
                                            echo "<br>No";
                                        }

                                        ?>

                                    </td>


                                    <!-- BOTON DETALLES -->
                                    <td>

                                        <a class="btn btn-success"
                                           href="ver_detalle.php?Articulo=<?php echo intval($idArt); ?>">

                                            Detalles
                                        </a>
                                    </td>
                                </tr>
                            <?php
                                }

                            }
                            else
                            {

                            ?>
                                <tr>
                                    <td colspan="6">
                                        No existen artículos registrados.
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <div align="right">
                            <a href="./detalles_excel.php"
                               class="btn btn-primary">
                                Descargar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php

}
catch(PDOException $e)
{

    echo "<div class='container-fluid'>";
    echo "<div class='alert alert-danger'>";
    echo "Error al consultar los artículos: "
        . htmlspecialchars(
            $e->getMessage(),
            ENT_QUOTES,
            'UTF-8'
        );

    echo "</div>";
    echo "</div>";

}

?>


    <!-- PIE DE PAGINA -->

    <br>
    <br>

    <div class="contactos">

        <table>
            <tr>
                <td>
                    <a href="https://www.facebook.com/pages/Instituto-Tecnol%C3%B3gico-Superior-de-Lerdo-P%C3%A1gina-Oficial/285056498195463">
                        <img src="../img/face.jpg" />
                    </a>
                </td>
                <td>
                    <a href="https://twitter.com/ITSLerdo">
                        <img src="../img/tw.jpg" />
                    </a>
                </td>
                <td>
                    <a>
                        <img src="../img/correoitsl.gif" />
                    </a>
                </td>
            </tr>
        </table>
    </div>


    <div class="pie_pagina">
        <img src="../img/pie_pagina.jpg" />
        <p>
            Av. Tecnológico N 1555 Sur Periferico Gomez Lerdo Km. 14.5
            <br>
            C.P. 35150 Cd. Lerdo, Dgo
            <br>
            Tels. 01 (871) 725 23 71, 725 57 79, 725 58 02
        </p>

    </div>


    <script type="text/javascript"
            src="../js/funciones/articulo.js">
    </script>

</body>

</html>