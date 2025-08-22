<?php
include_once "../plantilla/head2.php";
mysqli_set_charset($link, "utf8mb4");
$sql = "SELECT * FROM faq";
$items = mysqli_query($link, $sql);
?>
<div class="container mt-4">
    <div class="row align-items-center mb-3">
        <div class="col-12 mb-3">
            <h4 class="text-dark display-4">Gestión de Preguntas Frecuentes</h4>
        </div>
        <div class="col-auto">
            <a href="index.php?vista=faq/cargarFaq" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Cargar
            </a>
        </div>
        <div class="col">
            <form class="d-flex" role="search" method="GET" action="">
                <input type="hidden" name="vista" value="faq/faq">
                <input class="form-control me-2" name="buscar" type="search" placeholder="Buscar..." aria-label="Buscar" />
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
                    <th scope="col">Pregunta</th>
                    <th scope="col">Respuesta</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($campos = mysqli_fetch_array($items)) { ?>
                    <tr>
                        <td class="text-center fw-bold"><?= $campos['faq_id'] ?></td>
                        <td><?= $campos['pregunta'] ?></td>
                        <td><?= $campos['respuesta'] ?></td>
                        <td class="text-center">
                            <?php if ($campos['estado'] == 1): ?>
                                <span class="badge rounded-pill bg-success p-2">
                                    <i class="bi bi-check-circle-fill"></i> Activa
                                </span>
                            <?php else: ?>
                                <span class="badge rounded-pill bg-secondary p-2">
                                    <i class="bi bi-x-circle-fill"></i> Inactiva
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <!-- Botón editar -->
                                <a href="index.php?vista=faq/editarFaq&id=<?= $campos['faq_id'] ?>"
                                    class="btn btn-sm btn-primary"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Editar FAQ">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <!-- Botón eliminar -->
                                <button type="button"
                                    class="btn btn-sm btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#confirmarEliminacion<?= $campos['faq_id'] ?>"
                                    title="Eliminar FAQ">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>

                            <!-- Modal confirmación -->
                            <div class="modal fade" id="confirmarEliminacion<?= $campos['faq_id'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $campos['faq_id'] ?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="modalLabel<?= $campos['faq_id'] ?>">
                                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirmar eliminación
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Estás seguro de que querés eliminar la FAQ <strong>#<?= $campos['faq_id'] ?></strong>? Esta acción no se puede deshacer.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <a href="index.php?vista=faq/eliminarFaq&id=<?= $campos['faq_id'] ?>" class="btn btn-danger">
                                                Eliminar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Tooltip -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach(t => new bootstrap.Tooltip(t));
    });
</script>
