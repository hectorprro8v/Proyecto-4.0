<?php 
    include("usuario.php");
   session_start();
// Primero verificar la sesión
if($_SESSION["id"] == "") {
    header("Location: ../index.php");
    exit();
}


    
$clave=$_GET['clave'];
?>
<!DOCTYPE html>
<html>
    <head runat="server">
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
        <!--ALERTAS-->
        
    
    <title>RESUMEN - CID TEC LERDO</title>
</head>
<body>
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
                        <li class=""><a href="correos.php">Enviar Email</a></li>
                        <li class=""><a href="parametros.php">Parámetros</a></li>
                        <li class=""><a href="reportes/reportes_gen.php">Reportes Generales</a></li>
                    </ul>
                </div>
            </nav>
        </div>
              <form method="POST" action="addevaluar.php">
                <div class="container-fluid">
                    <div class="container-fluid">
                        <div class="panel panel-default" id="sombra">
                            <div class="panel-body">
                                <center><h2>RESUMEN DEL ARTÍCULO</h2></center><hr>
                            <?php
                                 $sqlsm = $conexion->prepare("select a.Nombre_Articulo as Nombre, l.nombre as linea,
                                    re.Resumen_Art as Resumen, re.Abstract_art as Abstract, re.Palabras_Clave as Palabras, re.Keywords as Keywords
                                    From articulo as a inner join  linea_investigacion as l on l.idLinea = a.idLinea
                                    inner join resumen as re on a.idArticulo = re.idArticulo   
                                    where a.Clave_Articulo = '$clave' group by a.Clave_Articulo");

                                    $sqlsm->execute();
                                    $sqlsm->setFetchMode(PDO::FETCH_ASSOC);
                                    $result = $sqlsm->fetchAll();
                                    
                                 foreach ($result as $row) {
                                $Nombre = $row["Nombre"];
                                $linea = $row["linea"];
                                $Resumen = $row["Resumen"];
                                $Abstract = $row["Abstract"];
                                $Palabras_clave = $row["Palabras"];
                                $Keywords = $row["Keywords"];
                              }?>
                            
                            <!--COLUMNA evaluar-->
                                <div class="container-fluid">
                                    <div class="panel panel-default">
                                        <div class="panel panel-heading" style="background-color: <?=color_revista();?>"></div>
                                          <div class="container-fluid">
                                        <div class="panel-body">
                                    <fieldset>
                                        <legend>DATOS DEL RESUMEN</legend>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <label class="col-md-12 col-sm-6 col-xs-6 text-left"for="basicinput">Clave del artículo</label>
                                                <div class='col-md-12 col-sm-6 col-xs-6'>
                                                    <p ><?=$clave?></p>
                                                </div> 
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6"> 
                                                <label class="col-md-12 col-sm-6 col-xs-6 text-left">Línea de investigación</label>
                                                <div class='col-md-12 col-sm-6 col-xs-6'>
                                                    <p><?=$linea?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="col-md-12 col-sm-6 col-xs-6 text-left">Nombre del resumen</label>  
                                                <div class='col-md-12 col-sm-6 col-xs-6'>
                                                    <p style="justify" ><?=$Nombre ?></p>
                                                </div>
                                            </div>
                                        </div>    
                                    </fieldset> 
                                            <br><br><br><br>
                                               <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                <center><label>RESUMEN</label></center>
                                                <textarea name="comen" class="form-control" readonly rows=10 style="resize:none;" ><?=$Resumen?>
                                                </textarea>
                                                </div>
                                                   </div>
                                                </div>
                                            
                                            <div class="row">
                                            <div class="col-md-12">
                                                    <div class="form-group">
                                                <center><label>ABSTRACT</label></center>
                                                <textarea name="comen" class="form-control" readonly rows=10 style="resize:none;" ><?=$Abstract?>
                                                </textarea>
                                                </div>
                                                   </div>
                                             </div>
                                            <br>
                                            <hr>
                                            <br>
                                              <div class="row">
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                <center><label>PALABRAS CLAVE</label></center>
                                                  <textarea name="comen" class="form-control" readonly rows=3 style="resize:none;"><?=$Palabras_clave?></textarea>
                                                </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                    <div class="form-group">
                                                <center><label>KEYWORDS</label></center>
                                                    <textarea name="comen" class="form-control" readonly rows=3 style="resize:none;"><?=$Keywords?></textarea>
                                                </div>
                                                   </div>
                                              </div>
                                            <br>
                                            <hr>
                                            <br>
                                              <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                    <a type="button" class="btn btn-danger btn-md" style="align:right" href="resumenes.php"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a>
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
                </div>
             </form>
    </body>
</html>