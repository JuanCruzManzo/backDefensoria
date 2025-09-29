<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] .'/backDefensoria/parametros.php';
include(CONEXION);
include(FUNCIONES);

function subirImagenConId($archivo, $id, $carpetaRelativa = "backDefensoria/uploads/noticias/", $extPermitidas = ['jpg', 'jpeg', 'png']) {
    if (!isset($archivo) || $archivo['error'] !== UPLOAD_ERR_OK) return null;

    $nombreTmp = $archivo['tmp_name'];
    $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
    $mime = mime_content_type($nombreTmp);

    $mimePermitidos = ['image/jpeg', 'image/png'];

    if (!in_array($extension, $extPermitidas) || !in_array($mime, $mimePermitidos)) return null;

    $nombreFinal = $id . '.' . $extension;
    $carpetaRelativa = rtrim($carpetaRelativa, '/') . '/';
    $directorioFisico = $_SERVER['DOCUMENT_ROOT'] . '/' . $carpetaRelativa;

    if (!is_dir($directorioFisico)) mkdir($directorioFisico, 0755, true);

    $rutaFisica = $directorioFisico . $nombreFinal;

    if (move_uploaded_file($nombreTmp, $rutaFisica)) {
        return $carpetaRelativa . $nombreFinal;
    }

    return null;
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$titulo = $_POST['titulo'] ?? '';
$autor = $_POST['autor'] ?? '';
$fdp = !empty($_POST['fecha_publicacion']) ? date('Y-m-d H:i:s', strtotime($_POST['fecha_publicacion'])) : null;
$fdf = !empty($_POST['fecha_finalizacion']) ? date('Y-m-d H:i:s', strtotime($_POST['fecha_finalizacion'])) : null;
$contenido = $_POST['contenido'] ?? '';
$estado = isset($_POST['estado']) ? intval($_POST['estado']) : 0;
$foto_ruta = '';

if ($id > 0) {
    // Editar noticia
    $sql_original = "SELECT * FROM noticias WHERE noticia_id = $id";
    $res_original = mysqli_query($link, $sql_original);
    $original = mysqli_fetch_assoc($res_original);

    $foto_ruta = subirImagenConId($_FILES['foto'], $id);
    if (!$foto_ruta) $foto_ruta = $_POST['foto_actual'] ?? '';

    $sql = "UPDATE noticias 
            SET titulo = ?, contenido = ?, fecha_publicacion = ?, fecha_finalizacion = ?, autor = ?, foto = ?, estado = ?
            WHERE noticia_id = ?";
    $stmt = mysqli_prepare($link, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssii", $titulo, $contenido, $fdp, $fdf, $autor, $foto_ruta, $estado, $id);
        if (mysqli_stmt_execute($stmt)) {
            $observacion = "Se modificó la noticia ID $id";
            $valor_anterior = "Título: {$original['titulo']} | Autor: {$original['autor']} | Estado: {$original['estado']} | Fecha publicación: {$original['fecha_publicacion']} | Fecha finalización: {$original['fecha_finalizacion']} | Foto: {$original['foto']}";
            $valor_nuevo = "Título: $titulo | Autor: $autor | Estado: $estado | Fecha publicación: $fdp | Fecha finalización: $fdf | Foto: $foto_ruta";
            registrarAuditoria($link, $_SESSION['usuario_id'], 'Editar', 'noticias', $observacion, $valor_anterior, $valor_nuevo);

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
    // Nueva noticia
    $sql_id = "SELECT AUTO_INCREMENT FROM information_schema.TABLES 
               WHERE TABLE_SCHEMA = 'defensoria' AND TABLE_NAME = 'noticias'";
    $result = mysqli_query($link, $sql_id);
    $row = mysqli_fetch_assoc($result);
    $proximo_id = $row['AUTO_INCREMENT'];

    $foto_ruta = subirImagenConId($_FILES['foto'], $proximo_id);

    $sql = "INSERT INTO noticias (titulo, contenido, fecha_publicacion, fecha_finalizacion, autor, foto, estado) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssi", $titulo, $contenido, $fdp, $fdf, $autor, $foto_ruta, $estado);
        if (mysqli_stmt_execute($stmt)) {
            $id_insertado = mysqli_insert_id($link);
            $observacion = "Se cargó la noticia ID $id_insertado";
            $valor_nuevo = "Título: $titulo | Autor: $autor | Estado: $estado | Fecha publicación: $fdp | Fecha finalización: $fdf | Foto: $foto_ruta";
            registrarAuditoria($link, $_SESSION['usuario_id'], 'Alta', 'noticias', $observacion, '', $valor_nuevo);

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