<?php
session_start();

// Verificar si hay sesión activa
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

require_once '../controlador/GradoController.php';
$controller = new GradoController();

// Verificar si se ha enviado un ID para actualizar
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $grado = $controller->readById($id); // Método para obtener los datos del grado por ID
} else {
    header('Location: listargrado.php');
    exit();
}

// Manejar la actualización del grado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'idGrado' => $id,
        'Nombre_Grado' => $_POST['Nombre_Grado'],
        'Seccion' => $_POST['Seccion'],
        'Tutor' => $_POST['Tutor'],
        'idInstitucion' => $_POST['idInstitucion']
    ];
    
    $controller->update($data);
    header('Location: listargrado.php');
    exit();
}

// Obtener las instituciones para el combobox
$instituciones = $controller->getInstituciones();

$title = "Actualizar Grado";
ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actualizar Grado</title>
  <link rel="stylesheet" href="../../public/css/styles_inicio.css">
  <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../public/css/styles_update.css"> <!-- CSS personalizado -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Incluir SweetAlert2 -->
</head>
<body>
  <div class="update-container">
    <h1>Actualizar Grado</h1>
    <form id="updateForm" method="post" action="update.php?id=<?php echo $grado['idGrado']; ?>">
      <div class="mb-3">
        <label for="Nombre_Grado" class="form-label">Nombre del Grado</label>
        <input type="text" class="form-control" id="Nombre_Grado" name="Nombre_Grado" value="<?php echo htmlspecialchars($grado['Nombre_Grado']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="Seccion" class="form-label">Sección</label>
        <input type="text" class="form-control" id="Seccion" name="Seccion" value="<?php echo htmlspecialchars($grado['Seccion']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="Tutor" class="form-label">Tutor</label>
        <input type="text" class="form-control" id="Tutor" name="Tutor" value="<?php echo htmlspecialchars($grado['Tutor']); ?>">
      </div>
      <div class="mb-3">
        <label for="idInstitucion" class="form-label">Institución</label>
        <select class="form-select" id="idInstitucion" name="idInstitucion" required>
          <?php foreach ($instituciones as $institucion): ?>
            <option value="<?php echo $institucion['idInstitucion']; ?>" <?php echo ($institucion['idInstitucion'] == $grado['idInstitucion']) ? 'selected' : ''; ?>>
              <?php echo $institucion['Nombre']; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Actualizar</button>
      <a href="listargradoS.php" class="btn btn-secondary">Cancelar</a>
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
                  text: 'El grado se ha actualizado correctamente.',
              }).then(() => {
                  window.location.href = 'listargrado.php'; // Redirigir después de la alerta
              });
          })
          .catch(error => {
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Hubo un problema al actualizar el grado.',
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
