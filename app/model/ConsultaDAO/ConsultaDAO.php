<?php

namespace App\Model\ConsultaDAO;

use App\Core\Connection;
use App\Core\DefaultController;
use App\Model\BaseDAO\BaseDAO;

class ConsultaDAO extends BaseDAO implements iConsultaDAO
{
    public function __construct()
    {
        $this->setTable("consultas");
    }

    public function selectAll(
        string $orderColumn = "id",
        string $orderDirection = "ASC",
        int $limit = null,
        int $offset = 0,
        bool $getJustActiveElements = true
    ): array
    {
        $sqlQuery = "SELECT consultas.id AS id,
                            consultas.descricao AS descricao,
                            DATE_FORMAT(consultas.data, '%d/%m/%Y') AS data,
                            consultas.notas AS notas,
                            consultas.file_path AS file_path,
                            animal.nome AS animal,
                            consultas.criado_em AS criado_em,
                            consultas.ativo AS ativo
                     FROM consultas 
                     INNER JOIN animal ON (consultas.animal = animal.id) ";
        if($getJustActiveElements) {
            $sqlQuery .= " WHERE consultas.ativo = 1 ";
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
}