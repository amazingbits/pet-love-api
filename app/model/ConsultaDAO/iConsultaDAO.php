<?php

namespace App\Model\ConsultaDAO;

use App\Model\BaseDAO\iBaseDAO;

interface iConsultaDAO extends iBaseDAO
{
    public function retornarConsultaPorIdAnimal(int $idAnimal): array;
}