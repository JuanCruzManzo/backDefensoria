<?php
include("../conexion/parametros.php");
include("../conexion/conexion.php");
include("../plantilla/head2.php");

$vista = isset($_GET['vista']) ? $_GET['vista'] : 'principal';
?>

<div class="d-flex">
    <nav class="d-flex flex-column bg-light p-3" style="width: 220px; min-height: 100vh; border-right: 1px solid #ccc;">
        <img src="../plantilla/logo_viejo.png" alt="Logo Defensoría" />
        <a href="?vista=faq" class="btn btn-clean mb-3"><i class="bi bi-patch-question-fill"></i>&nbsp;FAQ</a>
        <a href="?vista=normativas" class="btn btn-clean mb-3"><i class="bi bi-bookmark-fill"></i>&nbsp;Resoluciones</a>
        <a href="?vista=noticias" class="btn btn-clean mb-3"><i class="bi bi-newspaper"></i>&nbsp;Noticias</a>
        <a href="?vista=auditorias" class="btn btn-clean mb-3"><i class="bi bi-book-fill"></i>&nbsp;Auditorías</a>
    </nav>

    <main class="flex-grow-1 p-4">
        <?php
        $archivo = "../vistas/" . $vista . ".php";
        if (file_exists($archivo)) {
            include($archivo);
        } else {
            echo "<h4>Vista no encontrada</h4>";
        }
        ?>
    </main>
</div>

<?php include("../plantilla/footer.php"); ?>
