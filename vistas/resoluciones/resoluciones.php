<?php
include_once __DIR__ . "/../../conexion/parametros.php";
include_once __DIR__ . "/../../conexion/conexion.php";
include_once "../plantilla/head2.php";

$anio = isset($_GET['anio']) ? $_GET['anio'] : '';
$sql = "SELECT * FROM resoluciones";
if (!empty($anio)) {
    $sql .= " WHERE Anio = '$anio'";
}
$sql .= " ORDER BY resolucion_id ASC";
$resultado = mysqli_query($link, $sql);

?>

<div class="container py-4">
    <div class="row align-items-center mb-3">
        <div class="col-12 mb-3">
            <h4 class="text-dark display-4">Gestión de Resoluciones</h4>
        </div>
        <div class="col-auto">
            <a href="index.php?vista=resoluciones/cargarResoluciones" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Cargar
            </a>
        </div>
        <div class="col">
            <form class="d-flex" method="GET" action="">
                <input type="hidden" name="vista" value="resoluciones/resoluciones">
                <input class="form-control me-2" name="anio" type="search" placeholder="Buscar por año..." aria-label="Buscar por año" />
                <button class="btn btn-outline-success" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle shadow-sm">
            <thead class="table-success text-center">
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
                                    class="btn btn-sm btn-primary"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Editar resolución">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button"
                                    class="btn btn-sm btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#confirmarEliminacion<?= $row['resolucion_id'] ?>"
                                    title="Eliminar resolución">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                            <div class="modal fade" id="confirmarEliminacion<?= $row['resolucion_id'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $row['resolucion_id'] ?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="modalLabel<?= $row['resolucion_id'] ?>">
                                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirmar eliminación
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Estás segura de que querés eliminar la resolución <strong>#<?= $row['resolucion_id'] ?></strong>? Esta acción no se puede deshacer.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <a href="index.php?vista=resoluciones/eliminarResolucion&id=<?= $row['resolucion_id'] ?>" class="btn btn-danger">
                                                Eliminar
                                            </a>
                                        </div>
                                    </div>
                                </div>
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