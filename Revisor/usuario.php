
<?php
    error_reporting(E_ALL ^ E_NOTICE);
    include("../conexion.php");
    $conexion = conectar();
    session_start();


error_reporting(E_ERROR | E_WARNING | E_PARSE);


    $correo = $_SESSION['correo'];

    /*Consulta los datos del usuario*/
    $sentencia = "select * from usuario where Correo_Electronico = '$correo'";
    $gsent = $conexion->prepare($sentencia);
    $gsent->execute();
    $usuario_result = $gsent->fetchAll();

    foreach($usuario_result as $filas)
    {
        $idUsuario = $filas["idUsuario"];
        $correo_electronico = $filas["Correo_Electronico"];
        $nombres = $filas["Nombres"];
        $apellidop = $filas["Apellido_Paterno"];
        $apellidom = $filas["Apellido_Materno"];
        $telefono = $filas["Telefono"];
        $institucion = $filas["Institucion"];
        $correo_alternativo = $filas["Correo_Alternativo"];
    }
?>
