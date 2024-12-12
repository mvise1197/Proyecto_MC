<?php
require_once 'Database.php';

class PersonalModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }    

    public function create($nombre, $apellidos, $usuario, $clave, $correo, $idTipo_Usuario, $idInstitucion)
    {
        $clave_encriptada = password_hash($clave, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO Personal (Nombre, Apellidos, Usuario, Clave, Correo, idTipo_Usuario, idInstitucion) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssis", $nombre, $apellidos, $usuario, $clave_encriptada, $correo, $idTipo_Usuario, $idInstitucion);
        return $stmt->execute();
    }

    public function read()
    {
        $result = $this->db->query("SELECT * FROM Personal");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //MÉTODO PARA BUSCAR UN REGISTRO
    public function buscar($query)
    {
        $stmt = $this->db->prepare("
            SELECT * 
            FROM Personal 
            WHERE Nombre LIKE ? 
            OR Apellidos LIKE ? 
            OR Usuario LIKE ? 
            OR Correo LIKE ?
        ");
        $likeQuery = '%' . $query . '%';
        $stmt->bind_param("ssss", $likeQuery, $likeQuery, $likeQuery, $likeQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function update($idPersonal, $nombre, $apellidos, $usuario, $correo, $idTipo_Usuario, $idInstitucion, $clave = null)
    {
        if ($clave) {
            $clave_encriptada = password_hash($clave, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE Personal SET Nombre=?, Apellidos=?, Usuario=?, Clave=?, Correo=?, idTipo_Usuario=?, idInstitucion=? WHERE idPersonal=?");
            $stmt->bind_param("sssssisi", $nombre, $apellidos, $usuario, $clave_encriptada, $correo, $idTipo_Usuario, $idInstitucion, $idPersonal);
        } else {
            // Si no se proporciona una nueva clave, no se actualiza
            $stmt = $this->db->prepare("UPDATE Personal SET Nombre=?, Apellidos=?, Usuario=?, Correo=?, idTipo_Usuario=?, idInstitucion=? WHERE idPersonal=?");
            // Asegúrate de que 's' es para string y 'i' es para integer
            $stmt->bind_param("ssssssi", $nombre, $apellidos, $usuario, $correo, $idTipo_Usuario, $idInstitucion, $idPersonal);
        }
        return $stmt->execute();
    }
    public function readById($idPersonal)
    {
        $stmt = $this->db->prepare("SELECT * FROM Personal WHERE idPersonal=?");
        $stmt->bind_param("i", $idPersonal);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    //SE ESTÁ MODIFICANDO ESTE SEGMENTO PARA MANEJAR ERROR DE BORRAR

    /*public function delete($idPersonal)
    {
        $stmt = $this->db->prepare("DELETE FROM Personal WHERE idPersonal=?");
        $stmt->bind_param("i", $idPersonal);
        return $stmt->execute();
    }*/

    //SE ESTÁ MANEJANDO CON ESTE NUEVO SEGMENTO DE CÓDIGO / BORRAR EN CASO DE QUE FALLE
    public function delete($idPersonal)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM Personal WHERE idPersonal=?");
            $stmt->bind_param("i", $idPersonal);
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

    public function getTiposUsuario()
    {
        $result = $this->db->query("SELECT idTipo_Usuario, Tipo FROM Tipo_Usuario");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>