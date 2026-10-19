<?php
    include("usuario.php");
    $_SESSION["nameuser"]=$nombres." ".$apellidop." ";
    session_start();
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
        <title>INICIO - CID TEC LERDO</title>
    </head>
    <body>
    <!--cabecera de página-->
        <br/>
        <!--fin de cabecera de página-->
        <!--logotipos de dependencias-->
        <div class="logos">
            <img class="imagenlogo" src="../img/header_portal_vigente_1170.png">
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
                        <li class=""><a href="facturacion.php"><span class="glyphicon glyphicon-list-alt"></span> Facturación</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                    </ul>
                </div>
            </nav>
        </div>
        <!--Menu-->
        <!--SECCIÓN1 - PERFIL-->
            <div class="container-fluid">
                <div class="panel panel-default" id="sombra">
                    <div class="panel-body">
                        <h2><?php echo $nombres." ".$apellidop." ".$apellidom?></h2>
                        <hr>
                        <div class="container-fluid">
                            <div class="panel panel-default">
                                <div class="panel panel-heading" style="background-color: <?=color_revista();?>">
                                </div>
                                <div class="panel-body">
                                    <div class="container-fluid">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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