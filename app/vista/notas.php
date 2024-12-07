<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Notas</title>
</head>
<body>
    <h1>Gestión de Notas</h1>
    <form action="../controlador/crud_notas.php" method="POST">
        <label for="accion">Selecciona una acción:</label>
        <select id="accion" name="accion" onchange="mostrarCampos()">
            <option value="">-- Selecciona --</option>
            <option value="crear">Crear</option>
            <option value="leer">Leer</option>
            <option value="actualizar">Actualizar</option>
            <option value="eliminar">Eliminar</option>
        </select>
        <br><br>

        <!-- Campos comunes -->
        <div id="campos-comunes">
            <label for="idNotas">ID Notas (solo para actualizar o eliminar):</label>
            <input type="number" id="idNotas" name="idNotas">
            <br><br>
        </div>

        <!-- Campos para crear o actualizar -->
        <div id="campos-crear-actualizar" style="display: none;">
            <label for="idEstudiante">ID Estudiante:</label>
            <input type="number" id="idEstudiante" name="idEstudiante">
            <br><br>
            <label for="idCurso">ID Curso:</label>
            <input type="number" id="idCurso" name="idCurso">
            <br><br>
            <label for="idPeriodo">ID Periodo:</label>
            <input type="number" id="idPeriodo" name="idPeriodo">
            <br><br>
            <label for="nota1">Nota 1:</label>
            <input type="number" step="0.01" id="nota1" name="nota1">
            <br><br>
            <label for="nota2">Nota 2:</label>
            <input type="number" step="0.01" id="nota2" name="nota2">
            <br><br>
            <label for="nota3">Nota 3:</label>
            <input type="number" step="0.01" id="nota3" name="nota3">
            <br><br>
            <label for="nota4">Nota 4:</label>
            <input type="number" step="0.01" id="nota4" name="nota4">
            <br><br>
        </div>

        <button type="submit">Enviar</button>
    </form>

    <script>
        function mostrarCampos() {
            const accion = document.getElementById("accion").value;
            const camposCrearActualizar = document.getElementById("campos-crear-actualizar");
            const camposComunes = document.getElementById("campos-comunes");

            if (accion === "crear" || accion === "actualizar") {
                camposCrearActualizar.style.display = "block";
                camposComunes.style.display = "none";
            } else if (accion === "eliminar") {
                camposCrearActualizar.style.display = "none";
                camposComunes.style.display = "block";
            } else {
                camposCrearActualizar.style.display = "none";
                camposComunes.style.display = "none";
            }
        }
    </script>
</body>
</html>
