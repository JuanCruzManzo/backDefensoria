<?php
include_once __DIR__ . "/../../conexion/parametros.php";
include_once __DIR__ . "/../../conexion/conexion.php";
include_once "../plantilla/head2.php";

$anio = isset($_GET['anio']) ? $_GET['anio'] : '';
$sql = "SELECT * FROM resoluciones";
if (!empty($anio)) {
    $sql .= " WHERE Anio = '$anio'";
}
$sql .= " ORDER BY Anio DESC";
$resultado = mysqli_query($link, $sql);

?>

<div class="container py-4">
    <div class="row align-items-center mb-3">
        <div class="col-12 mb-3">
            <h4 class="fw-bold text-dark">Gestión de Resoluciones</h4>
        </div>
        <div class="col-auto">
            <a href="cargar_resolucion.php" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Cargar
            </a>
        </div>
        <div class="col">
            <form class="d-flex" method="GET" action="">
                <input type="hidden" name="vista" value="resoluciones/resoluciones">
                <input class="form-control me-2" name="anio" type="search" placeholder="Buscar por año..." aria-label="Buscar por año" />
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
                    <th scope="col">Título</th>
                    <th scope="col">Año</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td class="text-center fw-bold"><?= $row['resolucion_id'] ?></td>
                        <td><?= $row['Titulo'] ?></td>
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
                            <a href="editar_resolucion.php?id=<?= $row['resolucion_id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>