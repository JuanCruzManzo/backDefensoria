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
                <form action="index.php?vista=noticias/editarNoticia" method="POST">
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
                        <div class="mb-3">
                            <label class="form-label" for="fecha_publicacion">Fecha de Publicacion</label>
                            <input type="datetime-local" class="form-control" name="fecha_publicacion" id="fecha_publicacion" aria-describedby="fechadepublicacion" value="<?= $noticia['fecha_publicacion'] ?>">                   
                            <div id="fechadepublicacion" class="form-text">Es la fecha y hora en la que la noticia se va a publicar.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="fecha_finalizacion">Fecha de Publicacion</label>
                            <input type="datetime-local" class="form-control" id="fecha_finalizacion" name="fecha_finalizacion" aria-describedby="fechadefinalizacion" value="<?= $noticia['fecha_finalizacion'] ?>">                   
                            <div id="fechadefinalizacion" class="form-text">Es la fecha y hora en la que la noticia va a finalizar.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="foto">Subir Imagen</label>
                            <input type="file" class="form-control" id="foto" name="foto">                        
                        </div>                                                                                 
                        <div class="mb-3">
                            <label for="contenido" class="form-label">contenido de noticia</label>
                            <textarea name="contenido" class="form-control" id="contenido" rows="6"><?= htmlspecialchars($noticia['contenido']) ?></textarea>                    
                        </div>                                    
                        <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle"></i>&nbsp;Cargar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>