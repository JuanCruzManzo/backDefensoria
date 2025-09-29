<?php
include_once $_SERVER['DOCUMENT_ROOT'] .'/backDefensoria/parametros.php';
include(CONEXION);
include(HEAD);

$exito = isset($_GET['exito']) ? intval($_GET['exito']) : 0;
$memoria_id_destacada = isset($_GET['memoria_id']) ? intval($_GET['memoria_id']) : 0;

$sql = "SELECT memoria_id, titulo, sub_titulo, archivo, estado, fecha_creacion, fecha_publicacion FROM memorias ORDER BY fecha_publicacion DESC";
$result = mysqli_query($link, $sql);
?>
<div class="container">
    <div class="row mb-3">
        <h4 class="text-dark display-4">Gestión de Memorias</h4>
        <hr>
        <div class="col-md-6">
            <br>
            <a href="index.php?vista=noticias/cargarMemoria" class="btn-cargar"> <i class="bi bi-plus-circle"></i>&nbsp;Cargar Memoria</a>
            <a href="index.php?vista=noticias/noticias" class="btn-cargar"> <i class="bi bi-collection"></i>&nbsp;Volver a Noticias</a>
        </div>
    </div>
    <?php if ($exito): ?>
        <div class="alert alert-success">Memoria cargada/actualizada correctamente.</div>
    <?php endif; ?>
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle shadow-sm">
            <thead class="encabezado-azul-institucional">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Título</th>
                    <th scope="col">Sub-título</th>
                    <th scope="col">Fecha de creación</th>
                    <th scope="col">Fecha de publicación</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Archivo</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($memoria = mysqli_fetch_array($result)) { ?>
                    <tr<?= ($memoria_id_destacada && $memoria['memoria_id'] == $memoria_id_destacada) ? ' class="table-success"' : '' ?>>
                        <td class="text-center fw-bold"><?= $memoria['memoria_id'] ?></td>
                        <td><?= htmlspecialchars($memoria['titulo']) ?></td>
                        <td><?= htmlspecialchars($memoria['sub_titulo']) ?></td>
                        <td><?= date('Y-m-d H:i', strtotime($memoria['fecha_creacion'])) ?></td>
                        <td><?= date('Y-m-d', strtotime($memoria['fecha_publicacion'])) ?></td>
                        <td class="text-center">
                            <?php if ($memoria['estado'] == 1): ?>
                                <span class="badge rounded-pill bg-success p-2">Activo</span>
                            <?php else: ?>
                                <span class="badge rounded-pill bg-danger p-2">Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if (!empty($memoria['archivo'])): ?>
                                <a href="/<?= $memoria['archivo'] ?>" target="_blank"
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
                                <a href="index.php?vista=noticias/cargarMemoria&id=<?= $memoria['memoria_id'] ?>"
                                    class="btn-editar"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Editar memoria">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>