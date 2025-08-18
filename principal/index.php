<?php
include("../conexion/parametros.php");
include("../conexion/conexion.php");
include("../plantilla/head2.php");

$vista = isset($_GET['vista']) ? $_GET['vista'] : 'principal';

// Si viene con formato carpeta/archivo
if (strpos($vista, "/") !== false) {
    list($carpeta, $archivo) = explode("/", $vista);
} else {
    $carpeta = $vista;
    $archivo = $vista;
}

$ruta = "../vistas/$carpeta/$archivo.php";

?>

<div class="d-flex">
    <nav class="d-flex flex-column bg-light p-3" style="width: 220px; min-height: 100vh; border-right: 1px solid #ccc;">
        <img src="../plantilla/logo_viejo.png" alt="Logo Defensoría" />
        <a href="?vista=faq/faq" class="btn btn-clean mb-3"><i class="bi bi-patch-question-fill"></i>&nbsp;FAQ</a>
        <a href="?vista=resoluciones/resoluciones" class="btn btn-clean mb-3"><i class="bi bi-bookmark-fill"></i>&nbsp;Resoluciones</a>
        <a href="?vista=noticias/noticias" class="btn btn-clean mb-3"><i class="bi bi-newspaper"></i>&nbsp;Noticias</a>
        <a href="?vista=auditorias/auditorias" class="btn btn-clean mb-3"><i class="bi bi-book-fill"></i>&nbsp;Auditorías</a>
    </nav>

    <main class="flex-grow-1 p-4">
        <?php
        if (file_exists($ruta)) {
            include($ruta);
        } else {
            echo "<h4>Vista no encontrada: $ruta</h4>"; // 👈 te muestra la ruta exacta que intenta cargar
        }
        ?>
    </main>
</div>
