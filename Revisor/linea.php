<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

try
{
    function mostrar_linea()
    {
        include_once '../conexion.php';
        $conexion=conectar();

        $CE = "Select  * from linea_investigacion;"; 
         
        $resultado = $conexion->prepare($CE);
        $resultado->execute();
        $conteo = $resultado->rowCount();       
        $tabla ="";
        
        if($conteo > 0)
            {
                $tabla = "<table class='table' id='addCE'><thead style='background-color:black; color: white'>";
                $tabla .= "<th width='65%'> Selecciona tus cinco lineas de Investigación</th>";
                $tabla .= "</thead><tbody style='cursor: pointer'>";
                foreach ($resultado as $row)
                {
                    $id = $row['idLinea'];
                    $nombreCE = $row['Nombre'];

                    // $agrega=agregar_filas($clave_articulo);
                    $tabla .= "<tr onclick='seleccionar(this, $id)'>";
                    $tabla .= "<td>$nombreCE</td>";
                    $tabla .= "<td style='display: none'><input value='$id' type='checkbox' name='check[]' id='chk$id'></td></tr>";
                }

                $tabla .= "</tbody></table>";
            }
        else
            {
                $tabla.= "No existe linea de investigacion que seleccionar...";
            }
        
        return $tabla;
    }
}
catch(PDOException $e)
{
    print "Error: ".$e->getMessage()."<br>";
    die();
}
    
 
?>
