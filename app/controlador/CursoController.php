<?php
require_once '../modelo/CursoModel.php';

class CursoController
{
    private $model;

    public function __construct()
    {
        $this->model = new CursoModel();
    }

    // Método para crear un nuevo curso
    public function create($data)
    {
        return $this->model->create($data['Nombre_Curso'], $data['idGrado']);
    }

    // Método para leer todos los cursos
    public function read()
    {
        return $this->model->read();
    }

    // Método para obtener un curso por su ID
    public function readById($idCurso)
    {
        return $this->model->readById($idCurso);
    }

    // Método para actualizar un curso
    public function update($data)
    {
        return $this->model->update($data['idCurso'], $data['Nombre_Curso'], $data['idGrado']);
    }

    // Método para eliminar un curso
    public function delete($idCurso)
    {
        return $this->model->delete($idCurso);
    }

    // Método para obtener los grados disponibles
    public function getGrados()
    {
        return $this->model->getGrados();
    }
}
?>
