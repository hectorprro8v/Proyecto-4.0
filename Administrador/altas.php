<?php
	session_start();
    include("registro.php");
    if($_SESSION["id"]=="")
    {
        header("Location: ../index.php");
    }
    include("../verificacion.php");
    Nolink();
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/bootstrap.css">
        <link href="../css/index/indexstyle.css" rel="stylesheet" media="screen">
        <link href="../css/index/menu.css" rel="stylesheet" media="screen">
        <link href="../css/index/estilos.css" rel="stylesheet" media="screen">
        <link href="../css/index/navbar-fixed-left.min.css" rel="stylesheet">
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        
 
	<!-- JavaScript -->
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>

        <!-- CSS -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css"/>
        <!-- Semantic UI theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/semantic.min.css"/>
       
        
        <title>REGISTRO - CID TEC LERDO</title>
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
                        <h2>SISTEMA DE REGISTRO DE USUARIOS</h2>
                        <hr>
                        <div class="container-fluid">
                            <div class="panel panel-default">
                                <div class="panel panel-heading" style="background-color: <?=color_revista()?>">
                                </div>
                                <div class="panel-body">                                    
                                    <div class="panel panel-default col-md-4 col-md-offset-4" id="sombra"> 
                                        <br>
                                        <form id="registro" class="form formitic" method="post"> 
                                             <label><span class="glyphicon glyphicon-user"></span>  NOMBRE DE USUARIO</label>
                                            <input class="form-control "  placeholder="Ingresa nombre de usuario" type="text" name="usuario_reg" required>
                                            <br>

                                            <label><span class="glyphicon glyphicon-envelope"></span>  CORREO ELECTRÓNICO</label>
                                             <input class="form-control" placeholder="ingresa Correo Electronico" type="email"  name="email_reg" required>
                                             <br>

                                             <strong>TIPO DE USUARIO</strong>
                                             <select class="form-control " style="width: 150" name="Tipo_Usuario" required>
                                                 <option value = '' style="display: none">Elige un usuario</option>

                                                 <option value='A'>Administrador</option>
                                                 <option value='E'>Comité Editorial</option>
                                                 <option value='F'>Financiero</option>
                                                 
                                             </select>
                                             <br>
                                            <button class="btn btn-info form-control inpbtm" name="registrarse" type="submit">REGISTRAR</button>
                                            <br><br>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                 </div>
             </div>
	<div class="modal fade" tabindex=”-1″ id="cargando" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="panel-heading" style="color:black">
                        <h2>Procesando... Porfavor Espere.</h2>
                        <div id="bar" class="progress" style="hight: 30px;">
                            <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                                <h4 id="por"></h4>
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
        <div class="pie_pagina img-responsive">   
            <img src="../img/pie_pagina.jpg"/>
            <p>Av. Tecnológico N 1555 Sur Periferico Gomez Lerdo Km. 14.5
                <br/>C.P. 35150 Cd. Lerdo, Dgo
                <br/>Tels. 01 (871) 725 23 71, 725 57 79, 725 58 02
            </p>
        </div>
    </body>
</html>
<script>        
         $(document).on('submit', '#registro', function() {
             $('#cargando').modal('show');
              var elem = document.getElementById("bar");   
              var porcent=document.getElementById("por");
              var width = 1;
              var id = setInterval(frame, 100);
              function frame() {
                if (width >= 100) 
                {
                 
//                 window.location.href='altas.php';
                  clearInterval(id);
                  
                } 
                  else 
                  {
                  width++; 
                  document.getElementById("por").innerHTML=width +'%';
                  elem.style.width = width + '%'; 
                 
                }
              }
        });
          
</script>
<?php
    if($_SESSION['mensaje'] != "")
    { ?>
        <script>
            alertify.set('notifier','position', 'top-right');
            <?=$_SESSION['mensaje'];$_SESSION['mensaje']="";?>;
        </script>
<?php } ?>