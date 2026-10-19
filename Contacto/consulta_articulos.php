<?php
    include("../conexion.php");
    $conexion = conectar();
    session_start();
    if($_SESSION["id"]=="")
    {
        header("Location: ../index.php");
    }
    else
    {
        $idContacto = $_SESSION['id'];

        /*Consulta los resumenes y status*/
        $articulos = "SELECT ar.Clave_Articulo, ar.Nombre_Articulo, re.Status_Art, ex.Status_Ext, re.Concluido, (case ex.Aceptado when 1 then 'Aceptado' when 0 then 'No aceptado' else 'En revision' end) as Estado, ex.idArticulo as Extenso, ar.Publicado, ar.Publicado as P, ar.idArticulo from resumen as re inner join articulo as ar on ar.idArticulo = re.idArticulo left join extenso as ex on ex.idArticulo = ar.idArticulo where ar.Dictamen_Resumen = 1 and ar.idContacto = $idContacto;";
        $gsent = $conexion->prepare($articulos);
        $gsent->execute();
        $articulos_result = $gsent->fetchAll();
    }