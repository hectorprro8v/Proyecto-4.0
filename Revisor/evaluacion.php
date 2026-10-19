<?php
session_start();
$idUsuario=$_SESSION["id"];
include("../conexion.php");
$conexion=conectar();

$sqlsm = $conexion->prepare("SELECT a.Nombre_Articulo, u.Nombres as nombre, u.Apellido_Paterno, u.Apellido_Materno, u.Institucion,
    Modificaciones as m, Observaciones as o,
   (case ex.Aceptado when 1 then 'Aceptado' when 0 then 'No Aceptado' end) as e, ex.Concluido as Concluido
   From articulo as a inner join  usuario as u  inner join Extenso_Revisor as ex 
   where u.idUsuario = $idUsuario and a.Clave_Articulo = '$clavearticulo' group by a.idArticulo");   

    $sqlsm->execute();
    $sqlsm->setFetchMode(PDO::FETCH_ASSOC);
    $result = $sqlsm->fetchAll();
?>