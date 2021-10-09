<?php

namespace App\Model\AnimalDAO;

use App\Model\BaseDAO\BaseDAO;

class AnimalDAO extends BaseDAO implements iAnimalDAO
{
    public function __construct()
    {
        $this->setTable("animal");
    }
}