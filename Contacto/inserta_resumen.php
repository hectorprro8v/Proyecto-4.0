<?php
    include("../conexion.php");
    session_start();

   function validar_orcid($orcid)
{
    return preg_match('/^[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{3}[0-9X]$/', strtoupper($orcid));
}

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
    $idcontacto = $_SESSION["id"];

    if(isset($_POST["enviar"]))
    {   
        
       //VARIABLES DE RESUMEN Y ARTICULO//
        $titulo = addslashes($_POST["titulo"]);
        $titulo_ingles = addslashes($_POST["titulo_ingles"]);
        $linea = $_POST["linea"];
        $instituto = addslashes($_POST["instituto"]);
        $pais = addslashes($_POST["pais"]);
        $estado = addslashes($_POST["estado"]);
        $ciudad = addslashes($_POST["ciudad"]);
        $resumen = addslashes($_POST["resumen"]);
        $resumen = limpiar_texto_especial($resumen);
        $palabras = addslashes($_POST["palabras"]);
        $abstract = addslashes($_POST["abstract"]);
        $abstract = limpiar_texto_especial($abstract);
        $keywords = addslashes($_POST["keywords"]);
        //VARIABLES AUTOR PRINCIPAL
        $nombres_p = addslashes($_POST["nombresp"]);
        $apaterno_p = addslashes($_POST["apaternop"]);
        $amaterno_p = addslashes($_POST["amaternop"]);
        $instituto_p = addslashes($_POST["institutop"]);
        $email_p = addslashes($_POST["emailp"]);
        //$orcid_p = addslashes($_POST["orcidp"]);
        $cvu_p = addslashes($_POST["cvup"]);
        $gradoestudio = addslashes($_POST["gradoestudio"]);
        //VARIABLES AUTOR PRINCIPAL
        //VARIABLES AUTOR SECUNDARIO 1//
        $nombres_s1 = addslashes($_POST["nombress1"]);
        $apaterno_s1 = addslashes($_POST["apaternos1"]);
        $amaterno_s1 = addslashes($_POST["amaternos1"]);
        $instituto_s1 = addslashes($_POST["institutos1"]);
        $email_s1 = addslashes($_POST["emails1"]);
       // $orcid_s1 = addslashes($_POST["orcids1"]);
        $cvu_s1 = addslashes($_POST["cvus1"]);
        //VARIABLES AUTOR SECUNDARIO 1//
        //VARIABLES AUTOR SECUNDARIO 2//
        $nombres_s2 = addslashes($_POST["nombress2"]);
        $apaterno_s2 = addslashes($_POST["apaternos2"]);
        $amaterno_s2 = addslashes($_POST["amaternos2"]);
        $instituto_s2 = addslashes($_POST["institutos2"]);
        $email_s2 = addslashes($_POST["emails2"]);
      //  $orcid_s2 = addslashes($_POST["orcids2"]);
        $cvu_s2 = addslashes($_POST["cvus2"]);
        //VARIABLES AUTOR SECUNDARIO 2//
        //VARIABLES AUTOR SECUNDARIO 3//
        $nombres_s3 = addslashes($_POST["nombress3"]);
        $apaterno_s3 = addslashes($_POST["apaternos3"]);
        $amaterno_s3 = addslashes($_POST["amaternos3"]);
        $instituto_s3 = addslashes($_POST["institutos3"]);
        $email_s3 = addslashes($_POST["emails3"]);
    //    $orcid_s3 = addslashes($_POST["orcids3"]);
        $cvu_s3 = addslashes($_POST["cvus3"]);
        //VARIABLES AUTOR SECUNDARIO 3//
        //VARIABLES AUTOR SECUNDARIO 4//
        $nombres_s4 = addslashes($_POST["nombress4"]);
        $apaterno_s4 = addslashes($_POST["apaternos4"]);
        $amaterno_s4 = addslashes($_POST["amaternos4"]);
        $instituto_s4 = addslashes($_POST["institutos4"]);
        $email_s4 = addslashes($_POST["emails4"]);
       // $orcid_s4 = addslashes($_POST["orcids4"]);
        $cvu_s4 = addslashes($_POST["cvus4"]);
         // VALIDACIÓN DE ORCID
             $orcid_p = trim($_POST["orcidp"]);
        $orcid_s1 = trim($_POST["orcids1"]);
        $orcid_s2 = trim($_POST["orcids2"]);
        $orcid_s3 = trim($_POST["orcids3"]);
        $orcid_s4 = trim($_POST["orcids4"]);
        if($orcid_p == "" || !validar_orcid($orcid_p))
        {
            $_SESSION['mensaje'] = "alertify.error('El ORCID del autor principal es obligatorio y debe tener el formato 0000-0002-6968-4784')";
            header("Location: nuevo_resumen.php");
            exit();
        }

        if($nombres_s1 != "" && ($orcid_s1 == "" || !validar_orcid($orcid_s1)))
        {
            $_SESSION['mensaje'] = "alertify.error('El ORCID del coautor 1 es obligatorio y debe tener el formato 0000-0002-6968-4784')";
            header("Location: nuevo_resumen.php");
            exit();
        }

        if($nombres_s2 != "" && ($orcid_s2 == "" || !validar_orcid($orcid_s2)))
        {
            $_SESSION['mensaje'] = "alertify.error('El ORCID del coautor 2 es obligatorio y debe tener el formato 0000-0002-6968-4784')";
            header("Location: nuevo_resumen.php");
            exit();
        }

        if($nombres_s3 != "" && ($orcid_s3 == "" || !validar_orcid($orcid_s3)))
        {
            $_SESSION['mensaje'] = "alertify.error('El ORCID del coautor 3 es obligatorio y debe tener el formato 0000-0002-6968-4784')";
            header("Location: nuevo_resumen.php");
            exit();
        }

        if($nombres_s4 != "" && ($orcid_s4 == "" || !validar_orcid($orcid_s4)))
        {
            $_SESSION['mensaje'] = "alertify.error('El ORCID del coautor 4 es obligatorio y debe tener el formato 0000-0002-6968-4784')";
            header("Location: nuevo_resumen.php");
            exit();
        }

        try
        {
            
            
            if($titulo != null)
            {
                /* $sql2=$conexion->prepare("select Anio, Volumen, Numero from parametros;");*/
                $sql2=$conexion->prepare("select Anio, Volumen, Numero from parametros_revista;");
                $sql2->execute();

                $consulta_result2 = $sql2->fetchAll(PDO::FETCH_ASSOC);
                foreach($consulta_result2 as $result_param){
                    $Anio = $result_param['Anio'];
                    $Volumen = $result_param['Volumen'];
                    $Numero = $result_param['Numero'];
                }
                
                $idRegistro = limite_resumen(date("Y-m-d"));
                if(!$idRegistro)
                {
                    $_SESSION['mensaje'] = "alertify.error('No hay una convocatoria abierta en esta fecha.')";
                    header("Location: resumenes.php");
                    exit();
                }
                
                $nuevo_resumen = $conexion->prepare("CALL spAltaResumen('$titulo','$titulo_ingles','$linea', $idcontacto,'$instituto','$pais','$estado','$ciudad','$resumen','$abstract','$palabras','$keywords', '$Anio', '$Volumen', '$Numero', '$idRegistro')");
                $nuevo_resumen->execute();
                $filaNuevo = $nuevo_resumen->fetch(PDO::FETCH_ASSOC);
                $nuevo_resumen->closeCursor();
                $idArticulo = isset($filaNuevo["idArticulo"]) ? $filaNuevo["idArticulo"] : 0;
                $claveNueva = isset($filaNuevo["Clave_Articulo"]) ? $filaNuevo["Clave_Articulo"] : "";
                
                /*
                $sql1=$conexion->prepare("select idArticulo from articulo where Nombre_Articulo = '$titulo' and idContacto = $idcontacto");
                $sql1->execute();

                $consulta_result1 = $sql1->fetchAll(PDO::FETCH_ASSOC);
                foreach($consulta_result1 as $result_id){
                    $idArticulo = $result_id['idArticulo'];
                }
                */
                /*
                if($nuevo_resumen->rowCount()>0)*/
                if($idArticulo > 0)
                {
                    $sql = $conexion->prepare("insert into autores (idArticulo, Nombres, Apellido_Paterno, Apellido_Materno, Institucion, Correo_Electronico, ORCID, CVU,GradoEstudio, Principal) values ($idArticulo,'$nombres_p','$apaterno_p','$amaterno_p','$instituto_p','$email_p','$orcid_p','$cvu_p','$gradoestudio', 1)");
                    $sql->execute();
                    
                    if($nombres_s1 != "")
                    {
                        $sql1 = $conexion->prepare("insert into autores (idArticulo, Nombres, Apellido_Paterno, Apellido_Materno, Institucion, Correo_Electronico, ORCID, CVU, Principal) values ($idArticulo,'$nombres_s1','$apaterno_s1','$amaterno_s1','$instituto_s1','$email_s1','$orcid_s1','$cvu_s1', 0)");
                        $sql1->execute();
                    }
                    if($nombres_s2 != "")
                    {
                        $sql2 = $conexion->prepare("insert into autores (idArticulo, Nombres, Apellido_Paterno, Apellido_Materno, Institucion, Correo_Electronico, ORCID, CVU, Principal) values ($idArticulo,'$nombres_s2','$apaterno_s2','$amaterno_s2','$instituto_s2','$email_s2','$orcid_s2','$cvu_s2', 0)");
                        $sql2->execute();
                    }
                    if($nombres_s3 != "")
                    {
                        $sql3 = $conexion->prepare("insert into autores (idArticulo, Nombres, Apellido_Paterno, Apellido_Materno, Institucion, Correo_Electronico, ORCID, CVU, Principal) values ($idArticulo,'$nombres_s3','$apaterno_s3','$amaterno_s3','$instituto_s3','$email_s3','$orcid_s3','$cvu_s3', 0)");
                        $sql3->execute();
                    }
                    if($nombres_s4 != "")
                    {
                        $sql4 = $conexion->prepare("insert into autores (idArticulo, Nombres, Apellido_Paterno, Apellido_Materno, Institucion, Correo_Electronico, ORCID, CVU, Principal) values ($idArticulo,'$nombres_s4','$apaterno_s4','$amaterno_s4','$instituto_s4','$email_s4','$orcid_s4','$cvu_s4', 0)");
                        $sql4->execute();
                    }
                    
                    $_SESSION['mensaje'] = "alertify.success('El resumen se ha enviado correctamente, ahora puedes visualizarlo.')";
                    header("Location: resumenes.php");
                }
            }
            else
            {
                $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error, no existe el título del artículo y el resumen no se ha enviado, intenta nuevamente.')";
                header("Location: resumenes.php");
                //echo "¡Resumen no enviado!</strong> Ah ocurrido un error al ingresar los datos, el resumen no se ha enviado.";
            }
        }
        catch(PDOException $e)
        {
            //$_SESSION['mensaje'] = "alertify.error('Ah ocurrido un error, el resumen no se ha enviado. \n\nError: ".$e->getMessage()."')";
            //header("Location: resumenes.php");
            echo "¡Resumen no enviado! Ah ocurrido un error, el resumen no se ha enviado. Error: ".$e->getMessage();
            //header("Location: resumen_enviado.php");
        }
    }
    else
    {
        header("Location: nuevo_resumen.php");
    }
?>