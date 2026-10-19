<?php
   error_reporting(E_ALL ^ E_NOTICE);
   include("../conexion.php");
   $conexion=conectar();
   $idrevisor = $_GET['revisor'];
   if($idrevisor==null)
   {
       header("Location: detalle_revisores.php");
   }
?>