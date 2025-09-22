<?php
include_once "../plantilla/head2.php";
mysqli_set_charset($link, "utf8mb4");

// Tomamos lo que escribió el usuario
$buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

if ($buscar !== '') {
    // Escapar caracteres peligrosos
    $buscar = mysqli_real_escape_string($link, $buscar);

    $sql = "SELECT * FROM resenas 
            WHERE resena_id LIKE '%$buscar%' 
                OR resena LIKE '%$buscar%'               
                OR fecha LIKE '%$buscar%'               
                ORDER BY resena_id DESC";
} else {
    $sql = "SELECT * FROM resenas ORDER BY resena_id DESC";
}

$items = mysqli_query($link, $sql);
?>

<div class="container main-admin py-4 px-3">
    <div class="row align-items-center mb-3">
        <div class="col-12 mb-3">
            <h4 class="text-dark display-4">Gestión de Reseñas</h4>
            <hr>
        </div>
        <div class="col-12 col-md">
            <form class="row g-2" role="search" method="GET" action="">
                <input type="hidden" name="vista" value="resenas/resenas">
                <div class="col-12 col-md-9">
                    <input class="form-control me-2" name="buscar" type="search" placeholder="Buscar por código o palabras asociadas..." aria-label="Buscar" />
                </div>
                <div class="col-12 col-md-3">
                    <button class="btn-buscar" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
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
                        <td><?= $campos['resena'] ?></td>                        
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
                                <input type="checkbox" class="toggle-estado" data-id="<?= $campos['resena_id'] ?>" <?php if($campos['estado'] == 1) echo "checked"; ?>>
                                <div class="slider">
                                    <div class="circle">                                        
                                        <svg class="cross" viewBox="0 0 365.696 365.696" height="6" width="6" xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <path fill="currentColor" d="M243.188 182.86 356.32 69.726c12.5-12.5 12.5-32.766 0-45.247L341.238 9.398c-12.504-12.503-32.77-12.503-45.25 0L182.86 122.528 69.727 9.374c-12.5-12.5-32.766-12.5-45.247 0L9.375 24.457c-12.5 12.504-12.5 32.77 0 45.25l113.152 113.152L9.398 295.99c-12.503 12.503-12.503 32.769 0 45.25L24.48 356.32c12.5 12.5 32.766 12.5 45.247 0l113.132-113.132L295.99 356.32c12.503 12.5 32.769 12.5 45.25 0l15.081-15.082c12.5-12.504 12.5-32.77 0-45.25z"></path>
                                            </g>
                                        </svg>                                        
                                        <svg class="checkmark" viewBox="0 0 24 24" height="10" width="10" xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <path fill="currentColor" d="M9.707 19.121a.997.997 0 0 1-1.414 0l-5.646-5.647a1.5 1.5 0 0 1 0-2.121l.707-.707a1.5 1.5 0 0 1 2.121 0L9 14.171l9.525-9.525a1.5 1.5 0 0 1 2.121 0l.707.707a1.5 1.5 0 0 1 0 2.121z"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $(".toggle-estado").change(function() {
        let checkbox = $(this);
        let id = checkbox.data("id");
        let nuevoEstado = checkbox.is(":checked") ? 1 : 0;

        $.ajax({
            url: "../vistas/resenas/update_estado.php",
            type: "POST",
            data: { id: id, estado: nuevoEstado },
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