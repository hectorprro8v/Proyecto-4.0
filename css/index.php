<?php
    session_start();

    error_reporting(E_ALL ^ E_NOTICE);
?>
<!DOCTYPE html>
<html>
    <head runat="server">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="css/index/indexstyle.css" rel="stylesheet" media="screen">
        <link href="css/index/menu.css" rel="stylesheet" media="screen">
        <link href="css/index/estilos.css" rel="stylesheet" media="screen">
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery-3.2.1.min.js"></script>
        <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="css/ionicons/css/ionicons.min.css" rel="stylesheet">


 
        <!--ALERTAS-->
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
        <!-- CSS -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css"/>
        <!--ALERTAS-->
        
        <title>CID TEC LERDO - INICIO DE SESIÓN</title>
    </head>
    <body>
        <br>
        <!--logotipos de dependencias-->
        <div class="logos">
            <img class="imagenlogo" src="img/BannerCIDTEC.jpg" style="border-radius: 50px;">
        </div>
        <!--fin de logotipos de dependencias-->
        <div class="container">
            <div class="modal-dialog">
                <form method="post" action="sesion.php">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header" style="padding: 35px; background-color: black; ">
                        <tr><td><img  align='right' src='http://www.itslerdo.edu.mx/images/descargas/institucion/logo_tec/logo_oficial_tec_lerdo_nov2017_transparente.png' width='20%'> <div align='center'><h1 style="color: white; margin-top: 30px">SICSACID TEC LERDO</h1></div></td> </tr>
                        
                        </div>
                        <div class="modal-body">
                            <div style="padding-top: 50px; padding-left: 100px; padding-right: 100px;">
                                <div class="form-group">
                                    <label><span class="glyphicon glyphicon-user"></span> Correo electrónico</label>
                                    <input style="text-align: left" type="email" class="form-control" name="correo" placeholder="Ingresa tu correo">
                                </div>
                                <div class="form-group">
                                    <label><span class="glyphicon glyphicon-eye-open"></span> Contraseña</label>
                                    <input style="text-align: left" type="password" class="form-control" name="contrasena" placeholder="Ingresa tu contraseña">
                                </div>
                                
                                <label><span class="glyphicon glyphicon-user"></span> Tipo de usuario</label>
                                             <select class="form-control " style="width: 150" name="Tipo_Usuario" required>
                                                 <option value = '' style="display: none">Elige un usuario</option>

                                                 <option value='A'>Administrador</option>
                                                 <option value='C'>Autor/Contacto</option>
                                                 <option value='R'>Revisor</option>
                                                 <option value='E'>Comité Editorial</option>
                                                 <option value='F'>Financiero</option>
                                             </select>
                                <br>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Entrar</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <p>Descarga la convocatoria <a href="Documentos/Otros/Poster.png" target="_blank">aquí</a></p>
                            <p>Manual de registro, descargar <a href="Documentos/Otros/Manual_usuarioAC.pdf" target="_blank">aquí</a></p>
                            <p>¿No tienes una cuenta? <a href="registro.php">Registrate</a></p>
                            <p>¿Olvidaste tu <a href="recupera.php">Contraseña?</a></p>
                            <div align="left">
                            <a  type="button" class="btn" data-toggle="modal" data-target="#acerca"><span class="glyphicon glyphicon-question-sign"></span> Acerca de</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="container">
       <div class="modal fade" id="acerca" role="dialog">
            <div class="modal-dialog modal-lg">
            <!-- Contenido del modal-->
                <div class="modal-content">
                    <div class="section-header ">
                        <div><button style="padding-right: 25px;" type="button" class="close " data-dismiss="modal">&times;</button></div>
                        <h3 style="padding-left: 25px;"  class="section-title">Acerca de</h3>
                        <span class="section-divider"></span>
                    
                    </div> 
                    <div class="modal-body">
                        <section id="acercade">
                            <fieldset style="width: 860px">
                                <legend>ENCARGADOS DE LA REVISTA</legend>
                                   <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                               <center> <div class="icon" ><i class=""></i></div>
                                                <h4 class="title"> Ing. César Ríos Marmolejo</h4>
                                                <span>Editor responsable</span>
                                                 <div class="social">
                                                <a href=""><i class="fa fa-envelope"> posgrado@itslerdo.edu.mx</i></a>
                                                </div>
                                                </center>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6"> 
                                                <center>  <div class="icon"><i class=""></i></div>
                                            <h4 class="title">Ing. Karla Veronica Rodríguez Lozano</h4>
                                              <span>Supervisor editorial</span>
                                            <div class="social">
                                                <a href=""><i class="fa fa-envelope"> karla.rl@itslerdo.edu.mx</i></a>
                                          </div> </center>
                                        </div>
                                </div>
                                </fieldset>
                            <br><br>
<fieldset style="width: 860px">
                                        
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                               <center> <div class="icon" ><i class=""></i></div>
                                                <h4 class="title"> Revista CID TEC LERDO</h4>
                                                 <div class="social">
                                                <a href=""><i class="fa fa-envelope"> revistacid@itslerdo.edu.mx</i></a>
                                                </div>
                                                </center>
                                            </div>
                                        
                                        </div>
                                </div>
                        </fieldset> 
                    </section>
                </div>
            </div>
        </div>
    </div> 
        </div>

      
         <!--INICA EL PIÉ DE PÁGINA-->
        <div class="lineasep" ><img src="img/line.gif"/></div>
        <div class="contactos">
            <table style="padding-left: 100px;">
                <div class="pie_pagina">
                     <tr>
                    <td><a href="https://www.facebook.com/pages/Instituto-Tecnol%C3%B3gico-Superior-de-Lerdo-P%C3%A1gina-Oficial/285056498195463"><img 
                    src="img/face.jpg"/></a></td>
                    <td><a href="https://twitter.com/ITSLerdo?ref_src=twsrc%5Etfw&ref_url=http%3A%2F%2Fwww.itslerdo.edu.mx%2F"><img src="img/tw.jpg"/></a></td>
                    <td><a><img src="img/correoitsl.gif"/></a></td>
                </tr>
                </div>
            </table>
        </div>
        <!-- Pie de página-->
        <div class="pie_pagina">   
            <img src="img/footer_vigente_1170.png"/>
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
