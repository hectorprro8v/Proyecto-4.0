<?php
session_start();
include("../conexion.php");


if($_SESSION["id"]=="")
{
  header("Location: ../index.php");
}
include_once "mostrar_art.php";
date_default_timezone_set("America/Mexico_City");
setlocale(LC_TIME, 'spanish');
$fecha=strftime("%Y-%m-%d");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<head>
  <link href="../css/index/indexstyle.css" rel="stylesheet" media="screen" />
  <script src="../js/index/jquery-1.9.1.min.js"></script>
  <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
  <script src="../js/bootstrap.min.js"></script>
  <link href="../css/index/estilos.css" rel="stylesheet" media="screen">
  <link href="../css/index/navbar-fixed-left.min.css" rel="stylesheet">
  <!--ALERTAS-->
  <!-- JavaScript -->
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
      <a class="navbar-brand" href="index.php" style="margin-left: 15px;">SICSACID</a>
    </div>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
      <ul class="nav navbar-nav">
        <div class="image">
          <img src="../img/Logo_Revista.png" width="90" height="120" alt="User" style="margin-left:40px;">
        </div>
        <br>
        <li class="dropdown">
          <!-- <button href="#" class="btn btn-info dropdown-toggle" data-toggle="dropdown" type="button" style="margin-left:10px;"><?php echo $_SESSION["nameuser"]?> <b class="caret"></b></button> -->
          <ul class="dropdown-menu">
            <li class=""><a href="perfil.php"><span class="glyphicon glyphicon-user"></span> Perfil</a>
            </li>
            <li class="divider"></li>
            <li><a href="../destruir_sesion.php"><span class="glyphicon glyphicon-log-out"></span>
              Salir</a></li>
            </ul>
          </li>

          <li class="dropdown">
            <a href="#" class="dropdown" data-toggle="dropdown"> Revisores <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="alta_revisores.php">Alta Revisores</a></li>
              <li class="divider"></li>
              <li><a href="detalle_revisores.php">Detalle Revisores</a></li>
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
              <li class="divider"></li>
              <li><a href="detalles_articulos.php">Detalles artículos</a></li>
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
        </ul>
      </div>
    </nav>
  </div>
  <!--Menu-->
  <div class="container-fluid">
    <div class="panel panel-default" id="sombra">
      <div class="panel-body">
        <h2>ARTÍCULOS</h2>
        <hr>
        <div class="container-fluid">
          <div class="panel panel-default">
            <div class="panel panel-heading" style="background-color:<?=color_revista()?>"> </div>
            <div class="panel-body">

              <form action="ver_dictamen.php" method="POST">

                <div class="table-responsive">
                  <table id="tabla" class="table table-hover" style="text-align: center">
                    <thead style="background-color: black; color: white;">
                      <!--                                                            <h2>Articulos</h2>-->
                      <tr>
                        <th style="width: 5%">Clave</th>
                        <th style="width: 30%">Titulo del Articulo</th>
                        <th style="width: 15%">Fecha Revision</th>
                        <th style="width: 13%">Dictamen</th>
                        <th style="width: 20%">Revisores Asignados</th>
                        <th>Visor del documento</th>
                        <th style="width: 10%">Evaluación</th>

                      </tr>
                    </thead>
                    <center>

                      <tbody>
                        <?php
                        foreach ($result as $row)
                        {
                          $ida=$row[8];
                          $m=$row[5];
                          $o=$row[6];
                          $status=$row[7];
                          $c=$row[2];
                          $clave=$row[0];
                          $fl=$row[9];
                          if ($row[10] === 1 && $row[11] === 0)
                          {
                            ?>
                            <tr style="background-color: #ccffcc;">
                            <?php
                          }
                          else if ($row[10] === 0 && $row[11] === 0)
                          {
                            ?>
                            <tr style="background-color: #ffbfbf;">
                            <?php
                          } else if ($row[10] === 0 && $row[11] === 1) {
                            ?>
                            <tr style="background-color: #fdfec0;">
                            <?php
                          } else {
                            ?>
                            <tr style="background-color: #ffffff;">
                            <?php
                          }
                          
                            ?>
                              <td><?php echo $row[0]?></td>
                              <td><?php echo $row[1]?></td>
                              <td><?php echo $row[2]?></td>
                              <td><?php echo $row[3]?></td>
                              <td><?php echo $row[4]?></td>
                              <td id="mods" visibility: hidden><?php echo $m;?></td>
                              <td id="obs" visibility: hidden><?php echo $o;?></td>
                              <td id="ida" visibility: hidden><?php echo $ida;?></td>
                              <td>
                                <br>
                                <a type='button' class='btn btn-success btn-md'
                                href="../Documentos/Extensos/<?=$clave?>.docx">
                                <span
                                class="glyphicon glyphicon-download-alt"></span>Descargar</a>
                              </td>
                              <td>
                               
                               <?php
                                  //echo $status;
                                  if( $status == 'En revision')
                                  {  
                                    ?>  
                                        <br><a type="button" name="btnEvaluar" id="ida"
                                         href=<?php echo "evaluar_art.php?arti=".$ida;?> target=""
                                         class="btn btn-primary">Evaluar</a>
                                    <?php   
                                  } 
                                  if($status == 'Aceptado' || $status == 'No Aceptado' || $status == 'Segunda Revision')
                                    { 
                                     ?>
                                       <a type="button" name="btnart" id="ida"   href="../Documentos/Dictamen/Articulo/DA-<?=$clave?>.pdf" target="_blank"  class="btn btn-primary">Ver Dictamen</a>
                                       
                                    <?php
                                    }
                                    //Muestra el botón de evalaur cuando el artículo se encuentra en segunda revisón
                                  if( $status == 'Segunda Revision' )
                                    {
                                      if(substr_count($row[3],'Segunda Revision') <= 1)
                                      {
                                        ?>
                                        <br><a type="button" name="btnEvaluar" id="ida"
                                        href=<?php echo "evaluar_art.php?arti=".$ida;?> target=""
                                        class="btn btn-primary">Evaluar</a>
                                        
                                        <?php  
                                      }    
                                    } 
                                  ?>
                                </td>
                              </tr>
                              <?php
                            }
                            ?>
                          </tbody>
                        </center>
                      </table>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <form id="form2" action="dictamen_art.php" method="POST">
        <div class="modal fade" tabindex=”-1″ id="dictamen_a" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="panel panel-default">
                <div class="panel-heading" style="color:black">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4>Generar Dictamen</h4>
                </div>
                <div class="panel-body">

                  <div class="row">
                    <div class="col-lg-6">
                      <div Class="form-group" style="text-align:left">

                        <label>Modificaciones</label><br>
                        <textarea name="modificacion" id="m" style="width: 100%;" class="form-control"
                        rows="50" required></textarea>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div Class="form-group" style="text-align:left">

                        <label>Observaciones</label><br>
                        <textarea name="observacion" id="o" style="width: 100%;" class="form-control"
                        rows="50" required></textarea>

                        <br>
                        <label>Dictamen</label><br>
                        <select name="opciones" class="form-control" required>
                          <option value='' style="display: none">Elija una opcion</option>
                          <option value="1">Aceptado</option>
                          <option value="0">No Aceptado</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <br><br><br>
                  <div class="row" style="text-align: right;">
                    <div class="col-lg-6">
                    </div>
                    <div class="col-lg-4">
                      <button id="c" name="env" type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                    <div class="col-lg-1">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
      <div class="modal fade" tabindex=”-1″ id="cargando" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md" role="document" style="position: absolute;
        top: 150px;
        right: 100px;
        bottom: 0;
        left: 0;
        z-index: 10040;
        overflow: auto;
        overflow-y: auto;
        ">>
        <div class="modal-content">
          <div class="panel-heading" style="color:black">
            <h2>Procesando... Porfavor Espere.</h2>
            <div id="bar" class="progress" style="height: 30px;">
              <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="100"
              aria-valuemin="0" aria-valuemax="100" style="width:100%">
              <h4 id="por"></h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- pie de pagina-->
  <br>
  <br>
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
        <p>
          Av. Tecnológico N 1555 Sur Periferico Gomez Lerdo Km. 14.5
          <br />C.P. 35150 Cd. Lerdo, Dgo
          <br />Tels. 01 (871) 725 23 71, 725 57 79, 725 58 02
        </p>
      </div>
      <script type="text/javascript" src="../js/funciones/articulo.js"></script>
      <script>
      $(document).on('submit', '#form2', function() {
        $('#dictamen_a').modal('hide');
        $('#cargando').modal('show');
        var elem = document.getElementById("bar");
        var porcent = document.getElementById("por");
        var width = 1;
        var id = setInterval(frame, 100);

        function frame() {
          if (width >= 100) {
            //                 window.location.href='resumenes.php';
            clearInterval(id);
          } else {
            width++;
            document.getElementById("por").innerHTML = width + '%';
            elem.style.width = width + '%';
          }
        }
      });
      </script>
    </tr>
    <!-- Modal de CRITERIOS -->
    <div class="modal fade" id="modalCriterios" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <center>
              <h4 class="modal-title" id="myModal-label">Criterios evaluados</h4>
            </div>
            <div class="modal-body">
              <p>
              </p>
              <table id="tabla" class="table table-hover" style="text-align: center">
                <thead style="background-color: black; color: white;">
                  <tr>
                    <th style="width: 10%">Evaluador</th>
                    <th style="width: 20%">Fuentes confiables?</th>
                    <th style="width: 20%">Es original</th>
                    <th style="width: 20%">Mas de 100 hojas</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Juanito Alcachofa</td>
                    <td><span class="glyphicon glyphicon-ok text-success"></span></td>
                    <td><span class="glyphicon glyphicon-remove text-danger"></span></td>
                    <td><span class="glyphicon glyphicon-minus text-info"></td>
                    </tr>
                  </tbody>
                </table>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>
          <!-- fin del modal -->
        </body>
      </script>
      <script type="text/javascript">
      $(document).ready(function(){
        console.log("entro")
        console.log(<?php echo json_encode($result); ?>);
      })
      </script>
      </html>
      <?php
      if($_SESSION['mensaje'] != "")
      { ?>
        <script>
        <?=$_SESSION['mensaje'];$_SESSION['mensaje']="";?>;

        <?php } ?>
