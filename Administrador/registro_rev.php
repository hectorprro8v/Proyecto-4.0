<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Solo procesar si se envió el formulario
if (isset($_POST['registrar_rev'])) {
    // Conexión a la base de datos
    include_once("../conexion.php");
    include('../mail/class.phpmailer.php');
    include('../mail/class.smtp.php');
    $conectar = conectar();

    //variables de registro
    $nombre_reg = trim($_POST['nombre_reg']);
    $apellido_paterno_reg = trim($_POST['apellido_paterno_reg']);
    $apellido_materno_reg = trim($_POST['apellido_materno_reg']);
    $email_reg = trim($_POST['email_reg']);
    $Tipo_Usuario = $_POST['Tipo_Usuario'];
    $institucion_reg = trim($_POST['institucion_reg']);
    $grado_estudio_reg = trim($_POST['grado_estudio_reg']);
    
    // Preparar líneas de investigación como string separado por comas
    $lineas_investigacion = '';
    if(isset($_POST['lineas_investigacion']) && is_array($_POST['lineas_investigacion'])) {
        $lineas_investigacion = implode(',', $_POST['lineas_investigacion']);
    }
    
    try {
        // Llamar al procedimiento almacenado
        $stmt = $conectar->prepare("CALL sp_RegistrarRevisor(:nombre, :apellido_paterno, :apellido_materno, :email, :tipo_usuario, :institucion, :grado_estudios, :lineas_investigacion)");
        
        $stmt->bindParam(':nombre', $nombre_reg, PDO::PARAM_STR);
        $stmt->bindParam(':apellido_paterno', $apellido_paterno_reg, PDO::PARAM_STR);
        $stmt->bindParam(':apellido_materno', $apellido_materno_reg, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email_reg, PDO::PARAM_STR);
        $stmt->bindParam(':tipo_usuario', $Tipo_Usuario, PDO::PARAM_STR);
        $stmt->bindParam(':institucion', $institucion_reg, PDO::PARAM_STR);
        $stmt->bindParam(':grado_estudios', $grado_estudio_reg, PDO::PARAM_STR);
        $stmt->bindParam(':lineas_investigacion', $lineas_investigacion, PDO::PARAM_STR);
        
        $stmt->execute();
        
        // Obtener el resultado del procedimiento
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $idRevisor = $result['idRevisor'];
        
        // Mensaje de éxito
        $_SESSION['mensaje'] = "alertify.success('Nuevo revisor registrado correctamente')";
        
        // Redirigir a la carta de invitación
        header("Location: cartaInvitacion_rev.php?nombre_reg=".urlencode($nombre_reg)."&apellido_paterno_reg=".urlencode($apellido_paterno_reg)."&apellido_materno_reg=".urlencode($apellido_materno_reg)."&email_reg=".urlencode($email_reg));
        exit();
        
    } catch (PDOException $error) {
        // Capturar mensajes de error específicos del procedimiento almacenado
        $error_message = $error->getMessage();
        
        if (strpos($error_message, 'El usuario ya está registrado') !== false) {
            $_SESSION['mensaje'] = "alertify.warning('Ese usuario ya está registrado como revisor o contacto')";
        } elseif (strpos($error_message, 'Debe seleccionar al menos una línea') !== false) {
            $_SESSION['mensaje'] = "alertify.error('Debe seleccionar al menos una línea de investigación')";
        } else {
            $_SESSION['mensaje'] = "alertify.error('Error al registrar al nuevo revisor: " . $error_message . "')";
        }
        
        header("Location: alta_revisores.php");
        exit();
    }
}
// No hacer nada si no se envió el formulario
?>