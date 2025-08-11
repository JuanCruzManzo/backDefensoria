<?php
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
?>
