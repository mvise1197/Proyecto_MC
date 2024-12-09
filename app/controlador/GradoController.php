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

    public function update($data)
    {
        // Actualización para que coincida con los campos de la tabla Grado
        return $this->model->update($data['idGrado'], $data['Nombre_Grado'], $data['Seccion'], $data['Tutor'], $data['idInstitucion']);
    }

    public function delete($idGrado)
    {
        return $this->model->delete($idGrado);
    }

    public function getInstituciones()
    {
        return $this->model->getInstituciones();
    }
}
?>
