<?php
include_once $_SERVER['DOCUMENT_ROOT'] .'/backDefensoria/parametros.php';
include(CONEXION);
include(FUNCIONES);
include(HEAD);
mysqli_set_charset($link, "utf8mb4");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Buscar FAQ
$sql = "SELECT * FROM faq WHERE faq_id = $id";
$res = mysqli_query($link, $sql);
$faq = mysqli_fetch_assoc($res);
?>

<div class="container mt-4">
    <h2>Editar FAQ</h2>
    <form method="POST" action="index.php?vista=faq/actualizarFaq">
        <input type="hidden" name="faq_id" value="<?= $faq['faq_id'] ?>">

        <div class="mb-3">
            <label class="form-label">Pregunta</label>
            <textarea name="pregunta" class="form-control" rows="3" required><?= $faq['pregunta'] ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Respuesta</label>
            <textarea name="respuesta" class="form-control" rows="5" required><?= $faq['respuesta'] ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <option value="1" <?= $faq['estado']==1?'selected':'' ?>>Activa</option>
                <option value="0" <?= $faq['estado']==0?'selected':'' ?>>Inactiva</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar cambios</button>
        <a href="index.php?vista=faq/faq" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
