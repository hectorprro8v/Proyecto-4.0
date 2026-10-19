<?php
    include_once("../conexion.php");
    $conexion = conectar();
    session_start();
    $idUsuario = $_SESSION["id"];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
    
    if(isset($_POST["guardar"]))
    {
        $nombre=$_POST['nombre'];
        $apaterno=$_POST['apaterno'];
        $amaterno=$_POST['amaterno']; 
        $tel=$_POST['tel'];
        $instituto=$_POST['instituto'];
        $alternativo=$_POST['alternativo'];
        $perfil=$_POST['perfil'];
        
        $peticion= "call spEperfil($idUsuario, '$nombre','$apaterno','$amaterno','$tel','$instituto','$alternativo','$perfil')"; 
        $stmt = $conexion->prepare($peticion);
        $stmt->execute();
        
        if($stmt>0)
        {
           $_SESSION['mensaje'] = "alertify.success('Los datos han sido almacenados con éxito.')";
            header("Location: perfil.php");
        }
            else 
            {
                $_SESSION['mensaje'] = "alertify.warning('Ha ocurrido un error, no se han guardado los datos, intenta nuevamente...')";
                header("Location: editar_perfil.php");
            }
    }
?>