<?php
    include_once "../plantilla/head2.php";
    mysqli_set_charset($link, "utf8mb4");

    // Obtener término de búsqueda
    $busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

    // Consulta con filtro si hay búsqueda
    if ($busqueda !== '') {
        $busqueda_esc = mysqli_real_escape_string($link, $busqueda);
        $sql = "SELECT noticia_id, autor, titulo, fecha_creacion, estado FROM noticias 
                WHERE noticia_id = '$busqueda_esc'
                OR titulo LIKE '%$busqueda_esc%'
                OR autor LIKE '%$busqueda_esc%'";
    } else {
        $sql = "SELECT noticia_id, autor, titulo, fecha_creacion, estado FROM noticias";
    }
    $items = mysqli_query($link, $sql);
?>
<div class="container">
    <div class="row">
        <h4 class="text-dark display-4">Gestión de Noticias</h4>
        <div class="col">
            <br>
            <a href="index.php?vista=noticias/cargarNoticia" class="btn btn-success"> <i class="bi bi-plus-circle"></i>&nbsp;Cargar</a>
        </div>
        <div class="col">
            <br>
            <form class="d-flex" role="search" method="GET" action="">
                <input type="hidden" name="vista" value="noticias/noticias" />
                <input class="form-control me-2" type="search" name="busqueda" placeholder="Buscar por ID, título o autor" aria-label="Search" value="<?= htmlspecialchars($busqueda) ?>" />
                <button class="btn btn-outline-success me-2" type="submit">Buscar</button>
                <?php if ($busqueda !== ''): ?>
                    <a href="index.php?vista=noticias/noticias" class="btn btn-outline-secondary">Ver todas</a>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <br>
            <table class="table table-hover table-bordered align-middle shadow-sm">
                <thead class="table-success text-center">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Autor</th>
                        <th scope="col">Fecha de publicación</th>
                        <th scope="col">¿Publicado?</th>
                        <th scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody>                    
                    <?php while ($campos = mysqli_fetch_array($items)) { ?>
                    <tr>
                        <td class="text-center fw-bold"><?= $campos['noticia_id'] ?></td>
                        <td><?= $campos['titulo'] ?></td>
                        <td><?= $campos['autor'] ?></td>
                        <td><?= $campos['fecha_creacion'] ?></td>            
                        <td class="text-center">
                            <?php if ($campos['estado'] == 1): ?>
                                <span class="badge rounded-pill bg-success p-2">
                                    <i class="bi bi-check-circle-fill"></i> Si
                                </span>
                            <?php else: ?>
                                <span class="badge rounded-pill bg-danger p-2">
                                    <i class="bi bi-x-circle-fill"></i> No
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="index.php?vista=noticias/cargarNoticia&id=<?= $campos['noticia_id'] ?>" class="btn btn-primary">Editar</a>                    
                        </td>                        
                    </tr>
                <?php } ?>               
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>