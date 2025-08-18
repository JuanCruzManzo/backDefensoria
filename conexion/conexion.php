<?php
require_once(__DIR__ . "/parametros.php");

$link = mysqli_connect(HOST, USUARIO, PASS, DB);

if (!$link) {
    die("Error de conexión: " . mysqli_connect_error());
}
mysqli_set_charset($link, "utf8mb4");
