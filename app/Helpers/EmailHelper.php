<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailHelper
{
    public static function enviarCorreoReserva($emailDestino, $nombreCliente, $detalleReserva, $idReserva)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Cambia por tu servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'pruebacastillo18@gmail.com'; // Tu correo
            $mail->Password = 'rpgxxnvsjxnzaedx'; // Tu contraseña
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configuración del correo
            $mail->setFrom('pruebacastillo18@gmail.com', 'Castillo de Saguazu'); // Cambia el remitente
            $mail->addAddress($emailDestino, $nombreCliente);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Confirmacion de Reserva';
            $mail->Body = "
    <h1>Hola, $nombreCliente</h1>
    <p>Gracias por realizar tu reserva con nosotros. Aquí están los detalles de tu reserva:</p>
    <ul>
        <li><strong>Servicio:</strong> {$detalleReserva['servicio']}</li>
        <li><strong>Fecha de Entrada:</strong> {$detalleReserva['fecha_entrada']}</li>
        <li><strong>Fecha de Salida:</strong> {$detalleReserva['fecha_salida']}</li>
        <li><strong>Adultos:</strong> {$detalleReserva['adultos']}</li>
        <li><strong>Precio Total:</strong> Gs. {$detalleReserva['precio_total']}</li>
    </ul>
    <p>Podrás dejarnos tu reseña después de tu estadía. Haz clic en el siguiente enlace para completar tu reseña:</p>
    <a href='http://localhost:8000/resenha?reserva_id=$idReserva'>Completar Reseña</a>
    <p>Nota: Solo podrás completar la reseña después de la fecha de salida.</p>
";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Error al enviar correo: {$mail->ErrorInfo}");
            return false;
        }
    }
}
