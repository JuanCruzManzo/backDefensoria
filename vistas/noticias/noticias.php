<?php
include_once "../plantilla/head2.php";
mysqli_set_charset($link, "utf8mb4");

// Obtener término de búsqueda
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

// Paginación
$por_pagina = 6;
$pagina_actual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$inicio = ($pagina_actual - 1) * $por_pagina;

// Contar total de resultados
$sql_total = "SELECT COUNT(*) FROM noticias";
if ($busqueda !== '') {
    $busqueda_esc = mysqli_real_escape_string($link, $busqueda);
    $sql_total .= " WHERE noticia_id = '$busqueda_esc'
                    OR titulo LIKE '%$busqueda_esc%'
                    OR autor LIKE '%$busqueda_esc%'";
}
$total_resultado = mysqli_fetch_row(mysqli_query($link, $sql_total))[0];
$total_paginas = ceil($total_resultado / $por_pagina);

// Consulta principal
$sql = "SELECT noticia_id, autor, titulo, fecha_creacion, fecha_publicacion, estado FROM noticias";
if ($busqueda !== '') {
    $sql .= " WHERE noticia_id = '$busqueda_esc'
              OR titulo LIKE '%$busqueda_esc%'
              OR autor LIKE '%$busqueda_esc%'";
}
$sql .= " ORDER BY fecha_publicacion DESC LIMIT $inicio, $por_pagina";
$items = mysqli_query($link, $sql);
?>

<div class="container main-admin">
    <div class="row mb-3">
        <h4 class="text-dark display-4">Gestión de Noticias</h4>
        <hr>
        <div class="col-md-6 d-flex gap-2 flex-wrap align-items-center">
            <a href="index.php?vista=noticias/cargarNoticia" class="btn-cargar-noticias">
                <i class="bi bi-plus-circle"></i> Cargar Noticia
            </a>
            <a href="index.php?vista=noticias/cargarMemoria" class="btn-cargar-noticias">
                <i class="bi bi-plus-circle"></i> Cargar Memoria
            </a>
            <a href="index.php?vista=noticias/verMemorias" class="btn-cargar-noticias">
                <i class="bi bi-collection"></i> Ver Memorias
            </a>
        </div>
        <div class="col-md-6">
            <form class="d-flex" role="search" method="GET" action="index.php">
                <input type="hidden" name="vista" value="noticias/noticias" />
                <input class="form-control me-2" type="search" name="busqueda" placeholder="Buscar por ID, título o autor" aria-label="Search" value="<?= htmlspecialchars($busqueda) ?>" />
                <button class="btn-buscar" type="submit">Buscar</button>
                <?php if ($busqueda !== ''): ?>
                    <a href="index.php?vista=noticias/noticias" class="btn-cargar ms-2">Ver todas</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle shadow-sm">
            <thead class="encabezado-azul-institucional">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Título</th>
                    <th scope="col">Autor</th>
                    <th scope="col">Fecha de publicación</th>
                    <th scope="col">¿Publicado?</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($campos = mysqli_fetch_array($items)) { ?>
                    <tr>
                        <td class="text-center fw-bold"><?= $campos['noticia_id'] ?></td>
                        <td><?= htmlspecialchars($campos['titulo']) ?></td>
                        <td><?= htmlspecialchars($campos['autor']) ?></td>
                        <td><?= date('Y-m-d H:i', strtotime($campos['fecha_publicacion'])) ?></td>
                        <td class="text-center">
                            <?php if ($campos['estado'] == 1): ?>
                                <span class="badge rounded-pill bg-success p-2">
                                    <i class="bi bi-check-circle-fill"></i> Sí
                                </span>
                            <?php else: ?>
                                <span class="badge rounded-pill bg-danger p-2">
                                    <i class="bi bi-x-circle-fill"></i> No
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="index.php?vista=noticias/cargarNoticia&id=<?= $campos['noticia_id'] ?>"
                                    class="btn-editar"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Editar noticia">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php if ($total_paginas > 1): ?>
            <nav aria-label="Paginación de noticias">
                <ul class="pagination justify-content-center mt-3">
                    <li class="page-item <?= $pagina_actual <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="index.php?vista=noticias/noticias&pagina=<?= $pagina_actual - 1 ?><?= $busqueda ? '&busqueda=' . urlencode($busqueda) : '' ?>" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <li class="page-item <?= $i == $pagina_actual ? 'active' : '' ?>">
                            <a class="page-link" href="index.php?vista=noticias/noticias&pagina=<?= $i ?><?= $busqueda ? '&busqueda=' . urlencode($busqueda) : '' ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $pagina_actual >= $total_paginas ? 'disabled' : '' ?>">
                        <a class="page-link" href="index.php?vista=noticias/noticias&pagina=<?= $pagina_actual + 1 ?><?= $busqueda ? '&busqueda=' . urlencode($busqueda) : '' ?>" aria-label="Siguiente">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>

        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>