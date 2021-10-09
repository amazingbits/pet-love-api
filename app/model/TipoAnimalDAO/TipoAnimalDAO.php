<?php

namespace App\Model\TipoAnimalDAO;

use App\Model\BaseDAO\BaseDAO;

class TipoAnimalDAO extends BaseDAO implements iTipoAnimalDAO
{
    public function __construct()
    {
        $this->setTable("tipo_animal");
    }
}