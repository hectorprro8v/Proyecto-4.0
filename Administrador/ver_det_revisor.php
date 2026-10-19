<?php 
    session_start();
    $idRevisor = 0;
    if(!isset($_SESSION["id"]) || $_SESSION["id"] == "") {
       header("Location: ../index.php");
       exit(); // Para detener la ejecución después de la redirección
    }
    include("../verificacion.php");
    Nolink();
    include("../conexion.php");

    $conexion = conectar();
    use PHPMailer\PHPMailer\PHPMailer;
     use PHPMailer\PHPMailer\Exception;
    require '../vendor/autoload.php';
     date_default_timezone_set("America/Mexico_City");
    setlocale(LC_TIME, 'spanish'); 
    $fecha=strftime("%d de %B del %Y");
    use Spipu\Html2Pdf\Html2Pdf;
  
?>
<?php
        $idRevisor=$_GET['Revisor'];
       try{
         $ver_det_revisor = "SELECT 
         revisor.idRevisor,
        CONCAT(usuario.Nombres, ' ', usuario.Apellido_Paterno, ' ', usuario.Apellido_Materno) AS nombre,
        usuario.Institucion AS Institucion, 
        usuario.Correo_Electronico, 
        usuario.Telefono,
        usuario.Activo,
        GROUP_CONCAT(DISTINCT linea_investigacion.Nombre SEPARATOR ', ') AS Nombre_Linea,
        revisor.Cartaterminacion
        FROM 
            revisor
        INNER JOIN usuario ON revisor.idUsuario = usuario.idUsuario
        INNER JOIN revisor_linea ON revisor.idRevisor = revisor_linea.idRevisor
        INNER JOIN linea_investigacion ON revisor_linea.idLinea = linea_investigacion.idLinea
         WHERE revisor.idRevisor = $idRevisor
         GROUP BY 
            revisor.idRevisor";
         $gsent = $conexion->prepare($ver_det_revisor);
         $gsent->execute();
         $detalle_result = $gsent->fetchAll(); 



        $ver_articulos_revisor = "SELECT A.Clave_Articulo, A.Nombre_Articulo, A.Aceptado 
        FROM extenso_revisor AS ER
        INNER JOIN articulo AS A ON ER.idArticulo = A.idArticulo
        INNER JOIN revisor AS R ON ER.idRevisor = R.idRevisor
        WHERE R.idRevisor = $idRevisor;";    
        $gsent = $conexion->prepare($ver_articulos_revisor);
        $gsent->execute();
        $resultado_art_revisor = $gsent->fetchAll(); 
?>
<!DOCTYPE html>
<html>
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8">        
	    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
        
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

    <title>Detalle del Revisor</title>

</head>

<body>
<br>
<div class="container">
    <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-left" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse" style="color:red;">
                <img src="../img/menu.png">
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
                        <li><a href="perfil.php"><span class="glyphicon glyphicon-user"></span> Perfil</a></li>
                        <li class="divider"></li>
                        <li><a href="../destruir_sesion.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Revisores <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="alta_revisores.php">Alta Revisores</a></li>
                        <li class="divider"></li>
                        <li><a href="detalle_revisores.php">Detalle Revisores</a></li>
                    </ul>
                </li>

                <li><a href="altas.php">Alta usuarios</a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Resúmenes <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="asignar_CE.php">Asignar comité editorial</a></li>
                        <li class="divider"></li>
                        <li><a href="resumenes.php">Ver resumen</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Artículos <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="asignar_Revisores.php">Asignar artículos</a></li>
                        <li class="divider"></li>
                        <li><a href="articulos.php">Ver artículos</a></li>
                        <li class="divider"></li>
                        <li><a href="detalles_articulos.php">Detalles artículos</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Documentos <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="fichas_pago.php">Ficha de Pago</a></li>
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
                    </ul>
                </li>

                <li><a href="correos.php">Enviar Email</a></li>
                <li><a href="parametros.php">Parámetros</a></li>
                <li><a href="reportes/reportes_gen.php">Reportes Generales</a></li>
            </ul>
        </div>
    </nav>
</div>

<!-- CUERPO DE LA PÁGINA -->
<div class="container-fluid">
    <div class="panel panel-default" id="sombra">
        <div class="panel-body">
            <center><h2>Detalle de los Revisores:</h2></center>


            <?php 
                foreach($detalle_result as $dato){
                $idRev = $dato['idRevisor'];
                $Nom = $dato['nombre'];
                $Inst = $dato['Institucion'];
                $Correo = $dato['Correo_Electronico'];
                $Tel = $dato['Telefono'];
                $nombreLinea = $dato['Nombre_Linea'];
                $Est = $dato['Activo'];
                $CartTer = $dato['Cartaterminacion']   
            ?>

                <div class="container-fluid">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background-color: <?= color_revista(); ?>"></div>
                        <div class="panel-body">
                            <fieldset>
                                <legend>DATOS DEL REVISOR</legend>
                                <div class="row">
                                 <!-- Columna Izquierda -->
                                   <div class="col-md-6">
                                       <div class="col-md-12">
                                         <label>Nombre del Revisor</label>
                                         <p><?= $Nom ?></p>
                                       </div>

                                       <div class="col-md-12">
                                         <label>Institución</label>
                                         <p><?= $Inst ?></p>
                                       </div>

                                        <div class="col-md-12">
                                         <label>Teléfono</label>
                                         <p><?= $Tel ?></p>
                                         </div>
                                    </div>
                                    <!-- Columna Derecha -->
                                   <div class="col-md-6">
                                       <div class="col-md-12">
                                         <label>Estado</label>
                                         <p>
                                        <?php 
                                         if($Est == '1') {
                                           echo("Activo");
                                         } else {
                                            echo("No Activo");
                                         }
                                         ?></p>
                                       </div>

                                       <div class="col-md-12">
                                         <label>Correo</label>
                                         <p><?= $Correo ?></p>
                                       </div>

                                        <div class="col-md-12">
                                         <label>Líneas Investigación</label>
                                          <p><?= $nombreLinea ?></p>
                                        </div>  
                                   </div>   
                               </div> 
                            </fieldset>
                        </div>

                        <table id="tabla1" class="table table-hover" style="text-align: center">
                            <thead style="background-color: black; color: white;">
                                <tr>
                                    <th>Clave Articulo</th>
                                    <th>Nombre artículo</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <?php 
                                foreach($resultado_art_revisor as $dato){
                                $Clave_Art = $dato['Clave_Articulo'];
                                $Nom_Art = $dato['Nombre_Articulo'];
                                $Aceptado = $dato['Aceptado'];
                            ?>
                            
                            <tbody>
                                <tr>
                                    <td>
                                        <?= $Clave_Art ?>
                                    </td>
                                    
                                    <td>
                                        <?= $Nom_Art ?>
                                    </td>

                                    <td>
                                        <?php 
                                        //Verificación de estatus de aceptación
                                        if ($Aceptado  == '1') {
                                            echo("Aceptado");
                                            } else {
                                                echo("No Aceptado");
                                            }
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                            <?php 
                                } // Se cierra el foreach de los datos del revisor
                            ?>
                        </table>
                    </div>
                </div>
            <?php 
                } // Se cierra el foreach de los datos del revisor
            ?>

            <div class="container-fluid">
                <div class="row justify-content-between">
                    
                    <!-- Se tienen que agregar clases de boostrap, eso queda pendiente  display-flex  justify-content-between-->
                    <div class="">               
                        <a type="button" class="btn btn-danger btn-md" style="align:right" href="detalle_revisores.php"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a>
                        <?php
                        if ($CartTer == 0) {  // Si no existe aún la carta de terminación
                        ?>
                            <!-- Botón para generar la carta -->
                            <a type="button" href="cartatermina_rev.php?Revisor=<?php echo $idRevisor; ?>" 
                            class="btn btn-success">Generar</a>
                        <?php
                        } else {
                        ?>
                            <!-- Botón para descargar la carta existente -->
                            <a type="button" href="../Documentos/Cartas_Terminacion/CT-<?php echo $idRevisor; ?>.pdf" 
                            class="btn btn-success" target="_blank">Descargar</a>
                        <?php
                        }
                        ?>
                    </div>
                    
                </div>
            </div>
        </div>

        
    </div>
</div>

<?php 
    }
    catch(PDOException $e){
    $_SESSION['mensaje'] = "alertify.error('Ah ocurrido un error al tratar de guardar los datos. Error: ".$e->getMessage()."')";
    echo $_SESSION['mensaje']; //Muestra el error en la página
    }
?>                              
                    
</body>
</html>               


                           