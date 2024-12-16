<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="../../public/css/styles_inicio.css">
</head>
<body><!-- menu.php -->
<nav class="sidebar">
    <div class="menu-logo">
        <img src="../../public/img/logo.png" class="img_menu">
    </div>
    <!-- Menú -->
    <ul>
        <li><a href="#" onclick="cargarSeccion('inicio')">Inicio</a></li>
        <li><a href="#" onclick="cargarSeccion('personal')">Personal</a></li>
        <!-- Matrículas y Estudiantes -->
        <li class="has-submenu">
            <a href="#">Matrículas y Estudiantes</a>
            <ul class="submenu">
                <li><a href="#" onclick="cargarSeccion('mat_pag')">Matrículas y pagos</a></li>
                <li><a href="#" onclick="cargarSeccion('mat_est')">Matrícula de estudiantes</a></li>
                <li><a href="#" onclick="cargarSeccion('estudiantes')">Estudiantes</a></li>
            </ul>
        </li>
        <!-- Gestión Académica -->
        <li class="has-submenu">
            <a href="#">Gestión Académica</a>
            <ul class="submenu">
                <li><a href="#" onclick="cargarSeccion('grados')">Grados y Secciones</a></li>
                <li><a href="#" onclick="cargarSeccion('curso')">Cursos</a></li>
                <li><a href="#" onclick="cargarSeccion('nota')">Notas</a></li>
                <li><a href="#" onclick="cargarSeccion('plan')">Plan de estudios</a></li>
                <li><a href="#" onclick="cargarSeccion('horarios')">Programación de Horarios</a></li>
            </ul>
        </li>
        <!-- Control y Reportes -->
        <li class="has-submenu">
            <a href="#">Control y Reportes</a>
            <ul class="submenu">
                <li><a href="#" onclick="cargarSeccion('asistencias')">Control de asistencia</a></li>
                <li><a href="#" onclick="cargarSeccion('certificaciones')">Certificados</a></li>
                <li><a href="#" onclick="cargarSeccion('calendario')">Calendario escolar</a></li>
                <li><a href="#" onclick="cargarSeccion('reportes')">Reportes académicos</a></li>
            </ul>
        </li>
        <!-- Configuración -->
        <li class="has-submenu">
            <a href="#">Configuración</a>
            <ul class="submenu">
                <li><a href="#" onclick="cargarSeccion('configuracion')">Inventarios</a></li>
                <li><a href="#" onclick="cargarSeccion('rrhh')">Gestión RRHH</a></li>
            </ul>
        </li>
        <li><a href="../controlador/AutenticacionController.php?action=logout" class="logout-btn">Cerrar Sesión</a></li>
    </ul>
</nav>
</body>
</html>