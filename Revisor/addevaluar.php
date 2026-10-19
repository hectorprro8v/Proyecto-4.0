<?php
include("../conexion.php");
$conexion = conectar();
session_start();
error_reporting(0);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
$idUsuario = $_SESSION["id"];
//Traer id Revisor
$sentencia="SELECT idRevisor from revisor where idUsuario = $idUsuario";
$sql=$conexion->prepare($sentencia);
$sql->execute();
foreach($sql as $dato)
{
  $idRevisor=$dato["idRevisor"];
}
//--------------------------------

if (isset($_POST['guardar']))
{
  $clave = $_POST['clave'];
  $peticion3 = "SELECT ER.id_extenso_revisor from
  extenso_revisor AS ER
  INNER JOIN articulo AS ART ON ART.idArticulo =  ER.idArticulo
  where idRevisor = $idRevisor AND ART.Clave_Articulo = '$clave';";
  $stmt3 = $conexion->prepare($peticion3);
  $stmt3->execute();

  foreach ($stmt3 as $rev) {
    $idExtRev = $rev[0];
  }

  $acept = $_POST['radiob'];
  if($acept == null) {
    $acept = "N";
  }
  $modif = $_POST['mods'];
  $obser = $_POST['obs'];
  $clave = $_POST['clave'];
  $Con = $_POST['cbox'];

  $idsCrit = $_POST['idsCrit'];
  $obsCrit = $_POST['obsCriterio'];
  $estatusCrit = $_POST['estatusCrit'];
  $cantCrit = $_POST['cantCrit'];
  $variables = array($acept,$modif,$obser,$clave,$clave,$Con,$idsCrit,$estatusCrit,$cantCrit);
  //echo json_encode($variables);
  try
  {
    if ($_POST['hayDatos'] != '0') {
      for ($j=0; $j < $cantCrit; $j++) {
        $sentencias = $conexion->prepare("UPDATE
          criterio_extenso_revisor as CER
          set
          CER.observaciones = :obsCri,
          CER.estatus = :est
          WHERE
          CER.id_extenso_revisor = :id_er
          and
          CER.idCriterio = :id_cri;");
          $sentencias->bindParam(':id_er', $idExtRev, PDO::PARAM_INT);
          $sentencias->bindParam(':id_cri',$idsCrit[$j], PDO::PARAM_INT);
          $sentencias->bindParam(':obsCri',$obsCrit[$j], PDO::PARAM_STR);
          $sentencias->bindParam(':est',$estatusCrit[$j], PDO::PARAM_BOOL);
          $sentencias->execute();
        }
      }
      else{
        for ($i=0; $i < $cantCrit; $i++) {
          $sentencias = $conexion->prepare("INSERT INTO
            criterio_extenso_revisor(id_extenso_revisor,idCriterio,observaciones,estatus)
            values(:id_er, :id_cri, :obsCri, :est)");
            $sentencias->bindParam(':id_er', $idExtRev, PDO::PARAM_INT);
            $sentencias->bindParam(':id_cri',$idsCrit[$i], PDO::PARAM_INT);
            $sentencias->bindParam(':obsCri',$obsCrit[$i], PDO::PARAM_STR);
            $sentencias->bindParam(':est',$estatusCrit[$i], PDO::PARAM_BOOL);
            $sentencias->execute();
          }
        }

        if($Con == 1)
        {
          $peticion = "call spEvalrevisor('$clave','$idRevisor','$acept','$modif','$obser', 1)";
        }
        else
        {
          $peticion= "call spEvalrevisor('$clave','$idRevisor','$acept','$modif','$obser', 0)";
        }
        $stmt = $conexion->prepare($peticion);
        $eva = $stmt->execute();

        // if (count($eva) > 0)
        // {
          $_SESSION['mensaje'] = "alertify.success('Los datos han sido almacenados con éxito.')";
          echo "Los datos han sido almacenados con éxito.";
        // }
        // else
        // {
        //   $_SESSION['mensaje'] = "alertify.Error('Ha ocurrido un error, los datos no se guardaron correctamente...')";
        //   echo "los datos no se guardaron correctamente";
        // }

  }
  catch(PDOException $e)
  {
    $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error, intenta mas tarde. <br>Error: ".$e->getMessage()."')";
    echo "Ha ocurrido un error, intenta mas tarde. \n".$e;
  }
}

?>
