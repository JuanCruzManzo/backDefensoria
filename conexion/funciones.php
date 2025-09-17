<?php
$user=$_SESSION['usuario_id'];

function registrarAuditoria($link, $user, $accion, $tabla, $observacion, $valor_anterior = '', $valor_nuevo = '') {
    $fecha = date('Y-m-d H:i:s');
    $sql = "INSERT INTO auditorias (usuario_id, accion, observacion, fecha, tabla_afectada, valor_anterior, valor_nuevo)
            VALUES ('$user', '$accion', '$observacion', '$fecha', '$tabla', '$valor_anterior', '$valor_nuevo')";
    mysqli_query($link, $sql);
}
?>
