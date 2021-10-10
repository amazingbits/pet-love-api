<?php

namespace App\Model\BloqueioDAO;

use App\Model\BaseDAO\BaseDAO;

class BloqueioDAO extends BaseDAO implements iBloqueioDAO
{
    public function __construct()
    {
        $this->setTable("bloqueio");
    }
}