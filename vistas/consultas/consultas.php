<?php
include_once "../plantilla/head2.php";
mysqli_set_charset($link, "utf8mb4");

// Tomamos lo que escribió el usuario
$buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

if ($buscar !== '') {
    // Escapar caracteres peligrosos
    $buscar = mysqli_real_escape_string($link, $buscar);

    $sql = "SELECT * FROM consultas 
            WHERE consulta_id LIKE '%$buscar%' 
               OR comentario LIKE '%$buscar%' 
               OR tipo LIKE '%$buscar%'
               OR nombre LIKE '%$buscar%'
               OR email LIKE '%$buscar%'
               OR telefono LIKE '%$buscar%'
               OR apellido LIKE '%$buscar%'
               ORDER BY consulta_id ASC";
} else {
    $sql = "SELECT * FROM consultas ORDER BY consulta_id ASC";
}

$items = mysqli_query($link, $sql);
?>

<div class="container main-admin">
    <div class="row align-items-center mb-3">
        <div class="col-12 mb-3">
            <h4 class="text-dark display-4">Gestión de Consultas y Denuncias</h4>
            <hr>
        </div>
        <div class="col">
            <form class="d-flex" role="search" method="GET" action="">
                <input type="hidden" name="vista" value="consultas/consultas">
                <input class="form-control me-2" name="buscar" type="search" placeholder="Buscar por código o palabras asociadas..." aria-label="Buscar" />
                <button class="btn-buscar" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle shadow-sm">
            <thead class="encabezado-tabla text-white text-center">
                <tr>
                    <th scope="col">Cod.</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Tipo</th>                    
                    <th scope="col">Telefono</th>
                    <th scope="col">Mensaje</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($campos = mysqli_fetch_array($items)) { ?>
                    <tr>
                        <td class="text-center fw-bold"><?= $campos['consulta_id'] ?></td>
                        <td><?= $campos['nombre'] ?></td>
                        <td><?= $campos['apellido'] ?></td>
                        <td><?= $campos['tipo'] ?></td>                    
                        <td><?= $campos['telefono'] ?></td>
                        <td><?= $campos['comentario'] ?></td>
                        <td><?= $campos['email'] ?></td>
                        
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <!-- Botón editar -->
                                <a href="index.php?vista=faq/editarFaq&id=<?= $campos['consulta_id'] ?>"
                                    class="btn-editar"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Enviar Correo de Reseña">
                                    <i class="bi bi-send-fill"></i>
                                </a>
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