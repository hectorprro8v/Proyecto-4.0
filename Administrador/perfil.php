<?php 
include("usuario.php");
session_start();
include("../verificacion.php");
    Nolink();
    if($_SESSION["id"]=="")
    {
        header("Location: ../index.php");
    }
?>
<!DOCTYPE html>
<html>
    <head runat="server">
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
        
        <title>PERFIL - CID TEC LERDO</title>
    </head>
    <body>
        <!--cabecera de página-->
        <br/>
        <!--fin de cabecera de página-->
        <!--logotipos de dependencias-->
        <div class="logos">
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
                            <button href="#" class="btn btn-info dropdown-toggle" data-toggle="dropdown" type="button" style="margin-left:10px;"><?php echo $_SESSION["nameuser"]?> <b class="caret"></b></button>
                            <ul class="dropdown-menu">
                                <li class=""><a href="perfil.php"><span class="glyphicon glyphicon-user"></span> Perfil</a></li>
                                <li class="divider"></li>
                                <li><a href="../destruir_sesion.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
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
        <!--SECCIÓN1 - PERFIL-->
            <div class="container-fluid">
                <div class="panel panel-default" id="sombra">
                    <div class="panel-body">
                        <h2>PERFIL</h2>
                        <hr>
                        <div class="container-fluid">
                            <div class="panel panel-default">
                                <div class="panel panel-heading" style="background-color: <?=color_revista();?>">
                                </div>
                                <div class="panel-body">
                                    <div class="container-fluid col-lg-6">
                                        <div class="form-group">
                                          <h4 for="Nombre_contacto">Nombre(s)</h4>
                                          <input value="<?= $nombres ?>" type="text" class="form-control" style="text-align: center;" id="Nombre_contacto" readonly>
                                        </div>
                                        <div class="form-group">
                                          <h4 for="Apellidos_contacto">Apellidos</h4>
                                          <input value="<?php echo $apellidop." ".$apellidom ?>" type="text" class="form-control" style="text-align: center;" id="Apellidos_contacto" readonly>
                                        </div>
                                        <div class="form-group">
                                          <h4 for="Institucion_contacto">Institución</h4>
                                          <input value="<?php echo $institucion ?>" type="text" class="form-control" style="text-align: center;" id="Institucion_contacto"readonly>
                                        </div>
                                    </div>
                                    <div class="container-fluid col-lg-6">
                                        <div class="form-group">
                                          <h4 for="Correo_contacto">Correo Electrónico</h4>
                                          <input value="<?php echo $correo_electronico ?>" type="email" class="form-control" style="text-align: center;" id="Correo_contacto" placeholder="Correo@correo.com" readonly>
                                        </div>
                                        <div class="form-group">
                                          <h4 for="Alternativo_contacto">Correo Alternativo</h4>
                                          <input value="<?php echo $correo_alternativo ?>" type="email" class="form-control" style="text-align: center;" id="Alternativo_contacto" placeholder="Alternativo@correo.com" readonly>
                                        </div>
                                        <div class="form-group">
                                          <h4 for="Telefono_contacto">Teléfono</h4>
                                          <input value="<?php echo $telefono ?>" type="tel" class="form-control" style="text-align: center;" id="Telefono_contacto" placeholder="##########" readonly>
                                        </div>
                                    </div>
                                    <div class="container-fluid row">
                                         <div class="form-group col-md-6">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <button type="button" data-toggle="modal" data-target="#login" class="btn btn-warning btn-md ml-auto"><span class="glyphicon glyphicon-edit"></span> Cambiar Contraseña</button>
                                                </div>
                                                <div class="col-xs-6">
                                                    <button type="button" data-toggle="modal" data-target="#modal_perfil" class="btn btn-primary btn-md ml-auto"><span class="glyphicon glyphicon-edit"></span> Editar Perfil</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!--SECCIÓN1 - PERFIL-->
        <!--SECCIÓN2 - MODALES-->
        <!-- Modal LOGIN-->
        <div class="modal fade" id="login" role="dialog">
            <div class="modal-dialog">
            <!-- Contenido del modal-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h1 class="modal-title">Cambiar Contraseña</h1>
                    </div>
                    <form role="form" action="mod_contra.php" method="post">
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="form-group">
                                    <h4>Nueva Contraseña</h4>
                                    <input type="password" class="form-control" style="text-align: center" name="contra">
                                </div>
                                <div class="form-group">
                                    <h4>Repite la Contraseña</h4>
                                    <input type="password" class="form-control" style="text-align: center" name="repite_contra">
                                </div>
                                <p>Deberás iniciar sesión una vez que cambies los datos de inicio de sesión.</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-md-3">
                                <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Cancelar</button>
                            </div>
                            <div class="col-md-9">
                                <button type="submit" name="guardar" class="btn btn-primary  btn-md ml-auto"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal LOGIN-->
        <!-- Modal PERIL-->
        <div class="modal fade" id="modal_perfil" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title">EDITAR PERFIL</h1>
                    </div>
                    <form method="post" action="mod_perfil.php">
                        <div class="modal-body">
                            <div class="container-fluid row">
                                <div class="col-md-6 container-fluid">
                                    <div class="form-group">
                                      <h4 for="Nombre_contacto">Nombre(s)</h4>
                                      <input value="<?php echo $nombres ?>" type="text" class="form-control" style="text-align: center;" name="nombres">
                                    </div>
                                    <div class="form-group">
                                      <h4 for="ApellidoP_contacto">Apellidos Paterno</h4>
                                      <input value="<?php echo $apellidop ?>" type="text" class="form-control" style="text-align: center;" name="apellidop">
                                    </div>
                                    <div class="form-group">
                                      <h4 for="ApellidosM_contacto">Apellidos Materno</h4>
                                      <input value="<?php echo $apellidom ?>" type="text" class="form-control" style="text-align: center;" name="apellidom">
                                    </div>
                                </div>
                                <div class="col-md-6 container-fluid">
                                    <div class="form-group">
                                      <h4 for="Correo_contacto">Correo Electrónico</h4>
                                      <input value="<?php echo $correo_electronico ?>" type="email" class="form-control" style="text-align: center;" name="correo">
                                    </div>
                                    <div class="form-group">
                                      <h4 for="Alternativo_contacto">Correo Alternativo</h4>
                                      <input value="<?php echo $correo_alternativo ?>" type="email" class="form-control" style="text-align: center;" name="correo_alternativo">
                                    </div>
                                    <div class="form-group">
                                      <h4 for="Telefono_contacto">Teléfono</h4>
                                      <input value="<?php echo $telefono ?>" type="tel" class="form-control" style="text-align: center;" name="telefono">
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid">
                                <h4 for="Institucion_contacto">Institución</h4>
                                <input value="<?php echo $institucion ?>" type="text" class="form-control" style="text-align: center;" name="instituto">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger  btn-md ml-auto" data-dismiss="modal"> Cancelar</button>
                            </div>
                            <div class="col-md-10">
                                <button type="submit" name="guardar" class="btn btn-primary btn-md ml-auto" style="resize: both"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal EDITA PERFIL-->
        <!--SECCIÓN2 - MODALES-->
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