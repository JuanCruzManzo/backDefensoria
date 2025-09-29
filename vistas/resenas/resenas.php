<?php
include_once "../plantilla/head2.php";
mysqli_set_charset($link, "utf8mb4");

$buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

// Paginación
$por_pagina = 6;
$pagina_actual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$inicio = ($pagina_actual - 1) * $por_pagina;

// Total de resultados
$sql_total = "SELECT COUNT(*) FROM resenas";
if ($buscar !== '') {
    $buscar_esc = mysqli_real_escape_string($link, $buscar);
    $sql_total .= " WHERE resena_id LIKE '%$buscar_esc%' 
                    OR resena LIKE '%$buscar_esc%' 
                    OR fecha LIKE '%$buscar_esc%'";
}
$total_resultado = mysqli_fetch_row(mysqli_query($link, $sql_total))[0];
$total_paginas = ceil($total_resultado / $por_pagina);

// Consulta principal
$sql = "SELECT * FROM resenas";
if ($buscar !== '') {
    $sql .= " WHERE resena_id LIKE '%$buscar_esc%' 
              OR resena LIKE '%$buscar_esc%' 
              OR fecha LIKE '%$buscar_esc%'";
}
$sql .= " ORDER BY resena_id DESC LIMIT $inicio, $por_pagina";
$items = mysqli_query($link, $sql);
?>

<div class="container main-admin py-4 px-3">
    <div class="row align-items-center mb-3">
        <div class="col-12 mb-3">
            <h4 class="text-dark display-4">Gestión de Reseñas</h4>
            <hr>
        </div>
        <div class="col-12 col-md">
            <form class="row g-2" role="search" method="GET" action="index.php">
                <input type="hidden" name="vista" value="resenas/resenas">
                <div class="col-12 col-md-9">
                    <input class="form-control me-2" name="buscar" type="search" placeholder="Buscar por código o palabras asociadas..." aria-label="Buscar" value="<?= htmlspecialchars($buscar) ?>" />
                </div>
                <div class="col-12 col-md-3 d-flex gap-2">
                    <button class="btn-buscar w-100" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    <?php if ($buscar !== ''): ?>
                        <a href="index.php?vista=resenas/resenas" class="btn-cargar w-100">Ver todas</a>
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
                    <th scope="col">Fecha</th>
                    <th scope="col">Reseña</th>
                    <th scope="col">Estado</th>
                    <th scope="col">¿Mostrar?</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($campos = mysqli_fetch_array($items)) { ?>
                    <tr>
                        <td class="text-center fw-bold"><?= $campos['resena_id'] ?></td>
                        <td><?= $campos['fecha'] ?></td>
                        <?php
                        $resena = $campos['resena'];
                        $resumen = mb_strimwidth($resena, 0, 60, '...');
                        ?>
                        <td class="text-center">
                            <button type="button"
                                class="btn btn-sm btn-institucional-outline"
                                data-bs-toggle="modal"
                                data-bs-target="#modalResena"
                                data-resena="<?= htmlspecialchars($resena) ?>">
                                📝 <?= $resumen ?> <span class="text-decoration-underline">Ver más</span>
                            </button>
                        </td>
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
                            <label class="switch">
                                <input type="checkbox" class="toggle-estado" data-id="<?= $campos['resena_id'] ?>" <?php if ($campos['estado'] == 1) echo "checked"; ?>>
                                <div class="slider">
                                    <div class="circle">
                                        <!-- Íconos SVG -->
                                        <svg class="cross" viewBox="0 0 365.696 365.696" height="6" width="6" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="..."/></svg>
                                        <svg class="checkmark" viewBox="0 0 24 24" height="10" width="10" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="..."/></svg>
                                    </div>
                                </div>
                            </label>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php if ($total_paginas > 1): ?>
        <nav aria-label="Paginación de reseñas">
          <ul class="pagination justify-content-center mt-3">
            <li class="page-item <?= $pagina_actual <= 1 ? 'disabled' : '' ?>">
              <a class="page-link" href="index.php?vista=resenas/resenas&pagina=<?= $pagina_actual - 1 ?><?= $buscar ? '&buscar=' . urlencode($buscar) : '' ?>" aria-label="Anterior">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
              <li class="page-item <?= $i == $pagina_actual ? 'active' : '' ?>">
                <a class="page-link" href="index.php?vista=resenas/resenas&pagina=<?= $i ?><?= $buscar ? '&buscar=' . urlencode($buscar) : '' ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>
            <li class="page-item <?= $pagina_actual >= $total_paginas ? 'disabled' : '' ?>">
              <a class="page-link" href="index.php?vista=resenas/resenas&pagina=<?= $pagina_actual + 1 ?><?= $buscar ? '&buscar=' . urlencode($buscar) : '' ?>" aria-label="Siguiente">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
        <?php endif; ?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalResena" tabindex="-1" aria-labelledby="modalResenaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-institucional">
                    <h5 class="modal-title" id="modalResenaLabel">Reseña</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <pre id="contenidoResena" class="mb-0" style="white-space: pre-wrap; word-break: break-word;"></pre>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $(".toggle-estado").change(function() {
            let checkbox = $(this);
            let id = checkbox.data("id");
            let nuevoEstado = checkbox.is(":checked") ? 1 : 0;

            $.ajax({
                url: "../vistas/resenas/update_estado.php",
                type: "POST",
                data: {
                    id: id,
                    estado: nuevoEstado
                },
                success: function(response) {
                    console.log("Estado actualizado a: " + nuevoEstado);

                    // Actualizar la columna de Estado en tiempo real
                    let tdEstado = checkbox.closest("tr").find("td").eq(3); // columna 4 (Estado)

                    if (nuevoEstado == 1) {
                        tdEstado.html('<span class="badge rounded-pill bg-success p-2"><i class="bi bi-check-circle-fill"></i> Activa</span>');
                    } else {
                        tdEstado.html('<span class="badge rounded-pill bg-secondary p-2"><i class="bi bi-x-circle-fill"></i> Inactiva</span>');
                    }
                },
                error: function() {
                    alert("Error al actualizar el estado.");
                    // revertir el cambio visual del toggle
                    checkbox.prop("checked", !nuevoEstado);
                }
            });
        });
    });
</script>
<!--Script para el modal del campo reseña-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById("modalResena");
        const contenido = document.getElementById("contenidoResena");

        modal.addEventListener("show.bs.modal", function(event) {
            const boton = event.relatedTarget;
            const texto = boton.getAttribute("data-resena");
            contenido.textContent = texto;
        });
    });
</script>