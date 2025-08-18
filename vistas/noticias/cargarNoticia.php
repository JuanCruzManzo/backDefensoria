<?php 
    include_once "../plantilla/head2.php";

    if(isset($GET_["editar"])){
        //bloque de carga de noticias
    } else {
        //campos de form vacios
    }
?>

<div class="container">
    <div class="row">
        <div class="col">
            <div>
                <h3 class="display-2">Carga de Noticias</h3>
            </div>
            <div class="col">
                <form>
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Titulo</label>
                        <input type="text" class="form-control" id="titulo">                        
                    </div>                    
                    <div class="mb-3">
                        <label for="contenido" class="form-label">Cuerpo</label>
                        <input type="text" class="form-control" id="contenido">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="fecha_publicacion">Fecha de Publicacion</label>
                        <input type="datetime" class="form-control" id="fecha_publicacion" aria-describedby="fechadepublicacion">                        
                        <div id="fechadepublicacion" class="form-text">Es la fecha y hora en la que la noticia se va a publicar.</div>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle"></i>&nbsp;Cargar</button>
                </form>
            </div>
        </div>
    </div>
</div>