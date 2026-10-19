<?php 
    include("../conexion.php");
$conexion=conectar();
    include_once("mostrar_linea.php");
    session_start();
    if($_SESSION["id"]=="")
    {
        header("Location: ../index.php");
    }
 $idUsuario = $_SESSION["id"];

            $sentencia="select idRevisor from revisor where idUsuario = $idUsuario";
            $sql=$conexion->prepare($sentencia);
            $sql->execute();
            foreach($sql as $dato)
            {
                $idRevisor=$dato["idRevisor"];
            }

$consulta = "Select li.Nombre as Nombre,(case rv.Principal when 1 then 'Principal' when 0 then '' end)
as Principal from linea_investigacion as li
inner join revisor_linea as rv on li.idLinea = rv.idLinea 
where rv.idRevisor = (Select idRevisor from revisor where idUsuario = '$idUsuario')";
            
            $linea = $conexion->prepare($consulta);
            $linea->execute();
            $resul=$linea->fetchAll();

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
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css"/>
        <!--ALERTAS-->
        <title>MI PERFIL - CID TEC LERDO</title>
    </head>
    <body>
          <!--cabecera de página-->
        <br>
        <!--fin de cabecera de página-->
        <!--logotipos de dependencias-->
        <div class="logos">
            <img class="imagenlogo" src="../img/header_portal_vigente_1170.png"/>
        </div>
        <!--fin de logotipos de dependencias-->
       <br>
        <!--CUERPO DE LA PÁGINA-->
        <!--Menu-->
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
                            <button href="#" class="btn btn-info dropdown-toggle" data-toggle="dropdown" type="button" style="margin-left:10px;"><?php echo $_SESSION["nameuser"]?> <b class="caret"></b></button>
                            <ul class="dropdown-menu">
                                <li class=""><a href="perfil.php"><span class="glyphicon glyphicon-user"></span> Perfil</a></li>
                                <li class="divider"></li>
                                <li><a href="../destruir_sesion.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
                            </ul>
                        </li>
                        <li class=""><a href="linea_in.php">Líneas de investigación</a></li>
                        <li class=""><a href="documentos.php">Documentos</a></li>
                        <li class=""><a href="articulos.php">Artículos</a></li>
                        
                    </ul>
                </div>
            </nav>
        </div>
        <br>
        <!--Menu-->
        <!--SECCIÓN1 - PERFIL-->
        <form action="addlinea.php" method="POST">
            <div class="container-fluid">
                <div class="panel panel-default" id="sombra">
                    <div class="panel-body">
                        <h2>LÍNEAS DE INVESTIGACIÓN</h2>
                        <hr>
                        <div class="container-fluid">
                            <div class="panel panel-default">
                                <div class="panel panel-heading" style="background-color: <?=color_revista();?>">
                                </div>
                                <div class="panel-body">
                                     
                                    <div class="col-lg-6">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <div class="container-fluid">
                                                    <div class="table-responsive">
                                                        <?php
                                                            $sql=$conexion->prepare("select * from revisor_linea where idRevisor = (Select idRevisor from revisor where idUsuario = '$idUsuario');");
                                                            $sql->execute();
                                                            $result = $sql->rowCount();
                                                        if($result > 0)
                                                        {?>
                                                        <table id="linea" class="table table-hover"> 
                                                            <thead style="background-color:black; color: white">
                                                                <th>Líneas de investigación</th>
                                                                <th>Principales</th>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <?php 
                                                                    foreach ($resul as $row){ 
                                                                        $nombre = $row["Nombre"];
                                                                        $principal=$row["Principal"];
                                                                    ?>                                
                                                            <td><?=$nombre?></td>
                                                            <td><?=$principal?></td>

                                                                        </tr>
                                                                        <?php

                                                                            }
                                                                        ?>                                           
                                                                    </tbody>
                                                                </table>
                                                                    <?php } ?>
                                                                </div>          
                                                        
                                                            </div>
                                                      </div>    
                                                </div>
                                        </div>
                                    <div class="col-lg-6">
                                                  <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <div class="container-fluid">
                                                              <div class="table-responsive">
                                                               <?=$result = mostrar_lineas();?>
                                                                </div>              
                                                            </div>
                                                      </div>    
                                                </div>
                                        </div>
                                     <div class="container-fluid" align="right">
                                          <button type="submit" id="btngl" title="Recuerda que deben ser cinco líneas de investigación para continuar." class="btn btn-primary btn-md" style="width: 33em;" name="guardarlinea" value="guardar" >Guardar</button><br>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
    $('#btngl').prop('disabled',true); 
    var cantidad = 0;
    function seleccionar(tr, valor)
    {
        $(function()
          {
            if($("#chk"+valor).attr("checked") == "checked")
            {
                $("#chk"+valor).attr("checked", false);
                $("#chk"+valor).prop("checked", false);
                $(tr).css("background-color", "#FFFFFF");
                 
                 cantidad--;
            }
            else if(cantidad < 5)
                {


                    $("#chk"+valor).attr("checked", true);
                    $("#chk"+valor).prop("checked", true);
                    $(tr).css("background-color", "#BEDAE5");

                        cantidad++;
                        
                }
         if(cantidad > 4)
                {
                    $('#btngl').prop('disabled',false);
                }
        });
        
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


