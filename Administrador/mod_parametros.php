<?php
    include_once("../conexion.php");
    $conexion = conectar();
    session_start();


    if(isset($_POST["guardarP"]))
    {
        $nombreRevista =$_POST["nombreRevist"];
        $volumen =$_POST["volumen"];
        $numero =$_POST["numero"];
        $anio =$_POST["anio"];
        $con_Art =$_POST["con_Art"];
        $color=$_POST["color"];
        $linkRevista =$_POST["linkRevista"];

        if($nombreRevista!="" && $numero!="" && $volumen!="" && $anio!="" && $color!="" && $con_Art!="" && $linkRevista!="")
        {
            try
            {
                $sqlParam = "update parametros set Nombre_Revista = '$nombreRevista', Volumen = '$volumen', Numero = '$numero', Anio = '$anio', Color_Revista = '$color', Consec_Art = '$con_Art', Link_Publicacion = '$linkRevista'";
                $sentenciaParam = $conexion->prepare($sqlParam);
                $sentenciaParam->execute();

                if($sentenciaParam)
                {
                    $_SESSION['mensaje'] = "alertify.success('Los parametros se ha actualizado.')";
                    header("Location: parametros.php");
                }
                else
                {
                    $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error, no se han guardado los cambios, intenta nuevamente...')";
                    header("Location: parametros.php");
                }
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
//                $_SESSION['mensaje'] = "alertify.error('Ah ocurrido un error al tratar de guardar los datos. Error: ".$e->getMessage()."')";
//                header("Location: parametros.php");
            }
        }
        else
        {
            $_SESSION['mensaje'] = "alertify.error('Se deben llenar todos los campos')";
            header("Location: parametros.php");
        }
        
    }

    /*Agregar un nuevo registro (ciclo de publicación continua)*/
    if(isset($_POST["agregarRegistro"]))
    {
        $aperturaReg =$_POST["aperturaReg"];
        $cierreReg =$_POST["cierreReg"];
        $limiteSubirExt =$_POST["limiteSubirExt"];
        $limiteRevExt =$_POST["limiteRevExt"];
        $limiteExtMod =$_POST["limiteExtMod"];
        $limiteCartaAut =$_POST["limiteCartaAut"];
        $diaPublicacion =$_POST["diaPublicacion"];
        $mesPublicacion =$_POST["mesPublicacion"];
        $anioPublicacion =$_POST["anioPublicacion"];

        if($aperturaReg!="" && $cierreReg!="" && $limiteSubirExt!="" && $limiteRevExt!="" && $limiteExtMod!="" && $limiteCartaAut!="" && $diaPublicacion!="" && $mesPublicacion!="" && $anioPublicacion!="")
        {
            try
            {
                // El número de registro se asigna automáticamente (siguiente consecutivo)
                $sigNum = $conexion->query("select coalesce(max(Numero_registro),0)+1 as siguiente from registro")->fetch()["siguiente"];

                $sqlReg = "insert into registro (Numero_registro, Apertura_registro, Cierre_registro, Fecha_Limite_subir_Extenso, Fecha_Limite_Revision_Extenso, Fecha_Limite_Extenso_Modificado, Fecha_Limite_Carta_Aut, Dia_publicacion, Mes_publicacion, Año_publicacion) values ($sigNum, '$aperturaReg', '$cierreReg', '$limiteSubirExt', '$limiteRevExt', '$limiteExtMod', '$limiteCartaAut', '$diaPublicacion', '$mesPublicacion', '$anioPublicacion')";
                $sentenciaReg = $conexion->prepare($sqlReg);
                $sentenciaReg->execute();

                if($sentenciaReg)
                {
                    $_SESSION['mensaje'] = "alertify.success('Registro agregado correctamente.')";
                    header("Location: parametros.php");
                }
                else
                {
                    $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error, no se ha podido agregar el registro, intenta nuevamente...')";
                    header("Location: parametros.php");
                }
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }
        else
        {
            $_SESSION['mensaje'] = "alertify.error('Se deben llenar todos los campos')";
            header("Location: parametros.php");
        }
    }

    /*Eliminar un registro existente*/
    if(isset($_POST["eliminarRegistro"]))
    {
        $idRegistro =$_POST["id_registro"];

        if($idRegistro!="")
        {
            try
            {
                $sqlDel = "delete from registro where id_registro = $idRegistro";
                $sentenciaDel = $conexion->prepare($sqlDel);
                $sentenciaDel->execute();

                if($sentenciaDel)
                {
                    $_SESSION['mensaje'] = "alertify.success('Registro eliminado correctamente.')";
                    header("Location: parametros.php");
                }
                else
                {
                    $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error, no se ha podido eliminar el registro, intenta nuevamente...')";
                    header("Location: parametros.php");
                }
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }
        else
        {
            $_SESSION['mensaje'] = "alertify.error('No se especificó qué registro eliminar')";
            header("Location: parametros.php");
        }
    }

    /*Editar un registro ya existente*/
    if(isset($_POST["guardarRegistro"]))
    {
        $idRegistro =$_POST["id_registro"];
        $aperturaReg =$_POST["aperturaReg"];
        $cierreReg =$_POST["cierreReg"];
        $limiteSubirExt =$_POST["limiteSubirExt"];
        $limiteRevExt =$_POST["limiteRevExt"];
        $limiteExtMod =$_POST["limiteExtMod"];
        $limiteCartaAut =$_POST["limiteCartaAut"];
        $diaPublicacion =$_POST["diaPublicacion"];
        $mesPublicacion =$_POST["mesPublicacion"];
        $anioPublicacion =$_POST["anioPublicacion"];

        if($idRegistro!="" && $aperturaReg!="" && $cierreReg!="" && $limiteSubirExt!="" && $limiteRevExt!="" && $limiteExtMod!="" && $limiteCartaAut!="" && $diaPublicacion!="" && $mesPublicacion!="" && $anioPublicacion!="")
        {
            try
            {
                $sqlReg = "update registro set Apertura_registro='$aperturaReg', Cierre_registro='$cierreReg', Fecha_Limite_subir_Extenso='$limiteSubirExt', Fecha_Limite_Revision_Extenso='$limiteRevExt', Fecha_Limite_Extenso_Modificado='$limiteExtMod', Fecha_Limite_Carta_Aut='$limiteCartaAut', Dia_publicacion='$diaPublicacion', Mes_publicacion='$mesPublicacion', Año_publicacion='$anioPublicacion' where id_registro = $idRegistro";
                $sentenciaReg = $conexion->prepare($sqlReg);
                $sentenciaReg->execute();

                if($sentenciaReg)
                {
                    $_SESSION['mensaje'] = "alertify.success('Registro actualizado correctamente.')";
                    header("Location: parametros.php");
                }
                else
                {
                    $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error, no se ha podido actualizar el registro, intenta nuevamente...')";
                    header("Location: parametros.php");
                }
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }
        else
        {
            $_SESSION['mensaje'] = "alertify.error('Se deben llenar todos los campos')";
            header("Location: parametros.php");
        }
    }

    /*Si no coincidió ninguna acción válida, regresar a parámetros*/
    if(!isset($_POST["guardarP"]) && !isset($_POST["agregarRegistro"]) && !isset($_POST["eliminarRegistro"]) && !isset($_POST["guardarRegistro"]))
    {
        header("Location: parametros.php");
    }