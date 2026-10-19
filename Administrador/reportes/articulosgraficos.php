<?php
header('Content-type: application/json');
include_once "../../conexion.php";
$con=conectar();


/*-------------------------Articulos---------------------------*/
$result3 = array();

$articulos = "Select 'Aceptado' as Estado,(Select COUNT(Aceptado) from articulo where Aceptado=1) as Articulos,
((Select COUNT(Aceptado) from articulo where Aceptado=1)*100)/(Select COUNT(Aceptado) 
from articulo where Aceptado is not null) as Porcentaje
union
Select 'No Aceptado',(Select COUNT(Aceptado) from articulo where Aceptado=0) as Articulos,
((Select COUNT(Aceptado) from articulo where Aceptado=0)*100)/(Select COUNT(Aceptado) 
from articulo where Aceptado is not null) as Porcentaje";
$resarticulos3 = $con->prepare($articulos);
$resarticulos3->execute();

while ($fila = $resarticulos3->fetch(PDO::FETCH_ASSOC)){
    array_push($result3, array($fila["Estado"], $fila["Porcentaje"] ));
}

print json_encode($result3, JSON_NUMERIC_CHECK);

?>