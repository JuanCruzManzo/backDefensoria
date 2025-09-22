<?php
function registrarAuditoria($link, $usuario_id, $accion, $tabla, $observacion, $valor_anterior = '', $valor_nuevo = '') {
    $fecha = date('Y-m-d H:i:s');
    $sql = "INSERT INTO auditorias (usuario_id, accion, observacion, fecha, tabla_afectada, valor_anterior, valor_nuevo)
            VALUES ('$usuario_id', '$accion', '$observacion', '$fecha', '$tabla', '$valor_anterior', '$valor_nuevo')";
    mysqli_query($link, $sql);
}
?>
