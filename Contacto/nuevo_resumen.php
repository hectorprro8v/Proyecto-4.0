<?php 
    include('../conexion.php');
    $conexion = conectar();
    $color = color_revista();
    session_start();
    if($_SESSION["id"]=="")
    {
        header("Location: ../index.php");
    }
    // cargar nombre del usuario
        if(!isset($_SESSION["nameuser"]))
    {
        $consultaUsuario = $conexion->prepare("SELECT Nombres, Apellido_Paterno FROM usuario WHERE idUsuario = :id");
        $consultaUsuario->bindParam(':id', $_SESSION["id"]);
        $consultaUsuario->execute();
        $datosUsuario = $consultaUsuario->fetch(PDO::FETCH_ASSOC);
        $_SESSION["nameuser"] = $datosUsuario["Nombres"]." ".$datosUsuario["Apellido_Paterno"]." ";
    }

    $idRegistro = limite_resumen(date("Y-m-d"));
    if(!$idRegistro){
        header("Location: resumenes.php");
        die();
    }
    /*
    if(date("Y-m-d")>limite_resumen() || date("Y-m-d")<recepcion_resumen()){
        header("Location: resumenes.php");
        die();
    }*/
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
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
    <!--ALERTAS-->
    <?php /*
    <title>CID TEC LERDO - NUEVO RESUMEN</title>
    */?>
    <title>CID TEC LERDO - NUEVO REGISTRO</title>
</head>

<body>
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
                    <?php /*
                    <li class="" style="margin-left:20px"><a href="resumenes.php">Resumen </a></li>
                    */?>
                    <li class="" style="margin-left:20px"><a href="resumenes.php">Registro </a></li>
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
    <br>
    <form role="form" method="post" action="inserta_resumen.php">
        <!--CUERPO DE LA PÁGINA-->
        <div class="container-fluid">
            <div class="panel panel-default" id="sombra">
                <div class="panel-body">
                    <?php /*
                    <h1>NUEVO RESUMEN</h1>
                    */?>
                    <h1>NUEVO REGISTRO</h1>
                    <hr>
                    <div class="container-fluid">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: <?php echo $color?>">
                            </div>
                            <div class="panel-body">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="container-fluid">
                                            <h4 for="Titulo_resumen" style="text-align: center">Título</h4>
                                            <input type="text" class="form-control" style="text-align: center;"
                                                name="titulo" required>
                                        </div>

                                          <div class="container-fluid">
                                            <h4 for="Titulo_abstract" style="text-align: center">Título Inglés</h4>
                                            <input type="text" class="form-control" style="text-align: center;"
                                                name="titulo_ingles" required>
                                        </div>

                                    </div>
                                    <div class="container-fluid">
                                        <div class="col-md-6">
                                            <h4>Linea de Investigación</h4>
                                            <?php
                                                        /*Consulta las lineas de investigación*/
                                                        $lineas = 'select * from linea_investigacion';
                                                        $gsent = $conexion->prepare($lineas);
                                                        $gsent->execute();
                                                        $lineas_result = $gsent->fetchAll();
                                                    ?>
                                            <select class="form-control" name="linea">
                                                <?php 
                                                        foreach($lineas_result as $dato_linea): ?>
                                                <option value="<?php echo $dato_linea['Nombre'] ?>">
                                                    <?php echo $dato_linea['Nombre']?></option>
                                                <?php endforeach ?>
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <h4>Institución</h4>
                                            <input type="text" class="form-control" style="text-align: center;"
                                                name="instituto" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <h4>País</h4>
                                            <input type="text" class="form-control" style="text-align: center;"
                                                name="pais" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <h4>Estado</h4>
                                            <input type="text" class="form-control" style="text-align: center;"
                                                name="estado" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <h4>Ciudad</h4>
                                            <input type="text" class="form-control" style="text-align: center;"
                                                name="ciudad" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <!---->
                                            <h4>Resumen (200 a 250 palabras)</h4>
                                            <textarea class="form-control" rows="5" name="resumen" id="resumen" required
                                            onkeyup="contarPalabras()"></textarea>
                                            <p class="lblPalabras"><span id="lblPalabras">0 de 250 palabras</span></p>
                                            
                                            <script>
                                            var text1 = document.getElementById("resumen");
                                            text1.oninput = function() {
                                                var palabras1 = this.value.match(/\S+/g).length;
                                                if (palabras1 > 250) {
                                                    //Dividor el strin en las primeras 200 palabras despues del ultimo espacio
                                                    var contador1 = this.value.split(/\s+/, 250).join(" ");
                                                    //Añadimos un espacio al final para remplazar el ultimo caracter y evitar insertar mas palabras
                                                    this.value = contador1 + " ";
                                                }
                                            };

                                            function contarPalabras() {
                                                var textoEntero, ContPal, palabras;
                                                textoEntero = document.getElementById('resumen').value;
                                                palabras = textoEntero.split(/\s+/);
                                                ContPal = palabras.length;
                                                document.getElementById('lblPalabras').innerHTML = ContPal-1 + " de 250 palabras";
                                            }
                                            </script>
                                            <h4 class="in-line">Palabras Clave</h4>
                                            <input type="text" class="form-control" name="palabras" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <h4>Abstract (200 to 250 words)</h4>
                                            <textarea class="form-control" rows="5" name="abstract" required
                                                id="abstract" required onkeyup="contarPalabras2()"></textarea>
                                                <p class="lblPalabras2"><span id="lblPalabras2">0 of 250 words</span></p>
                                            
                                            <script>
                                            var text2 = document.getElementById("abstract");
                                            text2.oninput = function() {
                                                var palabras2 = this.value.match(/\S+/g).length;
                                                if (palabras2 > 250) {
                                                    //Dividor el strin en las primeras 200 palabras despues del ultimo espacio
                                                    var contador2 = this.value.split(/\s+/, 250).join(" ");
                                                    //Añadimos un espacio al final para remplazar el ultimo caracter y evitar insertar mas palabras
                                                    this.value = contador2 + " ";
                                                }
                                            };

                                            function contarPalabras2() {
                                                var textoEntero2, ContPal2, palabras2;
                                                textoEntero2 = document.getElementById('abstract').value;
                                                palabras2 = textoEntero2.split(/\s+/);
                                                ContPal2 = palabras2.length;
                                                document.getElementById('lblPalabras2').innerHTML = ContPal2-1 + " of 250 words";
                                            }
                                            </script>
                                            <h4 class="in-line">Keywords</h4>
                                            <input type="text" class="form-control" name="keywords" required>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="container-fluid">
                                            <h4>Autor principal</h4>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="container-fluid">
                                            <div class="col-sm-4">
                                                <h4>Nombre</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="nombresp" required>
                                            </div>
                                            <div class="col-sm-4">
                                                <h4>Apellido Paterno</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="apaternop" required>
                                            </div>
                                            <div class="col-sm-4">
                                                <h4>Apellido Materno</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="amaternop" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>Institución</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="institutop" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>Correo Electrónico</h4>
                                                <input type="email" class="form-control" style="text-align: center;"
                                                    name="emailp" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>ORCID (formato: 0000-0002-6968-4784)</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="orcidp" id="orcidp" 
                                                    placeholder="0000-0002-6968-4784" maxlength="19" pattern="[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{3}[0-9Xx]" 
                                                    title="Capture el ORCID con el formato 0000-0002-6968-4784"
                                                    required>
                                            </div>

                                            <div class="col-sm-6">
                                                <h4>¿Autor de Correspondencia? (Escribir SI en caso afirmativo)</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="cvup" id="cvup">
                                            </div>
                                            <div class="col-sm-12">
                                                <h4>Siglas de Grado Máximo de Estudio</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="gradoestudio" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="col-sm-3">
                                            <h4>Autores secundarios</h4>
                                        </div>
                                        <div class="col-sm-3 input-group two-fields">
                                            <select class="form-control" id="noautoress" onchange="NoAutores()"
                                                style="width: 60%">
                                                <option value="0">Sin coautores</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="container-fluid panel-primary" id="secundario1">
                                            <h3>Coautor 1</h3>
                                            <div class="col-sm-4">
                                                <h4>Nombre</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="nombress1" id="nombre1">
                                            </div>
                                            <div class="col-sm-4">
                                                <h4>Apellido Paterno</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="apaternos1" id="apellidop1">
                                            </div>
                                            <div class="col-sm-4">
                                                <h4>Apellido Materno</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="amaternos1" id="apellidom1">
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>Institución</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="institutos1" id="institucion1">
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>Correo Electrónico</h4>
                                                <input type="email" class="form-control" style="text-align: center;"
                                                    name="emails1" id="correo1">
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>ORCID (formato: 0000-0002-6968-4784)</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="orcids1" id="orcid1" placeholder="0000-0002-6968-4784"
        maxlength="19"
        pattern="[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{3}[0-9Xx]"
        title="Capture el ORCID con el formato 0000-0002-6968-4784">
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>¿Autor de Correspondencia? (Escribir SI en caso afirmativo)</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="cvus1" id="cvu1">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="container-fluid panel-primary" id="secundario2">
                                            <h3>Coautor 2</h3>
                                            <div class="col-sm-4">
                                                <h4>Nombre</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="nombress2" id="nombre2">
                                            </div>
                                            <div class="col-sm-4">
                                                <h4>Apellido Paterno</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="apaternos2" id="apellidop2">
                                            </div>
                                            <div class="col-sm-4">
                                                <h4>Apellido Materno</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="amaternos2" id="apellidom2">
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>Institución</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="institutos2" id="institucion2">
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>Correo Electrónico</h4>
                                                <input type="email" class="form-control" style="text-align: center;"
                                                    name="emails2" id="correo2">
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>ORCID (formato: 0000-0002-6968-4784)</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="orcids2" id="orcid2" placeholder="0000-0002-6968-4784"
        maxlength="19"
        pattern="[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{3}[0-9Xx]"
        title="Capture el ORCID con el formato 0000-0002-6968-4784">
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>¿Autor de Correspondencia? (Escribir SI en caso afirmativo)</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="cvus2" id="cvu2">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="container-fluid panel-primary" id="secundario3">
                                            <h3>Coautor 3</h3>
                                            <div class="col-sm-4">
                                                <h4>Nombre</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="nombress3" id="nombre3">
                                            </div>
                                            <div class="col-sm-4">
                                                <h4>Apellido Paterno</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="apaternos3" id="apellidop3">
                                            </div>
                                            <div class="col-sm-4">
                                                <h4>Apellido Materno</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="amaternos3" id="apellidom3">
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>Institución</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="institutos3" id="institucion3">
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>Correo Electrónico</h4>
                                                <input type="email" class="form-control" style="text-align: center;"
                                                    name="emails3" id="correo3">
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>ORCORCID (formato: 0000-0002-6968-4784)ID</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="orcids3" id="orcid3" placeholder="0000-0002-6968-4784"
        maxlength="19"
        pattern="[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{3}[0-9Xx]"
        title="Capture el ORCID con el formato 0000-0002-6968-4784">
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>¿Autor de Correspondencia? (Escribir SI en caso afirmativo)</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="cvus3" id="cvu3">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="container-fluid panel-primary" id="secundario4">
                                            <h3>Coautor 4</h3>
                                            <div class="col-sm-4">
                                                <h4>Nombre</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="nombress4" id="nombre4">
                                            </div>
                                            <div class="col-sm-4">
                                                <h4>Apellido Paterno</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="apaternos4" id="apellidop4">
                                            </div>
                                            <div class="col-sm-4">
                                                <h4>Apellido Materno</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="amaternos4" id="apellidom4">
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>Institución</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="institutos4" id="institucion4">
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>Correo Electrónico</h4>
                                                <input type="email" class="form-control" style="text-align: center;"
                                                    name="emails4" id="correo4">
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>ORCID (formato: 0000-0002-6968-4784)</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="orcids4" id="orcid4" placeholder="0000-0002-6968-4784"
        maxlength="19"
        pattern="[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{3}[0-9Xx]"
        title="Capture el ORCID con el formato 0000-0002-6968-4784">
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>¿Autor de Correspondencia? (Escribir SI en caso afirmativo)</h4>
                                                <input type="text" class="form-control" style="text-align: center;"
                                                    name="cvus4" id="cvu4">
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group container-fluid">
                                    <div class="modal-footer">
                                        <a type="button" class="btn btn-danger btn-md glyphicon glyphicon-remove"
                                            style="width: 48%;" data-dismiss="modal" href="resumenes.php"> Cancelar</a>
                                        <button class="btn btn-primary btn-md" type="submit" style="width: 48%;"
                                            name="enviar" id="enviar">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--CUERPO DE LA PÁGINA-->
    </form>
</body>

</html>
<script type="text/javascript">
function formatearORCID(input) {
    input.addEventListener('input', function () {
        var valor = this.value.replace(/[^0-9Xx]/g, '');
        if (valor.length > 16) {
            valor = valor.substring(0, 16);
        }

        var resultado = '';
        for (var i = 0; i < valor.length; i++) {
            if (i === 4 || i === 8 || i === 12) {
                resultado += '-';
            }
            resultado += valor[i];
        }

        this.value = resultado;
    });
}
window.onload = function() {
    $("#secundario1").hide();
    $("#secundario2").hide();
    $("#secundario3").hide();
    $("#secundario4").hide();

    formatearORCID(document.getElementById('orcidp'));
    formatearORCID(document.getElementById('orcid1'));
    formatearORCID(document.getElementById('orcid2'));
    formatearORCID(document.getElementById('orcid3'));
    formatearORCID(document.getElementById('orcid4'));
    //       document.getElementById("enviar").disabled = false;
}

function NoAutores() {
    var x = document.getElementById("noautoress").selectedIndex;
    //LO SIGUIENTE INDICA QUE LOS CAMPOS DE LOS COAUTORES SERÁN REQUERIDOS DEPENDIENDO DE LOS MISMOS COAUTORES QUE SE SOLICITEN
    if (x == 0) {
        $("#secundario1").hide();
        $("#nombre1").attr("required", false);
        $("#apellidop1").attr("required", false);
        $("#apellidom1").attr("required", false);
        $("#institucion1").attr("required", false);
        $("#correo1").attr("required", false);
        $("#orcid1").attr("required", false);
        $("#cvu1").attr("required", false);
        $("#secundario2").hide();
        $("#nombre2").attr("required", false);
        $("#apellidop2").attr("required", false);
        $("#apellidom2").attr("required", false);
        $("#institucion2").attr("required", false);
        $("#correo2").attr("required", false);
        $("#orcid2").attr("required", false);
        $("#cvu2").attr("required", false);
        $("#secundario3").hide();
        $("#nombre3").attr("required", false);
        $("#apellidop3").attr("required", false);
        $("#apellidom3").attr("required", false);
        $("#institucion3").attr("required", false);
        $("#correo3").attr("required", false);
        $("#orcid3").attr("required", false);
        $("#cvu3").attr("required", false);
        $("#secundario4").hide();
        $("#orcidp").attr("required", false);
        $("#cvup").attr("required", false);
    }
    if (x == 1) {
        $("#secundario1").show();
        $("#nombre1").attr("required", true);
        $("#apellidop1").attr("required", true);
        $("#apellidom1").attr("required", true);
        $("#institucion1").attr("required", true);
        $("#correo1").attr("required", true);
        $("#orcid1").attr("required", true);
        $("#cvu1").attr("required", false);
        $("#secundario2").hide();
        $("#nombre2").attr("required", false);
        $("#apellidop2").attr("required", false);
        $("#apellidom2").attr("required", false);
        $("#institucion2").attr("required", false);
        $("#correo2").attr("required", false);
        $("#orcid2").attr("required", false);
        $("#cvu2").attr("required", false);
        $("#secundario3").hide();
        $("#nombre3").attr("required", false);
        $("#apellidop3").attr("required", false);
        $("#apellidom3").attr("required", false);
        $("#institucion3").attr("required", false);
        $("#correo3").attr("required", false);
        $("#orcid3").attr("required", false);
        $("#cvu3").attr("required", false);
        $("#secundario4").hide();
        $("#nombre4").attr("required", false);
        $("#apellidop4").attr("required", false);
        $("#apellidom4").attr("required", false);
        $("#institucion4").attr("required", false);
        $("#correo4").attr("required", false);
        $("#orcid4").attr("required", false);
        $("#cvu4").attr("required", false);

        $("#orcidp").attr("required", false);
        $("#cvup").attr("required", false);
    }
    if (x == 2) {
        $("#secundario1").show();
        $("#nombre1").attr("required", true);
        $("#apellidop1").attr("required", true);
        $("#apellidom1").attr("required", true);
        $("#institucion1").attr("required", true);
        $("#correo1").attr("required", true);
        $("#orcid1").attr("required", true);
        $("#cvu1").attr("required", false);
        $("#secundario2").show();
        $("#nombre2").attr("required", true);
        $("#apellidop2").attr("required", true);
        $("#apellidom2").attr("required", true);
        $("#institucion2").attr("required", true);
        $("#correo2").attr("required", true);
        $("#orcid2").attr("required", true);
        $("#cvu2").attr("required", false);
        $("#secundario3").hide();
        $("#nombre3").attr("required", false);
        $("#apellidop3").attr("required", false);
        $("#apellidom3").attr("required", false);
        $("#institucion3").attr("required", false);
        $("#correo3").attr("required", false);
        $("#orcid3").attr("required", false);
        $("#cvu3").attr("required", false);
        $("#secundario4").hide();
        $("#nombre4").attr("required", false);
        $("#apellidop4").attr("required", false);
        $("#apellidom4").attr("required", false);
        $("#institucion4").attr("required", false);
        $("#correo4").attr("required", false);
        $("#orcid4").attr("required", false);
        $("#cvu4").attr("required", false);

        $("#orcidp").attr("required", false);
        $("#cvup").attr("required", false);
    }
    if (x == 3) {
        $("#secundario1").show();
        $("#nombre1").attr("required", true);
        $("#apellidop1").attr("required", true);
        $("#apellidom1").attr("required", true);
        $("#institucion1").attr("required", true);
        $("#correo1").attr("required", true);
        $("#orcid1").attr("required", true);
        $("#cvu1").attr("required", false);
        $("#secundario2").show();
        $("#nombre2").attr("required", true);
        $("#apellidop2").attr("required", true);
        $("#apellidom2").attr("required", true);
        $("#institucion2").attr("required", true);
        $("#correo2").attr("required", true);
        $("#orcid2").attr("required", true);
        $("#cvu2").attr("required", false);
        $("#secundario3").show();
        $("#nombre3").attr("required", true);
        $("#apellidop3").attr("required", true);
        $("#apellidom3").attr("required", true);
        $("#institucion3").attr("required", true);
        $("#correo3").attr("required", true);
        $("#orcid3").attr("required", true);
        $("#cvu3").attr("required", false);
        $("#secundario4").hide();
        $("#nombre4").attr("required", false);
        $("#apellidop4").attr("required", false);
        $("#apellidom4").attr("required", false);
        $("#institucion4").attr("required", false);
        $("#correo4").attr("required", false);
        $("#orcid4").attr("required", false);
        $("#cvu4").attr("required", false);

        $("#orcidp").attr("required", false);
        $("#cvup").attr("required", false);
    }
    if (x == 4) {
        $("#secundario1").show();
        $("#nombre1").attr("required", true);
        $("#apellidop1").attr("required", true);
        $("#apellidom1").attr("required", true);
        $("#institucion1").attr("required", true);
        $("#correo1").attr("required", true);
        $("#orcid1").attr("required", true);
        $("#cvu1").attr("required", false);
        $("#secundario2").show();
        $("#nombre2").attr("required", true);
        $("#apellidop2").attr("required", true);
        $("#apellidom2").attr("required", true);
        $("#institucion2").attr("required", true);
        $("#correo2").attr("required", true);
        $("#orcid2").attr("required", true);
        $("#cvu2").attr("required", false);
        $("#secundario3").show();
        $("#nombre3").attr("required", true);
        $("#apellidop3").attr("required", true);
        $("#apellidom3").attr("required", true);
        $("#institucion3").attr("required", true);
        $("#correo3").attr("required", true);
        $("#orcid3").attr("required", true);
        $("#cvu3").attr("required", false);
        $("#secundario4").show();
        $("#nombre4").attr("required", true);
        $("#apellidop4").attr("required", true);
        $("#apellidom4").attr("required", true);
        $("#institucion4").attr("required", true);
        $("#correo4").attr("required", true);
        $("#orcid4").attr("required", true);
        $("#cvu4").attr("required", false);

        $("#orcidp").attr("required", false);
        $("#cvup").attr("required", false);
    }
}
</script>
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