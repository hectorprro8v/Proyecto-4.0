<?php
    include_once("../conexion.php");
    $conexion = conectar();
    session_start();
    error_reporting(E_ERROR | E_WARNING | E_PARSE);

    $idUsuario = $_SESSION["id"];

 $sentencia="select idRevisor from revisor where idUsuario = $idUsuario";
        $sql=$conexion->prepare($sentencia);
        $sql->execute();
        foreach($sql as $dato)
        {
            $idRevisor=$dato["idRevisor"];
        }

        //consulta para llenar las lineas de investigacion
$peticion= "select rl.idLinea as idLinea, li.Nombre as nombre,rl.Principal as p from revisor_linea as rl 
            inner join linea_investigacion as li on rl.idLinea = li.idLinea
            where  idRevisor = $idRevisor group by li.Nombre, rl.idLinea "; 
         
        $resultado = $conexion->prepare($peticion);
        $resultado->execute();
        $resultado->setFetchMode(PDO::FETCH_ASSOC);
        $sq=$resultado->fetchAll();


$sqlsm = $conexion->prepare("select count(Principal) as Lineap from revisor_linea where idRevisor=$idRevisor and Principal = 1 group by Principal");  

    $sqlsm->execute();
    $sqlsm->setFetchMode(PDO::FETCH_ASSOC);
    $result = $sqlsm->fetchAll();
     

if(isset($_POST["glinea"]))
{
    try
    {
        
    $id=$_POST["check"];
    $idRevisor=$dato["idRevisor"];
    
        for($x=0; $x<count($id); $x++)
            {
                $modificar= "update revisor_linea set Principal = 1 where idLinea = $id[$x] and idRevisor = $idRevisor";
                $con= $conexion->prepare($modificar);
                $con->execute();
            }
	if($con>0)
        {
            $_SESSION['mensaje'] = "alertify.success('Se actualizaron las lineas de investigación principales.')";
        }
        else
            {
                $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error, las lineas principales no se han actualizado.')";
            }
 
    }
    catch(PDOExeption $e)
        {
            //echo $e->getMessage();
            $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error, las lineas principales no se han actualizado. <br>Error: ".$e->getMessage()."')";
        }
   
}

?>