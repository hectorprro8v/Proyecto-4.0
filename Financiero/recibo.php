<?php
    include("usuario.php");
    $recibo = $_GET['recibo'];
    if($recibo==null)
    {
        header("Location: facturacion.php");
    }
    $conexion = conectar();

    $sql2 = "select Fecha, RFC, Pais, Estado, Ciudad, Domicilio, CP, Sub_Total, Iva, Total, df.idDocumento as documento from recibo_pago as rp left join documentos_financiero as df on df.idRecibo = rp.idRecibo where rp.idRecibo = $recibo";
    $select_recibo_recibo = $conexion->prepare($sql2);
    $select_recibo_recibo->execute();

    foreach($select_recibo_recibo as $datos)
    {
        $Fecha = $datos["Fecha"];
        $RFC = $datos["RFC"];
        $Pais = $datos["Pais"];
        $Estado = $datos["Estado"];
        $Ciudad = $datos["Ciudad"];
        $Domicilio = $datos["Domicilio"];
        $CP = $datos["CP"];
        $Subtotal = $datos["Sub_Total"];
        $Iva = $datos["Iva"];
        $Total = $datos["Total"];
        $documento = $datos["documento"];
    }  

    $sql3 = "select ar.Clave_Articulo as clave, ar.Nombre_Articulo as titulo from articulo as ar, recibo_pago_detalle as rpd where ar.idArticulo = rpd.idArticulo and rpd.idRecibo = $recibo";
    $select_claves = $conexion->prepare($sql3);
    $select_claves->execute();
?>  
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        
        <link href="../css/index/indexstyle.css" rel="stylesheet" media="screen">
        <link href="../css/index/menu.css" rel="stylesheet" media="screen">
        <link href="../css/index/estilos.css" rel="stylesheet" media="screen">
        <link href="../css/index/navbar-fixed-left.min.css" rel="stylesheet">
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        
        <!--ALERTAS-->
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
        <!-- CSS -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css"/>
        <!--ALERTAS-->
        
        <title>RECIBO DE PAGO - CID TEC LERDO</title>
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
                            <button href="#" class="btn btn-info dropdown-toggle" data-toggle="dropdown" type="button"><?php echo $nombres." ".$apellidop." "?> <b class="caret"></b></button>
                            <ul class="dropdown-menu">
                                <li class=""><a href="perfil.php"><span class="glyphicon glyphicon-user"></span> Perfil</a></li>
                                <li class="divider"></li>
                                <li><a href="../destruir_sesion.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
                            </ul>
                        </li>
                        <li class=""><a href="facturacion.php"><span class="glyphicon glyphicon-list-alt"></span> Facturación</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                    </ul>
                </div>
            </nav>
        </div>
        <br>
            <!--CUERPO DE LA PÁGINA-->
                <div class='container-fluid'>
                    <div class='panel panel-default' id='sombra'>
                        <div class='panel-body'>
                            <div class='container-fluid' style='border: 2px solid'>
                                <br>
                                <div class='table-responsive'>
                                    <table>
                                        <th width='15%'><img src='../img/LogoTEC.png'></th>
                                        <th width='55%'><b><h2>INSTITUTO TECNOLÓGICO SUPERIOR DE LERDO</h2></b></th>
                                        <th width='30%'><img src='../img/LogoBanamex.png' width="300px"></th>
                                    </table>
                                </div>
                                <hr style='border: 1px solid'>
                                <div class='container-fluid'>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <th width='50%'><h3><b>Folio del recibo: </b><?=$recibo?></h3><br></th>
                                        </div>
                                        <div class="col-md-6">
                                            <th width='50%'><h3><b>Fecha de creación del recibo: </b><?=$Fecha?></h3></th>
                                        </div>
                                    </div>
                                    <br>
                                    <h4><b>RFC: </b><?=$RFC?></h4><br>
                                    <h4><b>Dirección: </b><?=$Domicilio?>, C.P. <?=$CP?>, <?=$Ciudad?>, <?=$Estado?>, <?=$Pais?></h4><br>
                                    <br>
                                        <h4><b>Artículo(s) que se pagan</b></h4>
                                        
                                        <?php foreach($select_claves as $datos)
                                                { 
                                                    $clave = $datos["clave"];
                                                    $titulo = $datos["titulo"];
                                        ?>
                                                    <h4><?php echo $clave." ".$titulo ?> </h4>
                                        <?php   } ?>
                                    <br>
                                    <br>
                                    <table>
                                        <td width='20%'><h4><b>Subtotal: </b><?=$Subtotal?></h4></td>
                                        <td width='20%'><h4><b>Iva: </b><?=$Iva?></h4></td>
                                        <td width='20%'><h4><b>Total a pagar: </b><?=$Total?></h4></td>
                                    </table>
                                </div><br>
                            </div><br>
                            <div class="row">
                                    <center><a type="button" class="btn btn-danger btn-lg" href='javascript:window.history.go(-1);'>Regresar</a>
                                    <input class="btn btn-lg" type="button" name="imprimir" value="Imprimir P&aacute;gina" onclick="window.print();">
                                        <?php
                                    if($documento==null)
                                    {?>
                                        <button class='btn btn-info btn-lg' data-toggle='modal' data-target='#comprobante'>Subir comprobante</button>
                                    <?php } ?></center>
                            </div>
                        </div>
                    </div>
                </div>
            <form action="envia_comprobante.php" method="post" enctype="multipart/form-data" name="subeextenso">
            <!--MODAL ENVIAR EXTENSO-->
                <div class="modal fade" id="comprobante" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <div class="modal-title">
                              <b><h2>COMPROBANTE DE PAGO</h2></b>
                            </div>
                        </div>
                        <div class="modal-body">
                            <p style="color: blue;" align="justify">Favor de asegurarse que el comprobante de pago corresponda a los artículos seleccionados cuando se generó la ficha de pago.</p>
                            <br>
                            <div class="container-fluid">
                                <input name="idRecibo" id="id" hidden>
                                <input name="clave" id="clave" hidden>
                                <label>Elegir archivo </label>
                                <input type="file" name="archivo" class="form-control">
                            </div>
                            <br>
                            <p>El archivo debe ser en formato .pdf (documento de PDF).</p>
                            <br>
                        </div>
                        <div class="modal-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cancelar</button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-primary btn-block" type="submit" name="subir_comp">Subir</button>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
            </form>
            <!--MODAL ENVIAR EXTENSO-->
    </body>
</html>