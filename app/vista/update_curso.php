<?php
session_start();

// Verificar si hay sesión activa
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

require_once '../controlador/CursoController.php'; // Cambiado a CursoController
$controller = new CursoController();

// Verificar si se ha enviado un ID para actualizar
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $curso = $controller->readById($id); // Método para obtener los datos del curso por ID
} else {
    header('Location: listarcurso.php');
    exit();
}

// Manejar la actualización del curso
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'idCurso' => $id,
        'nombre_curso' => $_POST['nombre_curso'], // Campo cambiado
        'idGrado' => $_POST['idGrado'] // Campo para grado
    ];
    
    $controller->update($data);
    header('Location: listarcurso.php'); // Redirige a la lista de cursos
    exit();
}

// Obtener los grados para el combobox
$grados = $controller->getGrados(); // Método para obtener los grados disponibles

$title = "Actualizar Curso";
ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actualizar Curso</title>
  <link rel="stylesheet" href="../../public/css/styles_inicio.css">
  <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../public/css/styles_update.css"> <!-- CSS personalizado -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Incluir SweetAlert2 -->
</head>
<body>
  <div class="update-container">
    <h1>Actualizar Curso</h1>
    <form id="updateForm" method="post" action="update.php?id=<?php echo $curso['idCurso']; ?>">
      <div class="mb-3">
        <label for="nombre_curso" class="form-label">Nombre del Curso</label>
        <input type="text" class="form-control" id="nombre_curso" name="nombre_curso" value="<?php echo htmlspecialchars($curso['Nombre_Curso']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="idGrado" class="form-label">Grado</label>
        <select class="form-select" id="idGrado" name="idGrado" required>
          <?php foreach ($grados as $grado): ?>
            <option value="<?php echo $grado['idGrado']; ?>" <?php echo ($grado['idGrado'] == $curso['idGrado']) ? 'selected' : ''; ?>>
              <?php echo $grado['Nombre']; ?> <!-- Asumiendo que 'Nombre' es el campo del grado -->
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Actualizar</button>
      <a href="listarcurso.php" class="btn btn-secondary">Cancelar</a>
    </form>

    <!-- Script para manejar la respuesta del formulario -->
    <script>
      document.getElementById('updateForm').addEventListener('submit', function(event) {
          event.preventDefault(); // Prevenir el envío por defecto

          // Enviar el formulario usando AJAX
          const formData = new FormData(this);
          fetch(this.action, {
              method: 'POST',
              body: formData
          })
          .then(response => response.text())
          .then(data => {
              // Mostrar alerta de éxito
              Swal.fire({
                  icon: 'success',
                  title: 'Actualización Exitosa',
                  text: 'El registro se ha actualizado correctamente.',
              }).then(() => {
                  window.location.href = 'listarcurso.php'; // Redirigir después de la alerta
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
