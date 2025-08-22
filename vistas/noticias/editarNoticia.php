<?php
include_once __DIR__ . "/../../conexion/conexion.php";

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$titulo = isset($_POST['titulo']) ? mysqli_real_escape_string($link, $_POST['titulo']) : '';
$autor = isset($_POST['autor']) ? mysqli_real_escape_string($link, $_POST['autor']) : '';
$fdp = isset($_POST['fecha_publicacion']) ? intval($_POST['fecha_publicacion']) : 0;
$fdf = isset($_POST['fecha_finalizacion']) ? intval($_POST['fecha_finalizacion']) : 0;
//VERIFICAR QUE HACER CON FOTO
$foto = isset($_POST['foto']) ? mysqli_real_escape_string($link, $_POST['foto']) : '';
//
$contenido = isset($_POST['contenido']) ? mysqli_real_escape_string($link, $_POST['contenido']) : '';
$estado = isset($_POST['estado']) ? intval($_POST['estado']) : 0;

if ($id > 0) {
        
    $sql = "UPDATE noticias                 
            SET titulo = '$titulo', contenido = '$contenido', fecha_publicacion = $fdp, fecha_finalizacion = $fdf, autor = '$autor', foto = '$foto', estado = $estado;   
            WHERE noticia_id = $id";    
} else {
    
    $sql = "INSERT INTO noticias (titulo, contenido, fecha_publicacion, fecha_finalizacion, autor, foto, estado) 
            VALUES ('$titulo', '$contenido', $fdp, $fdf, '$autor' , '$foto' , $estado)";
}

// Ejecutar consulta
if (mysqli_query($link, $sql)) {
    header("Location: index.php?vista=noticias/noticias");
    exit;
} else {
    echo "<div class='alert alert-danger'>Error en la operación: " . mysqli_error($link) . "</div>";
}
?>
