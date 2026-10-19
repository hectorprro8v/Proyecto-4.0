<?php
    include('consulta_resumenes.php');
    if($_SESSION["id"]=="")
    {
        header("Location: ../index.php");
    }
    
    error_reporting(E_ALL ^ E_NOTICE);
    $filaRegGeneral = $conexion->query("SELECT Apertura_registro, Cierre_registro FROM registro ORDER BY id_registro DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    $recepcionGeneral = isset($filaRegGeneral["Apertura_registro"]) ? $filaRegGeneral["Apertura_registro"] : "";
    $limiteGeneral = isset($filaRegGeneral["Cierre_registro"]) ? $filaRegGeneral["Cierre_registro"] : "";
    $idRegistro = limite_resumen(date("Y-m-d"));
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
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery-3.2.1.min.js"></script>
        
        <!--ALERTAS-->
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
        <!-- CSS -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css"/>
        <!--ALERTAS-->
        
        <title>REGISTROS - CID TEC LERDO</title>
    </head>
    <body> 
        <!--cabecera de página-->
        <br/>
        <!--fin de cabecera de página-->
        <!--logotipos de dependencias-->
        <div class="logos">
            <img class="imagenlogo" src="../img/header_portal_vigente_1170.png"/>
        </div>
        <!--fin de logotipos de dependencias-->
       <!--Menu-->
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
        <!--Menu-->
        <!--CUERPO DE LA PÁGINA-->
            <div class="container-fluid">
                <div class="panel panel-default" id="sombra">
                    <div class="panel-body"><h2>REGISTROS
                            <?php 
                                /*
                                antes...
                                    <?php if(date("Y-m-d")<=limite_resumen() && date("Y-m-d")>=recepcion_resumen()){?>
                                */
                                /* if(date("Y-m-d")<=$limiteGeneral && date("Y-m-d")>=$recepcionGeneral){?>*/
                                if($idRegistro){?>
                                <?php /*
                                <a class="btn btn-success btn-md glyphicon glyphicon-plus" style="top: -5px" data-toggle="modal" data-target="#modal_precio"> Nuevo Resumen</a>
                                */?>
                                <a class="btn btn-success btn-md glyphicon glyphicon-plus" style="top: -5px" data-toggle="modal" data-target="#modal_precio"> Nuevo Registro</a>
                        
                            <?php }else{
                                        /*
                                            antes...
                                            if(date("Y-m-d")>limite_resumen()){
                                        */
                                        if(date("Y-m-d")>$limiteGeneral){
                                            $_SESSION["mensaje"]="alertify.error('La fecha para enviar resumenes ha llegado al límite.')";
                                        }
                                        /*antes... 
                                        if(date("Y-m-d")<recepcion_resumen()) */
                                        if(date("Y-m-d")<$recepcionGeneral){
                                            /*
                                            $_SESSION["mensaje"]="alertify.error('La fecha de recepción de resumenes será hasta la fecha: ".recepcion_resumen()."')";
                                            */
                                            $_SESSION["mensaje"]="alertify.error('La fecha de recepción de resumenes será hasta la fecha: ".$recepcionGeneral."')";
                                        }
                                    } ?></h2>
                        <hr>
                        <div class="container-fluid">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: <?=color_revista();?>">
                                </div>
                                <div class="panel-body">
                                    <div class="container-fluid">
                                        <p>A continuación se muestran los resumenes enviados y su estado.</p>   
                                        <div class="table-responsive">          
                                            <table class="table" id="tabla_resumen">
                                                <thead class="" style="background-color: black; color: white;">
                                                    <tr>
                                                        <th style="width: 15%">Clave Articulo</th>
                                                        <th style="width: 60%">Título</th>
                                                        <th style="width: 15%">Estado</th>
                                                        <th style="width: 5%"></th>
                                                        <th style="width: 5%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        foreach($articulos_result as $dato_articulo){ ?>
                                                        <tr>
                                                            <?php $clave_Articulo_modal = $dato_articulo['Clave_Articulo'];
                                                                    $nombre_Artículo_modal = $dato_articulo['Nombre_Articulo'];
                                                                    $status_resumen_modal = $dato_articulo['Status_Art'];
                                                                    $estado_resumen_modal = $dato_articulo['Estado']; ?>
                                                            <td><?php echo $clave_Articulo_modal ?></td>
                                                            <td><?php echo $nombre_Artículo_modal ?></td>
                                                            <td><?php echo $status_resumen_modal?></td>
                                                            <td><a type='button'class='btn btn-primary btn-md' href="visualiza_resumen.php?clave=<?=$clave_Articulo_modal?>">Visualizar</a></td>
                                                            <?php if($status_resumen_modal!="En revision"){
                                                                        if($estado_resumen_modal=="Aceptado"){?>
                                                                            <td><a type='button' class='btn btn-success btn-md' href="dictamen_resumen.php?clave=<?=$clave_Articulo_modal?>" target="_blank">Dictamen</a></td>
                                                                    <?php }elseif($status_resumen_modal="No aceptado"){?>
                                                                            <td><a type='button' class='btn btn-danger btn-md' href="dictamen_resumen.php?clave=<?=$clave_Articulo_modal?>" target="_blank">Dictamen</a></td>
                                                                    <?php }} ?>
                                                        </tr>
                                                        <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         <div class="modal fade" id="modal_precio" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">  
                        <h3 class="modal-title">INSTRUCCIONES DE LLENADO</h3>
                    </div>
                    <form action="nuevo_resumen.php">
                        <div class="modal-body ">
                            <div class="container-fluid row">
                                     <div class="container-fluid col-lg-12">
                                        <h4>El resumen debe ser un sumario breve que se presente en un lenguaje simple y directo, que muestre el objetivo, el alcance del estudio realizado, la metodología utilizada, los resultados más importantes y las principales conclusiones. No incluir referencias en este apartado, no debe contener ecuaciones, tablas o figuras. No se deberán utilizar abreviaturas y deberá tener una extensión máxima de 250 palabras. El tipo de letra es Arial de 9 puntos en negritas. Solamente la palabra resumen va en itálica. </h4>
                                        <br>
                                        <h4>Se deben incluir de 4 a 6 palabras clave, separadas por comas y en orden alfabético, y con letra capital; que clasifiquen o caractericen el artículo que se presenta. Agregar una tabulación estándar antes de la frase “Palabras Clave”.</h4>
                                        <b style="color: red">Nota: Asegura que los datos sean llenados en su totaldad, una vez guardada la información no se podra editar el resúmen.</b>
                                    </div>
                                    <div class="modal-footer">
                            <div class="col-md-12">
                                <br>
                            </div>
                            <div class="col-md-12">
                                <br>
                                <button type="submit" class="btn btn-primary btn-block" style="resize: both"> Siguiente</button>
                            </div>
                        </div>
                                </div>
                            </div>
                    </form>
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
<?php } 
?>