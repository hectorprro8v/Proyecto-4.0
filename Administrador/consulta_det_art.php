<?php

include("../conexion.php");
$conexion = conectar();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION["id"] == "") {
    header("Location: ../index.php");
    exit;
}

$idContacto = $_SESSION['id'];

try {

    $articulos = "
        SELECT 
            art.idArticulo,
            art.idLinea,
            art.idContacto,
            art.Clave_Articulo,
            art.Nombre_Articulo,

            GROUP_CONCAT(
                DISTINCT CONCAT(
                    aut.Nombres, ' ',
                    aut.Apellido_Paterno, ' ',
                    aut.Apellido_Materno
                )
                SEPARATOR '<br><br>'
            ) AS Autores,

            ex.Status_Ext,
            re.Status_Art,
            re.Aceptado,
            art.Publicado

        FROM articulo AS art

        LEFT JOIN autores AS aut
            ON art.idArticulo = aut.idArticulo

        LEFT JOIN linea_investigacion AS li
            ON art.idLinea = li.idLinea

        LEFT JOIN extenso AS ex
            ON art.idArticulo = ex.idArticulo

        LEFT JOIN resumen AS re
            ON art.idArticulo = re.idArticulo

        WHERE art.idContacto = :idContacto

        GROUP BY
            art.idArticulo,
            art.idLinea,
            art.idContacto,
            art.Clave_Articulo,
            art.Nombre_Articulo,
            ex.Status_Ext,
            re.Status_Art,
            re.Aceptado,
            art.Publicado

        ORDER BY art.idArticulo DESC
    ";

    $gsent = $conexion->prepare($articulos);

    $gsent->bindParam(
        ':idContacto',
        $idContacto,
        PDO::PARAM_INT
    );

    $gsent->execute();

    $articulos_result = $gsent->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {

    die("Error: " . $e->getMessage());

}

?>