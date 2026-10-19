<?php
session_start();
// Primero verificar la sesión
if($_SESSION["id"] == "") {
    header("Location: ../index.php");
    exit();
}

include("../verificacion.php");
Nolink();

// Conexión a la base de datos
include_once("../conexion.php");
$conectar = conectar();

// Consulta para líneas de investigación
$query_lineas = "SELECT idLinea, Nombre FROM linea_investigacion ORDER BY Nombre";
$result_lineas = $conectar->query($query_lineas);
$lineas = array();
if($result_lineas) {
    while($row = $result_lineas->fetch(PDO::FETCH_ASSOC)) {
        $lineas[] = $row;
    }
}

// Incluir registro_rev.php solo si se envió el formulario
/*if(isset($_POST['registrar_rev'])) {
    include("registro_rev.php");
}*/
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
       
        <style>
            /* Estilos para mantener el diseño original pero mover a la izquierda */
            .main-container {
                display: flex;
                margin-top: 20px;
            }
            
            .form-container {
                width: 100%; /* Cambiado a 100% para que ocupe todo el ancho */
                padding-right: 0; /* Eliminado el padding */
            }
            
            .right-panel {
                display: none; /* Ocultar el panel derecho ya que ahora está dentro del formulario */
            }
            
            /* Mantener el diseño original del formulario */
            .panel-default {
                margin-bottom: 0;
            }
            
            #sombra {
                box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
                border: 1px solid #ddd;
                border-radius: 4px;
            }
            
            .formitic {
                padding: 15px;
            }
            
            .lineas-container {
                max-height: 400px;
                overflow-y: auto;
                border: 1px solid #ddd;
                padding: 15px;
                border-radius: 4px;
            }
            
            .linea-item {
                margin-bottom: 10px;
                padding: 8px;
                border: 1px solid #eee;
                border-radius: 4px;
            }
            
            .linea-item:hover {
                background-color: #f5f5f5;
            }
            
            .checkbox-linea {
                margin-right: 10px;
            }
            
            .principal-label {
                font-size: 12px;
                margin-left: 25px;
                color: #666;
            }
            
            @media (max-width: 992px) {
                .main-container {
                    flex-direction: column;
                }
                
                .form-container, .right-panel {
                    width: 100%;
                    padding-right: 0;
                    padding-left: 0;
                }
            }
        </style>
        
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
                    <h2>SISTEMA DE REGISTRO DE REVISORES</h2>
                    <hr>
                    <div class="main-container">
                        <!-- Formulario completo (ahora ocupa todo el ancho) -->
                        <div class="form-container">
                            <div class="panel panel-default">
                                <div class="panel panel-heading" style="background-color: <?=color_revista()?>">
                                    <!-- Línea guinda se mantiene aquí -->
                                </div>
                                <div class="panel-body">                                    
                                    <div class="panel panel-default col-md-12" id="sombra"> <!-- Cambiado a col-md-12 -->
                                        <br>
                                        <form id="registro_rev" class="form formitic" method="post" action="registro_rev.php" target="_blank">
                                            <label><span class="glyphicon glyphicon-user"></span> NOMBRE(S)</label>
                                            <input class="form-control" placeholder="Ingresa nombre(s)" type="text" name="nombre_reg" required>
                                            <br>

                                            <label>APELLIDO PATERNO</label>
                                            <input class="form-control" placeholder="Ingresa apellido paterno" type="text" name="apellido_paterno_reg" required>
                                            <br>

                                            <label>APELLIDO MATERNO</label>
                                            <input class="form-control" placeholder="Ingresa apellido materno" type="text" name="apellido_materno_reg" required>
                                            <br>

                                            <label><span class="glyphicon glyphicon-envelope"></span> CORREO ELECTRÓNICO</label>
                                            <input class="form-control" placeholder="Ingresa correo electrónico" type="email" name="email_reg" required>
                                            <br>

                                            <label><span class="glyphicon glyphicon-education"></span> INSTITUCIÓN</label>
                                            <input class="form-control" placeholder="Ingresa institución de adscripción" type="text" name="institucion_reg" required>
                                            <br>

                                            <label><span class="glyphicon glyphicon-certificate"></span> Grado de Estudios</label>
                                            <input class="form-control" placeholder="Ingresa tu grado de estudios" type="text" name="grado_estudio_reg" required>
                                            <br>

                                            <strong>TIPO DE USUARIO</strong>
                                            <select class="form-control" name="Tipo_Usuario" required>
                                                <option value="" style="display: none">Elige un tipo de usuario</option>
                                                <option value='R'>Revisor</option>
                                            </select>
                                            <br>
                                            
                                            <!-- Panel de líneas de investigación DENTRO del formulario -->
                                            <div class="panel panel-default">
                                                <div class="panel panel-heading" style="background-color: <?=color_revista()?>">
                                                    <h4 style="color:#f5f5f5;">LÍNEAS DE INVESTIGACIÓN</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <p>Seleccione las líneas de investigación para este revisor:</p>
                                                    <div class="lineas-container" id="sombra">
                                                        <?php if(count($lineas) > 0): ?>
                                                            <?php foreach($lineas as $linea): ?>
                                                                <div class="linea-item">
                                                                    <input type="checkbox" class="checkbox-linea" name="lineas_investigacion[]" value="<?php echo $linea['idLinea']; ?>" id="linea_<?php echo $linea['idLinea']; ?>">
                                                                    <label for="linea_<?php echo $linea['idLinea']; ?>"><?php echo htmlspecialchars($linea['Nombre']); ?></label>
                                                                    <br>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <p>No hay líneas de investigación registradas.</p>
                                                        <?php endif; ?>
                                                    </div>
                                                    <br>
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-success" id="seleccionar_todas">Seleccionar todas</button>
                                                        <button type="button" class="btn btn-warning" id="deseleccionar_todas">Desmarcar todas</button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <button class="btn btn-info form-control inpbtm" name="registrar_rev" type="submit" value="1">REGISTRAR</button>
                                            <br><br>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Panel derecho oculto -->
                        <div class="right-panel">
                            <!-- Este panel ahora está vacío porque el contenido se movió al formulario -->
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
    $(document).on('submit', '#registro_rev', function() {
        // Validar que se haya seleccionado al menos una línea de investigación
        var lineasSeleccionadas = $('input[name="lineas_investigacion[]"]:checked').length;
        if (lineasSeleccionadas === 0) {
            alertify.error('Debe seleccionar al menos una línea de investigación.');
            return false;
        }
        
        $('#cargando').modal('show');
        var elem = document.getElementById("bar");   
        var porcent=document.getElementById("por");
        var width = 1;
        var id = setInterval(frame, 100);
        function frame() {
            if (width >= 100) {              
                // window.location.href='altas.php';
                clearInterval(id);
            } else {
                width++; 
                document.getElementById("por").innerHTML=width + '%';
                elem.style.width = width + '%'; 
            }
        }
    });
    
    // Funcionalidad para seleccionar/deseleccionar todas las líneas
    $('#seleccionar_todas').click(function() {
        $('input[name="lineas_investigacion[]"]').prop('checked', true);
    });
    
    $('#deseleccionar_todas').click(function() {
        $('input[name="lineas_investigacion[]"]').prop('checked', false);
    });
</script>
<?php
     if(isset($_SESSION['mensaje']) && $_SESSION['mensaje'] != "")
     { ?>
        <script>
            alertify.set('notifier','position', 'top-right');
            <?=$_SESSION['mensaje'];$_SESSION['mensaje']="";?>;
        </script>
        
<?php } 
?>