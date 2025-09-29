<?php
include_once $_SERVER['DOCUMENT_ROOT'] .'/backDefensoria/parametros.php';
include(CONEXION);
include(FUNCIONES);
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['faq_id']);
    $pregunta = mysqli_real_escape_string($link, $_POST['pregunta']);
    $respuesta = mysqli_real_escape_string($link, $_POST['respuesta']);
    $estado = intval($_POST['estado']);

    // Obtener datos originales
    $sql_original = "SELECT pregunta, respuesta, estado FROM faq WHERE faq_id = $id";
    $result_original = mysqli_query($link, $sql_original);
    $original = mysqli_fetch_assoc($result_original);

    $pregunta_vieja = $original['pregunta'];
    $respuesta_vieja = $original['respuesta'];
    $estado_viejo = $original['estado'];

    $sql = "UPDATE faq 
            SET pregunta='$pregunta', respuesta='$respuesta', estado=$estado 
            WHERE faq_id=$id";

    if (mysqli_query($link, $sql)) {
        $observacion = "Se modificó la FAQ ID $id";
        $valor_anterior = "Pregunta: $pregunta_vieja | Respuesta: $respuesta_vieja | Estado: $estado_viejo";
        $valor_nuevo = "Pregunta: $pregunta | Respuesta: $respuesta | Estado: $estado";

        registrarAuditoria($link, $_SESSION['usuario_id'], 'Editar', 'faq', $observacion, $valor_anterior, $valor_nuevo);

        header("Location: index.php?vista=faq/faq");
        exit;
    } else {
        echo "Error al actualizar: " . mysqli_error($link);
    }
}
