<?php

namespace App\Model\UsuarioDAO;

use App\Model\BaseDAO\BaseDAO;

class UsuarioDAO extends BaseDAO implements iUsuarioDAO
{
    public function __construct()
    {
        $this->setTable("usuario");
    }

    public function listagemUusuario()
    {
        // TODO: Implement listagemUusuario() method.
    }
}