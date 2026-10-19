<?php
/*
    include("usuario.php");
    session_start();*/
    include("usuario.php");
    include_once("../conexion.php");
    $conexion = conectar();
    $filaRegGeneral = $conexion->query("SELECT Fecha_Limite_Extenso_Modificado FROM registro ORDER BY id_registro DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    $limiteExtModGeneral = $filaRegGeneral["Fecha_Limite_Extenso_Modificado"] ?? "";
    session_start();    
    if($_SESSION["id"]=="")
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
        <title>INICIO - CID TEC LERDO</title>
    </head>
    <body>
    <!--cabecera de página-->
        <br/>
        <!--fin de cabecera de página-->
        <!--logotipos de dependencias-->
        <div class="logos">
            <img class="imagenlogo" src="../img/header_portal_vigente_1170.png">
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
                                <li class=""><a href="editar_perfil.php">Editar perfil</a></li>
                                <li class="divider"></li>
                                <li><a href="../destruir_sesion.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
                            </ul>
                        </li>
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
        <!--SECCIÓN1 - PERFIL-->
        <div class="container">
            <div class="container-fluid">
                <div class="panel panel-default" id="sombra">
                    <div class="panel-body">
                        <h2>SUBIR DOCUMENTOS</h2>
                        <hr>
                        <div class="container-fluid">
                            <div class="panel panel-default">
                                <div class="panel panel-heading" style="background-color: <?=color_revista();?>">
                                </div>
                                <div class="panel-body">
                                    <form action="envia_documentos.php" method="post" enctype="multipart/form-data">
                                        <center>
                                            <?php /* antes 
                                                    if(date("Y-m-d")>limite_extenso_modificado()){
                                                    $_SESSION["mensaje"]="alertify.error('La fecha para enviar extensos modificados y presentaciones ha llegado al límite.')";
                                                */
                                                if(date("Y-m-d")>$limiteExtModGeneral){
                                                    $_SESSION["mensaje"]="alertify.error('La fecha para enviar extensos modificados y presentaciones ha llegado al límite.')";?>
                                                    <h4 style="color:red">La fecha para subir resumenes, extensos, extensos modificados y presentaciones ha llegado a su límte.</h4>
                                                <?php }else{ ?>
                                            <div class="container-fluid">
                                                <p>Seleccione el tipo de documento que desea subir.</p>
                                                <select class="form-control" style="width: 30%" id="tipo" name="tipo" onchange="tipo_documento()">
                                                    <option style="display: none">Selecciona el tipo de documento</option>
                                                    <option value="EM">Extenso Modificado</option>
                                                    <option value="CA">Carta de Autorización</option>
                                                </select>
                                            </div>
                                            <br>
                                            <div class="container-fluid" style="border: solid 1.5px; border-color: <?=color_revista();?>; width: 50%; height: 100%">
                                                <fieldset>
                                                    <div id="p1">
                                                        <!--legend>Subir extenso modificado.</legend-->
                                                    </div>
                                                    <div id="p2">
                                                        <br>
                                                        <label>Clave del artículo</label>
                                                        <input class="form-control" type="text" name="clave" maxlength="6" required>
                                                    </div>
                                                    <br>
                                                        <input class="form-control" type="file" name="archivo" style="text-align:center" accept=".docx, .pdf" id="input" disabled required>
                                                    <br>
                                                    <div id="p3">
                                                        
                                                    </div>
                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-primary btn-block" name="subir">Subir documento</button>
                                                    </div>
                                                    <br>
                                                </fieldset>
                                            </div>
                                           <?php } ?>
                                        </center>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
<script type="text/javascript">
    function tipo_documento(){
        var x = document.getElementById("tipo").selectedIndex;
        if(x==1){
            document.getElementById("p1").innerHTML='<legend>Subir extenso modificado.</legend>';
            document.getElementById("p3").innerHTML='<p align="justify"><b>¡Atención!</b> Recuerda que la <u>clave del artículo</u> debe ser idéntica a la que se te asignó por el sistema. Por ejemplo "CID999".</p>';
            document.getElementById("input").disabled = false;
            document.getElementById("input").attr(acept) = ".docx";
        }
        if(x==2){
            document.getElementById("p1").innerHTML='<legend>Subir Carta de Autorización.</legend>';
            document.getElementById("p3").innerHTML='<p align="justify"><b>¡Atención!</b> Recuerda que la <u>clave del artículo</u> que ingreses de tu carta de autorización sea idéntica a la clave del artículo que se te aceptó. Por ejemplo "CID999".</p>';
            document.getElementById("input").disabled = false;
            document.getElementById("input").attr(acept) = ".pdf";
        }
    }
</script>
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