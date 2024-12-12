<?php
require_once '../modelo/GradoModel.php';

class GradoController
{
    private $model;

    public function __construct()
    {
        $this->model = new GradoModel();
    }

    public function create($data)
    {
        // Modificación para que coincida con los campos de la tabla Grado
        return $this->model->create($data['Nombre_Grado'], $data['Seccion'], $data['Tutor'], $data['idInstitucion']);
    }

    public function read()
    {
        return $this->model->read();
    }

    // Nuevo método para obtener un grado por ID
    public function readById($idGrado)
    {
        return $this->model->readById($idGrado);
    }

    //MÉTODO PARA BUSCAR UN REGISTRO
    public function buscar($query){
        return $this->model->buscar($query);
    }

    public function update($data)
    {
        // Actualización para que coincida con los campos de la tabla Grado
        return $this->model->update($data['idGrado'], $data['Nombre_Grado'], $data['Seccion'], $data['Tutor'], $data['idInstitucion']);
    }

    public function delete($idGrado)
    {
        $resultado = $this->model->delete($idGrado);
        if (!$resultado) {
            return ['success' => false, 'message' => 'No se puede eliminar este registro porque está relacionado con otros datos.'];
        }
        return ['success' => true, 'message' => 'Usuario eliminado exitosamente.'];
    }

    public function getInstituciones()
    {
        return $this->model->getInstituciones();
    }
}
?>
