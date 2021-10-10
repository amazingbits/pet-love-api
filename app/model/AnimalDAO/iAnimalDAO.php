<?php

namespace App\Model\AnimalDAO;

use App\Model\BaseDAO\iBaseDAO;

interface iAnimalDAO extends iBaseDAO
{
    public function pegarAnimalPorIdDeUsuario(int $id): array;
}