<?php
include_once '../conexion.php';
$conexion=conectar();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

try
{
    $sqlCE=$conexion->prepare("SELECT a.clave_articulo as cla_articulo,a.idArticulo as idarticulo, a.nombre_articulo as nombre, l.nombre as Linea, count(rc.idUsuario) as totalrev
 from articulo as a 
 inner join linea_investigacion as l on l.idlinea=a.idlinea
 left join resumen_comite as rc on rc.idArticulo=a.idArticulo
 where a.Dictamen_Resumen is null
 group by a.idArticulo
having count(rc.idUsuario)<3 ");
    
    $sqlCE->execute();
    $sqlCE->setFetchMode(PDO::FETCH_ASSOC);
    $resultCE = $sqlCE->fetchAll();
    
    $sqlRev=$conexion->prepare("Select a.clave_articulo as cla_articulo, a.idArticulo as idarticulo , a.nombre_articulo as nombre, l.nombre as Linea, count(er.idRevisor) as totalrev
from  articulo as A 
inner join extenso as e on A.idArticulo=e.idArticulo
inner join linea_investigacion as l on l.idlinea=A.idlinea 
left join extenso_revisor as er on er.idArticulo=a.idArticulo
where A.Dictamen_Resumen = 1 and a.idArticulo in (Select idArticulo from extenso) 
and e.Concluido=1 and e.Aceptado is null
group by a.idArticulo
having count(er.idRevisor)<3");
    
    $sqlRev->execute();
    $sqlRev->setFetchMode(PDO::FETCH_ASSOC);
    $resultRev = $sqlRev->fetchAll();
    
}

catch(PDOException $e)
{
    print "Error: ".$e->getMessage()."<br>";
    die();
}
?>



