<?php 
    error_reporting(E_ALL ^ E_NOTICE);
    include("../conexion.php");
    $conexion=conectar();
    $idRecibo = $_GET['recibo'];
    if($idRecibo==null)
    {
        header("Location: facturacion.php");
    }
    else
    {
        $sql="select URL from documentos_financiero as doc where Tipo_Documento = 'R' and doc.idRecibo = $idRecibo";
        $sentencia=$conexion->prepare($sql);
        $sentencia->execute();
        foreach($sentencia as $dato)
        {
            $url_doc = $dato["URL"];
        }

        header("Location: $url_doc");
    }