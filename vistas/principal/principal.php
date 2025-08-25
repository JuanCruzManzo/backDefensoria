<?php
$sql = "SELECT noticia_id, titulo, contenido, fecha_publicacion FROM noticias ORDER BY fecha_publicacion DESC LIMIT 3";
$resultado = mysqli_query($link, $sql);
?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="col">
                <div class="card">
                    <h1>Bienvenido a la Defensoría del Pueblo</h1>
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-bar-chart-line"></i>&nbsp;Últimas Noticias</h5>
                        <?php
                        while ($noticia = mysqli_fetch_assoc($resultado)) {
                            $resumen = implode(' ', array_slice(explode(' ', strip_tags($noticia['contenido'])), 0, 100));
                            echo '
                <div class="mb-4">
                    <h6>' . htmlspecialchars($noticia['titulo']) . '</h6>
                    <p>' . $resumen . '...</p>
                    <a href="?vista=noticia&id=' . $noticia['noticia_id'] . '" class="btn btn-sm btn-primary">Leer más</a>
                </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>