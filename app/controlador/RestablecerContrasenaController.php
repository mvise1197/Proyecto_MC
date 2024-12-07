<?php
require_once '../modelo/Database.php';
require_once '../modelo/Usuario.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Conexión a la base de datos
    $db = new Database();
    $usuarioModel = new Usuario($db->getConnection());

    // Verificar si el token es válido y no ha expirado
    $result = $usuarioModel->verificarToken($token);

    if ($result->num_rows > 0) {
        // Verificar la expiración del token
        $row = $result->fetch_assoc();
        $idPersonal = $row['idPersonal'];
        $token_expiration = $row['token_expiration'];

        $currentDate = date('Y-m-d H:i:s');
        if ($currentDate < $token_expiration) {
            // Token válido, permitir cambio de contraseña
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nueva_clave = $_POST['nueva_clave'];

                // Actualizar la contraseña en la base de datos
                if ($usuarioModel->actualizarContrasena($idPersonal, $nueva_clave)) {
                    echo '<script>
                            alert("Contraseña actualizada exitosamente.");
                            window.location.href = "../vista/login.php"; // Redirige al login
                          </script>';
                    exit(); // Detener ejecución después de enviar el script
                } else {
                    echo 'Error al actualizar la contraseña.';
                }
            }
        } else {
            echo 'El token ha expirado.';
        }
    } else {
        echo 'Token inválido.';
    }
}
?>