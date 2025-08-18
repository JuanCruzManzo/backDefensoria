<?php
    include_once "../plantilla/head2.php";

    mysqli_set_charset($link, "utf8mb4");
    $sql = "SELECT * FROM faq";
    $items = mysqli_query($link, $sql);

?>

