<?php 
session_start();
include("../verificacion.php");
Nolink();

    if($_SESSION["id"]=="")
    {
        header("Location: ../index.php");
    }
include_once "mostrar_res.php";

date_default_timezone_set("America/Mexico_City");
setlocale(LC_TIME, 'spanish'); 
$fecha=strftime("%Y-%m-%d");

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/bootstrap.css">
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
    <title>RESUMENES - CID TEC LERDO</title>
 </head>
 
<body>
        <!--cabecera de página-->
        <br/>
        <!--logotipos de dependencias-->
        <div class="logos">
            <img class="imagenlogo" src="../img/header_portal_vigente_1170.png"/>
        </div>
        <!--fin de logotipos de dependencias-->
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
                            <!-- <button href="#" class="btn btn-info dropdown-toggle" data-toggle="dropdown" type="button" style="margin-left:10px;"><?php echo $_SESSION["nameuser"]?> <b class="caret"></b></button> -->
                            <ul class="dropdown-menu">
                                <li class=""><a href="perfil.php"><span class="glyphicon glyphicon-user"></span> Perfil</a></li>
                                <li class="divider"></li>
                                <li><a href="../destruir_sesion.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
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
                        <h2>RESUMEN</h2>
                        <hr>
                        <div class="container-fluid">
                            <div class="panel panel-default">
                                <div class="panel panel-heading" style="background-color:<?=color_revista()?>">  </div>
                                <div class="panel-body">
                                 <form action="ver_dictamen.php" method="POST">
                                                <div class="table-responsive">
                                                    <table id="tabla" class="table table-hover" style="text-align:center">
                                                        <thead style="background-color: black; color: white;">   
<!--                                                            <h2>Resumen</h2>-->
                                                            <tr>
                                                                
                                                                <th style="width: 5%">Clave</th>
                                                                <th style="width: 30%">Titulo del Resumen</th>
                                                                <th style="width: 15%">Fecha Revision</th>
                                                                <th style="width: 10%">Evaluacion</th>
                                                                <th style="width: 20%">Nombre Revisor</th>
                                                                <th style="width: 10%">Visualizar resumen</th>
                                                                <th style="width: 10%">Dictamen</th>
                                                                <th style="width: 10%">Actualizar resumen</th>
                                                                
                                                            </tr>
                                                         </thead>
                                                        <center>
                                                            <tbody>
                                                               <tr>
                                                            
                                                              <?php
                                                                     
                                                                    foreach ($result as $row)
                                                                    {
                                                                       $clave=$row[0];
                                                                       $status=$row[6];
                                                                       $ida=$row[7];
                                                                       $c=$row[2];
                                                                       $j=$row[5];
                                                                       $fl=$row[8];
                                                                       $aceptado=$row[9];
                                                              ?>          
                                                                                                                   
                                                                    <td><?php echo $row[0]?></td> 
                                                                    <td><?php echo $row[1]?></td>
                                                                    <td ><?php echo $row[2]?></td>
                                                                    <td><?php echo $row[3]?></td>
                                                                    <td><?php echo $row[4]?></td> 
                                                                    
                                                                    <td id="ida" visibility: hidden><?php echo $row[7]?></td>
                                                                   <td>
                                                                      <?php if($status=='Dictamen')
                                                 { 
                                                 ?>
                                                             <a type="button "class="btn btn-primary btn-block"  disabled href="visualizar_res.php?clave=<?php echo $clave ?>"><span class="glyphicon glyphicon-eye-open"></span>  </a>
                                                                        <?php
                                                }
                                                                        else { ?>
                                                                             <a type="button "class="btn btn-primary btn-block"  href="visualizar_res.php?clave=<?php echo $clave ?>"><span class="glyphicon glyphicon-eye-open"></span>  </a>
                                                                       <?php
                                                                         }
                                                                        
                                            ?>   
                                                                   </td>
                                                                    <td>
                                            <?php
                                           if(substr_count($c,'En espera')==3 && $fecha<$fl)
                                                      {  
                                                        ?>  
                                           <button type="button" data-toggle="modal" id="btnj" value="<?php echo $j;?>" data-target="#evaluar" class="btn btn-primary" 
                                            disabled><span class="glyphicon glyphicon-edit"></span> Evaluar</button>
                                                                  <?php                        
                                                        } 
                                            else if($status=='Dictamen')
                                                 { 
                                                 ?>
                                                                        <a type="button" name="btnres" id="ida"  href="../Documentos/Dictamen/Resumen/DR-<?=$clave?>.pdf"  target="_blank"  class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span> Ver Dictamen</a>
                                                   <?php
                                                 }
                                                
                                                else
                                                {
                                                ?>
                                                 <button type="button" data-toggle="modal" id="btnj" value="<?php echo $j;?>" data-target="#evaluar" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Evaluar</button>
                                                 <?php
                                                }                         
                                                                        
                                            ?>   
                                            
                                            <td>
                                                   <?php if($aceptado=='0')
                                                 { 
                                                 ?>
                                                 <a type="button "class="btn btn-primary btn-block"  disabled href="visualizar_res.php?clave=<?php echo $clave ?>"><span class="glyphicon glyphicon-eye-open"></span>  </a>
                                                 <?php
                                                }
                                                else { ?>
                                                    <a type="button "class="btn btn-primary btn-block"  href="actualiza_resumen.php?clave=<?php echo $clave ?>"><span class="glyphicon glyphicon-eye-open"></span>  </a>
                                                <?php
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
             <!--Modal-->
                         <form id="form1" action="dictamen_res.php" method="POST" style="display:block">        
                         <div class="modal fade" tabindex=”-1″ id="evaluar" role="dialog" data-backdrop="static" data-keyboard="false">
                                        <div class="modal-dialog modal-md" role="document">
                                             <div class="modal-content">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="color:black">
                                                        <button type="button" class="close" data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                
                                                            <h4>Generar Dictamen</h4>

                                                                
                                                             </div>
                                                               <div class="panel-body"> 
                                                                     
                                                                <div class="row">

                                                                 
                                                                    <div class="col-md-7" style="text-align:left">
                                                                    <div class="form-group" style="text-align:left">
                                                                             <label>Justificacion Original</label><br>
                                                                    <textarea name="just" id="just1" style="resize:none" class="form-control" rows="13" required></textarea>
                                                                         
                                                                        
                                                                    </div>
                                                                 </div>   
                                                                        
                                                                   <div class="col-md-4">
                                                                    <div class="form-group" style="text-align:left">
                                                                            
                                                                      <label>Dictamen</label><br>
                                                                            <select name="opcion" class="form-control" required>
                                                                                    <option value=''style="display: none">Elija una opcion</option>
                                                                                    <option value="1">Aceptado</option>
                                                                                    <option value="0">No Aceptado</option>
                                                                            </select>
                                                                    </div>
                                                                   </div>
       
                                                                  
                                                                </div> 
                                                               <br><br>
                                                                       
                                                            <div class="row" style="text-align: right;">
                                                               <div class="col-lg-6">
                                                                
                                                             </div>
                                                               <div class="col-lg-4">
                                                               <button id="clave" name="enviar" type="submit" class="btn btn-primary">Aceptar</button>
                                                         
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
                                                                             <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                                                                    <h4 id="por"></h4>
                                                                                    </div>
                                                                                 </div>

                                                                
                                                             </div>
                                                              
                                                        
                                   
                                                       </div>   
                                                    </div>
                                                 </div>                                                        
                                                 
                                            <!--Fin Modal-->
        <!-- pie de pagina-->
        <br>
        <br>
        <div class="contactos">
        <table>
            <tr>
                <td><a href="https://www.facebook.com/pages/Instituto-Tecnol%C3%B3gico-Superior-de-Lerdo-P%C3%A1gina-Oficial/285056498195463"><img  src="../img/face.jpg"/></a></td>
                <td><a href="https://twitter.com/ITSLerdo?ref_src=twsrc%5Etfw&ref_url=http%3A%2F%2Fwww.itslerdo.edu.mx%2F"><img src="../img/tw.jpg"/></a></td>
                <td><a><img src="../img/correoitsl.gif"/></a></td>
            </tr>
        </table>
        </div>

        <!-- Pie de página-->
        <div class="pie_pagina">   
      <img src="../img/pie_pagina.jpg"/>
            <p>
                Av. Tecnológico N 1555 Sur Periferico Gomez Lerdo Km. 14.5
                <br/>C.P. 35150 Cd. Lerdo, Dgo
                <br/>Tels. 01 (871) 725 23 71, 725 57 79, 725 58 02
            </p>
        </div>
     <script type="text/javascript" src="../js/funciones/resumen.js"> </script>
    <script>
        
         $(document).on('submit', '#form1', function() {
              $('#evaluar').modal('hide');
             $('#cargando').modal('show');
              var elem = document.getElementById("bar");   
              var porcent=document.getElementById("por");
              var width = 1;
              var id = setInterval(frame, 100);
              function frame() {
                if (width >= 100) 
                {
                 
//                 window.location.href='resumenes.php';
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
          
</script>
</body>
</html>

<?php
    if($_SESSION['mensaje'] != "")
    { ?>
        <script>
            <?=$_SESSION['mensaje'];$_SESSION['mensaje']="";?>;
        </script>
<?php } ?>