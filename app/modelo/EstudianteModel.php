<?php
require_once 'Database.php';

class EstudianteModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function create($nombre, $apellidos, $dni, $codigo_est, $idGrado)
    {
        // Se elimina la clave y el correo, se adaptan los campos a la tabla Estudiante
        $stmt = $this->db->prepare("INSERT INTO Estudiante (Nombre, Apellidos, DNI, Codigo_Est, idGrado) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $nombre, $apellidos, $dni, $codigo_est, $idGrado);
        return $stmt->execute();
    }

    public function read()
    {
        $result = $this->db->query("SELECT * FROM Estudiante");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //MÉTODO PARA BUSCAR UN REGISTRO
    public function buscar($query)
    {
        $stmt = $this->db->prepare("
            SELECT * 
            FROM Estudiante 
            WHERE idEstudiante LIKE ? 
            OR Nombre LIKE ?
            OR Apellidos LIKE ? 
            OR DNI LIKE ? 
            OR Codigo_Est LIKE ? 
            OR idGrado LIKE ?
        ");
        $likeQuery = '%' . $query . '%';
        $stmt->bind_param("ssssss", $likeQuery, $likeQuery, $likeQuery, $likeQuery, $likeQuery, $likeQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function update($idEstudiante, $nombre, $apellidos, $dni, $codigo_est, $idGrado)
    {
        $stmt = $this->db->prepare("UPDATE Estudiante SET Nombre=?, Apellidos=?, DNI=?, Codigo_Est=?, idGrado=? WHERE idEstudiante=?");
        $stmt->bind_param("ssssii", $nombre, $apellidos, $dni, $codigo_est, $idGrado, $idEstudiante);
        return $stmt->execute();
    }

    public function readById($idEstudiante)
    {
        $stmt = $this->db->prepare("SELECT * FROM Estudiante WHERE idEstudiante=?");
        $stmt->bind_param("i", $idEstudiante);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function delete($idEstudiante)
    /*{
        $stmt = $this->db->prepare("DELETE FROM Estudiante WHERE idEstudiante=?");
        $stmt->bind_param("i", $idEstudiante);
        return $stmt->execute();
    }*/
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM Estudiante WHERE idEstudiante=?");
            $stmt->bind_param("i", $idEstudiante);
            $stmt->execute();
            return true; // Eliminación exitosa
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) { // Código 1451 indica restricción de clave foránea
                return false;
            }
            throw $e; // Re-lanzar otras excepciones
        }
    }

    public function getGrados()
{
    $result = $this->db->query("SELECT idGrado, Nombre_Grado, Seccion, Tutor FROM Grado");
    return $result->fetch_all(MYSQLI_ASSOC);
}
}
?>
