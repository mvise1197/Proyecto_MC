<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PDO;

class EstudianteTest extends TestCase
{
    private $pdo;

    // Configuración inicial de la base de datos
    protected function setUp(): void
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=testdb', 'root', ''); // Asegúrate de tener los datos correctos
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Limpiar la base de datos antes de cada prueba
        $this->pdo->exec("DELETE FROM Estudiante");
    }

    // Prueba de integración para registrar un estudiante con grado
    public function testRegistrarEstudianteConGrado()
    {
        // Crear un grado
        $stmt = $this->pdo->prepare("INSERT INTO Grado (Nombre_Grado, Seccion, idInstitucion) VALUES ('Primer Grado', 'A', 1)");
        $stmt->execute();
        $gradoId = $this->pdo->lastInsertId();

        // Registrar un estudiante y asociarlo al grado creado
        $stmt = $this->pdo->prepare("INSERT INTO Estudiante (Nombre, Apellidos, DNI, Codigo_Est, idGrado) VALUES ('Juan', 'Pérez', '12345678', 'ESTU001', ?)");
        $stmt->execute([$gradoId]);

        // Verificar que el estudiante fue registrado correctamente
        $stmt = $this->pdo->prepare("SELECT * FROM Estudiante WHERE Codigo_Est = 'ESTU001'");
        $stmt->execute();
        $estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($estudiante);
        $this->assertEquals('Juan', $estudiante['Nombre']);
        $this->assertEquals('Pérez', $estudiante['Apellidos']);
        $this->assertEquals('12345678', $estudiante['DNI']);
        $this->assertEquals('ESTU001', $estudiante['Codigo_Est']);
        $this->assertEquals($gradoId, $estudiante['idGrado']);
    }

    // Limpiar después de la prueba
    protected function tearDown(): void
    {
        $this->pdo = null;
    }
}
