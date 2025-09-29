<?php
include_once $_SERVER['DOCUMENT_ROOT'] .'/backDefensoria/parametros.php';
include(CONEXION);
include(HEAD);
include(FUNCIONES);

// Filtro por año
$anio = isset($_GET['anio']) ? trim($_GET['anio']) : '';

// Paginación
$por_pagina = 6;
$pagina_actual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$inicio = ($pagina_actual - 1) * $por_pagina;

// Total de resultados
$sql_total = "SELECT COUNT(*) FROM resoluciones";
if ($anio !== '') {
    $sql_total .= " WHERE Anio = '$anio'";
}
$total_resultado = mysqli_fetch_row(mysqli_query($link, $sql_total))[0];
$total_paginas = ceil($total_resultado / $por_pagina);

// Consulta principal
$sql = "SELECT * FROM resoluciones";
if ($anio !== '') {
    $sql .= " WHERE Anio = '$anio'";
}
$sql .= " ORDER BY resolucion_id ASC LIMIT $inicio, $por_pagina";
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
            <form class="d-flex" method="GET" action="index.php">
                <input type="hidden" name="vista" value="resoluciones/resoluciones">
                <input class="form-control me-2" name="anio" type="search" placeholder="Buscar por año..." aria-label="Buscar por año" value="<?= htmlspecialchars($anio) ?>" />
                <button class="btn-buscar" type="submit">
                    <i class="bi bi-search"></i>
                </button>
                <?php if ($anio !== ''): ?>
                    <a href="index.php?vista=resoluciones/resoluciones" class="btn-cargar ms-2">Ver todas</a>
                <?php endif; ?>
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
                        <td><?= htmlspecialchars($row['Titulo']) ?></td>
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

        <?php if ($total_paginas > 1): ?>
            <nav aria-label="Paginación de resoluciones">
                <ul class="pagination justify-content-center mt-3">
                    <li class="page-item <?= $pagina_actual <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="index.php?vista=resoluciones/resoluciones&pagina=<?= $pagina_actual - 1 ?><?= $anio ? '&anio=' . urlencode($anio) : '' ?>" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <li class="page-item <?= $i == $pagina_actual ? 'active' : '' ?>">
                            <a class="page-link" href="index.php?vista=resoluciones/resoluciones&pagina=<?= $i ?><?= $anio ? '&anio=' . urlencode($anio) : '' ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $pagina_actual >= $total_paginas ? 'disabled' : '' ?>">
                        <a class="page-link" href="index.php?vista=resoluciones/resoluciones&pagina=<?= $pagina_actual + 1 ?><?= $anio ? '&anio=' . urlencode($anio) : '' ?>" aria-label="Siguiente">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach(t => new bootstrap.Tooltip(t));
    });
</script>

</html>