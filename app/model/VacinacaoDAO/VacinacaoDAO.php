<?php

namespace App\Model\VacinacaoDAO;

use App\Core\Connection;
use App\Core\DefaultController;
use App\Model\BaseDAO\BaseDAO;

class VacinacaoDAO extends BaseDAO implements iVacinacaoDAO
{
    private int $diasParaVacinar = 10;

    public function __construct()
    {
        $this->setTable("vacinacao");
    }

    public function selectAll(
        string $orderColumn = "id",
        string $orderDirection = "ASC",
        int $limit = null,
        int $offset = 0,
        bool $getJustActiveElements = true
    ): array
    {
        $sqlQuery = "SELECT vacinacao.id AS id,
                            animal.nome AS animal,
                            vacina.descricao AS vacina,
                            DATE_FORMAT(vacinacao.data_aplicacao, '%d/%m/%Y') AS data_aplicacao,
                            vacinacao.criado_em AS criado_em,
                            vacinacao.ativo AS ativo
                     FROM vacinacao
                     INNER JOIN animal ON (vacinacao.animal = animal.id) 
                     INNER JOIN vacina ON (vacinacao.vacina = vacina.id) ";

        if ($getJustActiveElements) {
            $sqlQuery .= " WHERE vacinacao.ativo = 1 ";
        }
        $sqlQuery .= " ORDER BY vacinacao.{$orderColumn} {$orderDirection} ";
        if (!empty($limit)) {
            $sqlQuery .= " LIMIT {$limit} OFFSET {$offset} ";
        }

        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->execute();
            if ($stmt->rowCount() === 0) {
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

    public function verificarSeEHoraDeVacinar(int $idAnimal): bool
    {
        $sqlQuery = "SELECT * 
                     FROM vacinacao 
                     INNER JOIN vacina ON (vacinacao.vacina = vacina.id)
                     WHERE vacinacao.animal = :animal 
                     AND ((data_aplicacao + INTERVAL vacina.duracao_dias DAY) < (CURDATE() + INTERVAL {$this->diasParaVacinar} DAY)) ";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":animal", $idAnimal);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            return false;
        }
    }

}