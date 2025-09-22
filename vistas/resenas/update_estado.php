<?php
require_once(__DIR__ . "/../../conexion/conexion.php");

var_dump($_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $estado = intval($_POST['estado']);

    $sql = "UPDATE resenas SET estado = ? WHERE resena_id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("ii", $estado, $id);

    if($stmt->execute()) {
        echo "ok";
    } else {
        http_response_code(500);
        echo "error";
    }
}
?>