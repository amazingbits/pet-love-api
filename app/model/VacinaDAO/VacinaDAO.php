<?php

namespace App\Model\VacinaDAO;

use App\Core\Connection;
use App\Core\DefaultController;
use App\Model\BaseDAO\BaseDAO;

class VacinaDAO extends BaseDAO implements iVacinaDAO
{
    public function __construct()
    {
        $this->setTable("vacina");
    }

    public function selectAll(
        string $orderColumn = "id",
        string $orderDirection = "ASC",
        int $limit = null,
        int $offset = 0,
        bool $getJustActiveElements = true
    ): array
    {
        $sqlQuery = " SELECT vacina.id AS id,
                             vacina.descricao AS descricao,
                             vacina.duracao_dias AS duracao_dias,
                             vacina.ativo AS ativo,
                             vacina.criado_em AS criado_em,
                             tipo_animal.descricao AS tipo
                       FROM vacina 
                       INNER JOIN tipo_animal ON (vacina.tipo = tipo_animal.id) ";

        if($getJustActiveElements) {
            $sqlQuery .= " WHERE vacina.ativo = 1 ";
        }
        $sqlQuery .= " ORDER BY vacina.{$orderColumn} {$orderDirection} ";
        if(!empty($limit)) {
            $sqlQuery .= " LIMIT {$limit} OFFSET {$offset} ";
        }

        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->execute();
            if($stmt->rowCount() === 0) {
                $view = new DefaultController();
                $view->response([
                    "message" => "Nenhum registro encontrado!"
                ], HTTP_NOT_FOUND);
            }
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