<?php

include_once "../conexion.php";
$con = conectar();

try
{
    $sql = $con->prepare("
        SELECT
            a.Clave_Articulo,
            a.Nombre_Articulo,

            COALESCE(
                GROUP_CONCAT(
                    DISTINCT IF(er.Fecha_Revision IS NULL, 'En espera', er.Fecha_Revision)
                    SEPARATOR '<br><br>'
                ),
                'En espera'
            ) AS Fecha,

            CASE
                WHEN e.Aceptado = 1 THEN 'Aceptado'
                WHEN e.Aceptado = 0 THEN 'No Aceptado'
                ELSE 'Pendiente'
            END AS Dictamen,

            COALESCE(
                GROUP_CONCAT(
                    DISTINCT CONCAT(
                        u.Nombres, ' ',
                        u.Apellido_Paterno, ' ',
                        u.Apellido_Materno
                    )
                    SEPARATOR '<br><br>'
                ),
                'Sin revisor asignado'
            ) AS Nombre,

            GROUP_CONCAT(
                DISTINCT er.Modificaciones
                SEPARATOR '\n\n'
            ) AS Modificaciones,

            GROUP_CONCAT(
                DISTINCT er.Observaciones
                SEPARATOR '\n\n'
            ) AS Observaciones,

            COALESCE(e.Status_Ext, 'Pendiente') AS Status_Ext,

            a.idArticulo,

            reg.Fecha_Limite_Revision_Extenso AS FechaLimite,

            e.Aceptado AS Aceptado,

            e.statusPrimeraRev AS statusPrimeraRev

        FROM articulo a

        INNER JOIN resumen r
            ON r.idArticulo = a.idArticulo

        INNER JOIN registro reg
            ON reg.id_registro = a.idRegistro

        LEFT JOIN extenso e
            ON e.idArticulo = a.idArticulo

        LEFT JOIN extenso_revisor er
            ON er.idArticulo = a.idArticulo

        LEFT JOIN revisor re
            ON re.idRevisor = er.idRevisor

        LEFT JOIN usuario u
            ON u.idUsuario = re.idUsuario

        WHERE r.Aceptado = 1

        GROUP BY
            a.idArticulo,
            a.Clave_Articulo,
            a.Nombre_Articulo,
            e.Aceptado,
            e.Status_Ext,
            e.statusPrimeraRev,
            reg.Fecha_Limite_Revision_Extenso

        ORDER BY a.idArticulo DESC
    ");

    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_NUM);
    $result = $sql->fetchAll();
}
catch(PDOException $e)
{
    print 'Error: ' . $e->getMessage();
    die();
}

?>