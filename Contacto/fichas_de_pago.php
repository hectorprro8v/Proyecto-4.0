<?php
    include("consulta_art_fich.php");
    $color = color_revista();
    $idContacto=$_SESSION["id"];
    if($idContacto=="")
    {
        header("Location: ../index.php");
    }
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
        
        <title>FICHAS DE PAGO - CID TEC LERDO</title>
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
        <!--CUERPO DE LA PÁGINA-->
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
                        <li class="" style="margin-left:20px"><a href="resumenes.php">Resumen </a></li>
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
        <!--SECCIÓN1 - PERFIL-->
            <div class="container-fluid">
                <div class="panel panel-default" id="sombra">
                    <div class="panel-body">
                        <h2>RECIBOS Y COMPROBANTES</h2>
                        <hr>
                        <div class="container-fluid">
                            <div class="panel panel-default">
                                <div class="panel panel-heading" style="background-color: <?=$color?>">
                                </div>
                                <div class="panel-body">
                                    <div class="container-fluid">
                                        <div class="table responsive">
                                            <?=mostrar_recibos();?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <form action="envia_comprobante.php" method="post" enctype="multipart/form-data" name="subeextenso">
        <!--MODAL ENVIAR COMPROBANTE-->
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
                        <p style="color: blue;" align="justify">Favor de asegurarse que el comprobante de pago incluya los artículos correspondientes seleccionados cuando se generó la ficha de pago, de lo contrario se invalidará su pago.</p>
                        <br>
                        <div class="container-fluid">
                            <input name="idRecibo" id="id" hidden>
                            <input name="clave" id="clave" hidden>
                            <label>Elegir archivo </label>
                            <input type="file" name="archivo" class="form-control" accept="application/pdf">
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
        <!--MODAL ENVIAR COMPROBANTE-->
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
<script type="text/javascript">
    $('#comprobante').on('show.bs.modal', function(e){
        var clave = $(e.relatedTarget).data().clave;
        document.getElementById('clave').value = clave;
        var id = $(e.relatedTarget).data().id;
        document.getElementById('id').value = id;
    });
</script>
<?php $idRecibo ='<script>document.write(id)</script>' ?>
<?php
    if(isset($_SESSION['mensaje']))
    { ?>
        <script type="text/javascript">
            alertify.set('notifier','position', 'top-right');
            <?=$_SESSION['mensaje'];
                $_SESSION["mensaje"]=null;
            ?>;
        </script>
<?php } ?>