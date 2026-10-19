<?php
    include("../conexion.php");
    $conexion = conectar();

    session_start();

    if(isset($_POST['subir_fact']))
    {
        try
        { 
            $idRecibo = $_POST["idRecibo"];
            $pago = $_POST["pago"];
            $regimen = $_POST["regimen"];
            $folio = $_POST["folio"];
            $otro = $_POST["otro"];
            //***XML***//
            $nombre_archivo_xml = $_FILES["archivoxml"]["name"];
            $tmp_nombre_xml = $_FILES["archivoxml"]["tmp_name"];
            $extension_xml = explode(".",$nombre_archivo_xml);
            $destino_xml = "../Documentos/Facturas/XML/Factura-".$idRecibo.".xml";
            //***PDF***//
            $nombre_archivo_pdf = $_FILES["archivopdf"]["name"];
            $tmp_nombre_pdf = $_FILES["archivopdf"]["tmp_name"];
            $extension_pdf = explode(".",$nombre_archivo_pdf);
            $destino_pdf = "../Documentos/Facturas/PDF/Factura-".$idRecibo.".pdf";
            
	        $num_xml = count($extension_xml)-1;
            $num_pdf = count($extension_pdf)-1;

            if($nombre_archivo_xml != null && $nombre_archivo_pdf != null)
            {
                if($extension_xml[$num_xml] == "xml" && $extension_pdf[$num_pdf] == "pdf")
                {
                    if(move_uploaded_file($tmp_nombre_xml, $destino_xml) && move_uploaded_file($tmp_nombre_pdf, $destino_pdf))
                    {
                       $documento = $conexion->prepare("CALL spAltaFactura($idRecibo, '$PAGO', '$regimen', '$folio', '$otro','$nombre_archivo_xml', '$destino_xml','$nombre_archivo_pdf', '$destino_pdf')");
                        $documento->execute();
                        
                        if($documento>0){
                            $_SESSION['mensaje']= "alertify.success('La factura se ha enviado de manera exitosa...')";
                            header('Location: facturacion.php');
                        }
                        else{
                            $_SESSION['mensaje']= "alertify.error('Ha ocurrido un error, la factura no se ha enviado...')";
                            header('Location: facturacion.php');
                        }
                    }
                    else
                    {
                        $_SESSION['mensaje']= "alertify.error('Ha ocurrido un error, los archivos no se han enviado, intenta nuevamente.')";
                        header('Location: facturacion.php');
                    }
                }
                else
                { 
                    $_SESSION['mensaje']= "alertify.warning('El tipo de archivo no es admitido, solamente se permiten documentos con extensión .xml y .pdf')";
                    header("Location: facturacion.php");
                }
            }
            else
            {
                $_SESSION['mensaje']= "alertify.warning('No se ha especificado un nombre de archivo válido para uno o más de los archivos solicitados, intenta nuevamente.')";
                header("Location: facturacion.php");
            }
        }
        catch(PDOException $e)
        {
           //echo $e->getMessage();
           $_SESSION['mensaje']= "alertify.error('Ha ocurrido un error, los archivos no se ha enviado. Error: ".$e->getMessage().".')";
           header('Location: facturacion.php');
        }
    }
    else
    {
        header("Location: facturacion.php");
    }
?>