<?php
    include("../conexion.php");
    session_start();

function limpiar_texto_especial($texto)
{
    $texto = str_replace("©", "(c)", $texto);
    $texto = str_replace("®", "(R)", $texto);
    $texto = str_replace("™", "(TM)", $texto);
    $texto = str_replace("≤", "<=", $texto);
    $texto = str_replace("≥", ">=", $texto);
    $texto = str_replace("±", "+/-", $texto);
    return $texto;
}
    
    $conexion = conectar();
    if(isset($_POST["enviar"]))
    {   
        
       //VARIABLES DE RESUMEN Y ARTICULO//
        $idArticulo = addslashes($_POST['idArticulo']);
        $resumen = addslashes($_POST["resumen"]);
        $resumen = limpiar_texto_especial($resumen);
        $palabras = addslashes($_POST["palabras_clave"]);
        $abstract = addslashes($_POST["abstract"]);
        $abstract = limpiar_texto_especial($abstract);
        $keywords = addslashes($_POST["keywords"]);
  
     
    if ($idArticulo <= 0) {
        $_SESSION['mensaje'] = "alertify.error('Artículo no válido.')";
        header("Location: resumenes.php");
        exit();
    }


       try
        {
            $actualiza_resumen = $conexion->prepare("CALL actualiza_resumen ('$idArticulo', '$resumen', '$palabras', '$abstract', '$keywords')");
            $actualiza_resumen->execute();

            $_SESSION['mensaje'] = "alertify.success('El resumen se ha actualizado correctamente.')";
            header("Location: resumenes.php");
            exit();
        }
        catch(PDOException $e)
        {
            $_SESSION['mensaje'] = "alertify.error('Ah ocurrido un error, el resumen no se ha enviado. Error: ".$e->getMessage()."')";
            header("Location: resumenes.php");
            exit();
        }
    }
    else
    {
        header("Location: nuevo_resumen.php");
        exit();
    }
?>