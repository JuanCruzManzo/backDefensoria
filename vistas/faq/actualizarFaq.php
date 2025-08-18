<?php
require_once(__DIR__ . "/../../conexion/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['faq_id']);
    $pregunta = mysqli_real_escape_string($link, $_POST['pregunta']);
    $respuesta = mysqli_real_escape_string($link, $_POST['respuesta']);
    $estado = intval($_POST['estado']);

    $sql = "UPDATE faq 
            SET pregunta='$pregunta', respuesta='$respuesta', estado=$estado 
            WHERE faq_id=$id";

    if (mysqli_query($link, $sql)) {
        // Redirigir a la lista de FAQ
        header("Location: index.php?vista=faq/faq");
        exit;
    } else {
        echo "Error al actualizar: " . mysqli_error($link);
    }
}
