<?php

namespace Model;

use Model\ActiveRecord;

class Categoria extends ActiveRecord
{
    protected static $tabla = 'categorias';
    protected static $idTabla = 'cat_id';
    protected static $columnasDB = ['cat_nombre'];

    public $cat_id;
    public $cat_nombre;

    public function __construct($args = [])
    {
        $this->cat_id = $args['cat_id'] ?? null;
        $this->cat_nombre = $args['cat_nombre'] ?? '';
    }
}
