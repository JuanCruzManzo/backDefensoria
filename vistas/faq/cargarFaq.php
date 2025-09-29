<?php
include_once $_SERVER['DOCUMENT_ROOT'] .'/backDefensoria/parametros.php';
include(CONEXION);
include(HEAD);
include(FUNCIONES);
mysqli_set_charset($link, "utf8mb4");
?>

<div class="container mt-4">
    <h2>Nueva FAQ</h2>
    <form method="POST" action="index.php?vista=faq/Insertarfaq">

        <div class="mb-3">
            <label class="form-label">Pregunta</label>
            <textarea name="pregunta" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Respuesta</label>
            <textarea name="respuesta" class="form-control" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <option value="1">Activa</option>
                <option value="0">Inactiva</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar FAQ</button>
        <a href="index.php?vista=faq/faq" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
