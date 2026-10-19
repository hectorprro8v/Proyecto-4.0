<?php
include_once "../conexion.php";

$con = conectar();

try {
    $sql = $con->prepare("
        SELECT
            a.Clave_Articulo,
            a.Nombre_Articulo,

            COALESCE(
                GROUP_CONCAT(
                    DISTINCT IF(rc.Fecha_Revision IS NOT NULL, rc.Fecha_Revision, 'En espera')
                    ORDER BY rc.id_resumen_comite
                    SEPARATOR '<br><br>'
                ),
                'En espera'
            ) AS Fecha,

            COALESCE(
                GROUP_CONCAT(
                    DISTINCT CASE
                        WHEN rc.Aceptado = 1 THEN 'Aceptado'
                        WHEN rc.Aceptado = 0 THEN 'No Aceptado'
                        ELSE 'Pendiente'
                    END
                    ORDER BY rc.id_resumen_comite
                    SEPARATOR '<br><br>'
                ),
                'Pendiente'
            ) AS Evaluacion,

            COALESCE(
                GROUP_CONCAT(
                    DISTINCT CONCAT_WS(
                        ' ',
                        u.Nombres,
                        u.Apellido_Paterno,
                        u.Apellido_Materno
                    )
                    ORDER BY rc.id_resumen_comite
                    SEPARATOR '<br><br>'
                ),
                'Sin comité asignado'
            ) AS Nombre,

            COALESCE(
                GROUP_CONCAT(
                    DISTINCT rc.Justificacion
                    ORDER BY rc.id_resumen_comite
                    SEPARATOR '\n\n'
                ),
                ''
            ) AS Justificacion,

            r.Status_Art,
            a.idArticulo,

            reg.Fecha_Limite_Revision_Resumen AS FechaLimiteRevisionResumen,

            r.Aceptado

        FROM articulo AS a

        INNER JOIN resumen AS r
            ON r.idArticulo = a.idArticulo

        INNER JOIN registro AS reg
            ON reg.id_registro = a.idRegistro

        LEFT JOIN resumen_comite AS rc
            ON rc.idArticulo = a.idArticulo

        LEFT JOIN usuario AS u
            ON u.idUsuario = rc.idUsuario

        GROUP BY
            a.idArticulo,
            a.Clave_Articulo,
            a.Nombre_Articulo,
            r.Status_Art,
            r.Aceptado,
            reg.Fecha_Limite_Revision_Resumen

        ORDER BY a.idArticulo DESC
    ");

    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_NUM);
    $result = $sql->fetchAll();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>