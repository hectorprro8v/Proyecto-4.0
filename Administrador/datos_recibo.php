<?php
include_once "../conexion.php";
session_start();
    include("../verificacion.php");
    Nolink();
    if($_SESSION["id"]=="")
    {
        header("Location: ../index.php");
    }
$conexion=conectar();
$idRecibo=$_GET['recibo'];
if($idRecibo==null)
{

    header('location: fichas_pago.php');
}
//    $idart = $_POST["enviar"];

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
                                        <th width='55%'><b><h1>INSTITUTO TECNOLÓGICO SUPERIOR DE LERDO</h1></b></th>
                                        <th width='30%'><img src='../img/LogoBanamex.png' width="300px"></th>
                                    </table>
                                </div>
                                <hr style='border: 1px solid'>
                                <div class='container-fluid'>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <th width='50%'><h3><b>Folio del recibo: </b><?=$idRecibo?></h3><br></th>
                                        </div>
                                        <div class="col-md-6">
                                            <th width='50%'><h3><b>Fecha de creación del recibo: </b><?=$Fecha?></h3></th>
                                        </div>
                                    </div>
                                    <br>
                                    <h3><b>RFC: </b><?=$RFC?></h3><br>
                                    <h3><b>Dirección: </b><?=$Domicilio?>, C.P. <?=$CP?>, <?=$Ciudad?>, <?=$Estado?>, <?=$Pais?></h3><br>
                                    <br>
                                        <h3><b>Artículo(s) que se pagan</b></h3>
                                        
                                        <?php foreach($select_claves as $datos)
                                                { 
                                                    $clave = $datos["clave"];
                                                    $titulo = $datos["titulo"];
                                        ?>
                                                    <h3><?php echo $clave." ".$titulo ?> </h3>
                                        <?php   } ?>
                                    <br>
                                    <br>
                                    <table>
                                        <td width='20%'><h3><b>Subtotal: </b><?=$Subtotal?></h3></td>
                                        <td width='20%'><h3><b>Iva: </b><?=$Iva?></h3></td>
                                        <td width='20%'><h3><b>Total a pagar: </b><?=$Total?></h3></td>
                                    </table>
                                </div><br>
                            </div><br>
                            <div class="row">
                                    <center><a type="button" class="btn btn-danger btn-lg" href='javascript:window.history.go(-1);'>Regresar</a>
                                    <input class="btn btn-lg" type="button" name="imprimir" value="Imprimir P&aacute;gina" onclick="window.print();">
                                        <?php
                                    if($documento==null)
                                    {?>
                                        <button class='btn btn-success btn-lg' data-toggle='modal' data-target='#modal'>Validar pago</button>
                                    <?php } ?></center>
                            </div>
                        </div>
                    </div>
                </div>
           <form action="validar_pago.php" method="POST" style="display:block">        
                         <div class="modal fade" tabindex=”-1″ id="modal" role="dialog" data-backdrop="static" data-keyboard="false">
                                        <div class="modal-dialog modal-sm" role="document" style="position: absolute;
                                                          top: 150px;
                                                          right: 100px;
                                                          bottom: 0;
                                                          left: 0;
                                                          z-index: 10040;
                                                          overflow: auto;
                                                          overflow-y: auto;
                                                        ">
                                             <div class="modal-content">
                                                <div class="panel panel-warning">
                                                    <div class="panel-heading" style="color:black">
                                                        <button type="button" class="close" data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                
                                                            <h2 class="panel-title">VALIDACIÓN DE PAGO</h2>

                                                             </div>
                                                               <div class="panel-body"> 
                                                                     
                                                                <div class="row">
                                                                <h4> A continuación se validará el pago con número de folio: <b id="folio"></b>  </h4>
                                                                  
                                                                </div> 
                                                               <br><br>
                                                                       
                                                            <div class="row" style="text-align: center;">
                                                               <div class="col-lg-2">
                                                                
                                                             </div>
                                                               <div class="col-lg-4">
                                                               <button id="idfolio" name="val" type="submit" class="btn btn-success" >Aceptar</button>
                                                         
                                                               </div>
                                                               <div class="col-lg-1">
                                                                 <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                                               
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

