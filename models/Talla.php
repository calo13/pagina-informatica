<?php

namespace Model;

use Model\ActiveRecord;

class Talla extends ActiveRecord
{
    protected static $tabla = 'tallas';
    protected static $idTabla = 'tal_id';
    protected static $columnasDB = ['tal_nombre'];

    public $tal_id;
    public $tal_nombre;

    public function __construct($args = [])
    {
        $this->tal_id = $args['tal_id'] ?? null;
        $this->tal_nombre = $args['tal_nombre'] ?? '';
    }
}
