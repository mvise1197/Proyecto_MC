<?php
class Usuario {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Verificar si el correo existe en la base de datos
    public function verificarCorreo($email) {
        $query = "SELECT idPersonal, Correo FROM Personal WHERE Correo = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Actualizar el token y su expiración en la base de datos
    public function actualizarToken($email, $token, $expiration) {
        $updateQuery = "UPDATE Personal SET token = ?, token_expiration = ? WHERE Correo = ?";
        $updateStmt = $this->conn->prepare($updateQuery);
        $updateStmt->bind_param('sss', $token, $expiration, $email);
        return $updateStmt->execute();
    }

    // Verificar si el token es válido y no ha expirado
    public function verificarToken($token) {
        $query = "SELECT idPersonal, token_expiration FROM Personal WHERE token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $token);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Actualizar la contraseña en la base de datos
    public function actualizarContrasena($idPersonal, $nueva_clave) {
        $hashedPassword = password_hash($nueva_clave, PASSWORD_BCRYPT);
        $updateQuery = "UPDATE Personal SET Clave = ?, token = NULL, token_expiration = NULL WHERE idPersonal = ?";
        $updateStmt = $this->conn->prepare($updateQuery);
        $updateStmt->bind_param('si', $hashedPassword, $idPersonal);
        return $updateStmt->execute();
    }
}
?>