<?php
if (!defined("HOST")) define("HOST", "localhost");
if (!defined("USUARIO")) define("USUARIO", "root");
if (!defined("PASS")) define("PASS", "");
if (!defined("DB")) define("DB", "defensoria");



define('BASE_URL','/backDefensoria/');
define("CONEXION", $_SERVER['DOCUMENT_ROOT'] . BASE_URL.'/conexion/conexion.php');
define("PARAMETROS", $_SERVER['DOCUMENT_ROOT'] . BASE_URL.'/parametros.php');
define("HEAD", $_SERVER['DOCUMENT_ROOT'] . BASE_URL.'/plantilla/head2.php');
define("FUNCIONES", $_SERVER['DOCUMENT_ROOT'] . BASE_URL.'/conexion/funciones.php');
?>