<?php
include_once __DIR__ . "/../../conexion/conexion.php";

function subirImagenConId($archivo, $id, $carpetaRelativa = "uploads/noticias/", $extPermitidas = ['jpg', 'jpeg', 'png']) {
    if (!isset($archivo) || $archivo['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $nombreTmp = $archivo['tmp_name'];
    $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $extPermitidas)) {
        return null;
    }

    $nombreFinal = $id . '.' . $extension;

    $directorioFisico = $_SERVER['DOCUMENT_ROOT'] . '/' . $carpetaRelativa;

    if (!is_dir($directorioFisico)) {
        mkdir($directorioFisico, 0755, true);
    }

    $rutaFisica = $directorioFisico . $nombreFinal;

    if (move_uploaded_file($nombreTmp, $rutaFisica)) {
        return $carpetaRelativa . $nombreFinal;
    }

    return null;
}



$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
$autor = isset($_POST['autor']) ? $_POST['autor'] : '';
$fdp = isset($_POST['fecha_publicacion']) && !empty($_POST['fecha_publicacion'])
    ? date('Y-m-d H:i:s', strtotime($_POST['fecha_publicacion']))
    : null;

$fdf = isset($_POST['fecha_finalizacion']) && !empty($_POST['fecha_finalizacion'])
    ? date('Y-m-d H:i:s', strtotime($_POST['fecha_finalizacion']))
    : null;
$contenido = isset($_POST['contenido']) ? $_POST['contenido'] : '';
$estado = 0;

//Calcular Estado de publicacion de la noticia. 
date_default_timezone_set('America/Argentina/Buenos_Aires');
if ($fdp && $fdf) {
    $ahora = time();
    $inicio = strtotime($fdp);
    $fin = strtotime($fdf);

    if ($ahora >= $inicio && $ahora <= $fin) {
        $estado = 1;
    }
}


$foto_ruta = '';

if ($id > 0) {

    $foto_ruta = subirImagenConId($_FILES['foto'], $id);
    if (!$foto_ruta) {
        $foto_ruta = $_POST['foto_actual'] ?? '';
    }

    $sql = "UPDATE noticias 
            SET titulo = ?, contenido = ?, fecha_publicacion = ?, fecha_finalizacion = ?, autor = ?, foto = ?, estado = ?
            WHERE noticia_id = ?";
    $stmt = mysqli_prepare($link, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssii", $titulo, $contenido, $fdp, $fdf, $autor, $foto_ruta, $estado, $id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?vista=noticias/noticias");
            exit;
        } else {
            echo "<div class='alert alert-danger'>Error al ejecutar UPDATE: " . mysqli_stmt_error($stmt) . "</div>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='alert alert-danger'>Error al preparar UPDATE: " . mysqli_error($link) . "</div>";
    }
} else {

    $sql_id = "SELECT AUTO_INCREMENT FROM information_schema.TABLES 
               WHERE TABLE_SCHEMA = 'defensoria' AND TABLE_NAME = 'noticias'";
    $result = mysqli_query($link, $sql_id);
    $row = mysqli_fetch_assoc($result);
    $proximo_id = $row['AUTO_INCREMENT'];

    $foto_ruta = subirImagenConId($_FILES['foto'], $proximo_id);
    if (!$foto_ruta) {
        $foto_ruta = '';
    }

    $sql = "INSERT INTO noticias (titulo, contenido, fecha_publicacion, fecha_finalizacion, autor, foto, estado) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssi", $titulo, $contenido, $fdp, $fdf, $autor, $foto_ruta, $estado);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?vista=noticias/noticias");
            exit;
        } else {
            echo "<div class='alert alert-danger'>Error al ejecutar INSERT: " . mysqli_stmt_error($stmt) . "</div>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='alert alert-danger'>Error al preparar INSERT: " . mysqli_error($link) . "</div>";
    }
}
?>
