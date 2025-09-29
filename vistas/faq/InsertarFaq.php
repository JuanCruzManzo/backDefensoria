<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] .'/backDefensoria/parametros.php';
include(CONEXION);
include(FUNCIONES);

mysqli_set_charset($link, "utf8mb4");

// Obtener el ID del usuario desde la sesión
$usuario_id = isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : 0;
if ($usuario_id <= 0) {
    echo "<div class='alert alert-danger'>Error: sesión no iniciada o usuario no válido.</div>";
    exit;
}

// Datos del form
$pregunta    = mysqli_real_escape_string($link, $_POST['pregunta']);
$respuesta   = mysqli_real_escape_string($link, $_POST['respuesta']);
$estado      = intval($_POST['estado']);

$sql = "INSERT INTO faq (pregunta, respuesta, estado, usuario_id) 
        VALUES ('$pregunta', '$respuesta', $estado, $usuario_id)";

if (mysqli_query($link, $sql)) {
    $id_insertado = mysqli_insert_id($link);
    $observacion = "Se creó la FAQ ID $id_insertado";
    $valor_nuevo = "Pregunta: $pregunta | Respuesta: $respuesta | Estado: $estado";

    registrarAuditoria($link, $usuario_id, 'Alta', 'faq', $observacion, '', $valor_nuevo);

    header("Location: index.php?vista=faq/faq"); 
    exit;
} else {
    echo "Error: " . mysqli_error($link);
}
