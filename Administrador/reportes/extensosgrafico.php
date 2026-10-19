<?php
header('Content-type: application/json');
include_once "../../conexion.php";
$con=conectar();


/*-------------------------Articulos---------------------------*/
$result2 = array();

$articulos = "select 'Aceptado' as Estado,(select count(idArticulo) from articulo where idArticulo in (Select idArticulo from extenso)) as Extenso,
((Select COUNT(*) from extenso where Aceptado=1)*100)/(Select COUNT(*)
from extenso where Aceptado is not null) as Porcentaje
union
select 'No Aceptado',(select count(idArticulo) from articulo where idArticulo
not in (Select idArticulo from extenso) and Dictamen_Resumen = 1) as Extenso,
((Select count(*) from extenso where Aceptado=0)*100)/(Select count(*)
from extenso where Aceptado is not null)as Porcentaje
";
$resarticulos = $con->prepare($articulos);
$resarticulos->execute();

while ($fila = $resarticulos->fetch(PDO::FETCH_ASSOC)){
    array_push($result2, array($fila["Estado"], $fila["Porcentaje"] ));
}

print json_encode($result2, JSON_NUMERIC_CHECK);

?>
