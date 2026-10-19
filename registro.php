<?php
    session_start();
    error_reporting(E_ALL ^ E_NOTICE);
?>
<!DOCTYPE html>
<html>
    <head runat="server">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        
        <link href="css/index/indexstyle.css" rel="stylesheet" media="screen">
        <link href="css/index/menu.css" rel="stylesheet" media="screen">
        <link href="css/index/estilos.css" rel="stylesheet" media="screen">
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery-3.2.1.min.js"></script>
        
        <!--ALERTAS-->
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
        <!-- CSS -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css"/>
        <!--ALERTAS-->
        
        <!--VALIDACIÓN-->
        <script src="js/validar.js"></script>
        <title>REGISTRO - CID TEC LERDO</title>
    </head>
    <body>
        <br>
        <!--logotipos de dependencias-->
        <div class="logos">
            <img class="imagenlogo" src="img/BannerCIDTEC.jpg" height="200px" style="border-radius: 15px;">
        </div>
        <!--fin de logotipos de dependencias-->
        <div class="container">
            <div class="modal-dialog">
                <form method="post" action="session_registro.php" id="registro" onsubmit="return validar_registro();">
                  <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header" style="padding: 35px; background-color: black; ">
                        <tr><td><img  align='right' src='img/Logotec2.png' width='20%'> <div align='center'><h1 style="color: white; margin-top: 30px">SICSACID TEC LERDO</h1></div></td> </tr>
                        
                        </div>
                        <div class="modal-body">
                            <div style="padding-top: 50px; padding-left: 100px; padding-right: 100px;">
                                <div class="form-group">
                                    <label><span class="glyphicon glyphicon-user"></span>Nombre</label>
                                    <input type="text" class="form-control" name="usuario_reg" id="usuario_reg" placeholder="Ingresa nombre" required>
                                </div>
                                
                                <div class="form-group">
                                    <label><span class="glyphicon glyphicon-user"></span> Correo electrónico</label>
                                    <input type="email" class="form-control" name="correo" id="correo" placeholder="Ingresa correo" required>
                                </div>
                                <div class="form-group">
                                    <label><span class="glyphicon glyphicon-eye-open"></span> Contraseña</label>
                                    <input type="password" class="form-control" name="contrasena" id="contrasena" placeholder="Ingresa tu contraseña" required>
                                </div>
                                <div class="form-group">
                                    <label><span class="glyphicon glyphicon-eye-open"></span> Confirmar contraseña</label>
                                    <input type="password" class="form-control" name="repite_contrasena" id="repite_contrasena" placeholder="Ingresa tu contraseña" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-block" name="registrar" id="registrar"><span class="glyphicon glyphicon-floppy-disk"></span> Registrar</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <p>Si ya tienes una cuenta, <a href="index.php">inicia sesión</a></p>
                            <p>¿Olvidaste tu <a href="recupera.php">Contraseña?</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
<div class="modal fade" tabindex=”-1″ id="cargando" role="dialog" data-backdrop="static" data-keyboard="false">
                                        <div class="modal-dialog modal-md" role="document" style="position: absolute;
                                                          top: 150px;
                                                          right: 100px;
                                                          bottom: 0;
                                                          left: 0;
                                                          z-index: 10040;
                                                          overflow: auto;
                                                          overflow-y: auto;
                                                        }">>
                                             <div class="modal-content">
                                               
                                                    <div class="panel-heading" style="color:black">
                                                       
                                                                
                                                             <h2>Procesando... Porfavor Espere.</h2>
                                                                             <div id="bar" class="progress" style="height: 30px;">
                                                                             <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                                                                    <h4 id="por"></h4>
                                                                                    </div>
                                                                                 </div>

                                                                
                                                             </div>
                                                              
                                                        
                                   
                                                       </div>   
                                                    </div>
                                                 </div>                                                        
                                                 
                                            <!--Fin Modal-->
        <!-- pie de pagina-->
        <br>
        <br>
        <div class="contactos">
        <table>
            <tr>
                <td><a href="https://www.facebook.com/pages/Instituto-Tecnol%C3%B3gico-Superior-de-Lerdo-P%C3%A1gina-Oficial/285056498195463"><img  src="img/face.jpg"/></a></td>
                <td><a href="https://twitter.com/ITSLerdo?ref_src=twsrc%5Etfw&ref_url=http%3A%2F%2Fwww.itslerdo.edu.mx%2F"><img src="img/tw.jpg"/></a></td>
                <td><a><img src="img/correoitsl.gif"/></a></td>
            </tr>
        </table>
        </div>

        <!-- Pie de página-->
        <div class="pie_pagina">   
      <img src="img/pie_pagina.jpg"/>
            <p>
                Av. Tecnológico N 1555 Sur Periferico Gomez Lerdo Km. 14.5
                <br/>C.P. 35150 Cd. Lerdo, Dgo
                <br/>Tels. 01 (871) 725 23 71, 725 57 79, 725 58 02
            </p>
        </div>
     <script type="text/javascript" src="../js/funciones/resumen.js"> </script>
    <script>
        
         $(document).on('submit', '#registro', function() {
             // $('#evaluar').modal('hide');
             $('#cargando').modal('show');
              var elem = document.getElementById("bar");   
              var porcent=document.getElementById("por");
              var width = 1;
              var id = setInterval(frame, 100);
              function frame() {
                if (width >= 100) 
                {
                 
//                 window.location.href='resumenes.php';
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