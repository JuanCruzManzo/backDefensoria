<?php
session_start();
include_once __DIR__ . "/../../conexion/conexion.php";
require_once(__DIR__ . "/../../conexion/funciones.php");

$id     = isset($_POST['id']) ? intval($_POST['id']) : 0;
$titulo = isset($_POST['titulo']) ? mysqli_real_escape_string($link, $_POST['titulo']) : '';
$anio   = isset($_POST['anio']) ? intval($_POST['anio']) : 0;
$estado = isset($_POST['estado']) ? intval($_POST['estado']) : 0;

if (empty($titulo) || $anio <= 0) {
    echo "<div class='alert alert-warning'>Datos incompletos o inválidos.</div>";
    exit;
}

// --- Manejo de archivo PDF ---
$pdfRuta = "";
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
    // 🔍 Obtener datos originales antes de actualizar
    $sql_original = "SELECT * FROM resoluciones WHERE resolucion_id = $id";
    $res_original = mysqli_query($link, $sql_original);
    $original = mysqli_fetch_assoc($res_original);

    $titulo_viejo = $original['Titulo'];
    $anio_viejo   = $original['Anio'];
    $estado_viejo = $original['estado'];
    $pdf_viejo    = $original['pdf'];

    // 🛠 Actualizar resolución existente
    $sql = "UPDATE resoluciones 
            SET Titulo = '$titulo', Anio = $anio, estado = $estado $pdfSql
            WHERE resolucion_id = $id";

    if (mysqli_query($link, $sql)) {
        $observacion = "Se modificó la resolución ID $id";
        $valor_anterior = "Título: $titulo_viejo | Año: $anio_viejo | Estado: $estado_viejo | PDF: $pdf_viejo";
        $valor_nuevo    = "Título: $titulo | Año: $anio | Estado: $estado | PDF: " . ($pdfRuta ?: $pdf_viejo);

        registrarAuditoria($link, $_SESSION['usuario_id'], 'Editar', 'resoluciones', $observacion, $valor_anterior, $valor_nuevo);

        header("Location: index.php?vista=resoluciones/resoluciones");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar: " . mysqli_error($link) . "</div>";
    }

} else {
    // 🆕 Insertar nueva resolución
    $sql = "INSERT INTO resoluciones (Titulo, Anio, estado, pdf) 
            VALUES ('$titulo', $anio, $estado, '$pdfRuta')";

    if (mysqli_query($link, $sql)) {
        $id_insertado = mysqli_insert_id($link);
        $observacion = "Se cargó la resolución ID $id_insertado";
        $valor_nuevo = "Título: $titulo | Año: $anio | Estado: $estado | PDF: $pdfRuta";

        registrarAuditoria($link, $_SESSION['usuario_id'], 'Alta', 'resoluciones', $observacion, '', $valor_nuevo);

        header("Location: index.php?vista=resoluciones/resoluciones");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error al insertar: " . mysqli_error($link) . "</div>";
    }
}
