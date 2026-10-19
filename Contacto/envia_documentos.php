<?php

    include("../conexion.php");
    $conexion = conectar();

    session_start();

    if(isset($_POST['subir']))
    {
        try
        {
            $clave_articulo = $_POST["clave"];
            $tipo = $_POST["tipo"];
            $nombre_archivo = $_FILES["archivo"]["name"];
            $tmp_nombre = $_FILES["archivo"]["tmp_name"];
            switch($tipo)
            {
                /* 
                case "EM":
                    $formato = array('.docx');
                    $destino = "../Documentos/Extenso_Modificado/".$clave_articulo.".docx";
                    break;
                */
                case "EM":
                    if(date("Y-m-d") > limite_extenso_modificado($clave_articulo)){
                        $_SESSION['mensaje']= "alertify.error('La fecha límite para subir el Extenso Modificado ya pasó.')";
                        header('Location: subir_documentos.php');
                        exit();
                    }
                    $formato = array('.docx');
                    $destino = "../Documentos/Extenso_Modificado/".$clave_articulo.".docx";
                    break;
                /*                
                case "CA":
                    $formato = array('.pdf');
                    $destino = "../Documentos/Carta_Autorizacion/".$clave_articulo.".pdf";
                    break;
                */
                case "CA":
                    if(date("Y-m-d") > Fecha_Limite_Carta_Aut($clave_articulo)){
                        $_SESSION['mensaje']= "alertify.error('La fecha límite para subir la Carta de Autorización ya pasó.')";
                        header('Location: subir_documentos.php');
                        exit();
                    }
                    $formato = array('.pdf');
                    $destino = "../Documentos/Carta_Autorizacion/".$clave_articulo.".pdf";
                    break;
            }
            $extension_archivo = substr($nombre_archivo, strrpos($nombre_archivo, '.'));

            if($nombre_archivo != "")
            {
                if(in_array($extension_archivo, $formato))
                {
                    
                        $sql = "select d.idArticulo from documento as d, articulo as a where a.idArticulo = d.idArticulo and Tipo_Documento='$tipo' and a.Clave_Articulo = '$clave_articulo';";
                        $gsent = $conexion->prepare($sql);
                        $gsent->execute();
                        $sql_result = $gsent->fetchAll();

                        foreach($sql_result as $dato_id) {
                            $idArticulo = $dato_id['idArticulo'];
                            $doc = $dato_id['documento'];
                        }
                        if($gsent->rowCount()>0){
                            $_SESSION['mensaje']= "alertify.error('Ya existe un archivo del mismo tipo...')";
                        }else{
                            $sql2="select idArticulo from articulo where Clave_Articulo='$clave_articulo'";
                            $sentencia = $conexion->prepare($sql2);
                            $sentencia->execute();
                            foreach($sentencia as $id){
                                $idArticulo=$id["idArticulo"];
                            }
                            
                            if($sentencia->rowCount()>0){
                                if(move_uploaded_file($tmp_nombre, $destino))
                                {
                                    $documento = $conexion->prepare("insert into documento(idArticulo, Nombre_Documento, Tipo_Documento, URL, Fecha_Envio)values($idArticulo,'$nombre_archivo', '$tipo','$destino', (select current_date()))");
                                    $documento->execute();
                                    $_SESSION['mensaje']= "alertify.success('El archivo se ha enviado de manera exitosa...')";
                                    }
                                    else
                                    {
                                        $_SESSION['mensaje']= "alertify.error('Ha ocurrido un error, el archivo no se ha enviado.')";
                                        header('Location: subir_documentos.php');
                                    }
                            }else{
                                $_SESSION['mensaje']= "alertify.error('El artículo no se ha encontrado, asegurate de introducir la clave de artículo correcta.')";
                            }
                        }
                        header('Location: subir_documentos.php');
                }
                else
                { 
                    $_SESSION['mensaje']= "alertify.warning('El tipo de archivo no es admitido. Selecciona un tipo de documento váido.";
                    header("Location: subir_documentos.php");
                }
            }
            else
            {
                $_SESSION['mensaje']= "alertify.warning('No se ha especificado un nombre de archivo válido, intenta nuevamente.')";
                header("Location: subir_documentos.php");
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
            //$_SESSION['mensaje']= "alertify.error('Ha ocurrido un error, el archivo no se ha enviado. Error: ".$e->getMessage().".')";
            //header('Location: subir_documentos.php');
        }
    }
    else
    {
        header("Location: subir_documentos.php");
        
    }
?>