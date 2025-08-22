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

if ($id > 0) {
    // Actualizar resolución existente
    $sql = "UPDATE resoluciones 
            SET Titulo = '$titulo', Anio = $anio, estado = $estado 
            WHERE resolucion_id = $id";
} else {
    // Insertar nueva resolución
    $sql = "INSERT INTO resoluciones (Titulo, Anio, estado) 
            VALUES ('$titulo', $anio, $estado)";
}

// Ejecutar consulta
if (mysqli_query($link, $sql)) {
    header("Location: index.php?vista=resoluciones/resoluciones");
    exit;
} else {
    echo "<div class='alert alert-danger'>Error en la operación: " . mysqli_error($link) . "</div>";
}
?>
