<?php

namespace App\Model\DocumentoDAO;

use App\Core\Connection;
use App\Model\BaseDAO\BaseDAO;

class DocumentoDAO extends BaseDAO implements iDocumentoDAO
{
    public function __construct()
    {
        $this->setTable("documentos");
    }

    public function save(array $params): bool
    {
        $sqlQuery = "INSERT INTO documentos (descricao, data, notas, file_path, animal) VALUES (:descricao, :data, :notas, :file_path, :animal)";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":descricao", $params["descricao"]);
            $stmt->bindValue(":data", $params["data"]);
            $stmt->bindValue(":notas", $params["notas"]);
            $stmt->bindValue(":file_path", $params["file_path"]);
            $stmt->bindValue(":animal", $params["animal"]);
            return $stmt->execute();
        } catch(\PDOException $e) {
            return false;
        }
    }

    public function getByAnimalId(int $animalId): array
    {
        $sqlQuery = "
            SELECT  documentos.*,
                    animal.descricao AS descAnimal
            FROM documentos 
            INNER JOIN animal ON (documentos.animal = animal.id)
            WHERE animal = :animal
        ";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":animal", $animalId);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch(\PDOException $e) {
            return [];
        }
    }

    public function getById(int $documentId): array
    {
        $sqlQuery = "
            SELECT  documentos.*,
                    animal.descricao AS descAnimal
            FROM documentos 
            INNER JOIN animal ON (documentos.animal = animal.id)
            WHERE documentos.id = :id
        ";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":id", $documentId);
            $stmt->execute();
            if($stmt->rowCount() > 0) return $stmt->fetch();
            return [];
        } catch(\PDOException $e) {
            return [];
        }
    }
}