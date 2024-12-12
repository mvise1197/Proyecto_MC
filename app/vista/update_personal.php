<?php
session_start();

// Verificar si hay sesión activa
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

require_once '../controlador/PersonalController.php';
$controller = new PersonalController();

// Verificar si se ha enviado un ID para actualizar
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $personal = $controller->readById($id); // Método para obtener los datos del personal por ID
} else {
    header('Location: listarpersonal.php');
    exit();
}

// Manejar la actualización del personal
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'idPersonal' => $id,
        'Nombre' => $_POST['nombre'],
        'Apellidos' => $_POST['apellidos'],
        'Usuario' => $_POST['usuario'],
        'Clave' => $_POST['clave'],
        'Correo' => $_POST['correo'],
        'idTipo_Usuario' => $_POST['idTipo_Usuario'],
        'idInstitucion' => $_POST['idInstitucion']
    ];
    
    // Actualiza el personal, pasando la clave solo si no está vacía
    if (empty($data['clave'])) {
        unset($data['clave']);
    }
    
    $controller->update($data);
    header('Location: listarpersonal.php');
    exit();
}

// Obtener las instituciones y tipos de usuario para los comboboxes
$instituciones = $controller->getInstituciones();
$tiposUsuario = $controller->getTiposUsuario();

$title = "Actualizar Personal";
ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actualizar Personal</title>
  <link rel="stylesheet" href="../../public/css/styles_inicio.css">
  <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../public/css/styles_update.css"> <!-- CSS personalizado -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Incluir SweetAlert2 -->
</head>
<body>
  <div class="update-container">
    <h1>Actualizar Personal</h1>
    <form id="updateForm" method="post" action="update.php?id=<?php echo $personal['idPersonal']; ?>">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($personal['Nombre']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="apellidos" class="form-label">Apellidos</label>
        <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($personal['Apellidos']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="usuario" class="form-label">Usuario</label>
        <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo htmlspecialchars($personal['Usuario']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="clave" class="form-label">Nueva Clave (dejar en blanco si no desea cambiarla)</label>
        <input type="password" class="form-control" id="clave" name="clave">
      </div>
      <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($personal['Correo']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="idTipo_Usuario" class="form-label">Tipo de Usuario</label>
        <select class="form-select" id="idTipo_Usuario" name="idTipo_Usuario" required>
          <?php foreach ($tiposUsuario as $tipo): ?>
            <option value="<?php echo $tipo['idTipo_Usuario']; ?>" <?php echo ($tipo['idTipo_Usuario'] == $personal['idTipo_Usuario']) ? 'selected' : ''; ?>>
              <?php echo $tipo['Tipo']; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="idInstitucion" class="form-label">Institución</label>
        <select class="form-select" id="idInstitucion" name="idInstitucion" required>
          <?php foreach ($instituciones as $institucion): ?>
            <option value="<?php echo $institucion['idInstitucion']; ?>" <?php echo ($institucion['idInstitucion'] == $personal['idInstitucion']) ? 'selected' : ''; ?>>
              <?php echo $institucion['Nombre']; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Actualizar</button>
      <a href="listarpersonal.php" class="btn btn-secondary">Cancelar</a>
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
                  window.location.href = 'listarpersonal.php'; // Redirigir después de la alerta
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