<?php
include_once '../conexion.php';
$conexion=conectar();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

try
{
//Obtener tabla de criterios
$sqlCriterios=$conexion->prepare("SELECT * FROM criterios;");
    
    $sqlCriterios->execute();
    $sqlCriterios->setFetchMode(PDO::FETCH_NUM);
    $resultCriterios = $sqlCriterios->fetchAll();
//Tabla Criterio Extenso Revisor
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
	where A.idArticulo = '$idArticulo'
    group by criterios, idER");
    
    $sqlDatosExRev->execute();
    $sqlDatosExRev->setFetchMode(PDO::FETCH_NUM);
    $resultExRev = $sqlDatosExRev->fetchAll();
//Revisores
    $sqlDatosRev=$conexion->prepare("SELECT 
	CER.id_extenso_revisor,
    concat(U.Nombres, ' ',U.Apellido_Paterno, ' ', U.Apellido_Materno) AS Revisor
FROM 
	criterio_extenso_revisor as CER INNER JOIN
    criterios AS C ON C.idCriterio = CER.idCriterio INNER JOIN
    extenso_revisor AS ER ON CER.id_extenso_revisor = ER.id_extenso_revisor INNER JOIN
    articulo AS A ON A.idArticulo = ER.idArticulo INNER JOIN 
   revisor AS R ON R.idRevisor = ER.idRevisor INNER JOIN
    usuario AS U ON U.idUsuario = R.idUsuario
	where A.idArticulo = '$idArticulo'
    group by revisor");
    
    $sqlDatosRev->execute();
    $sqlDatosRev->setFetchMode(PDO::FETCH_NUM);
    $resultRev = $sqlDatosRev->fetchAll();
//Observaciones Generales
$sqlObsMod = $conexion->prepare("SELECT 
a.idArticulo AS idAr, 
a.Clave_Articulo as clave,
a.Nombre_Articulo as titulo,
e.Modificaciones as m,
e.Observaciones as o,
e.ObsCriterio as c
from 
articulo as a
inner join extenso as e on e.idArticulo=a.idArticulo
where  a.idArticulo = '$idArticulo'
order by 
Status_Ext desc;");

$sqlObsMod->execute();
$sqlObsMod->setFetchMode(PDO::FETCH_NUM);
$resultObsMod = $sqlObsMod->fetchall();
    
}
catch(PDOException $e)
{
    print "Error: ".$e->getMessage()."<br>";
    die();
}
?>

