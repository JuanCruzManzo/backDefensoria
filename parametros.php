<?php
if (!defined("HOST")) define("HOST", "localhost");
if (!defined("USUARIO")) define("USUARIO", "root");
if (!defined("PASS")) define("PASS", "");
if (!defined("DB")) define("DB", "defensoria");



define('BASE_URL','/backDefensoria/');
define("CONEXION", $_SERVER['DOCUMENT_ROOT'] . '/backDefensoria/Conexion/conexion.php');
define("PARAMETROS", $_SERVER['DOCUMENT_ROOT'] . '/backDefensoria/parametros.php');
define("HEAD", $_SERVER['DOCUMENT_ROOT'] . '/backDefensoria/plantilla/head2.php');
define("FUNCIONES", $_SERVER['DOCUMENT_ROOT'] . '/backDefensoria/conexion/funciones.php');
?>