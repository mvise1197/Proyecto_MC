<?php
session_start();
require_once '../controlador/EstudianteController.php';

$controller = new EstudianteController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'Nombre' => $_POST['nombre'],
        'Apellidos' => $_POST['apellidos'],
        'DNI' => $_POST['dni'],
        'Codigo_Est' => $_POST['codigo_est'],
        'idGrado' => $_POST['idGrado']
    ];
    $controller->create($data);
    // Almacenar mensaje de éxito en la sesión
    $_SESSION['mensaje'] = 'Estudiante registrado exitosamente.';
    // Redirigir de vuelta a la lista de estudiantes después de crear
    header('Location: listarestudiantes.php');
    exit();
}

// Obtener los grados para el combobox
$grados = $controller->getGrados();

$title = "Registrar Nuevo Estudiante";
$additional_css = '<link rel="stylesheet" href="../../public/css/styles_create.css">';
ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrar Nuevo Estudiante</title>
  <link rel="stylesheet" href="../../public/css/styles_inicio.css">
  <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../public/css/styles_create.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <div class="create-container">
    <h1>Registrar Nuevo Estudiante</h1>
    <form id="createForm" method="post" action="create_estudiante.php">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
      </div>
      <div class="mb-3">
        <label for="apellidos" class="form-label">Apellidos</label>
        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
      </div>
      <div class="mb-3">
        <label for="dni" class="form-label">DNI</label>
        <input type="text" class="form-control" id="dni" name="dni" maxlength="8" required>
      </div>
      <div class="mb-3">
        <label for="codigo_est" class="form-label">Código del Estudiante</label>
        <input type="text" class="form-control" id="codigo_est" name="codigo_est" required>
      </div>
      <div class="mb-3">
        <label for="idGrado" class="form-label">Grado</label>
        <select class="form-select" id="idGrado" name="idGrado" required>
          <option value="" disabled selected>Seleccione un grado</option>
          <?php foreach ($grados as $grado): ?>
            <option value="<?php echo $grado['idGrado']; ?>"><?php echo $grado['Nombre_Grado']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Registrar</button>
      <button type="button" onclick="cargarSeccion('estudiantes')" class="btn btn-secondary">Cancelar</button>
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

      const nombre = document.getElementById('nombre').value.trim();
      const apellidos = document.getElementById('apellidos').value.trim();
      const dni = document.getElementById('dni').value.trim();
      const codigoEst = document.getElementById('codigo_est').value.trim();
      const idGrado = document.getElementById('idGrado').value;

      if (!nombre || !apellidos || !dni || !codigoEst || !idGrado) {
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
