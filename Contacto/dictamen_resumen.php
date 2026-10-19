<?php 
    error_reporting(E_ALL ^ E_NOTICE);
    include("../conexion.php");
    $conexion=conectar();
    $clave_articulo = $_GET['clave'];

    session_start();
    if($clave_articulo==null)
    {
        header("Location: resumenes.php");
    }
    else
    {
        $sql="select idDocumento, doc.URL from documento as doc, articulo as ar where doc.idArticulo = ar.idArticulo and ar.Clave_Articulo = '$clave_articulo' and Tipo_Documento='DR'";
        $sentencia=$conexion->prepare($sql);
        $sentencia->execute();
        foreach($sentencia as $dato)
        {
            $id_doc = $dato["idDocumento"];
            $url_doc = $dato["URL"];
        }
        
        if($sentencia->rowCount()>0){
            $sql="update documento set Fecha_Recepcion = current_date() where idDocumento = $id_doc";
            $sentencia=$conexion->prepare($sql);
            $sentencia->execute();
            
            if($sentencia){
                $_SESSION["mensaje"]="alertify.success('El documento se está descargando...')";
                header("Location: $url_doc");
            }
        }
        
    }