<?php
require_once '../modelo/Database.php';

$db = new Database();
$conexion = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    switch ($accion) {
        case 'crear':
            $fecha = $_POST['fecha'];
            $idEstudiante = $_POST['idEstudiante'];
            $inasistJustificada = $_POST['inasist_justificada'] ?? 'N';
            $inasistInjustificada = $_POST['inasist_injustificada'] ?? 'N';
            $tardJustificada = $_POST['tard_justificada'] ?? 'N';
            $tardInjustificada = $_POST['tard_injustificada'] ?? 'N';

            $sql = "INSERT INTO Asistencias (Fecha, Inasist_Justificada, Inasist_Injustificada, Tard_Justificada, Tard_Injustificada, idEstudiante)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sssssi", $fecha, $inasistJustificada, $inasistInjustificada, $tardJustificada, $tardInjustificada, $idEstudiante);

            if ($stmt->execute()) {
                echo "Asistencia registrada exitosamente.";
            } else {
                echo "Error al registrar asistencia: " . $stmt->error;
            }
            $stmt->close();
            break;

        case 'leer':
            $sql = "SELECT * FROM Asistencias";
            $resultado = $conexion->query($sql);
            $asistencias = [];
            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    $asistencias[] = $fila;
                }
            }
            echo json_encode($asistencias);
            break;

        case 'actualizar':
            $idAsistencias = $_POST['idAsistencias'];
            $fecha = $_POST['fecha'];
            $inasistJustificada = $_POST['inasist_justificada'];
            $inasistInjustificada = $_POST['inasist_injustificada'];
            $tardJustificada = $_POST['tard_justificada'];
            $tardInjustificada = $_POST['tard_injustificada'];

            $sql = "UPDATE Asistencias SET Fecha = ?, Inasist_Justificada = ?, Inasist_Injustificada = ?, Tard_Justificada = ?, Tard_Injustificada = ? WHERE idAsistencias = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sssssi", $fecha, $inasistJustificada, $inasistInjustificada, $tardJustificada, $tardInjustificada, $idAsistencias);

            if ($stmt->execute()) {
                echo "Asistencia actualizada exitosamente.";
            } else {
                echo "Error al actualizar asistencia: " . $stmt->error;
            }
            $stmt->close();
            break;

        case 'eliminar':
            $idAsistencias = $_POST['idAsistencias'];

            $sql = "DELETE FROM Asistencias WHERE idAsistencias = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("i", $idAsistencias);

            if ($stmt->execute()) {
                echo "Asistencia eliminada exitosamente.";
            } else {
                echo "Error al eliminar asistencia: " . $stmt->error;
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
