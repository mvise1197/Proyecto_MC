<?php
session_start();

// Verificar si hay una sesión activa
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$usuario = $_SESSION['usuario'];
$title = "Inicio";
ob_start();
?>

<h1>Hola, <?= htmlspecialchars($usuario['nombre']); ?>. Bienvenido al Sistema Escolar</h1>

<?php
$content = ob_get_clean();
include 'base.php';
?>