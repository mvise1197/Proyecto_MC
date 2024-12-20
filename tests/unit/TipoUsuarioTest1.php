<?php

use PHPUnit\Framework\TestCase;

class TipoUsuarioTest1 extends TestCase
{
    private $pdo;
    protected function setUp(): void
    {
        // Configurar la conexión PDO (ajusta según tu entorno)
        $this->pdo = new PDO('mysql:host=localhost;dbname=testdb', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Crear la tabla Tipo_Usuario si no existe
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS Tipo_Usuario (
                idTipo_Usuario INT AUTO_INCREMENT PRIMARY KEY,
                Tipo VARCHAR(20) NOT NULL
            );
        ");
    }
    private function limpiarTablas()
    {
        // Limpiar las tablas involucradas
        $this->pdo->exec("DELETE FROM Tipo_Usuario");
        $this->pdo->exec("DELETE FROM Institucion");
    }
    public function testRegistrarTipoUsuario()
    {
        // Datos de prueba
        $tipoUsuario = "Administrador";

        // Inserta un nuevo registro en la tabla
        $stmt = $this->pdo->prepare("INSERT INTO Tipo_Usuario (Tipo) VALUES (:tipo)");
        $stmt->execute([':tipo' => $tipoUsuario]);

        // Verifica si el registro fue insertado correctamente
        $stmt = $this->pdo->query("SELECT * FROM Tipo_Usuario WHERE Tipo = 'Administrador'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Afirmaciones para validar el resultado
        $this->assertNotNull($result, "El tipo de usuario no fue encontrado en la base de datos.");
        $this->assertEquals($tipoUsuario, $result['Tipo'], "El tipo de usuario registrado no coincide.");
    }
}
