<?php
require_once '../modelo/EstudianteModel.php';

class EstudianteController
{
    private $model;

    public function __construct()
    {
        $this->model = new EstudianteModel();
    }

    public function create($data)
    {
        // Modificado para coincidir con los datos de la tabla Estudiante
        return $this->model->create($data['Nombre'], $data['Apellidos'], $data['DNI'], $data['Codigo_Est'], $data['idGrado']);
    }

    public function read()
    {
        return $this->model->read();
    }

    // Nuevo método para obtener un estudiante por ID
    public function readById($idEstudiante)
    {
        return $this->model->readById($idEstudiante);
    }

    public function update($data)
    {
        // Modificado para coincidir con los datos de la tabla Estudiante
        return $this->model->update($data['idEstudiante'], $data['Nombre'], $data['Apellidos'], $data['DNI'], $data['Codigo_Est'], $data['idGrado']);
    }

    public function delete($idEstudiante)
    {
        $resultado = $this->model->delete($idEstudiante);
        if (!$resultado) {
            return ['success' => false, 'message' => 'No se puede eliminar este registro porque está relacionado con otros datos.'];
        }
        return ['success' => true, 'message' => 'Usuario eliminado exitosamente.'];
    }

    // Método para obtener los grados
    public function getGrados()
    {
        return $this->model->getGrados();
    }
}
?>
