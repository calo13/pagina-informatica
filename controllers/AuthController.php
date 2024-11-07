<?php

namespace Controllers;

use Classes\Email;
use Model\Cuenta;
use Model\Usuario;
use MVC\Router;
use Exception;

/**
 * Controlador de autenticación
 */
class AuthController
{
    public static function login(Router $router)
    {
        isNotAuth();
        $router->render('auth/login', []);
    }
    public static function loginAPI(Router $router)
    {
        isNotAuthApi();
        getHeadersApi();
        $db = Usuario::getDB();
        $db->beginTransaction();

        $data = sanitizar($_POST);

        try {
            $username = $data['username'];
            $password = $data['password'];

            $usuario = Usuario::where('usu_usuario', $username)[0];


            if (!$usuario) {
                echo json_encode([
                    'codigo' => 2,
                    'mensaje' => 'Usuario no encontrado',
                    'detalle' => 'Revise la información ingresada'
                ]);
                $db->rollBack();
                exit;
            }

            if (password_verify($password, $usuario->usu_password)) {
                unset($usuario->usu_password);
                $_SESSION['auth'] = true;
                $_SESSION['user'] = $usuario;
                $_SESSION['username'] = $usuario->usu_usuario;
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'Autenticación correcta',
                ]);
                $db->commit();
            } else {
                echo json_encode([
                    'codigo' => 2,
                    'mensaje' => 'Credenciales incorrectas',
                ]);
                $db->rollBack();
            }
        } catch (Exception $e) {
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error obteniendo usuario',
                'detalle' => $e->getMessage()
            ]);
            $db->rollBack();
            exit;
        }
    }

    public static function logout()
    {
        isAuth();
        $_SESSION = [];
        session_destroy();
        header('location: /login');
    }
}
