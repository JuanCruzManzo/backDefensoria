<?php
$sql_noticia = "SELECT noticia_id, titulo, contenido, fecha_publicacion FROM noticias ORDER BY fecha_creacion DESC LIMIT 3";
$resultado_not = mysqli_query($link, $sql_noticia);

$sql_resolucion = "SELECT resolucion_id, Titulo, anio FROM resoluciones ORDER BY anio ASC LIMIT 3";
$resultado_res = mysqli_query($link, $sql_resolucion);
?>
<div class="container">
    <div class="row">
        <h1 class="display-5">Bienvenido a la Defensoría del Pueblo</h1>
        <div class="col">   
            <div class="col">
                <div class="card">
                    <div class="card-body mt-3">
                        <h5 class="card-title"><i class="bi bi-bar-chart-line"></i>&nbsp;Últimas Noticias</h5>
                        <?php
                        while ($noticia = mysqli_fetch_assoc($resultado_not)) {
                            $resumen = implode(' ', array_slice(explode(' ', strip_tags($noticia['contenido'])), 0, 100));
                            echo 
                            '<div class="mb-4">
                                    <h6 class="display-6">' . htmlspecialchars($noticia['titulo']) . '</h6>
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