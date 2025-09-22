<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

include_once "../../conexion/conexion.php";

include "/htdocs/DefensoriaDelPueblo/Secciones/Contactenos/Reseñas/Reseñas.php";

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$id = intval($input['id'] ?? 0);

if ($id > 0) {
    $sql = "SELECT nombre, apellido, email FROM consultas WHERE consulta_id = $id LIMIT 1";
    $resultado = mysqli_query($link, $sql);
    $datos = mysqli_fetch_assoc($resultado);
    $url = "/htdocs/DefensoriaDelPueblo/Secciones/Contactenos/Resenas/Resenas.php";

    if ($datos) {
        $nombre = $datos['nombre'];
        $apellido = $datos['apellido'];
        $email = $datos['email'];

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'highlet.sample@gmail.com';
            $mail->Password = 'qdzw sbyt awmx oknm';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom('highlet.sample@gmail.com', 'Defensoría del Pueblo');
            $mail->addAddress($email);
            $mail->Subject = 'Confirmación de contacto';
            $mail->Body = "Hola $nombre $apellido,\n\n Te enviamos este link a nuestra pagina oficial para que nos dejes una reseña sobre la atencion que recibiste, y en que podriamos mejorar \n\n $url \n\nSaludos cordiales,\nDefensoría del Pueblo.";

            $mail->send();
            echo json_encode(['status' => 'ok', 'message' => 'Correo enviado correctamente.']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error al enviar el correo.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Consulta no encontrada.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID inválido.']);
}
?>
