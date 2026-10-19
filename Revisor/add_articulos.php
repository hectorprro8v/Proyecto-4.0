<?php
session_start();
$idUsuario = $_SESSION["id"];
include('../conexion.php');
$conexion=conectar();    

error_reporting(E_ERROR | E_WARNING | E_PARSE);

   $peticion = "SELECT a.Clave_Articulo, a.Nombre_Articulo, ex.Concluido as c,ex.Aceptado
	From articulo as a
		inner join extenso as e on e.idArticulo = a.idArticulo 
        inner join extenso_revisor as ex on ex.idArticulo = a.idArticulo
		inner join revisor as r on ex.idRevisor = r.idRevisor 
	where 
    r.idUsuario=$idUsuario"; 

   $stmt = $conexion->prepare($peticion);
   $stmt->execute();
   $result = $stmt->fetchAll();
?>