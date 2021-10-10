<?php

namespace App\Model\UsuarioDAO;

use App\Model\AnimalDAO\AnimalDAO;
use App\Model\BaseDAO\BaseDAO;
use App\Model\EnderecoDAO\EnderecoDAO;

class UsuarioDAO extends BaseDAO implements iUsuarioDAO
{
    private EnderecoDAO $enderecoDAO;
    private AnimalDAO $animalDAO;

    public function __construct()
    {
        $this->setTable("usuario");
        $this->enderecoDAO = new EnderecoDAO();
        $this->animalDAO = new AnimalDAO();
    }

    public function pegarUsuarioComEnderecoEAnimais(
        string $orderColumn = "id",
        string $orderDirection = "ASC",
        int $limit = null,
        int $offset = 0,
        bool $getJustActiveElements = true
    ): array
    {
        $res = [];
        $usuarios = $this->selectAll($orderColumn, $orderDirection, $limit, $offset, $getJustActiveElements);
        foreach($usuarios as $key=>$value) {
            $usuarioId = (int)$value["id"];
            $animais = $this->animalDAO->pegarAnimalPorIdDeUsuario($usuarioId);
            $enderecos = $this->enderecoDAO->pegarEnderecoPorIdDeUsuario($usuarioId);
            $curr = $value;
            $curr["animais"] = $animais;
            $curr["enderecos"] = $enderecos;
            array_push($res, $curr);
        }
        return $res;
    }
}