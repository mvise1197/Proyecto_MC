<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="../../public/css/styles_login.css">
    <link rel="icon" href="../../public/img/logo.ico">
</head>
<body>
    <div class="register-container">
        <div class="login-card">
            <img src="../../public/img/fondo.png" class="login-image">
            <h2>Restablecer Contraseña</h2>
            <form action="../controlador/RecuperarContrasenaController.php" method="POST">
                <div class="input-group">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" required placeholder="Ingrese su correo electrónico">
                </div>
                <p></p>
                <button type="submit" class="register_btn">Enviar Solicitud</button>
                <p class="create-account">
                    <a href="../vista/login.php" class="back-btn">Regresar al inicio de sesión</a> 
                </p>
            </form>   
        </div>
    </div>
</body>
</html>