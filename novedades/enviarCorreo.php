<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellido = htmlspecialchars($_POST['apellido']);
    $cedula = htmlspecialchars($_POST['cedula']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $email = htmlspecialchars($_POST['email']);
    $empresa = htmlspecialchars($_POST['empresa']);
    $cargo = htmlspecialchars($_POST['cargo']);
    $ciudad = htmlspecialchars($_POST['ciudad']);
    $razonSocial = htmlspecialchars($_POST['razonSocial']);
    $ruc = htmlspecialchars($_POST['ruc']);
    $direccionEmpresa = htmlspecialchars($_POST['direccionEmpresa']);
    $telefonoEmpresa = htmlspecialchars($_POST['telefonoEmpresa']);
    $emailEmpresa = htmlspecialchars($_POST['emailEmpresa']);

    // Enviar el correo al destinatario
    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor de correo
        $mail->isSMTP();
        $mail->Host = 'mail.aeds.ec';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@aeds.ec';
        $mail->Password = '**nfo2024EC**';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Establecer el charset a UTF-8
        $mail->CharSet = 'UTF-8';

        // Destinatarios
        $mail->setFrom('info@aeds.ec', 'AEDS | Academia Ecuatoriana de Derecho Societario');
        $mail->addAddress('info@aeds.ec'); // Correo del destinatario (tú)
        $mail->addCC('vchiriboga@lex.ec'); // Copia visible
        $mail->addReplyTo($email, $nombre);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje de contacto';
        $mail->Body = "Has recibido un nuevo mensaje de contacto de: <br><br>
                        Nombres: $nombre <br>
                        Apellidos: $apellido <br>
                        N° de Cédula: $cedula <br>
                        Teléfono / Celular: $telefono <br>
                        Correo electrónico: $email <br>
                        Empresa donde labora: $empresa <br>
                        Cargo en la empresa: $cargo <br>
                        Ciudad: $ciudad <br>
                        Razon Social de la Empresa: $razonSocial <br>
                        R.U.C.: $ruc <br>
                        Dirección de la Empresa: $direccionEmpresa <br>
                        Teléfono de la Empresa: $telefonoEmpresa <br>
                        Email de la Empresa: $emailEmpresa <br>";
        // Enviar el mensaje al destinatario principal (tú)
        $mail->send();

        // Enviar respuesta automática al usuario
        $autoReply = new PHPMailer(true);
        $autoReply->isSMTP();
        $autoReply->Host = 'mail.aeds.ec';
        $autoReply->SMTPAuth = true;
        $autoReply->Username = 'info@aeds.ec';
        $autoReply->Password = '**nfo2024EC**';
        $autoReply->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $autoReply->Port = 465;

        // Establecer el charset a UTF-8
        $autoReply->CharSet = 'UTF-8';

        $autoReply->setFrom('soporte@iweb.com.ec', 'AEDS | Academia Ecuatoriana de Derecho Societario');
        $autoReply->addAddress($email); // Dirección del usuario

        // Contenido del correo de respuesta automática
        $autoReply->isHTML(true);
        $autoReply->Subject = 'Confirmación de recepción';
        $autoReply->Body = "Hola $nombre $apellido,<br><br>Gracias por contactarnos. Hemos recibido tu mensaje y te responderemos a la brevedad.<br><br>Saludos,<br>AEDS | Academia Ecuatoriana de Derecho Societario";
        $autoReply->send();

        echo 'El mensaje se ha enviado correctamente. Revise su correo electrónico para la confirmación.';
    } catch (Exception $e) {
        echo "Hubo un error al enviar el mensaje: {$mail->ErrorInfo}";
    }
} else {
    echo 'Solicitud no válida';
}
?>