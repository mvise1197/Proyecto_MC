<?php
session_start();
require_once '../modelo/Autenticacion.php';

class AutenticacionController
{
    public function login($login, $password) // Cambiar $username a $login
    {
        $auth = new Autenticacion();
        $usuario = $auth->verificarCredenciales($login, $password); // Pasar login en lugar de username

        if ($usuario) {
            $_SESSION['usuario'] = [
                'id' => $usuario['idPersonal'],
                'nombre' => $usuario['Nombre'],
                'tipo' => $usuario['idTipo_Usuario']
            ];
            header('Location: ../vista/inicio.php');
            exit;
        } else {
            header('Location: ../vista/login.php?error=1');
            exit;
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: ../vista/login.php');
        exit;
    }

    public function registrarUsuario($nombre, $apellidos, $correo, $usuario, $clave, $idTipo_Usuario, $idInstitucion)
    {
        $auth = new Autenticacion();
    
        if ($auth->registrarUsuario($nombre, $apellidos, $correo, $usuario, $clave, intval($idTipo_Usuario), intval($idInstitucion))) {
            header('Location: ../vista/login.php?registered=1'); 
            exit;
        } else {
            header('Location: ../vista/registro.php?error=1');
            exit;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller = new AutenticacionController();

    if (isset($_POST['action']) && $_POST['action'] == 'login') {
        // Cambiar $_POST['username'] a $_POST['login']
        $controller->login($_POST['login'], $_POST['password']);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'register') {
        // Cambiar para incluir el correo
        $controller->registrarUsuario($_POST['nombre'], $_POST['apellidos'], $_POST['correo'], $_POST['usuario'], $_POST['clave'], $_POST['tipo_usuario'], 1);
    }
} elseif (isset($_GET['action']) && $_GET['action'] == 'logout') {
    $controller = new AutenticacionController();
    $controller->logout();
}
?>