<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="../../public/css/styles_inicio.css">
  <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
  <?php if (isset($additional_css)) echo $additional_css; ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <div class="container_fluid">
    <!-- Botón para colapsar el menú -->
    <button id="menu-toggle" class="menu-toggle">☰</button>

    <!-- Menú lateral -->
    <nav class="sidebar">
      <h2>I.E. TENIENTE MIGUEL CORTES DEL CASTILLO <br> PIURA</h2>
      <ul>
        <li><a href="#" onclick="cargarSeccion('inicio')">Inicio</a></li>
        <li><a href="#" onclick="cargarSeccion('usuarios')">Usuarios</a></li>
        <li><a href="#" onclick="cargarSeccion('grados')">Grados y Secciones</a></li>
        <li><a href="#" onclick="cargarSeccion('curso')">Cursos</a></li>
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
        <?php echo $content; ?>
      </section>
    </main>
  </div>

  <script src="../../public/js/bootstrap.bundle.min.js"></script>
  <script src="../../public/js/scripts.js" defer></script>
  <script>
    // Código JavaScript para el menú lateral
    document.addEventListener("DOMContentLoaded", function () {
      const menuToggle = document.getElementById("menu-toggle");
      const sidebar = document.querySelector(".sidebar");

      menuToggle.addEventListener("click", function () {
        sidebar.classList.toggle("active");
      });
    });
  </script>
</body>
</html>
