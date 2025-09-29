<?php
include_once $_SERVER['DOCUMENT_ROOT'] .'/backDefensoria/parametros.php';
include(CONEXION);
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

<div class="container main-admin">
    <h4 class="text-dark display-4">Gestión de Auditorías</h4>
    <hr>
    <div>
        <form method="GET" action="index.php" class="row g-3 mb-4">
            <input type="hidden" name="vista" value="auditorias/auditorias">
            <div class="col-md-4">
                <input type="text" name="modulo" class="form-control" placeholder="Filtrar por módulo (faq, noticias, etc.)">
            </div>
            <div class="col-md-4">
                <input type="date" name="fecha" class="form-control">
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn-cargar-noticias">
                    <i class="bi bi-funnel-fill"></i> Aplicar filtros
                </button>
            </div>
            <div class="col-md-2 d-grid">
                <a href="index.php?vista=auditorias/auditorias" class="btn-cargar-noticias">
                    <i class="bi bi-x-circle"></i> Limpiar filtros
                </a>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm">
            <thead class="encabezado-azul-institucional">
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
                        <td><strong><?= $log['nombre'] . ' ' . $log['apellido'] ?></strong></td>
                        <td class="text-dark fw-semibold"><?= ucfirst($log['accion']) ?></td>
                        <td class="text-uppercase text-muted"><?= $log['tabla_afectada'] ?></td>
                        <td><?= $log['observacion'] ?></td>
                        <td><?= date('d/m/Y', strtotime($log['fecha'])) ?></td>
                        <td><?= date('H:i', strtotime($log['fecha'])) ?></td>
                        <td>
                            <details>
                                <summary class="text-muted">Ver anterior</summary>
                                <pre class="small mb-0"><?= str_replace('|', "\n", $log['valor_anterior']) ?></pre>
                            </details>
                        </td>
                        <td>
                            <details>
                                <summary class="text-success">Ver nuevo</summary>
                                <pre class="small mb-0"><?= str_replace('|', "\n", $log['valor_nuevo']) ?></pre>
                            </details>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>