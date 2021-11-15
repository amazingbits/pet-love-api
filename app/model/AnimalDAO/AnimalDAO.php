<?php

namespace App\Model\AnimalDAO;

use App\Core\Connection;
use App\Core\DefaultController;
use App\Model\BaseDAO\BaseDAO;
use App\Model\ConsultaDAO\ConsultaDAO;
use App\Model\ExameDAO\ExameDAO;
use App\Model\VacinacaoDAO\VacinacaoDAO;

class AnimalDAO extends BaseDAO implements iAnimalDAO
{

    public function __construct()
    {
        $this->setTable("animal");
    }

    public function selectAll(
        string $orderColumn = "id",
        string $orderDirection = "ASC",
        int $limit = null,
        int $offset = 0,
        bool $getJustActiveElements = true
    ): array
    {
        $sqlQuery = "SELECT animal.id AS id,
                            animal.sexo AS sexo,
                            animal.nome AS nome,
                            DATE_FORMAT(animal.nascimento, '%d/%m/%Y') AS nascimento,
                            animal.castrado AS castrado,
                            animal_raca.descricao AS animal_raca,
                            animal_comportamento.descricao AS animal_comportamento,
                            tipo_animal.descricao AS tipo_animal,
                            usuario.nome AS dono,
                            animal.criado_em AS criado_em,
                            animal.ativo AS ativo
                     FROM animal 
                     INNER JOIN animal_raca ON (animal.animal_raca = animal_raca.id) 
                     INNER JOIN animal_comportamento ON (animal.animal_comportamento = animal_comportamento.id) 
                     INNER JOIN tipo_animal ON (animal.tipo_animal = tipo_animal.id) 
                     INNER JOIN usuario ON (animal.dono = usuario.id) ";

        if($getJustActiveElements) {
            $sqlQuery .= " WHERE animal.ativo = 1 ";
        }

        $sqlQuery .= " ORDER BY animal.{$orderColumn} {$orderDirection} ";
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

    public function pegarAnimalPorIdDeUsuario(int $id): array
    {
        $sqlQuery = "SELECT animal.id AS id,
                            animal.sexo AS sexo,
                            animal.nome AS nome,
                            DATE_FORMAT(animal.nascimento, '%d/%m/%Y') AS nascimento,
                            animal.castrado AS castrado,
                            animal_raca.descricao AS animal_raca,
                            animal_comportamento.descricao AS animal_comportamento,
                            tipo_animal.descricao AS tipo_animal,
                            usuario.nome AS dono,
                            animal.criado_em AS criado_em,
                            animal.ativo AS ativo
                     FROM animal 
                     INNER JOIN animal_raca ON (animal.animal_raca = animal_raca.id) 
                     INNER JOIN animal_comportamento ON (animal.animal_comportamento = animal_comportamento.id) 
                     INNER JOIN tipo_animal ON (animal.tipo_animal = tipo_animal.id) 
                     INNER JOIN usuario ON (animal.dono = usuario.id) 
                     WHERE animal.dono = :id";

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

    public function retornarInformacoesCompletasDoAnimalPorIdUsuario(int $idUsuario): array
    {
        $res = [];
        $animais = $this->pegarAnimalPorIdDeUsuario($idUsuario);
        foreach($animais as $key=>$value) {
            $idAnimal = (int)$value["id"];
            $curr = $value;
            array_push($res, $curr);
        }
        return $res;
    }

    public function retornarInformacoesCompletasDoAnimalPorIdAnimal(int $idAnimal): array
    {
        $sqlQuery = "SELECT animal.id AS id,
                            animal.sexo AS sexo,
                            animal.nome AS nome,
                            DATE_FORMAT(animal.nascimento, '%d/%m/%Y') AS nascimento,
                            animal.castrado AS castrado,
                            animal_raca.descricao AS animal_raca,
                            animal_comportamento.descricao AS animal_comportamento,
                            tipo_animal.descricao AS tipo_animal,
                            usuario.nome AS dono,
                            animal.criado_em AS criado_em,
                            animal.ativo AS ativo
                     FROM animal 
                     INNER JOIN animal_raca ON (animal.animal_raca = animal_raca.id) 
                     INNER JOIN animal_comportamento ON (animal.animal_comportamento = animal_comportamento.id) 
                     INNER JOIN tipo_animal ON (animal.tipo_animal = tipo_animal.id) 
                     INNER JOIN usuario ON (animal.dono = usuario.id) 
                     WHERE animal.id = :id";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":id", $idAnimal);
            $stmt->execute();
            if($stmt->rowCount() === 0) return [];
            $animal = $stmt->fetchAll();
            $res = [];
            foreach($animal as $key=>$value) {
                $idAnimal = (int)$value["id"];
                $curr = $value;
                array_push($res, $curr);
            }
            return $res;
        } catch (\PDOException $e) {
            return [];
        }
    }
}