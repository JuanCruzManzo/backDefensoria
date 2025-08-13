<?php
include_once "../plantilla/head2.php";
mysqli_set_charset($link, "utf8mb4");

// Validar y obtener el ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id = intval($_GET['id']);

// Consultar la FAQ
$sql = "SELECT * FROM faq WHERE faq_id = $id";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) == 0) {
    die("No se encontró la FAQ.");
}

$faq = mysqli_fetch_assoc($result);
?>

<div class="container mt-4">
    <h2>Editar FAQ</h2>
    <form action="actualizarFaq.php" method="POST">
        <input type="hidden" name="faq_id" value="<?= $faq['faq_id'] ?>">

        <div class="mb-3">
            <label for="pregunta" class="form-label">Pregunta</label>
            <input type="text" class="form-control" id="pregunta" name="pregunta"
                   value="<?= htmlspecialchars($faq['pregunta']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="respuesta" class="form-label">Respuesta</label>
            <textarea class="form-control" id="respuesta" name="respuesta" rows="4" required><?= htmlspecialchars($faq['respuesta']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" id="estado" name="estado">
                <option value="1" <?= $faq['estado'] == 1 ? 'selected' : '' ?>>Activa</option>
                <option value="0" <?= $faq['estado'] == 0 ? 'selected' : '' ?>>Inactiva</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Guardar cambios
        </button>
        <a href="listarFaq.php" class="btn btn-secondary ms-2">
            <i class="bi bi-arrow-left-circle"></i> Volver
        </a>
    </form>
</div>
