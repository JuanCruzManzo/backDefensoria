<?php
include("../conexion/parametros.php");
include("../conexion/conexion.php");
include("../plantilla/head2.php");

$vista = isset($_GET['vista']) ? $_GET['vista'] : 'principal';

if (strpos($vista, "/") !== false) {
    list($carpeta, $archivo) = explode("/", $vista);
} else {
    $carpeta = $vista;
    $archivo = $vista;
}
$ruta = "../vistas/$carpeta/$archivo.php";
?>

<div class="layout-admin d-flex">
  <!-- Sidebar institucional -->
  <aside class="sidebar-admin d-flex flex-column align-items-start">
    <a href="index.php" class="mb-4 w-100 text-center logo-admin">
      <img src="../plantilla/LogoNuevo.jpeg" alt="Logo Defensoría" width="160" class="img-shadow">
    </a>

    <nav class="w-100">
      <a href="?vista=faq/faq" class="btn-clean sidebar-subtitle"><i class="bi bi-patch-question-fill"></i>&nbsp;Preguntas Frecuentes</a>
      <a href="?vista=resoluciones/resoluciones" class="btn-clean sidebar-subtitle"><i class="bi bi-bookmark-fill"></i>&nbsp;Resoluciones</a>
      <a href="?vista=noticias/noticias" class="btn-clean sidebar-subtitle"><i class="bi bi-newspaper"></i>&nbsp;Noticias</a>
      <a href="?vista=consultas/consultas" class="btn-clean sidebar-subtitle"><i class="bi bi-person-raised-hand"></i>&nbsp;Consultas y denuncias</a>
      <a href="?vista=resenas/resenas" class="btn-clean sidebar-subtitle"><i class="bi bi-people-fill"></i>&nbsp;Reseñas</a>
    </nav>

    <div class="mt-auto w-100">
      <hr class="my-3"/>
      <a href="?vista=auditorias/auditorias" class="btn-clean sidebar-subtitle"><i class="bi bi-newspaper"></i>&nbsp;Auditoría</a>
     <a href="../login/cerrarSesion.php" class="btn-logout w-100 d-flex align-items-center justify-content-center gap-2 text-decoration-none">
        <i class="bi bi-box-arrow-right fs-5"></i>
        <strong>Cerrar sesión</strong>
      </a>
    </div>
  </aside>

  <!-- Área principal -->
  <main class="main-admin flex-grow-1 p-4">
    <div class="container">
      <?php
      if (file_exists($ruta)) {
          include($ruta);
      } else {
          echo "<div class='alert alert-warning'>Vista no encontrada: <code>$ruta</code></div>";
      }
      ?>
    </div>
  </main>
</div>
