<?php

namespace App\Model\AnimalRacaDAO;

use App\Model\BaseDAO\BaseDAO;

class AnimalRacaDAO extends BaseDAO implements iAnimalRacaDAO
{
    public function __construct()
    {
        $this->setTable("animal_raca");
    }
}