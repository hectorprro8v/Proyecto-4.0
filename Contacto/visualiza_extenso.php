<?php 
    include("../conexion.php");
    $conexion=conectar();
    $clave_articulo = $_GET['clave'];
    if($clave_articulo==null)
    {
        header("Location: articulos.php");
    }
    error_reporting(E_ALL ^ E_NOTICE);

    $sql="select Nombre_Articulo, Nombre_Documento from documento as doc, articulo as ar where doc.idArticulo = ar.idArticulo and ar.Clave_Articulo = '$clave_articulo'";
    $sentencia=$conexion->prepare($sql);
    $sentencia->execute();
    foreach($sentencia as $dato)
    {
        $nombre_doc = $dato["Nombre_Documento"];
        $nombre_art = $dato["Nombre_Articulo"];
    }
    $url="http://docs.google.com/gview?url=http://sicsacid.itslerdo.edu.mx/Documentos/Extensos/E-$clave_articulo-$nombre_doc&embedded=true";
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
        <!--CUERPO DE LA PÁGINA-->
                <div class="container-fluid">
                    <div class="panel panel-default" id="sombra">
                        <div class="panel-body">
                            <h1><?php echo $clave_articulo.": ".$nombre_art ?></h1>
                            <hr>   
                            <div class="container-fluid">
                                <div class="panel panel-default">
                                    <div class="panel-heading" id="color-head-panel">
                                    </div>
                                    <div class="panel-body">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <!--h3>En construcción</h3-->
                                            </div>
                                            <div class="container-fluid">
                                                <!--center><img src="../img/enconstruccion.jpg"></center-->
                                                <iframe src="<?=$url?>"  frameborder="0" width="100%" height="500px"></iframe>         
                                            </div>
                                            <div class="modal-footer">
                                                <div class="row container-fluid">
                                                    <a type="button" class="btn btn-danger btn-lg" style="width: 48%;" href='javascript:window.history.go(-1);'><span class="glyphicon glyphicon-chevron-left"></span>Regresar</a>
                                                    <?php 
                                                        if($dictamen_resumen == 1 && $dictamen_extenso == 1)
                                                        {?>
                                                            <a type="button" class="btn btn-primary btn-lg" style="width: 48%;" href="fichas_de_pago.php"><span class="glyphicon glyphicon-usd"></span>Pagar ahora</a>
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
    </body>
</html>
<script type="text/javascript">
    function word()
    {
        if(window.location("../Documentos/Extensos/ClaveCID001PruebaExtenso.docx"))
        {
            file.open("../Documentos/Extensos/ClaveCID001PruebaExtenso.docx");
            alert("Existe documento");   
        }
    }
</script>