<?php

namespace App\Model\ExameDAO;

use App\Model\BaseDAO\iBaseDAO;

interface iExameDAO extends iBaseDAO
{
    public function pegarExamePorIdAnimal(int $idAnimal): array;
}