<?php
include_once $_SERVER['DOCUMENT_ROOT'] .'/backDefensoria/parametros.php';
include(CONEXION);
include(FUNCIONES);
include(HEAD);  

$id_memoria = isset($_GET['id']) ? intval($_GET['id']) : 0;
$editando = false;
$datos = [
    'titulo' => '',
    'sub_titulo' => '',
    'fecha_creacion' => '',
    'estado' => 1,
    'fecha_publicacion' => '',
    'archivo' => ''
];
if ($id_memoria > 0) {
    $sql = "SELECT * FROM memorias WHERE memoria_id = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_memoria);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($res)) {
        $datos = $row;
        $editando = true;
    }
    mysqli_stmt_close($stmt);
}
$title_memoria = $editando ? "Editar Memoria" : "Crear Memoria";
?>
<div class="container">
    <div class="row">
        <div class="col">
            <div>
                <h3 class="display-2"><?=$title_memoria?></h3>
            </div>
            <div class="col">
                <form action="index.php?vista=noticias/procesarMemoria" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="memoria_id" value="<?= $editando ? $id_memoria : '' ?>">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required maxlength="30" value="<?= htmlspecialchars($datos['titulo']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="sub_titulo" class="form-label">Sub-título</label>
                        <input type="text" class="form-control" id="sub_titulo" name="sub_titulo" required maxlength="50" value="<?= htmlspecialchars($datos['sub_titulo']) ?>">
                    </div>
                    <?php if ($editando): ?>
                    <div class="mb-3">
                        <label class="form-label">Fecha de creación</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($datos['fecha_creacion']) ?>" readonly>
                    </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="1" <?= $datos['estado'] == 1 ? 'selected' : '' ?>>Activo</option>
                            <option value="0" <?= $datos['estado'] == 0 ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_publicacion" class="form-label">Fecha de publicación</label>
                        <input type="date" class="form-control" id="fecha_publicacion" name="fecha_publicacion" required value="<?= $datos['fecha_publicacion'] ? date('Y-m-d', strtotime($datos['fecha_publicacion'])) : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="archivo" class="form-label">Archivo PDF</label>
                        <input type="file" class="form-control" id="archivo" name="archivo" accept="application/pdf" <?= $editando ? '' : 'required' ?> >
                        <?php if ($editando && $datos['archivo']): ?>
                            <div class="mt-2">
                                <span class="text-muted">Archivo actual:</span>
                                <a href="../../documentos/<?= urlencode($datos['archivo']) ?>" target="_blank">
                                    <?= htmlspecialchars($datos['archivo']) ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn-cargar"><?= $editando ? 'Actualizar Memoria' : 'Cargar Memoria' ?></button>
                    <a href="index.php?vista=noticias/noticias" class="btn btn-secondary ms-2">Volver</a>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
