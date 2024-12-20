<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PDO;

class PersonalTest3 extends TestCase
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
    }

    /**
     * Prueba unitaria: Verifica que la información del personal (por ejemplo, la clave) puede ser actualizada correctamente.
     */
    public function testActualizarPersonal()
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

        // Obtener el ID del personal recién insertado
        $idPersonal = $this->pdo->lastInsertId();

        // Nuevos datos para actualizar el personal
        $nuevaClave = password_hash('nuevaClave123', PASSWORD_DEFAULT); // Nueva clave encriptada

        // Actualizar la clave del personal
        $stmt = $this->pdo->prepare("UPDATE Personal SET Clave = :clave WHERE idPersonal = :idPersonal");
        $stmt->execute([
            ':clave' => $nuevaClave,
            ':idPersonal' => $idPersonal
        ]);

        // Verificar si la clave ha sido actualizada correctamente
        $stmt = $this->pdo->prepare("SELECT Clave FROM Personal WHERE idPersonal = :idPersonal");
        $stmt->execute([':idPersonal' => $idPersonal]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Afirmaciones para validar que la clave fue actualizada correctamente
        $this->assertNotNull($result, "El personal no fue encontrado en la base de datos.");
        $this->assertNotEquals($clave, $result['Clave'], "La clave no ha sido actualizada.");
        $this->assertTrue(password_verify('nuevaClave123', $result['Clave']), "La clave actualizada no es válida.");
    }
}
