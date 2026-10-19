<?php 
include("usuario.php");
    session_start();
    include_once("seleccion_linea.php");
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
            <div class="container-fluid">
                <div class="panel panel-default" id="sombra">
                    <div class="panel-body">
                        <h2>PERFIL</h2>
                        <hr>
                        <div class="container-fluid">
                            <div class="panel panel-default">
                                <div class="panel panel-heading" style="background-color: <?=color_revista();?>">
                                </div>
                                <div class="panel-body">
                                    <div class="container-fluid col-lg-6">
                                        <div class="form-group">
                                          <h4 for="Nombre_revisor">Nombre(s)</h4>
                                          <input value="<?php echo $nombres ?>" type="text" class="form-control" style="text-align: center;" id="Nombre" readonly>
                                        </div>
                                        <div class="form-group">
                                          <h4 for="Apellidos_revisor">Apellidos</h4>
                                          <input value="<?php echo $apellidop." ".$apellidom ?>" type="text" class="form-control" style="text-align: center;" id="Apellidos" readonly>
                                        </div>
                                        <div class="form-group">
                                          <h4 for="Institucion_revisor">Institución</h4>
                                          <input value="<?php echo $institucion ?>" type="text" class="form-control" style="text-align: center;" id="Institucion"readonly>
                                        </div>
                                        
                                         <?php     
                                            $sql=$conexion->prepare("select count(Principal) as Lineap from revisor_linea where idRevisor=$idRevisor and Principal = 0 group by Principal");
                                            $sql->execute();
                                            $sql->setFetchMode(PDO::FETCH_ASSOC);
                                            $result = $sql->fetchAll();
                                        
                                            foreach ($result as $row) 
                                            {
                                                $pri= $row['Lineap'];

                                                 if ($pri != 3)
                                                    {
                                        ?>
                                        <div class="container-fluid row" id="selec">
                                        <form method="post">
                                                <?php
                                               foreach ($result as $row)
                                               {
                                                $vl =$row['Lineap'];
                                                if($vl>3 )
                                                
                                                {?>
                                        <div class="form-group col-lg-9">
                                            <div class="row" ><hr>
                                              <div class="form-group" >
                                                    <div class="container-fluid" >
                                                        <table id="lineas" class="table table-hover" >
                                                        <thead>
                                                            <th>Elige tres lineas principales</th>
                                                            </thead>
                                                            <tbody style="cursor: pointer">
                                                            <?php
                                                            foreach($sq as $row)
                                                            {
                                                                $id=$row['idLinea'];
                                                                $nom=$row['nombre'];
                                                                ?>
                                                                <tr onclick="seleccionar(this, <?=$id?>)">
                                                                <td style="display:none;"><input value="<?=$id?>" type="checkbox" name="check[]" id="chk<?=$id?>"> 
                                                                </td>
                                                                <td><?=$nom?></td>
                                                                </tr>
                                                                <?php
                                                             }  
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                        <div class="col-xs-6">
                                              
                                                      <button class="btn btn-info" id="btn" title="Recuerda que deben ser tres líneas de investigación principales." type="submit" name="glinea" >Guardar</button>
                                                       
                                                        </div>
                                                        </div>   
                                                        </div>
                                                </div>
                                        </div>
                                               <?php     
                                                        }
                                                       }
                                                            ?>
                                       </form>
                                    </div>  
                                        <?php
                                           }
                                                else
                                                {
                                                     $_SESSION['mensaje'] = "alertify.Error('Ha ocurrido un error, los datos no se guardaron correctamente...')";
                                                }
                                            }
                                        ?>
                                    </div>
                                    <div class="container-fluid col-lg-6">
                                        <div class="form-group">
                                          <h4 for="Correo_revisor">Correo Electrónico</h4>
                                          <input value="<?php echo $correo_electronico ?>" type="email" class="form-control" style="text-align: center;" id="Correo" placeholder="Correo@correo.com" readonly>
                                        </div>
                                        <div class="form-group">
                                          <h4 for="Alternativo_revisor">Correo Alternativo</h4>
                                          <input value="<?php echo $correo_alternativo ?>" type="email" class="form-control" style="text-align: center;" id="Alternativo" placeholder="Alternativo@correo.com" readonly>
                                        </div>
                                        <div class="form-group">
                                          <h4 for="Telefono_revisor">Teléfono</h4>
                                          <input value="<?php echo $telefono ?>" type="tel" class="form-control" style="text-align: center;" id="Telefono_" placeholder="##########" readonly>
                                        </div>
                                    </div>
                                    <div class="container-fluid row" align="right">
                                         <div class="form-group col-md-6">
                                        </div>
                                        <div class="form-group col-md-6" align="right" >
                                            <div class="row">
                                                <div class="col-xs-6" >
                                                    <button type="button" data-toggle="modal" data-target="#login" class="btn btn-warning btn-block"><span class="glyphicon glyphicon-edit"></span> Cambiar Contraseña</button>
                                                </div>
                                                <div class="col-xs-6" >
                                                    <button type="button" data-toggle="modal" data-target="#modal_perfil" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-edit"></span> Editar Perfil</button>
                                                </div>
                                            </div>
                                        </div>
                                             
                                                <?php     
                                            $sql=$conexion->prepare("Select URL_Ficha_Pres as Url from revisor where idRevisor = '$idRevisor'");
                                            $sql->execute();
                                             $sql->setFetchMode(PDO::FETCH_ASSOC);
                                             $result = $sql->fetchAll();
                                        
                                            foreach ($result as $row) 
                                            {
                                                $url= $row['Url'];

                                                 if ($url != "")
                                                    {
                                                        $radio="visibility: hidden";   
                                                    }
                                                      else 
                                                      {
                                                          $radio="";
                                                      }
                                             }
                                        ?>
                                        <fieldset <?=$radio?>>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalLong"<?=$radio?> >
                                              Subir curriculum</button>
                                            <!-- fin del boton del modal-->
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!--SECCIÓN1 - PERFIL-->
        <!--SECCIÓN2 - MODALES-->
              <!-- Modal -->
    <form action="sub_curriculum.php" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" data-backdrop="false">
            <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Curriculum</h4>
                      </div>
                        <div class="modal-body">
                            <center><p>Solo puedes subir archivos con formato <strong>PDF</strong></p></center>
                            <div class="form-control"><input type="file" name="archivo" align="center">
                            </div>
                        </div>
                         <div class="modal-footer">
                                <div class="col-md-5">
                                  <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cancelar</button>
                                </div>
                                <div class="col-md-7">
                                   <button type="submit" name="subir_curri" class="btn btn-primary btn-block"> Guardar</button>
                                </div>
                        </div>
                    </div>
            </div>
        </div>
    </form>
        <!-- Modal LOGIN-->
        <div class="modal fade" id="login" role="dialog">
            <div class="modal-dialog">
            <!-- Contenido del modal-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h1 class="modal-title">Cambiar Contraseña</h1>
                    </div>
                    <form role="form" action="mod_contra.php" method="post">
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="form-group">
                                    <h4>Nueva Contraseña</h4>
                                    <input type="password" class="form-control" style="text-align: center" name="contra">
                                </div>
                                <div class="form-group">
                                    <h4>Repite la Contraseña</h4>
                                    <input type="password" class="form-control" style="text-align: center" name="repite_contra">
                                </div>
                                <p>Deberás iniciar sesión una vez que cambies los datos de inicio de sesión.</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-md-3">
                                <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><span class="glyphicon glyphicon-floppy-remove"></span> Cancelar</button>
                            </div>
                            <div class="col-md-9">
                                <button type="submit" name="guardar" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal LOGIN-->
        <!-- Modal PERIL-->
        <div class="modal fade" id="modal_perfil" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title">EDITAR PERFIL</h1>
                    </div>
                    <form method="post" action="mod_perfil.php">
                        <div class="modal-body">
                            <div class="container-fluid row">
                                <div class="col-md-6 container-fluid">
                                    <div class="form-group">
                                      <h4 for="Nombre_contacto">Nombre(s)</h4>
                                      <input value="<?php echo $nombres ?>" type="text" class="form-control" style="text-align: center;" name="nombres">
                                    </div>
                                    <div class="form-group">
                                      <h4 for="ApellidoP_contacto">Apellidos Paterno</h4>
                                      <input value="<?php echo $apellidop ?>" type="text" class="form-control" style="text-align: center;" name="apellidop">
                                    </div>
                                    <div class="form-group">
                                      <h4 for="ApellidosM_contacto">Apellidos Materno</h4>
                                      <input value="<?php echo $apellidom ?>" type="text" class="form-control" style="text-align: center;" name="apellidom">
                                    </div>
                                </div>
                                <div class="col-md-6 container-fluid">
                                    <div class="form-group">
                                      <h4 for="Correo_contacto">Correo Electrónico</h4>
                                      <input value="<?php echo $correo_electronico ?>" type="email" class="form-control" style="text-align: center;" name="correo">
                                    </div>
                                    <div class="form-group">
                                      <h4 for="Alternativo_contacto">Correo Alternativo</h4>
                                      <input value="<?php echo $correo_alternativo ?>" type="email" class="form-control" style="text-align: center;" name="correo_alternativo">
                                    </div>
                                    <div class="form-group">
                                      <h4 for="Telefono_contacto">Teléfono</h4>
                                      <input value="<?php echo $telefono ?>" type="tel" class="form-control" style="text-align: center;" name="telefono">
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid">
                                <h4 for="Institucion_contacto">Institución</h4>
                                <input value="<?php echo $institucion ?>" type="text" class="form-control" style="text-align: center;" name="instituto">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><span class="glyphicon glyphicon-floppy-remove"></span> Cancelar</button>
                            </div>
                            <div class="col-md-10">
                                <button type="submit" name="guardar" class="btn btn-primary btn-block" style="resize: both"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal EDITA PERFIL-->
        <!--SECCIÓN2 - MODALES-->
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
       $('#btn').prop('disabled',true); 
         var cantidad = 0;
    function seleccionar(tr, valor){
      
        $(function(){
            if($("#chk"+valor).attr("checked") == "checked")
            {
                $("#chk"+valor).attr("checked", false);
                $("#chk"+valor).prop("checked", false);
                $(tr).css("background-color", "#FFFFFF");
                 
                 cantidad--;
                console.log(valor);
            }
            else if(cantidad<3)
            {    
                $("#chk"+valor).attr("checked", true);
                $("#chk"+valor).prop("checked", true);
                $(tr).css("background-color", "#BEDAE5");
                         
                    cantidad++;
                console.log(valor);
            }
             if(cantidad > 2)
                {
                    $('#btn').prop('disabled',false);
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


