<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] .'/backDefensoria/parametros.php';
include(CONEXION);
include(PARAMETROS);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST["username"]);
    $clave = trim($_POST["password"]);

    // Consulta segura
    $stmt = $link->prepare("SELECT usuario_id, usuario, nombre, contrasena, estado FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $fila = $resultado->fetch_assoc();

        if ($fila["estado"] != 1) {
            header("Location: login.php?error=Usuario inactivo");
            exit;
        }

        if ($clave === $fila["contrasena"]) {
            $_SESSION["usuario_id"] = $fila["usuario_id"];
            $_SESSION["usuario_nombre"] = $fila["nombre"];
            header("Location: ../principal/index.php");
            exit;
        } else {
            header("Location: login.php?error=Contraseña incorrecta");
            exit;
        }
    } else {
        header("Location: login.php?error=Usuario no encontrado");
        exit;
    }

    $stmt->close();
    $link->close();
}
?>
