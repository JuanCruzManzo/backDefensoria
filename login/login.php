<?php
include("../conexion/parametros.php");
include("../conexion/conexion.php");
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Defensoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <div class="fondo">
        <div class="container">
            <div class="row h-100 justify-content-center align-items-center min-vh-100">
                <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                    <div class="login-box shadow">
                        <h2 class="text-center mb-4 text-white">Defensoría del Pueblo</h2>
                        <form action="../principal/principal.php" method="post">
                            <div class="mb-3 input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Usuario" required>
                            </div>
                            <div class="mb-3 input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Acceder</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>