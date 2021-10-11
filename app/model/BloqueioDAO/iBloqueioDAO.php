<?php

namespace App\Model\BloqueioDAO;

use App\Model\BaseDAO\iBaseDAO;

interface iBloqueioDAO extends iBaseDAO
{
    public function verificarSeHaBloqueioNaDataEspecificada(int $idAgenda, string $data);
}