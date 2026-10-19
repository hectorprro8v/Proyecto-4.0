<?php

    include("../conexion.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);

    if(isset($_POST['subir_curri']))
    {
        try
        {
        $conexion = conectar();
        $formato = array('.pdf');   

        session_start();
        $idUsuario = $_SESSION["id"];

            $sentencia="select idRevisor from revisor where idUsuario = $idUsuario";
            $sql=$conexion->prepare($sentencia);
            $sql->execute();
            foreach($sql as $dato)
            {
                $idRevisor=$dato["idRevisor"];
            }
            
            
            $nombre_archivo = $_FILES['archivo']['name'];
            $tmp_nombre = $_FILES['archivo']['tmp_name'];
            $destino = "../Documentos/C_Revisor/CV-".$idRevisor.".pdf";
            $extension_archivo = substr($nombre_archivo, strrpos($nombre_archivo, '.'));
            
            if($nombre_archivo != "")
            {
                if(in_array($extension_archivo, $formato))
                {
                    if(move_uploaded_file($tmp_nombre, $destino))
                    {

                        $sql=$conexion->prepare("Update Revisor set URL_Ficha_Pres='$destino' where idRevisor = '$idRevisor'");
                        $sql->execute();
                        
                        $_SESSION['mensaje']= "alertify.success('El curriculum se ha enviado de manera exitosa...')";
                        //$mensaje = "El documento se ha enviado de manera exitosa";
                        header('Location: perfil.php');
                    }
                    else
                    {
                        $_SESSION['mensaje']= "alertify.error('Ha ocurrido un error, el curriculum no se ha enviado. Error: ".$e->getMessage().".')";
                        header('Location: perfil.php');
                    }
                }
                else
                { 
                    $_SESSION['mensaje']= "alertify.warning('El tipo de archivo no es admitido, solamente se permiten documentos .pdf ').";
                    header('Location: ../index.php');
                }
            }
            else
            {
                $_SESSION['mensaje']= "alertify.warning('No se ha especificado un nombre de archivo válido, intenta nuevamente.')";
                header('Location: perfil.php');
            }
        }
        catch(PDOException $e)
        {
            $_SESSION['mensaje']= "alertify.error('Ha ocurrido un error, el curriculum no se ha enviado. Error: ".$e->getMessage().".')";
            header('Location: perfil.php');
        }
    }

    else
    {
        header("Location: perfil.php");
    }
          
?>