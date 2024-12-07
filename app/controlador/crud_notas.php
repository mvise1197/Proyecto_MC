<?php
require_once '../modelo/Database.php';

$db = new Database();
$conexion = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    switch ($accion) {
        case 'crear':
            $idEstudiante = $_POST['idEstudiante'];
            $idCurso = $_POST['idCurso'];
            $idPeriodo = $_POST['idPeriodo'];
            $nota1 = $_POST['nota1'];
            $nota2 = $_POST['nota2'];
            $nota3 = $_POST['nota3'];
            $nota4 = $_POST['nota4'];
            $promedio = ($_POST['nota1'] + $_POST['nota2'] + $_POST['nota3'] + $_POST['nota4']) / 4;

            $sql = "INSERT INTO Notas (idEstudiante, idCurso, idPeriodo, Nota1, Nota2, Nota3, Nota4, Promedio)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("iiiddddd", $idEstudiante, $idCurso, $idPeriodo, $nota1, $nota2, $nota3, $nota4, $promedio);

            if ($stmt->execute()) {
                echo "Nota registrada exitosamente.";
            } else {
                echo "Error al registrar nota: " . $stmt->error;
            }
            $stmt->close();
            break;

        case 'leer':
            $sql = "SELECT * FROM Notas";
            $resultado = $conexion->query($sql);
            $notas = [];
            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    $notas[] = $fila;
                }
            }
            echo json_encode($notas);
            break;

        case 'actualizar':
            $idNotas = $_POST['idNotas'];
            $nota1 = $_POST['nota1'];
            $nota2 = $_POST['nota2'];
            $nota3 = $_POST['nota3'];
            $nota4 = $_POST['nota4'];
            $promedio = ($_POST['nota1'] + $_POST['nota2'] + $_POST['nota3'] + $_POST['nota4']) / 4;

            $sql = "UPDATE Notas SET Nota1 = ?, Nota2 = ?, Nota3 = ?, Nota4 = ?, Promedio = ? WHERE idNotas = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("dddddi", $nota1, $nota2, $nota3, $nota4, $promedio, $idNotas);

            if ($stmt->execute()) {
                echo "Nota actualizada exitosamente.";
            } else {
                echo "Error al actualizar nota: " . $stmt->error;
            }
            $stmt->close();
            break;

        case 'eliminar':
            $idNotas = $_POST['idNotas'];

            $sql = "DELETE FROM Notas WHERE idNotas = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("i", $idNotas);

            if ($stmt->execute()) {
                echo "Nota eliminada exitosamente.";
            } else {
                echo "Error al eliminar nota: " . $stmt->error;
            }
            $stmt->close();
            break;

        default:
            echo "Acción no válida.";
            break;
    }
}

$conexion->close();
?>
