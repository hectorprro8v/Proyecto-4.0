<?php
    $dir = $_GET['dir'];
    $recibo = $_GET['recibo'];
    if($dir==""&&$recibo=="")
    {
        header("Location: articulos.php");
    }
    include("../conexion.php");
    $conexion = conectar();

    switch($dir)
    {
        case "art":
            $sql1 = "select rp.idRecibo as recibo from recibo_pago as rp, recibo_pago_detalle as rpd, articulo as ar where rp.idRecibo = rpd.idRecibo and rpd.idArticulo = ar.idArticulo and ar.Clave_Articulo = '$recibo'";
        
            $select_recibo = $conexion->prepare($sql1);
            $select_recibo->execute();

            foreach($select_recibo as $datos)
            {
                $idRecibo = $datos["recibo"];
            }
            break;
        case "fich":
            $idRecibo = $recibo;
            break;
    }

    $sql2 = "select Fecha, RFC, Pais, Estado, Ciudad, Domicilio, CP, Sub_Total, Iva, Total, df.idDocumento as documento from recibo_pago as rp left join documentos_financiero as df on df.idRecibo = rp.idRecibo where rp.idRecibo = $idRecibo";
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

    $sql3 = "select ar.Clave_Articulo as clave, ar.Nombre_Articulo as titulo from articulo as ar, recibo_pago_detalle as rpd where ar.idArticulo = rpd.idArticulo and rpd.idRecibo = $idRecibo";
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
            <!--CUERPO DE LA PÁGINA-->
                <div class='container-fluid'>
                    <div class='panel panel-default' id='sombra'>
                        <div class='panel-body'>
                            <div class='container-fluid' style='border: 2px solid'>
                                <br>
                                <div class='table-responsive'>
                                    <table>
                                        <th width='15%'><img src='../img/LogoTEC.png'></th>
                                        <th width='55%'><b><h3>INSTITUTO TECNOLÓGICO SUPERIOR DE LERDO</h3></b></th>
                                        <th width='30%'><img src='../img/LogoBanamex.png' width="300px"></th>
                                    </table>
                                </div>
                                <hr style='border: 1px solid'>
                                <div class='container-fluid'>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <th width='50%'><h4><b>Folio del recibo: </b><?=$idRecibo?></h4><br></th>
                                        </div>
                                        <div class="col-md-6">
                                            <th width='50%'><h4><b>Fecha de creación del recibo: </b><?=$Fecha?></h4></th>
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
                                                    <h3><?php echo $clave." ".$titulo ?> </h3>
                                        <?php   } ?>
                                    <br>
                                    <br>
                                    <h4><b>BANCO: BANAMEX</b></h4><br>
                                    <h4><b>SUCURSAL: 4257</b></h4><br>
                                    <h4><b>CUENTA: 28450</b></h4><br>
                                    <h4><b>CLABE NTERBANCARIA: 002 060 425700284503</b></h4><br>
                                    <h4><b>TITULAR: INSTITUTO TECNOLÓGICO SUPERIOR DE LERDO</b></h4><br>
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
                                    </center>
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