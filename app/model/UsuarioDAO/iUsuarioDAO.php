<?php

namespace App\Model\UsuarioDAO;

use App\Model\BaseDAO\iBaseDAO;

interface iUsuarioDAO extends iBaseDAO
{
    public function pegarUsuarioComEnderecoEAnimais(
        string $orderColumn = "id",
        string $orderDirection = "ASC",
        int $limit = null,
        int $offset = 0,
        bool $getJustActiveElements = true
    );
}