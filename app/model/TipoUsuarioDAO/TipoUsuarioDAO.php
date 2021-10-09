<?php

namespace App\Model\TipoUsuarioDAO;

use App\Model\BaseDAO\BaseDAO;
use App\Model\TipoAnimalDAO\iTipoAnimalDAO;

class TipoUsuarioDAO extends BaseDAO implements iTipoAnimalDAO
{
    public function __construct()
    {
        $this->setTable("tipo_usuario");
    }
}