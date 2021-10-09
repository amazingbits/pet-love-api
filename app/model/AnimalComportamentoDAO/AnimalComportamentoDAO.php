<?php

namespace App\Model\AnimalComportamentoDAO;

use App\Model\BaseDAO\BaseDAO;

class AnimalComportamentoDAO extends BaseDAO implements iAnimalComportamentoDAO
{
    public function __construct()
    {
        $this->setTable("animal_comportamento");
    }
}