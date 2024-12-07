<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../public/css/styles_login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <img src="../../public/img/fondo.png" class="login-image">
            <h2>Iniciar Sesión</h2>
            <form action="../controlador/AutenticacionController.php" method="POST">
                <input type="hidden" name="action" value="login"> <!-- Añadir campo oculto para la acción -->
                <div class="input-group">
                    <label for="login">Usuario o Correo Electrónico</label> <!-- Cambiado el label -->
                    <input type="text" id="login" name="login" placeholder="Ingresa tu Usuario o Correo" required> <!-- Cambiado el nombre del campo -->
                </div>
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Ingresa tu Contraseña" required>
                </div>
                <div class="options">
                    <label>
                        <input type="checkbox"> Recordar
                    </label>
                    <a href="../vista/recuperar_contrasena.php">¿Olvidaste tu contraseña?</a>
                </div>
                <button type="submit" class="login-btn">Iniciar Sesión</button>
                <!-- Botón para redirigir a la página de registro -->
                <div>
                    <p class="create-account">
                        ¿No tienes una cuenta?
                        <a href="../vista/registro.php" class="register-btn">Registrar Usuario</a>
                    </p>
                    <p class="soporte">
                        <a href="#">Contactar con Soporte</a>
                    </p>
                </div>
            </form>

            <?php if (isset($_GET['error'])): ?>
                <p style="color: red;">Credenciales incorrectas. Por favor intenta nuevamente.</p>
            <?php endif; ?>

            <?php if (isset($_GET['registered'])): ?>
                <p style="color: green;">Registro exitoso. Ahora puedes iniciar sesión.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>