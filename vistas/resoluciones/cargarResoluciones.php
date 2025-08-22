<div class="container mt-4">
    <h2>Cargar Resolución</h2>
    <form method="POST" action="index.php?vista=resoluciones/insertarResolucion" enctype="multipart/form-data">

        <div class="mb-3">
            <label class="form-label">Titulo</label>
            <textarea name="titulo" class="form-control" rows="2" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Año</label>
            <textarea name="anio" class="form-control" rows="1" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <option value="1">Activa</option>
                <option value="0">Inactiva</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Archivo PDF</label>
            <input type="file" name="pdf" class="form-control" accept="application/pdf" required>
        </div>

        <button type="submit" class="btn btn-success">Guardar Resolución</button>
        <a href="index.php?vista=resoluciones/resoluciones" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
