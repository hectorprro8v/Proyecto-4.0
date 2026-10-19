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
        $contra = $_POST["contra"];
        $repite_contra = $_POST["repite_contra"];
        
        if($contra!="" && $repite_contra!="")
        {
            if($contra == $repite_contra)
            {
                try
                {
                    $sql = "call sp_ActualizaContraseniaUser('$contra', '$idContacto')";
                    $sentencia = $conexion->prepare($sql);
                    $sentencia->execute();

                    if($sentencia>0)
                    {
                        $_SESSION['mensaje'] = "alertify.success('La contraseña se ha actualizado.')";
                        header("Location: perfil.php");
                    }
                    else
                    {
                        $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error, no se han guardado los cambios, intenta nuevamente...')";
                        header("Location: perfil.php");
                    }
                }
                catch(PDOException $e)
                {
                    $_SESSION['mensaje'] = "alertify.error('Ah ocurrido un error al tratar de guardar los cambios. Error: ".$e->getMessage()."')";
                    header("Location: perfil.php");
                }
            }
            else{
                $_SESSION['mensaje'] = "alertify.error('Las contraseñas no coinsiden, intenta nuevamente...')";
                header("Location: perfil.php");
            }
        }
        else
        {
            $_SESSION['mensaje'] = "alertify.error('Se deben llenar todos los campos.')";
            header("Location: perfil.php");
        }
    }
    else
    {
        header("Location: perfil.php");
    }