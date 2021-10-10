<?php

namespace App\Model\EnderecoDAO;

use App\Core\Connection;
use App\Core\DefaultController;
use App\Model\BaseDAO\BaseDAO;

class EnderecoDAO extends BaseDAO implements iEnderecoDAO
{
    public function __construct()
    {
        $this->setTable("endereco");
    }

    public function pegarEnderecoPorIdDeUsuario(int $id): array
    {
        $sqlQuery = "SELECT * FROM endereco WHERE usuario = :id";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            $view = new DefaultController();
            $view->response([
                "message" => "Houve um erro ao listar os registros",
                "error" => $e->getMessage()
            ], HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}