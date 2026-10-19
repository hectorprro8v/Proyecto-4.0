<?php

    include("../conexion.php");
    $conexion = conectar();
    $formato = array('.docx');

    session_start();

    if(isset($_POST['subir']))
    {
            $titulo_articulo = $_POST["titulo_articulo"];
            $clave_articulo = $_POST["clave_articulo"];
            $nombre_archivo = $_FILES["archivo"]["name"];
            $nombre_archivoSA = $_FILES["archivoSA"]["name"];
            $tmp_nombre = $_FILES["archivo"]["tmp_name"];
            $tmp_nombreSA = $_FILES["archivoSA"]["tmp_name"];
            $destino = "../Documentos/Extensos/".$clave_articulo.".docx";
            $destinoSA = "../Documentos/ExtensosSA/".$clave_articulo.".docx";
            $extension_archivo = substr($nombre_archivo, strrpos($nombre_archivo, '.'));
            $extension_archivoSA = substr($nombre_archivoSA, strrpos($nombre_archivoSA, '.'));
            $someter_revision=0;
            $Correcto=0;
            $CorrectoSA=0;
        
         if(isset($_POST["cbox"]))  $someter_revision=1;

            if($nombre_archivo != "" and $nombre_archivoSA != "")
            {
                if(in_array($extension_archivo, $formato) and in_array($extension_archivoSA, $formato))
                {
                    if(file_exists("../Documentos/Extensos/$nombre_archivo")){
                        unlink("../Documentos/Extensos/$nombre_archivo");
                        
                    }
                            if(move_uploaded_file($tmp_nombre, $destino))
                            {
                                $Correcto=1;
                            }
                    
                    if(file_exists("../Documentos/ExtensosSA/$nombre_archivoSA")){
                        
                            unlink("../Documentos/ExtensosSA/$nombre_archivoSA");
                        
                    }
                    
                            if(move_uploaded_file($tmp_nombreSA, $destinoSA))
                            {
                                $CorrectoSA=1;
                            }  
                    
                    if($Correcto=1 and $CorrectoSA=1)
                    {
                        
                    }
                    else
                    {
                       echo 'Archivo guardado y remplazado';
                    }
                }
                else
                { 
                   echo 'error 1';
                }
            }
            else
            {
               echo 'Error 2';
            }
        }
            
?>