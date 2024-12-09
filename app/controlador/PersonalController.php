<?php
require_once '../modelo/PersonalModel.php';

class PersonalController
{
    private $model;

    public function __construct()
    {
        $this->model = new PersonalModel();
    }

    public function create($data)
    {
        return $this->model->create($data['nombre'], $data['apellidos'], $data['usuario'], $data['clave'], $data['correo'], $data['idTipo_Usuario'], $data['idInstitucion']);
    }

    public function read()
    {
        return $this->model->read();
    }

    // Nuevo método para obtener un personal por ID
    public function readById($idPersonal)
    {
        return $this->model->readById($idPersonal);
    }

    public function update($data)
    {
        return $this->model->update($data['idPersonal'], $data['nombre'], $data['apellidos'], $data['usuario'], $data['correo'], $data['idTipo_Usuario'], $data['idInstitucion'], isset($data['clave']) ? $data['clave'] : null);
    }

    public function delete($idPersonal)
    {
        return $this->model->delete($idPersonal);
    }

    public function getInstituciones()
    {
        return $this->model->getInstituciones();
    }

    public function getTiposUsuario()
    {
        return $this->model->getTiposUsuario();
    }
}
?>