<?php
header('Content-type: application/json');
include_once "../../conexion.php";
$con=conectar();


/*-------------------------Articulos---------------------------*/
$result4 = array();

$articulos = "Select 'Recibidos' as Estado,(Select COUNT(*) from articulo) as Articulos,
((Select COUNT(*) from articulo)*100)/(Select COUNT(*) 
from articulo) as Porcentaje
union
select 'Publicados' as Estado,(SELECT count(*)FROM recibo_pago_detalle as rd
inner join recibo_pago as rp on rd.idRecibo=rp.idRecibo where rp.Validado=1) as Articulos,
((Select COUNT(rp.Validado)
from recibo_pago as rp inner join recibo_pago_detalle as rpd on rpd.idRecibo = rp.idRecibo 
where rp.Validado=1)*100)/(Select COUNT(*) 
from articulo) as Porcentaje";
$resarticulos4 = $con->prepare($articulos);
$resarticulos4->execute();

while ($fila = $resarticulos4->fetch(PDO::FETCH_ASSOC)){
    array_push($result4, array($fila["Estado"], $fila["Porcentaje"] ));
}

print json_encode($result4, JSON_NUMERIC_CHECK);

?>