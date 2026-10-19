<?php
    include_once("../conexion.php");
    $conexion = conectar();
    session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

    $correo = $_SESSION["correo"];

    $nombres = $_POST["nombres"];
    $apellidop = $_POST["apellidop"];
    $apellidom = $_POST["apellidom"];
    $instituto= $_POST["instituto"];
    $correo_alternativo = $_POST["correo_alternativo"];
    $telefono = $_POST["telefono"];
    
    if(isset($_POST["guardar"]))
    {
        if($nombres!="" && $apellidop!="" && $apellidom!="" && $instituto!="" && $telefono!="")
        {
            try
            {
                $sql = "update usuario set Nombres = '$nombres', Apellido_Paterno = '$apellidop', Apellido_Materno = '$apellidom', Telefono = '$telefono', Institucion = '$instituto', Correo_Alternativo = '$correo_alternativo', Nuevo = 0 where Correo_Electronico = '$correo'";
                $sentencia = $conexion->prepare($sql);
                $sentencia->execute();
                
                if($sentencia>0)
                {
                    $_SESSION['mensaje'] = "alertify.success('Los datos han sido almacenados con éxito.')";
                    header("Location: index.php");
                }
                else
                {
                    $_SESSION['mensaje'] = "alertify.warning('Ha ocurrido un error, no se han guardado los datos, intenta nuevamente...')";
                    header("Location: editar_perfil.php");
                }
            }
            catch(PDOException $e)
            {
                $_SESSION['mensaje'] = "alertify.error('Ah ocurrido un error al tratar de guardar los datos. Error: ".$e->getMessage()."')";
                header("Location: ../index.php");
            }
        }
    }