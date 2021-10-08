<?php

namespace App\Model\TipoAnimalDAO;

use App\Model\BaseDAO\BaseDAO;

class TipoAnimalDAO extends BaseDAO
{
    public function __construct()
    {
        $this->setTable("tipo_animal");
    }
}