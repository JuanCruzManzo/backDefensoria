<?php 
    include_once "../plantilla/head2.php";

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    $title_noticia = ($id != 0) ? "Editar Noticia" : "Crear Noticia";

    if ($id != 0) {
        

        $sql = "SELECT * FROM noticias WHERE noticia_id = $id";
        $resultado = mysqli_query($link, $sql);
        $noticia = mysqli_fetch_assoc($resultado);

        if (!$noticia) {
            echo "<div class='alert alert-danger'>Noticia no encontrada.</div>";
            exit;
        }  
    } else {
    
    $noticia = [
    'noticia_id' => '',
    'titulo' => '',
    'autor' => '',
    'fecha_publicacion' => '',
    'fecha_finalizacion' => '',
    'estado' => 1,
    'foto' => '',
    'contenido' => ''
    ];
}
?>

<div class="container">
    <div class="row">
        <div class="col">
            <div>
                <h3 class="display-2"><?=$title_noticia?></h3>
            </div>
            <div class="col">
                <form action="index.php?vista=noticias/editarNoticia" method="POST" enctype="multipart/form-data">
                    <div class="col">
                        <input type="hidden" name="id" value="<?= $noticia['noticia_id'] ?>">

                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" value="<?= htmlspecialchars($noticia['titulo']) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="autor" class="form-label">Autor</label>
                            <input type="text" class="form-control" id="autor" name="autor" value="<?= htmlspecialchars($noticia['autor']) ?>">
                        </div>

                        <?php
                                $fechaPublicacion = !empty($noticia['fecha_publicacion']) 
                                ? date('d-m-Y H:i', strtotime($noticia['fecha_publicacion'])) 
                                : date('d-m-Y H:i');
                        ?>
                        <div class="mb-3">
                            <label class="form-label" for="fecha_publicacion">Fecha de Publicación</label>                            
                            <input type="text" class="form-control" name="fecha_publicacion" id="fecha_publicacion" aria-describedby="fechadepublicacion" value="<?= $fechaPublicacion ?>">                   
                            <div id="fechadepublicacion" class="form-text">Es la fecha y hora en la que la noticia se va a publicar.</div>
                        </div>

                        <?php
                            $fechaFinalizacion = !empty($noticia['fecha_finalizacion']) 
                                ? date('d-m-Y H:i', strtotime($noticia['fecha_finalizacion'])) 
                                : date('d-m-Y H:i');
                        ?>
                        <div class="mb-3">
                            <label class="form-label" for="fecha_finalizacion">Fecha de Finalización</label>
                            <input type="text" class="form-control" id="fecha_finalizacion" name="fecha_finalizacion" value="<?= $fechaFinalizacion ?>">
                            <div id="fechadefinalizacion" class="form-text">Es la fecha y hora en la que la noticia va a finalizar.</div>                            
                        </div>

                        <?php if (!empty($noticia['foto'])): ?>
                            <div class="mb-3">
                                <label class="form-label">Imagen actual</label><br>
                                <img src="/<?= htmlspecialchars($noticia['foto']) ?>" alt="Imagen actual">
                            </div>
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <label class="form-label" for="foto">Subir Imagen</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                            <input type="hidden" name="foto_actual" value="<?= $noticia['foto'] ?>">                        
                        </div>                                                                                                         
                        <div class="mb-3">
                            <label for="contenido" class="form-label">Contenido de noticia</label>
                            <textarea name="contenido" class="form-control" id="contenido" rows="6"><?= htmlspecialchars($noticia['contenido']) ?></textarea>                    
                        </div>                                    
                        <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle"></i>&nbsp;Cargar</button>
                        <div id="alertaFechas" class="alert alert-warning d-none mt-2" role="alert">
                            ⚠️ La fecha de finalización no puede ser anterior a la fecha de publicación.
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    let fechaPublicacionObj = null;
    let fechaFinalizacionObj = null;

    const alerta = document.getElementById("alertaFechas");
    const botonSubmit = document.querySelector("form button[type='submit']");

    flatpickr("#fecha_publicacion", {
        enableTime: true,
        dateFormat: "d-m-Y H:i",
        time_24hr: true,
        defaultDate: document.getElementById("fecha_publicacion").value,
        onChange: function(selectedDates) {
            fechaPublicacionObj = selectedDates[0];
            validarFechas();
        }
    });

    flatpickr("#fecha_finalizacion", {
        enableTime: true,
        dateFormat: "d-m-Y H:i",
        time_24hr: true,
        defaultDate: document.getElementById("fecha_finalizacion").value,
        onChange: function(selectedDates) {
            fechaFinalizacionObj = selectedDates[0];
            validarFechas();
        }
    });

    function validarFechas() {
        if (fechaPublicacionObj && fechaFinalizacionObj) {
            if (fechaFinalizacionObj < fechaPublicacionObj) {
                alerta.classList.remove("d-none");
                botonSubmit.disabled = true;
            } else {
                alerta.classList.add("d-none");
                botonSubmit.disabled = false;
            }
        }
    }

</script>
