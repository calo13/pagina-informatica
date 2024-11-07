<?php

namespace Controllers;

use Model\Categoria;
use MVC\Router;

class AppController
{
    public static function index(Router $router)
    {
        $router->render('pages/home', []);
    }
    public static function misionVision(Router $router)
    {
        $router->render('pages/mision-vision', []);
    }
    public static function quienesSomos(Router $router)
    {
        $router->render('pages/quienes-somos', []);
    }
    public static function contacto(Router $router)
    {
        $router->render('pages/contacto', []);
    }
    public static function productos(Router $router)
    {
        $categorias = Categoria::all();
        $router->render('pages/productos', [
            'categorias' => $categorias,
        ]);
    }

    public static function admin(Router $router)
    {
        isAuth();
        $router->render('admin/index', [], 'layouts/appLayout');
    }

    public static function test(Router $router)
    {
        echo "hola";
    }
}
