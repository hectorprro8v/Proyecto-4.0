<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];
    // Verifica que el archivo exista
    if (file_exists($file)) {
        header("Content-Type: application/pdf");
        header("Content-Disposition: inline; filename='" . basename($file) . "'");
        readfile($file);
        exit();
    } else {
        echo "El archivo no existe.";
    }
} else {
    echo "No se especificó un archivo.";
}
?>
