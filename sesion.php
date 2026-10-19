<?php
    include("conexion.php");
    $conexion = conectar();
    session_start();
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];
    $tipousu = $_POST["Tipo_Usuario"];
   // if ($tipousu=='M') $tipousu='R';
   // echo $tipousu;
    
    
try
    {

    $Token='charT';
    if ($tipousu=='C') $Token='charC';

    $sql = "Select U.idUsuario as idUsuario, U.Nombres as Nombres,  
    TP.Caracter_tipo as Tipo_Usuario, U.Nuevo as Nuevo from usuario_tipo as UT 
	inner join usuario as U on UT.Usuario=U.idUsuario
    inner join tipo_usuario as TP on UT.TipoUsuario=TP.Id_Tipo_Usuario
    where U.Correo_Electronico = '$correo'  
    AND U.Contrasenia = TO_BASE64(AES_ENCRYPT('$contrasena','$Token'))
    AND TP.Caracter_tipo = '$tipousu'
    LIMIT 1"; 


        $sentencia = $conexion->prepare($sql);
        $sentencia->execute();
        $numero = $sentencia->rowCount();
        echo $tipo;
            echo $idUsuario;
        if($numero > 0)
        {
        
            foreach($sentencia as $fila){
                $idUsuario = $fila["idUsuario"];
                $nombres = $fila["Nombres"];
                $tipo = $fila["Tipo_Usuario"];
                $nuevo = $fila["Nuevo"];
            }
            

            $_SESSION['id'] = $idUsuario;
            $_SESSION['correo'] = $correo;
            $_SESSION['mensaje'] = "";
            switch($tipo)
                {
                    case "C":    
                        if($nuevo==0)
                        {
                            $_SESSION['mensaje'] = "alertify.success('$nombres, bienvenido al sistema SICSACID TEC LERDO...')";
                            header("Location: Contacto/index.php");
                        }
                        else
                        { 
                            $_SESSION['mensaje'] = "alertify.success('Ingresa los datos correspondientes para continuar...')";
                            header("Location: Contacto/editar_perfil.php");
                        }
                        break;
                    case "R":
                        if($nuevo==0)
                        {
                            $_SESSION['mensaje'] = "alertify.success('$nombres, bienvenido al sistema SICSACID TEC LERDO...')";
                            header("Location: Revisor/index.php");
                        }
                        else
                        { 
                            $_SESSION['mensaje'] = "alertify.success('Ingresa los datos correspondientes para continuar...')";
                            header("Location: Revisor/editar_perfil.php");
                        }
                        break;
                        case "E":
                        if($nuevo==0)
                        {
                            $_SESSION['mensaje'] = "alertify.success('$nombres, bienvenido al sistema SICSACID TEC LERDO...')";
                            header("Location: Comite_Editorial/index.php");
                        }
                        else
                        { 
                            $_SESSION['mensaje'] = "alertify.success('Ingresa los datos correspondientes para continuar...')";
                            header("Location: Comite_Editorial/editar_perfil.php");
                        }
                        break;
                    case "A":
                        if($nuevo==0)
                        {
                            $_SESSION['mensaje'] = "alertify.success('$nombres, bienvenido al sistema SICSACID TEC LERDO...')";
                            header("Location: Administrador/index.php");
                        }
                        else
                        { 
                            $_SESSION['mensaje'] = "alertify.success('Ingresa los datos correspondientes para continuar...')";
                            header("Location: Administrador/editar_perfil.php");
                        }
                        break;
                        case "F":
                        if($nuevo==0)
                        {
                            $_SESSION['mensaje'] = "alertify.success('$nombres, bienvenido al sistema SICSACID TEC LERDO...')";
                            header("Location: Financiero/index.php");
                        }
                        else
                        { 
                            $_SESSION['mensaje'] = "alertify.success('Ingresa los datos correspondientes para continuar...')";
                            header("Location: Financiero/editar_perfil.php");
                        }
                        break;
                }
            } 
            else
            {
                $_SESSION['mensaje'] = "alertify.warning('El correo no se encuentra registrado o la contraseña ingresada no coincide. Intenta nuevamente...')";
                header("Location: index.php");
            }
        }
        
    catch(PDOException $e)
    {
        $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error, no se ha podido iniciar la sesión. Error: ".$e->getMessage()."')";
        header("Location: index.php");
    }
?>