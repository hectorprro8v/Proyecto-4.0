<?php 
include("usuario.php");
session_start();
    if($_SESSION["id"]=="")
    {
        header("Location: ../index.php");
    }

?>
<!DOCTYPE html>
<html>
    <head runat="server">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        
        <link href="../css/index/indexstyle.css" rel="stylesheet" media="screen">
        <link href="../css/index/menu.css" rel="stylesheet" media="screen">
        <link href="../css/index/estilos.css" rel="stylesheet" media="screen">
        <link href="../css/index/navbar-fixed-left.min.css" rel="stylesheet">
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery-3.2.1.min.js"></script>
        
        <!--ALERTAS-->
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
        <!-- CSS -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css"/>
        <!--ALERTAS-->
        
        <title>CID TEC LERDO - EDITAR PERFIL</title>
    </head>
    <body>
        <!--AQUÍ VA EL MENU-->
        <br>
         <div class="container">
            <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-left" role="navigation">
                <div class="navbar-header">
                    <button type="button" style="color:red;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse" >
                        <img src=../img/menu.png>
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
                            <button href="#" class="btn btn-info dropdown-toggle" data-toggle="dropdown" type="button" style="margin-left:10px;"><?php echo $_SESSION["nameuser"]?> <b class="caret"></b></button>
                            <ul class="dropdown-menu">
                                <li class=""><a href="perfil_c.php"><span class="glyphicon glyphicon-user"></span> Perfil</a></li>
                                <li class="divider"></li>
                                <li><a href="../destruir_sesion.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
                            </ul>
                        </li>
                        <li class=""><a href="articulos.php">Resumen</a></li>
                        <li class=""><a href="documentos_c.php">Documentos</a></li>
                        <li class=""><a href="ExcelDocumentos.php">Exportar...</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <br>
            <div class="container-fluid">
                <div class="panel panel-default" id="sombra">
                    <div class="panel-body">
                        <h1>EDITAR PERFIL</h1>
                        <hr>
                        <div class="container-fluid">
                            <div class="panel panel-default">
                                <div class="panel panel-heading" style="background-color: <?=color_revista();?>">
                                </div>
                                <div class="panel-body">
                                    <form action="add_perfil.php" method="POST">
                                        <div class="container-fluid col-lg-6">
                                            <div class="form-group">
                                              <h4 for="Nombre_contacto">Nombre(s)</h4>
                                              <input type="text" class="form-control" style="text-align: center;" id="Nombre_contacto" name="nombres" required>
                                            </div>
                                            <div class="form-group">
                                              <h4 for="Apellidop_contacto">Apellido Paterno</h4>
                                              <input type="text" class="form-control" style="text-align: center;" id="Apellidop_contacto" name="apellidop" required>
                                            </div>
                                            <div class="form-group">
                                              <h4 for="Apellidom_contacto">Apellido Materno</h4>
                                              <input type="text" class="form-control" style="text-align: center;" id="Institucion_contacto" name="apellidom" required>
                                            </div>
                                        </div>
                                        <div class="container-fluid col-lg-6">
                                         <div class="form-group container-fluid">
                                          <h4 for="Institucion_contacto">Institución</h4>
                                          <input type="text" class="form-control" style="text-align: center;" id="Institucion_contacto" name="instituto" required>
                                        </div>
                                            <div class="form-group">
                                              <h4 for="Alternativo_contacto">Correo Alternativo</h4>
                                              <input type="email" class="form-control" style="text-align: center;" id="Alternativo_contacto" name="correo_alternativo">
                                            </div>
                                            <div class="form-group">
                                              <h4 for="Telefono_contacto">Teléfono</h4>
                                              <input type="tel" class="form-control" style="text-align: center;" id="Telefono_contacto" name="telefono" required>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group container-fluid">
                                            <button type="submit" class="btn btn-primary btn-lg" name="guardar"><span class="glyphicon glyphicon-floppy-saved btn-md" ></span> Guardar y continuar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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