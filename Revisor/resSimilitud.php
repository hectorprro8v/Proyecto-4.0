<?php
    error_reporting(E_ALL ^ E_NOTICE);
    include("../conexion.php");
    $conexion=conectar();
    $clave_articulo = $_GET['clave'];
    if($clave_articulo==null)
    {
        header("Location: articulos.php");
    }
    else
    {
        header("Location: ../Documentos/Similitud/$clave_articulo.pdf");
    }