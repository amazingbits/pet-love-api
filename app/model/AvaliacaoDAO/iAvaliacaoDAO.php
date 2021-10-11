<?php

namespace App\Model\AvaliacaoDAO;

use App\Model\BaseDAO\iBaseDAO;

interface iAvaliacaoDAO extends iBaseDAO
{
    public function getByUser(int $idUser): array;
}