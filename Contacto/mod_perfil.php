<?php
    include_once("../conexion.php");
    $conexion = conectar();
    session_start();
    $idContacto = $_SESSION["id"];
    if($idContacto=="")
    {
        header("Location: ../index.php");
    }

    if(isset($_POST["guardar"]))
    {
        $nombres = $_POST["nombres"];
        $apellidop = $_POST["apellidop"];
        $apellidom = $_POST["apellidom"];
        $instituto= $_POST["instituto"];
        $correo= $_POST["correo"];
        $correo_alternativo = $_POST["correo_alternativo"];
        $telefono = $_POST["telefono"];
        
        if($nombres!="" && $apellidop!="" && $apellidom!="" && $instituto!="" && $telefono!="" && $correo!="")
        {
            try
            {
                $sql = "update usuario set Correo_Electronico = '$correo', Nombres = '$nombres', Apellido_Paterno = '$apellidop', Apellido_Materno = '$apellidom', Telefono = '$telefono', Institucion = '$instituto', Correo_Alternativo = '$correo_alternativo' where idUsuario = $idContacto";
                $sentencia = $conexion->prepare($sql);
                $sentencia->execute();
                
                if($sentencia>0)
                {
                    $_SESSION['mensaje'] = "alertify.success('La información de perfil se ha actualizada.')";
                    header("Location: perfil.php");
                }
                else
                {
                    $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error, no se han guardado los datos, intenta nuevamente...')";
                    header("Location: perfil.php");
                }
            }
            catch(PDOException $e)
            {
                $_SESSION['mensaje'] = "alertify.error('Ah ocurrido un error al tratar de guardar los datos. Error: ".$e->getMessage()."')";
                header("Location: perfil.php");
            }
        }
        else
        {
            $_SESSION['mensaje'] = "alertify.error('Se deben llenar todos los campos, excepto el correo alternativo el cual es opcional.')";
            header("Location: perfil.php");
        }
    }
    else
    {
        header("Location: perfil.php");
    }