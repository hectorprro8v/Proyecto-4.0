<?php
    include_once("../conexion.php");
    $conexion = conectar();
    session_start();
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    $idUsuario = $_SESSION["id"];
    //Trar id Revisor
    $sentencia="SELECT idRevisor from revisor where idUsuario = $idUsuario";
    $sql=$conexion->prepare($sentencia);
    $sql->execute();
    foreach($sql as $dato)
    {
        $idRevisor=$dato["idRevisor"];
    }


    $peticion3 = "SELECT extenso_revisor.id_extenso_revisor from extenso_revisor where idRevisor = '$idRevisor'";
            $stmt3 = $conexion->prepare($peticion3);
            $stmt3->execute();

            foreach ($stmt3 as $fil) {
                $idExtRev = $fil[0];
            }

            if($Con != null)
            {
                $peticion2 = "INSERT INTO 
                                criterio_extenso_revisor(id_extenso_revisor,idCriterio,observaciones,estatus) 
                            values
                                ('$idRevisor','$idCrit','$obsCrit','$cumplio');";
            }
            else
            {
                $peticion2 = "INSERT INTO 
                                criterio_extenso_revisor(id_extenso_revisor,idCriterio,observaciones,estatus) 
                            values
                                ('$idExtRev','1','$obsCrit','$cumplio');";
            }
                $stmt2 = $conexion->prepare($peticion2);
                $stmt2->execute();

                if ($stmt2 > 0)
                {
                    $_SESSION['mensaje'] = "alertify.success('Los datos han sido almacenados con éxito.')";
                    //header("location: articulos.php");
                }
                else 
                {
                    $_SESSION['mensaje'] = "alertify.Error('Ha ocurrido un error AL GUARDAR LOS CRITERIOS, los datos no se guardaron correctamente...')";
                   //header("location: articulos.php");    
                }

?>