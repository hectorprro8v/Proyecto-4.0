<?php
session_start();
include("../verificacion.php");
    Nolink();
include_once '../conexion.php';
$conexion=conectar();

include_once 'EnvioChecks-Rev-yCE.php';
         
$idart=$_GET["idarticulo"];
$clave=$_GET["clave"];
$nombre=$_GET["nombre"];
$linea=$_GET["lin"];
$total=$_GET["total"];
        
$CE=$conexion->prepare ("SELECT U.idUsuario as id, CONCAT(U.Nombres,'  ', U.Apellido_Paterno, '  ', U.Apellido_Materno)
 as NombreCo, count(R.idArticulo) as totalart 
 from tipo_usuario as TU inner join
 usuario_tipo as UT on TU.Id_Tipo_Usuario = UT.TipoUsuario
 inner join usuario as U 
 on UT.Usuario=U.idUsuario
 left join resumen_comite as R on U.idUsuario=R.idUsuario 
 where TU.Caracter_tipo='E' and U.idUsuario not in (select RC.idUsuario 
from resumen_comite as RC where RC.idArticulo = '$idart') group by R.IdUsuario,NombreCo");
         
$CE->execute();
$CE->setFetchMode(PDO::FETCH_ASSOC);
$resultado = $CE->fetchAll();

$auto = $conexion->prepare("select Concat(Nombres,' ',Apellido_Paterno,' ',Apellido_Materno) as Nombres, Institucion from autores where idArticulo ='$idart'");
$auto->execute();
$auto_resul = $auto->fetchAll();

if($_SESSION["id"]=="")
{
    header("Location: ../index.php");
}
if($idart =='' && $clave == '' && $nombre=='' && $linea=='' && $total=='')
    {
        header("Location: asignar_CE.php");
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
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
        
        <title>COMITÉ EDITORIAL - CID TEC LERDO</title>
    </head>
    <body>
        <!--cabecera de página-->
        <br/>
        <!--fin de cabecera de página-->
        <!--logotipos de dependencias-->
        <div class="logos table-responsive">
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
                    <a class="navbar-brand" href="index.php" style="margin-left: 15px;">SICSACID</a>
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
                        <li class=""><a href="altas.php">Alta usuarios</a></li>
                         <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Resúmenes <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="asignar_CE.php">Asignar comité editorial</a></li>
                                <li class="divider"></li>
                                <li><a href="resumenes.php">Ver resumen</a></li>
                            </ul>
                        </li>
                         <li class="dropdown">
                            <a href="#" class="dropdown" data-toggle="dropdown"> Artículos <b class="caret"></b></a>
                             
                            <ul class="dropdown-menu">
                                <li><a href="asignar_Revisores.php">Asignar artículos</a></li>
                                <li class="divider"></li>
                                <li><a href="articulos.php">Ver artículos</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Documentos <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="fichas_pago.php">Ficha de Pago</a></li>
                                <li class="divider"></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="reportes/reporte_res.php">Resumen</a></li>
                                <li class="divider"></li>
                                <li><a href="reportes/reporte_art.php">Artículo</a></li>
                                <li class="divider"></li>
                                <li><a href="reportes/reporte_us.php">Usuarios</a></li>
                                <li class="divider"></li>
                                <li><a href="reportes/reporte_fin.php">Financieros</a></li>
                                <li class="divider"></li>
                                
                            </ul>
                        </li>
                        <li class=""><a href="parametros.php">Parámetros</a></li>
                        <li class=""><a href="reportes/reportes_gen.php">Reportes Generales</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <!--Menu-->
        <div class="container-fluid">
                    <div class="container-fluid">
                        <div class="panel panel-default" id="sombra">
                            <div class="panel-body">
                                <h2 class="modal-title"style="text-align:" id="myModalLabel">AGREGAR COMITÉ EDITORIAL</h2>
                                <hr>
                                <div class="container-fluid">
                                    <div class="panel panel-default">
                                        <div class="panel panel-heading" style="background-color: <?=color_revista();?>">
                                        </div>
                                        <div class="panel-body">
                                            <div class="container-fluid">
                                            </div>
                                            <form id="modal-comite" method="post">
                                    <fieldset>
                                        <legend>DATOS DEL RESUMEN</legend>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <label class="col-md-12 col-sm-6 col-xs-6 text-left"for="basicinput">Clave del artículo</label>
                                                <div class='col-md-12 col-sm-6 col-xs-6'>
                                                    <p ><?=$clave?></p>
                                                    <input  type="text" name="idart" id="idart" value="<?=$idart?>" placeholder="ID del articulo" class="form-control span8 tip" readonly="readonly" style="width: 2px; height: 2px; visibility: hidden;">
                                                </div> 
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6"> 
                                                <label class="col-md-12 col-sm-6 col-xs-6 text-left">Linea de investigación </label>
                                                <div class='col-md-12 col-sm-6 col-xs-6'>
                                                    <p><?=$linea?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="col-md-12 col-sm-6 col-xs-6 text-left">Nombre del resumen</label>  
                                                <div class='col-md-12 col-sm-6 col-xs-6'>
                                                    <p style="justify" ><?=$nombre ?></p>
                                                </div>
                                            </div>
                                        </div> 
                                        <br>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="col-md-12 col-sm-6 col-xs-6 text-center" align="right">Autores</label>
                                                            <br>
                                                     <table id="tipopago" class="table table-hover"> 
                                        <thead style="background-color:black; color: white;">
                                                            <th>Nombres</th>
                                                            <th>Institución</th>
                                                        </thead>
                                                       <tbody>
                                                       <tr>
                                                            <?php 
                                                        foreach($auto_resul as $datos){
                                                        $nombres=$datos["Nombres"];
                                                        $insti=$datos["Institucion"];
                                                        
                                                        
                                                        ?>
                                                           </tr> 
                                                           <td style="text-align: center;" width="270px"><?=$nombres?></td>
                                                            <td style="text-align: center;" width="400px"><?=$insti?></td>
                                                 <?php 
                                                     }
                                                ?>
                                                           
                                                       </tbody>
                                                    </table>
                                                    
                                                </div>
                                            </div>
                                    </fieldset> 
                                    <br> <br>
                                    <h4>COMITÉ EDITORIAL</h4>
                                    <div class="container-fluid">
                                        <div class="panel panel-default">
                                            <div class="form-group"> 
                                                <div class="table-responsive">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <div class="col-md-6 col-sm-6 col-xs-6"> </div> 
                                                        <div class="col-md-6">
                                                            <label class="col-md-8 text-right">Numero de revisores asignados al artículo:</label>
                                                            <div class="col-md-4 text-left">
                                                            <input id="total" disabled class="form-control span8 tip" style="width:35px; height:40px;" value="<?=$total?>" > <br>
                                                            </div>                                                                
                                                        </div>
                                                    </div>
                                                    <table id="tablaseletCE" class="table table-hover"> 
                                                        <thead style="background-color:black; color: white"> 
                                                            <th>Nombre</th>
                                                            <th>Artículos asignados</th>
                                                        </thead>
                                                        <tbody style='cursor: pointer'>
                                                            <?php 
                                                            foreach ($resultado as $row)
                                                            {
                                                                $id = $row['id'];
                                                                $nombreCE = $row['NombreCo'];
                                                                $art_asig = $row['totalart'];
                                                             ?>  
                                                            
                                                            <tr onclick="seleccionar(this, <?=$id?>)">
                                                                <td><?=$nombreCE?></td>
                                                                <td><?=$art_asig?></td>
                                                                <td style='display: none'><input value='<?=$id?>' type='checkbox' name='check[]' id='chk<?=$id?>'></td>  
                                                            </tr>
                                                            <?php
                                                            }
                                                            ?>  
                                                        </tbody>
                                                    </table> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                   <a type="button" class="btn btn-danger btn-block" style="align:left" href="asignar_CE.php"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a>
                                                    </div>
                                                <div class="col-md-6">
                                                    <button id="clavee" name="guardar" type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-floppy-saved"></span> Guardar</button>
                                                </div>
                                                </div>
                                            </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                </div>
  
<div class="modal fade" tabindex=”-1″ id="cargando" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="panel-heading" style="color:black">
                        <h2>Procesando... Porfavor Espere.</h2>
                        <div id="bar" class="progress" style="hight: 30px;">
                            <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                                <h4 id="por"></h4>
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
	$(document).on('submit', '#modal-comite', function() {
             // $('#evaluar').modal('hide');
             $('#cargando').modal('show');
              var elem = document.getElementById("bar");   
              var porcent=document.getElementById("por");
              var width = 1;
              var id = setInterval(frame, 100);
              function frame() {
                if (width >= 100) 
                {
                 
//                 window.location.href='asignar_CE.php';
                  clearInterval(id);
                  
                } 
                  else 
                  {
                  width++; 
                  document.getElementById("por").innerHTML=width +'%';
                  elem.style.width = width + '%'; 
                 
                }
              }
        });
          
    
    var cantidad = $("#total").val();
    function seleccionar(tr, valor){       
        $(function(){
            if($("#chk"+valor).attr("checked") == "checked")
            {
                $("#chk"+valor).attr("checked", false);
                $("#chk"+valor).prop("checked", false);
                $(tr).css("background-color", "#FFFFFF");
                 
                 cantidad--;
            }
            else if(cantidad<3)
            {
                $("#chk"+valor).attr("checked", true);
                $("#chk"+valor).prop("checked", true);
                $(tr).css("background-color", "#BEDAE5");
                         
                    cantidad++;
            }
        });
    }
</script>