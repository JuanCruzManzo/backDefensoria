<?php
include_once $_SERVER['DOCUMENT_ROOT'] .'/backDefensoria/parametros.php';
include(HEAD);
mysqli_set_charset($link, "utf8mb4");

// Tomamos lo que escribió el usuario
$buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

// Paginación
$por_pagina = 6;
$pagina_actual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$inicio = ($pagina_actual - 1) * $por_pagina;

// Total de resultados
$sql_total = "SELECT COUNT(*) FROM faq";
if ($buscar !== '') {
    $buscar_esc = mysqli_real_escape_string($link, $buscar);
    $sql_total .= " WHERE faq_id LIKE '%$buscar_esc%' 
                    OR pregunta LIKE '%$buscar_esc%' 
                    OR respuesta LIKE '%$buscar_esc%'";
}
$total_resultado = mysqli_fetch_row(mysqli_query($link, $sql_total))[0];
$total_paginas = ceil($total_resultado / $por_pagina);

// Consulta principal
$sql = "SELECT * FROM faq";
if ($buscar !== '') {
    $sql .= " WHERE faq_id LIKE '%$buscar_esc%' 
              OR pregunta LIKE '%$buscar_esc%' 
              OR respuesta LIKE '%$buscar_esc%'";
}
$sql .= " ORDER BY faq_id ASC LIMIT $inicio, $por_pagina";
$items = mysqli_query($link, $sql);
?>

<div class="container main-admin">
    <div class="row align-items-center mb-3">
        <div class="col-12 mb-3">
            <h4 class="text-dark display-4">Gestión de Preguntas Frecuentes</h4>
            <hr>
        </div>
        <div class="col-auto">
            <a href="index.php?vista=faq/cargarFaq" class="btn-cargar">
                <i class="bi bi-plus-circle"></i> Cargar
            </a>
        </div>
        <div class="col">
            <form class="d-flex" role="search" method="GET" action="index.php">
                <input type="hidden" name="vista" value="faq/faq">
                <input class="form-control me-2" name="buscar" type="search" placeholder="Buscar por código o palabras asociadas..." aria-label="Buscar" value="<?= htmlspecialchars($buscar) ?>" />
                <button class="btn-buscar" type="submit">
                    <i class="bi bi-search"></i>
                </button>
                <?php if ($buscar !== ''): ?>
                    <a href="index.php?vista=faq/faq" class="btn-cargar ms-2">Ver todas</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle shadow-sm">
            <thead class="encabezado-azul-institucional">
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
                        <td><?= htmlspecialchars($campos['pregunta']) ?></td>
                        <td><?= htmlspecialchars($campos['respuesta']) ?></td>
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
                                <a href="index.php?vista=faq/editarFaq&id=<?= $campos['faq_id'] ?>"
                                   class="btn-editar"
                                   data-bs-toggle="tooltip"
                                   data-bs-placement="top"
                                   title="Editar FAQ">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </div>

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
                                            ¿Estás segura de que querés eliminar la FAQ <strong>#<?= $campos['faq_id'] ?></strong>? Esta acción no se puede deshacer.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <a href="index.php?vista=faq/eliminarFaq&id=<?= $campos['faq_id'] ?>" class="btn btn-danger">Eliminar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php if ($total_paginas > 1): ?>
        <nav aria-label="Paginación de FAQ">
          <ul class="pagination justify-content-center mt-3">
            <li class="page-item <?= $pagina_actual <= 1 ? 'disabled' : '' ?>">
              <a class="page-link" href="index.php?vista=faq/faq&pagina=<?= $pagina_actual - 1 ?><?= $buscar ? '&buscar=' . urlencode($buscar) : '' ?>" aria-label="Anterior">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
              <li class="page-item <?= $i == $pagina_actual ? 'active' : '' ?>">
                <a class="page-link" href="index.php?vista=faq/faq&pagina=<?= $i ?><?= $buscar ? '&buscar=' . urlencode($buscar) : '' ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>
            <li class="page-item <?= $pagina_actual >= $total_paginas ? 'disabled' : '' ?>">
              <a class="page-link" href="index.php?vista=faq/faq&pagina=<?= $pagina_actual + 1 ?><?= $buscar ? '&buscar=' . urlencode($buscar) : '' ?>" aria-label="Siguiente">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach(t => new bootstrap.Tooltip(t));
    });
</script>
