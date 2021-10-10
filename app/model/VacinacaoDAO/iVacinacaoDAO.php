<?php

namespace App\Model\VacinacaoDAO;

use App\Model\BaseDAO\iBaseDAO;

interface iVacinacaoDAO extends iBaseDAO
{
    public function verificarSeEHoraDeVacinar(
        int $idAnimal
    ): bool;

}