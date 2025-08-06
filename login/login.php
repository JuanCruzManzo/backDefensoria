<?php
include("../conexion/parametros.php");
include("../conexion/conexion.php");
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LogIn Defensoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos.css">
  </head>
 <body>
    <div class="container vh-100">
      <div class="row h-100 justify-content-center align-items-center">
        <div class="col-12 col-sm-8 col-md-6 col-lg-4">
          <div class="login-box">
            <h2 class="text-center mb-4">Defensoría del Pueblo</h2>
            <form action="../principal/principal.php" method="post">
              <div class="mb-3">
                <label for="username" class="form-label">Usuario</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Ingrese nombre de usuario" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese su contraseña" required>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Acceder</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
  </body>
</html>