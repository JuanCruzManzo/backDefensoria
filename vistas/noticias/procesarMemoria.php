<?php
session_start();
include_once "../plantilla/head2.php";
include_once "../conexion/conexion.php";

function isValidDate($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
    $sub_titulo = isset($_POST['sub_titulo']) ? trim($_POST['sub_titulo']) : '';
    $fecha_publicacion = isset($_POST['fecha_publicacion']) ? $_POST['fecha_publicacion'] : '';
    $estado = isset($_POST['estado']) ? intval($_POST['estado']) : 1;
    $archivo = $_FILES['archivo'] ?? null;
    $memoria_id = isset($_POST['memoria_id']) ? intval($_POST['memoria_id']) : 0;
    $usuario_id = isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : null;

    // Validaciones de campos
    if ($titulo === '' || !is_string($titulo) || strlen($titulo) > 30) {
        header("Location: index.php?vista=noticias/cargarMemoria&error=1");
        exit;
    }
    if ($sub_titulo === '' || !is_string($sub_titulo) || strlen($sub_titulo) > 50) {
        header("Location: index.php?vista=noticias/cargarMemoria&error=2");
        exit;
    }
    if ($fecha_publicacion === '' || !isValidDate($fecha_publicacion)) {
        header("Location: index.php?vista=noticias/cargarMemoria&error=3");
        exit;
    }
    if ($estado !== 0 && $estado !== 1) {
        header("Location: index.php?vista=noticias/cargarMemoria&error=4");
        exit;
    }
    if (!$usuario_id) {
        header("Location: index.php?vista=noticias/cargarMemoria&error=5");
        exit;
    }

    $nombre_archivo = '';
    $archivo_subido = false;
    $allowedMimeTypes = ['application/pdf', 'application/x-pdf', 'application/acrobat', 'applications/vnd.pdf', 'text/pdf', 'text/x-pdf'];
    $maxFileSize = 10 * 1024 * 1024; // 10MB

    if ($archivo && $archivo['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            header("Location: index.php?vista=noticias/cargarMemoria&error=6");
            exit;
        }
        if (!in_array($archivo['type'], $allowedMimeTypes)) {
            header("Location: index.php?vista=noticias/cargarMemoria&error=7");
            exit;
        }
        if ($archivo['size'] > $maxFileSize) {
            header("Location: index.php?vista=noticias/cargarMemoria&error=8");
            exit;
        }
        $ext = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        if ($ext !== 'pdf') {
            header("Location: index.php?vista=noticias/cargarMemoria&error=9");
            exit;
        }
        $nombre_archivo = time() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '', $archivo['name']);
        $ruta_destino = '../../documentos/' . $nombre_archivo;
        // Bloque de depuración
        var_dump([
            'tmp_name' => $archivo['tmp_name'],
            'ruta_destino' => $ruta_destino,
            'escribible' => is_writable('../../documentos/')
        ]);
        exit;
        if (!move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
            header("Location: index.php?vista=noticias/cargarMemoria&error=10");
            exit;
        }
        $archivo_subido = true;
    }

    // Si es edición, sobreescribe el archivo anterior si se sube uno nuevo
    if ($memoria_id > 0) {
        if ($archivo_subido) {
            $stmt = mysqli_prepare($link, "UPDATE memorias SET titulo=?, sub_titulo=?, archivo=?, estado=?, fecha_publicacion=?, usuario_id=? WHERE memoria_id=?");
            mysqli_stmt_bind_param($stmt, 'sssissi', $titulo, $sub_titulo, $nombre_archivo, $estado, $fecha_publicacion, $usuario_id, $memoria_id);
        } else {
            $stmt = mysqli_prepare($link, "UPDATE memorias SET titulo=?, sub_titulo=?, estado=?, fecha_publicacion=?, usuario_id=? WHERE memoria_id=?");
            mysqli_stmt_bind_param($stmt, 'ssissi', $titulo, $sub_titulo, $estado, $fecha_publicacion, $usuario_id, $memoria_id);
        }
        $exito = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        if ($exito) {
            header("Location: index.php?vista=noticias/verMemorias&exito=1&memoria_id=$memoria_id");
            exit;
        } else {
            header("Location: index.php?vista=noticias/cargarMemoria&error=11");
            exit;
        }
    } else {
        if (!$archivo_subido) {
            header("Location: index.php?vista=noticias/cargarMemoria&error=12");
            exit;
        }
        $fecha_creacion = date('Y-m-d H:i:s');
        $stmt = mysqli_prepare($link, "INSERT INTO memorias (titulo, sub_titulo, archivo, estado, fecha_creacion, fecha_publicacion, usuario_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sssissi', $titulo, $sub_titulo, $nombre_archivo, $estado, $fecha_creacion, $fecha_publicacion, $usuario_id);
        $exito = mysqli_stmt_execute($stmt);
        $nuevo_id = mysqli_insert_id($link);
        mysqli_stmt_close($stmt);
        if ($exito) {
            header("Location: index.php?vista=noticias/verMemorias&exito=1&memoria_id=$nuevo_id");
            exit;
        } else {
            header("Location: index.php?vista=noticias/cargarMemoria&error=13");
            exit;
        }
    }
} else {
    header("Location: index.php?vista=noticias/cargarMemoria&error=14");
    exit;
}
?>
