<?php

namespace App\Model\EnderecoDAO;

use App\Model\BaseDAO\iBaseDAO;

interface iEnderecoDAO extends iBaseDAO
{
    public function pegarEnderecoPorIdDeUsuario(int $id): array;
}