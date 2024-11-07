<?php

namespace Model;

use Model\ActiveRecord;

class Usuario extends ActiveRecord
{
    protected static $tabla = 'usuarios';
    protected static $idTabla = 'usu_id';
    protected static $columnasDB = [
        'usu_usuario',
        'usu_password',
        'usu_email',
        'usu_verificado',
        'usu_token',
    ];

    public $usu_id;
    public $usu_usuario;
    public $usu_password;
    public $usu_email;
    public $usu_verificado;
    public $usu_token;

    public function __construct($args = [])
    {
        $this->usu_id = $args['usu_id'] ?? null;
        $this->usu_usuario = $args['usu_usuario'] ?? '';
        $this->usu_password = $args['usu_password'] ?? '';
        $this->usu_email = $args['usu_email'] ?? '';
        $this->usu_verificado = $args['usu_verificado'] ?? '';
        $this->usu_token = $args['usu_token'] ?? '';
    }
}
