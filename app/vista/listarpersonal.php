<?php
session_start();

// Verificar si hay sesión activa
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

require_once '../controlador/PersonalController.php';
$controller = new PersonalController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_id'])) {
    $controller->delete($_POST['eliminar_id']);
    // Almacenar mensaje de éxito en la sesión
    $_SESSION['mensaje'] = 'Usuario eliminado exitosamente.';
    // Redirigir a la lista de personal
    header("Location: /app/vista/listarpersonal.php");
    exit();
}

// Obtener lista de personal
$personales = $controller->read();

// Configuración para la plantilla base
$title = "Lista de Personal";
ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Personal</title>
  <link rel="stylesheet" href="../../public/css/styles_inicio.css">
  <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../public/css/styles_listar.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="listar-container">
    <h1>Lista de Personal</h1>
    <button onclick="cargarFormularioCrear('personal')" class="btn btn-primary mb-3">Registrar Nuevo Personal</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($personales as $personal): ?>
            <tr>
                <td><?php echo htmlspecialchars($personal['idPersonal']); ?></td>
                <td><?php echo htmlspecialchars($personal['Nombre']); ?></td>
                <td><?php echo htmlspecialchars($personal['Apellidos']); ?></td>
                <td><?php echo htmlspecialchars($personal['Usuario']); ?></td>
                <td><?php echo htmlspecialchars($personal['Correo']); ?></td>
                <td>
                    <!-- Botón Editar -->
                    <a href="update_personal.php?id=<?php echo $personal['idPersonal']; ?>" class="btn btn-warning">✏️</a>
                    <!-- Botón para eliminar con SweetAlert2 -->
                    <button class="btn btn-danger" onclick="confirmarEliminacion('<?php echo $personal['idPersonal']; ?>')">🗑️</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (isset($_SESSION['mensaje'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '<?php echo $_SESSION['mensaje']; ?>',
            confirmButtonText: 'Aceptar'
        });
    </script>
    <?php unset($_SESSION['mensaje']); endif; ?>

</div>

<script src="../../public/js/bootstrap.bundle.min.js"></script>
<script src="../../public/js/scripts.js" defer></script>
<script>
  function confirmarEliminacion(id) {
    Swal.fire({
      title: '¿Estás seguro?',
      text: "No podrás revertir esta acción.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = ''; // Aquí puedes especificar la ruta deseada, si es necesario.
        
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'eliminar_id';
        input.value = id;
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
      }
    });
  }
</script>

</body>
</html>

<?php
$content = ob_get_clean();
include 'base.php';
?>