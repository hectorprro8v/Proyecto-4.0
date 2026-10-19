<?php 
    include("../conexion.php");
    $conexion=conectar();

error_reporting(E_ERROR | E_WARNING | E_PARSE);

    $clavearticulo = $_GET['clave'];
    if($clavearticulo==null)
    {
        header("Location: articulos.php");
    }
    error_reporting(E_ALL ^ E_NOTICE);

    $sql=" Select URL from documento where Tipo_Documento='ESA' and idArticulo=
 (Select idArticulo from articulo where Clave_Articulo = '$clavearticulo');";
    $sentencia=$conexion->prepare($sql);
    $sentencia->execute();
    foreach($sentencia as $dato)
    {
        $url_doc = $dato["URL"];
    }

    header("Location: $url_doc");