<?php

namespace App\Model\TipoUsuarioDAO;

use App\Model\BaseDAO\BaseDAO;

class TipoUsuarioDAO extends BaseDAO
{
    public function __construct()
    {
        $this->setTable("tipo_usuario");
    }
}