<?php 
include_once("../conexion.php");
    $conexion = conectar();
    session_start();
    $idUsuario = $_SESSION["id"];

error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(isset($_POST["guardarlinea"]))
{
    
    
        $ids=$_POST['check'];
        $sentencia="select idRevisor from revisor where idUsuario = $idUsuario";
        $sql=$conexion->prepare($sentencia);
        $sql->execute();
                foreach($sql as $dato)
                {
                    $idRevisor=$dato["idRevisor"];
                }
                    for($x=0; $x<count($ids); $x++)
                    {
                        $sql=$conexion->prepare("insert into revisor_linea (idLinea, idRevisor, Principal) values ($ids[$x], $idRevisor,0)");
                        $sql->execute();   
                    }
    if($sql>0)
    {
        $_SESSION['mensaje'] = "alertify.success('Lineas de investigacion almacenadas con éxito.')";
            header("Location: linea_in.php");
    }
    else 
            {
                $_SESSION['mensaje'] = "alertify.warning('Ha ocurrido un error,s intenta nuevamente...')";
                header("Location: editar_perfil.php");
            }
}
?>