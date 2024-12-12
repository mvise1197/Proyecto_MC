<?php

class Database
{
    private $host = 'localhost';
    private $usuario = 'root';
    private $clave = '';
    private $base_datos = 'bd_colegio_mc';
    private $conexion;

    public function getConnection()
    {
        if (!$this->conexion) {
            // Configurar MySQLi para lanzar excepciones antes de la conexión
            //EN CASO DE ERROR, RETIRAR ESTA LÍNEA
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $this->conexion = new mysqli($this->host, $this->usuario, $this->clave, $this->base_datos);

            if ($this->conexion->connect_error) {
                die('Error de conexión: ' . $this->conexion->connect_error);
            }
        }
        return $this->conexion;
    }
}
?>