<?php
$sql_noticia = "SELECT noticia_id, titulo, contenido, fecha_publicacion FROM noticias ORDER BY fecha_creacion DESC LIMIT 3";
$resultado_not = mysqli_query($link, $sql_noticia);
?>

<div class="container">
  <h1 class="display-5 mb-4">Bienvenido a la Defensoría del Pueblo</h1>

  <div class="card shadow-sm border-0">
    <div class="card-body">
      <h5 class="card-title text-secondary"><i class="bi bi-bar-chart-line"></i>&nbsp;Últimas Noticias</h5>
      <?php while ($noticia = mysqli_fetch_assoc($resultado_not)) {
        $resumen = implode(' ', array_slice(explode(' ', strip_tags($noticia['contenido'])), 0, 100));
      ?>
        <div class="mb-3 border-bottom pb-2">
          <h6 class="fw-bold"><?= htmlspecialchars($noticia['titulo']) ?></h6>
          <p class="text-muted"><?= $resumen ?>...</p>
          <a href="?vista=noticias/cargarNoticia&id=<?= $noticia['noticia_id'] ?>" class="btn-cargar">Leer más</a>
        </div>
      <?php } ?>
    </div>
  </div>
</div>

