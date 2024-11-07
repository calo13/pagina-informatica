<?php

namespace Model;

use Model\ActiveRecord;

class Producto extends ActiveRecord
{
    protected static $tabla = 'productos';
    protected static $idTabla = 'pro_id';
    protected static $columnasDB = ['pro_nombre', 'pro_descripcion', 'pro_precio', 'pro_cat_id', 'pro_estado'];

    public $pro_id;
    public $pro_nombre;
    public $pro_descripcion;
    public $pro_precio;
    public $pro_cat_id;
    public $pro_estado;

    public function __construct($args = [])
    {
        $this->pro_id = $args['pro_id'] ?? null;
        $this->pro_nombre = $args['pro_nombre'] ?? '';
        $this->pro_descripcion = $args['pro_descripcion'] ?? '';
        $this->pro_precio = $args['pro_precio'] ?? 0.0;
        $this->pro_cat_id = $args['pro_cat_id'] ?? null;
        $this->pro_estado = $args['pro_estado'] ?? 1;
    }
}
