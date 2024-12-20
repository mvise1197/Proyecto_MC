<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PDO;

class InstitucionTest2 extends TestCase
{
    private $pdo;

    /**
     * Configura la conexión a la base de datos de prueba.
     */
    protected function setUp(): void
    {
        // Configurar la conexión PDO (ajusta según tu entorno)
        $this->pdo = new PDO('mysql:host=localhost;dbname=testdb', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Crear la tabla Institucion si no existe
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS Institucion (
                idInstitucion INT AUTO_INCREMENT PRIMARY KEY,
                Nombre VARCHAR(85) NOT NULL,
                Nivel VARCHAR(45) NOT NULL,
                Codigo_Modular VARCHAR(10) NOT NULL UNIQUE,
                Logo VARCHAR(75)
            );
        ");
    }
    private function limpiarTablas()
    {
        // Limpiar las tablas involucradas
        $this->pdo->exec("DELETE FROM Tipo_Usuario");
    }
    public function testObtenerInstitucion()
    {
        // Datos de prueba
        $nombre = "Instituto Educativo";
        $nivel = "Secundaria";
        $codigoModular = "2234567890";
        $logo = "logo.png";

        // Inserta una nueva institución
        $stmt = $this->pdo->prepare("INSERT INTO Institucion (Nombre, Nivel, Codigo_Modular, Logo) 
                                     VALUES (:nombre, :nivel, :codigoModular, :logo)");
        $stmt->execute([
            ':nombre' => $nombre,
            ':nivel' => $nivel,
            ':codigoModular' => $codigoModular,
            ':logo' => $logo
        ]);

        // Obtén el ID de la institución recién insertada
        $idInstitucion = $this->pdo->lastInsertId();

        // Recupera la institución por su ID
        $stmt = $this->pdo->prepare("SELECT * FROM Institucion WHERE idInstitucion = :idInstitucion");
        $stmt->execute([':idInstitucion' => $idInstitucion]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Afirmaciones para validar la recuperación
        $this->assertNotNull($result, "La institución no fue encontrada en la base de datos.");
        $this->assertEquals($nombre, $result['Nombre'], "El nombre de la institución no coincide.");
        $this->assertEquals($nivel, $result['Nivel'], "El nivel de la institución no coincide.");
        $this->assertEquals($codigoModular, $result['Codigo_Modular'], "El código modular no coincide.");
        $this->assertEquals($logo, $result['Logo'], "El logo no coincide.");
    }
}
