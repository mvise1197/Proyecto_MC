<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="../../public/css/styles_inicio.css">
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
    <?php if (isset($additional_css)) echo $additional_css; ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body>
    <div class="container_fluid">
      <!-- Botón para colapsar el menú -->
      <button id="menu-toggle" class="menu-toggle">☰</button>

      <!-- Menú lateral -->
      <?php include('menu.php'); ?>

      <!-- Contenido principal -->
      <main class="main-content">
        <section id="contenido">
          <?php echo $content; ?>
        </section>
      </main>
    </div>

    <script src="../../public/js/bootstrap.bundle.min.js"></script>
    <script src="../../public/js/scripts.js" defer></script>
  </body>
</html>
