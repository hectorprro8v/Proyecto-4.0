<?php
session_start();
require_once __DIR__ . '/../conexion.php';
$conexion = conectar();
$conexion->exec("SET NAMES utf8mb4");

date_default_timezone_set('America/Mexico_City');

// Helper: convierte "$1,234.50" -> 1234.50
function toNumber($str) {
    $s = str_replace(['$', ',', ' '], '', (string)$str);
    return is_numeric($s) ? (float)$s : 0.0;
}

/**
 * Resuelve el idTipoPago a partir de lo que venga del front:
 *  - Si el front manda el PRECIO como value del <select>, buscamos por Precio.
 *  - Si manda el ID, lo aceptamos directo.
 *  - Si manda la Descripción, intentamos buscar por Descripcion.
 */
function resolveTipoPagoId(PDO $cn, $postedValor) {
    if ($postedValor === null || $postedValor === '') return null;

    // 1) Si es numérico con decimales, asumimos que es PRECIO
    if (is_numeric($postedValor) && strpos((string)$postedValor, '.') !== false) {
        $p = (float)$postedValor;
        $stmt = $cn->prepare("SELECT idTipoPago FROM tipopago WHERE ABS(Precio - :p) < 0.0001 LIMIT 1");
        $stmt->execute([':p' => $p]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) return (int)$row['idTipoPago'];
    }

    // 2) Si es todo dígitos, puede ser PRECIO entero o un ID
    if (ctype_digit((string)$postedValor)) {
        $entero = (int)$postedValor;

        // Primero probamos como ID
        $stmt = $cn->prepare("SELECT idTipoPago FROM tipopago WHERE idTipoPago = :id LIMIT 1");
        $stmt->execute([':id' => $entero]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) return (int)$row['idTipoPago'];

        // Luego probamos como PRECIO entero
        $stmt = $cn->prepare("SELECT idTipoPago FROM tipopago WHERE ABS(Precio - :p) < 0.0001 LIMIT 1");
        $stmt->execute([':p' => $entero]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) return (int)$row['idTipoPago'];
    }

    // 3) Si llega una cadena (posible Descripcion)
    $stmt = $cn->prepare("SELECT idTipoPago FROM tipopago WHERE Descripcion = :d LIMIT 1");
    $stmt->execute([':d' => (string)$postedValor]);
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) return (int)$row['idTipoPago'];

    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ====== 1) Recoger datos base ======
    $rfc         = trim($_POST['rfc'] ?? '');
    $razonsocial = trim($_POST['razonsocial'] ?? '');
    $pais        = trim($_POST['pais'] ?? '');
    $estado      = trim($_POST['estado'] ?? '');
    $ciudad      = trim($_POST['ciudad'] ?? '');
    $domicilio   = trim($_POST['domicilio'] ?? '');
    $cp          = trim($_POST['cp'] ?? '');

    // ---- artículos seleccionados y cantidad SIN depender de JS ----
    $ids = isset($_POST['check']) && is_array($_POST['check']) ? $_POST['check'] : [];
    $cantidad = count($ids);

    // Montos (vienen con $)
    $subtotal = toNumber($_POST['subtotal'] ?? '0');
    $iva      = toNumber($_POST['iva'] ?? '0');
    $total    = toNumber($_POST['total'] ?? '0');

    // ====== Tipo de pago ======
    // Front: <select name="precio" id="precios"> (ya no se deshabilita)
    $postedPrecio = $_POST['precio'] ?? ($_POST['precios'] ?? null);
    $idPrecioPago = resolveTipoPagoId($conexion, $postedPrecio);

    if ($idPrecioPago === null) {
        $_SESSION['mensaje'] = "alertify.error('Selecciona el tipo de pago antes de continuar.')";
        $_SESSION['mensaje_texto'] = "Selecciona el tipo de pago antes de continuar.";
        header("Location: generar_ficha.php");
        exit;
    }

    // ====== Facturación ======
    $factura       = isset($_POST['facturar']) ? 1 : 0;

    // 🔧 Forma de pago libre (hasta 200 chars). Si no se solicita factura -> null.
    $formaPago     = $factura ? mb_substr(trim($_POST['forma_pago'] ?? ''), 0, 200, 'UTF-8') : null;
    $regimenFiscal = $factura ? trim($_POST['regimen_fiscal'] ?? '') : null;
    $usoCFDI       = $factura ? trim($_POST['uso_cfdi'] ?? '') : null;

    if ($cantidad <= 0) {
        $_SESSION['mensaje'] = "alertify.warning('No has seleccionado ningún artículo a pagar.')";
        $_SESSION['mensaje_texto'] = "No has seleccionado ningún artículo a pagar.";
        header("Location: generar_ficha.php");
        exit;
    }

    // Si marcó factura, valida campos clave y PDF
    $sfGuardada = false;
    $sfURL = null; // ruta relativa para BD
    $destPath = null;

    if ($factura) {
        if ($formaPago === '' || $regimenFiscal === '' || $usoCFDI === '') {
            $_SESSION['mensaje'] = "alertify.error('Faltan datos de facturación (Forma de pago, Régimen fiscal o Uso de CFDI).')";
            $_SESSION['mensaje_texto'] = "Faltan datos de facturación (Forma de pago, Régimen fiscal o Uso de CFDI).";
            header("Location: generar_ficha.php");
            exit;
        }

        if (!isset($_FILES['situacion_fiscal_pdf']) || $_FILES['situacion_fiscal_pdf']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['mensaje'] = "alertify.error('Debes subir el PDF de Situación Fiscal.')";
            $_SESSION['mensaje_texto'] = "Debes subir el PDF de Situación Fiscal.";
            header("Location: generar_ficha.php");
            exit;
        }
        $mime = mime_content_type($_FILES['situacion_fiscal_pdf']['tmp_name']);
        if ($mime !== 'application/pdf') {
            $_SESSION['mensaje'] = "alertify.error('El archivo de Situación Fiscal debe ser PDF.')";
            $_SESSION['mensaje_texto'] = "El archivo de Situación Fiscal debe ser PDF.";
            header("Location: generar_ficha.php");
            exit;
        }

        $destDir = realpath(__DIR__ . '/../Documentos') ?: (__DIR__ . '/../Documentos');
        $destDir .= '/Situacion_Fiscal';

        if (!is_dir($destDir)) {
            @mkdir($destDir, 0775, true);
        }

        $sfNombre = 'SF_' . (int)($_SESSION['id'] ?? 0) . '_' . date('Ymd_His') . '.pdf';
        $destPath = $destDir . '/' . $sfNombre;

        if (!move_uploaded_file($_FILES['situacion_fiscal_pdf']['tmp_name'], $destPath)) {
            $_SESSION['mensaje'] = "alertify.error('No se pudo guardar el PDF de Situación Fiscal.')";
            $_SESSION['mensaje_texto'] = "No se pudo guardar el PDF de Situación Fiscal.";
            header("Location: generar_ficha.php");
            exit;
        }

        $sfURL = 'Documentos/Situacion_Fiscal/' . $sfNombre;
        $sfGuardada = true;
    }

    try {
        // ====== 3) Transacción ======
        $conexion->beginTransaction();

        // ====== 4) Insertar recibo_pago ======
        $sql = "INSERT INTO recibo_pago
                (Fecha, RFC, Razon_Social, Domicilio, Ciudad, Estado, Pais, CP,
                 Sub_Total, Iva, Total, id_Precio_Pago, Comprobante,
                 Forma_Pago, Regimen_Fiscal, UsoCFDI)
                VALUES (DATE_FORMAT(NOW(), '%Y-%m-%d'), :rfc, :razon, :dom, :ciudad, :estado, :pais, :cp,
                        :subt, :iva, :total, :id_precio, :comp, :forma, :regimen, :uso)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':rfc'       => $rfc,
            ':razon'     => $razonsocial,
            ':dom'       => $domicilio,
            ':ciudad'    => $ciudad,
            ':estado'    => $estado,
            ':pais'      => $pais,
            ':cp'        => $cp,
            ':subt'      => $subtotal,
            ':iva'       => $iva,
            ':total'     => $total,
            ':id_precio' => $idPrecioPago,
            ':comp'      => $factura,          // 0/1
            ':forma'     => $formaPago,        // texto libre o null
            ':regimen'   => $regimenFiscal ?: null,
            ':uso'       => $usoCFDI ?: null
        ]);

        $idRecibo = (int)$conexion->lastInsertId();

        // ====== 5) Insertar detalles ======
        $stmtDet = $conexion->prepare("INSERT INTO recibo_pago_detalle (idRecibo, idArticulo) VALUES (:idRecibo, :idArticulo)");
        foreach ($ids as $idArticulo) {
            $stmtDet->execute([
                ':idRecibo'  => $idRecibo,
                ':idArticulo'=> (int)$idArticulo
            ]);
        }

        // ====== 6) Registrar PDF de Situación Fiscal (si existe) ======
        if ($sfGuardada && $sfURL) {
            $stmtDoc = $conexion->prepare(
                "INSERT INTO documentos_financiero (idRecibo, Nombre_Documento, Tipo_Documento, URL, Fecha_Envio)
                 VALUES (:idRecibo, :nombre, 'PDF', :url, DATE_FORMAT(NOW(), '%Y-%m-%d'))"
            );
            $stmtDoc->execute([
                ':idRecibo' => $idRecibo,
                ':nombre'   => 'Situacion_Fiscal',
                ':url'      => $sfURL
            ]);
        }

        $conexion->commit();

        // ====== 7) Enviar correo (no aborta si falla) ======
        try {
            require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
            require_once __DIR__ . '/../PHPMailer/src/SMTP.php';
            require_once __DIR__ . '/../PHPMailer/src/Exception.php';

            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'revistacid@itslerdo.edu.mx';
            $mail->Password   = 'sbjh xlan pnvf ttoa';
            $mail->Port       = 587;

            // UTF-8
            $mail->CharSet  = 'UTF-8';
            $mail->Encoding = 'base64';

            $mail->setFrom('revistacid@itslerdo.edu.mx', 'Revista CID Teclero');
            $mail->addAddress('revistacid@itslerdo.edu.mx');

            $mail->Subject = 'Recibo de pago generado';
            $mail->Body    = "Se ha generado el recibo #{$idRecibo} el " . date('Y-m-d H:i') . ".\nTotal: $" . number_format((float)$total, 2);

            // if ($sfGuardada && $destPath && file_exists($destPath)) {
            //     $mail->addAttachment($destPath, 'Situacion_Fiscal.pdf');
            // }

            $mail->send();
        } catch (Throwable $exMail) {
            // No interrumpimos el flujo si el correo falla
        }

        $_SESSION['mensaje'] = "alertify.success('Los datos se han enviado correctamente.')";
        $_SESSION['mensaje_texto'] = "Los datos se han enviado correctamente.";
        header("Location: fichas_de_pago.php");
        exit;

    } catch (Throwable $e) {
        if ($conexion->inTransaction()) {
            $conexion->rollBack();
        }
        $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error. El recibo no se generó. Error: ".$e->getMessage()."')";
        $_SESSION['mensaje_texto'] = "Ha ocurrido un error. El recibo no se generó. Error: ".$e->getMessage();
        header("Location: generar_ficha.php");
        exit;
    }

} else {
    header("Location: generar_ficha.php");
    exit;
}

