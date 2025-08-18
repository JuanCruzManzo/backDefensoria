<?php
include_once __DIR__ . "/../../conexion/conexion.php";

$id = intval($_POST['id']);
$titulo = mysqli_real_escape_string($link, $_POST['titulo']);
$anio = intval($_POST['anio']);
$estado = intval($_POST['estado']);

$sql = "UPDATE resoluciones SET Titulo = '$titulo', Anio = $anio, estado = $estado WHERE resolucion_id = $id";
if (mysqli_query($link, $sql)) {
    header("Location: index.php?vista=resoluciones/resoluciones");
    exit;
} else {
    echo "<div class='alert alert-danger'>Error al actualizar: " . mysqli_error($link) . "</div>";
}

?>