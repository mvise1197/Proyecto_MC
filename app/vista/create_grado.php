<?php
session_start();
require_once '../controlador/GradoController.php';

$controller = new GradoController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'nombre_grado' => $_POST['nombre_grado'],
        'seccion' => $_POST['seccion'],
        'tutor' => $_POST['tutor'],
        'idInstitucion' => $_POST['idInstitucion']
    ];
    $controller->create($data);
    // Almacenar mensaje de éxito en la sesión
    $_SESSION['mensaje'] = 'Grado registrado exitosamente.';
    // Redirigir de vuelta a la lista de grados después de crear
    header('Location: listagrados.php');
    exit();
}

// Obtener las instituciones para el combobox
$instituciones = $controller->getInstituciones();

$title = "Registrar Nuevo Grado";
$additional_css = '<link rel="stylesheet" href="../../public/css/styles_create.css">';
ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrar Nuevo Grado</title>
  <link rel="stylesheet" href="../../public/css/styles_inicio.css">
  <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../public/css/styles_create.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <div class="create-container">
    <h1>Registrar Nuevo Grado</h1>
    <form id="createForm" method="post" action="create.php">
      <div class="mb-3">
        <label for="nombre_grado" class="form-label">Nombre del Grado</label>
        <input type="text" class="form-control" id="nombre_grado" name="nombre_grado" required>
      </div>
      <div class="mb-3">
        <label for="seccion" class="form-label">Sección</label>
        <input type="text" class="form-control" id="seccion" name="seccion" required>
      </div>
      <div class="mb-3">
        <label for="tutor" class="form-label">Tutor</label>
        <input type="text" class="form-control" id="tutor" name="tutor" required>
      </div>
      <div class="mb-3">
        <label for="idInstitucion" class="form-label">Institución</label>
        <select class="form-select" id="idInstitucion" name="idInstitucion" required>
          <option value="" disabled selected>Seleccione una institución</option>
          <?php foreach ($instituciones as $institucion): ?>
            <option value="<?php echo $institucion['idInstitucion']; ?>"><?php echo $institucion['Nombre']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Registrar</button>
      <button type="button" onclick="cargarSeccion('grados')" class="btn btn-secondary">Cancelar</button>
    </form>
  </div>

  <?php if (isset($_SESSION['mensaje'])): ?>
  <script>
      Swal.fire({
          icon: 'success',
          title: 'Éxito',
          text: '<?php echo $_SESSION['mensaje']; ?>',
          confirmButtonText: 'Aceptar'
      });
  </script>
  <?php 
      // Limpiar el mensaje después de mostrarlo
      unset($_SESSION['mensaje']); 
  endif; ?>

  <script src="../../public/js/bootstrap.bundle.min.js"></script>
  <script src="../../public/js/scripts.js" defer></script>

  <!-- Validación personalizada con SweetAlert2 -->
  <script>
    document.getElementById('createForm').addEventListener('submit', function(event) {
      event.preventDefault(); // Prevenir el envío por defecto

      const nombreGrado = document.getElementById('nombre_grado').value.trim();
      const seccion = document.getElementById('seccion').value.trim();
      const tutor = document.getElementById('tutor').value.trim();
      const idInstitucion = document.getElementById('idInstitucion').value;

      if (!nombreGrado || !seccion || !tutor || !idInstitucion) {
        Swal.fire({
          icon: 'error',
          title: 'Campos vacíos',
          text: 'Por favor, complete todos los campos obligatorios.',
        });
        return;
      }

      // Si todos los campos están completos, enviar el formulario
      Swal.fire({
        icon: 'success',
        title: 'Formulario válido',
        text: '¡Registro exitoso!',
        preConfirm: () => {
          this.submit(); // Enviar formulario
        }
      });
    });
  </script>

</body>
</html>
