<?php
require_once(__DIR__ . "/../../conexion/parametros.php");
require_once(__DIR__ . "/../../conexion/conexion.php");
mysqli_set_charset($link, "utf8mb4");

// Datos del form
$titulo = mysqli_real_escape_string($link, $_POST['titulo']);
$anio = mysqli_real_escape_string($link, $_POST['anio']);
$estado = intval($_POST['estado']);


$sql = "INSERT INTO resoluciones (titulo, anio, estado) 
        VALUES ('$titulo', '$anio', $estado)";

if (mysqli_query($link, $sql)) {
    header("Location: index.php?vista=resoluciones/resoluciones"); 
    exit;
} else {
    echo "Error: " . mysqli_error($link);
}
