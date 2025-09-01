<?php
include_once "../plantilla/head2.php";
mysqli_set_charset($link, "utf8mb4");

// Tomamos lo que escribió el usuario
$buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

if ($buscar !== '') {
    // Escapar caracteres peligrosos
    $buscar = mysqli_real_escape_string($link, $buscar);

    $sql = "SELECT * FROM noticias 
            WHERE noticia_id LIKE '%$buscar%' 
               OR titulo LIKE '%$buscar%'
               OR autor LIKE '%$buscar%'                
               OR contenido LIKE '%$buscar%'";
} else {
    $sql = "SELECT noticia_id, autor, titulo, fecha_publicacion, estado FROM noticias";
}

$items = mysqli_query($link, $sql);
?>

<div class="container mt-4">
    <div class="row align-items-center mb-3">
        <div class="col-12 mb-3">
            <h4 class="text-dark display-4">Gestión de Noticias</h4>
        </div>
        <div class="col-auto">
            <a href="index.php?vista=noticias/cargarNoticia" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Cargar
            </a>
        </div>
        <div class="col">
            <form class="d-flex" role="search" method="GET" action="">
                <input type="hidden" name="vista" value="noticias/noticias">
                <input class="form-control me-2" name="buscar" type="search" placeholder="Buscar por código, título o autor..." aria-label="Buscar" />
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
                        <td><?= $campos['titulo'] ?></td>
                        <td><?= $campos['autor'] ?></td>
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
                                   class="btn btn-sm btn-primary"
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
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>