<?php

session_start();
include('../conexion.php');
$conexion = conectar();
$color = color_revista();
$clave_articulo = $_GET['clave'];

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
        <br>
            <?php
        try{
            $articulo_detalle = "select re.idArticulo as idArticulo, ar.Nombre_Articulo as nombre_art, ar.Nombre_ingles as nombre_ingles,
			re.Resumen_Art as resumen, re.Abstract_Art as abstract, 
            re.Palabras_Clave as palabras, re.Keywords as keywords, 
            (case ar.Aceptado when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Status, 
            ar.idLinea from resumen as re inner join articulo as ar  on ar.idArticulo = re.idArticulo
            where ar.Clave_Articulo = '$clave_articulo'";
            $gsent = $conexion->prepare($articulo_detalle);
            $gsent->execute();
            $detalle_result = $gsent->fetchAll();

            foreach($detalle_result as $dato_detalle) {
                $idArticulo_res = $dato_detalle['idArticulo'];
                $titulo_esp = $dato_detalle['nombre_art'];
                $titulo_ingles = $dato_detalle['nombre_ingles'];
                $resumen_res = $dato_detalle['resumen'];
                $abstract_res = $dato_detalle['abstract'];
                $palabras_res = $dato_detalle['palabras'];
                $keywords_res = $dato_detalle['keywords'];
                $status_res = $dato_detalle['Status'];
                $idlinea_res = $dato_detalle['idLinea'];}
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
        <h3>Título en español</h3>
            <input 
                type="text" 
                class="form-control" 
                value="<?php echo htmlspecialchars($titulo_esp, ENT_QUOTES, 'UTF-8'); ?>" 
                readonly
            >

            <h3>Título en inglés</h3>
            <input 
                type="text" 
                class="form-control" 
                value="<?php echo htmlspecialchars($titulo_ingles, ENT_QUOTES, 'UTF-8'); ?>" 
                readonly
            >
                <form action="actualizar_resumen.php" method="post">

                <input 
                    type="hidden" 
                    name="idArticulo" 
                    value="<?php echo $idArticulo_res; ?>"
                >

                <div class="row">

                    <div class="col-sm-12">

                        <h3>Resumen</h3>

                        <textarea 
                            name="resumen" 
                            class="form-control" 
                            rows="12"><?php echo htmlspecialchars($resumen_res, ENT_QUOTES, 'UTF-8'); ?></textarea>

                        <h3>Palabras Clave</h3>

                        <input 
                            type="text" 
                            name="palabras_clave"
                            class="form-control" 
                            value="<?php echo htmlspecialchars($palabras_res, ENT_QUOTES, 'UTF-8'); ?>"
                        >

                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-12">

                        <h3>Abstract</h3>

                        <textarea 
                            name="abstract" 
                            class="form-control" 
                            rows="12"><?php echo htmlspecialchars($abstract_res, ENT_QUOTES, 'UTF-8'); ?></textarea>

                        <h3>Keywords</h3>

                        <input 
                            type="text" 
                            name="keywords"
                            class="form-control" 
                            value="<?php echo htmlspecialchars($keywords_res, ENT_QUOTES, 'UTF-8'); ?>"
                        >

                    </div>

                </div>

                <br>

                    <button class="btn btn-primary btn-md" type="submit" style="width: 48%;"
                           name="enviar" id="enviar">Guardar</button>
                                  

            </form>
    </body>
</html>

