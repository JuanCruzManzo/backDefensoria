<?php
include_once "../plantilla/head2.php";
mysqli_set_charset($link, "utf8mb4");
$sql = "SELECT * FROM faq";
$items = mysqli_query($link, $sql);
?>
<div class="container mt-4">
    <div class="row align-items-center mb-3">
        <div class="col-auto">
            <a href="" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Cargar
            </a>
        </div>
        <div class="col">
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Buscar..." aria-label="Buscar" />
                <button class="btn btn-outline-success" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle shadow-sm">
            <thead class="table-success">
                <tr class="text-center">
                    <th scope="col">Cod.</th>
                    <th scope="col">Pregunta</th>
                    <th scope="col">Respuesta</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
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