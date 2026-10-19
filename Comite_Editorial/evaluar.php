<?php 
include("usuario.php");
    session_start();
    if($_SESSION["id"]=="")
    {
        header("Location: ../index.php");
    }
$idUsuario=$_SESSION['id'];
$clavearticulo=$_GET['clave'];
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
    <title>EVALUACION - CID TEC LERDO</title>
</head>
<body>
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
              <form method="POST" action="addevaluar.php">
                <div class="container-fluid">
                    <div class="container-fluid">
                        <div class="panel panel-default" id="sombra">
                            <div class="panel-body">
                               <center><h2>FORMATO PARA LA EVALUACIÓN DE ARTÍCULOS DE INVESTIGACIÓN</h2></center> <hr>
                         
                            <!--COLUMNA evaluar-->
                                <div class="container-fluid">
                                    <div class="panel panel-default">
                                        <div class="panel panel-heading" style="background-color: <?=color_revista();?>"></div>
                                          <div class="container-fluid">
                                        <div class="panel-body">
                                            <input type="hidden" name="cl" value="<?php echo $clavearticulo?>"/>
                                            <?php
                                                   $sqlsm = $conexion->prepare("select a.Nombre_Articulo, l.nombre as linea, r.Justificacion,
                                                    (case r.Aceptado when 1 then 'Aceptado' when 0 then 'No Aceptado' end) as e, r.Concluido as concluido
                                                      From articulo as a inner join  linea_investigacion as l on l.idLinea = a.idLinea
                                                      inner join Resumen_Comite as r on a.idArticulo = r.idArticulo    
                                                      where a.Clave_Articulo = '$clavearticulo' and r.idUsuario =$idUsuario;");

                                                        $sqlsm->execute();
                                                        $sqlsm->setFetchMode(PDO::FETCH_ASSOC);
                                                        $result = $sqlsm->fetchAll();

                                                        foreach ($result as $row) {
                                                            $Nombre = $row["Nombre_Articulo"];
                                                            $linea = $row["linea"];
                                                            $justificacion =$row['Justificacion'];
                                                            $Concluido =$row['concluido'];
                                                            $E=$row['e'];
                                                            if($Concluido==1 )
                                                            { 
                                                                $etiqueta="<h4>".$E."</h4>";
                                                                $radio="visibility: hidden"; $des= "disabled"; } 
                                                            else {$des="";$radio=""; $etiqueta="";}
                                                            } ?>
                                           <div class="row">
                                                <div class="col-md-6">                                                    
                                               <fieldset style="width:465px;">
                                                   <legend> Datos del resumen</legend>
                                            <div class="form-group" style="height:50%;">
                                                <h4><label>Clave:</label></h4>
                                                <input class="form-control" style="width:125px" name="clave" value="<?=$clavearticulo?> ">
                                                </div>
                                            <div class="form-group" style="height:50%;">
                                                <h4><label>Nombre del resumen:</label></h4>
                                                <p><?=$Nombre?></p>
                                            </div>
                                            <div class="form-group" style="height:50%;">
                                                <h4><label>Línea de investiagación:</label></h4>
                                                <p><?=$linea?></p>
                                                </div><br>
                                                <div class="form-group" style="height:50%;">
                                                 <a type="button" class="btn btn-danger btn-block"  href="articulos.php"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a>
                                                </div>
                                                    </fieldset>
                                                </div>
                                                   
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        
                                               <fieldset  style="width:460px;">
                                                   <legend> Evaluación</legend>
                                                       <div class="form-group">
                                                        <h5><label>RESULTADO:</label></h5>
                                                           <?=$etiqueta;?>
                                                        <input type="radio" name="radiob" value="1" required <?=$radio;?>> 
                                                           <label <?=$radio;?>>ACEPTADO</label> 
                                                        <input type="radio" name="radiob" value="0" required <?=$radio;?>> 
                                                           <label <?=$radio;?>>NO ACEPTADO</label>
                                                           <br>
                                                        </div>
                                                        <div class="form-group">
                                                        <center><label>JUSTIFICACIÓN</label></center>
                                                        <textarea name="comen" class="form-control" rows=7 style="resize:none; width:center; "placeholder="Introduzca aqui sus comentarios" <?php echo $read; ?> ><?=$justificacion?>
                                                        </textarea>
                                                        </div>
                                                            <div class="form-group">
                                                            <input type="checkbox" name="cbox" id="cbox" value="1" <?=$radio; ?>><label <?=$radio;?>>TERMINAR EVALUACIÓN</label> 
                                                            </div><br>
                                                       <div class="form-group">
                                                         <button type="submit" class="btn btn-primary btn-block" name="gevaluar" <?php echo $des; ?>><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
                                                        </div>
                                                        </fieldset>
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