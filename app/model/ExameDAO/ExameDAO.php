<?php

namespace App\Model\ExameDAO;

use App\Core\Connection;
use App\Core\DefaultController;
use App\Model\BaseDAO\BaseDAO;

class ExameDAO extends BaseDAO implements iExameDAO
{
    public function __construct()
    {
        $this->setTable("exames");
    }

    public function selectAll(
        string $orderColumn = "id",
        string $orderDirection = "ASC",
        int $limit = null,
        int $offset = 0,
        bool $getJustActiveElements = true
    ): array
    {
        $sqlQuery = "SELECT exames.id AS id,
                            exames.descricao AS descricao,
                            DATE_FORMAT(exames.data, '%d/%m/%Y') AS data,
                            exames.notas AS notas,
                            exames.file_path AS file_path,
                            animal.nome AS animal,
                            exames.criado_em AS criado_em,
                            exames.ativo AS ativo
                     FROM exames 
                     INNER JOIN animal ON (exames.animal = animal.id) ";
        if($getJustActiveElements) {
            $sqlQuery .= " WHERE exames.ativo = 1 ";
        }
        $sqlQuery .= " ORDER BY {$orderColumn} {$orderDirection} ";
        if(!empty($limit)) {
            $sqlQuery .= " LIMIT {$limit} OFFSET {$offset} ";
        }

        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
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

    public function pegarExamePorIdAnimal(int $idAnimal): array
    {
        $sqlQuery = "SELECT exames.id AS id,
                            exames.descricao AS descricao,
                            DATE_FORMAT(exames.data, '%d/%m/%Y') AS data,
                            exames.notas AS notas,
                            exames.file_path AS file_path,
                            animal.nome AS animal,
                            exames.criado_em AS criado_em,
                            exames.ativo AS ativo
                     FROM exames 
                     INNER JOIN animal ON (exames.animal = animal.id) 
                     WHERE exames.animal = :idAnimal";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":idAnimal", $idAnimal);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return [];
        }
    }
}