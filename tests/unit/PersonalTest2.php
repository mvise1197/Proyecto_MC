<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PDO;

class PersonalTest2 extends TestCase
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

        // Crear las tablas necesarias para la prueba (si es necesario)
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS Tipo_Usuario (
                idTipo_Usuario INT AUTO_INCREMENT PRIMARY KEY,
                Tipo VARCHAR(20) NOT NULL
            );
            
            CREATE TABLE IF NOT EXISTS Institucion (
                idInstitucion INT AUTO_INCREMENT PRIMARY KEY,
                Nombre VARCHAR(85) NOT NULL,
                Nivel VARCHAR(45) NOT NULL,
                Codigo_Modular VARCHAR(10) NOT NULL UNIQUE,
                Logo VARCHAR(75)
            );
            
            CREATE TABLE IF NOT EXISTS Personal (
                idPersonal INT AUTO_INCREMENT PRIMARY KEY,
                Nombre VARCHAR(55) NOT NULL,
                Apellidos VARCHAR(75) NOT NULL,
                Usuario VARCHAR(45) NOT NULL UNIQUE,
                Clave VARCHAR(255) NOT NULL, 
                Correo VARCHAR(100) NOT NULL UNIQUE, 
                idTipo_Usuario INT NOT NULL,
                idInstitucion INT NOT NULL,
                token VARCHAR(255) NULL,
                token_expiration DATETIME NULL,
                FOREIGN KEY (idTipo_Usuario) REFERENCES Tipo_Usuario(idTipo_Usuario),
                FOREIGN KEY (idInstitucion) REFERENCES Institucion(idInstitucion)
            );
        ");
    }
    public function testObtenerPersonalPorUsuario()
    {
        // Insertar un tipo de usuario (ejemplo: "Docente")
        $stmt = $this->pdo->prepare("INSERT INTO Tipo_Usuario (Tipo) VALUES (:tipo)");
        $stmt->execute([':tipo' => 'Docente']);
        $idTipoUsuario = $this->pdo->lastInsertId();

        // Insertar una institución (ejemplo: "Instituto Educativo")
        $stmt = $this->pdo->prepare("INSERT INTO Institucion (Nombre, Nivel, Codigo_Modular, Logo) 
                                     VALUES (:nombre, :nivel, :codigoModular, :logo)");
        $stmt->execute([
            ':nombre' => 'Instituto Educativo',
            ':nivel' => 'Secundaria',
            ':codigoModular' => '1234567890',
            ':logo' => 'logo.png'
        ]);
        $idInstitucion = $this->pdo->lastInsertId();

        // Datos del nuevo personal
        $nombre = 'Juan';
        $apellidos = 'Perez';
        $usuario = 'juanperez';
        $clave = password_hash('secreto123', PASSWORD_DEFAULT); // Clave encriptada
        $correo = 'juan.perez@instituto.com';

        // Registrar el personal
        $stmt = $this->pdo->prepare("INSERT INTO Personal (Nombre, Apellidos, Usuario, Clave, Correo, idTipo_Usuario, idInstitucion) 
                                     VALUES (:nombre, :apellidos, :usuario, :clave, :correo, :idTipoUsuario, :idInstitucion)");
        $stmt->execute([
            ':nombre' => $nombre,
            ':apellidos' => $apellidos,
            ':usuario' => $usuario,
            ':clave' => $clave,
            ':correo' => $correo,
            ':idTipoUsuario' => $idTipoUsuario,
            ':idInstitucion' => $idInstitucion
        ]);

        // Recuperar el personal por su nombre de usuario
        $stmt = $this->pdo->prepare("SELECT * FROM Personal WHERE Usuario = :usuario");
        $stmt->execute([':usuario' => $usuario]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Afirmaciones para validar que el personal fue recuperado correctamente
        $this->assertNotNull($result, "El personal no fue encontrado en la base de datos.");
        $this->assertEquals($nombre, $result['Nombre'], "El nombre del personal no coincide.");
        $this->assertEquals($apellidos, $result['Apellidos'], "Los apellidos del personal no coinciden.");
        $this->assertEquals($usuario, $result['Usuario'], "El nombre de usuario no coincide.");
        $this->assertEquals($correo, $result['Correo'], "El correo electrónico no coincide.");
        $this->assertEquals($idTipoUsuario, $result['idTipo_Usuario'], "El tipo de usuario no coincide.");
        $this->assertEquals($idInstitucion, $result['idInstitucion'], "La institución no coincide.");
    }
}
