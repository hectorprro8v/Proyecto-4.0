<?php 
session_start();
include_once 'usuario.php';
//$idArticulo = $_GET['arti'];
$idArticulo = $_GET['idArt'];
include_once("mostrar_criterios.php");
    //Nolink();
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

    <title>ARTÍCULOS - CID TEC LERDO</title>
</head>

<body>
    <!--cabecera de página-->
    <br />
    <!--fin de cabecera de página-->
    <!--logotipos de dependencias-->
    <div class="logos">
        <img class="imagenlogo" src="../img/header_portal_vigente_1170.png" />
    </div>
    <!--fin de logotipos de dependencias-->
    <!--Menu-->
    <br>
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-left" role="navigation">
            <div class="navbar-header">
                <button type="button" style="color:red;" class="navbar-toggle" data-toggle="collapse"
                    data-target=".navbar-ex1-collapse">
                    <img src=../img/menu.png>
                </button>
                <a class="navbar-brand Active" href="index.php" style="margin-left:15px;">SICSACID</a>
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
                    <li class="" style="margin-left:20px"><a href="resumenes.php">Resumen </a></li>
                    <li class="" style="margin-left:20px"><a href="articulos.php">Artículos</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="margin-left:20px"> Documentos
                            <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="divider"></li>
                            <li class=""><a href="generar_ficha.php">Generar Ficha de Pago</a></li>
                            <li class=""><a href="fichas_de_pago.php">Recibos y Comprobantes</a></li>
                            <li class="divider"></li>
                            <li class=""><a href="subir_documentos.php">Subir Documentos</a></li>
                            <li class="divider"></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- FIN DEL MENU-->
    <!--INICIA FORMULARIO REVISION-->
    <div class="text-center">
        <h1>Comentarios</h1>
        <br>
        <h3>Criterios evaluados</3>
            <br>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-11">
                <div class="table-responsive">
                    <table id="tabla" class="table" style="text-align: center">
                        <thead>
                            <tr style="background-color: black; color: white;">
                                <th>Criterios</th>
                                <?php
                                $cantRev = 0;
                                $concaObs = "";
                                foreach($resultRev as $col)
                                {
                                    $idExRev = $col[0];
                                    $NombreRev = $col[1];
                            ?>
                                <th><?php echo 'Click para ver Comentarios';?></th>
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
                                            title="VER"></span>
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
                                            title="VER"></span>
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
                                            title="VER"></span>
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
                                            title="VER"></span>
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
                <?php 

                        foreach($resultObsMod as $fila)
                        {
                            $idArticulo = $fila[0];
                            $clave_articulo=$fila[1];
                            $titulo_ext=$fila[2];
                            $modificaciones = $fila[3];
                            $observaciones = $fila[4];
                            $Obscri = $fila[5];
                                
                    ?>
              <!--  <form action="subirSegundoExt.php" method="post" enctype="multipart/form-data"> -->
                <div class="form-group">

                    <!--crit-->
                    <label for="">Observaciones sobre los criterios:</label>
                    <textarea name="criterios" id="cri" style="width: 100%;" class="form-control" rows="10" required
                        readonly><?php echo $Obscri;?> 
                        </textarea>
                    <br>
                    <!--mod-->
                    <label for="">Modificaciones</label>
                    <textarea name="modificacion" id="m" style="width: 100%;" class="form-control" rows="10" required
                        readonly><?php echo $modificaciones;?>
                        </textarea>
                    <br>
                    <!--obs-->
                    <label for="">Observaciones</label>
                    <textarea name="observacion" id="o" style="width: 100%;" class="form-control" rows="10" required
                        readonly><?php echo $observaciones;?>
                        </textarea>
                    <br>
                </div>
                <br>
                <a type="button" class="btn btn-info btn-md" data-toggle="modal" 
                data-target="#extenso" style="top: 50%">Subir extenso</a>
                <!--
                    <label>Subir Segundo Extenso</label><br>
                    <input type="file" name="archivo" id="archivo">
                    <br>
                    <button id="subir" name="subir" type="submit" class="btn btn-primary"
                        value=< echo $idArticulo;?>>Enviar</button>
                </form>-->
                <?php } ?>
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

    <form action="subirSegundoExt.php" method="post" enctype="multipart/form-data" name="subeextenso">
        <!--MODAL ENVIAR EXTENSO-->
            <div class="modal fade" id="extenso" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h3 class="modal-title">
                          <input name="clave_articulo" value="<?php echo $clave_articulo?>" hidden>
                          <input name="titulo_articulo" value="<?php echo $titulo_ext?>" hidden>
                          <h3><?php echo $clave_articulo.": ".$titulo_ext ?></h3>
                        </h3>
                    </div>
                    <div class="modal-body">
                        <p>El archivo debe ser en formato .docx (documento de word).</p>
                        <div class="container-fluid">
                                <label>Subir Extenso </label>
                                <input type="file" name="archivo" class="form-control">
                        </div>
                        <br>
                        <div class="container-fluid">
                                <label>Subir extenso sin autores </label>
                                <input type="file" name="archivoSA" class="form-control">
                        </div>
                                         
                        <div class="form-group">
                        <input type="checkbox" name="cbox" id="cbox"> 
                            <label> SOMETER A REVISIÓN (Seleccionar esta opción para completar el envío)</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row container-fluid">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary btn-block" type="submit" name="subir">Subir</button>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
            <!--MODAL ENVIAR EXTENSO-->
        </form>



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