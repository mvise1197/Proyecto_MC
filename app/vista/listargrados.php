<?php
session_start();

// Verificar si hay sesión activa
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

require_once '../controlador/GradoController.php';
$controller = new GradoController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_id'])) {
  $resultado = $controller->delete($_POST['eliminar_id']);
  if ($resultado['success']) {
    $_SESSION['mensaje'] = $resultado['message'];
  } else {
    $_SESSION['error'] = $resultado['message'];
  }
  header("Location: /app/vista/listargrados.php");
  exit();
}

// Obtener lista de grados
$grados = $controller->read();

//FRAGMENTO DE PRUEBA
//VERIFICAR SI SE ENVIÓ EL TÉRMINO DE BUSQUEDA
$query = isset($_GET["query"]) ? trim($_GET["query"]) :null;
//OBTENER LISTA FILTRADA
if($query){
    $grados = $controller->buscar($query); //CON ESTE MÉTODO VOY A BUSCAR AL PERSONAL
}
else{
    $grados = $controller->read();//SE OBTIENE TODA LA LISTA
}

// Configuración para la plantilla base
$title = "Lista de Grados";
ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Grados</title>
  <link rel="stylesheet" href="../../public/css/styles_inicio.css">
  <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../public/css/styles_listar.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="listar-container">
    <h1>Lista de Grados</h1>
    <div>
        <div>
          <button onclick="cargarFormularioCrear('grados')" class="btn btn-primary mb-3">Registrar Nuevo Grado</button>
        </div>
        <div>
            <section id="buscar" class="mb-3">
                <form method="get" action="listargrados.php">
                    <input type="text" name="query" id="query" placeholder="Buscar Grado" class="form-control"/>
                    <button type="submit" class="btn btn-primary mt-2">Buscar</button>
                </form>
            </section>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Grado</th>
                <th>Sección</th>
                <th>Profesor Tutor</th>
                <th>Institución</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($grados as $grado): ?>
            <tr>
                <td><?php echo htmlspecialchars($grado['idGrado']); ?></td>
                <td><?php echo htmlspecialchars($grado['Nombre_Grado']); ?></td>
                <td><?php echo htmlspecialchars($grado['Seccion']); ?></td>
                <td><?php echo htmlspecialchars($grado['Tutor']); ?></td>
                <td><?php echo htmlspecialchars($grado['Nombre_Institucion']); ?></td>
                <td>
                    <!-- Botón Editar -->
                    <a href="update_grado.php?id=<?php echo $grado['idGrado']; ?>" class="btn btn-warning">✏️</a>
                    <!-- Botón para eliminar con SweetAlert2 -->
                    <button class="btn btn-danger" onclick="confirmarEliminacion('<?php echo $grado['idGrado']; ?>')">🗑️</button>
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

    <!-- Modificado: Mostrar mensajes de error -->
    <?php if (isset($_SESSION['error'])): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?php echo $_SESSION['error']; ?>',
            confirmButtonText: 'Aceptar'
        });
    </script>
    <?php unset($_SESSION['error']); endif; ?>

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
        form.action = 'listargrados.php';
        
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
