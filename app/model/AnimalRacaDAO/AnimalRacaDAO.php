<?php

namespace App\Model\AnimalRacaDAO;

use App\Core\Connection;
use App\Core\DefaultController;
use App\Model\BaseDAO\BaseDAO;

class AnimalRacaDAO extends BaseDAO implements iAnimalRacaDAO
{
    public function __construct()
    {
        $this->setTable("animal_raca");
    }

    public function selectAll(
        string $orderColumn = "id",
        string $orderDirection = "ASC",
        int $limit = null,
        int $offset = 0,
        bool $getJustActiveElements = true
    ): array
    {
        $sqlQuery = "SELECT animal_raca.id AS id,
                            animal_raca.descricao AS descricao,
                            tipo_animal.descricao AS tipo_animal,
                            animal_raca.ativo AS ativo,
                            animal_raca.criado_em AS criado_em
                     FROM animal_raca 
                     INNER JOIN tipo_animal ON (animal_raca.tipo_animal = tipo_animal.id) ";

        if($getJustActiveElements) {
            $sqlQuery .= " WHERE animal_raca.ativo = 1 ";
        }
        $sqlQuery .= " ORDER BY animal_raca.{$orderColumn} {$orderDirection} ";
        if(!empty($limit)) {
            $sqlQuery .= " LIMIT {$limit} OFFSET {$offset} ";
        }

        $conn = Connection::getInstance();
        $stmt = $conn->prepare($sqlQuery);
        try {
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