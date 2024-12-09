<?php
session_start();

// Verificar si hay sesión activa
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

require_once '../controlador/CursoController.php';
$controller = new CursoController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_id'])) {
    $controller->delete($_POST['eliminar_id']);
    // Almacenar mensaje de éxito en la sesión
    $_SESSION['mensaje'] = 'Curso eliminado exitosamente.';
    // Redirigir a la lista de cursos
    header("Location: /app/vista/listarcursos.php");
    exit();
}

// Obtener lista de cursos
$cursos = $controller->read();

// Configuración para la plantilla base
$title = "Lista de Cursos";
ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Cursos</title>
  <link rel="stylesheet" href="../../public/css/styles_inicio.css">
  <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../public/css/styles_listar.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="listar-container">
    <h1>Lista de Cursos</h1>
    <button onclick="cargarFormularioCrear('curso')" class="btn btn-primary mb-3">Registrar Nuevo Curso</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Curso</th>
                <th>Grado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cursos as $curso): ?>
            <tr>
                <td><?php echo htmlspecialchars($curso['idCurso']); ?></td>
                <td><?php echo htmlspecialchars($curso['Nombre_Curso']); ?></td>
                <td><?php echo htmlspecialchars($curso['idGrado']); ?></td> <!-- Suponiendo que idGrado es un valor representativo del grado -->
                <td>
                    <!-- Botón Editar -->
                    <a href="update_curso.php?id=<?php echo $curso['idCurso']; ?>" class="btn btn-warning">✏️</a>
                    <!-- Botón para eliminar con SweetAlert2 -->
                    <button class="btn btn-danger" onclick="confirmarEliminacion('<?php echo $curso['idCurso']; ?>')">🗑️</button>
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