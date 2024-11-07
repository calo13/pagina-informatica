<?php

namespace Model;

use Model\ActiveRecord;

class Imagen extends ActiveRecord
{
    protected static $tabla = 'imagenes';
    protected static $idTabla = 'img_id';
    protected static $columnasDB = ['img_ruta', 'img_nombre', 'img_principal', 'img_pro_id'];

    public $img_id;
    public $img_ruta;
    public $img_nombre;
    public $img_principal;
    public $img_pro_id;

    public function __construct($args = [])
    {
        $this->img_id = $args['img_id'] ?? null;
        $this->img_ruta = $args['img_ruta'] ?? '';
        $this->img_nombre = $args['img_nombre'] ?? '';
        $this->img_principal = $args['img_principal'] ?? 0; // 0: no es principal, 1: es principal
        $this->img_pro_id = $args['img_pro_id'] ?? null; // Relación con el producto
    }
}
