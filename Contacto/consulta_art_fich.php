<?php
    session_start();
    include("../conexion.php");

    function mostrar_art_pagos()
    {
        $conexion = conectar();
        $idContacto = isset($_SESSION['id']) ? (int)$_SESSION['id'] : 0;

        // ✅ SOLO artículos ACEPTADOS del usuario en sesión
        // y que aún no estén ligados a un recibo (re.idArticulo IS NULL)
        $sql = "SELECT ar.idArticulo,
                       ar.Clave_Articulo,
                       ar.Nombre_Articulo
                  FROM articulo ar
             LEFT JOIN recibo_pago_detalle re
                    ON ar.idArticulo = re.idArticulo
                 WHERE re.idArticulo IS NULL
                   AND ar.Aceptado   = 1
                   AND ar.idContacto = :idContacto
              ORDER BY ar.idArticulo DESC";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':idContacto' => $idContacto]);
        $articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$articulos) {
            // Mensaje claro si no hay aceptados
            return "<div class='alert alert-info'>
                        No hay artículos <strong>aceptados</strong> disponibles para pagar.
                        <br>Verifica que tus artículos estén en estado <em>Aceptado</em>.
                    </div>";
        }

        // ✅ Tabla con checkbox visible + “Seleccionar todos”
        $html  = "<table class='table table-hover' id='tabla_art_pagos'>";
        $html .= "<thead style='background-color:#000; color:#fff'>";
        $html .= "  <tr>";
        $html .= "    <th style='width:6%; text-align:center;'>";
        $html .= "      <input type='checkbox' id='chk_all' onclick='toggleTodos(this)' title='Seleccionar todos'>";
        $html .= "    </th>";
        $html .= "    <th style='width:18%'>Clave del artículo</th>";
        $html .= "    <th style='width:76%'>Título</th>";
        $html .= "  </tr>";
        $html .= "</thead><tbody>";

        foreach ($articulos as $a) {
            $id    = (int)$a['idArticulo'];
            $clave = htmlspecialchars($a['Clave_Articulo'], ENT_QUOTES, 'UTF-8');
            $nom   = htmlspecialchars($a['Nombre_Articulo'], ENT_QUOTES, 'UTF-8');

            $html .= "<tr onclick='filaClick(this)' data-id='$id'>";
            $html .= "  <td style='text-align:center'>";
            // ✅ Checkbox visible; el name debe ser check[] para que lo lea el servidor
            $html .= "    <input type='checkbox' class='art-chk' name='check[]' value='$id' onclick='event.stopPropagation(); onChkClick(this)'>";
            $html .= "  </td>";
            $html .= "  <td>$clave</td>";
            $html .= "  <td>$nom</td>";
            $html .= "</tr>";
        }

        $html .= "</tbody></table>";
        return $html;
    }
    
    function precio_articulo()
    {
        $conexion = conectar();
        $sql = "SELECT idtipopago AS Id, Precio, Descripcion FROM tipopago";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();

        // ✅ required para obligar escoger un tipo
        $html  = "<select class='form-control' name='precio' id='precios' onchange='seleccionar_precio()' required>";
        $html .= "<option value='' selected disabled>Selecciona una opción</option>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
            $precio      = $row["Precio"];        // el front usa el precio para calcular
            $descripcion = $row["Descripcion"];
            $html       .= "<option value='".htmlspecialchars($precio, ENT_QUOTES, 'UTF-8')."'>"
                        .   htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8')
                        . "</option>";    
        } 
        $html .= "</select>";
        return $html;
    }

    function mostrar_recibos()
    {        
        $conexion = conectar();
        $idContacto = isset($_SESSION['id']) ? (int)$_SESSION['id'] : 0;

        $sql = "SELECT rpd.idRecibo AS recibo,
                       ar.Clave_Articulo,
                       df.idDocumento AS documento,
                       CASE WHEN GROUP_CONCAT(df.Tipo_Documento) = 'R,FXML,FPDF' THEN 1 ELSE 0 END AS factura
                  FROM recibo_pago_detalle AS rpd
            INNER JOIN articulo AS ar ON rpd.idArticulo = ar.idArticulo
            INNER JOIN recibo_pago AS rp ON rp.idRecibo = rpd.idRecibo
             LEFT JOIN documentos_financiero AS df ON df.idRecibo = rp.idRecibo
                 WHERE ar.Aceptado   = 1
                   AND ar.idContacto = :idContacto
              GROUP BY rpd.idRecibo
              ORDER BY CASE WHEN documento IS NULL THEN 0 ELSE 1 END";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':idContacto' => $idContacto]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            return "Aún no se han generado recibos...";
        }

        $html  = "<table class='table' id='tabla_art_pagos'><thead style='background-color: black; color: white'>";
        $html .= "<th width='5%'>Folio</th>";
        $html .= "<th width='10%'>Clave de artículo</th>";
        $html .= "<th width='15%'>Ficha</th>";
        $html .= "<th width='15%'>Comprobante</th>";
        $html .= "<th width='15%'>Factura</th>";
        $html .= "</thead><tbody>";

        foreach ($rows as $r){
            $recibo        = (int)$r['recibo'];
            $claveArticulo = htmlspecialchars($r['Clave_Articulo'], ENT_QUOTES, 'UTF-8');
            $documento     = $r['documento'];
            $factura       = (int)$r['factura'];
            
            $html .= "<tr>";
            $html .= "<td>$recibo</td>";
            $html .= "<td>$claveArticulo</td>";
            $html .= "<td><a href='recibo.php?recibo=".$recibo."&dir=fich' type='button' class='btn btn-primary btn-md btn-block'>Visualizar</a></td>";
            if ($documento==null) {
                $html .= "<td><button class='btn btn-info btn-md btn-block' data-toggle='modal' data-target='#comprobante' data-clave='$claveArticulo' data-id=".$recibo.">Subir</button></td>";
            } else {
                $html .= "<td>Enviado</td>";
            }
            if ($factura==1) {
                $html .= "<td>
                            <div class='row'>
                              <div class='col-md-6'><a class='btn btn-success btn-md btn-block' href='../Documentos/Facturas/XML/Factura-".$recibo.".xml'>XML</a></div>
                              <div class='col-md-6'><a class='btn btn-success btn-md btn-block' href='../Documentos/Facturas/PDF/Factura-".$recibo.".pdf'>PDF</a></div>
                            </div>
                          </td>";
            } else {
                $html .= "<td>No disponible</td>";
            }
            $html .= "</tr>";
        }
        $html .= "</tbody></table>";
        return $html;
    }
?>
