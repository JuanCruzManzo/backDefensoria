<?php
include_once $_SERVER['DOCUMENT_ROOT'] .'/backDefensoria/parametros.php';
include(HEAD);
mysqli_set_charset($link, "utf8mb4");

// Tomamos lo que escribió el usuario
$buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

// Paginación
$por_pagina = 10;
$pagina_actual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$inicio = ($pagina_actual - 1) * $por_pagina;

// Total de resultados
$sql_total = "SELECT COUNT(*) FROM consultas";
if ($buscar !== '') {
    $buscar_esc = mysqli_real_escape_string($link, $buscar);
    $sql_total .= " WHERE consulta_id LIKE '%$buscar_esc%' 
                    OR comentario LIKE '%$buscar_esc%' 
                    OR tipo LIKE '%$buscar_esc%'
                    OR nombre LIKE '%$buscar_esc%'
                    OR email LIKE '%$buscar_esc%'
                    OR telefono LIKE '%$buscar_esc%'
                    OR apellido LIKE '%$buscar_esc%'";
}
$total_resultado = mysqli_fetch_row(mysqli_query($link, $sql_total))[0];
$total_paginas = ceil($total_resultado / $por_pagina);

// Consulta principal
$sql = "SELECT * FROM consultas";
if ($buscar !== '') {
    $sql .= " WHERE consulta_id LIKE '%$buscar_esc%' 
              OR comentario LIKE '%$buscar_esc%' 
              OR tipo LIKE '%$buscar_esc%'
              OR nombre LIKE '%$buscar_esc%'
              OR email LIKE '%$buscar_esc%'
              OR telefono LIKE '%$buscar_esc%'
              OR apellido LIKE '%$buscar_esc%'";
}
$sql .= " ORDER BY consulta_id ASC LIMIT $inicio, $por_pagina";
$items = mysqli_query($link, $sql);
?>

<div class="container main-admin py-4 px-3">
    <div class="row align-items-center mb-3">
        <div class="col-12 mb-3">
            <h4 class="text-dark display-4">Gestión de Consultas y Denuncias</h4>
            <hr>
        </div>
        <div class="col-12 col-md">
            <form class="row g-2" role="search" method="GET" action="index.php">
                <input type="hidden" name="vista" value="consultas/consultas">
                <div class="col-12 col-md-9">
                    <input class="form-control me-2" name="buscar" type="search" placeholder="Buscar por código o palabras asociadas..." aria-label="Buscar" value="<?= htmlspecialchars($buscar) ?>" />
                </div>
                <div class="col-12 col-md-3 d-flex gap-2">
                    <button class="btn-buscar w-100" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    <?php if ($buscar !== ''): ?>
                        <a href="index.php?vista=consultas/consultas" class="btn-cargar w-100">Ver todas</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle shadow-sm text-center">
            <thead class="encabezado-azul-institucional">
                <tr class="align-middle">
                    <th scope="col">Cod.</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Mensaje</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($campos = mysqli_fetch_array($items)) { ?>
                    <tr>
                        <td class="text-center fw-bold"><?= $campos['consulta_id'] ?></td>
                        <td><?= htmlspecialchars($campos['nombre']) ?></td>
                        <td><?= htmlspecialchars($campos['apellido']) ?></td>
                        <td><?= htmlspecialchars($campos['tipo']) ?></td>
                        <td><?= htmlspecialchars($campos['telefono']) ?></td>
                        <td><?= htmlspecialchars($campos['comentario']) ?></td>
                        <td><?= htmlspecialchars($campos['email']) ?></td>
                        <td class="text-center">
                            <div class="btn-group d-flex justify-content-center gap-2" role="group">
                                <button class="btn-enviar-correo btn-editar btn btn-sm" data-id="<?= $campos['consulta_id'] ?>" title="Enviar correo de confirmación">
                                    <i class="bi bi-send-fill"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php if ($total_paginas > 1): ?>
            <nav aria-label="Paginación de consultas">
                <ul class="pagination justify-content-center mt-3">
                    <li class="page-item <?= $pagina_actual <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="index.php?vista=consultas/consultas&pagina=<?= $pagina_actual - 1 ?><?= $buscar ? '&buscar=' . urlencode($buscar) : '' ?>" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <li class="page-item <?= $i == $pagina_actual ? 'active' : '' ?>">
                            <a class="page-link" href="index.php?vista=consultas/consultas&pagina=<?= $i ?><?= $buscar ? '&buscar=' . urlencode($buscar) : '' ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $pagina_actual >= $total_paginas ? 'disabled' : '' ?>">
                        <a class="page-link" href="index.php?vista=consultas/consultas&pagina=<?= $pagina_actual + 1 ?><?= $buscar ? '&buscar=' . urlencode($buscar) : '' ?>" aria-label="Siguiente">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>

<!-- Modal de envío de correo -->
<div class="modal fade" id="correoModal" tabindex="-1" aria-labelledby="correoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="correoModalLabel">Enviando correo...</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body d-flex justify-content-center align-items-center" id="correoModalBody">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
            </div>
            <div class="modal-footer" id="correoModalFooter" style="display:none;">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = new bootstrap.Modal(document.getElementById('correoModal'));
        const modalBody = document.getElementById('correoModalBody');
        const modalFooter = document.getElementById('correoModalFooter');
        const modalTitle = document.getElementById('correoModalLabel');

        document.querySelectorAll('.btn-enviar-correo').forEach(btn => {
            btn.addEventListener('click', function() {
                const consultaId = this.getAttribute('data-id');

                // Mostrar modal con spinner
                modalTitle.textContent = 'Enviando correo...';
                modalBody.innerHTML = `<div class="spinner-border text-primary" role="status">
                                      <span class="visually-hidden">Cargando...</span>
                                  </div>`;
                modalFooter.style.display = 'none';
                modal.show();

                fetch('../vistas/consultas/enviar_mail.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: consultaId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        modalTitle.textContent = data.status === 'ok' ? 'Éxito' : 'Error';
                        modalBody.textContent = data.message;
                        modalFooter.style.display = 'block';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        modalTitle.textContent = 'Error';
                        modalBody.textContent = 'Ocurrió un error al enviar el correo.';
                        modalFooter.style.display = 'block';
                    });
            });
        });
    });
</script>