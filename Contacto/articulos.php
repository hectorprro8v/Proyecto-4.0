<?php
    include('consulta_articulos.php');
    if($_SESSION["id"]=="")
    {
        header("Location: ../index.php");
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
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-3.2.1.min.js"></script>

    <!--ALERTAS-->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
    <!--ALERTAS-->

    <title>ARTÍCULOS - CID TEC LERDO</title>
</head>

<body>
    <!--cabecera de página-->
    <br />
    <!--fin de cabecera de página-->
    <!--logotipos de dependencias-->
    <div class="logos">
        <img class="imagenlogo" src="../img/header_portal_vigente_1170.png" />
    </div>
    <!--fin de logotipos de dependencias-->
    <!--Menu-->
    <br>
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-left" role="navigation">
            <div class="navbar-header">
                <button type="button" style="color:red;" class="navbar-toggle" data-toggle="collapse"
                    data-target=".navbar-ex1-collapse">
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
                        <button href="#" class="btn btn-info dropdown-toggle" data-toggle="dropdown" type="button"
                            style="margin-left:10px;"><?php echo $_SESSION["nameuser"]?> <b class="caret"></b></button>
                        <ul class="dropdown-menu">
                            <li class=""><a href="perfil.php"><span class="glyphicon glyphicon-user"></span> Perfil</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="../destruir_sesion.php"><span class="glyphicon glyphicon-log-out"></span>
                                    Salir</a></li>
                        </ul>
                    </li>
                    <li class="" style="margin-left:20px"><a href="resumenes.php">Resumen </a></li>
                    <li class="" style="margin-left:20px"><a href="articulos.php">Artículos</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="margin-left:20px"> Documentos
                            <b class="caret"></b></a>
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
            <div class="panel-body">
                <h2>ARTÍCULOS</h2>
                <hr>
                <div class="container-fluid">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background-color: <?=color_revista();?>">
                        </div>
                        <div class="panel-body">
                            <div class="container-fluid">
                                <p>A continuación se muestran los artículos enviados y su estado.</p>
                                <div class="table-responsive">
                                    <table class="table" id="tabla_resumen">
                                        <thead class="" style="background-color: black; color: white;">
                                            <tr>
                                                <th style="width: 15%">Clave Articulo</th>
                                                <th style="width: 40%">Título</th>
                                                <th style="width: 15%">Estado</th>
                                                <th style="width: 10%">Recibo</th>
                                                <th style="width: 5%">Extenso</th>
                                                <th style="width: 5%">Dictamen</th>
                                                <th style="width: 5%">Resultado de <br>Similitud</th>
                                                <th style="width: 5%">Carta de publicación</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                foreach($articulos_result as $dato_articulo){ ?>
                                            <tr>
                                            <?php 
                                                $clave_articulo = $dato_articulo['Clave_Articulo'];
                                                $nombre_articulo = $dato_articulo['Nombre_Articulo'];
                                                $extenso_articulo = $dato_articulo['Extenso'];
                                                $estado_extenso_articulo = $dato_articulo['Estado'];
                                                $extenso = $dato_articulo['Status_Ext'];
                                                $concluido = $dato_articulo['Concluido'];
                                                $publi = $dato_articulo['P'];
                                                $idArticulo = $dato_articulo['idArticulo'];
                                                if($extenso == 'Aceptado'){
                                                    ?>
                                                        <tr style="background-color: #b7ffd2;">
                                            <?php
                                                }else if($extenso == 'No aceptado'){
                                                    ?>
                                                        <tr style="background-color: #ffb7b7;">
                                            <?php
                                                }else if($extenso == 'Segunda Revision'){
                                                    ?>
                                                        <tr style="background-color: #fcfeb8;">
                                            <?php
                                                }else{
                                                    ?>
                                                        <tr>
                                            <?php
                                                }
                                                if(($extenso_articulo != null )and $concluido == 1){
                                                    switch($estado_extenso_articulo)
                                                    {
                                                    case "Aceptado":
                                                        $dictamen = "<a type='button' class='btn btn-success btn-md' href='dictamen_extenso.php?clave=$clave_articulo' target='_blank'>Dictamen</a>"; 
                                                        $recibo = "NA";
                                                        break;
                                                        case "No aceptado": $dictamen = "<a type='button' class='btn btn-danger btn-md' href='dictamen_extenso.php?clave=$clave_articulo' target='_blank'>Dictamen</a>";
                                                        $recibo = "NA";
                                                        break;
                                                        case !'En Revision': $dictamen="";
                                                        $recibo = "NA";
                                                         break;
                                                    }
                                                    $descargar="<a type='button'class='btn btn-success btn-md' href='extenso.php?clave=$clave_articulo'>Descargar</a>";
                                                    $descargar2="<a type='button'class='btn btn-info btn-md' href='resSimilitud.php?clave=$clave_articulo'>Descargar</a>";
                                                }else{
                                                    $extenso = "<a type='button'class='btn btn-primary btn-md' href='visualiza_resumen.php?clave=".$clave_articulo."'>Subir extenso</a>";
                                                    $recibo = "NA";
                                                    $descargar="";
                                                ?>
                                            <tr>

                                                <?php
                                                                }?>

                                                <td><?php echo $clave_articulo ?></td>
                                                <td><?php echo $nombre_articulo ?></td>
                                                <?php 
                                                // Nota: se removió la condición basada en statusExtensoMod (columna eliminada
                                                // del nuevo esquema, ligada al esquema anterior de múltiples rondas de corrección).
                                                // Pendiente de rediseñar cuando se simplifique el módulo de dictamen a resultado único.
                                                echo "<td>$extenso</td>";
                                                ?>
                                                <td><?php echo $recibo ?></td>
                                                <td><?php echo $descargar?></td>
                                                <td><?php echo $dictamen ?></td>
                                                <td><?php echo $descargar2?></td>
                                                <?php 
                                                    if ($publi == 1) {
                                                        $con=conectar();
                                                        $idContacto = $_SESSION['id'];
                                                        $sql = $con->prepare("SELECT D.URL as URL from articulo as A inner join documento as D on A.idArticulo=D.idArticulo
                                                                    where A.Publicado=1 and D.Tipo_Documento='CP' and A.idContacto = $idContacto  and A.Clave_Articulo = '$clave_articulo';");
                                                        $sql->execute();
                                                        $sql->setFetchMode(PDO::FETCH_NUM);
                                                        $result = $sql->fetchAll();
                                                        $dato = $result[0];
                                                        ?>
                                                <td>
                                                    <center><a class="btn btn-success float-right btn-sm"
                                                            href=<?php ECHO $dato[0]; ?> target="_blank">DESCARGAR</a>
                                                    </center>
                                                </td>
                                                <?php
                                                    }
                                                    else {
                                                        echo '<td> No disponible </td>';
                                                    }
                                                ?>
                                            </tr>
                                            <!--MODAL PARA MOSTRAR EL COMENTARIO POR REVISOR-->
                                            <!--<td><a type="button" class="btn btn-primary btn-md" href="comentarios_Crit_Gen.php?clave=<?=$clave_articulo?>"></td>-->
                                            <!-------------------------------------------->
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
    <!--INICA EL PIÉ DE PÁGINA-->
    <div class="lineasep"><img src="../img/line.gif" /></div>
    <div class="contactos">
        <table>
            <tr>
                <td><a
                        href="https://www.facebook.com/pages/Instituto-Tecnol%C3%B3gico-Superior-de-Lerdo-P%C3%A1gina-Oficial/285056498195463"><img
                            src="../img/face.jpg" /></a></td>
                <td><a
                        href="https://twitter.com/ITSLerdo?ref_src=twsrc%5Etfw&ref_url=http%3A%2F%2Fwww.itslerdo.edu.mx%2F"><img
                            src="../img/tw.jpg" /></a></td>
                <td><a><img src="../img/correoitsl.gif" /></a></td>
            </tr>
        </table>
    </div>
    <!-- Pie de página-->
    <div class="pie_pagina">
        <img src="../img/pie_pagina.jpg" />
        <p>Av. Tecnológico N 1555 Sur Periferico Gomez Lerdo Km. 14.5
            <br />C.P. 35150 Cd. Lerdo, Dgo
            <br />Tels. 01 (871) 725 23 71, 725 57 79, 725 58 02
        </p>
    </div>
</body>

</html>
<?php
    if(isset($_SESSION['mensaje']))
    { ?>
<script type="text/javascript">
alertify.set('notifier', 'position', 'top-right');
<?=$_SESSION['mensaje'];
                $_SESSION["mensaje"]=null;
            ?>;
</script>
<?php } ?>