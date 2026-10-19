<?php
include_once "../../conexion.php";
$con=conectar();

        $sql = $con->prepare("select Estado from articulo group by estado");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $result = $sql->fetchAll();

        $sql2 = $con->prepare("select Institucion from articulo group by institucion");
        $sql2->execute();
        $sql2->setFetchMode(PDO::FETCH_ASSOC);
        $result2 = $sql2->fetchAll();

?>

