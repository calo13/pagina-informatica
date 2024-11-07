<?php

namespace Model;

use Model\ActiveRecord;

class Stock extends ActiveRecord
{
    protected static $tabla = 'stock';
    protected static $idTabla = 'sto_id';
    protected static $columnasDB = ['sto_pro_id', 'sto_tal_id', 'sto_cantidad'];

    public $sto_id;
    public $sto_pro_id;
    public $sto_tal_id;
    public $sto_cantidad;

    public function __construct($args = [])
    {
        $this->sto_id = $args['sto_id'] ?? null;
        $this->sto_pro_id = $args['sto_pro_id'] ?? null;
        $this->sto_tal_id = $args['sto_tal_id'] ?? null;
        $this->sto_cantidad = $args['sto_cantidad'] ?? 0;
    }
}
