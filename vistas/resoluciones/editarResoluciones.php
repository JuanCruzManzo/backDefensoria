<?php
include_once __DIR__ . "/../../conexion/parametros.php";
include_once __DIR__ . "/../../conexion/conexion.php";
include_once "../plantilla/head2.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id != 0) {
        $title = "Editar Resolución";

        $sql = "SELECT * FROM resoluciones WHERE resolucion_id = $id";
        $resultado = mysqli_query($link, $sql);
        $resolucion = mysqli_fetch_assoc($resultado);

        if (!$resolucion) {
            echo "<div class='alert alert-danger'>Resolución no encontrada.</div>";
            exit;
        }  
    } else {
    $title = "Agregar Resolución";    
    $resolucion = [
        'resolucion_id' => '',
        'Titulo' => '',
        'Anio' => '',
        'estado' => 1 
    ];
}

?>

<div class="container py-4">
    <h4 class="fw-bold text-dark mb-4"><?=$title?></h4>

    <form method="POST" action="index.php?vista=resoluciones/actualizarResoluciones">
        <input type="hidden" name="id" value="<?= $resolucion['resolucion_id'] ?>">

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($resolucion['Titulo']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Año</label>
            <input type="number" name="anio" class="form-control" value="<?= $resolucion['Anio'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">PDF</label>
            <input type="text" name="pdf" class="form-control" value="<?= $pdf ['pdf'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <option value="1" <?= $resolucion['estado'] == 1 ? 'selected' : '' ?>>Publicado</option>
                <option value="0" <?= $resolucion['estado'] == 0 ? 'selected' : '' ?>>No publicado</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Guardar cambios</button>
        <a href="index.php?vista=resoluciones/resoluciones" class="btn btn-secondary">Cancelar</a>

        <a href="index.php?vistas=resoluciones/editarResoluciones&id=<?= $row['resolucion_id'] ?>" class="btn btn-sm btn-outline-primary me-1">
    <i class="bi bi-pencil-square"></i>
</a>

    </form>
</div>
