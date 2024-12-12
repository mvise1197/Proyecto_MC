<?php
session_start();

// Verificar si hay sesión activa
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

require_once '../controlador/EstudianteController.php';
$controller = new EstudianteController();

// Verificar si se ha enviado un ID para actualizar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $estudiante = $controller->readById($id); // Método para obtener los datos del estudiante por ID
        if (!$estudiante) {
            throw new Exception("Estudiante no encontrado.");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: listarEstudiantes.php');
        exit();
    }
} else {
    header('Location: listarEstudiantes.php');
    exit();
}

// Manejar la actualización del estudiante
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $data = [
            'idEstudiante' => $id,
            'Nombre' => trim($_POST['nombre']),
            'Apellidos' => trim($_POST['apellidos']),
            'DNI' => trim($_POST['dni']),
            'Codigo_Est' => trim($_POST['codigo_est']),
            'idGrado' => $_POST['idGrado']
        ];

        // Validar campos requeridos
        if (empty($data['Nombre']) || empty($data['Apellidos']) || empty($data['DNI']) || empty($data['Codigo_Est']) || empty($data['idGrado'])) {
            throw new Exception("Todos los campos son requeridos.");
        }

        $controller->update($data);
        $_SESSION['mensaje'] = "El estudiante se ha actualizado correctamente.";
        header('Location: listarEstudiantes.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}

// Obtener los grados para el combobox
$grados = $controller->getGrados();

$title = "Actualizar Estudiante";
ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actualizar Estudiante</title>
  <link rel="stylesheet" href="../../public/css/styles_inicio.css">
  <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../public/css/styles_update.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <div class="update-container">
    <h1>Actualizar Estudiante</h1>
    <form id="updateForm" method="post" action="">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($estudiante['Nombre']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="apellidos" class="form-label">Apellidos</label>
        <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($estudiante['Apellidos']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="dni" class="form-label">DNI</label>
        <input type="text" class="form-control" id="dni" name="dni" value="<?php echo htmlspecialchars($estudiante['DNI']); ?>" maxlength="8" required>
      </div>
      <div class="mb-3">
        <label for="codigo_est" class="form-label">Código de Estudiante</label>
        <input type="text" class="form-control" id="codigo_est" name="codigo_est" value="<?php echo htmlspecialchars($estudiante['Codigo_Est']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="idGrado" class="form-label">Grado</label>
        <select class="form-select" id="idGrado" name="idGrado" required>
          <?php foreach ($grados as $grado): ?>
            <option value="<?php echo $grado['idGrado']; ?>" <?php echo ($grado['idGrado'] == $estudiante['idGrado']) ? 'selected' : ''; ?>>
              <?php echo $grado['Nombre_Grado']; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Actualizar</button>
      <a href="listarEstudiantes.php" class="btn btn-secondary">Cancelar</a>
    </form>

    <!-- Script para manejar la respuesta del formulario -->
    <script>
      document.getElementById('updateForm').addEventListener('submit', function(event) {
          event.preventDefault(); // Prevenir el envío por defecto

          const formData = new FormData(this);
          fetch(this.action, {
              method: 'POST',
              body: formData
          })
          .then(response => response.text())
          .then(data => {
              Swal.fire({
                  icon: 'success',
                  title: 'Actualización Exitosa',
                  text: 'El registro se ha actualizado correctamente.',
              }).then(() => {
                  window.location.href = 'listarEstudiantes.php';
              });
          })
          .catch(error => {
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Hubo un problema al actualizar el registro.',
              });
          });
      });
    </script>

  </div>

  <script src="../../public/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$content = ob_get_clean();
include 'base.php';
?>
