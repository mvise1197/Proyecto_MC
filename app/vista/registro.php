<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../../public/css/styles_login.css"> <!-- Cambiado a registro.css -->
</head>
<body>
    <div class="register-container">
        <div class="login-card">
            <img src="../../public/img/fondo.png" class="login-image">
            <h2>Registro de Usuario</h2>
            <form action="../controlador/AutenticacionController.php" method="POST">
                <input type="hidden" name="action" value="register">
                <div class="input-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="input-group">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" required>
                </div>
                <div class="input-group">
                    <label for="correo">Correo Electrónico:</label> <!-- Campo para el correo -->
                    <input type="email" id="correo" name="correo" required> <!-- Tipo email para validación -->
                </div>
                <div class="input-group">
                    <label for="usuario">Usuario:</label>
                    <input type="text" id="usuario" name="usuario" required>
                </div>
                <div class="input-group">
                    <label for="clave">Clave:</label>
                    <input type="password" id="clave" name="clave" required>
                </div>
                <div class="select-group">
                    <label for="tipo_usuario">Tipo de Usuario:</label>
                    <select id="tipo_usuario" name="tipo_usuario" required>
                        <option value="">Seleccionar usuario</option> <!-- Opción por defecto -->
                        <option value="1">Administrador</option>
                        <option value="2">Docente</option>
                        <option value="3">Padre</option>
                        <option value="4">Alumno</option>
                    </select>
                </div>
                <p></p>
                <button type="submit" class="register_btn">Registrar</button>
                <p class="create-account">
                    <a href="../vista/login.php" class="back-btn">Regresar al inicio de sesión</a> 
                </p>
                <!--ALERTE DE REGISTRO COMPLETO O ERROR-->
                <?php if (isset($_GET['registered'])) : ?>
                    <p class="success-message">Registro exitoso. Puedes iniciar sesión.</p>
                <?php elseif (isset($_GET['error'])) : ?>
                    <p class="error-message">Error en el registro. Intenta nuevamente.</p>
                <?php endif; ?>
            </form>

            <!-- Botón para regresar al login -->
            
        </div>
    </div>
</body>
</html>