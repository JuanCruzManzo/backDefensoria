<?php
/*
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT titulo, contenido FROM noticias WHERE id = $id";
$resultado = mysqli_query($conexion, $sql);
$noticia = mysqli_fetch_assoc($resultado);

if ($noticia) {
    echo '<h2>' . htmlspecialchars($noticia['titulo']) . '</h2>';
    echo '<p>' . nl2br($noticia['cuerpo']) . '</p>';
} else {
    echo '<p>Noticia no encontrada.</p>';
}
    */
include_once "../plantilla/head2.php";
?>
<div class="container">
    <div class="row">
        <div class="col">
            <a href="" class="btn btn-success"> Cargar</a>
        </div>
        <div class="col">
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <br>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Cod.</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Autor</th>
                        <th scope="col">Fecha de publicación</th>
                        <th scope="col">¿Publicado?</th>
                        <th scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>Si</td>
                        <td class="btn btn-primary">Editar</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        <td>Si</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>John</td>
                        <td>Doe</td>
                        <td>@social</td>
                        <td>Si</td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>