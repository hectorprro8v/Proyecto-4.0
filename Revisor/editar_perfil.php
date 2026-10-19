<?php 
include("usuario.php");
            session_start();
    if($_SESSION["id"]=="")
    {
        header("Location: ../index.php");
    }
 $idUsuario = $_SESSION["id"];
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
        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <script src="../js/jquery-3.2.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        
        <title>EDITAR PERFIL - CID TEC LERDO</title>
    </head>
    <body>
        <br>
        <!--CUERPO DE LA PÁGINA-->
        <!--Menu-->
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
                            <button href="#" class="btn btn-info dropdown-toggle" data-toggle="dropdown" type="button"><?php echo $_SESSION["nameuser"]?> <b class="caret"></b></button>
                            <ul class="dropdown-menu">
                                <li class=""><a href="perfil.php"><span class="glyphicon glyphicon-user"></span> Perfil</a></li>
                                <li class="divider"></li>
                                <li><a href="../destruir_sesion.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
                            </ul>
                        </li>
                        <li class=""><a href="linea_in.php">Líneas de investigación</a></li>
                        <li class=""><a href="documentos.php">Documentos</a></li>
                        <li class=""><a href="articulos.php">Artículos</a></li>
                    </ul>
                </div>
            </nav>
        </div>
           
            <!--CUERPO DE LA PÁGINA-->
            <!--SECCIÓN1 - PERFIL-->
               <form action="addperfil.php" method="POST">
                <div class="container-fluid">
                   <div class="panel panel-default" id="sombra">
                           <div class="panel-body">
                                <h2>EDITAR PERFIL</h2>
                                <hr>
                                 <div class="container-fluid">
                              <div class="panel panel-heading" style="background-color: <?=color_revista();?>">
                                </div>
                                <!--COLUMNA 1-->
                                    <div class="panel-body" style=" align-content: center;">
                                            <div class="container-fluid col-lg-6">
                                                        <div class="form-group">
                                                            <h4>Nombre(s)</h4>
                                                          <h4 for="Nombre_revisor"><?php $nombres ?></h4>
                                                          <input type="text" class="form-control" style="text-align: center;" name="nombre" placeholder="Nombre(s)" required>
                                                        </div>
                                                    <div class="form-group">
                                                          <h4 for="Apaterno_revisor">Apellido Paterno</h4>
                                                          <input type="text" class="form-control" style="text-align: center;" name="apaterno" placeholder="Apellido paterno" required>
                                                    </div>
                                                    <div class="form-group">
                                                          <h4 for="Amaterno_revisor">Apellido Materno</h4>
                                                          <input type="text" class="form-control" style="text-align: center;" name="amaterno" placeholder="Apellido materno" required>
                                                    </div>
                                            </div>
                                            <div class="container-fluid col-lg-6">
                                                    <div class="form-group">
                                                          <h4 for="Institucion_revisor">Institución o Empresa</h4>
                                                          <input type="text" class="form-control" style="text-align: center;" name="instituto" placeholder="Institucion o Empresa" required>
                                                    </div>
                                                    <div class="form-group">
                                                          <h4 for="Alternativo_revisor">Correo Alternativo</h4>
                                                          <input type="email" class="form-control" style="text-align: center;" name="alternativo" placeholder="Correo alternativo">
                                                    </div>
                                                    <div class="form-group">
                                                          <h4 for="Telefono_contacto">Teléfono</h4>
                                                          <input type="tel" class="form-control" style="text-align: center;" name="tel" placeholder="Teléfono" required>
                                                    </div><br>
                                            </div>
                                                        <center><h4>Perfil (Agrega una breve descripción de tí):</h4></center>
                                                        <textarea name="perfil" class="form-control" rows=7 style="resize:none; width:center;">
                                                        </textarea>
                                                    </div>
                                            </div>
                                    </div>
                              </div>  
                        <center>
                        <div class="container-fluid">
                                <button type="submit" id="btngl" class="btn btn-primary btn-lmd btn-block" style="width: 50em;" name="guardar" value="guardar">Guardar</button><br>
                        </div>
                        </center>    
                    </div>
    </form>
</body>
</html>
<?php
    if(isset($_SESSION['mensaje']))
    { ?>
        <script type="text/javascript">
            alertify.set('notifier','position', 'top-right');
            <?=$_SESSION['mensaje'];
                $_SESSION["mensaje"]=null;
            ?>
        </script>
<?php } ?>
