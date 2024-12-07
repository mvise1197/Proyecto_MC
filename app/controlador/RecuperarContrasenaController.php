<?php
require_once '../modelo/Database.php';
require_once '../modelo/Usuario.php';
require_once '../libs/PHPMailer/src/Exception.php';
require_once '../libs/PHPMailer/src/PHPMailer.php';
require_once '../libs/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Conexión a la base de datos
    $db = new Database();
    $usuarioModel = new Usuario($db->getConnection());

    // Verificar si el correo existe en la base de datos
    $result = $usuarioModel->verificarCorreo($email);

    if ($result->num_rows > 0) {
        // Generar un token único y fecha de expiración
        $token = bin2hex(random_bytes(50));  
        $expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Actualizar el token en la base de datos
        if ($usuarioModel->actualizarToken($email, $token, $expiration)) {
            // Enviar el correo de restablecimiento
            enviarCorreo($email, $token);
            echo '<script>alert("Correo enviado correctamente. Regresando al login."); window.location.href = "../vista/login.php";</script>';
            exit();
        }
    } else {
        echo '<script>alert("El correo no está registrado.");</script>';
    }
}

function enviarCorreo($email, $token) {
    // Configuración del correo con PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Servidor SMTP de Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'andervilchez1704@gmail.com';  // Tu dirección de correo
        $mail->Password = 'jmxuifsskghzarmw';  // Tu contraseña de aplicación (no uses tu contraseña normal)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configuración del correo
        $mail->setFrom('andervilchez1704@gmail.com', 'Soporte');  // Remitente
        $mail->addAddress($email);  // Destinatario

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Restablecer contraseña';
        $mail->Body = '<p>Haz solicitado restablecer tu contraseña. Haz clic en el siguiente enlace para continuar:</p>
                       <p><a href="http://localhost:3000/app/vista/restablecer_contrasena.php?token=' . $token . '">Restablecer contraseña</a></p>';

        // Enviar correo
        if (!$mail->send()) {
            throw new Exception('Error al enviar el correo: ' . addslashes($mail->ErrorInfo));
        }
    } catch (Exception $e) {
        echo '<script>alert("Error al enviar el correo: ' . addslashes($e->getMessage()) . '");</script>';
    }
}
?>