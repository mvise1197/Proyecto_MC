<?php
session_start();
require_once '../controlador/PersonalController.php';

$controller = new PersonalController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'nombre' => $_POST['nombre'],
        'apellidos' => $_POST['apellidos'],
        'usuario' => $_POST['usuario'],
        'clave' => $_POST['clave'],
        'correo' => $_POST['correo'],
        'idTipo_Usuario' => $_POST['idTipo_Usuario'],
        'idInstitucion' => $_POST['idInstitucion']
    ];
    $controller->create($data);
    // Almacenar mensaje de éxito en la sesión
    $_SESSION['mensaje'] = 'Usuario registrado exitosamente.';
    // Redirigir de vuelta a la lista de personal después de crear
    header('Location: listarpersonal.php');
    exit();
}

// Obtener las instituciones y tipos de usuario para los comboboxes
$instituciones = $controller->getInstituciones();
$tiposUsuario = $controller->getTiposUsuario();

$title = "Registrar Nuevo Personal";
$additional_css = '<link rel="stylesheet" href="../../public/css/styles_create.css">';
ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrar Nuevo Personal</title>
  <link rel="stylesheet" href="../../public/css/styles_inicio.css">
  <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../public/css/styles_create.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <div class="create-container">
    <h1>Registrar Nuevo Personal</h1>
    <form id="createForm" method="post" action="create.php">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
      </div>
      <div class="mb-3">
        <label for="apellidos" class="form-label">Apellidos</label>
        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
      </div>
      <div class="mb-3">
        <label for="usuario" class="form-label">Usuario</label>
        <input type="text" class="form-control" id="usuario" name="usuario" required>
      </div>
      <div class="mb-3">
        <label for="clave" class="form-label">Clave</label>
        <input type="password" class="form-control" id="clave" name="clave" required>
      </div>
      <div class="mb-3">
        <label for="correo" class="form-label">Correo</label>
        <input type="email" class="form-control" id="correo" name="correo" required>
      </div>
      <div class="mb-3">
        <label for="idTipo_Usuario" class="form-label">Tipo de Usuario</label>
        <select class="form-select" id="idTipo_Usuario" name="idTipo_Usuario" required>
          <option value="" disabled selected>Seleccione un tipo de usuario</option>
          <?php foreach ($tiposUsuario as $tipo): ?>
            <option value="<?php echo $tipo['idTipo_Usuario']; ?>"><?php echo $tipo['Tipo']; ?></option>
          <?php endforeach; ?>
        </select>
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
      <button type="button" onclick="cargarSeccion('listpersonal')" class="btn btn-secondary">Cancelar</button>
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
      const usuario = document.getElementById('usuario').value.trim();
      const clave = document.getElementById('clave').value.trim();
      const correo = document.getElementById('correo').value.trim();
      const idTipoUsuario = document.getElementById('idTipo_Usuario').value;
      const idInstitucion = document.getElementById('idInstitucion').value;

      if (!nombre || !apellidos || !usuario || !clave || !correo || !idTipoUsuario || !idInstitucion) {
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
