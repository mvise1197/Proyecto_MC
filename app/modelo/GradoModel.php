<?php
require_once 'Database.php';

class GradoModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function create($Nombre_Grado, $Seccion, $Tutor, $idInstitucion)
    {
        $stmt = $this->db->prepare("INSERT INTO Grado (Nombre_Grado, Seccion, Tutor, idInstitucion) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $Nombre_Grado, $Seccion, $Tutor, $idInstitucion);
        return $stmt->execute();
    }

    public function read()
    {
        $query = "
        SELECT g.idGrado, g.Nombre_Grado, g.Seccion, g.Tutor, i.Nombre AS Nombre_Institucion
        FROM Grado g
        INNER JOIN Institucion i ON g.idInstitucion = i.idInstitucion
        ";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //MÉTODO PARA BUSCAR UN REGISTRO
    public function buscar($query)
    {
        $stmt = $this->db->prepare("
            SELECT g.idGrado, g.Nombre_Grado, g.Seccion, g.Tutor, i.Nombre AS Nombre_Institucion
            FROM Grado g
            INNER JOIN Institucion i ON g.idInstitucion = i.idInstitucion
            WHERE g.idGrado LIKE ? 
            OR g.Nombre_Grado LIKE ? 
            OR g.Seccion LIKE ? 
            OR g.Tutor LIKE ? 
            OR i.Nombre LIKE ? -- Buscar también por nombre de la institución
        ");
        $likeQuery = '%' . $query . '%';
        $stmt->bind_param("sssss", $likeQuery, $likeQuery, $likeQuery, $likeQuery, $likeQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function update($idGrado, $Nombre_Grado, $Seccion, $Tutor, $idInstitucion)
    {
        $stmt = $this->db->prepare("UPDATE Grado SET Nombre_Grado=?, Seccion=?, Tutor=?, idInstitucion=? WHERE idGrado=?");
        $stmt->bind_param("sssii", $Nombre_Grado, $Seccion, $Tutor, $idInstitucion, $idGrado);
        return $stmt->execute();
    }

    public function readById($idGrado)
    {
        $stmt = $this->db->prepare("SELECT * FROM Grado WHERE idGrado=?");
        $stmt->bind_param("i", $idGrado);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function delete($idGrado)
    /*{
        $stmt = $this->db->prepare("DELETE FROM Grado WHERE idGrado=?");
        $stmt->bind_param("i", $idGrado);
        return $stmt->execute();
    }*/
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM Grado WHERE idGrado=?");
            $stmt->bind_param("i", $idGrado);
            $stmt->execute();
            return true; // Eliminación exitosa
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) { // Código 1451 indica restricción de clave foránea
                return false;
            }
            throw $e; // Re-lanzar otras excepciones
        }
    }
    

    public function getInstituciones()
    {
        $result = $this->db->query("SELECT idInstitucion, Nombre FROM Institucion");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
