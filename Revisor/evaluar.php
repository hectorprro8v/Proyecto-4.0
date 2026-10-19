<?php
  $clavearticulo = $_GET['clave'];
  include_once("addevaluar.php");
  include_once("mostrar_criterios.php");
  include_once("../conexion.php");
  $conexion = conectar();
  session_start();
  if($_SESSION["id"]=="")
  {
    header("Location: ../index.php");
  }
  $idUsuario=$_SESSION["id"]; ?>
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

    <title>EVALUAR - CID TEC LERDO</title>
</head>
<body>
  <br>
  <!--CUERPO DE LA PÁGINA-->
  <!--Menu-->
  <div class="container">
    <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-left" role="navigation">
      <div class="navbar-header">
        <button type="button" style="color:red;" class="navbar-toggle" data-toggle="collapse"
        data-target=".navbar-ex1-collapse">
        <img src=../img/menu.png>
      </button>
      <a class="navbar-brand" href="index.php" style="margin-left:15px;">INICIO</a>
    </div>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
      <ul class="nav navbar-nav">
        <div class="image">
          <img src="../img/Logo_Revista.png" width="90" height="120" alt="User" style="margin-left:40px;">
        </div>
        <br>
        <li class="dropdown">
          <button href="#" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
          type="button"><?php echo $_SESSION["nameuser"]?> <b class="caret"></b></button>
          <ul class="dropdown-menu">
            <li class=""><a href="perfil.php"><span class="glyphicon glyphicon-user"></span> Perfil</a>
            </li>
            <li class="divider"></li>
            <li><a href="../destruir_sesion.php"><span class="glyphicon glyphicon-log-out"></span>
              Salir</a></li>
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
  <form method="POST">
    <div class="container-fluid">
      <div class="container-fluid">
        <div class="panel panel-default" id="sombra">
          <div class="panel-body">
            <center>
              <h2>FORMATO PARA LA EVALUACIÓN DE ARTÍCULOS DE INVESTIGACIÓN</h2>
            </center>
            <hr>
            <!--DATOS DE EVALUACION-->
            <div class="container-fluid">
              <div class="panel panel-default">
                <div class="panel panel-heading" style="background-color: <?=color_revista();?>"></div>
                  <div class="container-fluid">
                    <div>
                      <div class="panel-body">
                        <input type="hidden" name="clave" id="clave" value="<?php echo $clavearticulo?>" />
                        <?php
                          $sentencia="select idRevisor from revisor where idUsuario = $idUsuario";
                          $sql=$conexion->prepare($sentencia);
                          $sql->execute();
                          foreach ($sql as $dato) {
                            $idRevisor=$dato["idRevisor"];
                          }

                          $sqlsm = $conexion->prepare("SELECT
                            a.Nombre_Articulo,
                            l.Nombre,
                            u.Nombres AS nombre,
                            u.Apellido_Paterno,
                            u.Apellido_Materno,
                            u.Institucion,
                            Modificaciones AS m,
                            ex.Observaciones AS o,

                            r.idRevisor,
                            (CASE ex.Aceptado
                              WHEN 'A' THEN 'Aceptado'
                              WHEN 'N' THEN 'No Aceptado'
                              WHEN 'S' THEN 'Segunda Revision'
                              END) AS e,
                              ex.Concluido AS Concluido
                              FROM
                              usuario AS u
                              INNER JOIN
                              revisor AS r ON u.idUsuario = r.idUsuario
                              INNER JOIN
                              extenso_revisor AS ex ON r.idRevisor = ex.idRevisor
                              INNER JOIN
                              articulo AS a ON ex.idArticulo = a.idArticulo
                              INNER JOIN linea_investigacion as L on a.idLinea=L.idLinea
                              WHERE a.Clave_Articulo = '$clavearticulo' and  r.idRevisor = $idRevisor;
                          ");

                          $sqlsm->execute();
                          $sqlsm->setFetchMode(PDO::FETCH_ASSOC);
                          $result = $sqlsm->fetchAll();
                          foreach ($result as $row)
                          {
                            $Nomart = $row["Nombre_Articulo"];
                            $NomLinea = $row["Nombre"];
                            $nombre = $row["nombre"];
                            $pat =$row["Apellido_Paterno"];
                            $mat =$row["Apellido_Materno"];
                            $instituto =$row["Institucion"];
                            $MODS =$row['m'];
                            $OBSER =$row['o'];
                            $Concluido =$row['Concluido'];
                            $E=$row['e'];
                            if($Concluido==1 )
                            {
                              $etiqueta="<h4>".$E."</h4>";
                              $radio="visibility: hidden"; $des= "disabled";$read="readonly";
                            }
                            else
                            {
                              $des="";
                              $read="";
                              $radio="";
                              $etiqueta="";
                            }
                          }?>
                        <div class="form-group">
                          <h4 for="nombre_articulo">NOMBRE DEL ARTÍCULO:</h4>
                          <input type="text" readonly="readonly" class="form-control textbox box"
                          value="<?php echo $Nomart?>" placeholder="nombre del artículo"
                          <?php echo $des;?>>
                        </div>
                        
                        <div class="form-group">
                          <h4 for="nombre_articulo">LÍNEA DE INVESTIGACIÓN:</h4>
                          <input type="text" readonly="readonly" class="form-control textbox box"
                          id="NomLinea" value="<?php echo $NomLinea?>"
                          placeholder="Línea de Investigación" <?php echo $des;?>>
                        </div>

                        <div class="form-group">
                          <h4 for="nombre_articulo">NOMBRE DEL ARBITRO:</h4>
                          <input type="text" readonly="readonly" class="form-control textbox box"
                          id="nombre" value="<?php echo $nombre.' '.$pat.' '.$mat?>"
                          placeholder="nombre del revisor" <?php echo $des;?>>
                        </div>

                       
                        <!-- Button trigger modal -->
                        <h3><button type="button" class="btn btn-warning" data-toggle="modal"
                          data-target="#exampleModalLong">
                          Instrucciones para evaluar
                        </button> </h3>

                        <br>
                        <!--Criterios-->
                        <div class="form-group">
                          <h4 for="nombre_articulo">CRITERIOS A EVALUAR:</h4>
                        </div>
                        <hr>
                        <div class="container-fluid">
                          <div class="panel panel-default">
                            <div class="panel panel-heading" style="background-color:#262621;">
                            </div>
                            <div class="panel-body">
                              <div class="table responsive">
                                <table id="tablaCriterios" class="table table-hover" style="text-align:center">
                                  <thead style="background-color: black; color: white;">
                                    <tr>
                                      <th style="width: 50%">Criterios</th>
                                      <th style="width: 15%">Cumplio</th>
                                      <th style="width: 35%">Observaciones</th>
                                    </tr>
                                  </thead>
                                  <center>
                                  <tbody>
                                    <?php
                                    $cantidadCriterios = 0;
                                    foreach($resultCriterios as $fila)
                                    {
                                      $f1 = $resultObsCrit[$cantidadCriterios];
                                      $idCriterio = $fila[0];
                                      $descripcion = $fila[1];
                                      $puntuacion = $fila[2];
                                      $cantidadCriterios++;
                                      ?>
                                      <tr>
                                        <td style="background-color: black; color: white;">
                                          <?php echo $descripcion; ?></td>
                                          <td style="display: none"><input type="number" name="<?php echo "ID-".$cantidadCriterios;?>" id=<?php echo "ID-".$cantidadCriterios;?>
                                            value=<?php echo $idCriterio;?>>
                                          </td>
                                          <td>
                                            <?php
                                            if ($f1[2]==1) {
                                              ?>
                                              <input type="radio"
                                              name=<?php echo "cumplio-".$idCriterio; ?>
                                              id=<?php echo "cumplio-".$idCriterio; ?> value="1"
                                              checked="checked">
                                              Si
                                              <br>
                                              <input type="radio"
                                              name=<?php echo "cumplio-".$idCriterio; ?>
                                              id=<?php echo "cumplio-".$idCriterio; ?> value="0">
                                              No
                                              <?php
                                            }else{
                                              ?>
                                              <input type="radio"
                                              name=<?php echo "cumplio-".$idCriterio; ?>
                                              id=<?php echo "cumplio-".$idCriterio; ?> value="1"
                                              >
                                              Si
                                              <br>
                                              <input type="radio"
                                              name=<?php echo "cumplio-".$idCriterio; ?>
                                              id=<?php echo "cumplio-".$idCriterio; ?> value="0"
                                              checked="checked">
                                              No
                                            <?php }?>
                                          </td>
                                          <td class="observacionesCrit">
                                            <textarea name=<?php echo "obsCrit-".$idCriterio; ?> cols="50"
                                              id=<?php echo "obsCrit-".$idCriterio; ?> rows="3"><?php echo $f1[1];?></textarea>
                                            </td>
                                          </tr>
                                          <?php
                                        }
                                        ?>
                                      </tbody>
                                      </center>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <br>
                            <br>
                            <center><label>MODIFICACIONES</label></center>
                            <textarea name="mods" id="mods" class="form-control" rows=7
                            style="resize:none; width:center;"
                            placeholder="Introduzca aqui sus comentarios"
                            <?php echo $des;?>><?=$MODS;?></textarea>
                            <br>
                            <br>
                            <br>
                            <center><label>OBSERVACIONES</label></center>
                            <textarea name="obs"  id="obs" class="form-control" rows=7
                            style="resize:none; width:center;"
                            placeholder="Introduzca aqui sus comentarios"
                            <?php echo $des;?>><?=$OBSER?></textarea>
                            <br>
                            <br>
                            <div class="form-group">
                              <h5><label>RESULTADO:</label></h5>
                              <?=$etiqueta ?>
                              <div class="col-md-4">
                                <input type="radio" name="radiob" id="radiob" checked value="A" <?=$radio;?>>
                                <label<?=$radio;?>> ACEPTADO</label>
                              </div>
                              <div class="col-md-4">
                                <input type="radio" id="radiob" name="radiob" value="N" <?=$radio;?>>
                                <label<?=$radio;?>> NO ACEPTADO</label>
                              </div>
                             </div>
                            <br>
                            <br>
                            <div class="form-group">
                              <input type="checkbox" name="cbox" id="cbox" value="1" <?=$radio;?>>
                              <label<?=$radio;?>> TERMINAR EVALUACIÓN</label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <a type="button" class="btn btn-danger btn-block"
                                href="articulos.php"><span
                                class="glyphicon glyphicon-chevron-left"></span>
                                Regresar</a>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-md-6">
                                 <button type="button" class="btn btn-primary btn-block"
                                name="guardar" value="guardar" id="guardar" <?php echo $des;?>><span
                                class="glyphicon glyphicon-floppy-disk"></span>
                                Guardar</button><br> 
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLongTitle">Indicaciones:</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                    <h4>Ciencia, Ingeniería y Desarrollo Tec Lerdo</h4>Publica exclusivamente artículos con resultados
                    originales. NO acepta textos de divulgación científica o que hayan sido publicados con anterioridad
                    en otro idioma.</p>
                    <h5>
                        <p>
                            Agradeceríamos a usted que, al elaborar su arbitraje, tome en consideración los siguientes
                            puntos:
                        </p>
                        <p>a) empleo de fuentes documentales o de consulta que puedan considerarse originales;</p>
                        <p>b) coherencia de la estructura interna: claridad inicial del planteamiento de investigación,
                            desarrollo acorde con el planteamiento y conclusión o resultado del tema investigado;</p>
                        <p>c) al tratarse de artículos en que predominen riesgos de interpretación, evalúe la aportación
                            y pertinencia de ésta en el ámbito de la investigación contemporánea;</p>
                        <p>d) relevancia temática y originalidad; discusión de la materia y contribución para el avance
                            de la disciplina;</p>
                        <p>e) orientación de la línea de argumentación o evidencia empírica hacia la fundamentación de
                            los planteamientos esenciales;</p>
                        <p>f) correspondencia de la metodología con los objetivos de la investigación y/o de la
                            reflexión teórica.(Puede incluir anexos si sus comentarios requieren de un espacio mayor.)
                        </p>
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <!--FIN DEL MODAL-->
</body>
<script>
//console.log(<?php echo json_encode($resultObsCrit); ?>);
$("#guardar").click(async function(e) {
    e.preventDefault();
    //Datos de la tabla
    var idsCrit = new Array();
    var obsCriterio = new Array();
    var estatusCrit = new Array();
    var cantCrit = <?php echo $cantidadCriterios; ?>;
    for (let index = 1; index <= cantCrit; index++) {
        idCrit = $("#ID-"+index).val();
        obsCrit = $("#obsCrit-"+idCrit).val();
        estatus = document.querySelector('input[name=cumplio-'+idCrit+']:checked').value;
        idsCrit.push(idCrit);
        obsCriterio.push(obsCrit);
        estatusCrit.push(estatus);

    }
    radiob = document.querySelector('input[name=radiob]:checked').value;;
    mods = $("#mods").val();
    obs = $("#obs").val();
    clave = $("#clave").val();
    check = document.getElementById('cbox');;
    guardar = $("#guardar").val();
    cbox = 0;
    hayDatos = <?php echo count($resultObsCrit); ?>;

    if(check.checked){
        cbox = 1;
    }
    let datasend ={"idsCrit":idsCrit,
        "obsCriterio": obsCriterio,
        "estatusCrit": estatusCrit,
        "radiob":radiob,
        "mods":mods,
        "obs":obs,
        "clave":clave,
        "cbox":cbox,
        "cantCrit":cantCrit,
        "guardar":guardar,
        "hayDatos":hayDatos,
    };
    //console.log(datasend);
    await $.ajax({
        url: "addevaluar.php",
        type: "POST",
        data: datasend,
        timeout: 600000,
        success: function(data) {
          window.location.href = "articulos.php";

        },error: function(e){
          window.location.href = "articulos.php";
        }
    });
    window.location.href = "articulos.php";
});
</script>

</html>
