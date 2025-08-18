<?php
include_once __DIR__ . "/../../conexion/parametros.php";
include_once __DIR__ . "/../../conexion/conexion.php";
include_once "../plantilla/head2.php";

$sql = "SELECT * FROM resoluciones ORDER BY Anio DESC";
$resultado = mysqli_query($link, $sql);
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary">Gestión de Resoluciones</h3>
        <a href="cargar_resolucion.php" class="btn btn-success"><i class="bi bi-plus-circle me-2"></i> Cargar nueva</a>
    </div>

    <form class="input-group mb-4" method="GET" action="">
        <input class="form-control" name="anio" type="search" placeholder="Buscar por año..." aria-label="Buscar por año">
        <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i> Buscar</button>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Cod.</th>
                    <th>Título</th>
                    <th>Año</th>
                    <th>Estado</th>
                    <th>Pdf</th>
                    <th>Auditoría</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?= $row['resolucion_id'] ?></td>
                        <td><strong><?= $row['Titulo'] ?></strong></td>
                        <td><?= $row['Anio'] ?></td>
                        <td>
                            <span class="badge <?= $row['estado'] == 1 ? 'bg-success' : 'bg-secondary' ?>">
                                <?= $row['estado'] == 1 ? 'Publicado' : 'No publicado' ?>
                            </span>
                        </td>
                        <td>
                            <a href="../pdfs/<?= $row['pdf'] ?>" target="_blank" class="btn btn-sm btn-outline-dark">
                                <i class="bi bi-file-earmark-pdf"></i> Ver PDF
                            </a>
                        </td>
                        <td><?= $row['auditoria_id'] ?></td>
                        <td class="text-center">
                            <a href="editar_resolucion.php?id=<?= $row['resolucion_id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="eliminar_resolucion.php?id=<?= $row['resolucion_id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar esta resolución?')">
                                <i class="bi bi-trash"></i>
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