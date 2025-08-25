<?php
include_once __DIR__ . "/../../conexion/conexion.php";

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$titulo = isset($_POST['titulo']) ? mysqli_real_escape_string($link, $_POST['titulo']) : '';
$anio = isset($_POST['anio']) ? intval($_POST['anio']) : 0;
$estado = isset($_POST['estado']) ? intval($_POST['estado']) : 0;

if (empty($titulo) || $anio <= 0) {
    echo "<div class='alert alert-warning'>Datos incompletos o inválidos.</div>";
    exit;
}

// --- Manejo de archivo PDF ---
$pdfSql = "";
if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
    $nombreTmp = $_FILES['pdf']['tmp_name'];
    $nombreArchivo = basename($_FILES['pdf']['name']);
    $pdfRuta = "uploads/resoluciones/" . time() . "_" . $nombreArchivo;

    if (!is_dir("uploads/resoluciones/")) {
        mkdir("uploads/resoluciones/", 0777, true);
    }

    if (move_uploaded_file($nombreTmp, $pdfRuta)) {
        $pdfSql = ", pdf = '" . mysqli_real_escape_string($link, $pdfRuta) . "'";
    } else {
        echo "<div class='alert alert-danger'>Error al subir el PDF.</div>";
        exit;
    }
}

if ($id > 0) {
    // Actualizar resolución existente (incluye PDF si se subió)
    $sql = "UPDATE resoluciones 
            SET Titulo = '$titulo', Anio = $anio, estado = $estado $pdfSql
            WHERE resolucion_id = $id";
} else {
    // Insertar nueva resolución
    $sql = "INSERT INTO resoluciones (Titulo, Anio, estado, pdf) 
            VALUES ('$titulo', $anio, $estado, '$pdfRuta')";
}

if (mysqli_query($link, $sql)) {
    header("Location: index.php?vista=resoluciones/resoluciones");
    exit;
} else {
    echo "<div class='alert alert-danger'>Error en la operación: " . mysqli_error($link) . "</div>";
}
