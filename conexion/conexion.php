<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/backDefensoria/parametros.php'; 
$link = mysqli_connect(HOST, USUARIO, PASS, DB);

if (!$link) {
    die("Error de conexión: " . mysqli_connect_error());
}
mysqli_set_charset($link, "utf8mb4");
