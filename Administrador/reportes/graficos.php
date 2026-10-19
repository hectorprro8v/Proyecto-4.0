<?php
header('Content-type: application/json');
include_once "../../conexion.php";
$con=conectar();

/*-------------------------Resumenes---------------------------*/
$result = array();

$resumen = "select 'Aceptado' as Estado,(Select COUNT(*) from resumen where Aceptado=1) as Resumenes,
((Select COUNT(*) from resumen where Aceptado=1)*100)/(Select COUNT(*)
from resumen where Aceptado is not null) as Porcentaje
union
select 'No Aceptado',(Select COUNT(*) from resumen where Aceptado=0) as Resumenes,
((Select count(*) from resumen where Aceptado=0)*100)/(Select count(*)
from resumen where Aceptado is not null)as Porcentaje
";
$resresumen = $con->prepare($resumen);
$resresumen->execute();

while ($fila = $resresumen->fetch(PDO::FETCH_ASSOC)){
    array_push($result, array($fila["Estado"], $fila["Porcentaje"] ));
}

print json_encode($result, JSON_NUMERIC_CHECK);

?>
