<?php
session_start();

// Verificar si hay una sesión activa
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>I.E. TENIENTE MIGUEL CORTES DEL CASTILLO – PIURA</title>
  <link rel="stylesheet" href="../../public/css/styles_inicio.css">
  <script src="../../public/js/scripts.js" defer></script> <!-- Asegúrate de que el script se carga correctamente -->
</head>
<body>
  <div class="container">
    <!-- Botón para colapsar el menú -->
    <button id="menu-toggle" class="menu-toggle">☰</button>

    <!-- Menú lateral -->
    <nav class="sidebar">
      <h2>I.E. TENIENTE MIGUEL CORTES DEL CASTILLO <br> PIURA</h2><br><br>
      <ul>
        <li><a href="#" onclick="cargarSeccion('inicio')">Inicio</a></li>
        <li><a href="#" onclick="cargarSeccion('usuarios')">Usuarios</a></li>
        <li><a href="#" onclick="cargarSeccion('grados')">Grados y Secciones</a></li>
        <li><a href="#" onclick="cargarSeccion('estudiantes')">Estudiantes</a></li>
        <li><a href="#" onclick="cargarSeccion('asistencias')">Asistencias</a></li>
        <li><a href="#" onclick="cargarSeccion('notas')">Notas</a></li>
        <li><a href="#" onclick="cargarSeccion('reportes')">Reportes</a></li>
        <li><a href="#" onclick="cargarSeccion('configuracion')">Configuración</a></li>
        <li><a href="../controlador/AutenticacionController.php?action=logout" class="logout-btn">Cerrar Sesión</a></li>
      </ul>
    </nav>

    <!-- Contenido principal -->
    <main class="main-content">
      <section id="contenido">
        <h1>Hola, <?= htmlspecialchars($usuario['nombre']); ?>. Bienvenido al Sistema Escolar</h1>
      </section>
    </main>
  </div>
</body>
</html> 