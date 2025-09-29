<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] .'/backDefensoria/parametros.php';
include(CONEXION);
include(FUNCIONES);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $estado = intval($_POST['estado']);

    // Obtener datos anteriores
    $sql_original = "SELECT estado, resena FROM resenas WHERE resena_id = ?";
    $stmt_original = $link->prepare($sql_original);
    $stmt_original->bind_param("i", $id);
    $stmt_original->execute();
    $resultado = $stmt_original->get_result();
    $original = $resultado->fetch_assoc();

    $estado_viejo = $original['estado'];
    $resena_texto = $original['resena'];

    // Actualizar estado
    $sql = "UPDATE resenas SET estado = ? WHERE resena_id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("ii", $estado, $id);

    if ($stmt->execute()) {
        // Registrar auditoría
        $observacion = "Se modificó el estado de la reseña ID $id";
        $valor_anterior = "Estado: $estado_viejo | Reseña: $resena_texto";
        $valor_nuevo = "Estado: $estado | Reseña: $resena_texto";

        registrarAuditoria($link, $_SESSION['usuario_id'], 'Editar', 'resenas', $observacion, $valor_anterior, $valor_nuevo);

        echo "ok";
    } else {
        http_response_code(500);
        echo "error";
    }
}
