<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    
    try
        {
            function mostrar_lineas()
          {
                include_once("../conexion.php");
                $conexion = conectar();
                
                $idUsuario = $_SESSION["id"];
                
                 $sql=$conexion->prepare("select * from revisor_linea where idRevisor = (Select idRevisor from revisor where idUsuario = '$idUsuario')");
                $sql->execute();
                $result = $sql->rowCount();      
                
        
        if($result > 0)
            {
                 $tabla.= "Ya existen lineas de investigación...";
            }
        else
            {
               
            $CE = "Select  * from linea_investigacion"; 
         
                $resultado = $conexion->prepare($CE);
                $resultado->execute();
                $tabla ="";
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
                    $tabla .= "<td style='display:none'><input value='$id' type='checkbox' name='check[]' id='chk$id'></td></tr>";
                }

                $tabla .= "</tbody></table>";
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