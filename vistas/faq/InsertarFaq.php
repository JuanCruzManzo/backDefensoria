<?php
require_once(__DIR__ . "/../../conexion/parametros.php");
require_once(__DIR__ . "/../../conexion/conexion.php");
mysqli_set_charset($link, "utf8mb4");

// Datos del form
$pregunta    = mysqli_real_escape_string($link, $_POST['pregunta']);
$respuesta   = mysqli_real_escape_string($link, $_POST['respuesta']);
$estado      = intval($_POST['estado']);


$sql = "INSERT INTO faq (pregunta, respuesta, estado) 
        VALUES ('$pregunta', '$respuesta', $estado)";

if (mysqli_query($link, $sql)) {
    header("Location: index.php?vista=faq/faq"); 
    exit;
} else {
    echo "Error: " . mysqli_error($link);
}
