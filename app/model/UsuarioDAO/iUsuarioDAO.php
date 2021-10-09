<?php

namespace App\Model\UsuarioDAO;

use App\Model\BaseDAO\iBaseDAO;

interface iUsuarioDAO extends iBaseDAO
{
    public function listagemUusuario();
}