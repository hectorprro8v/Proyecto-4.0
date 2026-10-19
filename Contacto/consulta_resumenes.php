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
        $articulos = "select Clave_Articulo, Nombre_Articulo, Status_Art, (case re.Aceptado when 1 then 'Aceptado' when 0 then 'No aceptado' else 'En revisión' end) as Estado from resumen as re, articulo as ar where ar.idContacto = $idContacto and ar.idArticulo = re.idArticulo";
        $gsent = $conexion->prepare($articulos);
        $gsent->execute();
        $articulos_result = $gsent->fetchAll();
    }