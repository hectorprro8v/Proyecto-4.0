<?php 
session_start();
include_once 'usuario.php';
include_once("../verificacion.php");
    Nolink();
    if($_SESSION["id"]=="")
    {
        header("Location: ../index.php");
    }

    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css"/>
        <!--ALERTAS-->
        
        <title>PARÁMETROS - CID TEC LERDO</title>
    </head>
    <body>
    <!--cabecera de página-->
        <br/>
        <!--fin de cabecera de página-->
        <!--logotipos de dependencias-->
        <div class="logos img-responsive">
            <img class="imagenlogo" src="../img/header_portal_vigente_1170.png"/>
        </div>
        <!--fin de logotipos de dependencias-->
        <!--CUERPO DE LA PÁGINA-->
        <!--Menu-->
        <br>
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-left" role="navigation">
                <div class="navbar-header">
                    <button type="button" style="color:red;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse" >
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
                            <!-- <button href="#" class="btn btn-info dropdown-toggle" data-toggle="dropdown" type="button" style="margin-left:10px;"><?php echo $_SESSION["nameuser"]?> <b class="caret"></b></button> -->
                            <ul class="dropdown-menu">
                                <li class=""><a href="perfil.php"><span class="glyphicon glyphicon-user"></span> Perfil</a></li>
                                <li class="divider"></li>
                                <li><a href="../destruir_sesion.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
                            </ul>
                        </li> 
                        <li class="dropdown">
                            <a href="#" class="dropdown" data-toggle="dropdown"> Revisores <b class="caret"></b></a>
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
        <!--Menu-->
            <div class="container-fluid">
                <div class="panel panel-default" id="sombra">
                    <div class="panel-body">
                        <h2>PARÁMETROS DE LA REVISTA</h2>
                        <hr>
                        <div class="container-fluid">
                            <div class="panel panel-default">
                                <div class="panel panel-heading" style="background-color: <?=color_revista();?>">
                                </div>
                                <div class="panel-body">
                                        
                                    <div class="container-fluid col-lg-12">
                                        <div class="container-fluid col-lg-12">
                                    <h3>Revista</h3>
                                            <hr>
                                        <div class="form-group">
                                          <h4 for="Nombre_Revista">Nombre</h4>
                                          <input value="<?=$nombreRevista ?>" type="text" class="form-control" style="text-align: center;" id="Nombre_Revista" readonly>
                                        </div>    
                                        </div>
                                    </div>
                                    <div class="container-fluid col-lg-12">
                                        <div class="container-fluid col-lg-2">
                                            <div class="form-group">
                                              <h4 for="Color_Revista">Volumen</h4>
                                              <input value="<?=$volumen?>" type="text" class="form-control" style="text-align: center;" id="Volumen_revista" readonly>
                                            </div>
                                        </div>
                                         <div class="container-fluid col-lg-2">
                                            <div class="form-group">
                                              <h4 for="Institucion_contacto">Numero</h4>
                                              <input value="<?=$numero ?>" type="text" class="form-control" style="text-align: center;" id="numero_Revista"readonly>
                                            </div>
                                        </div>
                                             <div class="container-fluid col-lg-2">
                                                 <div class="form-group">
                                                 <h4 for="Color_Revista">Año</h4>
                                              <input value="<?=$anio?>" type="text" class="form-control" style="text-align: center;" id="anio_revista" readonly>
                                                 </div>
                                            </div>
                                        <div class="container-fluid col-lg-3">
                                            <div class="form-group">
                                              <h4 for="Color_Revista">Consecutivo de artículo</h4>
                                              <input value="<?=$con_Art?>" type="text" class="form-control" style="text-align: center;" id="Consec_revista" readonly>
                                            </div>
                                        </div>
                                        <div class="container-fluid col-lg-3">
                                            <div class="form-group">
                                              <h4 for="Color_Revista">Color</h4>
                                              <input value="<?=$color?>" type="text" class="form-control" style="text-align: center;" id="Color_revista" readonly>
                                            </div>
                                        </div>
                                        </div>
                                    <div class="container-fluid col-lg-12">
                                        <div class="container-fluid col-lg-12">
                                          <h4 for="Nombre_Revista">Link</h4>
                                            <div class="form-group">
                                          <input value="<?=$linkRevista ?>" type="text" class="form-control" style="text-align: center;" id="Nombre_Revista" readonly>
                                        </div>    
                                        </div>
                                    </div>
                                    <div class="container-fluid col-lg-12">
                                        <h3>Registro</h3>
                                        <hr>
                                        <div class="container-fluid row">
                                            <div class="col-xs-12" style="margin-bottom:15px;">
                                                <button type="button" data-toggle="modal" data-target="#modal_agregar_registro" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Agregar Registro</button>
                                            </div>
                                        </div>
                                        <?php if(count($registro_result) > 0){ ?>
                                        <table class="table table-hover">
                                            <thead style="background-color:black; color: white">
                                                <tr>
                                                    <th>Número</th>
                                                    <th>Apertura</th>
                                                    <th>Cierre</th>
                                                    <th>Límite subir extenso</th>
                                                    <th>Límite revisión extenso</th>
                                                    <th>Límite extenso modificado</th>
                                                    <th>Límite carta autorización</th>
                                                    <th>Publicación</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($registro_result as $reg){ ?>
                                                <tr>
                                                    <td><?=$reg['Numero_registro']?></td>
                                                    <td><?=$reg['Apertura_registro']?></td>
                                                    <td><?=$reg['Cierre_registro']?></td>
                                                    <td><?=$reg['Fecha_Limite_subir_Extenso']?></td>
                                                    <td><?=$reg['Fecha_Limite_Revision_Extenso']?></td>
                                                    <td><?=$reg['Fecha_Limite_Extenso_Modificado']?></td>
                                                    <td><?=$reg['Fecha_Limite_Carta_Aut']?></td>
                                                    <td><?=$reg['Dia_publicacion']?>/<?=$reg['Mes_publicacion']?>/<?=$reg['Año_publicacion']?></td>
                                                    <td>
                                                        <a href="#" data-toggle="modal" data-target="#modal_editar_registro_<?=$reg['id_registro']?>" title="Modificar">
                                                            <span class="glyphicon glyphicon-edit" style="color:#337ab7"></span>
                                                        </a>
                                                        &nbsp;
                                                        <a href="#" onclick="if(confirm('¿Seguro que quieres eliminar el registro #<?=$reg['Numero_registro']?>? Esta acción no se puede deshacer.')){document.getElementById('form_eliminar_registro_<?=$reg['id_registro']?>').submit();} return false;" title="Eliminar">
                                                            <span class="glyphicon glyphicon-trash" style="color:red"></span>
                                                        </a>
                                                        <form id="form_eliminar_registro_<?=$reg['id_registro']?>" method="post" action="mod_parametros.php" style="display:none">
                                                            <input type="hidden" name="id_registro" value="<?=$reg['id_registro']?>">
                                                            <input type="hidden" name="eliminarRegistro" value="1">
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php } else { ?>
                                        <p><em>No se ha agregado ningún registro todavía. Usa el botón "Agregar Registro" de arriba.</em></p>
                                        <?php } ?>
                                    </div>
                                    <div class="container-fluid row">
                                                <div class="col-xs-12">
<br>                                                  <button type="button" data-toggle="modal" data-target="#modal_parametros" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-edit"></span> Editar Revista</button>
                                                </div>
                                            </div>
                                    <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        <div class="modal fade" id="modal_parametros" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title">EDITAR REVISTA</h1>
                    </div>
                    <form method="post" action="mod_parametros.php">
                        <div class="modal-body">
                            <div class="container-fluid row">
                                     <div class="container-fluid col-lg-12">
                                        <div class="container-fluid col-lg-12">
                                    <h3>Revista</h3>
                                            <hr>
                                        <div class="form-group">
                                          <h4 for="Nombre_Revista">Nombre</h4>
                                          <input value="<?=$nombreRevista ?>" type="text" class="form-control" style="text-align: center;" name="nombreRevist" >
                                        </div>    
                                        </div>
                                    </div>
                                    <div class="container-fluid col-lg-12">
                                        <div class="container-fluid col-lg-2">
                                            <div class="form-group">
                                              <h4 for="Color_Revista">Volumen</h4>
                                              <input value="<?=$volumen?>" type="text" class="form-control" style="text-align: center;" name="volumen" >
                                            </div>
                                        </div>
                                         <div class="container-fluid col-lg-2">
                                            <div class="form-group">
                                              <h4 for="Institucion_contacto">Numero</h4>
                                              <input value="<?=$numero ?>" type="text" class="form-control" style="text-align: center;" name="numero">
                                            </div>
                                        </div>
                                             <div class="container-fluid col-lg-2">
                                                 <div class="form-group">
                                                 <h4 for="Color_Revista">Año</h4>
                                              <input value="<?=$anio?>" type="text" class="form-control" style="text-align: center;" name="anio" >
                                                 </div>
                                            </div>
                                        <div class="container-fluid col-lg-3">
                                            <div class="form-group">
                                              <h4 for="Color_Revista">Consecutivo articulo</h4> 
                                              <input value="<?=$con_Art ?>" type="text" class="form-control" style="text-align: center;" name="con_Art" >
                                            </div>
                                        </div>
                                        <div class="container-fluid col-lg-3">
                                            <div class="form-group">
                                              <h4 for="Color_Revista">Color</h4>
                                              <input value="<?=$color?>" type="color" class="form-control" style="text-align: center;" name="color" >
                                            </div>
                                        </div>
                                        <div class="container-fluid col-lg-3">
                                        </div>
                                    </div>
                                    <div class="container-fluid col-lg-12">
                                        <div class="container-fluid col-lg-12">
                                          <h4 for="Nombre_Revista">Link</h4>
                                            <div class="form-group">
                                          <input value="<?=$linkRevista ?>" type="text" class="form-control" style="text-align: center;" name="linkRevista">
                                        </div>    
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                            <div class="col-md-2">
<br>
                                <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"> Cancelar</button>
                            </div>
                            <div class="col-md-10">
<br>
                                <button type="submit" name="guardarP" class="btn btn-primary btn-block" style="resize: both"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
                            </div>
                        </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal: agregar un nuevo registro (ciclo de publicación continua) -->
        <div class="modal fade" id="modal_agregar_registro" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title">AGREGAR REGISTRO</h1>
                    </div>
                    <form method="post" action="mod_parametros.php">
                        <div class="modal-body">
                            <div class="container-fluid row">
                                <div class="container-fluid col-lg-4">
                                    <div class="form-group">
                                        <h4>Apertura de registro</h4>
                                        <input value="" type="date" class="form-control" style="text-align: center;" name="aperturaReg" >
                                    </div>
                                    <div class="form-group">
                                        <h4>Cierre de registro</h4>
                                        <input value="" type="date" class="form-control" style="text-align: center;" name="cierreReg" >
                                    </div>
                                </div>
                                <div class="container-fluid col-lg-4">
                                    <div class="form-group">
                                        <h4>Límite subir extenso</h4>
                                        <input value="" type="date" class="form-control" style="text-align: center;" name="limiteSubirExt" >
                                    </div>
                                    <div class="form-group">
                                        <h4>Límite revisión de extenso</h4>
                                        <input value="" type="date" class="form-control" style="text-align: center;" name="limiteRevExt" >
                                    </div>
                                </div>
                                <div class="container-fluid col-lg-4">
                                    <div class="form-group">
                                        <h4>Límite extenso modificado</h4>
                                        <input value="" type="date" class="form-control" style="text-align: center;" name="limiteExtMod" >
                                    </div>
                                    <div class="form-group">
                                        <h4>Límite carta de autorización</h4>
                                        <input value="" type="date" class="form-control" style="text-align: center;" name="limiteCartaAut" >
                                    </div>
                                </div>
                                <div class="container-fluid col-lg-4">
                                    <div class="form-group">
                                        <h4>Día de publicación</h4>
                                        <input value="" type="number" min="1" max="31" class="form-control" style="text-align: center;" name="diaPublicacion" >
                                    </div>
                                </div>
                                <div class="container-fluid col-lg-4">
                                    <div class="form-group">
                                        <h4>Mes de publicación</h4>
                                        <input value="" type="number" min="1" max="12" class="form-control" style="text-align: center;" name="mesPublicacion" >
                                    </div>
                                </div>
                                <div class="container-fluid col-lg-4">
                                    <div class="form-group">
                                        <h4>Año de publicación</h4>
                                        <input value="" type="number" class="form-control" style="text-align: center;" name="anioPublicacion" >
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="col-md-2">
                                    <br>
                                    <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"> Cancelar</button>
                                </div>
                                <div class="col-md-10">
                                    <br>
                                    <button type="submit" name="agregarRegistro" class="btn btn-success btn-block"><span class="glyphicon glyphicon-plus"></span> Agregar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modales: editar cada registro existente, uno por fila -->
        <?php foreach($registro_result as $reg){ ?>
        <div class="modal fade" id="modal_editar_registro_<?=$reg['id_registro']?>" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title">EDITAR REGISTRO #<?=$reg['Numero_registro']?></h1>
                    </div>
                    <form method="post" action="mod_parametros.php">
                        <input type="hidden" name="id_registro" value="<?=$reg['id_registro']?>">
                        <div class="modal-body">
                            <div class="container-fluid row">
                                <div class="container-fluid col-lg-4">
                                    <div class="form-group">
                                        <h4>Apertura de registro</h4>
                                        <input value="<?=$reg['Apertura_registro']?>" type="date" class="form-control" style="text-align: center;" name="aperturaReg" >
                                    </div>
                                    <div class="form-group">
                                        <h4>Cierre de registro</h4>
                                        <input value="<?=$reg['Cierre_registro']?>" type="date" class="form-control" style="text-align: center;" name="cierreReg" >
                                    </div>
                                </div>
                                <div class="container-fluid col-lg-4">
                                    <div class="form-group">
                                        <h4>Límite subir extenso</h4>
                                        <input value="<?=$reg['Fecha_Limite_subir_Extenso']?>" type="date" class="form-control" style="text-align: center;" name="limiteSubirExt" >
                                    </div>
                                    <div class="form-group">
                                        <h4>Límite revisión de extenso</h4>
                                        <input value="<?=$reg['Fecha_Limite_Revision_Extenso']?>" type="date" class="form-control" style="text-align: center;" name="limiteRevExt" >
                                    </div>
                                </div>
                                <div class="container-fluid col-lg-4">
                                    <div class="form-group">
                                        <h4>Límite extenso modificado</h4>
                                        <input value="<?=$reg['Fecha_Limite_Extenso_Modificado']?>" type="date" class="form-control" style="text-align: center;" name="limiteExtMod" >
                                    </div>
                                    <div class="form-group">
                                        <h4>Límite carta de autorización</h4>
                                        <input value="<?=$reg['Fecha_Limite_Carta_Aut']?>" type="date" class="form-control" style="text-align: center;" name="limiteCartaAut" >
                                    </div>
                                </div>
                                <div class="container-fluid col-lg-4">
                                    <div class="form-group">
                                        <h4>Día de publicación</h4>
                                        <input value="<?=$reg['Dia_publicacion']?>" type="number" min="1" max="31" class="form-control" style="text-align: center;" name="diaPublicacion" >
                                    </div>
                                </div>
                                <div class="container-fluid col-lg-4">
                                    <div class="form-group">
                                        <h4>Mes de publicación</h4>
                                        <input value="<?=$reg['Mes_publicacion']?>" type="number" min="1" max="12" class="form-control" style="text-align: center;" name="mesPublicacion" >
                                    </div>
                                </div>
                                <div class="container-fluid col-lg-4">
                                    <div class="form-group">
                                        <h4>Año de publicación</h4>
                                        <input value="<?=$reg['Año_publicacion']?>" type="number" class="form-control" style="text-align: center;" name="anioPublicacion" >
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="col-md-2">
                                    <br>
                                    <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"> Cancelar</button>
                                </div>
                                <div class="col-md-10">
                                    <br>
                                    <button type="submit" name="guardarRegistro" class="btn btn-primary btn-block" style="resize: both"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php } ?>
         <!--INICA EL PIÉ DE PÁGINA-->
        <div class="lineasep"><img src="../img/line.gif"/></div>
        <div class="contactos">
            <table>
                <tr>
                    <td><a href="https://www.facebook.com/pages/Instituto-Tecnol%C3%B3gico-Superior-de-Lerdo-P%C3%A1gina-Oficial/285056498195463"><img 
                    src="../img/face.jpg"/></a></td>
                    <td><a href="https://twitter.com/ITSLerdo?ref_src=twsrc%5Etfw&ref_url=http%3A%2F%2Fwww.itslerdo.edu.mx%2F"><img src="../img/tw.jpg"/></a></td>
                    <td><a><img src="../img/correoitsl.gif"/></a></td>
                </tr>
            </table>
        </div>
        <!-- Pie de página-->
        <div class="pie_pagina">   
            <img src="../img/pie_pagina.jpg"/>
            <p>Av. Tecnológico N 1555 Sur Periferico Gomez Lerdo Km. 14.5
                <br/>C.P. 35150 Cd. Lerdo, Dgo
                <br/>Tels. 01 (871) 725 23 71, 725 57 79, 725 58 02
            </p>
        </div>
    </body>
</html>

<?php
    if(isset($_SESSION['mensaje']))
    { ?>
        <script type="text/javascript">
            alertify.set('notifier','position', 'top-right');
            <?=$_SESSION['mensaje'];
                $_SESSION["mensaje"]=null;
            ?>;
        </script>
<?php } ?>