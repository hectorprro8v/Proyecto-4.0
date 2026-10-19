<?php

include_once "../conexion.php";
$con = conectar();
//--------------------CONSULTA REVISORES------------------------------------------
try {
    $sql = $con->prepare("SELECT revisor.idRevisor, 
              (usuario.Nombres, ' ', usuario.Apellido_Paterno, ' ', usuario.Apellido_Materno) As nombre,
              usuario.Institucion AS Institucion
              FROM revisor
              INNER JOIN usuario ON revisor.idUsuario = usuario.idUsuario;");
       $sql->execute();
       $sql->setFetchMode(PDO::FETCH_NUM);
       $result = $sql->fetchAll();
      } 
       catch (PDOException $e) 
       {
        print "Error: " . $e->getMessage() . "<br>";
        die();
       }
?>
