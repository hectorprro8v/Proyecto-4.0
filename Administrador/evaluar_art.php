<?php
session_start();
include_once 'usuario.php';

$idArticulo = $_GET['arti'];
include_once("mostrar_criterios.php");
   
    if($_SESSION["id"]=="")
    {
        header("Location: ../index.php");
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/index/indexstyle.css" rel="stylesheet" media="screen">
    <link href="../css/index/menu.css" rel="stylesheet" media="screen">
    <link href="../css/index/estilos.css" rel="stylesheet" media="screen">
    <link href="../css/index/navbar-fixed-left.min.css" rel="stylesheet">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <!--ALERTAS-->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
    <!--ALERTAS-->

    <title>Evaluacion(ADMIN) - CID TEC LERDO</title>
</head>

<body>
    <!--cabecera de página-->
    <br />
    <!--fin de cabecera de página-->
    <!--logotipos de dependencias-->
    <div class="logos img-responsive">
        <img class="imagenlogo" src="../img/header_portal_vigente_1170.png" />
    </div>
    <!--fin de logotipos de dependencias-->
    <!--CUERPO DE LA PÁGINA-->
    <!--Menu-->
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
                            <li class=""><a href="perfil.php"><span class="glyphicon glyphicon-user"></span> Perfil</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="../destruir_sesion.php"><span class="glyphicon glyphicon-log-out"></span>
                                    Salir</a></li>
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
    <!-- FIN DEL MENU-->
    <!--INICIA FORMULARIO REVISION-->
    <div class="text-center">
        <h1>Resultados de la evaluación</h1>
        <br>
        <h3>Criterios a evaluar</3>
            <br>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table id="tabla" class="table" style="text-align: center">
                        <thead>
                            <tr style="background-color: black; color: white;">
                                <th>Criterios/Revisores</th>
                                <?php
                                $cantRev = 0;
                                $concaObs = "";
                                foreach($resultRev as $col)
                                {
                                    $idExRev = $col[0];
                                    $NombreRev = $col[1];
                            ?>
                                <th><?php echo $NombreRev;?></th>
                                <?php
                                $cantRev++;
                                }
                            ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sepCrit = 0;
                                $critAc = 0;
                                $todasObs = "";
                                foreach($resultExRev as $filaER)
                                {
                                    $idCriterio = $filaER[0];
                                    $idER = $filaER[1];
                                    $ObsCrit = $filaER[2];
                                    $Revisor = $filaER[3];
                                    $critDes = $filaER[4];
                                    $estatus = $filaER[5];

                                    //ECHO $filaER[2]."<br>";
                                    //echo " 1 ----------------- <br>";
                                    //echo $idCriterio." ".$ObsCrit."<br>";
                                    //echo " 2 ----------------- <br>";

                                    if($critAc != $idCriterio)
                                    {
                                        ?>

                            <tr>
                                <th><?php echo $critDes; ?></th>
                                <?php
                                        $critAc = $idCriterio;
                                        $todasObs = $todasObs."\n".$critDes.": \n".$ObsCrit;
                                    }
                                    else
                                    {
                                        $todasObs = $todasObs."\n".$ObsCrit;
                                    }

                                    if($sepCrit < $cantRev)
                                    {
                                        $sepCrit++;
                                        if ($estatus == 1)
                                        {
                                        ?>
                                <td><button type="button" class="btn btn-default" data-toggle="modal"
                                        data-target=<?php echo "#ModalComentario".$idCriterio."-".$idER;?>
                                        id=<?php echo "btnComentario-".$idArticulo."-".$idER;?>>
                                        <span class="glyphicon glyphicon-ok text-success"
                                            title="Clic para ver Observaciones"></span>
                                    </button></td>
                                <?php
                                        }
                                        else
                                        {
                                            ?>
                                <td><button type="button" class="btn btn-default" data-toggle="modal"
                                        data-target=<?php echo "#ModalComentario".$idCriterio."-".$idER;?>
                                        id=<?php echo "btnComentario-".$idArticulo."-".$idER;?>>
                                        <span class="glyphicon glyphicon-remove text-danger"
                                            title="Clic para ver Observaciones"></span>
                                    </button></td>
                                <?php
                                        }
                                    }
                                    else
                                    {
                                        $sepCrit = 0;
                                        if ($estatus == 1)
                                        {
                                        ?>
                                <td><button type="button" class="btn btn-default" data-toggle="modal"
                                        data-target=<?php echo "#ModalComentario".$idCriterio."-".$idER;?>
                                        id=<?php echo "btnComentario-".$idArticulo."-".$idER;?>>
                                        <span class="glyphicon glyphicon-ok text-success"
                                            title="Clic para ver Observaciones"></span>
                                    </button></td>
                                <?php
                                        }
                                        else
                                        {
                                            ?>
                                <td><button type="button" class="btn btn-default" data-toggle="modal"
                                        data-target=<?php echo "#ModalComentario".$idCriterio."-".$idER;?>
                                        id=<?php echo "btnComentario-".$idArticulo."-".$idER;?>>
                                        <span class="glyphicon glyphicon-remove text-danger"
                                            title="Clic para ver Observaciones"></span>
                                    </button></td>
                                <?php
                                        }
                                    }
                                    ?>
                                <!--MODAL PARA MOSTRAR EL COMENTARIO POR REVISOR-->
                                <div class="modal fade" id=<?php echo "ModalComentario".$idCriterio."-".$idER;?>
                                    tabindex="-1" role="dialog" aria-labelledby="ModalComentario" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="tituloModalComentario">Comentario del
                                                    revisor:</h5>
                                            </div>
                                            <div class="modal-body">
                                                <?php echo $idCriterio." ".$ObsCrit;?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary"
                                                    data-dismiss="modal">Aceptar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!------------------------------------------------>
                                <?php
                                }
                           ?>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <form id="form2" action="dictamen_art.php" method="POST">
                    <?php

                        foreach($resultObsMod as $fila)
                        {
                            $idArticulo = $fila[0];
                            $idER = $fila[1];
                            $Nombres = $fila[2];
                            $modificaciones = $fila[3];
                            $observaciones = $fila[4];
                            $Aceptado = $fila[5];
                        }

                    ?>
                    <div class="form-group">
                        <!--crit-->
                        <label for="">Observaciones sobre los criterios:</label>
                        <textarea name="criterios" id="cri" style="width: 100%;" class="form-control" rows="10"
                            required><?php echo $todasObs;?>
                        </textarea>
                        <br>
                        <!--mod-->
                        <label for="">Modificación</label>
                        <textarea name="modificacion" id="m" style="width: 100%;" class="form-control" rows="10"
                            required><?php echo $modificaciones;?>
                        </textarea>
                        <br>
                        <!--obs-->
                        <label for="">Observaciones</label>
                        <textarea name="observacion" id="o" style="width: 100%;" class="form-control" rows="10"
                            required><?php echo $observaciones;?>
                        </textarea>
                        <br>
                    </div>
                    <br>
                    <label>Dictamen</label><br>
                    <select name="opciones" class="form-control" required style="width: 30%">
                        <option value='' style="display: none">Elija una opción</option>
                        <option value="1">Aceptado</option>
                        <option value="2">No Aceptado</option>
                        <option value="3">Segunda Revisión</option>
                    </select>
                    <br>
                    <button id="c" name="env" type="submit" class="btn btn-primary"
                        value=<?php echo $idArticulo;?>>Enviar</button>
                    <?php  ?>


                </form>
            </div>
        </div>
    </div>
    <!--TERMINA FORMULARIO-->
    <!--INICA EL PIÉ DE PÁGINA-->
    <div class="lineasep"><img src="../img/line.gif" /></div>
    <div class="contactos">
        <table>
            <tr>
                <td><a
                        href="https://www.facebook.com/pages/Instituto-Tecnol%C3%B3gico-Superior-de-Lerdo-P%C3%A1gina-Oficial/285056498195463"><img
                            src="../img/face.jpg" /></a></td>
                <td><a
                        href="https://twitter.com/ITSLerdo?ref_src=twsrc%5Etfw&ref_url=http%3A%2F%2Fwww.itslerdo.edu.mx%2F"><img
                            src="../img/tw.jpg" /></a></td>
                <td><a><img src="../img/correoitsl.gif" /></a></td>
            </tr>
        </table>
    </div>
    <!-- Pie de página-->
    <div class="pie_pagina">
        <img src="../img/pie_pagina.jpg" />
        <p>Av. Tecnológico N 1555 Sur Periferico Gomez Lerdo Km. 14.5
            <br />C.P. 35150 Cd. Lerdo, Dgo
            <br />Tels. 01 (871) 725 23 71, 725 57 79, 725 58 02
        </p>
    </div>
</body>

</html>

<?php
    if(isset($_SESSION['mensaje']))
    { ?>
<script type="text/javascript">
alertify.set('notifier', 'position', 'top-right');
<?=$_SESSION['mensaje'];
                $_SESSION["mensaje"]=null;
            ?>;
</script>
<?php } ?>
