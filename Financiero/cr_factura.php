<?php
    if($recibo==null)
        header("Location: facturacion.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/index/navbar-fixed-left.min.css" rel="stylesheet">
        <link href="../css/index/indexstyle.css" rel="stylesheet" media="screen">
        <link href="../css/index/navbar-fixed-left.min.css" rel="stylesheet">
        <link href="../css/index/menu.css" rel="stylesheet" media="screen">
        <link href="../css/index/estilos.css" rel="stylesheet" media="screen">
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        
        <!--ALERTAS-->
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
        <!-- CSS -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css"/>
        <!--ALERTAS-->
        <title>FACTURACIÓN - CID TEC LERDO</title>
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
                            <button href="#" class="btn btn-info dropdown-toggle" data-toggle="dropdown" type="button"><?php echo $_SESSION["nameuser"]?> <b class="caret"></b></button>
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
            <div class="container-fluid">
                <div class="panel panel-default" id="sombra">
                    <div class="panel-body">
                        <h2>FACTURACIÓN PARA EL RECIBO CON FOLIO: <?=$recibo?></h2>
                        <hr>
                        <div class="container-fluid">
                            <div class="panel panel-default">
                                <div class="panel panel-heading" style="background-color: <?=color_revista();?>">
                                </div>
                                <form action="envia_factura.php" method="post" enctype="multipart/form-data"> 
                                    <div class="panel-body">
                                        <input hidden name="idRecibo" value="<?=$recibo?>">
                                        <fieldset>
                                            <legend>DATOS DEL SOLICITANTE</legend>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4>RFC</h4>
                                                    <input type="text" class="form-control" style="text-align: center;" value="<?=$Razon_Social?>" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <h4>RFC</h4>
                                                    <input type="text" class="form-control" style="text-align: center;" value="<?=$rfc?>" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <h4>País</h4>
                                                    <input type="text" class="form-control" style="text-align: center;" value="<?=$pais?>" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <h4>Estado</h4>
                                                    <input type="text" class="form-control" style="text-align: center;" value="<?=$estado?>" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <h4>Ciudad</h4>
                                                    <input type="text" class="form-control" style="text-align: center;" value="<?=$ciudad?>" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <h4>Domicilio</h4>
                                                    <input type="text" class="form-control" style="text-align: center;" value="<?=$domicilio?>" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <h4>Código Postal</h4>
                                                    <input type="text" class="form-control" style="text-align: center;" value="<?=$cp?>" readonly>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <center><div class="container-fluid">
                                                    <h4>Artículo(s)</h4>
                                                    <h4><?=$articulos?></h4>
                                                </div></center>
                                            </div>
                                            <hr>
                                        </fieldset>
                                        <br>
                                        <fieldset>
                                            <legend>DATOS DE FACTURACIÓN</legend>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h4>Forma de Pago</h4>
                                                    <input type="text" class="form-control" style="text-align: center;" name="pago" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <h4>Régimen Fiscal</h4>
                                                    <input type="text" class="form-control" style="text-align: center;" name="regimen" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <h4>Folio de Factura</h4>
                                                    <input type="text" class="form-control" style="text-align: center;" name="folio" required>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <br>
                                        <fieldset>
                                            <legend>ARCHIVOS DE FACTURACIÓN</legend>
                                            <p>A continuación se deben seleccionar los archivos de factura.</p>
                                            <div class="container-fluid">
                                                <label>Elegir archivo XML</label>
                                                <input type="file" name="archivoxml" class="form-control" accept=".xml" required>
                                                <br>
                                                <label>Elegir archivo PDF</label>
                                                <input type="file" name="archivopdf" class="form-control" accept=".pdf" required>
                                            </div>
                                            <br>
                                        </fieldset>
                                        <fieldset>
                                            <legend>OTRO</legend>
                                            <textarea type="text" class="form-control" name="otro"></textarea>
                                        </fieldset>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <a class="btn btn-danger btn-lg btn-block" href="facturacion.php">Cancelar</a>
                                            </div>
                                            <div class="col-md-6">
                                                <button class="btn btn-primary btn-lg btn-block" type="submit" name="subir_fact">Enviar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
<?php } ?>