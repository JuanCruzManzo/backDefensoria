<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] .'/backDefensoria/parametros.php';
include(CONEXION);
include(PARAMETROS);
include(FUNCIONES);
mysqli_set_charset($link, "utf8mb4");

// Datos del form
$titulo = mysqli_real_escape_string($link, $_POST['titulo']);
$anio   = mysqli_real_escape_string($link, $_POST['anio']);
$estado = intval($_POST['estado']);

// Manejo de archivo PDF
$pdfRuta = "";
if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
    $nombreTmp = $_FILES['pdf']['tmp_name'];
    $nombreArchivo = basename($_FILES['pdf']['name']);
    $pdfRuta = "uploads/resoluciones/" . time() . "_" . $nombreArchivo;

    if (!is_dir("uploads/resoluciones/")) {
        mkdir("uploads/resoluciones/", 0777, true);
    }

    if (!move_uploaded_file($nombreTmp, $pdfRuta)) {
        die("Error al subir el archivo PDF.");
    }
} else {
    die("No se recibió un archivo PDF válido.");
}

$sql = "INSERT INTO resoluciones (titulo, Anio, estado, pdf) 
        VALUES ('$titulo', '$anio', $estado, '$pdfRuta')";

if (mysqli_query($link, $sql)) {
    $id_insertado = mysqli_insert_id($link);
    $observacion = "Se cargó la resolución ID $id_insertado";
    $valor_nuevo = "Título: $titulo | Año: $anio | Estado: $estado | PDF: $pdfRuta";

    registrarAuditoria($link, $_SESSION['usuario_id'], 'Alta', 'resoluciones', $observacion, '', $valor_nuevo);

    header("Location: index.php?vista=resoluciones/resoluciones"); 
    exit;
} else {
    echo "Error: " . mysqli_error($link);
}
