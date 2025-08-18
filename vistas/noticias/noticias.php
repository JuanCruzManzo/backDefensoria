<?php
    include_once "../plantilla/head2.php";
    mysqli_set_charset($link, "utf8mb4");

    $sql = "SELECT * FROM noticias";
    $items = mysqli_query($link, $sql);
?>
<div class="container">
    <div class="row">
        <div class="col">
            <a href="" class="btn btn-success"> Cargar</a>
        </div>
        <div class="col">
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <br>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Autor</th>
                        <th scope="col">Fecha de publicación</th>
                        <th scope="col">¿Publicado?</th>
                        <th scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>Si</td>
                        <td class="btn btn-primary">Editar</td>
                    </tr>

                    <?php while ($campos = mysqli_fetch_array($items)) { ?>
                    <tr>
                        <td class="text-center fw-bold"><?= $campos['faq_id'] ?></td>
                        <td><?= $campos['pregunta'] ?></td>
                        <td><?= $campos['respuesta'] ?></td>
                        <td class="text-center">
                            <?php if ($campos['estado'] == 1): ?>
                                <span class="badge rounded-pill bg-success p-2">
                                    <i class="bi bi-check-circle-fill"></i> Activa
                                </span>
                            <?php else: ?>
                                <span class="badge rounded-pill bg-danger p-2">
                                    <i class="bi bi-x-circle-fill"></i> Inactiva
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="../faq/editarFaq.php?id=<?= $campos['faq_id'] ?>" class="btn btn-primary">Editar</a>
                        </td>                        
                    </tr>
                <?php } ?>               
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>