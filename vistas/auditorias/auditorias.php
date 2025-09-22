<?php
include_once "../conexion/conexion.php";
mysqli_set_charset($link, "utf8mb4");

$modulo = isset($_GET['modulo']) ? trim($_GET['modulo']) : '';
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';

$where = [];
if ($modulo !== '') $where[] = "a.tabla_afectada LIKE '%$modulo%'";
if ($fecha !== '') $where[] = "DATE(a.fecha) = '$fecha'";

$condiciones = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "SELECT a.*, u.nombre, u.apellido
        FROM auditorias a
        JOIN usuarios u ON a.usuario_id = u.usuario_id
        $condiciones
        ORDER BY a.fecha DESC";

$resultado = mysqli_query($link, $sql);
?>

<div class="container">
    <h4 class="text-dark display-6">Historial de Auditoría</h4>
    <hr>
    <div>
        <form method="GET" class="d-flex gap-3 mb-4">
            <input type="text" name="modulo" class="form-control" placeholder="Filtrar por módulo">
            <input type="date" name="fecha" class="form-control">
            <button type="submit" class="btn-auditoria">
                <i class="bi bi-funnel-fill"></i> Filtrar
            </button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle shadow-sm">
            <thead class="encabezado-tabla text-white text-center">
                <tr>
                    <th>Usuario</th>
                    <th>Acción</th>
                    <th>Módulo</th>
                    <th>Observación</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Dato anterior</th>
                    <th>Dato nuevo</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($log = mysqli_fetch_array($resultado)) { ?>
                    <tr>
                        <td><?= $log['nombre'] . ' ' . $log['apellido'] ?></td>
                        <td><?= $log['accion'] ?></td>
                        <td><?= $log['tabla_afectada'] ?></td>
                        <td><?= $log['observacion'] ?></td>
                        <td><?= date('d/m/Y', strtotime($log['fecha'])) ?></td>
                        <td><?= date('H:i', strtotime($log['fecha'])) ?></td>
                        <td><?= $log['valor_anterior'] ?></td>
                        <td><?= $log['valor_nuevo'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>