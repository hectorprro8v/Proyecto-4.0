<?php 
    include("../conexion.php");
    $conexion = conectar();
    session_start();
    if($_SESSION["id"] == "")
    {
        header("Location: ../index.php");
        exit();
    }
    include("../verificacion.php");
    Nolink();
    $clave_articulo = $_GET['clave'];
    if($clave_articulo=="")
    {
        header("Location: resumenes.php");
    }
    error_reporting(E_ALL ^ E_NOTICE);
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
        <script src="../js/jquery-3.2.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/funciones_resumen.js"></script>
        
        <!--ALERTAS-->
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
        <!-- CSS -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css"/>
        <!--ALERTAS-->
        <title>CID TEC LERDO - ARTÍCULO <?php echo $clave_articulo ?> </title>
    </head>
    <body>  
              <br>
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-left" role="navigation">
                <div class="navbar-header">
                    <button type="button" style="color:red;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse" >
                        <img src=../img/menu.png>
                    </button>
                    <a class="navbar-brand Active" href="index.php" style="margin-left:15px;">SICSACID</a>
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
                        <?php /*
                        <li class="" style="margin-left:20px"><a href="resumenes.php">Resumen </a></li>
                        */?>
                        <li class="" style="margin-left:20px"><a href="resumenes.php">Registro </a></li>
                        <li class="" style="margin-left:20px"><a href="articulos.php">Artículos</a></li>
                         <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="margin-left:20px"> Documentos <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li class="divider"></li>
                                <li class=""><a href="generar_ficha.php">Generar Ficha de Pago</a></li>
                                <li class=""><a href="fichas_de_pago.php">Recibos y Comprobantes</a></li>
                                <li class="divider"></li>
                                <li class=""><a href="subir_documentos.php">Subir Documentos</a></li>
                                <li class="divider"></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <br>
            <?php
        try{
            $articulo_detalle = "select re.idArticulo as Articulo, Dictamen_Resumen, Dictamen_Extenso, Resumen_Art, Abstract_Art, Palabras_Clave, Keywords, Status_Art, re.Fecha_Recepcion, (case re.Aceptado when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Status, Nombre_Articulo, idLinea, Institucion, Pais, Estado, Ciudad, ex.Status_Ext, ex.idArticulo as Extenso ,ex.Concluido as Concluido from resumen as re, articulo as ar left join extenso as ex on ex.idArticulo = ar.idArticulo where ar.idArticulo = re.idArticulo and ar.Clave_Articulo = '$clave_articulo'";
            $gsent = $conexion->prepare($articulo_detalle);
            $gsent->execute();
            $detalle_result = $gsent->fetchAll();

            foreach($detalle_result as $dato_detalle) {
                $idArticulo_res = $dato_detalle['Articulo'];
                $resumen_res = $dato_detalle['Resumen_Art'];
                $abstract_res = $dato_detalle['Abstract_Art'];
                $palabras_res = $dato_detalle['Palabras_Clave'];
                $keywords_res = $dato_detalle['Keywords'];
                $status_res = $dato_detalle['Status_Art'];
                $titulo_res = $dato_detalle['Nombre_Articulo'];
                $idlinea_res = $dato_detalle['idLinea'];
                $instituto_res = $dato_detalle['Institucion'];
                $pais_res = $dato_detalle['Pais'];
                $estado_res = $dato_detalle['Estado'];
                $ciudad_res = $dato_detalle['Ciudad'];
                $status_ext = $dato_detalle['Status_Ext'];
                $existe_ext = $dato_detalle['Extenso'];
                $dictamen_resumen = $dato_detalle['Dictamen_Resumen'];
                $dictamen_extenso = $dato_detalle['Dictamen_Extenso'];
                $status = $dato_detalle['Status'];
                $concluido = $dato_detalle["Concluido"];
                
                $fecha_res = $dato_detalle['Fecha_Recepcion'];
                $status_ext = $dato_detalle['Status_Ext'];
            }
            $linea_detalle = "select Nombre from linea_investigacion where idLinea = $idlinea_res";
            $gsent = $conexion->prepare($linea_detalle);
            $gsent->execute();
            $linea_result = $gsent->fetchAll();

            foreach($linea_result as $dato_linea) {
                $nombre_linea = $dato_linea['Nombre'];
            }
        }
        catch(PDOException $e)
        {
            $_SESSION['mensaje'] = "alertify.error('Ah ocurrido un error al tratar de guardar los datos. Error: ".$e->getMessage()."')";
            header("Location: resumenes.php");
        }
        ?>  
        <!--CUERPO DE LA PÁGINA-->
            <div class="container-fluid">
                <div class="panel panel-default" id="sombra">
                    <div class="panel-body">
                        <h1><?php echo $clave_articulo.": ".$titulo_res ?></h1>
                        <hr>   
                        <div class="container-fluid">
                            <div class="panel panel-default">
                                <div class="panel-heading" id="color-head-panel">
                                </div>
                                <div class="panel-body">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <?php if($status =="Aceptado") {
                                                                $txt_res="green";
                                                            }else if($status =="No aceptado"){
                                                                        $txt_res="red";
                                                                    }else{$txt_res="orange"; }?>
                                                    <h4>Estado del resumen: <span style="color: <?=$txt_res?>"><?=$status?></span></h4>
                                                    
                                                </div>
                                                <div class="col-sm-4"><center>
                                                    <?php
                                                        if($existe_ext != null)
                                                            {?>
                                                                <h4>Estado del extenso: <?=$status_ext?></h4></center>
                                                           <?php }?>
                                                </div>
                                                <?php if($status == "Aceptado")
                                                      {
                                                    //La variable y el campo concluido es someter a revisión
                                                            if($existe_ext != null &&  ($concluido == 1))
                                                            {?>
                                                <div class="col-sm-2" style="background-color: #E0ECF8"><center>
                                                                <h4>Extenso enviado</h4>
                                                            <?php 
                                                            }
                                                            else
                                                            {
                                                                
                                                                if((date("Y-m-d")<=limite_extenso($clave_articulo))) {?>
                                                                    <a type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#extenso" style="top: 50%">Subir extenso</a>
                                                            <?php }else{ ?>
                                                                        <p style="color: red">La fecha para enviar extensos ha llegado al límite o su extenso ya esta sometido a revisión.</p>
                                                                <?php } ?>
                                                      <?php }
                                                      }
                                                      else
                                                      {  

                                                      } ?>
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-6">
                                            
                                            <h3>Linea de Investigación</h3>
                                            <input class="form-control" style="text-align: center" value="<?php echo $nombre_linea?>" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <h3>Institución</h3>
                                            <input class="form-control" style="text-align: center" value="<?php echo $instituto_res?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <h3>País</h3>
                                            <input type="text" class="form-control" style="text-align: center;" value="<?php echo $pais_res?>" readonly>
                                        </div>
                                        <div class="col-sm-4">
                                            <h3>Estado</h3>
                                            <input type="text" class="form-control" style="text-align: center;" value="<?php echo $estado_res?>" readonly>
                                        </div>
                                        <div class="col-sm-4">
                                            <h3>Ciudad</h3>
                                            <input type="text" class="form-control" style="text-align: center;" value="<?php echo $ciudad_res?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h3>Resumen</h3>
                                            <textarea class="form-control" rows="12" readonly><?php echo $resumen_res ?></textarea>
                                            <h3 class="in-line">Palabras Clave</h3>
                                            <input type="text" class="form-control" style="text-align: center;" value="<?php echo $palabras_res?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h3>Abstract</h3>
                                            <textarea class="form-control" rows="12" readonly><?php echo $abstract_res ?></textarea>
                                            <h3 class="in-line">Keywords</h3>
                                            <input type="text" class="form-control" style="text-align: center;" value="<?php echo $keywords_res?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid">
                                    <h3>Autores y coautores</h3>   
                                        <div class="table-responsive">          
                                            <table class="table">
                                                <thead class="" style="background-color: black; color: white;">
                                                    <tr>
                                                        <th>Nombre(s)</th>
                                                        <th>Apellidos</th>
                                                        <th>Institución</th>
                                                        <th>Correo electrónico</th>
                                                        <th>ORCID</th>
                                                        <th>CVU</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                        /*Consulta de los autores*/
                                                        $autor_detalle = "select * from autores where idArticulo = $idArticulo_res";
                                                        $gsent = $conexion->prepare($autor_detalle);
                                                        $gsent->execute();
                                                        $autor_result = $gsent->fetchAll();
                                                        foreach($autor_result as $dato_autor): ?>
                                                        <tr>
                                                            <td><?php echo $dato_autor['Nombres'] ?></td>
                                                            <td><?php echo $dato_autor['Apellido_Paterno']." ".$dato_autor['Apellido_Materno'] ?></td>
                                                            <td><?php echo $dato_autor['Institucion'] ?></td>
                                                            <td><?php echo $dato_autor['Correo_Electronico'] ?></td>
                                                            <td><?php echo $dato_autor['ORCID'] ?></td>
                                                            <td><?php echo $dato_autor['CVU'] ?></td>
                                                            <?php if($dato_autor['Principal'] == 1){?> <td>Principal</td> <?php }else{?><td>Secundario</td><?php } ?>
                                                        </tr>
                                                        <?php endforeach ?>
                                                </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <div class="modal-footer">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <a type="button" class="btn btn-danger btn-md btn-block" href='javascript:window.history.go(-1);'><span class="glyphicon glyphicon-chevron-left"></span>Regresar</a>
                                            </div>
                                            <div class="col-md-6">
                                                <?php 
                                                    if($dictamen_resumen == 1 && $dictamen_extenso == 1)
                                                    {?>
                                                        <a type="button" class="btn btn-primary btn-lg btn-block" href="generar_ficha.php"><span class="glyphicon glyphicon-usd"></span>Pagar ahora</a>
                                                 <?php } ?>
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
        <form action="envia_extenso.php" method="post" enctype="multipart/form-data" name="subeextenso">
        <!--MODAL ENVIAR EXTENSO-->
            <div class="modal fade" id="extenso" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h3 class="modal-title">
                          <input name="clave_articulo" value="<?php echo $clave_articulo?>" hidden>
                          <input name="titulo_articulo" value="<?php echo $titulo_res?>" hidden>
                          <h3><?php echo $clave_articulo.": ".$titulo_res ?></h3>
                        </h3>
                    </div>
                    <div class="modal-body">
                        <p>El archivo debe ser en formato .docx (documento de word).</p>
                        <div class="container-fluid">
                                <label>Subir Extenso </label>
                                <input type="file" name="archivo" class="form-control">
                        </div>
                        <br>
                        <div class="container-fluid">
                                <label>Subir extenso sin autores </label>
                                <input type="file" name="archivoSA" class="form-control">
                        </div>
                        <div class="container-fluid">
                                <label>Ficha tecnica (EXTENSO a una SOLA COLUMNA)</label>
                                <input type="file" name="ficha" class="form-control">
                        </div>
                       
                        <div class="form-group">
                        <input type="checkbox" name="cbox" id="cbox"> 
                            <label> SOMETER A REVISIÓN (Seleccionar esta opción para completar el envío)</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row container-fluid">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary btn-block" type="submit" name="subir">Subir</button>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
            <!--MODAL ENVIAR EXTENSO-->
        </form>
    </body>
</html>

