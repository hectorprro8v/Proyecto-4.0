 <?php
session_start();

include_once '../conexion.php';
$conexion=conectar();

include_once 'EnvioChecks-Rev-yCE.php';

$idart=$_GET["idarticulo"];
$clave=$_GET["clave"];
$nombre=$_GET["nombre"];
$linea=$_GET["lin"];
$total=$_GET["total"];
        
$REV=$conexion->prepare ("select r.idRevisor as idrev, CONCAT (U.Nombres,'  ', U.Apellido_Paterno, '  ', U.Apellido_Materno) as NombreCo, count(E.idArticulo) as total  from usuario as U  inner join revisor as R on U.idUsuario = R.idUsuario  inner join revisor_linea as rl on R.idRevisor = rl.idRevisor  left join extenso_revisor as E on R.idRevisor = E.idRevisor where r.idRevisor not in (select e.idRevisor from extenso_revisor as e where 
e.idArticulo='$idart') and rl.idLinea = (select idLinea from articulo as A where A.idArticulo='$idart') group by E.idRevisor, U.Nombres order by rl.Principal desc"); 
         
$REV->execute();
$REV->setFetchMode(PDO::FETCH_ASSOC);
$resultado1 = $REV->fetchAll();

$auto = $conexion->prepare("select Concat(Nombres,' ',Apellido_Paterno,' ',Apellido_Materno) as Nombres, Institucion from autores where idArticulo ='$idart'");
$auto->execute();
$auto_resul = $auto->fetchAll();



if($_SESSION["id"]=="")
{
    header("Location: ../index.php");
}
if($idart =='' && $clave == '' && $nombre=='' && $linea=='' && $total=='')
    {
        header("Location: asignar_Revisor.php");
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
        
        <title>REVISORES - CID TEC LERDO</title>
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
                                <h2 class="modal-title"style="text-align:" id="myModalLabel">AGREGAR REVISORES</h2>
                                <hr>
                                <div class="container-fluid">
                                    <div class="panel panel-default">
                                        <div class="panel panel-heading" style="background-color: <?=color_revista();?>">
                                        </div>
                                        <div class="panel-body">
                                            <div class="container-fluid">
                                            </div>
                                            <form id="modal-revisor" method="post">
                                    <fieldset>
                                        <legend>DATOS DEL ARTÍCULO</legend>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <label class="col-md-12 col-sm-6 col-xs-6 text-left"for="basicinput">Clave del artículo</label>
                                                <div class='col-md-12 col-sm-6 col-xs-6'>
                                                    <p ><?=$clave?></p>
                                                    <input  type="text" name="idart" id="idart" value="<?=$idart?>" placeholder="ID del articulo" class="form-control span8 tip" readonly="readonly" style="width: 2px; height: 2px; visibility: hidden;">
                                                </div> 
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6"> 
                                                <label class="col-md-12 col-sm-6 col-xs-6 text-left">Linea de Investigación </label>
                                                <div class='col-md-12 col-sm-6 col-xs-6'>
                                                    <p><?=$linea?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="col-md-12 col-sm-6 col-xs-6 text-left">Nombre del artículo</label> 
                                                
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
                                                         <thead style="background-color:black; color: white">
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
                                                    
                                              
                                    </fieldset> 
                                    <br> <br>
                                    
                                    <h4>REVISORES</h4>
                                    <div class="container-fluid">
                                        <div class="panel panel-default">
                                            <div class="form-group"> 
                                                <div class="table-responsive">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <div class="col-md-6 col-sm-6 col-xs-6"> </div> 
                                                        <div class="col-md-6">
                                                            <label class="col-md-8 text-right">Numero de revisores asignados al artículo:</label>
                                                            <div class="col-md-4 text-left">
                                                            <input id="total" disabled class="form-control span8 tip" style="width:35px; height:40px;" value="<?=$total?>" >
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
                                                            foreach ($resultado1 as $row)
                                                            {
                                                                $id = $row['idrev'];
                                                                $nombreREV = $row['NombreCo'];
                                                                $art_asig = $row['total'];
                                                             ?>  
                                                            
                                                            <tr onclick="seleccionar(this, <?=$id?>)">
                                                                <td><?=$nombreREV?></td>
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
                                                    <div class="col-md-5">
                                                    <a type="button" class="btn btn-danger btn-block" style="align:left" href="asignar_Revisores.php"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a>
                                                    </div>
                                                <div class="col-md-6">
                                                  <button id="clavee" name="guardarREV" type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-floppy-saved"></span> Guardar</button>
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
</body>
</html>
<script type="text/javascript">
    $(document).on('submit', '#modal-revisor', function() {
             // $('#evaluar').modal('hide');
             $('#cargando').modal('show');
              var elem = document.getElementById("bar");   
              var porcent=document.getElementById("por");
              var width = 1;
              var id = setInterval(frame, 100);
              function frame() {
                if (width >= 100) 
                {
                 
//                 window.location.href='asignar_Revisores.php';
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
<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>