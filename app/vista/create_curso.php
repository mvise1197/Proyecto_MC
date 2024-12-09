<?php
session_start();
require_once '../controlador/CursoController.php';

$controller = new CursoController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'nombre_curso' => $_POST['nombre_curso'],
        'idGrado' => $_POST['idGrado']
    ];
    $controller->create($data);
    // Almacenar mensaje de éxito en la sesión
    $_SESSION['mensaje'] = 'Curso registrado exitosamente.';
    // Redirigir de vuelta a la lista de cursos después de crear
    header('Location: listarcurso.php');
    exit();
}

// Obtener los grados para el combobox
$grados = $controller->getGrados();

$title = "Registrar Nuevo Curso";
$additional_css = '<link rel="stylesheet" href="../../public/css/styles_create.css">';
ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrar Nuevo Curso</title>
  <link rel="stylesheet" href="../../public/css/styles_inicio.css">
  <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../public/css/styles_create.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <div class="create-container">
    <h1>Registrar Nuevo Curso</h1>
    <form id="createForm" method="post" action="create.php">
      <div class="mb-3">
        <label for="nombre_curso" class="form-label">Nombre del Curso</label>
        <input type="text" class="form-control" id="nombre_curso" name="nombre_curso" required>
      </div>
      <div class="mb-3">
        <label for="idGrado" class="form-label">Grado</label>
        <select class="form-select" id="idGrado" name="idGrado" required>
          <option value="" disabled selected>Seleccione un grado</option>
          <?php foreach ($grados as $grado): ?>
            <option value="<?php echo $grado['idGrado']; ?>"><?php echo $grado['Grado']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Registrar</button>
      <button type="button" onclick="cargarSeccion('cursos')" class="btn btn-secondary">Cancelar</button>
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

      const nombre_curso = document.getElementById('nombre_curso').value.trim();
      const idGrado = document.getElementById('idGrado').value;

      if (!nombre_curso || !idGrado) {
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
