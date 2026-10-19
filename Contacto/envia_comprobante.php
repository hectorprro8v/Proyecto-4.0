<?php
    include("../conexion.php");
    $conexion = conectar();

    session_start();

    if(isset($_POST['subir_comp']))
    {
        //try
        //{ 
            $idRecibo = $_POST["idRecibo"];
            $clave_articulo = $_POST["clave"];
            $nombre_archivo = $_FILES["archivo"]["name"];
            $tmp_nombre = $_FILES["archivo"]["tmp_name"];
            $destino = "../Documentos/Recibos/".$idRecibo."-".$clave_articulo.".pdf";
            $extension = explode(".",$nombre_archivo);
	        $num = count($extension)-1;

            if($nombre_archivo != "")
            {
                if($extension[$num] == "pdf")
                {
                    if(move_uploaded_file($tmp_nombre, $destino))
                    {
                        $sql="insert into documentos_financiero (idRecibo, Nombre_Documento, Tipo_Documento, URL, Fecha_Envio) values('$idRecibo','$nombre_archivo', 'R', '$destino', (select current_date()));";
                        $documento = $conexion->prepare($sql);
                        $documento->execute();
                        
                        if($documento>0){
                            $_SESSION['mensaje']= "alertify.success('El comprobante de pago se ha enviado de manera exitosa...')";
                            header('Location: fichas_de_pago.php');
                        }
                        else{
                            $_SESSION['mensaje']= "alertify.error('Ha ocurrido un error, el comprobante de pago no se ha enviado, ontente nuevamente más tarde...')";
                            header('Location: fichas_de_pago.php');
                        }
                    }
                    else
                    {
                        $_SESSION['mensaje']= "alertify.error('Ha ocurrido un error, el comprobante de pago no se ha enviado.')";
                        header('Location: fichas_de_pago.php');
                    }
                }
                else
                { 
                    $_SESSION['mensaje']= "alertify.warning('El tipo de archivo no es admitido, solamente se permiten documentos .pdf (documento de PDF)')";
                    header("Location: fichas_de_pago.php");
                }
            }
            else
            {
                $_SESSION['mensaje']= "alertify.warning('No se ha especificado un nombre de archivo válido, intenta nuevamente.')";
                header("Location: fichas_de_pago.php");
            }
        }
        //catch(PDOException $e)
        //{
           //echo $e->getMessage();
            $_SESSION['mensaje']= "alertify.error('Ha ocurrido un error, el extenso no se ha enviado. Error: ".$e->getMessage().".')";
            header('Location: fichas_de_pago.php');
        //}
    //}
   /* else
    {
        header("Location: fichas_de_pago.php");
    }*/
?>