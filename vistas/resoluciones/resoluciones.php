<?php
include_once __DIR__ . "/../../conexion/parametros.php";
include_once __DIR__ . "/../../conexion/conexion.php";
require_once(__DIR__ . "/../../conexion/funciones.php");
include_once "../plantilla/head2.php";

$anio = isset($_GET['anio']) ? $_GET['anio'] : '';
$sql = "SELECT * FROM resoluciones";
if (!empty($anio)) {
    $sql .= " WHERE Anio = '$anio'";
}
$sql .= " ORDER BY resolucion_id ASC";
$resultado = mysqli_query($link, $sql);

?>

<div class="container main-admin">
    <div class="row align-items-center mb-3">
        <div class="col-12 mb-3">
            <h4 class="text-dark display-4">Gestión de Resoluciones</h4>
            <hr>
        </div>
        <div class="col-auto">
            <a href="index.php?vista=resoluciones/cargarResoluciones" class="btn-cargar">
                <i class="bi bi-plus-circle"></i> Cargar
            </a>
        </div>
        <div class="col">
            <form class="d-flex" method="GET" action="">
                <input type="hidden" name="vista" value="resoluciones/resoluciones">
                <input class="form-control me-2" name="anio" type="search" placeholder="Buscar por año..." aria-label="Buscar por año" />
                <button class="btn-buscar" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle shadow-sm">
            <thead class="encabezado-azul-institucional">
                <tr>
                    <th scope="col">Cod.</th>
                    <th scope="col">Título</th>
                    <th scope="col">Año</th>
                    <th scope="col">Estado</th>
                    <th scope="col">PDF</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td class="text-center fw-bold"><?= $row['resolucion_id'] ?></td>
                        <td><?= $row['Titulo'] ?></td>
                        <td class="text-center"><?= $row['Anio'] ?></td>
                        <td class="text-center">
                            <?php if ($row['estado'] == 1): ?>
                                <span class="badge rounded-pill bg-success p-2">
                                    <i class="bi bi-check-circle-fill"></i> Publicado
                                </span>
                            <?php else: ?>
                                <span class="badge rounded-pill bg-secondary p-2">
                                    <i class="bi bi-x-circle-fill"></i> No publicado
                                </span>
                            <?php endif; ?>
                        </td>
                        <!-- 👇 Botón PDF -->
                        <td class="text-center">
                            <?php if (!empty($row['pdf'])): ?>
                                <a href="<?= $row['pdf'] ?>" target="_blank"
                                    class="btn btn-sm btn-outline-danger"
                                    title="Ver PDF">
                                    <i class="bi bi-file-earmark-pdf-fill"></i> Ver
                                </a>
                            <?php else: ?>
                                <span class="text-muted">Sin archivo</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="index.php?vista=resoluciones/editarResoluciones&id=<?= $row['resolucion_id'] ?>"
                                    class="btn-editar"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Editar resolución">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach(t => new bootstrap.Tooltip(t));
    });
</script>

</html>