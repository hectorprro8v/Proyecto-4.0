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
        $sql="select doc.URL from documento as doc, articulo as ar where doc.idArticulo = ar.idArticulo and ar.Clave_Articulo = '$clave_articulo' and Tipo_Documento='E'";
        $sentencia=$conexion->prepare($sql);
        $sentencia->execute();
        foreach($sentencia as $dato)
        {
            $url_doc = $dato["URL"];
        }

        header("Location: $url_doc");
    }