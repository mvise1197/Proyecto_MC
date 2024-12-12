<?php
require_once 'Database.php';

class CursoModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    // Método para crear un curso
    public function create($nombreCurso, $idGrado)
    {
        $stmt = $this->db->prepare("INSERT INTO Curso (Nombre_Curso, idGrado) VALUES (?, ?)");
        $stmt->bind_param("si", $nombreCurso, $idGrado);
        return $stmt->execute();
    }

    // Método para leer todos los cursos
    public function read()
    {
        $result = $this->db->query("SELECT * FROM Curso");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Método para actualizar un curso
    public function update($idCurso, $nombreCurso, $idGrado)
    {
        $stmt = $this->db->prepare("UPDATE Curso SET Nombre_Curso=?, idGrado=? WHERE idCurso=?");
        $stmt->bind_param("sii", $nombreCurso, $idGrado, $idCurso);
        return $stmt->execute();
    }

    // Método para obtener un curso por su ID
    public function readById($idCurso)
    {
        $stmt = $this->db->prepare("SELECT * FROM Curso WHERE idCurso=?");
        $stmt->bind_param("i", $idCurso);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Método para eliminar un curso
    public function delete($idCurso)
    /*{
        $stmt = $this->db->prepare("DELETE FROM Curso WHERE idCurso=?");
        $stmt->bind_param("i", $idCurso);
        return $stmt->execute();
    }*/
    
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM Curso WHERE idCurso=?");
            $stmt->bind_param("i", $idCurso);
            $stmt->execute();
            return true; // Eliminación exitosa
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) { // Código 1451 indica restricción de clave foránea
                return false;
            }
            throw $e; // Re-lanzar otras excepciones
        }
    }

    // Método para obtener los grados
    public function getGrados()
    {
        $result = $this->db->query("SELECT idGrado, Nombre_Grado FROM Grado");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
