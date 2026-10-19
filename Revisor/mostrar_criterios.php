<?php
include_once '../conexion.php';
$conexion = conectar();
error_reporting(0);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

try
{
  $sqlCriterios = $conexion->prepare("SELECT * FROM criterios;");

  $sqlCriterios->execute();
  $sqlCriterios->setFetchMode(PDO::FETCH_NUM);
  $resultCriterios = $sqlCriterios->fetchAll();

  $sqlDatosExRev=$conexion->prepare("SELECT
    C.idCriterio, CER.id_extenso_revisor AS idER, CER.observaciones as Observaciones,
    concat(U.Nombres, ' ',U.Apellido_Paterno, ' ', U.Apellido_Materno) AS Revisor,
    C.descripcion AS Criterios,
    CER.estatus AS Estatus
    FROM
    criterio_extenso_revisor as CER INNER JOIN
    criterios AS C ON C.idCriterio = CER.idCriterio INNER JOIN
    extenso_revisor AS ER ON CER.id_extenso_revisor = ER.id_extenso_revisor INNER JOIN
    articulo AS A ON A.idArticulo = ER.idArticulo INNER JOIN
    revisor AS R ON R.idRevisor = ER.idRevisor INNER JOIN
    usuario AS U ON U.idUsuario = R.idUsuario
    where A.Clave_Articulo = '$clavearticulo'");

  //$sqlDatosExRev->execute();
  $sqlDatosExRev->setFetchMode(PDO::FETCH_NUM);
  $resultExRev = $sqlDatosExRev->fetchAll();

  $sqlObsMod = $conexion->prepare("SELECT
    EXR.id_extenso_revisor AS idER,
    EXR.idArticulo,
    EXR.Modificaciones,
    EXR.Observaciones,
    EXR.Aceptado
    from
		extenso_revisor AS EXR
    inner join
		articulo as ART ON ART.idArticulo = EXR.idArticulo
    WHERE
    ART.Clave_Articulo = '$clavearticulo';;
    ");

  //$sqlObsMod->execute();
  $sqlObsMod->setFetchMode(PDO::FETCH_NUM);
  $resultObsMod = $sqlObsMod->fetchall();

  //Observaciones Criterios
  $sqlObsCrit = $conexion->prepare("SELECT
      CER.idCriterio, CER.observaciones, estatus
      FROM
      criterio_extenso_revisor as CER
      INNER JOIN
      extenso_revisor as ER ON ER.id_extenso_revisor = CER.id_extenso_revisor
      INNER JOIN
      revisor as R ON R.idRevisor = ER.idRevisor
      INNER JOIN
      usuario as U ON U.idUsuario = R.idUsuario
      INNER JOIN
	    articulo as art on art.idArticulo = ER.idArticulo
      WHERE
      U.idUsuario = '$idUsuario' AND art.Clave_Articulo = '$clavearticulo';");
  $sqlObsCrit->execute();
  $sqlObsCrit->setFetchMode(PDO::FETCH_NUM);
  $resultObsCrit = $sqlObsCrit->fetchall();
}
catch(PDOException $e)
{
  print "Error: ".$e->getMessage()."<br>";
  die();
}
?>
