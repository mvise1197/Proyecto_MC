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

    //MÉTODO PARA BUSCAR UN REGISTRO
    public function buscar($query){
        return $this->model->buscar($query);
    }

    public function update($data)
    {
        return $this->model->update($data['idPersonal'], $data['nombre'], $data['apellidos'], $data['usuario'], $data['correo'], $data['idTipo_Usuario'], $data['idInstitucion'], isset($data['clave']) ? $data['clave'] : null);
    }

    //SE ESTÁ MANEJANDO CON ESTE NUEVO SEGMENTO DE CÓDIGO / BORRAR EN CASO DE QUE FALLE
    public function delete($idPersonal)
    {
        $resultado = $this->model->delete($idPersonal);
        if (!$resultado) {
            return ['success' => false, 'message' => 'No se puede eliminar este registro porque está relacionado con otros datos.'];
        }
        return ['success' => true, 'message' => 'Usuario eliminado exitosamente.'];
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