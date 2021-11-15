<?php

namespace App\Model\VacinacaoDAO;

use App\Core\Connection;
use App\Helper\DateHelper;
use App\Helper\FileHelper;
use App\Model\BaseDAO\BaseDAO;

class VacinacaoDAO extends BaseDAO implements iVacinacaoDAO
{
    private FileHelper $fileHelper;

    public function __construct()
    {
        $this->setTable("vacinacao");
        $this->fileHelper = new FileHelper();
    }

    public function save(array $params): bool
    {
        $sqlQuery = "INSERT INTO vacinacao (animal, vacina, data_aplicacao) VALUES (:animal, :vacina, :data_aplicacao)";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":animal", $params["animal"]);
            $stmt->bindValue(":vacina", $params["vacina"]);
            $stmt->bindValue(":data_aplicacao", $params["data_aplicacao"]);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function delete(int $id): bool
    {
        $sqlQuery = "DELETE FROM vacinacao WHERE id = :id";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":id", $id);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getByAnimalId(int $animalId): array
    {
        $sqlquery = "
            SELECT  vacinacao.*,
                    vacina.descricao AS descVacina,
                    vacina.duracao_dias AS duracao_dias,
                    animal.nome AS nomeAnimal
            FROM vacinacao
            INNER JOIN vacina ON (vacinacao.vacina = vacina.id) 
            INNER JOIN animal ON (vacinacao.animal = animal.id)
            WHERE vacinacao.animal = :animalId
        ";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlquery);
            $stmt->bindValue(":animalId", $animalId);
            $stmt->execute();
            $res = [];
            $dias = 30;
            $hoje = date("Y-m-d");
            $dateHelper = new DateHelper();
            foreach($stmt->fetchAll() as $vacinacao) {
                $status = "ok";
                $dataLimite = $dateHelper->addDaysToDate($vacinacao["data_aplicacao"], (int)$vacinacao["duracao_dias"]);
                $diff = $dateHelper->dateDifferenceInDays($dataLimite, $hoje);

                if($diff >= $dias) {
                    $status = "ok";
                } else if($diff > 0 && $diff < $dias) {
                    $status = "attention";
                } else {
                    $status = "over";
                }

                $curr = [
                    "id" => (int)$vacinacao["id"],
                    "animal" => (int)$vacinacao["animal"],
                    "vacina" => (int)$vacinacao["vacina"],
                    "data_aplicacao" => $vacinacao["data_aplicacao"],
                    "descVacina" => $vacinacao["descVacina"],
                    "nomeAnimal" => $vacinacao["nomeAnimal"],
                    "status" => $status
                ];
                array_push($res, $curr);
            }
            return $res;
        } catch(\PDOException $e) {
            return [];
        }
    }

    public function updateVaccinationDate(int $id, string $newDate): bool
    {
        $sqlQuery = "UPDATE vacinacao SET data_aplicacao = :data_aplicacao WHERE id = :id";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":data_aplicacao", $newDate);
            $stmt->bindValue(":id", $id);
            return $stmt->execute();
        } catch(\PDOException $e) {
            return false;
        }
    }

    public function verifyIfExists(int $vaccine, int $animal): bool
    {
        $sqlQuery = "SELECT * FROM vacinacao WHERE vacina = :vacina AND animal = :animal";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":vacina", $vaccine);
            $stmt->bindValue(":animal", $animal);
            $stmt->execute();
            if($stmt->rowCount() > 0) return true;
            return false;
        } catch(\PDOException $e) {
            return true;
        }
    }

    public function getById(int $id): array
    {
        $sqlquery = "
            SELECT  vacinacao.*,
                    vacina.descricao AS descVacina,
                    vacina.duracao_dias AS duracao_dias,
                    animal.nome AS nomeAnimal
            FROM vacinacao
            INNER JOIN vacina ON (vacinacao.vacina = vacina.id) 
            INNER JOIN animal ON (vacinacao.animal = animal.id)
            WHERE vacinacao.id = :id LIMIT 1
        ";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlquery);
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            $res = [];
            $cont = 0;
            $dateHelper = new DateHelper();
            foreach($stmt->fetchAll() as $vacinacao) {
                if($cont <= 0) {
                    return [
                        "id" => (int)$vacinacao["id"],
                        "animal" => (int)$vacinacao["animal"],
                        "vacina" => (int)$vacinacao["vacina"],
                        "data_aplicacao" => $vacinacao["data_aplicacao"],
                        "data_aplicacao_brl" => $dateHelper->dateSqlToBrl($vacinacao["data_aplicacao"]),
                        "descVacina" => $vacinacao["descVacina"],
                        "nomeAnimal" => $vacinacao["nomeAnimal"]
                    ];
                }
                $cont++;
            }
            return $res;
        } catch(\PDOException $e) {
            die($e);
            return [];
        }
    }
}