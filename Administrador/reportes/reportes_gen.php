<?php
include("tablas.php");

    if($_SESSION["id"]=="")
    {
        header("Location: ../../index.php");
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../../css/bootstrap.css">
    <link href="../../css/index/indexstyle.css" rel="stylesheet" media="screen">
    <link href="../../css/index/menu.css" rel="stylesheet" media="screen">
    <link href="../../css/index/estilos.css" rel="stylesheet" media="screen">
    <link href="../../css/index/navbar-fixed-left.min.css" rel="stylesheet">
    <script src="../../js/plotly-latest.min.js"></script>




    <!--ALERTAS-->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
    <!--ALERTAS-->

    <title>REPORTES - CID TEC LERDO</title>
</head>

<body>
    <!--cabecera de página-->
    <br />
    <!--fin de cabecera de página-->
    <!--logotipos de dependencias-->
    <div class="logos img-responsive">
        <img class="imagenlogo" src="../../img/header_portal_vigente_1170.png" />
    </div>
    <!--fin de logotipos de dependencias-->
    <!--CUERPO DE LA PÁGINA-->
    <!--Menu-->
    <br>
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-left" role="navigation">
            <div class="navbar-header">
                <button type="button" style="color:red;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <img src=../img/menu.png> </button> <a class="navbar-brand" href="../index.php" style="margin-left: 15px;">SICSACID</a>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <div class="image">
                        <img src="../../img/Logo_Revista.png" width="90" height="120" alt="User" style="margin-left:40px;">
                    </div>
                    <br>
                    <li class="dropdown">
                        <button href="#" class="btn btn-info dropdown-toggle" data-toggle="dropdown" type="button" style="margin-left:10px;"><?php echo $_SESSION["nameuser"]?><b class="caret"></b></button>
                        <ul class="dropdown-menu">
                            <li class=""><a href="../perfil.php"><span class="glyphicon glyphicon-user"></span> Perfil</a></li>
                            <li class="divider"></li>
                            <li><a href="../destruir_sesion.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
                        </ul>
                    </li>
                    <li class=""><a href="../altas.php">Alta usuarios</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Resúmenes <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="../asignar_CE.php">Asignar comité editorial</a></li>
                            <li class="divider"></li>
                            <li><a href="../resumenes.php">Ver resumen</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown" data-toggle="dropdown"> Artículos <b class="caret"></b></a>

                        <ul class="dropdown-menu">
                            <li><a href="../asignar_Revisores.php">Asignar artículos</a></li>
                            <li class="divider"></li>
                            <li><a href="../articulos.php">Ver artículos</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Documentos <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="../fichas_pago.php">Ficha de Pago</a></li>
                            <li class="divider"></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="reporte_res.php">Resumen</a></li>
                            <li class="divider"></li>
                            <li><a href="reporte_art.php">Artículo</a></li>
                            <li class="divider"></li>
                            <li><a href="reporte_us.php">Usuarios</a></li>
                            <li class="divider"></li>
                            <li><a href="reporte_fin.php">Financieros</a></li>
                            <li class="divider"></li>

                        </ul>
                    </li>
                    <li class=""><a href="../parametros.php">Parámetros</a></li>
                    <li class=""><a href="reporte_gen.php">Reportes Generales</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="container-fluid">
        <div class="panel panel-default" id="sombra">
            <div class="panel-body">
                <h2>REPORTES GRAFICOS</h2>
                <hr>
                <div class="container-fluid">
                    <div class="panel panel-default">
                        <div class="panel panel-heading" style="background-color: <?=color_revista()?>">
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-5 mt-4">
                                    <div class="card card-inverse">
                                        <div class="card-block">
                                            <!-------------RESUMENES------------->
                                            <h4 align="center" class="card-title mt-3">RESUMENES</h4>
                                            <table id="tipopago" class="table table-hover">
                                                <thead style="background-color:black; color: white">
                                                    <th>Estado</th>
                                                    <th>Resumenes</th>
                                                    <th>Porcentajes</th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <?php                                                                
                            
                                                foreach ($resresumen as $row){ 
                                                    $estado= $row['Estado'];
                                                    $resumen=$row['Resumenes'];
                                                    $porcentaje=$row['Porcentaje'];
                                                ?>
                                                        <td width="150px"><?=$estado?></td>
                                                        <td width="150px"><?=$resumen?></td>
                                                        <td width="150px"><?=$porcentaje?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer">
                                            <center><button class="btn btn-success float-right btn-sm" id="btnresumen">VER GRAFICO</button></center>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 mt-4" style="margin-left:168px">
                                    <div class="card card-inverse">
                                        <div class="card-block">
                                            <h4 align="center" class="card-title mt-3">RESUMENES INSTITUCION</h4>
                                            <table id="resumenesi" class="table table-hover">
                                                <thead style="background-color:black; color: white">
                                                    <th>Estado</th>
                                                    <th>ITSL</th>
                                                    <th>Externo</th>
                                                    <th>Total</th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <?php                                                                
                            
                                                foreach ($resresumenI as $row){ 
                                                    $estado= $row['Estado'];
                                                    $itsl=$row['ITSL'];
                                                    $externo=$row['Externo'];
                                                    $total=$row['Total'];
                                                    
                                                ?>
                                                        <td width="150px"><?=$estado?></td>
                                                        <td width="150px"><?=$itsl?></td>
                                                        <td width="150px"><?=$externo?></td>
                                                        <td width="150px"><?=$total?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer">
                                            <center><button onclick="genbarrasResumen();" data-toggle="modal" data-target="#modal_grafico" class="btn btn-success float-right btn-sm" id="btnresumen2">VER GRAFICO</button></center>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-5 mt-4">
                                            <br>
                                            <div class="card card-inverse">
                                                <div class="card-block">
                                                    <!-------------EXTENSOS------------->
                                                    <h4 align="center" class="card-title mt-3">EXTENSOS</h4>
                                                    <table id="tipopago" class="table table-hover">
                                                        <thead style="background-color:black; color: white">
                                                            <th>Estado</th>
                                                            <th>Resumenes</th>
                                                            <th>Porcentajes</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <?php                                                                
                            
                                                foreach ($resexten as $row){ 
                                                    $estado= $row['Estado'];
                                                    $extenso=$row['Extenso'];
                                                    $porcentaje=$row['Porcentaje'];
                                                ?>
                                                                <td width="150px"><?=$estado?></td>
                                                                <td width="150px"><?=$extenso?></td>
                                                                <td width="150px"><?=$porcentaje?></td>
                                                            </tr>
                                                            <?php
                                                }
                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="card-footer">
                                                    <center><button class="btn btn-success float-right btn-sm" id="btnresumen3">VER GRAFICO</button></center>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5 mt-4" style="margin-left:168px">
                                            <br>
                                            <div class="card card-inverse">
                                                <div class="card-block">
                                                    <h4 align="center" class="card-title mt-3">EXTENSOS INSTITUCION</h4>
                                                    <table id="resumenesi" class="table table-hover">
                                                        <thead style="background-color:black; color: white">
                                                            <th>Estado</th>
                                                            <th>ITSL</th>
                                                            <th>Externo</th>
                                                            <th>Total</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <?php                                                                
                            
                                                foreach ($resextensoI as $row){ 
                                                    $estado= $row['Estado'];
                                                    $itsl=$row['ITSL'];
                                                    $externo=$row['Externo'];
                                                    $total=$row['Total'];
                                                    
                                                ?>
                                                                <td width="150px"><?=$estado?></td>
                                                                <td width="150px"><?=$itsl?></td>
                                                                <td width="150px"><?=$externo?></td>
                                                                <td width="150px"><?=$total?></td>
                                                            </tr>
                                                            <?php
                                                }
                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="card-footer">
                                                    <center><button onclick="genbarrasExtenso();" data-toggle="modal" data-target="#modal_grafico_extenso" class="btn btn-success float-right btn-sm" id="btnresumen4">VER GRAFICO</button></center>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-5 mt-4">
                                            <br>
                                            <div class="card card-inverse">
                                                <div class="card-block">
                                                    <!-------------ARTICULOS------------->
                                                    <h4 align="center" class="card-title mt-3">ARTICULOS</h4>
                                                    <table id="tipopago" class="table table-hover">
                                                        <thead style="background-color:black; color: white">
                                                            <th>Estado</th>
                                                            <th>Articulos</th>
                                                            <th>Porcentajes</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <?php                                                                
                            
                                                foreach ($resarti as $row){ 
                                                    $estado= $row['Estado'];
                                                    $articulos=$row['Articulos'];
                                                    $porcentaje=$row['Porcentaje'];
                                                ?>
                                                                <td width="150px"><?=$estado?></td>
                                                                <td width="150px"><?=$articulos?></td>
                                                                <td width="150px"><?=$porcentaje?></td>
                                                            </tr>
                                                            <?php
                                                }
                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="card-footer">
                                                    <center><button class="btn btn-success float-right btn-sm" id="btnresumen5">VER GRAFICO</button></center>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5 mt-4" style="margin-left:168px">
                                            <br>
                                            <div class="card card-inverse">
                                                <div class="card-block">
                                                    <h4 align="center" class="card-title mt-3">ARTICULOS INSTITUCION</h4>
                                                    <table id="resumenesi" class="table table-hover">
                                                        <thead style="background-color:black; color: white">
                                                            <th>Estado</th>
                                                            <th>ITSL</th>
                                                            <th>Externo</th>
                                                            <th>Total</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <?php                                                                
                            
                                                foreach ($resartiI as $row){ 
                                                    $estado= $row['Estado'];
                                                    $itsl=$row['ITSL'];
                                                    $externo=$row['Externo'];
                                                    $total=$row['Total'];
                                                    
                                                ?>
                                                                <td width="150px"><?=$estado?></td>
                                                                <td width="150px"><?=$itsl?></td>
                                                                <td width="150px"><?=$externo?></td>
                                                                <td width="150px"><?=$total?></td>
                                                            </tr>
                                                            <?php
                                                }
                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="card-footer">
                                                    <center><button onclick="genbarrasA();" data-toggle="modal" data-target="#modal_grafico_art" class="btn btn-success float-right btn-sm" id="btnresumen7">VER GRAFICO</button></center>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                        <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-5 mt-4">
                                            <br>
                                            <div class="card card-inverse">
                                                <div class="card-block">
                                                    <!-------------ARTICULOS PUBLICADOS------------->
                                                    <h4 align="center" class="card-title mt-3">ARTICULOS PUBLICADOS</h4>
                                                    <table id="tipopago" class="table table-hover">
                                                        <thead style="background-color:black; color: white">
                                                            <th>Estado</th>
                                                            <th>Publicados</th>
                                                            <th>Porcentajes</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <?php                                                                
                            
                                                foreach ($resartip as $row){ 
                                                    $estado= $row['Estado'];
                                                    $articulosp =$row['Publicados'];
                                                    $porcentaje=$row['Porcentaje'];
                                                ?>
                                                                <td width="150px"><?=$estado?></td>
                                                                <td width="150px"><?=$articulosp?></td>
                                                                <td width="150px"><?=$porcentaje?></td>
                                                            </tr>
                                                            <?php
                                                }
                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="card-footer">
                                                    <center><button class="btn btn-success float-right btn-sm" id="btnresumen6">VER GRAFICO</button></center>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5 mt-4" style="margin-left:168px">
                                            <br>
                                            <div class="card card-inverse">
                                                <div class="card-block">
                                                    <h4 align="center" class="card-title mt-3">ARTICULOS PUBLICADOS POR INSTITUCION</h4>
                                                    <table id="resumenesi" class="table table-hover">
                                                        <thead style="background-color:black; color: white">
                                                            <th>Estado</th>
                                                            <th>ITSL</th>
                                                            <th>Externo</th>
                                                            <th>Total</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <?php                                                                
                            
                                                foreach ($resartipI as $row){ 
                                                    $estado= $row['Estado'];
                                                    $itsl=$row['ITSL'];
                                                    $extensos=$row['Externos'];
                                                    $total=$row['Total'];
                                                    
                                                ?>
                                                                <td width="150px"><?=$estado?></td>
                                                                <td width="150px"><?=$itsl?></td>
                                                                <td width="150px"><?=$extensos?></td>
                                                                <td width="150px"><?=$total?></td>
                                                            </tr>
                                                            <?php
                                                }
                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="card-footer">
                                                    <center><button onclick="genbarrasArticulosP();" data-toggle="modal" data-target="#modal_grafico_publicados" class="btn btn-success float-right btn-sm" id="btnresumen6">VER GRAFICO</button></center>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5 mt-4">
                                            <br>
                                            <div class="card card-inverse">
                                                <div class="card-block">
                                                    <!-------------ARTICULOS PUBLICADOS------------->
                                                    <h4 align="center" class="card-title mt-3">RESULTADO TOTAL</h4>
                                                    <table id="tipopago" class="table table-hover">
                                                        <thead style="background-color:black; color: white">
                                                            <th>Estado</th>
                                                            <th>Articulos</th>
                                                            <th>Porcentajes</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <?php                                                                
                            
                                                foreach ($restotal as $row){ 
                                                    $estado= $row['Estado'];
                                                    $articulo= $row['Articulos'];
                                                    $porcentaje=$row['Porcentaje'];
                                                ?>
                                                                <td width="150px"><?=$estado?></td>
                                                                <td width="150px"><?=$articulo?></td>
                                                                <td width="150px"><?=$porcentaje?></td>
                                                            </tr>
                                                            <?php
                                                }
                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="card-footer">
                                                    <center><button class="btn btn-success float-right btn-sm" id="btnresumen8">VER GRAFICO</button></center>
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
    </div>

    <div id="modal-1" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!--En este container se muestran los gráficos-->
                    <div id="contenedor-modal" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-2" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!--En este container se muestran los gráficos-->
                    <div id="GraficoExtenso" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="modal-3" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!--En este container se muestran los gráficos-->
                    <div id="GraficoArticulo" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="modal-4" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!--En este container se muestran los gráficos-->
                    <div id="GraficoArticuloPublicado" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-5" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!--En este container se muestran los gráficos-->
                    <div id="GraficoTotal" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_grafico" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!--En este container se muestran los gráficos-->
                    <div id="graficalineal"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_grafico_extenso" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!--En este container se muestran los gráficos-->
                    <div id="graficalinealextenso"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="modal_grafico_art" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!--En este container se muestran los gráficos-->
                    <div id="graficalinealart"></div>
                </div>
            </div>
        </div>
    </div>
    
     <div id="modal_grafico_publicados" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!--En este container se muestran los gráficos-->
                    <div id="graficalinealartp"></div>
                </div>
            </div>
        </div>
    </div>
    
    
    <!--Menu-->
    <!--INICA EL PIÉ DE PÁGINA-->
    <div class="lineasep"><img src="../../img/line.gif" /></div>
    <div class="contactos">
        <table>
            <tr>
                <td><a href="https://www.facebook.com/pages/Instituto-Tecnol%C3%B3gico-Superior-de-Lerdo-P%C3%A1gina-Oficial/285056498195463"><img src="../../img/face.jpg" /></a></td>
                <td><a href="https://twitter.com/ITSLerdo?ref_src=twsrc%5Etfw&ref_url=http%3A%2F%2Fwww.itslerdo.edu.mx%2F"><img src="../../img/tw.jpg" /></a></td>
                <td><a><img src="../../img/correoitsl.gif" /></a></td>
            </tr>
        </table>
    </div>
    <!-- Pie de página-->
    <div class="pie_pagina">
        <img src="../../img/pie_pagina.jpg" />
        <p>Av. Tecnológico N 1555 Sur Periferico Gomez Lerdo Km. 14.5
            <br />C.P. 35150 Cd. Lerdo, Dgo
            <br />Tels. 01 (871) 725 23 71, 725 57 79, 725 58 02
        </p>
    </div>
    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/funciones/reportes/usuario.js"></script>
    <script src="../reportes/codigoJS.js"></script>
    <script src="../../pluggins/Highcharts_7.0.3/code/highcharts.js"></script>
    <script src="../../pluggins/Highcharts_7.0.3/code/modules/exporting.js"></script>
    <script src="../../pluggins/Highcharts_7.0.3/code/modules/export-data.js"></script>
    <script src="../../js/plotly-latest.min.js"></script>
    <script src="../../pluggins/Highcharts_7.0.3/code/modules/drilldown.js"></script>
    <script src="../../js/funciones/reportes/articulo.js"></script>
</body>

</html>

<?php
    if($_SESSION['mensaje'] != "")
    { ?>
<script>
    <?=$_SESSION['mensaje'];$_SESSION['mensaje']="";?>;

</script>
<?php } ?>

<script type="text/javascript">
    function genbarrasResumen(json) {
        var parsed = JSON.parse(json);
        var arr = [];
        for (var x in parsed) {
            arr.push(parsed[x]);
        }
        return arr;
    }

</script>

<script type="text/javascript">
    datosX = genbarrasResumen('<?php echo $datosX ?>');
    datosY = genbarrasResumen('<?php echo $datosY ?>');
    datosX1 = genbarrasResumen('<?php echo $datosX1 ?>');
    datosY1 = genbarrasResumen('<?php echo $datosY1 ?>');


    var trace1 = {
        x: datosX,
        y: datosY,
        name: 'ITSL',
        type: 'bar'
    };

    var trace2 = {
        x: datosX1,
        y: datosY1,
        name: 'Externo',
        type: 'bar'
    };

    var data = [trace1, trace2];

    var layout = {
        barmode: 'group'
    };

    Plotly.newPlot('graficalineal', data, layout);

</script>

<script type="text/javascript">
    function genbarrasExtenso(json) {
        var parsed = JSON.parse(json);
        var arr = [];
        for (var x in parsed) {
            arr.push(parsed[x]);
        }
        return arr;
    }

</script>

<script type="text/javascript">
    datosExtX = genbarrasExtenso('<?php echo $datosExtX ?>');
    datosExtY = genbarrasExtenso('<?php echo $datosExtY ?>');
    datosExtX1 = genbarrasExtenso('<?php echo $datosExtX1 ?>');
    datosExtY1 = genbarrasExtenso('<?php echo $datosExtY1 ?>');


    var trace1 = {
        x: datosExtX,
        y: datosExtY,
        name: 'ITSL',
        type: 'bar'
    };

    var trace2 = {
        x: datosExtX1,
        y: datosExtY1,
        name: 'Externo',
        type: 'bar'
    };

    var data = [trace1, trace2];

    var layout = {
        barmode: 'group'
    };

    Plotly.newPlot('graficalinealextenso', data, layout);

</script>

<script type="text/javascript">
    function genbarrasA(json) {
        var parsed = JSON.parse(json);
        var arr = [];
        for (var x in parsed) {
            arr.push(parsed[x]);
        }
        return arr;
    }

</script>

<script type="text/javascript">
    datosAX = genbarrasA('<?php echo $datosAX ?>');
    datosAY = genbarrasA('<?php echo $datosAY ?>');
    datosAX1 = genbarrasA('<?php echo $datosAX1 ?>');
    datosAY1 = genbarrasA('<?php echo $datosAY1 ?>');


    var trace1 = {
        x: datosAX,
        y: datosAY,
        name: 'ITSL',
        type: 'bar'
    };

    var trace2 = {
        x: datosAX1,
        y: datosAY1,
        name: 'Externos',
        type: 'bar'
    };

    var data = [trace1, trace2];

    var layout = {
        barmode: 'group'
    };

    Plotly.newPlot('graficalinealart', data, layout);

</script>

<script type="text/javascript">
    function genbarrasA(json) {
        var parsed = JSON.parse(json);
        var arr = [];
        for (var x in parsed) {
            arr.push(parsed[x]);
        }
        return arr;
    }

</script>

<script type="text/javascript">
    datosApX = genbarrasA('<?php echo $datosApX ?>');
    datosApY = genbarrasA('<?php echo $datosApY ?>');
    datosApX1 = genbarrasA('<?php echo $datosApX1 ?>');
    datosApY1 = genbarrasA('<?php echo $datosApY1 ?>');


    var trace1 = {
        x: datosApX,
        y: datosApY,
        name: 'ITSL',
        type: 'bar'
    };

    var trace2 = {
        x: datosApX1,
        y: datosApY1,
        name: 'Externos',
        type: 'bar'
    };

    var data = [trace1, trace2];

    var layout = {
        barmode: 'group'
    };

    Plotly.newPlot('graficalinealartp', data, layout);

</script>









