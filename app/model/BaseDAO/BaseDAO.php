<?php

namespace App\Model\BaseDAO;

use App\Core\Connection;
use App\Core\DefaultController;

class BaseDAO implements iBaseDAO
{
    private string $table;

    public function selectAll(
        string $orderColumn = "id",
        string $orderDirection = "ASC",
        int $limit = null,
        int $offset = 0,
        bool $getJustActiveElements = true
    ): array
    {
        $sqlQuery = "SELECT * FROM {$this->table} ";
        if($getJustActiveElements) {
            $sqlQuery .= " WHERE ativo = 1 ";
        }
        $sqlQuery .= " ORDER BY {$orderColumn} {$orderDirection} ";
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

    public function selectById(int $id): array
    {
        $sqlQuery = "SELECT * FROM {$this->table} WHERE id = :id";
        $conn = Connection::getInstance();
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(":id", $id);
        try {
            $stmt->execute();
            if($stmt->rowCount() === 0) {
                $view = new DefaultController();
                $view->response([
                    "message" => "Nenhum registro encontrado!"
                ], HTTP_NOT_FOUND);
            }
            return $stmt->fetch();
        } catch(\PDOException $e) {
            $view = new DefaultController();
            $view->response([
                "message" => "Houve um erro ao buscar o registro",
                "error" => $e->getMessage()
            ], HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function insert(array $data): bool
    {
        $sqlQuery = "INSERT INTO {$this->table} (";
        $columns = "";
        $preparedColumns = "";

        foreach($data as $key=>$value) {
            $columns .= $key . ",";
            $preparedColumns .= ":" . $key . ",";
        }
        $columns = mb_substr($columns, 0, -1);
        $preparedColumns = mb_substr($preparedColumns, 0, -1);

        $sqlQuery .= $columns . ") VALUES ({$preparedColumns})";

        $conn = Connection::getInstance();
        $stmt = $conn->prepare($sqlQuery);
        foreach($data as $key=>$value) {
            $stmt->bindValue(":".$key, $value);
        }

        try {
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function update(array $data, array $where): bool
    {
        $sqlQuery = "UPDATE {$this->table} SET ";
        foreach($data as $key=>$value) {
            $sqlQuery .= " {$key} = :{$key},";
        }
        $sqlQuery = mb_substr($sqlQuery, 0, -1);
        $sqlQuery .= " WHERE ";
        $c = 0;
        foreach($where as $key=>$value) {
            if($c > 0) {
                $sqlQuery .= " AND ";
            }
            $sqlQuery .= " {$key} = :{$key} ";
            $c++;
        }

        $conn = Connection::getInstance();
        $stmt = $conn->prepare($sqlQuery);
        foreach($data as $key=>$value) {
            $stmt->bindValue(":".$key, $value);
        }
        foreach($where as $key=>$value) {
            $stmt->bindValue(":".$key, $value);
        }
        try {
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function delete(int $id): bool
    {
        $sqlQuery = "DELETE FROM {$this->table} WHERE id = :id";
        $conn = Connection::getInstance();
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(":id", $id);
        try {
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function disable(int $id, int $status): bool
    {
        $sqlQuery = "UPDATE {$this->table} SET ativo = :ativo WHERE id = :id";
        $conn = Connection::getInstance();
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(":ativo", $status);
        $stmt->bindValue(":id", $id);
        try {
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function compare(array $params, string $compareType = "=", bool $removeItem = false, array $itemsToRemove = []): bool
    {
        $sqlQuery = "SELECT * FROM {$this->table}";
        $c = 0;
        foreach($params as $key=>$value) {
            if($c === 0) {
                $sqlQuery .= " WHERE (";
            } else {
                $sqlQuery .= " OR ";
            }
            $sqlQuery .= " {$key} {$compareType} :{$key}";
            $c++;
        }
        $sqlQuery .= ") ";

        if($removeItem) {
            foreach($itemsToRemove as $key=>$value) {
                $sqlQuery .= " AND {$key} <> :{$key} ";
            }
        }

        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            foreach($params as $key=>$value) {
                $stmt->bindValue(":{$key}", $value);
            }
            if($removeItem) {
                foreach ($itemsToRemove as $key=>$value) {
                    $stmt->bindValue(":{$key}", $value);
                }
            }
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            return false;
        }
    }

    protected function setTable(string $table)
    {
        $this->table = $table;
    }
}