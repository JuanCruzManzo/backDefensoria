<?php
include_once '../conexion/parametros.php';
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Defensoria del pueblo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../plantilla//style.css">
</head>
<body>
  <div class="container">
    <div class="row-md-12">
      <div class="col">
        <nav class="navbar">
          <div class="navbar-logo">
            <a href="#">
              <img src="../plantilla/logo_viejo.png" alt="Logo Defensoría" />
            </a>
          </div>
          <div class="navbar-menu">

            <!-- Prensa -->
            <div class="dropdown">
              <a href="#">Prensa</a>
              <div class="dropdown-content">
                <a href="#">Noticias</a>
                <a href="#">Memorias</a>
                <a href="#">Archivos por años</a>
              </div>
            </div>
            <!--Links-->
              <a href="#">Links</a>

              <!-- Contactenos -->
              <div class = "dropdown">
              <a href="#">Contáctenos</a>
              <div class="dropdown-content">                
                <a href="#">FAQ</a>
                <a href="#">Formulario de Contacto</a>
              </div>
              </div>
          </div>
        </nav>
      </div>
    </div>
  </div>