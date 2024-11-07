<?php

namespace Controllers;

use Exception;
use Model\Categoria;
use Model\Imagen;
use Model\Producto;
use Model\Stock;
use Model\Talla;
use MVC\Router;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class ProductoController
{
    public static function index(Router $router)
    {
        isAuth();
        $categorias = Categoria::all();
        $tallas = Talla::all();
        $router->render('admin/productos', [
            'categorias' => $categorias,
            'tallas' => $tallas,
        ], 'layouts/appLayout');
    }

    public static function guardarAPI()
    {
        getHeadersApi();
        isAuthApi();
        $data = sanitizar($_POST);
        $db = Producto::getDB();
        $db->beginTransaction();
        try {

            $producto = new Producto($data);
            $resultado = $producto->crear();

            $id = $resultado['id'];

            $tallas = $data['prod_tallas'] ?? null;
            $files = $_FILES['prod_imagen'];


            if ($tallas) {
                foreach ($tallas as $key => $talla) {
                    $stock = new Stock([
                        'sto_pro_id' => $id,
                        'sto_tal_id' => $talla,
                    ]);

                    $stock->crear();
                }
            }

            for ($i = 0; $i < count($files['name']); $i++) {
                $nombreArchivo = $files['name'][$i];
                $tipoArchivo = $files['type'][$i];
                $tamanoArchivo = $files['size'][$i];
                $temporalArchivo = $files['tmp_name'][$i];
                $errorArchivo = $files['error'][$i];

                // Comprobar si hubo algún error al subir la imagen
                if ($errorArchivo === UPLOAD_ERR_OK) {
                    // Ruta de destino
                    $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION); // Obtener la extensión del archivo
                    $nuevoNombre = uniqid('img_', true) . '.' . $extension; // Generar nuevo no
                    $rutaDestino = __DIR__ . '/../storage/' . $nuevoNombre;

                    $manager = new ImageManager(['driver' => 'gd']);
                    $imagen = $manager->make($temporalArchivo);
                    $imagen->resize(900, 800);
                    $imagen->save($rutaDestino);

                    $img = new Imagen([
                        'img_nombre' => $nombreArchivo,
                        'img_ruta' => $rutaDestino,
                        'img_pro_id' => $id,
                    ]);

                    $img->crear();

                } else {
                    throw new Exception("Error al subir la imagen {$nombreArchivo}: {$errorArchivo}.", 500);
                }
            }

            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Producto guardado exitosamente.',
            ]);

            $db->commit();
        } catch (Exception $e) {
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error guardando producto',
                'detalle' => $e->getMessage()
            ]);
            $db->rollBack();
            exit;
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();
        isAuthApi();
        $data = sanitizar($_POST);
        $db = Producto::getDB();
        $db->beginTransaction();
        try {

            $id = $data['pro_id'];
            $producto = Producto::find($id);
            $producto->sincronizar($data);
            $resultado = $producto->actualizar();


            $files = $_FILES['prod_imagen'];

            $tallas = $data['prod_tallas'] ?? null;

            if ($tallas) {

                $tallaGuardadas = Stock::where('sto_pro_id', $id);

                foreach ($tallaGuardadas as $key => $talla) {
                    $talla->eliminar();
                }

                foreach ($tallas as $key => $talla) {
                    $stock = Stock::findOrCreate(
                        [
                            'sto_pro_id' => $id,
                            'sto_tal_id' => $talla,
                        ]
                        ,
                        [
                            'sto_pro_id' => $id,
                            'sto_tal_id' => $talla,
                        ]
                    );
                }
            }

            if ($files['name'][0] != '') {
                for ($i = 0; $i < count($files['name']); $i++) {
                    $nombreArchivo = $files['name'][$i];
                    $tipoArchivo = $files['type'][$i];
                    $tamanoArchivo = $files['size'][$i];
                    $temporalArchivo = $files['tmp_name'][$i];
                    $errorArchivo = $files['error'][$i];

                    // Comprobar si hubo algún error al subir la imagen
                    if ($errorArchivo === UPLOAD_ERR_OK) {
                        // Ruta de destino
                        $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION); // Obtener la extensión del archivo
                        $nuevoNombre = uniqid('img_', true) . '.' . $extension; // Generar nuevo no
                        $rutaDestino = __DIR__ . '/../storage/' . $nuevoNombre;

                        $manager = new ImageManager(['driver' => 'gd']);
                        $imagen = $manager->make($temporalArchivo);
                        $imagen->resize(900, 800);
                        $imagen->save($rutaDestino);

                        $img = new Imagen([
                            'img_nombre' => $nombreArchivo,
                            'img_ruta' => $rutaDestino,
                            'img_pro_id' => $id,
                        ]);

                        $img->crear();

                    } else {
                        throw new Exception("Error al subir la imagen {$nombreArchivo}: {$errorArchivo}.", 500);
                    }
                }
            }

            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Producto modificado exitosamente.',
            ]);

            $db->commit();
        } catch (Exception $e) {
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error modificado producto',
                'detalle' => $e->getMessage()
            ]);
            $db->rollBack();
            exit;
        }
    }

    public static function buscarAPI()
    {
        getHeadersApi();
        isAuthApi();
        try {

            $productos = Producto::joinWhere(
                [
                    ['categorias', 'cat_id', 'pro_cat_id', 'INNER']
                ],
                [],
            );

            foreach ($productos as $key => $producto) {
                $stocks = Stock::where('sto_pro_id', $producto->pro_id);
                $tallas = [];
                foreach ($stocks as $key => $stock) {
                    $tallas[] = $stock->sto_tal_id;
                }
                $producto->tallas = $tallas;
            }
            echo json_encode([
                'codigo' => 1,
                'datos' => $productos,
                'mensaje' => count($productos) . ' productos encontrados',
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error buscando productos',
                'detalle' => $e->getMessage()
            ]);
            exit;
        }
    }

    public static function categoriaAPI()
    {
        getHeadersApi();
        $categoria = filter_var($_GET['categoria'], FILTER_SANITIZE_NUMBER_INT);
        try {

            $productos = Producto::where('pro_cat_id', $categoria, '=', [['pro_estado', '1', '=']]);
            foreach ($productos as $key => $producto) {
                $tallas = Stock::joinWhere(
                    [['tallas', 'sto_tal_id', 'tal_id']],
                    [['sto_pro_id', $producto->pro_id]]

                );
                $imagenes = Imagen::where('img_pro_id', $producto->pro_id);

                $img = [];
                foreach ($imagenes as $key => $imagen) {
                    $img[] = convertirImagenABase64($imagen->img_ruta);

                }

                $producto->tallas = $tallas;
                $producto->imagenes = $img;
            }
            echo json_encode([
                'codigo' => 1,
                'datos' => $productos,
                'mensaje' => count($productos) . ' productos encontrados',
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error buscando productos',
                'detalle' => $e->getMessage()
            ]);
            exit;
        }
    }

    public static function fotosAPI()
    {
        getHeadersApi();
        isAuthApi();
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        try {

            $imagenes = Imagen::where('img_pro_id', $id);
            $img = [];
            foreach ($imagenes as $key => $imagen) {
                $img[$key]['id'] = $imagen->img_id;
                $img[$key]['imagen'] = convertirImagenABase64($imagen->img_ruta);

            }
            echo json_encode([
                'codigo' => 1,
                'datos' => $img,
                'mensaje' => count($img) . ' imagenes encontrados',
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error buscando imagenes',
                'detalle' => $e->getMessage()
            ]);
            exit;
        }
    }

    public static function eliminarFotoAPI()
    {
        getHeadersApi();
        isAuthApi();
        $_POST['img_id'] = filter_var($_POST['img_id'], FILTER_SANITIZE_NUMBER_INT);

        try {
            $imagen = Imagen::find($_POST['img_id']);
            unlink($imagen->img_ruta);
            $imagen->eliminar();
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Imagen eliminada exitosamente.',
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error eliminando imagen',
                'detalle' => $e->getMessage()
            ]);
            exit;
        }
    }

    public static function cambiarEstadoAPI()
    {
        getHeadersApi();
        isAuthApi();
        $_POST['pro_id'] = filter_var($_POST['pro_id'], FILTER_SANITIZE_NUMBER_INT);
        $_POST['pro_estado'] = filter_var($_POST['pro_estado'], FILTER_SANITIZE_NUMBER_INT);

        try {
            $empresa = Producto::find($_POST['pro_id']);
            $empresa->sincronizar($_POST);
            $empresa->actualizar();
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Estado cambiado exitosamente.',
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error cambiando estado',
                'detalle' => $e->getMessage()
            ]);
            exit;
        }
    }
}