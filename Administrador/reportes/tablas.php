<?php
include("../../conexion.php");
$conexion=conectar();
session_start();


/*-------------- tabla resumenes -----------*/
$resumen = "select 'Aceptado' as Estado,(Select COUNT(*) from resumen where Aceptado=1) as Resumenes,
            ((Select COUNT(*) from resumen where Aceptado=1)*100)/(Select COUNT(*)                                             from resumen where Aceptado is not null) as Porcentaje                                                           union
            select 'No Aceptado',(Select COUNT(*) from resumen where Aceptado=0) as Resumenes,                                 ((Select count(*) from resumen where Aceptado=0)*100)/(Select count(*)                                           from resumen where Aceptado is not null)as Porcentaje
            union
            select 'Total', (Select COUNT(*)from resumen where Aceptado is not null) as Resumenes,
            ((Select COUNT(*) from resumen where Aceptado is not null)*100)/(Select COUNT(*) 
            from resumen where Aceptado is not null) as Porcentaje";
$resresumen = $conexion->prepare($resumen);
$resresumen->execute();

/*-------------- tabla extensos -----------*/
$extenso = "select 'Enviado' as Estado,(select count(idArticulo) from articulo where idArticulo in (Select idArticulo from extenso)) as Extenso,
((Select COUNT(*) from extenso where Aceptado=1)*100)/(Select COUNT(*)
from extenso where Aceptado is not null) as Porcentaje
union
select 'No enviado',(select count(idArticulo) from articulo where idArticulo
not in (Select idArticulo from extenso) and Dictamen_Resumen = 1) as Extenso,
((Select count(*) from extenso where Aceptado=0)*100)/(Select count(*)
from extenso where Aceptado is not null)as Porcentaje
union
select 'Total' as Estado,(Select COUNT(*) from articulo where Dictamen_Resumen = 1) as Total,
((Select COUNT(*) from articulo where Dictamen_Resumen=1)*100)/(Select COUNT(*)
from articulo where Dictamen_Resumen = 1) as Porcentaje";
$resexten = $conexion->prepare($extenso);
$resexten->execute();

/*-------------- tabla articulos -----------*/
$articulo = "Select 'Aceptado' as Estado,(Select COUNT(Aceptado) from articulo where Aceptado=1) as Articulos,
((Select COUNT(Aceptado) from articulo where Aceptado=1)*100)/(Select COUNT(Aceptado) 
from articulo where Aceptado is not null) as Porcentaje
union
Select 'No Aceptado',(Select COUNT(Aceptado) from articulo where Aceptado=0) as Articulos,
((Select COUNT(Aceptado) from articulo where Aceptado=0)*100)/(Select COUNT(Aceptado) 
from articulo where Aceptado is not null) as Porcentaje
union 
select 'Total', (Select COUNT(Aceptado)from articulo where Aceptado is not null) as Articulos,
((Select COUNT(Aceptado) from articulo where Aceptado is not null)*100)/(Select COUNT(Aceptado) 
from articulo where Aceptado is not null) as Porcentaje";
$resarti = $conexion->prepare($articulo);
$resarti->execute();

/*-------------- tabla articulos publicados-----------*/
$articulosp = "select 'Publicado' as Estado,(SELECT count(idArticulo)FROM articulo where Publicado=1) as Publicados,
((SELECT count(idArticulo)FROM articulo where Publicado=1)*100)/
(SELECT count(idArticulo)FROM articulo where Dictamen_Extenso=1) as Porcentaje
union
select 'No Publicado' as Estado,(SELECT count(idArticulo)FROM articulo 
where Publicado=0 and Dictamen_Extenso=1) as Publicados,
((SELECT count(idArticulo)FROM articulo 
where Publicado=0 and Dictamen_Extenso=1)*100)/
(SELECT count(idArticulo)FROM articulo where Dictamen_Extenso=1) as Porcentaje
union
select 'Total',(SELECT count(idArticulo)FROM articulo 
where Dictamen_Extenso=1) as Publicados,
((SELECT count(idArticulo)FROM articulo 
where Dictamen_Extenso=1)*100)/
(SELECT count(idArticulo)FROM articulo where Dictamen_Extenso=1)as Porcentaje";
$resartip = $conexion->prepare($articulosp);
$resartip->execute();


/*------ Tabla resumenes por institucion -----*/
$resumenI="select 'Aceptado' as Estado,(Select COUNT(*) from resumen as r inner join articulo as a
on r.idArticulo = a.idArticulo where r.Aceptado=1 and a.Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as ITSL, 
(Select COUNT(*) from resumen as r inner join articulo as a
on r.idArticulo = a.idArticulo where r.Aceptado=1 and a.Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Externo,
(Select COUNT(*) from resumen as r inner join articulo as a
on r.idArticulo = a.idArticulo where r.Aceptado=1) as Total
UNION
(select 'No Aceptado',(Select count(*) from resumen as r inner join articulo as a
on r.idArticulo = a.idArticulo where r.Aceptado = 0 and a.Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO' ) as Tec,
(Select count(*) from resumen as r inner join articulo as a
on r.idArticulo = a.idArticulo where r.Aceptado = 0 and a.Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Externo,
(Select COUNT(*) from resumen as r inner join articulo as a
on r.idArticulo = a.idArticulo where r.Aceptado=0) as Total)
union
select 'Total',(Select COUNT(*) from resumen as r inner join articulo as a
on r.idArticulo = a.idArticulo where a.Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as ITSL, 
(Select COUNT(*) from resumen as r inner join articulo as a
on r.idArticulo = a.idArticulo where a.Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Externo,
(Select COUNT(*) from resumen as r inner join articulo as a
on r.idArticulo = a.idArticulo) as Total";
$resresumenI=$conexion->prepare($resumenI);
$resresumenI->execute();

/*------ Tabla extensos por institucion -----*/
$extensoI="select 'Enviado' as Estado,(select count(idArticulo) from articulo  where idArticulo in (Select idArticulo from extenso)
and Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as ITSL,
(select count(idArticulo) from articulo  where idArticulo in (Select idArticulo from extenso)
and Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Externo,
(select count(idArticulo) from articulo  where idArticulo in (Select idArticulo from extenso)) as Total
union
select 'No Enviado',(select count(idArticulo) from articulo  where idArticulo not in (Select idArticulo from extenso) and Dictamen_Resumen = 1
and Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO')as ITSL,
(select count(idArticulo) from articulo  where idArticulo not in (Select idArticulo from extenso) and Dictamen_Resumen = 1
and Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Externo,
(select count(idArticulo) from articulo  where idArticulo not in (Select idArticulo from extenso) and Dictamen_Resumen = 1) as Total
union
select 'Total' as Estado,(select count(idArticulo) from articulo where Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO' and Dictamen_Resumen=1) as ITSL,
(select count(idArticulo) from articulo where Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO'
and Dictamen_Resumen=1) as Externo,
(select count(idArticulo) from articulo where Dictamen_Resumen=1) as Total";
$resextensoI=$conexion->prepare($extensoI);
$resextensoI->execute();

/*------ Tabla articulos por institucion -----*/
$articulosI="Select 'Aceptado' as Estado,(Select COUNT(Aceptado) from articulo where Aceptado=1 
and Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as ITSL,
(Select COUNT(Aceptado) from articulo where Aceptado=1 
and Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Externo,
(Select COUNT(Aceptado) from articulo where Aceptado=1) as Total
union
Select 'No Aceptado',(Select COUNT(Aceptado) from articulo where Aceptado=0 
and Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as ITSL,
(Select COUNT(Aceptado) from articulo where Aceptado=0 
and Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Externo,
(Select COUNT(Aceptado) from articulo where Aceptado=0) as Total
union
select 'Total', (Select COUNT(Aceptado)from articulo where Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Tec,
(Select COUNT(Aceptado)from articulo where Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Externo,
(Select COUNT(Aceptado)from articulo) as Total";
$resartiI=$conexion->prepare($articulosI);
$resartiI->execute();


/*------ Tabla articulos publicados por institucion -----*/
$articulospI="select 'Aceptado' as Estado,(SELECT count(a.idArticulo)FROM recibo_pago_detalle as rd
inner join recibo_pago as rp on rd.idRecibo=rp.idRecibo
inner join articulo as a on rd.idArticulo = a.idArticulo where rp.Validado=1 
and a.Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as ITSL,
(SELECT count(a.idArticulo)FROM recibo_pago_detalle as rd
inner join recibo_pago as rp on rd.idRecibo=rp.idRecibo
inner join articulo as a on rd.idArticulo = a.idArticulo where rp.Validado=1 
and a.Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Externos, 
(SELECT count(a.idArticulo)FROM recibo_pago_detalle as rd
inner join recibo_pago as rp on rd.idRecibo=rp.idRecibo
inner join articulo as a on rd.idArticulo = a.idArticulo where rp.Validado=1) as Total
union
select 'No Aceptado' as Estado,(SELECT count(a.idArticulo)FROM recibo_pago_detalle as rd
inner join recibo_pago as rp on rd.idRecibo=rp.idRecibo
inner join articulo as a on rd.idArticulo = a.idArticulo where rp.Validado=0 
and a.Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as ITSL,
(SELECT count(a.idArticulo)FROM recibo_pago_detalle as rd
inner join recibo_pago as rp on rd.idRecibo=rp.idRecibo
inner join articulo as a on rd.idArticulo = a.idArticulo where rp.Validado=0 
and a.Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Externos,
(SELECT count(a.idArticulo)FROM recibo_pago_detalle as rd
inner join recibo_pago as rp on rd.idRecibo=rp.idRecibo
inner join articulo as a on rd.idArticulo = a.idArticulo where rp.Validado=0) as Total
union
select 'Total',(SELECT count(*)FROM recibo_pago_detalle as rd
inner join recibo_pago as rp on rd.idRecibo = rp.idRecibo
inner join articulo as a on rd.idArticulo = a.idArticulo where a.Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as ITSL,
(SELECT count(*)FROM recibo_pago_detalle as rd
inner join recibo_pago as rp on rd.idRecibo = rp.idRecibo
inner join articulo as a on rd.idArticulo = a.idArticulo where a.Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Externo,
(SELECT count(*)FROM recibo_pago_detalle as rd
inner join recibo_pago as rp on rd.idRecibo = rp.idRecibo
inner join articulo as a on rd.idArticulo = a.idArticulo) as Total";
$resartipI=$conexion->prepare($articulospI);
$resartipI->execute();

/*-------------- tabla total-----------*/
$total = "Select 'Recibidos' as Estado,(Select COUNT(*) from articulo) as Articulos,
((Select COUNT(*) from articulo)*100)/(Select COUNT(*) 
from articulo) as Porcentaje
union
select 'Publicados' as Estado,(SELECT count(*)FROM recibo_pago_detalle as rd
inner join recibo_pago as rp on rd.idRecibo=rp.idRecibo where rp.Validado=1) as Articulos,
((Select COUNT(rp.Validado)
from recibo_pago as rp inner join recibo_pago_detalle as rpd on rpd.idRecibo = rp.idRecibo 
where rp.Validado=1)*100)/(Select COUNT(*) 
from articulo) as Porcentaje";
$restotal = $conexion->prepare($total);
$restotal->execute();



/*----------- Grafica resumenes--------------*/
$resumen = "select 'Aceptado' as Estado,(Select COUNT(*) from resumen as r inner join articulo as a
on r.idArticulo = a.idArticulo where r.Aceptado=1 and a.Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as ITSL, 
(Select COUNT(*) from resumen as r inner join articulo as a
on r.idArticulo = a.idArticulo where r.Aceptado=1 and a.Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Externo,
(Select COUNT(*) from resumen as r inner join articulo as a
on r.idArticulo = a.idArticulo where r.Aceptado=1) as Total
UNION
(select 'No Aceptado' as Estado,(Select count(*) from resumen as r inner join articulo as a
on r.idArticulo = a.idArticulo where r.Aceptado = 0 and a.Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO' ) as ITSL,
(Select count(*) from resumen as r inner join articulo as a
on r.idArticulo = a.idArticulo where r.Aceptado = 0 and a.Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Externo,
(Select COUNT(*) from resumen as r inner join articulo as a
on r.idArticulo = a.idArticulo where r.Aceptado=0) as Total)
";
$resresumenes = $conexion->prepare($resumen);
$resresumenes->execute();

$valoresY=array();
$valoresX=array();
$valoresY1=array();
$valoresX1=array();



while ($fila = $resresumenes->fetch(PDO::FETCH_ASSOC)){
    $valoresX[]=$fila["Estado"];
    $valoresY[]=$fila["ITSL"];
    $valoresX1[]=$fila["Estado"];
    $valoresY1[]=$fila["Externo"];

}

$datosX=json_encode($valoresX);
$datosY=json_encode($valoresY);
$datosX1=json_encode($valoresX1);
$datosY1=json_encode($valoresY1);

/*----------- Grafica extensos--------------*/
$extenso = "select 'Enviado' as Estado,(select count(idArticulo) from articulo  where idArticulo in (Select idArticulo from extenso)
and Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as ITSL,
(select count(idArticulo) from articulo  where idArticulo in (Select idArticulo from extenso)
and Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Externo,
(select count(idArticulo) from articulo  where idArticulo in (Select idArticulo from extenso)) as Total
union
select 'No Enviado',(select count(idArticulo) from articulo  where idArticulo not in (Select idArticulo from extenso) and Dictamen_Resumen = 1
and Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO')as ITSL,
(select count(idArticulo) from articulo  where idArticulo not in (Select idArticulo from extenso) and Dictamen_Resumen = 1
and Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Externo,
(select count(idArticulo) from articulo  where idArticulo not in (Select idArticulo from extenso) and Dictamen_Resumen = 1) as Total";
$resextenso = $conexion->prepare($extenso);
$resextenso->execute();

$extensoY=array();
$extensoX=array();
$extensoY1=array();
$extensoX1=array();



while ($fila = $resextenso->fetch(PDO::FETCH_ASSOC)){
    $extensoX[]=$fila["Estado"];
    $extensoY[]=$fila["ITSL"];
    $extensoX1[]=$fila["Estado"];
    $extensoY1[]=$fila["Externo"];

}

$datosExtX=json_encode($extensoX);
$datosExtY=json_encode($extensoY);
$datosExtX1=json_encode($extensoX1);
$datosExtY1=json_encode($extensoY1);

/*----------- Grafica articulos--------------*/
$articulo = "Select 'Aceptado' as Estado,(Select COUNT(Aceptado) from articulo where Aceptado=1 
and Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as ITSL,
(Select COUNT(Aceptado) from articulo where Aceptado=1 
and Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Externos,
(Select COUNT(Aceptado) from articulo where Aceptado=1) as Total
union
Select 'No Aceptado',(Select COUNT(Aceptado) from articulo where Aceptado=0 
and Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as ITSL,
(Select COUNT(Aceptado) from articulo where Aceptado=0 
and Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Externos,
(Select COUNT(Aceptado) from articulo where Aceptado=0) as Total";
$resart = $conexion->prepare($articulo);
$resart->execute();

$articuloY=array();
$articuloX=array();
$articuloY1=array();
$articuloX1=array();

while ($fila = $resart->fetch(PDO::FETCH_ASSOC)){
    $articuloX[]=$fila["Estado"];
    $articuloY[]=$fila["ITSL"];
    $articuloX1[]=$fila["Estado"];
    $articuloY1[]=$fila["Externos"];
}

$datosAX=json_encode($articuloX);
$datosAY=json_encode($articuloY);
$datosAX1=json_encode($articuloX1);
$datosAY1=json_encode($articuloY1);

/*----------- Grafica articulos publicados--------------*/
$articulop = "select 'Aceptado' as Estado,(SELECT count(a.idArticulo)FROM recibo_pago_detalle as rd
inner join recibo_pago as rp on rd.idRecibo=rp.idRecibo
inner join articulo as a on rd.idArticulo = a.idArticulo where rp.Validado=1 
and a.Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as ITSL,
(SELECT count(a.idArticulo)FROM recibo_pago_detalle as rd
inner join recibo_pago as rp on rd.idRecibo=rp.idRecibo
inner join articulo as a on rd.idArticulo = a.idArticulo where rp.Validado=1 
and a.Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Externos, 
(SELECT count(a.idArticulo)FROM recibo_pago_detalle as rd
inner join recibo_pago as rp on rd.idRecibo=rp.idRecibo
inner join articulo as a on rd.idArticulo = a.idArticulo where rp.Validado=1) as Total
union
select 'No Aceptado' as Estado,(SELECT count(a.idArticulo)FROM recibo_pago_detalle as rd
inner join recibo_pago as rp on rd.idRecibo=rp.idRecibo
inner join articulo as a on rd.idArticulo = a.idArticulo where rp.Validado=0 
and a.Institucion = 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as ITSL,
(SELECT count(a.idArticulo)FROM recibo_pago_detalle as rd
inner join recibo_pago as rp on rd.idRecibo=rp.idRecibo
inner join articulo as a on rd.idArticulo = a.idArticulo where rp.Validado=0 
and a.Institucion != 'INSTITUTO TECNOLOGICO SUPERIOR DE LERDO') as Externos,
(SELECT count(a.idArticulo)FROM recibo_pago_detalle as rd
inner join recibo_pago as rp on rd.idRecibo=rp.idRecibo
inner join articulo as a on rd.idArticulo = a.idArticulo where rp.Validado=0) as Total";
$resartp = $conexion->prepare($articulop);
$resartp->execute();

$articulopY=array();
$articulopX=array();
$articulopY1=array();
$articulopX1=array();

while ($fila = $resartp->fetch(PDO::FETCH_ASSOC)){
    $articulopX[]=$fila["Estado"];
    $articulopY[]=$fila["ITSL"];
    $articulopX1[]=$fila["Estado"];
    $articulopY1[]=$fila["Externos"];
}

$datosApX=json_encode($articulopX);
$datosApY=json_encode($articulopY);
$datosApX1=json_encode($articulopX1);
$datosApY1=json_encode($articulopY1);

?>
