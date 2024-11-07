<?php

namespace Controllers;

use Classes\Email;
use Exception;
use MVC\Router;

class ContactoController {
    public static function enviar(){
        getHeadersApi();
        
    
        if (isset($_POST['email'], $_POST['name'], $_POST['subject'], $_POST['message'])) {
           
            $email_address = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
            $subject = htmlspecialchars($_POST['subject'], ENT_QUOTES, 'UTF-8');
            $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');
        
            
            if (filter_var($email_address, FILTER_VALIDATE_EMAIL) === false) {
                echo json_encode([
                    'codigo' => 2,
                    'mensaje' => 'Dirección de correo invalida',
                ]);
                exit;
            }
        
          
            $email = new Email($email_address, $name);
            
           
            try {
                $enviado = $email->generateEmail($subject, [$_ENV['EMAIL_TO_ADDRESS']], $message)->send();
        
                if ($enviado) {
                    echo json_encode([
                        'codigo' => 1,
                        'mensaje' => 'Correo enviado exitosamente',
                    ]);
                } else {
                    echo json_encode([
                        'codigo' => 0,
                        'mensaje' => 'Error al enviar correo',
                    ]);
                }
            } catch (Exception $e) {
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Ocurrió un error',
                    'detalle' => $e->getMessage()
                ]);
            }
        } else {
            echo json_encode([
                'codigo' => 2,
                'mensaje' => 'Faltan datos para enviar el correo',
            ]);
        }
        
    }

}