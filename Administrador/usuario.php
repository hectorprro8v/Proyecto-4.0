<?php
    error_reporting(E_ALL ^ E_NOTICE);
    include("../conexion.php");
    $conexion = conectar();
    session_start();
    if($_SESSION["id"] == "")
    {
        header("Location: ../index.php");
        exit();
    }

    include("../verificacion.php");
    Nolink();

    $correo = $_SESSION['correo'];

    /*Consulta los resumenes y status*/
    $sentencia = "select * from usuario where Correo_Electronico = '$correo'";
    $gsent = $conexion->prepare($sentencia);
    $gsent->execute();
    $usuario_result = $gsent->fetchAll();

    foreach($usuario_result as $filas){
        $idUsuario = $filas["idUsuario"];
        $correo_electronico = $filas["Correo_Electronico"];
        $nombres = $filas["Nombres"];
        $apellidop = $filas["Apellido_Paterno"];
        $apellidom = $filas["Apellido_Materno"];
        $telefono = $filas["Telefono"];
        $institucion = $filas["Institucion"];
        $correo_alternativo = $filas["Correo_Alternativo"];
    }
    $parametros = "select * from parametros";
    $param = $conexion->prepare($parametros);
    $param->execute();
    $param_result = $param->fetchAll();

    foreach($param_result as $filas){
        $nombreRevista = $filas["Nombre_Revista"];
        $volumen = $filas["Volumen"];
        $numero = $filas["Numero"];
        $anio = $filas["Anio"];
        $color =$filas["Color_Revista"];
        $con_Art = $filas["Consec_Art"];
        $linkRevista = $filas["Link_Publicacion"];
    }

    
    $registro = "select * from registro order by id_registro desc";
    $reg = $conexion->prepare($registro);
    $reg->execute();
    $registro_result = $reg->fetchAll();
    
    
    

?>