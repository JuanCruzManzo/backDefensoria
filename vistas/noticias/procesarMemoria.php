<?php
session_start();
include_once "../plantilla/head2.php";
include_once "../conexion/conexion.php";
require_once(__DIR__ . "/../../conexion/funciones.php");

// ---- Validar formato de fecha ----
function isValidDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

// ---- Subida de archivo PDF ----
function subirPDF($archivo, $carpetaRel = "backDefensoria/documentos/", $maxSize = 10 * 1024 * 1024)
{
    if (!isset($archivo) || $archivo['error'] !== UPLOAD_ERR_OK) return null;

    $ext = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
    if ($ext !== 'pdf') return null;                  // solo PDF
    if ($archivo['size'] > $maxSize) return null;     // máx 10 MB

    // nombre seguro
    $nombre = time() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '', $archivo['name']);

    // ruta absoluta: htdocs/documentos/
    $dirFisico = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/' . $carpetaRel;
    if (!is_dir($dirFisico)) {
        mkdir($dirFisico, 0755, true);
    }

    $rutaFisica = $dirFisico . $nombre;
    if (move_uploaded_file($archivo['tmp_name'], $rutaFisica)) {
        // guardamos ruta relativa para BD
        return $carpetaRel . $nombre;
    }
    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo     = trim($_POST['titulo'] ?? '');
    $sub_titulo = trim($_POST['sub_titulo'] ?? '');
    $fecha_pub  = $_POST['fecha_publicacion'] ?? '';
    $estado     = isset($_POST['estado']) ? intval($_POST['estado']) : 1;
    $archivo    = $_FILES['archivo'] ?? null;
    $memoria_id = intval($_POST['memoria_id'] ?? 0);
    $usuario_id = intval($_SESSION['usuario_id'] ?? 0);

    // ---- Validaciones básicas ----
    if ($titulo === '' || strlen($titulo) > 30) {
        header("Location: index.php?vista=noticias/cargarMemoria&error=1");
        exit;
    }
    if ($sub_titulo === '' || strlen($sub_titulo) > 50) {
        header("Location: index.php?vista=noticias/cargarMemoria&error=2");
        exit;
    }
    if (!isValidDate($fecha_pub)) {
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

    // ---- Subida de archivo ----
    $archivo_ruta = null;
    if ($archivo && $archivo['error'] !== UPLOAD_ERR_NO_FILE) {
        $archivo_ruta = subirPDF($archivo);
        if (!$archivo_ruta) {
            header("Location: index.php?vista=noticias/cargarMemoria&error=6");
            exit;
        }
    }

    // ---- Actualizar o insertar ----
    if ($memoria_id > 0) {
        // Obtener datos anteriores
        $consulta = mysqli_prepare($link, "SELECT * FROM memorias WHERE memoria_id = ?");
        mysqli_stmt_bind_param($consulta, 'i', $memoria_id);
        mysqli_stmt_execute($consulta);
        $anterior = mysqli_fetch_assoc(mysqli_stmt_get_result($consulta));
        mysqli_stmt_close($consulta);

        // Actualizar memoria
        if ($archivo_ruta) {
            $stmt = mysqli_prepare(
                $link,
                "UPDATE memorias
             SET titulo=?, sub_titulo=?, archivo=?, estado=?, fecha_publicacion=?, usuario_id=?
             WHERE memoria_id=?"
            );
            mysqli_stmt_bind_param(
                $stmt,
                'sssissi',
                $titulo,
                $sub_titulo,
                $archivo_ruta,
                $estado,
                $fecha_pub,
                $usuario_id,
                $memoria_id
            );
        } else {
            $stmt = mysqli_prepare(
                $link,
                "UPDATE memorias
             SET titulo=?, sub_titulo=?, estado=?, fecha_publicacion=?, usuario_id=?
             WHERE memoria_id=?"
            );
            mysqli_stmt_bind_param(
                $stmt,
                'ssissi',
                $titulo,
                $sub_titulo,
                $estado,
                $fecha_pub,
                $usuario_id,
                $memoria_id
            );
        }

        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if ($ok) {
            // Auditoría
            $valor_anterior = implode('|', [
                'Título: ' . $anterior['titulo'],
                'Subtítulo: ' . $anterior['sub_titulo'],
                'Estado: ' . $anterior['estado'],
                'Fecha publicación: ' . $anterior['fecha_publicacion'],
                'Archivo: ' . $anterior['archivo']
            ]);

            $valor_nuevo = implode('|', [
                'Título: ' . $titulo,
                'Subtítulo: ' . $sub_titulo,
                'Estado: ' . $estado,
                'Fecha publicación: ' . $fecha_pub,
                'Archivo: ' . ($archivo_ruta ?? $anterior['archivo'])
            ]);

            registrarAuditoria($link, $usuario_id, 'Actualizar', 'memorias', 'Actualización de memoria ID ' . $memoria_id, $valor_anterior, $valor_nuevo);

            header("Location: index.php?vista=noticias/verMemorias&exito=1&memoria_id=$memoria_id");
            exit;
        }

        header("Location: index.php?vista=noticias/cargarMemoria&error=11");
        exit;
    } else {
        if (!$archivo_ruta) {
            header("Location: index.php?vista=noticias/cargarMemoria&error=12");
            exit;
        }

        $fecha_crea = date('Y-m-d H:i:s');
        $stmt = mysqli_prepare(
            $link,
            "INSERT INTO memorias
         (titulo, sub_titulo, archivo, estado, fecha_creacion, fecha_publicacion, usuario_id)
         VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param(
            $stmt,
            'sssissi',
            $titulo,
            $sub_titulo,
            $archivo_ruta,
            $estado,
            $fecha_crea,
            $fecha_pub,
            $usuario_id
        );
        $ok = mysqli_stmt_execute($stmt);
        $nuevo_id = mysqli_insert_id($link);
        mysqli_stmt_close($stmt);

        if ($ok) {
            // Auditoría
            $valor_nuevo = implode('|', [
                'Título: ' . $titulo,
                'Subtítulo: ' . $sub_titulo,
                'Estado: ' . $estado,
                'Fecha publicación: ' . $fecha_pub,
                'Archivo: ' . $archivo_ruta
            ]);

            registrarAuditoria($link, $usuario_id, 'Crear', 'memorias', 'Creación de memoria ID ' . $nuevo_id, '', $valor_nuevo);

            header("Location: index.php?vista=noticias/verMemorias&exito=1&memoria_id=$nuevo_id");
            exit;
        }

        header("Location: index.php?vista=noticias/cargarMemoria&error=13");
        exit;
    }
} else {
    header("Location: index.php?vista=noticias/cargarMemoria&error=14");
    exit;
}
