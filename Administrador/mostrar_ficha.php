<?php

include_once "../conexion.php";
$con=conectar();
   

  try
   {
    //Le agrege que se mostrar solo el folio del idRecibo donde el Tipo_Documento sea R. 
   $sql2 = $con->prepare("SELECT * FROM (
    SELECT 
        rp.idRecibo as r, 
        idDocumento as d, 
        a.Publicado as p,
        df.Tipo_Documento as td,
        rpd.idArticulo as ai, 
        a.Clave_Articulo as c
    FROM recibo_pago as rp 
    INNER JOIN documentos_financiero as df ON rp.idRecibo = df.idRecibo 
    INNER JOIN recibo_pago_detalle as rpd ON rpd.idRecibo = rp.idRecibo 
    INNER JOIN articulo as a ON a.idArticulo = rpd.idArticulo
    UNION
    SELECT 
        '0' as r,
        '1' as d, 
        a.Publicado as p, 
        NULL as td,
        a.idArticulo as ai, 
        a.Clave_Articulo as c
    FROM articulo as a 
    INNER JOIN usuario as c ON a.idContacto = c.idUsuario
    WHERE a.Dictamen_Extenso = 1 AND UPPER(a.Institucion) LIKE UPPER('%lerdo%')
) AS union_resultado
WHERE td = 'R'
ORDER BY c");

    $sql2->execute();
    $sql2->setFetchMode(PDO::FETCH_ASSOC);
    $result2 = $sql2->fetchAll();
}
       catch(PDOException $e)
    {
        print "Error: ".$e->getMessage()."<br>";
        die();
    } 

?>